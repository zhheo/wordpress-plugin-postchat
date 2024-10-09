<?php

// 引入辅助函数
require_once plugin_dir_path(__FILE__) . 'postchat-functions.php';

// 步骤 3：更新渲染函数以使用辅助函数
function postchat_key_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[key]' value='<?php echo esc_attr($options['key']); ?>'>
    <p class="description">
        使用PostChat的用户请前往 <a href="https://ai.tianli0.top/" target="_blank">获取 KEY</a>，
        只使用文章摘要的用户前往 <a href="https://summary.zhheo.com/" target="_blank">获取 KEY</a>。
        示例的Key不支持文章摘要和自定义的知识库问答，但可以使用作者的知识库对话
    </p>
    <?php
}

function postchat_enableSummary_render() {
    $options = postchat_get_options();
    ?>
    <input type='checkbox' name='postchat_options[enableSummary]' <?php checked($options['enableSummary'], 1); ?> value='1'>
    <p class="description">开启文章摘要需要在 <a href="https://summary.zhheo.com/" target="_blank">绑定你的网站</a></p>
    <?php
}

function postchat_postSelector_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[postSelector]' value='<?php echo esc_attr($options['postSelector']); ?>'>
    <p class="description">文章选择器，用于选择文章内容。如果没有正常显示摘要，你需要访问 <a href="https://postsummary.zhheo.com/theme/custom.html#%E8%8E%B7%E5%8F%96tianligpt-postselector" target="_blank">学习获取</a>，也可以联系 <a href="mailto:zhheo@qq.com">zhheo@qq.com</a> 发送你的网站地址后获取</p>
    <?php
}

function postchat_title_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[title]' value='<?php echo esc_attr($options['title']); ?>'>
    <p class="description">摘要标题，用于显示在摘要顶部的自定义内容</p>
    <?php
}

function postchat_summaryStyle_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[summaryStyle]' value='<?php echo esc_attr($options['summaryStyle']); ?>'>
    <p class="description">摘要样式css地址，如果你需要自定义摘要的css样式，可以自行修改。</p>
    <?php
}

function postchat_postURL_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[postURL]' value='<?php echo esc_attr($options['postURL']); ?>'>
    <p class="description">在符合url条件的网页执行文章摘要功能，通常情况下，绝大多数WordPress网站使用默认配置即可，无需调整</p>
    <?php
}

function postchat_blacklist_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[blacklist]' value='<?php echo esc_attr($options['blacklist']); ?>'>
    <p class="description">填写相关的json地址，帮助文档：<a href="https://postsummary.zhheo.com/parameters.html#tianligpt-blacklist" target="_blank">https://postsummary.zhheo.com/parameters.html#tianligpt-blacklist</a></p>
    <?php
}

function postchat_wordLimit_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[wordLimit]' value='<?php echo esc_attr($options['wordLimit']); ?>'>
    <p class="description">危险操作！如果没有在文章摘要中开启url绑定，更改此变量损失已消耗过的key，因为你提交的内容发生了变化。（PostChat用户无影响，因为摘要数量是无限的）可以设置提交的字数限制，默认为1000字。，帮助文档：<a href="https://postsummary.zhheo.com/parameters.html#tianligpt-wordlimit" target="_blank">https://postsummary.zhheo.com/parameters.html#tianligpt-wordlimit</a></p>
    <?php
}

function postchat_typingAnimate_render() {
    $options = postchat_get_options();
    ?>
    <input type='checkbox' name='postchat_options[typingAnimate]' <?php checked($options['typingAnimate'], 1); ?> value='1'>
    <p class="description">智能的打字效果，模拟流处理的感觉</p>
    <?php
}

function postchat_beginningText_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[beginningText]' value='<?php echo esc_attr($options['beginningText']); ?>'>
    <p class="description">文章摘要开头的文本，默认为“这篇文章介绍了”。</p>
    <?php
}

function postchat_enableAI_render() {
    $options = postchat_get_options();
    ?>
    <input type='checkbox' name='postchat_options[enableAI]' <?php checked($options['enableAI'], 1); ?> value='1'>
    <p class="description">添加按钮点击对话的功能，如果你并非PostChat用户，而是仅文章摘要用户，建议关闭此功能</p>
    <?php
}

