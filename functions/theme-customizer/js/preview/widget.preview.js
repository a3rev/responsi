/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    function _previewWidgets() {
        var css = '';

        var responsi_enable_widget_container_bg_image = wp.customize.value('responsi_enable_widget_container_bg_image')();
        var responsi_widget_container_bg_image = wp.customize.value('responsi_widget_container_bg_image')();
        var responsi_widget_container_bg_position_horizontal = wp.customize.value('responsi_widget_container_bg_position_horizontal')();
        var responsi_widget_container_bg_position_vertical = wp.customize.value('responsi_widget_container_bg_position_vertical')();
        var responsi_widget_container_bg_image_repeat = wp.customize.value('responsi_widget_container_bg_image_repeat')();

        css += '.sidebar .sidebar-ctn, .sidebar-alt .sidebar-ctn{';
        if (responsi_enable_widget_container_bg_image == 'true') {
            css += 'background-image: url(' + responsi_widget_container_bg_image + ') !important;';
            css += 'background-position:' + responsi_widget_container_bg_position_horizontal + ' ' + responsi_widget_container_bg_position_vertical + ';';
            css += 'background-repeat:' + responsi_widget_container_bg_image_repeat + ';';
        } else {
            css += 'background-image: none !important;';
        }
        css += _cFn.renderBG('responsi_widget_container_bg', true);
        css += _cFn.renderBorder('responsi_widget_container_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_widget_container_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_widget_container_border_lr', 'left', true);
        css += _cFn.renderBorder('responsi_widget_container_border_lr', 'right', true);
        css += _cFn.renderRadius('responsi_widget_container_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_widget_container_border_radius_tr', 'top-right', true);
        css += _cFn.renderRadius('responsi_widget_container_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_widget_container_border_radius_br', 'bottom-right', true);
        css += _cFn.renderMarPad('responsi_widget_container_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_widget_container_margin', 'margin', true);
        css += _cFn.renderShadow('responsi_widget_container_box_shadow', true);
        css += 'box-sizing: border-box;';
        css += '}';

        css += '.sidebar .widget, .sidebar-alt .widget{';
        css += _cFn.renderBG('responsi_widget_bg');
        css += _cFn.renderMarPad('responsi_widget_padding', 'padding');
        css += _cFn.renderBorderBoxs('responsi_widget_border');
        css += _cFn.renderShadow('responsi_widget_box_shadow', true);
        css += 'text-align:' + wp.customize.value('responsi_widget_font_text_alignment')() + ';float: none; ';
        css += '}';

        var responsi_widget_title_text_alignment = wp.customize.value('responsi_widget_title_text_alignment')();
        var responsi_widget_title_transform = wp.customize.value('responsi_widget_title_transform')();
        var responsi_widget_title_align = wp.customize.value('responsi_widget_title_align')();

        css += '.sidebar .widget-title h3, .sidebar-alt .widget-title h3 {';
        css += _cFn.renderBG('responsi_widget_title_bg');
        css += _cFn.renderTypo('responsi_widget_font_title', true);
        css += 'text-align:' + responsi_widget_title_text_alignment + ' !important;';
        css += 'text-transform:' + responsi_widget_title_transform + ' !important;';
        css += _cFn.renderMarPad('responsi_widget_title_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_widget_title_margin', 'margin');
        css += _cFn.renderBorder('responsi_widget_title_border_top', 'top');
        css += _cFn.renderBorder('responsi_widget_title_border_bottom', 'bottom');
        css += _cFn.renderBorder('responsi_widget_title_border_left', 'left');
        css += _cFn.renderBorder('responsi_widget_title_border_right', 'right');
        css += _cFn.renderRadius('responsi_widget_title_border_radius_tl', 'top-left');
        css += _cFn.renderRadius('responsi_widget_title_border_radius_tr', 'top-right');
        css += _cFn.renderRadius('responsi_widget_title_border_radius_bl', 'bottom-left');
        css += _cFn.renderRadius('responsi_widget_title_border_radius_br', 'bottom-right');
        css += _cFn.renderShadow('responsi_widget_title_box_shadow', true);
        if (responsi_widget_title_align == 'left') {
            css += 'float:left !important;';
        }
        if (responsi_widget_title_align == 'right') {
            css += 'float:right !important;';
        }
        if (responsi_widget_title_align == 'center') {
            css += 'float:none !important;margin-left:auto !important;margin-right:auto !important;display:table;';
        }
        if (responsi_widget_title_align == 'stretched') {
            css += 'float:none !important;display:block;';
        }
        css += '}';

        css += '.sidebar .widget, .sidebar-alt .widget{';
        css += 'margin-bottom:' + wp.customize.value('responsi_widget_margin_between')() + 'px;';
        css += '}';

        css += '.sidebar .widget-content, .sidebar-alt .widget-content {';
        css += _cFn.renderMarPad('responsi_widget_content_padding', 'padding', true);
        css += '}';

        css += '.sidebar .widget ul li, .sidebar .widget ol li, .sidebar .widget p, .sidebar .widget .textwidget, .sidebar .widget:not(div), .sidebar .widget .textwidget .tel, .sidebar .widget .textwidget .tel a, .sidebar .widget .textwidget a[href^=tel], .sidebar .widget * a[href^=tel], .sidebar .widget a[href^=tel], .sidebar-alt .widget ul li, .sidebar-alt .widget ol li, .sidebar-alt .widget p, .sidebar-alt .widget .textwidget, .sidebar-alt .widget:not(div), .sidebar-alt .widget .textwidget .tel, .sidebar-alt .widget .textwidget .tel a, .sidebar-alt .widget .textwidget a[href^=tel], .sidebar-alt .widget * a[href^=tel], .sidebar-alt .widget a[href^=tel] {';
        css += _cFn.renderTypo('responsi_widget_font_text');
        css += '}';

        css += '.sidebar .widget a,.sidebar-alt .widget a, .sidebar .widget a:link,.sidebar-alt .widget a:link {';
        css += 'color: ' + wp.customize.value('responsi_widget_link_color')() + ' !important;';
        css += '}';

        css += '.sidebar .widget a:visited,.sidebar-alt .widget a:visited {';
        css += 'color: ' + wp.customize.value('responsi_widget_link_visited_color')() + ' !important;';
        css += '}';

        css += '.sidebar .widget a:hover,.sidebar-alt .widget a:hover {';
        css += 'color: ' + wp.customize.value('responsi_widget_link_hover_color')() + ' !important;';
        css += '}';

        if ($('#custom_widgets').length > 0) {
            $('#custom_widgets').html(css);
        } else {
            $('head').append('<style id="custom_widgets">' + css + '</style>');
        }
    }

    var fonts_fields = [
        'responsi_widget_font_title',
        'responsi_widget_font_text',
    ];

    var single_fields = [
        'responsi_widget_title_text_alignment',
        'responsi_widget_title_transform',
        'responsi_widget_title_align',
        'responsi_widget_link_color',
        'responsi_widget_link_hover_color',
        'responsi_widget_link_visited_color',
        'responsi_widget_font_text_alignment',
        'responsi_widget_margin_between',
        'responsi_enable_widget_container_bg_image',
        'responsi_widget_container_bg_image',
        'responsi_widget_container_bg_image_repeat',
    ];

    var bg_fields = [
        'responsi_widget_bg',
        'responsi_widget_container_bg',
        'responsi_widget_title_bg',
    ];

    var border_fields = [
        'responsi_widget_title_border_top',
        'responsi_widget_title_border_bottom',
        'responsi_widget_title_border_left',
        'responsi_widget_title_border_right',
        'responsi_widget_container_border_top',
        'responsi_widget_container_border_bottom',
        'responsi_widget_container_border_lr',
    ];

    var border_boxes_fields = [
        'responsi_widget_border',
    ]

    var border_radius_fields = [
        'responsi_widget_title_border_radius_tl',
        'responsi_widget_title_border_radius_tr',
        'responsi_widget_title_border_radius_bl',
        'responsi_widget_title_border_radius_br',
        'responsi_widget_container_border_radius_tl',
        'responsi_widget_container_border_radius_tr',
        'responsi_widget_container_border_radius_bl',
        'responsi_widget_container_border_radius_br',
    ];

    var shadow_fields = [
        'responsi_widget_box_shadow',
        'responsi_widget_title_box_shadow',
        'responsi_widget_container_box_shadow',
    ];

    var margin_padding_fields = [
        'responsi_widget_padding',
        'responsi_widget_title_margin',
        'responsi_widget_title_padding',
        'responsi_widget_content_padding',
        'responsi_widget_container_margin',
        'responsi_widget_container_padding',
    ];

    var position_fields = [
        'responsi_widget_container_bg_position',
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(window.ctrlFonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewWidgets();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewWidgets();
                });
            });
        });
    });

    $.each(border_boxes_fields, function(inx, val) {
        $.each(window.ctrlBorderBoxes, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewWidgets();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewWidgets();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewWidgets();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewWidgets();
                });
            });
        });
    });

    $.each(position_fields, function(inx, val) {
        $.each(window.ctrlPos, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewWidgets();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewWidgets();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewWidgets();
            });
        });
    });

    function _animationWidget( container, option_name ){
        
        var _container = $('body').find(container),
        type = wp.customize.value(option_name+'[type]')(),
        duration = wp.customize.value(option_name+'[duration]')(),
        delay = wp.customize.value(option_name+'[delay]')(),
        direction = wp.customize.value(option_name+'[direction]')(),
        old_type = _container.data('animation'),
        animationHaveDirection = [ 'bounce', 'fade', 'slide', 'zoom' ],
        animation_type = ( animationHaveDirection.indexOf( type ) > -1 ) ? type+'In'+direction.charAt( 0 ).toUpperCase() + direction.substring( 1 ): type;
        if( 'slide' === type && direction === '' ){
            animation_type = type+'InLeft';
        }

        _container.attr('class','msr-wg animateMe').attr('data',animation_type);

        setTimeout(function(){
            _container.attr( 'style', 'animation-delay:'+delay+'s;animation-duration:'+duration+'s');
            _container.removeClass(old_type).addClass( animation_type ).data('animation', animation_type );
        },10);
        

        setTimeout(function(){
            scrollWaypointInit(_container);
        },50);

    }

    var responsi_widget_animation = {
        'responsi_widget_animation' : '.content .sidebar .msr-wg, .content .sidebar-alt .msr-wg',
    };

    $.each( responsi_widget_animation, function(inx, val) {

        wp.customize(inx+'[type]', function(value) {
            value.bind(function(to) {
                _animationWidget( val,inx );
            });
        });

        wp.customize(inx+'[duration]', function(value) {
            value.bind(function(to) {
                _animationWidget( val,inx );
            });
        });

        wp.customize(inx+'[delay]', function(value) {
            value.bind(function(to) {
                _animationWidget( val,inx );
            });
        });

        wp.customize(inx+'[direction]', function(value) {
            value.bind(function(to) {
                _animationWidget( val,inx );
            });
        });
    });

})(jQuery);