 <section class="prod-wrap content-wrapper">
     <div class="prod-sorting" >
         <li><a class="prod-sorting-std" data-sorting="name">가나다순</a></li>
         <li><a class="prod-sorting-std" data-sorting="popular">인기순</a></li>
         <li><a class="prod-sorting-std" data-sorting="high_price">가격높은순</a></li>
         <li><a class="prod-sorting-std" data-sorting="row_price">가격낮은순</a></li>
     </div>
     <div class="prod-cate-wrap">
         <ul class="prod-cate">
             <input type="hidden" class="cate-info" data-cate="all" data-cate_value="x">
             <li>
                 <ul class="prod-cate-all cate-all" data-cate="all" data-cate_value="x">
                     <p><a>전체</a></p>
                 </ul>
             </li>
             <li>
                 <ul class="prod-cate-class">
                     <p><span data-cate="품목별">품목별</span><i class="fas fa-caret-down"></i></p>
                     <li class="line"><hr></li>
                     <li>베로니카 및 아스틸베</li>
                     <li>프리지아</li>
                     <li>천일홍</li>
                     <li>히야신스(국산)</li>
                     <li>장미</li>
                     <li class="cate-all" data-cate="kind" data-cate_value="9" style="font-weight: bold">수입꽃</li>
                     <li>라넌큐라스</li>
                     <li>스타티스</li>
                     <li>클레마티스</li>
                     <li class="cate-all" data-cate="kind" data-cate_value="3" style="font-weight: bold">리시안</li>
                     <li>스토크</li>
                     <li>다알리아</li>
                     <li>히야신스(수입)</li>
                     <li class="cate-all" data-cate="kind" data-cate_value="4" style="font-weight: bold">국화류</li>
                     <li>알스트로</li>
                     <li>스위트피</li>
                     <li>맨드라미</li>
                     <li>백합류</li>
                     <li>난과식물</li>
                     <li>장미(수입)</li>
                     <li>스카비오사</li>
                     <li>거베라</li>
                     <li>수국</li>
                     <li>카네이션(대륜)</li>
                     <li>작약</li>
                     <li>안개류</li>
                     <li>튤립</li>
                     <li>카네이션(스프레이)</li>
                     <li>글라디오라스</li>
                     <li>계절꽃(국산)</li>
                     <li>카라</li>
                     <li>튤립(수입)</li>
                     <li>델피늄</li>
                 </ul>
             </li>
             <li>
                 <ul class="prod-cate-shape">
                     <p><span data-cate="형태별">형태별</span><i class="fas fa-caret-down"></i></p>
                     <li class="line"><hr></li>
                     <li class="cate-all" data-cate="shape" data-cate_value="line">라인</li>
                     <li class="cate-all" data-cate="shape" data-cate_value="form">폼</li>
                     <li class="cate-all" data-cate="shape" data-cate_value="mass">매스</li>
                     <li class="cate-all" data-cate="shape" data-cate_value="filler">필러</li>
                     <li class="cate-all" data-cate="shape" data-cate_value="green">그린소재</li>
                 </ul>
             </li>
             <li>
                 <ul class="prod-cate-color">
                     <p><span data-cate="색상별">색상별</span><i class="fas fa-caret-down"></i></p>
                     <li class="line"><hr></li>
                     <div>
                         <li class="cate-all" data-cate="color" data-cate_value="red">
                             <div style="background: #ea2828; border-radius: 50% 50%; width: 25px; height: 25px;"></div>
                         </li>
                         <li class="cate-all" data-cate="color" data-cate_value="orange">
                             <div style="background: #ff974a; border-radius: 50% 50%; width: 25px; height: 25px;"></div>
                         </li>
                         <li class="cate-all" data-cate="color" data-cate_value="yellow">
                             <div style="background: #ffe266; border-radius: 50% 50%; width: 25px; height: 25px;"></div>
                         </li>
                         <li class="cate-all" data-cate="color" data-cate_value="green">
                             <div style="background: #a6e041; border-radius: 50% 50%; width: 25px; height: 25px;"></div>
                         </li>
                         <li class="cate-all" data-cate="color" data-cate_value="pink">
                             <div style="background: #ff7171; border-radius: 50% 50%; width: 25px; height: 25px;"></div>
                         </li>
                         <li class="cate-all" data-cate="color" data-cate_value="purple">
                             <div style="background: #ce29a7; border-radius: 50% 50%; width: 25px; height: 25px;"></div>
                         </li>
                         <li class="cate-all" data-cate="color" data-cate_value="blue">
                             <div style="background: #3a53ce; border-radius: 50% 50%; width: 25px; height: 25px;"></div>
                         </li>
                         <li class="cate-all" data-cate="color" data-cate_value="white">
                             <div style="background: #ffffff ; border: #666666 solid 1px; border-radius: 50% 50%; width: 25px; height: 25px;"></div>
                         </li>
                     </div>
                 </ul>
             </li>
         </ul>
     </div>
    <div class="main-prod-list-wrap">
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
    </div>
 </section>
 <script src="/static/js/main.js"></script>


