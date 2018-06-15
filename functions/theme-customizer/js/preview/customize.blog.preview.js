/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function( $ ) {
	function responsi_preview_blogs(){
        var css = '';

        var responsi_post_thumbnail_type = wp.customize.value('responsi_post_thumbnail_type')();
        var responsi_post_thumbnail_type_wide = wp.customize.value('responsi_post_thumbnail_type_wide')();
        if( responsi_post_thumbnail_type_wide <= 0 || responsi_post_thumbnail_type_wide == '' ){
            responsi_post_thumbnail_type_wide = 50;
        }
        var grid_thumb_width   = ( responsi_post_thumbnail_type_wide - 0.5 );
        var grid_content_width = ( 100 - responsi_post_thumbnail_type_wide ) - 0.5;

        if( responsi_post_thumbnail_type == 'left' || responsi_post_thumbnail_type == 'right' ){
            if( responsi_post_thumbnail_type == 'left' ){
                css += '.blog-post-item .thumbnail_container{width:'+grid_thumb_width+'% !important;clear:none;float:left !important;}';
                css += '.blog-post-item .content_container{width:'+grid_content_width+'% !important;clear:none;float:right !important;}';
            }
            if( responsi_post_thumbnail_type == 'right' ){
                css += '.blog-post-item .thumbnail_container{width:'+grid_thumb_width+'% !important;clear:none;float:right !important;}';
                css += '.blog-post-item .content_container{width:'+grid_content_width+'% !important;clear:none;float:left !important;}';
            }
        }else{
            css += '.blog-post-item .thumbnail_container{width:100% !important;clear:both;display: inline-block;float:none !important;}';
            css += '.blog-post-item .content_container{width:100% !important;clear:none;float:none !important;}';
        }

        css += '.box-item .entry-item.blog-post-item,#main .box-item .entry-item.blog-post-item,#main .box-item .entry-item{'+responsiCustomize.build_background('responsi_blog_box_bg',true)+responsiCustomize.build_border_boxes('responsi_blog_box_border',true)+responsiCustomize.build_box_shadow('responsi_blog_box_shadow',true)+'}';

        css += '#main .box-item .entry-item.blog-post-item .thumbnail{'+responsiCustomize.build_background('responsi_blog_post_thumbnail_bg',true)+responsiCustomize.build_padding_margin('responsi_blog_post_thumbnail_margin','margin',true)+responsiCustomize.build_padding_margin('responsi_blog_post_thumbnail_padding','padding',true)+responsiCustomize.build_border_boxes('responsi_blog_post_thumbnail_border',true)+responsiCustomize.build_box_shadow('responsi_blog_post_thumbnail_shadow',true)+'}';

        var responsi_blog_post_font_title_transform = wp.customize.value('responsi_blog_post_font_title_transform')();
        var responsi_blog_post_title_alignment = wp.customize.value('responsi_blog_post_title_alignment')();
        css += '#main .box-item .entry-item.blog-post-item h3{'+responsiCustomize.build_padding_margin('responsi_blog_post_title_padding','padding',true)+'}';
        css += 'body.category #main .box-item .entry-item h3 a,body.tag #main .box-item .entry-item h3 a,body.page-template-template-blog-php #main .box-item .entry-item h3 a, .box-item .entry-item h3 a, body.category #main .box-item .entry-item h3,body.tag #main .box-item .entry-item h3,body.page-template-template-blog-php #main .box-item .entry-item h3, .box-item .entry-item h3,body #main .blog-post .blog-post-item h3 a:link,#main .blog-post.box-item .entry-item h3 a:link, #main .blog-post.box-item .entry-item h3 a:visited{text-transform: '+responsi_blog_post_font_title_transform+' !important;text-align: '+responsi_blog_post_title_alignment+' !important;'+responsiCustomize.build_typography('responsi_blog_post_font_title',true)+'}';

        var responsi_blog_post_font_date_transform = wp.customize.value('responsi_blog_post_font_date_transform')();
        var responsi_blog_post_date_alignment = wp.customize.value('responsi_blog_post_date_alignment')();
        var responsi_blog_post_date_icon = wp.customize.value('responsi_blog_post_date_icon')();
        css += '.box-item .entry-item .blogpostinfo{text-transform: '+responsi_blog_post_font_date_transform+' !important;text-align: '+responsi_blog_post_date_alignment+' !important;'+responsiCustomize.build_typography('responsi_blog_post_font_date',true)+responsiCustomize.build_padding_margin('responsi_blog_post_date_padding','padding',true)+'}';
        css += '.box-item .entry-item .blogpostinfo .i_date:before{color:'+responsi_blog_post_date_icon+' !important;position: relative;font-size: 90%;}';
        var responsi_enable_blog_post_date_icon = wp.customize.value('responsi_enable_blog_post_date_icon')();
        if(responsi_enable_blog_post_date_icon != 'true'){
            css += '.box-item .entry-item .blogpostinfo .i_date:before{display:none !important;}';
        }else{
            css += '.box-item .entry-item .blogpostinfo .i_date:before{display:inherit !important;}';
        }
        var responsi_blog_post_content_alignment = wp.customize.value('responsi_blog_post_content_alignment')();
        css += '#main .box-item .entry-item.blog-post-item .entry-content{'+responsiCustomize.build_padding_margin('responsi_blog_post_description_padding','padding',true)+'}';
        css += 'body.category #main .box-item .entry-item .entry-content p,body.tag #main .box-item .entry-item .entry-content p,body.page-template-template-blog-php #main .box-item .entry-item .entry-content p, .box-item .entry-item .entry-content p,.box-item .people_position_container,.box-item .sponsor_phone_container,.box-item .room-content{text-align: '+responsi_blog_post_content_alignment+' !important;'+responsiCustomize.build_typography('responsi_blog_post_font_content',true)+'}';

        var responsi_enable_post_author_archive_icon = wp.customize.value('responsi_enable_post_author_archive_icon')();
        var responsi_post_author_archive_icon = wp.customize.value('responsi_post_author_archive_icon')();
        var responsi_blog_ext_alignment = wp.customize.value('responsi_blog_ext_alignment')();

        var responsi_blogext_padding_left = wp.customize.value('responsi_blogext_padding_left')();
        var responsi_blogext_padding_right = wp.customize.value('responsi_blogext_padding_right')();

        css += 'body #main .box-item .entry-item.blog-post-item .entry-bottom .postinfo,#main .box-item .entry-item .entry-bottom .postinfo,body #main .box-item .entry-item.blog-post-item .entry-bottom .posttags,#main .box-item .entry-item .entry-bottom .posttags, body .room_grid_view .box-item .entry-item .room-bottom .view_rom_container,body .room_grid_view .box-item .entry-item .room-bottom .view_room_container,#main .box-item .entry-item .entry-bottom .postinfo, body .room_grid_view .box-item .entry-item .room-bottom .postedin,body .project_grid_view .box-item .entry-item #container_projects .project-bottom .postedin,body #container_projects .view_project_container,body #container_projects .view_project_container,body .sponsor_grid_view .box-item .entry-item #container_sponsor .sponsor-bottom .postedin,body #container_sponsor .postedin,body .people_grid_view .box-item .entry-item #container_people .people-bottom .postedin,body #container_people .postedin,body #content #main .box-item .entry-item .view_people_container{'+responsiCustomize.build_background('responsi_post_author_archive_bg',true)+'}';
        css += 'body .logout-link:after, body .profile-link:after, body .dashboard-link:after, body .lost_password-link:after, body .register-link:after{color:' + responsi_post_author_archive_icon + ' !important;}';
        css += '.i_author:before,.i_cat:before,.i_comment:before,.i_tag:before,.i_authors span.author .fn:before {margin-right:5px;position:relative;color:' + responsi_post_author_archive_icon + ';}';
        css += '.i_comment{margin-right:3px;}';
        css += '.post p.tags:hover:before,.post p.tags:before,.icon:before, .icon:after {color:' + responsi_post_author_archive_icon + ';}';
        css += 'body.category #main .box-item .entry-item .entry-bottom,body.tag #main .box-item .entry-item .entry-bottom,body.page-template-template-blog-php #main .box-item .entry-item .entry-bottom, .box-item .entry-item .entry-bottom,.box-item .room-bottom, .box-item .project-bottom, .box-item .people-bottom, .box-item .sponsor-bottom{text-align:' +responsi_blog_ext_alignment+ ';' +responsiCustomize.build_typography('responsi_blog_ext_font',true)+'}';
        css += '#main .box-item .entry-item.blog-post-item .entry-bottom .postinfo,#main .box-item .entry-item.blog-post-item .entry-bottom .posttags,#main .box-item .entry-item .entry-bottom .posttags, body .room_grid_view .box-item .entry-item .room-bottom .view_rom_container, body .room_grid_view .box-item .entry-item .room-bottom .view_room_container,#main .box-item .entry-item .entry-bottom .postinfo, body .room_grid_view .box-item .entry-item .room-bottom .postedin,body .project_grid_view .box-item .entry-item #container_projects .project-bottom .postedin,body #container_projects .view_project_container,body #container_projects .view_project_container,body .sponsor_grid_view .box-item .entry-item #container_sponsor .sponsor-bottom .postedin,body #container_sponsor .postedin,body .people_grid_view .box-item .entry-item #container_people .people-bottom .postedin,body #container_people .view_people_container{'+responsiCustomize.build_padding_margin('responsi_blogext_padding','padding',true)+responsiCustomize.build_border('responsi_post_author_archive_border_top','top',true)+responsiCustomize.build_border('responsi_post_author_archive_border_bottom','bottom',true)+'margin :0px !important;}';
        css += 'body #main .box-item .entry-item.blog-post-item .entry-bottom .posttags,#main .box-item .entry-item .entry-bottom .posttags, div.box-content .box-item div.entry-item .entry-bottom .posttags{'+responsiCustomize.build_border('responsi_post_tags_comment_border_top','top',true)+responsiCustomize.build_border('responsi_post_tags_comment_border_bottom','bottom',true)+'}';
        if(responsi_enable_post_author_archive_icon != 'true'){
            css += '.box-item .entry-bottom .i_author:before, .box-item .entry-bottom .i_cat:before, .box-item .entry-bottom .i_comment:before, .box-item .entry-bottom .i_tag:before{display:none !important;}';
        }else{
            css += '.box-item .entry-bottom .i_author:before, .box-item .entry-bottom .i_cat:before, .box-item .entry-bottom .i_comment:before, .box-item .entry-bottom .i_tag:before{display:inherit !important;}';
        }
        css += 'div.box-content .box-item div.entry-item .entry-content a.more-link,body #wrapper #content div.box-content .box-item div.entry-item .entry-content a.button{';
            css += responsiCustomize.build_typography('responsi_blog_morelink_font',true);
        css += '}';

        var enable_fix_tall_title_grid = wp.customize.value('responsi_enable_fix_tall_title_grid')();
        var blog_title_line_height = wp.customize.value('responsi_blog_post_font_title[line_height]')();

        css += '@media only screen and (min-width: 480px) {';
        if (enable_fix_tall_title_grid == '1') {
            var blog_title_height = parseFloat(blog_title_line_height) + 0.1 ;
            css += 'body #main .box-item .entry-item h3 a{display:block !important;height: '+blog_title_height+'em !important;overflow: hidden !important;line-height:'+parseFloat(blog_title_line_height)+'em !important;}';
        }
        if (enable_fix_tall_title_grid == '2') {
            var blog_title_height = ( parseFloat(blog_title_line_height) * 2 ) + 0.1 ;
            css += 'body #main .box-item .entry-item h3 a{display:block !important;height: '+blog_title_height+'em !important;overflow: hidden !important;line-height:'+parseFloat(blog_title_line_height)+'em !important;}';
        }
        if (enable_fix_tall_title_grid == '3') {
            var blog_title_height = ( parseFloat(blog_title_line_height) * 3 ) + 0.1 ;
            css += 'body #main .box-item .entry-item h3 a{display:block !important;height: '+blog_title_height+'em !important;overflow: hidden !important;line-height:'+parseFloat(blog_title_line_height)+'em !important;}';
        }
        if (enable_fix_tall_title_grid == 'none') {
            css += 'body #main .box-item .entry-item h3 a{display:inherit !important;height: inherit !important;overflow: inherit !important;line-height:'+parseFloat(blog_title_line_height)+'em !important;}';
        }
        css += '}';

        var enable_fix_tall_des_grid = wp.customize.value('responsi_enable_fix_tall_des_grid')();
        var blog_des_line_height = wp.customize.value('responsi_blog_post_font_content[line_height]')();

        if (enable_fix_tall_des_grid == '1') {
            var blog_des_height = parseFloat(blog_des_line_height) ;
            css += 'body #main .box-item .entry-item p.gird_descriptions{display:block !important;height: '+blog_des_height+'em !important;overflow: hidden !important;line-height:'+blog_des_line_height+'em !important;}';
        }
        if (enable_fix_tall_des_grid == '2') {
            var blog_des_height = parseFloat(blog_des_line_height) * 2 ;
            css += 'body #main .box-item .entry-item p.gird_descriptions{display:block !important;height: '+blog_des_height+'em !important;overflow: hidden !important;line-height:'+blog_des_line_height+'em !important;}';
        }
        if (enable_fix_tall_des_grid == '3') {
            var blog_des_height = parseFloat(blog_des_line_height) * 3 ;
            css += 'body #main .box-item .entry-item p.gird_descriptions{display:block !important;height: '+blog_des_height+'em !important;overflow: hidden !important;line-height:'+blog_des_line_height+'em !important;}';
        }
        if (enable_fix_tall_des_grid == '4') {
            var blog_des_height = parseFloat(blog_des_line_height) * 4 ;
            css += 'body #main .box-item .entry-item p.gird_descriptions{display:block !important;height: '+blog_des_height+'em !important;overflow: hidden !important;line-height:'+blog_des_line_height+'em !important;}';
        }

        var blog_ext_line_height = wp.customize.value('responsi_blog_ext_font[line_height]')();
        var responsi_enable_fix_ext_cat_author = wp.customize.value('responsi_enable_fix_ext_cat_author')();
        var responsi_enable_fix_ext_tags_comment = wp.customize.value('responsi_enable_fix_ext_tags_comment')();

        if (responsi_enable_fix_ext_cat_author == '1') {
            blog_ext_height = parseFloat(blog_ext_line_height) ;
            css += 'body #main .box-item .entry-item .entry-bottom .postinfo .custom_lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_cat_author == '2') {
            blog_ext_height = parseFloat(blog_ext_line_height) * 2 ;
            css += 'body #main .box-item .entry-item .entry-bottom .postinfo .custom_lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_cat_author == '3') {
            blog_ext_height = parseFloat(blog_ext_line_height) * 3 ;
            css += 'body #main .box-item .entry-item .entry-bottom .postinfo .custom_lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_cat_author == 'none') {
            css += 'body #main .box-item .entry-item .entry-bottom .postinfo .custom_lines{display:inherit !important;height: auto !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }

        if (responsi_enable_fix_ext_tags_comment == '1') {
            blog_ext_height = parseFloat(blog_ext_line_height) ;
            css += 'body #main .box-item .entry-item .entry-bottom .posttags .custom_lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_tags_comment == '2') {
            blog_ext_height = parseFloat(blog_ext_line_height) * 2 ;
            css += 'body #main .box-item .entry-item .entry-bottom .posttags .custom_lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_tags_comment == '3') {
            blog_ext_height = parseFloat(blog_ext_line_height) * 3 ;
            css += 'body #main .box-item .entry-item .entry-bottom .posttags .custom_lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_tags_comment == 'none') {
            css += 'body #main .box-item .entry-item .entry-bottom .posttags .custom_lines{display:inherit !important;height: auto !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }

        if ( wp.customize.value('responsi_blog_morelink_alignment')() == 'left') {
            css += '.show-more-link{text-align:'+wp.customize.value('responsi_blog_morelink_alignment')()+';}';
        }
        if ( wp.customize.value('responsi_blog_morelink_alignment')() == 'right') {
            css += '.show-more-link{text-align:'+wp.customize.value('responsi_blog_morelink_alignment')()+';}';
        }
        if ( wp.customize.value('responsi_blog_morelink_alignment')() == 'center') {
            css += '.show-more-link{text-align:'+wp.customize.value('responsi_blog_morelink_alignment')()+';}';
        }

        if( $('#custom_blog_style').length > 0 ){
            $('#custom_blog_style').html(css);
        }else{
            $('head').append('<style id="custom_blog_style">'+css+'</style>');
        }
        $(window).trigger('resize');
    }

    var fonts_fields = [
        'responsi_blog_post_font_title',
        'responsi_blog_post_font_date',
        'responsi_blog_post_font_content',
        'responsi_blog_ext_font',
        'responsi_blog_morelink_font',
    ];

    var single_fields = [
        'responsi_post_thumbnail_type',
        'responsi_post_thumbnail_type_wide',
        'responsi_blog_post_font_title_transform',
        'responsi_blog_post_title_alignment',
        'responsi_blog_post_font_date_transform',
        'responsi_blog_post_date_alignment',
        'responsi_blog_post_date_icon',
        'responsi_blog_post_content_alignment',
        'responsi_enable_blog_post_date_icon',
        'responsi_enable_post_author_archive_icon',
        'responsi_post_author_archive_icon',
        'responsi_blog_ext_alignment',
        'responsi_blog_morelink_alignment'
    ];

    var bg_fields = [
        'responsi_blog_box_bg',
        'responsi_blog_post_thumbnail_bg',
        'responsi_post_author_archive_bg',
    ];

    var border_fields = [
        'responsi_post_author_archive_border_top',
        'responsi_post_author_archive_border_bottom',
        'responsi_post_tags_comment_border_top',
        'responsi_post_tags_comment_border_bottom',

    ];

    var border_boxes_fields = [
        'responsi_blog_post_thumbnail_border',
        'responsi_blog_box_border',
    ]

    var border_radius_fields = [
    ];

    var shadow_fields = [
        'responsi_blog_box_shadow',
        'responsi_blog_post_thumbnail_shadow',
    ];

    var margin_padding_fields = [
        'responsi_blog_post_thumbnail_margin',
        'responsi_blog_post_thumbnail_padding',
        'responsi_blog_post_title_padding',
        'responsi_blog_post_date_padding',
        'responsi_blog_post_description_padding',
        'responsi_blogext_padding',
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(typefonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_blogs();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(typeborder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_blogs();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(typeborderboxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_blogs();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(typeradius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_blogs();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(typeshadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_blogs();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(typemp, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    responsi_preview_blogs();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(typebg, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    responsi_preview_blogs();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                responsi_preview_blogs();
            });
        });
    });

    wp.customize('responsi_disable_blog_morelink',function( value ) {
        value.bind(function(to) {
            if( to == 'true' ){
                $( '.blogs-more' ).addClass('show-more-link').removeClass('hide-more-link');
                $( '.blogs-more' ).parent().parent().parent('.entry-content').show();
            }else{
                $( '.blogs-more' ).addClass('hide-more-link').removeClass('show-more-link');
                if( 'false' === wp.customize.value('responsi_disable_blog_content')() ){
                    $( '.blogs-more' ).parent().parent().parent('.entry-content').hide();
                }
            }
            $(window).trigger('resize');
        });
    });
    wp.customize('responsi_blog_morelink_type',function( value ) {
        value.bind(function(to) {
            if( to == 'button' ){
                $( '.blogs-more' ).addClass('button').removeClass('more-link');
            }else{
                $( '.blogs-more' ).addClass('more-link').removeClass('button');
            }
            $(window).trigger('resize');
        });
    });
    wp.customize('responsi_blog_morelink_text',function( value ) {
        value.bind(function(to) {
            $( '.blogs-more' ).html(to);
            $(window).trigger('resize');
        });
    });
    
} )( jQuery );
