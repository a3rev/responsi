/*-----------------------------------------------------------------------------------*/
/* Responsive menus */
/*-----------------------------------------------------------------------------------*/
(function ($) {
	var menuCount = 0;
	$.fn.mobileMenu = function (options) {
		var settings = {
			switchWidth: 721,
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
   	}

   	function isIE () {
		var myNav = navigator.userAgent.toLowerCase();
		return (myNav.indexOf('msie') != -1) ? parseInt(myNav.split('msie')[1]) : false;
	}

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

	}

	// Find all YouTube videos
	var $allVideos = jQuery("iframe[src^='https://www.youtube.com'],iframe[data-src],iframe[src^='//www.youtube.com'], iframe[src^='http://www.youtube.com'], iframe[src^='http://player.vimeo.com'], iframe[src^='//player.vimeo.com'], iframe[src^='http://www.kickstarter.com'], iframe[src^='//www.kickstarter.com'], object:not('.object-exclude'), embed:not('.object-exclude'), video:not('.object-exclude,.wp-video-shortcode'),.mejs-inner");

	jQuery(window).on( 'load', function() {
		
		if ( isIE() ) {
			if ( isIE() <= 9) {
				jQuery('body').addClass('ie ie9');
			}else{
				jQuery('body').addClass('ie').removeClass('ie9');
			}
		}else{
			jQuery('body').removeClass('ie ie9');
		}

		jQuery('body').addClass('site-loaded');

		var header_height = jQuery("#wrapper-top-fixed").outerHeight(true);
        jQuery("#wrapper-top-container").height(header_height);
        jQuery("#wrapper-top-fixed").css('position','fixed');

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
		});
		// When the window is resized
		// (You'll probably want to debounce this)
		jQuery(window).resize(function() {
			var header_height = jQuery("#wrapper-top-fixed").outerHeight(true);
            jQuery("#wrapper-top-container").height(header_height);
			$allVideos.each(function() {
				$fluidEl = jQuery(this).parent('.video_ojbect_container');
				var newWidth = $fluidEl.width();
				var $el = jQuery(this);
				$el.width(newWidth).height(newWidth * $el.attr('data-aspectRatio'));
			});
			//jQuery( '.responsi-icon-mobile-menu' ).removeClass('responsi-icon-cancel').addClass('responsi-icon-menu');
		// Kick off one resize to fix all videos on page load
		}).resize();

		jQuery('.mejs-overlay-loading').closest('.mejs-overlay').addClass('load'); //just a helper class

		var $video = jQuery('div.video video');
		var vidWidth = $video.attr('width');
		var vidHeight = $video.attr('height');

		jQuery(window).resize(function() {
			var targetWidth = jQuery(this).width(); //using window width here will proportion the video to be full screen; adjust as needed
			jQuery('div.video, div.video .mejs-container').css('height', Math.ceil(vidHeight * (targetWidth / vidWidth)));
		}).resize();

		if(jQuery('nav#navigation').find('.mobile-navigation').length == undefined || jQuery('nav#navigation').find('.mobile-navigation').length == 0 ){
			// Responsive Navigation (switch top drop down for select)
			jQuery('ul#main-nav').mobileMenu({
				switchWidth: 721,                   //width (in px to switch at)
				topOptionText: 'Menu...',     //first option text
				indentString: '&nbsp;&nbsp;&nbsp;'  //string for indenting nested items
			});
		}

	});

	jQuery(document).on("tap", ".mobile-navigation-close .nav-separator,.mobile-navigation-close .nav-mobile-text", function(){
		var clicked = jQuery(this).parent('div.mobile-navigation');
		clicked.siblings( ".responsi-menu" ).slideUp( "fast", function() {
			clicked.children('.responsi-icon-mobile-menu').removeClass('responsi-icon-cancel').addClass('responsi-icon-menu');
			clicked.removeClass('mobile-navigation-close').addClass('mobile-navigation-open');
			var header_height = jQuery("#wrapper-top-fixed").outerHeight(true);
			jQuery("#wrapper-top-container").height(header_height);
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

	/*-----------------------------------------------------------------------------------*/
	/* Responsi Masonry */
	/*-----------------------------------------------------------------------------------*/

	jQuery.ajaxSetup({ cache: false });
	jQuery( window ).on( 'load', function(){
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

        jQuery( window ).on( 'load resize', function() {
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
