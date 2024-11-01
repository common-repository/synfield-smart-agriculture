<?php

/**
 * @package SynFieldSmartAgriculture
 */

namespace SynField\Base;

use SynField\Base\BaseController;
use SynField\Api\Widgets\SmartAgricultureWidget;

/**
 * Class WidgetController
 * @package SynField\Base
*/
class WidgetController extends BaseController
{
    public function register()
    {
         if (!$this->activated('synfield_app_key')) {
              return;
         }
        $_widget = new SmartAgricultureWidget();
        $_widget->register();
    }
}