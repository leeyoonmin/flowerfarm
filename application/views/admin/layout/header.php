<div class="divTopNav">
  <table>
    <tr>
      <td class="hamBtn"><img src="/static/img/icon/ic_ham.png"></td>
      <td class="logo">Flower Farm Admin Page</td>
    </tr>
  </table>
</div>

<div class="divFixedLeftMenu">
  <div class="divLeftMenuTopHeader">
    <table>
      <tr>
        <td></td><td class="closeBtn"><img src="/static/img/icon/ic_close_white.png"></td>
      </tr>
    </table>
  </div>
  <div class="divLeftMenuTopContents">
    <a href="/admin"><img src="/static/img/icon/ic_logo.png"></a>
  </div>
  <div class="divMenu">
    <ul>
      <li class="mainMenu shop <?php if($_SERVER['REQUEST_URI']=="/admin/slideBanner") echo "selected"; ?>"><img src="/static/img/icon/ic_home_white.png"><span>상점관리</span></li>
      <ul class="subMenu menuUp">
        <a href="/admin/slideBanner"><li class="sub"><span>∞　슬라이드 베너 관리</span></li></a>
      </ul>
      <li class="mainMenu user"><img src="/static/img/icon/ic_member_white.png"><span>회원관리</span></li>
      <ul class="subMenu menuUp">
        <a href="/admin/inquiryUserInfo"><li class="sub"><span>∞　회원정보조회</span></li></a>
        <a href="/admin/userGradeMng"><li class="sub"><span>∞　회원등급관리</span></li></a>
        <a href="/admin/setUserNick"><li class="sub"><span>∞　회원별칭지정</span></li></a>
      </ul>
      <li class="mainMenu product"><img src="/static/img/icon/ic_flower_white.png"><span>상품관리</span></li>
      <ul class="subMenu menuUp">
        <a href="/admin/productList"><li class="sub"><span>∞　상품관리</span></li></a>
        <a href="/admin/productPriceMng"><li class="sub"><span>∞　상품가격관리</span></li></a>
        <a href="/admin/productCateMng"><li class="sub"><span>∞　상품카테고리관리</span></li></a>
      </ul>
      <li class="mainMenu order"><img src="/static/img/icon/ic_box_white.png"><span>주문관리</span></li>
      <ul class="subMenu menuUp">
        <a href="/admin/paymentList"><li class="sub"><span>∞　입금전 관리</span></li></a>
        <a href="/admin/readyProduct"><li class="sub"><span>∞　상품준비중 관리</span></li></a>
        <a href="/admin/onDelivery"><li class="sub"><span>∞　배송중관리</span></li></a>
        <a href="/admin/orderAllList"><li class="sub"><span>∞　전체주문내역</span></li></a>
      </ul>
      <li class="mainMenu forder"><img src="/static/img/icon/ic_forder_white.png"><span>발주관리</span></li>
      <ul class="subMenu menuUp">
        <a href="/admin/createForder"><li class="sub"><span>∞　발주서 생성</span></li></a>
        <a href="/admin/writeForder"><li class="sub"><span>∞　발주서 작성</span></li></a>
        <a href="/admin/writeModifiedForder"><li class="sub"><span>∞　수정발주서 작성</span></li></a>
        <a href="/admin/writeConfirmedForder"><li class="sub"><span>∞　확정발주서 작성</span></li></a>
        <a href="/admin/forderAllList"><li class="sub"><span>∞　전체발주내역</span></li></a>
      </ul>
      <li class="mainMenu board"><img src="/static/img/icon/ic_list_white.png"><span>게시판관리</span></li>
      <ul class="subMenu menuUp">
        <a href="/admin/noticeMng"><li class="sub"><span>∞　공지사항관리</span></li></a>
        <a href="/admin/faqMng"><li class="sub"><span>∞　FAQ관리</span></li></a>
        <a href="/admin/questionMng"><li class="sub"><span>∞　1:1문의</span></li></a>
      </ul>
      <li class="mainMenu account"><img src="/static/img/icon/ic_doller.png"><span>회계관리</span></li>
      <ul class="subMenu menuUp">
        <a href="/admin/accountsList"><li class="sub"><span>∞　회계장부 조회</span></li></a>
      </ul>
      <li class="mainMenu code"><img src="/static/img/icon/ic_code.png"><span>코드관리</span></li>
      <ul class="subMenu menuUp">
        <a href="/admin/commonCodeMng"><li class="sub"><span>∞　공통코드관리</span></li></a>
        <a href="/admin/sqlMng"><li class="sub"><span>∞　SQL관리</span></li></a>
      </ul>
    </ul>
  </div>
</div>

<div class="divFixedLeftMenuBG"></div>
