# 说明

think-swoole路由加载器

## 安装

`composer require ledc/swoole-routes`

## 使用说明

### 初始化路由引导文件
安装完之后，请执行以下命令，初始化路由引导文件 `php think route:list`


### 注册路由

在服务类 `register` 或 `boot` 方法中添加以下代码（任选一）

```php

use Ledc\SwooleRoutes\Autoloader;

// 添加路由文件：子进程重启会重新加载路由文件（即路由规则热更新）
Autoloader::addFile(__DIR__ . '/route.php');

// 添加路由目录：子进程重启会重新扫描目录内的新增路由文件，并加载（即路由文件热更新）
Autoloader::addDirectory(__DIR__ . '/route');
```

## 测试

执行命令 `php think route:list` 检查路由是否加载成功

## 官方文档

https://github.com/top-think/think-swoole

https://doc.thinkphp.cn/v6_1/Swoole.html

https://doc.thinkphp.cn/v8_0/think_swoole.html

## 捐赠

如果项目帮到您，可以请作者喝杯咖啡，深表谢意！

![reward](reward.png)