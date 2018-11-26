//아이디 입력값 유효성 검사
//현재는 input태그 속성인 pattern="[A-Za-z0-9]{4,10}" 으로 구현했으나, 중복확인 시에 입력값 유효성 검사 필요.

//아이디 중복확인
$(document).on('click', '.id-check-btn', function(e){
    var div = $(this).closest('.input-row');
    var user_id = $(div).find('input').val();
    if(user_id == ''){ //아이디를 입력하지 않은 경우,
        alert('아이디를 입력해주세요.');
        return;
    }

    $.ajax({
        type: 'post',
        url: '/auth/doubleCheck',
        data: {user_id: user_id},
        dataType: "json",
        success: function (data) {
            $(div).find('.error-msg').css('display', 'block');
            $(div).find('.error-msg').css('color', data.color);
            $(div).find('.error-msg').text(data.msg);
            if(data.check == 1){ //사용 가능한 아이디인 경우,
                $(div).find('input').attr('placeholder', '아이디 (특수문자 입력불가)');
                $(div).find('.join-id').attr('data-valid', '1');
                setTimeout(function(){ // 메세지('사용가능한 아이디입니다.') 보였다가 사라지도록.
                    $(div).find('.error-msg').text();
                    $(div).find('.error-msg').css('display', 'none');
                }, 1000);
            }
        },
        error:function(request,status,error){
            alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
    });
    e.preventDefault();
});

//아이디 중복확인 후, 다시 수정하는 경우, valid값 0으로 변경
$(document).on('keyup', '.join-id', function(){
    $(this).attr('data-valid', '0');
});

//비밀번호 유효성 검사
$(document).on('keyup', '.join-pw', function(){
    var str = $(this).val();
    var div = $(this).closest('.input-row');

    if(str.length < 8){
        $(div).find('.error-msg').css('display', 'block');
        $(div).find('.error-msg').css('color', 'red');
        $(div).find('.error-msg').text('비밀번호를 최소 8자리 이상 입력해주세요.');
        $(this).attr('data-valid', '0');
    }else{
        $(div).find('.error-msg').css('display', 'none');
        $(div).find('.error-msg').text();
        $(this).attr('data-valid', '1');
    }

    var pw = $('.join-pw').val();
    var pwCheck = $('.join-pw-check').val();
    var div = $('.join-pw-check').closest('.input-row');

    if(pw == pwCheck){
        $(div).find('.error-msg').css('display', 'none');
        $(div).find('.error-msg').text();
        $('.join-pw-check').attr('data-valid', '1');
    }else{
        $(div).find('.error-msg').css('display', 'block');
        $(div).find('.error-msg').css('color', 'red');
        $(div).find('.error-msg').text('비밀번호가 동일하지 않습니다.');
        $('.join-pw-check').attr('data-valid', '0');
    }

});

//비밀번호 확인 유효성 검사
$(document).on('keyup', '.join-pw-check', function(){
    var pw = $('.join-pw').val();
    var pwCheck = $('.join-pw-check').val();
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

//이미지 업로드 유효성 검사
$(document).on('change', '#image-upload', function(){
    var div = $(this).closest('.input-row');
    var file = $("#image-upload").val();
    //파일 확장자 검사
    if( file != "" ){
        var ext = file.split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg', 'jpeg']) == -1) {
            $(div).find('.error-msg').css('display', 'block');
            $(div).find('.error-msg').css('color', 'red');
            $(div).find('.error-msg').text('gif, png, jpg, jpeg 파일만 업로드 할수 있습니다.');
            return;
        }
    }

    //사이즈체크
    var maxSize  = 20971520;    //20MB
    var fileSize = 0;  // 파일 사이즈 초기화
    var browser=navigator.appName; // 브라우저 확인

    if (browser=="Microsoft Internet Explorer"){ // 익스플로러일 경우, 에러 발생 가능(확인 필요)
        var oas = new ActiveXObject("Scripting.FileSystemObject");
        fileSize = oas.getFile(this.value).size;
    }else{ // 익스플로러가 아닐경우
        fileSize = this.files[0].size;
    }
    //alert("현재 파일 사이즈: "+fileSize);

    if(fileSize > maxSize) { //파일 사이즈가 최대 사이즈보다 큰 경우, alert
        $(div).find('.error-msg').css('display', 'block');
        $(div).find('.error-msg').css('color', 'red');
        $(div).find('.error-msg').text('이미지 사이즈는 20MB 이내로 등록 가능합니다.');
        $(this).attr('data-valid', '0');
    }else{
        $(div).find('.error-msg').css('display', 'none');
        $(div).find('.error-msg').text();
        $(this).attr('data-valid', '1');
    }
});

//파일 업로드 시 이미지명 보이기
$(document).on('change', '.certificate .upload-hidden', function(){
    if(window.FileReader){// modern browser
        var filename = $(this)[0].files[0].name;
    } else { // old IE
        var filename = $(this).val().split('/').pop().split('\\').pop(); // 파일명만 추출
    } // 추출한 파일명 삽입
    $(this).siblings('.upload-name').val(filename);
});


// 회원가입 양식 제출
// 값 input 요소의 data-valid 값을 통해 유효성 검사를 모두 통과했는지 확인.
// data-valid : 0이면 alert 후 return / 1이면 통과
function joinSubmit(){
    if($('.join-id').attr('data-valid') == 0){ //아이디 중복확인
        alert(' 아이디 중복확인을 해주세요.');
        $('.join-id').focus();
        return false;
    }else if($('.join-pw').attr('data-valid') == 0){ //비밀번호 8자리 이상
        $('.join-pw').focus();
        return false;
    }else if($('.join-pw-check').attr('data-valid') == 0){ //비밀번호 확인
        $('.join-pw-check').focus();
        return false;
    }else if($('#image-upload').attr('data-valid') == 0){
        alert('규격에 맞는 이미지를 업로드해주세요.');
        $('.upload-name').focus();
        return false;
    }
    return true;
}