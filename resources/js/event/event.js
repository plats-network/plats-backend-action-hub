$(document).ready(function() {
  var confer_window = $(window);
  confer_window.on('load', function() {
    $('#preloader').fadeOut('1000', function() {
      $(this).remove();
    });
  });

  var welcomeSlider = $('.welcome-slides');
  welcomeSlider.owlCarousel({
    items: 1,
    loop: true,
    autoplay: false,
    smartSpeed: 1000,
    autoplayTimeout: 10000,
    nav: true,
    navText: [('<i class="fa fa-angle-left"></i>'), ('<i class="fa fa-angle-right"></i>')]
  })

  welcomeSlider.on('translate.owl.carousel', function() {
    var layer = $("[data-animation]");
    layer.each(function() {
      var anim_name = $(this).data('animation');
      $(this).removeClass('animated ' + anim_name).css('opacity', '0');
    });
  });

  $("[data-delay]").each(function() {
    var anim_del = $(this).data('delay');
    $(this).css('animation-delay', anim_del);
  });

  $("[data-duration]").each(function() {
    var anim_dur = $(this).data('duration');
    $(this).css('animation-duration', anim_dur);
  });

  welcomeSlider.on('translated.owl.carousel', function() {
    var layer = welcomeSlider.find('.owl-item.active').find("[data-animation]");
    layer.each(function() {
      var anim_name = $(this).data('animation');
      $(this).addClass('animated ' + anim_name).css('opacity', '1');
    });
  });

  $("#scrollDown").on('click', function() {
    $('html, body').animate({
      scrollTop: $("#about").offset().top - 75
    }, 800);
  });

  var clientArea = $('.client-area');
  clientArea.owlCarousel({
    items: 2,
    loop: true,
    autoplay: true,
    smartSpeed: 1000,
    margin: 40,
    autoplayTimeout: 7000,
    nav: true,
    navText: [('<i class="fa fa-angle-left"></i>'), ('<i class="fa fa-angle-right"></i>')],
    responsive: {
      0: {
        items: 1
      },
      576: {
        items: 1,
        margin: 15
      },
      992: {
        items: 1,
        margin: 20
      },
      1200: {
        items: 1,
        margin: 40
      }
    }
  });
  $('.portfolio-menu button.btn').on('click', function() {
    $('.portfolio-menu button.btn').removeClass('active');
    $(this).addClass('active');
  })
  $('.search-btn').on('click', function() {
    $('.search-form').toggleClass('search-form-active');
  })
  confer_window.on('scroll', function() {
    if (confer_window.scrollTop() > 0) {
      $('.header-area').addClass('sticky');
    } else {
      $('.header-area').removeClass('sticky');
    }
  });
  $('[data-toggle="tooltip"]').tooltip();
  $('.jarallax').jarallax({
    speed: 0.5
  });
  confer_window.scrollUp({
    scrollSpeed: 1000,
    scrollText: '<i class="arrow_carrot-up"</i>'
  });
  $('a[href="#"]').on('click', function($) {
    $.preventDefault();
  });
  var pricingTable = $(".single-ticket-pricing-table");
  pricingTable.on("mouseenter", function() {
    pricingTable.removeClass("active");
    $(this).addClass("active");
  });

  // Menu
  var navContainer = $('.classy-nav-container');
  var classy_nav = $('.classynav ul');
  var classy_navli = $('.classynav > ul > li');
  var navbarToggler = $('.classy-navbar-toggler');
  var closeIcon = $('.classycloseIcon');
  var navToggler = $('.navbarToggler');
  var classyMenu = $('.classy-menu');
  var var_window = $(window);
  var breakpoint = 991;
  var openCloseSpeed = 500;
  var megaopenCloseSpeed = 800;
  var sideMenu = true;

  navbarToggler.on('click', function() {
    navToggler.toggleClass('active');
    classyMenu.toggleClass('menu-on');
  });
  closeIcon.on('click', function() {
    classyMenu.removeClass('menu-on');
    navToggler.removeClass('active');
  });
  classy_navli.has('.dropdown').addClass('cn-dropdown-item');
  classy_navli.has('.megamenu').addClass('megamenu-item');
  classy_nav.find('li a').each(function() {
    if ($(this).next().length > 0) {
      $(this).parent('li').addClass('has-down').append('<span class="dd-trigger"></span>');
    }
  });
  classy_nav.find('li .dd-trigger').on('click', function(e) {
    e.preventDefault();
    $(this).parent('li').children('ul').stop(true, true).slideToggle(openCloseSpeed);
    $(this).parent('li').toggleClass('active');
  });
  $('.megamenu-item').removeClass('has-down');
  classy_nav.find('li .dd-trigger').on('click', function(e) {
    e.preventDefault();
    $(this).parent('li').children('.megamenu').slideToggle(megaopenCloseSpeed);
  });

  function breakpointCheck() {
    var windoWidth = window.innerWidth;
    if (windoWidth <= breakpoint) {
      navContainer.removeClass('breakpoint-off').addClass('breakpoint-on');
    } else {
      navContainer.removeClass('breakpoint-on').addClass('breakpoint-off');
    }
  }
  breakpointCheck();
  var_window.on('resize', function() {
    breakpointCheck();
  });
  if (sideMenu === true) {
    navContainer.addClass('sidebar-menu-on').removeClass('breakpoint-off');
  }
});
