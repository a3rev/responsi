<?php
/**
 * Default navigation block pattern
 */

function responsi_navigation_patterns(){
	ob_start();
	?>
	<!-- wp:group {"align":"full","className":"responsi-navigation"} -->
	<div class="wp-block-group alignfull responsi-navigation" id="responsi-navigation">

		<!-- wp:group {"className":"navigation-ctn site-width"} -->
		<div class="wp-block-group navigation-ctn site-width" id="navigation-ctn">
			
			<!-- wp:group {"className":"navigation-in"} -->
			<div class="wp-block-group navigation-in" id="navigation-in">
				
				<!-- wp:group {"tagName":"nav","className":"navigation clearfix"} -->
				<nav id="navigation" class="wp-block-group navigation clearfix">
					<!-- wp:html -->
						<?php do_action( 'responsi_navigation' ); ?>
			            <?php
			            global $responsi_options;
			            $nav_ctr = '';
			            $text_navigation = '';
			            $nav_ctr_before = apply_filters( 'responsi_mobile_navigation_before', '' );
			            $nav_ctr_after = apply_filters( 'responsi_mobile_navigation_after', '' );
			            
			            if( isset($responsi_options['responsi_nav_container_mobile_text_on']) && $responsi_options['responsi_nav_container_mobile_text_on'] == 'true' ){
			                $text_navigation = $responsi_options['responsi_nav_container_mobile_text'];
			            }
			            $nav_ctr = '<div class="navigation-mobile open alignment-'.$responsi_options['responsi_nav_icon_mobile_alignment'].'">'.$nav_ctr_before.'<span class="menu-text before">'. esc_html( $text_navigation ) .'</span><span class="separator nav-separator"><i class="menu-icon hamburger-icon hext-icon"></i></span><span class="menu-text after">'. esc_html( $text_navigation ) .'</span>'.$nav_ctr_after.'</div>';
			                
			            $nav_ctr = apply_filters( 'responsi_mobile_navigation', $nav_ctr );
			            
			            if ( function_exists('has_nav_menu' ) && has_nav_menu( 'primary-menu' ) ) {
			                $nav = @wp_nav_menu(array(
			                    'sort_column'       => 'menu_order',
			                    'menu_id'           => 'main-nav',
			                    'menu_class'        => 'responsi-menu menu nav',
			                    'theme_location'    => 'primary-menu',
			                    'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			                    'container'         => 'ul',
			                    'echo'              => false
			                ));
			                if( $nav != '' ){
			                    echo $nav_ctr.$nav;
			                }
			            } else {
			                echo $nav_ctr
			                ?>
			            <ul id="main-nav" class="responsi-menu menu nav">
			                <?php
			                if ( is_page() ){
			                    $highlight = "page_item";
			                }
			                else{
			                    $highlight = "page_item current_page_item";
			                }
			                ?>
			              <li class="<?php echo esc_attr( $highlight ); ?>"><a href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_attr_e('Home', 'responsi'); ?></a></li>
			              <?php wp_list_pages( 'sort_column=menu_order&depth=6&title_li=&exclude=' ); ?>
			            </ul>
			            <?php
			            }
			            ?>
			        <!-- /wp:html -->
				</nav>
				<!-- /wp:group -->
				
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->
		
	</div>
	<!-- /wp:group -->

	<?php
	$navigation = ob_get_clean();
	return $navigation;
}

return array(
	'title'      => __( 'Responsi Default navigation', 'responsi' ),
	'categories' => array( 'navigation' ),
	'blockTypes' => array( 'core/template-part/navigation' ),
	'content'    => responsi_navigation_patterns(),
);
