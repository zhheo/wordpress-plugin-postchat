<?php
// 确保直接访问文件时退出
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 监听文章发布和更新事件并收集文章信息
 */
function postchat_article_publish_listener($post_ID, $post, $update) {
    // 只处理已发布的文章
    if ($post->post_status !== 'publish' || $post->post_type !== 'post') {
        return;
    }

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
        error_log('PostChat: 文章已更新: ' . print_r($article_data, true));
    } else {
        error_log('PostChat: 新文章已发布: ' . print_r($article_data, true));
    }

    // 使用异步任务处理摘要添加，不影响保存过程
    wp_schedule_single_event(time(), 'postchat_add_summary_event', array($post_ID));
    
    // 触发自定义动作钩子，便于其他功能扩展
    do_action('postchat_article_published_or_updated', $article_data);
}

/**
 * 添加文章摘要
 * 
 * @param int $post_ID 文章ID
 */
function postchat_add_article_summary($post_ID) {
    // 设置摘要内容
    $summary = "这是PostChat摘要";
    
    // 更新文章摘要元数据
    update_post_meta($post_ID, '_postchat_summary', $summary);
    
    // 使用正确的WordPress API更新摘要
    // 使用suppress_filters参数避免无限循环
    wp_update_post(array(
        'ID' => $post_ID,
        'post_excerpt' => $summary,
    ), false, false);
    
    // 记录日志
    error_log('PostChat: 已为文章 ID:' . $post_ID . ' 添加摘要');
}

// 注册异步任务钩子
add_action('postchat_add_summary_event', 'postchat_add_article_summary');

// 添加文章发布和更新监听钩子 - 使用较低的优先级，确保在其他操作完成后执行
add_action('wp_insert_post', 'postchat_article_publish_listener', 20, 3);

/**
 * 插件初始化时注册所需的钩子
 */
function postchat_register_hooks() {
    // 确保异步事件系统已初始化
    if (!wp_next_scheduled('postchat_add_summary_event')) {
        // 仅注册钩子，不立即调度事件
        add_action('postchat_add_summary_event', 'postchat_add_article_summary');
    }
}
add_action('init', 'postchat_register_hooks'); 