<?php
  foreach($shopInfo as $item){
    if($item->CODE_NM == '팩스번호'){
      $FAX = $item->CODE;
    }else if($item->CODE_NM == '전화번호'){
      $TEL = $item->CODE;
    }else if($item->CODE_NM == '통신판매업신고번호'){
      $EL_CODE = $item->CODE;
    }else if($item->CODE_NM == '사업자등록번호'){
      $SHOP_CODE = $item->CODE;
    }else if($item->CODE_NM == '상점명'){
      $SHOP_NAME = $item->CODE;
    }else if($item->CODE_NM == '대표'){
      $PRESENT = $item->CODE;
    }else if($item->CODE_NM == '주소'){
      $ADDR = $item->CODE;
    }else if($item->CODE_NM == '개인정보관리자'){
      $ADMIN = $item->CODE;
    }
  }
?>
<div class="divFooter">
  <div class="divInfoBox">
    <div class="pc divInfo">
      <table>
        <tr>
          <td class="shopName"><?=$SHOP_NAME?></td>
        </tr>
        <tr>
          <td>대표 <span><?=$PRESENT?></span> 사업자등록번호 : <span><?=$SHOP_CODE?></span></td>
        </tr>
        <tr>
          <td>통신판매업신고 : <span><?=$EL_CODE?></span> 개인정보관리자 <span><?=$ADMIN?></span></td>
        </tr>
        <tr>
          <td><span><?=$ADDR?></span></td>
        </tr>
        <tr>
          <td>전화 : <span><?=$TEL?></span> 팩스 : <span><?=$FAX?></span></td>
        </tr>
      </table>
      <table>
        <tr>
          <td>부산광역시 대표 창업기업 선정</td><td><img src="/static/img/icon/ic_busan.png"><img src="/static/img/icon/ic_changjo.png"></td>
        </tr>
        <tr>
          <td>벤처기업 인증 제 20170108291호</td><td><img src="/static/img/icon/ic_kibo.png"></td>
        </tr>
      </table>
    </div>
    <div class="m divInfo">
      <table>
        <tr>
          <td class="shopName"><?=$SHOP_NAME?></td>
        </tr>
        <tr>
          <td>대표 <span><?=$PRESENT?></span> 사업자등록번호 : <span><?=$SHOP_CODE?></span></td>
        </tr>
        <tr>
          <td>통신판매업신고 : <span>2017-부산북구-0272호</span> </td>
        <tr>
          <td>개인정보관리자 <span><?=$ADMIN?></span></td>
        </tr>
        <tr>
          <td><span><?=$ADDR?></span></td>
        </tr>
        <tr>
          <td>전화 : <span><?=$TEL?></span> 팩스 : <span><?=$FAX?></span></td>
        </tr>
      </table>
      <table>
        <tr>
          <td><img src="/static/img/icon/ic_busan.png"><img src="/static/img/icon/ic_changjo.png"></td>
        </tr>
        <tr>
          <td>부산광역시 대표 창업기업 선정</td>
        </tr>
        <tr>
          <td><img src="/static/img/icon/ic_kibo.png"></td>
        </tr>
        <tr>
          <td>벤처기업 인증 제 20170108291호</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="divCopyright">
    <p>Copyrightⓒ 2017 <span>FLOWER FARM</span>. All right reserved</p>
  </div>
</div>
<script type="text/javascript">
  console.log('전체수행시간 : {elapsed_time}sec');
  console.log('메모리사용량 : {memory_usage}');
</script>
