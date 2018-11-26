<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>　</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/static/css/reset.css">
    <link rel="stylesheet" href="/static/semantic/semantic.min.css">
    <link rel="stylesheet" href="/static/css/admin/popup/popForderWrite.css">
    <script src="/static/semantic/semantic.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <style type="text/css">

    </style>
  </head>
  <body id="printBody" class="writeModifiedForder">
    <div class="popup">
      <div class="header">
        <button class="addProductBtn" type="button" name="button">상품추가</button>
        <button class="printBtn" type="button" name="button">출력</button>
        <button class="completeForderBtn" type="button" name="button">발주서 작성완료</button>
        <!--button class="saveBtn" type="button" name="button">임시저장</button>
        <button class="completeBtn" type="button" name="button">발주완료</button-->
      </div>
      <table class="title">
        <tr>
          <td colspan="2"><?=date('Y년 m월 d일',time())?></td>
        </tr>
        <tr>
          <td colspan="2">발주서</td>
        </tr>
        <tr>
          <td></td><td>발주자 : 황선민</td>
        </tr>
        <tr>
          <td>E-Mail : sunmin@flanc.co.kr</td>
          <td>수신자 : 이원철, 김우철</td>
        </tr>
      </table>

      <form class="saveFrm" action="/admin/writeOrderSaveServ" method="post">

      <table class="body">
        <tr class="header">
          <td>No</td><td>사진</td><td>상품명</td><td>구입</br>여부</td><td>요청수량</td><td>구입수량</td><td>단가</td><td>금액</td><td>구매처</td><td>비고</td>
        </tr>
        <?php
          $rowCnt = 1;
          $TT_CNT = 0;
          $TT_PRICE = 0;
          foreach($gridData as $item){
            echo "<tr>
              <td>".$rowCnt."<input type=\"hidden\" name=\"".$rowCnt."_id\" value=\"".$item->ID."\"></td>
              ";
              if($item->IMG_EXTENSION==""){
                echo "<td><img src=\"/static/uploads/product/noImage.png\"></td>";
              }else{
                echo "<td><img src=\"/static/uploads/product/".$item->ID.".".$item->IMG_EXTENSION."\"></td>";
              }
              echo "
              <td>".$item->NAME."</td>
              <td class=\"checkBox\"><input type=\"checkbox\" onclick=\"return false;\"><input name=\"".$rowCnt."_isPurchased\" class=\"inputCheckBox\" type=\"hidden\" value=\"".$item->IS_PURCHASED."\" readonly></td>
              <td class=\"documentInput qty variable\"><input type=\"text\" name=\"".$rowCnt."_qty\" value=\"".$item->QTY."\"  readonly></td>
              <td class=\"documentInput qty variable\"><input type=\"text\" name=\"".$rowCnt."_qty\" value=\"\"  readonly></td>
              <td class=\"documentInput price variable\"><input type=\"text\" name=\"".$rowCnt."_price\" value=\"\"  readonly></td>
              <td class=\"documentInput purchasePrice\"><input type=\"text\" value=\"\" readonly></td>
              <td class=\"documentInput purchaseShop\"><input type=\"text\" name=\"".$rowCnt."_purchaseShop\" value=\"\"  readonly></td>
              <td class=\"documentInput memo\"><input type=\"text\" name=\"".$rowCnt."_memo\" value=\"\"  readonly></td>
            </tr>";
            $rowCnt++;
            $TT_CNT += $item->QTY;
            $TT_PRICE += ($item->PURCHASED_PRICE*$item->PURCHASED_AMOUNT);
          }
        ?>
      </table>
      <table class="sum">
        <tr>
          <td rowspan="3"><input type="hidden" name="FODID" value="<?=$FODID?>">소계</td>
          <td class="totalCnt" rowspan="3"><?=$TT_CNT?></td>
          <td class="totalPurchaseCnt" rowspan="3"></td>
          <td class="td3" rowspan="3"></td>
          <td class="td4" style="text-align:left; padding-left:16px">구매금액</td>
          <td class="price">￦</td>
          <td class="td6 documentInput totalPrice" style="text-align:left; padding-left:16px">
            <input type="text" value=""  readonly>
          </td>
        </tr>
        <tr>
          <td class="td4" style="text-align:left; padding-left:16px">운임비</td>
          <td class="price">￦</td>
          <td class="td6 documentInput" style="text-align:left; padding-left:16px;" >
            <input class="deliveryFee" type="text" name="delivery_fee" value=""  readonly>
          </td>
        </tr>
        <tr>
          <td class="td4" style="text-align:left; padding-left:16px">총액</td>
          <td class="price">￦</td>
          <td class="td6 documentInput" style="text-align:left; padding-left:16px;" >
            <input class="ForderTotalPrice" type="text" value="" readonly>
          </td>
        </tr>
      </table>
      <table class="memo">
        <tr>
          <td>메모</td><td><textarea class="inputMemo" name="fmemo"></textarea></td>
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
      $('.header .addProductBtn').click(function(){
        location.href="/admin/addProductToForder?FODID=<?=$FODID?>";
      });
      $('.completeForderBtn').click(function(){
        window.opener.location.href="/admin/completeForderServ?FODID=<?=$FODID?>";
        window.close();
      });
    </script>
  </body>
</html>
