/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    function responsi_preview_settings() {
        var css = '';
        var responsi_button_text_transform = wp.customize.value('responsi_button_text_transform')();
        var responsi_button_color = wp.customize.value('responsi_button_color')();
        var responsi_button_gradient_from = wp.customize.value('responsi_button_gradient_from')();
        var responsi_button_gradient_to = wp.customize.value('responsi_button_gradient_to')();

        var responsi_button_text_shadow = wp.customize.value('responsi_button_text_shadow')();
        var button_text_shadow = '0 0px 0px rgba(0, 0, 0, 0.25)';
        if (responsi_button_text_shadow == 'true') {
            button_text_shadow = '0 -1px 1px rgba(0, 0, 0, 0.25)';
        }

        css += 'a.button, a.button:visited, button, .button, body #wrapper #content .button, body #wrapper #content .button:visited, body #wrapper #content .comment-entry div.reply a, body #wrapper #content #respond .form-submit input#submit, .custom_contact_popup input[type="submit"], input[type="submit"], input[type="button"],input[type="reset"]{text-shadow: ' + button_text_shadow + ' !important;' + responsiCustomize.build_padding_margin('responsi_button_padding', 'padding') + responsiCustomize.build_typography('responsi_button_text') + 'text-transform: ' + responsi_button_text_transform + ';' + responsiCustomize.build_border('responsi_button_border_top', 'top') + responsiCustomize.build_border('responsi_button_border_bottom', 'bottom') + responsiCustomize.build_border('responsi_button_border_left', 'left') + responsiCustomize.build_border('responsi_button_border_right', 'right') + 'background-color: ' + responsi_button_color + ';background: ' + responsi_button_color + ';background: linear-gradient( ' + responsi_button_gradient_from + ' , ' + responsi_button_gradient_to + ' );' + responsiCustomize.build_border_radius('responsi_button_border_radius_tl', 'top-left') + responsiCustomize.build_border_radius('responsi_button_border_radius_tr', 'top-right') + responsiCustomize.build_border_radius('responsi_button_border_radius_bl', 'bottom-left') + responsiCustomize.build_border_radius('responsi_button_border_radius_br', 'bottom-right') + responsiCustomize.build_box_shadow('responsi_button_border_box_shadow') + '}';

        var responsi_link_color = wp.customize.value('responsi_link_color')();
        var responsi_link_hover_color = wp.customize.value('responsi_link_hover_color')();
        var responsi_link_visited_color = wp.customize.value('responsi_link_visited_color')();
        css += 'a,a:link {color:' + responsi_link_color + '}';
        css += 'a:visited {color:' + responsi_link_visited_color + '}';
        css += 'a:hover, .post-meta a:hover, .post p.tags a:hover,.post-entries a:hover,.responsi-pagination a:hover, .responsi-pagination a:hover,.click_showmore a:hover,.click_showmore a:hover,#header .widget a:hover,#wrapper-footer-top .widget ul li a:hover,body.category #main .box-item .entry-item h3 a:hover,body.tag #main .box-item .entry-item h3 a:hover,body.page-template-template-blog-php #main .box-item .entry-item h3 a:hover, .box-item .entry-item h3 a:hover,#main .blog-post.box-item .entry-item h3 a:link:hover, #main .blog-post.box-item .entry-item h3 a:visited:hover {color:' + responsi_link_hover_color + '}';

        css += 'body{' + responsiCustomize.build_typography('responsi_font_text') + '}';
        css += 'h1{' + responsiCustomize.build_typography('responsi_font_h1') + '}';
        css += 'h2{' + responsiCustomize.build_typography('responsi_font_h2') + '}';
        css += 'h3{' + responsiCustomize.build_typography('responsi_font_h3') + '}';
        css += 'h4{' + responsiCustomize.build_typography('responsi_font_h4') + '}';
        css += 'h5{' + responsiCustomize.build_typography('responsi_font_h5') + '}';
        css += 'h6{' + responsiCustomize.build_typography('responsi_font_h6') + '}';

        var responsi_breadcrumbs_show = wp.customize.value('responsi_breadcrumbs_show')();
        var responsi_breadcrumbs_link = wp.customize.value('responsi_breadcrumbs_link')();
        var responsi_breadcrumbs_link_hover = wp.customize.value('responsi_breadcrumbs_link_hover')();
        var responsi_breadcrumbs_sep = wp.customize.value('responsi_breadcrumbs_sep')();
        if (responsi_breadcrumbs_show == 'true') {
            css += '.breadcrumbs,.breadcrumbs span.trail-end{' + responsiCustomize.build_typography('responsi_breadcrumbs_font', true) + '}';
            css += '.breadcrumbs a{color:' + responsi_breadcrumbs_link + ' !important;}';
            css += '.breadcrumbs a:hover{color:' + responsi_breadcrumbs_link_hover + ' !important;}';
            css += '.breadcrumbs span.sep,.breadcrumbs .sep{color:' + responsi_breadcrumbs_sep + ' !important;}';
        } else {
            css += '.breadcrumbs{display:none;}';
        }
        css += '.breadcrumbs{';
        css += responsiCustomize.build_padding_margin('responsi_breadcrumbs_padding', 'padding', true);
        css += responsiCustomize.build_padding_margin('responsi_breadcrumbs_margin', 'margin', true);
        css += responsiCustomize.build_background('responsi_breadcrumbs_bg', true);
        css += responsiCustomize.build_border('responsi_breadcrumbs_border_top', 'top', true);
        css += responsiCustomize.build_border('responsi_breadcrumbs_border_bottom', 'bottom', true);
        css += responsiCustomize.build_border('responsi_breadcrumbs_border_lr', 'left', true);
        css += responsiCustomize.build_border('responsi_breadcrumbs_border_lr', 'right', true);
        css += responsiCustomize.build_border_radius('responsi_breadcrumbs_border_radius', '', true);
        css += responsiCustomize.build_box_shadow('responsi_breadcrumbs_box_shadow', true);
        css += '}';

        if ($('#custom_setting_style').length > 0) {
            $('#custom_setting_style').html(css);
        } else {
            $('head').append('<style id="custom_setting_style">' + css + '</style>');
        }
    }

    var fonts_fields = [
        'responsi_button_text',
        'responsi_font_text',
        'responsi_font_h1',
        'responsi_font_h2',
        'responsi_font_h3',
        'responsi_font_h4',
        'responsi_font_h5',
        'responsi_font_h6',
        'responsi_breadcrumbs_font',
    ];

    var single_fields = [
        'responsi_button_text_shadow',
        'responsi_button_text_transform',
        'responsi_button_color',
        'responsi_button_gradient_from',
        'responsi_button_gradient_to',
        'responsi_link_color',
        'responsi_link_hover_color',
        'responsi_link_visited_color',
        'responsi_breadcrumbs_link',
        'responsi_breadcrumbs_link_hover',
        'responsi_breadcrumbs_sep',
    ];

    var bg_fields = [
        'responsi_breadcrumbs_bg',
    ];

    var border_fields = [
        'responsi_button_border_top',
        'responsi_button_border_bottom',
        'responsi_button_border_left',
        'responsi_button_border_right',
        'responsi_breadcrumbs_border_top',
        'responsi_breadcrumbs_border_bottom',
        'responsi_breadcrumbs_border_lr',
    ];

    var border_radius_fields = [
        'responsi_button_border_radius_tl',
        'responsi_button_border_radius_tr',
        'responsi_button_border_radius_bl',
        'responsi_button_border_radius_br',
        'responsi_breadcrumbs_border_radius',
    ];

    var shadow_fields = [
        'responsi_button_border_box_shadow',
        'responsi_breadcrumbs_box_shadow'
    ];

    var margin_padding_fields = [
        'responsi_button_padding',
        'responsi_breadcrumbs_padding',
        'responsi_breadcrumbs_margin',
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(typefonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_settings();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_settings();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(typeradius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_settings();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_settings();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_settings();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_settings();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_settings();
            });
        });
    });

})(jQuery);