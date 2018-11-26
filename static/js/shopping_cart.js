// 장바구니 전체선택
$(document).on('click', '.cart-table #check-all', function(){
    if($(this).prop('checked')){
        $('.cart-table input[type="checkbox"]').prop('checked', true);
        addAmount();
    }else{
        $('.cart-table input[type="checkbox"]').prop('checked', false);
        addAmount();
    }
});

// 상품 선택(체크박스)시, 결제금액 계산
$(document).on('click', '.item-select', function(){
    addAmount();
});

// 결제금액 계산
function addAmount(){
    var order_price = 0;
    var fare = $('.cart-fare-amount').data('fare');

    $('tbody input.item-select:checked').each(function(){
        var price = $(this).closest('tr').data('price');
        var qty = $(this).closest('tr').find('.qty-box input').val();
        order_price += price * Number(qty);
    });

    $('.cart-order-amount span').text(order_price);
    $('.cart-sum-amount span').text(order_price+Number(fare));
}