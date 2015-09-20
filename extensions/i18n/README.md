##Flarum 多语言插件  
本插件很好的实现了 [Flarum](http://flarum.org) 的多语言共存，前台支持多语言任意切换，和后台配置前台默认语言   
默认集成基于 Flarum 原生语言包翻译出来的中文简体语言包  
整体语言风格较细腻自然，符合多数中国人思维习惯  
**DEMO:** [FlarumOne](https://flarumone.com/)
  
###安装说明  
1.下载后解压并将其上传至 Flarum 根目录下的`extensions`目录内  
2.进入网站后台，修改默认的本地语言为简体中文后，刷新前台页面即可

###扩展和修改
为了扩展方便，我们规范所有插件的本地化翻译文件统一存放在一个文件夹内，文件夹的命名参照google的语言和语言代码对照表（即`src\languagecodes.yml`文件）  
个插件的本地化翻译文件的命名，采用插件名称+`.yml`后缀  
Flarum 核心的本地化翻译文件使用`core.yml`进行命名  

####附：目录结构
```
i18n
├── bootstrap.php
├── composer.json
├── flarum.json
├── LICENSE
├── locale
│   ├── fr
│   │   ├── core.js
│   │   ├── core.php
│   │   ├── core.yml
│   │   ├── likes.yml
│   │   ├── lock.yml
│   │   ├── mentions.yml
│   │   ├── pusher.yml
│   │   ├── sticky.yml
│   │   ├── subscriptions.yml
│   │   └── tags.yml
│   └── zh_CN
│       ├── core.js
│       ├── core.php
│       ├── core.yml
│       ├── likes.yml
│       ├── lock.yml
│       ├── mentions.yml
│       ├── pusher.yml
│       ├── sticky.yml
│       ├── subscriptions.yml
│       └── tags.yml
├── README.md
├── src
│   ├── Extension.php
│   └── languagecodes.yml
└── vendor
    ├── autoload.php
    └── composer
        ├── autoload_classmap.php
        ├── autoload_namespaces.php
        ├── autoload_psr4.php
        ├── autoload_real.php
        ├── ClassLoader.php
        ├── installed.json
        └── LICENSE
```

###更新记录 
####2015/9/14
**修复语言包一处错误** 

####2015/9/14
**修复某些插件找不到英文语言文件报错的问题**  

####2015/8/30 
**让插件的多语言变得更聪明**  
通过继承核心的默认语言设定 去识别您是否添加了对应的语言包  
  
###获取帮助  
如有疑问或建议，请直接提出问题   
与此同时，我们也希望您到 [FlarumOne](https://flarumone.com/) 互动交流
  
####特别鸣谢 小黄鸡 **Jsthon Wong** 同学  
本插件中文简体语言包原始翻译由他完成 [https://github.com/jsthon/Flarum-zh-CN](https://github.com/jsthon/Flarum-zh-CN)  
关于该版翻译不恰当的请找她，下面是她的联系方式  
* **博客/Blog:** <http://jsthon.com>  
* **邮箱/Mail:** jsthonwong@gmail.com  
