$(document).ready(function () {
    var start_index = Number($(".product_list_index").val());
    var last_index = Number($(".product_list_last_index").val());

    if(start_index==1){
        $(".product_list_back").css({
            "border" : "1px solid gray"
        });
    }
    if(last_index<start_index+15){
        $(".product_list_next").css({
            "border" : "1px solid gray"
        });
    }
});


$(document).on('click','.product_list_back',function () {
    var start_index = Number($(".product_list_index").val());
    if(0<start_index){
        start_index -= 15;
        if(start_index<=0){
            start_index=1;
        }

        location.href='?start_index='+start_index;
    }
});
$(document).on('click','.product_list_next',function () {
    var start_index = Number($(".product_list_index").val());
    var last_index = Number($(".product_list_last_index").val());
    if(last_index-start_index>=15){
        start_index += 15;
        location.href='?start_index='+start_index;
    }
});
$(document).on('click','.product_list_delete_btn',function() {

    var checkboxValue = [];
    $("input[name='chk']:checked").each(function () {
        checkboxValue.push($(this).val());
    });
    if(checkboxValue==""){
        alert("체크박스를 체크해주세요");
        return;
    }
    if(confirm('삭제 하겠습니까?')){
        $.ajax({
            url:"../admin/deleteProduct",
            type: "POST",
            datatype: 'JSON',
            data: {chk:checkboxValue},
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
});
$(document).on('click','.product_list_name, .product_list_type, .product_list_cate_kind, .product_list_cate_shape, .product_list_cate_color , .product_list_amount, .product_list_price_w, .product_list_price_r, .product_list_display, .product_list_sell, .product_list_popural',function() {
    var pid = $(this).parent().prevAll("#first").children().val();
    var type = $(this).next().val();
    var url = "/admin/modifyPopup/"+type+"/?pid="+pid;
    window.open(url,"수정","width=550, height=300,location=no");
});
$(document).on('click','.product_list_img',function() {
    var pid = $(this).parent().prevAll("#first").children().val();
    var type = $(this).next().val();
    var url = "/admin/modifyPopup/"+type+"/?pid="+pid;
    window.open(url,"수정","width=900, height=500,location=no");
});

function selectAll() {
    if($(".selectAll").is(':checked')){
        $("input[name='chk']").prop("checked",true);
    }
    else{
        $("input[name='chk']").prop("checked",false);
    }
} // 체크박스 전체 선택

