/***************************************
  왼쪽 슬라이드 메뉴 클릭 이벤트
***************************************/
$('.mainMenu').click(function(e){
  var target = "";
  if($(e.target).prop('tagName')=='LI'){
    target = $(e.target);
  }else{
    target = $(e.target).parents();
  }

  $('.mainMenu').removeClass('selected');
  $('.mainMenu').addClass('non_selected');
  target.removeClass('non_selected');
  target.addClass('selected');
  $('.non_selected').next('ul').slideUp();

  if(target.next('ul').hasClass('menuUp')){
    $('.menuDown').slideUp();
    $('.menuDown').addClass('menuUp');
    $('.menuDown').removeClass('menuDown');

    target.next('ul').removeClass('menuUp');
    target.next('ul').addClass('menuDown');
    target.next('ul').slideDown();
  }else{
    target.next('ul').removeClass('menuDown');
    target.next('ul').addClass('menuUp');
    target.next('ul').slideUp();
  }
});

/***************************************
  탑왼쪽 슬라이드 메뉴 배경 클릭 이벤트
***************************************/
$('.divFixedLeftMenuBG').click(function(e){
  $('.divFixedLeftMenu').transition('fade right');
  $('.divFixedLeftMenuBG').fadeOut('fast');
});

/***************************************
  탑 고정 네비게이션 햄버거 버튼 클릭 이벤트
***************************************/
$('.hamBtn').click(function(e){
  $('.divFixedLeftMenu').transition('fade right');
  $('.divFixedLeftMenuBG').fadeIn('fast');
});

/***************************************
  왼쪽 슬라이드 메뉴 탑 클로즈 버튼 이벤트
***************************************/
$('.divLeftMenuTopHeader .closeBtn').click(function(e){
  $('.divFixedLeftMenu').transition('fade right');
  $('.divFixedLeftMenuBG').fadeOut('fast');
});

/***************************************
  전체 체크 클릭 이벤트
***************************************/
$('#all_checked').click(function(e){
  var is_check = $(e.target).prop('checked');
  $('.checkBox').prop('checked',is_check);
});


/***************************************
  전체 체크 클릭 이벤트
***************************************/
$('.tr.body.isCheck').click(function(e){
  var is_check = $(e.target).parents('.tr').children('.isCheck').children('input').prop('checked');
  $(e.target).parents('.tr').children('.isCheck').children('input').prop('checked',!is_check);
  //$('.checkBox').prop('checked',is_check);
});

/***************************************
  전체 체크 클릭 이벤트
***************************************/
$('.tr.body.isOneCheck').click(function(e){
  var is_check = $(this).children('.isOneCheck').children('input').prop('checked');
  if(!is_check){
    $('.isOneCheck').children('input').prop('checked',false);
    $(this).children('.isOneCheck').children('input').prop('checked',true);
  }else{
    $(this).children('.isOneCheck').children('input').prop('checked',false);
  }
});


/***************************************
  달력출력
***************************************/
function setCalendar(getYear,getMonth){
  var day=1;
  var date = new Date();
  var yearNow = date.getFullYear();
  var monthNow = date.getMonth() + 1;
  var dayNow = date.getDate();
  var firstDayStrOfMonth = new Date(getYear+'-'+getMonth+'-01').getDay();
  firstDayStrOfMonth = Number(firstDayStrOfMonth);
  var lastDayOfMonth = ( new Date(getYear, getMonth, 0) ).getDate();
  $('.calendar .calendarBox table td').removeClass('today');
  $('.calendar .calendarBox table td').removeClass('able');
  $('.calendar .calendarBox table td').removeClass('unable');
  if(firstDayStrOfMonth==7){
    firstDayStrOfMonth=0;
  }
  for(var weeks=1; weeks<7; weeks++){
    for(var dayOfWeeks=0;dayOfWeeks<7;dayOfWeeks++){
      var pos = dayOfWeeks+((weeks-1)*7);
      $('.calendar .calendarBox table .pos'+(pos)).html('');
      if(pos>=firstDayStrOfMonth && day<=lastDayOfMonth){
        $('.calendar .calendarBox table .pos'+(pos)).addClass('is_day').html('<a>'+day+'</a>');
        if(day == dayNow && getMonth == monthNow){
          $('.calendar .calendarBox table .pos'+(pos)).addClass('today');
        }
        if((yearNow >= getYear && monthNow > getMonth)||(monthNow == getMonth && dayNow >=day)){
          $('.calendar .calendarBox table .pos'+(pos)).addClass('able');
        }else{
          if(dayOfWeeks == 1 || dayOfWeeks == 3 || dayOfWeeks == 5){
            $('.calendar .calendarBox table .pos'+(pos)).addClass('able');
          }else{
            $('.calendar .calendarBox table .pos'+(pos)).addClass('able');
          }
        }
        day++;
      }
    }
  }
}

