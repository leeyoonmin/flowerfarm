/************************************************************************
    가계부 그리드 드래그 이벤트 및 로직
*************************************************************************/
var mouseStart = 0;
var mousePotint = 0;
var clickPosition = 0 ;
$(".divLedger").mousedown(function(e) {
  $(document).on('mousemove',function(e){
    if(mouseStart == 0){
      mouseStart = getMousePos(e).x;
    }
    if(clickPosition == 0){
      clickPosition = $(".divLedgerLayout").scrollLeft();
    }
    mousePotint = getMousePos(e).x;
    $(".divLedgerLayout").scrollLeft(clickPosition-(mousePotint - mouseStart));
  });
});
$(".divLedger").mouseup(function(e) {
  $(document).off();
  mouseStart = 0;
  clickPosition = 0;
});
function getMousePos(e) {
  return {x:e.clientX,y:e.clientY};
}


/************************************************************************
    화면 로드완료 시 실행 로직
*************************************************************************/
$(document).ready(function(){
  var yy = $('.divLedgerCalendarButton .year').val();
  var mm = $('.divLedgerCalendarButton .month').val();
  if(document.body.scrollWidth>1024){
    setScrollbar('pc',mm);
  }else{
    setScrollbar('mobile',mm);
  }
});

function setScrollbar(mode,mm){
  if(mode == 'pc'){
    if(mm == 4){
      $(".divLedgerLayout").scrollLeft(270);
    }else if(mm == 5){
      $(".divLedgerLayout").scrollLeft(270+(250*(mm-4)));
    }else if(mm == 6){
      $(".divLedgerLayout").scrollLeft(270+(250*(mm-4)));
    }else if(mm == 7){
      $(".divLedgerLayout").scrollLeft(270+(250*(mm-4)));
    }else if(mm == 8){
      $(".divLedgerLayout").scrollLeft(270+(250*(mm-4)));
    }else if(mm == 9){
      $(".divLedgerLayout").scrollLeft(270+(250*(mm-4)));
    }else if(mm > 9){
      $(".divLedgerLayout").scrollLeft(270+(250*(mm-4)));
    }
  }else{
    if(mm == 2){
      $(".divLedgerLayout").scrollLeft(192);
    }else if(mm == 3){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm == 4){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm == 5){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm == 6){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm == 7){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm == 8){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm == 9){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm > 9){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm > 10){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm > 11){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }else if(mm > 12){
      $(".divLedgerLayout").scrollLeft(192+(250*(mm-2)));
    }
  }
}



/************************************************************************
    월별 달력 날짜 선택 버튼 클릭 이벤트
*************************************************************************/
$('.month .divLedgerCalendarButton input[type="button"]').click(function(e){
  var year, month;
  year = $('.divLedgerCalendarButton .date').val();
  if($(this).hasClass('prev')){
    if((Number(year)-1)==0){
      year = 1;
    }else{
      year = Number(year) - 1;
    }
  }else if($(this).hasClass('next')){
    year = Number(year) + 1
  }
  location.href = location.pathname+"?year="+String(year);
});

$('.calendar .divLedgerCalendarButton input[type="button"]').click(function(e){
  var date = $('.divLedgerCalendarButton .date').val().split(".");
  year = date[0];
  month = date[1];
  if($(this).hasClass('prev')){
    if((Number(month)-1)==0){
      month = 12;
      year = Number(year) - 1;
    }else{
      month = Number(month) - 1;
    }
  }else if($(this).hasClass('next')){
    if((Number(month)+1)==13){
      month = 1;
      year = Number(year) + 1;
    }else{
      month = Number(month) + 1;
    }
  }
  location.href = location.pathname+"?year="+String(year)+"&month="+String(month);
});

/************************************************************************
    월별 달력 박스 선택 이벤트
*************************************************************************/
$('.divLedgerCalendar td.is_day').click(function(e){
  var year = $('.divLedgerCalendarButton .year').val();
  var month = $(this).attr('month');
  month = lpad(month,2,0);
  var day = $(this).attr('day');
  day = lpad(day,2,0);
  location.href="/ledger/daily?year="+year+"&month="+month+"&day="+day;
});

