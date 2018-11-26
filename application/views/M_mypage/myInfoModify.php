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
        <td>
        </td>
      </tr>
    </table>
  </div>

  <div class="divTitle">
    <p class="title">회원정보변경</p>
  </div>
  <div class="divUserInfo">
    <form class="myInfoModifyFrm" action="/mypage/myInfoModifyPrc" method="post">

    <table>
      <tr>
        <td>아이디</td>
        <td><?=$userData->user_id?></td>
      </tr>
      <tr>
        <td>고객명</td>
        <td><input class="name" type="text" name="name" value="<?=$userData->user_name?>"></td>
      </tr>
      <tr>
        <td>가입유형</td>
        <td><?=$userData->user_type_nm?></td>
      </tr>
      <tr>
        <td>생년월일</td>
        <td><input type="text" name="birth" value="<?=$userData->user_birth?>" placeholder="예) 890820 8자리"></td>
      </tr>
      <tr>
        <td>성별</td>
        <td><input id="sex1" type="radio" name="sex" value="1" <?php if($userData->user_sex=='1'){echo "checked=\"checked\"";}?>><label for="sex1">남성</label><input id="sex2" type="radio" name="sex" value="2" <?php if($userData->user_sex=='2'){echo "checked=\"checked\"";}?>><label for="sex2">여성</label></td>
      </tr>
      <tr>
        <td>전화번호</td>
        <td>
          <select id="sel_tel1" name="tel1">
            <option value="010" <?php if($userData->user_tel_h=='010'){echo "selected";}?>>010</option>
            <option value="011" <?php if($userData->user_tel_h=='011'){echo "selected";}?>>011</option>
            <option value="016" <?php if($userData->user_tel_h=='016'){echo "selected";}?>>016</option>
            <option value="017" <?php if($userData->user_tel_h=='017'){echo "selected";}?>>017</option>
            <option value="018" <?php if($userData->user_tel_h=='018'){echo "selected";}?>>018</option>
            <option value="019" <?php if($userData->user_tel_h=='019'){echo "selected";}?>>019</option>
          </select>
          －<input type="tel" id="tel2" name="tel2" maxlength="4" value="<?=$userData->user_tel_b?>">
          －<input type="tel" id="tel3" name="tel3" maxlength="4" value="<?=$userData->user_tel_t?>">
        </td>
      </tr>
      <tr>
        <td>가입일</td><td><?=date('Y년 m월 d일',strtotime($userData->user_created))?></td>
      </tr>
    </table>
    <input type="submit" value="저장">
  </form>
  </div>

  <div class="divTitle">
    <p class="title">비밀번호변경</p>
  </div>
  <div class="divPasswordModify">
    <form class="passwordModifyFrm" action="/mypage/passwordModifyPrc" method="post">
      <table>
        <tr>
          <td>새 비밀번호</td>
          <td><input class="password1" type="password" name="password" value=""></td>
        </tr>
        <tr>
          <td>새 비밀번호확인</td>
          <td><input class="password2" type="password" name="password" value=""></td>
        </tr>
      </table>
      <input type="submit" value="저장">
    </form>
  </div>

</div>
