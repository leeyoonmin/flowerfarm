
<div class="m divSearch flower close">
  <table>
    <tr class="pc title">
      <td colspan="3" style="background:#FE8200; color:#fff; padding:8px;">편하게 검색하세요</td>
    </tr>
    <tr>
      <td>
        원산지
      </td>
      <td colspan="2">
        <select class="selectArea">
          <option value="0000">전체</option>
          <?php
            foreach($cateArea as $option){
              echo "<option value=\"".$option->CODE."\"";
              if(!empty($getData['area'])){if($getData['area']==$option->CODE){echo "selected";}}
              echo " >".$option->CODE_NM."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        품목별
      </td>
      <td colspan="2">
        <select class="selectKind">
          <option value="0000">전체</option>
          <?php
            foreach($cateKind as $option){
              echo "<option value=\"".$option->CODE."\"";
              if(!empty($getData['kind'])){if($getData['kind']==$option->CODE){echo "selected";}}
              echo " >".$option->CODE_NM."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        형태별
      </td>
      <td colspan="2">
        <select class="selectShape">
          <option value="0000">전체</option>
          <?php
            foreach($cateShape as $option){
              echo "<option value=\"".$option->CODE."\"";
              if(!empty($getData['shape'])){if($getData['shape']==$option->CODE){echo "selected";}}
              echo " >".$option->CODE_NM."</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        색상별
      </td>
      <td colspan="2">
          <input class="selectColor" type="hidden" value="<?php if(!empty($getData['color'])){echo $getData['color'];} ?>">
          <div class="colorSelector all" color="0000"></div><?php
            foreach($cateColor as $option){
              echo "<div class=\"colorSelector ";
              if(!empty($getData['color'])){if($getData['color']==$option->CODE){echo "selected";}}
              echo "\" color=\"".$option->CODE."\" style=\"background:#".$option->CODE."\"></div>";
            }
          ?>
      </td>
    </tr>
    <tr>
      <td>
        검색
      </td>
      <td>
        <input class="inputKeyword" type="text" value="<?php if(!empty($getData['keyword'])){ echo $getData['keyword'];}?>">
      </td>
      <td>
        <img class="searchBtn" src="/static/img/icon/ic_search_gray.png">
      </td>
    </tr>
  </table>
  <div class="divControlbox">
    <img src="/static/img/icon/ic_arrow_down.png">
  </div>
</div>
<div class="m divSearchBG"></div>



<div class="wrap productList">
  <!--div class="ui m pc active dimmer divLoader productList">
    <div class="ui text big loader">페이지 로딩 중 입니다..</div>
  </div-->
  <?php
  $productCnt = 0;
    foreach($gridData as $item){
      $productCnt++;
    }
  ?>
  <div class="m divHashTagContainer">
    <div class="divHashTag">
      <?php

        foreach($cateKind as $option){
          if($option->CODE == '01' || $option->CODE == '11' || $option->CODE == '12' || $option->CODE == '15'){
            echo "<input CODE=\"".$option->CODE."\" class=\"hashTag\" type=\"button\" value=\"#".$option->CODE_NM."\">";
          }
        }
      ?>
    </div>
  </div>

  <div class="divNewStickerContainer">
    <div class="divNewStickerBox">
    <div class="divNewSticker newsticker">
      <ul>
      	<li><span>[수입산] </span> 수입꽃은 화요일에 입고됩니다.</li>
        <li><span>[실속형] </span> 선택하신 색상에 맞춰 시장상황에 따라</li>
        <li><span>[실속형] </span> 가장 합리적인 상품으로 배송됩니다.</li>
      </ul>
    </div>
    </div>
  </div>
  <div class="pc divSearch flower">
    <table>
      <tr>
        <td class="title">
          원산지
        </td>
        <td class="body">
          <select class="selectArea">
            <option value="0000">전체</option>
            <?php
              foreach($cateArea as $option){
                echo "<option value=\"".$option->CODE."\"";
                if(!empty($getData['area'])){if($getData['area']==$option->CODE){echo "selected";}}
                echo " >".$option->CODE_NM."</option>";
              }
            ?>
          </select>
        </td>
        <td class="title">
          품목별
        </td>
        <td class="body">
          <select class="selectKind">
            <option value="0000">전체</option>
            <?php
              foreach($cateKind as $option){
                echo "<option value=\"".$option->CODE."\"";
                if(!empty($getData['kind'])){if($getData['kind']==$option->CODE){echo "selected";}}
                echo " >".$option->CODE_NM."</option>";
              }
            ?>
          </select>
        </td>
        <td class="title">
          형태별
        </td>
        <td class="body">
          <select class="selectShape">
            <option value="0000">전체</option>
            <?php
              foreach($cateShape as $option){
                echo "<option value=\"".$option->CODE."\"";
                if(!empty($getData['shape'])){if($getData['shape']==$option->CODE){echo "selected";}}
                echo " >".$option->CODE_NM."</option>";
              }
            ?>
          </select>
        </td>
        <td class="title">
          색상별
        </td>
        <td class="body">
            <input class="selectColor" type="hidden" value="<?php if(!empty($getData['color'])){echo $getData['color'];}else{echo "0000";} ?>">
            <div class="colorSelector all <?php if(empty($getData['color'])){echo "selected";}?>" color="0000"></div><?php
              foreach($cateColor as $option){
                echo "<div class=\"colorSelector ";
                if(!empty($getData['color'])){if($getData['color']==$option->CODE){echo "selected";}}
                echo "\" color=\"".$option->CODE."\" style=\"background:#".$option->CODE."\"></div>";
              }
            ?>
        </td>
        </tr>
        <tr>
        <td class="title">
          검색
        </td>
        <td class="body" colspan="6">
          <input class="inputKeyword" type="text" value="<?php if(!empty($getData['keyword'])){ echo $getData['keyword'];}?>" placeholder="검색어를 입력해주세요..">
        </td>
        <td class="body" colspan="1">
          <img class="searchBtn" src="/static/img/icon/ic_search_gray.png">
        </td>
      </tr>
    </table>
  </div>
  <div class="divOrder">
    <table>
      <tr>
        <td class="totalCnt">총 <?=number_format($gridDataCount)?>개 상품</td>
        <td>
          <div class="toggleBox <?php if(!empty($getData['is_img'])){if($getData['is_img']=="true"){echo "checked";}}?>">
            <div class="toggleBG">
              <div class="toggleCircle"></div>
            </div>
            <span>사진有</span>
            <input class="toggleValue" type="hidden" value="<?php
            if(!empty($getData['is_img'])){
               echo $getData['is_img'];
            }else{
              echo "false";
            }
            ?>">
          </div>
        </td>
        <td>
          <select class="orderSelect" name="">
            <option value="alphabet" <?php if(!empty($getData['orderBy'])){if($getData['orderBy']=="alphabet"){echo "selected";}}?>>가나다순</option>
            <option value="highPrice" <?php if(!empty($getData['orderBy'])){if($getData['orderBy']=="highPrice"){echo "selected";}}?>>가격높은순</option>
            <option value="lowPrice" <?php if(!empty($getData['orderBy'])){if($getData['orderBy']=="lowPrice"){echo "selected";}}?>>가격낮은순</option>
            <option value="popular" <?php if(!empty($getData['orderBy'])){if($getData['orderBy']=="popular"){echo "selected";}}?>>인기순</option>
          </select>
        </td>
      </tr>
    </table>
  </div>

  <div class="m divProductList">
    <?php
      $count = 1;
      foreach($gridData as $item){
          echo "
            <div class=\"divItem shadow_1 item".$count."\" kind=\"".$item->PRODUCT_CATE_KIND."\" shape=\"".$item->PRODUCT_CATE_SHAPE."\" color=\"".$item->PRODUCT_CATE_COLOR."\" name=\"".$item->PRODUCT_NAME."\" extension=\"".$item->IMG_EXTENSION."\">
              <table>
                <tr>
                  <td class=\"imgTD\">";

                    if(empty($item->IMG_EXTENSION)){
                      echo "<img class=\"img_false\" src=\"/static/uploads/product/noImage.png\">";
                    }else{
                      echo "<img class=\"img_true\" src=\"/static/uploads/product/".$item->PRODUCT_ID.".".$item->IMG_EXTENSION."\">";
                    }

                      echo"
                  </td>
                  <td class=\"infoTD\">
                    <table>
                      <tr>
                        <td class=\"cate\"><span>".$item->PRODUCT_CATE_KIND_NM."</span></td>
                      </tr>
                      <tr>
                        <td class=\"name\"><span>".$item->PRODUCT_NAME."</span></td>
                      </tr>
                      <tr>
                      ";
                      if($this->session->userdata('is_login')){
                        if($this->session->userdata('user_level')==5 || $this->session->userdata('user_level')==6){
                          echo"<td class=\"price\"><span>".number_format($item->PRODUCT_PRICE_CUNSUMER)."</span>원</td>";
                        }else{
                          echo"<td class=\"price\"><span>".number_format($item->PRODUCT_PRICE_WHOLESALE)."</span>원</td>";
                        }
                      }else{
                        echo"<td class=\"price\">로그인 후 확인</td>";
                      }
                      echo"</tr>
                    </table>
                  </td>
                  ";
                  if($this->session->userdata('is_login')){
                    echo"<td class=\"cartTD\">
                      <input class=\"HD_EXTENSION\" type=\"hidden\" value=\"".$item->IMG_EXTENSION."\">
                      <input class=\"HD_KIND\" type=\"hidden\" value=\"".$item->PRODUCT_CATE_KIND_NM."\">
                      <input class=\"HD_ID\" type=\"hidden\" value=\"".$item->PRODUCT_ID."\">
                      <input class=\"HD_NM\" type=\"hidden\" value=\"".$item->PRODUCT_NAME."\">";
                    if($this->session->userdata('is_login')){
                      if($this->session->userdata('user_level')==5 || $this->session->userdata('user_level')==6){
                        echo "<input class=\"HD_PRICE\" type=\"hidden\" value=\"".$item->PRODUCT_PRICE_CUNSUMER."\">";
                      }else{
                        echo "<input class=\"HD_PRICE\" type=\"hidden\" value=\"".$item->PRODUCT_PRICE_WHOLESALE."\">";
                      }
                    }
                    echo "<img src=\"/static/img/icon/ic_cart.png\">
                    </td>";
                  }else{
                    echo"<td></td>";
                  }
                  echo"
                </tr>
              </table>
            </div>
          ";
        $count++;
      }

    ?>
  </div>
  <div class="pc divProductList">
    <?php
      $count = 1;
      foreach($gridData as $item){
          echo "
            <div class=\"divItem shadow_1 item".$count."\" kind=\"".$item->PRODUCT_CATE_KIND."\" shape=\"".$item->PRODUCT_CATE_SHAPE."\" color=\"".$item->PRODUCT_CATE_COLOR."\" name=\"".$item->PRODUCT_NAME."\" extension=\"".$item->IMG_EXTENSION."\">
              <table>
                <tr>
                  <td class=\"imgTD\">
                    ";
                    if($item->PRODUCT_CATE_AREA == '02'){
                      echo "<div class=\"importLabel\">수입</div>";
                    }
                    if(empty($item->IMG_EXTENSION)){
                      echo "<img class=\"img_false\" src=\"/static/uploads/product/noImage.png\">";
                    }else{
                      echo "<img class=\"img_true\" src=\"/static/uploads/product/".$item->PRODUCT_ID.".".$item->IMG_EXTENSION."\">";
                    }

                      echo"
                  </td>
                  </tr>
                  <tr>
                  <td class=\"infoTD\">
                    <table>
                      <tr>
                        <td class=\"cate\">";
                        if($item->PRODUCT_CATE_AREA == '02'){
                          echo "<span class=\"importLabel\">수입</span>";
                        }
                        echo "<span>".$item->PRODUCT_CATE_KIND_NM."</span></td>
                      </tr>
                      <tr>
                        <td class=\"name\"><span>".$item->PRODUCT_NAME."</span></td>
                      </tr>
                      <tr>
                      ";
                      if($this->session->userdata('is_login')){
                        if($this->session->userdata('user_level')==5 || $this->session->userdata('user_level')==6){
                          echo"<td class=\"price\"><span>".number_format($item->PRODUCT_PRICE_CUNSUMER)."</span>원</td>";
                        }else{
                          echo"<td class=\"price\"><span>".number_format($item->PRODUCT_PRICE_WHOLESALE)."</span>원</td>";
                        }
                      }else{
                        echo"<td class=\"price\">로그인 후 확인</td>";
                      }
                      echo"</tr>
                    </table>
                  </td>
                  </tr><tr>
                  ";
                  if($this->session->userdata('is_login')){
                    echo"<td class=\"cartTD\">
                      <input class=\"HD_EXTENSION\" type=\"hidden\" value=\"".$item->IMG_EXTENSION."\">
                      <input class=\"HD_KIND\" type=\"hidden\" value=\"".$item->PRODUCT_CATE_KIND_NM."\">
                      <input class=\"HD_ID\" type=\"hidden\" value=\"".$item->PRODUCT_ID."\">
                      <input class=\"HD_NM\" type=\"hidden\" value=\"".$item->PRODUCT_NAME."\">";
                    if($this->session->userdata('is_login')){
                      if($this->session->userdata('user_level')==5 || $this->session->userdata('user_level')==6){
                        echo "<input class=\"HD_PRICE\" type=\"hidden\" value=\"".$item->PRODUCT_PRICE_CUNSUMER."\">";
                      }else{
                        echo "<input class=\"HD_PRICE\" type=\"hidden\" value=\"".$item->PRODUCT_PRICE_WHOLESALE."\">";
                      }
                    }
                    echo "<img src=\"/static/img/icon/ic_cart_white.png\">
                    </td>";
                  }else{
                    echo"<td></td>";
                  }
                  echo"
                </tr>
              </table>
            </div>
          ";
        $count++;
      }

    ?>
  </div>
</div>

<input class="ajaxCallCount" type="hidden" value="2">
<input class="user_level" type="hidden" value="<?php
if($this->session->userdata('is_login')==true){
  echo $this->session->userdata('user_level');
}else{
  echo "0";
}
?>">

<div class="divPopupImgViewer">
  <img class="closeBtn" src="/static/img/icon/ic_close_white.png">
  <img class="product_img" src="">
</div>
<div class="divPopupImgViewerBG"></div>
