/***********************************************************
        화면 로드온 이벤트
***********************************************************/
$(document).ready(function(){
  $('.materialboxed').materialbox();
  if(document.body.scrollWidth>1024){
    var keyword = $('.pc.divSearch .inputKeyword').val();
  }else{
    var keyword = $('.m.divSearch .inputKeyword').val();
  }
  itemViewControl(keyword,'loadOn');
  //$('.divSearch').removeClass('close');
  //$('.divSearch').addClass('open');
  //$('.divSearch').animate({'top':'51px'},300);
  //$('.divControlbox img').prop('src','/static/img/icon/ic_arrow_up.png');
  //$('.divSearchBG').transition('fade');
});

$(window).load(function(){
  //$('.ui.active.dimmer.divLoader.productList').transition('fade')
});


/***********************************************************
        사진유무 토글제어
***********************************************************/
$('.toggleBox').click(function(e){
  $('.divLoader.body').css('display','block');
  if(document.body.scrollWidth>1024){
    var keyword = $('.pc.divSearch .inputKeyword').val();
  }else{
    var keyword = $('.m.divSearch .inputKeyword').val();
  }
  if($(this).hasClass('checked')){
    $(this).removeClass('checked');
  }else{
    $(this).addClass('checked');
  }
  if($(this).children('.toggleValue').val() == 'false'){
    $(this).children('.toggleValue').val('true');
  }else{
    $(this).children('.toggleValue').val('false');
  }
  itemViewControl(keyword,'toggle');
});


/***********************************************************
        이미지 뷰어 초기화
***********************************************************/
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.materialboxed');
  var instances = M.Materialbox.init(elems);
});

/***********************************************************
        상세검색 열/닫기 버튼 클릭 이베트
***********************************************************/
$('.divSearch .divControlbox').click(function(e){
  if($('.divSearch').hasClass('open')){
    $('.divSearch').removeClass('open');
    $('.divSearch').addClass('close');
    $('.divSearch').animate({'top':'-120px'},300);
    $('.divControlbox img').prop('src','/static/img/icon/ic_arrow_down.png');
    $('.divSearchBG').fadeOut('fast');
  }else if($('.divSearch').hasClass('close')){
    $('.divSearch').removeClass('close');
    $('.divSearch').addClass('open');
    $('.divSearch').animate({'top':'50px'},300);
    $('.divControlbox img').prop('src','/static/img/icon/ic_arrow_up.png');
    $('.divSearchBG').fadeIn('fast');
  }
});
/***********************************************************
        검색창 배경 클릭 이벤트
***********************************************************/
$('.divSearchBG').click(function(e){
  $('.divSearch').removeClass('open');
  $('.divSearch').addClass('close');
  $('.divSearch').animate({'top':'-120px'},300);
  $('.divControlbox img').prop('src','/static/img/icon/ic_arrow_down.png');
  $('.divSearchBG').fadeOut('fast');
});

/***********************************************************
        장바구니 담기 버튼 클릭 시 장바구니 넣기
***********************************************************/
$('.divItem .cartTD').click(function(e){
  if(document.body.scrollWidth>1024){
    $('.divSlideCart').css('display','block').animate({'left':'0'},300);
    $('.divCartCallBtn ').removeClass('close');
    $('.divCartCallBtn ').addClass('open');
  }else{
    $('.divSlideCart').css('display','block').animate({'left':'25%'},300);
    $('.divSlideCartBG').transition('fade');
  }
  $('.divLoader.slideCart').css('display','block');
  insertCart($(e.target));
});

