/*********************************************************
    (입금전관리) 주문취소 버튼 클릭 이벤트
**********************************************************/
$('.paymentList .orerCancelBtn').click(function(e){
  orderCancle();
});

/*********************************************************
    (입금전관리) 입금확인 버튼 클릭 이벤트
**********************************************************/
$('.paymentList .paymentConfBtn').click(function(e){
  ajaxPaymentUpdate('입금확인','paymentConfServ');
});

/*********************************************************
    (입금전관리) 입금확인취소 버튼 클릭 이벤트
**********************************************************/
$('.paymentList .paymentConfCancleBtn').click(function(e){
  ajaxPaymentUpdate('입금확인취소','paymentConfCancleServ');
});

/*********************************************************
    (입금전관리) 입금전관리 조회 버튼 클릭 이벤트
**********************************************************/
$('.paymentList .searchBtn').click(function(e){
  search('paymentList');
});

/*********************************************************
    (발주서생성) 주문취소 버튼 클릭이벤트
**********************************************************/
$('.createForder .orerCancelBtn').click(function(e){
  orderCancle();
});

/*********************************************************
    (발주서생성) 조회 버튼 클릭이벤트
**********************************************************/
$('.createForder .searchBtn').click(function(e){
  search('createForder');
});

/*********************************************************
    (발주서생성) 발주서생성 버튼 클릭이벤트
**********************************************************/
$('.createForder .createForderBtn').click(function(e){
  forderDraftWriteBtn();
});

/*********************************************************
    (발주서작성) 조회 버튼 클릭이벤트
**********************************************************/
$('.writeForder .searchBtn').click(function(e){
  search('writeForder');
});

/*********************************************************
    (발주서작성) 발주서작성 버튼 클릭이벤트
**********************************************************/
$('.writeForder .writeForderBtn').click(function(e){
  var forderID;
  var progress;
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      forderID = $(this).parents('.td').next('.td').next('.td').text();
      progress = $(this).parents('.td').next('.td').next('.td').next('.td').next('.td').next('.td').next('.td').children('input').val();
    }
  });

  if(forderID == null){
    alert("선택된 건이 없습니다.");
    return false;
  }

  popupWriteForder(forderID,progress);
});

/*********************************************************
    (발주서작성) 발주서삭제 버튼 클릭이벤트
**********************************************************/
$('.writeForder .deleteForderBtn').click(function(e){
  ajaxByForderID('발주서삭제','ajaxCancleForder');
});

/*********************************************************
    ORDER ROW 더블클릭이벤트
**********************************************************/
$('.tr.body.order').dblclick(function(e){
  var orderID = $(this).children('.td.orderID').text();
  popupDetail(orderID);
});

/*********************************************************
    (수정발주서작성) 조회 버튼 클릭이벤트
**********************************************************/
$('.writeModifiedForder .searchBtn').click(function(e){
  search('writeModifiedForder');
});


/*********************************************************
    (수정발주서작성) 수정발주서작성 버튼 클릭이벤트
**********************************************************/
$('.writeModifiedForder .writeModifiedForderBtn').click(function(e){
  var forderID;
  var progress;
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      forderID = $(this).parents('.td').next('.td').next('.td').text();
      progress = $(this).parents('.td').next('.td').next('.td').next('.td').next('.td').next('.td').next('.td').children('input').val();
    }
  });

  if(forderID == null){
    alert("선택된 건이 없습니다.");
    return false;
  }

  popupWriteForder(forderID,progress);
});


/*********************************************************
    (발주품수령) 조회 버튼 클릭이벤트
**********************************************************/
$('.writeConfirmedForder .searchBtn').click(function(e){
  search('writeConfirmedForder');
});


/*********************************************************
    (상품준비중 관리) 조회 버튼 클릭이벤트
**********************************************************/
$('.readyProduct .searchBtn').click(function(e){
  search('readyProduct');
});

/*********************************************************
    (상품준비중 관리) 배송중처리 버튼 클릭이벤트
**********************************************************/
$('.readyProduct .onDeliveryBtn').click(function(e){
  ajaxByOrderID('배송중','updateOrderProgress');
});

/*********************************************************
    (배송중 관리) 조회 버튼 클릭이벤트
**********************************************************/
$('.onDelivery .searchBtn').click(function(e){
  search('onDelivery');
});

