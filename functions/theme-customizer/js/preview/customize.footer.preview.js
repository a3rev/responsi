/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {
    function responsi_preview_footer_widgets() {
        var css = '';
        var responsi_enable_before_footer_bg_image = wp.customize.value('responsi_enable_before_footer_bg_image')();
        var responsi_before_footer_bg_image = wp.customize.value('responsi_before_footer_bg_image')();
        var responsi_before_footer_bg_position_horizontal = wp.customize.value('responsi_before_footer_bg_position_horizontal')();
        var responsi_before_footer_bg_position_vertical = wp.customize.value('responsi_before_footer_bg_position_vertical')();
        var responsi_before_footer_bg_image_repeat = wp.customize.value('responsi_before_footer_bg_image_repeat')();

        css += '#wrapper-footer-top-content{';
        css += responsiCustomize.build_background('responsi_before_footer_bg', true);
        if (responsi_enable_before_footer_bg_image == 'true') {
            css += 'background-image: url(' + responsi_before_footer_bg_image + ') !important;';
            css += 'background-position:' + responsi_before_footer_bg_position_horizontal + ' ' + responsi_before_footer_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_before_footer_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += responsiCustomize.build_border('responsi_before_footer_border_top', 'top', true);
        css += responsiCustomize.build_border('responsi_before_footer_border_bottom', 'bottom', true);
        css += responsiCustomize.build_border('responsi_before_footer_border_lr', 'left', true);
        css += responsiCustomize.build_border('responsi_before_footer_border_lr', 'right', true);
        css += responsiCustomize.build_box_shadow('responsi_before_footer_box_shadow', true);
        css += responsiCustomize.build_padding_margin('responsi_before_footer_padding', 'padding', true);
        css += responsiCustomize.build_padding_margin('responsi_before_footer_margin', 'margin', true);
        css += responsiCustomize.build_border_radius('responsi_before_footer_border_radius_tl', 'top-left', true);
        css += responsiCustomize.build_border_radius('responsi_before_footer_border_radius_tr', 'top-right', true);
        css += responsiCustomize.build_border_radius('responsi_before_footer_border_radius_bl', 'bottom-left', true);
        css += responsiCustomize.build_border_radius('responsi_before_footer_border_radius_br', 'bottom-right', true);
        css += 'box-sizing: border-box;';
        css += '}';

        var responsi_enable_before_footer_content_bg_image = wp.customize.value('responsi_enable_before_footer_content_bg_image')();
        var responsi_before_footer_content_bg_image = wp.customize.value('responsi_before_footer_content_bg_image')();
        var responsi_before_footer_content_bg_position_horizontal = wp.customize.value('responsi_before_footer_content_bg_position_horizontal')();
        var responsi_before_footer_content_bg_position_vertical = wp.customize.value('responsi_before_footer_content_bg_position_vertical')();
        var responsi_before_footer_content_bg_image_repeat = wp.customize.value('responsi_before_footer_content_bg_image_repeat')();

        css += '#wrapper-footer-top-content #footer-top-content{';
        css += responsiCustomize.build_background('responsi_before_footer_content_bg', true);
        if (responsi_enable_before_footer_content_bg_image == 'true') {
            css += 'background-image: url(' + responsi_before_footer_content_bg_image + ') !important;';
            css += 'background-position:' + responsi_before_footer_content_bg_position_horizontal + ' ' + responsi_before_footer_content_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_before_footer_content_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += responsiCustomize.build_border('responsi_before_footer_content_border_top', 'top', true);
        css += responsiCustomize.build_border('responsi_before_footer_content_border_bottom', 'bottom', true);
        css += responsiCustomize.build_border('responsi_before_footer_content_border_lr', 'left', true);
        css += responsiCustomize.build_border('responsi_before_footer_content_border_lr', 'right', true);
        css += responsiCustomize.build_box_shadow('responsi_before_footer_content_box_shadow', true);
        css += responsiCustomize.build_padding_margin('responsi_before_footer_content_padding', 'padding', true);
        css += responsiCustomize.build_padding_margin('responsi_before_footer_content_margin', 'margin', true);
        css += responsiCustomize.build_border_radius('responsi_before_footer_content_border_radius_tl', 'top-left', true);
        css += responsiCustomize.build_border_radius('responsi_before_footer_content_border_radius_tr', 'top-right', true);
        css += responsiCustomize.build_border_radius('responsi_before_footer_content_border_radius_bl', 'bottom-left', true);
        css += responsiCustomize.build_border_radius('responsi_before_footer_content_border_radius_br', 'bottom-right', true);
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
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widgets();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(typeradius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widgets();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widgets();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widgets();
                });
            });
        });
    });

    $.each(position_fields, function(inx, val) {
        $.each(typepos, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widgets();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widgets();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_footer_widgets();
            });
        });
    });

    function responsi_preview_footer_widget_items() {
        var css = '';

        css += '.masonry_widget_footer .widget{';
        css += responsiCustomize.build_background('responsi_footer_widget_bg');
        css += responsiCustomize.build_padding_margin('responsi_footer_widget_padding', 'padding');
        css += responsiCustomize.build_border_boxes('responsi_footer_widget_border');
        css += responsiCustomize.build_box_shadow('responsi_footer_widget_box_shadow', true);
        css += 'text-align:' + wp.customize.value('responsi_font_footer_widget_text_alignment')() + ' !important;float: none !important';
        css += '}';


        var responsi_footer_widget_title_align = wp.customize.value('responsi_footer_widget_title_align')();
        css += '.masonry_widget_footer .fw_widget_title h3, .masonry_widget_footer .widget .fw_widget_title h3 {';
        css += responsiCustomize.build_background('responsi_footer_widget_title_bg', true);
        css += responsiCustomize.build_typography('responsi_font_footer_widget_title', true);
        css += 'text-align:' + wp.customize.value('responsi_footer_widget_title_text_alignment')() + ' !important;';
        css += 'text-transform:' + wp.customize.value('responsi_footer_widget_title_transform')() + ' !important;';
        css += responsiCustomize.build_padding_margin('responsi_footer_widget_title_padding', 'padding', true);
        css += responsiCustomize.build_padding_margin('responsi_footer_widget_title_margin', 'margin', true);
        css += responsiCustomize.build_border('responsi_footer_widget_title_border_top', 'top', true);
        css += responsiCustomize.build_border('responsi_footer_widget_title_border_bottom', 'bottom', true);
        css += responsiCustomize.build_border('responsi_footer_widget_title_border_left', 'left', true);
        css += responsiCustomize.build_border('responsi_footer_widget_title_border_right', 'right', true);
        css += responsiCustomize.build_border_radius('responsi_footer_widget_title_border_radius_tl', 'top-left', true);
        css += responsiCustomize.build_border_radius('responsi_footer_widget_title_border_radius_tr', 'top-right', true);
        css += responsiCustomize.build_border_radius('responsi_footer_widget_title_border_radius_bl', 'bottom-left', true);
        css += responsiCustomize.build_border_radius('responsi_footer_widget_title_border_radius_br', 'bottom-right', true);
        css += responsiCustomize.build_box_shadow('responsi_footer_widget_title_box_shadow', true);
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

        css += '.masonry_widget_footer .widget{';
        css += 'margin-bottom:' + wp.customize.value('responsi_footer_widget_margin_between')() + 'px;';
        css += '}';

        css += '.masonry_widget_footer .fw_widget_content {';
        css += responsiCustomize.build_padding_margin('responsi_footer_widget_content_padding', 'padding', true);
        css += '}';
        css += '.masonry_widget_footer .widget, .masonry_widget_footer .widget ul li, .masonry_widget_footer .widget ol li,.masonry_widget_footer .widget p, .masonry_widget_footer .widget .textwidget, .masonry_widget_footer .widget:not(div), .masonry_widget_footer .widget .textwidget .tel, .masonry_widget_footer .widget .textwidget .tel a, .masonry_widget_footer .widget .textwidget a[href^=tel], .masonry_widget_footer .widget * a[href^=tel], .masonry_widget_footer .widget a[href^=tel]{';
        css += 'text-decoration: none;';
        css += responsiCustomize.build_typography('responsi_font_footer_widget_text', true);
        css += '}';

        css += '.masonry_widget_footer .widget a, .masonry_widget_footer .widget a:link {';
        css += 'color: ' + wp.customize.value('responsi_footer_widget_link_color')() + ' !important;';
        css += '}';

        css += '.masonry_widget_footer .widget a:visited {';
        css += 'color: ' + wp.customize.value('responsi_footer_widget_link_visited_color')() + ' !important;';
        css += '}';

        css += '.masonry_widget_footer .widget a:hover {';
        css += 'color: ' + wp.customize.value('responsi_footer_widget_link_hover_color')() + ' !important;';
        css += '}';

        css += '#wrapper-footer-top .widget ul li a{';
        css += responsiCustomize.build_typography('responsi_font_footer_widget_list', true);
        css += '}';
        css += '#wrapper-footer-top .widget ul li a:visited{';
        css += 'color:' + wp.customize.value('responsi_footer_widget_link_visited_color')() + ' !important;';
        css += '}';
        css += '#wrapper-footer-top .widget ul li a:hover{';
        css += 'color:' + wp.customize.value('responsi_footer_widget_link_hover_color')() + ' !important;';
        css += '}';

        var responsi_before_footer_border_list_width = wp.customize.value('responsi_before_footer_border_list[width]')();
        css += '#wrapper-footer-top .widget ul li{';
        css += responsiCustomize.build_border('responsi_before_footer_border_list', 'top', true);
        css += '}';
        css += '#wrapper-footer-top .widget ul li:first-child{';
        css += 'border-top:none !important';
        css += '}';

        if (responsi_before_footer_border_list_width > 0) {
            css += '#wrapper-footer-top .widget ul li{margin-top: 5px !important;padding-top: 5px !important;}';
        } else {
            css += '#wrapper-footer-top .widget ul li{margin-top: 0 !important;padding: 0 !important;border-top:none !important;}';
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
        $.each(typefonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widget_items();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widget_items();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(typeborderboxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widget_items();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(typeradius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widget_items();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widget_items();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widget_items();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footer_widget_items();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_footer_widget_items();
            });
        });
    });

    //---------------------------------//

    function responsi_preview_footers() {
        var css = '';
        var responsi_footer_link_color = wp.customize.value('responsi_footer_link_color')();
        var responsi_footer_link_color_hover = wp.customize.value('responsi_footer_link_color_hover')();
        css += '#footer, #footer p {' + responsiCustomize.build_typography('responsi_footer_font') + '}';
        css += '#footer a, #footer * a,#footer a:active{color: ' + responsi_footer_link_color + ' !important;}';
        css += '#footer a:hover, #footer * a:hover ,#footer a:active:hover{color: ' + responsi_footer_link_color_hover + ' !important;}';

        var responsi_footer_custom_link_color = wp.customize.value('responsi_footer_custom_link_color')();
        var responsi_footer_custom_link_color_hover = wp.customize.value('responsi_footer_custom_link_color_hover')();
        css += '#footer#additional , #footer #additional p {' + responsiCustomize.build_typography('responsi_footer_custom_font') + '}';
        css += '#footer #additional a, #footer #additional * a,#footer #additional a:active{color: ' + responsi_footer_custom_link_color + ' !important;}';
        css += '#footer #additional a:hover, #footer #additional * a:hover ,#footer #additional a:active:hover{color: ' + responsi_footer_custom_link_color_hover + ' !important;}';

        var responsi_enable_footer_bg_image = wp.customize.value('responsi_enable_footer_bg_image')();
        var responsi_footer_bg_image = wp.customize.value('responsi_footer_bg_image')();
        var responsi_footer_bg_position_horizontal = wp.customize.value('responsi_footer_bg_position_horizontal')();
        var responsi_footer_bg_position_vertical = wp.customize.value('responsi_footer_bg_position_vertical')();
        var responsi_footer_bg_image_repeat = wp.customize.value('responsi_footer_bg_image_repeat')();
        css += '#wrapper-footer-content{';
        if (responsi_enable_footer_bg_image == 'true') {
            css += 'background-image: url(' + responsi_footer_bg_image + ') !important;';
            css += 'background-position:' + responsi_footer_bg_position_horizontal + ' ' + responsi_footer_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_footer_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += responsiCustomize.build_background('responsi_footer_bg', true);
        css += responsiCustomize.build_border('responsi_footer_border_top', 'top', true);
        css += responsiCustomize.build_border('responsi_footer_border_bottom', 'bottom', true);
        css += responsiCustomize.build_border('responsi_footer_border_lr', 'left', true);
        css += responsiCustomize.build_border('responsi_footer_border_lr', 'right', true);
        css += responsiCustomize.build_border_radius('responsi_footer_border_radius_tl', 'top-left', true);
        css += responsiCustomize.build_border_radius('responsi_footer_border_radius_tr', 'top-right', true);
        css += responsiCustomize.build_border_radius('responsi_footer_border_radius_bl', 'bottom-left', true);
        css += responsiCustomize.build_border_radius('responsi_footer_border_radius_br', 'bottom-right', true);
        css += responsiCustomize.build_padding_margin('responsi_footer_padding', 'padding', true);
        css += responsiCustomize.build_padding_margin('responsi_footer_margin', 'margin', true);
        css += responsiCustomize.build_box_shadow('responsi_footer_box_shadow', true);
        css += 'box-sizing: border-box;';
        css += '}';

        var responsi_enable_footer_content_bg_image = wp.customize.value('responsi_enable_footer_content_bg_image')();
        var responsi_footer_content_bg_image = wp.customize.value('responsi_footer_content_bg_image')();
        var responsi_footer_content_bg_position_horizontal = wp.customize.value('responsi_footer_content_bg_position_horizontal')();
        var responsi_footer_content_bg_position_vertical = wp.customize.value('responsi_footer_content_bg_position_vertical')();
        var responsi_footer_content_bg_image_repeat = wp.customize.value('responsi_footer_content_bg_image_repeat')();

        css += 'body #wrapper-footer #footer{';
        if (responsi_enable_footer_content_bg_image == 'true') {
            css += 'background-image: url(' + responsi_footer_content_bg_image + ') !important;';
            css += 'background-position:' + responsi_footer_content_bg_position_horizontal + ' ' + responsi_footer_content_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_footer_content_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += responsiCustomize.build_background('responsi_footer_content_bg', true);
        css += responsiCustomize.build_border('responsi_footer_content_border_top', 'top', true);
        css += responsiCustomize.build_border('responsi_footer_content_border_bottom', 'bottom', true);
        css += responsiCustomize.build_border('responsi_footer_content_border_lr', 'left', true);
        css += responsiCustomize.build_border('responsi_footer_content_border_lr', 'right', true);
        css += responsiCustomize.build_border_radius('responsi_footer_content_border_radius_tl', 'top-left', true);
        css += responsiCustomize.build_border_radius('responsi_footer_content_border_radius_tr', 'top-right', true);
        css += responsiCustomize.build_border_radius('responsi_footer_content_border_radius_bl', 'bottom-left', true);
        css += responsiCustomize.build_border_radius('responsi_footer_content_border_radius_br', 'bottom-right', true);
        css += responsiCustomize.build_padding_margin('responsi_footer_content_padding', 'padding', true);
        css += responsiCustomize.build_padding_margin('responsi_footer_content_margin', 'margin', true);
        css += responsiCustomize.build_box_shadow('responsi_footer_content_box_shadow', true);
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
        $.each(typefonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footers();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footers();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(typeradius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footers();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footers();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_footers();
                });
            });
        });
    });

    $.each(position_fields, function(inx, val) {
        $.each(typepos, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_footers();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_footers();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_footers();
            });
        });
    });
})(jQuery);