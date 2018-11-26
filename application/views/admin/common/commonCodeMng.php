<div class="wrap commonCodeMng">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">Common Code Manager</td><td class="hanTitle">공통코드관리</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divSearch box width100">
    <table>
      <tr class="trText">
        <td>업무구분</td>
        <td>코드구분</td>
        <td>코드명</td>
        <td>코드</td>
      </tr>
      <tr class="trInput">
        <td>
          <select class="selectBox WORK_DV">
            <option value="0000">전체</option>
            <?php
              foreach($comboData1 as $item){
                echo "<option value=\"".$item->WORK_DV."\" "; if(!empty($getData['WORK_DV'])){if($getData['WORK_DV'] == $item->WORK_DV) echo "selected";} echo">".$item->WORK_DV."</option>";
              }
            ?>
          </select>
        </td>
        <td>
          <select class="selectBox CODE_DV">
            <option value="0000">전체</option>
            <?php
              if(!empty($comboData2)){
                foreach($comboData2 as $item){
                  echo "<option class=\"option\" value=\"".$item->CODE_DV."\" "; if(!empty($getData['CODE_DV'])){if($getData['CODE_DV'] == $item->CODE_DV) echo "selected";} echo">".$item->CODE_DV."</option>";
                }
              }
            ?>
          </select>
        </td>
        <td>
          <input class="CODE_NM" type="text" value="<?php if(!empty($getData['CODE_NM'])) echo $getData['CODE_NM'];?>" placeholder="코드명">
        </td>
        <td>
          <input class="CODE" type="text" value="<?php if(!empty($getData['CODE'])) echo $getData['CODE'];?>" placeholder="코드">
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
          <input class="btn purple addBtn" type="button" name="" value="코드추가">
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
      </div><div class="td wd150">업무구분</div><div class="td wd150">코드구분</div><div class="td wd250">코드명</div><div class="td wd250">코드</div><div class="td wd100">사용여부</div><div class="td wd200">생성일시</div>
    </div>
    <?php
    $rowCnt = 0;
    if(empty($gridData)){
      echo "
        <div class=\"emptyGrid\">조회결과가 없습니다.</div>
      ";
    }else{
      foreach($gridData as $row){
        echo "<div class=\"tr body isCheck codemng\">
          <div class=\"td isCheck wd50\">
            <input class=\"TD_IDX\" type=\"hidden\" value=\"".$row->IDXKEY."\"><input type=\"checkbox\" class=\"checkBox\" id=\"checkBox".$rowCnt."\" class=\"checkbox-style\"/><label for=\"checkBox".$rowCnt."\"></label>
          </div>
          <div class=\"td wd150 TD_WORK_DV\">".$row->WORK_DV."</div><div class=\"td wd150 TD_CODE_DV\">".$row->CODE_DV."</div><div class=\"td wd250 TD_CODE_NM\">".$row->CODE_NM."</div><div class=\"td wd250 TD_CODE\">".$row->CODE."</div><div class=\"td wd100 TD_IS_USE\">".$row->IS_USE."</div><div class=\"td wd200\">".date("Y-m-d H:i:s",strtotime($row->CREATED))."</div>
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
  <div class="divpopuplayer">
    <input class="inputIDX" type="hidden" name="CODE_NM" value="">
    <table class="title">
      <tr>
        <td>공통코드 수정 팝업</td><td><a href="#" class="delBtn"><img src="/static/img/icon/ic_trash.png"></a></td>
      </tr>
    </table>
    <table class="body">
      <tr>
        <td>업무구분</td>
        <td><input class="inputWORK_DV" type="text" name="CODE_NM" value=""></td>
      </tr>
      <tr>
        <td>코드구분</td>
        <td><input class="inputCODE_DV" type="text" name="CODE_NM" value=""></td>
      </tr>
      <tr>
        <td>코드명</td>
        <td><input class="inputCODE_NM" type="text" name="CODE_NM" value=""></td>
      </tr>
      <tr>
        <td>코드</td>
        <td><input class="inputCODE" type="text" name="CODE" value=""></td>
      </tr>
      <tr>
        <td>사용여부</td>
        <td>
          <select class="selectBox inputIS_USE" name="IS_USE">
            <option class="value_Y" value="Y">사용</option>
            <option class="value_N" value="N">사용불가</option>
          </select>
        </td>
      </tr>
    </table>
    <input class="saveBtn" type="button" value="저장"><input class="closeBtn" type="button" value="닫기">
  </div>
  <div class="divpopuplayerBG"></div>
</div>
