/*********************************************************
    (공통코드관리) 주문취소 버튼 클릭 이벤트
**********************************************************/
$('.paymentList .orerCancelBtn').click(function(e){
  orderCancle();
});

/*********************************************************
    (공통코드관리) 공통코드관리 조회 버튼 클릭 이벤트
**********************************************************/
$('.commonCodeMng .searchBtn').click(function(e){
  search('commonCodeMng');
});

/*********************************************************
    (공통코드관리) 공통코드관리 코드추가 버튼 클릭 이벤트
**********************************************************/
$('.commonCodeMng .divButton .addBtn').click(function(e){
  $('.divpopuplayer .title td a').css('display','none');
  $('.divpopuplayer .title td:first-of-type').text('공통코드 추가 팝업');
  $('.divpopuplayer .saveBtn').val('추가');
  $('.divpopuplayer .saveBtn').addClass('addBtn');
  $('.divpopuplayer .saveBtn').removeClass('saveBtn');
  $('.divpopuplayer .inputIDX').val('');
  $('.divpopuplayer .inputWORK_DV').val('');
  $('.divpopuplayer .inputCODE_DV').val('');
  $('.divpopuplayer .inputCODE_NM').val('');
  $('.divpopuplayer .inputCODE').val('');
  if($('.divSearch .WORK_DV').val()!='0000'){
    $('.divpopuplayer .inputWORK_DV').val($('.divSearch .WORK_DV option:selected').text());
  }
  if($('.divSearch .CODE_DV').val()!='0000'){
    $('.divpopuplayer .inputCODE_DV').val($('.divSearch .CODE_DV option:selected').text());
  }
  if($(this).children('.TD_IS_USE').text()=="Y"){
    $('.divpopuplayer .inputIS_USE .value_Y').prop('selected',true);
  }
  $('.divpopuplayer').css('display','block');
  $('.divpopuplayerBG').css('display','block');
});

/*********************************************************
    (공통코드관리) 업무구분 변경 이벤트
**********************************************************/
$('.commonCodeMng .WORK_DV').change(function(e){
  ajaxGetCodeDV();
});

/*********************************************************
    CODEMNG ROW 더블클릭이벤트
**********************************************************/
$('.tr.body.codemng').dblclick(function(e){
  $('.divpopuplayer .title td a').css('display','inline');
  $('.divpopuplayer .title td:first-of-type').text('공통코드 수정 팝업');
  $('.divpopuplayer .addBtn').addClass('saveBtn');
  $('.divpopuplayer .saveBtn').removeClass('addBtn');
  $('.divpopuplayer .saveBtn').val('저장');
  $('.divpopuplayer .inputIDX').val($(this).children('.isCheck').children('.TD_IDX').val());
  $('.divpopuplayer .inputWORK_DV').val($(this).children('.TD_WORK_DV').text());
  $('.divpopuplayer .inputCODE_DV').val($(this).children('.TD_CODE_DV').text());
  $('.divpopuplayer .inputCODE_NM').val($(this).children('.TD_CODE_NM').text());
  $('.divpopuplayer .inputCODE').val($(this).children('.TD_CODE').text());
  if($(this).children('.TD_IS_USE').text()=="Y"){
    $('.divpopuplayer .inputIS_USE .value_Y').prop('selected',true);
  }else{
    $('.divpopuplayer .inputIS_USE .value_N').prop('selected',true);
  }
  $('.divpopuplayer').css('display','block');
  $('.divpopuplayerBG').css('display','block');
});

/*********************************************************
    (공통코드관리) 코드수정 팝업 닫기버튼 클릭 이벤트
**********************************************************/
$('.commonCodeMng .closeBtn').click(function(e){
  $('.divpopuplayer').css('display','none');
  $('.divpopuplayerBG').css('display','none');
});

/*********************************************************
    (공통코드관리) 코드수정 팝업 저장버튼 클릭 이벤트
**********************************************************/
$('.commonCodeMng .divpopuplayer .saveBtn').click(function(e){
  var IDX = $('.divpopuplayer .inputIDX').val();
  var WORK_DV = $('.divpopuplayer .inputWORK_DV').val();
  var CODE_DV = $('.divpopuplayer .inputCODE_DV').val();
  var CODE_NM = $('.divpopuplayer .inputCODE_NM').val();
  var CODE = $('.divpopuplayer .inputCODE').val();
  var IS_USE = $('.divpopuplayer .inputIS_USE').val();
  $.ajax({
    url:'/admin/updateCommonCode',
    dataType:'json',
    type:'POST',
    data:{'IDX':IDX, 'WORK_DV':WORK_DV, 'CODE_DV':CODE_DV, 'CODE_NM':CODE_NM, 'CODE':CODE, 'IS_USE':IS_USE},
    success:function(result){
      if(result['result']==true){
        search('commonCodeMng');
      }
      else{
        alert('알수없는 문재가 발생했습니다.\n관리자에게 문의바랍니다.');
      }
    }
  });
});

