jQuery(document).ready(function($) {
    
    setTimeout(function(){
        $('body').addClass('loaded');
    }, 3000);

    $(window).scroll(function(){
      var sticky = $('.sticky'), scroll = $(window).scrollTop();
      if (scroll >= 100){
        sticky.addClass('fixed');
      }else{
        sticky.removeClass('fixed');
      }
    });

    $('.toggle-nav').click(function (e) {
      e.stopPropagation();
      toggleNav();
    });

    function toggleNav(){
      if( $('.btn-hamburger').hasClass('is-active') ){
        $('.btn-hamburger').removeClass('is-active');
      }else {
        $('.btn-hamburger').addClass('is-active');
      }
    }

    // Hide Header on on scroll down
    var didScroll;
    var lastScrollTop = 0;
    var delta = 5;
    var navbarHeight = $('header').outerHeight();

    $(window).scroll(function(){
        didScroll = true;
    });

    setInterval(function() {
        if (didScroll) {
            hasScrolled();
            didScroll = false;
        }
    }, 250);

    function hasScrolled() {
        var st = $(this).scrollTop();
        
        if(Math.abs(lastScrollTop - st) <= delta){
        return;
        }
        
        if (st > lastScrollTop && st > navbarHeight){
            $('header').removeClass('nav-down').addClass('nav-up');
        } else {
            if(st + $(window).height() < $(document).height()) {
                $('header').removeClass('nav-up').addClass('nav-down');
            }
        }
        
        lastScrollTop = st;
    }

    function slideDownDivaMenu(){
      $(this).find('ul').slideDown();
    }

    function slideUpDivaMenu(){
      $(this).find('ul').slideUp();
    }

    $('.menu-filter-type ul').hoverIntent({
        over: slideDownDivaMenu,
        out: slideUpDivaMenu,
        interval: 200,
        selector: 'li'
    });

    $('.open-menu').click(function(e){
        e.preventDefault();
        $('.open-menu').toggleClass('open');
        if ( $(this).hasClass('filter-type-menu') ) {
          $('html').toggleClass('menu-is-open-filter-type');
          $('.menu-filter-type').toggleClass('open');
        } else {
          $('html').toggleClass('menu-is-open');
        }
    });

    $('.menu-filter-type .close-menu').click(function() {
        setTimeout(function(){
            $('.menu-filter-type').toggleClass('open');
            $('.open-menu').toggleClass('open');
            $('.btn-hamburger').removeClass('is-active');
        },150);
    });

    $(document).on('click', 'a[href*="#"]:not([href="#"])', function(e) {
        if (location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                e.preventDefault();
            }
        }
    });

});