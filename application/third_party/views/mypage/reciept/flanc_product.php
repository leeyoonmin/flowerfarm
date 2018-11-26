<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 8. 20.
 * Time: PM 6:14
 */



echo "
                     <table class='flanc-tb'>
                    <tr>
                        <td>거래일</td>
                        <td>거래처</td>
                        <td>품종</td>
                        <td>수량</td>
                        <td>가격</td>
                        <td>총가격</td>
                    </tr>";
foreach ($flanc_product as $row) {
    $order_amount = number_format($row->order_amount);
    $order_price = number_format($row->order_price);
    $order_multiple = number_format($row->order_multiple);
    echo "
                        <tr>
                            <td> $row->order_time </td>
                            <td>$row->order_seller </td>
                            <td> $row->product_name </td>
                            <td> $order_amount </td>
                            <td> $order_price </td>
                            <td> $order_multiple</td>
                        </tr>";

}
echo "
                    <tr>
                        <td>총합계</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan='4'> $flanc_all_price </td>
                    </tr>
                </table>";

?>