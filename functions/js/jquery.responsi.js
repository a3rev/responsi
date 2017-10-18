function isIE () {
	var myNav = navigator.userAgent.toLowerCase();
	return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
};

function getBaseURL() {
	var url = location.href;  // entire url including querystring - also: window.location.href;
	var baseURL = url.substring(0, url.indexOf('/', 14));


	if (baseURL.indexOf('http://localhost') != -1) {
		// Base Url for localhost
		var url = location.href;  // window.location.href;
		var pathname = location.pathname;  // window.location.pathname;
		var index1 = url.indexOf(pathname);
		var index2 = url.indexOf("/", index1 + 1);
		var baseLocalUrl = url.substr(0, index2);

		return baseLocalUrl + "/";
	}
	else {
		// Root Url for domain name
		return baseURL + "/";
	}

};

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

function is_touch_device() {
    return ('ontouchstart' in document.documentElement);
};

jQuery.exists = function(selector) {
    return (jQuery(selector).length > 0);
};

function responsi_header_height(){
	var win = jQuery(window);
	var header_height = jQuery("#wrapper-top-fixed").outerHeight(true);
	jQuery("#wrapper-top-container").height(header_height);
};

function browser() {
    var browser = "Unknown browser";
    if(!!window.chrome && !(!!window.opera))  browser = 'chrome'; // Chrome 1+
    if(typeof InstallTrigger !== 'undefined')  browser = 'firefox'; // Firefox 1.0+
    if(!!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0)  browser = 'opera'; // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
    if(/*@cc_on!@*/false || !!document.documentMode)  browser = 'ie'; // At least IE6
    if(Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0)  browser = 'safari'; // At least Safari 3+: "[object HTMLElementConstructor]"
    
    return browser;
}

/*
SmoothScroll for websites v1.2.1
Licensed under the terms of the MIT license.
// People involved
//  - Balazs Galambosi (maintainer)
//  - Michael Herf     (Pulse Algorithm)
*/

