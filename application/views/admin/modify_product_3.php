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
    .modify_product_wrap table td img{
        width: 200px;
        height: 150px;
        box-sizing: border-box;
        text-align: center;
        border: 0;
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

</script>

<div class="modify_product_wrap">
    <?php
    $baseURL= base_url();
    $imgURL = $baseURL."static/uploads/products/".$product;
    echo $type;

    ?>
    <form method='post' action=<?php $baseURL?>'/admin/modify_product3'>
        <table>

                <tr>
                   <td><img src="<?php echo $imgURL; ?>_1.png" onerror="this.style.display='none'"> </td>
                   <td><img src="<?php echo $imgURL; ?>_2.png" onerror="this.style.display='none'"></td>
                   <td><img src="<?php echo $imgURL; ?>_3.png" onerror="this.style.display='none'"></td>
                   <td><img src="<?php echo $imgURL; ?>_4.png" onerror="this.style.display='none'"></td>
                <tr>
                <tr>
                    <td>대표사진1</td>
                    <td>대표사진2</td>
                    <td>대표사진3</td>
                    <td>대표사진4</td>
                </tr>
                <tr>
                   <td><input type="file" name="file1"></td>
                   <td><input type="file" name="file2"></td>
                   <td><input type="file" name="file3"></td>
                   <td><input type="file" name="file4"></td>
                    <input type="hidden" name="pid" value="<?php echo $product?>">
                </tr>
        </table>
        <div class="submitBtn_wrap">
            <input type="submit" class="submitBtn" value="확인">
            <input type="button" class="cancleBtn" value="취소" onclick="window.close();">
        </div>
    </form>
</div>
