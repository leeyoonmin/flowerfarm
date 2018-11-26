<div class="divSlideMenu shadow_2">
<table>
  <tr>
    <td>Flower Farm</td><td class="hamCloseBtn"><img src="/static/img/icon/ic_close_green.png"></td>
  </tr>
  <?php
    if($this->session->userdata('is_login')){
      echo "
          <tr>
            <td class=\"menu\" colspan=\"2\"><a href=\"/auth/logout\">로그아웃</a></td>
          </tr>
          ";
    }else{
      echo "
          <tr>
            <td class=\"menu\" colspan=\"2\"><a href=\"/M_auth/login\">로그인</a></td>
          </tr>
          <tr>
            <td class=\"menu\" colspan=\"2\"><a href=\"/M_auth/joinSelect\">회원가입</a></td>
          </tr>
          ";
    }
  ?>
  <tr>
    <td class="menu gray" colspan="2"><a href="/M_menu/productList/01">꽃 보러가기</a></td>
  </tr>
  <!--tr>
    <td class="menu" colspan="2"><a href="/M_menu/productList/02">부자재</a></td>
  </tr-->
  <!--tr>
    <td class="menu" colspan="2"><a href="#">화훼시세(준비중)</a></td>
  </tr-->
  <tr>
    <td class="menu" colspan="2"><a href="/ledger/calendar">가계부</a></td>
  </tr>
  <?php
  if($this->session->userdata('is_login')){
    echo "
        <tr>
          <td class=\"menu\" colspan=\"2\"><a href=\"/mypage\">마이페이지</a></td>
        </tr>
        ";
  }
  ?>
  <tr>
    <td class="menu" colspan="2"><a href="/mypage/support/02">고객센터</a></td>
  </tr>
  <?php
  if($this->session->userdata('user_level')==1){
    echo "<tr>
      <td class=\"menu\" colspan=\"2\"><a style=\"color:#FE8200;\" href=\"/admin\">관리자페이지</a></td>
    </tr>";
  }
  ?>
</table>
</div>
<div class="divSlideMenuBG"></div>

<div class="divSlideCart shadow_2">
  <div class="divTopHeader">
    총 <span><?php $prdCnt = 0; foreach($this->cart->contents() as $item){$prdCnt++;} echo number_format($prdCnt);?></span>개 상품
  </div>
  <div class="divCartList">
    <?php
    foreach($this->cart->contents() as $item){
      echo"
      <div class=\"divItem item".$item['id']."\">
        <table>
          <tr>
            <td class=\"imgTD\"><img src=\"/static/uploads/product/";
            if($item['extension']==""){
              echo "noImage.png";
            }else{
              echo $item['id'].".".$item['extension'];
            }
            echo"\"></td>
            <td class=\"infoTD\">
              <p>".$item['name']."</p>
              <p><span>".number_format($item['price'])."</span>원</p>
            </td>
            <td class=\"controlTD\">
              <input type=\"hidden\" value=\"".$item['id']."\">
              <a class=\"minusBtn\">－</a><span>".$item['qty']."</span><a class=\"plusBtn\">＋</a>
            </td>
          </tr>
        </table>
        <!--img class=\"deleteBtn\" src=\"/static/img/icon/ic_close_white.png\"-->
      </div>
      ";
    }
    ?>
  </div>
  <div class="divCartTotal">
    <table>
      <tr>
        <td>상품가격</td><td class="productPrice"><?=number_format($this->cart->total())?>원</td>
      </tr>
      <tr>
        <td>배송비</td><td class="deliveryFee">0원</td>
      </tr>
      <tr>
        <td>총합계</td><td class="totalPrice"><?=number_format($this->cart->total())?>원</td>
      </tr>
    </table>
    <a href="/M_menu/cart"><input type="button" value="주문하기"></a>
  </div>
  <div class="ui active inverted dimmer divLoader slideCart">
    <div class="ui text small loader">로딩중..</div>
  </div>
  <div class="pc divCartCallBtn close shadow_2">
    장<br>
    바<br>
    구<br>
    니<br>
    <img src="/static/img/icon/ic_cart_bold.png">
  </div>
</div>
<div class="divSlideCartBG"></div>
<div class="ui active dimmer divLoader body">
  <div class="ui text small loader">로딩중..</div>
</div>
