<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Base;

/**
 * Class Activate
 * @package SynField\Base
 */
class Activate
{
    /**
     * The activation method
     */
    public static function activate()
    {
        // flush rewrite rules
        flush_rewrite_rules();
        // load the default options in settings
        $options = self::getOptions();
        self::registerDefaultOptions($options);
    }

    /**
     * Get the default options of the SynField Smart Agriculture Plugin settings in the admin panel
     */
    private static function getOptions()
    {
        return array(
            'synfield_app_key' => '',
            'synfield_app_key_error' => 'source'
        );
    }

    /**
     * Insert the default options of the SynField Smart Agriculture Plugin settings in the admin panel
     * @param array $options
     */
    private static function registerDefaultOptions($options)
    {
        foreach ($options as $option => $default) {
            if (!get_option($option)) {
                // use the hook that wordpress provides
                update_option($option, $default);
            }
        }
    }
}
