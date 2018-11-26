function checkRadioDefault(value) {
    value -=2;
    var radio = document.getElementsByName('user_type');
    radio[value].checked = true;
} // 라디오박스 기본값 셋팅

$(document).on('click','.modifyName',function (e) {
    if($('.name').length>0){
        return false;
    }
    else{
        if($('.phone').length>0){
            alert("휴대폰 번호를 먼저 입력하세요");
            return false;
        }
        else{
            $html="<br><div class='submitform1'><input type='text' class='name' placeholder='이름을 입력하세요'><input type='button' class='submitName' value='확인'><input type='button' class='cancle1' value='취소'></div>";
            $(".wrap_modifyName").append($html);
        }
    }
});

$(document).on('click','.modifyPhone',function (e) {
    if($(".phone").length>0){
        return false;
    }
    else{

        if($('.name').length>0){
            alert("이름을 먼저 입력하세요");
            return false;
        }
        else{
            $html="<br><div class='submitform2'><input type='text' class='phone' placeholder='전화번호를 입력하세요'><input type='button' class='submitPhone' value='확인'><input type='button'class='cancle2' value='취소'></div>";
            $(".wrap_modifyPhone").append($html);
        }

    }

});


$(document).on('click','.cancle1',function (e) {
    $(".submitform1").remove();
});
$(document).on('click','.cancle2',function (e) {
    $(".submitform2").remove();
});
$(document).on('click','.cancle3',function (e) {
    $(".submitform3").remove();
});

$(document).on('click','.submitName,.submitPhone',function(e) {
    var name= $('.name').val();
    var phone=$('.phone').val();
    var pw=$('.modifyPwCheck').val();
    if(name=="" || phone==""){
        alert("정보를 입력하세요 ");
        return;
    }
    if($('.phone').length<1){
        $.ajax({
            url:"../mypage/modify",
            type: "POST",
            data: {user_name:name, validate:1},
            success: function(data){
                alert("이름이 변경되었습니다");
                location.reload();
            },
            error: function(request,status,error){
                alert("실패");
            }
        });
    }
    if($('.name').length<1){
        $.ajax({
            url:"../mypage/modify",
            type: "POST",
            data: {user_cellphone:phone, validate:2},
            success: function(data){
                alert("휴대폰번호가 변경되었습니다");
                location.reload();
            },
            error: function(request,status,error){
                alert("실패");
            }
        });
    }

});

$(document).on('click','.submitPw',function(e) {
    var pw =$('.modifyPwCheck').val();
    if(pw==""){
        alert("비밀번호를 입력하세요");
        return;
    }
    else if($('.modifyPwCheck').val()==$('.modifyPw').val()){
        $.ajax({
            url:"../mypage/modify",
            type: "POST",
            data: {user_pw:pw, validate:3},
            success: function(data){
                alert("비밀번호가 변경되었습니다");
                $(".modifyPwView").load('../mypage/modifyPwView');
            },
            error: function(request,status,error){
                alert("실패");
            }
        });
    }
    else{
        return;
    }
});


$(document).on('keyup', '.modifyPw', function(){
    var str = $(this).val();
    var div = $(this).closest('.input-row');
    if(0<str.length && str.length< 8){
        $(div).find('.error-msg').css('display', 'block');
        $(div).find('.error-msg').css('color', 'red');
        $(div).find('.error-msg').text('비밀번호를 최소 8자리 이상 입력해주세요.');
        $(this).attr('data-valid', '0');
    }

    else{
        $(div).find('.error-msg').css('display', 'none');
        $(div).find('.error-msg').text();
        $(this).attr('data-valid', '1');
    }

    var pw = $('.modifyPw').val();
    var pwCheck = $('.modifyPwCheck').val();
    var div = $('.modifyPwCheck').closest('.input-row');

});
$(document).on('keyup', '.modifyPwCheck', function(){
    var pw = $('.modifyPw').val();
    var pwCheck = $('.modifyPwCheck').val();
    var div = $(this).closest('.input-row');

    if(pw == pwCheck){
        $(div).find('.error-msg').css('display', 'none');
        $(div).find('.error-msg').text();
        $(this).attr('data-valid', '1');
    }else{
        $(div).find('.error-msg').css('display', 'block');
        $(div).find('.error-msg').css('color', 'red');
        $(div).find('.error-msg').text('비밀번호가 동일하지 않습니다.');
        $(this).attr('data-valid', '0');
    }

});

$(document).on('click','.modifyType', function () {
    var userType = $("input[name='user_type']:checked").val();
    // alert(userType);
    $.ajax({
        url:"../mypage/modify",
        type: "POST",
        data: {user_type:userType, validate:4},
        success: function(data){
            alert("유저타입이 변경되었습니다");
            location.reload();
        },
        error: function(request,status,error){
            alert("실패");
        }
    });

});