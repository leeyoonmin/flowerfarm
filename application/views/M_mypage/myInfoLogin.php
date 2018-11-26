<div class="wrap">
  <div class="divItle myInfoLogin">
    <p class="title">개인정보보호를 위해</br>비밀번호를 다시 한 번 입력해주세요</p>
  </div>
  <div class="divLogin">
    <form class="myInfoLogin" action="/mypage/myInfoLoginPrc" method="post">

      <table>
        <tr>
          <td>아이디</td><td><?=$this->session->userdata('user_id')?></td>
        </tr>
        <tr>
          <td>비밀번호</td><td><input type="password" name="password" value=""></td>
        </tr>
      </table>

      <input type="submit" value="확인">

    </form>
  </div>
</div>
