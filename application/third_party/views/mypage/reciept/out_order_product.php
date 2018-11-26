
<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 8. 20.
 * Time: PM 6:17
 */


$baseURL=base_url();

echo "          <div class='out_order_wrap'>  
                <label for='selectAll'><input type='checkbox' class='selectAll' id='selectAll' onclick='selectAll()'>
                    전체선택</label>
                <input type='button' class='deleteBtn' name='del' value='삭제'>
                
                    <table class='out-tb'>
                        <tr>
                            <td></td>
                            <td>거래일</td>
                            <td>거래처</td>
                            <td>품종</td>
                            <td>수량</td>
                            <td>가격</td>
                            <td>총가격</td>
                            <td></td>
                        </tr>";

foreach ($outOrder_product as $row) {
    $order_amount = number_format($row->order_amount);
    $order_price = number_format($row->order_price);
    $order_multiple = number_format($row->order_multiple);
    echo "
                            <tr>
                                <td class='align-left'>
                                    <input type='checkbox' name='chk' value='$row->out_order_id'>
                                </td>
                                <td> $row->order_time </td>
                                <td> $row->order_seller </td>
                                <td> $row->product_name </td>
                                <td> $order_amount </td>
                                <td> $order_price </td>
                                <td> $order_multiple</td>
                                <td></td>
                            </tr>";
}
echo "
                        <tr>
                            <td></td>
                            <td>총합계</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> $out_all_price </td>
                            <td></td>
                        </tr>
                        <tr>
                            <form id='out_order' name='out_order' method='post'>
                                <td></td>
                                <td><input class='inputBox' name='day' id='day' placeholder='입력하세요' type='text'></td>
                                <td><input class='inputBox' name='seller' id='seller' placeholder='입력하세요' type='text'></td>
                                <td><input class='inputBox' name='product_name' id='product_name' placeholder='입력하세요' type='text'> </td>
                                <td><input class='inputBox' name='amount' id='amount' placeholder='입력하세요' type='text'></td>
                                <td><input class='inputBox' name='price' id='price' placeholder='입력하세요' type='text'></td>
                                <td><input type='button' class='inputBtn' name='inp' value='입력'></td>
                                <td></td>
                            </form>
                        </tr>
                    </table>
                
                
                <form method='post' action='$baseURL/reciept/action/$start'>
                    <input type='submit' name='export' value='엑셀파일받기'/>
                </form>
                <input type='submit' class='all_product' value='전체영수증보기'/>
                
                </div>
                ";
?>