var onePager = jQuery('.responsi-edge-one-pager').length;
if (!onePager && (browser() === 'chrome' || browser() === 'ie_11')) {
    // SmoothScroll for websites v1.2.1
    // Licensed under the terms of the MIT license.
    // People involved
    //  - Balazs Galambosi (maintainer)  
    //  - Michael Herf     (Pulse Algorithm)
    (function() {
        // Scroll Variables (tweakable)
        var defaultOptions = {
            // Scrolling Core
            frameRate: 150, // [Hz]
            animationTime: 400, // [px]
            stepSize: 120, // [px]
            // Pulse (less tweakable)
            // ratio of "tail" to "acceleration"
            pulseAlgorithm: true,
            pulseScale: 8,
            pulseNormalize: 1,
            // Acceleration
            accelerationDelta: 20, // 20
            accelerationMax: 1, // 1
            // Keyboard Settings
            keyboardSupport: true, // option
            arrowScroll: 50, // [px]
            // Other
            touchpadSupport: true,
            fixedBackground: true,
            excluded: ""
        };
        var options = defaultOptions;
        // Other Variables
        var isExcluded = false;
        var isFrame = false;
        var direction = {
            x: 0,
            y: 0
        };
        var initDone = false;
        var root = document.documentElement;
        var activeElement;
        var observer;
        var deltaBuffer = [120, 120, 120];
        var key = {
            left: 37,
            up: 38,
            right: 39,
            down: 40,
            spacebar: 32,
            pageup: 33,
            pagedown: 34,
            end: 35,
            home: 36
        };
        /***********************************************
         * SETTINGS
         ***********************************************/
        var options = defaultOptions;
        /***********************************************
         * INITIALIZE
         ***********************************************/
        /**
         * Tests if smooth scrolling is allowed. Shuts down everything if not.
         */
        function initTest() {
            var disableKeyboard = false;
            // disable keyboard support if anything above requested it
            if (disableKeyboard) {
                removeEvent("keydown", keydown);
            }
            if (options.keyboardSupport && !disableKeyboard) {
                addEvent("keydown", keydown);
            }
        }
        /**
         * Sets up scrolls array, determines if frames are involved.
         */
        function init() {
            if (!document.body) return;
            if (is_touch_device()) return;
            var body = document.body;
            var html = document.documentElement;
            var windowHeight = window.innerHeight;
            var scrollHeight = body.scrollHeight;
            // check compat mode for root element
            root = (document.compatMode.indexOf('CSS') >= 0) ? html : body;
            activeElement = body;
            initTest();
            initDone = true;
            // Checks if this script is running in a frame
            if (top != self) {
                isFrame = true;
            }
            /**
             * This fixes a bug where the areas left and right to 
             * the content does not trigger the onmousewheel event
             * on some pages. e.g.: html, body { height: 100% }
             */
            else if (scrollHeight > windowHeight && (body.offsetHeight <= windowHeight || html.offsetHeight <= windowHeight)) {

                var pending = false;
                var refresh = function () {
                    if (!pending && html.scrollHeight != document.height) {
                        pending = true; // add a new pending action
                        setTimeout(function () {
                            html.style.height = document.height + 'px';
                            pending = false;
                        }, 500); // act rarely to stay fast
                    }
                };
                html.style.height = 'auto';
                setTimeout(refresh, 10);

                // clearfix
                if (root.offsetHeight <= windowHeight) {
                    var underlay = document.createElement("div");   
                    underlay.style.clear = "both";
                    body.appendChild(underlay);
                }

            }
            // disable fixed background
            if (!options.fixedBackground && !isExcluded) {
                body.style.backgroundAttachment = "scroll";
                html.style.backgroundAttachment = "scroll";
            }
        }
        /************************************************
         * SCROLLING 
         ************************************************/
        var que = [];
        var pending = false;
        var lastScroll = +new Date;
        /**
         * Pushes scroll actions to the scrolling queue.
         */
        function scrollArray(elem, left, top, delay) {
            delay || (delay = 1000);
            directionCheck(left, top);
            if (options.accelerationMax != 1) {
                var now = +new Date;
                var elapsed = now - lastScroll;
                if (elapsed < options.accelerationDelta) {
                    var factor = (1 + (30 / elapsed)) / 2;
                    if (factor > 1) {
                        factor = Math.min(factor, options.accelerationMax);
                        left *= factor;
                        top *= factor;
                    }
                }
                lastScroll = +new Date;
            }
            // push a scroll command
            que.push({
                x: left,
                y: top,
                lastX: (left < 0) ? 0.99 : -0.99,
                lastY: (top < 0) ? 0.99 : -0.99,
                start: +new Date
            });
            // don't act if there's a pending queue
            if (pending) {
                return;
            }
            var scrollWindow = (elem === document.body);
            var step = function(time) {
                var now = +new Date;
                var scrollX = 0;
                var scrollY = 0;
                for (var i = 0; i < que.length; i++) {
                    var item = que[i];
                    var elapsed = now - item.start;
                    var finished = (elapsed >= options.animationTime);
                    // scroll position: [0, 1]
                    var position = (finished) ? 1 : elapsed / options.animationTime;
                    // easing [optional]
                    if (options.pulseAlgorithm) {
                        position = pulse(position);
                    }
                    // only need the difference
                    var x = (item.x * position - item.lastX) >> 0;
                    var y = (item.y * position - item.lastY) >> 0;
                    // add this to the total scrolling
                    scrollX += x;
                    scrollY += y;
                    // update last values
                    item.lastX += x;
                    item.lastY += y;
                    // delete and step back if it's over
                    if (finished) {
                        que.splice(i, 1);
                        i--;
                    }
                }
                // scroll left and top
                if (scrollWindow) {
                    window.scrollBy(scrollX, scrollY);
                } else {
                    if (scrollX) elem.scrollLeft += scrollX;
                    if (scrollY) elem.scrollTop += scrollY;
                }
                // clean up if there's nothing left to do
                if (!left && !top) {
                    que = [];
                }
                if (que.length) {
                    requestFrame(step, elem, (delay / options.frameRate + 1));
                } else {
                    pending = false;
                }
            };
            // start a new queue of actions
            requestFrame(step, elem, 0);
            pending = true;
        }
        /***********************************************
         * EVENTS
         ***********************************************/
        /**
         * Mouse wheel handler.
         * @param {Object} event
         */
        function wheel(event) {
            if (!initDone) {
                init();
            }
            var target = event.target;
            var overflowing = overflowingAncestor(target);
            // use default if there's no overflowing
            // element or default action is prevented    
            if (!overflowing || event.defaultPrevented || isNodeName(activeElement, "embed") || (isNodeName(target, "embed") && /\.pdf/i.test(target.src))) {
                return true;
            }
            var deltaX = event.wheelDeltaX || 0;
            var deltaY = event.wheelDeltaY || 0;
            // use wheelDelta if deltaX/Y is not available
            if (!deltaX && !deltaY) {
                deltaY = event.wheelDelta || 0;
            }
            // check if it's a touchpad scroll that should be ignored
            if (!options.touchpadSupport && isTouchpad(deltaY)) {
                return true;
            }
            // scale by step size
            // delta is 120 most of the time
            // synaptics seems to send 1 sometimes
            if (Math.abs(deltaX) > 1.2) {
                deltaX *= options.stepSize / 120;
            }
            if (Math.abs(deltaY) > 1.2) {
                deltaY *= options.stepSize / 120;
            }
            scrollArray(overflowing, -deltaX, -deltaY);
            event.preventDefault();
        }
        /**
         * Keydown event handler.
         * @param {Object} event
         */
        function keydown(event) {
            var target = event.target;
            var modifier = event.ctrlKey || event.altKey || event.metaKey || (event.shiftKey && event.keyCode !== key.spacebar);
            // do nothing if user is editing text
            // or using a modifier key (except shift)
            // or in a dropdown
            if (/input|textarea|select|embed/i.test(target.nodeName) || target.isContentEditable || event.defaultPrevented || modifier) {
                return true;
            }
            // spacebar should trigger button press
            if (isNodeName(target, "button") && event.keyCode === key.spacebar) {
                return true;
            }
            var shift, x = 0,
                y = 0;
            var elem = overflowingAncestor(activeElement);
            var clientHeight = elem.clientHeight;
            if (elem == document.body) {
                clientHeight = window.innerHeight;
            }
            switch (event.keyCode) {
                case key.up:
                    y = -options.arrowScroll;
                    break;
                case key.down:
                    y = options.arrowScroll;
                    break;
                case key.spacebar: // (+ shift)
                    shift = event.shiftKey ? 1 : -1;
                    y = -shift * clientHeight * 0.9;
                    break;
                case key.pageup:
                    y = -clientHeight * 0.9;
                    break;
                case key.pagedown:
                    y = clientHeight * 0.9;
                    break;
                case key.home:
                    y = -elem.scrollTop;
                    break;
                case key.end:
                    var damt = elem.scrollHeight - elem.scrollTop - clientHeight;
                    y = (damt > 0) ? damt + 10 : 0;
                    break;
                case key.left:
                    x = -options.arrowScroll;
                    break;
                case key.right:
                    x = options.arrowScroll;
                    break;
                default:
                    return true; // a key we don't care about
            }
            scrollArray(elem, x, y);
            event.preventDefault();
        }
        /**
         * Mousedown event only for updating activeElement
         */
        function mousedown(event) {
            activeElement = event.target;
        }
        /***********************************************
         * OVERFLOW
         ***********************************************/
        var cache = {}; // cleared out every once in while
        setInterval(function() {
            cache = {};
        }, 10 * 1000);
        var uniqueID = (function() {
            var i = 0;
            return function(el) {
                return el.uniqueID || (el.uniqueID = i++);
            };
        })();

        function setCache(elems, overflowing) {
            for (var i = elems.length; i--;) cache[uniqueID(elems[i])] = overflowing;
            return overflowing;
        }

        function overflowingAncestor(el) {
            var elems = [];
            var rootScrollHeight = root.scrollHeight;
            do {
                var cached = cache[uniqueID(el)];
                if (cached) {
                    return setCache(elems, cached);
                }
                elems.push(el);
                if (rootScrollHeight === el.scrollHeight) {
                    if (!isFrame || root.clientHeight + 10 < rootScrollHeight) {
                        return setCache(elems, document.body); // scrolling root in WebKit
                    }
                } else if (el.clientHeight + 10 < el.scrollHeight) {
                    overflow = getComputedStyle(el, "").getPropertyValue("overflow-y");
                    if (overflow === "scroll" || overflow === "auto") {
                        return setCache(elems, el);
                    }
                }
            } while (el = el.parentNode);
        }
        /***********************************************
         * HELPERS
         ***********************************************/
        function addEvent(type, fn, bubble) {
            window.addEventListener(type, fn, (bubble || false));
        }

        function removeEvent(type, fn, bubble) {
            window.removeEventListener(type, fn, (bubble || false));
        }

        function isNodeName(el, tag) {
            return (el.nodeName || "").toLowerCase() === tag.toLowerCase();
        }

        function directionCheck(x, y) {
            x = (x > 0) ? 1 : -1;
            y = (y > 0) ? 1 : -1;
            if (direction.x !== x || direction.y !== y) {
                direction.x = x;
                direction.y = y;
                que = [];
                lastScroll = 0;
            }
        }
        var deltaBufferTimer;

        function isTouchpad(deltaY) {
            if (!deltaY) return;
            deltaY = Math.abs(deltaY)
            deltaBuffer.push(deltaY);
            deltaBuffer.shift();
            clearTimeout(deltaBufferTimer);
            var allEquals = (deltaBuffer[0] == deltaBuffer[1] && deltaBuffer[1] == deltaBuffer[2]);
            var allDivisable = (isDivisible(deltaBuffer[0], 120) && isDivisible(deltaBuffer[1], 120) && isDivisible(deltaBuffer[2], 120));
            return !(allEquals || allDivisable);
        }

        function isDivisible(n, divisor) {
            return (Math.floor(n / divisor) == n / divisor);
        }
        var requestFrame = (function() {
            return window.requestAnimationFrame || window.webkitRequestAnimationFrame || function(callback, element, delay) {
                window.setTimeout(callback, delay || (1000 / 60));
            };
        })();
        /***********************************************
         * PULSE
         ***********************************************/
        /**
         * Viscous fluid with a pulse for part and decay for the rest.
         * - Applies a fixed force over an interval (a damped acceleration), and
         * - Lets the exponential bleed away the velocity over a longer interval
         * - Michael Herf, http://stereopsis.com/stopping/
         */
        function pulse_(x) {
            var val, start, expx;
            // test
            x = x * options.pulseScale;
            if (x < 1) { // acceleartion
                val = x - (1 - Math.exp(-x));
            } else { // tail
                // the previous animation ended here:
                start = Math.exp(-1);
                // simple viscous drag
                x -= 1;
                expx = 1 - Math.exp(-x);
                val = start + (expx * (1 - start));
            }
            return val * options.pulseNormalize;
        }

        function pulse(x) {
            if (x >= 1) return 1;
            if (x <= 0) return 0;
            if (options.pulseNormalize == 1) {
                options.pulseNormalize /= pulse_(1);
            }
            return pulse_(x);
        }
        var isChrome = /chrome/i.test(window.navigator.userAgent);
        var isMouseWheelSupported = 'onmousewheel' in document;
        if (isMouseWheelSupported) {
            addEvent("mousedown", mousedown);
            addEvent("mousewheel", wheel);
            addEvent("load", init);
        };
    })();
}
if (browser() === 'ie') {
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
        }
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
        }
        var animateLoop = function() {
            if (!running) return;
            requestAnimFrame(animateLoop);
            render();
            //log("45","animateLoop","animateLoop", "",stop);
        }
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
            }
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
                    container.bind("mousewheel", onWheel);
                    container.bind("DOMMouseScroll", onWheel);
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
                        container.unbind("mousewheel", onWheel);
                        container.unbind("DOMMouseScroll", onWheel);
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

