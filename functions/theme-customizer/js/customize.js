(function(wp, $) {

	var api = wp.customize;

	responsiCustomizeBase = {

		setup_ui_unhide_visible: function(groupID) {

			$('#' + groupID + ' .collapsed2').each(function() {
				$(this).find('input:checked').parent().parent().parent().parent().nextAll().each(function() {
					if ($(this).hasClass('last')) {
						$(this).removeClass('visible').addClass('hide');
						return false;
					}
					$(this).filter('.visible').removeClass('visible').addClass('hide');
				});
			});
		},

		setup_ui_unhide_hidden: function(groupID) {

			$('#' + groupID + ' .collapsed').each(function() {
				$(this).find('input:checked').parent().parent().parent().parent().nextAll().each(function() {
					if ($(this).hasClass('last')) {
						$(this).removeClass('hide');
						return false;
					}
					$(this).filter('.hide').removeClass('hide');
				});
			});
		},

		setup_ui_unhide_hidden_custom: function(groupID) {

			$('#' + groupID + ' .collapsed-custom').each(function() {
				$(this).find('input:checked').parent().parent().parent().parent().nextAll().each(function() {
					if ($(this).hasClass('hide-custom-last')) {
						$(this).removeClass('hide-custom');
						return false;
					}
					$(this).filter('.hide-custom').removeClass('hide-custom');
				});
			});
		},

		setup_ui_unhide_hidden_custom_sub: function(groupID) {

			$('#' + groupID + ' .collapsed-custom-sub').each(function() {
				$(this).find('input:checked').parent().parent().parent().parent().nextAll().each(function() {
					if ($(this).hasClass('hide-custom-sub-last')) {
						$(this).removeClass('hide-custom-sub');
						return false;
					}
					$(this).filter('.hide-custom-sub').removeClass('hide-custom-sub');
				});
			});
		},

		setup_ui_custom_logic: function(groupID) {

			//Logic Layout
			$('#' + groupID + ' .customize-control-layout.layout-logic input.responsi-radio-img-radio:checked').siblings('img').trigger('click');
			$('#' + groupID + ' .customize-control-layout.post-thumb-type input.responsi-radio-img-radio:checked').siblings('img').trigger('click');

			//Logic Boxed layout
			if ($('#' + groupID + ' #responsi_layout_boxed_cb').prop('checked')) {
				$('.for-wide-mode').addClass('hide-custom');
				$('.for-box-mode').removeClass('hide-custom');
			} else {
				$('.for-box-mode').addClass('hide-custom');
				$('.for-wide-mode').removeClass('hide-custom');
			}
			// end Logic Boxed layout

			//Logic Background Theme
			if ($('#' + groupID + ' #responsi_disable_background_style_img_cb').prop('checked')) {
				$('#' + groupID + ' #responsi_use_style_bg_image_cb').removeAttr('checked').iphoneStyle("refresh");
			}
			if ($('#' + groupID + ' #responsi_use_style_bg_image_cb').prop('checked')) {
				$('#' + groupID + ' #responsi_disable_background_style_img_cb').removeAttr('checked').iphoneStyle("refresh");
			}
			//end Logic Background Theme

			//Header Mobile
			var widget_num = $('#' + groupID + ' .header_sidebars_logical').find('input:checked').val();
			if (widget_num == 0) {
				$('#' + groupID + ' .header-widgets-logic').hide();
			} else {
				$('#' + groupID + ' .header-widgets-logic').show();
			}
			$('#' + groupID + ' .header-widgets-logic .responsi-imulticheckbox-item').hide();
			for (var i = 1; i <= widget_num; i++) {
				$('#' + groupID + ' .imulticheckbox-' + i).show();
			}

			//Sidebar Widget Mobile
			var sidebar_widget_logical = $('#' + groupID + ' .sidebar_widget_logical').find('input:checked').val();
			if (sidebar_widget_logical == 'one-col') {
				$('#' + groupID + ' .sidebar-widgets-logic').hide();
			} else {
				$('#' + groupID + ' .sidebar-widgets-logic').show();
			}

			//Footer Mobile
			var footer_widget_logical = $('#' + groupID + ' .footer_widget_logical').find('input:checked').val();
			if (footer_widget_logical == 0) {
				$('#' + groupID + ' .footer-widgets-logic').hide();
			} else {
				$('#' + groupID + ' .footer-widgets-logic').show();
			}

			//Logic Comments
			var responsi_comments = $('input[name="responsi_comments"]:checked');
			if (responsi_comments.val() == 'none') {
				$('li#customize-control-responsi_post_comments_bg, li#customize-control-post_label126').addClass('hide');
			} else {
				$('li#customize-control-responsi_post_comments_bg, li#customize-control-post_label126').removeClass('hide');
			}

			//Logic Footer Cell
			var footer_cell_1;
			var footer_cell_2;
			if ($('input#responsi_disable_ext_cat_author_cb').prop('checked')) {
				footer_cell_1 = true;
			} else {
				footer_cell_1 = false;
			}

			if ($('input#responsi_disable_ext_tags_comment_cb').prop('checked')) {
				footer_cell_2 = true;
			} else {
				footer_cell_2 = false;
			}

			if (footer_cell_1 == true && footer_cell_2 == true) {
				$('.footer-cell-both').removeClass('hide');
			}

			if (footer_cell_1 == false && footer_cell_2 == false) {
				$('.footer-cell-both').addClass('hide');
			}

			if (footer_cell_1 == true && footer_cell_2 == false) {
				$('.footer-cell-1, .footer-cell-both').removeClass('hide');
				$('.footer-cell-2').addClass('hide');
			}

			if (footer_cell_1 == false && footer_cell_2 == true) {
				$('.footer-cell-2, .footer-cell-both').removeClass('hide');
				$('.footer-cell-1').addClass('hide');
			}

			var _post_meta_date = false;
			var _post_meta_comment = false;
			var _post_meta_author = false;
			if ($('input#responsi_disable_post_meta_date_cb').prop('checked')) {
				_post_meta_date = true;
			} else {
				_post_meta_date = false;
			}
			if ($('input#responsi_disable_post_meta_comment_cb').prop('checked')) {
				_post_meta_comment = true;
			} else {
				_post_meta_comment = false;
			}
			if ($('input#responsi_disable_post_meta_author_cb').prop('checked')) {
				_post_meta_author = true;
			} else {
				_post_meta_author = false;
			}
			if (_post_meta_date == false && _post_meta_comment == false && _post_meta_author == false) {
				$('.single-post-meta').addClass('hide');
			} else {
				$('.single-post-meta').removeClass('hide');
			}
		},

		handleEvents: function() {
			$(document).on('responsi-ui-iradio-switch', '.customize-control input[name="responsi_comments"]', function(elem, status) {
				if ($(this).prop("checked")) {
					if ($(this).val() == 'none') {
						$('li#customize-control-responsi_post_comments_bg, li#customize-control-post_label126').addClass('hide');
					} else {
						$('li#customize-control-responsi_post_comments_bg, li#customize-control-post_label126').removeClass('hide');
					}
				}
			});

			// Off for show
			$(document).on('responsi-ui-icheckbox-switch', '.customize-control.collapsed2 input.responsi-ui-icheckbox', function(event, elem, status) {
				if ($(this).prop('checked')) {
					$(this).parent().parent().parent().parent('.collapsed2').nextAll().each(function() {
						if ($(this).filter('.last').length) {
							$(this).slideUp("fast").removeClass('visible').addClass('hide');
							return false;
						}
						$(this).slideUp("fast").removeClass('visible').addClass('hide');
					});
				} else {
					$(this).parent().parent().parent().parent('.collapsed2').nextAll().each(function() {
						if ($(this).filter('.last').length) {
							$(this).slideDown("fast").addClass('visible').removeClass('hide');
							return false;
						}
						$(this).slideDown("fast").addClass('visible').removeClass('hide');
					});
				}
			});

			// Off for hide
			$(document).on('responsi-ui-icheckbox-switch', '.customize-control.collapsed input.responsi-ui-icheckbox', function(event, elem, status) {
				if ($(this).prop('checked')) {
					$(this).parent().parent().parent().parent('.collapsed').nextAll().each(function() {
						if ($(this).filter('.last').length) {
							$(this).slideDown("fast").removeClass('hide').addClass('visible');
							return false;
						}
						$(this).slideDown("fast").removeClass('hide').addClass('visible');
					});
				} else {
					$(this).parent().parent().parent().parent('.collapsed').nextAll().each(function() {
						if ($(this).filter('.last').length) {
							$(this).slideUp("fast").addClass('hide');
							return false;
						}
						$(this).slideUp("fast").addClass('hide');
					});
				}
			});

			// Off for hide custom
			$(document).on('responsi-ui-icheckbox-switch', '.customize-control.collapsed-custom input.responsi-ui-icheckbox', function(event, elem, status) {
				if ($(this).prop('checked')) {
					$(this).parent().parent().parent().parent('.collapsed-custom').nextAll().each(function() {
						if ($(this).filter('.hide-custom-last').length) {
							$(this).slideDown("fast").removeClass('hide-custom').addClass('visible_custom');
							return false;
						}
						$(this).slideDown("fast").removeClass('hide-custom').addClass('visible_custom');
					});
				} else {
					$(this).parent().parent().parent().parent('.collapsed-custom').nextAll().each(function() {
						if ($(this).filter('.hide-custom-last').length) {
							$(this).slideUp("fast").addClass('hide-custom');
							return false;
						}
						$(this).slideUp("fast").addClass('hide-custom');
					});
				}
			});

			// Off for hide custom sub
			$(document).on('responsi-ui-icheckbox-switch', '.customize-control.collapsed-custom-sub input.responsi-ui-icheckbox', function(event, elem, status) {
				if ($(this).prop('checked')) {
					$(this).parent().parent().parent().parent('.collapsed-custom-sub').nextAll().each(function() {
						if ($(this).filter('.hide-custom-sub-last').length) {
							$(this).slideDown("fast").removeClass('hide-custom-sub').addClass('visible_custom_sub');
							return false;
						}
						$(this).slideDown("fast").removeClass('hide-custom-sub').addClass('visible_custom_sub');
					});
				} else {
					$(this).parent().parent().parent().parent('.collapsed-custom-sub').nextAll().each(function() {
						if ($(this).filter('.hide-custom-sub-last').length) {
							$(this).slideUp("fast").addClass('hide-custom-sub');
							return false;
						}
						$(this).slideUp("fast").addClass('hide-custom-sub');
					});
				}
			});

			//Logic Boxed layout
			$(document).on('responsi-ui-icheckbox-switch', '#responsi_layout_boxed_cb', function(event, elem, status) {
				if (elem.prop('checked')) {
					$('.for-wide-mode').addClass('hide-custom');
					$('.for-box-mode').removeClass('hide-custom');
				} else {
					$('.for-box-mode').addClass('hide-custom');
					$('.for-wide-mode').removeClass('hide-custom');
				}
			});
			// end Logic Boxed layout

			//Logic Background Theme
			$(document).on('responsi-ui-icheckbox-switch', '.customize-control-icheckbox input.responsi-ui-icheckbox', function(event, elem, status) {
				if (elem.attr('id') == 'responsi_disable_background_style_img_cb') {
					if (elem.prop('checked')) {
						$('#responsi_use_style_bg_image_cb').removeAttr('checked').iphoneStyle("refresh");
					}
				}
				if (elem.attr('id') == 'responsi_use_style_bg_image_cb') {
					if (elem.prop('checked')) {
						$('#responsi_disable_background_style_img_cb').removeAttr('checked').iphoneStyle("refresh");
					}
				}
			});
			//end Logic Background Theme

			//Header Mobile
			$(document).on('click', '.header_sidebars_logical img.responsi-radio-img-img', function() {
				var w_num = $(this).parent().parent('.customize-control-container').find('input:checked').val();
				if (w_num == 0) {
					$('.header-widgets-logic').slideUp();
				} else {
					$('.header-widgets-logic').slideDown();
				}
				$('.header-widgets-logic .responsi-imulticheckbox-item').hide();
				for (var i = 1; i <= w_num; i++) {
					$('.imulticheckbox-' + i).slideDown();
				}
			});

			//Sidebar Mobile
			$(document).on('click', '.sidebar_widget_logical img.responsi-radio-img-img', function() {
				var sidebar_widget_logical = $(this).parent().parent('.customize-control-container').find('input:checked').val();
				if (sidebar_widget_logical == 'one-col') {
					$('.sidebar-widgets-logic').slideUp();
				} else {
					$('.sidebar-widgets-logic').slideDown();
				}
			});

			//Footer Mobile
			$(document).on('click', '.footer_widget_logical img.responsi-radio-img-img', function() {
				var footer_widget_logical = $(this).parent().parent('.customize-control-container').find('input:checked').val();
				if (footer_widget_logical == 0) {
					$('.footer-widgets-logic').slideUp();
				} else {
					$('.footer-widgets-logic').slideDown();
				}
			});

			//Footer Cell
			$(document).on('responsi-ui-icheckbox-switch', '.customize-control-icheckbox input#responsi_disable_ext_cat_author_cb, .customize-control-icheckbox input#responsi_disable_ext_tags_comment_cb', function(event, elem, status) {
				var footer_cell_1;
				var footer_cell_2;

				if ($('input#responsi_disable_ext_cat_author_cb').prop('checked')) {
					footer_cell_1 = true;
				} else {
					footer_cell_1 = false;
				}

				if ($('input#responsi_disable_ext_tags_comment_cb').prop('checked')) {
					footer_cell_2 = true;
				} else {
					footer_cell_2 = false;
				}

				if (footer_cell_1 == true && footer_cell_2 == true) {
					$('.footer-cell-both').removeClass('hide');
				}

				if (footer_cell_1 == false && footer_cell_2 == false) {
					$('.footer-cell-both').addClass('hide');
				}

				if (footer_cell_1 == true && footer_cell_2 == false) {
					$('.footer-cell-1, .footer-cell-both').removeClass('hide');
					$('.footer-cell-2').addClass('hide');
				}

				if (footer_cell_1 == false && footer_cell_2 == true) {
					$('.footer-cell-2, .footer-cell-both').removeClass('hide');
					$('.footer-cell-1').addClass('hide');
				}

			});

			$(document).on('responsi-ui-icheckbox-switch', '.customize-control-icheckbox input#responsi_disable_post_meta_date_cb, .customize-control-icheckbox input#responsi_disable_post_meta_comment_cb, .customize-control-icheckbox input#responsi_disable_post_meta_author_cb', function(event, elem, status) {
				var _post_meta_date = false;
				var _post_meta_comment = false;
				var _post_meta_author = false;
				if ($('input#responsi_disable_post_meta_date_cb').prop('checked')) {
					_post_meta_date = true;
				} else {
					_post_meta_date = false;
				}
				if ($('input#responsi_disable_post_meta_comment_cb').prop('checked')) {
					_post_meta_comment = true;
				} else {
					_post_meta_comment = false;
				}
				if ($('input#responsi_disable_post_meta_author_cb').prop('checked')) {
					_post_meta_author = true;
				} else {
					_post_meta_author = false;
				}
				if (_post_meta_date == false && _post_meta_comment == false && _post_meta_author == false) {
					$('.single-post-meta').addClass('hide');
				} else {
					$('.single-post-meta').removeClass('hide');
				}
			});
		}
	};

	$(window).on( 'load', function() {

		if( window._responsiCustomizeControls ){

			$.each( window._responsiCustomizeControls, function( id, data ) {
				var Constructor = wp.customize.controlConstructor[ data.type ] || wp.customize.Control, options;
				options = _.extend( { params: data }, data ); // Inclusion of params alias is for back-compat for custom controls that expect to augment this property.
				wp.customize.control.add( new Constructor( id, options ) );
			});

		}

		responsiCustomizeBase.handleEvents();

		// Customize Responsi Focus
		api.previewer.bind('focus-panel-for-setting', function(panelId) {
			api.panel(panelId).expand();
		});

		api.previewer.bind('focus-section-for-setting', function(sectionId) {
			api.section(sectionId).expand();
		});

		$('li.control-section-default, ul.customize-pane-child').on('expanded', function() {
			
			var groupID = $(this).attr('id');
			responsiCustomizeBase.setup_ui_custom_logic(groupID);
			if (!$(this).hasClass('controls-added')) {
				$(this).addClass('controls-added');
				if (!$('.customize-control-iuploadcrop').hasClass('customize-control-upload')) {
					$('.customize-control-iuploadcrop').addClass('customize-control-upload');
				}
				responsiCustomizeBase.setup_ui_unhide_hidden_custom(groupID);
				responsiCustomizeBase.setup_ui_unhide_hidden_custom_sub(groupID);
				responsiCustomizeBase.setup_ui_unhide_hidden(groupID);
				responsiCustomizeBase.setup_ui_unhide_visible(groupID);
				$(this).find('li.customize-control-responsi').css({
					opacity: 1
				});
			}
		});

	});

})(window.wp, jQuery);

wp.customize.responsiFrameworkCustomize = wp.customize.ResponsiFrameworkPreview = ( function( $, _, wp, api ) {
	
	api.bind( 'ready', function() {
	});

}( jQuery, _, wp, wp.customize ) );
