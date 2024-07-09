<?php

// 创建设置页面
function postchat_add_admin_menu() {
  add_options_page(
    'PostChat Settings',
    'PostChat',
    'manage_options',
    'postchat',
    'postchat_options_page'
  );
}
add_action('admin_menu', 'postchat_add_admin_menu');

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

function postchat_options_validate($input) {
  $input['key'] = sanitize_text_field($input['key']);
  $input['postSelector'] = sanitize_text_field($input['postSelector']);
  $input['title'] = sanitize_text_field($input['title']);
  $input['summaryStyle'] = sanitize_text_field($input['summaryStyle']);
  $input['postURL'] = sanitize_text_field($input['postURL']);
  $input['blacklist'] = sanitize_text_field($input['blacklist']);
  $input['wordLimit'] = sanitize_text_field($input['wordLimit']);
  $input['backgroundColor'] = sanitize_text_field($input['backgroundColor']);
  $input['bottom'] = sanitize_text_field($input['bottom']);
  $input['left'] = sanitize_text_field($input['left']);
  $input['fill'] = sanitize_text_field($input['fill']);
  $input['width'] = sanitize_text_field($input['width']);
  $input['frameWidth'] = sanitize_text_field($input['frameWidth']);
  $input['frameHeight'] = sanitize_text_field($input['frameHeight']);
  $input['userTitle'] = sanitize_text_field($input['userTitle']);
  $input['userDesc'] = sanitize_text_field($input['userDesc']);
  $input['enableSummary'] = isset($input['enableSummary']) ? 1 : 0;
  $input['typingAnimate'] = isset($input['typingAnimate']) ? 1 : 0;
  $input['enableAI'] = isset($input['enableAI']) ? 1 : 0;
  $input['defaultInput'] = isset($input['defaultInput']) ? 1 : 0;
  $input['upLoadWeb'] = isset($input['upLoadWeb']) ? 1 : 0;
  $input['showInviteLink'] = isset($input['showInviteLink']) ? 1 : 0;
  $input['addButton'] = isset($input['addButton']) ? 1 : 0;
  return $input;
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

function postchat_key_render() {
  $options = get_option('postchat_options', [
    'key' => '70b649f150276f289d1025508f60c5f58a',
    'enableSummary' => true,
    'postSelector' => '#postchat_postcontent',
    'title' => '文章摘要',
    'summaryStyle' => 'https://ai.tianli0.top/static/public/postChatUser_summary.min.css',
    'postURL' => '*',
    'blacklist' => '',
    'wordLimit' => '1000',
    'typingAnimate' => true,
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
    'addButton' => true
  ]);
  ?>
  <input type='text' name='postchat_options[key]' value='<?php echo esc_attr($options['key']); ?>'>
  <p class="description">使用PostChat的用户请前往 <a href="https://ai.tianli0.top/" target="_blank">获取 KEY</a>，只使用文章摘要的用户前往 <a href="https://summary.zhheo.com/" target="_blank">获取 KEY</a> 。示例的Key不支持文章摘要和自定义的知识库问答，但可以使用作者的知识库对话</p>
  <?php
}

function postchat_enableSummary_render() {
  $options = get_option('postchat_options', ['enableSummary' => true]);
  ?>
  <input type='checkbox' name='postchat_options[enableSummary]' <?php checked($options['enableSummary'], 1); ?> value='1'>
  <p class="description">开启文章摘要需要在 <a href="https://summary.zhheo.com/" target="_blank">绑定你的网站</a></p>
  <?php
}

function postchat_postSelector_render() {
  $options = get_option('postchat_options', ['postSelector' => 'article']);
  ?>
  <input type='text' name='postchat_options[postSelector]' value='<?php echo esc_attr($options['postSelector']); ?>'>
  <p class="description">文章选择器，用于选择文章内容。如果没有正常显示摘要，你需要访问 <a href="https://postsummary.zhheo.com/theme/custom.html#%E8%8E%B7%E5%8F%96tianligpt-postselector" target="_blank">学习获取</a>，也可以联系 <a href="mailto:zhheo@qq.com">zhheo@qq.com</a> 发送你的网站地址后获取</p>
  <?php
}

function postchat_title_render() {
  $options = get_option('postchat_options', ['title' => '文章摘要']);
  ?>
  <input type='text' name='postchat_options[title]' value='<?php echo esc_attr($options['title']); ?>'>
  <p class="description">摘要标题，用于显示在摘要顶部的自定义内容</p>
  <?php
}

function postchat_summaryStyle_render() {
  $options = get_option('postchat_options', ['summaryStyle' => 'https://ai.tianli0.top/static/public/postChatUser_summary.min.css']);
  ?>
  <input type='text' name='postchat_options[summaryStyle]' value='<?php echo esc_attr($options['summaryStyle']); ?>'>
  <p class="description">摘要样式css地址，如果你需要自定义摘要的css样式，可以自行修改。</p>
  <?php
}

function postchat_postURL_render() {
  $options = get_option('postchat_options', ['postURL' => '*/archives/*']);
  ?>
  <input type='text' name='postchat_options[postURL]' value='<?php echo esc_attr($options['postURL']); ?>'>
  <p class="description">在符合url条件的网页执行文章摘要功能，通常情况下，绝大多数WordPress网站使用默认配置即可，无需调整</p>
  <?php
}

function postchat_blacklist_render() {
  $options = get_option('postchat_options', ['blacklist' => '']);
  ?>
  <input type='text' name='postchat_options[blacklist]' value='<?php echo esc_attr($options['blacklist']); ?>'>
  <p class="description">填写相关的json地址，帮助文档：<a href="https://postsummary.zhheo.com/parameters.html#tianligpt-blacklist" target="_blank">https://postsummary.zhheo.com/parameters.html#tianligpt-blacklist</a></p>
  <?php
}

function postchat_wordLimit_render() {
  $options = get_option('postchat_options', ['wordLimit' => '1000']);
  ?>
  <input type='text' name='postchat_options[wordLimit]' value='<?php echo esc_attr($options['wordLimit']); ?>'>
  <p class="description">危险操作！如果没有在文章摘要中开启url绑定，更改此变量损失已消耗过的key，因为你提交的内容发生了变化。（PostChat用户无影响，因为摘要数量是无限的）可以设置提交的字数限制，默认为1000字。，帮助文档：<a href="https://postsummary.zhheo.com/parameters.html#tianligpt-wordlimit" target="_blank">https://postsummary.zhheo.com/parameters.html#tianligpt-wordlimit</a></p>
  <?php
}

function postchat_typingAnimate_render() {
  $options = get_option('postchat_options', ['typingAnimate' => true]);
  ?>
  <input type='checkbox' name='postchat_options[typingAnimate]' <?php checked($options['typingAnimate'], 1); ?> value='1'>
  <p class="description">智能的打字效果，模拟流处理的感觉</p>
  <?php
}

function postchat_enableAI_render() {
  $options = get_option('postchat_options', ['enableAI' => true]);
  ?>
  <input type='checkbox' name='postchat_options[enableAI]' <?php checked($options['enableAI'], 1); ?> value='1'>
  <p class="description">添加按钮点击对话的功能，如果你并非PostChat用户，而是仅文章摘要用户，建议关闭此功能</p>
  <?php
}

function postchat_backgroundColor_render() {
  $options = get_option('postchat_options', ['backgroundColor' => '#3e86f6']);
  ?>
  <input type='text' name='postchat_options[backgroundColor]' value='<?php echo esc_attr($options['backgroundColor']); ?>'>
  <p class="description">调整按钮背景色彩</p>
  <?php
}

function postchat_fill_render() {
  $options = get_option('postchat_options', ['fill' => '#FFFFFF']);
  ?>
  <input type='text' name='postchat_options[fill]' value='<?php echo esc_attr($options['fill']); ?>'>
  <p class="description">调整按钮里面图标的颜色</p>
  <?php
}

function postchat_bottom_render() {
  $options = get_option('postchat_options', ['bottom' => '16px']);
  ?>
  <input type='text' name='postchat_options[bottom]' value='<?php echo esc_attr($options['bottom']); ?>'>
  <p class="description">按钮距离底部的边距</p>
  <?php
}

function postchat_left_render() {
  $options = get_option('postchat_options', ['left' => '16px']);
  ?>
  <input type='text' name='postchat_options[left]' value='<?php echo esc_attr($options['left']); ?>'>
  <p class="description">按钮距离左侧的边距，如果填写负值，则是距离右侧的边距。例如left为-3px，实际为right 3px</p>
  <?php
}

function postchat_width_render() {
  $options = get_option('postchat_options', ['width' => '44px']);
  ?>
  <input type='text' name='postchat_options[width]' value='<?php echo esc_attr($options['width']); ?>'>
  <p class="description">调整按钮的宽度</p>
  <?php
}

function postchat_frameWidth_render() {
  $options = get_option('postchat_options', ['frameWidth' => '375px']);
  ?>
  <input type='text' name='postchat_options[frameWidth]' value='<?php echo esc_attr($options['frameWidth']); ?>'>
  <p class="description">调整聊天界面框架的宽度</p>
  <?php
}

function postchat_frameHeight_render() {
  $options = get_option('postchat_options', ['frameHeight' => '600px']);
  ?>
  <input type='text' name='postchat_options[frameHeight]' value='<?php echo esc_attr($options['frameHeight']); ?>'>
  <p class="description">调整聊天界面框架的高度</p>
  <?php
}

function postchat_defaultInput_render() {
  $options = get_option('postchat_options', ['defaultInput' => true]);
  ?>
  <input type='checkbox' name='postchat_options[defaultInput]' <?php checked($options['defaultInput'], 1); ?> value='1'>
  <p class="description">勾选此项时，用户点击按钮后会自动添加本页面标题，让用户更方便的询问关于本页的内容</p>
  <?php
}

function postchat_upLoadWeb_render() {
  $options = get_option('postchat_options', ['upLoadWeb' => true]);
  ?>
  <input type='checkbox' name='postchat_options[upLoadWeb]' <?php checked($options['upLoadWeb'], 1); ?> value='1'>
  <p class="description">勾选此项时，你的网站内容将会被自动提交到PostChat，用户知识库建立和搜索功能</p>
  <?php
}

function postchat_showInviteLink_render() {
  $options = get_option('postchat_options', ['showInviteLink' => true]);
  ?>
  <input type='checkbox' name='postchat_options[showInviteLink]' <?php checked($options['showInviteLink'], 1); ?> value='1'>
  <p class="description">勾选此项时，用户点击PostChat图标将访问你的邀请链接，被邀请用户在注册一年内开通的所有会员你会获得时长奖励。</p>
  <?php
}

function postchat_userTitle_render() {
  $options = get_option('postchat_options', ['userTitle' => 'PostChat']);
  ?>
  <input type='text' name='postchat_options[userTitle]' value='<?php echo esc_attr($options['userTitle']); ?>'>
  <p class="description">你要自定义的PostChat界面标题</p>
  <?php
}

function postchat_userDesc_render() {
  $options = get_option('postchat_options', ['userDesc' => '如果你对网站的内容有任何疑问，可以来问我哦～']);
  ?>
  <input type='text' name='postchat_options[userDesc]' value='<?php echo esc_attr($options['userDesc']); ?>'>
  <p class="description">你要自定义的PostChat聊天界面描述</p>
  <?php
}

function postchat_addButton_render() {
  $options = get_option('postchat_options', ['addButton' => true]);
  ?>
  <input type='checkbox' name='postchat_options[addButton]' <?php checked($options['addButton'], 1); ?> value='1'>
  <p class="description">勾选此项时按钮会被显示。如果你是主题开发者在你自己通过主题开发添加按钮的情况时，建议将前面编辑按钮的参数设置得与你自己创造的按钮的参数相同，以便更好的计算窗口宽高和位置。如果主题开发者期望自行配置，可以用css的!important对内置样式进行覆盖。</p>
  <?php
}

function postchat_options_page() {
  ?>
  <form action='options.php' method='post'>
    <h2>PostChat Settings</h2>
    <?php
    settings_fields('postchat');
    do_settings_sections('postchat');
    submit_button();
    ?>
  </form>
  <?php
}
?>
