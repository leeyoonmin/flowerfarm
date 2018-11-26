<div class="wrap">
  <div class="divTitle">
    <div class="title">
      주문정보입력
    </div>
    <div class="link">
      #배송지선택
    </div>
  </div>
  <form class="orderFrm" action="/order/orderPrc" method="post">

  <div class="divWriteOrderInfo">
    <table>
      <tr>
        <td class="head">주문자명</td>
        <td>
          <input id="name" type="text" name="name" placeholder="주문자명" value="<?php if($user->user_name !=""){echo $user->user_name;}?>">
        </td>
      </tr>
      <tr>
        <td class="head" rowspan="3">주소</td>
        <td>
          <input id="postcode" type="text" name="postcode" placeholder="우편번호" value="<?php if(!empty($addr)){if($addr->RECIP_POSTCODE !=""){echo $addr->RECIP_POSTCODE;}}?>"><input id="postcode_btn" type="button" value="검색" onclick="searchPostcode()">
        </td>
      </tr>
      <tr>
        <td><input id="address" type="text" name="addr" placeholder="주소" value="<?php if(!empty($addr)){if($addr->RECIP_ADDR !=""){echo $addr->RECIP_ADDR;}}?>"></td>
      </tr>
      <tr>
        <td><input id="detail_addr" type="text" name="detail_address" placeholder="상세주소" value="<?php if(!empty($addr)){if($addr->RECIP_ADDR_DETAILS !=""){echo $addr->RECIP_ADDR_DETAILS;}}?>"></td>
      </tr>
      <tr>
        <td class="head">전화번호</td>
        <td>
          <select id="sel_tel1" name="tel1">
            <option value="010" <?php if(!empty($addr)){if($addr->RECIP_TEL_H=='010'){echo "selected";}}?>>010</option>
            <option value="011" <?php if(!empty($addr)){if($addr->RECIP_TEL_H=='011'){echo "selected";}}?>>011</option>
            <option value="016" <?php if(!empty($addr)){if($addr->RECIP_TEL_H=='016'){echo "selected";}}?>>016</option>
            <option value="017" <?php if(!empty($addr)){if($addr->RECIP_TEL_H=='017'){echo "selected";}}?>>017</option>
            <option value="018" <?php if(!empty($addr)){if($addr->RECIP_TEL_H=='018'){echo "selected";}}?>>018</option>
            <option value="019" <?php if(!empty($addr)){if($addr->RECIP_TEL_H=='019'){echo "selected";}}?>>019</option>
          </select>
          －<input type="tel" id="tel2" name="tel2" maxlength="4" value="<?php if(!empty($addr)){if($addr->RECIP_TEL_B !=""){echo $addr->RECIP_TEL_B;}}?>">
          －<input type="tel" id="tel3" name="tel3" maxlength="4" value="<?php if(!empty($addr)){if($addr->RECIP_TEL_T !=""){echo $addr->RECIP_TEL_T;}}?>">
        </td>
      </tr>
      <tr>
        <td class="head">요청사항</td>
        <td>
          <input id="req_msg" type="text" name="req_msg" placeholder="요청사항" value="<?php if(!empty($addr)){if($addr->REQ_MSG !=""){echo $addr->REQ_MSG;}}?>">
        </td>
      </tr>
    </table>
    <input type="hidden" name="deliveryMethod" value="<?=$getData['method']?>">
    <input type="hidden" name="deliveryDate" value="<?=$getData['date']?>">
  </div>
  <div class="divTitle">
    <div class="title">
      결제정보
    </div>
  </div>
  <?php
  $paymentPrice = $this->cart->total() + $getData['deliveryFee'];
  $bankName;
  $AccountHolder;
  $bankAccount;
  foreach($shopData as $item){
    if($item->CODE_NM == "입금은행"){
      $bankName = $item->CODE;
    }else if($item->CODE_NM == "예금주명"){
      $AccountHolder = $item->CODE;
    }if($item->CODE_NM == "입금계좌"){
      $bankAccount = $item->CODE;
    }
  }
  ?>
  <div class="divPaymentInfo">
    <table>
      <tr>
        <td class="head">결제방법</td><td>무통장입금</td>
      </tr>
      <tr>
        <td class="head">입금은행</td><td><?=$bankName?></td>
      </tr>
      <tr>
        <td class="head">예금주</td><td><?=$AccountHolder?></td>
      </tr>
      <tr>
        <td class="head">계좌번호</td><td><?=$bankAccount?></td>
      </tr>
      <tr>
        <td class="head">입금금액</td><td><?=number_format($paymentPrice)?> 원</td>
      </tr>
    </table>
  </div>
    <input type="hidden" name="payType" value="01">
    <input class="orderBtn" type="submit" value="주문완료">
  </form>
</div>

<div class="divOrderAddrPopup shadow_2">
  <div class="divAddrList">
  </div>
  <input class="submitBtn" type="button" value="기본배송지 선택">
  <div class="ui active dimmer inverted  divLoader addrPopupLoader">
    <div class="ui text small loader">로딩중..</div>
  </div>
</div>
<div class="divOrderAddrPopupBG"></div>

<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
<div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:3" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>
<script src="/static/js/M/daum_postcode.js"></script>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
