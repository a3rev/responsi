<?php
/**
 * Default header block pattern
 */

function responsi_main_patterns(){
	ob_start();
	?>
	<!-- wp:group {"align":"full","className":"responsi-content"} -->
	<div class="wp-block-group alignfull responsi-content" id="responsi-content">

		<!-- wp:group {"className":"content-ctn site-width clearfix"} -->
		<div class="wp-block-group content-ctn site-width clearfix" id="content-ctn">
			
			<!-- wp:group {"tagName":"article","className":"content-in"} -->
				<article id="content-in" class="wp-block-group content-in">
				
				<!-- wp:group {"className":"content col-full clearfix"} -->
				<div id="content" class="wp-block-group content col-full clearfix">

					<!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true},"tagName":"main","displayLayout":{"type":"flex","columns":4},"layout":{"inherit":true}} -->
					<main class="wp-block-query"><!-- wp:post-template {"align":"wide"} -->
					<!-- wp:group {"layout":{"inherit":true,"type":"constrained"}} -->
					<div class="wp-block-group"><!-- wp:post-featured-image {"isLink":true,"align":"wide","style":{"spacing":{"margin":{"top":"calc(1.75 * var(\u002d\u002dwp\u002d\u002dstyle\u002d\u002dblock-gap))"}}}} /-->

					<!-- wp:post-title {"isLink":true,"align":"wide","fontSize":"var(\u002d\u002dwp\u002d\u002dcustom\u002d\u002dtypography\u002d\u002dfont-size\u002d\u002dhuge, clamp(2.25rem, 4vw, 2.75rem))"} /-->

					<!-- wp:post-excerpt /--></div>
					<!-- /wp:group -->
					<!-- /wp:post-template -->

					<!-- wp:query-pagination {"paginationArrow":"arrow","align":"center","layout":{"type":"flex","justifyContent":"center"}} -->
					<!-- wp:query-pagination-numbers /-->
					<!-- /wp:query-pagination --></main>
					<!-- /wp:query -->

					<!-- wp:spacer {"height":40} -->
					<div style="height:40px" aria-hidden="true" class="wp-block-spacer"></div>
					<!-- /wp:spacer -->

				</div>
				<!-- /wp:group -->
				
			</article>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->
		
	</div>
	<!-- /wp:group -->

	<?php
	$main = ob_get_clean();
	return $main;
}

return array(
	'title'      => __( 'Responsi Default Main', 'responsi' ),
	'categories' => array( 'main' ),
	'blockTypes' => array( 'core/template-part/main' ),
	'content'    => responsi_main_patterns(),
);
