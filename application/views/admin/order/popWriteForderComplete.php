<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>발주서</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/static/css/reset.css">
    <link rel="stylesheet" href="/static/semantic/semantic.min.css">
    <link rel="stylesheet" href="/static/css/admin/popup/popForderWrite.css">
    <script src="/static/semantic/semantic.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <style type="text/css" media="print">
       @page{margin:0;}
       .header button{display:none;}
    </style>
  </head>
  <body id="printBody">
    <div class="popup writeConfirmedForder">
      <div class="header">
        <button class="printBtn" type="button" name="button">출력</button>
      </div>
      <table class="title">
        <tr>
          <td colspan="2"><?=date('Y년 m월 d일',time())?></td>
        </tr>
        <tr>
          <?php if($MODE=='10'){?>
            <td colspan="2">발주서</td>
          <?php }?>
          <?php if($MODE=='20'){?>
            <td colspan="2">수정발주서</td>
          <?php }?>
          <?php if($MODE=='30'){?>
            <td colspan="2">확정발주서</td>
          <?php }?>
        </tr>
        <tr>
          <td></td><td>발주자 : 황선민</td>
        </tr>
        <tr>
          <td>E-Mail : sunmin@flanc.co.kr</td>
          <td>수신자 : 이원철, 김우철</td>
        </tr>
      </table>

      <form class="saveFrm" action="/admin/writeConfirmedForderSaveServ" method="post">
      <table class="grid">
        <tr class="header">
          <td>No</td><td>사진</td><td>상품명</td><td>구입</br>여부</td><td>요청수량</td><td>구입수량</td><td>단가</td><td>금액</td><td>구매처</td><td>비고</td>
        </tr>
        <?php
          $rowCnt = 1;
          $TT_CNT = 0;
          $TT_PRICE = 0;
          $TT_PURCHASE_CNT = 0;
          foreach($gridData as $item){
            echo "<tr class=\"body\">
              <td>".$rowCnt."<input type=\"hidden\" name=\"".$rowCnt."_id\" value=\"".$item->ID."\"></td>
              ";
              if($item->IMG_EXTENSION==""){
                echo "<td><img src=\"/static/uploads/product/noImage.png\"></td>";
              }else{
                echo "<td><img src=\"/static/uploads/product/".$item->ID.".".$item->IMG_EXTENSION."\"></td>";
              }
              echo "
              <td>".$item->NAME."</td>";

              if($MODE == 10){
                echo "<td class=\"checkBox\"><input type=\"checkbox\" onclick=\"return false;\"></td>";
              }else if($MODE == 20){
                echo "<td class=\"checkBox\"><input type=\"checkbox\" onclick=\"return false;\" "; if($item->IS_PURCHASED == 'Y' && $item->FORDER_TYPE == '01'){echo "checked";} echo "></td>";
              }else if($MODE == 30){
                echo "<td class=\"checkBox\"><input type=\"checkbox\" onclick=\"return false;\" "; if($item->IS_PURCHASED == 'Y'){echo "checked";} echo "></td>";
              }

              if($MODE == '10'){
                echo "
                <td>".number_format($item->QTY)."</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>";
              }else if($MODE == '20'){
                echo "
                <td>".number_format($item->QTY)."</td>
                <td>"; if($item->FORDER_TYPE == '01'){echo number_format($item->PURCHASED_AMOUNT);} echo "</td>
                <td>"; if($item->FORDER_TYPE == '01'){echo number_format($item->PURCHASED_PRICE);} echo "</td>
                <td>"; if($item->FORDER_TYPE == '01'){echo number_format($item->PURCHASED_AMOUNT*$item->PURCHASED_PRICE);} echo "</td>
                <td>"; if($item->FORDER_TYPE == '01'){echo $item->PURCHASED_SHOP;} echo "</td>
                <td>"; if($item->FORDER_TYPE == '01'){echo $item->MEMO;} echo "</td>";
              }else if($MODE == '30'){
                echo "
                <td>"; echo number_format($item->QTY); echo "</td>
                <td>"; echo number_format($item->PURCHASED_AMOUNT); echo "</td>
                <td>"; echo number_format($item->PURCHASED_PRICE); echo "</td>
                <td>"; echo number_format($item->PURCHASED_AMOUNT*$item->PURCHASED_PRICE); echo "</td>
                <td>"; echo $item->PURCHASED_SHOP; echo "</td>
                <td>"; echo $item->MEMO; echo "</td>";
              }

            echo "
            </tr>";

            $rowCnt++;
            if($MODE=='10'){
                $TT_CNT += $item->QTY;
            }else if($MODE=='20'){
              $TT_CNT += $item->QTY;
              if($item->FORDER_TYPE == '01'){
                $TT_PURCHASE_CNT += $item->PURCHASED_AMOUNT;
                $TT_PRICE += ($item->PURCHASED_AMOUNT * $item->PURCHASED_PRICE);
              }
            }else if($MODE=='30'){
              $TT_CNT += $item->QTY;
              $TT_PURCHASE_CNT += $item->PURCHASED_AMOUNT;
              $TT_PRICE += ($item->PURCHASED_AMOUNT * $item->PURCHASED_PRICE);
            }
          }
        ?>
        <tr>
          <td colspan="11" style="border:0px;"></td>
        </tr>
        <tr class="sum">
          <td rowspan="3" colspan="4">소계</td>
          <td rowspan="3"><?=$TT_CNT?></td>
          <td rowspan="3"><?php if($MODE=='10'){}else{ echo $TT_PURCHASE_CNT;}?></td>
          <td rowspan="3" colspan="2"></td>
          <td style="text-align:left; padding-left:16px">구매금액</td>
          <td style="text-align:right; padding:4px 8px;">
            <?php
              if($MODE == '10'){

              }else{
                echo number_format($TT_PRICE)." 원";
              }
            ?>
          </td>
        </tr>
        <tr class="sum">
          <td style="text-align:left; padding-left:16px">운임비</td>
          <td style="text-align:right; padding:4px 8px;" >
            <?php
              if($MODE == '10'){

              }else{
                echo number_format($gridData[0]->DELIVERY_FEE)." 원";
              }
            ?>
          </td>
        </tr>
        <tr class="sum">
          <td style="text-align:left; padding-left:16px">총액</td>
          <td style="text-align:right; padding:4px 8px;">
            <?php
              if($MODE == '10'){

              }else{
                echo number_format($TT_PRICE+$gridData[0]->DELIVERY_FEE)." 원";
              }
            ?>
          </td>
        </tr>
        <tr>
          <td colspan="11" style="border:0px;"></td>
        </tr>
        <tr>
          <td rowspan="2" colspan="2">메모</td>
          <td>부산메모</td>
          <td colspan="7"><textarea readonly><?php echo $gridData[0]->FMEMO1;?></textarea></td>
        </tr>
        <tr>
          <td>서울메모</td>
          <td colspan="7"><textarea readonly><?php if($MODE == '10'){}else{echo $gridData[0]->FMEMO2;}?></textarea></td>
        </tr>
      </table>
      <input class="submit_mode" type="hidden" name="mode" value="">
    </form>
    </div>
    <div class="divPopupImgViewer">
      <img class="closeBtn" src="/static/img/icon/ic_close_white.png">
      <img class="product_img" src="">
    </div>
    <div class="divPopupImgViewerBG"></div>
    <?php
      $getData="";
      foreach($dataArray as $id){
        $getData = $getData.$id;
      }
    ?>
    <script type="text/javascript">
      $('.header .printBtn').click(function(){
        window.print();
      });

      $('.header .saveBtn').click(function(){
        $('.submit_mode').val('1');
        $('.saveFrm').submit();
      });

      $('.header .completeBtn').click(function(){
        $('.submit_mode').val('2');
        $('.saveFrm').submit();
      });

      $('.forderRequestBtn').click(function(){
        window.opener.location.href="/admin/forderRequestServ?IDA=<?=$getData?>";
        window.close();
      });

      $('.variable').change(function(e){
        var price = uncomma($(this).parents('tr').children('.price').children('input').val());
        var qty = uncomma($(this).parents('tr').children('.qty').children('input').val());
        $(this).parents('tr').children('.price').children('input').val(comma(price));
        $(this).parents('tr').children('.qty').children('input').val(comma(qty));
        $(this).parents('tr').children('.purchasePrice').children('input').val(comma(price*qty));
        if(price != 0 && qty != 0){
          $(this).parents('tr').children('.checkBox').children('input[type="checkbox"]').prop('checked',true);
          $(this).parents('tr').children('.checkBox').children('.inputCheckBox').val('Y');
        }else{
          $(this).parents('tr').children('.checkBox').children('input[type="checkbox"]').prop('checked',false);
          $(this).parents('tr').children('.checkBox').children('.inputCheckBox').val('N');
        }
        checkTotalPurchasePrice();
      });

      $('.deliveryFee').change(function(e){
        $('.deliveryFee').val(comma($('.deliveryFee').val()));
        setTotalPrice();
      });

      function checkTotalPurchasePrice(){
        var totalPrice = 0;
        var totalPurchaseCnt = 0;
        $('.checkBox input').each(function(e){
          if($(this).prop('checked')){
            totalPrice += Number(uncomma($(this).parents('td').parents('tr').children('.purchasePrice').children('input').val()));
          }
        });
        $('.checkBox input').each(function(e){
          if($(this).prop('checked')){
            totalPurchaseCnt += Number(uncomma($(this).parents('td').parents('tr').children('.qty').children('input').val()));
          }
        });
        $('.sum .totalPurchaseCnt').text(comma(totalPurchaseCnt));
        $('.sum .totalPrice input').val(comma(totalPrice));
        setTotalPrice();
      }

      //콤마찍기
      function comma(str) {
        str = String(str);
        return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
      }

      //콤마풀기
      function uncomma(str) {
          str = String(str);
          return str.replace(/[^\d]+/g, '');
      }

      function setTotalPrice(){
        $('.ForderTotalPrice').val(comma(Number(uncomma($('.deliveryFee').val())) + Number(uncomma($('.sum .totalPrice input').val()))));
      }

      $(document).ready(function(){
        checkTotalPurchasePrice();
      });

      $('.grid .body img').click(function(e){
        var img_path = $(this).attr('src');
        console.log(img_path);
        $('.divPopupImgViewer .product_img').attr('src',img_path);
        $('.divPopupImgViewer').fadeIn('fast');
        $('.divPopupImgViewerBG').fadeIn('fast');
        $('.divPopupImgViewer .closeBtn').css('left',Number($('.divPopupImgViewer').css('width').replace(/[^0-9]/g,''))-50+'px');
      });

      $('.divPopupImgViewerBG, .divPopupImgViewer .closeBtn, .divPopupImgViewer img').click(function(e){
        $('.divPopupImgViewerBG').fadeOut('fast');
        $('.divPopupImgViewer').fadeOut('fast');
      });
    </script>
  </body>
</html>
