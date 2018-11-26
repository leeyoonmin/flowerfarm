<div class="cart-slider">
    <div class="cart-wrap">
        <div class="cart-head">
            <img class="cart-btn" src="/static/img/cart_open.png">
            <img class="cart-btn" src="/static/img/cart_close.png" style="display: none;">
        </div><div class="cart-container">
            <div class="cart-items">
                <ul>
                    <?php if(isset($_SESSION['cart'])){
                        $cart_items = $_SESSION['cart'];
                        $amount = 0;
                        foreach($cart_items as $key => $item){
                            $amount += $item['p_price']*$item['p_qty'];
                            ?>
                            <li data-pid="<?=$key?>" data-price="<?=$item['p_price']?>" data-name="<?=$item['p_name']?>">
                                <div class="cart-img-wrap">
                                    <a href=""><img src="/static/uploads/products/<?=$key?>_sub.png"></a>
                                    <div>
                                        <i class="fas fa-minus cart-plus-minus" data-check="minus" data-after="slide"></i>
                                        <span><?=$item['p_qty']?></span>
                                        <i class="fas fa-plus cart-plus-minus" data-check="plus" data-after="slide"></i>
                                    </div>
                                </div>
                                <p class="item-price"><?=number_format($item['p_qty']*$item['p_price'])?></p>
                            </li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
            <div>
                <table class="cart-amount-tb">
                    <tbody>
                    <tr class="cart-row cart-prod-sum">
                        <th>총금액</th>
                        <td><span><?php if(isset($_SESSION['cart'])) { echo number_format($amount); }else{ echo 0;}?></span> 원</td>
                    </tr>
                    <tr class="cart-row cart-delivery">
                        <th>배송료</th>
                        <td><span>0</span> 원</td>
                    </tr>
                    <tr class="cart-sum">
                        <th>합계</th>
                        <td><span><?php if(isset($_SESSION['cart'])) { echo number_format($amount+0); }else{ echo 0;}?></span> 원</td>
                    </tr>
                    </tbody>
                </table>
                <a class="cart-btn-order" href="/cart">주문하기</a>
            </div>
        </div>
    </div>
</div>