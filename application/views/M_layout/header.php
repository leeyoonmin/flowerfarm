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
<div class="pc divTopHeaderBG"></div>
<div class="pc divTopHeaderContainer">
  <div class="divTopHeader ">
    <table>
      <tr>
        <td class="divLogo"><a href="/">FLOWER FARM</a></td>
        <td></td>
        <td class="menu strong color"><a href="/M_menu/productList/01?ver=1.0">꽃보러가기</a></td>
        <td class="menu"><a href="/ledger/calendar">가계부</a></td>
        <td class="menu"><a href="/M_menu/cart">장바구니</a></td>
        <?php if($this->session->userdata('is_login')){?>
          <td class="menu"><a href="/mypage">마이페이지</a></td>
        <?php }?>
        <td class="menu"><a href="/mypage/support/02">고객센터</a></td>
        <?php if($this->session->userdata('user_level')==1){?>
          <td class="menu strong color"><a href="/admin" target="_blank">관리자</a></td>
        <?php }?>
        <td></td>
        <?php if($this->session->userdata('is_login')){?>
        <td class="menu strong"><a href="/auth/logout">로그아웃</a></td>
      <?php }else{?>
        <td class="menu strong"><a href="/M_auth/login">로그인</a></td>
        <td class="menu strong color"><a href="/M_auth/joinSelect">회원가입</a></td>
      <?php }?>

      </tr>
    </table>
  </div>
</div>
