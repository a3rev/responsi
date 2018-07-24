/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {
    function responsi_preview_posts() {
        var css = '.main-wrap-post{ ' + responsiCustomize.build_background('responsi_post_box_bg', true) + responsiCustomize.build_border_boxes('responsi_post_box_border', true) + responsiCustomize.build_box_shadow('responsi_post_box_shadow', true) + responsiCustomize.build_padding_margin('responsi_post_box_margin', 'margin', true) + responsiCustomize.build_padding_margin('responsi_post_box_padding', 'padding', true) + '}';

        var responsi_post_title_font_transform = wp.customize.value('responsi_post_title_font_transform')();
        var responsi_post_title_position = wp.customize.value('responsi_post_title_position')();
        css += '#main .custom_box.custom_box_post h1.title, .custom_box.custom_box_post h1.title, #main .custom_box.custom_box_post h1.title a:link, #main .custom_box.custom_box_post h1.title a:visited{' + responsiCustomize.build_typography('responsi_font_post_title', true) + responsiCustomize.build_padding_margin('responsi_post_title_margin', 'margin', true) + 'text-transform: ' + responsi_post_title_font_transform + ' !important; text-align: ' + responsi_post_title_position + ';}';
        css += '.custom_box.custom_box_post{' + responsiCustomize.build_typography('responsi_font_post_text', true) + '}';

        var responsi_post_meta_transform = wp.customize.value('responsi_post_meta_transform')();
        var responsi_post_meta_link = wp.customize.value('responsi_post_meta_link')();
        var responsi_post_meta_link_hover = wp.customize.value('responsi_post_meta_link_hover')();
        var responsi_post_meta_icon = wp.customize.value('responsi_post_meta_icon')();

        var meta_box = '';
        meta_box = responsiCustomize.build_border('responsi_post_meta_border_top', 'top', true) + responsiCustomize.build_border('responsi_post_meta_border_bottom', 'bottom', true) + responsiCustomize.build_border('responsi_post_meta_border_lr', 'left', true) + responsiCustomize.build_border('responsi_post_meta_border_lr', 'right', true) + responsiCustomize.build_background('responsi_post_meta_bg', true);
        css += '.single .custom_box_post .post-meta{' + responsiCustomize.build_typography('responsi_font_post_meta', true) + 'text-transform: ' + responsi_post_meta_transform + ' !important;' + responsiCustomize.build_padding_margin('responsi_post_meta_margin', 'margin', true) + responsiCustomize.build_padding_margin('responsi_post_meta_padding', 'padding', true) + meta_box + '}';
        css += '.single .custom_box_post .post-meta a {text-transform:' + responsi_post_meta_transform + ';color:' + responsi_post_meta_link + ' !important;}';
        css += '.single .custom_box_post .post-meta a:hover {color:' + responsi_post_meta_link_hover + ' !important;}';
        css += '.single .custom_box_post .post-meta .i_author:before, .single .custom_box_post .post-meta .i_comment:before, .single .custom_box_post .post-meta .i_authors span.author .fn:before, .single .i_dates time.i_date:before {color:' + responsi_post_meta_icon + ' !important;}';
        var responsi_enable_post_meta_icon = wp.customize.value('responsi_enable_post_meta_icon')();
        if (responsi_enable_post_meta_icon != 'true') {
            css += '.single .custom_box_post .post-meta .i_author:before, .single .custom_box_post .post-meta .i_comment:before, .single .custom_box_post .post-meta .i_authors span.author .fn:before, .single .i_dates time.i_date:before{display:none !important;}';
        } else {
            css += '.single .custom_box_post .post-meta .i_author:before, .single .custom_box_post .post-meta .i_comment:before, .single .custom_box_post .post-meta .i_authors span.author .fn:before, .single .i_dates time.i_date:before{display:inherit !important;}';
        }

        var responsi_enable_post_meta_icon = wp.customize.value('responsi_enable_post_meta_icon')();
        if (responsi_enable_post_meta_icon != 'true') {
            css += '.single .custom_box_post .post-meta .i_author:before, .single .custom_box_post .post-meta .i_comment:before, .single .custom_box_post .post-meta .i_authors span.author .fn:before, .single .i_dates time.i_date:before{display:none !important;}';
        } else {
            css += '.single .custom_box_post .post-meta .i_author:before, .single .custom_box_post .post-meta .i_comment:before, .single .custom_box_post .post-meta .i_authors span.author .fn:before, .single .i_dates time.i_date:before{display:inherit !important;}';
        }

        var responsi_disable_post_meta_author = wp.customize.value('responsi_disable_post_meta_author')();
        var responsi_disable_post_meta_date = wp.customize.value('responsi_disable_post_meta_date')();
        var responsi_disable_post_meta_comment = wp.customize.value('responsi_disable_post_meta_comment')();

        if ( responsi_disable_post_meta_author != 'true' ) {
            css += '.single .custom_box_post .post-meta .i_authors{display:none !important;}';
        }else{
            css += '.single .custom_box_post .post-meta .i_authors{display:initial !important;}';
        }
        if ( responsi_disable_post_meta_date != 'true' ) {
            css += '.single .custom_box_post .post-meta .i_dates{display:none !important;}';
        }else{
            css += '.single .custom_box_post .post-meta .i_dates{display:initial !important;}';
        }
        if ( responsi_disable_post_meta_comment != 'true' ) {
            css += '.single .custom_box_post .post-meta .post-comments{display:none !important;}';
        }else{
            css += '.single .custom_box_post .post-meta .post-comments{display:initial !important;}';
        }
        if ( responsi_disable_post_meta_author != 'true' && responsi_disable_post_meta_date != 'true' && responsi_disable_post_meta_comment != 'true' ) {
            css += '.single .single_content .post-meta{display:none !important;}';
        }else{
            css += '.single .single_content .post-meta{display:block !important;}';
        }

        var post_utility_cats = '';
        var responsi_font_post_cat_tag_transform = wp.customize.value('responsi_font_post_cat_tag_transform')();
        post_utility_cats = responsiCustomize.build_border_radius('responsi_post_meta_cat_tag_border_radius', '', true) + responsiCustomize.build_border('responsi_post_meta_cat_tag_border_top', 'top', true) + responsiCustomize.build_border('responsi_post_meta_cat_tag_border_bottom', 'bottom', true) + responsiCustomize.build_border('responsi_post_meta_cat_tag_border_lr', 'left', true) + responsiCustomize.build_border('responsi_post_meta_cat_tag_border_lr', 'right', true) + responsiCustomize.build_background('responsi_post_meta_cat_tag_bg', true);
        css += '.post-utility-cat .categories{' + responsiCustomize.build_typography('responsi_font_post_cat_tag', true) + 'text-transform: ' + responsi_font_post_cat_tag_transform + ' !important;' + responsiCustomize.build_padding_margin('responsi_post_meta_cat_tag_margin', 'margin', true) + responsiCustomize.build_padding_margin('responsi_post_meta_cat_tag_padding', 'padding', true) + post_utility_cats + '}';
        var responsi_font_post_cat_tag_link = wp.customize.value('responsi_font_post_cat_tag_link')();
        var responsi_font_post_cat_tag_link_hover = wp.customize.value('responsi_font_post_cat_tag_link_hover')();
        var responsi_font_post_cat_tag_icon = wp.customize.value('responsi_font_post_cat_tag_icon')();
        css += '.post-utility-cat .categories a{color:' + responsi_font_post_cat_tag_link + ' !important;}';
        css += '.post-utility-cat .categories a:hover{color:' + responsi_font_post_cat_tag_link_hover + ' !important;}';
        css += '.post-utility-cat .categories .i_cat:before{color:' + responsi_font_post_cat_tag_icon + ' !important;}';
        var responsi_enable_font_post_cat_tag_icon = wp.customize.value('responsi_enable_font_post_cat_tag_icon')();
        if (responsi_enable_font_post_cat_tag_icon != 'true') {
            css += '.post-utility-cat .categories .i_cat:before{display:none !important;}';
        } else {
            css += '.post-utility-cat .categories .i_cat:before{display:inherit !important;}';
        }

        var post_utility_tags = '';
        var responsi_font_post_utility_tag_transform = wp.customize.value('responsi_font_post_utility_tag_transform')();
        post_utility_tags = responsiCustomize.build_border_radius('responsi_post_meta_utility_tag_border_radius', '', true) + responsiCustomize.build_border('responsi_post_meta_utility_tag_border_top', 'top', true) + responsiCustomize.build_border('responsi_post_meta_utility_tag_border_bottom', 'bottom', true) + responsiCustomize.build_border('responsi_post_meta_utility_tag_border_lr', 'left', true) + responsiCustomize.build_border('responsi_post_meta_utility_tag_border_lr', 'right', true) + responsiCustomize.build_background('responsi_post_meta_utility_tag_bg', true);
        css += '.post-utility-tag .posts-tags{' + responsiCustomize.build_typography('responsi_font_post_utility_tag', true) + 'text-transform: ' + responsi_font_post_utility_tag_transform + ' !important;' + responsiCustomize.build_padding_margin('responsi_post_meta_utility_tag_margin', 'margin', true) + responsiCustomize.build_padding_margin('responsi_post_meta_utility_tag_padding', 'padding', true) + post_utility_tags + '}';
        var responsi_font_post_utility_tag_link = wp.customize.value('responsi_font_post_utility_tag_link')();
        var responsi_font_post_utility_tag_link_hover = wp.customize.value('responsi_font_post_utility_tag_link_hover')();
        var responsi_font_post_utility_tag_icon = wp.customize.value('responsi_font_post_utility_tag_icon')();
        css += '.post-utility-tag .posts-tags a{color:' + responsi_font_post_utility_tag_link + ' !important;}';
        css += '.post-utility-tag .posts-tags a:hover{color:' + responsi_font_post_utility_tag_link_hover + ' !important;}';
        css += '.post-utility-tag .posts-tags .i_tag:before{color:' + responsi_font_post_utility_tag_icon + ' !important;}';
        var responsi_enable_font_post_utility_tag_icon = wp.customize.value('responsi_enable_font_post_utility_tag_icon')();
        if (responsi_enable_font_post_utility_tag_icon != 'true') {
            css += '.post-utility-tag .posts-tags .i_tag:before{display:none !important;}';
        } else {
            css += '.post-utility-tag .posts-tags .i_tag:before{display:inherit !important;}';
        }

        css += '#comments .comment.thread-even {' + responsiCustomize.build_background('responsi_post_comments_bg') + '}';

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
        'responsi_post_title_margins',
        'responsi_post_meta_margin',
        'responsi_post_meta_padding',
        'responsi_post_meta_cat_tag_margin',
        'responsi_post_meta_cat_tag_padding',
        'responsi_post_meta_utility_tag_margin',
        'responsi_post_meta_utility_tag_padding',
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(typefonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_posts();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_posts();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(typeborderboxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_posts();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(typeradius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_posts();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_posts();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_posts();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_posts();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_posts();
            });
        });
    });

})(jQuery);