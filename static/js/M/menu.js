/***********************************************************
        전역변수
***********************************************************/
var isAjaxCall = true;
var scrollT=0;
/***********************************************************
        화면 로드온 이벤트
***********************************************************/
$(document).ready(function(){
  addProductListImgViewerEvent();
  /***********************************************************
          스크롤 이벤트
  ***********************************************************/
  $(window).scroll(function(){
    scrollT = $(this).scrollTop();
    var listOffset = 0;
    var listTop = 0;
    var listHeight = 0;
    var browserH = $(window).height();

    if(document.body.scrollWidth>1024){
      listOffset = $('.pc.divProductList').offset();
      listHeight = $('.pc.divProductList').height();
      listTop = listOffset.top;
      if(scrollT+browserH > listTop+listHeight-500){
        if(isAjaxCall == true){
          loadMoreList();
          isAjaxCall = false;
        }
      }
    }else{
      listOffset = $('.m.divProductList').offset();
      listHeight = $('.m.divProductList').height();
      listTop = listOffset.top;
      if(scrollT+browserH > listTop+listHeight-300){
        if(isAjaxCall == true){
          loadMoreList();
          isAjaxCall = false;
        }
      }
    }

    if(scrollT>240 && document.body.scrollWidth>1024 && window.innerWidth>1900){
      $('.m.divSearch').fadeIn('fast');
    }else if(scrollT<240 && document.body.scrollWidth>1024){
      $('.m.divSearch').fadeOut('fast');
    }
  });
});

