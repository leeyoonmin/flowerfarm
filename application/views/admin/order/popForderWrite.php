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
    <link rel="stylesheet" href="/static/css/admin/popup/popForderWrite.css">
    <script src="/static/semantic/semantic.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  </head>
  <body>
    <div class="popup">
      <div class="header">
        <button type="button" name="button">출력</button>
      </div>
      <table class="title">
        <tr>
          <td colspan="2"><?=date('Y년 m월 d일',time())?></td>
        </tr>
        <tr>
          <td colspan="2">발주서</td>
        </tr>
        <tr>
          <td></td><td>발주자 : 황선민</td>
        </tr>
        <tr>
          <td>E-Mail : sunmin@flanc.co.kr</td>
          <td>수신자 : 이원철, 김우철</td>
        </tr>
      </table>
      <table class="body">
        <tr>
          <td>No</td><td>사진</td><td>상품명</td><td>수량</td><td>단가</td><td>금액</td><td>구매처</td><td>비고</td>
        </tr>
        <?php
          $rowCnt = 1;
          $TT_CNT = 0;
          $TT_PRICE = 0;
          foreach($gridData as $item){
            echo "<tr>
              <td>".$rowCnt."</td>";
              if($item->IMG_EXTENSION==""){
                echo "<td><img src=\"/static/uploads/product/noImage.png\"></td>";
              }else{
                echo "<td><img src=\"/static/uploads/product/".$item->ID.".".$item->IMG_EXTENSION."\"></td>";
              }
              echo "<td>".$item->NAME."</td>
              <td>".number_format($item->QTY)."</td>
              <td class=\"blur\">".number_format($item->PRODUCT_PRICE)."</td>
              <td class=\"blur\">".number_format($item->QTY*$item->PRODUCT_PRICE)."</td>
              <td></td>
              <td></td>
            </tr>";
            $rowCnt++;
            $TT_CNT += $item->QTY;
            $TT_PRICE += ($item->PRODUCT_PRICE*$item->QTY);
          }
        ?>
      </table>
      <table class="sum">
        <tr>
          <td rowspan="3">소계</td><td rowspan="4"><?=$TT_CNT?></td><td style="text-align:left; padding-left:16px">구매금액</td><td class="price">￦</td><td class="blur" style="text-align:left; padding-left:16px"><?=number_format($TT_PRICE)?></td>
        </tr>
        <tr>
          <td style="text-align:left; padding-left:16px">운임비</td><td class="price">￦</td><td style="text-align:left; padding-left:16px"></td>
        </tr>
        <tr>
          <td style="text-align:left; padding-left:16px">총액</td><td class="price">￦</td><td style="text-align:left; padding-left:16px"></td>
        </tr>
      </table>
      <table class="memo">
        <tr>
          <td>메모</td><td><textarea class="inputMemo" name="memo"></textarea></td>
        </tr>
      </table>
    </div>
    <?php
      $getData="";
      foreach($dataArray as $id){
        $getData = $getData.$id;
      }
    ?>
    <form class="forderWriteFrm" action="/admin/forderRequestServ" method="post">
      <input type="hidden" name="IDA" value="<?=$getData?>">
      <input type="hidden" class="MEMO_HD" name="MEMO" value="">
    </form>
    <button class="forderRequestBtn" type="button" name="button">발주신청</button>

    <script type="text/javascript">
      $('.header button').click(function(){
        window.print();
      });
      $('.forderRequestBtn').click(function(){
        $('.MEMO_HD').val($('.memo .inputMemo').val());
        $('.forderWriteFrm').submit();
        //window.opener.location.href="/admin/forderRequestServ?IDA=//$getData&MEMO="+$('.memo .inputMemo').val();
        //window.close();
      });
    </script>
  </body>
</html>