/*********************************************************
    (공통코드관리) 코드추가 팝업 추가버튼 클릭 이벤트
**********************************************************/
$('.commonCodeMng .divpopuplayer .addBtn').click(function(e){
  var IDX = $('.divpopuplayer .inputIDX').val();
  var WORK_DV = $('.divpopuplayer .inputWORK_DV').val();
  var CODE_DV = $('.divpopuplayer .inputCODE_DV').val();
  var CODE_NM = $('.divpopuplayer .inputCODE_NM').val();
  var CODE = $('.divpopuplayer .inputCODE').val();
  var IS_USE = $('.divpopuplayer .inputIS_USE').val();
  $.ajax({
    url:'/admin/updateCommonCode',
    dataType:'json',
    type:'POST',
    data:{'IDX':IDX, 'WORK_DV':WORK_DV, 'CODE_DV':CODE_DV, 'CODE_NM':CODE_NM, 'CODE':CODE, 'IS_USE':IS_USE},
    success:function(result){
      if(result['result']==true){
        search('commonCodeMng');
      }
      else{
        alert('알수없는 문재가 발생했습니다.\n관리자에게 문의바랍니다.');
      }
    }
  });
});

/*********************************************************
    (공통코드관리) 코드수정 팝업 삭제버튼 클릭 이벤트
**********************************************************/
$('.commonCodeMng .divpopuplayer .delBtn').click(function(e){
  if(!confirm('정말 삭제하시겠습니까?')){
    return false;
  }
  var IDX = $('.divpopuplayer .inputIDX').val();
  $.ajax({
    url:'/admin/updateCommonCode',
    dataType:'json',
    type:'POST',
    data:{'IDX':IDX},
    success:function(result){
      if(result['result']==true){
        window.location.reload();
      }
      else{
        alert('알수없는 문재가 발생했습니다.\n관리자에게 문의바랍니다.');
      }
    }
  });
});

/*********************************************************
    그리드 조회 로직
**********************************************************/
function search(mode){
  var PAGE='';
  var Param='';
  var WORK_DV='';
  var CODE_DV='';
  var CODE_NM='';
  var CODE='';
  PAGE = $('.selectPage').val();
  if(mode=='commonCodeMng'){
    WORK_DV = $('.WORK_DV').val();
    CODE_DV = $('.CODE_DV').val();
    CODE_NM = $('.CODE_NM').val();
    CODE = $('.CODE').val();
  }
  if(PAGE != ''){
    Param = Param + 'PAGE='+PAGE+'&';
  }
  if(WORK_DV != '0000'){
    Param = Param + 'WORK_DV='+WORK_DV+'&';
  }
  if(CODE_DV != '0000'){
    Param = Param + 'CODE_DV='+CODE_DV+'&';
  }
  if(CODE_NM != ''){
    Param = Param + 'CODE_NM='+CODE_NM+'&';
  }
  if(CODE != ''){
    Param = Param + 'CODE='+CODE+'&';
  }
  location.href = mode+'?'+Param;
}

/*********************************************************
    AJAX 업무구분별 코드구분 조회
**********************************************************/
function ajaxGetCodeDV(){
  var WORK_DV = $('.WORK_DV').val();
  if(WORK_DV == '0000'){
    $('.commonCodeMng .divSearch .CODE_DV .option').remove();
    return false;
  }
  $.ajax({
    url:'/admin/ajaxGetCodeDVByWorkDV',
    dataType:'json',
    type:'POST',
    data:{'WORK_DV':WORK_DV},
    success:function(result){
      if(result['result']==true){
        if(result['object'].length > 0){
          console.log(result['object']);
          $('.commonCodeMng .divSearch .CODE_DV .option').remove();
          for(var rowCnt = 0; result['object'].length > rowCnt; rowCnt++){
            $('.commonCodeMng .divSearch .CODE_DV').append('<option class=\"option\" value=\"' + result['object'][rowCnt]['CODE_DV'] + '\">' + result['object'][rowCnt]['CODE_DV'] + '</option>');
          }
        }
      }
      else{
        alert('알수없는 문재가 발생했습니다.\n관리자에게 문의바랍니다.');
      }
    }
  });
}