/***********************************************************
      상품 리스트 AJAX 호출
***********************************************************/
function loadMoreList(){
  var ajaxCallCount = $('.ajaxCallCount').val();
  var getData = "";
  var orderBy = $('.divOrder .orderSelect').val();
  var kind = "";
  var shape = "";
  var color = "";
  var keyword = "";
  if(document.body.scrollWidth>1024){
    kind = $('.pc.divSearch select.selectKind').val();
    shape = $('.pc.divSearch select.selectShape').val();
    color = $('.pc.divSearch .selectColor').val();
    area = $('.pc.divSearch select.selectArea').val();
    keyword = $('.pc.divSearch .inputKeyword').val();
  }else{
    kind = $('.m.divSearch select.selectKind').val();
    shape = $('.m.divSearch select.selectShape').val();
    color = $('.m.divSearch .selectColor').val();
    area = $('.m.divSearch select.selectArea').val();
    keyword = $('.m.divSearch .inputKeyword').val();
  }
  getData = {};
  var is_img = $('.toggleValue').val();
  getData['is_img'] = is_img;

  if(kind != "0000"){
    getData['kind'] = kind;
  }
  if(shape != "0000"){
    getData['shape'] = shape;
  }
  if(color != "0000"){
    getData['color'] = color;
  }
  if(area != "0000"){
    getData['area'] = color;
  }
  if(keyword != ""){
    getData['keyword'] = keyword;
  }
  if(orderBy != ""){
    getData['orderBy'] = orderBy;
  }
  if(ajaxCallCount != ""){
    getData['page'] = ajaxCallCount;
  }
  $.ajax({
        type:"POST",
        url:"/M_menu/ajaxLoadMoreList",
        data : {getData : getData},
        dataType : "json",
        success: function(res){
          var forCount = 0;
          for(var key in res['data']){
            forCount++;
            var item = res['data'][key];
            var imageName = "";
            if(item['IMG_EXTENSION'] == null || item['IMG_EXTENSION']==''){
              imageName = "/static/uploads/product/noImage.png";
              item['IMG_EXTENSION'] = "";
            }else{
              imageName = "/static/uploads/product/"+item['PRODUCT_ID']+"."+item['IMG_EXTENSION'];
            }
            // 사용자 레벨별 가격표시
            // 로그인 별
            var template = '';
            if(document.body.scrollWidth>1024){
              template = '<div class="divItem shadow_1 item1" kind="'+item['PRODUCT_CATE_KIND']+
              '" shape="'+item['PRODUCT_CATE_SHAPE']+'" color="'+item['PRODUCT_CATE_COLOR']+'" name="'+item['PRODUCT_NAME']+'" extension="'+item['IMG_EXTENSION']
              +'"><table><tr><td class="imgTD"><img class="img_true" src="'+imageName+'"></td></tr><tr><td class="infoTD"><table><tr><td class="cate">';

                    if(item['PRODUCT_CATE_AREA']=='02'){
                      template = template + '<span class="importLabel">수입</span><span>';
                    }
                          template = template + item['PRODUCT_CATE_KIND_NM']+'</span></td></tr><tr><td class="name"><span>'+item['PRODUCT_NAME']+'</span></td></tr><tr>';
                    if($('.user_level').val() > 0 && $('.user_level').val() < 5){ // 도매가표시
                      template = template + '<td class="price"><span>'+comma(item['PRODUCT_PRICE_WHOLESALE'])+'</span>원</td></tr>';
                    }else if($('.user_level').val() > 4){ // 소매가표시
                      template = template + '<td class="price"><span>'+comma(item['PRODUCT_PRICE_CUNSUMER'])+'</span>원</td></tr>';
                    }else if($('.user_level').val() == 0){
                      template = template + '<td class="price">로그인 후 확인</td></tr>';
                    }
                    template = template + '</table></td></tr><tr>';

                    if($('.user_level').val()!="0"){
                      if($('.user_level').val() > 0 && $('.user_level').val() < 5){ // 도매가표시
                        template = template + '<td class="cartTD"><input class="HD_EXTENSION" type="hidden" value="'+item['IMG_EXTENSION']
                        +'"><input class="HD_KIND" type="hidden" value="'+item['PRODUCT_CATE_KIND_NM']+'"><input class="HD_ID" type="hidden" value="'+item['PRODUCT_ID']
                        +'"><input class="HD_NM" type="hidden" value="'+item['PRODUCT_NAME']+'"><input class="HD_PRICE" type="hidden" value="'
                        +item['PRODUCT_PRICE_WHOLESALE']+'"><img src="/static/img/icon/ic_cart_white.png"></td>';
                      }else if($('.user_level').val() > 4){ // 소매가표시
                        template = template + '<td class="cartTD"><input class="HD_EXTENSION" type="hidden" value="'+item['IMG_EXTENSION']
                        +'"><input class="HD_KIND" type="hidden" value="'+item['PRODUCT_CATE_KIND_NM']+'"><input class="HD_ID" type="hidden" value="'+item['PRODUCT_ID']
                        +'"><input class="HD_NM" type="hidden" value="'+item['PRODUCT_NAME']+'"><input class="HD_PRICE" type="hidden" value="'
                        +item['PRODUCT_PRICE_CUNSUMER']+'"><img src="/static/img/icon/ic_cart_white.png"></td>';
                      }
                    }else{
                      template = template + '<td></td>';
                    }
                  template = template + '</tr></table></div>';
              $('.pc.divProductList').append(template);
            }else{
              template = '<div class="divItem shadow_1 item1" kind="'+item['PRODUCT_CATE_KIND']+'" shape="'+item['PRODUCT_CATE_SHAPE']+'" color="'
              +item['PRODUCT_CATE_COLOR']+'" name="'+item['PRODUCT_NAME']+'" extension="'+item['IMG_EXTENSION']
              +'"><table><tr><td class="imgTD"><img class="img_true" src="'+imageName+'"></td><td class="infoTD"><table><tr><td class="cate"><span>'
              +item['PRODUCT_CATE_KIND_NM']+'</span></td></tr><tr><td class="name"><span>'+item['PRODUCT_NAME']+'</span></td></tr><tr>';
                    if($('.user_level').val() > 0 && $('.user_level').val() < 5){
                      template = template + '<td class="price"><span>'+comma(item['PRODUCT_PRICE_WHOLESALE'])+'</span>원</td></tr>';
                    }else if($('.user_level').val() > 4){
                      template = template + '<td class="price"><span>'+comma(item['PRODUCT_PRICE_CUNSUMER'])+'</span>원</td></tr>';
                    }else if($('.user_level').val() == 0){
                      template = template + '<td class="price">로그인 후 확인</td></tr>';
                    }
                    template = template + '</table></td>';
                    if($('.user_level').val()!="0"){
                      if($('.user_level').val() > 0 && $('.user_level').val() < 5){ // 도매가표시
                        template = template + '<td class="cartTD"><input class="HD_EXTENSION" type="hidden" value="'
                        +item['IMG_EXTENSION']+'"><input class="HD_KIND" type="hidden" value="'+item['PRODUCT_CATE_KIND_NM']
                        +'"><input class="HD_ID" type="hidden" value="'+item['PRODUCT_ID']+'"><input class="HD_NM" type="hidden" value="'+item['PRODUCT_NAME']
                        +'"><input class="HD_PRICE" type="hidden" value="'+item['PRODUCT_PRICE_WHOLESALE']+'"><img src="/static/img/icon/ic_cart.png"></td>';
                      }else if($('.user_level').val() > 4){ // 소매가표시
                        template = template + '<td class="cartTD"><input class="HD_EXTENSION" type="hidden" value="'
                        +item['IMG_EXTENSION']+'"><input class="HD_KIND" type="hidden" value="'+item['PRODUCT_CATE_KIND_NM']
                        +'"><input class="HD_ID" type="hidden" value="'+item['PRODUCT_ID']+'"><input class="HD_NM" type="hidden" value="'+item['PRODUCT_NAME']
                        +'"><input class="HD_PRICE" type="hidden" value="'+item['PRODUCT_PRICE_CUNSUMER']+'"><img src="/static/img/icon/ic_cart.png"></td>';
                      }

                    }else{
                      template = template + '<td></td>';
                    }
                  template = template + '</tr></table></div>';
              $('.m.divProductList').append(template);
            }

          }
          $('.ajaxCallCount').val(Number(ajaxCallCount)+1);
          if(forCount == 20){
            isAjaxCall = true;
          }
          $('.divItem .cartTD').off();
          $('.divItem .cartTD').click(function(e){
            if(document.body.scrollWidth>1024){
              $('.divSlideCart').css('display','block').animate({'left':'0'},300);
              $('.divCartCallBtn ').removeClass('close');
              $('.divCartCallBtn ').addClass('open');
            }else{
              $('.divSlideCart').css('display','block').animate({'left':'25%'},300);
              $('.divSlideCartBG').fadeIn('fast');
            }
            $('.divLoader.slideCart').css('display','block');
            insertCart($(e.target));
          });
          addProductListImgViewerEvent();
        },
        error: function(xhr, status, error) {
          console.log(error);
        }
    });
}

