<?php
/*
Plugin Name: PostChat
Plugin URI: https://ai.tianli0.top/
Description: 文章智能摘要与AI对话插件
Requires at least: 5.8
Requires PHP: 5.6.20
Version: 2.0.0
Author: 张洪Heo
Author URI: https://zhheo.com/
License: GPLv2
*/

// 确保直接访问文件时退出
if (!defined('ABSPATH')) {
  exit;
}

require_once plugin_dir_path(__FILE__) . 'postchat-settings.php';
require_once plugin_dir_path(__FILE__) . 'postchat-insert.php'; 