<?php
  $plusAmt = 0;
  $minusAmt = 0;
  foreach($dailyData as $item){
    if($item->TYPE_CD == '01'){
      $plusAmt += $item->AMOUNT;
    }else if($item->TYPE_CD == '02'){
      $minusAmt += $item->AMOUNT;
    }
  }
  $total = $plusAmt - $minusAmt;
?>
<div class="wrap ledger daily" ondragstart="return false" onselectstart="return false">
  <div class="divLedgerCalendarButton">
    <input type="hidden" class="year" value="<?=$year?>"><input type="hidden" class="month" value="<?=$month?>"><input type="hidden" class="day" value="<?=$day?>">
    <input class="prev" type="button" value="<<"><input class="date" type="text" value="<?=$year.".".$month.".".$day?>" readonly><input class="next" type="button" value=">>">
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

  <div class="divLedgerLayout">
    <div class="divTotal">
      <table class="pc">
        <tr>
          <td>수입</td>
          <td><?=number_format($plusAmt)." 원"?></td>
          <td>지출</td>
          <td><?=number_format($minusAmt)." 원"?></td>
          <td>합계</td>
          <td><?=number_format($total)." 원"?></td>
        </tr>
      </table>
      <table class="m">
        <tr>
          <td>수입</td>
          <td>지출</td>
          <td>합계</td>
        </tr>
        <tr>
          <td><?=number_format($plusAmt)." 원"?></td>
          <td><?=number_format($minusAmt)." 원"?></td>
          <td><?=number_format($total)." 원"?></td>
        </tr>
      </table>
    </div>
    <div class="divLedgerDailyList">
      <table>
        <?php
          foreach($dailyData as $item){
            $AMOUNT = $item->AMOUNT;
            if($item->TYPE_CD == '02'){
              $AMOUNT = $item->AMOUNT*(-1);
            }
            echo "<tr is_ledger=\"".$item->IS_LEDGER."\" idxkey=\"".$item->IDXKEY."\">
              <td class=\"hidden\">".$item->TYPE_NM."</td>
              <td class=\"pc\">".$item->CATE."</td>
              <td>".$item->TEXT."</td>";
              if($item->TYPE_CD == '02'){
                echo "<td class=\"amount minus\">".number_format($AMOUNT)." 원</td>";
              }else{
                echo "<td class=\"amount plus\">".number_format($AMOUNT)." 원</td>";
              }
              echo "
              <td><img class=\"modifyBtn\" src=\"/static/img/icon/ic_pencil_gray.png\"><img class=\"deleteBtn\" src=\"/static/img/icon/ic_trash_gray.png\"></td>
            </tr>";
          }
          if(empty($dailyData)){
            echo "<tr>
              <td>가계부 내역이 없습니다.</td>
            </tr>";
          }
        ?>
      </table>
    </div>
  </div>

</div>
