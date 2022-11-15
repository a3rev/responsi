var isMobile = {
    Android: function() {
        var check;
        if (navigator.userAgent.match(/Android/i)) check = true;
        return check;
    },
    BlackBerry: function() {
        var check;
        if (navigator.userAgent.match(/BlackBerry/i)) check = true;
        return check;
    },
    iOS: function() {
        var check;
        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) check = true;
        return check;
    },
    Opera: function() {
        var check;
        if (navigator.userAgent.match(/Opera Mini/i)) check = true;
        return check;
    },
    Windows: function() {
        var check;
        if (navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i)) check = true;
        return check;
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};

window.browser = function () {
    var browser = "Unknown browser";
    if (!!window.chrome && !(!!window.opera)) browser = 'chrome'; // Chrome 1+
    if (typeof InstallTrigger !== 'undefined') browser = 'firefox'; // Firefox 1.0+
    if (!!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0) browser = 'opera'; // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
    if ( /*@cc_on!@*/ false || !!document.documentMode) browser = 'ie'; // At least IE6
    if (Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0) browser = 'safari'; // At least Safari 3+: "[object HTMLElementConstructor]"

    return browser;
}

window.onload = function (){
    document.body.className += ' site-loaded';
    if (window.isIE()) {
        if (window.isIE() <= 9) {
            document.body.className += ' ie ie9';
        } else {
            document.body.className += ' ie';
        }
    } 
}

window.isIE = function (){
    var myNav = navigator.userAgent.toLowerCase();
    return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
}

window.getBaseURL = function (){
    var url = location.href; // entire url including querystring - also: window.location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));


    if (baseURL.indexOf('http://localhost') != -1) {
        // Base Url for localhost
        url = location.href; // window.location.href;
        var pathname = location.pathname; // window.location.pathname;
        var index1 = url.indexOf(pathname);
        var index2 = url.indexOf("/", index1 + 1);
        var baseLocalUrl = url.substr(0, index2);

        return baseLocalUrl + "/";
    } else {
        // Root Url for domain name
        return baseURL + "/";
    }

}

window.isTouchDevice = function (){
    return ('ontouchstart' in document.documentElement);
}

jQuery.exists = function(selector) {
    return (jQuery(selector).length > 0);
};

window.responsiGetStyle = function responsiGetStyle(oElm, strCssRule){
    if( !oElm ){
        return;
    }
    var strValue = "";
    if(document.defaultView && document.defaultView.getComputedStyle){
        strValue = document.defaultView.getComputedStyle(oElm, "").getPropertyValue(strCssRule);
    }
    else if(oElm.currentStyle){
        strCssRule = strCssRule.replace(/\-(\w)/g, function (strMatch, p1){
            return p1.toUpperCase();
        });
        strValue = oElm.currentStyle[strCssRule];
    }
    return strValue;
}

window.hexToRGBA = function( hex, opacity ) {
    return 'rgba(' + (hex = hex.replace('#', '')).match(new RegExp('(.{' + hex.length/3 + '})', 'g')).map(function(l) { return parseInt(hex.length%2 ? l+l : l, 16) }).concat(opacity).join(',') + ')';
}

// addEventListener passive
!function(e){"function"==typeof define&&define.amd?define(e):e()}(function(){var e,t=["scroll","wheel","touchstart","touchmove","touchenter","touchend","touchleave","mouseout","mouseleave","mouseup","mousedown","mousemove","mouseenter","mousewheel","mouseover"];if(function(){var e=!1;try{var t=Object.defineProperty({},"passive",{get:function(){e=!0}});window.addEventListener("test",null,t),window.removeEventListener("test",null,t)}catch(e){}return e}()){var n=EventTarget.prototype.addEventListener;e=n,EventTarget.prototype.addEventListener=function(n,o,r){var i,s="object"==typeof r&&null!==r,u=s?r.capture:r;(r=s?function(e){var t=Object.getOwnPropertyDescriptor(e,"passive");return t&&!0!==t.writable&&void 0===t.set?Object.assign({},e):e}(r):{}).passive=void 0!==(i=r.passive)?i:-1!==t.indexOf(n)&&!0,r.capture=void 0!==u&&u,e.call(this,n,o,r)},EventTarget.prototype.addEventListener._original=e}});

