<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField;

/**
 * Class Bootstrap
 * @package SynField
 */
final class Bootstrap
{
    /**
     * Store all the classes in array
     * @return array List of classes
     */
    public static function getServices()
    {
        return array(
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Base\WidgetController::class,
            Pages\Admin::class,
        );
    }

    /**
     * Loop through the classes and initialize them and
     * call the register() method if it exists
     */
    public static function registerServices()
    {
        foreach (self::getServices() as $class) {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param class $class The class from the services array
     * @return mixed Class instance
     */
    private static function instantiate($class)
    {
        return new $class();
    }
}
