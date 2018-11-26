<div class="wrap sqlMng">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">SQL Manager</td><td class="hanTitle">SQL관리</td><td></td>
      </tr>
    </table>
  </div>
  <form class="sqlFrm" action="/admin/sqlMng" method="post">
  <div class="divSearch box width100">
    <table>
      <tr>
        <td>SQL</td>
      </tr>
      <tr>
        <td>
          <textarea name="SQL" rows="10" cols="160"><?php if(!empty($SQL)){echo $SQL;} ?></textarea>
        </td>
      </tr>
    </table>
  </div>

  <div class="division"></div>
    <div class="divButton box width100">
      <table>
        <tr>
          <td class="help"><!--※ [발주서작성] 버튼은 진행상태가 [발주접수]인 모든 발주건에 대해 작성됩니다.--></td>
          <td>
            <input class="btn green searchBtn" type="submit" name="" value="조회">
          </td>
        </tr>
      </table>
    </div>
  </form>

  <div class="division"></div>

  <div class="divGrid box width100">
    <table>
      <?php
      if(!empty($gridData)){
          echo "<tr class=\"head\"><td>ROW</td>";
          foreach($gridData[0] as $key=>$value){
              echo "<td>".$key."</td>";
          }
          echo "</tr>";
      }
      if(!empty($gridData)){
          $rows=1;
          $cols=1;
          foreach($gridData as $item){
              echo "<tr class=\"body\"><td>".$rows."</td>";
            foreach($item as $key=>$value){
                echo "<td>".$value."</td>";
              $cols++;
            }
            echo "</tr>";
            $rows++;
          }
        }
        ?>
    </table>
  </div>
</div>
