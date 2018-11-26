// 주문자와 동일 버튼 클릭시 주문자 정보가 받는사람 정보에 입력
$(document).on('click', '#same-as-user', function() {
    if($(this).prop('checked')){
        $('#recip-name').val($('#user-name').val());
        $('#recip-phone').val($('#user-phone').val());
    }
});

// 결제하기 버튼 클릭 시
$(document).on('submit', 'form', function(e){

    e.preventDefault();

    if($('.find-addr').attr('data-valid') == 0){ //우편번호 찾기를 하지 않은 경우, alert
        alert('우편번호 찾기 버튼을 눌러 주소를 입력해주세요.');
        return
    }


    var user_addr = $('#addr').val();
    var user_addr_details= $('#addr_details').val();
    var user_addr_zipcode= $('#zipcode').val();
    var user_req= $('#req').val();
    var recip_name= $('#recip-name').val();
    var recip_phone= $('#recip-phone').val();
        //나중에 배열로 한꺼번에 넣자
    var pay_method = $('input[type="radio"]:checked').val();
    if(pay_method == 2){
        alert('준비중입니다. 계좌이체의 경우, PG사와 계약 체결 후 이용 가능합니다.');
        return;
    }
    else if(pay_method == 3){
        if(confirm('주문 하시겠습니까?')) {
            var pids = Array();
            $('.selected-item').each(function () {
                pids.push($(this).data('pid'));
            });
            $.ajax({
                type: 'post',
                url: '/product/pay',
                dataType: "json",
                data: {'pids': pids, 'pay_method': pay_method},
                success: function (data) { // 배송지 입력 성공한 경우

                    // 현재 사용가능한 방식은 카드결제
                    // 실시간 계좌이체는 import 테스트모드에서는 사용 불가.
                    // 무통장입금은 요구사항 수렴 후 구현.

                    $.ajax({
                        type: 'post',
                        url: '/product/addr',
                        // dataType: 'json',
                        data: {
                            addr: user_addr, addr_details: user_addr_details, zipcode: user_addr_zipcode,
                            req: user_req, recipName: recip_name, recipPhone: recip_phone
                        },

                        success: function (data) {
                            window.location.href = "/mypage/checkMyOrder";
                        },
                        error: function (request, status, error) {

                            alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                        }
                    });
                },
                error: function (request, status, error) {
                    alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                }

            });


        }
        else{
            return;
        }
    }
    else if(pay_method == 1){
        if(confirm('주문 하시겠습니까?')) {
            //PG사 연결
            var first_prod = $('.product-name:first').text();
            var qty = $('.product-name').length - 1;
            IMP.request_pay({
                pg: 'danal',
                pay_method: pay_method,
                merchant_uid: 'merchant_' + new Date().getTime(),
                name: first_prod + ' 외 ' + qty + '건', //
                amount: $('#amount').text(),
                buyer_email: '',
                buyer_name: $('#user-name').val(),
                buyer_tel: $('#user-phone').val(),
                buyer_addr: $('#addr').val(),
                buyer_postcode: $('#zipcode').val(),
                m_redirect_url: 'https://www.yourdomain.com/payments/complete'
            }, function (rsp) {
                if (rsp.success) {
                    var pids = Array();
                    $('.selected-item').each(function () {
                        pids.push($(this).data('pid'));
                    });
                    $.ajax({
                        type: 'post',
                        url: '/product/pay',
                        dataType: "json",
                        data: {'pids': pids, 'pay_method': pay_method},
                        success: function (data) { // 배송지 입력 성공한 경우

                            // 현재 사용가능한 방식은 카드결제
                            // 실시간 계좌이체는 import 테스트모드에서는 사용 불가.
                            // 무통장입금은 요구사항 수렴 후 구현.


                        },
                        error: function (request, status, error) {
                            alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                        }

                    });
                    $.ajax({
                        type: 'post',
                        url: '/product/addr',
                        // dataType: 'json',
                        data: {
                            addr: user_addr, addr_details: user_addr_details, zipcode: user_addr_zipcode,
                            req: user_req, recipName: recip_name, recipPhone: recip_phone
                        },
                        success: function (data) {
                        },
                        error: function (request, status, error) {
                            alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
                        }
                    });

                    // var msg = '결제가 완료되었습니다.';
                    // msg += '고유ID : ' + rsp.imp_uid;
                    // msg += '상점 거래ID : ' + rsp.merchant_uid;
                    // msg += '결제 금액 : ' + rsp.paid_amount;
                    // msg += '카드 승인번호 : ' + rsp.apply_num;

                    alert('결제가 완료되었습니다. 홈으로 이동합니다.');
                    window.location.href = "/mypage/checkMyOrder";

                } else {
                    var msg = '결제에 실패하였습니다.';
                    msg += '에러내용 : ' + rsp.error_msg;
                    alert(msg);
                }
            });
        }
        else{
            return;
        }
    }

});

//우편번호 찾기 (다음 api)
$(document).on('click', '.find-addr', function(){
//$('.find-addr').on('click', function(){
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var fullAddr = ''; // 최종 주소 변수
            var extraAddr = ''; // 조합형 주소 변수

            // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                fullAddr = data.roadAddress;

            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                fullAddr = data.jibunAddress;
            }

            // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
            if(data.userSelectedType === 'R'){
                //법정동명이 있을 경우 추가한다.
                if(data.bname !== ''){
                    extraAddr += data.bname;
                }
                // 건물명이 있을 경우 추가한다.
                if(data.buildingName !== ''){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
            }

            $('#zipcode').removeAttr('disabled');
            $('#addr').removeAttr('disabled');

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            $('#zipcode').val(data.zonecode); //5자리 새우편번호 사용
            $('#addr').val(fullAddr);
            $('.find-addr').attr('data-valid', '1');

            // document.getElementById('sample6_postcode').value = data.zonecode;
            // document.getElementById('sample6_address').value = fullAddr;

            // 커서를 상세주소 필드로 이동한다.
            //document.getElementById('sample6_address2').focus();
        }
    }).open();
});
