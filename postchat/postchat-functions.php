<?php
// 确保直接访问文件时退出
if (!defined('ABSPATH')) {
    exit;
}

// 定义默认选项
function postchat_get_default_options() {
    return [
        'key' => '70b649f150276f289d1025508f60c5f58a',
        'enableSummary' => true,
        'postSelector' => '#postchat_postcontent',
        'title' => '文章摘要',
        'summaryStyle' => 'https://ai.tianli0.top/static/public/postChatUser_summary.min.css',
        'postURL' => '*',
        'blacklist' => '',
        'wordLimit' => '1000',
        'typingAnimate' => true,
        'beginningText' => '这篇文章介绍了',
        'enableAI' => true,
        'backgroundColor' => '#3e86f6',
        'fill' => '#FFFFFF',
        'bottom' => '16px',
        'left' => '16px',
        'width' => '44px',
        'frameWidth' => '375px',
        'frameHeight' => '600px',
        'defaultInput' => true,
        'upLoadWeb' => true,
        'showInviteLink' => true,
        'userTitle' => 'PostChat',
        'userDesc' => '如果你对网站的内容有任何疑问，可以来问我哦～',
        'addButton' => true,
        'summaryTheme' => '',
        'userMode' => 'magic',
        'userIcon' => 'https://ai.tianli0.top/static/img/PostChat.webp',
        'defaultChatQuestions' => [],
        'defaultSearchQuestions' => [],
    ];
}

// 获取合并后的选项
function postchat_get_options() {
    $defaults = postchat_get_default_options();
    $options = get_option('postchat_options', []);
    return wp_parse_args($options, $defaults);
}
