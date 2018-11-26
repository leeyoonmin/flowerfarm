<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>상품추가</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="/static/css/reset.css">
    <script src="/static/semantic/semantic.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <style type="text/css">
        body{background-color:#f5f5f5;}
        .wrap{padding:32px; width::100%; min-height:100%;}
        .divSelectProduct{display:inline-block; width:300px; padding:16px; background-color:#fff; border-radius:5px; margin-right:16px; vertical-align:middle;}
        .divSelectProduct td{padding:8px;}
        .divSelectProduct .resultList::-webkit-scrollbar{width:4px;}
        .divSelectProduct .resultList::-webkit-scrollbar-track{background:#f5f5f5}
        .divSelectProduct .resultList::-webkit-scrollbar-thumb{background-color:#c984f9; border-radius:2px;}
        .divSelectProduct .resultList::-webkit-scrollbar-thumb:hover{transition:300ms; background:#c984f9;}
        .divSelectProduct .resultList{max-height:700px; min-height:700px; overflow-y:scroll; padding-right:8px;}
        .divSelectProduct .resultList .resultItem{font-weight:400; border:1px solid #ddd; border-radius:4px; padding:8px 4px; margin-bottom:8px; cursor:pointer}
        .divSelectProduct .resultList .resultItem:hover{transition:200ms; background-color:#eee;}
        .divSelectProduct .resultList .resultItem:last-of-type{margin-bottom:0;}

        .divSelectOrder{display:inline-block; width:300px; padding:16px; background-color:#fff; border-radius:5px; margin-right:16px; vertical-align:middle;}
        .divSelectOrder td{padding:8px;}
        .divSelectOrder .resultList::-webkit-scrollbar{width:4px;}
        .divSelectOrder .resultList::-webkit-scrollbar-track{background:#f5f5f5}
        .divSelectOrder .resultList::-webkit-scrollbar-thumb{background-color:#c984f9; border-radius:2px;}
        .divSelectOrder .resultList::-webkit-scrollbar-thumb:hover{transition:300ms; background:#c984f9;}
        .divSelectOrder .resultList{max-height:700px; min-height:700px; overflow-y:scroll; padding-right:8px;}
        .divSelectOrder .resultList .resultItem{font-weight:400; border:1px solid #ddd; border-radius:4px; padding:8px 4px; margin-bottom:8px; cursor:pointer}
        .divSelectOrder .resultList .resultItem:last-of-type{margin-bottom:0;}
        .divSelectOrder .resultList .resultItem:hover{transition:300ms; background-color:#f5f5f5;}
        .divSelectOrder .resultList .resultItem.selected{transition:300ms; background-color:#f2e7ff; border:1px solid #c984f9}

        .divResult{display:inline-block; width:300px; padding:16px; background-color:#fff; border-radius:5px; vertical-align:middle;}
        .divResult .orderInfo{width:100%; margin-bottom:8px;}
        .divResult .orderInfo td{padding:8px;}
        .divResult .itemList{min-height:600px; max-height:600px; overflow-y:scroll; padding-right:8px;}
        .divResult .itemList::-webkit-scrollbar{width:4px;}
        .divResult .itemList::-webkit-scrollbar-track{background:#f5f5f5}
        .divResult .itemList::-webkit-scrollbar-thumb{background-color:#c984f9; border-radius:2px;}
        .divResult .itemList::-webkit-scrollbar-thumb:hover{transition:300ms; background:#c984f9;}
        .divResult .itemList table{width:100%;}
        .divResult .itemList .item{line-height:24px; border:1px solid #ddd;}
        .divResult .itemList .item img{height:20px; line-height:24px; vertical-align:middle;}
        .divResult .itemList .item a{font-size:12px; border:1px solid #ddd; padding:2px 5px 3px 4px; cursor:pointer;}
        .divResult .itemList .item span{padding:4px 8px;}
        .divResult .itemList .item td{padding:8px; vertical-align:middle;}
        .divResult .itemList .item td:nth-of-type(2){width:80px;}
        .divResult .itemList .item td:nth-of-type(3){width:40px; cursor:pointer; padding-top:8px;}
        .submitBtn{width:100%; border:0; background:#c984f9; color:#fff; padding:8px;}
    </style>
  </head>
  <body id="printBody">
    <div class="wrap">

      <div class="divSelectOrder">
        <table>
          <tr>
            <td>주문검색</td>
            <td><input class="keyword" type="text" name="" value=""></td>
          </tr>
        </table>
        <div class="resultList">
          <?php
            foreach($orderList as $item){
              echo "<h5 class=\"resultItem\" ORDER_ID=\"".$item->ORDER_ID."\">".$item->USER_ID."/".$item->USER_NAME."/".$item->CERTI_NAME."</h5>";
            }
          ?>
        </div>
      </div>

      <div class="divSelectProduct">
        <table>
          <tr>
            <td>상품검색</td>
            <td><input class="keyword" type="text" name="" value=""></td>
          </tr>
        </table>
        <div class="resultList">
          <?php
            foreach($productList as $item){
              echo "<h5 class=\"resultItem\" PRODUCT_ID=\"".$item->PRODUCT_ID."\">".$item->PRODUCT_NAME."</h5>";
            }
          ?>
        </div>
      </div>

      <div class="divResult">
        <table class="orderInfo">
          <tr>
            <td>아이디</td><td></td>
          </tr>
          <tr>
            <td>고객명</td><td></td>
          </tr>
          <tr>
            <td>상호명</td><td></td>
          </tr>
        </table>
        <div class="itemList">
          <table>

          </table>
        </div>
        <input class="HD_FODID" type="hidden" name="FODID" value="<?=$FODID?>">
        <input class="HD_ORDER_ID" type="hidden" name="ORDER_ID" value="">
        <input class="submitBtn" type="button" value="상품추가">
      </div>

    </div>
    <script type="text/javascript">
      $('.divSelectProduct .keyword').on('change keyup paste',function(e){
        var keyword = $(this).val();
        $.ajax({
            url:"/admin/searchProduct",
            type: "POST",
            datatype:'json',
            data: {'keyword':keyword},
            error:function(request,status,error){
              console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            },
            success: function(data){
              var jsonData = JSON.parse(data)['data'];
              $('.divSelectProduct .resultList .resultItem').remove();
              for(var i in jsonData){
                $('.divSelectProduct .resultList').append(`
                  <h5 class="resultItem" PRODUCT_ID="`+jsonData[i]['PRODUCT_ID']+`">`+jsonData[i]['PRODUCT_NAME']+`</h5>
                `);
              }
              $('.divSelectProduct .resultList .resultItem').off();
              addProductListEvent();
            }
        });
      });

      $('.divSelectOrder .keyword').on('change keyup paste',function(e){
        var keyword = $(this).val();
        var FODID = $('.HD_FODID').val();
        console.log(FODID);
        $.ajax({
            url:"/admin/searchOrder",
            type: "POST",
            datatype:'json',
            data: {'keyword':keyword, 'FODID':FODID},
            error:function(request,status,error){
              console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            },
            success: function(data){
              var jsonData = JSON.parse(data)['data'];
              $('.divSelectOrder .resultList .resultItem').remove();
              for(var i in jsonData){
                $('.divSelectOrder .resultList').append(`
                  <h5 class="resultItem" ORDER_ID="`+jsonData[i]['ORDER_ID']+`">`+jsonData[i]['USER_ID']+"/"+jsonData[i]['USER_NAME']+"/"+jsonData[i]['CERTI_NAME']+`</h5>
                `);
              }
              $('.divSelectOrder .resultList .resultItem').off();
              addOrderListEvent();
            }
        });
      });

      addProductListEvent();
      addOrderListEvent();

      function addProductListEvent(){
        $('.divSelectProduct .resultList .resultItem').off();
          $('.divSelectProduct .resultList .resultItem').click(function(e){
            var PRD_ID = $(this).attr('product_id');
            var PRD_NM = $(this).text();
            var IS_ITEM = false;
            $('.divResult .itemList .item').each(function(e){
              if($(this).attr('product_id') == PRD_ID){
                IS_ITEM = true;
                var qty = $(this).children('td').children('span').text();
                $(this).children('td').children('span').text(Number(qty)+1);
              }
            });
            if(IS_ITEM == false){
              $('.divResult .itemList table').append(`
                <tr class="item" product_id="`+PRD_ID+`">
                  <td>`+PRD_NM+`</td>
                  <td><a class="minus">－</a><span>1</span><a class="plus">＋</a></td>
                  <td><img src="/static/img/icon/ic_trash_gray.png"></td>
                </tr>
              `);
              addResultListEvent();
            }
          });
      }

      function addOrderListEvent(){
        $('.divSelectOrder .resultList .resultItem').click(function(e){
          $('.divSelectOrder .resultList .resultItem').removeClass('selected');
          $(this).addClass('selected');
          $('.HD_ORDER_ID').val($(this).attr('ORDER_ID'));
          var array = $(this).text().split('/');
          $('.divResult .orderInfo tr:nth-of-type(1) td:nth-of-type(2)').text(array[0]);
          $('.divResult .orderInfo tr:nth-of-type(2) td:nth-of-type(2)').text(array[1]);
          $('.divResult .orderInfo tr:nth-of-type(3) td:nth-of-type(2)').text(array[2]);
        });
      }

      function addResultListEvent(){
        $('.divResult .itemList .item td:nth-of-type(3)').off();
        $('.divResult .itemList .item td:nth-of-type(3)').click(function(e){
          $(this).parents('tr').remove();
        });
        $('.divResult .itemList .item td a').off();
        $('.divResult .itemList .item td a').click(function(e){
          setProductQty(this);
        });
      }

      function setProductQty(e){
        var qty = $(e).parents('td').children('span').text();
        if($(e).hasClass('plus')){
          qty = Number(qty)+1;
          $(e).parents('td').children('span').text(qty);
        }else if($(e).hasClass('minus')){
          qty = Number(qty)-1;
          $(e).parents('td').children('span').text(qty);
          if(qty==0){
            $(e).parents('td').parents('tr').remove();
          }
        }
      }

      $('.submitBtn').click(function(e){
        var ORDER_ID = $('.HD_ORDER_ID').val();
        var FODID = $('.HD_FODID').val();
        var PRD_LIST = new Array();
        $('.divResult .itemList .item').each(function(e){
          var PRODUCT_ID = $(this).attr('product_id');
          var QTY = $(this).children('td').children('span').text();
          PRD_LIST.push({PRD_ID:PRODUCT_ID, QTY:QTY});
        });

        if(ORDER_ID==""){
          alert("주문을 선택해주세요.");
          return false;
        }else if(PRD_LIST.length==0){
          alert("상품을 선택해주세요.");
          return false;
        }

        $.ajax({
            url:"/admin/addProductToForderServ",
            type: "POST",
            datatype:'json',
            data: {'FODID':FODID, 'ORDER_ID':ORDER_ID, 'PRD_LIST':PRD_LIST},
            error:function(request,status,error){
              console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
            },
            success: function(data){
              window.opener.location.reload();
              location.href='/admin/popupWriteForder?FODID='+FODID+'&MODE=10';
            }
        });

      });


    </script>
  </body>
</html>
