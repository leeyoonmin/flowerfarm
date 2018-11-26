<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <title>꽃팜 - 관리자페이지</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, minimum-scale=1.0, user-scalable=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="/static/css/reset.css">
    <link rel="stylesheet" href="/static/semantic/semantic.min.css">
    <link rel="stylesheet" href="/static/css/admin/popup/popOrderDetail.css">
    <script src="/static/semantic/semantic.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  </head>
  <body>
    <div class="popup">
      <div class="header">
        <button type="button" name="button">출력</button>
      </div>
      <div class="divTitle">
        <table>
          <tr>
            <td class="engTitle">Detail Order List</td><td class="hanTitle">주문 상세 리스트</td>
          </tr>
        </table>
      </div>

      <div class="box orderInfo">
        <table>
          <tr>
            <td>주문번호[<?=$gridData[0]->ORDER_ID?>]</td><td></td><td></td><td><?=$gridData[0]->ORDER_TIME?></td>
          </tr>
          <tr class="body">
            <td>아이디/고객명</td><td colspan="3"><?=$gridData[0]->USER_ID?>[<?=$gridData[0]->USER_NAME?>]</td>
          </tr>
          <tr class="body">
            <td>주소</td><td colspan="3"><?=$gridData[0]->ADDR?></td>
          </tr>
          <tr class="body">
            <td>전화번호</td><td colspan="3"><?=$gridData[0]->RECIP_PHONE?></td>
          </tr>
        </table>
      </div>

      <div class="box productInfo">
        <table>
          <tr>
            <td>상품정보</td><td colspan="4"></td>
          </tr>
          <tr class="head">
            <td>사진</td><td>상품명</td><td>수량</td><td>상품가격</td><td>구매금액</td>
          </tr>
          <?php
          $TT_PRICE = 0;
            foreach($gridData as $item){
              echo "
                <tr class=\"body\">";
                  if($item->IMG_EXTENSION==""){
                    echo "<td><img src=\"/static/uploads/product/noImage.png\"></td>";
                  }else{
                    echo "<td><img src=\"/static/uploads/product/".$item->PRODUCT_ID.".".$item->IMG_EXTENSION."\"></td>";
                  }
                  echo "
                  <td>".$item->PRODUCT_NAME."</td>
                  <td>".number_format($item->ORDER_AMOUNT)."</td>
                  <td>￦".number_format($item->ORDER_PRICE)."</td>
                  <td>￦".number_format($item->ORDER_AMOUNT*$item->ORDER_PRICE)."</td>
                </tr>
              ";
              $TT_PRICE = $TT_PRICE + $item->ORDER_AMOUNT * $item->ORDER_PRICE;
            }
          ?>
        </table>
      </div>

      <div class="box paymentInfo">
        <table>
          <tr>
            <td>결제정보</td><td></td>
          </tr>
          <tr class="body">
            <td>입금상태</td><td><?php switch($gridData[0]->IS_PAID){ case 0:echo "입금전";break; case 1:echo "입금완료";break;}?></td>
          </tr>
          <tr class="body">
            <td>입금계좌</td><td>OO은행 123-24-4458-4884</td>
          </tr>
          <tr class="body">
            <td>입금예정금액</td><td>￦<?=number_format($TT_PRICE)?></td>
          </tr>
        </table>
      </div>
      <script type="text/javascript">
        $('.header button').click(function(){
          window.print();
        });
      </script>
    </div>
  </body>
</html>