$('.divLedger .divMonth .divTitle').click(function(e){
  var month = $(this).children('h1').text().replace(/[^0-9]/g,'');
  var year = $('.divLedgerCalendarButton .date').val();
  month = lpad(month,2,0);
  console.log(year, month);
  location.href= "/ledger/calendar?year="+year+"&month="+month
});

/*************************************************************
    가계부 작성 버튼 클릭 이벤트
*************************************************************/
$('.divLedgerControlBox .addLedger').click(function(e){
  location.href = "/ledger/writeLedger";
});


/*************************************************************
    가계부 작성팝업 구분 라디오 버튼 클릭이벤트
*************************************************************/
$('.write .divWriteForm .radio_btn .item').click(function(){
  if($(this).attr('data')=='01'){
    $('.selectCateType1').removeClass('hidden');
    $('.selectCateType1').addClass('selected');
    $('.selectCateType2').addClass('hidden');
    $('.selectCateType2').removeClass('selected');
  }else{
    $('.selectCateType2').removeClass('hidden');
    $('.selectCateType2').addClass('selected');
    $('.selectCateType1').addClass('hidden');
    $('.selectCateType1').removeClass('selected');
  }
});

/*************************************************************
    (가계부 작성) 가격정보 입력 이벤트
*************************************************************/
$('.write .divWriteForm .price').on("change keyup paste", function(e){
  var str = $(this).val();
  str = str.replace(/[^0-9]/g,'');
  $(this).val(comma(str));
});

/*************************************************************
    (가계부 작성) 저장하기 버튼 클릭
*************************************************************/
$('.write .divWriteForm input[type="submit"]').click(function(e){
  if($('.write .divWriteForm .date').val() == ""){
    alert('날짜를 선택해주세요.');
    return false;
  }else if($('.write .divWriteForm select.selected').val() == "0000"){
    alert('분류를 선택해주세요.');
    return false;
  }else if($('.write .divWriteForm .text').val() == ""){
    alert('내용을 입력해주세요.');
    return false;
  }else if($('.write .divWriteForm .price').val() == ""){
    alert('가격을 입력해주세요.');
    return false;
  }

});


/*************************************************************
    (일일) 가계부 내역 버튼 클릭 이벤트
*************************************************************/
$('.daily .divLedgerLayout .divLedgerDailyList table .modifyBtn').click(function(e){
  var IDXKEY = $(this).parents('td').parents('tr').attr('idxkey');
  var IS_LEDGER = $(this).parents('td').parents('tr').attr('is_ledger');
  if(IS_LEDGER == 'N'){
    alert('꽃팜 구매정보는 삭제/수정이 불가능합니다.');
    return false;
  }
  location.href = "/ledger/updateLedger/"+IDXKEY;
});

$('.daily .divLedgerLayout .divLedgerDailyList table .deleteBtn').click(function(e){
  var IDXKEY = $(this).parents('td').parents('tr').attr('idxkey');
  var IS_LEDGER = $(this).parents('td').parents('tr').attr('is_ledger');
  if(IS_LEDGER == 'N'){
    alert('꽃팜 구매정보는 삭제/수정이 불가능합니다.');
    return false;
  }
  if(!confirm('정말 삭제하시겠습니까?')){
    return false;
  }
  location.href = "/ledger/deleteLedger/"+IDXKEY;
});
/*************************************************************
    (일별) 날짜 이동 버튼 클릭 이벤트
*************************************************************/
$('.daily .divLedgerCalendarButton input[type="button"]').click(function(e){
  var YEAR = $('.divLedgerCalendarButton .year').val();
  var MONTH = $('.divLedgerCalendarButton .month').val();
  var DAY = $('.divLedgerCalendarButton .day').val();
  var setDate = new Date(YEAR, MONTH, DAY);

  if($(this).hasClass('prev')){
    setDate.setDate(setDate.getDate() - 1);
    YEAR = setDate.getFullYear();
    MONTH = lpad(String(setDate.getMonth()),2,0);
    DAY = lpad(String(setDate.getDate()),2,0);
    location.href = location.pathname+'?year='+YEAR+'&month='+MONTH+'&day='+DAY;
  }else if($(this).hasClass('next')){
    setDate.setDate(setDate.getDate() + 1);
    YEAR = setDate.getFullYear();
    MONTH = lpad(String(setDate.getMonth()),2,0);
    DAY = lpad(String(setDate.getDate()),2,0);
    location.href = location.pathname+'?year='+YEAR+'&month='+MONTH+'&day='+DAY;
  }
});