/*-----------------------------------------------------------------------------------*/
/* FITVIDS.JS - Responsive video embeds */
/*-----------------------------------------------------------------------------------*/
/*global jQuery */
/*!
 * FitVids 1.0
 *
 * Copyright 2011, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
 * Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
 * Released under the WTFPL license - http://sam.zoy.org/wtfpl/
 *
 * Date: Thu Sept 01 18:00:00 2011 -0500
 */
;
(function($) {

    'use strict';

    $.fn.fitVids = function(options) {
        var settings = {
            customSelector: null,
            ignore: null
        };

        if (!document.getElementById('fit-vids-style')) {
            // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
            var head = document.head || document.getElementsByTagName('head')[0];
            var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
            var div = document.createElement("div");
            div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
            head.appendChild(div.childNodes[1]);
        }

        if (options) {
            $.extend(settings, options);
        }

        return this.each(function() {
            var selectors = [
                'iframe[src*="player.vimeo.com"]',
                'iframe[src*="youtube.com"]',
                'iframe[src*="youtube-nocookie.com"]',
                'iframe[src*="kickstarter.com"][src*="video.html"]',
                'object',
                'embed'
            ];

            if (settings.customSelector) {
                selectors.push(settings.customSelector);
            }

            var ignoreList = '.fitvidsignore';

            if (settings.ignore) {
                ignoreList = ignoreList + ', ' + settings.ignore;
            }

            var $allVideos = $(this).find(selectors.join(','));
            $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
            $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

            $allVideos.each(function(count) {
                var $this = $(this);
                if ($this.parents(ignoreList).length > 0) {
                    return; // Disable FitVids on this video.
                }
                if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) {
                    return;
                }
                if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width')))) {
                    $this.attr('height', 9);
                    $this.attr('width', 16);
                }
                var height = (this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10)))) ? parseInt($this.attr('height'), 10) : $this.height(),
                    width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
                    aspectRatio = height / width;
                if (!$this.attr('id')) {
                    var videoID = 'fitvid' + count;
                    $this.attr('id', videoID);
                }
                $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100) + '%');
                $this.removeAttr('height').removeAttr('width');
            });
        });
    };
    // Works with either jQuery or Zepto
})(window.jQuery || window.Zepto);


if (window.browser() === 'ie') {
    /**
     * Created by IntelliJ IDEA.
     *
     * User: phil
     * Date: 15/11/12
     * Time: 11:04 AM
     *
     */
    (function($) {
        var self = this,
            container, running = false,
            currentY = 0,
            targetY = 0,
            oldY = 0,
            maxScrollTop = 0,
            minScrollTop, direction, onRenderCallback = null,
            fricton = 0.7, // higher value for slower deceleration
            vy = 0,
            stepAmt = 5,
            minMovement = 0.1,
            ts = 0.1;
        var updateScrollTarget = function(amt) {
            targetY += amt;
            vy += (targetY - oldY) * stepAmt;
            oldY = targetY;
        };
        var render = function() {
            if (vy < -(minMovement) || vy > minMovement) {
                currentY = (currentY + vy);
                if (currentY > maxScrollTop) {
                    currentY = vy = 0;
                } else if (currentY < minScrollTop) {
                    vy = 0;
                    currentY = minScrollTop;
                }
                container.scrollTop(-currentY);
                vy *= fricton;
                if (onRenderCallback) {
                    onRenderCallback();
                }
            }
        };
        var animateLoop = function() {
            if (!running) return;
            requestAnimFrame(animateLoop);
            render();
            //log("45","animateLoop","animateLoop", "",stop);
        };
        var onWheel = function(e) {
            e.preventDefault();
            var evt = e.originalEvent;
            var delta = evt.detail ? evt.detail * -1 : evt.wheelDelta / 40;
            var dir = delta < 0 ? -1 : 1;
            if (dir != direction) {
                vy = 0;
                direction = dir;
            }
            //reset currentY in case non-wheel scroll has occurred (scrollbar drag, etc.)
            currentY = -container.scrollTop();
            updateScrollTarget(delta);
        };
        /*
         * http://paulirish.com/2011/requestanimationframe-for-smart-animating/
         */
        window.requestAnimFrame = (function() {
            return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function(callback) {
                window.setTimeout(callback, 1000 / 60);
            };
        })();
        /*
         * http://jsbin.com/iqafek/2/edit
         */
        var normalizeWheelDelta = function() {
            // Keep a distribution of observed values, and scale by the
            // 33rd percentile.
            var distribution = [],
                done = null,
                scale = 30;
            return function(n) {
                // Zeroes don't count.
                if (n == 0) return n;
                // After 500 samples, we stop sampling and keep current factor.
                if (done != null) return n * done;
                var abs = Math.abs(n);
                // Insert value (sorted in ascending order).
                outer: do { // Just used for break goto
                    for (var i = 0; i < distribution.length; ++i) {
                        if (abs <= distribution[i]) {
                            distribution.splice(i, 0, abs);
                            break outer;
                        }
                    }
                    distribution.push(abs);
                } while (false);
                // Factor is scale divided by 33rd percentile.
                var factor = scale / distribution[Math.floor(distribution.length / 3)];
                if (distribution.length == 500) done = factor;
                return n * factor;
            };
        }();
        $.fn.smoothWheel = function() {
            //  var args = [].splice.call(arguments, 0);
            var options = jQuery.extend({}, arguments[0]);
            return this.each(function(index, elm) {
                if (!('ontouchstart' in window)) {
                    container = $(this);
                    container.on("mousewheel", onWheel);
                    container.on("DOMMouseScroll", onWheel);
                    //set target/old/current Y to match current scroll position to prevent jump to top of container
                    targetY = oldY = container.scrollTop();
                    currentY = -targetY;
                    minScrollTop = container.get(0).clientHeight - container.get(0).scrollHeight;
                    if (options.onRender) {
                        onRenderCallback = options.onRender;
                    }
                    if (options.remove) {
                        //log("122", "smoothWheel", "remove", "");
                        running = false;
                        container.off("mousewheel", onWheel);
                        container.off("DOMMouseScroll", onWheel);
                    } else if (!running) {
                        running = true;
                        animateLoop();
                    }
                }
            });
        };
    })(jQuery);

    jQuery(window).smoothWheel();

}