function postchat_backgroundColor_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[backgroundColor]' value='<?php echo esc_attr($options['backgroundColor']); ?>'>
    <p class="description">调整按钮背景色彩</p>
    <?php
}

function postchat_fill_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[fill]' value='<?php echo esc_attr($options['fill']); ?>'>
    <p class="description">调整按钮里面图标的颜色</p>
    <?php
}

function postchat_bottom_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[bottom]' value='<?php echo esc_attr($options['bottom']); ?>'>
    <p class="description">按钮距离底部的边距</p>
    <?php
}

function postchat_left_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[left]' value='<?php echo esc_attr($options['left']); ?>'>
    <p class="description">按钮距离左侧的边距，如果填写负值，则是距离右侧的边距。例如left为-3px，实际为right 3px</p>
    <?php
}

function postchat_width_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[width]' value='<?php echo esc_attr($options['width']); ?>'>
    <p class="description">调整按钮的宽度</p>
    <?php
}

function postchat_frameWidth_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[frameWidth]' value='<?php echo esc_attr($options['frameWidth']); ?>'>
    <p class="description">调整聊天界面框架的宽度</p>
    <?php
}

function postchat_frameHeight_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[frameHeight]' value='<?php echo esc_attr($options['frameHeight']); ?>'>
    <p class="description">调整聊天界面框架的高度</p>
    <?php
}

function postchat_defaultInput_render() {
    $options = postchat_get_options();
    ?>
    <input type='checkbox' name='postchat_options[defaultInput]' <?php checked($options['defaultInput'], 1); ?> value='1'>
    <p class="description">勾选此项时，用户点击按钮后会自动添加本页面标题，让用户更方便的询问关于本页的内容</p>
    <?php
}

function postchat_upLoadWeb_render() {
    $options = postchat_get_options();
    ?>
    <input type='checkbox' name='postchat_options[upLoadWeb]' <?php checked($options['upLoadWeb'], 1); ?> value='1'>
    <p class="description">勾选此项时，你的网站内容将会被自动提交到PostChat，用户知识库建立和搜索功能</p>
    <?php
}

function postchat_showInviteLink_render() {
    $options = postchat_get_options();
    ?>
    <input type='checkbox' name='postchat_options[showInviteLink]' <?php checked($options['showInviteLink'], 1); ?> value='1'>
    <p class="description">勾选此项时，用户点击PostChat图标将访问你的邀请链接，被邀请用户在注册一年内开通的所有会员你会获得时长奖励。</p>
    <?php
}

function postchat_userTitle_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[userTitle]' value='<?php echo esc_attr($options['userTitle']); ?>'>
    <p class="description">你要自定义的PostChat界面标题</p>
    <?php
}

function postchat_userDesc_render() {
    $options = postchat_get_options();
    ?>
    <input type='text' name='postchat_options[userDesc]' value='<?php echo esc_attr($options['userDesc']); ?>'>
    <p class="description">你要自定义的PostChat聊天界面描述</p>
    <?php
}

function postchat_addButton_render() {
    $options = postchat_get_options();
    ?>
    <input type='checkbox' name='postchat_options[addButton]' <?php checked($options['addButton'], 1); ?> value='1'>
    <p class="description">勾选此项时按钮会被显示。如果你是主题开发者在你自己通过主题开发添加按钮的情况时，建议将前面编辑按钮的参数设置得与你自己创造的按钮的参数相同，以便更好的计算窗口宽高和位置。如果主题开发者期望自行配置，可以用css的!important对内置样式进行覆盖。</p>
    <?php
}

function postchat_options_page() {
    ?>
    <form action='options.php' method='post'>
        <h2>PostChat 设置</h2>
        <?php
        settings_fields('postchat');
        do_settings_sections('postchat');
        submit_button();
        ?>
    </form>
    <?php
}

// 注册设置菜单
function postchat_add_admin_menu() {
    add_options_page(
        'PostChat 设置',
        'PostChat',
        'manage_options',
        'postchat',
        'postchat_options_page'
    );
}
add_action('admin_menu', 'postchat_add_admin_menu');

