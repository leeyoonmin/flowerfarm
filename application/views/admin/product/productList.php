<div class="wrap productList">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">Product Manager</td><td class="hanTitle">상품 관리</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divSearch box width100">
    <table>
      <tr class="trText">
        <td>상품명</td>
        <td>최저가<span class="staticLowPrice"></span></td>
        <td>최고가<span class="staticHighPrice"></span></td>
        <td>원산지구분</td>
        <td>상품구분</td>
        <td>색상</td>
        <td>모양</td>
        <td>진열구분</td>
        <td>진열여부</td>
      </tr>
      <tr class="trInput">
        <td>
          <input class="PRD_NM" type="text" value="<?php if(!empty($getData['PRD_NM'])) echo $getData['PRD_NM'];?>" placeholder="상품명">
        </td>
        <td>
          <input class="LOW_PRICE" type="range" name="lowPrice" min="0" max="30000"  value="<?php if(!empty($getData['LOW_PRICE'])){echo $getData['LOW_PRICE'];}else{echo "0";}?>"/>
        </td>
        <td>
          <input class="HIGH_PRICE" type="range" name="highPrice" min="0" max="30000" value="<?php if(!empty($getData['HIGH_PRICE'])){echo $getData['HIGH_PRICE'];}else{echo "30000";}?>"/>
        </td>
        <td>
          <select class="selectBox PRD_AREA">
            <option value="0000">전체</option>
            <?php
              foreach($combo4 as $option){
                echo "<option value=\"".$option->CODE."\" "; if(!empty($getData['PRD_AREA'])){if($getData['PRD_AREA'] == $option->CODE) echo "selected";} echo">".$option->CODE_NM."</option>";
              }
            ?>
          </select>
        </td>
        <td>
          <select class="selectBox PRD_DV">
            <option value="0000">전체</option>
            <?php
              foreach($combo1 as $option){
                echo "<option value=\"".$option->CODE."\" "; if(!empty($getData['PRD_DV'])){if($getData['PRD_DV'] == $option->CODE) echo "selected";} echo">".$option->CODE_NM."</option>";
              }
            ?>
          </select>
        </td>
        <td>
          <select class="selectBox PRD_COLOR">
            <option value="0000">전체</option>
            <?php
              foreach($combo2 as $option){
                echo "<option value=\"".$option->CODE."\" "; if(!empty($getData['PRD_COLOR'])){if($getData['PRD_COLOR'] == $option->CODE) echo "selected";} echo">".$option->CODE_NM."</option>";
              }
            ?>
          </select>
        </td>
        <td>
          <select class="selectBox PRD_SHAPE">
            <option value="0000">전체</option>
            <?php
              foreach($combo3 as $option){
                echo "<option value=\"".$option->CODE."\" "; if(!empty($getData['PRD_SHAPE'])){if($getData['PRD_SHAPE'] == $option->CODE) echo "selected";} echo">".$option->CODE_NM."</option>";
              }
            ?>
          </select>
        </td>
        <td>
          <select class="selectBox PRD_DISPLAY">
            <option value="0000">전체</option>
            <option value="IS_NEW" <?php if(!empty($getData['PRD_DISPLAY'])){if($getData['PRD_DISPLAY'] == "IS_NEW") echo "selected";}?>>신상품</option>
            <option value="IS_RECOMMAND" <?php if(!empty($getData['PRD_DISPLAY'])){if($getData['PRD_DISPLAY'] == "IS_RECOMMAND") echo "selected";}?>>추천상품</option>
          </select>
        </td>
        <td>
          <select class="selectBox IS_DISPLAY">
            <option value="0000">전체</option>
            <option value="Y" <?php if(!empty($getData['IS_DISPLAY'])){if($getData['IS_DISPLAY'] == "Y") echo "selected";}?>>Y</option>
            <option value="N" <?php if(!empty($getData['IS_DISPLAY'])){if($getData['IS_DISPLAY'] == "N") echo "selected";}?>>N</option>
          </select>
        </td>
      </tr>
    </table>
  </div>

  <div class="division"></div>

  <div class="divButton box width100">
    <table>
      <tr>
        <td>
          총 <span><?=$rowCount?></span>개　　
          <input type="checkbox" class="checkBox" id="viewCnt" class="checkbox-style"/ <?php if(!empty($getData['VIEW_CNT'])){if($getData['VIEW_CNT'] == "true") echo "checked";}?>><label for="viewCnt">　100개 보기</label>
        </td>
        <td>
        </td>
        <td>
          <input class="btn blue addBtn controlBtn" type="button" name="" value="추가">
        </td>
        <td>
          <input class="btn purple modifyBtn controlBtn" type="button" name="" value="수정">
        </td>
        <td>
          <input class="btn red deleteBtn controlBtn" type="button" name="" value="삭제">
        </td>
        <td>
          <input class="btn green searchBtn" type="button" name="" value="조회">
        </td>
      </tr>
    </table>
  </div>

  <div class="division"></div>

  <div class="divGrid box width100">
    <table>
      <tr class="tr">
        <td class="isOneCheck td wd100"></td>
        <td class="td wd100">상품코드</td>
        <td class="td wd100">상품사진</td>
        <td class="td wd300">상품명</td>
        <td class="td wd150">공급가</td>
        <td td class="td wd150">사업자가</td>
        <td td class="td wd150">일반가</td>
        <td td class="td wd150">가격수정일자</td>
      </tr>
    <?php
    $rowCnt = 0;
    if(empty($gridData)){
      echo "<tr>
        <td colspan=\"8\" class=\"emptyGrid\">조회결과가 없습니다.</td>
      </tr>";
    }else{
      foreach($gridData as $row){
        echo "<tr class=\"tr body isOneCheck order\">
          <td class=\"td isOneCheck wd100\">
            <input type=\"checkbox\" class=\"checkBox\" id=\"checkBox".$rowCnt."\" class=\"checkbox-style\"/><label for=\"checkBox".$rowCnt."\"></label>
          </td>
          <td class=\"td wd100 product_id\">".$row->PRODUCT_ID."</td>";
          if(empty($row->IMG_EXTENSION)){
            echo "<td class=\"td wd100 productImg\"><img src=\"/static/uploads/product/noImage.png\"></td>";
          }else{
            echo "<td class=\"td wd100 productImg\"><img src=\"/static/uploads/product/".$row->PRODUCT_ID.".".$row->IMG_EXTENSION."\"></td>";
          }
          echo "
          <td class=\"td wd300\">".$row->PRODUCT_NAME."</td>
          <td class=\"td wd150\">".number_format($row->PRODUCT_PRICE_SUPPLY)."원</td>
          <td class=\"td wd150\">".number_format($row->PRODUCT_PRICE_WHOLESALE)."원</td>
          <td class=\"td wd150\">".number_format($row->PRODUCT_PRICE_CUNSUMER)."원</td>
          <td class=\"td wd150\">".$row->PRODUCT_TIME."</td>
          <td></td>
        </tr>";
        $rowCnt++;
      }
    }
    ?>
  </table>
  </div>
  <div class="division"></div>
  <?php
    if(empty($getData['PAGE'])){
      $getData['PAGE'] = 1;
    }
    $CURRENT_PAGE = $getData['PAGE'];
    if($getData['VIEW_CNT']=='false'){
      $LAST_PAGE = ceil($rowCount/10);
    }else{
      $LAST_PAGE = ceil($rowCount/100);
    }

    $PAGE_LIST = array();

  ?>
  <div class="divPagenation">
    <input class="selectPage" type="hidden" name="PAGE" value="">
    <input class="lastPage" type="hidden" name="PAGE" value="<?=$LAST_PAGE?>">
    <input class="currentPage" type="hidden" name="PAGE" value="<?=$CURRENT_PAGE?>">
    <ul class="Pagenation">
      <a><li class="firstBtn"><<</li></a>
      <a><li class="prevBtn">PREV</li></a>
      <?php
        $viewCnt = 0;
        for($i=1; $i<=$LAST_PAGE; $i++){
          if($viewCnt<5){
            if($CURRENT_PAGE == $i && $i <= $LAST_PAGE){
              echo "<a><li class=\"countBtn selected\">".$i."</li></a>";
              $viewCnt++;
            }else if($CURRENT_PAGE <= 3 && $i<=$LAST_PAGE){
              echo "<a><li class=\"countBtn\">".$i."</li></a>";
              $viewCnt++;
            }else if($CURRENT_PAGE > 3 && $i <= $LAST_PAGE && $CURRENT_PAGE-2 <=$i){
              echo "<a><li class=\"countBtn\">".$i."</li></a>";
              $viewCnt++;
            }else if($i<=$LAST_PAGE-2 && $i>=$LAST_PAGE-4){
              echo "<a><li class=\"countBtn\">".$i."</li></a>";
              $viewCnt++;
            }else{
              echo "<a><li class=\"countBtn unvisible\">".$i."</li></a>";
            }
          }
        }
      ?>
      <a><li class="nextBtn">NEXT</li></a>
      <a><li class="lastBtn">>></li></a>
    </ul>
  </div>

