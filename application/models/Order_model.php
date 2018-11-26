<?php
class Order_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
  function insertOrder($hashMap){
    $sql = "
    SELECT
    	CASE WHEN USER_ID IS NULL THEN 1 ELSE MAX(ORDER_INDEX)+1 END AS ORDER_IDX
    	FROM ORDER_TB
    	WHERE USER_ID='".$hashMap['user_id']."'
    ";
    $order_idx = $this->db->query($sql)->row()->ORDER_IDX;
    $sql = "
      INSERT INTO ORDER_TB(USER_ID, ORDER_ID, ORDER_TIME,PAY_TYPE, ORDER_INDEX, DELIVERY_TYPE, DELIVERY_DATE)
      VALUES(
          '".$hashMap['user_id']."'
        , '".$hashMap['order_id']."'
        , NOW()+0
        , '".$hashMap['pay_type']."'
        , '".$order_idx."'
        , '".$hashMap['delivery_method']."'
        , '".$hashMap['delivery_date']."'
        )
    ";
    return $this->db->query($sql);
  }

  function insertOrderAddr($hashMap){
    $sql = "
      INSERT INTO USER_ADDRESS_TB(ORDER_ID, USER_ID, RECIP_POSTCODE, RECIP_ADDR, RECIP_ADDR_DETAILS, REQ_MSG, RECIP_NAME, RECIP_TEL_H, RECIP_TEL_B, RECIP_TEL_T)
      VALUES(
          '".$hashMap['order_id']."'
        , '".$hashMap['user_id']."'
        , '".$hashMap['postcode']."'
        , '".$hashMap['addr']."'
        , '".$hashMap['detail_addr']."'
        , '".$hashMap['req_msg']."'
        , '".$hashMap['order_name']."'
        , '".$hashMap['tel1']."'
        , '".$hashMap['tel2']."'
        , '".$hashMap['tel3']."'
        )
    ";
    return $this->db->query($sql);
  }

  function insertOrderItem($hashMap){
    $sql = "
      INSERT INTO ORDER_ITEM_TB(ORDER_ID, PRODUCT_ID, ORDER_AMOUNT, ORDER_PRICE)
      VALUES(
          '".$hashMap['order_id']."'
        , '".$hashMap['product_id']."'
        , '".$hashMap['order_amount']."'
        , '".$hashMap['order_price']."'
        )
    ";
    return $this->db->query($sql);
  }

  function getOrderListByID($id,$getData){

    $sql = "
    SELECT
        A.ORDER_ID
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '결제방법' AND CODE = A.PAY_TYPE) AS PAY_TYPE
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '배송방법' AND CODE = A.DELIVERY_TYPE) AS DELIVERY_TYPE
	    , (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '배송방법' AND CODE = A.DELIVERY_TYPE)) AS DELIVERY_FEE
      , DELIVERY_DATE
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '주문진행상태' AND CODE = A.ORDER_STAT) AS ORDER_STAT
      , IS_PAID
      , IS_FORDER
      , CONCAT(SUBSTR(ORDER_TIME,1,4),'-',SUBSTR(ORDER_TIME,5,2),'-',SUBSTR(ORDER_TIME,7,2)) AS ORDER_DATE
      , CONCAT((SELECT PRODUCT_NAME FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID),' 외 ',COUNT(1),'종') AS PRODUCT_NM
      , SUM(ORDER_AMOUNT * ORDER_PRICE) AS SUM_PRICE
      FROM ORDER_TB A
         , ORDER_ITEM_TB B
      WHERE A.ORDER_ID = B.ORDER_ID
       AND A.USER_ID = '".$id."'
       AND A.ORDER_STAT <> '99'

    ";
    if(empty($getData)){
      $timestamp = strtotime("-1 week");
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
      ";
    }else if($getData['period']=="all"){
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '00000000' AND '".date("Ymd", time())."'
      ";
    }else if($getData['period']=="1week"){
      $timestamp = strtotime("-1 week");
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
      ";
    }else if($getData['period']=="1month"){
      $timestamp = strtotime("-1 month");
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
      ";
    }else if($getData['period']=="6month"){
      $timestamp = strtotime("-6 month");
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
      ";
    }

    $sql = $sql."
      GROUP BY ORDER_ID
      ORDER BY ORDER_TIME DESC
    ";
    return $this->db->query($sql)->result();
  }

  function getCancleListByID($id,$getData){

    $sql = "
    SELECT
        A.ORDER_ID
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '결제방법' AND CODE = A.PAY_TYPE) AS PAY_TYPE
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '배송방법' AND CODE = A.DELIVERY_TYPE) AS DELIVERY_TYPE
	    , (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '배송방법' AND CODE = A.DELIVERY_TYPE)) AS DELIVERY_FEE
      , DELIVERY_DATE
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '주문진행상태' AND CODE = A.ORDER_STAT) AS ORDER_STAT
      , IS_PAID
      , IS_FORDER
      , CONCAT(SUBSTR(ORDER_TIME,1,4),'-',SUBSTR(ORDER_TIME,5,2),'-',SUBSTR(ORDER_TIME,7,2)) AS ORDER_DATE
      , CONCAT((SELECT PRODUCT_NAME FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID),' 외 ',COUNT(1),'종') AS PRODUCT_NM
      , SUM(ORDER_AMOUNT * ORDER_PRICE) AS SUM_PRICE
      FROM ORDER_TB A
         , ORDER_ITEM_TB B
      WHERE A.ORDER_ID = B.ORDER_ID
       AND A.USER_ID = '".$id."'
       AND A.ORDER_STAT = '99'

    ";
    if(empty($getData)){
      $timestamp = strtotime("-1 week");
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
      ";
    }else if($getData['period']=="all"){
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '00000000' AND '".date("Ymd", time())."'
      ";
    }else if($getData['period']=="1week"){
      $timestamp = strtotime("-1 week");
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
      ";
    }else if($getData['period']=="1month"){
      $timestamp = strtotime("-1 month");
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
      ";
    }else if($getData['period']=="6month"){
      $timestamp = strtotime("-6 month");
      $sql = $sql."
        AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
      ";
    }

    $sql = $sql."
      GROUP BY ORDER_ID
      ORDER BY ORDER_TIME DESC
    ";
    return $this->db->query($sql)->result();
  }

  function getForderStatByOrderID($orderID){
    $sql = "
    SELECT
      IS_FORDER
      FROM ORDER_TB
      WHERE ORDER_ID = '".$orderID."'
    ";
    return $this->db->query($sql)->row();
  }

  function orderCancel($orderID){
    $sql = "
    UPDATE ORDER_TB
    SET ORDER_STAT = '99'
    WHERE ORDER_ID = '".$orderID."'
    ";
    return $this->db->query($sql);
  }

  function getOrderDetailByID($id){
    $sql = "
    SELECT
          A.ORDER_ID
        , A.ORDER_TIME
        , A.IS_PAID
        , A.PAY_TYPE
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV='결제방법' AND CODE=A.PAY_TYPE) AS PAY_TYPE_NM
        , A.DELIVERY_TYPE
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV='배송방법' AND CODE=A.DELIVERY_TYPE) AS DELIVERY_TYPE_NM
        , (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV='배송비' AND CODE_NM=(SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV='배송방법' AND CODE=A.DELIVERY_TYPE)) AS DELIVERY_FEE
        , A.DELIVERY_DATE
        , A.ORDER_STAT
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV='주문진행상태' AND CODE=A.ORDER_STAT) AS ORDER_STAT_NM
        , A.IS_FORDER
        , B.PRODUCT_ID
        , (SELECT PRODUCT_NAME FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID) AS PRODUCT_NAME
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '상품상세구분코드' AND CODE = (SELECT PRODUCT_CATE_KIND FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID)) AS PRODUCT_CATE
        , (SELECT IMG_EXTENSION FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID) AS IMG_EXTENSION
        , B.ORDER_AMOUNT
        , B.ORDER_PRICE
        , C.USER_ID
        , C.RECIP_NAME
        , CONCAT('(',C.RECIP_POSTCODE,') ',C.RECIP_ADDR,' ',C.RECIP_ADDR_DETAILS) AS RECIP_ADDR
        , C.REQ_MSG
        , CONCAT(C.RECIP_TEL_H,'-',C.RECIP_TEL_B,'-',C.RECIP_TEL_T) AS RECIP_TEL
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
           , USER_ADDRESS_TB C
        WHERE A.ORDER_ID = B.ORDER_ID
         AND A.ORDER_ID = '".$id."'
         AND A.ORDER_ID = C.ORDER_ID
    ";
    return $this->db->query($sql)->result();
  }

  function getPaymentInfo(){
    $sql = "
      SELECT CODE_NM , CODE FROM COMMON_CODE_TB WHERE WORK_DV = '상점정보' AND CODE_DV = '결제정보'
    ";
    return $this->db->query($sql)->result();
  }


}
