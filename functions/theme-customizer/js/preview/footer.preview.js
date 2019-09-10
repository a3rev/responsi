/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {
    function _previewFooterWidgets() {
        var css = '';
        var responsi_enable_before_footer_bg_image = wp.customize.value('responsi_enable_before_footer_bg_image')();
        var responsi_before_footer_bg_image = wp.customize.value('responsi_before_footer_bg_image')();
        var responsi_before_footer_bg_position_horizontal = wp.customize.value('responsi_before_footer_bg_position_horizontal')();
        var responsi_before_footer_bg_position_vertical = wp.customize.value('responsi_before_footer_bg_position_vertical')();
        var responsi_before_footer_bg_image_repeat = wp.customize.value('responsi_before_footer_bg_image_repeat')();

        css += '.responsi-footer-widgets{';
        css += _cFn.renderBG('responsi_before_footer_bg', true);
        if (responsi_enable_before_footer_bg_image == 'true') {
            css += 'background-image: url(' + responsi_before_footer_bg_image + ') !important;';
            css += 'background-position:' + responsi_before_footer_bg_position_horizontal + ' ' + responsi_before_footer_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_before_footer_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += _cFn.renderBorder('responsi_before_footer_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_before_footer_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_before_footer_border_lr', 'left', true);
        css += _cFn.renderBorder('responsi_before_footer_border_lr', 'right', true);
        css += _cFn.renderShadow('responsi_before_footer_box_shadow', true);
        css += _cFn.renderMarPad('responsi_before_footer_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_before_footer_margin', 'margin', true);
        css += _cFn.renderRadius('responsi_before_footer_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_before_footer_border_radius_tr', 'top-right', true);
        css += _cFn.renderRadius('responsi_before_footer_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_before_footer_border_radius_br', 'bottom-right', true);
        css += 'box-sizing: border-box;';
        css += '}';

        var responsi_enable_before_footer_content_bg_image = wp.customize.value('responsi_enable_before_footer_content_bg_image')();
        var responsi_before_footer_content_bg_image = wp.customize.value('responsi_before_footer_content_bg_image')();
        var responsi_before_footer_content_bg_position_horizontal = wp.customize.value('responsi_before_footer_content_bg_position_horizontal')();
        var responsi_before_footer_content_bg_position_vertical = wp.customize.value('responsi_before_footer_content_bg_position_vertical')();
        var responsi_before_footer_content_bg_image_repeat = wp.customize.value('responsi_before_footer_content_bg_image_repeat')();

        css += '.responsi-footer-widgets .footer-widgets-in{';
        css += _cFn.renderBG('responsi_before_footer_content_bg', true);
        if (responsi_enable_before_footer_content_bg_image == 'true') {
            css += 'background-image: url(' + responsi_before_footer_content_bg_image + ') !important;';
            css += 'background-position:' + responsi_before_footer_content_bg_position_horizontal + ' ' + responsi_before_footer_content_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_before_footer_content_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += _cFn.renderBorder('responsi_before_footer_content_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_before_footer_content_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_before_footer_content_border_lr', 'left', true);
        css += _cFn.renderBorder('responsi_before_footer_content_border_lr', 'right', true);
        css += _cFn.renderShadow('responsi_before_footer_content_box_shadow', true);
        css += _cFn.renderMarPad('responsi_before_footer_content_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_before_footer_content_margin', 'margin', true);
        css += _cFn.renderRadius('responsi_before_footer_content_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_before_footer_content_border_radius_tr', 'top-right', true);
        css += _cFn.renderRadius('responsi_before_footer_content_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_before_footer_content_border_radius_br', 'bottom-right', true);
        css += 'box-sizing: border-box;';
        css += '}';

        if ($('#custom_footer_widgets').length > 0) {
            $('#custom_footer_widgets').html(css);
        } else {
            $('head').append('<style id="custom_footer_widgets">' + css + '</style>');
        }
    }

    var single_fields = [
        'responsi_enable_before_footer_bg_image',
        'responsi_before_footer_bg_image',
        'responsi_before_footer_bg_image_repeat',
        'responsi_enable_before_footer_content_bg_image',
        'responsi_before_footer_content_bg_image',
        'responsi_before_footer_content_bg_image_repeat'

    ];

    var bg_fields = [
        'responsi_before_footer_bg',
        'responsi_before_footer_content_bg',
    ];

    var border_fields = [
        'responsi_before_footer_border_top',
        'responsi_before_footer_border_bottom',
        'responsi_before_footer_border_lr',
        'responsi_before_footer_content_border_top',
        'responsi_before_footer_content_border_bottom',
        'responsi_before_footer_content_border_lr',

    ];

    var border_radius_fields = [
        'responsi_before_footer_border_radius_tl',
        'responsi_before_footer_border_radius_tr',
        'responsi_before_footer_border_radius_bl',
        'responsi_before_footer_border_radius_br',
        'responsi_before_footer_content_border_radius_tl',
        'responsi_before_footer_content_border_radius_tr',
        'responsi_before_footer_content_border_radius_bl',
        'responsi_before_footer_content_border_radius_br',
    ];

    var shadow_fields = [
        'responsi_before_footer_box_shadow',
        'responsi_before_footer_content_box_shadow'
    ];

    var margin_padding_fields = [
        'responsi_before_footer_margin',
        'responsi_before_footer_padding',
        'responsi_before_footer_content_margin',
        'responsi_before_footer_content_padding',
    ];

    var position_fields = [
        'responsi_before_footer_bg_position',
        'responsi_before_footer_content_bg_position'
    ];

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgets();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgets();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgets();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewFooterWidgets();
                });
            });
        });
    });

    $.each(position_fields, function(inx, val) {
        $.each(window.ctrlPos, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewFooterWidgets();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgets();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewFooterWidgets();
            });
        });
    });

    function _previewFooterWidgetItems() {
        var css = '';

        css += '.msr-wg-footer .widget{';
        css += _cFn.renderBG('responsi_footer_widget_bg');
        css += _cFn.renderMarPad('responsi_footer_widget_padding', 'padding');
        css += _cFn.renderBorderBoxs('responsi_footer_widget_border');
        css += _cFn.renderShadow('responsi_footer_widget_box_shadow', true);
        css += 'text-align:' + wp.customize.value('responsi_font_footer_widget_text_alignment')() + ' !important;float: none !important';
        css += '}';


        var responsi_footer_widget_title_align = wp.customize.value('responsi_footer_widget_title_align')();
        css += '.msr-wg-footer .widget-title h3, .msr-wg-footer .widget .widget-title h3 {';
        css += _cFn.renderBG('responsi_footer_widget_title_bg', true);
        css += _cFn.renderTypo('responsi_font_footer_widget_title', true);
        css += 'text-align:' + wp.customize.value('responsi_footer_widget_title_text_alignment')() + ' !important;';
        css += 'text-transform:' + wp.customize.value('responsi_footer_widget_title_transform')() + ' !important;';
        css += _cFn.renderMarPad('responsi_footer_widget_title_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_footer_widget_title_margin', 'margin', true);
        css += _cFn.renderBorder('responsi_footer_widget_title_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_footer_widget_title_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_footer_widget_title_border_left', 'left', true);
        css += _cFn.renderBorder('responsi_footer_widget_title_border_right', 'right', true);
        css += _cFn.renderRadius('responsi_footer_widget_title_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_footer_widget_title_border_radius_tr', 'top-right', true);
        css += _cFn.renderRadius('responsi_footer_widget_title_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_footer_widget_title_border_radius_br', 'bottom-right', true);
        css += _cFn.renderShadow('responsi_footer_widget_title_box_shadow', true);
        if (responsi_footer_widget_title_align == 'left') {
            css += 'float:left !important;';
        }
        if (responsi_footer_widget_title_align == 'right') {
            css += 'float:right !important;';
        }
        if (responsi_footer_widget_title_align == 'center') {
            css += 'float:none !important;margin-left:auto !important;margin-right:auto !important;display:table;';
        }
        if (responsi_footer_widget_title_align == 'stretched') {
            css += 'float:none !important;display:block;';
        }
        css += '}';

        css += '.msr-wg-footer .widget{';
        css += 'margin-bottom:' + wp.customize.value('responsi_footer_widget_margin_between')() + 'px;';
        css += '}';

        css += '.msr-wg-footer .widget-content {';
        css += _cFn.renderMarPad('responsi_footer_widget_content_padding', 'padding', true);
        css += '}';
        css += '.msr-wg-footer .widget, .msr-wg-footer .widget ul li, .msr-wg-footer .widget ol li,.msr-wg-footer .widget p, .msr-wg-footer .widget .textwidget, .msr-wg-footer .widget:not(div), .msr-wg-footer .widget .textwidget .tel, .msr-wg-footer .widget .textwidget .tel a, .msr-wg-footer .widget .textwidget a[href^=tel], .msr-wg-footer .widget * a[href^=tel], .msr-wg-footer .widget a[href^=tel]{';
        css += 'text-decoration: none;';
        css += _cFn.renderTypo('responsi_font_footer_widget_text', true);
        css += '}';

        css += '.msr-wg-footer .widget a, .msr-wg-footer .widget a:link {';
        css += 'color: ' + wp.customize.value('responsi_footer_widget_link_color')() + ' !important;';
        css += '}';

        css += '.msr-wg-footer .widget a:visited {';
        css += 'color: ' + wp.customize.value('responsi_footer_widget_link_visited_color')() + ' !important;';
        css += '}';

        css += '.msr-wg-footer .widget a:hover {';
        css += 'color: ' + wp.customize.value('responsi_footer_widget_link_hover_color')() + ' !important;';
        css += '}';

        css += '.footer-widgets-ctn .widget ul li a{';
        css += _cFn.renderTypo('responsi_font_footer_widget_list', true);
        css += '}';
        css += '.footer-widgets-ctn .widget ul li a:visited{';
        css += 'color:' + wp.customize.value('responsi_footer_widget_link_visited_color')() + ' !important;';
        css += '}';
        css += '.footer-widgets-ctn .widget ul li a:hover{';
        css += 'color:' + wp.customize.value('responsi_footer_widget_link_hover_color')() + ' !important;';
        css += '}';

        var responsi_before_footer_border_list_width = wp.customize.value('responsi_before_footer_border_list[width]')();
        css += '.footer-widgets-ctn .widget ul li{';
        css += _cFn.renderBorder('responsi_before_footer_border_list', 'top', true);
        css += '}';
        css += '.footer-widgets-ctn .widget ul li:first-child{';
        css += 'border-top:none !important';
        css += '}';

        if (responsi_before_footer_border_list_width > 0) {
            css += '.footer-widgets-ctn .widget ul li{margin-top: 5px !important;padding-top: 5px !important;}';
        } else {
            css += '.footer-widgets-ctn .widget ul li{margin-top: 0 !important;padding: 0 !important;border-top:none !important;}';
        }

        if ($('#custom_footer_widget_items').length > 0) {
            $('#custom_footer_widget_items').html(css);
        } else {
            $('head').append('<style id="custom_footer_widget_items">' + css + '</style>');
        }
    }

    var fonts_fields = [
        'responsi_font_footer_widget_title',
        'responsi_font_footer_widget_text',
        'responsi_font_footer_widget_list'
    ];

    var single_fields = [
        'responsi_footer_widget_title_text_alignment',
        'responsi_footer_widget_title_transform',
        'responsi_footer_widget_title_align',
        'responsi_footer_widget_link_color',
        'responsi_footer_widget_link_hover_color',
        'responsi_footer_widget_link_visited_color',
        'responsi_font_footer_widget_text_alignment',
        'responsi_footer_widget_margin_between',
    ];

    var bg_fields = [
        'responsi_footer_widget_bg',
        'responsi_footer_widget_title_bg',
    ];

    var border_fields = [
        'responsi_footer_widget_title_border_top',
        'responsi_footer_widget_title_border_bottom',
        'responsi_footer_widget_title_border_left',
        'responsi_footer_widget_title_border_right',
        'responsi_before_footer_border_list',
    ];

    var border_boxes_fields = [
        'responsi_footer_widget_border',
    ]

    var border_radius_fields = [
        'responsi_footer_widget_title_border_radius_tl',
        'responsi_footer_widget_title_border_radius_tr',
        'responsi_footer_widget_title_border_radius_bl',
        'responsi_footer_widget_title_border_radius_br',
    ];

    var shadow_fields = [
        'responsi_footer_widget_box_shadow',
        'responsi_footer_widget_title_box_shadow'
    ];

    var margin_padding_fields = [
        'responsi_footer_widget_padding',
        'responsi_footer_widget_title_margin',
        'responsi_footer_widget_title_padding',
        'responsi_footer_widget_content_padding'
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(window.ctrlFonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgetItems();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgetItems();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(window.ctrlBorderBoxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgetItems();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgetItems();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgetItems();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewFooterWidgetItems();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooterWidgetItems();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewFooterWidgetItems();
            });
        });
    });

    //---------------------------------//

    function _previewFooters() {
        var css = '';
        var responsi_footer_link_color = wp.customize.value('responsi_footer_link_color')();
        var responsi_footer_link_color_hover = wp.customize.value('responsi_footer_link_color_hover')();
        css += '.footer, .footer p {' + _cFn.renderTypo('responsi_footer_font') + '}';
        css += '.footer a, .footer * a,.footer a:active{color: ' + responsi_footer_link_color + ' !important;}';
        css += '.footer a:hover, .footer * a:hover ,.footer a:active:hover{color: ' + responsi_footer_link_color_hover + ' !important;}';

        var responsi_footer_custom_link_color = wp.customize.value('responsi_footer_custom_link_color')();
        var responsi_footer_custom_link_color_hover = wp.customize.value('responsi_footer_custom_link_color_hover')();
        css += '.footer.additional , .footer .additional p {' + _cFn.renderTypo('responsi_footer_custom_font') + '}';
        css += '.footer .additional a, .footer .additional * a,.footer .additional a:active{color: ' + responsi_footer_custom_link_color + ' !important;}';
        css += '.footer .additional a:hover, .footer .additional * a:hover ,.footer .additional a:active:hover{color: ' + responsi_footer_custom_link_color_hover + ' !important;}';

        var responsi_enable_footer_bg_image = wp.customize.value('responsi_enable_footer_bg_image')();
        var responsi_footer_bg_image = wp.customize.value('responsi_footer_bg_image')();
        var responsi_footer_bg_position_horizontal = wp.customize.value('responsi_footer_bg_position_horizontal')();
        var responsi_footer_bg_position_vertical = wp.customize.value('responsi_footer_bg_position_vertical')();
        var responsi_footer_bg_image_repeat = wp.customize.value('responsi_footer_bg_image_repeat')();
        css += '.responsi-footer{';
        if (responsi_enable_footer_bg_image == 'true') {
            css += 'background-image: url(' + responsi_footer_bg_image + ') !important;';
            css += 'background-position:' + responsi_footer_bg_position_horizontal + ' ' + responsi_footer_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_footer_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += _cFn.renderBG('responsi_footer_bg', true);
        css += _cFn.renderBorder('responsi_footer_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_footer_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_footer_border_lr', 'left', true);
        css += _cFn.renderBorder('responsi_footer_border_lr', 'right', true);
        css += _cFn.renderRadius('responsi_footer_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_footer_border_radius_tr', 'top-right', true);
        css += _cFn.renderRadius('responsi_footer_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_footer_border_radius_br', 'bottom-right', true);
        css += _cFn.renderMarPad('responsi_footer_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_footer_margin', 'margin', true);
        css += _cFn.renderShadow('responsi_footer_box_shadow', true);
        css += 'box-sizing: border-box;';
        css += '}';

        var responsi_enable_footer_content_bg_image = wp.customize.value('responsi_enable_footer_content_bg_image')();
        var responsi_footer_content_bg_image = wp.customize.value('responsi_footer_content_bg_image')();
        var responsi_footer_content_bg_position_horizontal = wp.customize.value('responsi_footer_content_bg_position_horizontal')();
        var responsi_footer_content_bg_position_vertical = wp.customize.value('responsi_footer_content_bg_position_vertical')();
        var responsi_footer_content_bg_image_repeat = wp.customize.value('responsi_footer_content_bg_image_repeat')();

        css += '.footer-ctn .footer{';
        if (responsi_enable_footer_content_bg_image == 'true') {
            css += 'background-image: url(' + responsi_footer_content_bg_image + ') !important;';
            css += 'background-position:' + responsi_footer_content_bg_position_horizontal + ' ' + responsi_footer_content_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_footer_content_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += _cFn.renderBG('responsi_footer_content_bg', true);
        css += _cFn.renderBorder('responsi_footer_content_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_footer_content_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_footer_content_border_lr', 'left', true);
        css += _cFn.renderBorder('responsi_footer_content_border_lr', 'right', true);
        css += _cFn.renderRadius('responsi_footer_content_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_footer_content_border_radius_tr', 'top-right', true);
        css += _cFn.renderRadius('responsi_footer_content_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_footer_content_border_radius_br', 'bottom-right', true);
        css += _cFn.renderMarPad('responsi_footer_content_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_footer_content_margin', 'margin', true);
        css += _cFn.renderShadow('responsi_footer_content_box_shadow', true);
        css += 'box-sizing: border-box;';
        css += '}';

        if ($('#custom_footers').length > 0) {
            $('#custom_footers').html(css);
        } else {
            $('head').append('<style id="custom_footers">' + css + '</style>');
        }
    }

    var fonts_fields = [
        'responsi_footer_font',
        'responsi_footer_custom_font',
    ];

    var single_fields = [
        'responsi_footer_link_color',
        'responsi_footer_link_color_hover',
        'responsi_footer_custom_link_color',
        'responsi_footer_custom_link_color_hover',
        'responsi_enable_footer_bg_image',
        'responsi_footer_bg_image',
        'responsi_footer_bg_image_repeat',
        'responsi_enable_footer_content_bg_image',
        'responsi_footer_content_bg_image',
        'responsi_footer_content_bg_image_repeat',
    ];

    var bg_fields = [
        'responsi_footer_bg',
        'responsi_footer_content_bg',
    ];

    var border_fields = [
        'responsi_footer_border_top',
        'responsi_footer_border_bottom',
        'responsi_footer_border_lr',
        'responsi_footer_content_border_top',
        'responsi_footer_content_border_bottom',
        'responsi_footer_content_border_lr',


    ];

    var border_radius_fields = [
        'responsi_footer_border_radius_tl',
        'responsi_footer_border_radius_tr',
        'responsi_footer_border_radius_bl',
        'responsi_footer_border_radius_br',
        'responsi_footer_content_border_radius_tl',
        'responsi_footer_content_border_radius_tr',
        'responsi_footer_content_border_radius_bl',
        'responsi_footer_content_border_radius_br',
    ];

    var shadow_fields = [
        'responsi_footer_box_shadow',
        'responsi_footer_content_box_shadow'
    ];

    var margin_padding_fields = [
        'responsi_footer_margin',
        'responsi_footer_padding',
        'responsi_footer_content_margin',
        'responsi_footer_content_padding',
    ];

    var position_fields = [
        'responsi_footer_bg_position',
        'responsi_footer_content_bg_position'
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(window.ctrlFonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooters();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooters();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooters();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooters();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewFooters();
                });
            });
        });
    });

    $.each(position_fields, function(inx, val) {
        $.each(window.ctrlPos, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewFooters();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewFooters();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewFooters();
            });
        });
    });

    wp.customize('responsi_additional_animation[type]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.additional-animation', 'responsi_additional_animation' );
        });
    });

    wp.customize('responsi_additional_animation[duration]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.additional-animation', 'responsi_additional_animation' );
        });
    });

    wp.customize('responsi_additional_animation[delay]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.additional-animation', 'responsi_additional_animation' );
        });
    });

    wp.customize('responsi_additional_animation[direction]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.additional-animation', 'responsi_additional_animation' );
        });
    });

    wp.customize('responsi_footer_left_animation[type]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.copyright-animation', 'responsi_footer_left_animation' );
        });
    });

    wp.customize('responsi_footer_left_animation[duration]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.copyright-animation', 'responsi_footer_left_animation' );
        });
    });

    wp.customize('responsi_footer_left_animation[delay]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.copyright-animation', 'responsi_footer_left_animation' );
        });
    });

    wp.customize('responsi_footer_left_animation[direction]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.copyright-animation', 'responsi_footer_left_animation' );
        });
    });

    wp.customize('responsi_footer_link_animation[type]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.credit-animation', 'responsi_footer_link_animation' );
        });
    });

    wp.customize('responsi_footer_link_animation[duration]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.credit-animation', 'responsi_footer_link_animation' );
        });
    });

    wp.customize('responsi_footer_link_animation[delay]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.credit-animation', 'responsi_footer_link_animation' );
        });
    });

    wp.customize('responsi_footer_link_animation[direction]', function(value) {
        value.bind(function(to) {
            _cFn.renderAnimation( '.credit-animation', 'responsi_footer_link_animation' );
        });
    });

})(jQuery);