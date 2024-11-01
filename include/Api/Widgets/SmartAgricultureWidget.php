<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Api\Widgets;

use SynField\Base\BaseController;
use WP_Widget;

/**
 * Class SmartAgricultureWidget
 * @package SynField\Api\Widgets
 */
class SmartAgricultureWidget extends WP_Widget
{
    /**
     * The widget identifier
     * See WP_Widget class.
     * @var string $widget_id
     */
    public $widget_id;
    /**
     * Name for the widget displayed on the configuration page.
     * See WP_Widget class.
     * @var string $widget_name
     */
    public $widget_name;
    /**
     * Option array passed to wp_register_sidebar_widget().
     * See WP_Widget class.
     * @var array $widget_options
     */
    public $widget_options = array();
    /**
     * Option array passed to wp_register_widget_control().
     * See WP_Widget class.
     * @var array $control_options
     */
    public $control_options = array();

    /**
     * SmartAgricultureWidget constructor.
     */
    function __construct()
    {
        $this->widget_id = 'synfield_smart_agriculture_widget';
        $this->widget_name = 'SynField Smart Agriculture Widget';
        $this->widget_options = array(
            'classname' => $this->widget_id,
            'description' => $this->widget_name,
            'customize_selective_refresh' => true,
        );
        $this->control_options = array(
            'width' => 200,
            'height' => 250
        );
        parent::__construct($this->widget_id, $this->widget_name, $this->widget_options, $this->control_options);
    }

    /**
     * Trigger the widget registration by passing the proper arguments
     * in the WP_Widget base class.
     */
    public function register()
    {
        // Init the widget using a callback method `widgetsInit`.
        add_action('widgets_init', array($this, 'widgetsInit'));
    }

    /**
     * Register the SynField Smart Agriculture widget
     */
    public function widgetsInit()
    {
        register_widget($this);
    }

