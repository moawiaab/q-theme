<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7e1be9d22185d527782395d36654c589
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Moawiaab\\QTheme\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Moawiaab\\QTheme\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7e1be9d22185d527782395d36654c589::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7e1be9d22185d527782395d36654c589::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit7e1be9d22185d527782395d36654c589::$classMap;

        }, null, ClassLoader::class);
    }
}
