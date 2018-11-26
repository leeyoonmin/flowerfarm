<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>꽃팜 - 관리자페이지</title>
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
       body{padding:32px;}
       .header button{display:none;}

    </style>
  </head>
  <body id="printBody">
    <div class="popup writeModifiedForder">
      <div class="header">
        <button class="printBtn" type="button" name="button">출력</button>
        <?php if($MODIFY == 'true'){?>
        <button class="saveBtn" type="button" name="button">임시저장</button>
        <button class="completeBtn" type="button" name="button">작성완료</button>
        <?php }?>
      </div>
      <table class="title">
        <tr>
          <td colspan="2"><?=date('Y년 m월 d일',time())?></td>
        </tr>
        <tr>
          <td colspan="2">수정발주서</td>
        </tr>
        <tr>
          <td></td><td>발주자 : 황선민</td>
        </tr>
        <tr>
          <td>E-Mail : sunmin@flanc.co.kr</td>
          <td>수신자 : 이원철, 김우철</td>
        </tr>
      </table>

      <form class="saveFrm" action="/admin/writeForderSaveServ" method="post">

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
              <td>".$item->NAME."</td>
              <td class=\"checkBox\"><input type=\"checkbox\" onclick=\"return false;\" "; if($item->IS_PURCHASED == 'Y'){echo "checked";} echo "><input name=\"".$rowCnt."_isPurchased\" class=\"inputCheckBox\" type=\"hidden\" value=\"".$item->IS_PURCHASED."\"></td>
              <td class=\"documentInput request_qty variable\"><input type=\"text\" name=\"".$rowCnt."_qty\" value=\"".number_format($item->QTY)."\" readonly></td>
              <td class=\"documentInput qty variable\"><input type=\"text\" name=\"".$rowCnt."_qty\" value=\""; if($item->PURCHASED_AMOUNT != 0) echo number_format($item->PURCHASED_AMOUNT);{echo "";} echo"\"></td>
              <td class=\"documentInput price variable\"><input type=\"text\" name=\"".$rowCnt."_price\" value=\""; if($item->PURCHASED_PRICE != 0) echo number_format($item->PURCHASED_PRICE); echo"\"></td>
              <td class=\"documentInput purchasePrice\"><input type=\"text\" value=\""; if($item->PURCHASED_AMOUNT*$item->PURCHASED_PRICE != 0) echo number_format($item->PURCHASED_AMOUNT*$item->PURCHASED_PRICE); else{echo 0;} echo"\" readonly></td>
              <td class=\"documentInput purchaseShop\"><input type=\"text\" name=\"".$rowCnt."_purchaseShop\" value=\"".$item->PURCHASED_SHOP."\"></td>
              <td class=\"documentInput memo\"><input type=\"text\" name=\"".$rowCnt."_memo\" value=\"".$item->MEMO."\"></td>
            </tr>";
            $rowCnt++;
            $TT_CNT += $item->QTY;
            $TT_PRICE += ($item->PRODUCT_PRICE*$item->QTY);
            if($item->IS_PURCHASED == "Y"){
              $TT_PURCHASE_CNT = $TT_PURCHASE_CNT + $item->QTY;
            }
          }
        ?>
        <tr>
          <td colspan="11" style="border:0px;"></td>
        </tr>
        <tr class="sum">
          <td rowspan="3" colspan="4"><input type="hidden" name="FODID" value="<?=$FODID?>">소계</td>
          <td class="totalCnt" rowspan="3"><?=$TT_CNT?></td>
          <td class="totalPurchaseCnt" rowspan="3">$TT_PURCHASE_CNT</td>
          <td rowspan="3" colspan="2"></td>
          <td class="td4" style="text-align:left; padding:4px; padding-left:16px">구매금액</td>
          <td class="td6 documentInput totalPrice" style="text-align:left; padding:4px; padding-left:16px">
            <input type="text" value="" readonly>
          </td>
        </tr>
        <tr class="sum">
          <td class="td4"style="text-align:left; padding:4px; padding-left:16px">운임비</td>
          <td class="td6 documentInput" style="text-align:left; padding:4px; padding-left:16px;" >
            <input class="deliveryFee" type="text" name="delivery_fee" value="<?=number_format($gridData[0]->DELIVERY_FEE)?>">
          </td>
        </tr>
        <tr class="sum">
          <td class="td4" style="text-align:left; padding:4px;   padding-left:16px">총액</td>
          <td class="td6 documentInput" style="text-align:left; padding:4px; padding-left:16px;" >
            <input class="ForderTotalPrice" type="text" value="" readonly>
          </td>
        </tr>
        <tr>
          <td colspan="11" style="border:0px;"></td>
        </tr>
        <tr>
          <td rowspan="2" colspan="2">메모</td>
          <td>부산메모</td>
          <td colspan="7"><textarea class="inputMemo" name="fmemo1"><?=($gridData[0]->FMEMO1)?></textarea></td>
        </tr>
        <tr>
          <td>서울메모</td>
          <td colspan="7"><textarea class="inputMemo" name="fmemo2"><?=($gridData[0]->FMEMO1)?></textarea></td>
        </tr>
      </table>
      <input class="submit_mode" type="hidden" name="mode" value="">
    </form>
    </div>
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
    </script>
  </body>
</html>
