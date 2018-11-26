<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 31.
 * Time: PM 2:29
 */
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <script src="<?php echo base_url(); ?>/static/js/setChart.js"></script>
    <title>꽃팜</title>
    <link rel="stylesheet" type="text/css" href="/static/css/currentPrice.css?ver=7">
    <script src="<?php echo base_url();?>/static/js/currentPrice.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all"/>
    <script src="https://www.amcharts.com/lib/3/themes/none.js"></script>


</head>


<body>
    <div class="contents">
        <p class="auctionChart">경매가 차트</p>
        <p style="font-size: 20px; text-align: center;">부산</p>
        <div class="chartformwrap">
            <div class="buttonwrap">
                <p class="chartBtn">표</p>
                <p class="graphBtn">그래프</p>
            </div>
        </div>

        <div class="selectZone_busan">
            <form method="post">
                <div class="gongpanzone_busan">
                    <select name="gongpan_busan" class="gongpanSelect_busan" onchange="setGongpan_busan(this.value);">
                        <option value="">공판장선택</option>
                        <?php
                        foreach ($gongpanName as $row) {
                            echo "<option value='$row->gongpanName'>$row->gongpanName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mclasszone_busan">
                    <select name='mclassname_busan' class='mclassSelect_busan' onchange='setMclass_busan(this.value);'>
                        <option value=''>품종선택</option>
                    </select>
                </div>
                <div class="sclasszone_busan">
                    <select name='sclassname_busan' class='sclassSelect_busan' id='sclassname_busan'>
                        <option value=''>품명선택</option>
                    </select>
                </div>
                <input type="button" class="submitDatas_busan" value="조회">
            </form>
        </div>
        <div id="graphdiv_busan"></div> <!--부산 화훼 차트 표출-->
        <div id="chartdiv_busan"></div>

        <div class="selectZone_other">
        <p style="font-size: 20px; text-align: center; margin-bottom: 30px;"> 수도권 </p>
            <form method="post">
                <div class="gongpanzone_other">
                    <select name="gongpan_other" class="gongpanSelect_other" onchange="setGongpan_other(this.value);">
                        <option value="">공판장선택</option>
                        <?php
                        foreach ($gongpanName_other as $row) {
                            echo "<option value='$row->gongpanName'>$row->gongpanName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="sclasszone_other">
                    <select name='sclassname_other' class='sclassSelect_other' id='sclassname_other'>
                        <option value=''>품명선택</option>
                    </select>
                </div>
                    <input type="button" class="submitDatas_other" value="조회">
            </form>
            <div id="graphdiv_other"></div>
        </div>
    </div>
</body>




