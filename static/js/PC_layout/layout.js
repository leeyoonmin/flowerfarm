/*****************************************************
  장바구니 제어 버튼 클릭 이벤트
******************************************************/
var slideCartState = false;
var slideTimer;
$('.divHeader').click(function(){
  if(slideCartState){
    slideCartClose();
  }else{
    slideCartOpen();
  }
});

/*****************************************************
  장바구니 열기 로직
******************************************************/
function slideCartOpen(){
  $('.divHeader').animate({'top':'0','width':'150px','height':'34px','padding':'0px'},200).removeClass('z-depth-2');
  $('.divHeader span').css('display','inline-block').css('margin-bottom','0px');
  $('.divHeader span:nth-of-type(4)').css('margin-right','8px');
  $('.divHeader span:nth-of-type(5)').text('닫');
  $('.divSlideCart').transition('fade right');
  slideCartState = true;
}

/*****************************************************
  장바구니 닫기 로직
******************************************************/
function slideCartClose(){
  $('.divHeader').animate({'top':'40%','width':'40px','height':'140px','padding':'16px 12px'},200).addClass('z-depth-2');
  $('.divHeader span').css('display','block').css('margin-bottom','4px');
  $('.divHeader span:nth-of-type(4)').css('margin-right','0px').css('margin-bottom','8px');
  $('.divHeader span:nth-of-type(5)').text('열');
  $('.divSlideCart').transition('fade right');
  slideCartState = false;
}
