<div class="wrap ledger calendar" ondragstart="return false" onselectstart="return false">
  <div class="divLedgerCalendarButton">
    <input type="hidden" class="year" value="<?=$year?>"><input type="hidden" class="month" value="<?=$month?>">
    <input class="prev" type="button" value="<<"><input class="date" type="text" value="<?=$year.".".$month?>" readonly><input class="next" type="button" value=">>">
  </div>
  <div class="divLedgerControlBox">
    <table>
      <tr>
        <td>
          <a href="/ledger/daily?year=<?=$year?>&month=<?=$month?>"><img src="/static/img/icon/ic_calendar_day.png"></a>
        </td>
        <td>
          <a href="/ledger/month?year=<?=$year?>&month=<?=$month?>"><img src="/static/img/icon/ic_calendar_month.png"></a>
        </td>
        <td>
          <a href="/ledger/calendar?year=<?=$year?>&month=<?=$month?>"><img src="/static/img/icon/ic_calendar.png"></a>
        </td>
        <td>
          <a href="/ledger/dashboard"><img src="/static/img/icon/ic_chart_white4.png"></a>
        </td>
      </tr>
    </table>
    <table class="addLedger">
      <tr>
        <td>
          <a><img src="/static/img/icon/ic_plus_white.png"></a>
        </td>
        <td>
          가계부 작성
        </td>
      </tr>
    </table>
  </div>

  <div class="divLedgerCalendar">
    <div class="divCalendarContext">
        <?php
          $yearNow = date('Y',time());
          $monthNow = date('m',time());
          $today = date('d',time());
          $firstDayMonth = date('w', strtotime($year.str_pad($month,2,0, STR_PAD_LEFT).'01'));
          $lastDayMonth = date("t", strtotime($year.str_pad($month,2,0, STR_PAD_LEFT).'01'));
        ?>
        <div class="calendar">
          <div class="calendarBox">
            <table>
              <tr>
                <td class="is_day ">일</td><td class="is_day">월</td><td class="is_day">화</td><td class="is_day">수</td><td class="is_day">목</td><td class="is_day">금</td><td class="is_day">토</td>
              </tr>
              <?php
              $day = 1;
              for($week=1;$week<7;$week++){
                echo "<tr>";
                for($dayOfWeeks=0;$dayOfWeeks<7;$dayOfWeeks++){
                  $pos = $dayOfWeeks+(($week-1)*7);

                  if($pos>=$firstDayMonth && $day<=$lastDayMonth){
                    $plusAmt = 0;
                    $plusCnt = 0;
                    $is_plus = false;
                    $is_minus = false;
                    $sum = 0;
                    foreach($dailyData as $item){
                      if($item->DATE == $year.str_pad($month,2,0, STR_PAD_LEFT).str_pad($day,2,0, STR_PAD_LEFT) && $item->TYPE_CD == "01"){
                        $is_plus = true;
                        $plusAmt = $item->AMOUNT;
                        echo "<script>console.log('".substr($item->DATE,4,2)." 수입 : ".$item->AMOUNT."')</script>";
                        $sum += $item->AMOUNT;
                      }else if($item->DATE == $year.str_pad($month,2,0, STR_PAD_LEFT).str_pad($day,2,0, STR_PAD_LEFT) && $item->TYPE_CD == "02"){
                        $is_minus = true;
                        $minusAmt = $item->AMOUNT;
                        echo "<script>console.log('".substr($item->DATE,4,2)." 지출 : ".$item->AMOUNT."')</script>";
                        $sum -= $item->AMOUNT;
                      }
                    }

                    if($day == $today && $monthNow == str_pad($month,2,0, STR_PAD_LEFT) && $yearNow == $year){
                      echo "<td class=\"pos".$pos." is_day today "; if($is_plus || $is_minus){echo "able";} echo "\" month=\"".$month."\" day=\"".$day."\" type=\"\"><a>".($day)."</a><span class=\"todayLabel\">오늘</span>";
                      if($is_plus){
                        echo "<p class=\"staticPlus\">".number_format($plusAmt)."원</p>";
                      }else{
                        echo "<p>empty</p>";
                      }
                      if($is_minus){
                        echo "<p class=\"staticMinus\">-".number_format($minusAmt)."원</p>";
                      }else{
                        echo "<p>empty</p>";
                      }
                      if($is_minus || $is_plus){
                        echo "<p class=\"staticSum\">".number_format($sum)."원</p>";
                      }else{
                        echo "<p>empty</p>";
                      }
                      echo "</td>";
                    }else{
                      echo "<td class=\"pos".$pos." is_day "; if($is_plus || $is_minus){echo "able";} echo "\"  month=\"".$month."\" day=\"".$day."\" type=\"\"><a>".($day)."</a>";
                      if($is_plus){
                        echo "<p class=\"staticPlus\">".number_format($plusAmt)."원</p>";
                      }else{
                        echo "<p>empty</p>";
                      }
                      if($is_minus){
                        echo "<p class=\"staticMinus\">-".number_format($minusAmt)."원</p>";
                      }else{
                        echo "<p>empty</p>";
                      }
                      if($is_minus || $is_plus){
                        echo "<p class=\"staticSum\">".number_format($sum)."원</p>";
                      }else{
                        echo "<p>empty</p>";
                      }

                      echo "</td>";
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
  </div>

</div>

<div class="divPopup ledgerDitail shadow_2">
  <p class="popupTitle"></p>
  <div class="divList">

  </div>
</div>
<div class="divPopup ledgerAdd shadow_2">
  <p class="popupTitle">가계부 작성</p>
  <div class="divForm">
    <table>
      <tr>
        <td>구분</td>
        <td>
          <div class="radio_btn">
            <div class="item selected" data="01">
              <div class="circle"><div></div></div>
              <div class="label">수입</div>
            </div>
            <div class="item" data="02">
              <div class="circle"><div></div></div>
              <div class="label">지출</div>
            </div>
            <input type="hidden" value="01">
          </div>
        </td>
      </tr>
      <tr>
        <td>날짜</td>
        <td>
          <input class="date" type="date" value="<?=date('Y-m-d', time())?>" placeholder="선택">
        </td>
      </tr>
      <tr>
        <td>분류</td>
        <td>
          <select class="selectCateType1 selected">
            <option value="0000">선택</option>
            <?php
              foreach($cateType1 as $item){
                echo "<option value=".$item->CATE_CODE.">".$item->CATE_NAME."</option>";
              }
            ?>
          </select>
          <select class="selectCateType2 hidden">
            <option value="0000">선택</option>
            <?php
              foreach($cateType2 as $item){
                echo "<option value=".$item->CATE_CODE.">".$item->CATE_NAME."</option>";
              }
            ?>
          </select>
          <a class="editCate">카테고리 편집</a>
        </td>
      </tr>

      <tr>
        <td>제목</td>
        <td>
          <input class="title" type="text" value="" placeholder="ex) OO도매 절화구입">
        </td>
      </tr>
      <tr>
        <td>내용</td>
        <td>
          <input class="text" type="text" value="" placeholder="ex) 장미 5단, 튤립 3단, 유카리 2단">
        </td>
      </tr>
      <tr>
        <td>가격</td>
        <td>
          <input class="price" type="text" value="">
        </td>
      </tr>
    </table>
    <input mode="" type="submit" value="작성">
  </div>
</div>
<div class="divPopupBG"></div>
