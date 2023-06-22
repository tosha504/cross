
( function () {
  console.log('ready');
  const burger = jQuery( '.header__burger span' ),
  body = jQuery( 'body' ),
  nav = jQuery( '.header__mobile' );

  burger.on( 'click', function ( ) {
    burger.toggleClass( 'active' );
    nav.toggleClass( 'active' );
    body.toggleClass( 'fixed-page' );
  });

  jQuery(window).scroll(function() {
    var scrollTop = jQuery(window).scrollTop();
    if ( scrollTop > 40 ) { 
      jQuery('header')
      jQuery('.header__logo a img.normal').removeClass('active');
      jQuery('.header__logo a img.sticky').addClass('active');
    } else {
      jQuery('.header__logo a img.normal').addClass('active');
      jQuery('.header__logo a img.sticky').removeClass('active');
    }

    if(jQuery('.summary.entry-summary')) {
      jQuery('.summary.entry-summary').css({'top':`${document.querySelector(".header").clientHeight + 20}px`, 'z-index':'90'})
    }
  });
   
  function mobNavMenu() {
    jQuery( '.header__arrow-link' ).on('click', function (e) {
      e.preventDefault()
      jQuery(this).parent().siblings('ul .sub-menu').slideToggle( 700 );

      if( !jQuery( e.target ).hasClass( 'active' ) ) {
        jQuery( e.target ).addClass( 'active' )
      } else {
        jQuery( e.target ).removeClass( 'active' )
      }
    })
  }

  if(jQuery(window).width() < 1200) {
    mobNavMenu();
  } 

  jQuery(document).on("click", '.cart-qty', function (e) {
    e.preventDefault();
    if(jQuery(body).hasClass('woocommerce-checkout')) {
     jQuery('.cart-qty').attr('disabled', 'disabled');
    }
    const input  =  jQuery(this).parent().find('.input-text.qty.text');
    const input_val = parseInt(input.val());
    if (jQuery(this).hasClass('plus')) {
      input.val(input_val + 1);
      input.attr('value',input_val + 1)
    }
    else {
      const new_val = input_val - 1;
      if (new_val > 0) {
        input.val(input_val - 1);
        input.attr('value',input_val - 1)
      }
    }

    input.trigger("change");
  });

 
  let timeout;
  jQuery('.woocommerce').on('change', 'input.qty', function(){
    if ( timeout !== undefined ) {
        clearTimeout( timeout );
    }
    
    timeout = setTimeout(function() {
      jQuery("[name='update_cart']").trigger("click"); // trigger cart update
    }, 100 ); // 1 second delay, half a second (500) seems comfortable too
    
  });

  jQuery('.variation-button').click(function(e) {
    jQuery(e.target).addClass('active')
    if(jQuery(e.target).siblings().hasClass('active')) {
      jQuery(this).siblings().removeClass('active')
    }
    
    var attribute = jQuery(this).data('attribute');
    var value = jQuery(this).data('value');

    jQuery('select[id="' + attribute + '"]').val(value).change();
  });

  jQuery('.reset_variations').on('click', function (e) {
    jQuery('.variation-button').removeClass('active')
  })

  jQuery('.cartsfsd').on('click', function (e) {
    e.preventDefault()
    jQuery('.xoo-wsc-modal').addClass('xoo-wsc-cart-active')
  })

  jQuery('.select__item').click(function(e){
    e.preventDefault();
    if(!jQuery(this).hasClass('button__primary')){
      jQuery('.col-1, .col-2').toggleClass('d-none');
      jQuery(e.target).addClass('button__primary').removeClass('button__secondary'); 
      if(jQuery(e.target).siblings().hasClass('button__primary')) {
        jQuery(e.target).siblings().removeClass('button__primary').addClass('button__secondary');
      }
    }
  });

  console.log( jQuery('.letters li a'));

  jQuery('.letters li a').on('click', function (e) {
    console.log(e);
  })
  
  jQuery('.result__wrap-btn a').on('click', function (e) {
    e.preventDefault()
    var scrollTop = jQuery(window).scrollTop();
    if(scrollTop > 200)
    jQuery("html, body").animate({ scrollTop:  document.body.scrollTop = 0 }, 1500);
  });

})( jQuery );