<div class="wrap accountList">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">일별 회계장부</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divSearch box width100">
    <table>
      <tr class="trText">
        <td>기간</td>
      </tr>
      <tr class="trInput">
        <td class="tdDatePicker">
          <input class="inputDatePicker FRDT openCalendar" type="text" value="<?php if(!empty($getData['FRDT'])){ echo date('Y-m-d',strtotime($getData['FRDT']));}else{echo date('Y-m-d', strtotime("-7 days"));}?>" placeholder="시작일자"><input class="FRDT btnDatePicker openCalendar" type="button" name="" value="D">
           ~
          <input class="inputDatePicker TODT openCalendar" type="text" value="<?php if(!empty($getData['TODT'])){ echo date('Y-m-d',strtotime($getData['TODT']));}else{echo date('Y-m-d',time());}?>" placeholder="종료일자"><input class="TODT btnDatePicker openCalendar" type="button" name="" value="D">
        </td>
      </tr>

    </table>
  </div>

  <div class="division"></div>

  <div class="divButton box width100">
    <table>
      <tr>
        <td></td>
        <td>
          <input class="btn green searchBtn" type="button" name="" value="조회">
        </td>
      </tr>
    </table>
  </div>

  <div class="divGrid">
    <table id="grid1">
      <tr>
        <td>총 판매가(+배송비)</td>
        <td>총 구입액(+운임비)</td>
        <td>총 마진</td>
      </tr>
      <tr>
        <td style="color:blue"><?=number_format($gridData2->ORDER_PRICE)?></td>
        <td style="color:red"><?=number_format($gridData2->PURCHASED_PRICE)?></td>
        <td style="color:<?php if($gridData2->ORDER_PRICE-$gridData2->PURCHASED_PRICE<0){echo "red";}else if($gridData2->ORDER_PRICE-$gridData2->PURCHASED_PRICE>0){echo "blue";}?>"><?=number_format($gridData2->ORDER_PRICE-$gridData2->PURCHASED_PRICE)?></td>
      </tr>
    </table>
    <table id="grid2">
      <tr>
        <td>배송일자</td>
        <td>이름/상호명(아이디)</td>
        <td>상품명</td>
        <td>주문수량</td>
        <td>판매단가</td>
        <td>매입단가</td>
        <td>판매가</td>
        <td>매입가</td>
        <td>마진</td>
        <td>판매가총액</td>
        <td>매입가총액</td>
        <td>총 마진</td>
        <td>결제여부</td>
        <td>배송여부</td>
        <td>총 구입액(+운임비)</td>
      </tr>
      <?php
      $deliveryDateArr = array();
      $deliveryDateCnt = 0;
      $deliveryDate = "";
      $userIDArr = array();
      $userIDCnt = 0;
      $userID = "";

        foreach($gridData as $row){
            $PRD_NM = $row->PRODUCT_CATE."_".$row->PRODUCT_NAME;
            if($deliveryDate != $row->DELIVERY_DATE){
              $deliveryDate = $row->DELIVERY_DATE;
              $deliveryDateArr[$deliveryDateCnt] = $row->DELIVERY_DATE;
              $deliveryDateCnt++;
            }
            if($userID != $row->USER_ID){
              $userID = $row->USER_ID;
              $userIDArr[$userIDCnt] = $row->USER_ID;
              $userIDCnt++;
            }
          echo "
            <tr>
              <td rowspan=\"1\" class=\"deliveryDate".$row->DELIVERY_DATE."\">".date('Y-m-d',strtotime($row->DELIVERY_DATE))."</td>
              <td rowspan=\"1\" class=\"userName".$row->DELIVERY_DATE."\">"; if($row->SHOP_NAME != ""){echo $row->SHOP_NAME;}else{echo $row->USER_NAME;} echo"</BR>(".$row->USER_ID.")</td>
              <td rowspan=\"1\">".$row->PRODUCT_CATE."_".$row->PRODUCT_NAME."</td>
              <td rowspan=\"1\">".$row->ORDER_AMOUNT."</td>
              <td rowspan=\"1\">".number_format($row->ORDER_PRICE)."</td>
              <td rowspan=\"1\">".number_format($row->PURCHASED_PRICE)."</td>
              <td rowspan=\"1\">".number_format($row->TT_ORDER_PRICE)."</td>
              <td rowspan=\"1\">".number_format($row->TT_PURCHASED_PRICE)."</td>
              <td rowspan=\"1\" style=\"color:"; if($row->BENEFIT>0){echo "blue";}else if($row->BENEFIT<0){echo "red";} echo "\">".number_format($row->BENEFIT)."</td>
              <td rowspan=\"1\" class=\"sum_order_price".$row->DELIVERY_DATE.$row->USER_ID."\">".number_format($row->SUM_ORDER_PRICE)."</td>
              <td rowspan=\"1\" class=\"sum_purchased_price".$row->DELIVERY_DATE.$row->USER_ID."\">".number_format($row->SUM_PURCHASED_PRICE)."</td>
              <td rowspan=\"1\" style=\"color:"; if($row->SUM_BENEFIT>0){echo "blue";}else if($row->SUM_BENEFIT<0){echo "red";} echo "\" class=\"sum_benefit".$row->DELIVERY_DATE.$row->USER_ID."\">".number_format($row->SUM_BENEFIT)."</td>
              <td rowspan=\"1\">".$row->IS_PAID."</td>
              <td rowspan=\"1\" class=\"is_delivery".$row->DELIVERY_DATE.$row->USER_ID."\">".$row->IS_DELIVERY."</br>(".$row->DELIVERY_TYPE.")</td>
              <td rowspan=\"1\" class=\"tt_expenses".$row->DELIVERY_DATE."\">".number_format($row->TT_EXPENSES)."</td>
            </tr>
          ";
        }
        if($userIDCnt==0 && $deliveryDateCnt==0){
          echo "<tr><td colspan=\"15\" style=\"padding:32px\">조회결과가 없습니다.</td></tr>";
        }
      ?>
    </table>
  </div>

</div>
<script type="text/javascript">

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

<?php
  foreach($deliveryDateArr as $date){
    foreach($userIDArr as $ID){
      echo "genRowspan(\"sum_order_price".$date.$ID."\");";
      echo "genRowspan(\"sum_purchased_price".$date.$ID."\");";
      echo "genRowspan(\"sum_benefit".$date.$ID."\");";
      echo "genRowspan(\"is_delivery".$date.$ID."\");";
    }
    echo "genRowspan(\"tt_expenses".$date."\");";
    echo "genRowspan(\"deliveryDate".$date."\");";
    echo "genRowspan(\"userName".$date."\");";
  }
?>
</script>
