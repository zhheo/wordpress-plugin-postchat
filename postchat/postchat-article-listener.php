<?php
// 确保直接访问文件时退出
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 检查是否应该启用文章监听
 * 
 * @return bool 是否满足启用条件
 */
function postchat_should_enable_listener() {
    $options = postchat_get_options();
    
    // 仅在同时满足三个条件时才启用监听
    return (
        isset($options['enableSummary']) && $options['enableSummary'] && 
        isset($options['privateSummary']) && $options['privateSummary'] && 
        isset($options['apiSecret']) && !empty($options['apiSecret'])
    );
}

/**
 * 监听文章发布和更新事件并收集文章信息
 */
function postchat_article_publish_listener($post_ID, $post, $update) {
    // 使用静态变量防止无限循环和多重调用
    static $is_processing = array();
    
    // 如果这篇文章已经在处理中，跳过
    if (isset($is_processing[$post_ID]) && $is_processing[$post_ID]) {
        return;
    }
    
    // 检查是否是我们自己的更新操作，防止无限循环
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // 检查是否是自动保存或修订版本
    if (wp_is_post_revision($post_ID) || wp_is_post_autosave($post_ID)) {
        return;
    }
    
    // 检查是否满足启用条件
    if (!postchat_should_enable_listener()) {
        return;
    }
    
    // 只处理已发布的文章
    if ($post->post_status !== 'publish' || $post->post_type !== 'post') {
        return;
    }

    // 标记文章为处理中
    $is_processing[$post_ID] = true;
    
    try {
        // 收集文章信息
        $article_data = array(
            'id' => $post_ID,                            // 文章唯一标识符
            'title' => get_the_title($post_ID),          // 文章标题
            'permalink' => get_permalink($post_ID),      // 文章永久链接
            'content' => $post->post_content,            // 文章内容
            'publish_time' => $post->post_date,          // 发布时间
            'author' => get_the_author_meta('display_name', $post->post_author), // 作者名
            'is_update' => $update                       // 是否为更新操作
        );

        // 记录日志，方便调试
        if ($update) {
            postchat_log('文章已更新，准备生成摘要', array('post_id' => $post_ID, 'title' => $article_data['title']));
        } else {
            postchat_log('新文章已发布，准备生成摘要', array('post_id' => $post_ID, 'title' => $article_data['title']));
        }

        // 获取当前已有的摘要，如果存在且内容未变，则跳过处理
        $existing_summary = get_post_meta($post_ID, '_postchat_summary', true);
        $content_hash = md5($post->post_content . $post->post_title);
        $stored_hash = get_post_meta($post_ID, '_postchat_content_hash', true);
        
        if (!empty($existing_summary) && $content_hash === $stored_hash) {
            postchat_log('文章内容未变化，跳过摘要生成', array('post_id' => $post_ID));
            return;
        }
        
        // 使用异步任务处理摘要添加，不影响保存过程
        // 使用延迟执行，避免同时多次调用
        $scheduled = wp_schedule_single_event(time() + 5, 'postchat_add_summary_event', array($post_ID, $content_hash));
        
        if ($scheduled) {
            postchat_log('已安排异步任务生成摘要', array('post_id' => $post_ID));
        } else {
            postchat_log('安排异步任务失败', array('post_id' => $post_ID));
        }
        
        // 触发自定义动作钩子，便于其他功能扩展
        do_action('postchat_article_published_or_updated', $article_data);
    } finally {
        // 处理完成，取消标记
        $is_processing[$post_ID] = false;
    }
}

/**
 * 记录调试信息到日志
 * 
 * @param string $message 日志消息
 * @param mixed $data 附加数据（可选）
 */
function postchat_log($message, $data = null) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        if ($data !== null) {
            if (is_array($data) || is_object($data)) {
                $data_str = print_r($data, true);
            } else {
                $data_str = (string) $data;
            }
            error_log('PostChat: ' . $message . ' - ' . $data_str);
        } else {
            error_log('PostChat: ' . $message);
        }
    }
}

/**
 * 清理HTML内容，提取纯文本
 * 
 * @param string $content 原始HTML内容
 * @return string 清理后的纯文本
 */
function postchat_clean_html_content($content) {
    // 将HTML实体转换为实际字符
    $content = html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    // 移除所有 WordPress 块标记和编辑器评论
    $content = preg_replace('/<!--\s*wp:(.*?)-->/', '', $content);
    $content = preg_replace('/<!--\s*\/wp:(.*?)-->/', '', $content);
    $content = preg_replace('/<!--(.*?)-->/', '', $content);
    
    // 移除所有短代码
    $content = strip_shortcodes($content);
    
    // 移除所有HTML标签，但保留段落和标题的分隔
    $content = str_replace(['</p>', '</h1>', '</h2>', '</h3>', '</h4>', '</h5>', '</h6>', '<br>', '<br />'], "\n", $content);
    $content = wp_strip_all_tags($content, true);
    
    // 解码URL编码字符
    $content = urldecode($content);
    
    // 移除多余的空白和换行，将多个空白替换为单个空格
    $content = preg_replace('/\s+/', ' ', $content);
    $content = trim($content);
    
    // 移除非UTF-8字符
    $content = preg_replace('/[^\p{L}\p{N}\p{P}\p{Z}]/u', '', $content);
    
    // 移除XML和HTML特殊字符
    $content = str_replace(['<', '>', '&lt;', '&gt;', '&amp;', '&quot;', '&#039;'], '', $content);
    
    // 限制字数
    if (mb_strlen($content, 'UTF-8') > 1000) {
        $content = mb_substr($content, 0, 1000, 'UTF-8') . '...';
    }
    
    return $content;
}