/***********************************************************
        사진유무 토글제어
***********************************************************/
$('.toggleBox').click(function(e){
  //$('.divLoader.body').css('display','block');
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
        상세검색 열/닫기 버튼 클릭 이베트
***********************************************************/
$('.divSearch .divControlbox').click(function(e){
  if($('.divSearch').hasClass('open')){
    $('.divSearch').removeClass('open');
    $('.divSearch').addClass('close');
    $('.divSearch').animate({'top':'-158px'},200);
    $('.divControlbox img').prop('src','/static/img/icon/ic_arrow_down.png');
    $('.divSearchBG').fadeOut('fast');
  }else if($('.divSearch').hasClass('close')){
    $('.divSearch').removeClass('close');
    $('.divSearch').addClass('open');
    $('.divSearch').animate({'top':'50px'},200);
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
  $('.divSearch').animate({'top':'-158px'},200);
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
    //$('.divSlideCartBG').transition('fade');
    $('.divSlideCartBG').fadeIn('fast');
  }
  $('.divLoader.slideCart').css('display','block');
  insertCart($(e.target));
});

/***********************************************************
        정렬순서 값 변경 이벤트
***********************************************************/
$('.orderSelect').change(function(e){
var orderBy = $(this).val();
var kind = "";
var shape = "";
var color = "";
var keyword = "";
if(document.body.scrollWidth>1024){
  kind = $('.pc.divSearch select.selectKind').val();
  shape = $('.pc.divSearch select.selectShape').val();
  color = $('.pc.divSearch .selectColor').val();
  keyword = $('.pc.divSearch .inputKeyword').val();
}else{
  kind = $('.m.divSearch select.selectKind').val();
  shape = $('.m.divSearch select.selectShape').val();
  color = $('.m.divSearch .selectColor').val();
  keyword = $('.m.divSearch .inputKeyword').val();
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
if(keyword != ""){
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
  if(scrollT < 250){
    if(document.body.scrollWidth>1024){
      var keyword = $('.pc.divSearch .inputKeyword').val();
    }else{
      var keyword = $('.m.divSearch .inputKeyword').val();
    }
  }else{
    var keyword = $('.m.divSearch .inputKeyword').val();
  }

  itemViewControl(keyword,'selectChange');
});

/***********************************************************
        HashTag 클릭 이벤트
***********************************************************/
$('.divHashTagContainer .divHashTag .hashTag').click(function(e){
  var CODE = $(this).attr('CODE');
  var is_img = $('.toggleValue').val();
  var orderBy = $('.divOrder .orderSelect').val();
  location.href="/M_menu/productList/01?kind="+CODE+"&color=&is_img="+is_img+"&orderBy="+orderBy;
});


/***********************************************************
        카테고리창 셀렉터 최종 뷰 데이터 조회 로직
***********************************************************/
function itemViewControl(keyword, mode){
  var orderBy = $('.divOrder .orderSelect').val();
  var kind = "";
  var shape = "";
  var color = "";
  var area = "";
  var keyword = "";
  if(scrollT < 250){
    if(document.body.scrollWidth>1024){
      kind = $('.pc.divSearch select.selectKind').val();
      shape = $('.pc.divSearch select.selectShape').val();
      color = $('.pc.divSearch .selectColor').val();
      area = $('.pc.divSearch .selectArea').val();
      keyword = $('.pc.divSearch .inputKeyword').val();
    }else{
      kind = $('.m.divSearch select.selectKind').val();
      shape = $('.m.divSearch select.selectShape').val();
      color = $('.m.divSearch .selectColor').val();
      area = $('.m.divSearch .selectArea').val();
      keyword = $('.m.divSearch .inputKeyword').val();
    }
  }else{
    kind = $('.m.divSearch select.selectKind').val();
    shape = $('.m.divSearch select.selectShape').val();
    color = $('.m.divSearch .selectColor').val();
    area = $('.m.divSearch .selectArea').val();
    keyword = $('.m.divSearch .inputKeyword').val();
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
  if(area != "0000"){
    url = url+"area="+area+"&";
  }
  if(keyword != ""){
    url = url+"keyword="+keyword+"&";
  }
  url = url+"is_img="+is_img+"&";
  url = url+"orderBy="+orderBy;
  location.href = url;
}
/***********************************************************
        검색 Enter키 다운 시
***********************************************************/
$('.divSearch .inputKeyword').on('change keyup paste',function(e){
  if(e.keyCode == 13){//키가 13이면 실행 (엔터는 13)
    if(document.body.scrollWidth>1024){
      var keyword = $('.pc.divSearch .inputKeyword').val();
    }else{
      var keyword = $('.m.divSearch .inputKeyword').val();
    }
    itemViewControl(keyword,'keyword');
  }
});

$('.divSearch .searchBtn').click(function(e){
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


(function (a)
{
    a.fn.Vnewsticker = function (b)
    {
        var c =
        {
            speed : 5000,
			pause : 4000,
			showItems : 3,
			mousePause : true,
			isPaused : false,
            direction : "up",
			height : 0
        };
        var b = a.extend(c, b);
        moveUp = function (g, d, e)
        {
            if (e.isPaused) {
                return
            }
            var f = g.children("ul");
            var h = f.children("li:first").clone(true);
            if (e.height > 0) {
                d = f.children("li:first").height()
            }
            f.animate({
                top : "-=" + d + "px"
            },
            e.speed, function ()
            {
                a(this).children("li:first").remove();
                a(this).css("top", "0px")
            });
            h.appendTo(f)
        };
        moveDown = function (g, d, e)
        {
            if (e.isPaused) {
                return
            }
            var f = g.children("ul");
            var h = f.children("li:last").clone(true);
            if (e.height > 0) {
                d = f.children("li:first").height()
            }
            f.css("top", "-" + d + "px").prepend(h);
            f.animate({
                top : 0
            },
            e.speed, function ()
            {
                a(this).children("li:last").remove()
            });
        };
        return this.each(function ()
        {
            var f = a(this);
            var e = 0;
            f.css({
                overflow : "hidden", position : "relative"
            }).children("ul").css({
                position : "absolute", margin : 0, padding : 0
            }).children("li").css({
                margin : 0
				//padding : 0
            });
            if (b.height == 0)
            {
                f.children("ul").children("li").each(function ()
                {
                    if (a(this).height() > e) {
                        e = a(this).height();
                    }
                });
                f.children("ul").children("li").each(function ()
                {
                    a(this).height(e)
                });
                f.height(e * b.showItems)
            }
            else {
                f.height(b.height)
            }
            var d = setInterval(function ()
            {
                if (b.direction == "up") {
                    moveUp(f, e, b)
                }
                else {
                    moveDown(f, e, b)
                }
            },
            b.pause);
            if (b.mousePause)
            {
                f.bind("mouseenter", function ()
                {
                    b.isPaused = true;
                }).bind("mouseleave", function ()
                {
                    b.isPaused = false;
                })
            }
        })
    }
})(jQuery);

$('.divNewSticker').Vnewsticker({
			speed: 2000,         //스크롤 스피드
			pause: 0,        //잠시 대기 시간
			mousePause: true,   //마우스 오버시 일시정지(true=일시정지)
			showItems: 1,       //스크롤 목록 갯수 지정(1=한줄만 보임)
			direction : "up"    //left=옆으로스크롤, up=위로스크롤, 공란=아래로 스크롤
});

$('.divMainVideo .closeBtn').click(function(e){
  $('.divMainVideo').fadeOut('fast');
});

$('.divNewProduct .divItem').mouseenter(function(e){
  $(this).children('.divInfo').fadeIn('fast');
});

$('.divNewProduct .divItem').mouseleave(function(e){
  $(this).children('.divInfo').fadeOut('fast');
});

function addProductListImgViewerEvent(){
  $('.divProductList .divItem .imgTD img').off();
  $('.divProductList .divItem .imgTD img').click(function(e){
    var img_path = $(this).attr('src');
    console.log(img_path);
    $('.divPopupImgViewer .product_img').attr('src',img_path);
    $('.divPopupImgViewer').fadeIn('fast');
    $('.divPopupImgViewerBG').fadeIn('fast');

    $('.divPopupImgViewer .closeBtn').css('left',Number($('.divPopupImgViewer').css('width').replace(/[^0-9]/g,''))-50+'px');
  });

  $('.divPopupImgViewerBG, .divPopupImgViewer .closeBtn, .divPopupImgViewer img').off();
  $('.divPopupImgViewerBG, .divPopupImgViewer .closeBtn, .divPopupImgViewer img').click(function(e){
    $('.divPopupImgViewerBG').fadeOut('fast');
    $('.divPopupImgViewer').fadeOut('fast');
  });

}
