;(function($) {

   'use strict'

	var postsCarousel = function(){
		if ( $().owlCarousel ) {
			$('.posts-carousel .carousel-inner').owlCarousel({
				navigation : false,
				pagination: true,
				responsive: true,
				items: 3,
				itemsDesktop: [3000,3],
				itemsDesktopSmall: [1400,3],
				itemsTablet:[991,2],
				itemsTabletSmall: [767,1],
				itemsMobile: [360,1],
				touchDrag: true,
				mouseDrag: true,
				autoHeight: true,
				autoPlay: 5000,
				slideSpeed:1000,
			});
		}
	};

	var menuAnimation = function(){
		$('.sub-menu').hide();
		$('.main-navigation .children').hide();

		if ( matchMedia( 'only screen and (min-width: 1024px)' ).matches ) {
			$('.menu-item').hover( 
				function() {
					$(this).children('.sub-menu').fadeIn().addClass('submenu-visible');
				}, 
				function() {
					$(this).children('.sub-menu').fadeOut().removeClass('submenu-visible');
				}
			);
			$('.main-navigation li').hover( 
				function() {
					$(this).children('.main-navigation .children').fadeIn().addClass('submenu-visible');
				}, 
				function() {
					$(this).children('.main-navigation .children').fadeOut().removeClass('submenu-visible');
				}
			);	
		}
	};

	var stickyWidgets = function() {
		if ($('#secondary').data('sticky') == 'on') {
			$('.widget-area').stickit({
			  scope: StickScope.Parent,
			  className: '',
			  top: 30,
			  extraHeight: 0,
			  screenMinWidth: 1025
			});
		}
	};	

	var featuredImages = function() {

		$(window).scroll(function() {
		    clearTimeout($.data(this, 'scrollTimer'));
		    $.data(this, 'scrollTimer', setTimeout(function() {
				if (!$('.single .large-thumb').length )
					return;

			    var scrollTop = $(this).scrollTop();

			    var topDistance = $('.large-thumb').offset().top;

			    if ( ( topDistance ) < scrollTop+50 ) {
			       $('.large-thumb').addClass('featured-top');
			    } else {
			       $('.large-thumb').removeClass('featured-top');		        	
			    }
		    }, 100));
		});

	};

	var contentBar = function() {
		function barSizing() {
			var contentWidth = $('.site-content').width();
			var containerWidth = $('.site-content > .container').width();
			var leftBar = $('.left-bar');
			var headerBar = $('.header-bar');
			var barWidth = (contentWidth - containerWidth)/2;

			leftBar.width(barWidth);

		}
		$(document).ready(barSizing);
		$(window).on('resize',barSizing);		
	}

    var responsiveVideo = function(){
		$("body").fitVids();
    };

    var topButton = function(){
		var goTop = $('.top-button span');
		goTop.on('click', function() {
			$("html, body").animate({ scrollTop: 0 }, 1200);
			return false;
		});
	};

    var mobileMenu = function(){
		var	menuType = 'desktop';

		$(window).on('load resize', function() {
			var currMenuType = 'desktop';

			if ( matchMedia( 'only screen and (max-width: 1024px)' ).matches ) {
				currMenuType = 'mobile';
			}

			if ( currMenuType !== menuType ) {
				menuType = currMenuType;

				if ( currMenuType === 'mobile' ) {
					var $mobileMenu = $('#site-navigation').attr('id', 'mainnav-mobi').hide();
					var hasChildMenu = $('#mainnav-mobi').find('li:has(ul)');

					hasChildMenu.children('ul').hide();
					hasChildMenu.children('a').after('<span class="btn-submenu">+</span>');
					$('.btn-menu').removeClass('active');
				} else {
					var $desktopMenu = $('#mainnav-mobi').attr('id', 'site-navigation').removeAttr('style');

					$desktopMenu.find('.submenu').removeAttr('style');
					$('.btn-submenu').remove();
				}
			}
		});

		$('.btn-menu').on('click', function() {
			$('#mainnav-mobi').slideToggle(300);
			$(this).toggleClass('active');
		});

		$(document).on('click', '#mainnav-mobi li .btn-submenu', function(e) {
			$(this).toggleClass('active').next('ul').slideToggle(300);
			e.stopImmediatePropagation()
		});	
	};
    
    var socialTarget = function() {
		$( '.social-navigation li a' ).attr( 'target','_blank' );
	}

    var removePreloader = function() {
		$('.preloader').css('opacity', 0);
		setTimeout(function(){$('.preloader').hide();}, 600);	
    }

	// Dom Ready
	$(function() {
		postsCarousel();
		menuAnimation();		
		stickyWidgets();
		featuredImages();
		contentBar();
		responsiveVideo();
		topButton();
		mobileMenu();
		socialTarget();
		removePreloader();
   	});

})(jQuery);