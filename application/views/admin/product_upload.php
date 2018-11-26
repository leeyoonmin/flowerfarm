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
    <script src="<?php echo base_url();?>/static/js/admin_product_management.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/admin_product_management.css?ver=1">
</head>

<div class="sidemenu_wrap">
    <a href="/admin/addproduct" >  상품 등록 > </a>
    <a href="/admin/check" >  상품 목록 > </a>
</div>


<div class="product_manage_wrap">
    <h1>상품 등록 </h1><br><br>
  <table>
      <div class="product_manage_title"> 기본정보 </div>
      <tr>
          <td>상품명</td>
          <td><input type="text" class="product_name"></td>
      </tr>
      <tr>
          <td>부자재</td>
          <td><input type="checkbox" class="is_sub"> 부자재 </td>
      </tr>
      <tr>
          <td>품목</td>
          <td>
              <select name="include_item">
                 <option>품목을 고르세요</option>
              </select>
              <input type="button" class="include_item_btn" value="품목추가">
          </td>
      </tr>
      <tr>
          <td>모양</td>
          <td>
              <select name="include_shape">
                  <option>모양을 고르세요</option>
              </select>
              <input type="button" class="include_shape_btn" value="모양추가">
          </td>
      </tr>
      <tr>
          <td>색상</td>
          <td>
              <select name="include_color">
                 <option>색상을 고르세요</option>
              </select>
              <input type="button" class="include_color_btn" value="색상추가" >
          </td>
      </tr>
      <tr>
          <td>재고량</td>
          <td><input type="text" class="product_amount"> 단</td>
      </tr>
      <tr>
          <td>가격</td>
          <td><input type="text" class="product_price"> 원</td>
      </tr>
      <tr>
          <td>이미지</td>
          <td>
              <div class="image_1">
                  <img class="image_1_view"><br><br>이미지를 등록하세요<br><br>
                  <input type="button" class="image_1_btn" value="대표이미지1">
              </div>
              <div class="image_2">
                  <img class="image_2_view"><br><br>이미지를 등록하세요<br><br>
                  <input type="button" class="image_2_btn" value="대표이미지2">
              </div>
              <div class="image_3">
                  <img class="image_3_view"><br><br>이미지를 등록하세요<br><br>
                  <input type="button" class="image_3_btn" value="대표이미지3">
              </div>
              <div class="image_4">
                  <img class="image_4_view"><br><br>이미지를 등록하세요<br><br>
                  <input type="button" class="image_4_btn" value="대표이미지4">
              </div>
          </td>
      </tr>
      <tr>
          <td>진열</td>
          <td><input type="checkbox" class="is_show"> 진열 </td>
      </tr>
      <tr>
          <td>판매</td>
          <td><input type="checkbox" class="is_sell"> 판매 </td>
      </tr>
      <tr>
          <td>인기상품 / 새상품</td>
          <td>
              <select name="popular_product">
                  <option value="1"> 인기상품 </option>
                  <option value="2"> 새 상품 </option>
                  <option value="3"> 재고없음 </option>
              </select>
          </td>
      </tr>
  </table>
    <div class="submit_wrap">
        <input type="button" class="submit_btn" value="등록">
    </div>

</div>
