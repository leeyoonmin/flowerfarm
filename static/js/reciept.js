$(document).on('click','.inputBtn',function () {
    var user2 = "";
    var day2= $('#day').val();
    var seller2= $('#seller').val();
    var product_name2= $('#product_name').val();
    var amount2= $('#amount').val();
    var price2= $('#price').val();
    var year = $("select[name='reciept_select_year']").val();
    var month =$("select[name='reciept_select_month']").val();
    var start=year+"-"+month+"-"+"01";
    var end=year+"-"+month+"-"+(new Date(year,month,0)).getDate();
    var temp_start = year*10000+month*100+1;
    var temp_end = year*10000+month*100+(new Date(year,month,0)).getDate();
    if(day2=="" ||seller2==""||product_name2==""||amount2==""||price2==""){
        alert("정보를 모두 입력하여 주세요 ");
        return;
    }
    if(temp_start<=day2 && day2<=temp_end){
        $.ajax({
                    url:"../reciept/inputdata",
                    type: "POST",
                    // datatype: 'JSON',
                    data: {user:user2, day: day2, seller:seller2, product_name:product_name2, amount:amount2, price:price2, start:start,end:end},
                    success: function(data){
                        $('.out_order_wrap').html(data);

                    },
                    //에러발생시,
                    error:function(request,status,error){
                        alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
                    }
                });
    }
    else{
        alert(start+"~"+end+" 사이의 날짜를 입력하세요");
    }

}); //데이터 입력

$(document).on('click','.deleteBtn',function (e) {

    var checkboxValue = [];
    var year = $("select[name='reciept_select_year']").val();
    var month =$("select[name='reciept_select_month']").val();
    var start=year+"-"+month+"-"+"01";
    var end=year+"-"+month+"-"+(new Date(year,month,0)).getDate();
    $("input[name='chk']:checked").each(function () {
        checkboxValue.push($(this).val());
    });
    $.ajax({
        url:"../reciept/deletedata",
        type: "POST",
        datatype: 'JSON',
        data: {chk:checkboxValue, start:start,end:end},
        error:function(request,status,error){
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        },
        success: function(data){
            $('.out_order_wrap').html(data);
            // $('#mainContents').load('../mypage/reload');
        }
    });
}); //데이터 삭제

function selectAll() {
    if($(".selectAll").is(':checked')){
        $("input[name='chk']").prop("checked",true);
    }
    else{
        $("input[name='chk']").prop("checked",false);
    }
} // 체크박스 전체 선택

function onlyNumber(event){
    event = event || window.event;
    var keyID = (event.which) ? event.which : event.keyCode;
    if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 )
        return;
    else
        return false;
}
function removeChar(event) {
    event = event || window.event;
    var keyID = (event.which) ? event.which : event.keyCode;
    if ( keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39 )
        return;
    else
        event.target.value = event.target.value.replace(/[^0-9]/g, "");
}
$(document).on('click', '.submit_reciept', function () {

    var year = $("select[name='reciept_select_year']").val();
    var month =$("select[name='reciept_select_month']").val();
    var result_start=year+"-"+month+"-"+"01";
    var result_end=year+"-"+month+"-"+(new Date(year,month,0)).getDate();
    if(year.length>1 && month.length){
        $('.reciept_content').css({
            "display" : "inherit"
        });
        $.ajax({
            url: "../mypage/reciept",
            type: "POST",
            datatype: 'JSON',
            data: {start:result_start, end:result_end},
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            },
            success: function (data) {
                $(".reciept_content").html(data);
                // $('#mainContents').load('../mypage/reload');
            }
        });


    }
    else{
        alert("날짜를 선택하세요");
    }



}); //영수증 날짜별 조회

$(document).on('click', '.submit_reciept_seller', function () {

    var year = $("select[name='reciept_seller_select_year']").val();
    var month =$("select[name='reciept_seller_select_month']").val();
    var result_start=year+"-"+month+"-"+"01";
    var result_end=year+"-"+month+"-"+(new Date(year,month,0)).getDate();
    if(year.length>1 && month.length){
        $('.reciept_seller_content').css({
            "display" : "inherit"
        });

        $.ajax({
            url: "../mypage/reciept_seller",
            type: "POST",
            datatype: 'JSON',
            data: {start:result_start, end:result_end},
            error: function (request, status, error) {
                alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
            },
            success: function (data) {
                $(".reciept_seller_content").html(data);
                // $('#mainContents').load('../mypage/reload');
            }
        });


    }
    else{
        alert("날짜를 선택하세요");
    }



});// 영수증(판매량 조회) 날짜별 조회
$(document).on('click', '.all_product', function () {
    var year = $("select[name='reciept_select_year']").val();
    var month =$("select[name='reciept_select_month']").val();
    var result_start=year+"-"+month+"-"+"01";
    var result_end=year+"-"+month+"-"+(new Date(year,month,0)).getDate();
    var url = "/reciept/show_all_order/"+result_start;
    window.open(url,"영수증","width=1000, height=800,location=no");

});


//모든 제품 다 노출되는 팝업 띄우기