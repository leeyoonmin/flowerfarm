<div class="wrap forderRequestList writeModifiedForder">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">수정발주서 작성</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divSearch box width100">
    <table>
      <tr class="trText">
        <td>발주번호</td>
        <td>기간</td>
        <td>진행상태</td>
      </tr>
      <tr class="trInput">
        <td>
          <input class="FOID" type="text" value="<?php if(!empty($getData['FOID'])) echo $getData['FOID'];?>" placeholder="발주번호">
        </td>
        <td class="tdDatePicker">
          <input class="inputDatePicker FRDT openCalendar" type="text" value="<?php if(!empty($getData['FRDT'])){ echo $getData['FRDT'];}?>" placeholder="시작일자"><input class="btnDatePicker FRDT openCalendar" type="button" name="" value="D" readonly>
           ~
          <input class="inputDatePicker TODT openCalendar" type="text" value="<?php if(!empty($getData['TODT'])){ echo $getData['TODT'];}?>" placeholder="종료일자"><input class="btnDatePicker TODT openCalendar" type="button" name="" value="D" readonly>
        </td>
        <td>
          <select class="selectBox PROGRESS">
            <option value="0000">전체</option>
            <?php
              foreach($comboData as $item){
                echo "<option value=\"".$item->CODE."\" "; if(!empty($getData['PROGRESS'])){if($getData['PROGRESS'] == $item->CODE) echo "selected";} echo">".$item->CODE_NM."</option>";
              }
            ?>
          </select>
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
          <input class="btn blue writeModifiedForderBtn" type="button" name="" value="수정발주서작성">
        </td>
        <td>
          <input class="btn red forderReturnBtn" type="button" name="" value="발주서반송">
        </td>
        <td>
          <input class="btn green searchBtn" type="button" name="" value="조회">
        </td>
      </tr>
    </table>
  </div>

  <div class="division"></div>

  <div class="divGrid box width100">
  <div class="table">
    <div class="tr head">
      <div class="td wd50">
        <input type="checkbox" id="" class="checkbox-style"/><label for=""></label>
      </div><div class="td wd150">발주요청일</div><div class="td wd250">발주번호</div><div class="td wd100">발주구분</div><div class="td wd300">상품명</div><div class="td wd150">판매금액</div><div class="td wd150">진행상태</div>
    </div>
    <?php
    $rowCnt = 0;
    if(empty($gridData)){
      echo "
        <div class=\"emptyGrid\">조회결과가 없습니다.</div>
      ";
    }else{
      foreach($gridData as $row){
        echo "<div class=\"tr body isOneCheck forder\">
          <div class=\"td isOneCheck wd50\">
            <input type=\"checkbox\" class=\"checkBox\" id=\"checkBox".$rowCnt."\" class=\"checkbox-style\"/><label for=\"checkBox".$rowCnt."\"></label>
          </div>
          <div class=\"td wd150\">".$row->FORDER_DATE."</div><div class=\"td wd250 forderID\">".$row->ID."</div><div class=\"td wd100\">".$row->FORDER_NM."</div><div class=\"td wd300\">".$row->PRODUCT."</div><div class=\"td wd150\">".number_format($row->PAY_PRICE)." 원</div><div class=\"td wd150 prg\"><input type=\"hidden\" value=\"".$row->PROGRESS."\">".$row->PROGRESS_NM."</div>
        </div>";
        $rowCnt++;
      }
    }

    ?>
  </div>
  </div>

  <div class="division"></div>
  <?php
    if(empty($getData['PAGE'])){
      $getData['PAGE'] = 1;
    }
    $CURRENT_PAGE = $getData['PAGE'];
    $LAST_PAGE = ceil($rowCount/10);
    $PAGE_LIST = array();

  ?>
  <div class="divPagenation">
    <input class="selectPage" type="hidden" name="PAGE" value="">
    <ul class="Pagenation">
      <a href="#"><li class="firstBtn"><<</li></a>
      <a href="#"><li class="prevBtn">PREV</li></a>
      <?php
        $viewCnt = 0;
        for($i=1; $i<=$LAST_PAGE; $i++){
          if($viewCnt<5){
            if($CURRENT_PAGE == $i && $i <= $LAST_PAGE){
              echo "<a href=\"#\"><li class=\"countBtn selected\">".$i."</li></a>";
              $viewCnt++;
            }else if($CURRENT_PAGE <= 3 && $i<=$LAST_PAGE){
              echo "<a href=\"#\"><li class=\"countBtn\">".$i."</li></a>";
              $viewCnt++;
            }else if($CURRENT_PAGE > 3 && $i <= $LAST_PAGE && $CURRENT_PAGE-2 <=$i){
              echo "<a href=\"#\"><li class=\"countBtn\">".$i."</li></a>";
              $viewCnt++;
            }else if($i<=$LAST_PAGE-2 && $i>=$LAST_PAGE-4){
              echo "<a href=\"#\"><li class=\"countBtn\">".$i."</li></a>";
              $viewCnt++;
            }else{
              echo "<a href=\"#\"><li class=\"countBtn unvisible\">".$i."</li></a>";
            }
          }
        }
      ?>
      <a href="#"><li class="nextBtn">NEXT</li></a>
      <a href="#"><li class="lastBtn">>></li></a>
    </ul>
  </div>

</div>
