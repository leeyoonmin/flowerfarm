<ul class="prod-list">
    <?php
    foreach($products as $product){
        $stock = $product->product_amount;

        if(isset($_SESSION['is_login'])){
            if($_SESSION['user_type'] == 5){
                $product->price = $product->product_price_r;
            }else{
                $product->price = $product->product_price_w;}
        }else {
            $product->price = 'x';
        }
        ?>
        <li class="prod-item" data-pid="<?=$product->product_id?>" data-price="<?=$product->price?>"
            data-name="<?=$product->product_name?>">
            <div class="img-box">
                <a href="/product/details/<?=$product->product_id?>">
                    <div class="main-box">
                        <div class="back">
                            <img src="/static/uploads/products/<?=$product->product_id?>_sub.png">
                            <?php
                            if(isset($_SESSION['is_login'])){
                                ?>
                                <div class="btn-box">
                                    <button class="<?php if($stock == 0){echo "out-of-stock";}else{ echo "cart-plus-minus";}?>" data-check="minus" data-after="main"><i class="fas fa-minus fa-lg"></i></button><button class="<?php if($stock == 0){echo "out-of-stock";}else{ echo "cart-plus-minus";}?>" data-check="plus" data-after="main"><i class="fas fa-plus fa-lg"></i></button>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="front">
                            <img src="/static/uploads/products/<?=$product->product_id?>_main.png">
                        </div>
                    </div>
                    <div class="tag-box"></div>
                </a>
            </div>
            <div class="info-box">
                <div class="info-top">
                    <div class="prod-name"><a href="/product/details/<?=$product->product_id?>"><?=$product->product_name?></a></div>
                    <div class="price pull-right"><?php if($product->price == 'x'){ echo '<a>로그인후 확인</a>';}else{ echo number_format($product->price); }?></div>
                    <div class="stock pull-right"><?php if($stock == 0){echo "품절";}else{ echo "재고 ".number_format($stock);}?></div>
                </div>
                <div class="info-bottom">
                    <span>무료배송</span>
                </div>
            </div>
        </li>
        <?php
    }
    ?>
</ul>