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
    <script src="<?php echo base_url();?>/static/js/check_my_order.js?ver=3"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/order.css?ver=2">
</head>
<body>
    <div class="mp-order-wrapper">
        <h1> 주문내역조회 </h1>
        <?php

        if($latestOrder){
            foreach ($latestOrder as $row1){
                $result=0;
                ?>
                <table>
                    <tr class="order-header">
                        <td><?=$row1->order_time?></td>
                        <td class="order-header-detail" colspan="3"><a href='orderDetail/<?=$row1->order_id?>'>주문상세보기 > </a></td>
                    </tr>
                    <?php

                    foreach ($myorder as $row) {;
                        if ($row1->order_id == $row->order_id) {
                            $result += $row->order_price *$row->order_amount;
                            $ispay = ($row->is_paid == 1 ? "결제완료" : "결제대기");
                            ?>
                            <tr>
                                <td><a href="<?php echo base_url();?>product/details/<?php echo $row->product_id?>"><img src="/static/uploads/products/<?=$row->product_id?>_main.png"></a></td>
                                <td><a href="<?php echo base_url();?>product/details/<?php echo $row->product_id?>">
                                    <h2><?= $row->product_name ?></h2><br>
                                    <h2 style="color: #0000FF;"><?= $row->order_amount ?></> 단</h2><br>
                                    <h2><?= $row->order_price ?> 원 / 1단</h2>
                                    </a>
                                </td>
                                <td>
                                    <?= $ispay ?><br><br>
                                    <input type="hidden" value='<?php echo $row->order_id?>' class="check_order_id">
                                    <button type='button' value='<?php echo $row->order_item_index?>' class="order_cancle_btn">주문 취소</button>
                                </td>
                            </tr>
                            <?php
                       }

                    }
                    echo "
                        <tr>
                        <td></td>
                        <td></td>
                        <td><h2 style='color: #dd1144;'>총 합 계: $result 원</h2></td>
                        </tr>
                        ";
                    ?>

                </table><br><br>
                <?php
            }
        }
        else{
            echo "주문내역이 없습니다";
        }

        ?>
        <div class="page_shift_wrap">
            <div class="button_wrap">
                <input type="button" class="page_back" value="<">
                <input type="button" class="page_next" value=">">
                <input type="hidden" class="page_index" value="<?php echo $start_index?>">
                <input type="hidden" class="page_max_index" value="<?php echo $max_index?>">
            </div>
        </div>
    </div>

</body>
