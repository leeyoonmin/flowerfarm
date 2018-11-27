/***********************************************
    Range Input 조작 로직
***********************************************/
$('.divSearch .LOW_PRICE').on('input', function(e){
  setLowPrice();
});

$('.divSearch .HIGH_PRICE').on('input', function(e){
  setHighPrice();
});

function setLowPrice(){
  var price = $('.divSearch .LOW_PRICE').val();
  $('.divSearch .staticLowPrice').text(commas(price) + '원');
}

function setHighPrice(){
  var price = $('.divSearch .HIGH_PRICE').val();
  $('.divSearch .staticHighPrice').text(commas(price) + '원');
}

/*********************************************************
    삭제버튼 클릭 이벤트
**********************************************************/
$('.productList .deleteBtn').click(function(e){
  var id="";
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      id = $(this).parents('td').next('.product_id').text();
    }
  });
  if(id==""){
    alert('상품을 선택하세요');
    return false;
  }
  if(!confirm('정말 삭제하시겠습니까?')){
    return false;
  }

  $.ajax({
    type:"POST",
    url:"/admin/ajaxDeleteProduct",
    data : {
      id : id
    },
    dataType : "json",
    success: function(res){
      location.href = "";
    },
    error: function(xhr, status, error) {
      console.log(error);
      alert('문제가 발생했습니다. \n문제가 반복되면 관리자에게 문의하세요.');
      $('.divPopupProduct .divLoader').transition('fade');
    }
  });

});

/*********************************************************
    수정버튼 클릭 이벤트
**********************************************************/
$('.productList .modifyBtn').click(function(e){
  var id="";
  $('.checkBox').each(function(e){
    if($(this).prop('checked')){
      id = $(this).parents('td').next('.product_id').text();
    }
  });
  if(id==""){
    alert('상품을 선택하세요');
    return false;
  }
  $('.divPopupProduct .divLoader').transition('fade');
  $.ajax({
    type:"POST",
    url:"/admin/ajaxGetProductByID",
    data : {
      id : id
    },
    dataType : "json",
    success: function(res){
      $('.divPopupProduct .PRD_ID').val(id);
      $('.divPopupProduct .PRD_NM').val(res['object'][0]['PRODUCT_NAME']);
      $('.divPopupProduct .PRD_PRICE').val(res['object'][0]['PRODUCT_PRICE_SUPPLY']);
      $('.divPopupProduct .PRD_DV').val(res['object'][0]['PRODUCT_CATE_KIND']);
      $('.divPopupProduct .PRD_COLOR').val(res['object'][0]['PRODUCT_CATE_COLOR']);
      $('.divPopupProduct .PRD_SHAPE').val(res['object'][0]['PRODUCT_CATE_SHAPE']);
      $('.divPopupProduct .PRD_AREA').val(res['object'][0]['PRODUCT_CATE_AREA']);
      $('.divPopupProduct .PRD_AMOUNT').val(res['object'][0]['PRODUCT_AMOUNT']);
      $('.divPopupProduct .IS_DISPLAY').val(res['object'][0]['IS_DISPLAY']);
      if(res['object'][0]['IMG_EXTENSION']=="" || res['object'][0]['IMG_EXTENSION']==null){
        $('#PRD_IMG').attr('src','/static/uploads/product/noImage.png');
      }else{
        $('#PRD_IMG').attr('src','/static/uploads/product/'+res['object'][0]['PRODUCT_ID']+'.'+res['object'][0]['IMG_EXTENSION']);
      }
      if(res['object'][0]['IS_NEW']=="Y"){
        $('.divPopupProduct #is_new').attr('checked',true);
      }
      if(res['object'][0]['IS_RECOMMAND']=="Y"){
        $('.divPopupProduct #is_recommand').attr('checked',true);
      }
      $('.divPopupProduct .divLoader').transition('fade');
    },
    error: function(xhr, status, error) {
      console.log(error);
      alert('문제가 발생했습니다. \n문제가 반복되면 관리자에게 문의하세요.');
      $('.divPopupProduct .divLoader').transition('fade');
    }
  });
  $('.divPopupProduct').fadeIn('fast');
  $('.divPopupProductBG').fadeIn('fast');
});

