(function(wp, $) {

	var api = wp.customize;

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

				var picker = control.container.find('.color-picker-hex'),
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
					picker.val(control.params.values.color).wpColorPicker({
						change: function() {
							control.settings[control.id + '[color]'].set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.settings[control.id + '[color]'].set('');
						}
					}).bind('change keyup', function( event ) {
						event.preventDefault();
						control.settings[control.id + '[color]'].set($(this).val());
					});

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

				var picker = control.container.find('.color-picker-hex'),
				size_select = control.container.find('select.responsi-border-width'),
				style_select = control.container.find('select.responsi-border-style'),
				size_selected,
				style_selected;

				if (!control.container.hasClass('applied_border')) {
					control.container.addClass('applied_border');

						// Color Picker
					picker.val(control.params.values.color).wpColorPicker({
						change: function() {
							control.settings[control.id + '[color]'].set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.settings[control.id + '[color]'].set('');
						}
					}).bind('change keyup', function( event ) {
						event.preventDefault();
						control.settings[control.id + '[color]'].set($(this).val());
					});
				
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

				}
			});

			

		}
	});

	api.Customize_BorderRadius_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var switcher = control.container.find('.responsi-ui-icheckbox'),
					ui_slide = control.container.find('.ui-slide'),
					ui_slide_input = control.container.find('.islide-value'),
					min = parseInt(_wpCustomBorderRadiusControl.rounded.min),
					max = parseInt(_wpCustomBorderRadiusControl.rounded.max),
					step = parseInt(_wpCustomBorderRadiusControl.rounded.step),
					rounded_value = parseInt(control.params.values.rounded_value),
					checked_value = _wpCustomBorderRadiusControl.corner.checked_value,
					unchecked_value = _wpCustomBorderRadiusControl.corner.unchecked_value,
					checked_label = _wpCustomBorderRadiusControl.corner.checked_label,
					unchecked_label = _wpCustomBorderRadiusControl.corner.unchecked_label,
					container_width = parseInt(_wpCustomBorderRadiusControl.corner.container_width),
					corner_value = control.params.values.corner;

				if (corner_value == checked_value) {
					control.container.find('.responsi-range-slider').show();
				} else {
					control.container.find('.responsi-range-slider').hide();
				}

				if (!control.container.hasClass('applied_border_radius')) {
					control.container.addClass('applied_border_radius');

					// Switcher
					switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
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
							control.settings[control.id + '[corner]'].set(val);
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
							control.settings[control.id + '[rounded_value]'].set(ui.value);
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

				var picker = control.container.find('.color-picker-hex'),
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
					onoff_container_width = parseInt(_wpCustomBoxShadowControl.onoff.container_width),
					onoff_value = control.params.values.onoff,
					inset_checked_value = _wpCustomBoxShadowControl.inset.checked_value,
					inset_unchecked_value = _wpCustomBoxShadowControl.inset.unchecked_value,
					inset_checked_label = _wpCustomBoxShadowControl.inset.checked_label,
					inset_unchecked_label = _wpCustomBoxShadowControl.inset.unchecked_label,
					inset_container_width = parseInt(_wpCustomBoxShadowControl.inset.container_width),
					h_shadow_selected,
					v_shadow_selected,
					blur_selected,
					spread_selected;

				if (onoff_value == onoff_checked_value) {
					control.container.find('.responsi-box-shadow-container').show();
				} else {
					control.container.find('.responsi-box-shadow-container').hide();
				}

				if (!control.container.hasClass('applied_box_shadow')) {
					control.container.addClass('applied_box_shadow');

					// OnOff Switcher
					onoff_switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
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
							control.settings[control.id + '[onoff]'].set(val);
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
							control.settings[control.id + '[inset]'].set(val);
							inset_switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							inset_switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);

						}
					});

					// Color Picker
					picker.val(control.params.values.color).wpColorPicker({
						change: function() {
							control.settings[control.id + '[color]'].set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.settings[control.id + '[color]'].set('');
						}
					}).bind('change keyup', function( event ) {
						event.preventDefault();
						control.settings[control.id + '[color]'].set($(this).val());
					});

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
				setting_id = switcher.siblings('input[type="hidden"]').data('customize-setting-link'),
				checked_value = control.params.checked_value,
				unchecked_value = control.params.unchecked_value,
				checked_label = control.params.checked_label,
				unchecked_label = control.params.unchecked_label,
				container_width = parseInt(control.params.container_width);

				/*switcher.on(control.id, function() {
					if (null === control.setting) {
						control.settings[setting_id].set($(this).val());
					} else {
						control.setting.set($(this).val());
					}
				});*/

				if (!control.container.hasClass('applied_icheckbox')) {
					control.container.addClass('applied_icheckbox');

					switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
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
							if (null === control.setting) {
								control.settings[setting_id].set(val.toString());
							} else {
								control.setting.set(val.toString());
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
					container_width = parseInt(_wpCustomIMultiCheckboxControl.onoff.container_width);

				if (!control.container.hasClass('applied_imulticheckbox')) {
					control.container.addClass('applied_imulticheckbox');

					control.container.find('input.responsi-ui-imulticheckbox').each(function(i) {

						var input_name = $(this).siblings('input[type="hidden"]').attr('name');
						var setting_id = $(this).siblings('input[type="hidden"]').data('customize-setting-link');

						$(this).iphoneStyle({
							duration: 50,
							resizeContainer: true,
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
								control.settings[setting_id].set(val.toString());
								$('input[name="' + input_name + '"]').trigger("responsi-ui-icheckbox-switch", [elem, status]);
							},
							onEnd: function(elem, value) {
								var status = value.toString();
								$('input[name="' + input_name + '"]').trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
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
							container_width = parseInt(_wpCustomIRadioControl.onoff.container_width),
							input_name = $(this).attr('name'),
							current_item = $(this);

						current_item.iphoneStyle({
							duration: 50,
							resizeContainer: true,
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
									$('input[name="' + input_name + '"]').not(current_item).removeAttr('checked').removeAttr('checkbox-disabled').iphoneStyle("refresh");
									control.setting.set(current_item.val());
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

				var setting_id = control.params.setting_id,
					ui_slide = control.container.find('.ui-slide'),
					ui_slide_input = control.container.find('.islide-value'),
					min = parseInt(control.params.min),
					max = parseInt(control.params.max),
					step = parseInt(control.params.step),
					value = parseInt(control.params.value);

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
							if (null === control.setting) {
								control.settings[setting_id].set(ui.value);
							} else {
								control.setting.set(ui.value);
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

				var picker = control.container.find('.color-picker-hex'),
					onoff_switcher = control.container.find('.responsi-ibackground-onoff'),
					onoff_checked_value = _wpCustomiBackgroundControl.onoff.checked_value,
					onoff_unchecked_value = _wpCustomiBackgroundControl.onoff.unchecked_value,
					onoff_checked_label = _wpCustomiBackgroundControl.onoff.checked_label,
					onoff_unchecked_label = _wpCustomiBackgroundControl.onoff.unchecked_label,
					onoff_container_width = parseInt(_wpCustomiBackgroundControl.onoff.container_width),
					onoff_value = control.params.values.onoff;

				if (onoff_value == onoff_checked_value) {
					control.container.find('.responsi-ibackground-container').show();
				} else {
					control.container.find('.responsi-ibackground-container').hide();
				}
				
				if (!control.container.hasClass('applied_box_shadow')) {
					control.container.addClass('applied_ibackground');

					// OnOff Switcher
					onoff_switcher.iphoneStyle({
						duration: 50,
						resizeContainer: true,
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
							control.settings[control.id + '[onoff]'].set(val);
							onoff_switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							onoff_switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
						}
					});

					// Color Picker
					picker.val(control.params.values.color).wpColorPicker({
						change: function() {
							control.settings[control.id + '[color]'].set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.settings[control.id + '[color]'].set('');
						}
					}).bind('change keyup', function( event ) {
						event.preventDefault();
						control.settings[control.id + '[color]'].set($(this).val());
					});

				}
			});
		}
	});

	api.Customize_iColor_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				var picker = control.container.find('.icolor-picker');

				if (!control.container.hasClass('applied_icolor')) {
					control.container.addClass('applied_icolor');

					picker.val(control.params.defaultValue).wpColorPicker({
						change: function() {
							control.setting.set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.setting.set('');
						}
					}).bind('change keyup', function( event ) {
						event.preventDefault();
						control.setting.set($(this).val());
					});

				}
			});
		}
	});

	api.Customize_iSelect_Control = api.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('select.responsi-iselect').on('change', function( event ) {
				event.preventDefault();
				control.setting.set($(this).val());
			});
		}
	});

	api.Customize_iText_Control = api.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('input.responsi-itext').on('change keyup', function( event ) {
				event.preventDefault();
				control.setting.set($(this).val());
			});
		}
	});

	api.Customize_iTextarea_Control = api.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('textarea.responsi-itextarea').on('change keyup', function( event ) {
				event.preventDefault();
				control.setting.set($(this).val());
			});
		}
	});

	api.Customize_Multiple_Text_Control = api.Control.extend({
		ready: function() {

			var control = this;
			control.container.find('input.responsi-multitext').on('change keyup', function( event ) {
				event.preventDefault();
				var setting_id = $(this).data('customize-setting-link');
				control.settings[setting_id].set($(this).val());
			});
		}
	});

	api.Customize_Background_Patterns_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );

			control.container.find('span.bp-item').on('click', function( event ) {
				event.preventDefault();
				$(this).siblings('span.bp-item').removeClass('bg-selected');
				$(this).addClass('bg-selected');
			});

			control.container.find('input.bp-radio').on('change', function( event ) {
				event.preventDefault();
				control.setting.set($(this).val());
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

	api.Customize_Layout_Control = api.Control.extend({
		ready: function() {

			var control = this,
				sectionContainer = api.sectionContainer( this );
			
			sectionContainer.on('expanded', function( event ) {

				event.preventDefault();

				if (!control.container.hasClass('applied_layout')) {
					control.container.addClass('applied_layout');

					control.container.find('img.responsi-radio-img-img').on('click', function( event ) {
						event.preventDefault();
						$(this).parent('.layout-item').siblings('.layout-item').children('img.responsi-radio-img-img').removeClass('responsi-radio-img-selected');
						$(this).addClass('responsi-radio-img-selected');
						var layout_val = $(this).data('value');
						control.logicLayout($(this), layout_val);
						control.logicLayoutThumbnail($(this), layout_val);
					});

					control.container.find('input.responsi-radio-img-radio').on('change', function( event ) {
						event.preventDefault();
						control.setting.set($(this).val());
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
						$(this).parent('.layout-item').siblings('.layout-item-5').find('img').click();
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
						$(this).parent('.layout-item').siblings('.layout-item-4').find('img').click();
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
						event.preventDefault();
						control.hideEditor();
						return false;
					});

					$(document).on('click keydown', '.update-editor-button[data-id="' + control.id + '"]', function( event ) {
						event.preventDefault();
						control.updateAndCloseEditor(control);
						return false;
					});

					control.setting.bind(function() {
						control.renderContent();
					});
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
			var control = this,
			setting_id = control.id;
			this.frame = this.showEditor(control, setting_id);
		},

		showEditor: function(control, contentId) {
			$('#wp-editor-customize-backdrop').show();
			$('#wp-editor-customize-container').show();

			this.currentContentId = contentId;
			this.currentEditorPage = ($('body').hasClass('wp-customizer') ? 'wp-customizer' : '');

			if (this.currentEditorPage == "wp-customizer") {
				this.wpFullOverlayOriginalZIndex = parseInt($('.wp-full-overlay').css('zIndex'));
				$('.wp-full-overlay').css({
					zIndex: 49000
				});
			}

			this.setEditorContent(control, contentId);
		},

		setEditorContent: function(control, contentId) {
			var editor = tinyMCE.EditorManager.get('wpeditorcustomize');
			var content = control.setting._value;
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
			control.setting.set(content);
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

	api.Customize_iUpload_Control = api.ImageControl.extend({});

	api.Customize_iUploadCrop_Control = api.CroppedImageControl.extend({});

	$.extend(api.controlConstructor, {
		typography 			: api.Customize_Typography_Control,
		border 				: api.Customize_Border_Control,
		border_radius 		: api.Customize_BorderRadius_Control,
		box_shadow 			: api.Customize_BoxShadow_Control,
		icheckbox 			: api.Customize_iCheckbox_Control,
		iswitcher 			: api.Customize_iCheckbox_Control,
		imulticheckbox 		: api.Customize_iMultiCheckbox_Control,
		iradio 				: api.Customize_iRadio_Control,
		slider 				: api.Customize_Slider_Control,
		ibackground 		: api.Customize_iBackground_Control,
		icolor 				: api.Customize_iColor_Control,
		iselect 			: api.Customize_iSelect_Control,
		itext 				: api.Customize_iText_Control,
		itextarea 			: api.Customize_iTextarea_Control,
		multitext 			: api.Customize_Multiple_Text_Control,
		background_patterns : api.Customize_Background_Patterns_Control,
		layout 				: api.Customize_Layout_Control,		
		ieditor 			: api.Customize_iEditor_Control,
		iupload 			: api.Customize_iUpload_Control,
		iuploadcrop 		: api.Customize_iUploadCrop_Control
	});

})(window.wp, jQuery);