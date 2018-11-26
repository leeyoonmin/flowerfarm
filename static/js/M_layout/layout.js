/***********************************************************
        화면 로드온 이벤트
***********************************************************/
$(window).load(function(){
  if($('.targetInput').val()==""){
    $('.targetBtn').removeClass('able');
    $('.targetBtn').addClass('disable');
    $('.buttonValue').val('disable');
  }else{
    $('.targetBtn').removeClass('disable');
    $('.targetBtn').addClass('able');
    $('.buttonValue').val('able');
  }
  ////////////////////////슬라이드 장바구니 리스트 높이 설정
  var divSlideCartHeight = $('.divSlideCart').css('height');
  divSlideCartHeight = divSlideCartHeight.replace(/[^0-9]/g,'');

  var divTopHeaderHeight = $('.divSlideCart .divTopHeader').css('height');
  divTopHeaderHeight = divTopHeaderHeight.replace(/[^0-9]/g,'');

  var divCartTotalHeight = $('.divSlideCart .divCartTotal').css('height');
  divCartTotalHeight = divCartTotalHeight.replace(/[^0-9]/g,'');

  var slideCartHeight = divSlideCartHeight - divTopHeaderHeight - 155;
  $('.divSlideCart .divCartList').css('height',slideCartHeight);


  /*
  $(".divSlideCart .divCartList .divItem").bind('touchstart', function(e) {
    console.log('START');
    e.preventDefault();	//	이벤트취소
  });

	$(".divSlideCart .divCartList .divItem").bind('touchmove', function(e) {
	  var event = e.originalEvent;
    if($(event.path[5]).hasClass('shadow_2')){

    }else{
      $('.divTrashBox').animate({'top':'90%'},200);
    }
    $(event.path[5]).addClass('shadow_2').css('z-index','999').css('position','fixed').css('width','280px').css('left',event.touches[0].pageX-50).css('top',event.touches[0].pageY-80);
    event.preventDefault();
	});

  $(".divSlideCart .divCartList .divItem").bind('touchend', function(e) {
    console.log('END');
    $(event.path[5]).removeClass('shadow_2').css('position','static').css('position','static').animate({'width':'100%'});
    $('.divTrashBox').animate({'top':'120%'},200);
  });
  */
  $('#tel2').on("change keyup paste", function(e){
    var str = $('#tel2').val();
    str = str.replace(/[^0-9]/g,'');
    $('#tel2').val(str);
    if(str.length > 3){
      $('#tel3').focus();
    }
  });

  $('#tel3').on("change keyup paste", function(e){
    var str = $('#tel3').val();
    str = str.replace(/[^0-9]/g,'');
    $('#tel3').val(str);
  });

});
/*********************************************
        탑헤더 메뉴버튼 클릭 이벤트
*********************************************/
$('.divTopHeader .hamBtn').click(function(e){
  $('.divSlideMenu').css('display','block').animate({'left':'0px'},300);
  //$('.divSlideMenuBG').transition('fade');
  $('.divSlideMenuBG').fadeIn('fast');
});
$('.divSlideMenuBG').click(function(e){
  $('.divSlideMenu').animate({'left':'-120%'},300,function(){$('.divSlideMenu').css('display','none')});
  //$('.divSlideMenuBG').transition('fade');
  $('.divSlideMenuBG').fadeOut('fast');
});

/*********************************************
        탑헤더 카트버튼 클릭 이벤트
*********************************************/
$('.divTopHeader .cartBtn').click(function(e){
  $('.divSlideCart').animate({'left':'25%'},300).css('display','block');
  //$('.divSlideCartBG').transition('fade');
  $('.divSlideCartBG').fadeIn('fast');
});
$('.divSlideCartBG').click(function(e){
  $('.divSlideCart').animate({'left':'120%'},300,function(){$('.divSlideCart').css('display','none')});
  //$('.divSlideCartBG').transition('fade');
  $('.divSlideCartBG').fadeOut('fast');
});
$('.divSlideMenu .hamCloseBtn').click(function(e){
  $('.divSlideMenu').animate({'left':'-120%'},300,function(){$('.divSlideMenu').css('display','none')});
  //$('.divSlideMenuBG').transition('fade');
  $('.divSlideMenuBG').fadeOut('fast');
});

/*********************************************
        PC 카트버튼 클릭 이벤트
*********************************************/
$('.divCartCallBtn').click(function(e){
  if($(this).hasClass('close')){
    $('.divSlideCart').animate({'left':'0px'},250);
    $(this).removeClass('close');
    $(this).addClass('open');
  }else{
    $('.divSlideCart').animate({'left':'-300px'},300);
    $(this).removeClass('open');
    $(this).addClass('close');
  }
});


/*********************************************
    특정 INPUT 입력시 비활성화 버튼 -> 활성화
*********************************************/
$('.targetInput').on("change keyup paste", function(e){
  if($(this).val()==""){
    $('.targetBtn').removeClass('able');
    $('.targetBtn').addClass('disable');
    $('.buttonValue').val('disable');
  }else{
    $('.targetBtn').removeClass('disable');
    $('.targetBtn').addClass('able');
    $('.buttonValue').val('able');
  }
});