/*********************************************************
    추가버튼 클릭 이벤트
**********************************************************/
$('.productList .addBtn').click(function(e){
  $('.divPopupProduct .PRD_ID').val('');
  $('.divPopupProduct .PRD_NM').val('');
  $('.divPopupProduct .PRD_PRICE').val('');
  $('.divPopupProduct .PRD_DV').val('0000');
  $('.divPopupProduct .PRD_COLOR').val('0000');
  $('.divPopupProduct .PRD_SHAPE').val('0000');
  $('.divPopupProduct .PRD_AREA').val('0000');
  $('.divPopupProduct .PRD_AMOUNT').val('');
  $('.divPopupProduct #is_new').attr('checked',false);
  $('.divPopupProduct #is_recommand').attr('checked',false);
  $('#PRD_IMG').attr('src','/static/uploads/product/noImage.png');
  $('.divPopupProduct').fadeIn('fast');
  $('.divPopupProductBG').fadeIn('fast');
});

/*********************************************************
    팝업배경 클릭 이벤트
**********************************************************/
$('.divPopupProductBG').click(function(e){
  $('.divPopupProduct').fadeOut('fast');
  $('.divPopupProductBG').fadeOut('fast');
});

/*********************************************************
    (상품관리) 수정/저장 버튼클릭
**********************************************************/
$('.divPopupProduct .btn.blue').click(function(e){
  if($('.divPopupProduct .PRD_NM').val()==""){
    alert('상품명을 입력해주세요');
    return false;
  }else if($('.divPopupProduct .PRD_PRICE').val()==""){
    alert('상품가격을 입력해주세요');
    return false;
  }else if($('.divPopupProduct .PRD_AREA').val()=="0000"){
    //alert('원산지를 선택해주세요');
    //return false;
  }else if($('.divPopupProduct .PRD_DV').val()=="0000"){
    alert('상품구분을 선택해주세요');
    return false;
  }else if($('.divPopupProduct .PRD_COLOR').val()=="0000"){
    alert('상품색상을 선택해주세요');
    return false;
  }else if($('.divPopupProduct .PRD_SHAPE').val()=="0000"){
    alert('상품형태를 선택해주세요');
    return false;
  }else if($('.divPopupProduct .PRD_AMOUNT').val()==""){
    alert('재고를 입력해주세요');
    return false;
  }else{
    $('.productFrm').submit();
  }
});

/*********************************************************
    조회버튼 클릭 이벤트
**********************************************************/
$('.productList .searchBtn').click(function(e){
  search('productList');
});

/*********************************************************
    그리드 조회 로직
**********************************************************/
function search(mode){
  var PRD_NM='';
  var PRD_DV='0000';
  var PRD_AREA='0000';
  var PRD_COLOR='0000';
  var PRD_SHAPE='0000';
  var LOW_PRICE='';
  var HIGH_PRICE='';
  var PRD_DISPLAY = '0000';
  var IS_DISPLAY = '0000';
  var VIEW_CNT='';
  var PAGE='';
  var Param='';

  PAGE = $('.selectPage').val();
  if(mode=='productList'){
    PRD_AREA = $('.divSearch .PRD_AREA').val();
    PRD_NM = $('.divSearch .PRD_NM').val();
    PRD_DV = $('.divSearch .PRD_DV').val();
    PRD_COLOR = $('.divSearch .PRD_COLOR').val();
    PRD_SHAPE = $('.divSearch .PRD_SHAPE').val();
    LOW_PRICE = $('.divSearch .LOW_PRICE').val();
    HIGH_PRICE = $('.divSearch .HIGH_PRICE').val();
    PRD_DISPLAY = $('.divSearch .PRD_DISPLAY').val();
    IS_DISPLAY = $('.divSearch .IS_DISPLAY').val();
    VIEW_CNT = $('#viewCnt').prop('checked');
  }

  if(PRD_NM != ''){
    Param = Param + 'PRD_NM='+PRD_NM+'&';
  }
  if(PRD_AREA != '0000'){
    Param = Param + 'PRD_AREA='+PRD_AREA+'&';
  }
  if(PRD_DV != '0000'){
    Param = Param + 'PRD_DV='+PRD_DV+'&';
  }
  if(PRD_COLOR != '0000'){
    Param = Param + 'PRD_COLOR='+PRD_COLOR+'&';
  }
  if(PRD_SHAPE != '0000'){
    Param = Param + 'PRD_SHAPE='+PRD_SHAPE+'&';
  }
  if(LOW_PRICE != ''){
    Param = Param + 'LOW_PRICE='+LOW_PRICE+'&';
  }
  if(HIGH_PRICE != ''){
    Param = Param + 'HIGH_PRICE='+HIGH_PRICE+'&';
  }
  if(PRD_DISPLAY != '0000'){
    Param = Param + 'PRD_DISPLAY='+PRD_DISPLAY+'&';
  }
  if(IS_DISPLAY != '0000'){
    Param = Param + 'IS_DISPLAY='+IS_DISPLAY+'&';
  }
  if(PAGE != ''){
    Param = Param + 'PAGE='+PAGE+'&';
  }
  Param = Param + 'VIEW_CNT='+VIEW_CNT+'&';
  location.href = mode+'?'+Param;
}