/**
 * 从API获取文章摘要
 * 
 * @param string $title 文章标题
 * @param string $content 文章内容
 * @param string $url 文章URL
 * @return string|false 摘要内容或失败时返回false
 */
function postchat_get_summary_from_api($title, $content, $url) {
    $options = postchat_get_options();
    
    // 清理内容，只保留纯文本
    $clean_content = postchat_clean_html_content($content);
    $clean_title = postchat_clean_html_content($title);
    
    // 确保内容长度合适
    if (mb_strlen($clean_content, 'UTF-8') < 30) {
        postchat_log('文章内容过短，无法生成摘要', array(
            'content_length' => mb_strlen($clean_content, 'UTF-8'),
            'post_id' => url_to_postid($url)
        ));
        return false;
    }
    
    // 准备请求参数
    $api_url = 'https://api.ai.zhheo.com/api/v2/summary/generate/internal';
    $body = array(
        'content' => $clean_content,
        'title' => $clean_title,
        'url' => $url,
        'key' => $options['key'],
        'language' => get_locale(),
        'system' => 'WordPress',
        'embedding' => 'cover',
        'api_secret' => $options['apiSecret']
    );
    
    postchat_log('正在请求API生成摘要', array(
        'url' => $url,
        'title' => $clean_title,
        'content_length' => mb_strlen($clean_content, 'UTF-8'),
        'content_preview' => mb_substr($clean_content, 0, 100, 'UTF-8') . '...'
    ));
    
    // 发送POST请求 - 使用JSON格式
    $response = wp_remote_post($api_url, array(
        'body' => json_encode($body),
        'timeout' => 30,
        'headers' => array('Content-Type' => 'application/json'),
    ));
    
    // 检查请求是否成功
    if (is_wp_error($response)) {
        postchat_log('API请求失败', $response->get_error_message());
        return false;
    }
    
    $status_code = wp_remote_retrieve_response_code($response);
    if ($status_code !== 200) {
        postchat_log('API返回错误状态码', $status_code);
        postchat_log('响应内容', wp_remote_retrieve_body($response));
        return false;
    }
    
    // 解析响应
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);
    
    // 检查响应格式
    if (!isset($data['code']) || $data['code'] !== 200 || !isset($data['data']['summary'])) {
        postchat_log('API响应格式错误', $body);
        return false;
    }
    
    postchat_log('成功获取摘要', $data['data']['summary']);
    
    // 返回摘要内容
    return $data['data']['summary'];
}

/**
 * 添加文章摘要
 * 
 * @param int $post_ID 文章ID
 * @param string $content_hash 内容哈希值，用于检查内容是否变化
 */
function postchat_add_article_summary($post_ID, $content_hash = '') {
    // 使用静态变量防止无限循环
    static $is_updating = false;
    
    // 已在更新过程中，避免递归
    if ($is_updating) {
        postchat_log('检测到递归调用，已跳过', array('post_id' => $post_ID));
        return;
    }
    
    // 检查是否满足启用条件
    if (!postchat_should_enable_listener()) {
        postchat_log('未满足摘要生成条件，已跳过', array('post_id' => $post_ID));
        return;
    }
    
    // 获取文章数据
    $post = get_post($post_ID);
    if (!$post) {
        postchat_log('无法获取文章数据', array('post_id' => $post_ID));
        return;
    }
    
    // 再次检查内容哈希，避免多次处理
    if (!empty($content_hash)) {
        $stored_hash = get_post_meta($post_ID, '_postchat_content_hash', true);
        if ($content_hash === $stored_hash) {
            postchat_log('内容哈希未变化，跳过摘要生成', array('post_id' => $post_ID));
            return;
        }
    }
    
    $title = get_the_title($post_ID);
    $content = $post->post_content;
    $permalink = get_permalink($post_ID);
    
    postchat_log('准备处理文章摘要', array(
        'post_id' => $post_ID, 
        'title' => $title, 
        'permalink' => $permalink
    ));
    
    // 从API获取摘要
    $summary = postchat_get_summary_from_api($title, $content, $permalink);
    
    if ($summary === false) {
        postchat_log('获取摘要失败，处理终止', array('post_id' => $post_ID));
        return;
    }
    
    // 设置标志防止无限循环
    $is_updating = true;
    
    try {
        // 保存内容哈希值，用于后续比较
        if (!empty($content_hash)) {
            update_post_meta($post_ID, '_postchat_content_hash', $content_hash);
        } else {
            // 如果没有提供哈希值，计算一个
            update_post_meta($post_ID, '_postchat_content_hash', md5($content . $title));
        }
        
        // 更新文章摘要元数据
        update_post_meta($post_ID, '_postchat_summary', $summary);
        
        // 使用直接数据库更新以避免触发额外的钩子
        global $wpdb;
        $result = $wpdb->update(
            $wpdb->posts,
            array('post_excerpt' => $summary),
            array('ID' => $post_ID),
            array('%s'),
            array('%d')
        );
        
        if ($result === false) {
            postchat_log('数据库更新摘要失败', array(
                'post_id' => $post_ID,
                'db_error' => $wpdb->last_error
            ));
        } else {
            // 清除缓存
            clean_post_cache($post_ID);
            
            postchat_log('已成功为文章添加摘要', array(
                'post_id' => $post_ID,
                'summary' => $summary
            ));
        }
    } catch (Exception $e) {
        postchat_log('更新摘要时发生错误', array(
            'post_id' => $post_ID,
            'error' => $e->getMessage()
        ));
    } finally {
        // 重置更新标志
        $is_updating = false;
    }
}

