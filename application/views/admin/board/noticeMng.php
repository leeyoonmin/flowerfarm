<div class="wrap board noticeMng ">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">Notice Board Manager</td><td class="hanTitle">공지사항 게시판 관리</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divSearch box width100">
    <table>
      <tr class="trText">
        <td>글번호</td>
        <td>글제목</td>
        <td>글내용</td>
      </tr>
      <tr class="trInput">
        <td>
          <input class="ROWNUM" type="text" value="<?php if(!empty($getData['ROWNUM'])) echo $getData['ROWNUM'];?>" placeholder="글번호">
        </td>
        <td>
          <input class="TITLE" type="text" value="<?php if(!empty($getData['TITLE'])) echo $getData['TITLE'];?>" placeholder="글제목">
        </td>
        <td>
          <input class="TEXT" type="text" value="<?php if(!empty($getData['TEXT'])) echo $getData['TEXT'];?>" placeholder="글내용">
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
          <input class="btn red deleteBtn" type="button" name="" value="삭제">
        </td>
        <td>
          <input class="btn purple writeBtn" type="button" name="" value="글쓰기">
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
      </div><div class="td wd150">글번호</div><div class="td wd700">글제목</div><div class="td wd250">작성일자</div>
    </div>
    <?php
    $rowCnt = 0;
    if(empty($gridData)){
      echo "
        <div class=\"emptyGrid\">조회결과가 없습니다.</div>
      ";
    }else{
      foreach($gridData as $row){
        echo "<div class=\"tr body isOneCheck board\">
          <div class=\"td isOneCheck wd50\">
            <input class=\"TD_IDX\" type=\"hidden\" value=\"".$row->IDXKEY."\"><input type=\"checkbox\" class=\"checkBox\" id=\"checkBox".$rowCnt."\" class=\"checkbox-style\"/><label for=\"checkBox".$rowCnt."\"></label>
          </div>
          <div class=\"td wd150 TD_WORK_DV\">".$row->ROWNUM."</div><div class=\"td wd700 TD_CODE_DV\">".$row->TITLE."</div><div class=\"td wd250 TD_CODE_NM\">".date('Y. m. d',strtotime($row->CREATED))."</div>
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

  <div class="divWritePopup">
    <input class="popupMode" type="hidden" value="">
    <table>
      <tr>
        <td class="title"> <input type="text" value="" placeholder="제목"> </td>
      </tr>
      <tr>
        <td class="retext"><textarea name="name" placeholder="내용"></textarea></td>
      </tr>
    </table>
    <input class="boardID" type="hidden" value="">
    <img class="closeBtn" src="/static/img/icon/ic_close_white.png">
    <input class="btn blue submitBtn" type="button" value="작성완료">
    <div class="ui active inverted dimmer">
      <div class="ui text loader">Loading</div>
    </div>
  </div>
  <div class="divWritePopupBG"></div>

</div>
