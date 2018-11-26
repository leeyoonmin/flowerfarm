/*****************************************************
  온 로드 함수
******************************************************/
$(document).ready(function(){
  $('.materialboxed').materialbox();
  $('.ui.rating').rating('disable');
});

document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.materialboxed');
  var instances = M.Materialbox.init(elems);
});


/*****************************************************
  상품 그리드 -> 상품박스 -> 수량 증가/감소 버튼 클릭이벤트
******************************************************/
$('.divGrid .divItem .qtyBtn').click(function(e){
  $(this).transition({animation :'pulse',duration:200});
  if(slideCartState){
    clearTimeout(slideTimer);
    slideTimer = setTimeout("slideCartClose()", 3000);
    return false;
  }
  slideCartOpen();
  slideTimer = setTimeout("slideCartClose()", 3000);
});


/*****************************************************
  상품리스트 상품 마우스 오버 이벤트
******************************************************/
$('.divGrid .divItem').mouseenter(function(e){
  $(this).children('input.minusBtn').css('left',$(this).offset().left+136);
  $(this).children('input.plusBtn').css('left',$(this).offset().left+163);
  $(this).children('input').css('top',$(this).offset().top+4);
  $(this).addClass('z-depth-2');
  $(this).children('input').transition('slide down');
});

/*****************************************************
  상품리스트 상품 마우스 아웃 이벤트
******************************************************/
$('.divGrid .divItem').mouseleave(function(e){
  $(this).removeClass('z-depth-2');
  $(this).children('input').transition({animation:'fade down',duration:100});
});

/*****************************************************
  화면 스크롤에 따른 검색창 상단고정 이벤트
******************************************************/
$(window).scroll(function () {
  var divSearchTopOffset = $('.divSearch').offset().top;
  if(divSearchTopOffset < $(document).scrollTop()){
    $('.divSearch.fixed').css('display','block');
  }else{
    $('.divSearch.fixed').css('display','none');
  }
});

/*****************************************************
  검색창 키워드에 따른 상품검색 로직
******************************************************/
$(".divSearch .inputSearch").on("change keyup paste", function(){
  var keyword = $(".divSearch input").val();
  $('.divGrid .divItem').each(function(){
    if(keyword == ''){
      $('.divGrid .divItem').removeClass('keywordHidden');
      return false;
    }
    if($(this).children('.itemInfo').children().children().children().children('.name').text().match(keyword)){
      $(this).removeClass('keywordHidden');
    }else{
      $(this).addClass('keywordHidden');
    }
  });
});

/*****************************************************
  카테고리 클릭에 따른 상품검색 로직
******************************************************/
$('.divCategory .trKIND input').click(function(e){
  $('.divCategory .trKIND input').each(function(e){
    $(this).prop('checked',false);
  });
  $(this).prop('checked',true);
});

$('.divCategory .trCOLOR input').click(function(e){
  $('.divCategory .trCOLOR input').each(function(e){
    $(this).prop('checked',false);
  });
  $(this).prop('checked',true);
});

$('.divCategory .trSHAPE input').click(function(e){
  $('.divCategory .trSHAPE input').each(function(e){
    $(this).prop('checked',false);
  });
  $(this).prop('checked',true);
});
