//============= owl slider =============
$(document).ready(function() {
    $('.owl-one').owlCarousel({
        loop: false,
        margin: 0,
        nav: true,
        dots: false,
        autoplay: false,
        slideSpeed: 6000,
        autoplayTimeout: 5000,
        autoplaySpeed: 6000,
        autoplayHoverPause: true,
        navText: [
            '<span aria-label="' + 'Previous' + '"><i class="far fa-arrow-left"></i></span>',
            '<span aria-label="' + 'Next' + '"><i class="far fa-arrow-right"></i></span>'
        ],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            690: {
                items: 1
            },
            768: {
                items: 1
            },
            960: {
                items: 1
            },
            1025: {
                items: 1
            }
        }
    });

    $('.owl-two').owlCarousel({
        loop: false,
        margin: 15,
        nav: true,
        dots: false,
        autoplay: true,
        slideSpeed: 6000,
        autoplayTimeout: 5000,
        autoplaySpeed: 6000,
        autoplayHoverPause: true,
        navText: [
            '<span aria-label="' + 'Previous' + '"><i class="far fa-arrow-left"></i></span>',
            '<span aria-label="' + 'Next' + '"><i class="far fa-arrow-right"></i></span>'
        ],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            690: {
                items: 3
            },
            768: {
                items: 3
            },
            960: {
                items: 4
            },
            1025: {
                items: 4
            }
        }
    });
	$('.owl-three').owlCarousel({
        loop: false,
        margin: 0,
        nav: false,
        dots: true,
        autoplay: false,
        slideSpeed: 6000,
        autoplayTimeout: 5000,
        autoplaySpeed: 6000,
        autoplayHoverPause: true,
        navText: [
            '<span aria-label="' + 'Previous' + '"><i class="far fa-arrow-left"></i></span>',
            '<span aria-label="' + 'Next' + '"><i class="far fa-arrow-right"></i></span>'
        ],
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 1
            },
            690: {
                items: 1
            },
            768: {
                items: 1
            },
            960: {
                items: 1
            },
            1025: {
                items: 1
            }
        }
    });
});

//stellarnav
jQuery(document).ready(function($) {
    jQuery('.stellarnav').stellarNav({
        theme: 'dark',
        breakpoint: 1023,
        position: 'right',
        phoneBtn: '',
        locationBtn: ''
    });
});

//============= slick slider =============

//Main Banner Start
$('.slider').slick({
    draggable: true,
    arrows: false,
    dots: true,
    fade: true,
    autoplay: true,
    autoplaySpeed: 5000,
    speed: 1000,
    infinite: true,
    cssEase: 'cubic-bezier(0.7, 0, 0.3, 1)',
    touchThreshold: 100
});

$('.Testimonial').slick({
    draggable: true,
    arrows: false,
    dots: true,
    autoplay: true,
    autoplaySpeed: 5000,
    speed: 1000,
    infinite: true,
});

//sticky Header //
// $(window).scroll(function() {
//     var scroll = $(window).scrollTop();

//     if (scroll >= 100) {
//         $(".site-header").addClass("sticky");
//     } else {
//         $(".site-header").removeClass("sticky");
//     }
// });

var lastScrollTop = 0;
$(window).scroll(function(event){
   var st = $(this).scrollTop();

    if (st > lastScrollTop)
    {
        $(".site-header").removeClass("sticky");
    }
    else
    {
        $(".site-header").addClass("sticky");
    }

    if(parseInt(st) <= 0)
    {
        $(".site-header").removeClass("sticky");
    }

   lastScrollTop = st;
});

$('.continue').click(function() {
    $('.nav-tabs > .active').next('li').find('a').trigger('click');
});

$('.back').click(function() {
    $('.nav-tabs > .active').prev('li').find('a').trigger('click');
});

$("#btn-receitamob").click(function() {
    $("#receita-div").slideToggle(1500, function() {});
    $(this).find("i").toggleClass("fa-chevron-double-down fa-chevron-double-up");
});

$("#btn-receitamob").click(function() {
    $(this).find("span").toggleClass("custom-scroll-link custom-scroll-link-up");
});

$(document).ready(function() {
    $('[data-toggle=search-form]').click(function() {
        $('.search-form-wrapper').toggleClass('open');
        $('.search-form-wrapper .search').focus();
        //$('html').toggleClass('search-form-open');
    });

    $('[data-toggle=search-form-close]').click(function() {
        $('.search-form-wrapper').removeClass('open');
        //$('html').removeClass('search-form-open');
    });

    $('.search-form-wrapper .search').keypress(function(event) {
        if ($(this).val() == "Search") $(this).val("");
    });

    $('.search-close').click(function(event) {
        $('.search-form-wrapper').removeClass('open');
        //$('html').removeClass('search-form-open');
    });

    $('.header-sec-link').click(function() {
        $('.HeaderTextarea').slideToggle("fast");
    });

	$('#showall').click(function() {
        $('.allmenu').toggle("slide");
    });

    $('.radioshow').on('change', function() {
        var val = $(this).attr('data-class');
        $('.allshow').hide();
        $('.' + val).show();
    });

	// Show/Hide Password on signup/profile
	$('#show-password').click(function(){

		if($(this).is(':checked'))
		{
			$('#password').attr('type', 'text');
			$('#password_confirmation').attr('type', 'text');
		}
		else
		{
			$('#password').attr('type', 'password');
			$('#password_confirmation').attr('type', 'password');
		}
	});

    // Show/Hie Footer
    $("#ShowFooter").click(function () {
        if ($('.footer').is(':hidden')) {
            $('.footer').show();
            $(this).css('color', '#666');
        } else {
            $('.footer').hide();
            $(this).css('color', '#007fff');
        }
    });

    $(function(){
        $(document.body).on('show.bs.modal', function () {
            $(window.document).find('html').addClass('modal-open');
        });
        $(document.body).on('hide.bs.modal', function () {
            $(window.document).find('html').removeClass('modal-open');
        });
    });
});