<div class="wrap">
  <div class="divTitle">
    <p class="title">장바구니</p>
  </div>
  <div class="divItemList">


        <?php
        $itemCnt = 0;
        if($this->cart->total_items()>0){
          foreach($this->cart->contents() as $item){
            echo "
            <div class=\"divItem\">
              <table>
                <tr>
                  <td class=\"imgTD\">
                    <img src=\"/static/uploads/product/";
                    if($item['extension']==""){
                      echo "noImage.png";
                    }else{
                      echo $item['id'].".".$item['extension'];
                    }
                    echo "\">
                  </td>
                  <td class=\"infoTD\">
                    <p class=\"kind\">".$item['kind']."</p>
                    <p class=\"name\">".$item['name']."</p>
                    <p class=\"price\"><span>".number_format($item['price'])."</span>원</p>
                  </td>
                  <td class=\"countTD\">
                    <input type=\"hidden\" value=\"".$item['id']."\">
                    <a class=\"minusBtn\">－</a><span>".number_format($item['qty'])."</span><a class=\"plusBtn\">＋</a>
                  </td>
                  <td class=\"pc totalTD\">
                    <p class=\"totalPrice\"><span>".number_format($item['price']*$item['qty'])."</span>원</p>
                  </td>
                  <td class=\"deleteTD\">
                    <a>Ｘ</a>
                  </td>
                </tr>
              </table>
            </div>
            ";
            $itemCnt++;
          }
        }
        else{
          echo "<div class=\"divEmptyItem\">
            <img src=\"/static/img/icon/ic_search_gray.png\">
            <p>장바구니에 담긴 상품이 없습니다.</p>
          </div>";
        }
        ?>
        <div class="static">
          <p>홈페이지에 없거나 실속형, 저가형 상품에 대한 추가 요청주문이 있으면,</p>
          <p>010-2724-7297으로 SMS문자주문 해주시면 최대한 구해다 드리겠습니다.</p>
        </div>
  </div>


  <div class="divTitle">
    <p class="title">주문희망일자</p>
  </div>
  <div class="divSelectDeliveryDate">
    <div class="pc static">
      <p>- 수입꽃은 화요일에 세관을 통해 들어와 수요일에 받아 보실 수 있습니다.</p>
      <p>&nbsp;&nbsp;화요일에 주문하시면 가장 퀄리티 좋은 꽃을 받아 보실 수 있습니다.</p>
    </div>
    <div class="m static">
      <p>- 수입꽃은 화요일에 세관을 통해 들어와서 수요일에 받아 보실 수<br>&nbsp;&nbsp;있습니다. 화요일에 주문하시면 가장 퀄리티 좋은 꽃을<br>&nbsp;&nbsp;받아 보실 수 있습니다.</p>
    </div>
    <div class="divCalendarContext">
        <?php
          $year = date('Y',time());
          $month = date('m',time());
          $today = date('d',time());
          $firstDayMonth = date('w', strtotime($year.$month.'01'));
          $lastDayMonth = date("t", time());
        ?>
        <div class="calendar">
          <div class="buttonBox">
            <table>
              <tr>
                <td></td><td><a class="prev_month_btn">＜</a></td><td><input class="dateNow" type="text" value="<?=$year.".".$month?>" readonly></td><td><a class="next_month_btn">＞</a></td><td></td>
              </tr>
            </table>
          </div>
          <div class="calendarBox">
            <table>
              <tr>
                <td class="is_day">일</td><td class="is_day">월</td><td class="is_day">화</td><td class="is_day">수</td><td class="is_day">목</td><td class="is_day">금</td><td class="is_day">토</td>
              </tr>
              <?php
              $day = 1;
              for($week=1;$week<7;$week++){
                echo "<tr>";
                for($dayOfWeeks=0;$dayOfWeeks<7;$dayOfWeeks++){
                  $pos = $dayOfWeeks+(($week-1)*7);

                  if($pos>=$firstDayMonth && $day<=$lastDayMonth){
                    if($day == $today){
                      echo "<td class=\"pos".$pos." is_day today unable\"><a>".($day)."</a></td>";
                    }else{
                      if($day < $today){
                        echo "<td class=\"pos".$pos." is_day unable\"><a>".($day)."</a></td>";
                      }else{
                        if($dayOfWeeks==1 ||$dayOfWeeks==2 ||$dayOfWeeks==3 ||$dayOfWeeks==4 || $dayOfWeeks==5){
                          echo "<script>console.log('".$pos.", ".$day.", ".$firstDayMonth.", ".$lastDayMonth.",".$dayOfWeeks."');</script>";
                          echo "<td class=\"pos".$pos." is_day able\"><a>".($day)."</a></td>";
                        }else{
                          echo "<td class=\"pos".$pos." is_day unable\"><a>".($day)."</a></td>";
                        }
                      }
                    }
                    $day++;
                  }else{
                    echo "<td class=\"pos".$pos."\"></td>";
                  }
                }
                echo "</tr>";
              }
              ?>
            </table>
          </div>
        </div>
      </div>
      <input class="inputDeliveryDate" type="hidden" value="">
  </div>

  <div class="divTitle">
    <p class="title">배송방법</p>
  </div>
  <div class="divSelectDeliveryMethod">
    <table>
      <tr>
        <?php
          foreach($delivery_info as $item){
            if($item->DELIVERY_CODE == '01'){
              echo "
              <td class=\"normal selected\">
                <p>".$item->DELIVERY_TYPE."</p>
                <p>".number_format($item->DELIVERY_FEE)." 원</p>
              </td>
              ";
            }else if($item->DELIVERY_CODE == '02'){
              echo "
              <td class=\"quick\">
                <p>".$item->DELIVERY_TYPE."</p>
                <p>".number_format($item->DELIVERY_FEE)." 원</p>
              </td>
              ";
            }
          }
        ?>
      </tr>
    </table>
  </div>
  <div class="pc static">
    <p>- 직접배송 : 오후 1시부터 순차적으로 배송됩니다.</p>
    <p>- 퀵서비스 : 추가요금이 발생하며, 조금 더 빨리(오후 1시에 퀵서비스 출발) 받아보실 수 있습니다.</p>
  </div>
  <div class="m static">
    <p>- 직접배송 : 오후 1시부터 순차적으로 배송됩니다.</p>
    <p>- 퀵서비스 : 추가요금이 발생하며, 조금 더 빨리(오후 1시에<br>&nbsp;&nbsp;퀵서비스 출발) 받아보실 수 있습니다.</p>
  </div>
  <div class="divCartTotal">
    <table>
      <tr>
        <td>총 <span class="itemCnt"><?=$itemCnt?></span> 개 상품<span class="totalPrice"><?=number_format($this->cart->total())?></span> 원</td><td class="orderBtn">주문서작성</td>
      </tr>
    </table>
    <input class="inputDeliveryMethod" type="hidden" value="01">
    <input class="TOTAL_PRICE_HD" type="hidden" value="<?=$this->cart->total()?>">
  </div>
</div>