/*************************************************************
    (가계부작성) 카테고리 편집 버튼 클릭 이벤트
*************************************************************/
$('.write .divWriteForm .editCate').click(function(e){
  location.href = "/ledger/editCate";
});

/*************************************************************
    (카테고리편집) 삭제 버튼 클릭 이벤트
*************************************************************/
$('.editCate .divTypeList .deleteBtn').click(function(e){
  if(!confirm('정말 삭제하시겠습니까?')){
    return false;
  }
  var target = $(this);
  var TYPE = $(this).parents('td').parents('tr').attr('type');
  var CATE = $(this).parents('td').parents('tr').attr('cate');
  if(CATE == ""){
    target.parents('td').parents('tr').remove();
  }else{
    $.ajax({
        url:"/ledger/ajaxDeleteCate",
        type: "POST",
        datatype: 'JSON',
        data: {'TYPE':TYPE , 'CATE':CATE},
        error:function(request,status,error){
          console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        },
        success: function(data){
          console.log('Ok');
          target.parents('td').parents('tr').remove();
        }
    });
  }
});

/*************************************************************
    (카테고리편집) 수정 버튼 클릭 이벤트
*************************************************************/
$('.editCate .divTypeList .modifyBtn').click(function(e){
  $(this).parents('td').prev('td').children('input').prop('readonly',false).focus();
});

/*************************************************************
    (카테고리편집) 인풋창 벗어나면 readonly =? true
*************************************************************/
$('.editCate .divTypeList input').blur(function(e){
  $(this).prop('readonly',true);
})

/*************************************************************
    (카테고리편집) 추가 버튼 클릭 이벤트
*************************************************************/
$('.editCate .divTypeList .addBtn').click(function(e){
  var TYPE = $(this).attr('type');
  if(TYPE == '01'){
    $('.editCate .divType1List table').append('<tr type="01" cate=""><td><input type="text" value="" readonly></td><td><img class="modifyBtn" src="/static/img/icon/ic_pencil_gray.png"><img class="deleteBtn" src="/static/img/icon/ic_trash_gray.png"></td></tr>');
    $('.editCate .divType1List tr:last-of-type').prop('readonly',false).focus();
  }else if(TYPE == '02'){
    $('.editCate .divType2List table').append('<tr type="02" cate=""><td><input type="text" value="" readonly></td><td><img class="modifyBtn" src="/static/img/icon/ic_pencil_gray.png"><img class="deleteBtn" src="/static/img/icon/ic_trash_gray.png"></td></tr>');
  }
  $('.editCate .divTypeList .modifyBtn').off();
  $('.editCate .divTypeList .modifyBtn').click(function(e){
    $(this).parents('td').prev('td').children('input').prop('readonly',false).focus();
  });
  $('.editCate .divTypeList input').blur(function(e){
    $(this).prop('readonly',true);
  });
  $('.editCate .divTypeList .deleteBtn').off();
  $('.editCate .divTypeList .deleteBtn').click(function(e){
    if(!confirm('정말 삭제하시겠습니까?')){
      return false;
    }
    var target = $(this);
    var TYPE = $(this).parents('td').parents('tr').attr('type');
    var CATE = $(this).parents('td').parents('tr').attr('cate');
    if(CATE == ""){
      target.parents('td').parents('tr').remove();
    }else{
      $.ajax({
          url:"/ledger/ajaxDeleteCate",
          type: "POST",
          datatype: 'JSON',
          data: {'TYPE':TYPE , 'CATE':CATE},
          error:function(request,status,error){
            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
          },
          success: function(data){
            console.log('Ok');
            target.parents('td').parents('tr').remove();
          }
      });
    }
  });
})

/*************************************************************
    (카테고리편집) 저장 버튼 클릭 이벤트
*************************************************************/
$('.editCate input[type="submit"]').click(function(){
  var List = new Array();
  var count = 0;
  $('.editCate .divTypeList tr').each(function(){
    var TYPE = $(this).attr('type');
    var CATE = $(this).attr('cate');
    var TEXT = $(this).children('td').children('input').val();
    List.push({'type':TYPE, 'cate':CATE, 'text':TEXT});
  });
  $.ajax({
      url:"/ledger/ajaxAddCate",
      type: "POST",
      datatype: 'JSON',
      data: {'LIST':List},
      error:function(request,status,error){
        console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
      },
      success: function(data){
        location.reload();
      }
  });
})

