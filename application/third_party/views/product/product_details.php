<script src="/static/js/product_details.js"></script>
<?php
$stock = $product->product_amount;
if(isset($_SESSION['is_login'])){
        if($_SESSION['user_type'] == 5){
            $product->price = $price->product_price_r;
        }else{
            $product->price = $price->product_price_w;
        }
    }else{
        $product->price = '로그인후 확인';
    }?>
<div class="prod-details-wrapper content-wrapper">
    <div class="prod-nav">홈 > 도매 > 튤립</div>
    <div class="prod-box">
        <div class="prod-details">
            <div class="prod-img">
                <img src="/static/uploads/products/<?=$product->product_id?>_main.png">
            </div>
            <div class="prod-info">
                <div class="prod-name"><?=$product->product_name?></div>
                <div class="prod-price">단 당 <span><?=number_format($product->price)?></span></div>
                <table>
                    <tr>
                        <td class="prod-col1">배송종류</td>
                        <td class="prod-col2">도매</td>
                    </tr>
                    <tr>
                        <td>생산지</td>
                        <td>경기</td>
                    </tr>
                    <tr>
                        <td colspan="2">구매후기 <span>22</span> 건</td>
                    </tr>
                    <tr>
                        <td>재고</td>
                        <td><span id="prod-stock"><?=number_format($stock)?></span> 단</td>
                    </tr>
                    <tr class="ctrl-prod-amount" data-pid="<?=$product->product_id?>" data-price="<?=$product->price?>" data-name="<?=$product->product_name?>">
                        <td>수량</td>
                        <td>
                            <div>
                                <button type="button" class="amount-minus"><i class="fas fa-minus minus"></i></button>
                                <input type="number" value="1" min="1" max="<?=$product->product_amount - $product->sum_ordered_amount?>" id="details_qty" disabled>
                                <button type="button" class="amount-plus"><i class="fas fa-plus plus"></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>합계</td>
                        <td class="prod-sum"><span><?=number_format($product->price)?></span>원</td>
                    </tr>
                </table>
                <div class="prod-btn-box">
                    <a class="btn-in-cart">장바구니</a>
                    <a href="/cart" class="btn-order">구매하기</a>
                </div>
            </div>
        </div>
        <div class="sub-photo-box">
            <img class="sub-photo" src="/static/uploads/products/<?=$product->product_id?>_main.png" onerror="this.src='/static/uploads/products/spare.png'">
            <img class="sub-photo" src="/static/uploads/products/<?=$product->product_id?>_sub.png" onerror="this.src='/static/uploads/products/spare.png'">
            <img class="sub-photo" src="/static/uploads/products/<?=$product->product_id?>_extra.png" onerror="this.src='/static/uploads/products/spare.png'">
            <img class="sub-photo" src="/static/uploads/products/<?=$product->product_id?>_extra1.png" onerror="this.src='/static/uploads/products/spare.png'">
            <img class="sub-photo" src="/static/uploads/products/<?=$product->product_id?>_extra2.png" onerror="this.src='/static/uploads/products/spare.png'">
        </div>
    </div>
    <div class="review-wrap">
        <p>구매후기</p>
        <table class="review-table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>만족도</th>
                    <th>내용</th>
                    <th>작성자</th>
                    <th>작성일</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width:82px;">1</td>
                    <td style="width:150px;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </td>
                    <td style="width:483px;">마음에 들어</td>
                    <td style="width:135px;">user1</td>
                    <td style="width:140px;">2018-07-25</td>
                </tr>
                <tr>
                    <td style="width:82px;">1</td>
                    <td style="width:150px;">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </td>
                    <td style="width:483px;">마음에 들어</td>
                    <td style="width:135px;">user1</td>
                    <td style="width:140px;">2018-07-25</td>
                </tr>
            </tbody>
        </table>
        <div class="review-pagination">
            <div><i class="fas fa-chevron-left"></i></div>
            <div>1</div>
            <div>2</div>
            <div>3</div>
            <div>4</div>
            <div>5</div>
            <div><i class="fas fa-chevron-right"></i></div>
        </div>
    </div>
</div>