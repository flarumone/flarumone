![Flarum](http://flarum.org/img/logo.png)

**[FlarumOne](http://flarumone.com) 基于 Flarum 轻论坛的中文增强发行版**
Flarum 是一款优雅简洁论坛软件，让在线交流变得更加轻松愉快
FlarumOne 主要亮点是尽可能的适应国内使用场景，首先对其进行汉化并使其支持多语言切换，其次优化中文搜索，并改默认google字体的cdn为360提供，提升国内用户的加载速度
后续将扩展中文分词搜索，手机号码注册账号，国内第三方登陆

## 已集成扩展
名称 | 功能简述
------------ | -------------
akismet | 第三方阻止垃圾内容的服务，使用前需向`akismet.com`申请`API Key`
bbcode | 让帖子和回复支持`BBCode`
emoji | 让帖子和回复支持`emoji`表情代码
i18n | i18n（其来源是英文单词 internationalization的首末字符i和n，18为中间的字符数）是“国际化”的简称。详细介绍可以参见：`https://github.com/flarumone/i18n`
imageattachments | 这是个截图上传扩展，可以直接将截图粘贴到发帖和回复的输入框内，程序将会把截图自动上传到服务器
likes | 实现点赞
likesearch | 支持中文搜索
lock | 锁帖，禁止任何人回复
markdown | 让帖子和回复支持`markdown`语法，功能强大，可参考：`https://guides.github.com/features/mastering-markdown`
mentions | 就是`@`功能，圈人用的
noslug | 清除帖子url后面的标题参数，使url更优雅
pusher | 论坛的动态推送功能，在用户不刷新页面的情况下，也可收到别的用户对论坛的内容更新提醒
reports | 给用户举报违规内容用的，自己不可以举报自己
s9e-autoimage | 可自动将帖子或回复内的图片地址可视化，入直接将`http://flarum.org/img/logo.png`放到回复中，发布后，即可显示图片，而不是一个`url`
s9e-mediaembed | 可讲优酷视频地址自动转成引用视频给插入到帖子或回复中
sticky | 实现帖子顶置
subscriptions | 站内通知功能，如：接受关注的帖子的动态、自己的帖子被点赞，等
suspend | 禁言，禁止用户发布帖子和回复
tags | 标签

> **Demo:**[http://flarumone.com](http://flarumone.com)

[下载](https://github.com/flarumone/flarumone/releases) - [文档](http://php.szlt.net/flarum/index.html) - [支持](http://flarumone.com)

![截图](http://flarum.org/img/screenshot.png)

## 安装
> **FlarumOne 目前处于测试阶段，因此不要将它用在生产环境中。**

想立即使用 FlarumOne，可以到[下载](https://github.com/flarumone/flarumone/releases)页面。
你需要一个安装了 **PHP 5.5+** 和 **MySQL 5.5+** 的服务器。

## 亮点
Flarum 继承于 [esoTalk](http://esotalk.org) 和 [FluxBB](http://fluxbb.org)
- **快速、简单** 没有混乱，没有膨胀，没有复杂的依赖关系。Flarum 使用 PHP 构建，因此它很容易部署。界面使用 Mithril，它是一个高性能 JavaScript 框架。
- **漂亮、响应式** Flarum 由我们的设计师精心设计，它是跨平台的、开箱即用的。界面布局使用了 LESS，所以主题风格只是小事一桩。
- **强大、可扩展** 为了满足您的社区需求，您可以定制、扩展和集成 Flarum。Flarum 的架构非常灵活，它拥有非常全面的 API 和文档。
- **自由、开放** Flarum 基于 [MIT license](https://github.com/flarum/flarum/blob/master/LICENSE) 发布。