/***************************************
  이전달 이동
***************************************/
$('.calendar .buttonBox .prev_month_btn').click(function(e){
  var getDate = $('.dateNow').val();
  var getDateArray = getDate.split(".");
  var getYear = getDateArray[0];
  var getMonth = getDateArray[1];
  getMonth = Number(getMonth) - 1;
  if(getMonth == 0){
    getYear = Number(getYear) - 1;
    getMonth = 12;
  }
  $('.dateNow').val(getYear+"."+getMonth);
  setCalendar(getYear,getMonth);
  setClickEvent();
});

/***************************************
  다음달 이동
***************************************/
$('.calendar .buttonBox .next_month_btn').click(function(e){
  var getDate = $('.dateNow').val();
  var getDateArray = getDate.split(".");
  var getYear = getDateArray[0];
  var getMonth = getDateArray[1];
  getMonth = Number(getMonth) + 1;
  if(getMonth == 13){
    getYear = Number(getYear) + 1;
    getMonth = 1;
  }
  $('.dateNow').val(getYear+"."+getMonth);
  setCalendar(getYear,getMonth);
  setClickEvent();
});

/***************************************
  달력이벤트 등록
***************************************/
function setClickEvent(){
  $('.able').click(function(e){
    if($(e.target).prop('tagName')=="A"){
      var getDate = $('.dateNow').val();
      var getDateArray = getDate.split(".");
      var getYear = getDateArray[0];
      var getMonth = getDateArray[1];
      var getDay = $(e.target).html();
    }
  });
}

/***************************************
  달력열기버튼 클릭 이벤트
***************************************/
var fromORto;
$('.openCalendar').click(function(e){

  var leftOffset;
  var topOffset;

  if($(this).hasClass('TODT')){
    fromORto = 'TODT';
  }else if($(this).hasClass('FRDT')){
    fromORto = 'FRDT';
  }

  if($(this).hasClass('btnDatePicker')){
    leftOffset = Math.ceil($(this).prev().offset().left);
    topOffset = Math.ceil($(this).prev().offset().top);
  }else if($(this).hasClass('inputDatePicker')){
    leftOffset = Math.ceil($(this).offset().left);
    topOffset = Math.ceil($(this).offset().top);
  }
  $('.divCalendar').css('top',topOffset+34).css('left',leftOffset);
  $('.divCalendar').transition('fade down');
});

/***************************************
  달력날짜 클릭 이벤트
***************************************/
$('.divCalendar .calendar .able').click(function(e){
  var year = $('.divCalendar .calendar .dateNow').val().substring(0,4);
  var month = $('.divCalendar .calendar .dateNow').val().substring(5,7);
  var day = $(this).text();
  $('.inputDatePicker.'+fromORto).val(year+'-'+lpad(month,2,0)+'-'+lpad(day,2,0));
  $('.divCalendar').transition('fade down');
});

/***************************************
  페이지네이션 페이지클릭 이벤트
***************************************/
$('.divPagenation .Pagenation .countBtn').click(function(e){
  $('.selectPage').val($(this).text());
  search(window.location.pathname.substring(7));
});

$('.divPagenation .Pagenation .firstBtn').click(function(e){
  $('.selectPage').val('1');
  console.log($('.selectPage').val());
  search(window.location.pathname.substring(7));
});