// 注册异步任务钩子 - 需要接收两个参数：文章ID和内容哈希
add_action('postchat_add_summary_event', 'postchat_add_article_summary', 10, 2);

// 添加文章发布和更新监听钩子 - 使用较低的优先级，确保在其他操作完成后执行
add_action('wp_insert_post', 'postchat_article_publish_listener', 20, 3);

/**
 * 插件初始化时注册所需的钩子
 */
function postchat_register_hooks() {
    // 仅在满足条件时注册钩子
    if (postchat_should_enable_listener()) {
        // 确保异步事件系统已初始化
        if (!has_action('postchat_add_summary_event', 'postchat_add_article_summary')) {
            // 注册钩子，不立即调度事件
            add_action('postchat_add_summary_event', 'postchat_add_article_summary', 10, 2);
            postchat_log('已注册异步摘要生成事件处理器');
        }
        
        // 添加数据库维护钩子（每天清理一次旧的失败任务）
        if (!wp_next_scheduled('postchat_maintenance_cleanup')) {
            wp_schedule_event(time(), 'daily', 'postchat_maintenance_cleanup');
        }
    } else {
        // 如果不满足条件，则清除所有调度的事件
        $timestamp = wp_next_scheduled('postchat_maintenance_cleanup');
        if ($timestamp) {
            wp_unschedule_event($timestamp, 'postchat_maintenance_cleanup');
        }
        
        // 清除所有排队的摘要任务
        $crons = _get_cron_array();
        if (!empty($crons)) {
            foreach ($crons as $timestamp => $cron) {
                if (isset($cron['postchat_add_summary_event'])) {
                    unset($crons[$timestamp]['postchat_add_summary_event']);
                    if (empty($crons[$timestamp])) {
                        unset($crons[$timestamp]);
                    }
                }
            }
            _set_cron_array($crons);
        }
    }
}
add_action('init', 'postchat_register_hooks');

/**
 * 维护函数 - 清理过期的失败任务
 */
function postchat_maintenance_cleanup() {
    postchat_log('执行日常维护清理');
    
    // 清理可能存在的重复或过期任务
    $crons = _get_cron_array();
    $now = time();
    $modified = false;
    
    if (!empty($crons)) {
        foreach ($crons as $timestamp => $cron) {
            // 超过24小时未执行的任务视为过期
            if ($timestamp < ($now - 86400) && isset($cron['postchat_add_summary_event'])) {
                postchat_log('清理过期的摘要任务', array('timestamp' => date('Y-m-d H:i:s', $timestamp)));
                unset($crons[$timestamp]['postchat_add_summary_event']);
                if (empty($crons[$timestamp])) {
                    unset($crons[$timestamp]);
                }
                $modified = true;
            }
        }
        
        if ($modified) {
            _set_cron_array($crons);
        }
    }
}
add_action('postchat_maintenance_cleanup', 'postchat_maintenance_cleanup');

/**
 * 在插件停用时清理所有相关的调度事件
 */
function postchat_deactivation_cleanup() {
    // 清理维护任务
    $timestamp = wp_next_scheduled('postchat_maintenance_cleanup');
    if ($timestamp) {
        wp_unschedule_event($timestamp, 'postchat_maintenance_cleanup');
    }
    
    // 清理所有摘要任务
    $crons = _get_cron_array();
    $modified = false;
    
    if (!empty($crons)) {
        foreach ($crons as $timestamp => $cron) {
            if (isset($cron['postchat_add_summary_event'])) {
                unset($crons[$timestamp]['postchat_add_summary_event']);
                if (empty($crons[$timestamp])) {
                    unset($crons[$timestamp]);
                }
                $modified = true;
            }
        }
        
        if ($modified) {
            _set_cron_array($crons);
        }
    }
}
register_deactivation_hook(plugin_basename(__FILE__), 'postchat_deactivation_cleanup'); 