/***********************************************************
        타겟 버튼 클릭 시
***********************************************************/
$('.targetBtn').click(function(e){
  if($('.buttonValue').val()=='able'){
    return true;
  }else{
    return false;
  }
});

/***********************************************************
        숫자 콤마 붙이는 로직
***********************************************************/
function commas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}


/***********************************************************
      슬라이드 메뉴 터치 시 뒤 엘리멘트는 동작 무시
***********************************************************/
$('.divSlideCartBG').bind('touchmove',function(e){
	event.preventDefault();
});
$('.divSlideMenu').bind('touchmove',function(e){
	event.preventDefault();
});
$('.divSlideMenuBG').bind('touchmove',function(e){
  event.preventDefault();
});
$('.divLoader').bind('touchmove',function(e){
  event.preventDefault();
});

/***********************************************************
        슬라이드 카드 총계 업데이트
***********************************************************/
function updateCartTotal(){
  $.ajax({
        type:"POST",
        url:"/cart/ajaxCartTotalPrice",
        data : {},
        dataType : "json",
        success: function(res){
          $('.divSlideCart .divCartTotal .productPrice').text(comma(res['price'])+'원');
          $('.divSlideCart .divCartTotal .totalPrice').text(comma(res['price'])+'원');
          $('.divSlideCart .divTopHeader span').text(comma(res['count']));
          $('.divLoader.slideCart').css('display','none');
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
}


/***********************************************************
        슬라이드 카드 아이템 갯수조작 이벤트
***********************************************************/
function updateItemCount(id,mode,qty){
  $('.divLoader.slideCart').css('display','block');
  $.ajax({
        type:"POST",
        url:"/cart/ajaxUpdateCartItemCount",
        data : {id:id, mode:mode, qty:qty},
        dataType : "json",
        success: function(res){
          if(res['result'] == false){
            alert('재고를 초과하였습니다.');
            updateCartTotal();
            return false;
          }
          if(res['qty']==0){
            /*
            $('.divSlideCart .divItem.item'+id).transition({
              animation  : 'fly left',
              duration   : '500ms',
              onComplete : function() {
                $('.divSlideCart .divItem.item'+id).remove();
              }
            });
            */
            $('.divSlideCart .divItem.item'+id).remove();
          }else{
            $('.divSlideCart .divItem.item'+id+' .controlTD span').text(res['qty']);
          }

          updateCartTotal();
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
}

var selectDay = '';
var selectMonth = '';
/***********************************************************
        달력 이벤트 등록
***********************************************************/
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
        if(day == selectDay && getMonth == selectMonth){
          $('.calendar .calendarBox table .pos'+(pos)).addClass('selected');
        }
        if((yearNow >= getYear && monthNow > getMonth)||(monthNow == getMonth && dayNow >=day)){
          $('.calendar .calendarBox table .pos'+(pos)).addClass('unable');
        }else{
          if(dayOfWeeks == 1 || dayOfWeeks == 2  || dayOfWeeks == 3  || dayOfWeeks == 4 || dayOfWeeks == 5){
            $('.calendar .calendarBox table .pos'+(pos)).addClass('able');
          }else{
            $('.calendar .calendarBox table .pos'+(pos)).addClass('unable');
          }
        }
        day++;
      }
    }
  }
}

/***********************************************************
        달력 이전달 버튼 클릭이벤트
***********************************************************/
$('.calendar .buttonBox .prev_month_btn').click(function(e){
  $('.able').removeClass('selected');
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

/***********************************************************
        달력 다음달 버튼 클릭 이벤트
***********************************************************/
$('.calendar .buttonBox .next_month_btn').click(function(e){
  $('.able').removeClass('selected');
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

/***********************************************************
        달력 일자 클릭 이벤트
***********************************************************/
function setClickEvent(){
  $('.is_day').off();
  $('.able').click(function(e){
    if($(e.target).prop('tagName')=="A"){
      var getDate = $('.dateNow').val();
      var getDateArray = getDate.split(".");
      var getYear = getDateArray[0];
      var getMonth = getDateArray[1];
      var getDay = $(e.target).html();
      selectDay = getDay;
      selectMonth = getMonth;
      $('.is_day').removeClass('selected');
      $(this).addClass('selected');
      $('.inputDeliveryDate').val(lpad(getYear,2,0)+lpad(getMonth,2,0)+lpad(getDay,2,0));
    }
  });
}

/***********************************************************
        LPAD 함수
***********************************************************/
function lpad(s, padLength, padString){

    while(s.length < padLength)
        s = padString + s;
    return s;
}

/***********************************************************
        RPAD 함수
***********************************************************/
function rpad(s, padLength, padString){
    while(s.length < padLength)
        s += padString;
    return s;
}

/***********************************************************
        상품리스트 카드담기 버튼 클릭 이벤트
***********************************************************/
$('.divSlideCart .divCartList .divItem .controlTD a').click(function(e){
  var id = $(this).parents().children('input').val();
  if($(this).hasClass('plusBtn')){
    updateItemCount(id,'plus','');
  }else if($(this).hasClass('minusBtn')){
    updateItemCount(id,'minus','');
  }
});

/***********************************************************
        상품리스트 삭제 버튼 클릭 이벤트
***********************************************************/
$('.divSlideCart .divCartList .divItem .deleteBtn').click(function(e){
  alert('delete');
});

/***********************************************************
        상품리스트 카드담기 버튼 클릭 이벤트 등록로직
***********************************************************/
function cartItemCountEventReset(id){
  $('.divSlideCart .divCartList .divItem.item'+id+' .controlTD a').click(function(e){
    var id = $(this).parents().children('input').val();
    if($(this).hasClass('plusBtn')){
      updateItemCount(id,'plus','');
    }else if($(this).hasClass('minusBtn')){
      updateItemCount(id,'minus','');
    }
  });

  $(".divSlideCart .divCartList .divItem.item"+id).bind('touchstart', function(e) {
    startLongTapTimer(this); //롱탭을 판단하기 위한 타이머를 활성화
    bStartEvent = true;
    //e.preventDefault();	//	이벤트취소
  });

  $(".divSlideCart .divCartList .divItem.item"+id).bind('touchmove', function(e) {
    if(!bStartEvent) {
        return
    }
    deleteLongTabTimer(e); //touchmove 이벤트가 발생했기 때문에 롱탭 타이머 삭제
  });

  $(".divSlideCart .divCartList .divItem.item"+id).bind('touchend', function(e) {
    if(!bStartEvent) {
        return
    }
    deleteLongTabTimer(e); //touchend 이벤트가 발생했기 때문에 롱탭 타이머 삭제
    bStartEvent = false;
  });

  /*
  $(".divSlideCart .divCartList .divItem.item"+id).dblclick(function(e){
    var id = $(this).children().children().children().children('.controlTD').children('input').val();
    $(this).transition({animation :'pulse', duration:300, onComplete : function() {
      if(confirm('해당 상품을 삭제하시겠습니까?')){
        updateItemCount(id,'minus',0);
      }
    }});
  });
  */

  $('.divSlideCart .divCartList .divItem.item'+id).fadeIn('fast');
}

/***********************************************************
        숫자 콤마 붙이는 로직
***********************************************************/
function comma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

var bStartEvent = false;
/***********************************************************
        슬라이드 카드 아이템 롱탭 이벤트
***********************************************************/
function startLongTapTimer(target) { //롱탭을 판단하는 타이머를 실행하는 코드
    var self = this;
    this.nLongTabTimer = setTimeout(function() {
        var id = $(target).children().children().children().children('.controlTD').children('input').val();
      //롱탭 이벤트로 판단한다.
        /*
        $(target).transition({animation :'pulse', duration:300, onComplete : function() {
          if(confirm('해당 상품을 삭제하시겠습니까?')){
            updateItemCount(id,'minus',0);
          }
        }});
        */
        delete self.nLongTabTimer;
    }, 500)
}

function deleteLongTabTimer() {
    //활성화된 롱탭 타이머를 삭제하는 코드
    if( typeof this.nLongTabTimer !== 'undefined') {
        clearTimeout(this.nLongTabTimer);
        delete this.nLongTabTimer;
    }
}


$(".divSlideCart .divCartList .divItem").bind('touchstart', function(e) {
  startLongTapTimer(this); //롱탭을 판단하기 위한 타이머를 활성화
  bStartEvent = true;
  //e.preventDefault();	//	이벤트취소
});

$(".divSlideCart .divCartList .divItem").bind('touchmove', function(e) {
  if(!bStartEvent) {
      return
  }
  deleteLongTabTimer(e); //touchmove 이벤트가 발생했기 때문에 롱탭 타이머 삭제
});

$(".divSlideCart .divCartList .divItem").bind('touchend', function(e) {
  if(!bStartEvent) {
      return
  }
  deleteLongTabTimer(e); //touchend 이벤트가 발생했기 때문에 롱탭 타이머 삭제
  bStartEvent = false;
});

$(".divSlideCart .divCartList .divItem").dblclick(function(e){
  var id = $(this).children().children().children().children('.controlTD').children('input').val();
  /*
  $(this).transition({animation :'pulse', duration:300, onComplete : function() {
    if(confirm('해당 상품을 삭제하시겠습니까?')){
      updateItemCount(id,'minus',0);
    }
  }});
  */
});

/*******************************************************
    커스텀 라디오 버튼 클릭 이벤트
*******************************************************/
$('.radio_btn .item').click(function(){
  $(this).parents().children('.item').removeClass('selected');
  $(this).addClass('selected');
  console.log($(this).attr('data'));
  $(this).parents().children('input[type="hidden"]').val($(this).attr('data'));
})
