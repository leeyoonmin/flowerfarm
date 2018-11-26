//숫자에 콤마추가
function addComma(num) {
    var regexp = /\B(?=(\d{3})+(?!\d))/g;
    return num.toString().replace(regexp, ',');
}


//상세페이지 수량에 따른 가격 변화
function changePrice(amount){
    var price = Number($('.ctrl-prod-amount').data('price'));
    $('.prod-sum > span').text(addComma(price*amount));
}

// + 버튼 클릭시
$(document).on('click', '.amount-plus', function(){
    var input = $(this).closest('div').find('input');
    var amount = $(input).val();
    var stock = Number($('#prod-stock').text());
    if(stock <= amount){ // 재고 수량을 초과해 선택한 경우
        alert('재고 수량을 초과했습니다.');
        return;
    }
    amount = Number(amount)+1;
    $(input).val(amount);
    changePrice(amount);
});

// - 버튼 클릭시
$(document).on('click', '.amount-minus', function(){
    var input = $(this).closest('div').find('input');
    var amount = $(input).val();
    if(amount == 1){ // 수량이 1일 때, - 버튼을 누른 경우
        alert('최소 수량은 1 입니다.');
        return;
    }
    amount = Number(amount)-1;
    $(input).val(amount);
    changePrice(amount);
});

// 장바구니 버튼 클릭시 장바구니에 추가
$(document).on('click', '.btn-in-cart', function(){
    var p_qty = $('#details_qty').val();
    var p_id = $('.ctrl-prod-amount').data('pid');
    var p_name = $('.ctrl-prod-amount').data('name');
    var p_price = $('.ctrl-prod-amount').data('price');

    $.ajax({
        type: 'post',
        url: '/cart/add_Cart',
        data: {p_id : p_id, p_price: p_price, p_name: p_name, p_qty: p_qty},
        success: function (res) {
            load_cart();
            if(res == '"max_err"'){ // 결과값이 '"max_err"'로 나오는 이유는..?
                alert('재고 수량을 초과했습니다.');
            }
        },
        error:function(request,status,error){
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }

    });
});

// 구매하기 버튼 클릭시 선택한 상품을 장바구니에 추가한 후, 장바구니 페이지로 이동
$(document).on('click', '.btn-order', function(){
    var p_qty = $('#details_qty').val();
    var p_id = $('.ctrl-prod-amount').data('pid');
    var p_name = $('.ctrl-prod-amount').data('name');
    var p_price = $('.ctrl-prod-amount').data('price');

    $.ajax({
        type: 'post',
        url: '/cart/add_Cart',
        // dataType: "json",
        data: {p_id : p_id, p_price: p_price, p_name: p_name, p_qty: p_qty},
        success: function (res) {
            if(res == '"max_err"'){ // 결과값이 '"max_err"'로 나오는 이유는..?
                alert('재고 수량을 초과했습니다.');
            }
            window.location.href = '/cart';
        },
        error:function(request,status,error){
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }

    });
});

//작은 이미지에 마우스오버 시, 메인이미지 변경
$(document).on('mouseover', '.sub-photo-box>img', function(){
    $('.prod-img > img').attr('src', this.src);
    $('.sub-photo-box>img').each(function(){
        $(this).removeClass('add-line');
    });
    $(this).addClass('add-line');
});