$('.divPagenation .Pagenation .prevBtn').click(function(e){
  $('.selectPage').val($('.divPagenation .currentPage').val()-1);
  if($('.selectPage').val()<1){
    return false;
  }
  search(window.location.pathname.substring(7));
});

$('.divPagenation .Pagenation .nextBtn').click(function(e){
  $('.selectPage').val($('.divPagenation .currentPage').val()+1);
  if($('.selectPage').val() > $('.divPagenation .lastPage').val()){
    return false;
  }
  search(window.location.pathname.substring(7));

});

$('.divPagenation .Pagenation .lastBtn').click(function(e){
  $('.selectPage').val($('.divPagenation .lastPage').val());
  search(window.location.pathname.substring(7));
  console.log($('.selectPage').val());
});

/***************************************
  LPAD 함수
***************************************/
function lpad(s, padLength, padString){

    while(s.length < padLength)
        s = padString + s;
    return s;
}

/***************************************
  RPAD 함수
***************************************/
function rpad(s, padLength, padString){
    while(s.length < padLength)
        s += padString;
    return s;
}
function getNumber(str){
  return str.replace(/[^0-9]/g,'');
}

/***************************************
  온로드 이벤트
***************************************/
$(document).ready(function(){
  $('.divGrid .tr .td input').prop('checked',false);
  if(location.pathname == '/admin/slideBanner'){
    $('.divFixedLeftMenu .divMenu .mainMenu.shop').addClass('selected');
    $('.divFixedLeftMenu .divMenu .mainMenu.shop').next('ul').css('display','block');
  }else if(location.pathname == '/admin/inquiryUserInfo' || location.pathname == '/admin/userGradeMng' || location.pathname == '/admin/setUserNick'){
    $('.divFixedLeftMenu .divMenu .mainMenu.user').addClass('selected');
    $('.divFixedLeftMenu .divMenu .mainMenu.user').next('ul').css('display','block');
  }else if(location.pathname == '/admin/productList' || location.pathname == '/admin/productPriceMng' || location.pathname == '/admin/productCateMng'){
    $('.divFixedLeftMenu .divMenu .mainMenu.product').addClass('selected');
    $('.divFixedLeftMenu .divMenu .mainMenu.product').next('ul').css('display','block');
  }else if(location.pathname == '/admin/paymentList' || location.pathname == '/admin/readyProduct' || location.pathname == '/admin/onDelivery' || location.pathname == '/admin/orderAllList'){
    $('.divFixedLeftMenu .divMenu .mainMenu.order').addClass('selected');
    $('.divFixedLeftMenu .divMenu .mainMenu.order').next('ul').css('display','block');
  }else if(location.pathname == '/admin/forderRequest' || location.pathname == '/admin/createForder' || location.pathname == '/admin/writeForder' || location.pathname == '/admin/writeModifiedForder' || location.pathname == '/admin/writeConfirmedForder' || location.pathname == '/admin/forderAllList'){
    $('.divFixedLeftMenu .divMenu .mainMenu.forder').addClass('selected');
    $('.divFixedLeftMenu .divMenu .mainMenu.forder').next('ul').css('display','block');
  }else if(location.pathname == '/admin/noticeMng' || location.pathname == '/admin/faqMng' || location.pathname == '/admin/questionMng'){
    $('.divFixedLeftMenu .divMenu .mainMenu.board').addClass('selected');
    $('.divFixedLeftMenu .divMenu .mainMenu.board').next('ul').css('display','block');
  }else if(location.pathname == '/admin/commonCodeMng' || location.pathname == '/admin/sqlMng'){
    $('.divFixedLeftMenu .divMenu .mainMenu.code').addClass('selected');
    $('.divFixedLeftMenu .divMenu .mainMenu.code').next('ul').css('display','block');
  }else if(location.pathname == '/admin/accountsList'){
    $('.divFixedLeftMenu .divMenu .mainMenu.account').addClass('selected');
    $('.divFixedLeftMenu .divMenu .mainMenu.account').next('ul').css('display','block');
  }
});
