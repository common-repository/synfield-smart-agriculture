<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Base;

/**
 * Class BaseController
 * @package SynField\Base
 */
class BaseController
{
    /**
     * @var string $plugin The plugin name
     */
    public $plugin;
    /**
     * @var string $plugin_path The plugin path
     */
    public $plugin_path;
    /**
     * @var string $plugin_url The plugin url
     */
    public $plugin_url;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->plugin = $this->getPluginName();
        $this->plugin_path = $this->getPluginPath();
        $this->plugin_url = $this->getPluginUrl();
    }

    /**
     * Define if an option is activated or not.
     * @param string $option The option
     * @return bool
     */
    public function activated($option)
    {
        return isset($option) ? $option : false;
    }

    /**
     * Get the plugin name
     * @return string    The path of plugin name
     */
    private function getPluginName()
    {
        // PHP 7+
        // return plugin_basename( dirname(__FILE__, 3) )  . '/synfield-smart-agriculture.php' ;

        // PHP 5.3 to 5.6
        return plugin_basename(realpath(__DIR__ . '/../..')) . '/synfield-smart-agriculture.php';
    }

    /**
     * Get the plugin path
     * @return string    The path of plugin folder
     */
    private function getPluginPath()
    {
        // PHP 7+
        // return plugin_dir_path( dirname(__FILE__, 2)  );

        // PHP 5.3 to 5.6
        return plugin_dir_path(realpath(__DIR__ . '/..'));
    }

    /**
     * Get the plugin URL
     * @return string    The URL of plugin
     */
    private function getPluginUrl()
    {
        // PHP 7+
        // return plugin_dir_url( dirname(__FILE__, 2) ) ;

        // PHP 5.3 to 5.6
        return plugin_dir_url(realpath(__DIR__ . '/..'));
    }
}
