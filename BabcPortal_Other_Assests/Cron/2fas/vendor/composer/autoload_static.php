<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb4ef1e5ba783a097f0f9350ffa26059e
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RobThree\\Auth\\' => 14,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RobThree\\Auth\\' => 
        array (
            0 => __DIR__ . '/..' . '/robthree/twofactorauth/lib',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb4ef1e5ba783a097f0f9350ffa26059e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb4ef1e5ba783a097f0f9350ffa26059e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb4ef1e5ba783a097f0f9350ffa26059e::$classMap;

        }, null, ClassLoader::class);
    }
}
