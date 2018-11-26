      </div>
    </td>
    <td class="divContainerRight">
      <div class="divHeader">
        <h1>Total Count <span>3</span></h1>
      </div>

      <div class="divItemList">

        <?php
          $imgCnt = 800;
          for($c=1;$c<20; $c++){
            echo
            '<div class="item">
              <table>
                <tr>
                  <td class="img">
                    <img src="/static/uploads/product/'.str_pad($imgCnt,6,0,STR_PAD_LEFT).'.jpg">
                  </td>
                  <td class="info">
                    <p class="name">Good Rose</p>
                    <p class="price">￦ 9,000</p>
                  </td>
                  <td class="control">
                    <a href="#">－</a>
                    <span>1</span>
                    <a href="#">＋</a>
                  </td>
                </tr>
              </table>
            </div>';
            $imgCnt++;
          }
        ?>

      </div>

      <div class="divTotal">
        <table>
          <tr>
            <td>Product Price</td><td>￦ 40,500</td>
          </tr>
          <tr>
            <td>Delivery Fee</td><td>￦ 10,000</td>
          </tr>
          <tr>
            <td>Total Price</td><td>￦ 40,500</td>
          </tr>
        </table>
        <input class="btn wd100" type="button" value="BUY!">
      </div>

    </td>
  </tr>
</table>
