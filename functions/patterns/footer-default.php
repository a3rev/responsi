<?php
/**
 * Default footer
 */

function responsi_footer_patterns(){
	ob_start();
	?>
	<!-- wp:group {"align":"full","className":"responsi-footer"} -->
	<div class="wp-block-group alignfull responsi-footer" id="responsi-footer">

		<!-- wp:group {"className":"footer-ctn site-width"} -->
		<div class="wp-block-group footer-ctn site-width" id="footer-ctn">
			
			<!-- wp:group {"className":"footer-in"} -->
			<div class="wp-block-group footer-in" id="footer-in">
				
				<!-- wp:group {"className":"footer"} -->
				<div class="wp-block-group footer" id="footer">

					<!-- wp:group {"className":"footer-copyright-credit"} -->
					<div class="wp-block-group footer-copyright-credit">
						
						<?php 

						global $responsi_options;
				        if( !is_array( $responsi_options ) ) return;

				        $defaults = array(
				            'before'    => '',
				            'after'     => ''
				        );

				        $atts     = $defaults;
				        $output   = '';

				        if ( 'true' === $responsi_options['responsi_footer_left'] && '' !== trim( $responsi_options['responsi_footer_left_text'] ) ) {
				            
				            $footer_copyright_animation = responsi_generate_animation($responsi_options['responsi_footer_left_animation']);

				            $footer_copyright_class = '';
				            $footer_copyright_data = '';
				            $footer_copyright_style = '';

				            if( false !== $footer_copyright_animation ){
				                $footer_copyright_class = ' '.$footer_copyright_animation['class'];
				                $footer_copyright_data = ' data-animation="'.$footer_copyright_animation['data'].'"';
				                $footer_copyright_style = ' style="'.$footer_copyright_animation['style'].'"';
				            }

				            $output = '<!-- wp:group {"className":"copyright-animation clearfix'.$footer_copyright_class.'"} --><div id="copyright-animation" class="wp-block-group copyright-animation clearfix'.$footer_copyright_class.'"'.$footer_copyright_data . $footer_copyright_style.'><!-- wp:paragraph -->'.sprintf('%1$s%3$s%2$s', $atts['before'], $atts['after'], wpautop( strip_tags($responsi_options['responsi_footer_left_text']) ) ).'<!-- /wp:paragraph --></div><!-- /wp:group -->';
				        }

				        echo '<!-- wp:group {"className":"copyright col-left"} --><div class="wp-block-group copyright col-left" id="copyright">'.$output.'</div><!-- /wp:group -->';

				        $output   = '';
				        $html     = '';

				      
				        if ( isset($responsi_options['responsi_enable_footer_right']) && 'true' === $responsi_options['responsi_enable_footer_right'] ) {
				            $footer_right_text_before     = $responsi_options['responsi_footer_right_text_before'];
				            $footer_right_text_before_url = $responsi_options['responsi_footer_right_text_before_url'];

				            if ( '' !== trim($footer_right_text_before_url) ) {
				                $text_before = '<a href="' . esc_url( $footer_right_text_before_url ) . '" target="_blank" rel="noopener">' . $footer_right_text_before . '</a>';
				            } else {
				                $text_before = $footer_right_text_before;
				            }

				            $footer_right_logo     = esc_url( $responsi_options['responsi_footer_right_logo'] );
				            $footer_right_logo_url = $responsi_options['responsi_footer_right_logo_url'];
				            $right_logo = '';
				            if ( '' !== trim($footer_right_logo_url) && '' !== trim($footer_right_logo) ) {
				                $width_height_attr = responsi_get_image_attribute( $footer_right_logo );
				                $right_logo = '<a href="' . esc_url( $footer_right_logo_url ) . '" target="_blank" rel="noopener"><img src="' .  esc_url( $footer_right_logo ) . '" alt="'.__( 'Logo', 'responsi' ).'"'.$width_height_attr.'></a>';
				            } elseif( '' !== trim( $footer_right_logo ) ) {
				                $width_height_attr = responsi_get_image_attribute( $footer_right_logo );
				                $right_logo = '<img src="' . esc_url( $footer_right_logo ) . '" alt="'.__( 'Logo', 'responsi' ).'"'.$width_height_attr.'>';
				            }

				            $footer_right_text_after     = $responsi_options['responsi_footer_right_text_after'];
				            $footer_right_text_after_url = $responsi_options['responsi_footer_right_text_after_url'];

				            if ( '' !== trim($footer_right_text_after_url) ) {
				                $text_after = '<a href="' . esc_url( $footer_right_text_after_url ) . '" target="_blank" rel="noopener">' . $footer_right_text_after . '</a>';
				            } else {
				                $text_after = $footer_right_text_after;
				            }

				            $html = $text_before . $right_logo . $text_after;
				        }

				     
				        $output = sprintf( '%1$s%3$s%2$s', $atts['before'], $atts['after'], $html );

				        if( '' !== $output && isset($responsi_options['responsi_footer_link_animation']) ){
				        
				            $footer_credit_animation = responsi_generate_animation($responsi_options['responsi_footer_link_animation']);

				            $footer_credit_class = '';
				            $footer_credit_data = '';
				            $footer_credit_style = '';

				            if( false !== $footer_credit_animation ){
				                $footer_credit_class = ' '.$footer_credit_animation['class'];
				                $footer_credit_data = ' data-animation="'.$footer_credit_animation['data'].'"';
				                $footer_credit_style = ' style="'.$footer_credit_animation['style'].'"';
				            }

				            $output_footer_credit = '<!-- wp:group {"className":"credit-animation clearfix'.$footer_credit_class.'"} --><div id="credit-animation" class="wp-block-group credit-animation clearfix'.$footer_credit_class.'"'.$footer_credit_data . $footer_credit_style.'><!-- wp:paragraph -->'.$output.'<!-- /wp:paragraph --><!-- wp:loginout /--></div><!-- /wp:group -->';
				            $output = $output_footer_credit;

				        }

				        echo '<!-- wp:group {"className":"credit col-right"} --><div class="wp-block-group credit col-right" id="credit">'.$output.'</div><!-- /wp:group -->';

				        ?>

			        </div>
					<!-- /wp:group -->
					
				</div>
				<!-- /wp:group -->
				
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->
		
	</div>
	<!-- /wp:group -->

	<?php
	$footer = ob_get_clean();
	return $footer;
}

return array(
	'title'      => __( 'Responsi Default footer', 'responsi' ),
	'categories' => array( 'footer' ),
	'blockTypes' => array( 'core/template-part/footer' ),
	'content'    => responsi_footer_patterns(),
);
