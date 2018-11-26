<div class="wrap">
  <div class="divSection joinResult">
    <div class="divTitle">
      <p class="title">회원가입</p>
      <p class="subTitle">신선하고 퀄리티 높은 꽃으로 보답하겠습니다.</p>
    </div>
    <div class="box">
      <p class="boxTitle">Step 3. 가입완료</p>
      <div class="formBox">
        <?php
        echo "<p class=\"msg\"><span>".$this->session->userdata('user_name')."</span>님 꽃팜 가입을 환영합니다.</p>";
        if($this->session->userdata('user_level')=="6"){
          echo "<br><p>사업자가입 시 승인절차가 필요하며,</p><p>승인완료 시 사업자가격이 표시됩니다.</p>";
        }
        ?>
      </div>
      <a href="/ledger/calendar"><input class="width2" type="button" value="가계부"></a><a href="/M_main"><input class="width2 last" type="button" value="홈으로"></a>
    </div>
  </div>
</div>

<!--div class="wrap joinResult">
  <div class="divJoin">
    <div class="divText">
      <div class="spinner">
        <div class="dot1"></div>
        <div class="dot2"></div>
        <div class="dot3"></div>
        <div class="dot4"></div>
      </div>
      <h1 class="intro hidden"><span class="static name"></span> 님, <br>회원가입을 축하드립니다.</h1>
      <h1 class="intro hidden">감사합니다.</h1>
      <h1 class="intro hidden">신선하고 퀄리트 높은 <span class="static" style="color:#ec513c">꽃</span>으로<br>보답하겠습니다.</h1>

      <h1 class="id hidden"><span class="static name"></span>님,</br>참 이쁜 이름이네요</h1>
      <h1 class="id hidden">기억에 남을 것 같아요</h1>
      <h1 class="id show">당신을 표현할<br>아이디를 입력해주세요</h1>

      <h1 class="pw hidden"><span class="static id"></span>,<br><span class="static name"></span>님의 개성을</br>잘 표현할 수 있겠어요</h1>
      <h1 class="pw show">이제 <span class="static name"></span>님의 아이디를 <br>안전하게 보호해줄<br>비밀번호를 입력해주세요</h1>

      <h1 class="pw end"><span class="static id"></span>,<br><span class="static name"></span>님의 개성을</br>잘 표현할 수 있겠어요</h1>
      <h1 class="pw end">이제 <span class="static name"></span>님의 아이디를 <br>안전하게 보호해줄<br>비밀번호를 입력해주세요</h1>

      <h1 class="tel show">마지막으로 <span class="static name"></span>님의<br>전화번호를 입력해주세요</h1>

    </div>
    <div class="divInput">
      <input class="shadow_2 input text name" type="text" name="name" value="" autocomplete="off">
      <div class="divTel shadow_2">
        <select name="tel1" class="tel1">
          <option value="010">010</option>
          <option value="011">011</option>
          <option value="016">016</option>
          <option value="017">017</option>
          <option value="018">018</option>
          <option value="019">019</option>
        </select>
        －<input class="tel2" type="tel" name="tel2" maxlength="4" value="">
        －<input class="tel3" type="tel" name="tel3" maxlength="4" value="">
      </div>
      <input class="input button name" type="button" value="확인">
    </div>
  </div>
</div-->
