<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit782cee56931952c65a985f871b65f8fa
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

        spl_autoload_register(array('ComposerAutoloaderInit782cee56931952c65a985f871b65f8fa', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit782cee56931952c65a985f871b65f8fa', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit782cee56931952c65a985f871b65f8fa::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
