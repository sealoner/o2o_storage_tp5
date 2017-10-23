基于ThinkPHP5.X搭建的O2O商城
===============

> ThinkPHP5的运行环境要求PHP5.4以上。

## 项目说明
PHP刚入门接触的第一个框架是ThinkPHP3.2，那个时候，单字母函数对于我这个新手小白来说简单而又直白，但是随着学习深度的增加，这种函数命名方式在我看来变得越来越愚蠢和尴尬。

2017年3月，ThinkPHP5.0发布，不仅增加了Composer及单元测试，还支持惰性加载以及自动加载的缓存机制，底层的代码也进行了重构，更重要的是拜托了那愚蠢的单字母函数，整个框架与TP3.X相比，变得更加优雅与高效（虽然随处可见Laravel的影子(￣▽￣)~* )。

最近正好有空在整理电脑，发现了很多从前自己写的项目，有已经写完的也有还差几个功能模块没写的，借此机会将这些还没有完成的项目放在GitHub上，慢慢的将之补全，也希望可以帮助那些有需要的人节省一些重复造轮子的时间。

这套代码是基于ThinkPHP5.0.3框架开发的一套O2O线上商城，于2017年5月底完成基本功能的构建，包括：
1. 前、后台模块页面的搭建；
2. 数据库的构建；
3. 商家的会话管理与CRUD；
4. 管理员的会话管理与CRUD；
5. 生活服务分类管理模块；
6. 百度地图应用的封装；
7. 封装phpmailer类库；
8. 商户模块（图片上传处理、商户入驻后台的开发、门店管理、团购商品列表页开发等）；
9. 推荐位管理；
10. 前台页面商品详情页的开发；
11. 商品的抢购与秒杀；
12. 订单及微信支付（待开发）

…………

## 数据库
数据库名称为`o2o_storage`，如要修改，请在`\application\database.php`中的'database'配置项中修改默认数据库名。

数据表文件以及测试数据，见包中的`o2o_storage.sql`文件。

## 近期目标
1. 改Bug
2. 完成微信支付接口模块

## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─module_name        模块目录
│  │  ├─config.php      模块配置文件
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  ├─view            视图目录
│  │  └─ ...            更多类库目录
│  │
│  ├─command.php        命令行工具配置文件
│  ├─common.php         公共函数文件
│  ├─config.php         公共配置文件
│  ├─route.php          路由配置文件
│  ├─tags.php           应用行为扩展定义文件
│  └─database.php       数据库配置文件
│
├─public                WEB目录（对外访问目录）
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─thinkphp              框架系统目录
│  ├─lang               语言文件目录
│  ├─library            框架类库目录
│  │  ├─think           Think类库包目录
│  │  └─traits          系统Trait目录
│  │
│  ├─tpl                系统模板目录
│  ├─base.php           基础定义文件
│  ├─console.php        控制台入口文件
│  ├─convention.php     框架惯例配置文件
│  ├─helper.php         助手函数文件
│  ├─phpunit.xml        phpunit配置文件
│  └─start.php          框架入口文件
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

> router.php用于php自带webserver支持，可用于快速测试
> 切换到public目录后，启动命令：php -S localhost:8888  router.php
> 上面的目录结构和名称是可以改变的，这取决于你的入口文件和配置参数。
