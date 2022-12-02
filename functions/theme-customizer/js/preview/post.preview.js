/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {
    function _previewPosts() {
        var css = '.main-post{ ' + _cFn.renderBG('responsi_post_box_bg', true) + _cFn.renderBorderBoxs('responsi_post_box_border', true) + _cFn.renderShadow('responsi_post_box_shadow', true) + _cFn.renderMarPad('responsi_post_box_margin', 'margin', true) + _cFn.renderMarPad('responsi_post_box_padding', 'padding', true) + '}';

        var responsi_post_title_font_transform = wp.customize.value('responsi_post_title_font_transform')();
        var responsi_post_title_position = wp.customize.value('responsi_post_title_position')();
        css += '.main .responsi-area.responsi-area-post h1.title, .responsi-area.responsi-area-post h1.title, .main .responsi-area.responsi-area-post h1.title a:link, .main .responsi-area.responsi-area-post h1.title a:visited{' + _cFn.renderTypo('responsi_font_post_title', true) + _cFn.renderMarPad('responsi_post_title_margin', 'margin', true) + 'text-transform: ' + responsi_post_title_font_transform + ' !important; text-align: ' + responsi_post_title_position + ';}';
        css += '.responsi-area.responsi-area-post{' + _cFn.renderTypo('responsi_font_post_text', true) + '}';
        css += '.responsi-area.responsi-area-post .post-entries svg, .responsi-area.responsi-area-post .profile-link svg{width:' + wp.customize.value('responsi_font_post_text[size]')() + 'px;height:' + wp.customize.value('responsi_font_post_text[size]')() + 'px}';

        var responsi_post_meta_transform = wp.customize.value('responsi_post_meta_transform')();
        var responsi_post_meta_link = wp.customize.value('responsi_post_meta_link')();
        var responsi_post_meta_link_hover = wp.customize.value('responsi_post_meta_link_hover')();
        var responsi_post_meta_icon = wp.customize.value('responsi_post_meta_icon')();

        var meta_box = '';
        meta_box = _cFn.renderBorder('responsi_post_meta_border_top', 'top', true) + _cFn.renderBorder('responsi_post_meta_border_bottom', 'bottom', true) + _cFn.renderBorder('responsi_post_meta_border_lr', 'left', true) + _cFn.renderBorder('responsi_post_meta_border_lr', 'right', true) + _cFn.renderBG('responsi_post_meta_bg', true);
        css += '.single .responsi-area-post .post-meta{' + _cFn.renderTypo('responsi_font_post_meta', true) + 'text-transform: ' + responsi_post_meta_transform + ' !important;' + _cFn.renderMarPad('responsi_post_meta_margin', 'margin', true) + _cFn.renderMarPad('responsi_post_meta_padding', 'padding', true) + meta_box + '}';
        css += '.single .responsi-area-post .post-meta a {text-transform:' + responsi_post_meta_transform + ';color:' + responsi_post_meta_link + ' !important;}';
        css += '.single .responsi-area-post .post-meta a:hover {color:' + responsi_post_meta_link_hover + ' !important;}';
        css += '.single .responsi-area-post .post-meta svg {fill:' + responsi_post_meta_icon + ' !important;width:' + wp.customize.value('responsi_font_post_meta[size]')() + 'px;height:' + wp.customize.value('responsi_font_post_meta[size]')() + 'px}';
        
        var responsi_enable_post_meta_icon = wp.customize.value('responsi_enable_post_meta_icon')();
        if (responsi_enable_post_meta_icon != 'true') {
            css += '.single .responsi-area-post .post-meta .i_author svg, .single .responsi-area-post .post-meta .i_comment svg, .single .responsi-area-post .post-meta .i_authors span.author .fn svg, .single .i_dates time.i_date svg{display:none !important;}';
        } else {
            css += '.single .responsi-area-post .post-meta .i_author svg, .single .responsi-area-post .post-meta .i_comment svg, .single .responsi-area-post .post-meta .i_authors span.author .fn svg, .single .i_dates time.i_date svg{display:inherit !important;}';
        }

        var responsi_enable_post_meta_icon = wp.customize.value('responsi_enable_post_meta_icon')();
        if (responsi_enable_post_meta_icon != 'true') {
            css += '.single .responsi-area-post .post-meta .i_author svg, .single .responsi-area-post .post-meta .i_comment svg, .single .responsi-area-post .post-meta .i_authors span.author .fn svg, .single .i_dates time.i_date svg{display:none !important;}';
        } else {
            css += '.single .responsi-area-post .post-meta .i_author svg, .single .responsi-area-post .post-meta .i_comment svg, .single .responsi-area-post .post-meta .i_authors span.author .fn svg, .single .i_dates time.i_date svg{display:inherit !important;}';
        }

        var responsi_disable_post_meta_author = wp.customize.value('responsi_disable_post_meta_author')();
        var responsi_disable_post_meta_date = wp.customize.value('responsi_disable_post_meta_date')();
        var responsi_disable_post_meta_comment = wp.customize.value('responsi_disable_post_meta_comment')();

        if ( responsi_disable_post_meta_author != 'true' ) {
            css += '.single .responsi-area-post .post-meta .i_authors{display:none !important;}';
        }else{
            css += '.single .responsi-area-post .post-meta .i_authors{display:initial !important;}';
        }
        if ( responsi_disable_post_meta_date != 'true' ) {
            css += '.single .responsi-area-post .post-meta .i_dates{display:none !important;}';
        }else{
            css += '.single .responsi-area-post .post-meta .i_dates{display:initial !important;}';
        }
        if ( responsi_disable_post_meta_comment != 'true' ) {
            css += '.single .responsi-area-post .post-meta .post-comments{display:none !important;}';
        }else{
            css += '.single .responsi-area-post .post-meta .post-comments{display:initial !important;}';
        }
        if ( responsi_disable_post_meta_author != 'true' && responsi_disable_post_meta_date != 'true' && responsi_disable_post_meta_comment != 'true' ) {
            css += '.single .single-ct .post-meta{display:none !important;}';
        }else{
            css += '.single .single-ct .post-meta{display:block !important;}';
        }

        var post_utility_cats = '';
        var responsi_font_post_cat_tag_transform = wp.customize.value('responsi_font_post_cat_tag_transform')();
        post_utility_cats = _cFn.renderRadius('responsi_post_meta_cat_tag_border_radius', '', true) + _cFn.renderBorder('responsi_post_meta_cat_tag_border_top', 'top', true) + _cFn.renderBorder('responsi_post_meta_cat_tag_border_bottom', 'bottom', true) + _cFn.renderBorder('responsi_post_meta_cat_tag_border_lr', 'left', true) + _cFn.renderBorder('responsi_post_meta_cat_tag_border_lr', 'right', true) + _cFn.renderBG('responsi_post_meta_cat_tag_bg', true);
        css += '.categories .categories{' + _cFn.renderTypo('responsi_font_post_cat_tag', true) + 'text-transform: ' + responsi_font_post_cat_tag_transform + ' !important;' + _cFn.renderMarPad('responsi_post_meta_cat_tag_margin', 'margin', true) + _cFn.renderMarPad('responsi_post_meta_cat_tag_padding', 'padding', true) + post_utility_cats + '}';
        css += '.categories .categories svg{width:' + wp.customize.value('responsi_font_post_cat_tag[size]')() + 'px;height:' + wp.customize.value('responsi_font_post_cat_tag[size]')() + 'px}';
        var responsi_font_post_cat_tag_link = wp.customize.value('responsi_font_post_cat_tag_link')();
        var responsi_font_post_cat_tag_link_hover = wp.customize.value('responsi_font_post_cat_tag_link_hover')();
        var responsi_font_post_cat_tag_icon = wp.customize.value('responsi_font_post_cat_tag_icon')();
        css += '.categories .categories a{color:' + responsi_font_post_cat_tag_link + ' !important;}';
        css += '.categories .categories a:hover{color:' + responsi_font_post_cat_tag_link_hover + ' !important;}';
        css += '.categories .categories .i_cat svg{fill:' + responsi_font_post_cat_tag_icon + ' !important;}';
        var responsi_enable_font_post_cat_tag_icon = wp.customize.value('responsi_enable_font_post_cat_tag_icon')();
        if (responsi_enable_font_post_cat_tag_icon != 'true') {
            css += '.categories .categories .i_cat svg{display:none !important;}';
        } else {
            css += '.categories .categories .i_cat svg{display:inherit !important;}';
        }

        var post_utility_tags = '';
        var responsi_font_post_utility_tag_transform = wp.customize.value('responsi_font_post_utility_tag_transform')();
        post_utility_tags = _cFn.renderRadius('responsi_post_meta_utility_tag_border_radius', '', true) + _cFn.renderBorder('responsi_post_meta_utility_tag_border_top', 'top', true) + _cFn.renderBorder('responsi_post_meta_utility_tag_border_bottom', 'bottom', true) + _cFn.renderBorder('responsi_post_meta_utility_tag_border_lr', 'left', true) + _cFn.renderBorder('responsi_post_meta_utility_tag_border_lr', 'right', true) + _cFn.renderBG('responsi_post_meta_utility_tag_bg', true);
        css += '.tags .posts-tags{' + _cFn.renderTypo('responsi_font_post_utility_tag', true) + 'text-transform: ' + responsi_font_post_utility_tag_transform + ' !important;' + _cFn.renderMarPad('responsi_post_meta_utility_tag_margin', 'margin', true) + _cFn.renderMarPad('responsi_post_meta_utility_tag_padding', 'padding', true) + post_utility_tags + '}';
        css += '.tags .posts-tags svg{width:' + wp.customize.value('responsi_font_post_utility_tag[size]')() + 'px;height:' + wp.customize.value('responsi_font_post_utility_tag[size]')() + 'px}';
        var responsi_font_post_utility_tag_link = wp.customize.value('responsi_font_post_utility_tag_link')();
        var responsi_font_post_utility_tag_link_hover = wp.customize.value('responsi_font_post_utility_tag_link_hover')();
        var responsi_font_post_utility_tag_icon = wp.customize.value('responsi_font_post_utility_tag_icon')();
        css += '.tags .posts-tags a{color:' + responsi_font_post_utility_tag_link + ' !important;}';
        css += '.tags .posts-tags a:hover{color:' + responsi_font_post_utility_tag_link_hover + ' !important;}';
        css += '.tags .posts-tags .i_tag svg{fill:' + responsi_font_post_utility_tag_icon + ' !important;}';
        var responsi_enable_font_post_utility_tag_icon = wp.customize.value('responsi_enable_font_post_utility_tag_icon')();
        if (responsi_enable_font_post_utility_tag_icon != 'true') {
            css += '.tags .posts-tags .i_tag svg{display:none !important;}';
        } else {
            css += '.tags .posts-tags .i_tag svg{display:inherit !important;}';
        }

        css += '#comments .comment.thread-even {' + _cFn.renderBG('responsi_post_comments_bg') + '}';

        if ($('#custom_post_style').length > 0) {
            $('#custom_post_style').html(css);
        } else {
            $('head').append('<style id="custom_post_style">' + css + '</style>');
        }
    }

    var fonts_fields = [
        'responsi_font_post_title',
        'responsi_font_post_utility_tag',
        'responsi_font_post_text',
        'responsi_font_post_meta',
        'responsi_font_post_cat_tag',
    ];

    var single_fields = [
        'responsi_post_title_font_transform',
        'responsi_post_title_position',
        'responsi_post_meta_transform',
        'responsi_post_meta_link',
        'responsi_post_meta_link_hover',
        'responsi_enable_post_meta_icon',
        'responsi_post_meta_icon',
        'responsi_font_post_cat_tag_transform',
        'responsi_font_post_cat_tag_link',
        'responsi_font_post_cat_tag_link_hover',
        'responsi_enable_font_post_cat_tag_icon',
        'responsi_font_post_cat_tag_icon',
        'responsi_font_post_utility_tag_transform',
        'responsi_font_post_utility_tag_link',
        'responsi_font_post_utility_tag_link_hover',
        'responsi_enable_font_post_utility_tag_icon',
        'responsi_font_post_utility_tag_icon',
        'responsi_disable_post_meta_author',
        'responsi_disable_post_meta_date',
        'responsi_disable_post_meta_comment',
    ];

    var bg_fields = [
        'responsi_post_box_bg',
        'responsi_post_meta_bg',
        'responsi_post_meta_cat_tag_bg',
        'responsi_post_comments_bg',
        'responsi_post_meta_utility_tag_bg',
    ];

    var border_fields = [
        'responsi_post_meta_border_top',
        'responsi_post_meta_border_bottom',
        'responsi_post_meta_border_lr',
        'responsi_post_meta_cat_tag_border_top',
        'responsi_post_meta_cat_tag_border_bottom',
        'responsi_post_meta_cat_tag_border_lr',
        'responsi_post_meta_utility_tag_border_top',
        'responsi_post_meta_utility_tag_border_bottom',
        'responsi_post_meta_utility_tag_border_lr',
    ];

    var border_boxes_fields = [
        'responsi_post_box_border',
    ]

    var border_radius_fields = [
        'responsi_post_meta_cat_tag_border_radius',
        'responsi_post_meta_utility_tag_border_radius',
    ];

    var shadow_fields = [
        'responsi_post_box_shadow',
    ];

    var margin_padding_fields = [
        'responsi_post_box_padding',
        'responsi_post_box_margin',
        'responsi_post_title_margin',
        'responsi_post_meta_margin',
        'responsi_post_meta_padding',
        'responsi_post_meta_cat_tag_margin',
        'responsi_post_meta_cat_tag_padding',
        'responsi_post_meta_utility_tag_margin',
        'responsi_post_meta_utility_tag_padding',
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(window.ctrlFonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPosts();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPosts();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(window.ctrlBorderBoxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPosts();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPosts();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPosts();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewPosts();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewPosts();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewPosts();
            });
        });
    });

})(jQuery);