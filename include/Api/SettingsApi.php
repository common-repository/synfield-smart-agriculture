<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Api;

/**
 * Class SettingsApi
 * @package SynField\Api
 */
class SettingsApi
{
    /**
     * @var array $admin_pages The list of admin pages
     */
    public $admin_pages = array();
    /*
     * @var array $options_pages  The list of options pages
     */
    public $options_pages = array();
    /**
     * @var array $settings The plugin settings in the admin panel
     */
    public $settings = array();
    /**
     * @var array $settings_sections The sections of the plugin settings in the admin panel
     */
    public $settings_sections = array();
    /**
     * @var array $settings_fields The fields of the plugin settings in the admin panel
     */
    public $settings_fields = array();

    /**
     * Register the options pages in the admin panel
     */
    public function register()
    {
        if (!empty($this->options_pages)) {
            add_action('admin_menu', array($this, 'addAdminOptions'));
        }

        if (!empty($this->settings)) {
            add_action('admin_init', array($this, 'registerCustomFields'));
        }
    }

    /**
     * Append the menu pages to the admin pages
     * @param array $menuPages The pages to be added
     * @return $this The instance
     */
    public function appendMenuPages($menuPages)
    {
        $this->admin_pages = $menuPages;
        return $this;
    }

    /**
     * Append the option pages to the option pages
     * @param array $optionPages The pages to be added
     * @return  $this The pages
     */
    public function appendOptionsPages($optionPages)
    {
        $this->options_pages = $optionPages;
        return $this;
    }

    /**
     * Generate a menu page in the admin panel for each page
     */
    public function addAdminMenu()
    {
        foreach ($this->admin_pages as $page) {
            add_menu_page($page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'],
                $page['callback'], $page['icon_url'], $page['position']);
        }
    }

    /**
     * Generate an options page in the admin panel for each page
     */
    public function addAdminOptions()
    {
        foreach ($this->options_pages as $page) {
            add_options_page($page['page_title'], $page['menu_title'], $page['capability'],
                $page['menu_slug'], $page['callback']);
        }
    }

    /**
     * @param array $settings The settings
     * @return $this
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @param array $settings_sections The sections in the settings
     * @return $this
     */
    public function setSettingsSections($settings_sections)
    {
        $this->settings_sections = $settings_sections;
        return $this;
    }

    /**
     * @param array $settings_fields The fields in the settings
     * @return $this
     */
    public function setSettingsFields($settings_fields)
    {
        $this->settings_fields = $settings_fields;
        return $this;
    }

    /**
     * Register the settings (including sections and fields)
     */
    public function registerCustomFields()
    {
        // register_setting
        foreach ($this->settings as $setting) {
            register_setting($setting["option_group"], $setting["option_name"],
                (isset($setting["callback"]) ? $setting["callback"] : ''));
        }

        // add_settings_section
        foreach ($this->settings_sections as $section) {
            add_settings_section($section["id"], $section["title"],
                (isset($section["callback"]) ? $section["callback"] : ''), $section["page"]);
        }

        // add_settings_field
        foreach ($this->settings_fields as $field) {
            add_settings_field($field["id"], $field["title"], (isset($field["callback"]) ? $field["callback"] : ''),
                $field["page"], $field["section"], (isset($field["args"]) ? $field["args"] : ''));
        }
    }
}