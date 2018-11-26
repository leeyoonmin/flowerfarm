<div class="wrap ledger write" ondragstart="return false" onselectstart="return false">
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
  </div>

  <div class="divLedgerLayout">
    <div class="divWriteForm">
      <form action="/ledger/addLedgerPrc" method="post">
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
                <input name="TYPE" type="hidden" value="01">
              </div>
            </td>
          </tr>
          <tr>
            <td>날짜</td>
            <td>
              <input class="date" name="DATE" type="date" value="<?=date('Y-m-d', time())?>" placeholder="선택">
            </td>
          </tr>
          <tr>
            <td>분류</td>
            <td>
              <select name="CATE_1" class="selectCateType1 selected">
                <option value="0000">선택</option>
                <?php
                  foreach($cateType1 as $item){
                    echo "<option value=".$item->CATE_CODE.">".$item->CATE_NAME."</option>";
                  }
                ?>
              </select>
              <select name="CATE_2" class="selectCateType2 hidden">
                <option value="0000">선택</option>
                <?php
                  foreach($cateType2 as $item){
                    echo "<option value=".$item->CATE_CODE.">".$item->CATE_NAME."</option>";
                  }
                ?>
              </select>
              <a class="editCate">#카테고리 편집</a>
            </td>
          </tr>

          <tr>
            <td>내용</td>
            <td>
              <input name="TEXT" class="text" type="text" value="" placeholder="">
            </td>
          </tr>
          <tr>
            <td>가격</td>
            <td>
              <input name="PRICE" class="price" type="tel" value="">
            </td>
          </tr>
        </table>
        <input type="submit" value="저장하기">
      </form>
    </div>
  </div>

</div>
