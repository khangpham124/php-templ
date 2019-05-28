/* check and insert number of item */
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

var start = readCookie('incart');
if (start) {
    $('.numbCart').html(start);
} else {
    $('.numbCart').html(0);
}

$(".button").click(function() {
    var $button = $(this);
    var oldValue = $button.parent().find(".quantity").val();
    if ($button.attr("rel") == '+') {
        var newVal = parseFloat(oldValue) + 1;
    } else {
        if (oldValue > 0) {
            var newVal = parseFloat(oldValue) - 1;
        } else {
            newVal = 0;
        }
    }
    $button.parent().find("input").val(newVal);
});

$(".addToCard").click(function() {
    var isThis = $(this);
    if (isThis.hasClass("addToDes")) {
        var quantity = 1;
    } else {
        var isQuan = $(this).parent().prev().find('.quantity');
        var quantity = parseInt(isQuan.val());
    }
    if (isThis.hasClass("inDesign")) {
        var sku = isThis.attr('data-numb');
    }
    var id_pro = isThis.attr('data-id');
    var name_pro = isThis.attr('data-title');
    var getCL = isThis.attr('data-color');
    var color = getCL.replace('#', '');
    isThis.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    setTimeout(function() {
        isThis.html('<i class="fa fa-shopping-cart"></i> Đã thêm');
        isThis.addClass('disable');
    }, 500);
    $.ajax({
        data: {},
        url: '/ajax/create_json.php?proid=' + id_pro + '&qual=' + quantity + '&name_pro=' + name_pro + '&color=' + color + '&sku=' + sku,
        type: 'GET',
        success: function(data) {
            var start = readCookie('incart');
            $('.numbCart').html(start);
            $(".addToCard").removeClass('disable');
        }
    })
});



/* remove Item from cart */
$('.removeItem').click(function() {
    var itemDel = $(this).attr('data-id');
    var itemCost = $(this).attr('data-quan');
    $(this).parent().parent().remove();
    $.ajax({
        data: {},
        url: '/ajax/edit_json.php?proid=' + itemDel + '&qual=' + itemCost,
        type: 'GET',
        success: function(data) {
            var start = readCookie('incart');
            $('.numbCart').html(start);
        }
    })
});

$('.methodPay').click(function() {
    var methodPay = readCookie('methodPay');
    var noteOrder = $('#note_order').val();
    createCookie('noteOrder', noteOrder, 24);
    if (methodPay == 'cod') {
        window.location = ('https://desino.vn/confirm/');
    } else if (methodPay !== null) {
        $.ajax({
            data: {},
            url: '/ajax/feeCharge.php',
            type: 'GET',
            success: function(data) {
                window.location = (data);
                // window.open(data)
            }
        })
    } else if (methodPay == null) {
        alert('Please choose a payment method');
    }
});

$(".addToWish").click(function() {
    var isThis = $(this);
    var id_pro = isThis.attr('data-id');
    var getCL = isThis.attr('data-color');
    var color = getCL.replace('#', '');
    isThis.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    setTimeout(function() {
        isThis.html('<i class="fa fa-shopping-cart"></i> Added');
        isThis.addClass('disable');
    }, 500);
    $.ajax({
        data: {},
        url: '/ajax/addwish.php?proid=' + id_pro + '&color=' + color + '&action=add',
        type: 'GET',
        success: function(data) {}
    })
});

$('.removeList').click(function() {
    var itemDel = $(this).attr('data-id');
    $(this).parent().parent().remove();
    $.ajax({
        data: {},
        url: '/ajax/addwish.php?proid=' + itemDel + '&action=remove',
        type: 'GET',
        success: function(data) {

        }
    })
});

$('.removeItem').click(function() {
    var itemDel = $(this).attr('data-id');
    var itemCost = $(this).attr('data-quan');
    $(this).parent().parent().remove();
    $.ajax({
        data: {},
        url: '/ajax/edit_json.php?proid=' + itemDel + '&qual=' + itemCost,
        type: 'GET',
        success: function(data) {
            var start = readCookie('incart');
            $('.numbCart').html(start);
        }
    })
});

$('.listDesign li').click(function() {
    eraseCookie(design);
    $('.listDesign li').removeClass('chose');
    var elm = $(this).find('a').attr('data-id');
    $(this).toggleClass('chose');
    createCookie('design', elm, 24);
    var design = readCookie('design');
    if (design != '') {
        $('.btnPage').removeClass('disable');
    } else {
        $('.btnPage').addClass('disable');
    }
});