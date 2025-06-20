<?php

namespace Ledc\SwooleRoutes;

/**
 * 路由加载器
 */
final class Autoloader
{
    /**
     * 路由文件
     * - 主进程添加的路由文件，子进程继承
     * @var array
     */
    private static array $routesFile = [];
    /**
     * 路由目录
     * - 主进程添加的路由目录，子进程继承；子进程重启会重新扫描目录内的新增路由文件，并加载（即路由文件热更新）
     * @var array
     */
    private static array $routesDirectory = [];

    /**
     * 添加路由文件
     * - 子进程重启会重新加载路由文件（即路由规则热更新）
     * @param string $file 路由文件
     * @return void
     */
    public static function addFile(string $file): void
    {
        if (is_file($file)) {
            $path = realpath($file);
            self::$routesFile[md5($path)] = $path;
        }
    }

    /**
     * 添加路由目录
     * - 子进程重启会重新扫描目录内的新增路由文件，并加载（即路由文件热更新）
     * @param string $directory 路由目录
     * @return void
     */
    public static function addDirectory(string $directory): void
    {
        if (is_dir($directory)) {
            $path = realpath(rtrim($directory, '/\\'));
            self::$routesDirectory[md5($path)] = $path;
        }
    }

    /**
     * 批量添加路由文件
     * @param string $directory 路由目录
     * @return void
     */
    public static function batchFile(string $directory): void
    {
        if (is_dir($directory)) {
            foreach (glob(rtrim($directory, '/\\') . DIRECTORY_SEPARATOR . '*.php') as $file) {
                self::addFile($file);
            }
        }
    }

    /**
     * 加载路由文件
     * - 在 worker 子进程执行
     * @return void
     */
    public static function loadRoutesFromFiles(): void
    {
        clearstatcache();
        foreach (self::$routesDirectory as $hash => $directory) {
            self::batchFile($directory);
        }

        foreach (self::$routesFile as $hash => $file) {
            if (is_file($file)) {
                include $file;
            }
        }
    }
}