// 注册设置
function postchat_settings_init() {
    register_setting('postchat', 'postchat_options', 'postchat_options_validate');

    add_settings_section(
        'postchat_section_account',
        '账户',
        'postchat_section_account_cb',
        'postchat'
    );

    add_settings_field(
        'postchat_key',
        '账户KEY',
        'postchat_key_render',
        'postchat',
        'postchat_section_account'
    );

    // 文章摘要设置
    add_settings_section(
        'postchat_section_summary',
        '文章摘要',
        'postchat_section_summary_cb',
        'postchat'
    );

    add_settings_field(
        'postchat_enableSummary',
        '开启文章摘要',
        'postchat_enableSummary_render',
        'postchat',
        'postchat_section_summary'
    );

    add_settings_field(
        'postchat_postSelector',
        '文章选择器',
        'postchat_postSelector_render',
        'postchat',
        'postchat_section_summary'
    );

    add_settings_field(
        'postchat_title',
        '摘要标题',
        'postchat_title_render',
        'postchat',
        'postchat_section_summary'
    );

    add_settings_field(
        'postchat_summaryStyle',
        '摘要样式css',
        'postchat_summaryStyle_render',
        'postchat',
        'postchat_section_summary'
    );

    add_settings_field(
        'postchat_postURL',
        '文章路由',
        'postchat_postURL_render',
        'postchat',
        'postchat_section_summary'
    );

    add_settings_field(
        'postchat_blacklist',
        '黑名单',
        'postchat_blacklist_render',
        'postchat',
        'postchat_section_summary'
    );

    add_settings_field(
        'postchat_wordLimit',
        '字数限制',
        'postchat_wordLimit_render',
        'postchat',
        'postchat_section_summary'
    );

    add_settings_field(
        'postchat_typingAnimate',
        '打字动画效果',
        'postchat_typingAnimate_render',
        'postchat',
        'postchat_section_summary'
    );

    add_settings_field(
        'postchat_beginningText',
        '开头文本',
        'postchat_beginningText_render',
        'postchat',
        'postchat_section_summary'
    );

    // 智能对话设置
    add_settings_section(
        'postchat_section_chat',
        '智能对话',
        'postchat_section_chat_cb',
        'postchat'
    );

    add_settings_field(
        'postchat_enableAI',
        '开启PostChat智能对话',
        'postchat_enableAI_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_backgroundColor',
        '背景颜色',
        'postchat_backgroundColor_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_fill',
        '填充颜色',
        'postchat_fill_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_bottom',
        '底部距离',
        'postchat_bottom_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_left',
        '左边距离',
        'postchat_left_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_width',
        '宽度',
        'postchat_width_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_frameWidth',
        '框架宽度',
        'postchat_frameWidth_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_frameHeight',
        '框架高度',
        'postchat_frameHeight_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_defaultInput',
        '默认输入',
        'postchat_defaultInput_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_upLoadWeb',
        '上传网站',
        'postchat_upLoadWeb_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_showInviteLink',
        '显示邀请链接',
        'postchat_showInviteLink_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_userTitle',
        '界面标题',
        'postchat_userTitle_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_userDesc',
        '聊天界面描述',
        'postchat_userDesc_render',
        'postchat',
        'postchat_section_chat'
    );

    add_settings_field(
        'postchat_addButton',
        '是否显示按钮',
        'postchat_addButton_render',
        'postchat',
        'postchat_section_chat'
    );
}
add_action('admin_init', 'postchat_settings_init');

// 步骤 5：处理选项验证
function postchat_options_validate($input) {
    $defaults = postchat_get_default_options();
    $validated = [];

    foreach ($defaults as $key => $default) {
        if (isset($input[$key])) {
            if (is_bool($default)) {
                $validated[$key] = $input[$key] ? 1 : 0;
            } else {
                $validated[$key] = sanitize_text_field($input[$key]);
            }
        } else {
            $validated[$key] = $default;
        }
    }

    return $validated;
}

function postchat_section_account_cb() {
    echo '请填写您的账户信息';
}

function postchat_section_summary_cb() {
    echo '配置文章摘要功能';
}

function postchat_section_chat_cb() {
    echo '配置智能对话功能';
}

// 步骤 4：（可选）在插件激活时初始化默认选项
register_activation_hook(__FILE__, 'postchat_activate');

function postchat_activate() {
    $default_options = postchat_get_default_options();
    add_option('postchat_options', $default_options);
}

?>
