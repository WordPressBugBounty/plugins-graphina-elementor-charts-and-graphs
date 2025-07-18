<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbf153414e17a0d71d2d84d854de531b3
{
    public static $files = array (
        'b7e1c4cbafbabee94a69519a450ea263' => __DIR__ . '/..' . '/kucrut/vite-for-wp/vite-for-wp.php',
    );

    public static $prefixLengthsPsr4 = array (
        'G' => 
        array (
            'Graphina\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Graphina\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbf153414e17a0d71d2d84d854de531b3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbf153414e17a0d71d2d84d854de531b3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbf153414e17a0d71d2d84d854de531b3::$classMap;

        }, null, ClassLoader::class);
    }
}
