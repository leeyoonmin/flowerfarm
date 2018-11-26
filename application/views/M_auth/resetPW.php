<div class="wrap">
  <div class="divSection login findID">
    <div class="divTitle">
      <p class="title">비밀번호 재설정</p>
      <p class="subTitle">신선하고 퀄리티 높은 꽃으로 보답하겠습니다.</p>
    </div>
    <div class="box">
      <form class="resetFrm" action="/auth/resetPWPrc" method="post">
        <div class="formBox">
          <input class="inputPW1 targetInput" type="password" name="password" placeholder="비밀번호">
          <input class=" inputPW2" type="password" name="password" placeholder="비밀번호확인">
          <input type="hidden" name="id" value="<?=$USER_ID?>">
        </div>
      </form>
      <input class="targetBtn disable resetPWBtn" type="submit" value="비밀번호 설정">
      <input class="buttonValue" type="hidden" value="disalbe">

    </div>

    <div class="subMenuBox">
      <table>
        <tr>
          <td><a href="/M_auth/findPW">비밀번호찾기</a></td>
          <td><a href="/M_auth/login">로그인</a></td>
          <td><a href="/M_auth/joinSelect">회원가입</a></td>
        </tr>
      </table>
    </div>
    <div class="resultBox">

    </div>
  </div>
</div>
