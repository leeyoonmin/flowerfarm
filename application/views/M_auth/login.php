<div class="wrap login">
  <div class="divSection login">
    <div class="divTitle">
      <p class="title">로그인</p>
      <p class="subTitle">신선하고 퀄리티 높은 꽃으로 보답하겠습니다.</p>
    </div>
    <div class="box">
      <form class="" action="/auth/loginPrc" method="post">

      <div class="formBox">
        <input class="targetInput" type="text" name="id" placeholder="아이디">
        <input class="lastInput" type="password" name="password" placeholder="비밀번호">
      </div>

      <input class="targetBtn disable" type="submit" value="로그인">
      <input class="buttonValue" type="hidden" value="disalbe">

    </form>
    </div>
    <div class="subMenuBox">
      <table>
        <tr>
          <td><a href="/M_auth/findID">아이디찾기</a></td>
          <td><a href="/M_auth/findPW">비밀번호찾기</a></td>
          <td><a href="/M_auth/joinSelect">회원가입</a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
