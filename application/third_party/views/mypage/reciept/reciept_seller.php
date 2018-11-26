<head>
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/reciept.css?ver=1">
    <script src="<?php echo base_url();?>/static/js/reciept.js?ver=2"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>

</head>
<div class="receipt-wrapper">
    <div id="mainContents">
        <?php
        /**
         * Created by PhpStorm.
         * User: messi
         * Date: 2018. 7. 5.
         * Time: PM 1:44
         */
        defined('BASEPATH') OR exit('No direct script access allowed');
        ?>
        <div class="contents">
        <h1>영수증(판매량 확인)</h1>

        <div class="selectZone">
            <select name="reciept_seller_select_year" class="reciept_seller_select_year">
                <option value="">년도</option>
                <option value="2017">2017년</option>
                <option value="2018">2018년</option>
            </select>
            <select name="reciept_seller_select_month" class="reciept_seller_select_month">
                <option value="">월</option>
                <option value="01">1월</option>
                <option value="02">2월</option>
                <option value="03">3월</option>
                <option value="04">4월</option>
                <option value="05">5월</option>
                <option value="06">6월</option>
                <option value="07">7월</option>
                <option value="08">8월</option>
                <option value="09">9월</option>
                <option value="10">10월</option>
                <option value="11">11월</option>
                <option value="12">12월</option>
            </select>
            <input type="button" class="submit_reciept_seller" value="조회">
        </div>


        <div class="reciept_seller_content"> </div>
        </div>


    </div>
</div>


<script>


</script>