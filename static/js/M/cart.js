/***********************************************************
        장바구니 아이템 삭제버튼 클릭이벤트
***********************************************************/
$('.divItemList .divItem .deleteTD').click(function(e){
  if(!confirm('정말 삭제하시겠습니까?')){
    return false;
  }
  $('.divLoader.body').css('display','block');
  var id = $(this).prev().prev().children('input').val();
  $.ajax({
        type:"POST",
        url:"/cart/ajaxDeleteCartItem",
        data : {id:id},
        dataType : "json",
        success: function(res){
          location.reload();
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
});
/***********************************************************
        장바구니 아이템 플러스 마이너스 버튼 클릭이벤트
***********************************************************/
$('.divItemList .divItem .countTD a').click(function(e){
  $('.divLoader.body').css('display','block');
  var id = $(this).parents().children('input').val();
  console.log('aa');
  if($(this).hasClass('plusBtn')){
    updateCartItemCount(id,'plus');
  }else if($(this).hasClass('minusBtn')){
    updateCartItemCount(id,'minus');
  }
});

/***********************************************************
        장바구니 아이템 수량 증가/감소 로직
***********************************************************/
function updateCartItemCount(id,mode){
  console.log(id,mode);
  $.ajax({
        type:"POST",
        url:"/cart/ajaxUpdateCartItemCount",
        data : {id:id, mode:mode, qty:''},
        dataType : "json",
        success: function(res){
          if(res['result']==false){
            alert('재고를 초과하였습니다.');
            location.reload();
          }else{
            location.reload();
          }
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
}

/***********************************************************
        달력 일자 클릭 이벤트
***********************************************************/
  $('.able').click(function(e){
    if($(e.target).prop('tagName')=="A"){
      var getDate = $('.dateNow').val();
      var getDateArray = getDate.split(".");
      var getYear = getDateArray[0];
      var getMonth = getDateArray[1];
      var getDay = $(e.target).html();
      selectDay = getDay;
      selectMonth = getMonth;
      $('.able').removeClass('selected');
      $(this).addClass('selected');
      $('.inputDeliveryDate').val(getYear+getMonth+getDay);
    }
  });

/***********************************************************
        배송방법 선택 이벤트
***********************************************************/
$('.divSelectDeliveryMethod td').click(function(e){
  $('.divSelectDeliveryMethod td').removeClass('selected');
  $(this).addClass('selected');
  if($(this).hasClass('normal')){
    $('.inputDeliveryMethod').val('01');
  }else if($(this).hasClass('quick')){
    $('.inputDeliveryMethod').val('02');
  }
  var DELIVERY_FEE = $(this).children('p:nth-of-type(2)').text().replace(/[^0-9]/g,"");
  var TOTAL_PRICE = $('.TOTAL_PRICE_HD').val().replace(/[^0-9]/g,"");
  $('.divCartTotal .totalPrice').text(comma(Number(DELIVERY_FEE)+Number(TOTAL_PRICE)));
});

/***********************************************************
        주문서작성 버튼 클릭 이벤트
***********************************************************/
$('.divCartTotal .orderBtn').click(function(e){
  var date = $('.inputDeliveryDate').val();
  var method = $('.inputDeliveryMethod').val();
  var deliveryFee = $('.divSelectDeliveryMethod td.selected').children('p:nth-of-type(2)').text().replace(/[^0-9]/g,"");
  if($('.divCartTotal td:nth-of-type(1) span:nth-of-type(1)').text()<1){
    alert('주문할 상품이 없습니다.');
    return false;
  }else if(date == ""){
    alert('배송희망일자를 선택해주세요.');
    return false;
  }
  location.href="/M_menu/order?date="+date+'&method='+method+'&deliveryFee='+deliveryFee;
});
