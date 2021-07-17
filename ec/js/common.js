function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function createCookie(name, value, hours) {
    if (hours) {
        var date = new Date();
        date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    } else var expires = "";
    document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}


function readCookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}


function eraseCookie(name) { createCookie(name, "", -1); }

function listCookies() {
    var theCookies = document.cookie.indexOf('compare').split(';');
    var aString = '';
    for (var i = 1; i <= theCookies.length; i++) {
        aString += i + ' ' + theCookies[i - 1] + "\n";
    }
    return aString;
}


function numberWithCommas(number) {
    var parts = number.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}


function renderCart() {
    var numb = 0;
    var getCurrentCart = JSON.parse(localStorage.getItem('minicart'));
    var i = 0;
    $.each(getCurrentCart,function (index){
        numb += Number(getCurrentCart[index]['quantity']);
    });
    $('.js-numbCart').html(numb);
}


$('#list-products').on('click', '.js-button', function() {
    var $button = $(this);
    var oldValue = $button.parent().find(".quantity").val();
    $('.addToCart').removeClass('disable');
    $('.addToCart').html('Add to cart');
    if ($button.attr("rel") == 'desc') {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }
    $button.parent().find(".quantity").val(newVal);
});



Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

// Get the size of an object
var sizeCart = Object.size(JSON.parse(localStorage.getItem('minicart')));
if(sizeCart > 0) {
    renderCart();
    $('.btn-checkout').show();
} else {
    $('#cart-in').html('<p class="mt--40">Chưa có sản phẩm</p>');
    $('#cart-head').html('Chưa có sản phẩm');
}


$('.addToCart').click(function() {
    var isThis = $(this);
    let isQuan = $('.quantity-add');
    let isColor = $(this).parent().find('.color-add').val();
    let isSize = $(this).parent().find('.size-add').val();
    let isSku = $(this).parent().find('.sku-add').val();
    let isName = $(this).parent().find('.name-add').val();
    let isPrice = $(this).parent().find('.price-add').val();
    let isThumb = $(this).parent().find('.thumb-add').val();
    let quantity = parseInt(isQuan.val());
    let id_pro = isThis.attr('data-id');
    if($('.prod-info .js-filter-size').length > 0) {
        if(isSize!='') {
            isThis.html('<i class="fa fa-spinner fa-spin"></i> Loading...'); 
            var eachItem = [];
            var data = {
                id_pro : id_pro,
                name_pro: isName,
                quantity: quantity,
                color: isColor,
                size: isSize,
                sku: isSku,
                price: isPrice,
                thumb:isThumb
            };
            if(!localStorage.getItem("minicart")) {
                eachItem.push(data);
                localStorage.setItem("minicart", JSON.stringify(eachItem));
                $('.js-numbCart').html(quantity);
            } else {
                var currentCart = JSON.parse(localStorage.getItem('minicart'));
                var arrID = [];
                $.each(currentCart,function (index){
                    arrID.push(currentCart[index]['id_pro']);
                });
                if(arrID.indexOf(id_pro) > -1) {
                    $.each(currentCart,function (index){
                        if(currentCart[index]['id_pro']===id_pro){
                            var currenrQuan = currentCart[index]['quantity'];
                            currentCart[index]['quantity'] = currenrQuan + quantity;
                        }
                    });
                } else {
                    currentCart.push(data);
                }
                localStorage.setItem('minicart', JSON.stringify(currentCart));
            }
            
            isThis.addClass('disable');
            isThis.html('Added');
            $.toast({ 
                text : "Add to cart", 
                hideAfter: 800,
                position: 'top-right', 
                loader: false,
                showHideTransition : 'slide'  // It can be plain, fade or slide
            })
            renderCart();
            setTimeout(function(){
                isThis.html('Add to bag<i class="fa fa-shopping-bag" aria-hidden="true"></i>')
                isThis.removeClass('disable');
            }, 1000);
        } else {
            $('.error-field').addClass('err');
            $.toast({ 
                text : "Please select size", 
                hideAfter: 1200,
                position: 'top-right', 
                loader: false,
                bgColor: '#b09246',
                showHideTransition : 'slide'  // It can be plain, fade or slide
            });
        }
    } else {
        isThis.html('<i class="fa fa-spinner fa-spin"></i> Loading...'); 
            var eachItem = [];
            var data = {
                id_pro : id_pro,
                name_pro: isName,
                quantity: quantity,
                color: isColor,
                size: isSize,
                sku: isSku,
                price: isPrice,
                thumb:isThumb
            };
            if(!localStorage.getItem("minicart")) {
                eachItem.push(data);
                localStorage.setItem("minicart", JSON.stringify(eachItem));
                $('.js-numbCart').html(quantity);
            } else {
                var currentCart = JSON.parse(localStorage.getItem('minicart'));
                var arrID = [];
                $.each(currentCart,function (index){
                    arrID.push(currentCart[index]['id_pro']);
                });
                if(arrID.indexOf(id_pro) > -1) {
                    $.each(currentCart,function (index){
                        if(currentCart[index]['id_pro']===id_pro){
                            var currenrQuan = currentCart[index]['quantity'];
                            currentCart[index]['quantity'] = currenrQuan + quantity;
                        }
                    });
                } else {
                    currentCart.push(data);
                }
                localStorage.setItem('minicart', JSON.stringify(currentCart));
            }
            
            isThis.addClass('disable');
            isThis.html('Added');
            $.toast({ 
                text : "Add to cart", 
                hideAfter: 800,
                position: 'top-right', 
                loader: false,
                showHideTransition : 'slide'  // It can be plain, fade or slide
            })
            renderCart();
            setTimeout(function(){
                isThis.html('Add to bag<i class="fa fa-shopping-bag" aria-hidden="true"></i>')
                isThis.removeClass('disable');
            }, 1000);
    }
});


