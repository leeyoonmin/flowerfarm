
<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 8. 20.
 * Time: PM 7:38
 */

echo "         
                    <style>
                    .out-tb{border-collapse: collapse;text-align: center;}
                    .out-tb td{width: 150px;height: 40px;border: 1px solid #bcbcbc;vertical-align: middle;}
                    .out-tb tr:first-child{border-bottom: 1px solid #7d7d7d;height: 30px;background-color: #ededed;}
                    </style>
                    <table class='out-tb'>
                        <tr>
                            <td>거래일</td>
                            <td>거래처</td>
                            <td>품종</td>
                            <td>수량</td>
                            <td>가격</td>
                            <td>총가격</td>
                        </tr>";
$result=0;
foreach ($all_product as $row) {
    $order_amount = number_format($row->order_amount);
    $order_price = number_format($row->order_price);
    $order_multiple = number_format($row->order_multiple);
    $result += $row->order_multiple;
    if($row->is_flanc==1){
        echo "
                            <tr style='background:#ffdddd'>
                                <td> $row->order_time </td>
                                <td> $row->order_seller </td>
                                <td> $row->product_name </td>
                                <td> $order_amount </td>
                                <td> $order_price </td>
                                <td> $order_multiple</td>
                            </tr>";

    }
    if($row->is_flanc==0){
        echo "
                            <tr>
                                <td> $row->order_time </td>
                                <td> $row->order_seller </td>
                                <td> $row->product_name </td>
                                <td> $order_amount </td>
                                <td> $order_price </td>
                                <td> $order_multiple</td>
                            </tr>";
    }

}
$result = number_format($result);
echo "
                        <tr>
                            <td>총합계</td>
                            <td</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>$result</td>
                        </tr>
                      
                    </table>
       
            ";

?>