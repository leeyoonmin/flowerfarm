<div class="wrap productPriceMng">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">상품가격관리</td><td></td>
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
        </td>
        <td>
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
        <td class="td wd100">상품사진</td>
        <td class="td wd300">상품명</td>
        <td class="td wd150">가격수정일자</td>
        <td class="td wd100">공급가</td>
        <td class="td wd100">사업자가</td>
        <td class="td wd100">일반가</td>
        <td class="td wd100">진열여부</td>
        <td></td>
      </tr>
    <?php
    $rowCnt = 0;
    if(empty($gridData)){
      echo "<tr>
        <td colspan=\"8\" class=\"emptyGrid\">조회결과가 없습니다.</td>
      </tr>";
    }else{
      foreach($gridData as $row){
        echo "<tr class=\"tr body isOneCheck order\">";
          if(empty($row->IMG_EXTENSION)){
            echo "<td class=\"td wd100 productImg\"><img src=\"/static/uploads/product/noImage.png\"></td>";
          }else{
            echo "<td class=\"td wd100 productImg\"><img src=\"/static/uploads/product/".$row->PRODUCT_ID.".".$row->IMG_EXTENSION."\"></td>";
          }
          echo "
          <td class=\"td wd300\">".$row->PRODUCT_NAME."</td>
          <td class=\"td wd150 "; if(preg_replace("/[^0-9]/", "",$row->PRODUCT_TIME) < date('Ymd',strtotime("-7 day"))){echo "old";} echo" PRODUCT_TIME\">".$row->PRODUCT_TIME."</td>
          <td class=\"td wd100\"><input class=\"PRODUCT_PRICE PRODUCT_PRICE_SUPPLY\" style=\"width:80px ; text-align:center; font-weight:700;\" type=\"text\" value=\"".number_format($row->PRODUCT_PRICE_SUPPLY)."\"></td>
          <td class=\"td wd100\"><input class=\"PRODUCT_PRICE PRODUCT_PRICE_WHOLESALE\" style=\"width:80px ; text-align:center; font-weight:700;\" type=\"text\" value=\"".number_format($row->PRODUCT_PRICE_WHOLESALE)."\"></td>
          <td class=\"td wd100\"><input class=\"PRODUCT_PRICE PRODUCT_PRICE_CUNSUMER\" style=\"width:80px ; text-align:center; font-weight:700;\" type=\"text\" value=\"".number_format($row->PRODUCT_PRICE_CUNSUMER)."\"></td>
          <td class=\"td wd100\">
            <select>
              <option value=\"Y\" "; if($row->IS_DISPLAY == "Y") echo "selected"; echo">Y</option>
              <option value=\"N\" "; if($row->IS_DISPLAY == "N") echo "selected"; echo">N</option>
            </select>
          </td>
          <td><input type=\"hidden\" value=\"".$row->PRODUCT_ID."\"><input class=\"btn blue saveBtn\" type=\"button\" value=\"저장\"></td>
        </tr>";
        $rowCnt++;
      }
    }
    ?>
  </table>
  </div>

<div class="divPopupProductBG"></div>

<div class="divPopupImgViewer">
  <img class="closeBtn" src="/static/img/icon/ic_close_white.png">
  <img class="product_img" src="">
</div>
<div class="divPopupImgViewerBG"></div>