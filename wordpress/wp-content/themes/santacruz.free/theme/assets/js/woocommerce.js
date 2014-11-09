
jQuery( document ).ready( function( $ ) {

    // grid hover
    $('ul.products').on('hover', 'li.add-hover.grid:not(.category)', function(e){
        var $this_item = $(this),
            to,
            image_height = $(this).find('a.thumb').height();

        if(e.type == 'mouseenter') {
            if ( !$this_item.hasClass('product-category') ) {
                $this_item.height( $this_item.outerHeight() );
            }
            else {
                $this_item.height( $this_item.outerHeight() - 2 );
            }


            $this_item.find('.product-meta-wrapper').css('height', '').height( $this_item.find('.product-meta-wrapper').height() );
            if ( $('html').attr('id') == 'ie8' || $('html').attr('id') == 'ie9' ) {
                $this_item.addClass('js_hover');
            }

//            var meta_offset = Math.abs( $this_item.find('.grid-add-to-cart').offset().top - $this_item.find('.product-meta').offset().top );
//            $this_item.find('.grid-add-to-cart').hide();
//            $this_item.find('a.thumb').height( image_height - meta_offset).css('overflow', 'hidden');


            clearTimeout(to);

        } else if ( e.type == 'mouseleave' ) {
            if ( $('html').attr('id') == 'ie8' || $('html').attr('id') == 'ie9' ) {
                $this_item.removeClass('js_hover');
            }
            $this_item.find('.product-meta-wrapper').height( 0 );
//            $this_item.find('a.thumb').css( 'height', '' );
//            $this_item.find('.grid-add-to-cart').show();
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
        if(typeof woocommerce_params.plugin_url != 'undefined'){
            product.find('.product-wrapper').block({message: null, overlayCSS: {background: '#fff url(' + woocommerce_params.plugin_url + '/assets/images/ajax-loader.gif) no-repeat center', opacity: 0.3, cursor:'none'}});
        }else{

            product.find('.product-wrapper').block({message: null, overlayCSS: {background: '#fff url(' + woocommerce_params.ajax_loader_url +') no-repeat center', opacity: 0.3, cursor:'none'}});
        }

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

    /* fix next prev height */
    function checkPrevNextHeight(slider){

        var product_wrapper = $(slider).find('li a img');

        var div_height = ((product_wrapper.height()==0 || product_wrapper.height()==null) ? 220 : product_wrapper.height())  +3;
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

        var carouFredSelOptions_defaults = {
            responsive: false,
            auto: true,
            items: 1,
            direction: 'left',
            align : 'left',
            circular: true,
            infinite: true,
            debug: false,
            prev: '.es-nav .es-nav-prev',
            next: '.es-nav .es-nav-next',
            swipe: {
                items : 1,
                onTouch: true
            },
            scroll  : {
                onAfter : function(item) {

                    checkPrevNextHeight(item.items.new.parents(".products-slider-wrapper"));
                }
            }
        };

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

                    /* fix next prex height */
                    checkPrevNextHeight(this);

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

                        checkPrevNextHeight(t);
                    });
                }
            });
        });
        $('.es-nav-prev, .es-nav-next').removeClass('hidden').show();
    }

    //shop sidebar
    $('#sidebar-shop-sidebar .widget h3').prepend('<div class="minus">-</div>');
    $('#sidebar-shop-sidebar .widget').on('click', 'h3', function(){
        $(this).parent().find('> *:not(h3)').slideToggle();

        if( $(this).find('div').hasClass('minus') ) {
            $(this).find('div').removeClass('minus').addClass('plus').text('+');
        } else {
            $(this).find('div').removeClass('plus').addClass('minus').text('-');
        }
    });


    //cart dropdown
    $('.shop_table_shipping th, .shop_table_coupon th').on('click', function(e){
        e.preventDefault();

        $('.shipping-calculator-form').show();

        tbody = $(this).parents('table').find('tbody td');
        tbody.slideToggle();
    });


    //IE8 double border
    var selectors = $('table.shop_table.cart', '#ie8,#ie9');
    if( selectors.length > 0 ) {
        selectors.each(function(){
            $(this).wrap('<div class="ie_border"></div>');
        });
    }
});