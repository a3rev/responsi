/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {
    function responsi_preview_pages() {
        var css = '';

        css += '.archive-container .main-wrap{ ' + responsiCustomize.build_background('responsi_archive_box_bg', true) + responsiCustomize.build_border_boxes('responsi_archive_box_border', true) + responsiCustomize.build_box_shadow('responsi_archive_box_shadow', true) + responsiCustomize.build_padding_margin('responsi_archive_box_margin', 'margin', true) + responsiCustomize.build_padding_margin('responsi_archive_box_padding', 'padding', true) + '}';

        css += '.main-wrap-page{' + responsiCustomize.build_background('responsi_page_box_bg', true) + responsiCustomize.build_border_boxes('responsi_page_box_border', true) + responsiCustomize.build_padding_margin('responsi_page_box_margin', 'margin', true) + responsiCustomize.build_padding_margin('responsi_page_box_padding', 'padding', true) + responsiCustomize.build_box_shadow('responsi_page_box_shadow', true) + '}';

        var responsi_page_title_font_transform = wp.customize.value('responsi_page_title_font_transform')();
        css += '#main .custom_box.custom_box_page h1.title, .custom_box.custom_box_page h1.title, #main .custom_box.custom_box_page h1.title a:link, #main .custom_box.custom_box_page h1.title a:visited{' + responsiCustomize.build_typography('responsi_page_title_font', true) + responsiCustomize.build_padding_margin('responsi_page_title_margin', 'margin', true) + 'text-transform:' + responsi_page_title_font_transform + ' !important;}';
        css += '.custom_box.custom_box_page{' + responsiCustomize.build_typography('responsi_page_content_font', true) + '}';

        var responsi_archive_title_font_transform = wp.customize.value('responsi_archive_title_font_transform')();
        css += '#main .custom_box.custom_box_archive h1.title, .custom_box.custom_box_archive h1.title, #main .custom_box.custom_box_archive h1.title a:link, #main .custom_box.custom_box_archive h1.title a:visited{' + responsiCustomize.build_typography('responsi_archive_title_font', true) + responsiCustomize.build_padding_margin('responsi_archive_title_margin', 'margin', true) + 'text-transform:' + responsi_archive_title_font_transform + ' !important;}';
        css += '.custom_box.custom_box_archive,.archive_header .catrss{' + responsiCustomize.build_typography('responsi_archive_content_font', true) + '}';

        var responsi_archive_title_border_bottom_width = wp.customize.value('responsi_archive_title_border_bottom[width]')();
        css += '.archive_header{' + responsiCustomize.build_border('responsi_archive_title_border_bottom', 'bottom', true) + '}';
        if (responsi_archive_title_border_bottom_width > 0) {
            css += '.responsi_title .archive_header{padding-bottom:5px !important;}';
        } else {
            css += '.responsi_title .archive_header{padding-bottom:0px !important;}';
        }

        var responsi_enable_archive_title_box = wp.customize.value('responsi_enable_archive_title_box')();

        if (responsi_enable_archive_title_box == 'true') {
            css += '#main .custom_box.custom_box_archive, .custom_box.custom_box_archive,.custom_box_archive{' + responsiCustomize.build_background('responsi_archive_title_box_bg', true) + responsiCustomize.build_border_boxes('responsi_archive_title_box_border', true) + responsiCustomize.build_padding_margin('responsi_archive_title_box_padding', 'padding', true) + responsiCustomize.build_padding_margin('responsi_archive_title_box_margin', 'margin', true) + responsiCustomize.build_box_shadow('responsi_archive_title_box_shadow', true) + '}';
        } else {
            css += '#main .custom_box.custom_box_archive, .custom_box.custom_box_archive,.custom_box_archive{padding:0px !important;border-width:0px !important;background-color:transparent !important;box-shadow: 0 0 0px #ffffff !important;border-radius: 0px !important;}';
        }

        var responsi_showmore = wp.customize.value('responsi_showmore')();
        if (responsi_showmore == 'click_showmore') {
            var responsi_showmore_text = wp.customize.value('responsi_showmore_text')();
            var responsi_scroll_font_text_alignment = wp.customize.value('responsi_scroll_font_text_alignment')();
            if (responsi_showmore_text == '') responsi_showmore_text = 'Show more';
            $('.click_showmore a.showmore').html(responsi_showmore_text);
            css += 'body #main .click_showmore_container,.nav-entries{';
            css += responsiCustomize.build_typography('responsi_scroll_font', true);
            css += 'text-align: ' + responsi_scroll_font_text_alignment + ' !important;';
            css += responsiCustomize.build_padding_margin('responsi_scroll_box_margin', 'margin', true);
            css += responsiCustomize.build_padding_margin('responsi_scroll_box_padding', 'padding', true);
            css += responsiCustomize.build_background('responsi_scroll_box_bg', true);
            css += responsiCustomize.build_border('responsi_scroll_box_border_top', 'top', true);
            css += responsiCustomize.build_border('responsi_scroll_box_border_bottom', 'bottom', true);
            css += responsiCustomize.build_border('responsi_scroll_box_border_lr', 'left', true);
            css += responsiCustomize.build_border('responsi_scroll_box_border_lr', 'right', true);
            css += responsiCustomize.build_padding_margin('responsi_scroll_box_padding', 'padding', true);
            css += responsiCustomize.build_border_radius('responsi_scroll_box_border_radius', '', true);
            css += responsiCustomize.build_box_shadow('responsi_scroll_box_shadow', true);
            css += '}';
            css += '.nav-entries, .responsi-pagination,.nav-entries a, .responsi-pagination a,.click_showmore a,.click_showmore{' + responsiCustomize.build_typography('responsi_scroll_font', true) + '}';
            css += '.responsi-pagination a:hover, .responsi-pagination a:hover,.click_showmore a:hover,.click_showmore a:hover {color:' + wp.customize.value('responsi_link_hover_color')() + ' !important;}';
        } else {
            css += '.click_showmore_container{display:none !important;}';
        }

        if ($('#custom_page_style').length > 0) {
            $('#custom_page_style').html(css);
        } else {
            $('head').append('<style id="custom_page_style">' + css + '</style>');
        }
        $(window).trigger('resize');
    }

    var fonts_fields = [
        'responsi_scroll_font',
        'responsi_archive_content_font',
        'responsi_archive_title_font',
        'responsi_page_content_font',
        'responsi_page_title_font'
    ];

    var single_fields = [
        'responsi_scroll_font_text_alignment',
        'responsi_showmore',
        'responsi_showmore_text',
        'responsi_enable_archive_title_box',
        'responsi_archive_title_font_transform',
        'responsi_page_title_font_transform'
    ];

    var bg_fields = [
        'responsi_scroll_box_bg',
        'responsi_archive_box_bg',
        'responsi_archive_title_box_bg',
        'responsi_page_box_bg'
    ];

    var border_fields = [
        'responsi_scroll_box_border_top',
        'responsi_scroll_box_border_bottom',
        'responsi_scroll_box_border_lr',
        'responsi_archive_title_border_bottom'
    ];

    var border_boxes_fields = [
        'responsi_page_box_border',
        'responsi_archive_box_border',
        'responsi_archive_title_box_border',
    ]

    var border_radius_fields = [
        'responsi_scroll_box_border_radius',
    ];

    var shadow_fields = [
        'responsi_archive_box_shadow',
        'responsi_scroll_box_shadow',
        'responsi_archive_title_box_shadow',
        'responsi_page_box_shadow'
    ];

    var margin_padding_fields = [
        'responsi_scroll_box_padding',
        'responsi_scroll_box_margin',
        'responsi_archive_box_margin',
        'responsi_archive_box_padding',
        'responsi_archive_title_box_margin',
        'responsi_archive_title_box_padding',
        'responsi_archive_title_margin',
        'responsi_page_title_margin',
        'responsi_page_box_padding',
        'responsi_page_box_margin'
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(typefonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_pages();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_pages();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(typeborderboxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_pages();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(typeradius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_pages();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_pages();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_pages();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_pages();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_pages();
            });
        });
    });
})(jQuery);