$(document).ready(function() {
  var confer_window = $(window);
  confer_window.on('load', function() {
    $('#preloader').fadeOut('1000', function() {
      $(this).remove();
    });
  });

  $('#info').on('click', function(e) {
    $('#e-menu').toggle('show');
  });


  if ($('#showModal').length > 0) {
    $('#showModal').on('click', function() {
      $('#myModal').modal();
    });

    $('.ticket--sp').on('click', function() {
      $('#myModal').modal();
    });
  }

  if ($('#editInfo').length > 0) {
    $('#editInfo').on('click', function() {
      $('#infoEditEmail').modal();
    })
  }

  $('.aws').on('click', function(e) {
    var id = $(this).data('id'),
      result = $(this).data('result'),
      url = $('#taskQ').data('url');

    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 1500,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    });

    if (result == 1) {
      Toast.fire({
        icon: 'success',
        title: 'Chính xác 😀'
      })
    } else {
      Toast.fire({
        icon: 'error',
        title: 'Sai rồi 😥'
      })
    }

    setTimeout(function(e) {
      window.location.replace(url);
    }, 1500);
  });

  $('.price-package').on('click', function(e) {
    var price = $(this).data('price'),
      id = $(this).data('id');
    $('#amount').val(price);
    $('#sponsorId').val(id);
    $('#amount').focus();
  });

  $(document).on('click', '#cSponsor', function (event) {
      var type = $(this).data('type'),
      amount = $('#amount').val(),
      url = $(this).data('url'),
      sponsor_id = $('#sponsorId').val(),
      id = $(this).data('id');

      setTimeout(function(e) {
        window.location.replace(url + "?type="+type+"&amount="+amount+'&event_id='+id+'&detail_id='+sponsor_id);
      }, 1000);
  });

  $("#infoForm").validate({
    onfocusout: false,
    onkeyup: false,
    onclick: false,
    rules: {
      "email": {
        required: true,
        email: true
      }
    },
    messages: {
      "email": {
        required: "Vui lòng nhập email",
        email: 'Email không đúng định dạng'
      },
    }
  });


  $('.nav-tabs a').click(function(){
    $(this).tab('show');
  })

  $('.nav-tabs a[href="#session"]').tab('show')
  $('.nav-tabs a:first').tab('show')
  $('.nav-tabs li:eq(0) a').tab('show')
  // $('.nav-tabs a:last').tab('show')

  // var page = 1;
  // $(window).scroll(function() {
  //     if($(window).scrollTop() + $(window).height() >= $(document).height()) {
  //         page++;
  //         loadMoreData(page);
  //     }
  // });

  // function loadMoreData(url, page){
  //   debugger
  //   $.ajax({
  //     url: url + '?page=' + page,
  //     type: "get",
  //     beforeSend: function() {
  //       $('.ajax-load').show();
  //     }
  //   }).done(function(data) {
  //     if(data.html == " "){
  //       $('.ajax-load').html("No more records found");
  //       return;
  //     }
  //     $('.ajax-load').hide();
  //     $("#post-data").append(data.html);
  //   }).fail(function(jqXHR, ajaxOptions, thrownError) {
  //     alert('server not responding...');
  //   });
  // }

  // $('.more-schedule-btn').on('click', function(e) {
  //   var $div = $($(this).data('div'));
  //   var $link = $(this).data('link');
  //   var $page = $(this).data('page');
  //   var $href = $link + $page;
  //   $.get($href, function(response) {
  //     var $html = $(response).find("#boxEvent").html();
  //     $div.append($html);
  //   });

  //   $(this).data('page', (parseInt($page) + 1));



  //   // var page = $(this).data('page'),
  //   //   link = $(this).data('link'),
  //   //   href = link + page,
  //   //   div = $(this).data('div');



  //   // // debugger
  //   // $.get(href, function(r) {
  //   //   // var a =  $('.ev-list').find('#boxEvent').html();
  //   //   var a = $(r).find('#boxEvent').html();
  //   //   div.append(a);

  //   //   // var htmlList = $(r).('.ev-list').find('#boxEvent').html();
  //   //   // var htmlList = $(r).find("#boxEvent").html();
  //   //   debugger
  //   //   // div = $(this).data('div');
  //   // });

  //   // $(this).data('page', 2+1);
  //   // $(this).data('page', (parseInt(page) + 1));
  // });

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
  // $('.jarallax').jarallax({
  //   speed: 0.5
  // });
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
