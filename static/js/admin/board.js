/*********************************************************
    (게시판관리) 답변하기 버튼 클릭 이벤트
**********************************************************/
$('.board.question .writeBtn').click(function(e){
  var id = "";
  $('.isOneCheck input').each(function(e){
    if($(this).prop('checked')){
      id = $(this).prev().val();
    }
  });

  if(id == ""){
    alert('답변할 게시물이 선택되지 않았습니다.');
    return false;
  }
  $('.divWritePopup .ui.active.inverted.dimmer').css('display','block');
  openRetextPopup(id);
});

/*********************************************************
    (게시판관리) 공지사항 글쓰기 버튼 클릭 이벤트
**********************************************************/
$('.board.noticeMng .writeBtn').click(function(e){
  var id = "";
  $('.isOneCheck input').each(function(e){
    if($(this).prop('checked')){
      id = $(this).prev().val();
    }
  });
  $('.divWritePopup input[type="text"]').val('');
  $('.divWritePopup textarea').val('');
  openWritePopup();
  $('.popupMode').val('write');
});



/*********************************************************
    1:1 문의 게시판 삭제 버튼 클릭
**********************************************************/
$('.board.question .deleteBtn').click(function(e){
  var id = "";
  $('.isOneCheck input').each(function(e){
    if($(this).prop('checked')){
      id = $(this).prev().val();
    }
  });

  if(id == ""){
    alert('삭제할 게시물이 선택되지 않았습니다.');
    return false;
  }

  if(!confirm('정말 삭제하시겠습니까?')){
    return false;
  }

  deleteBoard(id);

});

/*********************************************************
    공지사항문의 게시판 삭제 버튼 클릭
**********************************************************/
$('.board.noticeMng .deleteBtn').click(function(e){
  var id = "";
  $('.isOneCheck input').each(function(e){
    if($(this).prop('checked')){
      id = $(this).prev().val();
    }
  });

  if(id == ""){
    alert('삭제할 게시물이 선택되지 않았습니다.');
    return false;
  }

  if(!confirm('정말 삭제하시겠습니까?')){
    return false;
  }

  deleteBoard(id);

});

/*********************************************************
    (게시판관리) 1:1 게시글 더블클릭 이벤트
**********************************************************/
$('.question .tr.body.board').dblclick(function(e){
  var id = "";
  id = $(this).children().children('.TD_IDX').val();
  if(id == ""){
    alert('답변할 게시물이 선택되지 않았습니다.');
    return false;
  }
  $('.divWritePopup .ui.active.inverted.dimmer').css('display','block');
  openRetextPopup(id);
});

/*********************************************************
    (게시판관리) 공지사항 게시글 더블클릭 이벤트
**********************************************************/
$('.noticeMng .tr.body.board').dblclick(function(e){
  var id = "";
  id = $(this).children().children('.TD_IDX').val();
  if(id == ""){
    alert('답변할 게시물이 선택되지 않았습니다.');
    return false;
  }
  $('.divWritePopup .ui.active.inverted.dimmer').css('display','block');
  openWritePopup(id);
  $('.popupMode').val('modify');
  $('.boardID').val(id);
});

/*********************************************************
    (게시판관리) 1:1 게시판관리 조회 버튼 클릭 이벤트
**********************************************************/
$('.board.question .searchBtn').click(function(e){
  search('question');
});

/*********************************************************
    (게시판관리) 공지사항 게시판관리 조회 버튼 클릭 이벤트
**********************************************************/
$('.board.noticeMng .searchBtn').click(function(e){
  search(location.pathname.substring(7));
});

/*********************************************************
    그리드 조회 로직
**********************************************************/
function search(mode){
  var PAGE='';
  var Param='';
  var ROWNUM='';
  var TITLE='';
  var TEXT='';
  var PROGRESS='0000';
  var CATE = '0000'
  PAGE = $('.selectPage').val();
  ROWNUM = $('.ROWNUM').val();
  TITLE = $('.TITLE').val();
  TEXT = $('.TEXT').val();
  if(mode=='question'){
    PROGRESS = $('.PROGRESS').val();
  }
  if(mode=='faqMng'){
    CATE = $('.CATE').val();
  }
  if(PAGE != ''){
    Param = Param + 'PAGE='+PAGE+'&';
  }
  if(ROWNUM != ''){
    Param = Param + 'ROWNUM='+ROWNUM+'&';
  }
  if(TITLE != ''){
    Param = Param + 'TITLE='+TITLE+'&';
  }
  if(TEXT != ''){
    Param = Param + 'TEXT='+TEXT+'&';
  }
  if(PROGRESS != '0000'){
    Param = Param + 'PROGRESS='+PROGRESS+'&';
  }
  if(CATE != '0000'){
    Param = Param + 'CATE='+CATE+'&';
  }
  location.href = location.pathname+'?'+Param;
}

