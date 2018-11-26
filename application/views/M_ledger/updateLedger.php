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
      <form action="/ledger/updateLedgerPrc" method="post">
        <table>
          <tr>
            <td>구분</td>
            <td>
              <div class="radio_btn">
                <div class="item <?php if($ledger->TYPE_CD=='01'){echo "selected";}?>" data="01">
                  <div class="circle"><div></div></div>
                  <div class="label">수입</div>
                </div>
                <div class="item <?php if($ledger->TYPE_CD=='02'){echo "selected";}?>" data="02">
                  <div class="circle"><div></div></div>
                  <div class="label">지출</div>
                </div>
                <input name="TYPE" type="hidden" value="<?=$ledger->TYPE_CD?>">
              </div>
            </td>
          </tr>
          <tr>
            <td>날짜</td>
            <td>
              <input class="date" name="DATE" type="date" value="<?=date('Y-m-d', strtotime($ledger->DATE))?>">
            </td>
          </tr>
          <tr>
            <td>분류</td>
            <td>
              <select name="CATE_1" class="selectCateType1" <?php if($ledger->TYPE_CD == '01'){echo "selected";}else{echo "hidden";}?>>
                <option value="0000">선택</option>
                <?php
                  foreach($cateType1 as $item){
                    if($ledger->TYPE_CD == '01' && $item->CATE_CODE == $ledger->CATE_CD){
                      echo "<option value=".$item->CATE_CODE." selected>".$item->CATE_NAME."</option>";
                    }else{
                      echo "<option value=".$item->CATE_CODE.">".$item->CATE_NAME."</option>";
                    }
                  }
                ?>
              </select>
              <select name="CATE_2" class="selectCateType2" <?php if($ledger->TYPE_CD == '02'){echo "selected";}else{echo "hidden";}?>>
                <option value="0000">선택</option>
                <?php
                  foreach($cateType2 as $item){
                    if($ledger->TYPE_CD == '02' && $item->CATE_CODE == $ledger->CATE_CD){
                      echo "<option value=".$item->CATE_CODE." selected>".$item->CATE_NAME."</option>";
                    }else{
                      echo "<option value=".$item->CATE_CODE.">".$item->CATE_NAME."</option>";
                    }
                  }
                ?>
              </select>
              <a class="editCate">#카테고리 편집</a>
            </td>
          </tr>

          <tr>
            <td>내용</td>
            <td>
              <input name="TEXT" class="text" type="text" value="<?=$ledger->TEXT?>" placeholder="">
            </td>
          </tr>
          <tr>
            <td>가격</td>
            <td>
              <input name="PRICE" class="price" type="text" value="<?=number_format($ledger->AMOUNT)?>">
            </td>
          </tr>
        </table>
        <input type="hidden" name="IDXKEY" value="<?=$ledger->IDXKEY?>">
        <input type="submit" value="저장하기">
      </form>
    </div>
  </div>

</div>