/*********************************************************
    (배송중 관리) 배송완료처리 버튼 클릭이벤트
**********************************************************/
$('.onDelivery .completeDeliveryBtn').click(function(e){
  ajaxByOrderID('배송완료','updateOrderProgress');
});

/*********************************************************
    (전체주문조회) 조회 버튼 클릭이벤트
**********************************************************/
$('.orderAllList .searchBtn').click(function(e){
  search('orderAllList');
});

$('.forderConfirm .searchBtn').click(function(e){
  search('forderConfirm');
});




/*********************************************************
    (발주품수령) 발주서보기 버튼 클릭이벤트
**********************************************************/
$('.writeConfirmedForder .completeFordertBtn, .forderAllList .completeFordertBtn, .forderConfirm .completeFordertBtn').click(function(e){
  var rowCnt = 0;
  var checkBoxArray = new Array();
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      checkBoxArray[rowCnt] = $(this).parents('.td').next('.td').next('.td').text();
      rowCnt++;
    }
  });

  console.log(checkBoxArray.length);
  if(rowCnt == 0){
    alert('선택된 발주가 없습니다.');
    return false;
  }
  if(checkBoxArray.length > 1){
    alert('발주서보기는 1건 만 선택해서 진행해주세요.');
    return false;
  }
  popupCompleteForder('init',checkBoxArray[0]);
});

/*********************************************************
    (발주품수령) 수정발주서보기 버튼 클릭이벤트
**********************************************************/
$('.writeConfirmedForder .modifyFordertBtn, .forderAllList .modifyFordertBtn, .forderConfirm .modifyFordertBtn').click(function(e){
  var rowCnt = 0;
  var checkBoxArray = new Array();
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      checkBoxArray[rowCnt] = $(this).parents('.td').next('.td').next('.td').text();
      rowCnt++;
    }
  });

  if(rowCnt == 0){
    alert('선택된 발주가 없습니다.');
    return false;
  }
  console.log(checkBoxArray.length);
  if(checkBoxArray.length > 1){
    alert('1건 만 선택해주세요.');
    return false;
  }
  popupCompleteForder('30',checkBoxArray[0]);
});




/*********************************************************
    (확정발주서작성) 추가발주 버튼 클릭이벤트
**********************************************************/
$('.forderConfirm .addForderBtn').click(function(e){
  var rowCnt = 0;
  var checkBoxArray = new Array();
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      checkBoxArray[rowCnt] = $(this).parents('.td').next('.td').next('.td').text();
      rowCnt++;
    }
  });

  if(rowCnt == 0){
    alert('선택된 발주가 없습니다.');
    return false;
  }
  if(checkBoxArray.length > 1){
    alert('1건 만 선택해주세요.');
    return false;
  }
  popupAddForder(checkBoxArray[0]);
});

/*********************************************************
    (확정발주서작성) 확정발주서작성 버튼 클릭이벤트
**********************************************************/
$('.writeConfirmedForder .writeConfirmedForderBtn').click(function(e){
  var forderID;
  var progress;
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      forderID = $(this).parents('.td').next('.td').next('.td').text();
      progress = $(this).parents('.td').next('.td').next('.td').next('.td').next('.td').next('.td').next('.td').children('input').val();
    }
  });

  if(forderID == null){
    alert("선택된 건이 없습니다.");
    return false;
  }
  
  popupWriteForder(forderID,progress);
});

/*********************************************************
    발주서 이전 상태로 되돌리기 (발주서반송)
**********************************************************/
$('.writeConfirmedForder .forderReturnBtn, .writeModifiedForder .forderReturnBtn').click(function(e){
  var forderID;
  var progress;
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      forderID = $(this).parents('.td').next('.td').next('.td').text();
      progress = $(this).parents('.td').next('.td').next('.td').next('.td').next('.td').next('.td').next('.td').children('input').val();
    }
  });

  if(forderID == null || progress == null){
    alert('선택된 항목이 없습니다.');
    return false;
  }

  if(!confirm("발주서 반송처리 하시겠습니까?")){
    return false;
  }

  $.ajax({
      url:"/admin/ajaxUpdateForderPRG",
      type: "POST",
      datatype: 'JSON',
      data: {'forderID':forderID, 'progress':progress},
      error:function(request,status,error){
        alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
      window.location.reload();
      }
  });
});