$('.list-toggle li').click(function() {
    $('.list-toggle li').removeClass('checked');
    $(this).addClass('checked');
    $(this).find('.list-toggle-hide').slideToggle(200);
});

$('.list-toggle-title').click(function() {
    $('.list-toggle-title').removeClass('open');
    $('.list-toggle-hide').slideUp(200);
    $(this).toggleClass('open');
    $(this).next('.list-toggle-hide').slideToggle(200);
});

$('.js-filter-size').click(function() {
    $('.js-filter-size').removeClass('chose');
    $(this).addClass('chose');
    let sizeChose = $(this).attr('data-size');
    let skuChose = $(this).attr('data-sku');
    let priceChose = $(this).attr('data-price');
    $('.size-add').val(sizeChose);
    $('.sku-add').val(skuChose);
    if(priceChose) {
        $('.price-add').val(priceChose);
        $('.js-get-price').text(addCommas(priceChose));
    }

    $('.error-field').removeClass('err');
});

$('.js-button-toggle').click(function() {
    $('.js-toggle-hide.sort-list').slideToggle(200);
});


/* remove Item from cart */
$('#cart-in').on('click', '.js-remove-item', function() {
    var elm = $(this);
    var getCurrentCart = JSON.parse(localStorage.getItem('minicart'));
    var newCart = []
    $.each(getCurrentCart,function (index){
        var itemDel = elm.attr('data-rmv');
        var id_pro = getCurrentCart[index]['id_pro'];
        if( id_pro != itemDel) {
            newCart.push(getCurrentCart[index])
        }
    });
    localStorage.setItem('minicart', JSON.stringify(newCart));
    renderCart();
    var sizeCart = Object.size(JSON.parse(localStorage.getItem('minicart')));
    if(sizeCart == 0) {
        $('.btn-checkout').hide();
        $('#cart-in').html('<p class="mt--40">Chưa có sản phẩm nào</p>');
    }
});

