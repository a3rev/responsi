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
			if ($('#' + groupID + ' #responsi_layout_boxed').prop('checked')) {
				$('.for-wide-mode').addClass('hide-custom');
				$('.for-box-mode').removeClass('hide-custom');
			} else {
				$('.for-box-mode').addClass('hide-custom');
				$('.for-wide-mode').removeClass('hide-custom');
			}
			// end Logic Boxed layout

			//Logic Background Theme
			if ($('#' + groupID + ' #responsi_disable_background_style_img').prop('checked')) {
				$('#' + groupID + ' #responsi_use_style_bg_image').prop('checked', false ).iphoneStyle("refresh");
			}
			if ($('#' + groupID + ' #responsi_use_style_bg_image').prop('checked')) {
				$('#' + groupID + ' #responsi_disable_background_style_img').prop('checked', false ).iphoneStyle("refresh");
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
			$('#' + groupID + ' .header-animation').hide();
			for (var i = 1; i <= widget_num; i++) {
				$('#' + groupID + ' .imulticheckbox-' + i).show();
				$('#' + groupID + ' .header-animation-' + i).show();
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
				$('#' + groupID + ' .footer-animation').hide();
				for (var i = 1; i <= footer_widget_logical; i++) {
					$('#' + groupID + ' .footer-animation-' + i).show();
				}
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
			if ($('input#responsi_disable_ext_cat_author').prop('checked')) {
				footer_cell_1 = true;
			} else {
				footer_cell_1 = false;
			}

			if ($('input#responsi_disable_ext_tags_comment').prop('checked')) {
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
			if ($('input#responsi_disable_post_meta_date').prop('checked')) {
				_post_meta_date = true;
			} else {
				_post_meta_date = false;
			}
			if ($('input#responsi_disable_post_meta_comment').prop('checked')) {
				_post_meta_comment = true;
			} else {
				_post_meta_comment = false;
			}
			if ($('input#responsi_disable_post_meta_author').prop('checked')) {
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
			$(document).on('responsi-ui-icheckbox-switch', '#responsi_layout_boxed', function(event, elem, status) {
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
				if (elem.attr('id') == 'responsi_disable_background_style_img') {
					if (elem.prop('checked')) {
						$('#responsi_use_style_bg_image').prop('checked', false ).iphoneStyle("refresh");
					}
				}
				if (elem.attr('id') == 'responsi_use_style_bg_image') {
					if (elem.prop('checked')) {
						$('#responsi_disable_background_style_img').prop('checked', false ).iphoneStyle("refresh");
					}
				}
			});
			//end Logic Background Theme

			//Header Mobile
			$(document).on('click', '.header_sidebars_logical img.responsi-radio-img-img', function() {
				var w_num = $(this).parent().parent('.customize-ctrl').find('input:checked').val();
				if (w_num == 0) {
					$('.header-widgets-logic').slideUp();
				} else {
					$('.header-widgets-logic').slideDown();
				}
				$('.header-widgets-logic .responsi-imulticheckbox-item').hide();
				$('.header-animation').hide();
	
				for (var i = 1; i <= w_num; i++) {
					$('.imulticheckbox-' + i).slideDown();
					$('.header-animation-' + i).slideDown();
				}
			});

			//Sidebar Mobile
			$(document).on('click', '.sidebar_widget_logical img.responsi-radio-img-img', function() {
				var sidebar_widget_logical = $(this).parent().parent('.customize-ctrl').find('input:checked').val();
				if (sidebar_widget_logical == 'one-col') {
					$('.sidebar-widgets-logic').slideUp();
				} else {
					$('.sidebar-widgets-logic').slideDown();
				}
			});

			//Footer Mobile
			$(document).on('click', '.footer_widget_logical img.responsi-radio-img-img', function() {
				var footer_widget_logical = $(this).parent().parent('.customize-ctrl').find('input:checked').val();
			
				if (footer_widget_logical == 0) {
					$('.footer-widgets-logic').slideUp();
				} else {
					$('.footer-widgets-logic').slideDown();
					$('.footer-animation').hide();
					for (var i = 1; i <= footer_widget_logical; i++) {
						$('.footer-animation-' + i).show();
					}
				}
			});

			//Footer Cell
			$(document).on('responsi-ui-icheckbox-switch', '.customize-control-icheckbox input#responsi_disable_ext_cat_author, .customize-control-icheckbox input#responsi_disable_ext_tags_comment', function(event, elem, status) {
				var footer_cell_1;
				var footer_cell_2;

				if ($('input#responsi_disable_ext_cat_author').prop('checked')) {
					footer_cell_1 = true;
				} else {
					footer_cell_1 = false;
				}

				if ($('input#responsi_disable_ext_tags_comment').prop('checked')) {
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

			$(document).on('responsi-ui-icheckbox-switch', '.customize-control-icheckbox input#responsi_disable_post_meta_date, .customize-control-icheckbox input#responsi_disable_post_meta_comment, .customize-control-icheckbox input#responsi_disable_post_meta_author', function(event, elem, status) {
				var _post_meta_date = false;
				var _post_meta_comment = false;
				var _post_meta_author = false;
				if ($('input#responsi_disable_post_meta_date').prop('checked')) {
					_post_meta_date = true;
				} else {
					_post_meta_date = false;
				}
				if ($('input#responsi_disable_post_meta_comment').prop('checked')) {
					_post_meta_comment = true;
				} else {
					_post_meta_comment = false;
				}
				if ($('input#responsi_disable_post_meta_author').prop('checked')) {
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

	api.sectionContainer = function( control ){
		var sectionContainer = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
		if( sectionContainer.length == 0 ){
			sectionContainer = control.container.parent('ul.customize-pane-child');
		}
		return sectionContainer;
	}

	api.Customize_Typography_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var picker,
				size_select = control.container.find('select.responsi-typography-size'),
				line_height_select = control.container.find('select.responsi-typography-line-height'),
				face_select = control.container.find('select.responsi-typography-face'),
				style_select = control.container.find('select.responsi-typography-style'),
				size_selected,
				line_height_selected,
				style_selected,
				face_selected;

				if (!control.container.hasClass('applied_typography')) {
					control.container.addClass('applied_typography');

					// Color Picker
					picker = control.container.find( '.color-picker-hex' );
					picker.val( control.params.values.color ).wpColorPicker({
						change: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( picker.wpColorPicker( 'color' ) );
							}
							updating = false;
						},
						clear: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( '' );
							}
							updating = false;
						}
					});

					if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
						control.settings[control.id + '[color]'].bind( function ( value ) {
							// Bail if the update came from the control itself.
							if ( updating ) {
								return;
							}
							picker.val( value );
							picker.wpColorPicker( 'color', value );
						} );
					}

					// Collapse color picker when hitting Esc instead of collapsing the current section.
					control.container.on( 'keydown', function( event ) {
						var pickerContainer;
						if ( 27 !== event.which ) { // Esc.
							return;
						}
						pickerContainer = control.container.find( '.wp-picker-container' );
						if ( pickerContainer.hasClass( 'wp-picker-active' ) ) {
							picker.wpColorPicker( 'close' );
							control.container.find( '.wp-color-result' ).trigger('focus');
							event.stopPropagation();
						}
					} );

					for (var i = _wpCustomTypographyControl.size.min; i <= _wpCustomTypographyControl.size.max; i++) {
						size_selected = '';
						if (i == control.params.values.size) {
							size_selected = 'selected="select"';
						}
						size_select.append('<option value="' + i + '" ' + size_selected + ' >' + i + 'px</option>');
					}

					_.each(_wpCustomTypographyControl.line_heights, function(line_height_value, index) {
						line_height_selected = '';
						if (line_height_value == control.params.values.line_height) {
							line_height_selected = 'selected="select"';
						}
						line_height_select.append('<option value="' + line_height_value + '" ' + line_height_selected + ' >' + line_height_value + '</option>');
					});

					_.each(_wpCustomTypographyControl.styles, function(style_name, index) {
						style_selected = '';
						if (index == control.params.values.style) {
							style_selected = 'selected="select"';
						}
						style_select.append('<option value="' + index + '" ' + style_selected + ' >' + style_name + '</option>');
					});

					_.each(_wpCustomTypographyControl.fonts, function(font_name, index) {
						face_selected = '';
						if (index == control.params.values.face) {
							face_selected = 'selected="select"';
						}
						face_select.append('<option value="' + index + '" ' + face_selected + ' >' + font_name.name + '</option>');
					});

					size_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[size]'] ){
							control.settings[control.id + '[size]'].set($(this).val());
						}
					});

					line_height_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[line_height]'] ){
							control.settings[control.id + '[line_height]'].set($(this).val());
						}
					});

					face_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[face]'] ){
							control.settings[control.id + '[face]'].set($(this).val());
						}
					});

					style_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[style]'] ){
							control.settings[control.id + '[style]'].set($(this).val());
						}
					});
				}
			});
		}
	});

	api.Customize_Border_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var picker,
				size_select = control.container.find('select.responsi-border-width'),
				style_select = control.container.find('select.responsi-border-style'),
				size_selected,
				style_selected;

				if (!control.container.hasClass('applied_border')) {
					control.container.addClass('applied_border');

					// Color Picker
					picker = control.container.find( '.color-picker-hex' );
					picker.val( control.params.values.color ).wpColorPicker({
						change: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( picker.wpColorPicker( 'color' ) );
							}
							updating = false;
						},
						clear: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( '' );
							}
							updating = false;
						}
					});
					
					if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
						control.settings[control.id + '[color]'].bind( function ( value ) {
							// Bail if the update came from the control itself.
							if ( updating ) {
								return;
							}
							picker.val( value );
							picker.wpColorPicker( 'color', value );
						} );
					}

					// Collapse color picker when hitting Esc instead of collapsing the current section.
					control.container.on( 'keydown', function( event ) {
						var pickerContainer;
						if ( 27 !== event.which ) { // Esc.
							return;
						}
						pickerContainer = control.container.find( '.wp-picker-container' );
						if ( pickerContainer.hasClass( 'wp-picker-active' ) ) {
							picker.wpColorPicker( 'close' );
							control.container.find( '.wp-color-result' ).trigger('focus');
							event.stopPropagation();
						}
					} );
				
					for (var i = _wpCustomBorderControl.width.min; i <= _wpCustomBorderControl.width.max; i++) {
						size_selected = '';
						if (i == control.params.values.width) {
							size_selected = 'selected="select"';
						}
						size_select.append('<option value="' + i + '" ' + size_selected + ' >' + i + 'px</option>');
					}

					_.each(_wpCustomBorderControl.styles, function(style_name, index) {
						style_selected = '';
						if (index == control.params.values.style) {
							style_selected = 'selected="select"';
						}
						style_select.append('<option value="' + index + '" ' + style_selected + ' >' + style_name + '</option>');
					});

					size_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[width]'] ){
							control.settings[control.id + '[width]'].set($(this).val());
						}
					});

					style_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[style]'] ){
							control.settings[control.id + '[style]'].set($(this).val());
						}
					});

				}
			});

			

		}
	});

	api.Customize_Border_Radius_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var switcher = control.container.find('.responsi-ui-icheckbox'),
					ui_slide = control.container.find('.ui-slide'),
					ui_slide_input = control.container.find('.islide-value'),
					min = parseFloat(_wpCustomBorderRadiusControl.rounded.min),
					max = parseFloat(_wpCustomBorderRadiusControl.rounded.max),
					step = parseFloat(_wpCustomBorderRadiusControl.rounded.step),
					rounded_value = parseFloat(control.params.values.rounded_value),
					checked_value = _wpCustomBorderRadiusControl.corner.checked_value,
					unchecked_value = _wpCustomBorderRadiusControl.corner.unchecked_value,
					checked_label = _wpCustomBorderRadiusControl.corner.checked_label,
					unchecked_label = _wpCustomBorderRadiusControl.corner.unchecked_label,
					container_width = parseFloat(_wpCustomBorderRadiusControl.corner.container_width),
					corner_value = control.params.values.corner;


				if (!control.container.hasClass('applied_border_radius')) {
					control.container.addClass('applied_border_radius');

					if (corner_value == checked_value) {
						control.container.find('.responsi-range-slider').show();
					} else {
						control.container.find('.responsi-range-slider').hide();
					}

					// Switcher
					switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
						customWidth: true,
						containerWidth: container_width,
						resizeHandle: false,
						handleMargin: 10,
						handleRadius: 5,
						containerRadius: 0,
						checkedLabel: checked_label,
						uncheckedLabel: unchecked_label,
						onChange: function(elem, value) {
							var status = value.toString();
							if (elem.prop('checked')) {
								var val = checked_value;
								control.container.find('.responsi-range-slider').show();
							} else {
								var val = unchecked_value;
								control.container.find('.responsi-range-slider').hide();
							}
							if( 'undefined' !== typeof control.settings[control.id + '[corner]'] ){
								control.settings[control.id + '[corner]'].set(val);
							}
							switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
						}
					});

					// Slider
					ui_slide.slider({
						isRTL: true,
						range: "min",
						min: min,
						max: max,
						value: rounded_value,
						step: step,
						slide: function(event, ui) {
							ui_slide_input.val(ui.value).trigger('keyup');
						},
						change: function(event, ui) {
							if( 'undefined' !== typeof control.settings[control.id + '[rounded_value]'] ){
								control.settings[control.id + '[rounded_value]'].set(ui.value);
							}
						}
					});

				}
			});
		}
	});

	api.Customize_Border_Boxes_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var picker,
				size_select = control.container.find('select.responsi-border-width'),
				style_select = control.container.find('select.responsi-border-style'),
				size_selected,
				style_selected,
				switcher = control.container.find('.responsi-ui-icheckbox'),
				min = parseFloat(_wpCustomBorderBoxesControl.rounded.min),
				max = parseFloat(_wpCustomBorderBoxesControl.rounded.max),
				step = parseFloat(_wpCustomBorderBoxesControl.rounded.step),
				ui_slide_topleft = control.container.find('.ui-slide-topleft'),
				ui_slide_input_topleft = control.container.find('.islide-value-topleft'),
				ui_slide_topright = control.container.find('.ui-slide-topright'),
				ui_slide_input_topright = control.container.find('.islide-value-topright'),
				ui_slide_bottomright = control.container.find('.ui-slide-bottomright'),
				ui_slide_input_bottomright = control.container.find('.islide-value-bottomright'),
				ui_slide_bottomleft = control.container.find('.ui-slide-bottomleft'),
				ui_slide_input_bottomleft = control.container.find('.islide-value-bottomleft'),
				topleft = parseFloat(control.params.values.topleft),
				topright = parseFloat(control.params.values.topright),
				bottomright = parseFloat(control.params.values.bottomright),
				bottomleft = parseFloat(control.params.values.bottomleft),
				checked_value = _wpCustomBorderBoxesControl.corner.checked_value,
				unchecked_value = _wpCustomBorderBoxesControl.corner.unchecked_value,
				checked_label = _wpCustomBorderBoxesControl.corner.checked_label,
				unchecked_label = _wpCustomBorderBoxesControl.corner.unchecked_label,
				container_width = parseFloat(_wpCustomBorderBoxesControl.corner.container_width),
				corner_value = control.params.values.corner;

				if (!control.container.hasClass('applied_border_boxes')) {
					control.container.addClass('applied_border_boxes');

					if (corner_value == checked_value) {
						control.container.find('.responsi-range-slider').show();
					} else {
						control.container.find('.responsi-range-slider').hide();
					}

					// Color Picker
					picker = control.container.find( '.color-picker-hex' );
					picker.val( control.params.values.color ).wpColorPicker({
						change: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( picker.wpColorPicker( 'color' ) );
							}
							updating = false;
						},
						clear: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( '' );
							}
							updating = false;
						}
					});
					
					if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
						control.settings[control.id + '[color]'].bind( function ( value ) {
							// Bail if the update came from the control itself.
							if ( updating ) {
								return;
							}
							picker.val( value );
							picker.wpColorPicker( 'color', value );
						} );
					}

					// Collapse color picker when hitting Esc instead of collapsing the current section.
					control.container.on( 'keydown', function( event ) {
						var pickerContainer;
						if ( 27 !== event.which ) { // Esc.
							return;
						}
						pickerContainer = control.container.find( '.wp-picker-container' );
						if ( pickerContainer.hasClass( 'wp-picker-active' ) ) {
							picker.wpColorPicker( 'close' );
							control.container.find( '.wp-color-result' ).trigger('focus');
							event.stopPropagation();
						}
					} );
				
					for (var i = _wpCustomBorderBoxesControl.width.min; i <= _wpCustomBorderBoxesControl.width.max; i++) {
						size_selected = '';
						if (i == control.params.values.width) {
							size_selected = 'selected="select"';
						}
						size_select.append('<option value="' + i + '" ' + size_selected + ' >' + i + 'px</option>');
					}

					_.each(_wpCustomBorderBoxesControl.styles, function(style_name, index) {
						style_selected = '';
						if (index == control.params.values.style) {
							style_selected = 'selected="select"';
						}
						style_select.append('<option value="' + index + '" ' + style_selected + ' >' + style_name + '</option>');
					});


					// Switcher
					switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
						customWidth: true,
						containerWidth: container_width,
						resizeHandle: false,
						handleMargin: 10,
						handleRadius: 5,
						containerRadius: 0,
						checkedLabel: checked_label,
						uncheckedLabel: unchecked_label,
						onChange: function(elem, value) {
							var status = value.toString();
							if (elem.prop('checked')) {
								var val = checked_value;
								control.container.find('.responsi-range-slider').show();
							} else {
								var val = unchecked_value;
								control.container.find('.responsi-range-slider').hide();
							}
							if( 'undefined' !== typeof control.settings[control.id + '[corner]'] ){
								control.settings[control.id + '[corner]'].set(val);
							}
							switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
						}
					});

					// Slider
					ui_slide_topleft.slider({
						isRTL: true,
						range: "min",
						min: min,
						max: max,
						value: topleft,
						step: step,
						slide: function(event, ui) {
							ui_slide_input_topleft.val(ui.value).trigger('keyup');
						},
						change: function(event, ui) {
							if( 'undefined' !== typeof control.settings[control.id + '[topleft]'] ){
								control.settings[control.id + '[topleft]'].set(ui.value);
							}
						}
					});

					ui_slide_topright.slider({
						isRTL: true,
						range: "min",
						min: min,
						max: max,
						value: topright,
						step: step,
						slide: function(event, ui) {
							ui_slide_input_topright.val(ui.value).trigger('keyup');
						},
						change: function(event, ui) {
							if( 'undefined' !== typeof control.settings[control.id + '[topright]'] ){
								control.settings[control.id + '[topright]'].set(ui.value);
							}
						}
					});

					ui_slide_bottomright.slider({
						isRTL: true,
						range: "min",
						min: min,
						max: max,
						value: bottomright,
						step: step,
						slide: function(event, ui) {
							ui_slide_input_bottomright.val(ui.value).trigger('keyup');
						},
						change: function(event, ui) {
							if( 'undefined' !== typeof control.settings[control.id + '[bottomright]'] ){
								control.settings[control.id + '[bottomright]'].set(ui.value);
							}
						}
					});

					ui_slide_bottomleft.slider({
						isRTL: true,
						range: "min",
						min: min,
						max: max,
						value: bottomleft,
						step: step,
						slide: function(event, ui) {
							ui_slide_input_bottomleft.val(ui.value).trigger('keyup');
						},
						change: function(event, ui) {
							if( 'undefined' !== typeof control.settings[control.id + '[bottomleft]'] ){
								control.settings[control.id + '[bottomleft]'].set(ui.value);
							}
						}
					});

					size_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[width]'] ){
							control.settings[control.id + '[width]'].set($(this).val());
						}
					});

					style_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[style]'] ){
							control.settings[control.id + '[style]'].set($(this).val());
						}
					});

				}
			});

			

		}
	});

	api.Customize_BoxShadow_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var picker,
					onoff_switcher = control.container.find('.responsi-box-shadow-onoff'),
					inset_switcher = control.container.find('.responsi-box-shadow-inset'),
					h_shadow_select = control.container.find('select.responsi-box-shadow_h_shadow'),
					v_shadow_select = control.container.find('select.responsi-box-shadow_v_shadow'),
					blur_select = control.container.find('select.responsi-box-shadow_blur'),
					spread_select = control.container.find('select.responsi-box-shadow_spread'),
					onoff_checked_value = _wpCustomBoxShadowControl.onoff.checked_value,
					onoff_unchecked_value = _wpCustomBoxShadowControl.onoff.unchecked_value,
					onoff_checked_label = _wpCustomBoxShadowControl.onoff.checked_label,
					onoff_unchecked_label = _wpCustomBoxShadowControl.onoff.unchecked_label,
					onoff_container_width = parseFloat(_wpCustomBoxShadowControl.onoff.container_width),
					onoff_value = control.params.values.onoff,
					inset_checked_value = _wpCustomBoxShadowControl.inset.checked_value,
					inset_unchecked_value = _wpCustomBoxShadowControl.inset.unchecked_value,
					inset_checked_label = _wpCustomBoxShadowControl.inset.checked_label,
					inset_unchecked_label = _wpCustomBoxShadowControl.inset.unchecked_label,
					inset_container_width = parseFloat(_wpCustomBoxShadowControl.inset.container_width),
					h_shadow_selected,
					v_shadow_selected,
					blur_selected,
					spread_selected;


				if (!control.container.hasClass('applied_box_shadow')) {
					control.container.addClass('applied_box_shadow');

					if (onoff_value == onoff_checked_value) {
						control.container.find('.responsi-box-shadow-container').show();
					} else {
						control.container.find('.responsi-box-shadow-container').hide();
					}

					// OnOff Switcher
					onoff_switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
						customWidth: true,
						containerWidth: onoff_container_width,
						resizeHandle: false,
						handleMargin: 10,
						handleRadius: 5,
						containerRadius: 0,
						checkedLabel: onoff_checked_label,
						uncheckedLabel: onoff_unchecked_label,
						onChange: function(elem, value) {
							var status = value.toString();
							if (elem.prop('checked')) {
								var val = onoff_checked_value;
								control.container.find('.responsi-box-shadow-container').show();
							} else {
								var val = onoff_unchecked_value;
								control.container.find('.responsi-box-shadow-container').hide();
							}
							if( 'undefined' !== typeof control.settings[control.id + '[onoff]'] ){
								control.settings[control.id + '[onoff]'].set(val);
							}
							onoff_switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							onoff_switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
						}
					});

					// Inset Switcher
					inset_switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
						customWidth: true,
						containerWidth: inset_container_width,
						resizeHandle: false,
						handleMargin: 10,
						handleRadius: 5,
						containerRadius: 0,
						checkedLabel: inset_checked_label,
						uncheckedLabel: inset_unchecked_label,
						onChange: function(elem, value) {
							var status = value.toString();
							if (elem.prop('checked')) {
								var val = inset_checked_value;
							} else {
								var val = inset_unchecked_value;
							}
							if( 'undefined' !== typeof control.settings[control.id + '[inset]'] ){
								control.settings[control.id + '[inset]'].set(val);
							}
							inset_switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							inset_switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);

						}
					});

					// Color Picker
					picker = control.container.find( '.color-picker-hex' );
					picker.val( control.params.values.color ).wpColorPicker({
						change: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( picker.wpColorPicker( 'color' ) );
							}
							updating = false;
						},
						clear: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( '' );
							}
							updating = false;
						}
					});
		
					if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
						control.settings[control.id + '[color]'].bind( function ( value ) {
							// Bail if the update came from the control itself.
							if ( updating ) {
								return;
							}
							picker.val( value );
							picker.wpColorPicker( 'color', value );
						} );
					}

					// Collapse color picker when hitting Esc instead of collapsing the current section.
					control.container.on( 'keydown', function( event ) {
						var pickerContainer;
						if ( 27 !== event.which ) { // Esc.
							return;
						}
						pickerContainer = control.container.find( '.wp-picker-container' );
						if ( pickerContainer.hasClass( 'wp-picker-active' ) ) {
							picker.wpColorPicker( 'close' );
							control.container.find( '.wp-color-result' ).trigger('focus');
							event.stopPropagation();
						}
					} );

					for (var i = _wpCustomBoxShadowControl.size.min; i <= _wpCustomBoxShadowControl.size.max; i++) {
						h_shadow_selected = '';
						if (i + 'px' == control.params.values.h_shadow) {
							h_shadow_selected = 'selected="select"';
						}
						h_shadow_select.append('<option value="' + i + 'px" ' + h_shadow_selected + ' >' + i + 'px</option>');

						v_shadow_selected = '';
						if (i + 'px' == control.params.values.v_shadow) {
							v_shadow_selected = 'selected="select"';
						}
						v_shadow_select.append('<option value="' + i + 'px" ' + v_shadow_selected + ' >' + i + 'px</option>');

						blur_selected = '';
						if (i + 'px' == control.params.values.blur) {
							blur_selected = 'selected="select"';
						}
						blur_select.append('<option value="' + i + 'px" ' + blur_selected + ' >' + i + 'px</option>');

						spread_selected = '';
						if (i + 'px' == control.params.values.spread) {
							spread_selected = 'selected="select"';
						}
						spread_select.append('<option value="' + i + 'px" ' + spread_selected + ' >' + i + 'px</option>');
					}

					h_shadow_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[h_shadow]'] ){
							control.settings[control.id + '[h_shadow]'].set($(this).val());
						}
					});

					v_shadow_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[v_shadow]'] ){
							control.settings[control.id + '[v_shadow]'].set($(this).val());
						}
					});

					blur_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[blur]'] ){
							control.settings[control.id + '[blur]'].set($(this).val());
						}
					});
					spread_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[spread]'] ){
							control.settings[control.id + '[spread]'].set($(this).val());
						}
					});

				}
			});
		}
	});

	api.Customize_iCheckbox_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var switcher = control.container.find('.responsi-ui-icheckbox'),
				checked_value = control.params.checked_value ? control.params.checked_value : _wpCustomIRadioControl.onoff.checked_value,
				unchecked_value = control.params.unchecked_value ? control.params.unchecked_value : _wpCustomIRadioControl.onoff.unchecked_value,
				checked_label = control.params.checked_label ? control.params.checked_label : _wpCustomIRadioControl.onoff.checked_label,
				unchecked_label = control.params.unchecked_label ? control.params.unchecked_label : _wpCustomIRadioControl.onoff.unchecked_label,
				container_width = control.params.container_width ? parseFloat(control.params.container_width) : _wpCustomIRadioControl.onoff.container_width;

				if (!control.container.hasClass('applied_icheckbox')) {
					control.container.addClass('applied_icheckbox');

					switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
						customWidth: true,
						containerWidth: container_width,
						resizeHandle: false,
						handleMargin: 10,
						handleRadius: 5,
						containerRadius: 0,
						checkedLabel: checked_label,
						uncheckedLabel: unchecked_label,
						onChange: function(elem, value) {
							var status = value.toString();
							if (elem.prop('checked')) {
								var val = checked_value;
							} else {
								var val = unchecked_value;
							}
							if( 'undefined' !== typeof control.settings[control.id] ){
								control.settings[control.id].set(val.toString());
							}else{
								if( null !== control.setting ){
									control.setting.set(val.toString());
								}
							}

							switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
						}
					});

				}
			});
		}
	});

	api.Customize_iMultiCheckbox_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var checked_value = _wpCustomIMultiCheckboxControl.onoff.checked_value,
					unchecked_value = _wpCustomIMultiCheckboxControl.onoff.unchecked_value,
					checked_label = _wpCustomIMultiCheckboxControl.onoff.checked_label,
					unchecked_label = _wpCustomIMultiCheckboxControl.onoff.unchecked_label,
					container_width = parseFloat(_wpCustomIMultiCheckboxControl.onoff.container_width);

				if (!control.container.hasClass('applied_imulticheckbox')) {
					control.container.addClass('applied_imulticheckbox');

					control.container.find('input.responsi-ui-imulticheckbox').each(function(i) {

						var setting_id = $(this).data('setting-link');

						$(this).iphoneStyle({
							duration: 50,
							resizeContainer: true,
							customWidth: true,
							containerWidth: container_width,
							resizeHandle: false,
							handleMargin: 10,
							handleRadius: 5,
							containerRadius: 0,
							checkedLabel: checked_label,
							uncheckedLabel: unchecked_label,
							onChange: function(elem, value) {
								var status = value.toString();
								if (elem.prop('checked')) {
									var val = checked_value;
								} else {
									var val = unchecked_value;
								}
								if( 'undefined' !== typeof control.settings[setting_id] ){
									control.settings[setting_id].set(val.toString());
								}
								$('input[name="' + setting_id + '"]').trigger("responsi-ui-icheckbox-switch", [elem, status]);
							},
							onEnd: function(elem, value) {
								var status = value.toString();
								$('input[name="' + setting_id + '"]').trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
							}
						});
					});

				}
			});
		}
	});

	api.Customize_iRadio_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();
				
				if (!control.container.hasClass('applied_iradio')) {
					control.container.addClass('applied_iradio');

					control.container.find('input.responsi-ui-iradio').each(function(i) {

						var checked_label = _wpCustomIRadioControl.onoff.checked_label,
							unchecked_label = _wpCustomIRadioControl.onoff.unchecked_label,
							container_width = parseFloat(_wpCustomIRadioControl.onoff.container_width),
							input_name = $(this).attr('name'),
							current_item = $(this);

						current_item.iphoneStyle({
							duration: 50,
							resizeContainer: true,
							customWidth: true,
							containerWidth: container_width,
							resizeHandle: false,
							handleMargin: 10,
							handleRadius: 5,
							containerRadius: 0,
							checkedLabel: checked_label,
							uncheckedLabel: unchecked_label,
							onChange: function(elem, value) {
								var status = value.toString();
								if (elem.prop('checked')) {
									$('input[name="' + input_name + '"]').not(current_item).prop('checked', false ).removeAttr('checkbox-disabled').iphoneStyle("refresh");
									if( null !== control.setting ){
										control.setting.set(current_item.val());
									}
								}
								$('input[name="' + input_name + '"]').trigger("responsi-ui-iradio-switch", [elem, status]);
							},
							onEnd: function(elem, value) {
								var status = value.toString();
								if (elem.prop('checked')) {
									$('input[name="' + input_name + '"]').not(current_item).removeAttr('checkbox-disabled');
									$(current_item).attr('checkbox-disabled', 'true');
								}
								$('input[name="' + input_name + '"]').trigger("responsi-ui-iradio-switch-end", [elem, status]);
							}
						});

					});

				}
			});
		}
	});

	api.Customize_Slider_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var ui_slide = control.container.find('.ui-slide'),
					ui_slide_input = control.container.find('.islide-value'),
					min = parseFloat(control.params.min),
					max = parseFloat(control.params.max),
					step = parseFloat(control.params.step),
					value = parseFloat(control.params.value);

				if (!control.container.hasClass('applied_slider')) {
					control.container.addClass('applied_slider');

					ui_slide.slider({
						isRTL: true,
						range: "min",
						min: min,
						max: max,
						value: value,
						step: step,
						slide: function(event, ui) {
							ui_slide_input.val(ui.value).trigger('keyup');
						},
						change: function(event, ui) {
							if( 'undefined' !== typeof control.settings[control.id] ){
								control.settings[control.id].set(ui.value);
							} else {
								if( null !== control.setting ){
									control.setting.set(ui.value);
								}
							}
						}
					});
				}
			});
		}
	});

	api.Customize_iBackground_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var picker,
					onoff_switcher = control.container.find('.responsi-ibackground-onoff'),
					onoff_checked_value = _wpCustomiBackgroundControl.onoff.checked_value,
					onoff_unchecked_value = _wpCustomiBackgroundControl.onoff.unchecked_value,
					onoff_checked_label = _wpCustomiBackgroundControl.onoff.checked_label,
					onoff_unchecked_label = _wpCustomiBackgroundControl.onoff.unchecked_label,
					onoff_container_width = parseFloat(_wpCustomiBackgroundControl.onoff.container_width),
					onoff_value = control.params.values.onoff;

				
				
				if (!control.container.hasClass('applied_ibackground')) {
					control.container.addClass('applied_ibackground');

					if (onoff_value == onoff_checked_value) {
						control.container.find('.responsi-ibackground-container').show();
					} else {
						control.container.find('.responsi-ibackground-container').hide();
					}

					// OnOff Switcher
					onoff_switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
						customWidth: true,
						containerWidth: onoff_container_width,
						resizeHandle: false,
						handleMargin: 10,
						handleRadius: 5,
						containerRadius: 0,
						checkedLabel: onoff_checked_label,
						uncheckedLabel: onoff_unchecked_label,
						onChange: function(elem, value) {
							var status = value.toString();
							if (elem.prop('checked')) {
								var val = onoff_checked_value;
								control.container.find('.responsi-ibackground-container').show();
							} else {
								var val = onoff_unchecked_value;
								control.container.find('.responsi-ibackground-container').hide();
							}
							if( 'undefined' !== typeof control.settings[control.id + '[onoff]'] ){
								control.settings[control.id + '[onoff]'].set(val);
							}
							onoff_switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							onoff_switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
						}
					});

					// Color Picker
					picker = control.container.find( '.color-picker-hex' );
					picker.val( control.params.values.color ).wpColorPicker({
						change: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( picker.wpColorPicker( 'color' ) );
							}
							updating = false;
						},
						clear: function() {
							updating = true;
							if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
								control.settings[control.id + '[color]'].set( '' );
							}
							updating = false;
						}
					});
		
					if( 'undefined' !== typeof control.settings[control.id + '[color]'] ){
						control.settings[control.id + '[color]'].bind( function ( value ) {
							// Bail if the update came from the control itself.
							if ( updating ) {
								return;
							}
							picker.val( value );
							picker.wpColorPicker( 'color', value );
						} );
					}

					// Collapse color picker when hitting Esc instead of collapsing the current section.
					control.container.on( 'keydown', function( event ) {
						var pickerContainer;
						if ( 27 !== event.which ) { // Esc.
							return;
						}
						pickerContainer = control.container.find( '.wp-picker-container' );
						if ( pickerContainer.hasClass( 'wp-picker-active' ) ) {
							picker.wpColorPicker( 'close' );
							control.container.find( '.wp-color-result' ).trigger('focus');
							event.stopPropagation();
						}
					} );

				}
			});
		}
	});

	api.Customize_iColor_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this ),
				picker,
				isHueSlider = this.params.mode === 'hue',
				updating = false,color;

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				if (!control.container.hasClass('applied_icolor')) {

					control.container.addClass('applied_icolor');

					// Color Picker
					if ( isHueSlider ) {
						color = 250;
						if( null !== control.setting ){
							color = control.setting();
						}
						picker = control.container.find( '.color-picker-hue' );
						picker.val( color ).wpColorPicker({
							change: function( event, ui ) {
								updating = true;
								if( null !== control.setting ){
									control.setting( ui.color.h() );
								}
								updating = false;
							}
						});
					} else {
						color = '#RRGGBB';
						if( null !== control.setting ){
							color = control.setting();
						}
						picker = control.container.find( '.color-picker-hex' );
						picker.val( color ).wpColorPicker({
							change: function() {
								updating = true;
								if( null !== control.setting ){
									control.setting.set( picker.wpColorPicker( 'color' ) );
								}
								updating = false;
							},
							clear: function() {
								updating = true;
								if( null !== control.setting ){
									control.setting.set( '' );
								}
								updating = false;
							}
						});
					}

					if( null !== control.setting ){
						control.setting.bind( function ( value ) {
							// Bail if the update came from the control itself.
							if ( updating ) {
								return;
							}
							picker.val( value );
							picker.wpColorPicker( 'color', value );
						} );
					}

					// Collapse color picker when hitting Esc instead of collapsing the current section.
					control.container.on( 'keydown', function( event ) {
						var pickerContainer;
						if ( 27 !== event.which ) { // Esc.
							return;
						}
						pickerContainer = control.container.find( '.wp-picker-container' );
						if ( pickerContainer.hasClass( 'wp-picker-active' ) ) {
							picker.wpColorPicker( 'close' );
							control.container.find( '.wp-color-result' ).trigger('focus');
							event.stopPropagation(); // Prevent section from being collapsed.
						}
					} );

				}
			});
		}
	});

	api.Customize_iSelect_Control = api.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('select.responsi-iselect').on('change', function( event ) {
				if( null !== control.setting ){
					control.setting.set($(this).val());
				}
			});
		}
	});

	api.Customize_iText_Control = api.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('input.responsi-itext').on('change keyup', function( event ) {
				if( null !== control.setting ){
					control.setting.set($(this).val());
				}
			});
		}
	});

	api.Customize_iTextarea_Control = api.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('textarea.responsi-itextarea').on('change keyup', function( event ) {
				if( null !== control.setting ){
					control.setting.set($(this).val());
				}
			});
		}
	});

	api.Customize_Multiple_Text_Control = api.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('input.responsi-multitext').on('change keyup', function( event ) {
				var setting_id = $(this).data('setting-link');
				if( 'undefined' !== typeof control.settings[setting_id] ){
					control.settings[setting_id].set($(this).val());
				}
			});
		}
	});

	api.Customize_Background_Patterns_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			control.container.find('span.bp-item').on('click', function( event ) {
				$(this).siblings('span.bp-item').removeClass('bg-selected');
				$(this).addClass('bg-selected');
			});

			control.container.find('input.bp-radio').on('change', function( event ) {
				if( null !== control.setting ){
					control.setting.set($(this).val());
				}
			});

			
			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();
				if (!control.container.hasClass('applied_background_patterns')) {
					control.container.addClass('applied_background_patterns');

					var i = 0;
					_.each(_wpCustomBackgroundPatternsControl.backgrounds, function(val, key) {
						i++;
						control.container.find('.bp-item-' + i).attr('style', 'background:#fff url(' + _wpCustomBackgroundPatternsControl.bg_url + '/backgrounds/' + val + ')');
					});

					_.each(_wpCustomBackgroundPatternsControl.patterns, function(val, key) {
						i++;
						control.container.find('.bp-item-' + i).attr('style', 'background:#fff url(' + _wpCustomBackgroundPatternsControl.bg_url + '/patterns/' + val + ')');
					});

				}
			});
		}
	});

	api.Customize_Column_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );
			
			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				//var column_val = control.params.values.col;
				var column_val = control.container.find('.column-item input[type="radio"]:checked').val();

				control.container.find('.column-item-input input[type="number"]').addClass('hide-col-inp');

				_.each(control.params.choices, function(val, key) {

					if( column_val != 1 ){
						if( column_val >= key ){
							control.container.find('.column-item-input input[type="number"].column-input-'+key ).removeClass('hide-col-inp');
						}
					}
					
				});

				if (!control.container.hasClass('applied_column')) {
					control.container.addClass('applied_column');

					control.container.find('img.responsi-radio-img-img').each( function( index ) {
						$(this).attr( 'src', $(this).data( 'src' ) );
					});

					control.container.find('img.responsi-radio-img-img').on('click', function( event ) {
						$(this).parent('.column-item').siblings('.column-item').children('img.responsi-radio-img-img').removeClass('responsi-radio-img-selected');
						$(this).addClass('responsi-radio-img-selected');
						column_val = $(this).data('value');

						control.container.find('.column-item-input').attr('class', 'column-item-input column-item-input'+column_val);
						
						_.each(control.params.choices, function(val, key) {

							if( column_val != 1 ){
								if( column_val >= key ){
									control.container.find('.column-item-input input[type="number"].column-input-'+key ).removeClass('hide-col-inp');
								}else{
									control.container.find('.column-item-input input[type="number"].column-input-'+key ).addClass('hide-col-inp');
								}
							}else{
								control.container.find('.column-item-input input[type="number"].responsi-input-input').addClass('hide-col-inp');
							}

						});

					});

					control.container.find('input.responsi-radio-img-radio').on('change', function( event ) {

						var col = $(this).val();

						if( control.params.validate && control.params.validate_col){

							if( col == 1 ){
								//control.settings[control.id + '[col1]'].set('100');
								control.container.find('.column-item-input input[type="number"].column-input-1' ).val(100).trigger('change');
							}

							if( col == 2 ){
								//control.settings[control.id + '[col1]'].set('50');
								control.container.find('.column-item-input input[type="number"].column-input-1' ).val(50).trigger('change');
								//control.settings[control.id + '[col2]'].set('50');
								control.container.find('.column-item-input input[type="number"].column-input-2' ).val(50).trigger('change');
							}

							if( col == 3 ){
								//control.settings[control.id + '[col1]'].set('33');
								control.container.find('.column-item-input input[type="number"].column-input-1' ).val(33).trigger('change');
								//control.settings[control.id + '[col2]'].set('34');
								control.container.find('.column-item-input input[type="number"].column-input-2' ).val(34).trigger('change');
								//control.settings[control.id + '[col3]'].set('33');
								control.container.find('.column-item-input input[type="number"].column-input-3' ).val(33).trigger('change');
							}

							if( col == 4 ){
								//control.settings[control.id + '[col1]'].set('25');
								control.container.find('.column-item-input input[type="number"].column-input-1' ).val(25).trigger('change');
								//control.settings[control.id + '[col2]'].set('25');
								control.container.find('.column-item-input input[type="number"].column-input-2' ).val(25).trigger('change');
								//control.settings[control.id + '[col3]'].set('25');
								control.container.find('.column-item-input input[type="number"].column-input-3' ).val(25).trigger('change');
								//control.settings[control.id + '[col4]'].set('25');
								control.container.find('.column-item-input input[type="number"].column-input-4' ).val(25).trigger('change');
							}

							if( col == 5 ){
								//control.settings[control.id + '[col1]'].set('20');
								control.container.find('.column-item-input input[type="number"].column-input-1' ).val(20).trigger('change');
								//control.settings[control.id + '[col2]'].set('20');
								control.container.find('.column-item-input input[type="number"].column-input-2' ).val(20).trigger('change');
								//control.settings[control.id + '[col3]'].set('20');
								control.container.find('.column-item-input input[type="number"].column-input-3' ).val(20).trigger('change');
								//control.settings[control.id + '[col4]'].set('20');
								control.container.find('.column-item-input input[type="number"].column-input-4' ).val(20).trigger('change');
								//control.settings[control.id + '[col5]'].set('20');
								control.container.find('.column-item-input input[type="number"].column-input-5' ).val(20).trigger('change');
							}

							if( col == 6 ){
								//control.settings[control.id + '[col1]'].set('16.6666666');
								control.container.find('.column-item-input input[type="number"].column-input-1' ).val(16.6666666).trigger('change');
								//control.settings[control.id + '[col2]'].set('16.6666666');
								control.container.find('.column-item-input input[type="number"].column-input-2' ).val(16.6666666).trigger('change');
								//control.settings[control.id + '[col3]'].set('16.6666666');
								control.container.find('.column-item-input input[type="number"].column-input-3' ).val(16.6666666).trigger('change');
								//control.settings[control.id + '[col4]'].set('16.6666666');
								control.container.find('.column-item-input input[type="number"].column-input-4' ).val(16.6666666).trigger('change');
								//control.settings[control.id + '[col5]'].set('16.6666666');
								control.container.find('.column-item-input input[type="number"].column-input-5' ).val(16.6666666).trigger('change');
								//control.settings[control.id + '[col6]'].set('16.6666666');
								control.container.find('.column-item-input input[type="number"].column-input-6' ).val(16.6666666).trigger('change');
							}

						}

						control.settings[control.id + '[col]'].set(col);

					});

					if( control.params.validate ){

						var total,
						totalCol,
						
						min,
						max,

						current_id,
						current_new_value,

						next_id,
						next_new_value;

						control.container.find('.responsi-input-input').on('change keyup', function( event ) {

							totalCol = control.container.find('.column-item input[type="radio"]:checked').val();
							current_id = $(this).data('id');

							if( totalCol == current_id ){
								next_id = $(this).prev().data('id');
							}else{
								next_id = $(this).next().data('id');
							}

							current_new_value = $(this).val();

							min = 1;
							max = 100;

							if( totalCol >= 1 ){
								
								for (var i = 1; i <= totalCol; i++) {
									if( i != current_id && i != next_id ){
										max = max - parseFloat(control.container.find('.column-input-'+i).val() );
									}
								}
								
							}

							next_new_value = max - current_new_value;

							total = parseFloat(next_new_value) + parseFloat(current_new_value);

							if( current_new_value >= 1 && next_new_value >= 1 && total <= max ){
								control.container.find('.column-input-'+next_id).val(next_new_value);
								control.settings[control.id + '[col'+next_id+']'].set(next_new_value);
								control.settings[control.id + '[col'+current_id+']'].set(current_new_value);
							}else{
								control.container.find('.column-input-'+current_id).val(control.settings[control.id + '[col'+current_id+']'].get('value'));
							}
							
						});

					}else{
						control.container.find('.responsi-input-input').on('change keyup', function( event ) {
							var key = $(this).data('id');
							control.settings[control.id + '[col'+key+']'].set($(this).val());
						});
					}

				}

				

			});

		}

	});

	api.Customize_Layout_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );
			
			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				if (!control.container.hasClass('applied_layout')) {
					control.container.addClass('applied_layout');

					control.container.find('img.responsi-radio-img-img').each( function( index ) {
						$(this).attr( 'src', $(this).data( 'src' ) );
					});

					control.container.find('img.responsi-radio-img-img').on('click', function( event ) {
						$(this).parent('.layout-item').siblings('.layout-item').children('img.responsi-radio-img-img').removeClass('responsi-radio-img-selected');
						$(this).addClass('responsi-radio-img-selected');
						var layout_val = $(this).data('value');
						control.logicLayout($(this), layout_val);
						control.logicLayoutThumbnail($(this), layout_val);
					});

					control.container.find('input.responsi-radio-img-radio').on('change', function( event ) {
						if( null !== control.setting ){
							control.setting.set($(this).val());
						}
					});

				}

			});

		},
		logicLayout: function(obj, layout) {
			if (layout == 'one-col') {
				obj.parent().parent().parent('.layout-logic').siblings('.layout-content-logic').find('img').each(function() {
					$(this).show();
				});
			}
			if (layout == 'two-col-left' || layout == 'two-col-right') {
				obj.parent().parent().parent('.layout-logic').siblings('.layout-content-logic').find('img').each(function() {
					if ($(this).data('value') == 6) {
						$(this).hide();
					} else {
						$(this).show();
					}
					if ($(this).hasClass('responsi-radio-img-selected') && $(this).data('value') == 6) {
						$(this).parent('.layout-item').siblings('.layout-item-5').find('img').trigger( 'click' );
					}
				});
			}
			if (layout == 'three-col-left' || layout == 'three-col-middle' || layout == 'three-col-right') {
				obj.parent().parent().parent('.layout-logic').siblings('.layout-content-logic').find('img').each(function() {
					if ($(this).data('value') == 5 || $(this).data('value') == 6) {
						$(this).hide();
					} else {
						$(this).show();
					}
					if ($(this).hasClass('responsi-radio-img-selected') && $(this).data('value') >= 5) {
						$(this).parent('.layout-item').siblings('.layout-item-4').find('img').trigger( 'click' );
					}
				});
			}
		},
		logicLayoutThumbnail: function(obj, layout) {
			if (layout == 'top') {
				obj.parent().parent().parent('.post-thumb-type').siblings('.for-post-thumb-type').addClass('hide');
			} else {
				obj.parent().parent().parent('.post-thumb-type').siblings('.for-post-thumb-type').removeClass('hide');
			}
		}

	});

	api.Customize_iEditor_Control = api.Control.extend({

		currentContentId: '',

		/**
		 * @var string
		 */
		currentEditorPage: '',

		/**
		 * @var int
		 */
		wpFullOverlayOriginalZIndex: 0,

		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );
			
			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				if (!control.container.hasClass('applied_editor')) {
					control.container.addClass('applied_editor');

					_.bindAll(control, 'openFrame', 'hideEditor');

					control.container.on('click keydown', 'button.show-editor-button', control.openFrame);

					$('a.close-editor-button').on('click keydown', function( event ) {
						control.hideEditor();
						return false;
					});

					$(document).on('click keydown', '.update-editor-button[data-id="' + control.id + '"]', function( event ) {
						control.updateAndCloseEditor(control);
						return false;
					});

					if( null !== control.setting ){
						control.setting.bind(function() {
							control.renderContent();
						});
					}
				}

			});
		},

		openFrame: function(event) {
			if (api.utils.isKeydownButNotEnterEvent(event)) {
				return;
			}

			event.preventDefault();

			if (!this.frame) {
				this.initFrame();
			}
		},
		/**
		 * Create a media modal select frame, and store it so the instance can be reused when needed.
		 */
		initFrame: function() {
			var control = this;
			this.frame = this.showEditor(control, control.id);
		},

		showEditor: function(control, contentId) {
			$('#wp-editor-customize-backdrop').show();
			$('#wp-editor-customize-container').show();

			this.currentContentId = contentId;
			this.currentEditorPage = ($('body').hasClass('wp-customizer') ? 'wp-customizer' : '');

			if (this.currentEditorPage == "wp-customizer") {
				this.wpFullOverlayOriginalZIndex = parseFloat($('.wp-full-overlay').css('zIndex'));
				$('.wp-full-overlay').css({
					zIndex: 49000
				});
			}

			this.setEditorContent(control, contentId);
		},

		setEditorContent: function(control, contentId) {
			var editor = tinyMCE.EditorManager.get('wpeditorcustomize');
			var content = '';
			if( null !== control.setting ){
				content = control.setting._value;
			}

			content = content.replace('<frameeditor','<iframe').replace('/frameeditor>','/iframe>');

			$('#wpeditor_customize_title').html(control.params.label);
			$('a.update-editor-button').attr('data-id', control.id);
			if ($('#wp-wpeditorcustomize-wrap').hasClass('html-active')) {
				content = switchEditors.pre_wpautop(content);
			} else {
				content = switchEditors.wpautop(content);
			}
			$('#wpeditorcustomize').val(content);
			if (typeof editor == "object" && editor !== null) {
				editor.setContent(content);
			}
		},

		/**
		 * Update widget and close the editor
		 */
		updateAndCloseEditor: function(control) {

			var editor = tinyMCE.EditorManager.get('wpeditorcustomize');
			if (typeof editor == "undefined" || editor == null || editor.isHidden()) {
				var content = $('#wpeditorcustomize').val();
			} else {
				var content = editor.getContent();
			}
			if( null !== control.setting ){
				control.setting.set(content.replace('<iframe', '<frameeditor').replace('/iframe>','/frameeditor>'));
			}
			this.hideEditor();
		},

		/**
		 * Hide editor
		 */
		hideEditor: function() {
			$('#wp-editor-customize-backdrop').hide();
			$('#wp-editor-customize-container').hide();

			if (this.currentEditorPage == "wp-customizer") {
				$('.wp-full-overlay').css({
					zIndex: this.wpFullOverlayOriginalZIndex
				});
			}
		},

	});

	api.Customize_Animation_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var type_select = control.container.find('select.responsi-animation-type'),
				direction_select = control.container.find('select.responsi-animation-direction'),
				
				min_duration = parseFloat(_wpCustomAnimationControl.duration.min),
				max_duration = parseFloat(_wpCustomAnimationControl.duration.max),
				step_duration = parseFloat(_wpCustomAnimationControl.duration.step),
				ui_slide_input_duration = control.container.find('.islide-value-duration'),
				ui_slide_duration = control.container.find('.ui-slide-duration'),

				min_delay = parseFloat(_wpCustomAnimationControl.delay.min),
				max_delay = parseFloat(_wpCustomAnimationControl.delay.max),
				step_delay = parseFloat(_wpCustomAnimationControl.delay.step),
				ui_slide_input_delay = control.container.find('.islide-value-delay'),
				ui_slide_delay = control.container.find('.ui-slide-delay'),
				
				type = control.params.values.type,
				direction = control.params.values.direction,
				duration = parseFloat(control.params.values.duration),
				delay = parseFloat(control.params.values.delay);

				if (!control.container.hasClass('applied_animation')) {
					control.container.addClass('applied_animation');

					if (type !== 'none') {
						control.container.find('.animation-inner-container').show();
					} else {
						control.container.find('.animation-inner-container').hide();
					}

					if ( type === 'bounce' || type === 'fade' || type === 'slide'  || type === 'zoom' ) {
						control.container.find('.responsi-direction-container').show();
					}else{
						control.container.find('.responsi-direction-container').hide();
					}

					_.each(_wpCustomAnimationControl.type, function(type, index) {
						type_selected = '';

						if (index == control.params.values.type) {
							type_selected = 'selected="select"';
						}
						
						type_select.append('<option value="' + index + '" ' + type_selected + '>' + type + '</option>');
					});

					_.each(_wpCustomAnimationControl.direction, function(direction, index) {
						var direction_selected = '',
						disable_option = '';
						
						if ( type === 'slide' && index == '' ) {
							disable_option = 'disabled="true"';
							if( control.params.values.direction == '' ){
								control.settings[control.id + '[direction]'].set('left');
								control.params.values.direction = 'left';
							}
						}

						if (index == control.params.values.direction) {
							direction_selected = 'selected="select"';
						}

						direction_select.append('<option value="' + index + '" ' + direction_selected + ' ' + disable_option + '>' + direction + '</option>');
					});

					type_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[type]'] ){

							var change_value = $(this).val();

							if ( change_value === 'slide' ) {

								direction_select.find('option[value=""]').attr('disabled','true').prop('selected', false );

								if( control.params.values.direction == '' ){
									control.settings[control.id + '[direction]'].set('left');
									control.params.values.direction = 'left';
								}
							
							}else{
								direction_select.find('option[value=""]').prop('disabled', false );
							}

							if (change_value !== 'none' ) {
								control.container.find('.animation-inner-container').show();
							} else {
								control.container.find('.animation-inner-container').hide();
							}

							if ( change_value === 'bounce' || change_value === 'fade' || change_value === 'slide'  || change_value === 'zoom' ) {
								control.container.find('.responsi-direction-container').show();
							}else{
								control.container.find('.responsi-direction-container').hide();
							}

							control.settings[control.id + '[type]'].set(change_value);
						}
					});

					direction_select.on('change', function( event ) {
						if( 'undefined' !== typeof control.settings[control.id + '[direction]'] ){
							control.settings[control.id + '[direction]'].set($(this).val());
						}
					});

					ui_slide_duration.slider({
						isRTL: true,
						range: "min",
						min: min_duration,
						max: max_duration,
						value: duration,
						step: step_duration,
						slide: function(event, ui) {
							ui_slide_input_duration.val(ui.value).trigger('keyup');
						},
						change: function(event, ui) {
							if( 'undefined' !== typeof control.settings[control.id + '[duration]'] ){
								control.settings[control.id + '[duration]'].set(ui.value);
							}
						}
					});

					ui_slide_delay.slider({
						isRTL: true,
						range: "min",
						min: min_delay,
						max: max_delay,
						value: delay,
						step: step_delay,
						slide: function(event, ui) {
							ui_slide_input_delay.val(ui.value).trigger('keyup');
						},
						change: function(event, ui) {
							if( 'undefined' !== typeof control.settings[control.id + '[delay]'] ){
								control.settings[control.id + '[delay]'].set(ui.value);
							}
						}
					});

				}
			});
		}
	});

	api.Customize_iUpload_Control = api.ImageControl.extend({

		select: function() {
			// Get the attachment from the modal frame.
			var node,
				attachment = this.frame.state().get( 'selection' ).first().toJSON(),
				mejsSettings = window._wpmejsSettings || {};

			this.params.attachment = attachment;

			// Set the Customizer setting; the callback takes care of rendering.

			this.setting( attachment.url );

			node = this.container.find( 'audio, video' ).get(0);

			// Initialize audio/video previews.
			if ( node ) {
				this.player = new MediaElementPlayer( node, mejsSettings );
			} else {
				this.cleanupPlayer();
			}
		},

		// @deprecated
		success: function() {},

		// @deprecated
		removerVisibility: function() {}

	});

	api.Customize_iUploadCrop_Control = api.CroppedImageControl.extend({});

	api.bind( 'ready', function() {
		
	})( jQuery );

	$(window).on( 'load', function() {

		/*wp.customize.control.add( new wp.customize.DateTimeControl( 'special_datetime', {
		    label: 'Special Datetime',
		    description: 'There are incrementing digits in this datetime!',
		    section: 'custom_css',
		    includeTime: true,
		    twelveHourFormat: false,
		    allowPastDate: true,
		    setting: new wp.customize.Value( '2018-02-03 13:57' )
		} ) );

		wp.customize.control.add( new wp.customize.Customize_Border_Boxes_Control( 'border_boxes_control', {
		    section 	: 'custom_css',
		    label 		: 'Border Boxes Control',
		    type 		: 'border_boxes',
		    setting_id 	: 'border_boxes_control',
		    //setting: new wp.customize.Values({width : '1', style : 'solid', color : '#ffffff', corner : 'square', topleft : '0', topright : '0', bottomright : '0', bottomleft : '0'}),
		    // settings    : { 'border_control[width]' : 'border_control[width]', 'border_control[style]' : 'border_control[style]', 'border_control[color]' : 'border_control[color]', 'border_control[corner]' : 'border_control[corner]', 'border_control[topleft]' : 'border_control[topleft]', 'border_control[topright]' : 'border_control[topright]', 'border_control[bottomright]' : 'border_control[bottomright]', 'border_control[bottomleft]' : 'border_control[bottomleft]' },
		    values: { width : '1', style : 'solid', color : '#000000', corner : 'square', topleft : '10', topright : '10', bottomright : '10', bottomleft : '10' }
		} ) );*/

		/*var control = new api.Customize_Border_Boxes_Control( 'border_boxes_control', {
		    section 	: 'custom_css',
		    label 		: 'Border Boxes Control',
		    type 		: 'border_boxes',
		    //setting_id 	: 'border_boxes_control',
		    setting: new wp.customize.Values({width : '1', style : 'solid', color : '#ffffff', corner : 'square', topleft : '0', topright : '0', bottomright : '0', bottomleft : '0'}),
		    settings    : { 'border_control[width]' : 'border_control[width]', 'border_control[style]' : 'border_control[style]', 'border_control[color]' : 'border_control[color]', 'border_control[corner]' : 'border_control[corner]', 'border_control[topleft]' : 'border_control[topleft]', 'border_control[topright]' : 'border_control[topright]', 'border_control[bottomright]' : 'border_control[bottomright]', 'border_control[bottomleft]' : 'border_control[bottomleft]' },
		    values: { width : '1', style : 'solid', color : '#000000', corner : 'square', topleft : '10', topright : '10', bottomright : '10', bottomleft : '10' }
		} );*/

		/*
		var control = new api.Customize_Background_Patterns_Control( 'background_patterns_control', {
		    section 	: 'custom_css',
		    label 		: 'Background Patterns Control',
		    type 		: 'background_patterns',
		    setting_id 	: 'border_control',
		    //setting 	: new wp.customize.Value('http://localhost/responsi/wp-content/plugins/responsi-backgrounds-addon/picker/backgrounds/foggy_birds.jpg'),
		    //settings    : { default : 'background_patterns_control' },
		} );

		var control = new api.Customize_Border_Control( 'border_control', {
		    section 	: 'custom_css',
		    label 		: 'Border Control',
		    type 		: 'border',
		    setting_id 	: 'border_control',
		    //setting: new wp.customize.Values({width : '1', style : 'solid', color : '#ffffff'}),
		    //settings    : { 'border_control[width]' : 'border_control[width]', 'border_control[style]' : 'border_control[style]', 'border_control[color]' : 'border_control[color]' },
		    //values: { width : '1', style : 'solid', color : '#000000' }
		} );

		var control = new api.Customize_Border_Radius_Control( 'border_radius_control', {
		    section 	: 'custom_css',
		    label 		: 'Border Radius Control',
		    type 		: 'border_radius',
		    setting_id 	: 'border_radius_control',
		    //setting: new wp.customize.Values({width : '1', style : 'solid', color : '#ffffff'}),
		    //settings    : { 'border_radius_control[corner]' : 'border_radius_control[corner]', 'border_radius_control[rounded_value]' : 'border_radius_control[rounded_value]'},
		    //values: {'corner': 'square', 'rounded_value': '0'};
		} );

		var control = new api.Customize_Border_Boxes_Control( 'border_boxes_control', {
		    section 	: 'custom_css',
		    label 		: 'Border Boxes Control',
		    type 		: 'border_boxes',
		    setting_id 	: 'border_boxes_control',
		    //setting: new wp.customize.Values({width : '1', style : 'solid', color : '#ffffff'}),
		    //settings    : { 'border_control[width]' : 'border_control[width]', 'border_control[style]' : 'border_control[style]', 'border_control[color]' : 'border_control[color]' },
		    //values: { width : '1', style : 'solid', color : '#000000' }
		} );

		var control = new api.Customize_BoxShadow_Control( 'box_shadow_control', {
		    section 	: 'custom_css',
		    label 		: 'Boxshadow Control',
		    type 		: 'box_shadow',
		    setting_id 	: 'box_shadow_control',
		    //setting: new wp.customize.Values({'onoff':'false' , 'h_shadow':'0px' , 'v_shadow':'0px', 'blur':'8px' , 'spread':'0px', 'color':'#DBDBDB', 'inset':''}),
		    //settings    : { 'box_shadow_control[onoff]' : 'box_shadow_control[onoff]', 'box_shadow_control[h_shadow]' : 'box_shadow_control[h_shadow]', 'box_shadow_control[v_shadow]' : 'box_shadow_control[v_shadow]', 'box_shadow_control[blur]' : 'box_shadow_control[blur]', 'box_shadow_control[spread]' : 'box_shadow_control[spread]', 'box_shadow_control[color]' : 'box_shadow_control[color]', 'box_shadow_control[inset]' : 'box_shadow_control[inset]'},
		    //values: {'onoff':'false' , 'h_shadow':'0px' , 'v_shadow':'0px', 'blur':'8px' , 'spread':'0px', 'color':'#DBDBDB', 'inset':''};
		} );

		var control = new api.Customize_iBackground_Control( 'ibackground_control', {
		    section 	: 'custom_css',
		    label 		: 'iBackground Control',
		    type 		: 'ibackground',
		    setting_id 	: 'ibackground_control',
		    //setting: new wp.customize.Values({onoff : 'false', color : '#ffffff'}),
		    //settings    : { 'ibackground_control[onoff]' : 'ibackground_control[onoff]', 'ibackground_control[color]' : 'ibackground_control[color]'},
		    //values: {onoff : 'false', color : '#ffffff'};
		} );

		var control = new api.Customize_iCheckbox_Control( 'icheckbox_control', {
		    section 	: 'custom_css',
		    label 		: 'iCheckox Control',
		    type 		: 'icheckbox',
		    setting_id 	: 'icheckbox_control',
		    //setting 	: new wp.customize.Value('true'),
		    //settings    : { default : 'icheckbox_control' },
		} );

		var control = new api.Customize_iColor_Control( 'icolor_control', {
		    section: 'custom_css',
		    label: 'iColor',
		    type: 'icolor',
		    setting_id 	: 'icolor_control',
		    //mode: 'hue',
		    //settings: { 'default': 'icolor_control' },
		} );

		var control = new api.Customize_iColor_Control( 'icolor_hue_control', {
		    section: 'custom_css',
		    label: 'iColor Hue',
		    type: 'icolor',
		    setting_id 	: 'icolor_hue_control',
		    mode: 'hue',
		    //settings: { 'default': 'icolor_hue_control' },
		} );

		var control = new api.Customize_iEditor_Control( 'ieditor_control', {
		    section: 'custom_css',
		    label: 'iEditor',
		    type: 'ieditor',
		    setting_id 	: 'ieditor_control',
		    //settings: { 'default': 'ieditor_control' },
		} );

		var control = new api.Control( 'ilabel_control', {
		    section: 'custom_css',
		    label: 'iLabel',
		    type: 'ilabel'
		} );

		var control = new api.Customize_iMultiCheckbox_Control( 'imulticheckbox_control', {
		    section: 'custom_css',
		    label: 'iMulticheckbox',
		    type: 'imulticheckbox',
		    choices : { "1":"Checkbox 1","2":"Checkbox 2" },
		    defaultValue : [ "true", "false" ],
		    setting_id 	: 'imulticheckbox_control',
		    //settings: { 'default': 'imulticheckbox_control' },
		} );

		var control = new api.Customize_iRadio_Control( 'iradio_control', {
		    section: 'custom_css',
		    label: 'iRadio',
		    type: 'iradio',
		    choices : { "1":"Radio 1","2":"Radio 2" },
		    value : '1',
		    setting_id 	: 'iradio_control',
		    //settings: { 'default': 'iradio_control' },
		} );

		var control = new api.Customize_iSelect_Control( 'iselect_control', {
		    section: 'custom_css',
		    label: 'iSelect',
		    type: 'iselect',
		    choices : { "1":"Select 1","2":"Select 2" },
		    value : '1',
		    setting_id 	: 'iselect_control',
		    input_attrs : { 'min':1,"step":1,"max":2 }
		    //settings: { 'default': 'iselect_control' },
		} );

		var control = new api.Customize_iCheckbox_Control( 'iswitcher_control', {
		    section 	: 'custom_css',
		    label 		: 'iSwitcher Control',
		    type 		: 'iswitcher',
		    setting_id 	: 'iswitcher_control',
		    checked_value:'enable',
		    unchecked_value:'disable',
		    checked_label:'Enable',
		    unchecked_label:'Disable',
		    container_width:115
		    //setting 	: new wp.customize.Value('true'),
		    //settings    : { default : 'iswitcher_control' },
		} );

		var control = new api.Customize_iText_Control( 'itext_control', {
		    section 	: 'custom_css',
		    label 		: 'itext Control',
		    type 		: 'itext',
		    setting_id 	: 'itext_control',
		    value 		: 250,
		    //setting 	: new wp.customize.Value('250'),
		    //settings    : { default : 'itext_control' },
		} );

		var control = new api.Customize_iTextarea_Control( 'itextarea_control', {
		    section 	: 'custom_css',
		    label 		: 'iTextarea Control',
		    type 		: 'itextarea',
		    setting_id 	: 'itextarea_control',
		    value 		: "Textarea",
		    //setting 	: new wp.customize.Value('250'),
		    //settings    : { default : 'itextarea_control' },
		} );

		var control = new api.Customize_iUpload_Control( 'iupload_control', {
		    section 	: 'custom_css',
		    label 		: 'iUpload Control',
		    type 		: 'iupload',
		    setting_id 	: 'iupload_control',
		    setting 	: new wp.customize.Value(''),
		    canUpload 	: 'Remove', 
		    //settings    : { default : 'iupload_control' },
		} );

		var control = new api.Customize_iUploadCrop_Control( 'iuploadcrop_control', {
		    section 	: 'custom_css',
		    label 		: 'iUploadcrop Control',
		    type 		: 'iuploadcrop',
		    setting_id 	: 'iuploadcrop_control',
		    canUpload 	: 'Remove', 
		    width 		: 250,
		    height 		: 250,
		    flex_width 	: false,
		    flex_height : false,
		    setting 	: new wp.customize.Value(''),
		   	//settings    : { default : 'iuploadcrop_control' },
		} );

		var control = new api.Customize_Layout_Control( 'layout_control', {
		    section: 'custom_css',
		    label: 'Layout',
		    type: 'layout',
		    choices : { 
				'1' : 'http://localhost/responsi/wp-content/themes/responsi/functions/images/header-widgets-1.png',
				'2' : 'http://localhost/responsi/wp-content/themes/responsi/functions/images/header-widgets-2.png',
				'3' : 'http://localhost/responsi/wp-content/themes/responsi/functions/images/header-widgets-3.png',
				'4' : 'http://localhost/responsi/wp-content/themes/responsi/functions/images/header-widgets-4.png',
				'5' : 'http://localhost/responsi/wp-content/themes/responsi/functions/images/header-widgets-5.png',
				'6' : 'http://localhost/responsi/wp-content/themes/responsi/functions/images/header-widgets-6.png'
		    },
		    value : '1',
		    setting_id 	: 'layout_control',
		    //settings: { 'default': 'layout_control' },
		} );

		var control = new api.Customize_Multiple_Text_Control( 'multitext_control', {
		    section: 'custom_css',
		    label: 'Multi Text Control',
		    type: 'multitext',
		    choices : { 'top':'Top',
					'bottom':'Bottom',
					'left':'Left',
					'right':'Right',},
		    defaultValue : [ 0, 0, 0, 0 ],
		    setting_id 	: 'multitext_control',
		    //settings: { 'default': 'multitext_control' },
		} );

		var control = new api.Customize_Slider_Control( 'slider_control', {
		    section: 'custom_css',
		    label: 'Slider Control',
		    type: 'slider',
			value : '10',
		    'min':1,"step":1,"max":20 ,
		    setting_id 	: 'slider_control',
		    //settings: { 'default': 'slider_control' },
		} );

		$.each( {'size':'13' , 'line_height':'1.4' , 'face':'Open Sans', 'style':'normal' , 'color':'#555555' }, function( id, value){
			var setting = new api.Setting( 'typography_control['+id+']', value, {transport: 'postMessage'} );
			api.add( setting )
		});

		var control = new api.Customize_Typography_Control( 'typography_control', {
		    section 	: 'custom_css',
		    label 		: 'Typography Control',
		    type 		: 'typography',
		    setting_id 	: 'typography_control',
		    //setting: new wp.customize.Values({'size':'13' , 'line_height':'1.4' , 'face':'Open Sans', 'style':'normal' , 'color':'#555555' }),
		    settings    : { 'typography_control[size]' : 'typography_control[size]', 'typography_control[line_height]' : 'typography_control[line_height]', 'typography_control[face]' : 'typography_control[face]', 'typography_control[style]' : 'typography_control[style]', 'typography_control[color]' : 'typography_control[color]'},
		    //values: {'size':'13' , 'line_height':'1.4' , 'face':'Open Sans', 'style':'normal' , 'color':'#555555' };
		} );*/

		setTimeout( function(){
			// Create Controls
			$.each( window._responsiCustomizeSettings.controls, function( id, data ) {
				
				options = _.extend( { params: data }, data ); // Inclusion of params alias is for back-compat for custom controls that expect to augment this property.
				
				var control;
			
				switch( data.type ) {

					case 'animation':
				        control = new api.Customize_Animation_Control( id, options );
				        break;
				    
				    case 'typography':
				        control = new api.Customize_Typography_Control( id, options );
				        break;

				    case 'border':
				        control = new api.Customize_Border_Control( id, options );
				        break;

				    case 'border_radius':
				        control = new api.Customize_Border_Radius_Control( id, options );
				        break;

				    case 'border_boxes':
				        control = new api.Customize_Border_Boxes_Control( id, options );
				        break;

				    case 'box_shadow':
				        control = new api.Customize_BoxShadow_Control( id, options );
				        break;

				    case 'icheckbox':
				        control = new api.Customize_iCheckbox_Control( id, options );
				        break;

				    case 'iswitcher':
				        control = new api.Customize_iCheckbox_Control( id, options );
				        break;

				    case 'imulticheckbox':
				        control = new api.Customize_iMultiCheckbox_Control( id, options );
				        break;

				    case 'iradio':
				        control = new api.Customize_iRadio_Control( id, options );
				        break;

				    case 'slider':
				        control = new api.Customize_Slider_Control( id, options );
				        break;

				    case 'ibackground':
				        control = new api.Customize_iBackground_Control( id, options );
				        break;

				    case 'icolor':
				        control = new api.Customize_iColor_Control( id, options );
				        break;

				    case 'iselect':
				        control = new api.Customize_iSelect_Control( id, options );
				        break;

				    case 'itext':
				        control = new api.Customize_iText_Control( id, options );
				        break;

				    case 'itextarea':
				        control = new api.Customize_iTextarea_Control( id, options );
				        break;

				    case 'multitext':
				        control = new api.Customize_Multiple_Text_Control( id, options );
				        break;

				    case 'background_patterns':
				        control = new api.Customize_Background_Patterns_Control( id, options );
				        break;

				    case 'layout':
				        control = new api.Customize_Layout_Control( id, options );
				        break;

				    case 'column':
				        control = new api.Customize_Column_Control( id, options );
				        break;

				    case 'ieditor':
				        control = new api.Customize_iEditor_Control( id, options );
				        break;

				    case 'iupload':
				        control = new api.Customize_iUpload_Control( id, options );
				        break;

				    case 'iuploadcrop':
				        control = new api.Customize_iUploadCrop_Control( id, options );
				        break;
				    
				    default:
				    	control = new api.Control( id, options );
				    	break;
				}

				wp.customize.control.add( control );

				if( data.notifications && ( data.notifications.type == 'none'
					|| data.notifications.type == 'success'
					|| data.notifications.type == 'info'
					|| data.notifications.type == 'warning'
					|| data.notifications.type == 'error' ) ){

			        var code = 'responsi-notifications-' + data.notifications.type;
			        wp.customize.control( id ).notifications.add( code, new wp.customize.Notification( code, {
			                dismissible: data.notifications.dismissible,
			                message: data.notifications.message,
			                type: data.notifications.type
			        } ) );
				
				}

			});

			$.each(  window._responsiCustomizeSettings.panels, function( id, data ) {
				if( data.notifications && ( data.notifications.type == 'none'
					|| data.notifications.type == 'success'
					|| data.notifications.type == 'info'
					|| data.notifications.type == 'warning'
					|| data.notifications.type == 'error' ) ){

			        var code = 'responsi-notifications-' + data.notifications.type;
			        wp.customize.panel( id ).notifications.add( code, new wp.customize.Notification( code, {
			                dismissible: data.notifications.dismissible,
			                message: data.notifications.message,
			                type: data.notifications.type
			        } ) );
				}
			});

			$.each(  window._responsiCustomizeSettings.sections, function( id, data ) {
				if( data.notifications && ( data.notifications.type == 'none'
					|| data.notifications.type == 'success'
					|| data.notifications.type == 'info'
					|| data.notifications.type == 'warning'
					|| data.notifications.type == 'error' ) ){

			        var code = 'responsi-notifications-' + data.notifications.type;
			        wp.customize.section( id ).notifications.add( code, new wp.customize.Notification( code, {
			                dismissible: data.notifications.dismissible,
			                message: data.notifications.message,
			                type: data.notifications.type
			        } ) );
				}
			});

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
					
					responsiCustomizeBase.setup_ui_unhide_hidden_custom(groupID);
					responsiCustomizeBase.setup_ui_unhide_hidden_custom_sub(groupID);
					responsiCustomizeBase.setup_ui_unhide_hidden(groupID);
					responsiCustomizeBase.setup_ui_unhide_visible(groupID);

					$(this).addClass('controls-added');
				}
			});

			api.trigger( 'responsi-customize-ready' );

		}, 200 );

	});

})(window.wp, jQuery);
