<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Base;

use \SynField\Base\BaseController;

/**
 * Class Enqueue
 * @package SynField\Base
 */
class Enqueue extends BaseController
{
    /**
     * Include the Synfield Smart Agriculture plugin assets (styles, scripts & fonts) using the WP Action API.
     */
    public function register()
    {
        $this->enqueueWidget();
        $this->enqueueAdmin();
    }

    public function enqueueWidget()
    {
        add_action('wp_enqueue_scripts', array($this, 'loadWidgetStyles'));
        add_action('wp_enqueue_scripts', array($this, 'loadWidgetScripts'));
        add_action('wp_enqueue_scripts', array($this, 'loadWpGoogleFonts'));
    }

    public function enqueueAdmin()
    {
        add_action('admin_enqueue_scripts', array($this, 'loadAdminStyles'));
        add_action('admin_enqueue_scripts', array($this, 'loadAdminScripts'));
    }

    /**
     * Register the style if source provided and enqueues
     */
    public function loadWidgetStyles()
    {
        wp_enqueue_style('synfield-smart-agriculture-fonts', $this->plugin_url . 'assets/css/fontawesome.min.css');
        wp_enqueue_style('synfield-smart-agriculture-widget', $this->plugin_url . 'assets/css/synfield_widget.css');
    }

    /**
     * Register the style if source provided and enqueues
     */
    public function loadWidgetScripts()
    {
        wp_enqueue_script('synfield-smart-agriculture', $this->plugin_url . 'assets/js/fontawesome.min.js');
        wp_enqueue_script('synfield-smart-agriculture-widget', $this->plugin_url . 'assets/js/synfield-widget.js');
    }

    /**
     * Register the fonts and enqueues
     */
    public function loadWpGoogleFonts()
    {
        $use_google_font = apply_filters('synfield_smart_agriculture_use_google_font', true);
        $google_font_queuename = apply_filters('synfield_smart_agriculture_google_font_queue_name', 'opensans-googlefont');

        if ($use_google_font) {
            wp_enqueue_style($google_font_queuename, 'https://fonts.googleapis.com/css?family=Open+Sans:400,300');
            wp_add_inline_style('synfield-smart-agriculture', ".synfield-smart-agriculture-wrap { font-family: 'Open Sans', sans-serif;  font-weight: 400; font-size: 14px; line-height: 14px; } ");
        }
    }

    /**
     * Register the style of the SynField Weather plugin in the admin panel (settings page)
     */
    public function loadAdminStyles()
    {
        wp_enqueue_style('synfield-smart-agriculture', $this->plugin_url . 'assets/css/synfield-admin.css');
    }

    /**
     * Register the scripts of the SynField Plugin settings in admin panel
     */
    public function loadAdminScripts()
    {
        wp_enqueue_script('synfield-smart-agriculture', $this->plugin_url . 'assets/js/synfield-admin.js');
    }
}