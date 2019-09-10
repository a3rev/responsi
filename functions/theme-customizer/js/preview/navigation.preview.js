/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    function _previewNavigations() {

        var css = '';

        css += '.responsi-navigation{';
        css += _cFn.renderBG('responsi_container_nav_bg');
        if (wp.customize.value('responsi_enable_container_nav_bg_image')() == 'true') {

            var bimage = wp.customize.value('responsi_container_bg_image')();
            var bvertical = wp.customize.value('responsi_container_bg_position_vertical')();
            var bhorizontal = wp.customize.value('responsi_container_bg_position_horizontal')();
            var brepeat = wp.customize.value('responsi_container_bg_image_repeat')();

            css += 'background-image: url(' + bimage + ') !important;';
            css += 'background-position:' + bhorizontal + ' ' + bvertical + ' !important;';
            css += 'background-repeat:' + brepeat + ' !important;';
        } else {
            css += 'background-image: none !important;';
        }

        css += _cFn.renderMarPad('responsi_container_nav_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_container_nav_margin', 'margin', true);
        css += _cFn.renderBorder('responsi_container_nav_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_container_nav_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_container_nav_border_lr', 'left', true);
        css += _cFn.renderBorder('responsi_container_nav_border_lr', 'right', true);
        css += _cFn.renderShadow('responsi_nav_box_shadow', true);

        css += '}';

        css += '.navigation{';
        css += 'text-align: ' + wp.customize.value('responsi_nav_position')() + ' !important;';
        css += '}';

        css += '.navigation{';
        css += _cFn.renderBG('responsi_nav_bg', true);
        css += _cFn.renderMarPad('responsi_nav_padding_tb', 'padding', true);
        css += _cFn.renderMarPad('responsi_nav_padding_lr', 'padding', true);
        css += _cFn.renderMarPad('responsi_nav_margin', 'margin', true);
        css += _cFn.renderBorder('responsi_nav_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_nav_border_bot', 'bottom', true);
        css += _cFn.renderBorder('responsi_nav_border_lr', 'left', true);
        css += _cFn.renderBorder('responsi_nav_border_lr', 'right', true);
        css += _cFn.renderRadius('responsi_nav_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_nav_border_radius_tr', 'top-right', true);
        css += _cFn.renderRadius('responsi_nav_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_nav_border_radius_br', 'bottom-right', true);
        css += _cFn.renderShadow('responsi_nav_shadow', true);
        css += '}';

        css += '.navigation-in nav > ul.menu > li,.navigation-in div > ul.menu > li , .navigation-in .partial-refresh-menu-container ul.menu > li{';
        css += _cFn.renderBorder('responsi_nav_divider_border', 'left', true);
        css += '}';

        var responsi_nav_font_size = wp.customize.value('responsi_nav_font[size]')();
        var responsi_nav_font_line_height = wp.customize.value('responsi_nav_font[line_height]')();
        var responsi_nav_font_face = wp.customize.value('responsi_nav_font[face]')();
        var responsi_nav_font_style = wp.customize.value('responsi_nav_font[style]')();
        var responsi_nav_font_color = wp.customize.value('responsi_nav_font[color]')();
        var responsi_nav_hover = wp.customize.value('responsi_nav_hover')();
        var responsi_nav_currentitem = wp.customize.value('responsi_nav_currentitem')();

        css += '.navigation-in ul.menu > li.menu-item-has-children > a:after{border-color:' + responsi_nav_font_color + ' transparent transparent !important;}';
        css += '.navigation-in nav > ul.menu > li > a,.navigation-in div > ul.menu > li > a ,.navigation-in nav > ul.menu > li:first-child > a,.navigation-in div > ul.menu > li:first-child > a , .navigation-in .partial-refresh-menu-container ul.menu > li > a,.navigation-in .navigation-in .partial-refresh-menu-container ul > li:first-child > a{';
        css += _cFn.renderTypo('responsi_nav_font', true);
        css += 'text-transform:' + wp.customize.value('responsi_nav_font_transform')() + ' !important;';
        css += _cFn.renderBorder('responsi_navi_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_navi_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_navi_border_left', 'left', true);
        css += _cFn.renderBorder('responsi_navi_border_right', 'right', true);
        css += _cFn.renderRadius('responsi_navi_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_navi_border_radius_tr', 'top-right', true);
        css += _cFn.renderRadius('responsi_navi_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_navi_border_radius_br', 'bottom-right', true);
        css += _cFn.renderMarPad('responsi_navi_border_padding', 'padding', true);
        css += _cFn.renderMarPad('responsi_navi_border_margin', 'margin', true);
        css += '}';
        css += '.navigation-in ul.menu > li.current-menu-item > a{' + _cFn.renderBG('responsi_nav_currentitem_bg', true) + 'color:' + responsi_nav_currentitem + ' !important;}';
        css += '.navigation-in ul.menu > li > a:hover,.navigation-in ul.menu > li:hover > a,.navigation-in .menu > li.menu-item-has-children:hover > a,.navigation-mobile .hamburger-icon:hover,.navigation-mobile .responsi-icon-cancel:hover,.navigation-in ul.menu > li.current-menu-item > a:hover{color:' + responsi_nav_hover + ' !important;}';
        css += '.navigation-in ul.menu > li a:hover, .navigation-in ul.menu > li.menu-item-has-children:hover > a,.navigation-in ul.menu > li:hover > a {' + _cFn.renderBG('responsi_nav_hover_bg', true) + '}';
        css += '.navigation-in ul.menu > li.menu-item-has-children:hover > a:after,.navigation-in ul.menu > li.menu-item-has-children.current-menu-item:hover > a:after{border-color:' + responsi_nav_hover + ' transparent transparent !important;}';
        css += '.navigation-in ul.menu > li.menu-item-has-children.current-menu-item > a:after{border-color:' + responsi_nav_hover + ' transparent transparent !important;}';

        css += '.navigation-in nav > ul.menu > li > a, .navigation-in div > ul.menu > li > a, .navigation-in nav > ul.menu > li:first-child > a, .navigation-in div > ul.menu > li:first-child > a, .navigation-in .partial-refresh-menu-container ul.menu > li > a, .navigation-in .navigation-in .partial-refresh-menu-container ul > li:first-child > a{';
        css += _cFn.renderBG('responsi_navi_background', true);
        css += '}';

        //Dropdown

        css += '.navigation-in ul.menu ul li a{' + _cFn.renderBG('responsi_nav_dropdown_item_background') + '}';
        css += '.navigation-in ul.menu > li ul li a:hover,.navigation-in ul.menu > li ul li:hover{' + _cFn.renderBG('responsi_nav_dropdown_hover_background', true) + '}';
        css += '.navigation-in ul.menu > li.menu-item-has-children:hover ul li a{color:' + wp.customize.value('responsi_nav_dropdown_font[color]')() + ' !important;}';
        css += '.navigation-in ul.menu li.menu-item-has-children ul li a:hover{color:' + wp.customize.value('responsi_nav_dropdown_hover_color')() + ' !important;}';
        css += '.navigation-in ul.menu > li > ul > li.menu-item-has-children a:after { border-color:transparent transparent transparent ' + wp.customize.value('responsi_nav_dropdown_font[color]')() + ';}';
        css += '.navigation-in ul.menu > li > ul li.menu-item-has-children:hover > a:hover:after{ border-color:transparent transparent transparent ' + wp.customize.value('responsi_nav_dropdown_hover_color')() + ' !important;}';

        css += '.navigation-in ul.menu ul{';
        css += _cFn.renderBG('responsi_nav_dropdown_background', true);
        css += _cFn.renderMarPad('responsi_nav_dropdown_padding', 'padding', true);
        css += _cFn.renderBorder('responsi_nav_dropdown_border_top', 'top', true);
        css += _cFn.renderBorder('responsi_nav_dropdown_border_bottom', 'bottom', true);
        css += _cFn.renderBorder('responsi_nav_dropdown_border_left', 'left', true);
        css += _cFn.renderBorder('responsi_nav_dropdown_border_right', 'right', true);
        css += _cFn.renderRadius('responsi_nav_dropdown_border_radius_bl', 'bottom-left', true);
        css += _cFn.renderRadius('responsi_nav_dropdown_border_radius_br', 'bottom-right', true);
        css += _cFn.renderShadow('responsi_nav_dropdown_shadow', true);
        css += '}';

        css += '.navigation-in ul.menu ul,.navigation-in ul.sub-menu > li:first-child,.navigation-in ul.sub-menu > li:first-child > a{';
        css += _cFn.renderRadius('responsi_nav_dropdown_border_radius_tl', 'top-left', true);
        css += _cFn.renderRadius('responsi_nav_dropdown_border_radius_tr', 'top-right', true);
        css += '}';

        css += '.navigation-in ul.menu ul li{';
        css += _cFn.renderBorder('responsi_nav_dropdown_separator', 'top', true);
        css += '}';

        css += '.navigation-in ul.menu ul li a {' + _cFn.renderTypo('responsi_nav_dropdown_font', true) + '}';
        css += '.navigation-in ul.menu li ul li a{';
        css += _cFn.renderMarPad('responsi_nav_dropdown_item_padding', 'padding', true);
        css += 'text-transform:' + wp.customize.value('responsi_nav_dropdown_font_transform')() + ' !important;';
        css += _cFn.renderTypo('responsi_nav_dropdown_font', true);
        css += '}';


        if ($('#custom_navi_primary').length > 0) {
            $('#custom_navi_primary').html(css);
        } else {
            $('head').append('<style id="custom_navi_primary">' + css + '</style>');
        }
    }


    var fonts_fields = [
        'responsi_nav_font',
        'responsi_nav_dropdown_font'
    ];

    var single_fields = [
        'responsi_enable_container_nav_bg_image',
        'responsi_container_bg_image',
        'responsi_container_bg_image_repeat',
        'responsi_container_bg_position_vertical',
        'responsi_container_bg_position_horizontal',
        'responsi_nav_position',
        'responsi_nav_hover',
        'responsi_nav_currentitem',
        'responsi_nav_font_transform',
        'responsi_nav_dropdown_font_transform',
        'responsi_nav_dropdown_hover_color'

    ];

    var bg_fields = [
        'responsi_container_nav_bg',
        'responsi_nav_bg',
        'responsi_nav_hover_bg',
        'responsi_nav_currentitem_bg',
        'responsi_navi_background',
        'responsi_nav_dropdown_background',
        'responsi_nav_dropdown_item_background',
        'responsi_nav_dropdown_hover_background'
    ];

    var border_fields = [
        'responsi_container_nav_border_top',
        'responsi_container_nav_border_bottom',
        'responsi_container_nav_border_lr',
        'responsi_nav_border_top',
        'responsi_nav_border_bot',
        'responsi_nav_border_lr',
        'responsi_nav_divider_border',
        'responsi_navi_border_top',
        'responsi_navi_border_bottom',
        'responsi_navi_border_left',
        'responsi_navi_border_right',
        'responsi_nav_dropdown_border_top',
        'responsi_nav_dropdown_border_bottom',
        'responsi_nav_dropdown_border_left',
        'responsi_nav_dropdown_border_right',
        'responsi_nav_dropdown_separator'

    ];

    var border_radius_fields = [
        'responsi_nav_border_radius_tl',
        'responsi_nav_border_radius_tr',
        'responsi_nav_border_radius_bl',
        'responsi_nav_border_radius_br',
        'responsi_navi_border_radius_tl',
        'responsi_navi_border_radius_tr',
        'responsi_navi_border_radius_bl',
        'responsi_navi_border_radius_br',
        'responsi_nav_dropdown_border_radius_tl',
        'responsi_nav_dropdown_border_radius_tr',
        'responsi_nav_dropdown_border_radius_bl',
        'responsi_nav_dropdown_border_radius_br',

    ];

    var shadow_fields = [
        'responsi_nav_box_shadow',
        'responsi_nav_shadow',
        'responsi_nav_dropdown_shadow'
    ];

    var margin_padding_fields = [
        'responsi_container_nav_margin',
        'responsi_container_nav_padding',
        'responsi_nav_margin',
        'responsi_nav_padding_tb',
        'responsi_nav_padding_lr',
        'responsi_navi_border_margin',
        'responsi_navi_border_padding',
        'responsi_nav_dropdown_padding',
        'responsi_nav_dropdown_item_padding'
    ];

    $.each(fonts_fields, function(inx, val) {
        $.each(window.ctrlFonts, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewNavigations();
                });
            });
        });
    });

    $.each(border_fields, function(inx, val) {
        $.each(window.ctrlBorder, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewNavigations();
                });
            });
        });
    });

    $.each(border_radius_fields, function(inx, val) {
        $.each(window.ctrlRadius, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewNavigations();
                });
            });
        });
    });

    $.each(shadow_fields, function(inx, val) {
        $.each(window.ctrlShadow, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewNavigations();
                });
            });
        });
    });

    $.each(margin_padding_fields, function(inx, val) {
        $.each(window.ctrlMarPad, function(i, v) {
            wp.customize(val + v, function(value) {
                value.bind(function(to) {
                    _previewNavigations();
                });
            });
        });
    });

    $.each(bg_fields, function(inx, val) {
        $.each(window.ctrlBG, function(i, v) {
            wp.customize(val + '[' + v + ']', function(value) {
                value.bind(function(to) {
                    _previewNavigations();
                });
            });
        });
    });

    $.each(single_fields, function(inx, val) {
        wp.customize(val, function(value) {
            value.bind(function(to) {
                _previewNavigations();
            });
        });
    });
})(jQuery);
