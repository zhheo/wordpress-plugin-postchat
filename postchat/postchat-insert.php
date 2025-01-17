<?php
// 确保直接访问文件时退出
if (!defined('ABSPATH')) {
    exit;
}

// 引入辅助函数
require_once plugin_dir_path(__FILE__) . 'postchat-functions.php';

// 添加新的函数来处理 post_class
function postchat_add_post_class($classes, $class, $post_id) {
    // 修改判断条件，适配更多场景
    if (!is_admin() && (is_single() || is_page()) && get_post_type($post_id) == 'post') {
        $classes[] = 'postchat_postcontent';
        
        // 如果是区块主题，也给 entry-content 添加类名
        if (wp_is_block_theme()) {
            add_filter('render_block', function($block_content, $block) {
                if ($block['blockName'] === 'core/post-content') {
                    return str_replace('class="', 'class="postchat_postcontent ', $block_content);
                }
                return $block_content;
            }, 10, 2);
        }
    }
    return $classes;
}
add_filter('post_class', 'postchat_add_post_class', 10, 3);

// 添加新的过滤器来处理区块内容
function postchat_add_block_class() {
    add_filter('render_block_core/post-content', function($block_content) {
        if (is_single() && !is_admin()) {
            return str_replace('class="', 'class="postchat_postcontent ', $block_content);
        }
        return $block_content;
    });
}
add_action('init', 'postchat_add_block_class');

// 在所有页面插入自定义 JS 和 CSS
function postchat_enqueue_scripts() {
    $options = postchat_get_options();

    if (!$options) {
        return;
    }

    // 检查并更新旧版本的选择器设置
    if ($options['postSelector'] === '#postchat_postcontent') {
        $options['postSelector'] = '.postchat_postcontent';
        update_option('postchat_options', $options);
    }

    $enableSummary = $options['enableSummary'];
    $enableAI = $options['enableAI'];

    // 注册和加载样式表
    wp_register_style(
        'postchat-summary-style',
        esc_url($options['summaryStyle']),
        array(),
        '1.0.0'
    );
    wp_enqueue_style('postchat-summary-style');

    // 确定要加载的脚本URL
    if ($enableSummary && $enableAI) {
        $script_url = "https://ai.tianli0.top/static/public/postChatUser_summary.min.js";
    } elseif ($enableSummary) {
        $script_url = "https://ai.tianli0.top/static/public/tianli_gpt.min.js";
    } elseif ($enableAI) {
        $script_url = "https://ai.tianli0.top/static/public/postChatUser.min.js";
    } else {
        return;
    }

    // 先注册和加载主脚本
    wp_enqueue_script(
        'postchat-main',
        esc_url($script_url),
        array(),
        '1.0.0',
        true
    );

    // 然后添加配置变量
    wp_add_inline_script(
        'postchat-main',
        'let tianliGPT_key = "' . esc_js($options['key']) . '";
        let tianliGPT_postSelector = "' . esc_js($options['postSelector']) . '";
        let tianliGPT_Title = "' . esc_js($options['title']) . '";
        let tianliGPT_postURL = "' . esc_js($options['postURL']) . '";
        let tianliGPT_blacklist = "' . esc_js($options['blacklist']) . '";
        let tianliGPT_wordLimit = "' . esc_js($options['wordLimit']) . '";
        let tianliGPT_typingAnimate = ' . ($options['typingAnimate'] ? 'true' : 'false') . ';
        let tianliGPT_theme = "' . esc_js($options['summaryTheme']) . '";
        var postChatConfig = ' . wp_json_encode([
            'backgroundColor' => $options['backgroundColor'],
            'bottom' => $options['bottom'],
            'left' => $options['left'],
            'fill' => $options['fill'],
            'width' => $options['width'],
            'frameWidth' => $options['frameWidth'],
            'frameHeight' => $options['frameHeight'],
            'defaultInput' => (bool) $options['defaultInput'],
            'upLoadWeb' => (bool) $options['upLoadWeb'],
            'showInviteLink' => (bool) $options['showInviteLink'],
            'userTitle' => $options['userTitle'],
            'userDesc' => $options['userDesc'],
            'addButton' => (bool) $options['addButton'],
            'beginningText' => $options['beginningText'],
            'userMode' => $options['userMode'],
            'userIcon' => $options['userIcon'],
            'defaultChatQuestions' => $options['defaultChatQuestions'],
            'defaultSearchQuestions' => $options['defaultSearchQuestions']
        ]) . ';',
        'before'
    );

    // 为主脚本添加自定义属性
    add_filter('script_loader_tag', function($tag, $handle) use ($options) {
        if ('postchat-main' === $handle) {
            return str_replace('<script', '<script data-postChat_key="' . esc_attr($options['key']) . '"', $tag);
        }
        return $tag;
    }, 10, 2);
}
add_action('wp_enqueue_scripts', 'postchat_enqueue_scripts');