//##################################################################################################//




/*********************************************************
    주문상태변경 로직
**********************************************************/
function ajaxPaymentUpdate(action,url){
  var currentAction = action;
  var checkBoxArray = new Array();
  var rowCnt = 0;
  var falseFlag = false;
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      checkBoxArray[rowCnt] = $(this).parents('.td').next('.td').next('.td').text();
      rowCnt++;
    }
  });

  if(rowCnt == 0){
    alert('선택된 주문이 없습니다.');
    return false;
  }

  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      if(action == '입금확인'){
        if($(this).parents('.td').next('.td').next('.td').next('.td').next('.td').next('.td').next('.td').text() == "입금완료"){
          alert('이미 ['+action+']된 건이 존재합니다.');
          falseFlag = true;
          return false;
        }
      }
      if(action == '입금확인취소'){
        if($(this).parents('.td').next('.td').next('.td').next('.td').next('.td').next('.td').next('.td').text() == "입금전"){
          alert('['+action+']가 되지않은 건이 존재합니다.');
          falseFlag = true;
          return false;
        }
      }
    }
  });

  if(falseFlag){
    return false;
  }

  if(!confirm('['+action+']처리 하시겠습니까?')){
    return false;
  }

  $.ajax({
      url:"/admin/"+url,
      type: "POST",
      datatype: 'JSON',
      data: {'order_id':checkBoxArray},
      error:function(request,status,error){
        alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
      window.location.reload();
      }
  });
}

/*********************************************************
    그리드 조회 로직
**********************************************************/
function search(mode){
  var ODID='';
  var FOID='';
  var FRDT='';
  var TODT='';
  var USER_INFO_DV='0000';
  var USER_INFO_VALUE='';
  var IS_PAID='0000';
  var IS_FORDER='0000';
  var PROGRESS='0000';
  var ORDER_STAT='0000';
  var FORDER_STAT='0000';
  var PAGE='';
  var Param='';
  FRDT = $('.divSearch .FRDT').val();
  TODT = $('.divSearch .TODT').val();
  PAGE = $('.selectPage').val();
  if(mode=='paymentList'){
    ODID = $('.divSearch .ODID').val();
    USER_INFO_DV = $('.divSearch .USER_INFO_DV').val();
    USER_INFO_VALUE = $('.divSearch .USER_INFO_VALUE').val();
    IS_PAID = $('.divSearch .IS_PAID').val();
    IS_FORDER = $('.divSearch .IS_FORDER').val();
  }else if(mode=='createForder'){
    ODID = $('.divSearch .ODID').val();
    USER_INFO_DV = $('.divSearch .USER_INFO_DV').val();
    USER_INFO_VALUE = $('.divSearch .USER_INFO_VALUE').val();
    IS_PAID = $('.divSearch .IS_PAID').val();
  }else if(mode=='writeModifiedForder'){
    PROGRESS = $('.divSearch .PROGRESS').val();
    FOID = $('.divSearch .FOID').val();
  }else if(mode=='writeConfirmedForder'){
    FOID = $('.divSearch .FOID').val();
  }else if(mode=='writeForder'){
    FOID = $('.divSearch .FOID').val();
  }else if(mode=='readyProduct'){
    ODID = $('.divSearch .ODID').val();
    USER_INFO_DV = $('.divSearch .USER_INFO_DV').val();
    USER_INFO_VALUE = $('.divSearch .USER_INFO_VALUE').val();
    IS_PAID = $('.divSearch .IS_PAID').val();
    PROGRESS = $('.divSearch .PROGRESS').val();
  }else if(mode=='onDelivery'){
    ODID = $('.divSearch .ODID').val();
    USER_INFO_DV = $('.divSearch .USER_INFO_DV').val();
    USER_INFO_VALUE = $('.divSearch .USER_INFO_VALUE').val();
  }else if(mode=='orderAllList'){
    ODID = $('.divSearch .ODID').val();
    FOID = $('.divSearch .FOID').val();
    USER_INFO_DV = $('.divSearch .USER_INFO_DV').val();
    USER_INFO_VALUE = $('.divSearch .USER_INFO_VALUE').val();
    IS_PAID = $('.divSearch .IS_PAID').val();
    ORDER_STAT = $('.divSearch .ORDER_STAT').val();
    FORDER_STAT = $('.divSearch .FORDER_STAT').val();
  }else if(mode=='forderConfirm'){
    FOID = $('.divSearch .FOID').val();
  }
  if(ODID != ''){
    Param = Param + 'ODID='+ODID+'&';
  }
  if(FOID != ''){
    Param = Param + 'FOID='+FOID+'&';
  }
  if(FRDT != '' && TODT != ''){
    Param = Param + 'TODT='+TODT+'&FRDT='+FRDT+'&';
  }
  if(USER_INFO_DV != '0000' && USER_INFO_VALUE != ''){
    Param = Param + 'USER_INFO_DV='+USER_INFO_DV+'&'+'USER_INFO_VALUE='+USER_INFO_VALUE+'&';
  }
  if(IS_PAID != '0000'){
    Param = Param + 'IS_PAID='+IS_PAID+'&';
  }
  if(IS_FORDER != '0000'){
    Param = Param + 'IS_FORDER='+IS_FORDER+'&';
  }
  if(PROGRESS != '0000'){
    Param = Param + 'PROGRESS='+PROGRESS+'&';
  }
  if(ORDER_STAT != '0000'){
    Param = Param + 'ORDER_STAT='+ORDER_STAT+'&';
  }
  if(FORDER_STAT != '0000'){
    Param = Param + 'FORDER_STAT='+FORDER_STAT+'&';
  }
  if(PAGE != ''){
    Param = Param + 'PAGE='+PAGE+'&';
  }
  location.href = mode+'?'+Param;
}

