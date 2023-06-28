function _readOnlyError(name) { throw new TypeError("\"" + name + "\" is read-only"); }
(function () {
  console.log('ready');
  var burger = jQuery('.header__burger span'),
    body = jQuery('body'),
    nav = jQuery('.header__mobile'),
    scroll_brand_btn = jQuery('a.scroll'),
    hash = window.location.hash;
  burger.on('click', function () {
    burger.toggleClass('active');
    nav.toggleClass('active');
    body.toggleClass('fixed-page');
  });
  jQuery(window).scroll(function () {
    var scrollTop = jQuery(window).scrollTop();
    if (scrollTop > 40) {
      jQuery('header');
      jQuery('.header__logo a img.normal').removeClass('active');
      jQuery('.header__logo a img.sticky').addClass('active');
    } else {
      jQuery('.header__logo a img.normal').addClass('active');
      jQuery('.header__logo a img.sticky').removeClass('active');
    }
    if (jQuery('.summary.entry-summary')) {
      jQuery('.summary.entry-summary').css({
        'top': "".concat(document.querySelector(".header").clientHeight + 20, "px"),
        'z-index': '90'
      });
    }
  });
  function mobNavMenu() {
    jQuery('.header__arrow-link').on('click', function (e) {
      e.preventDefault();
      jQuery(this).parent().siblings('ul .sub-menu').slideToggle(700);
      if (!jQuery(e.target).hasClass('active')) {
        jQuery(e.target).addClass('active');
      } else {
        jQuery(e.target).removeClass('active');
      }
    });
  }
  if (jQuery(window).width() < 1200) {
    mobNavMenu();
  }
  jQuery(document).on("click", '.cart-qty', function (e) {
    e.preventDefault();
    if (jQuery(body).hasClass('woocommerce-checkout')) {
      jQuery('.cart-qty').attr('disabled', 'disabled');
    }
    var input = jQuery(this).parent().find('.input-text.qty.text');
    var input_val = parseInt(input.val());
    if (jQuery(this).hasClass('plus')) {
      input.val(input_val + 1);
      input.attr('value', input_val + 1);
    } else {
      var new_val = input_val - 1;
      if (new_val > 0) {
        input.val(input_val - 1);
        input.attr('value', input_val - 1);
      }
    }
    input.trigger("change");
  });
  var timeout;
  jQuery('.woocommerce').on('change', 'input.qty', function () {
    if (timeout !== undefined) {
      clearTimeout(timeout);
    }
    timeout = setTimeout(function () {
      jQuery("[name='update_cart']").trigger("click"); // trigger cart update
    }, 100); // 1 second delay, half a second (500) seems comfortable too
  });

  jQuery('.variation-button').click(function (e) {
    jQuery(e.target).addClass('active');
    if (jQuery(e.target).siblings().hasClass('active')) {
      jQuery(this).siblings().removeClass('active');
    }
    var attribute = jQuery(this).data('attribute');
    var value = jQuery(this).data('value');
    jQuery('select[id="' + attribute + '"]').val(value).change();
  });
  jQuery('.reset_variations').on('click', function (e) {
    jQuery('.variation-button').removeClass('active');
  });
  jQuery('.cartsfsd').on('click', function (e) {
    e.preventDefault();
    jQuery('.xoo-wsc-modal').addClass('xoo-wsc-cart-active');
  });
  jQuery('.select__item').click(function (e) {
    e.preventDefault();
    if (!jQuery(this).hasClass('button__primary')) {
      jQuery('.col-1, .col-2').toggleClass('d-none');
      jQuery(e.target).addClass('button__primary').removeClass('button__secondary');
      if (jQuery(e.target).siblings().hasClass('button__primary')) {
        jQuery(e.target).siblings().removeClass('button__primary').addClass('button__secondary');
      }
    }
  });
  scroll_brand_btn.on('click', function (e) {
    var target = jQuery(this).attr('href');
    jQuery(e.target).addClass('active');
    if (jQuery(e.target).parent().siblings().children().hasClass('active')) {
      jQuery(e.target).parent().siblings().children().removeClass('active');
    }
    ;
    jQuery("html, body").animate({
      scrollTop: jQuery(target).offset().top - jQuery(".header").height() * 2
    }, 1000);
  });
  jQuery('.result__wrap-btn').on('click', function (e) {
    var scrollTop = jQuery(window).scrollTop();
    if (scrollTop > 40) jQuery("html, body").animate({
      scrollTop: document.body.scrollTop = 0
    }, 1000, function () {
      if (window.history.replaceState) {
        scroll_brand_btn.removeClass('active');
        window.history.replaceState(null, null, window.location.href.split('#')[0]);
      } else {
        '', _readOnlyError("hash");
      }
    });
  });
  if (jQuery(window).width() < 768) {
    jQuery('.result__content').css('display', 'none');
    jQuery('.result__title').on('click', function (e) {
      jQuery(this).toggleClass('active').siblings('ul').slideToggle();
      if (jQuery(this).parent().siblings().children('.result__title').hasClass('active')) {
        jQuery(this).parent().siblings().children('.result__title').removeClass('active');
        jQuery(this).parent().siblings().children('ul').slideUp();
      }
    });
  }
  if (hash) {
    if (jQuery(window).width() < 768) {
      var p = function p(hash) {
        jQuery(hash).children('.result__title').addClass('active');
        jQuery(hash).children('ul').slideDown();
      };
      jQuery("html, body").animate({
        scrollTop: jQuery(hash).offset().top - jQuery(".header").height() - 20,
        "function": p(hash)
      }, 1000);
    } else {
      jQuery("html, body").animate({
        scrollTop: jQuery(hash).offset().top - jQuery(".header").height() * 2
      }, 1000);
      scroll_brand_btn.each(function () {
        var a_href = jQuery(this).attr('href');
        console.log(a_href == hash);
        if (a_href == hash) {
          jQuery(this).addClass('active');
        }
      });
    }
  }
  jQuery('.letters').css({
    'top': "".concat(jQuery(".header").height() + 10, "px"),
    'z-index': '1'
  });
})(jQuery);
