<div class="divCalendar">
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
          <td></td><td><input class="prev_month_btn" type="button" value="prev"></td><td><input class="dateNow" type="text" value="<?=$year.".".$month?>" readonly></td><td><input class="next_month_btn" type="button" value="next"></td><td></td>
        </tr>
      </table>
    </div>
    <div class="calendarBox">
      <table>
        <tr>
          <td>일</td><td>월</td><td>화</td><td>수</td><td>목</td><td>금</td><td>토</td>
        </tr>
        <?php
        $day = 1;
        for($week=1;$week<7;$week++){
          echo "<tr>";
          for($dayOfWeeks=0;$dayOfWeeks<7;$dayOfWeeks++){
            $pos = $dayOfWeeks+(($week-1)*7);
            if($pos>=$firstDayMonth && $day<=$lastDayMonth){
              if($day == $today){
                echo "<td class=\"pos".$pos." is_day today able\"><a>".($day)."</a></td>";
              }else{
                if($day < $today){
                  echo "<td class=\"pos".$pos." is_day able\"><a>".($day)."</a></td>";
                }else{
                  if($dayOfWeeks==1 ||$dayOfWeeks==3 || $dayOfWeeks==5){
                    echo "<td class=\"pos".$pos." is_day able\"><a>".($day)."</a></td>";
                  }else{
                    echo "<td class=\"pos".$pos." is_day able\"><a>".($day)."</a></td>";

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