$('.js-quan-cart').focusout(function(){
    let isThis= $(this);
    let updateQuan = parseInt(isThis.val());
    let itemChange = isThis.attr('data-change');
    let getCurrentCart = JSON.parse(localStorage.getItem('minicart'));
    // $.each(getCurrentCart,function (index){
        
    // });
    getCurrentCart[itemChange]['quantity'] = updateQuan;
    localStorage.setItem('minicart', JSON.stringify(getCurrentCart));
    renderCart();
});


$('.js-get-booking').click(function() {
    var bodyFormData = new FormData();
    var urlBooking = $('#urlBooking').val();
    var address = $('#address').val();
    var fullname = $('#fullname').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
    var payment = $('.input-radio.checked').attr('data-pay');
    let codePromo = $('#has_promo').val();


    var orderDate = $('#dateorder').val();
    var noted = $('#noted').val();
    

    bodyFormData.append("address", address );
    bodyFormData.append("orderDate", orderDate );
    bodyFormData.append("noted", noted );
    
    bodyFormData.append("fullname", fullname );
    bodyFormData.append("phone", phone );
    bodyFormData.append("email", email );
    bodyFormData.append("payment", payment );
    bodyFormData.append("codePromo", codePromo );
    
    var booking = JSON.parse(localStorage.getItem('minicart'));
    
    createCookie('fullname', fullname, 168);
    createCookie('phone', phone, 168);
    createCookie('email', email, 168);
    createCookie('address', address, 168);


    for (var i = 0; i < booking.length; i++) {
        bodyFormData.append("prod_id_"+ i , booking[i]['id_pro'] );
        bodyFormData.append("prod_name_"+ i , booking[i]['name_pro'] );
        bodyFormData.append("prod_quan_"+ i , booking[i]['quantity'] );
        bodyFormData.append("prod_price_"+ i , booking[i]['price'] );
        bodyFormData.append("prod_size_"+ i , booking[i]['size'] );
        bodyFormData.append("prod_color_"+ i , booking[i]['color'] );
        bodyFormData.append("prod_thumb_"+ i , booking[i]['thumb'] );
        bodyFormData.append("prod_sku_"+ i , booking[i]['sku'] );
    }
    bodyFormData.append("numberOder", booking.length );
    $(this).addClass('disable').html('<i class="fa fa-spinner fa-spin"></i>');
    const options = {
        method: 'POST',
        headers: { 'content-type': 'application/json' },
        data: bodyFormData,
        url: urlBooking
    };
    axios(options).then(function (response) {
        localStorage.removeItem('minicart');
        $.toast({ 
            text : "Loading...", 
            hideAfter: 800,
            position: 'top-right', 
            loader: false,
            showHideTransition : 'slide'  // It can be plain, fade or slide
        })
        window.location.href = 'https://lotus-club.vn/confirm';
    });
});

//Open modal
$('.js-open-popup').click(function() {
    $('.overlay').fadeIn(200);
    $('.popup').fadeIn(200);
});



$('body').on('click', '.js-item-assign', function() {    
    $(this).toggleClass('active');
});


$('.js-cancel').click(function() {
    $('.popup').fadeIn(200);
    $('.overlay').fadeIn(200);
});

$('.overlay').click(function() {
    $('.popup').fadeOut(200);
    $('.overlay').fadeOut(200);
});

// $('#formUpdate').on('change', '.js-input-update', function() {
//     console.log('abc');
// });

// $( ".js-input-update" ).keyup(function() {
//     console.log('bbb');
// });

$('.js-cancel-booking').click(function() {
    var isThis = $(this);
    isThis.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    var urlCancelBooking = $('#order-list').attr('data-action-del'); 
    var idBooking = isThis.attr('data-cancel'); 
    var last_update = $('#last_update').val(); 
    var bodyFormData = new FormData();
    bodyFormData.append("idBooking", idBooking );
    bodyFormData.append("last_update", last_update );
    const options = {
        method: 'POST',
        headers: { 'content-type': 'application/json' },
        data: bodyFormData,
        url: urlCancelBooking
    };
    axios(options).then(function (response) {
        setTimeout(function(){
                location.reload();
        }, 500);
    });
});

