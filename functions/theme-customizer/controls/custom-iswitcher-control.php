<?php
/**
 * Class to create a custom iSwitcher control
 */
if ( ! class_exists( 'Customize_iSwitcher_Control' ) && class_exists('Customize_iCheckbox_Control')) {
	class Customize_iSwitcher_Control extends Customize_iCheckbox_Control {

		public $type = 'iswitcher';

		public $ui_class = 'responsi-ui-iswitcher';

	}
}
?>