/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

(function($) {
    var $window = $(window);
    var windowHeight = $window.height();

    $window.on( 'resize', function() {
        windowHeight = $window.height();
    });

    $.fn.parallax = function(xpos, speedFactor, outerHeight) {
        var $this = $(this);
        var getHeight;
        var firstTop;
        var paddingTop = 0;

        //get the starting position of each element to have parallax applied to it      
        $this.each(function() {
            firstTop = $this.offset().top;
        });

        if (outerHeight) {
            getHeight = function(jqo) {
                return jqo.outerHeight(true);
            };
        } else {
            getHeight = function(jqo) {
                return jqo.height();
            };
        }

        // setup defaults if arguments aren't specified
        if (arguments.length < 1 || xpos === null) xpos = "50%";
        if (arguments.length < 2 || speedFactor === null) speedFactor = 0.1;
        if (arguments.length < 3 || outerHeight === null) outerHeight = true;

        // function to be called whenever the window is scrolled or resized
        function update() {
            var pos = $window.scrollTop();

            $this.each(function() {
                var $element = $(this);
                var top = $element.offset().top;
                var height = getHeight($element);

                // Check if totally above or totally below viewport
                if (top + height < pos || top > pos + windowHeight) {
                    return;
                }

                $this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
            });
        }

        $window.on('scroll', update).on( 'resize', update);
        update();
    };
})(jQuery);