/*********************************************************
    발주서작성 로직
**********************************************************/
function forderDraftWriteBtn(){
  var checkBoxAraay = new Array();
  var rowCnt = 0;
  var falseFlag = '';
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      checkBoxAraay[rowCnt] = $(this).parents('.td').next('.td').next('.td').text();
      if($(this).parents('.td').next('.td').next('.td').next('.td').next('.td').next('.td').next('.td').next('.td').text()=='Y'){
        falseFlag = 'alreadyFoder';
      }
      rowCnt++;
    }
  });

  if(rowCnt == 0){
    alert('선택된 주문이 없습니다.');
    return false;
  }

  if(falseFlag != ''){
    if(falseFlag == 'alreadyFoder'){
      alert('이미 발주요청된 건이 포함되어있습니다.');
    }
    return false;
  }

  popupForderWrite(checkBoxAraay);
}

/*********************************************************
    주문상세 팝업 열기
**********************************************************/
function popupDetail(orderID){
  var windowW = 641;  // 창의 가로 길이
  var windowH = 900;  // 창의 세로 길이
  var left = Math.ceil((window.screen.width - windowW)/2);
  var top = Math.ceil((window.screen.height - windowH)/2-50);
  var popUrl = "/admin/popupOrderDetail/"+orderID;
  window.open(popUrl,"pop_01","l top="+top+", left="+left+", height="+windowH+", width="+windowW);
}

/*********************************************************
   추가발주 팝업열기
**********************************************************/
function popupAddForder(orderID){
  var windowW = 1200;  // 창의 가로 길이
  var windowH = 850;  // 창의 세로 길이
  var left = Math.ceil((window.screen.width - windowW)/2);
  var top = Math.ceil((window.screen.height - windowH)/2-50);
  var popUrl = "/admin/popupAddForder/"+orderID;
  console.log(popUrl,"pop_01"," top="+top+", left="+left+", height="+windowH+", width="+windowW);
  window.open(popUrl,"","height="+windowH+", width="+windowW);
}

/*********************************************************
    발주서작성 팝업1 열기
**********************************************************/
function popupForderWrite(orderIDArray){
  var idList='';
  for(var rowCnt=0; orderIDArray.length > rowCnt; rowCnt++){
    idList = idList + orderIDArray[rowCnt];
  }
  var windowW = 641;  // 창의 가로 길이
  var windowH = 900;  // 창의 세로 길이
  var left = Math.ceil((window.screen.width - windowW)/2);
  var top = Math.ceil((window.screen.height - windowH)/2-50);
  var popUrl = "/admin/popupForderPreview?IDA="+idList;
  window.open(popUrl,"pop_01","l top="+top+", left="+left+", height="+windowH+", width="+windowW);
}