/*************************************************************
    (대쉬보드) 검색섹션 수입/지출 버튼 클릭이벤트
*************************************************************/
$('.dashboard .typeBtn').click(function(){
  var CurrentPage = $('.CurrentType').val();
  if($(this).hasClass('plus')){
    if(CurrentPage == "plus"){
      return false;
    }else{
      $('.CurrentType').val('plus');
      var pluscnt = 0;
      $('.dashboard .chartPlus').css('display','block');
      $('.dashboard .gridPlus').css('display','block');
      $('.dashboard .chartMinus').css('display','none');
      $('.dashboard .gridMinus').css('display','none');
    }
  }else if($(this).hasClass('minus')){
    if(CurrentPage == "minus"){
      return false;
    }else{
      $('.CurrentType').val('minus');
      var minuscnt = 0;
      $('.dashboard .chartPlus').css('display','none');
      $('.dashboard .gridPlus').css('display','none');
      $('.dashboard .chartMinus').css('display','block');
      $('.dashboard .gridMinus').css('display','block');
    }
  }
  $('.dashboard .typeBtn').removeClass('selected');
  $(this).addClass('selected');

});
/*************************************************************
    (대쉬보드) 검색섹션 월간/년간 변경 이벤트
*************************************************************/
$('.dashboard .modeSelect').change(function(){
  location.href=location.pathname+"?mode="+$(this).val();
});
/*************************************************************
    (대쉬보드) 검색섹션 날짜이동 이벤트
*************************************************************/
$('.dashboard .calendarBtn').click(function(){
  var date = $('.dashboard .calendarDate').val().replace(/[^0-9]/g,'');
  var year = date.substring(0,4);
  var month = date.substring(4,6);
  console.log(year,month);
  if($(this).hasClass('prev')){
    if($('.dashboard .modeSelect').val()=="m"){
      month --;
      if(month==0){
        month = 12;
        year--;
      }
    }else if($('.dashboard .modeSelect').val()=="y"){
      year--;
    }
  }else if($(this).hasClass('next')){
    if($('.dashboard .modeSelect').val()=="m"){
      month++;
      if(month==13){
        month=1;
        year++;
      }
    }else if($('.dashboard .modeSelect').val()=="y"){
      year++;
    }
  }
  if($('.dashboard .modeSelect').val()=="m"){
    location.href = location.pathname+"?mode=m&year="+year+"&month="+month;
  }else if($('.dashboard .modeSelect').val()=="y"){
    location.href = location.pathname+"?mode=y&year="+year;
  }
});

/*************************************************************
    (대쉬보드) 검색섹션 날짜이동 이벤트
*************************************************************/
$('.dashboard.detail .calendarBtn').click(function(){
  var date = $('.dashboard .calendarDate').val().replace(/[^0-9]/g,'');
  var year = date.substring(0,4);
  var type = $('.TYPE_HD').val();
  var cate = $('.CATE_HD').val();
  var catenm = $('.highcharts-legend tspan').text();
  if($(this).hasClass('prev')){
      year--;
  }else if($(this).hasClass('next')){
      year++;
  }
  location.href = location.pathname+"?year="+year+"&type="+type+"&cate="+cate+"&catenm="+catenm;
});

/*************************************************************
    (대쉬보드) 그리드 로우 클릭이벤트
*************************************************************/
$('.dashboard .divGrid tr').click(function(e){
  var DATE = $('.dashboard .calendarDate').val().replace(/[^0-9]/g,'');
  var YEAR = DATE.substring(0,4);
  var TYPE = $(this).attr('type');
  var CATE = $(this).attr('cate');
  location.href = location.pathname + 'Detail?year=' + YEAR + '&type=' + TYPE + '&cate=' + CATE;
});

$('.dashboard .divGrid2 td').click(function(e){
  var year = $(this).attr('year');
  var month = $(this).attr('month');
  location.href = '/ledger/calendar?year=' + year + '&month=' + month;
});
