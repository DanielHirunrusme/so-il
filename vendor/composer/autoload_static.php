<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit31137a138a8ca9bf6e7c51c4cd9a45ef
{
    public static $files = array (
        'be01b9b16925dcb22165c40b46681ac6' => __DIR__ . '/..' . '/wp-cli/php-cli-tools/lib/cli/cli.php',
        '76fc6c949209497345dda0ef893bb49e' => __DIR__ . '/..' . '/rhumsaa/array_column/src/array_column.php',
        '5a567ab1ed0c941f3e96d2c95015942e' => __DIR__ . '/..' . '/wp-cli/wp-cli/php/Spyc.php',
    );

    public static $prefixesPsr0 = array (
        'c' => 
        array (
            'cli' => 
            array (
                0 => __DIR__ . '/..' . '/wp-cli/php-cli-tools/lib',
            ),
        ),
        'W' => 
        array (
            'WP_CLI' => 
            array (
                0 => __DIR__ . '/..' . '/wp-cli/wp-cli/php',
            ),
        ),
        'S' => 
        array (
            'Symfony\\Component\\Finder\\' => 
            array (
                0 => __DIR__ . '/..' . '/symfony/finder',
            ),
        ),
        'R' => 
        array (
            'Requests' => 
            array (
                0 => __DIR__ . '/..' . '/rmccue/requests/library',
            ),
        ),
        'M' => 
        array (
            'Mustache' => 
            array (
                0 => __DIR__ . '/..' . '/mustache/mustache/src',
            ),
        ),
        'F' => 
        array (
            'FancyGuy\\Composer\\' => 
            array (
                0 => __DIR__ . '/..' . '/fancyguy/webroot-installer/src',
            ),
        ),
        'D' => 
        array (
            'Dotenv' => 
            array (
                0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
            ),
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 
            array (
                0 => __DIR__ . '/..' . '/composer/installers/src',
            ),
        ),
        'B' => 
        array (
            'Bedrock\\Installer' => 
            array (
                0 => __DIR__ . '/../..' . '/scripts',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixesPsr0 = ComposerStaticInit31137a138a8ca9bf6e7c51c4cd9a45ef::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
