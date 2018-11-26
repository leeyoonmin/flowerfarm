<div class="wrap">
  <div class="divSection joinNormal">
    <div class="divTitle">
      <p class="title">회원가입</p>
      <p class="subTitle">신선하고 퀄리티 높은 꽃으로 보답하겠습니다.</p>
    </div>
    <div class="box">
      <p class="boxTitle">Step 2. 정보입력</p>
      <div class="formBox">
        <form class="joinFrm" action="/auth/joinPrc" method="post">
          <p>아이디</p>
          <input class="inputID" type="email" name="id" value="" placeholder="영소문자/숫자 6~20자, 한글/영대문자 불가">
          <input class="is_duplicated" type="hidden" value="true">
          <p>비밀번호</p>
          <input class="inputPW1" type="password" name="pw" value="" placeholder="비밀번호를 입력해주세요">
          <p>비밀번화확인</p>
          <input class="inputPW2" type="password" value="" placeholder="비밀번호를 다시 입력해주세요">
          <p>고객명</p>
          <input class="inputNM" type="text" name="name" value="" placeholder="이름 혹은 상호명을 입력해주세요">
          <p>전화번호</p>
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
        </form>
      </div>
      <div class="agreeBox">
        본인은 만 14세 이상이며,</br><a>꽃팜 구매회원 이용약관</a>, <a>개인정보 수집 및 이용</a> 내용을</br>확인하였으며 동의합니다.
      </div>
      <p class="errMsg"></p>
      <input class="joinBtn" type="submit" value="가입">
    </div>
  </div>
</div>