$('.js-toogle-click').click(function() {
    $(this).prev('.toggleSection').slideToggle(200);
});

$('#list-products').on('click', '.js-categories', function() {     
    $('.js-list-products').slideUp(200);
    $(this).parent().toggleClass('active');
    $(this).parent().next('.js-list-products').slideDown(200);
}); 



$('#search-form').on('keyup keypress', function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) { 
      e.preventDefault();
      return false;
    }
  });


$(document).on('keyup keypress keydown change','.required-field',function(){
    if(($(this).val() != '' )||( $(this).val() != 0 )) {
        $(this).removeClass('check-require');
    } else if(($(this).val() == '' )||( $(this).val() == 0 )) {
        $(this).addClass('check-require');
    }
    let elm = $(this).closest( ".tab-content");
    let btnContinue = elm.find( ".btn-direct-next");
    let numberOfCheck = elm.find('.check-require').length;
    
    if(numberOfCheck == 0) {
        btnContinue.removeClass('disable');
    } else {
        btnContinue.addClass('disable');
    }
    $('.js-btn-save').removeClass('disable');
});


$('body').on('click', '.close-popup', function() {    
    $('.popup').fadeOut(200);
    $('.overlay').fadeOut(200);
});



$('.js-rmv').click(function() {
    $('.popup').fadeIn(200);
    $('.overlay').fadeIn(200);
    let IDUser =  $(this).attr('data-id');
    $('#btn-remove-user').attr('data-id',IDUser);
});


$(document).on('change','.count-select',function(){
    if($('body').hasClass('outbound')) {
        let catchValue = $(this).val();
        let maxLimit = catchValue.split('_');
        $(this).parent().next().find('.max-limit').attr('max',maxLimit[2]);
        $(this).parent().next().find('.max-limit').attr('placeholder', 'Available : ' + maxLimit[2] + ' items');
    }
});



$(document).on('keyup keypress change','.max-limit',function(){
    let getValue = parseInt($(this).val());
    let maxThis = parseInt($(this).attr('max'));
    $('#text__err').text('');
    if(getValue > maxThis) {
        $('#text__err').text('Limt order');
        $(this).val('');
    } else {
        $('#text__err').text('');
    }
});



$('.js-toogle-cart').click(function() {
    $('.cart-head').slideToggle(200);
});


$('.slide-container').slick({
    dots : false,
    slidesToShow: 1,
    fade: true,
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 700,
    infinite: true,
    arrows: false,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
    ]
}); 

$('.slide-slogan').slick({
    dots : false,
    slidesToShow: 1,
    fade: true,
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 700,
    infinite: true,
    arrows: false,
});


$('.slide-products-news').slick({
    dots : false,
    slidesToShow: 4,
    autoplay: false,
    autoplaySpeed: 2000,
    speed: 300,
    infinite: true,
    arrows: true,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
    ]
});






$('.slide-products').slick({
    dots : false,
    slidesToShow: 4,
    autoplay: false,
    autoplaySpeed: 2000,
    speed: 300,
    infinite: true,
    arrows: true,
    responsive: [
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
    ]
});

$('.input-page-require').focusout(function() {
    let checkVal = $(this).val();
    if(checkVal == '') {
        $(this).addClass('require js-require');
        $(this).focus();
    } else {
        $(this).removeClass('require js-require');
    }
    let lengtRequire = $('.js-require').length;
    console.log(lengtRequire);
    if(lengtRequire == 0) {
        $('.js-get-booking').removeClass('disable');
    } else {
        $('.js-get-booking').addClass('disable');
    }
});

