<?php

/** This this file on Plugin uninstall
 * @package SynFieldSmartAgriculture
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// define the options related to synfield plugin
$synfield_app_key_option = 'synfield_app_key';
$synfield_app_key_error_option = 'synfield_app_key_error';
$synfield_widget_options = 'widget_synfield_smart_agriculture_widget';

// delete plugin options
delete_option($synfield_app_key_option);
delete_option($synfield_app_key_error_option);
// delete widget options
delete_option($synfield_widget_options);