/*********************************************************
    답변하기 팝업 오픈 로직
**********************************************************/
function openRetextPopup(id){
  $('.divWritePopup input[type="hidden"]').val(id);
  $('.divWritePopup').transition('fade');
  $('.divWritePopupBG').transition('fade');
  $.ajax({
      url:"/admin/ajaxGetBoard",
      type: "POST",
      datatype: 'JSON',
      data: {'id':id},
      error:function(request,status,error){
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
        result = JSON.parse(data);
        var re = /\r\n/g;
        var text = result['data']['text'];
        var retext = result['data']['retext'];
        text = text.replace(re, "</br>");
        if(retext != null){
          retext = retext.replace(re, "</br>");
        }

        $('.divWritePopup .title').html('제목 : '+result['data']['title']);
        $('.divWritePopup .contents').html(text);
        $('.divWritePopup textarea').val(retext);
        $('.divWritePopup .user').html('아이디 : '+result['data']['user_id']);
        $('.divWritePopup .ui.active.inverted.dimmer').css('display','none');
      }
  });
}

function openWritePopup(id){
  $('.divWritePopup').transition('fade');
  $('.divWritePopupBG').transition('fade');
  if(id != null){
    $.ajax({
        url:"/admin/ajaxGetBoard",
        type: "POST",
        datatype: 'JSON',
        data: {'id':id},
        error:function(request,status,error){
          console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        },
        success: function(data){
          result = JSON.parse(data);
          var re = /\r\n/g;
          var text = result['data']['text'];
          text = text.replace(re, "</br>");
          $('.divWritePopup input[type="text"]').val(result['data']['title']);
          $('.divWritePopup select').val(result['data']['category']);
          $('.divWritePopup textarea').val(text);
          $('.divWritePopup .ui.active.inverted.dimmer').css('display','none');
        }
    });
  }
}

/*********************************************************
    답변하기 팝업 닫기 로직
**********************************************************/
function closeWritePopup(){
  $('.divWritePopup').transition('fade');
  $('.divWritePopupBG').transition('fade');
}

/*********************************************************
    답변하기 팝업 닫기 이벤트
**********************************************************/
$('.divWritePopup img').click(function(e){
  closeWritePopup();
});

/*********************************************************
    답변하기 팝업 닫기 이벤트
**********************************************************/
$('.divWritePopupBG').click(function(e){
  closeWritePopup();
});


/*********************************************************
    답변하기버튼 클릭이벤트
**********************************************************/
$('.question .divWritePopup .submitBtn').click(function(e){
  var id = $('.divWritePopup input[type="hidden"]').val();
  var retext = $('.divWritePopup textarea').val();
  $('.divWritePopup .ui.active.inverted.dimmer').css('display','block');
  $.ajax({
      url:"/admin/ajaxUpdateRetext",
      type: "POST",
      datatype: 'JSON',
      data: {'id':id , 'retext':retext},
      error:function(request,status,error){
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
        console.log(data);
        result = JSON.parse(data);
        if(result['result']){
          window.location.reload();
        }
      }
  });
});

/*********************************************************
    게시글작성 클릭이벤트
**********************************************************/
$('.noticeMng .divWritePopup .submitBtn').click(function(e){
  var id = $('.divWritePopup .boardID').val();
  var title = $('.divWritePopup input[type="text"]').val();
  var text = $('.divWritePopup textarea').val();
  var type = "";
  var cate = $('.divWritePopup select').val();

  console.log(cate);
  $('.divWritePopup .ui.active.inverted.dimmer').css('display','block');
  if($('.popupMode').val() == 'write'){
    path = 'ajaxWriteBoard';
  }else if($('.popupMode').val() == 'modify'){
    path = 'ajaxUpdateBoard';
  }
  if(location.pathname.substring(7)=="noticeMng"){
    type = '01';
  }else if(location.pathname.substring(7)=="faqMng"){
    type = '02';
  }

  $.ajax({
      url:"/admin/"+path,
      type: "POST",
      datatype: 'JSON',
      data: {'id':id, 'title':title , 'text':text, 'type':type, 'cate':cate},
      error:function(request,status,error){
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
        console.log(data);
        result = JSON.parse(data);
        if(result['result']){
          window.location.reload();
        }
      }
  });
});

/*********************************************************
    게시물 삭제버튼 클릭이벤트
**********************************************************/
function deleteBoard(id){
  $.ajax({
      url:"/admin/ajaxDeleteBoard",
      type: "POST",
      datatype: 'JSON',
      data: {'id':id},
      error:function(request,status,error){
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
        console.log(data);
        result = JSON.parse(data);
        if(result['result']){
          window.location.reload();
        }
      }
  });
}
