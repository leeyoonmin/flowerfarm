<div class="wrap ledger editCate" ondragstart="return false" onselectstart="return false">
  <div class="divLedgerControlBox">
    <table>
      <tr>
        <td>
          <a href="/ledger/daily?year=&month="><img src="/static/img/icon/ic_calendar_day.png"></a>
        </td>
        <td>
          <a href="/ledger/month?year=&month="><img src="/static/img/icon/ic_calendar_month.png"></a>
        </td>
        <td>
          <a href="/ledger/calendar?year=&month="><img src="/static/img/icon/ic_calendar.png"></a>
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
    <div class="divTypeList divType1List">
      <h1>수입</h1>
      <table>
        <?php
          foreach($cateType1 as $item){
            echo "<tr type=\"01\" cate=\"".$item->CATE_CODE."\">
              <td><input type=\"text\" value=\"".$item->CATE_NAME."\" readonly></td><td><img class=\"modifyBtn\" src=\"/static/img/icon/ic_pencil_gray.png\"><img class=\"deleteBtn\" src=\"/static/img/icon/ic_trash_gray.png\"></td>
            </tr>";
          }
        ?>
      </table>
      <img type="01" class="addBtn" src="/static/img/icon/ic_plus_white.png">
    </div>
    <div class="divTypeList divType2List">
      <h1>지출</h1>
      <table>
        <?php
          foreach($cateType2 as $item){
            echo "<tr type=\"02\" cate=\"".$item->CATE_CODE."\">
              <td><input type=\"text\" value=\"".$item->CATE_NAME."\" readonly></td><td><img class=\"modifyBtn\" src=\"/static/img/icon/ic_pencil_gray.png\"><img class=\"deleteBtn\" src=\"/static/img/icon/ic_trash_gray.png\"></td>
            </tr>";
          }
        ?>
      </table>
      <img type="02" class="addBtn" src="/static/img/icon/ic_plus_white.png">
    </div>
    <input type="submit" value="저장하기">
  </div>

</div>
