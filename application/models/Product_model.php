<?php
class Product_model extends CI_Model {

    function __construct() {
        $this->load->helper('custlog');
        parent::__construct();
    }

    function getDisplayProductList($hashMap,$type){
      $sql = "
      SELECT
          A.PRODUCT_ID
        , A.PRODUCT_NAME
        , A.IMG_EXTENSION
        , A.PRODUCT_CATE_AREA
        , A.PRODUCT_CATE_KIND
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '상품정보' AND CODE_DV = '상품상세구분코드' AND CODE = A.PRODUCT_CATE_KIND) AS PRODUCT_CATE_KIND_NM
        , A.PRODUCT_CATE_SHAPE
        , A.PRODUCT_CATE_COLOR
        , A.PRODUCT_AMOUNT
        , B.PRODUCT_PRICE_CUNSUMER
        , B.PRODUCT_PRICE_WHOLESALE
        , CASE WHEN C.ORDER_AMOUNT IS NULL THEN 0 ELSE C.ORDER_AMOUNT END AS ORDER_AMOUNT
        FROM PRODUCT_TB A
          , (
              SELECT
                  BB.PRODUCT_ID
                , BB.PRODUCT_TIME
                , BB.PRODUCT_PRICE_CUNSUMER
                , BB.PRODUCT_PRICE_WHOLESALE
                FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                        FROM PRODUCT_PRICE_TB
                      GROUP BY PRODUCT_ID
                     ) AA
                  , PRODUCT_PRICE_TB BB
               WHERE AA.PRODUCT_ID = BB.PRODUCT_ID
                 AND AA.PRODUCT_TIME = BB.PRODUCT_TIME
               ) B LEFT JOIN (
             SELECT
              product_id
             , sum(order_amount) AS ORDER_AMOUNT
               FROM ORDER_ITEM_TB
             GROUP BY product_id
            ) C ON B.PRODUCT_ID = C.PRODUCT_ID
        WHERE A.PRODUCT_ID = B.PRODUCT_ID
         AND A.IS_SELL = 'Y'
         AND A.IS_DISPLAY = 'Y'
      ";
      if($type != '00'){
        $sql = $sql."
          AND A.PRODUCT_TYPE = '".$type."'
        ";
      }
      if(!empty($hashMap['kind'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_KIND = '".$hashMap['kind']."'
        ";
      }
      if(!empty($hashMap['area'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_AREA = '".$hashMap['area']."'
        ";
      }
      if(!empty($hashMap['shape'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_SHAPE = '".$hashMap['shape']."'
        ";
      }
      if(!empty($hashMap['color'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_COLOR = '".$hashMap['color']."'
        ";
      }
      if(!empty($hashMap['keyword'])){
        $sql = $sql."
          AND A.PRODUCT_NAME LIKE '%".$hashMap['keyword']."%'
        ";
      }
      if($hashMap['is_img'] == 'true'){
        $sql = $sql."
          AND A.IMG_EXTENSION IS NOT NULL
        ";
      }
      if(!empty($hashMap['option'])){
        if($hashMap['option'] == 'new'){
          $sql = $sql."
            AND A.IS_NEW = 'Y'
          ";
        }
        if($hashMap['option'] == 'recommand'){
          $sql = $sql."
            AND A.IS_RECOMMAND = 'Y'
          ";
        }
      }

      if(empty($hashMap['orderBy'])){
        if(!empty($hashMap['option'])){
          if($hashMap['option'] == 'best'){
            $sql = $sql."
              ORDER BY C.ORDER_AMOUNT DESC
            ";
          }
        }else{
          $sql = $sql."
          ORDER BY A.PRODUCT_NAME
          ";
        }

      }else if($hashMap['orderBy'] == "alphabet"){
        $sql = $sql."
          ORDER BY A.PRODUCT_NAME
        ";
      }else if($hashMap['orderBy'] == "highPrice"){
        $sql = $sql."
          ORDER BY B.PRODUCT_PRICE_CUNSUMER DESC
        ";
      }else if($hashMap['orderBy'] == "lowPrice"){
        $sql = $sql."
          ORDER BY B.PRODUCT_PRICE_CUNSUMER
        ";
      }else if($hashMap['orderBy'] == "popular"){
        $sql = $sql."
          ORDER BY C.ORDER_AMOUNT DESC
        ";
      }
      $sql = $sql."
        limit ".(($hashMap['page']*20)-20).",20
      ";
      $result = $this->db->query($sql)->result();
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result);
      return $result;
    }

    function getDisplayProductCount($hashMap,$type){
      $sql = "
      SELECT
          A.PRODUCT_ID
        , A.PRODUCT_NAME
        , A.IMG_EXTENSION
        , A.PRODUCT_CATE_KIND
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '상품정보' AND CODE_DV = '상품상세구분코드' AND CODE = A.PRODUCT_CATE_KIND) AS PRODUCT_CATE_KIND_NM
        , A.PRODUCT_CATE_SHAPE
        , A.PRODUCT_CATE_COLOR
        , A.PRODUCT_AMOUNT
        , B.PRODUCT_PRICE_CUNSUMER
        , B.PRODUCT_PRICE_WHOLESALE
        , CASE WHEN C.ORDER_AMOUNT IS NULL THEN 0 ELSE C.ORDER_AMOUNT END AS ORDER_AMOUNT
        FROM PRODUCT_TB A
          , (
              SELECT
                  BB.PRODUCT_ID
                , BB.PRODUCT_TIME
                , BB.PRODUCT_PRICE_CUNSUMER
                , BB.PRODUCT_PRICE_WHOLESALE
                FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                        FROM PRODUCT_PRICE_TB
                      GROUP BY PRODUCT_ID
                     ) AA
                  , PRODUCT_PRICE_TB BB
               WHERE AA.PRODUCT_ID = BB.PRODUCT_ID
                 AND AA.PRODUCT_TIME = BB.PRODUCT_TIME
               ) B LEFT JOIN (
             SELECT
              product_id
             , sum(order_amount) AS ORDER_AMOUNT
               FROM ORDER_ITEM_TB
             GROUP BY product_id
            ) C ON B.PRODUCT_ID = C.PRODUCT_ID
        WHERE A.PRODUCT_ID = B.PRODUCT_ID
         AND A.IS_SELL = 'Y'
         AND A.IS_DISPLAY = 'Y'
      ";
      if($type != '00'){
        $sql = $sql."
          AND A.PRODUCT_TYPE = '".$type."'
        ";
      }
      if(!empty($hashMap['kind'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_KIND = '".$hashMap['kind']."'
        ";
      }
      if(!empty($hashMap['shape'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_SHAPE = '".$hashMap['shape']."'
        ";
      }
      if(!empty($hashMap['area'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_AREA = '".$hashMap['area']."'
        ";
      }
      if(!empty($hashMap['color'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_COLOR = '".$hashMap['color']."'
        ";
      }
      if(!empty($hashMap['keyword'])){
        $sql = $sql."
          AND A.PRODUCT_NAME LIKE '%".$hashMap['keyword']."%'
        ";
      }
      if($hashMap['is_img'] == 'true'){
        $sql = $sql."
          AND A.IMG_EXTENSION IS NOT NULL
        ";
      }

      if(empty($hashMap['orderBy'])){
        $sql = $sql."
          ORDER BY A.PRODUCT_NAME
        ";
      }else if($hashMap['orderBy'] == "alphabet"){
        $sql = $sql."
          ORDER BY A.PRODUCT_NAME
        ";
      }else if($hashMap['orderBy'] == "highPrice"){
        $sql = $sql."
          ORDER BY B.PRODUCT_PRICE_CUNSUMER DESC
        ";
      }else if($hashMap['orderBy'] == "lowPrice"){
        $sql = $sql."
          ORDER BY B.PRODUCT_PRICE_CUNSUMER
        ";
      }else if($hashMap['orderBy'] == "popular"){
        $sql = $sql."
          ORDER BY C.ORDER_AMOUNT DESC
        ";
      }
      $result = $this->db->query($sql);
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result->result());
      return $result;
    }

    function getProductCate($cate){
      $sql = "
        SELECT
          CODE
         , CODE_NM
          FROM COMMON_CODE_TB
         WHERE WORK_DV = '상품정보'
           AND CODE_DV = '".$cate."'
           AND IS_USE = 'Y'
        ORDER BY CODE
      ";
      return $this->db->query($sql)->result();
    }

    function getNewProduct(){
      $sql = "
      SELECT
          A.PRODUCT_ID
        , A.PRODUCT_NAME
        , A.IMG_EXTENSION
        , A.PRODUCT_CATE_KIND
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '상품정보' AND CODE_DV = '상품상세구분코드' AND CODE = A.PRODUCT_CATE_KIND) AS PRODUCT_CATE_KIND_NM
        , A.PRODUCT_CATE_SHAPE
        , A.PRODUCT_CATE_COLOR
        , A.PRODUCT_AMOUNT
        , B.PRODUCT_PRICE_CUNSUMER
        , B.PRODUCT_PRICE_WHOLESALE
        , CASE WHEN C.ORDER_AMOUNT IS NULL THEN 0 ELSE C.ORDER_AMOUNT END AS ORDER_AMOUNT
        FROM PRODUCT_TB A
          , (
              SELECT
                  BB.PRODUCT_ID
                , BB.PRODUCT_TIME
                , BB.PRODUCT_PRICE_CUNSUMER
                , BB.PRODUCT_PRICE_WHOLESALE
                FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                        FROM PRODUCT_PRICE_TB
                      GROUP BY PRODUCT_ID
                     ) AA
                  , PRODUCT_PRICE_TB BB
               WHERE AA.PRODUCT_ID = BB.PRODUCT_ID
                 AND AA.PRODUCT_TIME = BB.PRODUCT_TIME
               ) B LEFT JOIN (
             SELECT
              product_id
             , sum(order_amount) AS ORDER_AMOUNT
               FROM ORDER_ITEM_TB
             GROUP BY product_id
            ) C ON B.PRODUCT_ID = C.PRODUCT_ID
        WHERE A.PRODUCT_ID = B.PRODUCT_ID
         AND A.IS_SELL = 'Y'
         AND A.IS_DISPLAY = 'Y'
         AND A.IS_NEW = 'Y'
         ORDER BY A.PRODUCT_NAME
      ";
      return $this->db->query($sql)->result();
    }

    function getRecommandProduct(){
      $sql = "
      SELECT
          A.PRODUCT_ID
        , A.PRODUCT_NAME
        , A.IMG_EXTENSION
        , A.PRODUCT_CATE_KIND
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '상품정보' AND CODE_DV = '상품상세구분코드' AND CODE = A.PRODUCT_CATE_KIND) AS PRODUCT_CATE_KIND_NM
        , A.PRODUCT_CATE_SHAPE
        , A.PRODUCT_CATE_COLOR
        , A.PRODUCT_AMOUNT
        , B.PRODUCT_PRICE_CUNSUMER
        , B.PRODUCT_PRICE_WHOLESALE
        , CASE WHEN C.ORDER_AMOUNT IS NULL THEN 0 ELSE C.ORDER_AMOUNT END AS ORDER_AMOUNT
        FROM PRODUCT_TB A
          , (
              SELECT
                  BB.PRODUCT_ID
                , BB.PRODUCT_TIME
                , BB.PRODUCT_PRICE_CUNSUMER
                , BB.PRODUCT_PRICE_WHOLESALE
                FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                        FROM PRODUCT_PRICE_TB
                      GROUP BY PRODUCT_ID
                     ) AA
                  , PRODUCT_PRICE_TB BB
               WHERE AA.PRODUCT_ID = BB.PRODUCT_ID
                 AND AA.PRODUCT_TIME = BB.PRODUCT_TIME
               ) B LEFT JOIN (
             SELECT
              product_id
             , sum(order_amount) AS ORDER_AMOUNT
               FROM ORDER_ITEM_TB
             GROUP BY product_id
            ) C ON B.PRODUCT_ID = C.PRODUCT_ID
        WHERE A.PRODUCT_ID = B.PRODUCT_ID
         AND A.IS_SELL = 'Y'
         AND A.IS_DISPLAY = 'Y'
         AND A.IS_RECOMMAND = 'Y'
         ORDER BY A.PRODUCT_NAME
      ";
      return $this->db->query($sql)->result();
    }

    function getBsetSellerProduct(){
      $sql = "
      SELECT
          A.PRODUCT_ID
        , A.PRODUCT_NAME
        , A.IMG_EXTENSION
        , A.PRODUCT_CATE_KIND
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '상품정보' AND CODE_DV = '상품상세구분코드' AND CODE = A.PRODUCT_CATE_KIND) AS PRODUCT_CATE_KIND_NM
        , A.PRODUCT_CATE_SHAPE
        , A.PRODUCT_CATE_COLOR
        , A.PRODUCT_AMOUNT
        , B.PRODUCT_PRICE_CUNSUMER
        , B.PRODUCT_PRICE_WHOLESALE
        , CASE WHEN C.ORDER_AMOUNT IS NULL THEN 0 ELSE C.ORDER_AMOUNT END AS ORDER_AMOUNT
        FROM PRODUCT_TB A
          , (
              SELECT
                  BB.PRODUCT_ID
                , BB.PRODUCT_TIME
                , BB.PRODUCT_PRICE_CUNSUMER
                , BB.PRODUCT_PRICE_WHOLESALE
                FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                        FROM PRODUCT_PRICE_TB
                      GROUP BY PRODUCT_ID
                     ) AA
                  , PRODUCT_PRICE_TB BB
               WHERE AA.PRODUCT_ID = BB.PRODUCT_ID
                 AND AA.PRODUCT_TIME = BB.PRODUCT_TIME
               ) B LEFT JOIN (
                 SELECT
                  B.product_id
                 , SUM(B.order_amount) AS ORDER_AMOUNT
                   FROM ORDER_TB A, ORDER_ITEM_TB B
                  WHERE A.ORDER_ID = B.ORDER_ID
                    AND A.ORDER_STAT <> '99'
                 GROUP BY product_id
            ) C ON B.PRODUCT_ID = C.PRODUCT_ID
        WHERE A.PRODUCT_ID = B.PRODUCT_ID
         AND A.IS_SELL = 'Y'
         AND A.IS_DISPLAY = 'Y'
         AND C.ORDER_AMOUNT <> 0
         ORDER BY C.ORDER_AMOUNT DESC
         LIMIT 10
      ";
      return $this->db->query($sql)->result();
    }


}
