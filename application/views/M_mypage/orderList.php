<div class="wrap myOrderList">
  <div class="divSearch">
    <table>
      <input class="all <?php if(!empty($getData)){if($getData['period'] == "all") echo "selected";}?>" type="button" value="전체">
      <input class="6month <?php if(!empty($getData)){if($getData['period'] == "6month") echo "selected";}?>" type="button" value="6개월" >
      <input class="1month <?php if(!empty($getData)){if($getData['period'] == "1month") echo "selected";}?>" type="button" value="1개월" >
      <input class="1week <?php if(!empty($getData)){if($getData['period'] == "1week") echo "selected";}else{echo "selected";}?>" type="button" value="1주" >
    </table>
  </div>
  <div class="divOrderList">
    <?php
      foreach($orderList as $item){
        echo "
          <div class=\"divOrderItem\">
            <table>
              <tr>
                <td class=\"orderDate\">".$item->ORDER_DATE."</td>
              </tr>
              <tr>
                <td class=\"productName\">".$item->PRODUCT_NM."　[".$item->ORDER_STAT."]</td>
              </tr>
              <tr>
                <td class=\"price\">".number_format($item->SUM_PRICE+$item->DELIVERY_FEE)." 원</td>
              </tr>
            </table>
          </div>
          <div class=\"divButton\">
            <input class=\"orderID\" type=\"hidden\" value=\"".$item->ORDER_ID."\">
            <input class=\"orderCancelBtn\" type=\"button\" value=\"주문취소\"><input class=\"orderReturnBtn\" type=\"hidden\" value=\"반품신청\"><input class=\"orderDetailBtn\" type=\"button\" value=\"상세조회\">
          </div>
        ";
      }
      if(empty($orderList)){
        echo "
          <div class=\"divEmpty\">주문내역이 없습니다.</div>
        ";
      }
    ?>
  </div>
</div>