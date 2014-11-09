// ==ClosureCompiler==
// @output_file_name default.js
// @compilation_level SIMPLE_OPTIMIZATIONS
// ==/ClosureCompiler==

jQuery( document ).ready( function( $ ) {

    // grid hover
    $('ul.products').on('hover', 'li.add-hover.grid:not(.category)', function(e){
        var $this_item = $(this), to;

        if(e.type == 'mouseenter') {

            if ( !$this_item.hasClass('product-category') ) {
                $this_item.height( $this_item.outerHeight() - 1 );
            }
            else {
                $this_item.height( $this_item.outerHeight() - 3 );
            }

            $this_item.find('.product-meta-wrapper').css('height', '').height( $this_item.find('.product-meta-wrapper').height() );
            if ( $('html').attr('id') == 'ie8' || $('html').attr('id') == 'ie9' ) {
                $this_item.addClass('js_hover');
            }
            clearTimeout(to);

        } else if ( e.type == 'mouseleave' ) {
            if ( $('html').attr('id') == 'ie8' || $('html').attr('id') == 'ie9' ) {
                $this_item.removeClass('js_hover');
            }
            $this_item.find('.product-meta-wrapper').height( 0 );
            to = setTimeout(function()
            {
                $this_item.css( 'height', 'auto' );
            },700);
        }
    });


    // hover opacity
    $(document).on('hover', '.content ul.products li:not(.list):not(.classic)', function(e){
        var ul = $('ul.products');
        if(e.type == 'mouseenter') {
            ul.children().not(this).stop(true, false).animate({opacity:0.6}, 300);

        } else if ( e.type == 'mouseleave' ) {
            ul.children().not(this).delay(10).animate({opacity:1}, 300);
        }
    });

    $(document).on('hover', 'ul.products li', function(e){
        if(e.type == 'mouseenter') {
            var img = $(this).find('img.image-hover');
            if ( img.length > 0 ) img.css({'display':'block', opacity:0}).animate({opacity:1}, 400);

        } else if ( e.type == 'mouseleave' ) {
            var img = $(this).find('img.image-hover');
            if ( img.length > 0 ) img.animate({opacity:0}, 400);
        }
    });

    var add_hover = function(){
        if ( $(window).width() < 768 ) {
            $('ul.products li.product.open-on-mobile:not(.force-open)').removeClass('add-hover');
        } else {
            $('ul.products li.product.open-on-mobile:not(.force-open):not(.add-hover)').addClass('add-hover');
        }
    };
    add_hover();
    $(window).resize(add_hover);

    
    // add to cart
    var product;
    $('ul.products').on( 'click', 'li.product .add_to_cart_button', function(){
        product = $(this).parents('li.product');
        product.find('.product-wrapper').block({message: null, overlayCSS: {background: '#fff url(' + woocommerce_params.plugin_url + '/assets/images/ajax-loader.gif) no-repeat center', opacity: 0.3, cursor:'none'}});
        $('.widget.woocommerce.widget_shopping_cart a.cart_control').show();
        $('.widget.woocommerce.widget_shopping_cart a.cart_control.cart_control_empty').remove();
    });
    $('body').on( 'added_to_cart', function(){
        if ( product.find('.product-wrapper > .added').length == 0 ) {
            product.find('.product-wrapper').append('<span class="added">added</span>');
            product.find('.added').fadeIn(500);
            product.find('.product-wrapper .grid-add-to-cart .add_to_cart_button').addClass('added');
        }
        product.find('.product-wrapper').unblock();
    });

    // variations select
    if( $.fn.selectbox !== undefined ) {
        var form = $('form.variations_form');
        var select = form.find('select');

        form.find('select').selectbox({
            effect: 'fade',
            onOpen: function() {       //console.log('open');
                //$('.variations select').trigger('focusin');
            }
        });

        var update_select = function(event){  // console.log(event);
            form.find('select').selectbox("detach");
            form.find('select').selectbox("attach");
        };

        // fix variations select
        form.on( 'woocommerce_update_variation_values', update_select);
        form.find('.reset_variations').on('click', update_select);
    }

    var carouFredSelOptions_defaults = {
        responsive: false,
        auto: false,
        items: 4,
        circular: true,
        infinite: true,
        debug: false,
        prev: '.es-nav .es-nav-prev',
        next: '.es-nav .es-nav-next',
        swipe: {
            onTouch: true
        },
        scroll  : {
            items     : 1,
            pauseOnHover: true,
            onAfter : function(item) {
                checkPrevNextHeight(item.items.new.parents(".products-slider-wrapper"));
            }
        }
    };



    /* fix next prev height */
    function checkPrevNextHeight(slider){
        var produt_wrapper = $(slider).find('.product-wrapper a');
        var div_height = produt_wrapper.height()+3;
        var prev = $(slider).find('.es-nav.prev') ;

        if(prev!=null){
            prev.height(div_height);
        }

        var next = $(slider).find('.es-nav.next');
        if(next!=null){
            next.height(div_height);
        }

    }



    if( $.fn.carouFredSel ) {
        $('.products-slider-wrapper').each(function(){
            $(this).imagesLoaded(function(){
                var t = $(this);
                var items = carouFredSelOptions_defaults.items;

                if( $(this).parents('.border-box').length == 0) {
                    var carouFredSel;

                    var prev = $(this).find('.es-nav-prev').show();
                    var next = $(this).find('.es-nav-next').show();

                    carouFredSelOptions_defaults.prev = prev;
                    carouFredSelOptions_defaults.next = next;


                    if( $('body').outerWidth() <= 767 ) {
                        t.find('li').each(function(){
                            $(this).width( t.width() );
                        });

                        carouFredSelOptions_defaults.items = 1;
                    } else {
                        t.find('li').each(function(){
                            $(this).attr('style', '');
                        });

                        carouFredSelOptions_defaults.items = items;
                    }

                    carouFredSel = $(this).find('.products').carouFredSel( carouFredSelOptions_defaults );

                    $(window).resize(function(){
                        carouFredSel.trigger('destroy', false).attr('style','');

                        if( $('body').outerWidth() <= 767 ) {
                            t.find('li').each(function(){
                                $(this).width( t.width() );
                            });

                            carouFredSelOptions_defaults.items = 1;
                        } else {
                            t.find('li').each(function(){
                                $(this).attr('style', '');
                            });

                            carouFredSelOptions_defaults.items = items;
                        }

                        carouFredSel.carouFredSel(carouFredSelOptions_defaults);
                    });
                }
            });
        });
        $('.es-nav-prev, .es-nav-next').removeClass('hidden').show();
    }

    //shop sidebar
    $('#sidebar-shop-sidebar .widget h3').prepend('<div class="minus" />');
    $('#sidebar-shop-sidebar .widget').on('click', 'h3', function(){
        $(this).parent().find('> *:not(h3)').slideToggle();

        if( $(this).find('div').hasClass('minus') ) {
            $(this).find('div').removeClass('minus').addClass('plus');
        } else {
            $(this).find('div').removeClass('plus').addClass('minus');
        }
    });



    //IE8 double border
    var selectors = $('table.shop_table.cart', '#ie8,#ie9');
    if( selectors.length > 0 ) {
        selectors.each(function(){
            $(this).wrap('<div class="ie_border"></div>');
        });
    }
});