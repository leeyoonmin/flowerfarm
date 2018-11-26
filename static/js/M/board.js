/***********************************************************
  게시판 페이지징 버튼 클릭이벤트
***********************************************************/
$('.divPagenation .Pagenation .countBtn').click(function(e){
  var PAGE = $(this).text();
  location.href = location.pathname+"?PAGE="+PAGE
});
$('.divPagenation .Pagenation .prevBtn,.divPagenation .Pagenation .nextBtn,.divPagenation .Pagenation .firstBtn,.divPagenation .Pagenation .lastBtn').click(function(e){
  var CURRENT_PAGE = $('.divPagenation .selectPage').val();
  var LAST_PAGE = $('.divPagenation .lastPage').val();
  var PAGE = $(this).text();
  if(PAGE == "NEXT"){
    if(CURRENT_PAGE == LAST_PAGE){
      return false;
    }
    location.href = location.pathname+"?PAGE="+(Number(CURRENT_PAGE)+1);
  }else if(PAGE == "PREV"){
    if(CURRENT_PAGE == '1'){
      return false;
    }
    location.href = location.pathname+"?PAGE="+(Number(CURRENT_PAGE)-1);
  }else if(PAGE == "<<"){
    location.href = location.pathname+"?PAGE="+'1';
  }else if(PAGE == ">>"){
    location.href = location.pathname+"?PAGE="+LAST_PAGE;
  }
});

/***********************************************************
  게시판 1:1문의 글쓰기 버튼 클릭이벤트
***********************************************************/
$('.writeBtn').click(function(e){
  location.href = '/mypage/writeBoard';
});

$('.boardFrm input[type="submit"]').click(function(e){
  var TITLE = $('.boardFrm input[type="text"]').val();
  var TEXT = $('.boardFrm textarea').val();
  if(TITLE==""){
    alert('제목을 입력하세요.');
    return false;
  }else if(TEXT==""){
    alert('내용을 입력해주세요.');
    return false;
  }else{
    $('.boardFrm').submit();
  }
});
