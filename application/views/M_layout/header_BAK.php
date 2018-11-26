<div class="m divTopHeader shadow_1">
  <table>
    <tr>
      <td class="hamBtn"><img src="/static/img/icon/ic_ham_green.png"></td>
      <td class="logoBtn"><a href="/M_main">Flower Farm</a></td>
      <?php
        if($this->uri->segment(2)=="cart" || $this->uri->segment(2)=="order"){
          echo "<td width=\"50px\"></td>";
        }
        else{
          echo "<td class=\"cartBtn\"><img src=\"/static/img/icon/ic_cart_green.png\"></td>";
        }
      ?>
    </tr>
  </table>
</div>
<div class="m divTopHeaderBG"></div>

<div class="pc divTopHeaderBG">
  <div class="divTopHeader ">
    <ul>
      <?php
      if($this->session->userdata('user_level')==1){
        echo "<li><a style=\"color:#01cbe2;font-weight:bold\" href=\"/admin\" target=\"_blank\">관리자페이지<a></li>";
      }
      ?>
      <li><a href="/M_menu/cart">장바구니<a></li>
      <li><a href="/mypage/support/01">고객센터<a></li>
        <?php
        if($this->session->userdata('is_login')){
          echo "<li><a href=\"/mypage\">마이페이지<a></li>";
          echo "<li><a href=\"/auth/logout\">로그아웃<a></li>";
        }else{
          echo "<li><a href=\"/M_auth/joinSelect\">회원가입<a></li>";
          echo "<li><a href=\"/M_auth/login\">로그인<a></li>";
        }
        ?>
    </ul>
  </div>
</div>

<div class="pc divMainLogo">
  <a href="/">FLOWER FARM</a>
</div>

<div class="pc divMainMenu">
  <div class="menu">
    <table>
      <tr>
        <td style="background:#FE8200;"><a style="color:#fff;" class="<?php if($_SERVER['REQUEST_URI']=="/M_menu/productList/01") echo "selected";?>" href="/M_menu/productList/01">꽃 사러가기</a></td>
        <!--td><a class="hover <?php /*if($_SERVER['REQUEST_URI']=="/M_menu/productList/02") echo "selected";*/?>" href="/M_menu/productList/02">부자재</a></td-->
        <!--td><a href="#">시세정보(준비중)</a></td-->
        <td><a class="hover <?php if(substr($_SERVER['REQUEST_URI'],0,7)=="/ledger") echo "selected";?>" href="/ledger/daily">가계부</a></td>
        <?php
          if($this->session->userdata('user_level') == "1" || $this->session->userdata('user_level') == "3" || $this->session->userdata('user_level') == "2"){
            //echo "<td></td>";
            //echo "<td><a class=\"\" href=\"/manager\" target=\"_blank\">관리페이지</a></td>";
          }else{
            //echo "<td></td>";
          }
        ?>

      </tr>
    </table>
  </div>
</div>
