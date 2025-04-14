<?php
// 确保直接访问文件时退出
if (!defined('ABSPATH')) {
    exit;
}

/**
 * 添加PostChat摘要到文章内容
 * 
 * @param string $content 文章内容
 * @return string 添加了摘要的文章内容
 */
function postchat_display_summary($content) {
    // 只在单篇文章页面添加摘要
    if (!is_single()) {
        return $content;
    }
    
    // 获取当前文章ID
    $post_id = get_the_ID();
    
    // 获取自定义摘要
    $summary = get_post_meta($post_id, '_postchat_summary', true);
    
    // 如果没有找到自定义摘要，则返回原内容
    if (empty($summary)) {
        return $content;
    }
    
    // 从插件选项获取摘要标题
    $options = get_option('postchat_options', array());
    $summary_title = isset($options['title']) ? $options['title'] : '文章摘要';
    
    // 创建摘要HTML
    $summary_html = '
    <div class="postchat-summary">
        <h3 class="postchat-summary-title">' . esc_html($summary_title) . '</h3>
        <div class="postchat-summary-content">' . esc_html($summary) . '</div>
    </div>
    ';
    
    // 获取注入位置
    $inject_dom = isset($options['injectDom']) && !empty($options['injectDom']) ? $options['injectDom'] : '';
    
    // 如果没有指定注入位置，默认添加到内容开头
    if (empty($inject_dom)) {
        return $summary_html . $content;
    }
    
    // 记录日志，显示摘要已添加
    error_log('PostChat: 为文章 ID:' . $post_id . ' 显示摘要');
    
    // 如果有指定注入位置，则返回原内容（通过JavaScript注入）
    return $content;
}

// 添加到WordPress内容过滤器
add_filter('the_content', 'postchat_display_summary');

/**
 * 添加自定义摘要样式
 */
function postchat_summary_styles() {
    // 只在单篇文章页面添加样式
    if (!is_single()) {
        return;
    }
    
    // 获取当前文章ID
    $post_id = get_the_ID();
    
    // 检查文章是否有自定义摘要
    $summary = get_post_meta($post_id, '_postchat_summary', true);
    if (empty($summary)) {
        return;
    }
    
    // 添加样式
    echo '
    <style type="text/css">
        .postchat-summary {
            background-color: #f8f9fa;
            border-left: 4px solid #4a89dc;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 3px;
        }
        .postchat-summary-title {
            margin-top: 0;
            color: #333;
            font-size: 18px;
            font-weight: bold;
        }
        .postchat-summary-content {
            color: #666;
            line-height: 1.6;
        }
    </style>
    ';
}

// 添加到WordPress头部
add_action('wp_head', 'postchat_summary_styles'); 