<script src="/static/js/shopping_cart.js"></script>
<section class="cart-page-wrapper content-wrapper">
    <h1>장바구니</h1>
    <table class="cart-table">
        <thead>
            <tr class="thead">
                <td class="margin-none">
                    <input id="check-all" class="item-select" type="checkbox" checked>
                </td>
                <td>
                    상품명
                </td>
                <td>
                    가격
                </td>
                <td>
                    수량
                </td>
                <td class="margin-none">
                    주문금액
                </td>
            </tr>
        </thead>
        <form method="post" action="/product/order">
        <tbody>
            <?php
            $amount = 0;
            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $key => $item){
                    $amount += $item['p_price'] * $item['p_qty'];
            ?>
            <tr data-pid="<?=$key?>" data-price="<?=$item['p_price']?>" data-name="<?=$item['p_name']?>">
                <td class="margin-none">
                    <input class="item-select" name="pids[]" value="<?=$key?>" type="checkbox" checked>
                </td>
                <td class="cart-prod-info">
                    <div class="cart-prod-img">
                        <img src="/static/uploads/products/<?=$key?>_sub.png">
                    </div>
                    <p><?=$item['p_name']?></p>
                </td>
                <td>
                    <?=number_format($item['p_price'])?>
                </td>
                <td>
                    <div class="cart-qty-box">
                        <div class="qty-box">
                            <input type="text" value="<?=$item['p_qty']?>">
                        </div>
                        <div class="cart-btn-box">
                            <button class="cart-plus-minus-tb" data-check="plus" data-after="cart" type="button"><i class="fas fa-sort-up"></i></button>
                            <button class="cart-plus-minus-tb" data-check="minus" data-after="cart" type="button"><i class="fas fa-sort-down"></i></button>
                        </div>
                    </div>
                </td>
                <td class="margin-none">
                    <?= number_format($item['p_price'] * $item['p_qty']) ?>
                </td>
            </tr>
            <?php
                }
            }else{
            ?>
            <tr><td class="margin-none" colspan="5">장바구니에 담긴 상품이 없습니다.</td></tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <div class="amount-info-box">
        <div>
            <p>주문하기</p>
            <p class="cart-order-amount"><span><?=number_format($amount)?></span>원</p>
        </div>
        <div>
            <i class="fas fa-plus"></i>
        </div>
        <div>
            <p>배송비</p>
            <p class="cart-fare-amount" data-fare="0">0원</p>
        </div>
        <div>
            <i class="fas fa-equals"></i>
        </div>
        <div>
            <p>결제금액</p>
            <p class="cart-sum-amount"><span><?=number_format($amount)?></span>원</p>
        </div>
    </div>
    <?php if(isset($_SESSION['cart'])){
            if(sizeof($_SESSION['cart'])){
    ?>
            <div class="cart-order-btn">
                <input type="submit" id="cart-submit" value="주문하기">
            </div>
    <?php
            }
        }
    ?>
    </form>
</section>
