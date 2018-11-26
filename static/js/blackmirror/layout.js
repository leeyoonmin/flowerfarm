/***********************************************************
        화면 로드온 이벤트
***********************************************************/
$(window).load(function(){
  ////////////////////////슬라이드 장바구니 리스트 높이 설정
  setFixedCartHeight();
});

/***********************************************************
        화면 사이즈 변경
***********************************************************/
$(window).resize(function(){
  console.log('resize');
  setFixedCartHeight();
});

/***********************************************************
        우측 고정 카드 높이 설정
***********************************************************/
function setFixedCartHeight(){
  var divSlideCartHeight = window.innerHeight;//$('.divContainerRight').css('height');

  //divSlideCartHeight = divSlideCartHeight.replace(/[^0-9]/g,'');
  var divTopHeaderHeight = 64;
  var divCartTotalHeight = 182;
  var slideCartHeight = divSlideCartHeight - divTopHeaderHeight - divCartTotalHeight;
  $('.divContainerRight .divItemList').css('height',slideCartHeight);
  $('.divContainerRight .divItemList').css('max-height',slideCartHeight);

  console.log('브라우저높이 : ' + divSlideCartHeight +', 최종높이 : '+slideCartHeight);
}
