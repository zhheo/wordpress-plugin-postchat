=== PostChat ===
 
Contributors: zhheo
Tags: AI,PostChat,HongMo,Customer Service,GPT
Donate link: https://rewards.zhheo.com/
Tested up to: 6.7
Stable tag: 2.2
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
  
一个人工智能工具插件，用于提供基于网站内容的摘要生成、知识库对话和搜索。
  
== Description ==
  
PostChat插件支持将你的网站内容添加到知识库，并且支持访客通过知识库来与AI进行对话，并且支持AI搜索功能。还可以为你的博客文章生成AI摘要，让用户更方便的知道这个文章讲了什么。是一个让你的网站升级成为AI站点的绝佳插件。

** 目前只支持中文和中国大陆地区使用。 **

![](https://bu.dusays.com/2024/12/16/675fda0c40691.jpeg)

## PostChat

PostChat的WordPress插件，也支持文章摘要用户使用

## 功能

这个插件支持PostChat用户和文章摘要用户使用。文章摘要用户可以在插件设置中关闭“智能对话”功能即可。

- 文章摘要生成功能
- 文章知识库功能
- 文章知识库对话功能
- 文章AI搜索功能

更多功能可以参见：https://ai.tianli0.top/

## 本插件在Wordpress中的表现

[预览地址](https://wp.zhheo.com/index.php/2024/07/09/dongporou/)

## PostChat在更多网站中的表现

[张洪Heo](https://blog.zhheo.com/)

[Tianli](https://tianli-blog.club/)

## 插件配置

点击左侧的“设置”，选择“PostChat”

![help1.webp](https://img.zhheo.com/i/2024/07/09/668cb3e669711.webp)

## 主题适配

此插件支持所有的PostChat开发API，提供主题开发者对于PostChat的控制能力。包括深色模式切换：`postChatUser.setPostChatTheme('dark')`；聊天窗口输入框：`postChatUser.setPostChatInput(content)`等。

详见开发者文档：https://postchat.zhheo.com/advanced/theme.html

## 开发者

PostChat由[张洪Heo](https://github.com/zhheo)与[Tianli](https://github.com/TIANLI0)共同构建，技术支持请联系：zhheo@qq.com（一个工作日内回复）
  
== Frequently Asked Questions ==
  
= 我如何使用这个插件？ =
  
安装插件成功后，前往 https://ai.tianli0.top/ 去注册一个账号，在开通会员后即可获取到账户KEY，进入插件设置界面替换账户KEY为自己的账户KEY即可。
产品使用文档：https://postchat.zhheo.com/newUser.html

= PostChat是如何定价的？ =

PostChat插件为PostChat会员和摘要AI两款产品的用户服务。

使用摘要AI用户（https://summary.zhheo.com/）可以享受生成文章摘要的功能，费用为10CNY/50000tokens

使用PostChat会员用户享受摘要AI的无限制Tockens额度，并支持对话、搜索等高级功能，费用为18CNY/月或128CNY/年
  
== Screenshots ==
1. 唤醒PostChat主界面
2. PostChat的知识库对话功能
3. PostChat的搜索功能
4. PostChat的摘要AI功能，可以为文章生成摘要在文章顶部展示

== External services ==

此插件将网页内容连接到TianliGPT获取AI摘要信息。每次加载网页时，它都会发送当前网页中经过网站站长的规则筛选处理的部分的内容给TianliGPT，并获取来自TianliGPT的文章摘要总结内容服务。用户需要使用来自PostChat的账户Key才可以使用。（官网地址：https://postchat.zhheo.com/）

服务涉及到的外部资源链接：
- https://ai.tianli0.top/static/public/postChatUser_summary.min.css
- https://ai.tianli0.top/static/public/postChatUser_summary.min.js
- https://ai.tianli0.top/static/public/tianli_gpt.min.js
-	https://ai.tianli0.top/static/public/postChatUser.min.js

此服务由“洪绘科技”提供。

[用户协议](https://ai.tianli0.top/static/Agreement.html) [隐私政策](https://ai.tianli0.top/static/PrivacyPolice.html)
  
== Changelog ==
= 2.2 =
优化了插件引入方式，避免添加dom
此举有效解决在子比等一些特殊主题使用css的>符号造成的样式冲突

= 2.1.3 =
全新发布的 PostChat 插件，支持网站内容知识库对话及搜索功能。首次安装后需要在后台配置 账户KEY 才能正常使用。

== Upgrade Notice ==
= 2.2 =
优化了插件引入方式，避免添加dom
此举有效解决在子比等一些特殊主题使用css的>符号造成的样式冲突

= 2.1.3 =
全新发布的 PostChat 插件，支持网站内容知识库对话及搜索功能。首次安装后需要在后台配置 账户KEY 才能正常使用。

