<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 18.
 * Time: PM 6:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>꽃팜</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>


<div class="mp-wrapper">
    <h1> 마이페이지 </h1>
    <ul>
        <li><a href="/mypage/checkMyOrder">주문내역조회</a></li>
        <li><a href="/mypage/modifyMyInfo">회원정보수정하기</a></li>
        <li><a href="/mypage/reciept">영수증</a></li>
        <?php
         $userType = $this->session-> userdata('user_type');
         if($userType==2 ||$userType==3){
             echo "<li><a href='/mypage/reciept_seller'>영수증(판매량확인)</a></li>";
         }
        ?>
    </ul>
</div>
</body>