/***********************************************************
        정렬순서 값 변경 이벤트
***********************************************************/
$('.orderSelect').change(function(e){
var orderBy = $(this).val();
var kind = $('.divSearch .selectKind').val();
var shape = $('.divSearch .selectShape').val();
var color = $('.divSearch .selectColor').val();
if(document.body.scrollWidth>1024){
  var keyword = $('.pc.divSearch .inputKeyword').val();
}else{
  var keyword = $('.m.divSearch .inputKeyword').val();
}
var is_img = $('.toggleValue').val();
var url = location.pathname+"?";
if(kind != "0000"){
  url = url+"kind="+kind+"&";
}
if(shape != "0000"){
  url = url+"shape="+shape+"&";
}
if(color != "0000"){
  url = url+"color="+color+"&";
}
if(keyword != "0000"){
  url = url+"keyword="+keyword+"&";
}
  url = url+"is_img="+is_img+"&";
url = url+"orderBy="+orderBy;
location.href = url;
});

/***********************************************************
        상품리스트 카드담기 버튼 클릭 이벤트
***********************************************************/
function insertCart(target){
  var id,name,price,img_extension;
  if(target.prop('tagName')=="IMG"){
    img_extension = target.prev().prev().prev().prev().prev().val();
    id = target.prev().prev().prev().val();
    name = target.prev().prev().val();
    kind = target.prev().prev().prev().prev().val();
    price = target.prev().val();
  }else{
    img_extension = target.children('.HD_EXTENSION').val();
    id = target.children('.HD_ID').val();
    name = target.children('.HD_NM').val();
    kind = target.children('.HD_KIND').val();
    price = target.children('.HD_PRICE').val();
  }

  $.ajax({
        type:"POST",
        url:"/cart/ajaxCartAddItem",
        data : {id : id, name:name, price:price, kind:kind, extension:img_extension},
        dataType : "json",
        success: function(res){
          $('.divLoader.slideCart').css('display','none');
          if(res['result'] == false){
            alert('재고가 없어 장바구니 담기에 실패했습니다.');
            return false;
          }
          if(res['qty']==1){
            if(img_extension == ''){
              $('.divSlideCart .divCartList').append("<div class=\"divItem item"+id+" hidden\"><table><tr><td class=\"imgTD\"><img src=\"/static/uploads/product/noImage.png\"></td><td class=\"infoTD\"><p>"+name+"</p><p><span>"+comma(price)+"</span>원</p></td><td class=\"controlTD\"><input type=\"hidden\" value=\""+id+"\"><a class=\"minusBtn new\">－</a><span>1</span><a class=\"plusBtn new\">＋</a></td></tr></table></div>");
            }else{
              $('.divSlideCart .divCartList').append("<div class=\"divItem item"+id+" hidden\"><table><tr><td class=\"imgTD\"><img src=\"/static/uploads/product/"+id+"."+img_extension+"\"></td><td class=\"infoTD\"><p>"+name+"</p><p><span>"+comma(price)+"</span>원</p></td><td class=\"controlTD\"><input type=\"hidden\" value=\""+id+"\"><a class=\"minusBtn new\">－</a><span>1</span><a class=\"plusBtn new\">＋</a></td></tr></table></div>");
            }
            cartItemCountEventReset(id);
          }else{
            $('.divSlideCart .divCartList .divItem.item'+id+' .controlTD span').text(res['qty']);
          }
          updateCartTotal();
          var targetOffset = 0;
          var listCnt = 0;
          $('.divSlideCart .divCartList .divItem').each(function(e){
            if($(this).hasClass('item'+id)){
              targetOffset = 64*listCnt;
              $('.divSlideCart .divCartList .divItem').removeClass('selected');
              $(this).addClass('selected');
            }
            listCnt++;
          });
          $('.divSlideCart .divCartList').animate({scrollTop:targetOffset}, 500);
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
}

/***********************************************************
        카테고리창 셀렉터 변경 이벤트
***********************************************************/
$('.divSearch select').change(function(e){
  if(document.body.scrollWidth>1024){
    var keyword = $('.pc.divSearch .inputKeyword').val();
  }else{
    var keyword = $('.m.divSearch .inputKeyword').val();
  }
  itemViewControl(keyword,'selectChange');
});


/***********************************************************
        카테고리창 셀렉터 최종 뷰 데이터 조회 로직
***********************************************************/
function itemViewControl(keyword, mode){
  if(document.body.scrollWidth>1024){
    var selectKindValue = $('.pc.divSearch select.selectKind').val();
    var selectShapeValue = $('.pc.divSearch select.selectShape').val();
  }else{
    var selectKindValue = $('.m.divSearch select.selectKind').val();
    var selectShapeValue = $('.m.divSearch select.selectShape').val();
  }
  var selectColorValue = $('.divSearch .selectColor').val();

  var is_kind;
  var is_shape;
  var is_color;
  var is_img;
  var itemCnt = 0;
  $('.divProductList .divItem').each(function(index){

    if(selectKindValue != '0000'){
      if($(this).attr('kind') == selectKindValue){
        is_kind = true;
      }else{
        is_kind = false;
      }
    }else{
      is_kind = true;
    }

    if(selectShapeValue != '0000'){
      if($(this).attr('shape') == selectShapeValue){
        is_shape = true;
      }else{
        is_shape = false;
      }
    }else{
      is_shape = true;
    }

    if(selectColorValue != '0000'){
      if($(this).attr('color') == selectColorValue){
        is_color = true;
      }else{
        is_color = false;
      }
    }else{
      is_color = true;
    }
    if($('.toggleBox').children('.toggleValue').val() =='true'){
      if($(this).attr('extension') == ''){
        is_img = false;
      }else{
        is_img = true;
      }
    }else{
      is_img = true;
    }
    if(is_kind & is_shape & is_color & is_img){
      if(keyword=="" || keyword==null){
        $(this).removeClass('cateHidden');
        $(this).addClass('cateShow');
        itemCnt++;
      }else{
        var id = $(this).attr('name').trim();
        var disassemble = Hangul.disassemble(id,true);
        var cho="";
        for(var i=0,l=disassemble.length;i<l;i++){
          cho+=disassemble[i][0];
        }
        var not_found1 = (id.indexOf(keyword) == -1);
        var not_found2 = Hangul.rangeSearch(cho, keyword, true);
        var r2 = not_found2.map(function(a){return cho.substr(a[0], a[1]-a[0]+1);})
        if(not_found1 && not_found2.length==0){
          $(this).removeClass('cateShow');
          $(this).addClass('cateHidden');
        }else{
          $(this).removeClass('cateHidden');
          $(this).addClass('cateShow');
          itemCnt++;
        }
      }
    }
    else{
      $(this).removeClass('cateShow');
      $(this).addClass('cateHidden');
    }
  });
  $('.divOrder .totalCnt').text('총 '+(itemCnt/2)+'개 상품');
  $('.divLoader.body').css('display','none');
}
/***********************************************************
        검색 키워드 변경 시 아이템리스트 변경 이벤트
***********************************************************/
$('.divSearch .inputKeyword').on('change keyup paste',function(e){
  if(document.body.scrollWidth>1024){
    var keyword = $('.pc.divSearch .inputKeyword').val();
  }else{
    var keyword = $('.m.divSearch .inputKeyword').val();
  }
  itemViewControl(keyword,'keyword');
});
/***********************************************************
        카테고리 색상 버튼 클릭이벤트
***********************************************************/
$('.divSearch .colorSelector').click(function(e){
  if($(this).hasClass('selected')){
    $('.divSearch .colorSelector').removeClass('selected');
    $('.divSearch .selectColor').val('0000');
  }else{
    $('.divSearch .colorSelector').removeClass('selected');
    $(this).addClass('selected');
    $('.divSearch .selectColor').val($(this).attr('color'));
  }
  if(document.body.scrollWidth>1024){
    var keyword = $('.pc.divSearch .inputKeyword').val();
  }else{
    var keyword = $('.m.divSearch .inputKeyword').val();
  }
  itemViewControl(keyword);
});
/***********************************************************
        숫자 콤마 붙이는 로직
***********************************************************/
function comma(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
