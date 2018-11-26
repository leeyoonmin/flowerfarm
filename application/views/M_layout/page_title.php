<div class="m divSearchBG2"></div>
<div class="page_title">
  <table>
    <tr class="mobile_url">
      <?php
        switch($page_title){
          case 'mypage' : echo "<td><h2><a href=\"/\">Home</a> > My Page</h2></td></tr><tr><td><h1>My Page</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > My Page</h2></td>"; break;
          case 'cart' : echo "<td><h2><a href=\"/\">Home</a> > Cart</h2></td></tr><tr><td><h1>Cart</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > Cart</h2></td>"; break;
          case 'login' : echo "<td><h2><a href=\"/\">Home</a> > Login</h2></td></tr><tr><td><h1>Login</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > Login</h2></td>"; break;
          case 'join' : echo "<td><h2><a href=\"/\">Home</a> > Join</h2></td></tr><tr><td><h1>Join</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > Join</h2></td>"; break;
          case 'ledger' : echo "<td><h2><a href=\"/\">Home</a> > Ledger</h2></td></tr><tr><td><h1>Ledger</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > Ledger</h2></td>"; break;
          case 'order_info' : echo "<td><h2><a href=\"/\">Home</a> > <a href=\"/mypage\">Mypage</a> > Order Info </h2></td></tr><tr><td><h1>Order Info</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > <a href=\"/mypage\">Mypage</a> > Order Info</h2></td>"; break;
          case 'myInfo' : echo "<td><h2><a href=\"/\">Home</a> > <a href=\"/mypage\">Mypage</a> > My Info </h2></td></tr><tr><td><h1>My Info</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > <a href=\"/mypage\">Mypage</a> > My Info</h2></td>"; break;
          case 'support' : echo "<td><h2><a href=\"/\">Home</a> > <a href=\"/mypage\">Mypage</a> > Support </h2></td></tr><tr><td><h1>Support</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > <a href=\"/mypage\">Mypage</a> > Support</h2></td>"; break;

          case 'mart01' : echo "<td><h2><a href=\"/\">Home</a> > Flower Market</h2></td></tr><tr><td><h1>Flower Market</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > Flower Market</h2></td>"; break;
          case 'market_price' : echo "<td><h2><a href=\"/\">Home</a> > Market Price</h2></td></tr><tr><td><h1>Market Price</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > Market Price</h2></td>"; break;
          case 'order' : echo "<td><h2><a href=\"/\">Home</a> > <a href=\"/menu/orderlist\">Order</a> > Order Info </h2></td></tr><tr><td><h1>Order Info</h1><p>보다 다양하고 신선한 꽃으로 보답하겠습니다</p></td><td><h2><a href=\"/\">Home</a> > Order Info</h2></td>"; break;
        }
      ?>
    </tr>
  </table>
</div>
