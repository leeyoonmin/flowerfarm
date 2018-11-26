<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 30.
 * Time: PM 2:18
 */
?>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>꽃팜</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/reciept.css">
</head>



    <div class='modifyPwView'>
        <div class='input-row'>
            <div>신규 비밀번호 <input type='password' class='modifyPw'><br><br></div>
            <div class='error-msg'></div>
        </div>
        <div class='input-row'>
            <div>비밀번호 확인 <input type='password' class='modifyPwCheck'><br><br></div>
            <div class='error-msg'></div>
        </div>
        <input type='button' class='submitPw' value='비밀번호변경'>
    </div>