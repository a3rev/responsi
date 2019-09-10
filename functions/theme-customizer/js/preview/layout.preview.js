/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    //Layout Style Width
    function _previewSites() {
        var css = '';
        var responsi_layout_width = wp.customize.value('responsi_layout_width')();
        var responsi_box_border_lr_width = wp.customize.value('responsi_box_border_lr[width]')();
        if (responsi_box_border_lr_width > 0) {
            responsi_box_border_lr_width = parseInt(responsi_box_border_lr_width * 2);
            responsi_layout_width = parseInt(responsi_layout_width) + parseInt(responsi_box_border_lr_width);
        }

        css += '.site-width{';
        css += 'max-width:' + responsi_layout_width + 'px;';
        css += '}';

        if ($('#custom_site_structure').length > 0) {
            $('#custom_site_structure').html(css);
        } else {
            $('head').append('<style id="custom_site_structure">' + css + '</style>');
        }
        $(window).trigger('resize');
    }

    var header_mobile = [1, 2, 3, 4, 5, 6];
    $.each(header_mobile, function(inx, val) {
        wp.customize('responsi_on_header_' + val, function(value) {
            value.bind(function(to) {
                if (to == 'false' || to == false) {
                    $('body').addClass('mobile-header-' + val);
                } else {
                    $('body').removeClass('mobile-header-' + val);
                }
            });
        });
    });

    var single_fields = [
        'responsi_layout_width',
    ];
    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewSites();
            });
        });
    });

    function _previewMobileWidgets() {
        var css = '';

        if (wp.customize.value('responsi_font_sidebar_widget_text_alignment_mobile')() == 'true') {
            var center_sidebar_widget_text_alignment_mobile = '.sidebar .widget-title, .sidebar .widget-title h3, .sidebar .widget-title *, .sidebar .widget-content, .sidebar .widget-content *, .sidebar-alt .widget-title, .sidebar-alt .widget-title h3, .sidebar-alt .widget-title *, .sidebar-alt .widget-content, .sidebar-alt .widget-content * {text-align:center !important;}';
        } else {
            var center_sidebar_widget_text_alignment_mobile = '.sidebar .widget-title, .sidebar .widget-title h3, .sidebar .widget-title *, .sidebar-alt .widget-title,  .sidebar-alt .widget-title h3, .sidebar-alt .widget-title * {text-align:' + wp.customize.value('responsi_widget_title_text_alignment')() + ' !important;}';
            center_sidebar_widget_text_alignment_mobile += '.sidebar .widget-content, .sidebar .widget-content *, .sidebar-alt .widget-content, .sidebar-alt .widget-content *{text-align:' + wp.customize.value('responsi_widget_font_text_alignment')() + ' !important;}';
        }

        if (wp.customize.value('responsi_font_footer_widget_text_alignment_mobile')() == 'true') {
            var footer_widget_text_alignment_mobile = '.msr-wg-footer .widget .widget-title, .msr-wg-footer .widget .widget-title *, .msr-wg-footer .widget .widget-content, .msr-wg-footer .widget .widget-content * {text-align:center !important;}';
        } else {
            var footer_widget_text_alignment_mobile = '.msr-wg-footer .widget .widget-title, .msr-wg-footer .widget .widget-title * {text-align:' + wp.customize.value('responsi_footer_widget_title_text_alignment')() + ' !important;}';
            footer_widget_text_alignment_mobile += '.msr-wg-footer .widget .widget-content, .msr-wg-footer .widget .widget-content *{text-align:' + wp.customize.value('responsi_font_footer_widget_text_alignment')() + ' !important;}';
        }

        css += '@media only screen and (max-width: 782px) {';
        css += center_sidebar_widget_text_alignment_mobile;
        css += footer_widget_text_alignment_mobile;
        css += '}';

        if ($('#custom_mobile_center_widgets').length > 0) {
            $('#custom_mobile_center_widgets').html(css);
        } else {
            $('head').append('<style id="custom_mobile_center_widgets">' + css + '</style>');
        }
    }

    var single_fields = [
        'responsi_font_sidebar_widget_text_alignment_mobile',
        'responsi_font_footer_widget_text_alignment_mobile',
    ];

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewMobileWidgets();
            });
        });
    });

    //Background Theme
    function _previewBackground() {

        if ( is_safari ) {
            $('body').css({
                'background-image': '',
                'background-attachment': '',
                'background-repeat': '',
                'background-position': '',
                'background-size': ''
            });
        }
        var to = wp.customize.value('responsi_use_style_bg_image')();
        if (to == 'false') {
            $('body').css({
                'background-image': 'none'
            });
        } else {
            var bimage = wp.customize.value('responsi_style_bg_image')();
            var bsize = wp.customize.value('responsi_use_bg_size')();
            var bsizew = wp.customize.value('responsi_bg_size_width')();
            var bsizeh = wp.customize.value('responsi_bg_size_height')();
            var bsizewh = 'inherit';
            if (bsize == 'true' && bsizew != '' && bsizeh != '') {
                bsizewh = bsizew + ' ' + bsizeh;
            }
            var battachment = wp.customize.value('responsi_style_bg_image_attachment')();
            var bvertical = wp.customize.value('responsi_bg_position_vertical')();
            var bhorizontal = wp.customize.value('responsi_bg_position_horizontal')();
            var brepeat = wp.customize.value('responsi_style_bg_image_repeat')();
            setTimeout(function() {
                $('body').css({
                    'background-image': 'url(' + bimage + ')',
                    'background-attachment': battachment,
                    'background-repeat': brepeat,
                    'background-position': bvertical + ' ' + bhorizontal,
                    'background-size': bsizewh
                });
            }, 1);
        }
    }
    wp.customize('responsi_style_bg[onoff]', function(value) {
        value.bind(function(to) {
            if ( is_safari ) {
                $('body').css('background-color', '');
            }
            if (to == 'false') {
                $('body').css('background-color', 'transparent');
            } else {
                var bcolor = wp.customize.value('responsi_style_bg[color]')();
                $('body').css('background-color', bcolor);
            }
        });
    });

    wp.customize('responsi_style_bg[color]', function(value) {
        value.bind(function(to) {
            if ( is_safari ) {
                $('body').css('background-color', '');
            }
            $('body').css('background-color', to);
        });
    });

    wp.customize('responsi_disable_background_style_img', function(value) {
        value.bind(function(to) {
            if ( is_safari ) {
                $('body').css({
                    'background-image': '',
                    'background-attachment': '',
                    'background-repeat': '',
                    'background-position': '',
                    'background-size': ''
                });
            }
            if (to == 'false') {
                $('body').css({
                    'background-image': 'none'
                });
            } else {
                var bimage = wp.customize.value('responsi_background_style_img')();
                var battachment = wp.customize.value('responsi_style_bg_image_attachment')();
                setTimeout(function() {
                    $('body').css({
                        'background-image': 'url(' + bimage + ')',
                        'background-attachment': battachment,
                        'background-repeat': 'repeat',
                        'background-position': 'center',
                        'background-size': 'auto'
                    });
                }, 1);
            }
        });
    });

    wp.customize('responsi_background_style_img', function(value) {
        value.bind(function(to) {
            if ( is_safari ) {
                $('body').css({
                    'background-image': '',
                    'background-attachment': '',
                    'background-repeat': '',
                    'background-position': '',
                    'background-size': ''
                });
            }
            var battachment = wp.customize.value('responsi_style_bg_image_attachment')();
            $('body').css({
                'background-image': 'url(' + to + ')',
                'background-attachment': battachment,
                'background-repeat': 'repeat',
                'background-position': 'center',
                'background-size': 'auto'
            });
        });
    });

    var single_fields = [
        'responsi_use_style_bg_image',
        'responsi_style_bg_image',
        'responsi_use_bg_size',
        'responsi_bg_size_width',
        'responsi_bg_size_height',
        'responsi_style_bg_image_attachment',
        'responsi_style_bg_image_repeat',
        'responsi_bg_position_vertical',
        'responsi_bg_position_horizontal'
    ];

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewBackground();
            });
        });
    });

    //Layout Style & Body Container
    function _previewContent() {
        var css = '';
        var responsi_box_shadow_inset = wp.customize.value('responsi_box_shadow[inset]')();

        css += '.responsi-content{';
        css += _cFn.renderBG('responsi_wrap_container_background');
        css += '}';

        css += '.content-in{';
        css += _cFn.renderMarPad('responsi_wrapper_padding', 'padding');
        css += _cFn.renderMarPad('responsi_wrapper_margin', 'margin');
        css += _cFn.renderBG('responsi_wrap_content_background');
        css += _cFn.renderBorder('responsi_wrapper_border_top', 'top');
        css += _cFn.renderBorder('responsi_wrapper_border_bottom', 'bottom');
        css += _cFn.renderBorder('responsi_wrapper_border_left_right', 'left');
        css += _cFn.renderBorder('responsi_wrapper_border_left_right', 'right');
        css += _cFn.renderRadius('responsi_wrapper_border_radius');
        css += _cFn.renderShadow('responsi_wrapper_border_box_shadow', true);
        css += '}';


        if (wp.customize.value('responsi_layout_boxed')() == 'true') {
            if (wp.customize.value('responsi_enable_boxed_style')() == 'true') {
                css += '.layout-box-mode .wrapper-ctn {';
                css += _cFn.renderMarPad('responsi_box_padding', 'padding');
                css += _cFn.renderMarPad('responsi_box_margin', 'margin');
                css += _cFn.renderBorder('responsi_box_border_tb', 'top');
                css += _cFn.renderBorder('responsi_box_border_tb', 'bottom');
                css += _cFn.renderBorder('responsi_box_border_lr', 'left');
                css += _cFn.renderBorder('responsi_box_border_lr', 'right');
                css += _cFn.renderRadius('responsi_box_border_radius');
                var _shadow = 'box-shadow:none !important;';
                if (responsi_box_shadow_inset != 'inset') {
                    _shadow += _cFn.renderShadow('responsi_box_shadow', true);
                }
                css += _shadow;
                css += '}';


                css += '.wrapper-ctn .wrapper-in{';
                css += _cFn.renderBG('responsi_box_inner_bg');
                css += _cFn.renderMarPad('responsi_box_inner_padding', 'padding');
                css += _cFn.renderMarPad('responsi_box_inner_margin', 'margin');
                css += _cFn.renderBorder('responsi_box_inner_border_top', 'top');
                css += _cFn.renderBorder('responsi_box_inner_border_bottom', 'bottom');
                css += _cFn.renderBorder('responsi_box_inner_border_left', 'left');
                css += _cFn.renderBorder('responsi_box_inner_border_right', 'right');
                css += _cFn.renderRadius('responsi_box_inner_border_radius');
                css += _cFn.renderShadow('responsi_box_inner_shadow');
                css += '}';


            } else {
                css += '.layout-box-mode .wrapper-ctn {';
                css += 'padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;';
                css += '}';

                css += '.wrapper-ctn .wrapper-in{';
                css += 'padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;background-color:transparent !important;';
                css += '}';
            }
        } else {
            css += '.layout-box-mode .wrapper-ctn {';
            css += 'padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;';
            css += '}';

            css += '.wrapper-ctn .wrapper-in{';
            css += 'padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;background-color:transparent !important;';
            css += '}';
        }

        if ($('#custom_content_body_style').length > 0) {
            $('#custom_content_body_style').html(css);
        } else {
            $('head').append('<style id="custom_content_body_style">' + css + '</style>');
        }
    }

    var single_fields = [
        'responsi_enable_boxed_style',
    ];

    var bg_fields = [
        'responsi_wrap_container_background',
        'responsi_wrap_content_background',
        'responsi_box_inner_bg'
    ];

    var border_fields = [
        'responsi_box_border_lr',
        'responsi_box_border_tb',
        'responsi_wrapper_border_left_right',
        'responsi_wrapper_border_top',
        'responsi_wrapper_border_bottom',
        'responsi_box_inner_border_left',
        'responsi_box_inner_border_right',
        'responsi_box_inner_border_top',
        'responsi_box_inner_border_bottom'
    ];

    var border_radius_fields = [
        'responsi_box_border_radius',
        'responsi_wrapper_border_radius',
        'responsi_box_inner_border_radius'
    ];

    var shadow_fields = [
        'responsi_box_shadow',
        'responsi_wrapper_border_box_shadow',
        'responsi_box_inner_shadow'
    ];

    var margin_padding_fields = [
        'responsi_box_margin',
        'responsi_box_padding',
        'responsi_wrapper_margin',
        'responsi_wrapper_padding',
        'responsi_box_inner_margin',
        'responsi_box_inner_padding'
    ];

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewContent();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewContent();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewContent();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewContent();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewContent();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewContent();
            });
        });
    });


    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewContent();
            });
        });
    });

    var responsi_header_animation = {
        'responsi_header_animation_1' : '.header #header-animation-1',
        'responsi_header_animation_2' : '.header #header-animation-2',
        'responsi_header_animation_3' : '.header #header-animation-3',
        'responsi_header_animation_4' : '.header #header-animation-4',
        'responsi_header_animation_5' : '.header #header-animation-5',
        'responsi_header_animation_6' : '.header #header-animation-6'
    };

    $.each( responsi_header_animation, function(inx, val) {

        wp.customize(inx+'[type]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimation( val,inx );
            });
        });

        wp.customize(inx+'[duration]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimation( val,inx );
            });
        });

        wp.customize(inx+'[delay]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimation( val,inx );
            });
        });

        wp.customize(inx+'[direction]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimation( val,inx );
            });
        });
    });

    var responsi_footer_animation = {
        'responsi_footer_animation_1' : '#footer-widgets-animation-1',
        'responsi_footer_animation_2' : '#footer-widgets-animation-2',
        'responsi_footer_animation_3' : '#footer-widgets-animation-3',
        'responsi_footer_animation_4' : '#footer-widgets-animation-4',
        'responsi_footer_animation_5' : '#footer-widgets-animation-5',
        'responsi_footer_animation_6' : '#footer-widgets-animation-6'
    };

    $.each( responsi_footer_animation, function(inx, val) {

        wp.customize(inx+'[type]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimation( val,inx );
            });
        });

        wp.customize(inx+'[duration]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimation( val,inx );
            });
        });

        wp.customize(inx+'[delay]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimation( val,inx );
            });
        });

        wp.customize(inx+'[direction]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimation( val,inx );
            });
        });
    });

})(jQuery);
