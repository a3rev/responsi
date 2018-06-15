/*
 * Script run inside a Customizer preview frame.
 */

var is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
var is_safari = navigator.userAgent.indexOf("Safari") > -1;
if ( (is_chrome) && (is_safari) ) {
    is_safari = false;
}
var typefonts = ['size', 'line_height', 'face', 'style', 'color'];
var typeshadow = ['onoff', 'h_shadow', 'v_shadow', 'blur', 'spread', 'inset', 'color'];
var typeradius = ['corner', 'rounded_value'];
var typeborder = ['width', 'style', 'color'];
var typeborderboxes = ['width', 'style', 'color','corner','topleft','topright','bottomright','bottomleft'];
var typemp = ['_top', '_bottom', '_left', '_right'];
var typesize = ['_width', '_height'];
var typepos = ['_vertical', '_horizontal'];
var typebg = ['onoff', 'color'];

(function($) {

    $.fn.setFixedStyle = function() {
        responsiCustomize.override_important_css($(this));
    };
    responsiCustomize = {
        override_important_css: function(apply_to) {
            if ($(apply_to).attr('style')) {
                //setTimeout(function(){
                var current_style = $(apply_to).attr('style').toString();
                if (current_style) {
                    current_style = current_style + ';';
                    current_style = current_style.replace("/;;/gi", ";");
                    current_style = current_style.split(';');
                    var new_attr = '';
                    for (var i = 0; i < current_style.length; i++) {
                        if (current_style[i] != '') {
                            var attr = current_style[i].replace("/!important/g", "");
                            attr = attr.replace("/important/gi", "").toString();
                            attr = attr.replace("/!/gi", "");
                            attr = attr.replace("/;/gi", "");
                            attr = attr.replace("!important", "");
                            attr = attr.replace("!", "");
                            attr = attr.replace("important", "");
                            attr = attr.replace("!important", "");
                            attr = attr.replace(";", "");
                            new_attr += attr + ' !important;';
                        }
                    }
                    $(apply_to).attr('style', new_attr);
                }
                //}, 50);
            }
        },

        get_google_fonts: function(font) {

            if (typeof font === 'object') {
                font = font.face;
            }

            font = font.replace(/"/g, '');
            var font_defaults = [
                '', 'Arial, sans-serif',
                'Verdana, Geneva, sans-serif',
                'Trebuchet MS, Tahoma, sans-serif',
                'Georgia, serif',
                'Times New Roman, serif',
                'Tahoma, Geneva, Verdana, sans-serif',
                'Palatino, Palatino Linotype, serif',
                'Helvetica Neue, Helvetica, sans-serif',
                'Helvetica neue, Arial, sans-serif',
                'Calibri, Candara, Segoe, Optima, sans-serif',
                'Myriad Pro, Myriad, sans-serif',
                'Lucida Grande, Lucida Sans Unicode,Lucida Sans, sans-serif',
                'Arial Black, sans-serif',
                'Gill Sans, Gill Sans MT, Calibri, sans-serif',
                'Geneva, Tahoma, Verdana, sans-serif',
                'Impact, Charcoal, sans-serif',
                'Courier, Courier New, monospace',
                'Century Gothic, sans-serif'
            ];
            if ($.inArray(font, font_defaults) !== -1) return;
            var list_fonts = font.replace(" ", "+");
            var google_fonts_list = $('#google_fonts_customize').attr('href');
            if (google_fonts_list) {
                google_fonts_list = google_fonts_list.replace('http://fonts.googleapis.com/css?family=', '');
                google_fonts_list = google_fonts_list.replace('https://fonts.googleapis.com/css?family=', '');
                google_fonts_list = google_fonts_list.replace(" ", "+");
                google_fonts_list = google_fonts_list = google_fonts_list.split('|');
                if (google_fonts_list.length > 0) {
                    google_fonts_list = $.unique(google_fonts_list);
                    var note = '|';
                    for (var i = 0; i < google_fonts_list.length; i++) {
                        if (google_fonts_list[i] != '' && google_fonts_list[i] != font.replace(" ", "+")) {
                            list_fonts += note + google_fonts_list[i];
                        }
                    }
                }
            }
            if (list_fonts != '') {
                $('#google_fonts_customize').remove();
                list_fonts = list_fonts.replace(" ", "+");
                list_fonts = list_fonts.replace('http://fonts.googleapis.com/css?family=', '');
                list_fonts = list_fonts.replace('https://fonts.googleapis.com/css?family=', '');
                $('head').append('<link id="google_fonts_customize" type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=' + list_fonts + '">');
            }
        },

        build_typography: function(id, imp) {
            imp = imp || false;
            var size = wp.customize.value(id + '[size]')();
            var line_height = wp.customize.value(id + '[line_height]')();
            var face = wp.customize.value(id + '[face]')();
            var style = wp.customize.value(id + '[style]')();
            var color = wp.customize.value(id + '[color]')();

            if ( typeof size === 'object' ){
                size = size.size;
            }
            if ( typeof line_height === 'object' ){
                line_height = line_height.line_height;
            }
            if ( typeof face === 'object' ){
                face = face.face;
            }
            if ( typeof style === 'object' ){
                style = style.style;
            }
            if ( typeof color === 'object' ){
                color = color.color;
            }

            responsiCustomize.get_google_fonts(face);
            var fonts = '';
            if (imp) {
                fonts = 'font:' + style + ' ' + size + 'px/' + line_height + 'em ' + face + ' !important;color:' + color + ' !important;';
            } else {
                fonts = 'font:' + style + ' ' + size + 'px/' + line_height + 'em ' + face + ';color:' + color + ';';
            }

            return fonts;
        },

        build_box_shadow: function(id, imp) {
            imp = imp || false;
            var onoff = wp.customize.value(id + '[onoff]')();
            var h_shadow = wp.customize.value(id + '[h_shadow]')();
            var v_shadow = wp.customize.value(id + '[v_shadow]')();
            var blur = wp.customize.value(id + '[blur]')();
            var spread = wp.customize.value(id + '[spread]')();
            var color = wp.customize.value(id + '[color]')();
            var inset = wp.customize.value(id + '[inset]')();

            if ( typeof onoff === 'object' ){
                onoff = onoff.onoff;
            }
            if ( typeof h_shadow === 'object' ){
                h_shadow = h_shadow.h_shadow;
            }
            if ( typeof v_shadow === 'object' ){
                v_shadow = v_shadow.v_shadow;
            }
            if ( typeof blur === 'object' ){
                blur = blur.blur;
            }
            if ( typeof spread === 'object' ){
                spread = spread.spread;
            }
            if ( typeof color === 'object' ){
                color = color.color;
            }
            if ( typeof onoff === 'object' ){
                inset = inset.inset;
            }

            _inset = '';
            if (inset == 'inset') {
                _inset = ' inset';
            } else {
                _inset = '';
            }
            var shadows = 'box-shadow: none !important;';
            if (onoff == 'true') {
                if (imp) {
                    shadows = 'box-shadow:' + h_shadow + ' ' + v_shadow + ' ' + blur + ' ' + spread + ' ' + color + _inset + ' !important;';
                } else {
                    shadows = 'box-shadow:' + h_shadow + ' ' + v_shadow + ' ' + blur + ' ' + spread + ' ' + color + _inset + ';';
                }
            }

            return shadows;
        },

        build_background: function(id, imp) {
            imp = imp || false;
            var onoff = wp.customize.value(id + '[onoff]')();
            var color = wp.customize.value(id + '[color]')();

            if ( typeof onoff === 'object' ){
                onoff = onoff.onoff;
            }
            if ( typeof color === 'object' ){
                color = color.color;
            }

            var background_color = 'background-color: transparent !important;';
            if (onoff == 'true') {
                if (imp) {
                    background_color = 'background-color: ' + color + ' !important;';
                } else {
                    background_color = 'background-color: ' + color + ';';
                }
            }
            return background_color;
        },

        build_border_radius: function(id, corner, imp) {
            corner = corner || '';
            imp = imp || false;
            var corner_to = '';
            if (corner != '') {
                corner_to = '-' + corner;
            }
            var onoff = wp.customize.value(id + '[corner]')();
            var rounded_value = wp.customize.value(id + '[rounded_value]')();

            if ( typeof onoff === 'object' ){
                onoff = onoff.onoff;
            }
            if ( typeof rounded_value === 'object' ){
                rounded_value = rounded_value.rounded_value;
            }

            var radius = 'border' + corner_to + '-radius:0px !important;';
            if (onoff == 'rounded') {
                if (imp) {
                    radius = 'border' + corner_to + '-radius:' + rounded_value + 'px !important;';
                } else {
                    radius = 'border' + corner_to + '-radius:' + rounded_value + 'px;';
                }
            }
            return radius;
        },

        build_border: function(id, type, imp) {
            type = type || '';
            imp = imp || false;
            var border_type = '';
            if (type != '') {
                border_type += '-' + type;
            }
            var width = wp.customize.value(id + '[width]')();
            var style = wp.customize.value(id + '[style]')();
            var color = wp.customize.value(id + '[color]')();
            if ( typeof width === 'object' ){
                width = width.width;
            }
            if ( typeof width === 'object' ){
                width = width.width;
            }
            if ( typeof style === 'object' ){
                style = style.style;
            }
            if ( typeof color === 'object' ){
                color = color.color;
            }
            var borders = 'border' + border_type + ':0px solid #000000 !important;';
            if (imp) {
                borders = 'border' + border_type + ':' + width + 'px ' + style + ' ' + color + ' !important;';
            } else {
                borders = 'border' + border_type + ':' + width + 'px ' + style + ' ' + color + ';';
            }

            return borders;
        },

        build_border_boxes: function(id, imp) {

            var border_boxes = '', border_style = '', border_corner = '', ipt = '';

            imp = imp || false;

            if ( imp ) {
                ipt = ' !important';
            } 

            var width = wp.customize.value(id + '[width]')();
            var style = wp.customize.value(id + '[style]')();
            var color = wp.customize.value(id + '[color]')();
            
            if ( typeof width === 'object' ){
                width = width.width;
            }
            if ( typeof width === 'object' ){
                width = width.width;
            }
            if ( typeof style === 'object' ){
                style = style.style;
            }
            if ( typeof color === 'object' ){
                color = color.color;
            }

            border_style = 'border:' + width + 'px ' + style + ' ' + color + ipt + ';';

            var onoff = wp.customize.value(id + '[corner]')();
            var topleft = wp.customize.value(id + '[topleft]')();
            var topright = wp.customize.value(id + '[topright]')();
            var bottomright = wp.customize.value(id + '[bottomright]')();
            var bottomleft = wp.customize.value(id + '[bottomleft]')();

            if ( typeof onoff === 'object' ){
                onoff = onoff.onoff;
            }
            if ( typeof topleft === 'object' ){
                topleft = topleft.topleft;
            }

            if ( typeof topright === 'object' ){
                topright = topright.topright;
            }

            if ( typeof bottomright === 'object' ){
                bottomright = bottomright.bottomright;
            }

            if ( typeof bottomleft === 'object' ){
                bottomleft = bottomleft.bottomleft;
            }

            if ( onoff == 'rounded' ) {
                border_corner += 'border-top-left-radius:' + topleft + 'px'+ ipt +';';
                border_corner += 'border-top-right-radius:' + topright + 'px'+ ipt +';';
                border_corner += 'border-bottom-right-radius:' + bottomright + 'px'+ ipt +';';
                border_corner += 'border-bottom-left-radius:' + bottomleft + 'px'+ ipt +';';
            }else{
                border_corner += 'border-top-left-radius:0px'+ ipt +';';
                border_corner += 'border-top-right-radius:0px'+ ipt +';';
                border_corner += 'border-bottom-right-radius:0px'+ ipt +';';
                border_corner += 'border-bottom-left-radius:0px'+ ipt +';';
            }
            
            border_boxes = border_style + border_corner;

            return border_boxes;
           
        },

        build_padding_margin: function(id, type, imp) {
            imp = imp || false;
            var important = '';
            if (imp) {
                important = ' !important';
            }
            var mps = '';
            if (wp.customize.has(id + '_top')) {
                var top = wp.customize.value(id + '_top')();
                mps += type + '-top:' + top + 'px' + important + ';';
            }
            if (wp.customize.has(id + '_bottom')) {
                var bottom = wp.customize.value(id + '_bottom')();
                mps += type + '-bottom:' + bottom + 'px' + important + ';';
            }
            if (wp.customize.has(id + '_left')) {
                var left = wp.customize.value(id + '_left')();
                mps += type + '-left:' + left + 'px' + important + ';';
            }
            if (wp.customize.has(id + '_right')) {
                var right = wp.customize.value(id + '_right')();
                mps += type + '-right:' + right + 'px' + important + ';';
            }

            return mps;
        }
    };
})(jQuery);
