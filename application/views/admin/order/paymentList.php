<div class="wrap paymentList">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">Payment List</td><td class="hanTitle">입금전 관리</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divSearch box width100">
    <table>
      <tr class="trText">
        <td>주문번호</td>
        <td>기간</td>
        <td>고객정보</td>
        <td>입금여부</td>
        <td>발주여부</td>
      </tr>
      <tr class="trInput">
        <td>
          <input class="ODID" type="text" value="<?php if(!empty($getData['ODID'])) echo $getData['ODID'];?>" placeholder="주문번호">
        </td>
        <td class="tdDatePicker">
          <input class="inputDatePicker FRDT openCalendar" type="text" value="<?php if(!empty($getData['FRDT'])){ echo $getData['FRDT'];}?>" placeholder="시작일자"><input class="FRDT btnDatePicker openCalendar" type="button" name="" value="D">
           ~
          <input class="inputDatePicker TODT openCalendar" type="text" value="<?php if(!empty($getData['TODT'])){ echo $getData['TODT'];}?>" placeholder="종료일자"><input class="TODT btnDatePicker openCalendar" type="button" name="" value="D">
        </td>
        <td>
          <select class="selectBox left USER_INFO_DV">
            <option value="0000">선택</option>
            <option value="USER_ID" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="USER_ID") echo "selected";}?>>아이디</option>
            <option value="SHOP_NM" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="SHOP_NM") echo "selected";}?>>상호명</option>
            <option value="CUST_NM" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="CUST_NM") echo "selected";}?>>대표자명</option>
            <option value="ADDR" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="ADDR") echo "selected";}?>>주소</option>
            <option value="TEL" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="TEL") echo "selected";}?>>전화번호</option>
          </select><input class="selectInput USER_INFO_VALUE" type="text" value="<?php if(!empty($getData['USER_INFO_VALUE'])) echo $getData['USER_INFO_VALUE'];?>" placeholder="입력하세요">
        </td>
        <td>
          <select class="selectBox IS_PAID">
            <option value="0000">선택<?php $EXIST_IS_PAID = false; foreach($getData as $key=>$value){if($key=='IS_PAID') $EXIST_IS_PAID = true;}?></option>
            <option value="N" <?php if($EXIST_IS_PAID){if($getData['IS_PAID']=='N') echo "selected";}?>>입금전</option>
            <option value="Y"<?php if($EXIST_IS_PAID){if($getData['IS_PAID']=='Y') echo "selected";}?>>입금완료</option>
          </select>
        </td>
        <td>
          <select class="selectBox IS_FORDER">
            <option value="0000">선택</option>
            <option value="N" <?php if(!empty($getData['IS_FORDER'])){if($getData['IS_FORDER']=='N') echo "selected";}?>>발주미신청</option>
            <option value="Y"<?php if(!empty($getData['IS_FORDER'])){if($getData['IS_FORDER']=='Y') echo "selected";}?>>발주신청</option>
          </select>
        </td>
      </tr>
    </table>
  </div>

  <div class="division"></div>

  <div class="divButton box width100">
    <table>
      <tr>
        <td></td>
        <td>
          <input class="btn blue paymentConfBtn" type="button" name="" value="입금확인">
        </td>
        <td>
          <input class="btn orange paymentConfCancleBtn" type="button" name="" value="입금확인취소">
        </td>
        <td>
          <input class="btn red orerCancelBtn" type="button" name="" value="주문취소">
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
        <input type="checkbox" id="all_checked" class="checkbox-style"/><label for="all_checked"></label>
      </div><div class="td wd150">주문일</div><div class="td wd150">주문번호</div><div class="td wd300">상품명</div>  <div class="td wd150">주문자</div><div class="td wd150">입금금액</div><div class="td wd100">입금여부</div><div class="td wd100">발주여부</div>
    </div>
    <?php
    $rowCnt = 0;
    if(empty($gridData)){
      echo "
        <div class=\"emptyGrid\">조회결과가 없습니다.</div>
      ";
    }else{
      foreach($gridData as $row){
        if($row->IS_PAID == 'Y') $row->IS_PAID = "입금완료";
        else $row->IS_PAID = "입금전";
        if($row->IS_FORDER == 'Y') $row->IS_FORDER = "발주신청";
        else $row->IS_FORDER = "발주미신청";
        echo "<div class=\"tr body isCheck order\">
          <div class=\"td isCheck wd50\">
            <input type=\"checkbox\" class=\"checkBox\" id=\"checkBox".$rowCnt."\" class=\"checkbox-style\"/><label for=\"checkBox".$rowCnt."\"></label>
          </div>
          <div class=\"td wd150\">".date('Y-m-d H:i',strtotime($row->ORDER_TIME))."</div><div class=\"td wd150 orderID\">".$row->ORDER_ID."</div><div class=\"td wd300\">".$row->PRODUCT."</div><div class=\"td wd150\">".$row->USER_ID."</div><div class=\"td wd150\">".number_format($row->PAY_PRICE)." 원</div><div class=\"td wd100\">".$row->IS_PAID."</div><div class=\"td wd100\">".$row->IS_FORDER."</div>
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