/*********************************************************
    발주서작성 팝업2 열기
**********************************************************/
function popupWriteForder(forderID,progress){
  var windowH = 850;
  var windowW = 1200;
  var left = Math.ceil((window.screen.width - windowW)/2);
  var top = Math.ceil((window.screen.height - windowH)/2-50);
  var popUrl = "/admin/popupWriteForder?FODID="+forderID+"&MODE="+progress;
  window.open(popUrl,"pop_01","top="+top+", left="+left+", height="+windowH+", width="+windowW);
}

/*********************************************************
    (발주품수령) 발주서/수정발주서 팝업 열기
**********************************************************/
function popupCompleteForder(mode,id){
  var windowH = 850;
  var windowW = 1200;
  var left = Math.ceil((window.screen.width - windowW)/2);
  var top = Math.ceil((window.screen.height - windowH)/2-50);
  var popUrl = "/admin/popupWriteForder?FODID="+id+"&MODE="+mode;
  if(mode=='init'){
    popUrl = "/admin/popupWriteForder?FODID="+id+"&MODE="+mode;
  }
  console.log("top="+top+", left="+left+", height="+windowH+", width="+windowW);
  window.open(popUrl,"pop_01","top="+top+", left="+left+", height="+windowH+", width="+windowW);
}

/*********************************************************
    발주상태변경 로직
**********************************************************/
function ajaxByForderID(action,url){
  var currentAction = action;
  var checkBoxArray = new Array();
  var rowCnt = 0;
  var falseFlag = false;
  var setProgress = '';
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      checkBoxArray[rowCnt] = $(this).parents('.td').next('.td').next('.td').text();
      rowCnt++;
    }
  });

  if(rowCnt == 0){
    alert('선택된 주문이 없습니다.');
    return false;
  }

  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      if(action == '발주접수'){
        setProgress = '20';
        if($(this).parents('.td').parents('.tr').children('.prg').children('input').val() != "10"){
          alert('이미 ['+action+']된 건이 존재합니다.');
          falseFlag = true;
          return false;
        }
      }
      if(action == '발주취소'){
        if($(this).parents('.td').parents('.tr').children('.prg').children('input').val() != "10"){
          alert('[발주요청] 상태만 발주취소가 가능합니다.');
          falseFlag = true;
          return false;
        }
      }
      if(action == '수정발주서 접수'){
        setProgress = '40';
      }
      if(action == '발주품 반송'){
        setProgress = '25';
      }
    }
  });

  if(falseFlag){
    return false;
  }

  if(!confirm('['+action+']처리 하시겠습니까?')){
    return false;
  }

  $.ajax({
      url:"/admin/"+url,
      type: "POST",
      datatype: 'JSON',
      data: {'forder_id':checkBoxArray,'progress':setProgress},
      error:function(request,status,error){
        alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
      window.location.reload();
      }
  });
}

/*********************************************************
    주문상태변경 로직
**********************************************************/
function ajaxByOrderID(action,url){
  var currentAction = action;
  var checkBoxArray = new Array();
  var rowCnt = 0;
  var falseFlag = false;
  var setProgress = '';
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      checkBoxArray[rowCnt] = $(this).parents('.td').next('.td').next('.td').text();
      rowCnt++;
    }
  });

  if(rowCnt == 0){
    alert('선택된 주문이 없습니다.');
    return false;
  }

  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      if(action == '배송중'){
        setProgress = '30';
        if($(this).parents('.td').parents('.tr').children('.forderStat').children('input').val() != "40"){
          alert('[발주완료]건 만 ['+action+']처리할 수 있습니다.');
          falseFlag = true;
          return false;
        }
      }
      if(action == '배송완료'){
        setProgress = '40';
        if($(this).parents('.td').parents('.tr').children('.orderStat').children('input').val() == "40"){
          alert('이미 [배송완료]된 건이 존재합니다.');
          falseFlag = true;
          return false;
        }
      }
    }
  });

  if(falseFlag){
    return false;
  }

  if(!confirm('['+action+']처리 하시겠습니까?')){
    return false;
  }

  $.ajax({
      url:"/admin/"+url,
      type: "POST",
      datatype: 'JSON',
      data: {'order_id':checkBoxArray,'progress':setProgress},
      error:function(request,status,error){
        alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
      window.location.reload();
      }
  });
}

$(document).ready(function(){

});
