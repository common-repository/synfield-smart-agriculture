<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Api\Callbacks;

use \SynField\Base\BaseController;

/**
 * Class AdminCallbacks
 * @package SynField\Api\Callbacks
 */
class AdminCallbacks extends BaseController
{
    /**
     * @return mixed
     */
    public function adminSettings()
    {
        return require_once($this->plugin_path . "/templates/admin.php");
    }

    /**
     *
     */
    public function synfieldSmartAgricultureSection()
    {
        echo __('SynField global settings', 'synfield-weather');
    }

    /**
     *
     */
    public function synfieldSmartAgricultureAppKeyField()
    {
        if (defined('SYNFIELD_WEATHER_APP_ID')) {
            echo "<em>" . __('Defined in wp-config', 'synfield_app_key') . ": " . SYNFIELD_WEATHER_APP_ID . "</em>";
        } else {
            $field = esc_attr(apply_filters('SYNFIELD_WEATHER_APP_ID', get_option('synfield_app_key')));

            $appIdForm = "<input type='text' name='synfield_app_key' value='$field' style='width:70%;' placeholder='" . __('enter here the API key', 'synfield-weather') . "'/>";
            $appIdDescription = '<p>' . __('The <strong>API key</strong> is provided by', 'synfield-weather') . ' <a href="//www.synfield.gr" target="_blank">Synelixis Solutions</a>. ';
            $appIdDescription .= '' . __('This API key is used when the API key field in the widget form is empty.', 'synfield-weather').'</p>';
            echo $appIdForm . $appIdDescription;
        }
    }

    /**
     *
     */
    public function synfieldSmartAgricultureAppKeyErrorField()
    {
        $field = esc_attr(get_option('synfield_app_key_error'));
        if (!$field) {
            $field = "source";
        }

        $options = "<p>";
        $options .= __("What should the plugin do when there is an error?<br>", 'synfield-weather');
        $options .= "<input type='radio' name='synfield_app_key_error' value='source' " . checked($field, 'source', false) . " /> " . __('Hidden', 'synfield-weather') . "<br/>";
        $options .= "<input type='radio' name='synfield_app_key_error' value='display-admin' " . checked($field, 'display-admin', false) . " /> " . __('Visible from admin', 'synfield-weather') . "<br/>";
        $options .= "<input type='radio' name='synfield_app_key_error' value='display-all' " . checked($field, 'display-all', false) . " /> " . __('Visible from anyone', 'synfield-weather') . "<br/>";
        $options .= "</p>";

        echo $options;
    }


}