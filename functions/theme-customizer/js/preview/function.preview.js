/*
 * Script run inside a Customizer preview frame.
 */

window.is_chrome = navigator.userAgent.indexOf("Chrome") > -1;
window.is_safari = navigator.userAgent.indexOf("Safari") > -1;
if ( (window.is_chrome) && (window.is_safari) ) {
    is_safari = false;
}

window.ctrlFonts = ['size', 'line_height', 'face', 'style', 'color'];
window.ctrlShadow = ['onoff', 'h_shadow', 'v_shadow', 'blur', 'spread', 'inset', 'color'];
window.ctrlRadius = ['corner', 'rounded_value'];
window.ctrlBorder = ['width', 'style', 'color'];
window.ctrlBorderBoxes = ['width', 'style', 'color','corner','topleft','topright','bottomright','bottomleft'];
window.ctrlMarPad = ['_top', '_bottom', '_left', '_right'];
window.ctrlSize = ['_width', '_height'];
window.ctrlPos = ['_vertical', '_horizontal'];
window.ctrlBG = ['onoff', 'color'];
window.fontsDefaults.push (
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
);

(function( wp, $ ) {

    window.responsiCustomize = {
        overrideCss: function(apply_to) {
            if ($(apply_to).attr('style')) {
                //setTimeout(function(){
                var curStyle = $(apply_to).attr('style').toString();
                if (curStyle) {
                    curStyle = curStyle + ';';
                    curStyle = curStyle.replace("/;;/gi", ";");
                    curStyle = curStyle.split(';');
                    var new_attr = '';
                    for (var i = 0; i < curStyle.length; i++) {
                        if (curStyle[i] != '') {
                            var attr = curStyle[i].replace("/!important/g", "");
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

        getGFonts: function(font) {

            if (typeof font === 'object') {
                font = font.face;
            }

            font = font.replace(/"/g, '');

            if ($.inArray(font, window.fontsDefaults) !== -1) return;

            //if ($.inArray(font, window.gFontsList) !== -1) return;

            window.fontsDefaults.push(font);

            var listFonts = font.replace(" ", "+"),
            gFonts = $('#gFonts-css').attr('href'),
            note = '|';
            
            if (gFonts) {
                gFonts = gFonts.replace('http://fonts.googleapis.com/css?family=', '');
                gFonts = gFonts.replace('https://fonts.googleapis.com/css?family=', '');
                gFonts = gFonts.replace(" ", "+");
                gFonts = gFonts.split('|');
                if (gFonts.length > 0) {
                    gFonts = $.unique(gFonts);

                    for (var i = 0; i < gFonts.length; i++) {
                        if (gFonts[i] != '' && gFonts[i] != font.replace(" ", "+")) {
                            listFonts += note + gFonts[i];
                        }
                    }
                }
            }

            if (listFonts != '') {
                $('#gFonts-css').remove();
                listFonts = listFonts.replace(" ", "+");
                listFonts = listFonts.replace('http://fonts.googleapis.com/css?family=', '');
                listFonts = listFonts.replace('https://fonts.googleapis.com/css?family=', '');
                $('head').append('<link id="gFonts-css" type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=' + listFonts + '">');
            }

        },

        renderTypo: function(id, imp) {
            imp = imp || false;
            var size = wp.customize.value(id + '[size]')(),
            lineHeight = wp.customize.value(id + '[line_height]')(),
            face = wp.customize.value(id + '[face]')(),
            style = wp.customize.value(id + '[style]')(),
            color = wp.customize.value(id + '[color]')(),
            fonts = '';

            if ( typeof size === 'object' ){
                size = size.size;
            }
            if ( typeof lineHeight === 'object' ){
                lineHeight = lineHeight.line_height;
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

            responsiCustomize.getGFonts(face);

            face = face.replace(/Exo 2/g, '"Exo 2"');
            face = face.replace(/Slabo 13px/g, '"Slabo 13px"');
            face = face.replace(/Slabo 27px/g, '"Slabo 27px"');
           
            if (imp) {
                fonts = 'font:' + style + ' ' + size + 'px/' + lineHeight + 'em ' + face + ' !important;color:' + color + ' !important;';
            } else {
                fonts = 'font:' + style + ' ' + size + 'px/' + lineHeight + 'em ' + face + ';color:' + color + ';';
            }

            return fonts;
        },

        renderShadow: function(id, imp) {
            imp = imp || false;
            var onoff = wp.customize.value(id + '[onoff]')(),
            h_shadow = wp.customize.value(id + '[h_shadow]')(),
            v_shadow = wp.customize.value(id + '[v_shadow]')(),
            blur = wp.customize.value(id + '[blur]')(),
            spread = wp.customize.value(id + '[spread]')(),
            color = wp.customize.value(id + '[color]')(),
            inset = wp.customize.value(id + '[inset]')(),
            shadows = 'box-shadow: none !important;';

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

            if (onoff == 'true') {
                if (imp) {
                    shadows = 'box-shadow:' + h_shadow + ' ' + v_shadow + ' ' + blur + ' ' + spread + ' ' + color + _inset + ' !important;';
                } else {
                    shadows = 'box-shadow:' + h_shadow + ' ' + v_shadow + ' ' + blur + ' ' + spread + ' ' + color + _inset + ';';
                }
            }

            return shadows;
        },

        renderBG: function(id, imp) {
            imp = imp || false;
            var onoff = wp.customize.value(id + '[onoff]')(),
            color = wp.customize.value(id + '[color]')(),
            bgColor = 'background-color: transparent !important;';

            if ( typeof onoff === 'object' ){
                onoff = onoff.onoff;
            }
            if ( typeof color === 'object' ){
                color = color.color;
            }
            
            if (onoff == 'true') {
                if (imp) {
                    bgColor = 'background-color: ' + color + ' !important;';
                } else {
                    bgColor = 'background-color: ' + color + ';';
                }
            }
            return bgColor;
        },

        renderRadius: function(id, corner, imp) {
            corner = corner || '';
            imp = imp || false;
            var cornerTo = '',
            onoff = wp.customize.value(id + '[corner]')(),
            roundedValue = wp.customize.value(id + '[rounded_value]')(),
            radius = 'border' + cornerTo + '-radius:0px !important;';
            if (corner != '') {
                cornerTo = '-' + corner;
            }

            if ( typeof onoff === 'object' ){
                onoff = onoff.onoff;
            }
            if ( typeof roundedValue === 'object' ){
                roundedValue = roundedValue.rounded_value;
            }

            if (onoff == 'rounded') {
                if (imp) {
                    radius = 'border' + cornerTo + '-radius:' + roundedValue + 'px !important;';
                } else {
                    radius = 'border' + cornerTo + '-radius:' + roundedValue + 'px;';
                }
            }
            return radius;
        },

        renderBorder: function(id, type, imp) {
            type = type || '';
            imp = imp || false;
            var borderType = '';
            if (type != '') {
                borderType += '-' + type;
            }
            var width = wp.customize.value(id + '[width]')(),
            style = wp.customize.value(id + '[style]')(),
            color = wp.customize.value(id + '[color]')(),
            borders = 'border' + borderType + ':0px solid #000000 !important;';
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
            if (imp) {
                borders = 'border' + borderType + ':' + width + 'px ' + style + ' ' + color + ' !important;';
            } else {
                borders = 'border' + borderType + ':' + width + 'px ' + style + ' ' + color + ';';
            }

            return borders;
        },

        renderBorderBoxs: function(id, imp) {

            var borderBoxes = '',
            borderStyle = '',
            borderCorner = '',
            ipt = '',
            width = wp.customize.value(id + '[width]')(),
            style = wp.customize.value(id + '[style]')(),
            color = wp.customize.value(id + '[color]')(),
            onoff = wp.customize.value(id + '[corner]')(),
            topleft = wp.customize.value(id + '[topleft]')(),
            topright = wp.customize.value(id + '[topright]')(),
            bottomright = wp.customize.value(id + '[bottomright]')(),
            bottomleft = wp.customize.value(id + '[bottomleft]')();

            imp = imp || false;

            if ( imp ) {
                ipt = ' !important';
            } 

            borderStyle = 'border:' + width + 'px ' + style + ' ' + color + ipt + ';';
            
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
                borderCorner += 'border-top-left-radius:' + topleft + 'px'+ ipt +';';
                borderCorner += 'border-top-right-radius:' + topright + 'px'+ ipt +';';
                borderCorner += 'border-bottom-right-radius:' + bottomright + 'px'+ ipt +';';
                borderCorner += 'border-bottom-left-radius:' + bottomleft + 'px'+ ipt +';';
            }else{
                borderCorner += 'border-top-left-radius:0px'+ ipt +';';
                borderCorner += 'border-top-right-radius:0px'+ ipt +';';
                borderCorner += 'border-bottom-right-radius:0px'+ ipt +';';
                borderCorner += 'border-bottom-left-radius:0px'+ ipt +';';
            }
            
            borderBoxes = borderStyle + borderCorner;

            return borderBoxes;
           
        },

        renderMarPad: function(id, type, imp) {
            imp = imp || false;
            var important = '',
            mps = '';

            if (imp) {
                important = ' !important';
            }

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
        },

        renderAnimation: function( container, option_name ){
        
            var _container = $('body').find(container),
            _type = wp.customize.value(option_name+'[type]')(),
            _duration = wp.customize.value(option_name+'[duration]')(),
            _delay = wp.customize.value(option_name+'[delay]')(),
            _direction = wp.customize.value(option_name+'[direction]')(),
            _oldType = _container.data('animation'),
            _hasDirection = [ 'bounce', 'fade', 'slide', 'zoom' ],
            _animType = ( _hasDirection.indexOf( _type ) > -1 ) ? _type+'In'+_direction.charAt( 0 ).toUpperCase() + _direction.substring( 1 ): _type;
            if( 'slide' === _type && _direction === '' ){
                _animType = _type+'InLeft';
            }
            _container.attr( 'style', 'animation-delay:'+_delay+'s;animation-duration:'+_duration+'s');
            _container.removeClass(_oldType).data('animation', _animType ).addClass( _animType );

            setTimeout(function(){
                scrollWaypointInit(_container);
            },10);

        },

        renderAnimationCards: function( container, option_name ){
        
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

            _container.attr('class','animateMe').attr('data',animation_type);

            setTimeout(function(){
                _container.attr( 'style', 'animation-delay:'+delay+'s;animation-duration:'+duration+'s');
                _container.removeClass(old_type).addClass( animation_type ).data('animation', animation_type );
            },10);
            

            setTimeout(function(){
                scrollWaypointInit(_container);
            },50);

        }

    };

    if (wp.customize.selectiveRefresh){
        wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
            $(window).trigger('load');
            $(document).trigger('responsi-partial-content-rendered');
            scrollWaypointInit(jQuery(".animateMe"));
        } );
    }

    window._cFn = responsiCustomize;

    $.fn.setFixedStyle = function() {
        _cFn.overrideCss($(this));
    };

})(window.wp, jQuery);
