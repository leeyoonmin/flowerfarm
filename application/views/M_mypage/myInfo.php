<div class="wrap">
  <div class="divSearch">

  <div class="divTitle">
    <p class="title">회원정보</p><a class="link" href="/mypage/myInfoLogin/">#정보수정</a>
  </div>
  <div class="divUserInfo">
    <table>
      <tr>
        <td>아이디</td><td><?=$userData->user_id?></td>
      </tr>
      <tr>
        <td>고객명</td><td><?=$userData->user_name?></td>
      </tr>
      <tr>
        <td>가입유형</td><td><?=$userData->user_type_nm?></td>
      </tr>
      <tr>
        <td>생년월일</td><td><?=$userData->user_birth?></td>
      </tr>
      <tr>
        <td>성별</td><td><?php if($userData->user_sex == '1'){echo "남성";}else if($userData->user_sex == '2'){echo "여성";}?></td>
      </tr>
      <tr>
        <td>전화번호</td><td><?=$userData->user_tel_h?>-<?=$userData->user_tel_b?>-<?=$userData->user_tel_t?></td>
      </tr>
      <tr>
        <td>가입일</td><td><?=date('Y년 m월 d일',strtotime($userData->user_created))?></td>
      </tr>
    </table>
  </div>

  <div class="divTitle">
    <p class="title">기본배송주소</p><a class="link">#주소록관리</a>
  </div>
  <div class="divUserDefaultAddr">
    <table>
      <tr>
        <td>수령인</td><td><?=$userData->user_id?></td>
      </tr>
      <tr>
        <td>주소</td><td><?=$userData->user_name?></td>
      </tr>
      <tr>
        <td>전화번호</td><td><?=$userData->user_type_nm?></td>
      </tr>
    </table>
  </div>

</div>
