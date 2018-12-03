<div class="wrap productCateMng">

  <div class="divPageTitle">
    <table>
      <tr>
        <td class="engTitle">상품카테고리 관리</td><td></td>
      </tr>
    </table>
  </div>

  <div class="divButton box width100">
    <table>
      <tr>
        <td>
          총 <span><?=$rowCount?></span>개　　
        </td>
        <td>
        </td>
        <td>
          <input class="btn orange upBtn controlBtn" type="button" name="" value="▲">
        </td>
        <td>
          <input class="btn orange downBtn controlBtn" type="button" name="" value="▼">
        </td>
        <td>
          <input class="btn blue addBtn controlBtn" type="button" name="" value="추가">
        </td>
        <td>
          <input class="btn red deleteBtn controlBtn" type="button" name="" value="삭제">
        </td>
      </tr>
    </table>
  </div>

  <div class="division"></div>

  <div class="divGrid box width100">
    <table>
      <tr class="tr">
        <td class="isOneCheck td wd100"></td>
        <td class="td wd150">카테고리명</td>
        <td class="td wd150">순서</td>
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
            <input type=\"hidden\" value=\"".$row->IDXKEY."\">
            <input type=\"checkbox\" class=\"checkBox\" id=\"checkBox".$rowCnt."\" class=\"checkbox-style\"/><label for=\"checkBox".$rowCnt."\"></label>
          </td>
          <td class=\"td wd150\">".$row->CODE_NM."</td>
          <td class=\"td wd150\">".$row->CODE."</td>
          <td></td>
        </tr>";
        $rowCnt++;
      }
    }
    ?>
  </table>
  </div>
  <div class="division"></div>
</div>

<div class="divAddProductCate">
  <input class="PRODUCT_CATE" type="text" value="" placeholder="카테고리 명">
  <input class="popAddBtn" type="button" value="추가">
</div>
<div class="divAddProductCateBG"></div>
