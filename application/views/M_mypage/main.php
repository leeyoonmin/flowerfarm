<div class="wrap">
  <div class="divBaseInfo">
    <table>
      <tr>
        <td class="userImg">
          <?php
            if($userData->user_type < 5){
              echo "<img src=\"/static/img/icon/ic_home.png\">";
            }
            else{
              echo "<img src=\"/static/img/icon/ic_member.png\">";
            }
          ?>
        </td>
        <td class="nameCard">
            <?="[".$userData->user_type_nm."] ".$userData->user_name?>
        </td>
        <td class="userSettings">
            <img src="/static/img/icon/ic_settings.png"><br>
            내 정보 관리
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td><?=date('m',time())."월 구매금액 : <span>".number_format($monthPrice)."<span> 원"?></td>
        <td><?="이번주 구매금액 : <span>".number_format($weekPrice)."<span> 원"?></td>
      </tr>
    </table>
  </div>

  <div class="divMenuList">
    <ul>
      <a href="mypage/orderList"><li>주문내역<img src="/static/img/icon/ic_arrow_right.png" alt=""></li></a>
      <a href="mypage/cancleList"><li>취소/환불 내역<img src="/static/img/icon/ic_arrow_right.png" alt=""></li></a>
      <?php if($this->session->userdata('user_level')==5){?>
        <a href="mypage/transBiz"><li>사업자회원 전환신청<img src="/static/img/icon/ic_arrow_right.png" alt=""></li></a>
      <?php }?>
      <!--a><li>마일리지 관리<img src="/static/img/icon/ic_arrow_right.png" alt=""></li></a>
      <a><li>쿠폰 관리<img src="/static/img/icon/ic_arrow_right.png" alt=""></li></a-->
      <a href="mypage/support/03"><li>1:1 문의<img src="/static/img/icon/ic_arrow_right.png" alt=""></li></a>
    </ul>
  </div>
</div>
