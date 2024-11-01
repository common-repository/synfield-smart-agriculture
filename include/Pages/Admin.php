<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Pages;

use \SynField\Base\BaseController;
use \SynField\Api\SettingsApi;
use \SynField\Api\Callbacks\AdminCallbacks;

/**
 * Class Admin
 * @package SynField\Pages
 */
class Admin extends BaseController
{
    /**
     * @var object $settings The SettingsApi class instance
     */
    public $settings;
    /**
     * @var object $callbacks The AdminCallbacks class instance
     */
    public $callbacks;
    /**
     * @var array $pages The list of a list of pages
     */
    public $pages;

    /**
     * This method does loads the Option Page for the SynField Smart Agriculture Plugin
     */
    public function register()
    {
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();

        $this->setPages();

        // Load the settings in the admin panel
        $this->setSettings();
        $this->setSettingsSections();
        $this->setSettingsFields();

        $this->settings->appendOptionsPages($this->pages)->register();
    }

    /**
     * Set the option pages to be loaded in the WP admin panel (SynField Smart Agriculture plugin)
     */
    private function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'SynField Smart Agriculture',
                'menu_title' => __('SynField Smart Agriculture'),
                'capability' => 'manage_options',
                'menu_slug' => 'synfield-smart-agriculture',
                'callback' => array($this->callbacks, 'adminSettings')
            )
        );
    }

    /**
     * Set the SynField Smart Agriculture plugin settings in the admin panel
     */
    private function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'synfield_settings_group',
                'option_name' => 'synfield_app_key',
                'callback' => ''
            ),
            array(
                'option_group' => 'synfield_settings_group',
                'option_name' => 'synfield_app_key_error',
                'callback' => ''
            ),
        );
        $this->settings->setSettings($args);
    }

    /**
     * Set the section(s) of the SynField Smart Agriculture plugin settings in the admin panel
     */
    private function setSettingsSections()
    {
        $args = array(
            array(
                'id' => 'synfield_settings_section',
                'title' => '',
                'callback' => array($this->callbacks, 'synfieldSmartAgricultureSection'),
                'page' => 'synfield-smart-agriculture'

            )
        );
        $this->settings->setSettingsSections($args);
    }

    /**
     * Set the fields of the SynField Smart Agriculture plugin settings in the admin panel
     */
    private function setSettingsFields()
    {
        $args = array(
            array(
                'id' => 'synfield_app_key',
                'title' => __('SynField API key', 'synfield-smart-agriculture'),
                'callback' => array($this->callbacks, 'synfieldSmartAgricultureAppKeyField'),
                'page' => 'synfield-smart-agriculture',
                'section' => 'synfield_settings_section',
                'args' => array(
                    'label_for' => 'synfield_app_key'
                )
            ),
            array(
                'id' => 'synfield_app_key_error',
                'title' => __('Error Handling', 'synfield-smart-agriculture'),
                'callback' => array($this->callbacks, 'synfieldSmartAgricultureAppKeyErrorField'),
                'page' => 'synfield-smart-agriculture',
                'section' => 'synfield_settings_section',
                'args' => array(
                    'label_for' => 'synfield_app_key_error'
                )
            )
        );
        $this->settings->setSettingsFields($args);
    }
}