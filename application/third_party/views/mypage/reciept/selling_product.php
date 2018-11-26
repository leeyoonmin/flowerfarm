<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 8. 21.
 * Time: PM 4:57
 */


$total = 0;
echo "
            <table class='flanc-tb'>
                <tr>
                    <td>거래일</td>
                    <td>품종</td>
                    <td>판매량</td>
                    <td>가격(단위당)</td>
                    <td>합계</td>
                </tr>";

foreach ($selling_product as $row) {
    $a = $row->product_amount;
    $b = $row->order_price;
    $multiple = $a * $b;
    $total += $multiple;
    $product_amount = number_format($row->product_amount);
    $order_price = number_format($row->order_price);
    $multiple = number_format($multiple);
    echo "<tr>
                        <td>$row->order_time</td>
                        <td>$row->product_name</td>
                        <td>$product_amount 단</td>
                        <td>$order_price 원</td>
                        <td>$multiple 원</td>
                    </tr>";

}
$total = number_format($total);
echo "
                <tr>
                    <td>총합계</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>$total 원</td>
                </tr>
            </table>
           
           
           
           ";


?>