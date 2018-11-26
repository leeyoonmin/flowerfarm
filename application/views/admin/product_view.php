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
    <script src="<?php echo base_url();?>/static/js/admin_product_management.js?ver=8"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/admin_product_management.css?ver=7">
</head>
<div class="sidemenu_wrap">
    <a href="/admin" >  상품 등록 > </a>
    <a href="/admin/check" >  상품 목록 > </a>
</div>


<div class="product_list_wrap">
    <h1>상품 목록 </h1><br><br>
    <div class="product_list_delete_wrap">
        <input type="button" class="product_list_delete_btn" value="삭제">
    </div>
    <table>
        <tr>
            <td><input type="checkbox" class='selectAll' id='selectAll' onclick="selectAll()"></td>
            <td>No</td>
            <td>상품명</td>
            <td>부자재</td>
            <td>품목</td>
            <td>모양</td>
            <td>색상</td>
            <td>재고량</td>
            <td>도매가</td>
            <td>소매가</td>
            <td>대표 이미지</td>
            <td>진열</td>
            <td>판매</td>
            <td>인기상품</td>
        </tr>
        <?php

            foreach ($product_info as $row){
                $amount = number_format($row->product_amount);
                $price_w = number_format($row->product_price_w);
                $price_r = number_format($row->product_price_r);
                $type = ($row->product_type==1 ? "화훼":"부자재" );
                $display = ($row->display==1 ? "진열":"비진열");
                $sell = ($row->is_sell==1 ? "판매":"비판매");
                if($row->is_popural==1){
                    $popural = "인기상품";
                }
                if($row->is_popural==2){
                    $popural = "신상품";
                }
                if($row->is_popural==2){
                    $popural = "재고없음";
                }
                else{
                        $popural = "-";
                }

               echo "
                    <tr>
                        <td id='first'><input type='checkbox' name='chk' value='$row->product_id'></td>
                        <td>$row->personal_index</td>
                        <td><a class='product_list_name'>$row->product_name</a>
                            <input type='hidden' value='product_name'>
                        </td>
                        <td><a class='product_list_type'>$type</a>
                            <input type='hidden' value='product_type'>
                        </td>
                        <td><a class='product_list_cate_kind'>$row->product_cate_kind</a>
                            <input type='hidden' value='product_cate_kind'>
                        </td>
                        <td><a class='product_list_cate_shape'>$row->product_cate_shape</a>
                            <input type='hidden' value='product_cate_shape'>
                        </td>
                        <td><a class='product_list_cate_color'>$row->product_cate_color</a>
                            <input type='hidden' value='product_cate_color'>
                        </td>
                        <td><a class='product_list_amount'>$amount</a>
                            <input type='hidden' value='product_amount'>
                        </td>
                        <td><a class='product_list_price_w'>$price_w</a>
                            <input type='hidden' value='product_price_w'>
                        </td>
                        <td><a class='product_list_price_r'>$price_r</a>
                            <input type='hidden' value='product_price_r'>
                        </td>
                        <td><a class='product_list_img'><img src='/static/uploads/products/".$row->product_id."_1.png'></a>
                            <input type='hidden' value='product_id'>
                        </td>
                        <td><a class='product_list_display'>$display</a>
                            <input type='hidden' value='display'>
                        </td>
                        <td><a class='product_list_sell'>$sell</a>
                            <input type='hidden' value='is_sell'>
                        </td>
                        <td><a class='product_list_popural'>$popural</a>
                            <input type='hidden' value='is_popural'>
                        </td>
                    </tr>    
                    ";

            }

        ?>

    </table>

    <div class="product_list_btn_wrap">
        <input type="button" class="product_list_back" value="<">
        <input type="button" class="product_list_next" value=">">
        <input type="hidden" class="product_list_index" value="<?php echo $start_index?>">
        <input type="hidden" class="product_list_last_index" value="<?php echo $last_index?>">
    </div>

</div>