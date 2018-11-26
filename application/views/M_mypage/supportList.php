<div class="wrap supportList">
  <div class="m divTitle">
    <h1>고객센터</h1>
    <p>더욱 신선하고 품질 좋은 꽃으로 보답하겠습니다.</p>
  </div>
  <div class="divBoard">
    <div class="divTabBox">
      <table>
        <tr>
          <td class="<?php if($type=="01") echo "selected";?>"><a href="/mypage/support/01">공지사항</a></td>
          <td class="<?php if($type=="02") echo "selected";?>"><a href="/mypage/support/02">FAQ</a></td>
          <td class="<?php if($type=="03") echo "selected";?>"><a href="/mypage/support/03">1:1문의</a></td>
        </tr>
      </table>
    </div>

    <?php
    if($type=="02"){
      echo"
      <div class=\"divCategory\">
        <select class=\"cateSelect\">
          <option value=\"00\">전체</option>";
            foreach($boardCate as $item){
              echo "<option value=\"".$item->CODE."\">".$item->CODE_NM."</option>";
            }
            echo"
        </select>
      </div>";
    }
    ?>

    <div class="divBoardBox">
      <table>
        <tr>
          <td><?php if($type=="01"){echo "번호";}else{echo "구분";} ?></td><td>제목</td><td>날짜</td>
        </tr>
        <?php
          foreach($gridData as $item){
            if($type == "01"){
              $column1 = $item->ROWNUM;
            }else if($type=="03"){
              $column1 = $item->BOARD_STAT;
            }else if($type=="02"){
              $column1 = $item->CATEGORY;
            }
            if(strlen($item->TITLE)>30){
              $title = iconv_substr($item->TITLE,0,30,"utf-8")."..";
            }else{
              $title = $item->TITLE;
            }
            echo "
            <tr class=\"list\">
              <td>".$column1."</td><td>".$title."</td><td>".date('Y.m.d',strtotime($item->CREATED))."</td>
            </tr>
            <tr class=\"contents hidden\">
              <td colspan=\"3\">
                <h1 class=\"title\">".$item->TITLE."</h1>
                <p>".nl2br($item->TEXT)."<p>";
                if(!empty($item->RETEXT)){
                  echo "</br></br><div style=\"background:#666; height:1px; margin-bottom:8px;\"></div>RE :　".$item->TITLE."</br></br>".nl2br($item->RETEXT)."</br></br>";
                }
                if($type == 3){
                  echo "<div class=\"divBoardButton\">";
                  if($item->BOARD_STAT_CD == '20'){
                    echo "<input type=\"hidden\" value=\"".$item->IDXKEY."\"><img class=\"modifyBtn boardBtn\" src=\"/static/img/icon/ic_pencil_gray.png\"><img class=\"boardBtn deleteBtn\" src=\"/static/img/icon/ic_trash_gray.png\">";
                  }
                  echo "
                  </div>";
                }
                echo "
              </td>
            </tr>";


          }
          if($rowCount == 0){
            echo "
              <tr>
                <td colspan=\"3\">게시글이 없습니다.</td>
              </tr>
            ";
          }
        ?>

      </table>
      <form class="modifyFrm" action="/mypage/modifyBoard" method="post">
        <input type="hidden" name="idxkey" value="">
      </form>
    </div>
  </div>

  <?php
    if($type == 3){
      echo "<input class=\"writeBtn\" type=\"button\" value=\"1:1 문의하기\">";
    }
    if($rowCount==0){
      $rowCount = 1;
    }
    if(empty($getData['PAGE'])){
      $getData['PAGE'] = 1;
    }
    $CURRENT_PAGE = $getData['PAGE'];
    $LAST_PAGE = ceil($rowCount/5);
    $PAGE_LIST = array();

  ?>
  <div class="divPagenation">
    <input class="selectPage" type="hidden" name="PAGE" value="<?=$CURRENT_PAGE?>">
    <input class="lastPage" type="hidden" name="PAGE" value="<?=$LAST_PAGE?>">
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
