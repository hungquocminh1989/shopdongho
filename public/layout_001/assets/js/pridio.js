$(document).ready(function () {	
    $('.bypostauthor .comment-wrap .comment-author .qtv').show();
    
    var width1 = $('body').width();
	if(width1 > 768) {
		$('li.dropdown').hover(function () {
			$(this).children('.dropdown-menu').stop(true, false, true).slideToggle(400);
		});
	}
    
    $('.product__gallery__slide__bottom').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 130,
        itemMargin: 5,
        asNavFor: '.product__gallery__slide__top'
    });

    $('.product__right__color__item').click(function() {
        $('.product__right__color__item').removeClass('active');
        $(this).addClass('active');
        var data__price = $(this).attr('data-price');
        if(data__price == '' || data__price == 'Liên hệ') {
			data__price = 'Liên hệ';
		} else {
	        data__price = data__price.replace(/[.]/g, '');
	        data__price = parseInt(data__price);
    	}
		if ($('.product__right__color__item__1.active')[0]) {
			var data_price_color = parseInt($('.product__right__color__item__1.active').attr('data-price-color'));
		} else {
			var data_price_color = 0;
		}
        data_price = data__price + data_price_color;
        if(data__price == 'Liên hệ') {
        	$('.product__right__price__new').html('Liên hệ');
        	$('.product__right__price__old').hide();
        } else {
        	$('.product__right__price__new').html(data_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+' VND');
            $('.product__right__price__old').hide();
        }
    });

    $('.product__right__color__1').children().click(function() {
        $('.product__right__color__1').children().removeClass('active');
        $(this).addClass('active');
        var data_price_color = parseInt($(this).attr('data-price-color'));
        if($('.product__right__color__item.active')[0]) {
        	var data__price_1 = $('.product__right__color__item.active').attr('data-price');
	        data__price_1 = data__price_1.replace(/[.]/g, '');
	        if(data__price_1 == '' || data__price_1 == 'Liên hệ') {
				data__price_1 = 'Liên hệ';
			} else {
		        data__price_1 = data__price_1.replace(/[.]/g, '');
		        data__price_1 = parseInt(data__price_1);
	    	}
        } else {
        	var data__price_1 = 0;
        }
        
        var data_price = data__price_1 + data_price_color;
        if(data__price_1 == 'Liên hệ') {
        	$('.product__right__price__new').html('Liên hệ');
        	$('.product__right__price__old').hide();
        } else {
        	$('.product__right__price__new').html(data_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+' VND');
            $('.product__right__price__old').hide();
        }
    });
    
    var ajaxurl = "http://mistore.com.vn/wp-admin/admin-ajax.php";
    $('.product__right__button__cart__heading').click(function() {
        var product_id      = $(this).attr('data-id');
        var product_name    = $('.product__right__name').html();
        var product_image   = $(this).attr('data-image');
        var product_price   = $('.product__right__price span').html();
        var product_color   = $('.product__right__color__item.active').html();
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            crossDomain: true,
            data: {
                "action": "add_cart",
                product_id: product_id,
                product_name: product_name,
                product_image: product_image,
                product_price: product_price,
                product_color: product_color,
            },
            dataType : 'json',
            success: function (response) {
                var trs = '';
                $.each(response, function (i, val) {
                    trs += '<tr><td><img class="img-responsive" src="'+val.product_image+'"></td><td>'+val.product_name+'</td><td>'+val.quantity+'</td><td>'+val.product_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'</td><td><a class="del-product" data-id="'+i+'"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td></tr>';
                });
                $('.cart-table tbody').html(trs).trigger('change');
                
                var total = 0;
                $.each(response, function (i, val) {
                    var price = parseInt(val.product_price);
                    total = total+price ;
                });
                $('.total span').html(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")).trigger('change');
                
                var p = '';
                $.each(response, function(i, val) {
                    p += 'SP: '+val.product_name+'- Màu: '+val.product_color+'- Số lượng: '+val.quantity+'- Giá: '+val.product_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'---';
                });
                $('span.product textarea').html(p+'Tổng tiền: '+total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")).trigger('change');
            }
        });
    });
    
    $(".cart-table").on("click",".del-product", function(){
        var product_id = $(this).attr('data-id');
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            crossDomain: true,
            data: {
                "action": "del_product",
                product_id: product_id
            },
            dataType : 'json',
            success: function (response) {
                var trs = '';
                $.each(response, function (i, val) {
                    trs += '<tr><td><img class="img-responsive" src="'+val.product_image+'"></td><td>'+val.product_name+'</td><td>'+val.quantity+'</td><td>'+val.product_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'</td><td><a class="del-product" data-id="'+i+'"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td></tr>';
                });
                $('.cart-table tbody').html(trs).trigger('change');
                
                var total = 0;
                $.each(response, function (i, val) {
                    var price = parseInt(val.product_price);
                    total = total+price ;
                });
                $('.total span').html(total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")).trigger('change');
                
                var p = '';
                $.each(response, function(i, val) {
                    p += 'SP: '+val.product_name+'- Màu: '+val.product_color+'- Số lượng: '+val.quantity+'- Giá: '+val.product_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'---';
                });
                $('span.product textarea').html(p+'Tổng tiền: '+total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")).trigger('change');
            }
        });
    });
    
    $('#cart__modal .wpcf7').hide();
    $('span.product textarea').hide();

    $('.product__right__button__dh__heading').click(function () {
        var product_hide = $('.product__right__name').html();
        var color = $('.product__right__color__item.active').html();
        var total = $('.product__right__price span').html();
        $('span.product textarea').html(product_hide+' Màu: '+color+' Tổng tiền: '+total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    });


    var owl4 = $("#owl-right");
    owl4.owlCarousel({
        navigation: true,
        navigationText : ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
        pagination: false,
        singleItem: true,
        slideSpeed : 200,
        autoPlay: 4000
    });

    if(width1 < 1025) {
        $('.header__bottom__menu').hide();
        $('.header__middle__menu__item').click(function() {
            $('.header__bottom__menu').slideToggle();
        });
    }

    $('.product__bottom__left__tab__content__viewmore').click(function() {
    	$('.product__bottom__left__tab__content__viewmore').hide();
    	$('#dacdiem').css('height', 'auto');
    });

    $('.link__fanpage').click(function () {
    	$('.fanpage__iframe').slideToggle();
    });

});