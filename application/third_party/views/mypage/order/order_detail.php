<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 30.
 * Time: PM 8:56
 */
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
    <title>꽃팜</title>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>/static/css/reciept.css">
</head>
<script>
    function back() {
        window.location.href='../../mypage/checkMyOrder';
    }
</script>
<body>
    <div class="mp-od-detail-wrapper">
        <div class="btns">
            <input type='button' value='배송조회'>
            <input type='button' value='교환/반품 신청'>
            <input type='button' value='주문 취소'>
        </div>
        <h2>주문내역</h2>
        <table>
            <?php
            foreach ($detail as $row) {
                $user_name = $row->user_name;
                $order_time = $row->order_time;
                $certi_phone = $row->user_cellphone;
                $user_address = $row->user_addr;
                $pay_type = $row->pay_type;
                $is_paid = $row->is_paid;
                ?>
            <tr>
                <td><img src="/static/uploads/products/<?=$row->product_id?>_main.png"></td>
                <td><?= $row->product_name ?> <br><?= $row->order_amount ?> 단 / <?= $row->order_price ?> 원</td>
                <td><?= $row->order_time ?></td>
            </tr>
        <?php
        }
        ?>
        </table>
        <h2>받는 사람 정보</h2>
        <table>
            <tr>
                <td>수령인</td>
                <td class="large-td"><?= $user_name ?></td>
            </tr>
            <tr>
                <td>연락처</td>
                <td class="large-td"><?= $certi_phone ?></td>
            </tr>
            <tr>
                <td>주소</td>
                <td class="large-td"><?= $user_address ?></td>
            </tr>
        </table>

        <h2>결제정보</h2>
        <table>
            <tr>
                <td>결제수단</td>
                <td class="large-td"><?= $pay_type ?></td>
            </tr>
            <tr>
                <td>결제여부</td>
                <td class="large-td"><?= $is_paid ?></td>
            </tr>
        </table>
        <button type='button' onclick='back()'>주문목록으로 돌아가기</button>
    </div>
</body>
