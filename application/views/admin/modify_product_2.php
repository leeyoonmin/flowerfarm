<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 18.
 * Time: PM 6:01
 */
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
    .modify_product_wrap table{
        margin: auto;
        font-size: 13px;
        margin-top: 20px;
        border-spacing: 0;
        padding: 0;
        border-collapse: collapse;
    }
    .modify_product_wrap table td{
        width: 200px;
        height: 50px;
        border: 1px solid gainsboro;
        box-sizing: border-box;
        text-align: center;
        border-spacing: 0;
        padding: 0;
    }
    .modify_product_wrap .submitBtn_wrap{
        margin: auto;
        width: 100px;
    }
    .modify_product_wrap .submitBtn{
        margin-top: 20px;
        float: left;
        width: 50%;

    }
    .modify_product_wrap .cancleBtn{
        margin-top: 20px;
        float: left;
        width: 50%;

    }
</style>
<script>
    function numkeyCheck(e) {
        var keyValue = event.keyCode;
        if( ((keyValue >= 48) && (keyValue <= 57)) )
            return true; else return false;
    } //숫자만 입력받기

    function sub() {
        var a = document.getElementById('price_w').value;
        var b = document.getElementById('price_r').value;
        if(a==""||b==""){
            alert("도매/소매가를 모두 입력하세요");
            return false;
        }
        if(confirm("수정하시겠습니까?")){
            return;
        }
        else{
            return false;
        }

    }
</script>

<div class="modify_product_wrap">
    <?php
    $baseURL= base_url();
    $pid =$_GET['pid'];
    echo $type; ?>
    <form method='post' action=<?php $baseURL?>'/admin/modify_product2' onsubmit="return sub();">
        <table>
            <?php
            foreach ($product as $row){
                echo "
                        <tr> 
                            <td> 도매 </td>   
                            <td>$row->product_price_w</td>
                            <td><input type='text' id='price_w' name='price_w' onkeypress='return numkeyCheck(event)'></td>
                        <tr>
                        <tr>
                            <td> 소매 </td>
                            <td>$row->product_price_r</td>
                            <td><input type='text' id='price_r' name='price_r' onkeypress='return numkeyCheck(event)'></td>
                        </tr>
                        
                        ";
            }
            ?>

            </tr>
        </table>
        <div class="submitBtn_wrap">
            <input type="submit" class="submitBtn" value="확인"  >
            <input type="button" class="cancleBtn" value="취소" onclick="window.close();">
            <input type="hidden" name="pid" value="<?php echo $pid; ?>"  >
        </div>
    </form>
</div>