let numberOfCheck = $('.js-require').length;
if(numberOfCheck == 0) {
    $('.js-get-booking').removeClass('disable');
}



// $('.slide-cate-child').slick({
//     dots : false,
//     slidesToShow: 3,
//     autoplaySpeed: 2000,
//     speed: 200,
//     infinite: true,
//     arrows: true,
//     responsive: [
//       {
//         breakpoint: 767,
//         settings: {
//           slidesToShow: 2,
//           slidesToScroll: 1
//         }
//       },
//     ]
// });


let widthwin = $(window).width();
if(widthwin <= 767) {
    $('.slide-products-detail').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        fade: true,
    });
}

$( window ).resize(function() {
    let widthwin = $(window).width();
    if(widthwin <= 767) {
        $('.slide-products-detail').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
        });
    }
});



// $('.js-load-more').click(function() {
//     const isThis = $(this);
//     // let postSlug = isThis.data('post-slug');
//     let countPost = $('#count_post').val();
//     let currentNumbPost = $('#list-products li').length;
//     let category = $('#category_hidden').val();
//     let urlProducts;
//     var datetime = new Date();
//     let currTime = datetime.getTime();

//     let currUrl = window.location.href;
//     let url = new URL(currUrl);
    
//     let sort = url.searchParams.get("sort");

//     let lang= $('#lang_web').val();

//     if(!sort) {
//         sort = 'asc';
//     }

//     if(category != undefined) {
//         urlProducts = 'https://lotus-club.vn/data/list-products.php?per_page=16&offset=' + currentNumbPost + '&category=' + category + '&time=' + currTime + '&lang=' + lang;
//     } else {
//         urlProducts = 'https://lotus-club.vn/data/list-products.php?per_page=16&offset=' + currentNumbPost + '&sort=' + sort + '&time=' + currTime + '&lang=' + lang;
//     }
    
//     let loadingIcon  = "<p class='taC js-loading'><i class='fa fa-spinner fa-pulse gray-light' style='font-size:30px;margin-top:30px'></i></p>";
//     $('#list-products').append(loadingIcon);
//     $(this).addClass('disable');
//     axios.get(urlProducts, {
//         headers: {
//             "Content-type": "application/json"
//         },
//     }).then(function (response) {
//         const getPost = response.data;
//         if(getPost.length > 0) {
//           $('.js-loading').remove();
//           isThis.removeClass('disable');
//           $('#list-products').append(getPost);   
//           let totalItem = $('#list-products li').length;
//           if(totalItem  == countPost ) {
//              isThis.hide(); 
//           }
//         } else {
//           $('.js-loading').remove();
//         }
//     });
// });

$('.js-load-more').click(function() {
    const isThis = $(this);
    let count_click = $('#count_click').val();
    let new_count = parseInt(count_click) + 1;
    console.log(count_click, new_count);
    for(let i = count_click * 16; i <= new_count * 16; i++ ) {
        $('.item_' + i).removeClass('hide-item');
    }
    $('#count_click').val(new_count);
    if($('.hide-item').length == 0) {
        isThis.hide();
    }
});


