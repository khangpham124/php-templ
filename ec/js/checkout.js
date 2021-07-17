
function renderCheckout() {
    const checkoutList = $('#checkout-list');
    var htmlCart = '';
    var getCurrentCart = JSON.parse(localStorage.getItem('minicart'));
    var total = 0;
    let totalMessage;
    let labelPromotion;
    if(readCookie('lang_web') == 'vn') {
        totalMessage = 'Chưa bao gồm chi phí vận chuyển và thuế VAT';
        labelPromotion = 'Nhập mã khuyến mãi';
        btnPromo = 'Nhập';
    } else {
        totalMessage = 'Subtotal does not include shipping & tax';
        labelPromotion = 'Promotion code';
        btnPromo = 'Enter';
    }
    if(getCurrentCart) {
        $.each(getCurrentCart,function (index){
            var subTotal = getCurrentCart[index]['quantity'] * getCurrentCart[index]['price'];
            htmlCart += `<div class="flex-box flex-box--wrap box--border--bottom padding--vertical--10">
                    <div class="grid--15"><img src="`+ getCurrentCart[index]['thumb'] + `" alt="`+ getCurrentCart[index]['name_pro'] + `"></div>
                    <div class="grid--30 grid__mb--45 padding--left--20">
                        <strong>`+ getCurrentCart[index]['name_pro'] +`</strong></br class="pc">(`
                        + getCurrentCart[index]['color'] +`)</br>`
                        + getCurrentCart[index]['size'] + `
                        <p class="sp"> `+addCommas(getCurrentCart[index]['price']) +` x`+ getCurrentCart[index]['quantity'] +`</p> 
                        
                    </div>
                    <div class="grid--15 taC pc">` + getCurrentCart[index]['quantity'] + `</div>
                    <div class="grid--15 taC pc">` + addCommas(getCurrentCart[index]['price']) + ` Đ</div>
                    <div class="grid--15 grid__mb--25 taC">`+ addCommas(subTotal) +` Đ</div>
                    <div class="grid--10 taC"><a href="javascript:void(0)" class="js-remove-item" data-rmv="`+  getCurrentCart[index]['id_pro'] +`"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div>
                    </div>`
            total +=   subTotal;     
        });
        htmlCart += `
            <div class="box-promotion mt--30 mt__mb--10 flex-box flex-box--aligncenter box--border--bottom flex-box__mb--wrap padding--10">
                <div class="grid--70 grid__mb--100">
                    <div class="flex-box flex-box__mb--wrap flex-box--aligncenter grid--100 ">
                        <label class="grid__mb--100">`+labelPromotion+`</label>
                        <p class="wrap-relative ml--20 ml__mb--0 grid--100"><input type="text" class="input-page js-code-text"><a href="javascript:void(0)" class="btn-page-input js-input-code btn-absolute">`+btnPromo+`</a></p>
                    </div>
                    <p id="code_err" class="text__err mt--10 mb--10 fw--bold"></p>
                </div>
                <div class="grid--30 grid__mb--100 taR">
                    <span id="priceDown" class="text--violet fw--bold">0 Đ</span>
                </div>
            </div>

            <div class="padding--10"><div colspan="4">
            <p id="code_err" class="text__err mt--10 fw--bold"></p>
            Total<br></div>
            <div colspan="2" class="taR">
            <span id="totalPrice" class="fw--bold" data-ori=`+ total + `>`+ addCommas(total) +`</span> Đ
            </div>
        </div>`;
    } else {
        $('.js-btn-chekckout').hide();
        if(readCookie('lang_web') == 'en') {
            htmlCart =  `<tr><td colspan="6">There are no items in your bag.</td></tr>`
        } else {
            htmlCart =  `<tr><td colspan="6">Giỏ hàng của bạn đang trống.</td></tr>`
        }
        
    }
    checkoutList.html(htmlCart);
}
renderCheckout();

$('#checkout-list').on('click', '.js-remove-item', function() {
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
    $(this).parent().parent().remove();
    localStorage.setItem('minicart', JSON.stringify(newCart));
    renderCheckout();
    renderCart();
    var sizeCart = Object.size(JSON.parse(localStorage.getItem('minicart')));
    if(sizeCart == 0) {
        $('#list-products').html('<p class="mt--40">Chưa có sản phẩm nào</p>');
        $('.js-get-booking').hide();
    }
    $('#totalPrice').text(addCommas(originalTotal));
    $('#priceDown').text('');
});

$('#checkout-list').on('click', '.js-input-code', function() {
    let codeText = $('.js-code-text').val();
    let originalTotal = parseInt($('#totalPrice').attr('data-ori'));
    if(codeText == 'KHAITRUONG') {
        let downPrice = originalTotal * 20 / 100;
        let newDownPrice = originalTotal - downPrice;
        $('#totalPrice').text(addCommas(newDownPrice));
        $('#has_promo').val('KHAITRUONG');
        $('#priceDown').text('-' + addCommas(downPrice) + ' Đ') ;
    } else {
        if(readCookie('lang_web') == 'vn') {
            $('#code_err').text('Mã code không hợp lệ');
        } else {
            $('#code_err').text('Invalid code');
        }
        $('#totalPrice').text(addCommas(originalTotal));
        $('#priceDown').text('');
    }
});

