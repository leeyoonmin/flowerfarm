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
    <script src="<?php echo base_url();?>/static/js/modifyMyInfo.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/reciept.css">
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/mypage.css">
</head>

<div class="contents">
    <div class="member-wrapper content-wrapper">
        <div class="mp-member-header">
            회원정보변경
        </div>
        <section class="member-main mp-main">
            <div class="main-wrapper mp-main-wrapper">
                <form action="modifyMyInfo" method="post">
                    <div class="login-input">
                        <div class="field-wrap">
                            <div class="input-field">
                                <label class="input-field-label">
                                    <div class="input-field-input">
                                        <input class="member-input loginIdInput" name="id" placeholder="아이디" value="<?php echo $this->session-> userdata('user_id'); ?>">
                                    </div>
                                </label>
                            </div>
                            <div class="expand-field">
                                <div classs="error-message"></div>
                            </div>
                        </div>
                        <div class="field-wrap">
                            <div class="input-field">
                                <label class="input-field-label">
                                    <div class="input-field-input">
                                        <input class="member-input loginIdInput" name="pw" type="password" placeholder="비밀번호">
                                    </div>
                                </label>
                            </div>
                            <div class="expand-field">
                                <div classs="error-message">
                                    <?php if($flag==2){
                                        echo "<div style='color:red;'>비밀번호 틀렸습니다</div><br>";
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="login-trigger-wrap">
                        <input type="submit" class="checkIdBtn login-trigger login" value="확인">
                        <input type="button" value="취소" class="login-trigger register" id="login_cancle">
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
