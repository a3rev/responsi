/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {
    function _previewPages() {
        var css = '';

        css += '.main-archive .main-ctn{ ' + _cFn.renderBG('responsi_archive_box_bg', true) + _cFn.renderBorderBoxs('responsi_archive_box_border', true) + _cFn.renderShadow('responsi_archive_box_shadow', true) + _cFn.renderMarPad('responsi_archive_box_margin', 'margin', true) + _cFn.renderMarPad('responsi_archive_box_padding', 'padding', true) + '}';

        css += '.main-page{' + _cFn.renderBG('responsi_page_box_bg', true) + _cFn.renderBorderBoxs('responsi_page_box_border', true) + _cFn.renderMarPad('responsi_page_box_margin', 'margin', true) + _cFn.renderMarPad('responsi_page_box_padding', 'padding', true) + _cFn.renderShadow('responsi_page_box_shadow', true) + '}';

        var responsi_page_title_font_transform = wp.customize.value('responsi_page_title_font_transform')();
        var responsi_page_title_position = wp.customize.value('responsi_page_title_position')();
        css += '.main .responsi-area.responsi-area-page h1.title, .responsi-area.responsi-area-page h1.title, .main .responsi-area.responsi-area-page h1.title a:link, .main .responsi-area.responsi-area-page h1.title a:visited{' + _cFn.renderTypo('responsi_page_title_font', true) + _cFn.renderMarPad('responsi_page_title_margin', 'margin', true) + 'text-transform:' + responsi_page_title_font_transform + ' !important;text-align:' + responsi_page_title_position + ';}';
        css += '.responsi-area.responsi-area-page{' + _cFn.renderTypo('responsi_page_content_font', true) + '}';

        var responsi_archive_title_font_transform = wp.customize.value('responsi_archive_title_font_transform')();
        var responsi_archive_title_position = wp.customize.value('responsi_archive_title_position')();
        css += '.main .responsi-area.responsi-area-archive h1.title, .responsi-area.responsi-area-archive h1.title, .main .responsi-area.responsi-area-archive h1.title a:link, .main .responsi-area.responsi-area-archive h1.title a:visited{' + _cFn.renderTypo('responsi_archive_title_font', true) + _cFn.renderMarPad('responsi_archive_title_margin', 'margin', true) + 'text-transform:' + responsi_archive_title_font_transform + ' !important;text-align:' + responsi_archive_title_position + ';}';
        css += '.responsi-area.responsi-area-archive,.archive_header .catrss{' + _cFn.renderTypo('responsi_archive_content_font', true) + '}';

        var responsi_archive_title_border_bottom_width = wp.customize.value('responsi_archive_title_border_bottom[width]')();
        css += '.archive_header{' + _cFn.renderBorder('responsi_archive_title_border_bottom', 'bottom', true) + '}';
        if (responsi_archive_title_border_bottom_width > 0) {
            css += '.responsi_title .archive_header{padding-bottom:5px !important;}';
        } else {
            css += '.responsi_title .archive_header{padding-bottom:0px !important;}';
        }

        var responsi_enable_archive_title_box = wp.customize.value('responsi_enable_archive_title_box')();

        if (responsi_enable_archive_title_box == 'true') {
            css += '.main .responsi-area.responsi-area-archive, .responsi-area.responsi-area-archive,.responsi-area-archive{' + _cFn.renderBG('responsi_archive_title_box_bg', true) + _cFn.renderBorderBoxs('responsi_archive_title_box_border', true) + _cFn.renderMarPad('responsi_archive_title_box_padding', 'padding', true) + _cFn.renderMarPad('responsi_archive_title_box_margin', 'margin', true) + _cFn.renderShadow('responsi_archive_title_box_shadow', true) + '}';
        } else {
            css += '.main .responsi-area.responsi-area-archive, .responsi-area.responsi-area-archive,.responsi-area-archive{padding:0px !important;border-width:0px !important;background-color:transparent !important;box-shadow: 0 0 0px #ffffff !important;border-radius: 0px !important;}';
        }

        var responsi_showmore = wp.customize.value('responsi_showmore')();
        if (responsi_showmore == 'click_showmore') {
            var responsi_showmore_text = wp.customize.value('responsi_showmore_text')();
            var responsi_scroll_font_text_alignment = wp.customize.value('responsi_scroll_font_text_alignment')();
            if (responsi_showmore_text == '') responsi_showmore_text = 'Show more';
            $('.pagination-btn a.showmore').html(responsi_showmore_text);
            css += '.pagination-ctrl,.nav-entries{';
            css += _cFn.renderTypo('responsi_scroll_font', true);
            css += 'text-align: ' + responsi_scroll_font_text_alignment + ' !important;';
            css += _cFn.renderMarPad('responsi_scroll_box_margin', 'margin', true);
            css += _cFn.renderMarPad('responsi_scroll_box_padding', 'padding', true);
            css += _cFn.renderBG('responsi_scroll_box_bg', true);
            css += _cFn.renderBorder('responsi_scroll_box_border_top', 'top', true);
            css += _cFn.renderBorder('responsi_scroll_box_border_bottom', 'bottom', true);
            css += _cFn.renderBorder('responsi_scroll_box_border_lr', 'left', true);
            css += _cFn.renderBorder('responsi_scroll_box_border_lr', 'right', true);
            css += _cFn.renderMarPad('responsi_scroll_box_padding', 'padding', true);
            css += _cFn.renderRadius('responsi_scroll_box_border_radius', '', true);
            css += _cFn.renderShadow('responsi_scroll_box_shadow', true);
            css += '}';
            css += '.nav-entries, .responsi-pagination,.nav-entries a, .responsi-pagination a,.pagination-btn a,.pagination-btn{' + _cFn.renderTypo('responsi_scroll_font', true) + '}';
            css += '.responsi-pagination a:hover, .responsi-pagination a:hover,.pagination-btn a:hover,.pagination-btn a:hover {color:' + wp.customize.value('responsi_link_hover_color')() + ' !important;}';
        } else {
            css += '.pagination-ctrl{display:none !important;}';
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
        'responsi_archive_title_position',
        'responsi_page_title_font_transform',
        'responsi_page_title_position'
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
        $.each(window.ctrlFonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPages();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPages();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(window.ctrlBorderBoxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPages();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPages();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPages();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewPages();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPages();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewPages();
            });
        });
    });
})(jQuery);