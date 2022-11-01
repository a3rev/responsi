<?php
/**
 * Default header block pattern
 */

function responsi_header_patterns(){
	ob_start();
	?>
	<!-- wp:group {"align":"full","className":"responsi-header"} -->
	<div class="wp-block-group alignfull responsi-header" id="responsi-header">

		<!-- wp:group {"className":"header-ctn site-width"} -->
		<div class="wp-block-group header-ctn site-width" id="header-ctn">
			
			<!-- wp:group {"className":"header-in"} -->
			<div class="wp-block-group header-in" id="header-in">
				
				<!-- wp:group {"tagName":"header","className":"header clearfix col-full col-1"} -->
				<header id="header" class="wp-block-group header clearfix col-full col-1">

					<!-- wp:group {"className":"box box-last col-item  header-widget-1"} -->
					<div class="wp-block-group box box-last col-item  header-widget-1">

						<!-- wp:group {"className":"clearfix"} -->
						<div id="header-animation-1" class="wp-block-group clearfix">

							<!-- wp:group {"className":"widget widget_text"} -->
							<div class="wp-block-group widget widget_text">

								<!-- wp:group {"className":"logo-ctn"} -->
								<div class="wp-block-group logo-ctn">

									<!-- wp:site-title {"className":"logo site-title"} /-->

								</div>
								<!-- /wp:group -->

								<!-- wp:group {"className":"desc-ctn"} -->
								<div class="wp-block-group desc-ctn">

									<?php
									global $responsi_options;
								    $site_description = get_bloginfo('description');
								    if ( 'true' === $responsi_options['responsi_enable_site_description'] && '' !== $site_description) {
								        echo '<!-- wp:paragraph --><span class="site-description">' . $site_description . '</span><!-- /wp:paragraph -->';
								    }
									?>

								</div>
								<!-- /wp:group -->

							</div>
							<!-- /wp:group -->

						</div>
						<!-- /wp:group -->

					</div>
					<!-- /wp:group -->

				</header>
				<!-- /wp:group -->
				
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->
		
	</div>
	<!-- /wp:group -->

	<?php
	$header = ob_get_clean();
	return $header;
}

return array(
	'title'      => __( 'Responsi Default header', 'responsi' ),
	'categories' => array( 'header' ),
	'blockTypes' => array( 'core/template-part/header' ),
	'content'    => responsi_header_patterns(),
);
