<?php

namespace A3Rev\Responsi;

/**
 * Class to create a custom Border Radius control
 */
if (! class_exists('\A3Rev\Responsi\Customize_iBackground_Control') && class_exists('\WP_Customize_Control')) {
    class Customize_iBackground_Control extends \WP_Customize_Control
    {

        public $type = 'ibackground';

        public $notifications = array();

        /**
         * Constructor.
         *
         * @since 3.4.0
         * @uses WP_Customize_Control::__construct()
         *
         * @param WP_Customize_Manager $manager Customizer bootstrap instance.
         * @param string               $id      Control ID.
         * @param array                $args    Optional. Arguments to override class property defaults.
         */
        public function __construct($manager, $id, $args = array())
        {
            parent::__construct($manager, $id, $args);
        }

        /**
         * Enqueue scripts/styles for the switcher.
         *
         * @since 3.4.0
         */
        public function enqueue()
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('responsi-customize-controls');
        }

        /**
         * Refresh the parameters passed to the JavaScript via JSON.
         *
         * @since 3.4.0
         * @uses WP_Customize_Control::to_json()
         */
        public function to_json()
        {
            parent::to_json();

            $custom_class = '';
            if (isset($this->input_attrs['class']) && $this->input_attrs['class']) {
                $custom_class = $this->input_attrs['class'];
            }

            $values = array();
            foreach ($this->settings as $key => $setting) {
                $key = str_replace(array( $this->id, '[', ']' ), '', $key);
                if (isset($setting->default) && is_array($setting->default) && isset($setting->default[$key])) {
                    $values[$key] = $setting->default[$key];
                } else {
                    $values[$key] = $setting->value();
                }
            }

            $this->json['setting_id']   = $this->id;
            $this->json['values']       = $values;
            $this->json['custom_class'] = $custom_class;
            $this->json['notifications'] = $this->notifications;
        }

        protected function render()
        {
            
            $custom_class = '';
            if (isset($this->input_attrs['class']) && $this->input_attrs['class']) {
                $custom_class = ' '.$this->input_attrs['class'];
            }

            $id    = 'customize-control-' . str_replace('[', '-', str_replace(']', '', $this->id));
            $class = 'customize-control customize-control-' . $this->type;

            $class .= $custom_class;

            printf('<li id="%s" class="%s">', esc_attr($id), esc_attr($class));
            $this->render_content();
            echo '</li>';
        }

        /**
         * Don't render the control content from PHP, as it's rendered via JS on load.
         *
         * @since 3.4.0
         */
        public function render_content()
        {
        }

        /**
         * Render a JS template for the content of the color picker control.
         *
         * @since 4.1.0
         */
        public function content_template()
        {
            ?><# 
            if( 'undefined' === typeof data.values ){
                data.values = { 'onoff' : 'false', 'color' : '#dbdbdb' };
            }
            var setting_id = data.setting_id ? data.setting_id : 'ibackground',onoff_value = data.values.onoff,defaultValue = '#RRGGBB',defaultValueAttr = '',isHueSlider = data.mode === 'hue',onoff_checked = '';
            if('true' == onoff_value){onoff_checked = 'checked="checked"';}else{onoff_value = 'false';}
            if( data.values.color && _.isString( data.values.color ) && ! isHueSlider ){
                if ( '#' !== data.values.color.substring( 0, 1 ) ) {defaultValue = '#' + data.values.color;}else{defaultValue = data.values.color;}
                defaultValueAttr = ' data-default-color=' + defaultValue;
            } #>
            <div class="customize-ctrl {{ data.custom_class }}">
                <# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
                <div class="ibackground-container">
                    <div class="responsi-iphone-checkbox"><input type="checkbox" {{{ onoff_checked }}} id="{{ setting_id }}_onoff" class="checkbox responsi-input responsi-ibackground-onoff responsi-ui-icheckbox" /></div>
                    <div class="responsi-ibackground-container"><input class="color-picker-hex icolor-picker" type="text" maxlength="7" placeholder="{{ defaultValue }}" {{ defaultValueAttr }} /></div>
                </div>
                <# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
            </div>
            <?php
        }
    }
}
?>