$('.js-filter-item').click(function() {
    const isThis = $(this);
    let category = $('#category_hidden').val();
    $('.js-load-more').hide();
    isThis.toggleClass('chose');
    let arrSize = '';
    let arrColor = '';
    let arrGender = '';
    let arrEffect = '';
    let arrType = '';
    let arrBase = '';

    $( ".js-filter-item.chose" ).each(function() {
        let typeFilter = $(this).attr('data-filter');
        let groupFilter = $(this).attr('data-group');
        switch(typeFilter) {
        case 'filter-size':
            arrSize += groupFilter + ',' ;
        break;
        case 'filter-color':
            arrColor += groupFilter + ',' ;
        break;
        case 'filter-gender':
            arrGender += groupFilter + ',' ;
        break;
        case 'filter-effect':
            arrEffect += groupFilter + ',' ;
        break;
        case 'filter-type':
            arrType += groupFilter + ',' ;
        break;
        case 'filter-base':
            arrBase += groupFilter + ',' ;
        break;
      }
    });

    let urlProducts;
    let param = '';
    if(arrColor != '') {
        param += '&color=' + arrColor.slice(0, -1);
    }

    if(arrGender != '') {
        param += '&gender=' + arrGender.slice(0, -1);
    }

    if(arrEffect != '') {
        param += '&effect=' + arrEffect.slice(0, -1);
    }

    if(arrType != '') {
        param += '&type=' + arrType.slice(0, -1);
    }

    if(arrBase != '') {
        param += '&base=' + arrBase.slice(0, -1);
    }

    if(category != undefined) {
        param += '&category=' + category;
    }

    var datetime = new Date();
    let currTime = datetime.getTime();

    let checkFilter = $('.js-filter-item.chose').length;
    if(checkFilter > 0) {
        urlProducts = 'https://lotus-club.vn/data/filter-products.php?size=' + arrSize.slice(0, -1) + param + '&time=' + currTime;
        let loadingIcon  = "<p class='taC js-loading'><i class='fa fa-spinner fa-pulse gray-light' style='font-size:30px;margin-top:30px'></i></p>";
        $('#list-products').html('').append(loadingIcon);
        $(this).addClass('disable');
        axios.get(urlProducts, {
            headers: {
                "Content-type": "application/json"
            },
        }).then(function (response) {
            const getPost = response.data;
            if(getPost.length > 0) {
            $('.js-loading').remove();
            isThis.removeClass('disable');
            $('#list-products').append(getPost);   
            } else {
            $('.js-loading').remove();
            }
        });
    } else {
        location.reload(); 
    }
});

  $(".button").click(function() {
    var $button = $(this);
    var oldValue = $button.parent().find(".quantity").val();
    if ($button.attr("rel") == '+') {
        var newVal = parseFloat(oldValue) + 1;
        $('.dec').removeClass('disabled');
    } else {
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
            if (parseFloat(newVal) == 1) {
                $('.dec').addClass('disabled');
            }
        } else {
            newVal = 1;
        }
    }
    $button.parent().find("input").val(newVal);
});

$('.js-slide-fliter').click(function() {
    $(this).toggleClass('clicked');
    $('.side-bar').toggleClass('active');
});

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $.toast({ 
        text : "Copied !!!", 
        hideAfter: 800,
        position: 'top-right', 
        loader: false,
        showHideTransition : 'slide'  // It can be plain, fade or slide
    })
}

$('.lang-menu li a').click(function() {
    var lang = $(this).attr('data-attribute');
    var parent = $(this).parent();
    parent.addClass('active');
    eraseCookie('lang_web');
    createCookie('lang_web', lang, 24);
    location.reload(); 
});



$('#news-items').addClass('active');

$('.js-tab-item').click(function() {
    let tabName = $(this).attr('data-tab');
    $('.tab-content').removeClass('active');
    $('#'+tabName).addClass('active');
    
    $('.js-tab-item').removeClass('active');
    $(this).addClass('active');
    if(tabName == 'promotion-items') {
        $('.slide-products-pro').slick({
            dots : false,
            slidesToShow: 4,
            autoplay: false,
            autoplaySpeed: 2000,
            speed: 300,
            infinite: true,
            arrows: true,
            responsive: [
            {
                breakpoint: 767,
                settings: {
                slidesToShow: 2,
                slidesToScroll: 1
                }
            },
            ]
        });
    }
    if(tabName == 'best-items') {
    $('.slide-products-best').slick({
        dots : false,
        slidesToShow: 4,
        autoplay: false,
        autoplaySpeed: 2000,
        speed: 300,
        infinite: true,
        arrows: true,
        responsive: [
          {
            breakpoint: 767,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1
            }
          },
        ]
    });
    }
});