/*-----------------------------------------------------------------------------------*/
/* Run scripts on $(document).ready() */
/*-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {

    /*-----------------------------------------------------------------------------------*/
    /* Sure console is define */
    /*-----------------------------------------------------------------------------------*/
    if (!(window.console && console.log)) {
        console = {
            log: function() {},
            debug: function() {},
            info: function() {},
            warn: function() {},
            error: function() {}
        };
    }

    var $elMenuItem = $('.responsi-menu .menu-item-has-children > a, #sidenav-content .menu-item-has-children > a');

    $elMenuItem.before('<i class="fa fa-caret-down"></i>');
    $elMenuItem.append('<i class="item-arrow"> </i>');

    $(document).ready(function() {
        $(responsi_paramaters.responsi_button_none_css_lists).addClass('none-button-css');
    });

    $(document).on('responsi-partial-content-rendered responsi-exclude-button-css', function() {
        $(responsi_paramaters.responsi_button_none_css_lists).addClass('none-button-css');
    });

    window.responsiToolbar = document.getElementsByClassName("responsi-toolbar")[0], 
    window.responsiSite = document.getElementsByClassName("responsi-site")[0];

    $(window).on('scroll resize', function() {
        window.responsiTopCtn();
    });

    window.topCtnHeight = 0;
    window.wpAdminbar = 0;
    window.topCtnScroll = 0;
    window.adminBarHeight = 0;
    window.ahwHeight = 0;

    window.responsiTopCtn = function() {

        window.adminBarHeight = ( document.getElementById( 'wpadminbar' ) && document.getElementById( 'wpadminbar' ).innerHTML.length ) ? document.getElementById( 'wpadminbar' ).clientHeight : 0;
        window.ahwHeight = ( document.getElementById( 'responsi-ahw' ) && document.getElementById( 'responsi-ahw' ).innerHTML.length ) ? document.getElementById( 'responsi-ahw' ).clientHeight : 0;

        if( window.responsiGetStyle(document.getElementById( 'wpadminbar' ), 'position') != 'fixed' ){
            window.adminBarHeight = 0;
        }

        if( window.responsiGetStyle(document.querySelector( '.ahw-header' ), 'position') != 'fixed' ){
            window.ahwHeight = 0;
        }

        window.topCtnScroll = ( window.adminBarHeight + window.ahwHeight ) - window.pageYOffset;

        if( ( window.adminBarHeight + window.ahwHeight ) > window.topCtnScroll ){
            document.getElementsByTagName('body')[0].classList.add('toolbar-sticky');
            if( window.responsiGetStyle(document.querySelector( '.ahw-header' ), 'position') != 'fixed' ){
                if( document.getElementsByClassName("toolbar-ctn")[0] != undefined ){
                    document.querySelector(".toolbar-ctn").style.top = window.adminBarHeight + 'px';
                }
            }else{
                if( document.getElementsByClassName("toolbar-ctn")[0] != undefined ){
                    document.querySelector(".toolbar-ctn").style.removeProperty("top");
                }
            }

        }else{
            document.getElementsByTagName('body')[0].classList.remove('toolbar-sticky');
            if( window.responsiGetStyle(document.querySelector( '.ahw-header' ), 'position') != 'fixed' ){
                if( document.getElementsByClassName("toolbar-ctn")[0] != undefined ){
                    document.querySelector(".toolbar-ctn").style.removeProperty("top");
                }
            }
        }

        window.topCtnHeight = 0;

        if( document.getElementsByClassName("toolbar-ctn")[0] != undefined ){
            window.topCtnHeight = document.querySelector(".toolbar-ctn").offsetHeight;
            document.querySelector(".responsi-toolbar").style.height = window.topCtnHeight + 'px';
        }

    }

    /* Parallax for edge slider */
    /* -------------------------------------------------------------------- */

    function parallaxEdge() {
        "use strict";

        if (!isMobile.any()) {
            var $parallaxLayer = [];

            $('.parallax-edge').each(function() {
                var progressVal,
                    currentPoint,
                    ticking = false,
                    scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop,
                    $this = $(this),
                    $window = $(window),
                    windowHeight = $(window).height(),
                    parentHeight = $this.outerHeight(),
                    startPoint = 0,
                    endPoint = $this.offset().top + parentHeight,
                    effectLayer = $this,
                    cntLayer = $this.find('.responsi-grid'),
                    height = $this.outerHeight();

                var $speedFactor = 0.7;
                
                if (typeof $this.attr('data-speedFactor') !== typeof undefined && $this.attr('data-speedFactor') !== false) {
                    $speedFactor = $this.attr('data-speedFactor');
                }

                var animationSet = function() {
                    scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;
                    currentPoint = (startPoint + scrollY) * $speedFactor;
                    progressVal = (1 / (endPoint - startPoint) * (scrollY - startPoint));
                    if (progressVal <= 1) {
                        effectLayer.css({
                            //transform: "translate3d(0, " + currentPoint + "px, 0)"
                            //transform: "translate(0," + currentPoint * $speedFactor + "px)"
                            //'transform': 'translateY(' + currentPoint * $speedFactor + 'px)'
                            transform: "translate(0," + currentPoint * 0.5 + "px)"
                            //transform: "translate3d(0, " + currentPoint * 0.5 + "px, 0)"
                        });
                    }
               
                    ticking = false;
                };
                
                animationSet();
                
                var requestTick = function() {
                    if (!ticking) {
                        window.requestAnimationFrame(animationSet);
                        ticking = true;
                    }
                };

                $window.on('scroll', requestTick);

            });
        }
    }

    function parallax() {
        "use strict";
        if (!window.isTouchDevice() && $(window).width() > 1050) {
            $('.parallax-background').each(function() {
                var $this = $(this),
                    $speedFactor = 0.3;
                if (typeof $this.attr('data-speedFactor') !== typeof undefined && $this.attr('data-speedFactor') !== false) {
                    $speedFactor = $this.attr('data-speedFactor');
                }
                $($this).parallax("49%", $speedFactor);
            });
        }
    }

    if (isMobile.any()) {

        /*$(document).on( 'dblclick()', '.responsi-menu li.menu-item-has-children.open > a', function(event){
            //event.preventDefault();
            $(this).parent('.responsi-menu li.menu-item-has-children').find('li.menu-item-has-children').removeClass('open');
            return false;
        });
        */

        $(document).on('dblclick', '.responsi-menu li.menu-item-has-children > a', function(event) {
            return true;
        });

        /*$(document).on('tap click', '.responsi-menu li.menu-item-has-children > a', function() {
            if (!$(this).parent('.responsi-menu li.menu-item-has-children').hasClass('open')) {
                $('li.menu-item-has-children').removeClass('open');
                $(this).parent('.responsi-menu li.menu-item-has-children').addClass('open');
                $(this).parent('.responsi-menu li.menu-item-has-children').siblings('li.menu-item-has-children').removeClass('open').find('li.menu-item-has-children').removeClass('open');
                $(window).trigger('build-icon-arrow');
                return false;
            }
        });*/

    }

    $(window).on("build-icon-arrow load", function() {
        
        var $el, position = 0, itemHeight;
        
        $('.responsi-menu .menu-item-has-children > i, .responsi-menu .menu-item-has-children > svg').each(function(){

            itemHeight = $(this).siblings('a').outerHeight();

            if( $(this).is( "i" ) ){

                $(this).css({
                    width: 100 + '%',
                    height: itemHeight,
                    lineHeight: itemHeight+"px",
                    left: function() {
                        $el = $(this).siblings('a').find('.item-arrow');
                        position = $el.position();
                        return position.left + 10;
                    },
                    opacity:1
                });
            }

            if( $(this).is( "svg" ) ){

                $(this).css({
                    //height: itemHeight+"px",
                    lineHeight: itemHeight+"px",
                    maxHeight: itemHeight+"px",
                    paddingTop:$(this).siblings('a').css('padding-top'),
                    paddingBottom:$(this).siblings('a').css('padding-bottom'),
                    paddingRight:'100%',
                    left: function() {
                        $el = $(this).siblings('a').find('.item-arrow');
                        position = $el.position();
                        return position.left + 10;
                    },
                    opacity:1
                });
            }

        });

        window.responsiTopCtn();

    });

    $(document).on("tap click", ".responsi-menu .menu-item-has-children > i, .responsi-menu .menu-item-has-children > svg", function() {
        $(this).parent().addClass('open');
        $(this).addClass('fa-caret-up').removeClass('fa-caret-down');
        $(window).trigger('build-icon-arrow');
        return false;
    });

    $(document).on("tap click", ".responsi-menu .menu-item-has-children.open > i, .responsi-menu .menu-item-has-children.open > svg", function() {
        $(this).parent().removeClass('open');
        $(this).addClass('fa-caret-down').removeClass('fa-caret-up');
        $(window).trigger('build-icon-arrow');
        return false;
    });

    $(document).on("tap click", ".close .separator,.close .menu-text", function() {
        var clicked = $(this).parent('div.navigation-mobile');
        clicked.siblings(".responsi-menu").slideUp("fast", function() {
            clicked.children('.menu-icon').removeClass('responsi-icon-cancel').addClass('hamburger-icon');
            clicked.removeClass('close').addClass('open');
            $(window).trigger('build-icon-arrow');
        });
    });

    $(document).on("tap click", ".open .separator, .open .menu-text", function() {
        $('.responsi-menu .menu-item-has-children > i, .responsi-menu .menu-item-has-children > svg').css({opacity:0});
        var clicked = $(this).parent('div.navigation-mobile');
        clicked.siblings(".responsi-menu").slideDown("fast", function() {
            clicked.children('.menu-icon').removeClass('hamburger-icon').addClass('responsi-icon-cancel');
            clicked.removeClass('open').addClass('close');
            $(window).trigger('build-icon-arrow');
        });
    });

    $(document).on("mouseenter", "div.box-content .box-item", function() {
        $(this).addClass("hover");
    });

    $(document).on("mouseleave", "div.box-content .box-item", function() {
        $(this).removeClass("hover");
    });

    // Find all YouTube videos

    function applyVideoCtn() {

        var $allVideos = $("iframe[src*='youtube.com'], iframe[data-src*='youtube.com'], iframe[src*='player.vimeo.com'], iframe[data-src*='player.vimeo.com'], iframe[src*='kickstarter.com'], iframe[data-src*='kickstarter.com'], object:not('.object-exclude'), embed:not('.object-exclude'), video:not('.object-exclude,.wp-video-shortcode')");

        if ($allVideos.length > 0) {
            $allVideos.each(function() {

                var video_ojbect, $el, newWidth;
                video_ojbect = $(this);

                if (!video_ojbect.parent().hasClass('video-ojbect-ctn')) {

                    video_ojbect.wrap('<div class="video-ojbect-ctn" />');
                    video_ojbect
                        // jQuery .data does not work on object/embed elements
                        .attr('data-aspectRatio', this.height / this.width)
                        .css('max-width', this.width + 'px')
                        .css({
                            "max-width": this.width + 'px'
                        })
                        .css({
                            maxWidth: this.width + 'px'
                        })
                        .css('max-height', this.height + 'px')
                        .css({
                            "max-height": this.height + 'px'
                        })
                        .css({
                            maxHeight: this.height + 'px'
                        })
                        .removeAttr('height')
                        .removeAttr('width').addClass('video_ojbect');
                    $fluidEl = video_ojbect.parent('.video-ojbect-ctn');
                    newWidth = $fluidEl.width();
                    $el = video_ojbect;
                    $el.width(newWidth).height(newWidth * $el.attr('data-aspectRatio'));
                } else {
                    $fluidEl = video_ojbect.parent('.video-ojbect-ctn');
                    newWidth = $fluidEl.width();
                    $el = video_ojbect;
                    $el.width(newWidth).height(newWidth * $el.attr('data-aspectRatio'));
                }
            });
            /*var $video = $('div.video video');
            var vidWidth = $video.attr('width');
            var vidHeight = $video.attr('height');
            var targetWidth = $(window).width();
            $('div.video, div.video .mejs-container').css('height', Math.ceil(vidHeight * (targetWidth / vidWidth)));
            $('.mejs-overlay-loading').closest('.mejs-overlay').addClass('load');*/
        }
    }

    $.ajaxSetup({
        cache: false
    });

    $(document).ready(function() {

        parallaxEdge();
        parallax();

        window.responsiTopCtn();

        var _widget_el = 0;
        $('.msr-wg').each(function() {
            _widget_el = $(this).find('.widget-content').length;
            if (2 === _widget_el) {
                $(this).find('.widget-content:first-child').remove();
            }
        });

        //applyVideoCtn();

        /*-----------------------------------------------------------------------------------*/
        /* Responsi */
        /*-----------------------------------------------------------------------------------*/

        if ('true' === responsi_paramaters.responsi_fixed_thumbnail && responsi_paramaters.responsi_fixed_thumbnail_tall > 0) {
            var thumbWidth = $('.responsi-frontend .main .box-item .card-item .card-thumb').first().width(),
            thumbMaxHeight = (thumbWidth * responsi_paramaters.responsi_fixed_thumbnail_tall) / 100,
            css = '.card-item .thumb > a{ height:' + thumbMaxHeight + 'px !important; }';
            if ($('#card-custom-style').length > 0) {
                $('#card-custom-style').html(css);
            } else {
                $('head').append('<style id="card-custom-style">' + css + '</style>');
            }
        }

        function responsiInfiniteScroll( elem ){

            if( null !== elem ){

                let scrollThresholdData = true
            
                if ('click_showmore' === responsi_paramaters.responsi_showmore) {
                    scrollThresholdData = false;
                }

                if( null !== document.querySelector('a.next.page-numbers') ){

                    let options = {
                        path:'a.next.page-numbers',
                        path1: function generatePageUrl() {

                            let pageNumbers = $('body').find('.pagination').find('a.page-numbers:not(.next)');

                            if( pageNumbers.length > 0 && pageNumbers.length == 1){
                                return pageNumbers[this.loadCount] ? pageNumbers[this.loadCount].href : false;
                            }else{

                                if (pageNumbers.length > 0 && this.loadCount <= pageNumbers.length ) {
                                    console.log(pageNumbers[this.loadCount] ? pageNumbers[this.loadCount].href : false);
                                    return pageNumbers[this.loadCount] ? pageNumbers[this.loadCount].href : false;
                                }
                            }

                            return false;

                        },
                        append: false,
                        history: false,
                        checkLastPage: true,
                        status: '.responsi-scroller-status',
                        button: '.pagination-ctrl',
                        hideNav: '.responsi-pagination',
                        scrollThreshold: scrollThresholdData,
                    };


                    let infScroll = new InfiniteScroll( elem, options);

                    infScroll.on( 'load', function( body, path, response ) {
                        if( null !== document.querySelector('a.next.page-numbers') ){
                            let items = '';
                            let appendItems = '';
                            let contents = body.querySelector('.box-content');
                            if( null !== contents ){

                                items = contents.querySelectorAll('.box-item');
                                appendItems = items;
                                elem.append( ...appendItems );
                                
                                $(document.body).trigger('newElements');

                                if (typeof $(window).lazyLoadXT !== 'undefined' && typeof $(window).lazyLoadXT === 'function') { 
                                    $(window).lazyLoadXT();
                                }

                                if( this.button != undefined ){
                                    this.button.element.classList.remove("requesting");
                                }

                            }
                        }
                    });

                    infScroll.on( 'request', function( path, fetchPromise ) {
                        if( this.button != undefined  ){
                            this.button.element.classList.add("requesting");
                        }
                    });

                    infScroll.on( 'last', function( body, path ) {
                        $('.page-load-status .infinite-scroll-last').fadeOut( 2600, function() {});
                    });

                    infScroll.on( 'error', function( body, path ) {
                        $('.page-load-status .infinite-scroll-error').fadeOut( 2600, function() {});
                    });

                    return infScroll;
                    
                }else{
                    return false;
                }

            }

            return false;

        }

        let elemInfiniteScroll = document.querySelector('.box-content');

        let infScroll = responsiInfiniteScroll( elemInfiniteScroll );

        $(window).on('vsaf_ajax_filtering_end' , function() {
        
            if( infScroll ){
                infScroll.destroy();
                infScroll = responsiInfiniteScroll( elemInfiniteScroll );
            }else{
                infScroll = responsiInfiniteScroll( elemInfiniteScroll );
            }
        });


        if ( ( typeof wp != "undefined" && typeof wp != undefined ) && ( typeof wp.customize != "undefined" && typeof wp.customize != undefined ) ) {
            setTimeout(function() {
                if (responsi_paramaters.responsi_google_webfonts != '') {
                    if ($('#google-fonts-css').length > 0) {
                        $('#google-fonts-css').attr('href', responsi_paramaters.responsi_google_webfonts);
                    } else {
                        $('head').append('<link id="google-fonts-css" href="' + responsi_paramaters.responsi_google_webfonts + '" rel="stylesheet">');
                    }
                    setTimeout(function() {
                        $(document.body).trigger('newElements');
                    }, 250);
                }
            }, 250);
        }

    });

    $(window).on('resize newElements lazyload', function() {

        if ('true' === responsi_paramaters.responsi_fixed_thumbnail && responsi_paramaters.responsi_fixed_thumbnail_tall > 0) {
            var thumbWidth = $('.responsi-frontend .main .box-item .card-item .card-thumb').first().width(),
            thumbMaxHeight = (thumbWidth * responsi_paramaters.responsi_fixed_thumbnail_tall) / 100,
            css = '.card-item .thumb > a{ height:' + thumbMaxHeight + 'px !important; }';
            if ($('#card-custom-style').length > 0) {
                $('#card-custom-style').html(css);
            } else {
                $('head').append('<style id="card-custom-style">' + css + '</style>');
            }
        }

        if (typeof scrollWaypointInit === "function") { 
            scrollWaypointInit($(".animateMe"));
        }
        
    });

    $(window).on('resize', function() {
        window.responsiTopCtn();
    });

    /*-----------------------------------------------------------------------------------*/
    /* Add back-top first */
    /*-----------------------------------------------------------------------------------*/

    // fade in .backTopBtn
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.backTopBtn').fadeIn();
        } else {
            $('.backTopBtn').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('.backTopBtn a').on('click', function() {
        $('html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });

});
