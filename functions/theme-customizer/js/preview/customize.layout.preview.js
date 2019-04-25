/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    //Layout Style Width
    function responsi_preview_site_structure() {
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
                responsi_preview_site_structure();
            });
        });
    });

    function responsi_preview_mobile_center_widgets() {
        var css = '';

        if (wp.customize.value('responsi_font_sidebar_widget_text_alignment_mobile')() == 'true') {
            var center_sidebar_widget_text_alignment_mobile = '#sidebar .fw_widget_title, #sidebar .fw_widget_title h3, #sidebar .fw_widget_title *, #sidebar .fw_widget_content, #sidebar .fw_widget_content *, #sidebar-alt .fw_widget_title, #sidebar-alt .fw_widget_title h3, #sidebar-alt .fw_widget_title *, #sidebar-alt .fw_widget_content, #sidebar-alt .fw_widget_content * {text-align:center !important;}';
        } else {
            var center_sidebar_widget_text_alignment_mobile = '#sidebar .fw_widget_title, #sidebar .fw_widget_title h3, #sidebar .fw_widget_title *, #sidebar-alt .fw_widget_title,  #sidebar-alt .fw_widget_title h3, #sidebar-alt .fw_widget_title * {text-align:' + wp.customize.value('responsi_widget_title_text_alignment')() + ' !important;}';
            center_sidebar_widget_text_alignment_mobile += '#sidebar .fw_widget_content, #sidebar .fw_widget_content *, #sidebar-alt .fw_widget_content, #sidebar-alt .fw_widget_content *{text-align:' + wp.customize.value('responsi_widget_font_text_alignment')() + ' !important;}';
        }

        if (wp.customize.value('responsi_font_footer_widget_text_alignment_mobile')() == 'true') {
            var footer_widget_text_alignment_mobile = '.masonry_widget_footer .widget .fw_widget_title, .masonry_widget_footer .widget .fw_widget_title *, .masonry_widget_footer .widget .fw_widget_content, .masonry_widget_footer .widget .fw_widget_content * {text-align:center !important;}';
        } else {
            var footer_widget_text_alignment_mobile = '.masonry_widget_footer .widget .fw_widget_title, .masonry_widget_footer .widget .fw_widget_title * {text-align:' + wp.customize.value('responsi_footer_widget_title_text_alignment')() + ' !important;}';
            footer_widget_text_alignment_mobile += '.masonry_widget_footer .widget .fw_widget_content, .masonry_widget_footer .widget .fw_widget_content *{text-align:' + wp.customize.value('responsi_font_footer_widget_text_alignment')() + ' !important;}';
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
                responsi_preview_mobile_center_widgets();
            });
        });
    });

    //Background Theme
    function responsi_preview_style_background() {

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
                responsi_preview_style_background();
            });
        });
    });

    //Layout Style & Body Container
    function responsi_preview_style_content() {
        var css = '';
        var responsi_box_shadow_inset = wp.customize.value('responsi_box_shadow[inset]')();

        css += '#wrapper-content{';
        css += responsiCustomize.build_background('responsi_wrap_container_background');
        css += '}';

        css += '#wrapper-article{';
        css += responsiCustomize.build_padding_margin('responsi_wrapper_padding', 'padding');
        css += responsiCustomize.build_padding_margin('responsi_wrapper_margin', 'margin');
        css += responsiCustomize.build_background('responsi_wrap_content_background');
        css += responsiCustomize.build_border('responsi_wrapper_border_top', 'top');
        css += responsiCustomize.build_border('responsi_wrapper_border_bottom', 'bottom');
        css += responsiCustomize.build_border('responsi_wrapper_border_left_right', 'left');
        css += responsiCustomize.build_border('responsi_wrapper_border_left_right', 'right');
        css += responsiCustomize.build_border_radius('responsi_wrapper_border_radius');
        css += responsiCustomize.build_box_shadow('responsi_wrapper_border_box_shadow', true);
        css += '}';


        if (wp.customize.value('responsi_layout_boxed')() == 'true') {
            if (wp.customize.value('responsi_enable_boxed_style')() == 'true') {
                css += '.layout-box-mode #wrapper-boxes {';
                css += responsiCustomize.build_padding_margin('responsi_box_padding', 'padding');
                css += responsiCustomize.build_padding_margin('responsi_box_margin', 'margin');
                css += responsiCustomize.build_border('responsi_box_border_tb', 'top');
                css += responsiCustomize.build_border('responsi_box_border_tb', 'bottom');
                css += responsiCustomize.build_border('responsi_box_border_lr', 'left');
                css += responsiCustomize.build_border('responsi_box_border_lr', 'right');
                css += responsiCustomize.build_border_radius('responsi_box_border_radius');
                var _shadow = 'box-shadow:none !important;';
                if (responsi_box_shadow_inset != 'inset') {
                    _shadow += responsiCustomize.build_box_shadow('responsi_box_shadow', true);
                }
                css += _shadow;
                css += '}';


                css += 'body #wrapper-boxes-content {';
                css += responsiCustomize.build_background('responsi_box_inner_bg');
                css += responsiCustomize.build_padding_margin('responsi_box_inner_padding', 'padding');
                css += responsiCustomize.build_padding_margin('responsi_box_inner_margin', 'margin');
                css += responsiCustomize.build_border('responsi_box_inner_border_top', 'top');
                css += responsiCustomize.build_border('responsi_box_inner_border_bottom', 'bottom');
                css += responsiCustomize.build_border('responsi_box_inner_border_left', 'left');
                css += responsiCustomize.build_border('responsi_box_inner_border_right', 'right');
                css += responsiCustomize.build_border_radius('responsi_box_inner_border_radius');
                css += responsiCustomize.build_box_shadow('responsi_box_inner_shadow');
                css += '}';


            } else {
                css += '.layout-box-mode #wrapper-boxes {';
                css += 'padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;';
                css += '}';

                css += 'body #wrapper-boxes-content {';
                css += 'padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;background-color:transparent !important;';
                css += '}';
            }
        } else {
            css += '.layout-box-mode #wrapper-boxes {';
            css += 'padding:0 !important;margin:0 !important;border:none !important;border-radius:0px !important;box-shadow:none !important;';
            css += '}';

            css += 'body #wrapper-boxes-content {';
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
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_style_content();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(typeradius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_style_content();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_style_content();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_style_content();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_style_content();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_style_content();
            });
        });
    });


    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_style_content();
            });
        });
    });

    var responsi_header_animation = {
        'responsi_header_animation_1' : '#header_animation_1',
        'responsi_header_animation_2' : '#header_animation_2',
        'responsi_header_animation_3' : '#header_animation_3',
        'responsi_header_animation_4' : '#header_animation_4',
        'responsi_header_animation_5' : '#header_animation_5',
        'responsi_header_animation_6' : '#header_animation_6'
    };

    $.each( responsi_header_animation, function(inx, val) {

        wp.customize(inx+'[type]', function(value) {
            value.bind(function(to) {
                responsiCustomize.build_animation( val,inx );
            });
        });

        wp.customize(inx+'[duration]', function(value) {
            value.bind(function(to) {
                responsiCustomize.build_animation( val,inx );
            });
        });

        wp.customize(inx+'[delay]', function(value) {
            value.bind(function(to) {
                responsiCustomize.build_animation( val,inx );
            });
        });

        wp.customize(inx+'[direction]', function(value) {
            value.bind(function(to) {
                responsiCustomize.build_animation( val,inx );
            });
        });
    });

    var responsi_footer_animation = {
        'responsi_footer_animation_1' : '#footer_animation_1',
        'responsi_footer_animation_2' : '#footer_animation_2',
        'responsi_footer_animation_3' : '#footer_animation_3',
        'responsi_footer_animation_4' : '#footer_animation_4',
        'responsi_footer_animation_5' : '#footer_animation_5',
        'responsi_footer_animation_6' : '#footer_animation_6'
    };

    $.each( responsi_footer_animation, function(inx, val) {

        wp.customize(inx+'[type]', function(value) {
            value.bind(function(to) {
                responsiCustomize.build_animation( val,inx );
            });
        });

        wp.customize(inx+'[duration]', function(value) {
            value.bind(function(to) {
                responsiCustomize.build_animation( val,inx );
            });
        });

        wp.customize(inx+'[delay]', function(value) {
            value.bind(function(to) {
                responsiCustomize.build_animation( val,inx );
            });
        });

        wp.customize(inx+'[direction]', function(value) {
            value.bind(function(to) {
                responsiCustomize.build_animation( val,inx );
            });
        });
    });

})(jQuery);