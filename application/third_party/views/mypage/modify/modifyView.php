<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 18.
 * Time: PM 6:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$id =$this->session->userdata('user_id');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>꽃팜</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo base_url();?>/static/js/modifyMyInfo.js?ver=3"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/reciept.css">
</head>


<body>
<div class="contents">

    <div class="mp-modify-wrapper">

<?php
      foreach ($user as $row){

          echo "
                
                <form method='post'>
                <table>
                    <tr>
                        <th>아이디</th>
                        <th style='width:350px;'>$id</th>
                    </tr>
                    <tr>
                        <th>이름</th>
                        <th>
                            <div class='wrap_modifyName'>$row->user_name <input type='button' class='modifyName' value='이름 변경'></div>
                        </th>
                    </tr> 
                    <tr>
                        <th>휴대폰 번호</th>
                        <th>
                            <div class='wrap_modifyPhone'>$row->user_cellphone <input type='button' class='modifyPhone' value='휴대폰 번호 변경'></div>
                        </th>
                    </tr>
                    <tr>
                        <th>비밀번호</th>
                        <th style='height: 200px;'>
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
                        </th>
                    </tr>
                    <tr>
                        <th>유저타입</th>
                        <th> <div class='modifyTypeArea'>
                             <input type='radio' name='user_type' value='2'/>농가
                             <input type='radio' name='user_type' value='3'/>도매
                             <input type='radio' name='user_type' value='4'/>소매
                             <input type='radio' name='user_type' value='5'/>일반 <br><br>
                             <input type='button' class='modifyType' value='유저타입 변경'>
                             </div>
                        </th>
                    </tr>
                    <tr>
                        <th> 주소 </th>
                        <th style='height: 100px;'>
                             <div class='wrap_modifyAdr'><div> $row->user_addr <input type='button' class='modifyAdr' value='주소변경'></div>
                        </th>
                    </tr>
                 
                </table>   
                </form> 
                            
                ";
          echo "<script> checkRadioDefault($row->user_type)</script>";

      }  ?>

    </div>
</div>
</body>
