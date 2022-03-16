<?php

namespace A3Rev\Responsi;

/**
 * Class to create a custom Border Boxes control
 */
if (! class_exists('\A3Rev\Responsi\Customize_Border_Boxes_Control') && class_exists('\WP_Customize_Control')) {
    class Customize_Border_Boxes_Control extends \WP_Customize_Control
    {

        public $type = 'border_boxes';

        public $notifications = array();

        /**
         * Constructor.
         *
         * @since 1.0.0
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
         * Enqueue scripts/styles.
         *
         * @since 1.0.0
         */
        public function enqueue()
        {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('responsi-customize-controls');
        }

        /**
         * Refresh the parameters passed to the JavaScript via JSON.
         *
         * @since 1.0.0
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
            ?>
            <# 
            if( 'undefined' === typeof data.values ){
                data.values = { 'width' : '0', 'style' : 'solid', 'color' : '#dbdbdb','corner': 'square', 'topleft': '0', 'topright': '0', 'bottomright': '0', 'bottomleft': '0' };
            }
            var setting_id = data.setting_id ? data.setting_id : 'border_boxes', defaultValue = '#RRGGBB',defaultValueAttr = '',isHueSlider = data.mode === 'hue';
            var checked = '';
            if('rounded' == data.values.corner ){checked = 'checked="checked"';}

            if( data.values.color && _.isString( data.values.color ) && ! isHueSlider ){
                if ( '#' !== data.values.color.substring( 0, 1 ) ) {defaultValue = '#' + data.values.color;}else{defaultValue = data.values.color;}
                defaultValueAttr = ' data-default-color=' + defaultValue;
            } #>
            <div class="customize-ctrl {{ data.custom_class }}">
                <# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
                <div class="border-container border-boxes-container">
                    <select class="responsi-border responsi-border-width" name="{{ setting_id }}[width]"></select>
                    <select class="responsi-border responsi-border-style" name="{{ setting_id }}[style]"></select>
                    <input class="color-picker-hex icolor-picker responsi-border" type="text" maxlength="7" placeholder="{{ defaultValue }}" {{ defaultValueAttr }} />
                    <div class="responsi-iphone-checkbox responsi-iswitcher-checkbox">
                        <input type="checkbox" {{{ checked }}} id="{{ setting_id }}_corner" class="checkbox responsi-input responsi-ui-icheckbox responsi-ui-iswitcher" />
                    </div>
                    <div class="responsi-range-slider">
                        <div class="ui-slide ui-slide-topleft" id="{{ setting_id }}_topleft_div"></div>
                        <input type="text" readonly="readonly" id="{{ setting_id }}_topleft" name="{{ setting_id }}_topleft" value="{{ data.values.topleft }}" class="responsi-input regular-text islide-value islide-value-topleft" />
                    </div>
                    <div class="responsi-range-slider">
                        <div class="ui-slide ui-slide-topright" id="{{ setting_id }}_topright_div"></div>
                        <input type="text" readonly="readonly" id="{{ setting_id }}_topright" name="{{ setting_id }}_topright" value="{{ data.values.topright }}" class="responsi-input regular-text islide-value islide-value-topright" />
                    </div>
                    <div class="responsi-range-slider">
                        <div class="ui-slide ui-slide-bottomright" id="{{ setting_id }}_bottomright_div"></div>
                        <input type="text" readonly="readonly" id="{{ setting_id }}_bottomright" name="{{ setting_id }}_bottomright" value="{{ data.values.bottomright }}" class="responsi-input regular-text islide-value islide-value-bottomright" />
                    </div>
                    <div class="responsi-range-slider">
                        <div class="ui-slide ui-slide-bottomleft" id="{{ setting_id }}_bottomleft_div"></div>
                        <input type="text" readonly="readonly" id="{{ setting_id }}_bottomleft" name="{{ setting_id }}_bottomleft" value="{{ data.values.bottomleft }}" class="responsi-input regular-text islide-value islide-value-bottomleft" />
                    </div>
                </div>
                <# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
            </div>
            <?php
        }
    }
}
?>
