
/*********************************************************
    (회원정보조회) 조회 버튼 클릭 이벤트
**********************************************************/
$('.inquiryUserInfo .searchBtn').click(function(e){
  search('inquiryUserInfo');
});

/*********************************************************
    (회원등급관리) 조회 버튼 클릭 이벤트
**********************************************************/
$('.userGradeMng .searchBtn').click(function(e){
  search('userGradeMng');
});

/*********************************************************
    (회원등급관리) 등급변경 버튼 클릭 이벤트
**********************************************************/
$('.userGradeMng .changeGradeBtn').click(function(e){
  popupChangeGrade();
});

/*********************************************************
    (회원등급관리) 버튼 조작 검증 로직
**********************************************************/
function popupChangeGrade(){
  $('.divPopupChangeGrade').fadeIn('fast');
  $('.divPopupBG').fadeIn('fast');
}
$('.divPopupBG').click(function(){
  $('.divPopupChangeGrade').fadeOut('fast');
  $('.divPopupBG').fadeOut('fast');
});

/*********************************************************
    (회원등급관리) 팝업 등급변경 버튼 클릭 이벤트
**********************************************************/
$('.divPopupChangeGrade .popupChangeGradeBtn').click(function(e){
  var grade = $('.divPopupChangeGrade select').val();
  if(grade=='0000'){
    alert('등급을 선택해주세요.');
    return false;
  }
  clickLogic('changeGradeBtn',grade);
});

/*********************************************************
    (회원등급관리) 버튼 조작 검증 로직
**********************************************************/
function clickLogic(logic,grade){
  var rowCnt = 0;
  var url = '';
  var checkBoxArray = new Array();
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      checkBoxArray[rowCnt] = $(this).parents('.td').next('.td').next('.td').text();
      rowCnt++;
    }
  });
  if(checkBoxArray.length == 0){
    alert('선택된 건이 없습니다.');
    return false;
  }
  if(logic == 'changeGradeBtn'){
    url = 'updateUserGrade';
  }
  ajaxSend(url, checkBoxArray, grade);
}

/*********************************************************
    (회원등급관리) 버튼 조작 검증 로직
**********************************************************/
function ajaxSend(url, arrayData, grade){
  $.ajax({
      url:"/admin/"+url,
      type: "POST",
      datatype: 'JSON',
      data: {'id':arrayData, 'grade':grade},
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
  var Param='';
  var FRDT='';
  var TODT='';
  var USER_TYPE_CD='0000';
  var USER_INFO_DV='0000';
  var USER_INFO_VALUE='';
  var IS_BIZ = '0000';
  FRDT = $('.divSearch .FRDT').val();
  TODT = $('.divSearch .TODT').val();
  PAGE = $('.selectPage').val();
  if(mode=='inquiryUserInfo' || mode=='userGradeMng'){
    USER_INFO_DV = $('.divSearch .USER_INFO_DV').val();
    USER_INFO_VALUE = $('.divSearch .USER_INFO_VALUE').val();
    IS_BIZ = $('.divSearch .IS_BIZ').val();
    USER_TYPE_CD = $('.divSearch .USER_TYPE_CD').val();
  }
  if(FRDT != '' && TODT != ''){
    Param = Param + 'TODT='+TODT+'&FRDT='+FRDT+'&';
  }
  if(USER_INFO_DV != '0000' && USER_INFO_VALUE != ''){
    Param = Param + 'USER_INFO_DV='+USER_INFO_DV+'&'+'USER_INFO_VALUE='+USER_INFO_VALUE+'&';
  }
  if(IS_BIZ != '0000'){
    Param = Param + 'IS_BIZ='+IS_BIZ+'&';
  }
  if(USER_TYPE_CD != '0000'){
    Param = Param + 'USER_TYPE_CD='+USER_TYPE_CD+'&';
  }
  if(PAGE != ''){
    Param = Param + 'PAGE='+PAGE+'&';
  }
  location.href = mode+'?'+Param;
}
