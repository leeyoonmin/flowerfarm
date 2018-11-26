<div class="wrap ledger month" ondragstart="return false" onselectstart="return false">
  <div class="divLedgerCalendarButton">
    <input type="hidden" class="year" value="<?=$year?>"><input type="hidden" class="month" value="<?=$month?>">
    <input class="prev" type="button" value="<<"><input class="date" type="text" value="<?=$year?>" readonly><input class="next" type="button" value=">>">
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
      <div class="divLedger">
        <?php

        for($cnt=1; $cnt < 13; $cnt++){
          $plusAmt = 0;
          $minusAmt = 0;
          $plusCnt = 0;
          $sum = 0;
                echo "
                <div class=\"divMonth\">
                  <div class=\"divTitle\">
                    <h1 class=\"title\">".$cnt."월</h1>
                  </div>";
                  $is_plus = false;
                  $is_minus = false;
                  foreach($monthData as $item){
                    if($cnt == substr($item->DATE,4,2) && $item->TYPE_CD == "01"){
                      $is_plus = true;
                      $plusAmt += $item->AMOUNT;
                      $sum += $item->AMOUNT;
                    }
                    if($cnt == substr($item->DATE,4,2) && $item->TYPE_CD == "02"){
                      $is_minus = true;
                      $minusAmt += $item->AMOUNT;
                      $sum -= $item->AMOUNT;
                    }
                  }
                  if(!$is_plus){
                    echo "
                    <div class=\"box plus\" type=\"01\" month=\"".$cnt."\" day=\"0\">
                      <p class=\"static\">수입</p><p class=\"number\"><span>0</span>원</p>
                    </div>";
                  }else{
                    echo "
                    <div class=\"box plus able\" type=\"01\" month=\"".$cnt."\" day=\"0\">
                      <p class=\"static\">수입</p><p class=\"number\"><span>".number_format($plusAmt)."</span>원</p>
                    </div>";
                  }
                  if(!$is_minus){
                    echo "
                    <div class=\"box minus\" type=\"02\" month=\"".$cnt."\" day=\"0\">
                      <p class=\"static\">지출</p><p class=\"number\"><span>0</span>원</p>
                    </div>";
                  }else{
                    echo "
                    <div class=\"box minus able\" type=\"02\" month=\"".$cnt."\" day=\"0\">
                      <p class=\"static\">지출</p><p class=\"number\"><span>-".number_format($minusAmt)."</span>원</p>
                    </div>";
                  }
                echo
                 "<div class=\"box sum "; if($sum != 0){echo "able";} echo"\" type=\"\" month=\"".$cnt."\" day=\"0\">
                    <p class=\"static\">합계</p><p class=\"number\"><span>".number_format($sum)."</span>원</p>
                  </div>
                </div>
                ";
                $is_plus = false;
                $is_minus = false;
          }
        ?>
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
        <td>날짜</td>
        <td>
          <input class="date" type="date" value="<?=date('Y-m-d', time())?>" placeholder="선택">
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

<div class="divPopup CateMng">
  <div class="">
    <table>
      <tr>
        <td></td>
      </tr>
    </table>
  </div>
  <div class="">
    <table>
      <tr>

      </tr>
    </table>
  </div>
</div>
