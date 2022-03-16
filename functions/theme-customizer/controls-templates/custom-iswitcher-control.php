<?php

namespace A3Rev\Responsi;

/**
 * Class to create a custom iSwitcher control
 */
if (! class_exists('\A3Rev\Responsi\Customize_iSwitcher_Control') && class_exists('\A3Rev\Responsi\Customize_iCheckbox_Control')) {
    class Customize_iSwitcher_Control extends \A3Rev\Responsi\Customize_iCheckbox_Control
    {

        public $type = 'iswitcher';

        public $ui_class = 'responsi-ui-iswitcher';

        public $notifications = array();
    }
}
