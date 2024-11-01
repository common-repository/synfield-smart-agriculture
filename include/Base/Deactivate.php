<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Base;

/**
 * Class Deactivate
 * @package SynField\Base
 */
class Deactivate
{
    /**
     * The deactivation method
     */
    public static function deactivate()
    {
        // flush rewrite rules
        flush_rewrite_rules();
        // Remove the SynField weather plugin options
        $options = self::getOptions();
        self::deleteOptions($options);
    }

    /**
     * Get the options of the SynField Smart Agriculture Plugin settings in the admin panel
     */
    private static function getOptions()
    {
        return array(
            'synfield_app_key',
            'synfield_app_key_error'
        );
    }

    /**
     * Delete the options of the SynField Smart Agriculture Plugin settings in the admin panel
     * @param array $options The options
     */
    private static function deleteOptions($options)
    {
        foreach ($options as $option) {
            // use the hook that wordpress provides
            delete_option($option);
        }
    }
}
