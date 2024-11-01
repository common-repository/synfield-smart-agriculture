<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Base;

use \SynField\Base\BaseController;

/**
 * Class SettingsLinks
 * @package SynField\Base
 */
class SettingsLinks extends BaseController
{
    /**
     * Enrich the plugin links
     */
    public function register()
    {
        add_filter("plugin_action_links_$this->plugin", array($this, 'addSettingsLink'));
    }

    /**
     * Append the settings link of the plugin in the existing ones
     * @param array $links The default links of the plugin
     * @return array       The list of links including the settings link
     */
    public function addSettingsLink($links)
    {
        $settings_link = '<a href="options-general.php?page=synfield-smart-agriculture">' . __("Settings", "synfield-smart-agriculture") . '</a>';
        array_push($links, $settings_link);
        return $links;
    }
}
