<div class="wrap inquiryUserInfo">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">Inquiry User Info</td><td class="hanTitle">회원정보조회</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divSearch box width100">
    <table>
      <tr class="trText">
        <td>가입일</td>
        <td>고객타입</td>
        <td>고객정보</td>
        <td>사업자여부</td>
      </tr>
      <tr class="trInput">
        <td class="tdDatePicker">
          <input class="inputDatePicker FRDT openCalendar" type="text" value="<?php if(!empty($getData['FRDT'])){ echo $getData['FRDT'];}?>" placeholder="시작일자"><input class="FRDT btnDatePicker openCalendar" type="button" name="" value="D">
           ~
          <input class="inputDatePicker TODT openCalendar" type="text" value="<?php if(!empty($getData['TODT'])){ echo $getData['TODT'];}?>" placeholder="종료일자"><input class="TODT btnDatePicker openCalendar" type="button" name="" value="D">
        </td>
        <td>
          <select class="selectBox USER_TYPE_CD">
            <option value="0000">전체</option>
            <option value="6" <?php if(!empty($getData['USER_TYPE_CD'])){if($getData['USER_TYPE_CD']=='6') echo "selected";}?>>승인대기</option>
            <option value="5" <?php if(!empty($getData['USER_TYPE_CD'])){if($getData['USER_TYPE_CD']=='5') echo "selected";}?>>일반</option>
            <option value="4"<?php if(!empty($getData['USER_TYPE_CD'])){if($getData['USER_TYPE_CD']=='4') echo "selected";}?>>소매</option>
            <option value="3" <?php if(!empty($getData['USER_TYPE_CD'])){if($getData['USER_TYPE_CD']=='3') echo "selected";}?>>도매</option>
            <option value="2"<?php if(!empty($getData['USER_TYPE_CD'])){if($getData['USER_TYPE_CD']=='2') echo "selected";}?>>농장</option>
            <option value="1"<?php if(!empty($getData['USER_TYPE_CD'])){if($getData['USER_TYPE_CD']=='1') echo "selected";}?>>관리자</option>
          </select>
        </td>
        <td>
          <select class="selectBox left USER_INFO_DV">
            <option value="0000">전체</option>
            <option value="USER_ID" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="USER_ID") echo "selected";}?>>아이디</option>
            <option value="USER_NAME" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="USER_NAME") echo "selected";}?>>이름</option>
            <option value="USER_ADDR" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="USER_ADDR") echo "selected";}?>>주소</option>
            <option value="USER_CELLPHONE" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="USER_CELLPHONE") echo "selected";}?>>전화번호</option>
            <option value="CERTI_NUM" <?php if(!empty($getData['USER_INFO_DV'])){if($getData['USER_INFO_DV']=="CERTI_NUM") echo "selected";}?>>사업자번호</option>
          </select><input class="selectInput USER_INFO_VALUE" type="text" value="<?php if(!empty($getData['USER_INFO_VALUE'])) echo $getData['USER_INFO_VALUE'];?>" placeholder="입력하세요">
        </td>
        <td>
          <select class="selectBox IS_BIZ">
            <option value="0000">전체</option>
            <option value="Y" <?php if(!empty($getData['IS_BIZ'])){if($getData['IS_BIZ']=='Y') echo "selected";}?>>Y</option>
            <option value="N"<?php if(!empty($getData['IS_BIZ'])){if($getData['IS_BIZ']=='N') echo "selected";}?>>N</option>
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
      </div><div class="td wd150">가입일</div><div class="td wd150">아이디</div><div class="td wd150">이름</div><div class="td wd150">타입</div><div class="td wd150">사업자번호</div><div class="td wd150">전화번호</div><div class="td wd100">사업자여부</div>
    </div>
    <?php
    $rowCnt = 0;
    if(empty($gridData)){
      echo "
        <div class=\"emptyGrid\">조회결과가 없습니다.</div>
      ";
    }else{
      foreach($gridData as $row){
        echo "<div class=\"tr body isCheck order\">
          <div class=\"td isCheck wd50\">
            <input type=\"checkbox\" class=\"checkBox\" id=\"checkBox".$rowCnt."\" class=\"checkbox-style\"/><label for=\"checkBox".$rowCnt."\"></label>
          </div>
          <div class=\"td wd150\">".date('Y-m-d',strtotime($row->USER_CREATED))."</div><div class=\"td wd150 orderID\">".$row->USER_ID."</div><div class=\"td wd150\">".$row->USER_NAME."</div><div class=\"td wd150\">".$row->USER_TYPE_NM."</div><div class=\"td wd150\">".$row->CERTI_NUM."</div><div class=\"td wd150\">".$row->USER_CELLPHONE."</div><div class=\"td wd100\">".$row->IS_BIZ."</div>
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
