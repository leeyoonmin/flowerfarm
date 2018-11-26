<?php
  $TT_ORDER_PRICE = 0;
  foreach($orderInfo as $item){
    $TT_ORDER_PRICE += $item->ORDER_AMOUNT * $item->ORDER_PRICE;
  }
?>
<div class="wrap orderDetail">

  <div class="divPayment divTable">
    <div class="divTitle">
      결제정보
    </div>
    <table>
      <tr>
        <td>결제방법</td><td><?=$orderInfo[0]->PAY_TYPE_NM?></td>
      </tr>
      <tr>
        <td>입금은행</td><td>농협</td>
      </tr>
      <tr>
        <td>예금주</td><td>김성수(플랑)</td>
      </tr>
      <tr>
        <td>계좌번호</td><td>0365-3650-09</td>
      </tr>
      <tr>
        <td>입금금액</td><td><?=number_format($TT_ORDER_PRICE+$orderInfo[0]->DELIVERY_FEE)?> 원</td>
      </tr>
      <tr>
        <td>결제여부</td><td><?php if($orderInfo[0]->IS_PAID == "Y"){echo "입금완료";}else{echo "입금전";}?></td>
      </tr>
    </table>
  </div>

  <div class="divOrderInfo divTable">
    <div class="divTitle">
      주문정보
    </div>
    <table>
      <tr>
        <td>주문자명</td><td><?=$orderInfo[0]->RECIP_NAME?></td>
      </tr>
      <tr>
        <td>주소</td><td><?=$orderInfo[0]->RECIP_ADDR?></td>
      </tr>
      <tr>
        <td>전화번호</td><td><?=$orderInfo[0]->RECIP_TEL?></td>
      </tr>
      <tr>
        <td>배송희망일자</td><td><?=date("Y년 m월 d일",strtotime($orderInfo[0]->DELIVERY_DATE))?></td>
      </tr>
      <tr>
        <td>배송방법</td><td><?=$orderInfo[0]->DELIVERY_TYPE_NM?></td>
      </tr>
      <tr>
        <td>주문상태</td><td><?=$orderInfo[0]->ORDER_STAT_NM?></td>
      </tr>
      <tr>
        <td>배송요청사항</td><td><?=$orderInfo[0]->REQ_MSG?></td>
      </tr>
    </table>
  </div>

  <div class="divProductInfo divList">
    <div class="divTitle">
      상품정보
    </div>
    <table>
      <tr>
        <td>사진</td><td>상품명</td><td>수량</td><td>가격</td>
      </tr>
      <?php
      foreach($orderInfo as $item){
        echo "
        <tr>";
        if(empty($item->IMG_EXTENSION)){
          echo "<td class=\"imgTD\"><img src=\"/static/uploads/product/noImage.png\"></td>";
        }else{
          echo "<td class=\"imgTD\"><img src=\"/static/uploads/product/".$item->PRODUCT_ID.".$item->IMG_EXTENSION\"></td>";
        }
        echo "
          <td class=\"nameTD\">".$item->PRODUCT_NAME."</td>
          <td class=\"qtyTD\">".$item->ORDER_AMOUNT."</td>
          <td class=\"priceTD\">".number_format($item->ORDER_PRICE)." 원</td>
        </tr>
        ";
      }
      ?>
    </table>
  </div>

</div>

<div class="divPopupImgViewer">
  <img class="closeBtn" src="/static/img/icon/ic_close_white.png">
  <img class="product_img" src="">
</div>
<div class="divPopupImgViewerBG"></div>
