/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    function responsi_preview_headers() {
        var css = '';

        css += '.site-logo-container a.site-title, .site-logo-container a.site-title:hover, .site-logo-container a:link:hover, .site-title, a.site-title:link, a.site-title:hover, a.site-title:link:hover, .header-widget-1 a, .header-widget-1 a:hover, #header .header-widget-1 .widget a, #header .header-widget-1 .widget a:link, #header .header-widget-1 .widget a:link:hover {';
        css += responsiCustomize.build_typography('responsi_font_logo', true);
        css += '}';
        css += '.site-description {';
        css += responsiCustomize.build_typography('responsi_font_desc');
        css += '}';

        var responsi_enable_header_bg_image = wp.customize.value('responsi_enable_header_bg_image')();
        var responsi_header_bg_image = wp.customize.value('responsi_header_bg_image')();
        var responsi_bg_header_position_vertical = wp.customize.value('responsi_bg_header_position_vertical')();
        var responsi_bg_header_position_horizontal = wp.customize.value('responsi_bg_header_position_horizontal')();
        var responsi_header_bg_image_repeat = wp.customize.value('responsi_header_bg_image_repeat')();

        css += '#wrapper-header-content{';
        css += 'z-index:0;';
        css += responsiCustomize.build_background('responsi_header_bg');
        if (responsi_enable_header_bg_image == 'true') {
            css += 'background-image: url(' + responsi_header_bg_image + ');';
            css += 'background-position:' + responsi_bg_header_position_horizontal + ' ' + responsi_bg_header_position_vertical + ';';
            css += 'background-repeat:' + responsi_header_bg_image_repeat + ';';
        } else {
            css += 'background-image: none;';
        }
        css += responsiCustomize.build_padding_margin('responsi_header_padding', 'padding', true);
        css += responsiCustomize.build_padding_margin('responsi_header_margin', 'margin', true);
        css += responsiCustomize.build_border('responsi_header_border_top', 'top');
        css += responsiCustomize.build_border('responsi_header_border_bottom', 'bottom', true);
        css += responsiCustomize.build_border('responsi_header_border_lr', 'left', true);
        css += responsiCustomize.build_border('responsi_header_border_lr', 'right', true);
        css += responsiCustomize.build_box_shadow('responsi_header_box_shadow', true);
        css += '}';


        var responsi_enable_header_inner_bg_image = wp.customize.value('responsi_enable_header_inner_bg_image')();
        var responsi_header_inner_bg_image = wp.customize.value('responsi_header_inner_bg_image')();
        var responsi_bg_header_inner_position_vertical = wp.customize.value('responsi_bg_header_inner_position_vertical')();
        var responsi_bg_header_inner_position_horizontal = wp.customize.value('responsi_bg_header_inner_position_horizontal')();
        var responsi_header_inner_bg_image_repeat = wp.customize.value('responsi_header_inner_bg_image_repeat')();

        css += '#header-content{';
        css += responsiCustomize.build_background('responsi_header_inner_bg');
        if (responsi_enable_header_inner_bg_image == 'true') {
            css += 'background-image: url(' + responsi_header_inner_bg_image + ');';
            css += 'background-position:' + responsi_bg_header_inner_position_horizontal + ' ' + responsi_bg_header_inner_position_vertical + ';';
            css += 'background-repeat:' + responsi_header_inner_bg_image_repeat + ';';
        } else {
            css += 'background-image: none;';
        }
        css += responsiCustomize.build_padding_margin('responsi_header_inner_padding', 'padding', true);
        css += responsiCustomize.build_padding_margin('responsi_header_inner_margin', 'margin', true);
        css += responsiCustomize.build_border('responsi_header_inner_border_top', 'top');
        css += responsiCustomize.build_border('responsi_header_inner_border_bottom', 'bottom', true);
        css += responsiCustomize.build_border('responsi_header_inner_border_lr', 'left', true);
        css += responsiCustomize.build_border('responsi_header_inner_border_lr', 'right', true);
        css += responsiCustomize.build_box_shadow('responsi_header_inner_box_shadow', true);
        css += '}';

        css += '.masonry_widget_header .fw_widget_title h3 {';
        css += responsiCustomize.build_typography('responsi_font_header_widget_title');
        css += '}';
        css += '#header .widget .textwidget, #header .widget:not(div), #header .widget p,#header .widget label,#header .widget .textwidget,#header .login-username label, #header .login-password label, #header .widget .textwidget .tel, #header .widget .textwidget .tel a, #header .widget .textwidget a[href^=tel], #header .widget * a[href^=tel], #header .widget a[href^=tel]{';
        css += responsiCustomize.build_typography('responsi_font_header_widget_text');
        css += 'text-decoration: none;';
        css += '}';
        css += '#header .widget a,#header .widget ul li a,#header .widget ul li{';
        css += responsiCustomize.build_typography('responsi_font_header_widget_link');
        css += 'text-decoration: none;';
        css += '}';
        var responsi_font_header_widget_link_hover = wp.customize.value('responsi_font_header_widget_link_hover')();
        css += '#header .widget a:hover{color:' + responsi_font_header_widget_link_hover + ';}';
        
        css += '.masonry_widget_header .widget{text-align:' + wp.customize.value('responsi_font_header_widget_text_alignment')() + ';}';

        var header_widgets_margin = 0;
        if (wp.customize.value('responsi_header_widget_mobile_margin')() == 'true' && wp.customize.value('responsi_header_widget_mobile_margin_between')() >= 0) {
            header_widgets_margin = wp.customize.value('responsi_header_widget_mobile_margin_between')();
        }

        if (wp.customize.value('responsi_font_header_widget_text_alignment_mobile')() == 'true') {
            var center_header_widget_mobile = '.masonry_widget_header .widget, .masonry_widget_header * .widget, .masonry_widget_header .widget *, .masonry_widget_header .widget .fw_widget_title h3 {text-align:center !important;}.logo.site-logo,.site-logo-container,.site-description-container{margin:auto;}';
        } else {
            var center_header_widget_mobile = '.masonry_widget_header .widget, .masonry_widget_header * .widget, .masonry_widget_header .widget *, .masonry_widget_header .widget .fw_widget_title h3 {text-align:' + wp.customize.value('responsi_font_header_widget_text_alignment')() + ' !important;}.logo.site-logo,.site-logo-container,.site-description-container{margin:auto;}';
        }

        css += '@media only screen and (max-width: 720px) {';
        css += 'body #header .widget{ margin-bottom:' + header_widgets_margin + 'px !important;}';
        css += center_header_widget_mobile;
        css += '}';

        if ($('#custom_header').length > 0) {
            $('#custom_header').html(css);
        } else {
            $('head').append('<style id="custom_header">' + css + '</style>');
        }
    }

    var fonts_fields = [
        'responsi_font_logo',
        'responsi_font_desc',
        'responsi_font_header_widget_title',
        'responsi_font_header_widget_text',
        'responsi_font_header_widget_link'
    ];

    var single_fields = [
        'responsi_font_header_widget_text_alignment_mobile',
        'responsi_enable_header_bg_image',
        'responsi_header_bg_image',
        'responsi_header_bg_image_repeat',
        'responsi_enable_header_inner_bg_image',
        'responsi_header_inner_bg_image',
        'responsi_header_inner_bg_image_repeat',
        'responsi_font_header_widget_link_hover',
        'responsi_font_header_widget_text_alignment',
        'responsi_header_widget_mobile_margin',
        'responsi_header_widget_mobile_margin_between'
    ];

    var bg_fields = [
        'responsi_header_bg',
        'responsi_header_inner_bg'
    ];

    var border_fields = [
        'responsi_header_border_top',
        'responsi_header_border_bottom',
        'responsi_header_border_lr',
        'responsi_header_inner_border_top',
        'responsi_header_inner_border_bottom',
        'responsi_header_inner_border_lr'
    ];

    var shadow_fields = [
        'responsi_header_box_shadow',
        'responsi_header_inner_box_shadow'
    ];

    var margin_padding_fields = [
        'responsi_header_margin',
        'responsi_header_padding',
        'responsi_header_inner_margin',
        'responsi_header_inner_padding'
    ];

    var position_fields = [
        'responsi_bg_header_position',
        'responsi_bg_header_inner_position',
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(typefonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_headers();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_headers();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_headers();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_headers();
                });
            });
        });
    });

    $.each(position_fields, function(inx, val) {
        $.each(typepos, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_headers();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_headers();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_headers();
            });
        });
    });

})(jQuery);