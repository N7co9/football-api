<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit497f22c4eb77721ad1a8aedbc556ac3f
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit497f22c4eb77721ad1a8aedbc556ac3f::$classMap;

        }, null, ClassLoader::class);
    }
}
