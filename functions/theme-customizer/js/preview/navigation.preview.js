/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
(function($) {

    function _previewNavigations() {

        var css = '';

        css += '@media only screen and (min-width: 783px){';

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

                if (wp.customize.value('responsi_container_bg_image_size_on')() == 'true') {
                    css += 'background-size:' + wp.customize.value('responsi_container_bg_image_size_width')() + ' ' + wp.customize.value('responsi_container_bg_image_size_height')() + ';';
                } else {
                    css += 'background-size:initial;';
                }

            } else {
                css += 'background-image: none !important;';
            }

            css += _cFn.renderMarPad('responsi_container_nav_padding', 'padding', true);
            css += _cFn.renderMarPad('responsi_container_nav_margin', 'margin', true);
            css += _cFn.renderBorder('responsi_container_nav_border_top', 'top', true);
            css += _cFn.renderBorder('responsi_container_nav_border_bottom', 'bottom', true);
            css += _cFn.renderBorder('responsi_container_nav_border_lr', 'left', true);
            css += _cFn.renderBorder('responsi_container_nav_border_lr', 'right', true);
            css += _cFn.renderRadius('responsi_container_nav_border_radius', '');
            css += _cFn.renderShadow('responsi_nav_box_shadow', true);

            css += '}';

            css += '.navigation-in{';
                css += _cFn.renderBG('responsi_content_nav_background_color');
                var responsi_content_nav_background_image_position_horizontal = 'center';
                if (wp.customize.value('responsi_content_nav_background_image_position_horizontal')() != '') {
                    responsi_content_nav_background_image_position_horizontal = wp.customize.value('responsi_content_nav_background_image_position_horizontal')();
                }
                var responsi_content_nav_background_image_position_vertical = 'center';
                if (wp.customize.value('responsi_content_nav_background_image_position_vertical')() != '') {
                    responsi_content_nav_background_image_position_vertical = wp.customize.value('responsi_content_nav_background_image_position_vertical')();
                }

                if (wp.customize.value('responsi_content_nav_background_image')() == 'true') {
                    css += 'background-image:url(' + wp.customize.value('responsi_content_nav_background_image_url')() + ');';
                    css += 'background-repeat:' + wp.customize.value('responsi_content_nav_background_image_repeat')() + ';';
                    css += 'background-position:' + responsi_content_nav_background_image_position_horizontal + ' ' + responsi_content_nav_background_image_position_vertical + ';';
                } else {
                    css += 'background-image:none !important;';
                }

                if (wp.customize.value('responsi_content_nav_background_image_size_on')() == 'true') {
                    css += 'background-size:' + wp.customize.value('responsi_content_nav_background_image_size_width')() + ' ' + wp.customize.value('responsi_content_nav_background_image_size_height')() + ';';
                } else {
                    css += 'background-size:initial;';
                }

                css += _cFn.renderMarPad('responsi_content_nav_padding', 'padding');
                css += _cFn.renderMarPad('responsi_content_nav_margin', 'margin');
                css += _cFn.renderRadius('responsi_content_nav_border_radius', '');
                css += _cFn.renderBorder('responsi_content_nav_border_top', 'top');
                css += _cFn.renderBorder('responsi_content_nav_border_bottom', 'bottom');
                css += _cFn.renderBorder('responsi_content_nav_border_lr', 'left');
                css += _cFn.renderBorder('responsi_content_nav_border_lr', 'right');
                css += _cFn.renderShadow('responsi_content_nav_box_shadow');
            css += '}';

            css += '.navigation{';
            css += 'text-align: ' + wp.customize.value('responsi_nav_position')() + ' !important;';
            css += '}';

            css += '.navigation-in ul.menu{';
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

            css += '.navigation-in ul.menu > li{';
                css += _cFn.renderMarPad('responsi_navi_li_margin', 'margin', true);
                css += _cFn.renderBorder('responsi_nav_divider_border', 'left', true);
            css += '}';

            var responsi_nav_font_size = wp.customize.value('responsi_nav_font[size]')(),
            responsi_nav_font_line_height = wp.customize.value('responsi_nav_font[line_height]')(),
            responsi_nav_font_face = wp.customize.value('responsi_nav_font[face]')(),
            responsi_nav_font_style = wp.customize.value('responsi_nav_font[style]')(),
            responsi_nav_font_color = wp.customize.value('responsi_nav_font[color]')(),
            responsi_nav_hover = wp.customize.value('responsi_nav_hover')(),
            responsi_nav_currentitem = wp.customize.value('responsi_nav_currentitem')(),
            responsi_nav_currentitem_border = wp.customize.value('responsi_nav_currentitem_border')(),
            responsi_nav_border_hover = wp.customize.value('responsi_nav_border_hover')();

            css += '.navigation-in ul.menu > li > a{';
                css += _cFn.renderTypo('responsi_nav_font');
                css += 'text-transform:' + wp.customize.value('responsi_nav_font_transform')() + ' !important;';
                css += _cFn.renderBorder('responsi_navi_border_top', 'top');
                css += _cFn.renderBorder('responsi_navi_border_bottom', 'bottom');
                css += _cFn.renderBorder('responsi_navi_border_left', 'left');
                css += _cFn.renderBorder('responsi_navi_border_right', 'right');
                css += _cFn.renderRadius('responsi_navi_border_radius_tl', 'top-left');
                css += _cFn.renderRadius('responsi_navi_border_radius_tr', 'top-right');
                css += _cFn.renderRadius('responsi_navi_border_radius_bl', 'bottom-left');
                css += _cFn.renderRadius('responsi_navi_border_radius_br', 'bottom-right');
                css += _cFn.renderMarPad('responsi_navi_border_padding', 'padding');
                css += _cFn.renderMarPad('responsi_navi_border_margin', 'margin');
                css += _cFn.renderBG('responsi_navi_background');
            css += '}';

            css += '.navigation-in ul.menu > li:first-child > a, .customize-partial-edit-shortcuts-shown .navigation-in ul.menu > li:nth-child(2) a{';
                css += _cFn.renderRadius('responsi_navi_border_radius_first_tl', 'top-left');
                css += _cFn.renderRadius('responsi_navi_border_radius_first_tr', 'top-right');
                css += _cFn.renderRadius('responsi_navi_border_radius_first_bl', 'bottom-left');
                css += _cFn.renderRadius('responsi_navi_border_radius_first_br', 'bottom-right');
            css += '}';

            css += '.navigation-in ul.menu > li:last-child > a{';
                css += _cFn.renderRadius('responsi_navi_border_radius_last_tl', 'top-left');
                css += _cFn.renderRadius('responsi_navi_border_radius_last_tr', 'top-right');
                css += _cFn.renderRadius('responsi_navi_border_radius_last_bl', 'bottom-left');
                css += _cFn.renderRadius('responsi_navi_border_radius_last_br', 'bottom-right');
            css += '}';

            if( wp.customize.value('responsi_nav_divider_border[width]')() >= 0 ){
                css += '.navigation-in ul.menu > li {'+_cFn.renderBorder('responsi_nav_divider_border', 'left', true)+'}';
                css += '.navigation-in ul.menu > li:first-child, .navigation-in ul.menu > li:first-child,.customize-partial-edit-shortcuts-shown .navigation-in ul.menu > li:nth-child(2) { border-left: 0px !important; }';
                css += '.navigation-in ul.menu > li > ul  { left: ' + wp.customize.value('responsi_navi_border_margin_left')() + 'px !important; }';
            }

            css += '.navigation-in ul.menu > li.menu-item-has-children > a:after{border-color:' + responsi_nav_font_color + ' transparent transparent !important;}';

            css += '.navigation-in ul.menu > li.current-menu-item > a{' + _cFn.renderBG('responsi_nav_currentitem_bg', true) + 'color:' + responsi_nav_currentitem + ' !important;border-color:'+responsi_nav_currentitem_border+';}';
            css += '.navigation-in ul.menu > li > a:hover,.navigation-in ul.menu > li:hover > a,.navigation-in .menu > li.menu-item-has-children:hover > a,.navigation-mobile .hamburger-icon:hover,.navigation-mobile .responsi-icon-cancel:hover,.navigation-in ul.menu > li.current-menu-item > a:hover{color:' + responsi_nav_hover + ' !important;border-color:'+responsi_nav_border_hover+';}';

            css += '.navigation-in ul.menu > li a:hover, .navigation-in ul.menu > li.menu-item-has-children:hover > a,.navigation-in ul.menu > li:hover > a {' + _cFn.renderBG('responsi_nav_hover_bg', true) + '}';
            css += '.navigation-in ul.menu > li.menu-item-has-children:hover > a:after,.navigation-in ul.menu > li.menu-item-has-children.current-menu-item:hover > a:after{border-color:' + responsi_nav_hover + ' transparent transparent !important;}';
            css += '.navigation-in ul.menu > li.menu-item-has-children.current-menu-item > a:after{border-color:' + responsi_nav_hover + ' transparent transparent !important;}';

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

        css += '}';

        css += '@media only screen and (max-width: 782px){';

            /* Nav Bar Mobile Style */
            css += '.navigation-mobile {';
                css += _cFn.renderBG('responsi_navbar_container_mobile_background_color', true);
                css += _cFn.renderMarPad('responsi_navbar_container_mobile_padding', 'padding', true);
                css += _cFn.renderMarPad('responsi_navbar_container_mobile_margin', 'margin', true);
                css += _cFn.renderRadius('responsi_navbar_container_mobile_border_radius', '', true);
                css += _cFn.renderBorder('responsi_navbar_container_mobile_border_top', 'top', true);
                css += _cFn.renderBorder('responsi_navbar_container_mobile_border_bottom', 'bottom', true);
                css += _cFn.renderBorder('responsi_navbar_container_mobile_border_lr', 'left', true);
                css += _cFn.renderBorder('responsi_navbar_container_mobile_border_lr', 'right', true);
                css += _cFn.renderShadow('responsi_navbar_container_mobile_box_shadow', true);
                css += 'text-align:' + wp.customize.value('responsi_nav_icon_mobile_alignment')() + ' !important;';
            css += '}';

            /* Nav Bar Icon Mobile Style */
            css += '.navigation-mobile svg.hext-icon, .navigation-mobile svg {';
                css += _cFn.renderBG('responsi_nav_icon_mobile_background_color', true);
                css += _cFn.renderMarPad('responsi_nav_icon_mobile_padding', 'padding', true);
                css += _cFn.renderMarPad('responsi_nav_icon_mobile_margin', 'margin', true);
                css += _cFn.renderRadius('responsi_nav_icon_mobile_border_radius', '', true);
                css += _cFn.renderBorder('responsi_nav_icon_mobile_border_top', 'top', true);
                css += _cFn.renderBorder('responsi_nav_icon_mobile_border_bottom', 'bottom', true);
                css += _cFn.renderBorder('responsi_nav_icon_mobile_border_left', 'left', true);
                css += _cFn.renderBorder('responsi_nav_icon_mobile_border_right', 'right', true);
                css += _cFn.renderShadow('responsi_nav_icon_mobile_box_shadow', true);
            css += '}';

            var _iconSeparatorPos = 'right';

            if (wp.customize.value('responsi_nav_icon_mobile_alignment')() == 'left') {
                _iconSeparatorPos = 'right';
                $('.navigation-mobile').addClass('alignment-left').removeClass('alignment-right');
            } else {
                _iconSeparatorPos = 'left';
                $('.navigation-mobile').addClass('alignment-right').removeClass('alignment-left');
            }

            css += '.navigation-mobile span.nav-separator {';
                css += _cFn.renderBorder('responsi_nav_icon_mobile_separator', _iconSeparatorPos);
            css += '}';

            css += '.navigation-mobile svg.hext-icon, .navigation-mobile svg{';
                css += 'font-size: ' + wp.customize.value('responsi_nav_icon_mobile_size')() + 'px !important;';
                css += 'color: ' + wp.customize.value('responsi_nav_icon_mobile_color')() + ' !important;';
                css += 'width: ' + wp.customize.value('responsi_nav_icon_mobile_size')() + 'px !important;';
                css += 'height: ' + wp.customize.value('responsi_nav_icon_mobile_size')() + 'px !important;';
            css += '}';

            if (wp.customize.value('responsi_nav_container_mobile_text_on')() == 'false') {
                $('.navigation-mobile .menu-text').html('');
            } else {
                $('.navigation-mobile .menu-text').html(wp.customize.value('responsi_nav_container_mobile_text')());
            }

            /* Nav Bar Mobile Text Style */
            css += '.navigation-mobile span.menu-text{';
                css += _cFn.renderMarPad('responsi_nav_container_mobile_text_padding', 'padding', true);
                css += _cFn.renderMarPad('responsi_nav_container_mobile_text_margin', 'margin', true);
                css += _cFn.renderTypo('responsi_nav_container_mobile_text_font', true);
                css += 'text-transform:' + wp.customize.value('responsi_nav_container_mobile_text_font_transform')() + ' !important;';
            css += '}';

            css += 'ul.responsi-menu{';
                css += _cFn.renderBG('responsi_nav_container_dropdown_mobile_background_color');
                css += _cFn.renderMarPad('responsi_nav_container_dropdown_mobile_margin', 'margin');
                css += _cFn.renderMarPad('responsi_nav_container_dropdown_mobile_padding', 'padding');
                css += _cFn.renderBorder('responsi_nav_container_dropdown_mobile_border_top', 'top');
                css += _cFn.renderBorder('responsi_nav_container_dropdown_mobile_border_bottom', 'bottom');
                css += _cFn.renderBorder('responsi_nav_container_dropdown_mobile_border_lr', 'left');
                css += _cFn.renderBorder('responsi_nav_container_dropdown_mobile_border_lr', 'right');
                css += _cFn.renderRadius('responsi_nav_container_dropdown_mobile_border_radius');
                css += _cFn.renderShadow('responsi_nav_container_dropdown_mobile_box_shadow');
            css += '}';

            css += 'ul.responsi-menu a{';
                css += _cFn.renderMarPad('responsi_nav_item_dropdown_mobile_padding', 'padding');
                css += _cFn.renderTypo('responsi_nav_item_dropdown_mobile_font');
                css += 'text-transform:'+ wp.customize.value('responsi_nav_item_dropdown_mobile_font_transform')() +';';
                css += _cFn.renderBG('responsi_nav_item_dropdown_mobile_background');
                css += _cFn.renderBorder('responsi_nav_item_dropdown_mobile_separator', 'top');
            css += '}';

            css += 'ul.responsi-menu li a:hover, ul.responsi-menu li:hover > a{'; 
                css += _cFn.renderBG('responsi_nav_item_dropdown_mobile_hover_background');
                css += 'color:'+ wp.customize.value('responsi_nav_item_dropdown_mobile_hover_color')() +' !important;';    
            css += '}';

            css += 'ul.responsi-menu .menu-item-has-children svg{';
                css += 'width: ' + wp.customize.value('responsi_nav_item_dropdown_mobile_font[size]')() + 'px;';
                css += 'height: ' + wp.customize.value('responsi_nav_item_dropdown_mobile_font[size]')() + 'px;';
                css += 'fill: ' + wp.customize.value('responsi_nav_item_dropdown_mobile_font[color]')() + ';';
            css += '}';

            css += 'ul.responsi-menu .menu-item-has-children > svg{';
                css += 'height: ' + wp.customize.value('responsi_nav_item_dropdown_mobile_font[size]')() + 'px;';
            css += '}';

            css += 'ul.responsi-menu ul li a { padding-left: ' + (parseInt(wp.customize.value('responsi_nav_item_dropdown_mobile_padding_left')()) + 20) + 'px !important; }';
            css += 'ul.responsi-menu ul li ul li a { padding-left: ' + (parseInt(wp.customize.value('responsi_nav_item_dropdown_mobile_padding_left')()) + 40) + 'px !important; }';
            css += 'ul.responsi-menu ul li ul li ul li a { padding-left: ' + (parseInt(wp.customize.value('responsi_nav_item_dropdown_mobile_padding_left')()) + 60) + 'px !important; }';
            css += 'ul.responsi-menu ul li ul li ul li ul li a { padding-left: ' + (parseInt(wp.customize.value('responsi_nav_item_dropdown_mobile_padding_left')()) + 80) + 'px !important; }';
            
            css += 'ul.responsi-menu .sub-menu a{';
                css += _cFn.renderTypo('responsi_nav_item_dropdown_mobile_submenu_font');
                css += _cFn.renderBorder('responsi_nav_item_dropdown_mobile_submenu_separator', 'top');
                css += _cFn.renderBG('responsi_nav_item_dropdown_mobile_submenu_background');
                css += 'text-transform:' + wp.customize.value('responsi_nav_item_dropdown_mobile_submenu_font_transform')() + ';';
            css += '}';

            css += 'ul.responsi-menu .sub-menu li a:hover, ul.responsi-menu .sub-menu li:hover > a{';
                css += _cFn.renderBG('responsi_nav_item_dropdown_mobile_submenu_hover_background');
                css += 'color:' + wp.customize.value('responsi_nav_item_dropdown_mobile_submenu_hover_color')() + ' !important;';
            css += '}';

            css += 'ul.responsi-menu ul.sub-menu .menu-item-has-children > i,ul.responsi-menu ul.sub-menu .menu-item-has-children > svg{';
                css += 'font-size: ' + wp.customize.value('responsi_nav_item_dropdown_mobile_submenu_font[size]')() + 'px;';
                css += 'color: ' + wp.customize.value('responsi_nav_item_dropdown_mobile_submenu_font[color]')() + ';';
                css += 'font-weight: ' + wp.customize.value('responsi_nav_item_dropdown_mobile_submenu_font[style]')() + ';';
            css += '}';

            css += '.responsi-navigation, .hext-moblie-menu-icon{';
            css += _cFn.renderMarPad('responsi_container_nav_mobile_padding', 'padding');
            css += _cFn.renderMarPad('responsi_container_nav_mobile_margin', 'margin');
            css += '}';

            css += '.navigation-in{';
            css += _cFn.renderMarPad('responsi_content_nav_mobile_padding', 'padding');
            css += _cFn.renderMarPad('responsi_content_nav_mobile_margin', 'margin');
            css += '}';

        css += '}';


        if ($('#custom_navi_primary').length > 0) {
            $('#custom_navi_primary').html(css);
        } else {
            $('head').append('<style id="custom_navi_primary">' + css + '</style>');
        }
        $(window).trigger('build-icon-arrow resize');
    }


    var fonts_fields = [
        'responsi_nav_font',
        'responsi_nav_dropdown_font',
        'responsi_nav_item_dropdown_mobile_font',
        'responsi_nav_item_dropdown_mobile_submenu_font',
        'responsi_nav_container_mobile_text_font'
    ];

    var single_fields = [
        'responsi_enable_container_nav_bg_image',
        'responsi_container_bg_image',
        'responsi_container_bg_image_repeat',
        'responsi_container_bg_position_vertical',
        'responsi_container_bg_position_horizontal',
        'responsi_container_bg_image_size_on',
        'responsi_nav_position',
        'responsi_nav_hover',
        'responsi_nav_currentitem',
        'responsi_nav_font_transform',
        'responsi_nav_dropdown_font_transform',
        'responsi_nav_dropdown_hover_color',
        'responsi_nav_item_dropdown_mobile_font_transform',
        'responsi_nav_item_dropdown_mobile_hover_color',
        'responsi_nav_item_dropdown_mobile_submenu_font_transform',
        'responsi_nav_item_dropdown_mobile_submenu_hover_color',
        'responsi_nav_icon_mobile_alignment',
        'responsi_nav_icon_mobile_size',
        'responsi_nav_icon_mobile_color',
        'responsi_nav_container_mobile_text_on',
        'responsi_nav_container_mobile_text',
        'responsi_nav_container_mobile_text_font_transform',
        'responsi_content_nav_background_image',
        'responsi_content_nav_background_image_url',
        'responsi_content_nav_background_image_repeat',
        'responsi_content_nav_background_image_position_horizontal',
        'responsi_content_nav_background_image_position_vertical',
        'responsi_content_nav_background_image_size_on',
        'responsi_nav_currentitem_border',
        'responsi_nav_border_hover'
    ];

    var bg_fields = [
        'responsi_container_nav_bg',
        'responsi_nav_bg',
        'responsi_nav_hover_bg',
        'responsi_nav_currentitem_bg',
        'responsi_navi_background',
        'responsi_nav_dropdown_background',
        'responsi_nav_dropdown_item_background',
        'responsi_nav_dropdown_hover_background',
        'responsi_nav_container_dropdown_mobile_background_color',
        'responsi_nav_item_dropdown_mobile_background',
        'responsi_nav_item_dropdown_mobile_hover_background',
        'responsi_nav_item_dropdown_mobile_submenu_background',
        'responsi_nav_item_dropdown_mobile_submenu_hover_background',
        'responsi_navbar_container_mobile_background_color',
        'responsi_nav_icon_mobile_background_color',
        'responsi_content_nav_background_color'
    ];

    var bg_sizes = [
        'responsi_container_bg_image_size',
        'responsi_content_nav_background_image_size',
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
        'responsi_nav_dropdown_separator',
        'responsi_nav_container_dropdown_mobile_border_top',
        'responsi_nav_container_dropdown_mobile_border_bottom',
        'responsi_nav_container_dropdown_mobile_border_lr',
        'responsi_nav_item_dropdown_mobile_separator',
        'responsi_nav_item_dropdown_mobile_submenu_separator',
        'responsi_navbar_container_mobile_border_top',
        'responsi_navbar_container_mobile_border_bottom',
        'responsi_navbar_container_mobile_border_lr',
        'responsi_nav_icon_mobile_border_top',
        'responsi_nav_icon_mobile_border_bottom',
        'responsi_nav_icon_mobile_border_left',
        'responsi_nav_icon_mobile_border_right',
        'responsi_content_nav_border_top',
        'responsi_content_nav_border_bottom',
        'responsi_content_nav_border_lr',
    ];

    var border_radius_fields = [
        'responsi_container_nav_border_radius',
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
        'responsi_nav_container_dropdown_mobile_border_radius',
        'responsi_navbar_container_mobile_border_radius',
        'responsi_nav_icon_mobile_border_radius',
        'responsi_content_nav_border_radius',
        'responsi_navi_border_radius_first_tl',
        'responsi_navi_border_radius_first_tr',
        'responsi_navi_border_radius_first_bl',
        'responsi_navi_border_radius_first_br',
        'responsi_navi_border_radius_last_tl',
        'responsi_navi_border_radius_last_tr',
        'responsi_navi_border_radius_last_bl',
        'responsi_navi_border_radius_last_br',

    ];

    var shadow_fields = [
        'responsi_nav_box_shadow',
        'responsi_nav_shadow',
        'responsi_nav_dropdown_shadow',
        'responsi_nav_container_dropdown_mobile_box_shadow',
        'responsi_navbar_container_mobile_box_shadow',
        'responsi_nav_icon_mobile_box_shadow',
        'responsi_content_nav_box_shadow'
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
        'responsi_nav_dropdown_item_padding',
        'responsi_nav_container_dropdown_mobile_margin',
        'responsi_nav_container_dropdown_mobile_padding',
        'responsi_nav_item_dropdown_mobile_padding',
        'responsi_navbar_container_mobile_padding',
        'responsi_navbar_container_mobile_margin',
        'responsi_nav_icon_mobile_padding',
        'responsi_nav_icon_mobile_margin',
        'responsi_nav_container_mobile_text_padding',
        'responsi_nav_container_mobile_text_margin',
        'responsi_container_nav_mobile_padding',
        'responsi_container_nav_mobile_margin',
        'responsi_content_nav_padding',
        'responsi_content_nav_margin',
        'responsi_content_nav_mobile_padding',
        'responsi_content_nav_mobile_margin',
        'responsi_navi_li_margin'
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

    $.each(bg_sizes, function(inx, val) {
        $.each(window.ctrlSize, function(i, v) {
            wp.customize(val + v, function(value) {
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
