$(document).ready(function () {
    var start_index = $(".page_index").val();
    var max_index = $(".page_max_index").val();

    if(start_index<=5){
        $(".page_next").css({
            "border" : "1px solid gray"
        });
    }
    if(max_index-5<start_index){
        $(".page_back").css({
            "border" : "1px solid gray"
        });
    }
});
$(document).on('click','.page_next',function(e) {
      var start_index = $(".page_index").val();
      if(5<start_index){
          start_index -= 5;
          location.href='?start_index='+start_index;
      }
});//다음페이지 주문목록 불러오기
$(document).on('click','.page_back',function(e) {
    var start_index = Number($(".page_index").val());
    var max_index = Number($(".page_max_index").val());
    if(start_index+5<=max_index){
        start_index = start_index+5; // start_index가 string형이 되어서 처리
        location.href='?start_index='+start_index;
    }
});//이전페이지 주문목록 불러오기
$(document).on('click','.order_cancle_btn',function(e) {
    var order_item_index = $(this).val();
    var order_id = $(this).prev().val();
    if(confirm('주문취소 하겠습니까?')){
    $.ajax({
        url:"../mypage/deleteOrder",
        type: "POST",
        datatype: 'JSON',
        data: {order_item_index:order_item_index,order_id:order_id},
        error:function(request,status,error){
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        },
        success: function(data){
            history.replaceState({}, null, location.pathname); //get 파라미터 삭제시키기
             window.location.reload();

        }
    });
    }
    else{
        return;
    }
});// 주문목록에서 항목 삭제


