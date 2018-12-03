<div class="wrap main">

  <div class="pc divSlideBanner banner1">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php
          foreach($slideBanner1 as $slide){
            echo "<div class=\"swiper-slide\"><a href=\"".$slide->CODE."\"><img src=\"/static/img/slide/".$slide->CODE."\"></a></div>";
          }
        ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>

  <div class="m divSlideBanner banner2">
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <?php
          foreach($slideBanner2 as $slide){
            echo "<div class=\"swiper-slide\"><img src=\"/static/img/slide/".$slide->CODE."\"></div>";
          }
        ?>
      </div>
    </div>
  </div>

  <div class="pc divMainVideoBanner">
    <div class="divVideo">
      <table>
        <tr>
          <td>
            <video class="" muted="" autoplay="" playsinline="" loop="loop">
              <source src="/static/video/mainBannerVideo.mp4" type="video/mp4">
            </video>
          </td>
          <td>
            <h1><span>꽃팜</span> 홍보영상</h1>
            <p>동해물과 백두산이 마르고 닳도록</p>
            <p>하느님이 보우사하 <span>우리나라</span> 만세</p>
            <p>무궁화 삼천리 화려강산</p>
            <p><span>대한</span>사람 대한으로 길이 보전하세</p>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="m divMainVideoBanner">
    <div class="divVideo">
      <table>
        <tr>
          <td><h1><span class="strong1">꽃팜</span> 홍보영상</h1></td>
        </tr>
        <tr>
          <td>
            <video class="" muted="" autoplay="" playsinline="" loop="loop">
              <source src="/static/video/mainBannerVideo.mp4" type="video/mp4">
            </video>
          </td>
        </tr>
        <tr>
          <td>
            <p>동해물과 백두산이 마르고 닳도록</p>
            <p>하느님이 보우사하 <span class="strong1">우리나라</span> 만세</p>
            <p>무궁화 삼천리 화려강산</p>
            <p><span class="strong1">대한</span>사람 대한으로 길이 보전하세</p>
          </td>
        </tr>
      </table>
    </div>
  </div>

  <div class="divProductBanner">

  <div class="divNewProduct">
    <h1 class="title">신상품<span>NEW</span></h1>
    <?php
      foreach($newList as $item){
        echo "<a href=\"/M_menu/productList/01?option=new\"><div class=\"divItem\">";
        if($item->IMG_EXTENSION == NULL){
          echo "<img src=\"/static/uploads/product/noImage.png\">";
        }else{
          echo "<img src=\"/static/uploads/product/".$item->PRODUCT_ID.".".$item->IMG_EXTENSION."\">";
        }
        echo "<div class=\"divInfo\">
            <p>".$item->PRODUCT_CATE_KIND_NM."</p>
            <p>".$item->PRODUCT_NAME."</p>
          </div>
        </div></a>";
      }
    ?>
  </div>

  <div class="divNewProduct">
    <h1 class="title">추천상품<span>RECOMMAND</span></h1>
    <?php
      foreach($recommand as $item){
        echo "<a href=\"/M_menu/productList/01?option=recommand\"><div class=\"divItem\">";
        if($item->IMG_EXTENSION == NULL){
          echo "<img src=\"/static/uploads/product/noImage.png\">";
        }else{
          echo "<img src=\"/static/uploads/product/".$item->PRODUCT_ID.".".$item->IMG_EXTENSION."\">";
        }
        echo "<div class=\"divInfo\">
            <p>".$item->PRODUCT_CATE_KIND_NM."</p>
            <p>".$item->PRODUCT_NAME."</p>
          </div>
        </div></a>";
      }
    ?>
  </div>

  <div class="divNewProduct">
    <h1 class="title">베스트 10<span>BEST</span></h1>
    <?php
      foreach($bestSeller as $item){
        echo "<a href=\"/M_menu/productList/01?option=best\"><div class=\"divItem\">";
        if($item->IMG_EXTENSION == NULL){
          echo "<img src=\"/static/uploads/product/noImage.png\">";
        }else{
          echo "<img src=\"/static/uploads/product/".$item->PRODUCT_ID.".".$item->IMG_EXTENSION."\">";
        }
        echo "<div class=\"divInfo\">
            <p>".$item->PRODUCT_CATE_KIND_NM."</p>
            <p>".$item->PRODUCT_NAME."</p>
          </div>
        </div></a>";
      }
    ?>
  </div>

  </div>

  <!-- Swiper JS -->
  <script src="/static/swiper/swiper.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var viewCnt;
    if(document.body.scrollWidth < 1025){
      viewCnt = 3;
    }else{
      viewCnt = 5;
    }
    var swiper1 = new Swiper('.banner1 .swiper-container', {
      loop: true,
      pagination: {
        el: '.swiper-pagination'
      },
      autoplay: {
        delay: 10000,
        disableOnInteraction: false,
      },
    });
    var swiper2 = new Swiper('.banner2 .swiper-container', {
      loop: true,
      pagination: {
        el: '.swiper-pagination'
      },
      autoplay: {
        delay: 10000,
        disableOnInteraction: false,
      },
    });
  </script>
  <!--div class="divMainVideo">
      <video autoplay loop>
        <source src="/static/video/main_banner_video.mp4" type="video/mp4">
      </video>
      <input id="checkPopup1" type="checkbox"><label for="checkPopup1">일주일간 보지 않기</label><input class="closeBtn" type="button" value="닫기">
  </div-->
</div>
