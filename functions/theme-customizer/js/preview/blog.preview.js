/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function( $ ) {
	function _previewBlogs(){
        
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
                css += '@media screen and (min-width:481px) {';
                    css += '.card-item .card-thumb{width:'+grid_thumb_width+'% !important;clear:none;float:left;}';
                    css += '.card-item .card-content{width:'+grid_content_width+'%;clear:none;float:right;}';
                css += '}';
            }else{
                if( responsi_post_thumbnail_type == 'right' ){
                    css += '@media screen and (min-width:481px) {';
                        css += '.card-item .card-thumb{width:'+grid_thumb_width+'%;clear:none;float:right;}';
                        css += '.card-item .card-content{width:'+grid_content_width+'%;clear:none;float:left;}';
                    css += '}';
                }
            }
        }else{
            css += '.card-item .card-thumb{width:100%;clear:both;display: inline-block;float:none;}';
            css += '.card-item .card-content{width:100%;clear:both;float:none;}';
        }

        css += '.box-item .entry-item.card-item,.main .box-item .entry-item.card-item,.main .box-item .entry-item{'+_cFn.renderBG('responsi_blog_box_bg',true)+_cFn.renderBorderBoxs('responsi_blog_box_border',true)+_cFn.renderShadow('responsi_blog_box_shadow',true)+'}';

        css += '.main .box-item .entry-item.card-item .thumb{'+_cFn.renderBG('responsi_blog_post_thumbnail_bg',true)+_cFn.renderMarPad('responsi_blog_post_thumbnail_margin','margin',true)+_cFn.renderMarPad('responsi_blog_post_thumbnail_padding','padding',true)+_cFn.renderBorderBoxs('responsi_blog_post_thumbnail_border',true)+_cFn.renderShadow('responsi_blog_post_thumbnail_shadow',true)+'}';

        var responsi_blog_post_font_title_transform = wp.customize.value('responsi_blog_post_font_title_transform')();
        var responsi_blog_post_title_alignment = wp.customize.value('responsi_blog_post_title_alignment')();
        css += '.main .box-item .entry-item.card-item h2{'+_cFn.renderMarPad('responsi_blog_post_title_padding','padding',true)+'}';
        css += 'body.category .main .box-item .entry-item h2 a,body.tag .main .box-item .entry-item h2 a,body.page-template-template-blog-php .main .box-item .entry-item h2 a, .box-item .entry-item h2 a, body.category .main .box-item .entry-item h2,body.tag .main .box-item .entry-item h2,body.page-template-template-blog-php .main .box-item .entry-item h2, .box-item .entry-item h2,body .main .card .card-item h2 a:link,.main .card.box-item .entry-item h2 a:link, .main .card.box-item .entry-item h2 a:visited{text-transform: '+responsi_blog_post_font_title_transform+' !important;text-align: '+responsi_blog_post_title_alignment+' !important;'+_cFn.renderTypo('responsi_blog_post_font_title',true)+'}';

        var responsi_blog_post_font_date_transform = wp.customize.value('responsi_blog_post_font_date_transform')();
        var responsi_blog_post_date_alignment = wp.customize.value('responsi_blog_post_date_alignment')();
        var responsi_blog_post_date_icon = wp.customize.value('responsi_blog_post_date_icon')();
        css += '.box-item .entry-item .blogpostinfo{text-transform: '+responsi_blog_post_font_date_transform+' !important;text-align: '+responsi_blog_post_date_alignment+' !important;'+_cFn.renderTypo('responsi_blog_post_font_date',true)+_cFn.renderMarPad('responsi_blog_post_date_padding','padding',true)+'}';
        css += '.box-item .entry-item .blogpostinfo .i_date:before{color:'+responsi_blog_post_date_icon+' !important;position: relative;font-size: 90%;}';
        var responsi_enable_blog_post_date_icon = wp.customize.value('responsi_enable_blog_post_date_icon')();
        if(responsi_enable_blog_post_date_icon != 'true'){
            css += '.box-item .entry-item .blogpostinfo .i_date:before{display:none !important;}';
        }else{
            css += '.box-item .entry-item .blogpostinfo .i_date:before{display:inherit !important;}';
        }
        var responsi_blog_post_content_alignment = wp.customize.value('responsi_blog_post_content_alignment')();
        css += '.main .box-item .entry-item.card-item .card-info{'+_cFn.renderMarPad('responsi_blog_post_description_padding','padding',true)+'}';
        css += 'body.category .main .box-item .entry-item .card-info p,body.tag .main .box-item .entry-item .card-info p,body.page-template-template-blog-php .main .box-item .entry-item .card-info p, .box-item .entry-item .card-info p,.box-item .people_position_container,.box-item .sponsor_phone_container,.box-item .room-content{text-align: '+responsi_blog_post_content_alignment+' !important;'+_cFn.renderTypo('responsi_blog_post_font_content',true)+'}';

        var responsi_enable_post_author_archive_icon = wp.customize.value('responsi_enable_post_author_archive_icon')();
        var responsi_post_author_archive_icon = wp.customize.value('responsi_post_author_archive_icon')();
        var responsi_blog_ext_alignment = wp.customize.value('responsi_blog_ext_alignment')();

        var responsi_blogext_padding_left = wp.customize.value('responsi_blogext_padding_left')();
        var responsi_blogext_padding_right = wp.customize.value('responsi_blogext_padding_right')();

        css += 'body .main .box-item .entry-item.card-item .card-meta .postinfo,.main .box-item .entry-item .card-meta .postinfo,body .main .box-item .entry-item.card-item .card-meta .posttags,.main .box-item .entry-item .card-meta .posttags, body .room_grid_view .box-item .entry-item .room-bottom .view_rom_container,body .room_grid_view .box-item .entry-item .room-bottom .view_room_container,.main .box-item .entry-item .card-meta .postinfo, body .room_grid_view .box-item .entry-item .room-bottom .postedin,body .project_grid_view .box-item .entry-item #container_projects .project-bottom .postedin,body #container_projects .view_project_container,body #container_projects .view_project_container,body .sponsor_grid_view .box-item .entry-item #container_sponsor .sponsor-bottom .postedin,body #container_sponsor .postedin,body .people_grid_view .box-item .entry-item #container_people .people-bottom .postedin,body #container_people .postedin,body .content .main .box-item .entry-item .view_people_container{'+_cFn.renderBG('responsi_post_author_archive_bg',true)+'}';
        css += 'body .logout-link:after, body .profile-link:after, body .dashboard-link:after, body .lost_password-link:after, body .register-link:after{color:' + responsi_post_author_archive_icon + ' !important;}';
        css += '.i_author:before,.i_cat:before,.i_comment:before,.i_tag:before,.i_authors span.author .fn:before {margin-right:5px;position:relative;color:' + responsi_post_author_archive_icon + ';}';
        css += '.i_comment{margin-right:3px;}';
        css += '.post p.tags:hover:before,.post p.tags:before,.icon:before, .icon:after {color:' + responsi_post_author_archive_icon + ';}';
        css += 'body.category .main .box-item .entry-item .card-meta,body.tag .main .box-item .entry-item .card-meta,body.page-template-template-blog-php .main .box-item .entry-item .card-meta, .box-item .entry-item .card-meta,.box-item .room-bottom, .box-item .project-bottom, .box-item .people-bottom, .box-item .sponsor-bottom{text-align:' +responsi_blog_ext_alignment+ ';' +_cFn.renderTypo('responsi_blog_ext_font',true)+'}';
        css += '.main .box-item .entry-item.card-item .card-meta .postinfo,.main .box-item .entry-item.card-item .card-meta .posttags,.main .box-item .entry-item .card-meta .posttags, body .room_grid_view .box-item .entry-item .room-bottom .view_rom_container, body .room_grid_view .box-item .entry-item .room-bottom .view_room_container,.main .box-item .entry-item .card-meta .postinfo, body .room_grid_view .box-item .entry-item .room-bottom .postedin,body .project_grid_view .box-item .entry-item #container_projects .project-bottom .postedin,body #container_projects .view_project_container,body #container_projects .view_project_container,body .sponsor_grid_view .box-item .entry-item #container_sponsor .sponsor-bottom .postedin,body #container_sponsor .postedin,body .people_grid_view .box-item .entry-item #container_people .people-bottom .postedin,body #container_people .view_people_container{'+_cFn.renderMarPad('responsi_blogext_padding','padding',true)+_cFn.renderBorder('responsi_post_author_archive_border_top','top',true)+_cFn.renderBorder('responsi_post_author_archive_border_bottom','bottom',true)+'margin :0px !important;}';
        css += 'body .main .box-item .entry-item.card-item .card-meta .posttags,.main .box-item .entry-item .card-meta .posttags, div.box-content .box-item div.entry-item .card-meta .posttags{'+_cFn.renderBorder('responsi_post_tags_comment_border_top','top',true)+_cFn.renderBorder('responsi_post_tags_comment_border_bottom','bottom',true)+'}';
        if(responsi_enable_post_author_archive_icon != 'true'){
            css += '.box-item .card-meta .i_author:before, .box-item .card-meta .i_cat:before, .box-item .card-meta .i_comment:before, .box-item .card-meta .i_tag:before{display:none !important;}';
        }else{
            css += '.box-item .card-meta .i_author:before, .box-item .card-meta .i_cat:before, .box-item .card-meta .i_comment:before, .box-item .card-meta .i_tag:before{display:inherit !important;}';
        }
        css += 'div.box-content .box-item div.entry-item .card-info a.more-link,.content-ctn .content div.box-content .box-item div.entry-item .card-info a.button{';
            css += _cFn.renderTypo('responsi_blog_morelink_font',false);
        css += '}';

        var enable_fix_tall_title_grid = wp.customize.value('responsi_enable_fix_tall_title_grid')();
        var blog_title_line_height = wp.customize.value('responsi_blog_post_font_title[line_height]')();

        css += '@media only screen and (min-width: 480px) {';
        if (enable_fix_tall_title_grid == '1') {
            var blog_title_height = parseFloat(blog_title_line_height) + 0.1 ;
            css += 'body .main .box-item .entry-item h2 a{display:block !important;height: '+blog_title_height+'em !important;overflow: hidden !important;line-height:'+parseFloat(blog_title_line_height)+'em !important;}';
        }
        if (enable_fix_tall_title_grid == '2') {
            var blog_title_height = ( parseFloat(blog_title_line_height) * 2 ) + 0.1 ;
            css += 'body .main .box-item .entry-item h2 a{display:block !important;height: '+blog_title_height+'em !important;overflow: hidden !important;line-height:'+parseFloat(blog_title_line_height)+'em !important;}';
        }
        if (enable_fix_tall_title_grid == '3') {
            var blog_title_height = ( parseFloat(blog_title_line_height) * 3 ) + 0.1 ;
            css += 'body .main .box-item .entry-item h2 a{display:block !important;height: '+blog_title_height+'em !important;overflow: hidden !important;line-height:'+parseFloat(blog_title_line_height)+'em !important;}';
        }
        if (enable_fix_tall_title_grid == 'none') {
            css += 'body .main .box-item .entry-item h2 a{display:inherit !important;height: inherit !important;overflow: inherit !important;line-height:'+parseFloat(blog_title_line_height)+'em !important;}';
        }
        css += '}';

        var enable_fix_tall_des_grid = wp.customize.value('responsi_enable_fix_tall_des_grid')();
        var blog_des_line_height = wp.customize.value('responsi_blog_post_font_content[line_height]')();

        if (enable_fix_tall_des_grid == '1') {
            var blog_des_height = parseFloat(blog_des_line_height) ;
            css += 'body .main .box-item .entry-item p.desc{display:block !important;height: '+blog_des_height+'em !important;overflow: hidden !important;line-height:'+blog_des_line_height+'em !important;}';
        }
        if (enable_fix_tall_des_grid == '2') {
            var blog_des_height = parseFloat(blog_des_line_height) * 2 ;
            css += 'body .main .box-item .entry-item p.desc{display:block !important;height: '+blog_des_height+'em !important;overflow: hidden !important;line-height:'+blog_des_line_height+'em !important;}';
        }
        if (enable_fix_tall_des_grid == '3') {
            var blog_des_height = parseFloat(blog_des_line_height) * 3 ;
            css += 'body .main .box-item .entry-item p.desc{display:block !important;height: '+blog_des_height+'em !important;overflow: hidden !important;line-height:'+blog_des_line_height+'em !important;}';
        }
        if (enable_fix_tall_des_grid == '4') {
            var blog_des_height = parseFloat(blog_des_line_height) * 4 ;
            css += 'body .main .box-item .entry-item p.desc{display:block !important;height: '+blog_des_height+'em !important;overflow: hidden !important;line-height:'+blog_des_line_height+'em !important;}';
        }

        var blog_ext_line_height = wp.customize.value('responsi_blog_ext_font[line_height]')();
        var responsi_enable_fix_ext_cat_author = wp.customize.value('responsi_enable_fix_ext_cat_author')();
        var responsi_enable_fix_ext_tags_comment = wp.customize.value('responsi_enable_fix_ext_tags_comment')();

        if (responsi_enable_fix_ext_cat_author == '1') {
            blog_ext_height = parseFloat(blog_ext_line_height) ;
            css += 'body .main .box-item .entry-item .card-meta .postinfo .meta-lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_cat_author == '2') {
            blog_ext_height = parseFloat(blog_ext_line_height) * 2 ;
            css += 'body .main .box-item .entry-item .card-meta .postinfo .meta-lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_cat_author == '3') {
            blog_ext_height = parseFloat(blog_ext_line_height) * 3 ;
            css += 'body .main .box-item .entry-item .card-meta .postinfo .meta-lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_cat_author == 'none') {
            css += 'body .main .box-item .entry-item .card-meta .postinfo .meta-lines{display:inherit !important;height: auto !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }

        if (responsi_enable_fix_ext_tags_comment == '1') {
            blog_ext_height = parseFloat(blog_ext_line_height) ;
            css += 'body .main .box-item .entry-item .card-meta .posttags .meta-lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_tags_comment == '2') {
            blog_ext_height = parseFloat(blog_ext_line_height) * 2 ;
            css += 'body .main .box-item .entry-item .card-meta .posttags .meta-lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_tags_comment == '3') {
            blog_ext_height = parseFloat(blog_ext_line_height) * 3 ;
            css += 'body .main .box-item .entry-item .card-meta .posttags .meta-lines{display:block !important;height: '+blog_ext_height+'em !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }
        if (responsi_enable_fix_ext_tags_comment == 'none') {
            css += 'body .main .box-item .entry-item .card-meta .posttags .meta-lines{display:inherit !important;height: auto !important;overflow: hidden !important;line-height:'+blog_ext_line_height+'em !important;}';
        }

        if ( wp.customize.value('responsi_blog_morelink_alignment')() == 'left') {
            css += '.ctrl-open{text-align:'+wp.customize.value('responsi_blog_morelink_alignment')()+';}';
        }
        if ( wp.customize.value('responsi_blog_morelink_alignment')() == 'right') {
            css += '.ctrl-open{text-align:'+wp.customize.value('responsi_blog_morelink_alignment')()+';}';
        }
        if ( wp.customize.value('responsi_blog_morelink_alignment')() == 'center') {
            css += '.ctrl-open{text-align:'+wp.customize.value('responsi_blog_morelink_alignment')()+';}';
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
        $.each(window.ctrlFonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewBlogs();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewBlogs();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(window.ctrlBorderBoxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewBlogs();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewBlogs();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewBlogs();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewBlogs();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewBlogs();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewBlogs();
            });
        });
    });

    wp.customize('responsi_disable_blog_morelink',function( value ) {
        value.bind(function(to) {
            if( to == 'true' ){
                $( '.ctrl' ).addClass('ctrl-open').removeClass('ctrl-close');
                $( '.ctrl' ).parent().parent().parent('.card-info').show();
            }else{
                $( '.ctrl' ).addClass('ctrl-close').removeClass('ctrl-open');
                if( 'false' === wp.customize.value('responsi_disable_blog_content')() ){
                    $( '.ctrl' ).parent().parent().parent('.card-info').hide();
                }
            }
            $(window).trigger('resize');
        });
    });
    wp.customize('responsi_blog_morelink_type',function( value ) {
        value.bind(function(to) {
            if( to == 'button' ){
                $( '.ctrl a' ).addClass('button').removeClass('more-link');
            }else{
                $( '.ctrl a' ).addClass('more-link').removeClass('button');
            }
            $(window).trigger('resize');
        });
    });
    wp.customize('responsi_blog_morelink_text',function( value ) {
        value.bind(function(to) {
            $( '.ctrl' ).html(to);
            $(window).trigger('resize');
        });
    });


    var _animBlogObj = {
        'responsi_blog_animation' : '.box-content .card .animateMe',
    };

    $.each( _animBlogObj, function(inx, val) {

        wp.customize(inx+'[type]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimationCards( val,inx );
            });
        });

        wp.customize(inx+'[duration]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimationCards( val,inx );
            });
        });

        wp.customize(inx+'[delay]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimationCards( val,inx );
            });
        });

        wp.customize(inx+'[direction]', function(value) {
            value.bind(function(to) {
                _cFn.renderAnimationCards( val,inx );
            });
        });
    });
    
} )( jQuery );