(function( $ ){
	var $window = $(window);
	var windowHeight = $window.height();

	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		
		//get the starting position of each element to have parallax applied to it		
		$this.each(function(){
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
		function update(){
			var pos = $window.scrollTop();				

			$this.each(function(){
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

		$window.bind('scroll', update).resize(update);
		update();
	};
})(jQuery);

/*-----------------------------------------------------------------------------------*/
/* Responsive menus */
/*-----------------------------------------------------------------------------------*/
(function ($) {
	var menuCount = 0;
	$.fn.mobileMenu = function (options) {
		var settings = {
			switchWidth: 783,
			topOptionText: 'Menu',
			indentString: '&nbsp;&nbsp;&nbsp;'
		};

		function isList($this) {
			return $this.is('ul, ol')
		}
		function isMobile() {
			return ($(window).width() < settings.switchWidth)
		}
		function menuExists($this) {
			if ($this.attr('id')) {
				return ($('#mobileMenu_' + $this.attr('id')).length > 0)
			} else {
				menuCount++;
				$this.attr('id', 'mm' + menuCount);
				return ($('#mobileMenu_mm' + menuCount).length > 0)
			}
		}
		function goToPage($this) {
			if ($this.val() !== null) {
				document.location.href = $this.val()
			}
		}
		function showMenu($this) {
			$this.css('display', 'none');
			$('#mobileMenu_' + $this.attr('id')).show()
		}
		function hideMenu($this) {
			$this.css('display', '');
			$('#mobileMenu_' + $this.attr('id')).hide()
		}
		function createMenu($this) {
			if (isList($this)) {
				var selectString = '<select id="mobileMenu_' + $this.attr('id') + '" class="mobileMenu">';
				selectString += '<option value="">' + settings.topOptionText + '</option>';
				$this.find('li').each(function () {
					var levelStr = '';
					var len = $(this).parents('ul, ol').length;
					var submenuClass = '';
					for (i = 1; i < len; i++) {
						levelStr += settings.indentString;
						submenuClass = 'mobile-hide'
					}
					var link = $(this).find('a:first-child').attr('href');
					var text = levelStr + $(this).clone().children('ul, ol').remove().end().text();
					selectString += '<option value="' + link + '" class="' + submenuClass + '">' + text + '</option>'
				});
				selectString += '</select>';
				$this.parent().append(selectString);
				$('#mobileMenu_' + $this.attr('id')).change(function () {
					goToPage($(this))
				});
				showMenu($this)
			} else {
				alert('mobileMenu will only work with UL or OL elements!')
			}
		}
		function run($this) {
			if (isMobile() && !menuExists($this)) {
				createMenu($this)
			} else if (isMobile() && menuExists($this)) {
				showMenu($this)
			} else if (!isMobile() && menuExists($this)) {
				hideMenu($this)
			}
		}
		return this.each(function () {
			if (options) {
				$.extend(settings, options)
			}
			var $this = $(this);
			$(window).resize(function () {
				run($this)
			});
			run($this)
		})
	}
})(jQuery); 

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
;(function( $ ){

  'use strict';

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null,
      ignore: null
    };

    if(!document.getElementById('fit-vids-style')) {
      // appendStyles: https://github.com/toddmotto/fluidvids/blob/master/dist/fluidvids.js
      var head = document.head || document.getElementsByTagName('head')[0];
      var css = '.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}';
      var div = document.createElement("div");
      div.innerHTML = '<p>x</p><style id="fit-vids-style">' + css + '</style>';
      head.appendChild(div.childNodes[1]);
    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
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

      if(settings.ignore) {
        ignoreList = ignoreList + ', ' + settings.ignore;
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not('object object'); // SwfObj conflict patch
      $allVideos = $allVideos.not(ignoreList); // Disable FitVids on this video.

      $allVideos.each(function(count){
        var $this = $(this);
        if($this.parents(ignoreList).length > 0) {
          return; // Disable FitVids on this video.
        }
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        if ((!$this.css('height') && !$this.css('width')) && (isNaN($this.attr('height')) || isNaN($this.attr('width'))))
        {
          $this.attr('height', 9);
          $this.attr('width', 16);
        }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + count;
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+'%');
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );



/*-----------------------------------------------------------------------------------*/
/* Run scripts on jQuery(document).ready() */
/*-----------------------------------------------------------------------------------*/

jQuery.noConflict();

jQuery(document).ready(function(){
	/*-----------------------------------------------------------------------------------*/
	/* Sure console is define */
	/*-----------------------------------------------------------------------------------*/
	if(!(window.console && console.log)) {
		console = {
			log: function(){},
			debug: function(){},
			info: function(){},
			warn: function(){},
			error: function(){}
   		};
   	};

	/* Parallax for edge slider */
	/* -------------------------------------------------------------------- */

	function responsi_parallax_edge() {
	    "use strict";
	    
	    if ( !isMobile.any() ) {
	        var $parallaxLayer = [];
	        jQuery('.parallax-edge').each(function() {
	            var progressVal,
	                currentPoint,
	                ticking = false,
	                scrollY = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop,
	                $this = jQuery(this),
	                $window = jQuery(window),
	                windowHeight = jQuery(window).height(),
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
	                        '-webkit-transform': 'translateY(' + currentPoint + 'px)',
	                        '-moz-transform': 'translateY(' + currentPoint + 'px)',
	                        '-ms-transform': 'translateY(' + currentPoint + 'px)',
	                        '-o-transform': 'translateY(' + currentPoint + 'px)',
	                        'transform': 'translateY(' + currentPoint + 'px)'
	                    });
	                }
	                cntLayer.stop().css({
	                    opacity: (1 - (progressVal * 2))
	                });
	                ticking = false;
	            }
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
	};

	function responsi_parallax() {
	    "use strict";
	    if (!is_touch_device() && jQuery(window).width() > 1050) {
	        jQuery('.parallax-background').each(function() {
	            var $this = jQuery(this),
	                $speedFactor = 0.3;
	            if (typeof $this.attr('data-speedFactor') !== typeof undefined && $this.attr('data-speedFactor') !== false) {
	                $speedFactor = $this.attr('data-speedFactor');
	            }
	            jQuery($this).parallax("49%", $speedFactor);
	        });
	    }
	};

	jQuery(document).on("tap", ".mobile-navigation-close .nav-separator,.mobile-navigation-close .nav-mobile-text", function(){
		var clicked = jQuery(this).parent('div.mobile-navigation');
		clicked.siblings( ".responsi-menu" ).slideUp( "fast", function() {
			clicked.children('.responsi-icon-mobile-menu').removeClass('responsi-icon-cancel').addClass('responsi-icon-menu');
			clicked.removeClass('mobile-navigation-close').addClass('mobile-navigation-open');
			responsi_header_height();
		});
	});

	jQuery(document).on("tap", ".mobile-navigation-open .nav-separator, .mobile-navigation-open .nav-mobile-text", function(){
		var clicked = jQuery(this).parent('div.mobile-navigation');
		clicked.siblings( ".responsi-menu" ).slideDown( "fast", function() {
			clicked.children('.responsi-icon-mobile-menu').removeClass('responsi-icon-menu').addClass('responsi-icon-cancel');
			clicked.removeClass('mobile-navigation-open').addClass('mobile-navigation-close');
		});
	});

	jQuery(document).on("mouseenter", "div.box-content .box-item", function(){
		jQuery(this).addClass("hover");

	});

	jQuery(document).on("mouseleave", "div.box-content .box-item", function(){
		jQuery(this).removeClass("hover");
	});

	// Find all YouTube videos
	var $allVideos = jQuery("iframe[src^='https://www.youtube.com'],iframe[data-src],iframe[src^='//www.youtube.com'], iframe[src^='http://www.youtube.com'], iframe[src^='http://player.vimeo.com'], iframe[src^='//player.vimeo.com'], iframe[src^='http://www.kickstarter.com'], iframe[src^='//www.kickstarter.com'], object:not('.object-exclude'), embed:not('.object-exclude'), video:not('.object-exclude,.wp-video-shortcode'),.mejs-inner");

	jQuery.ajaxSetup({ cache: false });
	
	jQuery(window).on( 'load', function() {

		jQuery('body').addClass('site-loaded');

		if ( isIE() ) {
			if ( isIE() <= 9) {
				jQuery('body').addClass('ie ie9');
			}else{
				jQuery('body').addClass('ie').removeClass('ie9');
			}
		}else{
			jQuery('body').removeClass('ie ie9');
		}

		responsi_header_height();
		responsi_parallax_edge();
		responsi_parallax();

		//jQuery("#wrapper-top-fixed").css('position','fixed');

		if(jQuery('nav#navigation').find('.mobile-navigation').length == undefined || jQuery('nav#navigation').find('.mobile-navigation').length == 0 ){
			// Responsive Navigation (switch top drop down for select)
			jQuery('ul#main-nav').mobileMenu({
				switchWidth: 783,                   	//width (in px to switch at)
				topOptionText: 'Menu...',		     	//first option text
				indentString: '&nbsp;&nbsp;&nbsp;'  	//string for indenting nested items
			});
		}

        var fw_widget_content = 0;
        jQuery( '.masonry_widget' ).each( function(){
        	fw_widget_content = jQuery(this).find( '.fw_widget_content' ).length;
        	if( 2 === fw_widget_content ){
        		jQuery(this).find( '.fw_widget_content:first-child' ).remove();
        	}
        });

        if( $allVideos.length > 0 ){ 
	        $allVideos.each(function() {
				jQuery(this).wrap('<div class="video_ojbect_container" />');
				jQuery(this)
			    // jQuery .data does not work on object/embed elements
			    .attr('data-aspectRatio', this.height / this.width)
				.css('max-width',this.width+'px')
				.css({ "max-width": this.width + 'px' })
				.css({ maxWidth: this.width + 'px' })
				.css('max-height',this.height+'px')
				.css({ "max-height": this.height + 'px' })
				.css({ maxHeight: this.height + 'px' })
			    .removeAttr('height')
			    .removeAttr('width').addClass('video_ojbect');
			    $fluidEl = jQuery(this).parent('.video_ojbect_container');
				var newWidth = $fluidEl.width();
				var $el = jQuery(this);
				$el.width(newWidth).height(newWidth * $el.attr('data-aspectRatio'));
			});
			jQuery('.mejs-overlay-loading').closest('.mejs-overlay').addClass('load'); //just a helper class
		}

		/*-----------------------------------------------------------------------------------*/
		/* Responsi Masonry */
		/*-----------------------------------------------------------------------------------*/
		var screen_width = jQuery('html').width();
        var content_column = responsi_paramaters.responsi_content_column_grid;

        if ( 'true' === responsi_paramaters.responsi_fixed_thumbnail && responsi_paramaters.responsi_fixed_thumbnail_tall > 0) {
            var thumb_container_width   = jQuery('body #main .box-item .blog-post-item .thumbnail_container').first().width();
            var thumb_max_height        = ( thumb_container_width * responsi_paramaters.responsi_fixed_thumbnail_tall ) / 100;
            var css = '.blog-post-item .thumbnail > a{ height:'+thumb_max_height +'px !important; }';
            if ( jQuery('#blog-thumb-height').length > 0 ) {
                jQuery('#blog-thumb-height').html(css);
            } else {
                jQuery('head').append('<style id="blog-thumb-height">' + css + '</style>');
            }
        }

        if( screen_width <= 720 && screen_width >= 480 ){
            content_column = 2;
        }
        jQuery('div.box-content').imagesLoaded( function(){
            jQuery('div.box-content').masonry({
                itemSelector: '.box-item',
                columnWidth: jQuery('div.box-content').parent().width()/content_column,
                "gutter": (( jQuery('div.box-content').width() - jQuery('div.box-content').parent().width()) / content_column ) -0.1
            });
        }).trigger('newElements');

        var enable_infinitescroll = true;
        var nextPage = true;
        var currentPage = jQuery('div.pagination span.current').html();
        var maxPageNumber = 1;
        var pageNumbers = jQuery('div.pagination').find('a.page-numbers');
        if(pageNumbers.length > 0){
            pageNumbers.each(function(index){
                if( jQuery(this).html() == (parseInt(currentPage) + 1)){
                    nextPage = jQuery(this);
                }
            });
            maxPageNumber = pageNumbers.length + 1;
        }
        if( nextPage ){
            if ( responsi_paramaters.responsi_is_customized ) {
            	var enable_infinitescroll = false;
            }
            if( enable_infinitescroll == true ){
                jQuery('div.box-content').infinitescroll({
                    navSelector  : 'div.pagination',
                    nextSelector : 'div.pagination a.page-numbers',
                    itemSelector : '.box-item',
                    loading: {
                        finishedMsg : responsi_paramaters.responsi_loading_text_end,
                        msgText     : '<em>' + responsi_paramaters.responsi_loading_text + '</em>',
                        img         : responsi_paramaters.responsi_loading_icon
                    },
                    maxPage:maxPageNumber,
                    //if ( ! responsi_paramaters.responsi_is_customized ) {
                    path:function generatePageUrl( currentPage ){
                        var pageNumbers = jQuery('div.pagination').find('a.page-numbers');
                        var url      = window.location.href;
                        if ( responsi_paramaters.responsi_is_search ){
                        	return [url+"&paged="+currentPage];
                    	} else {
                    		if( responsi_paramaters.responsi_is_permalinks ){
	                    		return [url+"page/"+currentPage+"/"];
	                    	}else{
	                    		return [url+"&paged="+currentPage];
	                    	}
                        }
                    }
                    //}
                },
                function( newElements, opts ) {
                    var $newElems = jQuery( newElements ).css({ opacity: 0 });
                    jQuery('#main').find('#infscr-loading').css( 'max-width', jQuery('#main').width()+'px' );
                    $newElems.find( '.thumbnail_container .thumbnail > a > img[srcset]' ).each(function(){
                        var src = jQuery(this).attr('src');
                        if( '' !== src ){
                            jQuery(this).attr( 'src', '' );
                            jQuery(this).attr( 'src', src );
                        }
                    });
                    $newElems.imagesLoaded( function(){
                        $newElems.animate({ opacity: 1 });
                        jQuery('div.box-content').masonry( 'appended', $newElems, true );
                        if ( 'click_showmore' === responsi_paramaters.responsi_showmore ) {
                            jQuery('.click_showmore_container').show();
                        }
                    }).trigger('newElements');
                });
            }
            if ( 'click_showmore' === responsi_paramaters.responsi_showmore ) {
                jQuery( window ).unbind('.infscr');
                jQuery('.responsi-pagination').before('<div class="click_showmore_container"><div class="click_showmore"><a class="showmore" href="#">' + responsi_paramaters.responsi_showmore_text + '</a></div></div>');
                jQuery('.click_showmore a').click(function(){
                    if( enable_infinitescroll == true ){
                        jQuery('div.box-content').infinitescroll('retrieve');
                    }
                    return false;
                });
            }
        }

        jQuery( window ).on( 'resize newElements lazyload', function() {
	        var content_column = responsi_paramaters.responsi_content_column_grid;
	        var screen_width = jQuery('html').width();
	        if ( 'true' === responsi_paramaters.responsi_fixed_thumbnail && responsi_paramaters.responsi_fixed_thumbnail_tall > 0) {
	            var thumb_container_width   = jQuery('body #main .box-item .blog-post-item .thumbnail_container').first().width();
	            var thumb_max_height        = ( thumb_container_width * responsi_paramaters.responsi_fixed_thumbnail_tall ) / 100;
	            var css = '.blog-post-item .thumbnail > a{ height:'+thumb_max_height +'px !important; }';
	            if ( jQuery('#blog-thumb-height').length > 0 ) {
	                jQuery('#blog-thumb-height').html(css);
	            } else {
	                jQuery('head').append('<style id="blog-thumb-height">' + css + '</style>');
	            }
	        }
	        if( screen_width <= 720 && screen_width >= 480 ){
	            content_column = 2;
	        }
	        if( jQuery('div.box-content .box-item').length ){
	            if( typeof jQuery('div.box-content').masonry === 'function' ){
	                jQuery('div.box-content').masonry({
	                    itemSelector: '.box-item',
	                    columnWidth: jQuery('div.box-content').parent().width()/content_column,
	                    "gutter": (( jQuery('div.box-content').width() - jQuery('div.box-content').parent().width()) / content_column) - 0.1,
	                });
	            }
	        }
	    });

	});

	jQuery(window).on( 'resize', function() {
		
		responsi_header_height();

        if( $allVideos.length > 0 ){ 
	        $allVideos.each(function() {
				$fluidEl = jQuery(this).parent('.video_ojbect_container');
				var newWidth = $fluidEl.width();
				var $el = jQuery(this);
				$el.width(newWidth).height(newWidth * $el.attr('data-aspectRatio'));
			});
			var $video = jQuery('div.video video');
			var vidWidth = $video.attr('width');
			var vidHeight = $video.attr('height');
			var targetWidth = jQuery(this).width(); //using window width here will proportion the video to be full screen; adjust as needed
			jQuery('div.video, div.video .mejs-container').css('height', Math.ceil(vidHeight * (targetWidth / vidWidth)));
		}

	});

	jQuery(window).on( 'load resize', function() {
		if ( 'one-col' !== responsi_paramaters.responsi_layout ) {
            var screen_width = jQuery('html').width();
            var content_column_sb = responsi_paramaters.responsi_content_column;
            if( screen_width <= 720 && screen_width >= 480 ){
                content_column_sb = 2;
                jQuery('.sidebar-wrap-content').masonry({
                    itemSelector: '.masonry_widget',
                    columnWidth: jQuery('.sidebar-wrap-content').width() / content_column_sb,
                    transitionDuration:0,
                    "gutter": -0.5
                });
            }
        }
	});

	/*-----------------------------------------------------------------------------------*/
	/* Add back-top first */
	/*-----------------------------------------------------------------------------------*/

	// hide #back-top first
	jQuery("#back-top").hide();

	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('#back-top').fadeIn();
			} else {
				jQuery('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		jQuery('#back-top a').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

}); // End jQuery()
