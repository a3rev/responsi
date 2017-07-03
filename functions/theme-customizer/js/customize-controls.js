(function(wp, $) {

	wp.customize.Customize_Background_Patterns_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('span.bp-item').on('click', function() {
				$(this).siblings('span.bp-item').removeClass('background-selected');
				$(this).addClass('background-selected');
			});

			control.container.find('input.bp-radio').on('change', function() {
				control.setting.set($(this).val());
			});

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}

			section_container.on('expanded', function() {
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

	wp.customize.Customize_Border_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;
			var picker = this.container.find('.color-picker-hex');
			var size_select = control.container.find('select.responsi-border-width');
			var style_select = control.container.find('select.responsi-border-style');

			var control_id = control.id;

			// Border Width
			size_select.on('change', function() {
				control.settings[control_id + '[width]'].set($(this).val());
			});

			// Border Style
			style_select.on('change', function() {
				control.settings[control_id + '[style]'].set($(this).val());
			});

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_border')) {
					control.container.addClass('applied_border');

					var size_selected = '';
					for (var i = _wpCustomBorderControl.width.min; i <= _wpCustomBorderControl.width.max; i++) {
						size_selected = '';
						if (i == control.params.values.width) {
							size_selected = 'selected="select"';
						}
						size_select.append('<option value="' + i + '" ' + size_selected + ' >' + i + 'px</option>');
					}

					var style_selected = '';
					_.each(_wpCustomBorderControl.styles, function(style_name, index) {
						style_selected = '';
						if (index == control.params.values.style) {
							style_selected = 'selected="select"';
						}
						style_select.append('<option value="' + index + '" ' + style_selected + ' >' + style_name + '</option>');
					});

					// Color Picker
					picker.val(control.params.values.color).wpColorPicker({
						change: function() {
							control.settings[control_id + '[color]'].set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.settings[control_id + '[color]'].set('');
						}
					}).bind('change keyup', function() {
						control.settings[control_id + '[color]'].set($(this).val());
					});

				}
			});

		}
	});

	wp.customize.Customize_BorderRadius_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;
			var switcher = control.container.find('.responsi-ui-icheckbox');
			var ui_slide = control.container.find('.ui-slide');
			var ui_slide_input = control.container.find('.responsi-slide-value');
			var control_id = control.id;

			var min = parseInt(_wpCustomBorderRadiusControl.rounded.min);
			var max = parseInt(_wpCustomBorderRadiusControl.rounded.max);
			var step = parseInt(_wpCustomBorderRadiusControl.rounded.step);
			var rounded_value = parseInt(control.params.values.rounded_value);

			var checked_value = _wpCustomBorderRadiusControl.corner.checked_value;
			var unchecked_value = _wpCustomBorderRadiusControl.corner.unchecked_value;
			var checked_label = _wpCustomBorderRadiusControl.corner.checked_label;
			var unchecked_label = _wpCustomBorderRadiusControl.corner.unchecked_label;
			var container_width = parseInt(_wpCustomBorderRadiusControl.corner.container_width);
			var corner_value = control.params.values.corner;

			if (corner_value == checked_value) {
				control.container.find('.responsi-range-slider').show();
			} else {
				control.container.find('.responsi-range-slider').hide();
			}

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_border_radius')) {
					control.container.addClass('applied_border_radius');

					// Switcher
					switcher.iphoneStyle({
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
							control.settings[control_id + '[corner]'].set(val);
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
							control.settings[control_id + '[rounded_value]'].set(ui.value);
						}
					});

				}
			});
		}
	});

	wp.customize.Customize_BoxShadow_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;
			var picker = control.container.find('.color-picker-hex')
			var onoff_switcher = control.container.find('.responsi-box-shadow-onoff');
			var inset_switcher = control.container.find('.responsi-box-shadow-inset');
			var h_shadow_select = control.container.find('select.responsi-box-shadow_h_shadow');
			var v_shadow_select = control.container.find('select.responsi-box-shadow_v_shadow');
			var blur_select = control.container.find('select.responsi-box-shadow_blur');
			var spread_select = control.container.find('select.responsi-box-shadow_spread');
			var control_id = control.id;

			var onoff_checked_value = _wpCustomBoxShadowControl.onoff.checked_value;
			var onoff_unchecked_value = _wpCustomBoxShadowControl.onoff.unchecked_value;
			var onoff_checked_label = _wpCustomBoxShadowControl.onoff.checked_label;
			var onoff_unchecked_label = _wpCustomBoxShadowControl.onoff.unchecked_label;
			var onoff_container_width = parseInt(_wpCustomBoxShadowControl.onoff.container_width);
			var onoff_value = control.params.values.onoff;

			var inset_checked_value = _wpCustomBoxShadowControl.inset.checked_value;
			var inset_unchecked_value = _wpCustomBoxShadowControl.inset.unchecked_value;
			var inset_checked_label = _wpCustomBoxShadowControl.inset.checked_label;
			var inset_unchecked_label = _wpCustomBoxShadowControl.inset.unchecked_label;
			var inset_container_width = parseInt(_wpCustomBoxShadowControl.inset.container_width);

			setTimeout(function() {
				if (onoff_value == onoff_checked_value) {
					control.container.find('.responsi-box-shadow-container').show();
				} else {
					control.container.find('.responsi-box-shadow-container').hide();
				}
			}, 5000);

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_box_shadow')) {
					control.container.addClass('applied_box_shadow');

					var h_shadow_selected = '';
					var v_shadow_selected = '';
					var blur_selected = '';
					var spread_selected = '';
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

					// OnOff Switcher
					onoff_switcher.iphoneStyle({
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
							control.settings[control_id + '[onoff]'].set(val);
							onoff_switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							onoff_switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);
						}
					});

					// Inset Switcher
					inset_switcher.iphoneStyle({
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
							control.settings[control_id + '[inset]'].set(val);
							inset_switcher.trigger("responsi-ui-icheckbox-switch", [elem, status]);
							//control.container.find('.box-shadow-container select').bind('change');
							//control.container.find('.box-shadow-container input').bind('change keyup');
							//var color = control.container.find('.box-shadow-container input.wp-color-picker').val();
							//control.settings[control_id + '[color]'].set(color);
						},
						onEnd: function(elem, value) {
							var status = value.toString();
							inset_switcher.trigger("responsi-ui-icheckbox-switch-end", [elem, status]);

						}
					});

					// Color Picker
					picker.val(control.params.values.color).wpColorPicker({
						change: function() {
							control.settings[control_id + '[color]'].set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.settings[control_id + '[color]'].set('');
						}
					}).bind('change keyup', function() {
						control.settings[control_id + '[color]'].set($(this).val());
					});
				}
			});

			// H Shadow
			h_shadow_select.on('change', function() {
				control.settings[control_id + '[h_shadow]'].set($(this).val());
			});

			// V Shadow
			v_shadow_select.on('change', function() {
				control.settings[control_id + '[v_shadow]'].set($(this).val());
			});

			// Blur
			blur_select.on('change', function() {
				control.settings[control_id + '[blur]'].set($(this).val());
			});

			// Spread
			spread_select.on('change', function() {
				control.settings[control_id + '[spread]'].set($(this).val());
			});
			
		}
	});

	wp.customize.Customize_iCheckbox_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this,
				switcher = this.container.find('.responsi-ui-icheckbox');

			var control_id = control.id;
			var setting_id = switcher.data('customize-setting-link');

			var checked_value = control.params.checked_value;
			var unchecked_value = control.params.unchecked_value;
			var checked_label = control.params.checked_label;
			var unchecked_label = control.params.unchecked_label;
			var container_width = parseInt(control.params.container_width);

			switcher.on(control_id, function() {
				if (null === control.setting) {
					control.settings[setting_id].set($(this).val());
				} else {
					control.setting.set($(this).val());
				}
			});

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_icheckbox')) {
					control.container.addClass('applied_icheckbox');

					switcher.iphoneStyle({
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
								control.settings[setting_id].set(val);
							} else {
								control.setting.set(val);
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

	wp.customize.Customize_iMultiCheckbox_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;

			var checked_value = _wpCustomIMultiCheckboxControl.onoff.checked_value;
			var unchecked_value = _wpCustomIMultiCheckboxControl.onoff.unchecked_value;
			var checked_label = _wpCustomIMultiCheckboxControl.onoff.checked_label;
			var unchecked_label = _wpCustomIMultiCheckboxControl.onoff.unchecked_label;
			var container_width = parseInt(_wpCustomIMultiCheckboxControl.onoff.container_width);

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_imulticheckbox')) {
					control.container.addClass('applied_imulticheckbox');

					control.container.find('input.responsi-ui-imulticheckbox').each(function(i) {

						var input_name = $(this).attr('name');
						var setting_id = $(this).data('customize-setting-link');

						$(this).iphoneStyle({
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

	wp.customize.Customize_iColor_Control = wp.customize.Control.extend({
		ready: function() {
			var control = this,
				picker = this.container.find('.responsi-color-picker');

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_icolor')) {
					control.container.addClass('applied_icolor');

					picker.val(control.params.defaultValue).wpColorPicker({
						change: function() {
							control.setting.set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.setting.set('');
						}
					}).bind('change keyup', function() {
						control.setting.set($(this).val());
					});
				}
			});
		}
	});

	wp.customize.Customize_iEditor_Control = wp.customize.Control.extend({

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
			var control = this;
			_.bindAll(control, 'openFrame', 'hideEditor');
			control.container.on('click keydown', 'button.show-editor-button', control.openFrame);
			$('a.close-editor-button').on('click keydown', function() {
				control.hideEditor();
				return false;
			});
			$(document).on('click keydown', '.update-editor-button[data-id="' + control.id + '"]', function() {
				control.updateAndCloseEditor(control);
				return false;
			});
			control.setting.bind(function() {
				control.renderContent();
			});
		},

		openFrame: function(event) {
			if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
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
			var setting_id = control.id;
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

	wp.customize.Customize_iRadio_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_iradio')) {
					control.container.addClass('applied_iradio');

					control.container.find('input.responsi-ui-iradio').each(function(i) {

						var checked_label = _wpCustomIRadioControl.onoff.checked_label;
						var unchecked_label = _wpCustomIRadioControl.onoff.unchecked_label;
						var container_width = parseInt(_wpCustomIRadioControl.onoff.container_width);

						var input_name = $(this).attr('name');
						var current_item = $(this);
						current_item.iphoneStyle({
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
								}
								control.setting.set(current_item.val());
								$('input[name="' + input_name + '"]').trigger("responsi-ui-iradio-switch", [elem, status]);
							},
							onEnd: function(elem, value) {
								var status = value.toString();
								if (elem.prop('checked')) {
									$('input[name="' + input_name + '"]').not(current_item).removeAttr('checkbox-disabled');
									$(current_item).attr('checkbox-disabled', 'true');
								}
								control.setting.set(current_item.val());
								$('input[name="' + input_name + '"]').trigger("responsi-ui-iradio-switch-end", [elem, status]);
							}
						});

					});

				}
			});
		}
	});

	wp.customize.Customize_iSelect_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('select.responsi-iselect').on('change', function() {
				control.setting.set($(this).val());
			});
		}
	});

	wp.customize.Customize_iText_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('input.responsi-itext').on('change keyup', function() {
				control.setting.set($(this).val());
			});
		}
	});

	wp.customize.Customize_iTextarea_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;

			control.container.find('textarea.responsi-itextarea').on('change keyup', function() {
				control.setting.set($(this).val());
			});
		}
	});

	wp.customize.Customize_iUpload_Control = wp.customize.ImageControl.extend({});

	wp.customize.Customize_iUploadCrop_Control = wp.customize.CroppedImageControl.extend({});

	wp.customize.Customize_Layout_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;
			control.container.find('img.responsi-radio-img-img').on('click', function() {
				$(this).parent('.layout-item').siblings('.layout-item').children('img.responsi-radio-img-img').removeClass('responsi-radio-img-selected');
				$(this).addClass('responsi-radio-img-selected');
				var layout_val = $(this).data('value');
				control.logicLayout($(this), layout_val);
				control.logicLayoutThumbnail($(this), layout_val);
			});
			control.container.find('input.responsi-radio-img-radio').on('change', function() {
				control.setting.set($(this).val());
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

	wp.customize.Customize_Multiple_Text_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;
			control.container.find('input.responsi-multitext').on('change keyup', function() {
				var setting_id = $(this).data('customize-setting-link');
				control.settings[setting_id].set($(this).val());
			});
		}
	});

	wp.customize.Customize_Slider_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;
			var ui_slide = control.container.find('.ui-slide');
			var ui_slide_input = control.container.find('.responsi-slide-value');
			var setting_id = control.params.setting_id;

			var min = parseInt(control.params.min);
			var max = parseInt(control.params.max);
			var step = parseInt(control.params.step);
			var value = parseInt(control.params.value);

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
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

	wp.customize.Customize_Typography_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;
			var picker = this.container.find('.color-picker-hex');
			var size_select = control.container.find('select.responsi-typography-size');
			var line_height_select = control.container.find('select.responsi-typography-line-height');
			var face_select = control.container.find('select.responsi-typography-face');
			var style_select = control.container.find('select.responsi-typography-style');

			var control_id = control.id;

			// Font Size
			size_select.on('change', function() {
				control.settings[control_id + '[size]'].set($(this).val());
			});

			// Font Line Height
			line_height_select.on('change', function() {
				control.settings[control_id + '[line_height]'].set($(this).val());
			});

			// Font Face
			face_select.on('change', function() {
				control.settings[control_id + '[face]'].set($(this).val());
			});

			// Font Style
			style_select.on('change', function() {
				control.settings[control_id + '[style]'].set($(this).val());
			});

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}
			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_typography')) {
					control.container.addClass('applied_typography');

					var size_selected = '';
					for (var i = _wpCustomTypographyControl.size.min; i <= _wpCustomTypographyControl.size.max; i++) {
						size_selected = '';
						if (i == control.params.values.size) {
							size_selected = 'selected="select"';
						}
						size_select.append('<option value="' + i + '" ' + size_selected + ' >' + i + 'px</option>');
					}

					var line_height_selected = '';
					_.each(_wpCustomTypographyControl.line_heights, function(line_height_value, index) {
						line_height_selected = '';
						if (line_height_value == control.params.values.line_height) {
							line_height_selected = 'selected="select"';
						}
						line_height_select.append('<option value="' + line_height_value + '" ' + line_height_selected + ' >' + line_height_value + '</option>');
					});

					var style_selected = '';
					_.each(_wpCustomTypographyControl.styles, function(style_name, index) {
						style_selected = '';
						if (index == control.params.values.style) {
							style_selected = 'selected="select"';
						}
						style_select.append('<option value="' + index + '" ' + style_selected + ' >' + style_name + '</option>');
					});

					var face_selected = '';
					_.each(_wpCustomTypographyControl.fonts, function(font_name, index) {
						face_selected = '';
						if (index == control.params.values.face) {
							face_selected = 'selected="select"';
						}
						face_select.append('<option value="' + index + '" ' + face_selected + ' >' + font_name.name + '</option>');
					});

					// Color Picker
					picker.val(control.params.values.color).wpColorPicker({
						change: function() {
							control.settings[control_id + '[color]'].set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.settings[control_id + '[color]'].set('');
						}
					}).bind('change keyup', function() {
						control.settings[control_id + '[color]'].set($(this).val());
					});

				}
			});

		}
	});

	wp.customize.Customize_iBackground_Control = wp.customize.Control.extend({
		ready: function() {

			var control = this;
			var picker = control.container.find('.color-picker-hex')
			var onoff_switcher = control.container.find('.responsi-ibackground-onoff');
			var control_id = control.id;

			var onoff_checked_value = _wpCustomiBackgroundControl.onoff.checked_value;
			var onoff_unchecked_value = _wpCustomiBackgroundControl.onoff.unchecked_value;
			var onoff_checked_label = _wpCustomiBackgroundControl.onoff.checked_label;
			var onoff_unchecked_label = _wpCustomiBackgroundControl.onoff.unchecked_label;
			var onoff_container_width = parseInt(_wpCustomiBackgroundControl.onoff.container_width);
			var onoff_value = control.params.values.onoff;

			setTimeout(function() {
				if (onoff_value == onoff_checked_value) {
					control.container.find('.responsi-ibackground-container').show();
				} else {
					control.container.find('.responsi-ibackground-container').hide();
				}
			}, 5000);

			var section_container = control.container.parent('ul.accordion-section-content').parent('li.accordion-section');
			if( section_container.length == 0 ){
				section_container = control.container.parent('ul.customize-pane-child');
			}

			section_container.on('expanded', function() {
				if (!control.container.hasClass('applied_box_shadow')) {
					control.container.addClass('applied_ibackground');

					// OnOff Switcher
					onoff_switcher.iphoneStyle({
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
							control.settings[control_id + '[onoff]'].set(val);
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
							control.settings[control_id + '[color]'].set(picker.wpColorPicker('color'));
						},
						clear: function() {
							control.settings[control_id + '[color]'].set('');
						}
					}).bind('change keyup', function() {
						control.settings[control_id + '[color]'].set($(this).val());
					});

				}
			});
		}
	});

	$.extend(wp.customize.controlConstructor, {
		'icheckbox': wp.customize.Customize_iCheckbox_Control,
		'imulticheckbox': wp.customize.Customize_iMultiCheckbox_Control,
		'iswitcher': wp.customize.Customize_iCheckbox_Control,
		'iradio': wp.customize.Customize_iRadio_Control,
		'icolor': wp.customize.Customize_iColor_Control,
		'iselect': wp.customize.Customize_iSelect_Control,
		'itext': wp.customize.Customize_iText_Control,
		'itextarea': wp.customize.Customize_iTextarea_Control,
		'multitext': wp.customize.Customize_Multiple_Text_Control,
		'slider': wp.customize.Customize_Slider_Control,
		'typography': wp.customize.Customize_Typography_Control,
		'border': wp.customize.Customize_Border_Control,
		'border_radius': wp.customize.Customize_BorderRadius_Control,
		'box_shadow': wp.customize.Customize_BoxShadow_Control,
		'background_patterns': wp.customize.Customize_Background_Patterns_Control,
		'iupload': wp.customize.Customize_iUpload_Control,
		'iuploadcrop': wp.customize.Customize_iUploadCrop_Control,
		'layout': wp.customize.Customize_Layout_Control,
		'ieditor': wp.customize.Customize_iEditor_Control,
		'ibackground': wp.customize.Customize_iBackground_Control
	});

})(window.wp, jQuery);