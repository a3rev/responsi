/**
 * Custom Fields JavaScript
 *
 * All JavaScript logic for fields in the post meta box.
 * @since 4.8.0
 *
 */

(function ($) {

  responsiCustomFields = {

/**
 * adjust_form_encoding()
 *
 * @since 4.8.0
 */

 	adjust_form_encoding: function () {
 		$( 'form#post' ).attr( 'enctype','multipart/form-data' ).attr( 'encoding','multipart/form-data' );
 	}, // End adjust_form_encoding()

/**
 * setup_wordcounters()
 *
 * @since 4.8.0
 */

 	setup_wordcounters: function () {
 		if ( $( '.words-count' ).length ) {
	 		$( '.words-count' ).each( function() {
				var s = ''; var s2 = '';
			    var length = $( this ).val().length;
			    var w_length = $( this ).val().split(/\b[\s,\.-:;]*/).length;

			    if( length != 1 ) { s = 's'; }
			    if( w_length != 1 ) { s2 = 's'; }
			    if( $( this ).val() == '' ) { s2 = 's'; w_length = '0'; }

			    $( this ).parent().find( '.counter' ).html( length + ' character'+ s + ', ' + w_length + ' word' + s2 );

			    $( this ).keyup( function() {
			    var s = ''; var s2 = '';
			        var new_length = $( this ).val().length;
			        var word_length = $( this ).val().split(/\b[\s,\.-:;]*/).length;

			        if( new_length != 1 ) { s = 's'; }
			        if( word_length != 1 ){ s2 = 's'; }
			        if( $( this ).val() == '' ) { s2 == 's'; word_length = '0';}

			        $( this ).parent().find( '.counter' ).html( new_length + ' character' + s + ', ' + word_length + ' word' + s2 );
			    });
			});
		}
 	}, // End setup_wordcounters()

/**
 * setup_image_selectors()
 *
 * @since 4.8.0
 */

 	setup_image_selectors: function () {
 		if ( $( '.responsi-metabox-radio-img-img, .responsi-radio-img-img' ).length ) {


	 		$( '.responsi-metabox-radio-img-img, .responsi-radio-img-img' ).click( function() {

				$( this ).parent().parent().find( '.responsi-metabox-radio-img-img' ).removeClass( 'responsi-metabox-radio-img-selected' );
				$( this ).parent().parent().find( '.responsi-radio-img-img' ).removeClass( 'responsi-radio-img-selected' );
				$( this ).addClass( 'responsi-metabox-radio-img-selected' ).addClass( 'responsi-radio-img-selected' );
				var objID = $(this).siblings('input').attr('id');
				responsiCustomFields.setup_image_selectors_click(objID);
				if( $( this ).siblings('input').length > 0 ){
					var status = $( this ).siblings('input').val().toString();
					$( this ).siblings('input').trigger("responsi-metabox-radio-img-switch", [ $( this ).siblings('input'), status]);
				}

			});
			$( '.responsi-metabox-radio-img-label, .responsi-metabox-radio-img-radio, .responsi-radio-img-label, .responsi-radio-img-radio' ).hide();
			$( '.responsi-metabox-radio-img-img, .responsi-radio-img-img' ).show();


			$( '.group .page-layout' ).each(function(){
				var page_layout = $( this ).find( 'input.responsi-radio-img-radio:checked' ).val();
				$( this ).find( 'input.responsi-radio-img-radio:checked' ).parent().parent().parent().parent('.page-layout').nextAll().each( function(){
					if ($( this ).hasClass( 'pagelast' ) ) {
						if( page_layout == 'one-col'){
							$( this ).find('input.responsi-radio-img-radio').each( function(){
								$( this ).siblings('img').show();
							});
						}
						if( page_layout == 'two-col-left' || page_layout == 'two-col-right'){
							$( this ).find('input.responsi-radio-img-radio').each( function(){
								if($( this ).val() == 6){
									$( this ).siblings('img').hide();
								}else{
									$( this ).siblings('img').show();
								}
							});
							if( $( this ).is(':checked') && $( this ).val() >= 5){
								$( this ).parent().parent().find( '.responsi-radio-img-selected' ).removeClass( 'responsi-radio-img-selected' );
								$( this ).parent().parent().find( 'input.responsi-radio-img-radio' ).each( function(){
									if( $( this ).val() == 5){
										$( this ).prop('checked',true);
										$( this ).siblings('img').addClass("responsi-radio-img-selected");
									}
								});
							}
						}
						if( page_layout == 'three-col-left' || page_layout == 'three-col-middle' || page_layout == 'three-col-right'){
							$( this ).find('input.responsi-radio-img-radio').each( function(){
								if($( this ).val() == 5 || $( this ).val() == 6){
									$( this ).siblings('img').hide();
								}else{
									$( this ).siblings('img').show();
								}
							});
							if( $( this ).is(':checked') && $( this ).val() >= 5){
								$( this ).parent().parent().find( '.responsi-radio-img-selected' ).removeClass( 'responsi-radio-img-selected' );
								$( this ).parent().parent().find( 'input.responsi-radio-img-radio' ).each( function(){
									if( $( this ).val() == 4){
										$( this ).prop('checked',true);
										$( this ).siblings('img').addClass("responsi-radio-img-selected");
									}
								});
							}
						}
						return false;
					}
					if( page_layout == 'one-col'){
						$( this ).find('input.responsi-radio-img-radio').each( function(){
							$( this ).siblings('img').show();
						});
					}
					if( page_layout == 'two-col-left' || page_layout == 'two-col-right'){

						$( this ).find('input.responsi-radio-img-radio').each( function(){
							if($( this ).val() == 6){
								$( this ).siblings('img').hide();
							}else{
								$( this ).siblings('img').show();
							}
							if( $( this ).is(':checked') && $( this ).val() >= 5){
								$( this ).parent().parent().find( '.responsi-radio-img-selected' ).removeClass( 'responsi-radio-img-selected' );
								$( this ).parent().parent().find( 'input.responsi-radio-img-radio' ).each( function(){
									if( $( this ).val() == 5){
										$( this ).prop('checked',true);
										$( this ).siblings('img').addClass("responsi-radio-img-selected");
									}
								});
							}
						});
					}
					if( page_layout == 'three-col-left' || page_layout == 'three-col-middle' || page_layout == 'three-col-right'){
						$( this ).find('input.responsi-radio-img-radio').each( function(){
							if($( this ).val() == 5 || $( this ).val() == 6){
								$( this ).siblings('img').hide();
							}else{
								$( this ).siblings('img').show();
							}
							if( $( this ).is(':checked') && $( this ).val() >= 5){
								$( this ).parent().parent().find( '.responsi-radio-img-selected' ).removeClass( 'responsi-radio-img-selected' );
								$( this ).parent().parent().find( 'input.responsi-radio-img-radio' ).each( function(){
									if( $( this ).val() == 4){
										$( this ).prop('checked',true);
										$( this ).siblings('img').addClass("responsi-radio-img-selected");
									}
								});
							}
						});
					}
				});
			});
		}
 	}, // End setup_image_selectors()
	setup_image_selectors_click: function (obj) {

		objID = $( '#' + obj ); // Get the jQuery object.
		objID.parent().parent().parent().parent('.page-layout').nextAll().each( function(){
			if ( $( this ).filter( '.pagelast' ).length ) {
				if(objID.val() == 'one-col'){
					$( this ).find('input.responsi-radio-img-radio').each( function(){
						$( this ).siblings('img').show();
					});
				}
				if( objID.val() == 'two-col-left' || objID.val() == 'two-col-right'){
					$( this ).find('input.responsi-radio-img-radio').each( function(){
						if($( this ).val() == 6){
							$( this ).siblings('img').hide();
						}else{
							$( this ).siblings('img').show();
						}
						if( $( this ).is(':checked') && $( this ).val() >= 6){
							$( this ).parent().parent().find( '.responsi-radio-img-selected' ).removeClass( 'responsi-radio-img-selected' );
							$( this ).parent().parent().find( 'input.responsi-radio-img-radio' ).each( function(){
								if( $( this ).val() == 5){
									$( this ).prop('checked',true);
									$( this ).siblings('img').addClass("responsi-radio-img-selected");
								}
							});
						}
					});
				}
				if( objID.val() == 'three-col-left' || objID.val() == 'three-col-middle' || objID.val() == 'three-col-right'){
					$( this ).find('input.responsi-radio-img-radio').each( function(){
						if($( this ).val() == 5|| $( this ).val() == 6){
							$( this ).siblings('img').hide();
						}else{
							$( this ).siblings('img').show();

						}
						if( $( this ).is(':checked') && $( this ).val() >= 5){
							$( this ).parent().parent().find( '.responsi-radio-img-selected' ).removeClass( 'responsi-radio-img-selected' );
							$( this ).parent().parent().find( 'input.responsi-radio-img-radio' ).each( function(){
								if( $( this ).val() == 4){
									$( this ).prop('checked',true);
									$( this ).siblings('img').addClass("responsi-radio-img-selected");
								}
							});
						}

					});
				}
				return false;
			}
			if(objID.val() == 'one-col'){
				$( this ).find('input.responsi-radio-img-radio').each( function(){
					$( this ).siblings('img').show();
				});
			}
			if( objID.val() == 'two-col-left' || objID.val() == 'two-col-right'){
				$( this ).find('input.responsi-radio-img-radio').each( function(){
					if($( this ).val() == 6){
						$( this ).siblings('img').hide();
					}else{
						$( this ).siblings('img').show();
					}
					$( this ).parent().parent().find( '.responsi-radio-img-selected' ).removeClass( 'responsi-radio-img-selected' );
					$( this ).parent().parent().find( 'input.responsi-radio-img-radio' ).each( function(){
						if( $( this ).val() == 5){
							$( this ).prop('checked',true);
							$( this ).siblings('img').addClass("responsi-radio-img-selected");
						}
					});
				});
			}
			if( objID.val() == 'three-col-left' || objID.val() == 'three-col-middle' || objID.val() == 'three-col-right'){
				$( this ).find('input.responsi-radio-img-radio').each( function(){
					if($( this ).val() == 5 || $( this ).val() == 6){
						$( this ).siblings('img').hide();
					}else{
						$( this ).siblings('img').show();
					}
					if( $( this ).is(':checked') && $( this ).val() >= 5){
						$( this ).parent().parent().find( '.responsi-radio-img-selected' ).removeClass( 'responsi-radio-img-selected' );
						$( this ).parent().parent().find( 'input.responsi-radio-img-radio' ).each( function(){
							if( $( this ).val() == 4){
								$( this ).prop('checked',true);
								$( this ).siblings('img').addClass("responsi-radio-img-selected");
							}
						});
					}
				});
			}

		});


 	}, // End setup_image_selectors_click()

 	setup_meta_image_selectors_click: function () {
		var parent_layout = ($('input.responsi-metabox-radio-img-radio:checked').val());
		if(parent_layout == 'two-col-left' || parent_layout == 'two-col-right'){
			$('#responsi-metabox-radio-img-content_layout1').parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
				if(index == 6){
					$(this).hide();
				}
			});
		}
		if(parent_layout == 'three-col-left' || parent_layout == 'three-col-middle' || parent_layout == 'three-col-right'){
			$('#responsi-metabox-radio-img-content_layout1').parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
				if(index == 5 || index == 6){
					$(this).hide();
				}
			});
		}


		$( document ).on( 'click','.responsi-metabox-radio-img-img',function(){

			var layout = $( this ).attr('onclick').replace("document.getElementById('responsi-metabox-radio-img-layout", "").replace("').checked = true;", "");

			var content_layout = $( this ).attr('onclick').replace("document.getElementById('responsi-metabox-radio-img-content_layout", "").replace("').checked = true;", "");

			if(layout == 1){
				$('img.responsi-metabox-radio-img-img').show();
				$('#responsi-metabox-radio-img-content_layout'+layout).prop('checked',true);
				$('#responsi-metabox-radio-img-content_layout'+layout).parent().parent().find('.responsi-metabox-radio-img-img').removeClass( 'responsi-metabox-radio-img-selected' );
				$('#responsi-metabox-radio-img-content_layout'+layout).parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
					if(index == (layout-1)){
						$(this).addClass( 'responsi-metabox-radio-img-selected' );
					}
				});

			}
			if(content_layout == 1){
				$('#responsi-metabox-radio-img-layout'+content_layout).prop('checked',true);
				$('#responsi-metabox-radio-img-layout'+content_layout).parent().parent().find('.responsi-metabox-radio-img-img').removeClass( 'responsi-metabox-radio-img-selected' );
				$('#responsi-metabox-radio-img-layout'+content_layout).parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
					if(index == (content_layout-1)){
						$(this).addClass( 'responsi-metabox-radio-img-selected' );
					}
				});
			}

			if(layout == 2){
				$('img.responsi-metabox-radio-img-img').show();
				if($('input#responsi-metabox-radio-img-content_layout1').is(':checked') ){
					$('#responsi-metabox-radio-img-content_layout6').prop('checked',true);
					$('#responsi-metabox-radio-img-content_layout'+layout).parent().parent().find('.responsi-metabox-radio-img-img').removeClass( 'responsi-metabox-radio-img-selected' );
					$('#responsi-metabox-radio-img-content_layout'+layout).parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
						if(index == 6){
							$(this).addClass( 'responsi-metabox-radio-img-selected' );
						}
					});
				}
			}

			if(layout == 3 || layout == 4){
				$('img.responsi-metabox-radio-img-img').show();
				$('#responsi-metabox-radio-img-content_layout'+layout).parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
					if(index == 6){
						$(this).hide();
					}
				});
				if($('input#responsi-metabox-radio-img-content_layout1').is(':checked') || $('input#responsi-metabox-radio-img-content_layout6').is(':checked') ){
					$('#responsi-metabox-radio-img-content_layout5').prop('checked',true);
					$('#responsi-metabox-radio-img-content_layout'+layout).parent().parent().find('.responsi-metabox-radio-img-img').removeClass( 'responsi-metabox-radio-img-selected' );
					$('#responsi-metabox-radio-img-content_layout'+layout).parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
						if(index == 5){
							$(this).addClass( 'responsi-metabox-radio-img-selected' );
						}
					});
				}
			}

			if(layout == 5 || layout == 6 || layout == 7){
				$('img.responsi-metabox-radio-img-img').show();
				$('#responsi-metabox-radio-img-content_layout1').parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
					if(index == 5 || index == 6){
						$(this).hide();
					}
				});
				if($('input#responsi-metabox-radio-img-content_layout1').is(':checked') || $('input#responsi-metabox-radio-img-content_layout5').is(':checked') || $('input#responsi-metabox-radio-img-content_layout6').is(':checked') ){
				$('#responsi-metabox-radio-img-content_layout4').prop('checked',true);
					$('#responsi-metabox-radio-img-content_layout1').parent().parent().find('.responsi-metabox-radio-img-img').removeClass( 'responsi-metabox-radio-img-selected' );
					$('#responsi-metabox-radio-img-content_layout1').parent().parent().find('img.responsi-metabox-radio-img-img').each(function(index){
						if(index == 4){
							$(this).addClass( 'responsi-metabox-radio-img-selected' );
						}
					});
				}
			}

		});
	},

