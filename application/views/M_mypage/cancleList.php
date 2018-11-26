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
          <table>
            <tr class=\"divOrderItem\">
              <td>".$item->ORDER_DATE."</td>
              <td>".$item->PRODUCT_NM."</td>
              <td class=\"price\">".number_format($item->SUM_PRICE+$item->DELIVERY_FEE)." 원</td>
              <td>
                <input class=\"orderID\" type=\"hidden\" value=\"".$item->ORDER_ID."\">
                <input class=\"orderDetailBtn\" type=\"button\" value=\"상세조회\">
              </td>
            </tr>
          </table>
        ";
      }
      if(empty($orderList)){
        echo "
          <div class=\"divEmpty\">주문취소내역이 없습니다.</div>
        ";
      }
    ?>
  </div>
</div>
