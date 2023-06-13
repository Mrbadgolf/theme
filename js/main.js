jQuery(document).ready(function ($) {
	"use strict";

	/*if( jQuery('html').attr('dir') == 'rtl' ){
		jQuery('[data-vc-full-width="true"]').each( function(i,v){
			jQuery(this).css( 'left' , 'auto');
		});
	}*/

		function bs_fix_vc_full_width_row() {
			var $elements = jQuery('[data-vc-full-width="true"]');
			jQuery.each($elements, function () {
				var $el = jQuery(this);
				$el.css('right', $el.css('left')).css('left', '');
			});
		}
		if( jQuery('html').attr('dir') == 'rtl' ) {
			// Fixes rows in RTL
			jQuery(document).on('vc-full-width-row', function () {
				bs_fix_vc_full_width_row();
			});
	
			// Run one time because it was not firing in Mac/Firefox and Windows/Edge some times
			bs_fix_vc_full_width_row();
		}
	//scroll to top
	$(document).ready(function(){
		$(window).scroll(function () {
			if ($(this).scrollTop() > 0) {
				$('#scroller').fadeIn();
			} else {
				$('#scroller').fadeOut();
			}
		});
		$('#scroller').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
	});
	/* Sticky Top menu*/
	var $menu = $("#stickymenu");
	if($(window).width()>960){
		$(window).scroll(function(){
			if ( $(this).scrollTop() > 100 && $menu.hasClass("default") ){
				$menu.removeClass("default").addClass("fixed animated slideInDown");
			} else if($(this).scrollTop() <= 100 && $menu.hasClass("fixed")) {
				$menu.removeClass("fixed animated slideInDown").addClass("default");
			}
		});
	}
	/* Page loading animation */
	$(window).on('load', function () {
		var $preloader = $('#page-preloader'),
			$spinner = $preloader.find('.spinner');
		$spinner.fadeOut();
		$preloader.delay(350).fadeOut('slow');
	});
	/* Search Line in menu*/
	$('.open-search, .search-sbmt-close').click(function () {
		$('.search-block').toggleClass('opened-search');
		$('.open-search').toggleClass('opacity0');
	});
	/* Show menu container in Header 3 */
	$('#show4').click(function () {
		$('.menu-container').css('top', '0');
	});
	$('#hide4').click(function () {
		$('.menu-container').css('top', '-3000px');
	});

});