    /**
     * Display the widget content
     * @param array $args
     * @param array $instance
     * @return string   The content
     */
    public function widget($args, $instance)
    {
        $serial_number = isset($instance['serial_number']) ? $instance['serial_number'] : false;
        if ($serial_number) {
            // Compose the endpoint and invoke the web service
            $endpoint = SYNFIELD_SMART_AGRICULTURE_API_BASE_URL . $serial_number . "/measurements";
            $global_api_key = get_option('synfield_app_key');
            $api_key = (isset($instance['api_key']) && !empty($instance['api_key'])) ? $instance['api_key'] : $global_api_key;
            $args = array(
                "headers" => array(
                    "accept" => "application/json",
                    "x-api-key" => $api_key
                ),
                "sslverify" => FALSE
            );
            $request = wp_remote_get($endpoint, $args);
            // get the response
            $response = json_decode($request['body'], true);
            // evaluate the HTTP status code
            $response_status_code = wp_remote_retrieve_response_code($request);
            if ($response_status_code != 200) {
                return $response_status_code;
            }
            $location = $response["location"];
            $node_data = $response["data"];
            $air_temperature = $node_data["air-temperature"];
            $air_humidity = $node_data["air-humidity"];
            $rain = $node_data["rain"];
            $wind_speed = $node_data["wind-speed"];
            $wind_dir = $node_data["wind-direction"];

            echo $args['before_widget'];
            $widget_content = '<div class="synfield_smart_agriculture_widget_container synfield_text_black">
                <table class="synfield_smart_agriculture_table">
                    <thead>
                        <tr>
                            <td colspan="4" class="synfield_smart_agriculture_location synfield_smart_agriculture_body_tr_no_border">' . $location . '</td>
                        </tr>
                        <tr class="synfield_smart_agriculture_head_tr synfield_smart_agriculture_table_row">
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border">
                                <span class="synfield_text_black">
                                    ' . __("Temperature", "synfield-smart-agriculture") . '
                                </span>
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border">
                                <span class="synfield_text_black">
                                    ' . __("Humidity", "synfield-smart-agriculture") . '
                                </span>
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border">
                                <span class="synfield_text_black">
                                    ' . __("Rain", "synfield-smart-agriculture") . '
                                </span>        
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border">
                                <span class="synfield_text_black">
                                    ' . __("Wind", "synfield-smart-agriculture") . '                                
                                </span>        
                            </td>
                        </tr>
                    </thead>
                    <tbody class="synfield_smart_agriculture_widget_body">
                        <tr class="synfield_smart_agriculture_body_tr_no_border synfield_smart_agriculture_table_row">
                            <td class="synfield_text_black text-center text-middle synfield_smart_agriculture_body_tr_no_border"><i class="fas fa-thermometer-half fa-2x"></i></td> 
                            <td class="synfield_text_black text-center text-middle synfield_smart_agriculture_body_tr_no_border"><i class="fas fa-tint fa-2x"></i></td>
                            <td class="synfield_text_black text-center text-middle synfield_smart_agriculture_body_tr_no_border"><i class="fas fa-cloud-rain fa-2x"></i></td>
                            <td class="synfield_text_black text-center text-middle synfield_smart_agriculture_body_tr_no_border"><i class="fas fa-wind fa-2x"></i></span></td>
                        </tr>
                        <tr class="synfield_smart_agriculture_table_row">
                            <td class="synfield_smart_agriculture_font_lg synfield_smart_agriculture_body_tr_no_border synfield_text_black text-center text-middle" title="' . __("Current temperature", "synfield-smart-agriculture") .'"> 
                                ' . $this->serviceValue($air_temperature, 'current') . '<sup><sup>o</sup>' . $air_temperature["units"] . '</sup>
                            </td>
                            <td class="synfield_smart_agriculture_font_lg synfield_smart_agriculture_body_tr_no_border synfield_text_black text-center text-middle" title="' . __("Current humidity", "synfield-smart-agriculture") .'">
                                ' . $this->serviceValue($air_humidity, 'current') . '<sup>' . $air_humidity["units"] . '</sup>
                            </td>
                            <td class="synfield_smart_agriculture_font_lg synfield_smart_agriculture_body_tr_no_border synfield_text_black text-center text-middle" title="' . __("Daily volume of rain", "synfield-smart-agriculture") .'">
                                ' . $this->serviceValue($rain, 'day') . '<sup>' . $rain['units'] . '</sup>
                            </td>
                            <td class="synfield_smart_agriculture_font_lg synfield_smart_agriculture_body_tr_no_border synfield_text_black text-center text-middle" title="' . __("Current wind speed and direction", "synfield-smart-agriculture") .'">
                                ' . $this->serviceValue($wind_speed, 'current') . '<sup>' . $wind_speed["units"] . '</sup><br>
                                <span class="synfield_smart_agriculture_font_sm">' . $this->WindDirectionMapping($this->serviceValue($wind_dir, 'current')) . '</span>
                            </td>
                        </tr>
                        <tr class="synfield_smart_agriculture_font_sm synfield_smart_agriculture_table_row">
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border" title="' . __("High temperature", "synfield-smart-agriculture") .'">
                                <span class="synfield_smart_agriculture_high_color">
                                    <i class="fas fa-caret-up"></i>
                                </span>
                                <span class="synfield_text_black">
                                    ' . $this->serviceValue($air_temperature, 'high') . '<sup><sup>o</sup>' . $air_temperature["units"] . '</sup>
                                </span>
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border" title="' . __("High humidity", "synfield-smart-agriculture") .'">
                                <span class="synfield_smart_agriculture_high_color">
                                    <i class="fas fa-caret-up"></i>
                                </span>
                                <span class="synfield_text_black text-center text-middle">
                                    ' . $this->serviceValue($air_humidity, 'high') . '<sup>' . $air_humidity["units"] . '</sup>
                                </span>
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border" title="' . __("Monthly volume of rain", "synfield-smart-agriculture") .'">
                                <span class="synfield_text_black text-center text-middle">
                                    ' . $this->serviceValue($rain, 'month') . '<sup>' . $rain['units'] . '</sup><br>
                                    ' . __("monthly", "synfield-smart-agriculture") . '
                                </span>
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border" title="' . __("High wind speed", "synfield-smart-agriculture") .'">
                                <span class="synfield_smart_agriculture_high_color">
                                    <i class="fas fa-caret-up"></i>
                                </span>
                                <span class="synfield_text_black text-center text-middle">
                                    ' . $this->serviceValue($wind_speed, 'high') . '<sup>' . $wind_speed["units"] . '</sup>
                                </span>
                            </td>
                        </tr>                        
                        <tr class="synfield_smart_agriculture_font_sm synfield_smart_agriculture_body_tr_no_border synfield_smart_agriculture_table_row">
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border" title="' . __("Low temperature", "synfield-smart-agriculture") .'">
                                <span class="synfield_smart_agriculture_low_color"><i class="fas fa-caret-down"></i></span>
                                <span class="synfield_text_black">
                                    ' . $this->serviceValue($air_temperature, 'low') . '<sup><sup>o</sup>' . $air_temperature["units"] . '</sup>
                                </span>
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border" title="' . __("Low humidity", "synfield-smart-agriculture") .'">
                                <span class="synfield_smart_agriculture_low_color"><i class="fas fa-caret-down"></i></span>
                                <span class="synfield_text_black">
                                ' . $this->serviceValue($air_humidity, 'low') . '<sup>' . $air_humidity["units"] . '</sup>
                                </span>
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border" title="' . __("Yearly volume of rain", "synfield-smart-agriculture") .'">
                                <span class="synfield_text_black">
                                    ' . $this->serviceValue($rain, 'year') . '<sup>' . $rain['units'] . '</sup><br>
                                    ' . __("yearly", "synfield-smart-agriculture") . '
                                </span>
                            </td>
                            <td class="text-center text-middle synfield_smart_agriculture_body_tr_no_border" title="' . __("Low wind speed", "synfield-smart-agriculture") .'">
                                <span class="synfield_smart_agriculture_low_color"><i class="fas fa-caret-down"></i></span>
                                <span class="synfield_text_black">0 
                                    <sup>' . $wind_speed["units"] . '</sup>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="synfield_smart_agriculture_powered_by synfield_smart_agriculture_body_tr_no_border">
                                <span>
                                    ' . __("Smart agriculture solutions", "synfield-smart-agriculture") . '
                                    &bullet; <a href="' . $this->getLInk() . '" target="_blank" class="synfield_smart_agriculture_a_href">www.synfield.gr</a>
                                </span>
                            </td>
                        </tr>                        
                    </tbody>
                </table>
            </div>';
            echo $widget_content;
        }
        echo $args['after_widget'];
    }