</div>

<div class="divPopupProduct">
  <?php
    if($this->session->userdata('user_level')=="1"){
      echo "<form class=\"productFrm\" enctype=\"multipart/form-data\" action=\"/admin/uploadProduct\" method=\"post\">";
    }else{
      echo "<form class=\"productFrm\" enctype=\"multipart/form-data\" action=\"/manager/uploadProduct\" method=\"post\">";
    }
  ?>
  <table>
    <tr>
      <td colspan="2" class="imgTD" rowspan="9"><img id="PRD_IMG" src="/static/uploads/product/noImage.png"></td>
      <td class="headTD">상품명</td>
      <td class="bodyTD"><input class="PRD_NM" name="PRD_NM" type="text"></td>
    </tr>
    <tr>
      <td class="headTD">가격</td>
      <td class="bodyTD"><input class="PRD_PRICE" name="PRD_PRICE" type="text"></td>
    </tr>
    <tr>
      <td class="headTD">원산지</td>
      <td class="bodyTD">
        <select class="selectBox PRD_AREA" name="PRD_AREA">
          <option value="0000">선택</option>
          <?php
            foreach($combo4 as $option){
              echo "<option value=\"".$option->CODE."\">".$option->CODE_NM."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="headTD">구분</td>
      <td class="bodyTD">
        <select class="selectBox PRD_DV" name="PRD_DV">
          <option value="0000">선택</option>
          <?php
            foreach($combo1 as $option){
              echo "<option value=\"".$option->CODE."\">".$option->CODE_NM."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="headTD">색상</td>
      <td class="bodyTD">
        <select class="selectBox PRD_COLOR" name="PRD_COLOR">
          <option value="0000">선택</option>
          <?php
            foreach($combo2 as $option){
              echo "<option value=\"".$option->CODE."\">".$option->CODE_NM."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="headTD">형태</td>
      <td class="bodyTD">
        <select class="selectBox PRD_SHAPE" name="PRD_SHAPE">
          <option value="0000">선택</option>
          <?php
            foreach($combo3 as $option){
              echo "<option value=\"".$option->CODE."\">".$option->CODE_NM."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="headTD">재고</td>
      <td class="bodyTD"><input class="PRD_AMOUNT" type="text" name="PRD_AMT"></td>
    </tr>
    <tr>
      <td class="headTD">진열여부</td>
      <td class="bodyTD">
        <select class="selectBox IS_DISPLAY" name="IS_DISPLAY">
          <option value="Y" >Y</option>
          <option value="N">N</option>
        </select>
      </td>
    </tr>
    <tr>
      <td class="headTD">옵션</td>
      <td class="bodyTD">
        <input type="checkbox" id="is_new" name="IS_NEW"><label for="is_new">신상품</label>
        <input type="checkbox" id="is_recommand" name="IS_RECOMMAND"><label for="is_recommand">추천상품</label>
      </td>
    </tr>
    <tr>
      <td class="headTD">사진 업로드</td>
      <td class="bodyTD">
        <input type="file" accept="image/*" name="PRD_IMG" onchange="loadFile(event)">
      </td>
      <td colspan="2">
        <input class="PRD_ID" type="hidden" name="PRD_ID" value="">
        <input class="btn blue" type="button" value="저장">
      </td>
    </tr>
  </table>

  <div class="divLoader">
    <div class="lds-dual-ring"></div>
  </div>
  <?php
    $array = $this->input->get();
    $URL = "?";
    foreach($array as $key=>$value){
      $URL=$URL.$key."=".$value."&";
    }
  ?>
  <input type="hidden" name="URL" value="<?=$URL?>">
  <input type="hidden" name="PAGE" value="<?=$CURRENT_PAGE?>">
  </form>
</div>

<div class="divPopupProductBG"></div>

<div class="divPopupImgViewer">
  <img class="closeBtn" src="/static/img/icon/ic_close_white.png">
  <img class="product_img" src="">
</div>
<div class="divPopupImgViewerBG"></div>
