/***********************************************************
        화면 로드온 이벤트
***********************************************************/
$(document).ready(function(){
  $('.materialboxed').materialbox();
});
/***********************************************************
        이미지 뷰어 초기화
***********************************************************/
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.materialboxed');
  var instances = M.Materialbox.init(elems);
});
/****************************************************
  마이페이지 - 내정보관리 버튼 클릭
****************************************************/
$('.divBaseInfo .userSettings').click(function(e){
  location.href = "/mypage/myInfo";
});
/****************************************************
  마이페이지 - 내정보수정 저장버튼 클릭
****************************************************/
$('.myInfoModifyFrm input[type="submit"]').click(function(){
  if($('.myInfoModifyFrm .name').val()==""){
    alert('고객명은 필수입력값입니다.\n고객명을 입력해주십시오.');
    return false;
  }
});
/****************************************************
  마이페이지 - 비밀번호변경 저장버튼 클릭
****************************************************/
$('.passwordModifyFrm input[type="submit"]').click(function(){
  if($('.passwordModifyFrm .password1').val()=="" || $('.passwordModifyFrm .password1').val()==""){
    alert('비밀번호를 입력해주십시오.');
    return false;
  }else if($('.passwordModifyFrm .password1').val() != $('.passwordModifyFrm .password2').val()){
    alert('비밀번호가 다릅니다.');
    return false;
  }
});
/****************************************************
  마이페이지 - 주문조회 - 버튼 클릭
****************************************************/
$('.myOrderList .divButton input').click(function(e){
  var orderID = $(this).parents().children('.orderID').val();
  if($(this).hasClass('orderCancelBtn')){
    console.log('주문취소',orderID);
    orderCancel(orderID);
  }else if($(this).hasClass('orderReturnBtn')){
    console.log('반품신청',orderID);
  }else if($(this).hasClass('orderDetailBtn')){
    console.log('주문상세',orderID);
    location.href = "/mypage/orderDetail/"+orderID+"?prev="+location.pathname.substring(8);
  }
});

/****************************************************
  마이페이지 - 주문취소 - 버튼 클릭
****************************************************/
function orderCancel(id){
  if(!confirm('정말 [주문취소]하시겠습니까?')){
    return false;
  }
  $.ajax({
        type:"POST",
        url:"/mypage/ajaxOrderCancle",
        data : {id:id},
        dataType : "json",
        success: function(res){
          if(res['result'] == true){
            location.href="";
          }else{
            if(res['is_forder'] == 'Y'){
              alert('이미 물품이 발주된 건은 주문취소할 수 없습니다.\n자세한 내용은 고객센터로 문의바랍니다.');
            }
          }
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
}

/****************************************************
  마이페이지 - 주문조회 - 기간설정 버튼 클릭 이벤트
****************************************************/
$('.myOrderList .divSearch input').click(function(e){
  $('.myOrderList .divSearch input').removeClass('selected');
  $(this).addClass('selected');
  var url = location.pathname+"?";
  if($(this).hasClass('all')){
    location.href = url+'period=all';
  }else if($(this).hasClass('6month')){
    location.href = url+'period=6month';
  }else if($(this).hasClass('1month')){
    location.href = url+'period=1month';
  }else if($(this).hasClass('1week')){
    location.href = url+'period=1week';
  }
});

/****************************************************
  마이페이지 - 게시판 로우 클릭 이벤트
****************************************************/
$('.supportList .divBoardBox .list').click(function(e){
  if($(this).next('.contents').hasClass('showText')){
    $('.supportList .divBoardBox .contents.showText').css('display','none');
    $('.supportList .divBoardBox .contents').removeClass('showText');
    $('.supportList .divBoardBox .contents').addClass('hiddenText');
  }else{
    $('.supportList .divBoardBox .contents.showText').css('display','none');
    $('.supportList .divBoardBox .contents').removeClass('showText');
    $('.supportList .divBoardBox .contents').addClass('hiddenText');
    $(this).next('.contents').removeClass('hiddenText');
    $(this).next('.contents').addClass('showText');
    $(this).next('.contents').fadeIn('fast');
  }
});

/****************************************************
  마이페이지 - 1:1 문의 게시판 수정
****************************************************/
$('.supportList .divBoardBox .contents .modifyBtn').click(function(e){
  var idxkey = $(this).prev().val();
  $('.supportList .divBoardBox .modifyFrm input').val(idxkey);
  $('.supportList .divBoardBox .modifyFrm').submit();
});

/****************************************************
  마이페이지 - 1:1 문의 게시판 삭제
****************************************************/
$('.supportList .divBoardBox .contents .deleteBtn').click(function(e){
  var idxkey = $(this).prev().prev().val();
  if(confirm('정말 삭제하시겠습니까?')){
    $.ajax({
          type:"POST",
          url:"/mypage/ajaxDeleteBoard",
          data : {idxkey:idxkey},
          dataType : "json",
          success: function(res){
            if(res['result'] == true){
              location.href="";
            }else{
              alert('게시판 삭제중 문제가 발생했습니다.\n문제가 계속되면 관리자에게 문의바랍니다.');
            }
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
      });
  }
});

/****************************************************
  마이페이지 - 사업자회원 전환신청하기 버튼 클릭이벤트
****************************************************/
$('.transBiz .submitBtn').click(function(e){
  if($('.transBizFrm .SHOP_NM').val() == ""){
    alert('상호명을 입력해주세요.');
    return false;
  }else if($('.transBizFrm .CERTI_NUM').val().length != 10){
    alert('사업자번호는 10자리 입니다.');
    return false;
  }else if(!reqBizNum($('.transBizFrm .CERTI_NUM').val())){
    alert('올바른 사업자번호가 아닙니다.');
    return false;
  }else{
    $('.transBizFrm').submit();
  }
});

/***********************************************************
        사업자 가입버튼 클릭 시 이벤트
***********************************************************/
function reqBizNum(bizNum){
  if(bizNum.length < 10){
    return false;
  }
  var BizNumArr = new Array();
  for(var cnt=0; cnt<10; cnt++){
    BizNumArr[cnt] = bizNum.substring(cnt,cnt+1);
  }
  var step1 = BizNumArr[0]*1+BizNumArr[1]*3+BizNumArr[2]*7+BizNumArr[3]*1+BizNumArr[4]*3+BizNumArr[5]*7+BizNumArr[6]*1+BizNumArr[7]*3+BizNumArr[8]*5;
  var step2 = step1 + Math.floor(((step1%10)*BizNumArr[8])/10);
  var step3 = 10-step2%10;
  if(step3 == BizNumArr[9]){
    return true;
  }else{
    return false;
  }
}