    /**
     * This private method checks if the required label exists in the service array.
     *
     * @param array $data The service array, e.g. { ["current"]=> int(89) ["low"]=> float(12.9) ["high"]=> float(34.4) ["units"]=> string(1) "C" }
     * @param string $value The required key in the service array, e.g. 'current', 'low', 'high' etc
     * @return string       The value of the service. If it does not exist, return just a dash char.
     */
    private function serviceValue($data, $value)
    {
        $default_value = "-";
        if (array_key_exists($value, $data)) {
            if (is_null($data[$value])) {
                return $default_value;
            }
            if (is_numeric($data[$value])){
				return round($data[$value], 1);
            }
            return $data[$value];
        } else {
            return $default_value;
        }
    }

    /**
     * This private method returns the wind direction term.
     *
     * @param integer $index
     * @return string The wind direction as a literal
     */
    private function WindDirectionMapping($index)
    {
        if ($index == 1) {
            return __('South', 'synfield-smart-agriculture');
        } else if ($index == 2 || $index == 3 || $index == 4) {
            return __('Southwest', 'synfield-smart-agriculture');
        } else if ($index == 5) {
            return __('West', 'synfield-smart-agriculture');
        } else if ($index == 6 || $index == 7 || $index == 8) {
            return __('Northwest', 'synfield-smart-agriculture');
        } else if ($index == 9) {
            return __('North', 'synfield-smart-agriculture');
        } else if ($index == 10 || $index == 11 || $index == 12) {
            return __('Northeast', 'synfield-smart-agriculture');
        } else if ($index == 13) {
            return __('East', 'synfield-smart-agriculture');
        } else if ($index == 14 || $index == 15 || $index == 16) {
            return __('Southeast', 'synfield-smart-agriculture');
        } else {
            return "-";
        }
    }

    /**
     * Get the url of the Synfield
     * @return string The Synfield url
     */
    private function getLInk()
    {
        $base_url = "https://www.synfield.gr";
        try {
            $host_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $domain = str_ireplace('www.', '', parse_url($host_url, PHP_URL_HOST));
            return "$base_url/?utm_source=widget&utm_medium=$domain&utm_campaign=partnership";
        } catch (Exception $ex) {
            return $base_url;
        }
    }

    /**
     * Outputs the Settings update form.
     * @param array $instance
     * @return string|void
     */
    function form($instance)
    {
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('api_key'); ?>">
                <?php _e('Type the API key:', 'synfield-smart-agriculture'); ?><br/>
            </label>
            <input style="margin-top: 4px;" id="<?php echo $this->get_field_id('api_key'); ?>"
                   name="<?php echo $this->get_field_name('api_key'); ?>" type="text"
                   value="<?php echo $instance['api_key']; ?>"/>
            <br>
            <br>
            <label for="<?php echo $this->get_field_id('serial_number'); ?>">
                <?php _e('Type your Serial Number:', 'synfield-smart-agriculture'); ?><br/>
                <small><?php _e('(e.g.: 9342424294823942343)', 'synfield-smart-agriculture'); ?></small>
            </label>
            <br>
            <input style="margin-top: 4px;" id="<?php echo $this->get_field_id('serial_number'); ?>"
                   name="<?php echo $this->get_field_name('serial_number'); ?>" type="text"
                   value="<?php echo $instance['serial_number']; ?>"/>
        </p>
        <?php
    }

    /**
     * Updates a particular instance of a widget.
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['api_key'] = strip_tags($new_instance['api_key']);
        $instance['serial_number'] = strip_tags($new_instance['serial_number']);
        return $instance;
    }
}
