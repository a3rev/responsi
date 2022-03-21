<?php

namespace A3Rev\Responsi;

/**
 * Class to create a custom Animation control
 */
if (! class_exists('\A3Rev\Responsi\Customize_Animation_Control') && class_exists('\WP_Customize_Control')) {
    class Customize_Animation_Control extends \WP_Customize_Control
    {

        public $type = 'animation';

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
            <# if( 'undefined' === typeof data.values ){ data.values = {'type':'none' ,'direction':'center', 'duration':'1' , 'delay':'1'}; }
            var setting_id = data.setting_id;
            #>
            <div class="customize-ctrl {{ data.custom_class }}">
                <# if(data.label){ #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
                <div class="animation-container">
                    <select name="{{ setting_id }}[type]" class="responsi-animation responsi-iselect responsi-animation-type"></select>
                    <div class="animation-inner-container">
                        
                        <div class="responsi-range-slider">
                            <label><?php echo esc_attr__('Duration', 'responsi'); ?> (s)</label>
                            <div class="ui-slide ui-slide-duration" id="{{ setting_id }}_duration_div"></div>
                            <input type="text" readonly="readonly" id="{{ setting_id }}_duration" name="{{ setting_id }}_duration" value="{{ data.values.duration }}" class="responsi-input regular-text islide-value islide-value-duration" />
                        </div>
                        
                        <div class="responsi-range-slider">
                            <label><?php echo esc_attr__('Delay', 'responsi'); ?> (s)</label>
                            <div class="ui-slide ui-slide-delay" id="{{ setting_id }}_delay_div"></div>
                            <input type="text" readonly="readonly" id="{{ setting_id }}_delay" name="{{ setting_id }}_delay" value="{{ data.values.delay }}" class="responsi-input regular-text islide-value islide-value-delay" />
                        </div>

                        <div class="responsi-direction-container">
                            <label><?php echo esc_attr__('Direction', 'responsi'); ?></label>
                            <select name="{{ setting_id }}[direction]" class="responsi-animation responsi-iselect responsi-animation-direction"></select>
                        </div>
                        
                    </div>
                </div>
                <# if( data.description ){ #><span class="customize-control-description">{{{ data.description }}}</span><# } #>
            </div>
            <?php
        }
    }
}
?>
