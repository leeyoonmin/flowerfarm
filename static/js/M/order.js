/***************************************
  온로드 이벤트
***************************************/
$(document).ready(function(){

});
/***************************************
  주문하기 버튼 클릭 이벤트
***************************************/
$('.orderBtn').click(function(e){
  if($('#name').val()==""){
    alert('주문자명을 입력해주세요.');
    return false;
  }else if($('#postcode').val()==""){
    alert('우편번호를 입력해주세요.');
    return false;
  }else if($('#address').val()==""){
    alert('주소를 입력해주세요.');
    return false;
  }else if($('#detail_addr').val()==""){
    alert('상세주소를 입력해주세요.');
    return false;
  }
});
/***************************************
  주소록 선택 버튼 클릭이벤트
***************************************/
$('.divTitle .link').click(function(e){
  $('.divOrderAddrPopup').css('display','block');
  $('.divOrderAddrPopupBG').css('display','block');
  $('.addrPopupLoader').css('display','block');
  $.ajax({
        type:"POST",
        url:"/M_menu/ajaxGetOrderAddrList",
        data : {},
        dataType : "json",
        success: function(res){
          if(res['result'] == true){
            $('.divAddrBox').remove();
            $('.divEmptyBox').remove();
            for(var cnt=0; cnt<res['addrList'].length; cnt++){
              if(res['addrList'][cnt]['USER_ADDR_DEFAULT'] == 'Y'){
                $('.divOrderAddrPopup .divAddrList').append('<div orderID=\"'+res['addrList'][cnt]['ORDER_ID']+'\" class=\"divAddrBox default\"><table><tr><td>주소</td><td>(<span class=\"postcode\">'+res['addrList'][cnt]['RECIP_POSTCODE']+'</span>)<span class=\"addr\">'+res['addrList'][cnt]['RECIP_ADDR']+'</span> <span class=\"detail_addr\">'+res['addrList'][cnt]['RECIP_ADDR_DETAILS']+'</span></td></tr><tr><td>전화번호</td><td><span class=\"tel_h\">'+res['addrList'][cnt]['RECIP_TEL_H']+'</span>-<span class=\"tel_b\">'+res['addrList'][cnt]['RECIP_TEL_B']+'</span>-<span class=\"tel_t\">'+res['addrList'][cnt]['RECIP_TEL_T']+'</span></td></tr><tr><td>요청사항</td><td><span class=\"req_msg\">'+res['addrList'][cnt]['REQ_MSG']+'</td></tr></table></div>');

              }else{
                $('.divOrderAddrPopup .divAddrList').append('<div orderID=\"'+res['addrList'][cnt]['ORDER_ID']+'\" class=\"divAddrBox\"><table><tr><td>주소</td><td>(<span class=\"postcode\">'+res['addrList'][cnt]['RECIP_POSTCODE']+'</span>)<span class=\"addr\">'+res['addrList'][cnt]['RECIP_ADDR']+'</span> <span class=\"detail_addr\">'+res['addrList'][cnt]['RECIP_ADDR_DETAILS']+'</span></td></tr><tr><td>전화번호</td><td><span class=\"tel_h\">'+res['addrList'][cnt]['RECIP_TEL_H']+'</span>-<span class=\"tel_b\">'+res['addrList'][cnt]['RECIP_TEL_B']+'</span>-<span class=\"tel_t\">'+res['addrList'][cnt]['RECIP_TEL_T']+'</span></td></tr><tr><td>요청사항</td><td><span class=\"req_msg\">'+res['addrList'][cnt]['REQ_MSG']+'</td></tr></table></div>');

              }
            }
            if(res['addrList'].length<1){
              $('.divOrderAddrPopup .divAddrList').append('<div class=\"divEmptyBox\">주소록 내역이 없습니다.</div>');
            }
            $('.addrPopupLoader').css('display','none');
            /***************************************
              주소록 팝업 주소박스 선택이벤트
            ***************************************/
            $('.divOrderAddrPopup .divAddrBox').click(function(e){
              $('.divOrderAddrPopup .divAddrBox').removeClass('default');
              $(this).addClass('default');
            });
          }else{

          }
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });

});
/***************************************
  주소록 팝업 배경 선택 이벤트
***************************************/
$('.divOrderAddrPopupBG').click(function(e){
  $('.divOrderAddrPopup').css('display','none');
  $('.divOrderAddrPopupBG').css('display','none');
});
/***************************************
  주소록 팝업 서브밋 버튼 클릭이벤트
***************************************/
$('.divOrderAddrPopup .submitBtn').click(function(e){
  $('.addrPopupLoader').css('display','block');
  var id = $('.divOrderAddrPopup .divAddrList .divAddrBox.default').attr('orderID');
  $.ajax({
        type:"POST",
        url:"/M_menu/ajaxUpdateDefaultAddr",
        data : {id:id},
        dataType : "json",
        success: function(res){
          if(res['result'] == true){
            $('#postcode').val($('.divOrderAddrPopup .default .postcode').text());
            $('#address').val($('.divOrderAddrPopup .default .addr').text());
            $('#detail_address').val($('.divOrderAddrPopup .default .detail_addr').text());
            $('#tel1').val($('.divOrderAddrPopup .default .tel_h').text());
            $('#tel2').val($('.divOrderAddrPopup .default .tel_b').text());
            $('#tel3').val($('.divOrderAddrPopup .default .tel_t').text());
            $('#req_msg').val($('.divOrderAddrPopup .default .req_msg').text());
            $('.divOrderAddrPopup').css('display','none');
            $('.divOrderAddrPopupBG').css('display','none');
          }else{

          }
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
});