/***********************************************
    숫자에 콤마 붙이는 로직
***********************************************/
function commas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

/***********************************************
    상품팝업 사진 업로드 변경 로직
***********************************************/
var loadFile = function(event) {
  var output = document.getElementById('PRD_IMG');
  output.src = URL.createObjectURL(event.target.files[0]);
};

/***********************************************
    시작 시 동작 로직
***********************************************/
$(document).ready(function(){
  setLowPrice();
  setHighPrice();
});

/***********************************************
    스크롤에 따른 버튼박스 상단 고정
***********************************************/
var isDivButtonFixed = false;
$(window).scroll(function() {
  var scrollTop = $(this).scrollTop();

  if(scrollTop>302 && isDivButtonFixed==false){
    $('.divButton').css('position','fixed').css('top','0').css('left','50%').css('transform','translateX(-50%)').css('margin-top','0px').css('padding','16px').css('z-index','999').css('box-shadow','5px 10px 10px rgba(0,0,0,.05)');
    isDivButtonFixed = true;
  }else if(scrollTop<302){
    $('.divButton').css('position','static').css('left','').css('transform','translateX(0%)').css('margin-top','4px').css('padding','0px').css('box-shadow','0px 0px 0px rgba(0,0,0,0.3)');
    isDivButtonFixed = false;
  }
});

/***********************************************
100개 보기 클릭 이벤트
***********************************************/
$('#viewCnt').change(function(e){
  search('productList');
})

/***********************************************************
   이미지 클릭 이벤트
***********************************************************/
$('.productList .divGrid .productImg img, .productPriceMng .divGrid .productImg img').click(function(e){
  var img_path = $(this).attr('src');
  $('.divPopupImgViewer .product_img').attr('src',img_path);
  $('.divPopupImgViewer').fadeIn('fast');
  $('.divPopupImgViewerBG').fadeIn('fast');
  $('.divPopupImgViewer .closeBtn').css('left',Number($('.divPopupImgViewer').css('width').replace(/[^0-9]/g,''))-50+'px');
});

$('.divPopupImgViewerBG, .divPopupImgViewer .closeBtn, .divPopupImgViewer img').click(function(e){
  $('.divPopupImgViewerBG').fadeOut('fast');
  $('.divPopupImgViewer').fadeOut('fast');
});

/***********************************************************
   [상품가격관리] 저장버튼 클릭이벤트
***********************************************************/
$('.productPriceMng .divGrid .saveBtn').click(function(e){
  var PRODUCT_ID = $(this).prev().val();
  var PRODUCT_PRICE_SUPPLY = $(this).parents('td').prev().prev().prev().prev().children().val();
  var PRODUCT_PRICE_WHOLESALE = $(this).parents('td').prev().prev().prev().children().val();
  var PRODUCT_PRICE_CUNSUMER = $(this).parents('td').prev().prev().children().val();
  var IS_DISPLAY = $(this).parents('td').prev().children().val();
  var PRODUCT_TIME = $(this).parents('td').prev().prev().prev().prev().prev();

  console.log(PRODUCT_ID , PRODUCT_PRICE_SUPPLY , PRODUCT_PRICE_WHOLESALE , PRODUCT_PRICE_CUNSUMER, IS_DISPLAY);

  $.ajax({
    type:"POST",
    url:"/admin/ajaxUpdateProduct",
    data : {
      PRODUCT_ID : PRODUCT_ID,
      PRODUCT_PRICE_SUPPLY : PRODUCT_PRICE_SUPPLY.replace(',',''),
      PRODUCT_PRICE_WHOLESALE : PRODUCT_PRICE_WHOLESALE.replace(',',''),
      PRODUCT_PRICE_CUNSUMER : PRODUCT_PRICE_CUNSUMER.replace(',',''),
      IS_DISPLAY : IS_DISPLAY
    },
    dataType : "json",
    success: function(res){
      PRODUCT_TIME.text(res['today']);
      alert('저장완료');
    },
    error: function(xhr, status, error) {
      alert('저장실패');
      console.log(error);
    }
  });
});

/***********************************************************
   [상품가격관리] 가격변경 이벤트
***********************************************************/
$('.PRODUCT_PRICE').keyup(function() {
    var INPUT_VAL = $(this).val().replace(',','');
    $(this).val(commas(INPUT_VAL));
});
