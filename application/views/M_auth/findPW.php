<div class="wrap">
  <div class="divSection login findID">
    <div class="divTitle">
      <p class="title">비밀번호찾기</p>
      <p class="subTitle">신선하고 퀄리티 높은 꽃으로 보답하겠습니다.</p>
    </div>
    <div class="box">
      <div class="formBox">
        <input class="inputFindID" type="text" name="id" placeholder="아이디">
        <select id="sel_tel1" name="tel1">
          <option value="010" >010</option>
          <option value="011">011</option>
          <option value="016">016</option>
          <option value="017">017</option>
          <option value="018">018</option>
          <option value="019">019</option>
        </select>
        － <input type="tel" id="tel2" name="tel2" maxlength="4" value="">
        － <input type="tel" id="tel3" name="tel3" maxlength="4" value="">
      </div>
      <input class="getIdentifyCodeBtn" type="submit" value="인증번호 받기">
      <input class="buttonValue" type="hidden" value="disalbe">
      <div class="formBox identifyFrm">
        <input class="inputFindNM targetInput inputIdentifyCode" type="text" name="name" placeholder="인증번호 입력"><input class="inputCount" type="text" value="03:00" readonly>
      </div>
      <input class="targetBtn disable pwResetBtn" type="submit" value="비밀번호 재설정">
      <input class="buttonValue" type="hidden" value="disalbe">
    </div>
    <div class="subMenuBox">
      <table>
        <tr>
          <td><a href="/M_auth/login">로그인</a></td>
          <td><a href="/M_auth/findID">아이디찾기</a></td>
          <td><a href="/M_auth/joinSelect">회원가입</a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<form class="resetFrm" action="/M_auth/resetPW" method="post">
  <input class="frmCODE" type="hidden" name="identifyCode" value="">
  <input class="frmID" type="hidden" name="id" value="">
</form>
