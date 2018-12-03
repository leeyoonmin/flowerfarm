<?php
$TOTAL_PRICE = 0;
$TOTAL_QTY = 0;
foreach($TRADING as $item){
  if($item->IS_PURCHASED == "Y"){
    $TOTAL_PRICE += $item->TT_PRICE;
    $TOTAL_QTY += $item->QTY;
  }
}
$TOTAL_PRICE = $TOTAL_PRICE + $TRADING[0]->DELIVERY_FEE;
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>거래명세서</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="/static/css/reset.css">
    <style media="print">
      @page{margin:0;}
      body{padding:32px 48px;}
      .divHeader .title1{text-align:center; line-height:96px; font-size:28px;}
      .divHeader .title2{text-align:left; line-height:24px; font-size:16px; margin}
      .divHeader .title3{text-align:right; line-height:24px; font-size:16px;}
      .divProductList table{width:100%; margin-top:16px;}
      .divProductList td{padding:8px; border:1px solid #252626;}
      .divProductList td:nth-of-type(1){text-align:center;}
      .divProductList td:nth-of-type(4){text-align:center;}
      .divProductList td:nth-of-type(5){text-align:right;}
      .divProductList td:nth-of-type(6){text-align:right;}
      .divProductList tr:first-of-type td{background-color:#eee; text-align:center;}
      .divProductList tr:last-of-type td:nth-of-type(1){background-color:#fffee4; text-align:center;}
      .divProductList tr:last-of-type td:nth-of-type(2){background-color:#fffee4; text-align:center;}
      .divProductList tr:last-of-type td:nth-of-type(3){background-color:#fffee4; text-align:right;}
      .divProductList tr.notPurchased td{text-decoration:line-through;}
      .divProductList tr.notPurchased td:last-of-type{text-decoration:none;}
      .divProductList .totalPrice{text-align:right; padding:8px;}
    </style>
    <style media="screen">
      body{padding:0px 32px;}
      .divHeader .title1{text-align:center; line-height:96px; font-size:28px;}
      .divHeader .title2{text-align:left; line-height:24px; font-size:16px; margin}
      .divHeader .title3{text-align:right; line-height:24px; font-size:16px;}
      .divProductList table{width:100%; margin-top:16px;}
      .divProductList td{padding:8px; border:1px solid #252626;}
      .divProductList td:nth-of-type(1){text-align:center;}
      .divProductList td:nth-of-type(4){text-align:center;}
      .divProductList td:nth-of-type(5){text-align:right;}
      .divProductList td:nth-of-type(6){text-align:right;}
      .divProductList tr:first-of-type td{background-color:#eee; text-align:center;}
      .divProductList tr:last-of-type td:nth-of-type(1){background-color:#fffee4; text-align:center;}
      .divProductList tr:last-of-type td:nth-of-type(2){background-color:#fffee4; text-align:center;}
      .divProductList tr:last-of-type td:nth-of-type(3){background-color:#fffee4; text-align:right;}
      .divProductList tr.notPurchased td{text-decoration:line-through;}
      .divProductList tr.notPurchased td:last-of-type{text-decoration:none;}
      .divProductList .totalPrice{text-align:right; padding:8px;}
    </style>
  </head>
  <body>
    <div class="divHeader">
      <h1 class="title1">거　래　명　세　서</h1>
      <p class="title2">주문일자 : <?=date('Y. m. d.',strtotime($TRADING[0]->ORDER_TIME))?></p>
      <p class="title2">구매자 : <?=$TRADING[0]->USER_NM?><?php if(!empty($TRADING[0]->SHOP_NM)){ echo " / ".$TRADING[0]->SHOP_NM;}?><?="(".$TRADING[0]->USER_ID.")"?></p>
      <p class="title2">합계금액 : <?=number_format($TOTAL_PRICE)?></p>
      <p class="title3">회사 : 꽃팜</p>
      <p class="title3">담당자 : 황선민 이사</p>
      <p class="title3">연락처 : 010-2724-7297</p>
      <p class="title3">주소 : 부산광역시 동래구 안락로 66-2, 1층</p>
    </div>
    <div class="divProductList">
      <table>
        <tr>
          <td>번호</td>
          <td>상품명</td>
          <td>색상/크기</td>
          <td>수량</td>
          <td>가격</td>
          <td>총계</td>
          <td>비고</td>
        </tr>
        <?php
          $rowCnt = 1;
          $TOTAL_PRICE = 0;
          foreach($TRADING as $item){
              echo "
              <tr class=\""; if($item->IS_PURCHASED == "N"){echo "notPurchased";}else{$TOTAL_PRICE += $item->TT_PRICE;} echo "\">
                <td>".$rowCnt."</td>
                <td>".$item->PRODUCT_NAME."</td>
                <td>".$item->COLOR."</td>
                <td>".number_format($item->QTY)."</td>
                <td>".number_format($item->PRICE)."</td>
                <td>".number_format($item->TT_PRICE)."</td>
                <td>".$item->MEMO."</td>
              </tr>
              ";
            $rowCnt++;
          }
        ?>
        <?php if($TRADING[0]->DELIVERY_TYPE=="퀵서비스"){?>
        <tr>
          <td><?=$rowCnt?></td>
          <td>배송비</td>
          <td><?=$TRADING[0]->DELIVERY_TYPE?></td>
          <td></td>
          <td><?=$TRADING[0]->DELIVERY_FEE?></td>
          <td><?=$TRADING[0]->DELIVERY_FEE?></td>
          <td></td>
        </tr>
        <?php }?>
        <tr>
          <td colspan="3"></td>
          <td><?=number_format($TOTAL_QTY)?></td>
          <td colspan="3">총계 : <?=number_format($TOTAL_PRICE + $TRADING[0]->DELIVERY_FEE)?></td>
        </tr>
      </table>
      <p class="totalPrice">* 입금계좌 : 농협 0365-3650-09 김성수</p>
    </div>
    <script type="text/javascript">
    $(document).ready(function(){
      window.print();
    });
    </script>
  </body>
</html>
