<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    IMP.init('imp39560047'); // "가맹점 식별코드"
</script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="/static/js/order.js?ver=4"></script>
<section class="order-list-wrapper">
    <h1>주문내역</h1>
    <table class="list-table">
        <thead>
        <tr class="thead">
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
        <tbody>
            <?php
            $amount = 0;
            foreach($order_items as $pid){
                $item = $_SESSION['cart'][$pid];
                $amount += $item['p_price'] * $item['p_qty'];
                ?>
                <tr class="selected-item" data-pid="<?=$pid?>" data-price="<?=$item['p_price']?>" data-name="<?=$item['p_name']?>">
                    <td class="cart-prod-info">
                        <div class="cart-prod-img">
                            <img src="/static/uploads/products/<?=$pid?>_sub.png">
                        </div>
                        <p class="product-name"><?=$item['p_name']?></p>
                    </td>
                    <td>
                        <?=number_format($item['p_price'])?>
                    </td>
                    <td>
                        <?=$item['p_qty']?>
                    </td>
                    <td class="margin-none">
                        <?=number_format($item['p_price'] * $item['p_qty']) ?>
                    </td>
                </tr>
            <?php
                    }
            ?>
            <tr>
                <td class="margin-none" colspan="3">합계</td>
                <td class="margin-none" id="amount" data-amount="<?=$amount?>"><?=number_format($amount)?></td>
            </tr>
        </tbody>
    </table>
</section>
<form id="addr-form">
<section class="addr-wrapper">
    <div class="addr-title">
        <h1>배송지 정보</h1>
        <button type="button" id="add-addr-btn" style="display:none;">배송지 등록/변경</button>
    </div>
        <table class="order-table">
            <thead>
                <tr>
                    <td class="align-center">주문하는 분</td>
                    <td>
                        <input type="text" value="<?=$user->user_name?>" id="user-name">
                    </td>
                    <td class="align-center">휴대폰번호</td>
                    <td class="margin-none">
                        <input type="text" value="<?=$user->user_cellphone?>" id="user-phone">
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="align-center">받으시는 분</td>
                    <td colspan="3" class="margin-none">
                        <div class="align">
                            <input type="text" class="align-item" id="recip-name" name="recipName" value="<?=$addr->recip_name?>" required>
                            <label for="same-as-user" class="align-item"><input type="checkbox" id="same-as-user" class="align-item" <?php if($addr->order_id != NULL){ echo 'checked';} ?>>주문자와 동일</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-center">휴대폰번호</td>
                    <td colspan="3" class="margin-none">
                        <input type="text" id="recip-phone" name="recipPhone" value="<?=$addr->recip_phone?>" required>
                    </td>
                </tr>
                <tr>
                    <td class="align-center">배송지</td>
                    <td colspan="3" class="margin-none">
                        <div>
                            <input id="zipcode" type="text" name="zipcode" placeholder="우편번호 찾기" value="<?=$addr->user_addr_zipcode?>" disabled>
                            <button type="button" class="find-addr" data-valid="<?php if($addr->order_id == NULL){ echo '0';} else{ echo '1'; }?>">우편번호 찾기</button>
                        </div>
                        <div>
                            <input type="text" class="addr" id="addr" placeholder="주소" name="addr" value="<?=$addr->user_addr?>" disabled>
                            <input type="text" class="addr" id="addr_details" placeholder="상세주소" name="addr_details" value="<?=$addr->user_addr_details?>">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="align-center">배송메세지</td>
                    <td colspan="3" class="margin-none">
                        <textarea id=req name="req"><?=$addr->user_req?></textarea>
                    </td>
                </tr>
                <input type="hidden" value="<?php if($addr->order_id == NULL){ echo '0';} else{ echo '1'; }?>" name="check">
            </tbody>
        </table>
</section>
<section class="pay-wrapper">
    <h1>결제수단</h1>
    <div class="pay-box">
        <li>
            <label>
                <input type="radio" name="payment" value="card" required>신용/체크카드
            </label>
        </li>
        <li>
            <label>
                <input type="radio" name="payment" value="trans">실시간 계좌이체
            </label>
        </li>
        <li>
            <label>
                <input type="radio" name="payment" value="deposit">무통장입금
            </label>
        </li>
    </div>
    <div class="cart-order-btn">
        <input type="submit" id="order-submit" value="결제하기">
    </div>
</section>
</form>
