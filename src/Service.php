<?php

namespace Ledc\SwooleRoutes;

use think\Route;

/**
 * 系统服务类
 */
class Service extends \think\Service
{
    /**
     * 绑定容器对象
     * @var array
     */
    public array $bind = [];

    /**
     * 服务注册
     * @description 通常用于注册系统服务，也就是将服务绑定到容器中。
     * @return void
     */
    public function register(): void
    {
        // 路由加载器
        $autoload = root_path() . 'route/ledc_swoole_routes.php';
        if (!is_file($autoload)) {
            $content = <<<AUTOLOAD
<?php
// 加载路由文件：在worker子进程中执行
Ledc\SwooleRoutes\Autoloader::loadRoutesFromFiles();
AUTOLOAD;
            file_put_contents($autoload, $content . PHP_EOL);
        }
    }

    /**
     * 服务启动
     * @description 在所有的系统服务注册完成之后调用，用于定义启动某个系统服务之前需要做的操作。
     * @param Route $route
     * @return void
     */
    public function boot(Route $route): void
    {
        // 添加路由文件：子进程重启会重新加载路由文件（即路由规则热更新）
        // Autoloader::addFile(__DIR__ . '/route.php');

        // 添加路由目录：子进程重启会重新扫描目录内的新增路由文件，并加载（即路由文件热更新）
        // Autoloader::addDirectory(__DIR__ . '/route');
    }
}
