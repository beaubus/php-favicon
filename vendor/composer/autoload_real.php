<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit032f7650bf40e8daa5c461e97ac9908c
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit032f7650bf40e8daa5c461e97ac9908c', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit032f7650bf40e8daa5c461e97ac9908c', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit032f7650bf40e8daa5c461e97ac9908c::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}