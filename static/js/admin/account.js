/////////////////////////////////////////////////////////////////////////////////////
//       화면 호출 시 실행                                                          //
/////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){
  
});

/////////////////////////////////////////////////////////////////////////////////////
//       이벤트 리스트                                                              //
/////////////////////////////////////////////////////////////////////////////////////

//(회계장부 리스트) 조회버튼 클릭
$('.accountList .divButton .searchBtn').click(function(e){
  search('accountList');
});

/////////////////////////////////////////////////////////////////////////////////////
//       로직 리스트                                                                //
/////////////////////////////////////////////////////////////////////////////////////

//조회 로직
function search(screen){
  var FRDT='';
  var TODT='';
  var Param='';
  TODT = $('.divSearch .TODT').val();
  FRDT = $('.divSearch .FRDT').val();
  if(FRDT != '' && TODT != ''){
    Param = Param + 'FRDT='+getNumber(FRDT) + '&TODT='+getNumber(TODT) + '&';
  }
  var URL = location.pathname+'?'+Param;
  location.href = URL;
}

// 테이블 셀 병합 로직
function genRowspan(className){
  $("." + className).each(function() {
  	var rows = $("." + className + ":contains('" + $(this).text() + "')");
		if (rows.length > 1) {
		  rows.eq(0).attr("rowspan", rows.length);
		  rows.not(":eq(0)").remove();
    }
  });
}
