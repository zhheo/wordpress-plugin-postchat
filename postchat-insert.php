<?php

// 引入辅助函数
require_once plugin_dir_path(__FILE__) . 'postchat-functions.php';

// 添加自定义 class 到文章内容
function postchat_add_custom_class($content) {
    if (is_single()) {
        $content = '<div id="postchat_postcontent">' . $content . '</div>';
    }
    return $content;
}
add_filter('the_content', 'postchat_add_custom_class');

// 在所有页面插入自定义 JS 代码
function postchat_enqueue_custom_js() {
    $options = postchat_get_options(); // 使用辅助函数获取选项

    // 确保选项存在
    if (!$options) {
        return;
    }

    $enableSummary = $options['enableSummary'];
    $enableAI = $options['enableAI'];

    if ($enableSummary && $enableAI) {
        $script_url = "https://ai.tianli0.top/static/public/postChatUser_summary.min.js";
    } elseif ($enableSummary) {
        $script_url = "https://ai.tianli0.top/static/public/tianli_gpt.min.js";
    } elseif ($enableAI) {
        $script_url = "https://ai.tianli0.top/static/public/postChatUser.min.js";
    } else {
        return;
    }

    // Debug 输出，确保选项正确传递和判断（生产环境中请移除）
    echo '<!-- PostChat Debug: Options: ' . json_encode($options) . ' -->';
    echo '<!-- PostChat Debug: Script URL: ' . $script_url . ' -->';
    ?>
    <link rel="stylesheet" href="<?php echo esc_url($options['summaryStyle']); ?>">
    <script>
        let tianliGPT_key = '<?php echo esc_js($options['key']); ?>';
        let tianliGPT_postSelector = '<?php echo esc_js($options['postSelector']); ?>';
        let tianliGPT_Title = '<?php echo esc_js($options['title']); ?>';
        let tianliGPT_postURL = '<?php echo esc_js($options['postURL']); ?>';
        let tianliGPT_blacklist = '<?php echo esc_js($options['blacklist']); ?>';
        let tianliGPT_wordLimit = '<?php echo esc_js($options['wordLimit']); ?>';
        let tianliGPT_typingAnimate = <?php echo $options['typingAnimate'] ? 'true' : 'false'; ?>;
        let tianliGPT_theme = '<?php echo esc_js($options['summaryTheme']); ?>';
        var postChatConfig = {
            backgroundColor: "<?php echo esc_js($options['backgroundColor']); ?>",
            bottom: "<?php echo esc_js($options['bottom']); ?>",
            left: "<?php echo esc_js($options['left']); ?>",
            fill: "<?php echo esc_js($options['fill']); ?>",
            width: "<?php echo esc_js($options['width']); ?>",
            frameWidth: "<?php echo esc_js($options['frameWidth']); ?>",
            frameHeight: "<?php echo esc_js($options['frameHeight']); ?>",
            defaultInput: <?php echo $options['defaultInput'] ? 'true' : 'false'; ?>,
            upLoadWeb: <?php echo $options['upLoadWeb'] ? 'true' : 'false'; ?>,
            showInviteLink: <?php echo $options['showInviteLink'] ? 'true' : 'false'; ?>,
            userTitle: "<?php echo esc_js($options['userTitle']); ?>",
            userDesc: "<?php echo esc_js($options['userDesc']); ?>",
            addButton: <?php echo $options['addButton'] ? 'true' : 'false'; ?>,
            beginningText: "<?php echo esc_js($options['beginningText']); ?>",
            userMode: "<?php echo esc_js($options['userMode']); ?>",
            userIcon: "<?php echo esc_js($options['userIcon']); ?>",
            defaultChatQuestions: <?php echo json_encode($options['defaultChatQuestions']); ?>,
            defaultSearchQuestions: <?php echo json_encode($options['defaultSearchQuestions']); ?>
        };
    </script>
    <script data-postChat_key="<?php echo esc_js($options['key']); ?>" src="<?php echo esc_url($script_url); ?>"></script>
    <?php
}
add_action('wp_footer', 'postchat_enqueue_custom_js');

?>