/**
 * setup_colourpickers()
 *
 * @since 4.8.0
 */

 	setup_colourpickers: function () {
 		if ( jQuery().ColorPicker && $( '.section-typography, .section-border, .section-color' ).length ) {
 			$( '.section-typography, .section-border, .section-color' ).each( function () {

 				var option_id = $( this ).find( '.responsi-color' ).attr( 'id' );
				var color = $( this ).find( '.responsi-color' ).val();
				var picker_id = option_id += '_picker';

 				if ( $( this ).hasClass( 'section-typography' ) || $( this ).hasClass( 'section-border' ) ) {
					option_id += '_color';
				}

	 			$( '#' + picker_id ).children( 'div' ).css( 'backgroundColor', color );
				$( '#' + picker_id ).ColorPicker({
					color: color,
					onShow: function ( colpkr ) {
						jQuery( colpkr ).fadeIn( 200 );
						return false;
					},
					onHide: function ( colpkr ) {
						jQuery( colpkr ).fadeOut( 200 );
						return false;
					},
					onChange: function ( hsb, hex, rgb ) {
						$( '#' + picker_id ).children( 'div' ).css( 'backgroundColor', '#' + hex );
						$( '#' + picker_id ).next( 'input' ).attr( 'value', '#' + hex );

					}
				});
 			});
 		}
 	}, // End setup_colourpickers()

/**
 * setup_field_tabber()
 *
 * @since 1.0.0
 */

  	setup_field_tabber: function () {
  		$( '.responsi-metabox-tabs' ).tabs();
  	}, // End setup_field_tabber()

/**
 * setup_upload_titletest()
 *
 * @since 4.8.0
 * @deprecated
 */

 	setup_upload_titletest: function () {
 		if ( $( 'input#title' ).length ) {
			var val = $( 'input#title' ).attr( 'value' );
			if(val == ''){
				$( '.responsi-metabox-fields .button-highlighted' ).after( '<em class="responsi-metabox-rednote">Please add a Title before uploading a file</em>' );
			};
		}
 	} // End setup_upload_titletest()


  }; // End responsiCustomFields Object // Don't remove this, or the sky will fall on your head.

/**
 * Execute the above methods in the responsiCustomFields object.
 *
 * @since 4.8.0
 */
	$(document).ready(function () {

		responsiCustomFields.adjust_form_encoding();
		responsiCustomFields.setup_wordcounters();
		responsiCustomFields.setup_image_selectors();
		responsiCustomFields.setup_meta_image_selectors_click();
		responsiCustomFields.setup_upload_titletest();
		responsiCustomFields.setup_field_tabber();

	});

})(jQuery);
