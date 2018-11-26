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
            return true;
        else
            return false;
    } //숫자만 입력받기

    function sub() {
        if(document.getElementById('ptype').value=="상품명"){
            var a = document.getElementById('pname').value;
        }
        if(document.getElementById('ptype').value=="재고량"){
            var b = document.getElementById('pamount').value;
        }

        if(a==""||b==""){
            alert("수정된 정보를 기입하세요");
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
    <form method='post' action=<?php $baseURL?>'/admin/modify_product1' onsubmit="return sub();">
        <table>
            <tr>
                <td><?php echo $product; ?></td>
                <?php
                    if($type=="상품명"){
                        echo "<td><input type='text' id='pname' name='pname'></td>";
                    }
                    if($type=="재고량"){
                        echo "<td><input type='text' id='pamount' name='pamount' onkeypress='return numkeyCheck(event)'></td>";
                    }
                ?>

            <tr>


            </tr>
        </table>
        <div class="submitBtn_wrap">
            <input type="submit" class="submitBtn" value="확인"  >
            <input type="button" class="cancleBtn" value="취소" onclick="window.close();">
            <input type="hidden" name="pid" value="<?php echo $pid; ?>" >
            <input type="hidden" id="ptype" name="ptype" value="<?php echo $type; ?>" >
        </div>
    </form>
</div>
