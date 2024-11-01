<?php

/**
 * @package SynFieldSmartAgriculture
 */

/*
Plugin Name: SynField Smart Agriculture
Plugin URI: https://www.synfield.gr
Description: Enable the data visualization of SynField nodes in a widget.
Version: 0.2.0
Author: Synelixis Solutions
Author URI: https://www.synelixis.com
License: GPLv3
Text Domain: synfield-smart-agriculture
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2007-2019 Synelixis Solutions SA
*/

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('Hey, you can\t access this file!');

// Use the autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

// Define the URL of the SynField web service as a constant
define('SYNFIELD_SMART_AGRICULTURE_API_BASE_URL', 'https://app.synfield.gr/en/api/v1/wp/widget/nodes/');

use SynField\Bootstrap;
use SynField\Base\Activate;
use SynField\Base\Deactivate;

/**
 * Activate the plugin
 */
function activate_synfield_smart_agriculture()
{
    Activate::activate();
}

/**
 * Deactivate the plugin
 */
function deactivate_synfield_smart_agriculture()
{
    Deactivate::deactivate();
}

register_activation_hook(__FILE__, 'activate_synfield_smart_agriculture');
register_deactivation_hook(__FILE__, 'deactivate_synfield_smart_agriculture');

/**
 * Initialize the proper classes of the plugin
 */
if (class_exists('SynField\\Bootstrap')) {
    Bootstrap::registerServices();
}