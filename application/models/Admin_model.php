
<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 5.
 * Time: PM 1:50
 */

class Admin_model extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->helper('custlog');
    }

    function getPCSlideInfo(){
      $sql = "
        SELECT
            IDXKEY
          , CODE_NM
          , CODE
          FROM COMMON_CODE_TB
         WHERE WORK_DV = '상점정보'
           AND CODE_DV = '슬라이드베너'
           AND CODE_NM = '데스크탑'
      ";
      return $this->db->query($sql)->result();
    }

    function getMSlideInfo(){
      $sql = "
        SELECT
            IDXKEY
          , CODE_NM
          , CODE
          FROM COMMON_CODE_TB
         WHERE WORK_DV = '상점정보'
           AND CODE_DV = '슬라이드베너'
           AND CODE_NM = '모바일'
      ";
      return $this->db->query($sql)->result();
    }

    function getFileName($id){
      $sql = "
        SELECT
            CODE
          FROM COMMON_CODE_TB
         WHERE IDXKEY = '".$id."'
      ";
      return $this->db->query($sql)->row();
    }

    function updateFileName($id,$fileName){
      $sql = "
        UPDATE COMMON_CODE_TB
           SET CODE = '".$fileName."'
         WHERE IDXKEY = '".$id."'
      ";
      return $this->db->query($sql);
    }

    function insertFileName($id,$name,$type){
      if($type == "pc"){
        $type = "데스크탑";
      }else if($type == "m"){
        $type = "모바일";
      }
      $sql = "
        INSERT INTO COMMON_CODE_TB
        VALUES(
          '".$id."','상점정보','슬라이드베너','".$type."','".$name."','Y', NOW()+0
        );
      ";
      return $this->db->query($sql);
    }

    function getUserInfoBase($param,$mode,$url){
      $sql = "
      SELECT * FROM (
      SELECT
        A.USER_CREATED
      , A.USER_ID
      , A.USER_TYPE AS USER_TYPE_CD
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '회원구분' AND CODE = A.USER_TYPE) AS USER_TYPE_NM
      , USER_NAME
      , CONCAT('(',USER_POSTCODE,')',USER_ADDR,USER_DETAIL_ADDR) AS USER_ADDR
      , CONCAT(USER_TEL_H, '-', USER_TEL_B, '-', USER_TEL_T) AS USER_CELLPHONE
      , (CASE WHEN A.USER_TYPE IN('2','3','4') THEN 'Y' ELSE 'N' END) AS IS_BIZ
      , CONCAT(SUBSTR(B.CERTI_NUM,1,3),'-',SUBSTR(B.CERTI_NUM,4,2),'-',SUBSTR(B.CERTI_NUM,6)) AS CERTI_NUM
      FROM USER_TB A LEFT JOIN CERTIFICATE_TB B
      ON (A.USER_ID = B.USER_ID)
      ) Z
      WHERE 1=1
      ";
      if(!empty($param['FRDT']) && !empty($param['TODT'])){
        $sql = $sql."
           AND USER_CREATED+0 BETWEEN '".str_replace("-","",$param['FRDT'])."000000' AND '".str_replace("-","",$param['TODT'])."999999'
        ";
      }
      if(!empty($param['USER_INFO_DV']) && !empty($param['USER_INFO_VALUE'])){
        $sql = $sql."
         AND ".$param['USER_INFO_DV']." LIKE '%".$param['USER_INFO_VALUE']."%'
        ";
      }
      if(!empty($param['IS_BIZ'])){
        $sql = $sql."
         AND IS_BIZ = '".$param['IS_BIZ']."'
        ";
      }
      if(!empty($param['USER_TYPE_CD'])){
        $sql = $sql."
         AND USER_TYPE_CD = '".$param['USER_TYPE_CD']."'
        ";
      }
      if(empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit 0,10
        ";
      }else if(!empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($param['PAGE']*10)-10).",10
        ";
      }
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function updateUserGrade($id, $grade){
      $sql = "
        UPDATE USER_TB
           SET USER_TYPE = '".$grade."'
         WHERE USER_ID = '".$id."'
      ";
      return $this->db->query($sql);
    }

    function getProductCateDV(){
      $sql = "
        SELECT
            CODE_NM
          , CODE
          FROM COMMON_CODE_TB
          WHERE WORK_DV = '상품정보'
            AND CODE_DV = '상품상세구분코드'
            AND IS_USE = 'Y'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getProductCateColor(){
      $sql = "
        SELECT
            CODE_NM
          , CODE
          FROM COMMON_CODE_TB
          WHERE WORK_DV = '상품정보'
            AND CODE_DV = '상품색상구분코드'
            AND IS_USE = 'Y'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getProductCateShape(){
      $sql = "
        SELECT
            CODE_NM
          , CODE
          FROM COMMON_CODE_TB
          WHERE WORK_DV = '상품정보'
            AND CODE_DV = '상품형태구분코드'
            AND IS_USE = 'Y'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getProductCateArea(){
      $sql = "
        SELECT
            CODE_NM
          , CODE
          FROM COMMON_CODE_TB
          WHERE WORK_DV = '상품정보'
            AND CODE_DV = '상품원산지구분코드'
            AND IS_USE = 'Y'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getProductList($param,$mode){
      $sql = "
      SELECT
          A.PRODUCT_ID
        , A.PRODUCT_NAME
        , A.IMG_EXTENSION
        , A.PRODUCT_CATE_KIND
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '상품정보' AND CODE_DV = '상품상세구분코드' AND CODE = A.PRODUCT_CATE_KIND) AS PRODUCT_CATE_KIND_NM
        , A.PRODUCT_CATE_SHAPE
        , A.PRODUCT_CATE_COLOR
        , A.PRODUCT_CATE_AREA
        , A.IS_DISPLAY
        , A.IS_NEW
        , A.IS_RECOMMAND
        , A.PRODUCT_AMOUNT
        , B.PRODUCT_PRICE_SUPPLY
        , B.PRODUCT_PRICE_CUNSUMER
        , B.PRODUCT_PRICE_WHOLESALE
        , CONCAT(SUBSTR(B.PRODUCT_TIME,1,4),'.',SUBSTR(B.PRODUCT_TIME,5,2),'.',SUBSTR(B.PRODUCT_TIME,7,2)) AS PRODUCT_TIME
        FROM PRODUCT_TB A
          , (
              SELECT
                  BB.PRODUCT_ID
                , BB.PRODUCT_TIME
                , BB.PRODUCT_PRICE_CUNSUMER
                , BB.PRODUCT_PRICE_WHOLESALE
                , BB.PRODUCT_PRICE_SUPPLY
                FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                        FROM PRODUCT_PRICE_TB
                      GROUP BY PRODUCT_ID
                     ) AA
                  , PRODUCT_PRICE_TB BB
               WHERE AA.PRODUCT_ID = BB.PRODUCT_ID
                 AND AA.PRODUCT_TIME = BB.PRODUCT_TIME
               ) B
        WHERE A.PRODUCT_ID = B.PRODUCT_ID
      ";
      if(!empty($param['PRD_NM'])){
        $sql = $sql."
          AND A.PRODUCT_NAME LIKE '%".$param['PRD_NM']."%'
        ";
      }
      if(!empty($param['PRD_AREA'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_AREA = '".$param['PRD_AREA']."'
        ";
      }
      if(!empty($param['PRD_DV'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_KIND = '".$param['PRD_DV']."'
        ";
      }
      if(!empty($param['PRD_COLOR'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_COLOR = '".$param['PRD_COLOR']."'
        ";
      }
      if(!empty($param['PRD_SHAPE'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_SHAPE = '".$param['PRD_SHAPE']."'
        ";
      }
      if(!empty($param['LOW_PRICE']) && !empty($param['LOW_PRICE'])){
        $sql = $sql."
          AND B.PRODUCT_PRICE_SUPPLY BETWEEN '".$param['LOW_PRICE']."' AND '".$param['HIGH_PRICE']."'
        ";
      }
      if(!empty($param['LOW_PRICE']) && !empty($param['LOW_PRICE'])){
        $sql = $sql."
          AND B.PRODUCT_PRICE_SUPPLY BETWEEN '".$param['LOW_PRICE']."' AND '".$param['HIGH_PRICE']."'
        ";
      }
      if(!empty($param['PRD_DISPLAY'])){
        if($param['PRD_DISPLAY']=="IS_NEW"){
          $sql = $sql."
            AND A.IS_NEW = 'Y'
          ";
        }
        if($param['PRD_DISPLAY']=="IS_RECOMMAND"){
          $sql = $sql."
            AND A.IS_RECOMMAND = 'Y'
          ";
        }
      }
      if(!empty($param['IS_DISPLAY'])){
        $sql = $sql."
          AND A.IS_DISPLAY = '".$param['IS_DISPLAY']."'
        ";
      }
      if(!empty($param['ID'])){
        $sql = $sql."
          AND A.PRODUCT_ID = '".$param['ID']."'
        ";
      }
      if(empty($param['PAGE']) && $mode=="IQY"){
        if($param['VIEW_CNT']=='false'){
          $sql = $sql."
          limit 0,10
          ";
        }else{
          $sql = $sql."
          limit 0,100
          ";
        }
      }else if(!empty($param['PAGE']) && $mode=="IQY"){
        if($param['VIEW_CNT']=='false'){
          $sql = $sql."
          limit ".(($param['PAGE']*10)-10).",10
          ";
        }else{
          $sql = $sql."
          limit ".(($param['PAGE']*100)-100).",100
          ";
        }
      }
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function getProductListByUserID($param,$mode){
      $sql = "
      SELECT
          A.PRODUCT_ID
        , A.PRODUCT_NAME
        , A.IMG_EXTENSION
        , A.PRODUCT_CATE_KIND
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '상품정보' AND CODE_DV = '상품상세구분코드' AND CODE = A.PRODUCT_CATE_KIND) AS PRODUCT_CATE_KIND_NM
        , A.PRODUCT_CATE_SHAPE
        , A.PRODUCT_CATE_COLOR
        , A.IS_DISPLAY
        , A.IS_NEW
        , A.IS_RECOMMAND
        , A.PRODUCT_AMOUNT
        , B.PRODUCT_PRICE_SUPPLY
        , B.PRODUCT_PRICE_CUNSUMER
        , B.PRODUCT_PRICE_WHOLESALE
        , CONCAT(SUBSTR(B.PRODUCT_TIME,1,4),'.',SUBSTR(B.PRODUCT_TIME,5,2),'.',SUBSTR(B.PRODUCT_TIME,7,2)) AS PRODUCT_TIME
        FROM PRODUCT_TB A
          , (
              SELECT
                  BB.PRODUCT_ID
                , BB.PRODUCT_TIME
                , BB.PRODUCT_PRICE_CUNSUMER
                , BB.PRODUCT_PRICE_WHOLESALE
                , BB.PRODUCT_PRICE_SUPPLY
                FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                        FROM PRODUCT_PRICE_TB
                      GROUP BY PRODUCT_ID
                     ) AA
                  , PRODUCT_PRICE_TB BB
               WHERE AA.PRODUCT_ID = BB.PRODUCT_ID
                 AND AA.PRODUCT_TIME = BB.PRODUCT_TIME
               ) B
        WHERE A.PRODUCT_ID = B.PRODUCT_ID
      ";
      if(!empty($param['PRD_NM'])){
        $sql = $sql."
          AND A.PRODUCT_NAME LIKE '%".$param['PRD_NM']."%'
        ";
      }
      if(!empty($param['PRD_DV'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_KIND = '".$param['PRD_DV']."'
        ";
      }
      if(!empty($param['PRD_COLOR'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_COLOR = '".$param['PRD_COLOR']."'
        ";
      }
      if(!empty($param['PRD_SHAPE'])){
        $sql = $sql."
          AND A.PRODUCT_CATE_SHAPE = '".$param['PRD_SHAPE']."'
        ";
      }
      if(!empty($param['LOW_PRICE']) && !empty($param['LOW_PRICE'])){
        $sql = $sql."
          AND B.PRODUCT_PRICE_SUPPLY BETWEEN '".$param['LOW_PRICE']."' AND '".$param['HIGH_PRICE']."'
        ";
      }
      if(!empty($param['LOW_PRICE']) && !empty($param['LOW_PRICE'])){
        $sql = $sql."
          AND B.PRODUCT_PRICE_SUPPLY BETWEEN '".$param['LOW_PRICE']."' AND '".$param['HIGH_PRICE']."'
        ";
      }
      if(!empty($param['PRD_DISPLAY'])){
        if($param['PRD_DISPLAY']=="IS_NEW"){
          $sql = $sql."
            AND A.IS_NEW = 'Y'
          ";
        }
        if($param['PRD_DISPLAY']=="IS_RECOMMAND"){
          $sql = $sql."
            AND A.IS_RECOMMAND = 'Y'
          ";
        }
      }
      if(!empty($param['ID'])){
        $sql = $sql."
          AND A.PRODUCT_ID = '".$param['ID']."'
        ";
      }
      $sql = $sql."
        AND A.USER_ID = '".$this->session->userdata('user_id')."'
      ";
      if(empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit 0,10
        ";
      }else if(!empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($param['PAGE']*10)-10).",10
        ";
      }
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function getProductID(){
      $sql = "
      SELECT
          LPAD(MAX(PRODUCT_ID)+1,6,0) AS SEQ
        FROM PRODUCT_TB
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->row()->SEQ;
    }

    function insertProduct($data){
      $sql = "
        INSERT INTO PRODUCT_TB
        VALUES(
          '".$this->session->userdata('user_id')."'
        , '".$data['PRD_ID']."'
        , '".$data['IMG_EXTENSION']."'
        , '".$data['IMG_SIZE']."'
        , '01'
        , '".$data['PRD_NM']."'
        , '".$data['PRD_AMT']."'
        , ''
        , '".$data['PRD_SHAPE']."'
        , '".$data['PRD_COLOR']."'
        , '".$data['PRD_DV']."'
        , '".$data['PRD_AREA']."'
        , '".$data['IS_DISPLAY']."'
        , 'Y'
        , '".$data['IS_RECOMMAND']."'
        , '".$data['IS_NEW']."'
        , 0
        , NOW()+0
        )
      ";
      return $this->db->query($sql);
    }

    function insertProductPrice($data){
      $sql = "
        INSERT INTO PRODUCT_PRICE_TB
        VALUES(
           '".$data['PRD_ID']."'
          , SUBSTR(NOW()+0,1,8)
          , '".($data['PRD_PRICE'])."'
          , '".($data['PRD_PRICE']+1000)."'
          , '".($data['PRD_PRICE']+2000)."'
        )
      ";
      return $this->db->query($sql);
    }

    function updateProduct($data){
      $sql = "
        UPDATE PRODUCT_TB
        SET PRODUCT_NAME = '".$data['PRD_NM']."'";
        if(!empty($data['IMG_EXTENSION'])){
          $sql=$sql."
            , IMG_SIZE = '".$data['IMG_SIZE']."'
            , IMG_EXTENSION = '".$data['IMG_EXTENSION']."'
          ";
        }
      $sql=$sql."
        , PRODUCT_AMOUNT = '".$data['PRD_AMT']."'
        , PRODUCT_CATE_SHAPE = '".$data['PRD_SHAPE']."'
        , PRODUCT_CATE_COLOR = '".$data['PRD_COLOR']."'
        , PRODUCT_CATE_KIND = '".$data['PRD_DV']."'
        , PRODUCT_CATE_AREA = '".$data['PRD_AREA']."'
        , IS_DISPLAY = '".$data['IS_DISPLAY']."'
        , IS_RECOMMAND = '".$data['IS_RECOMMAND']."'
        , IS_NEW = '".$data['IS_NEW']."'
        WHERE PRODUCT_ID = '".$data['PRD_ID']."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function updateProductPrice($data){
      $sql = "
        SELECT CASE WHEN COUNT(1)>0 THEN 'Y' ELSE 'N' END IS_TODAY
          FROM PRODUCT_PRICE_TB
          WHERE PRODUCT_ID = '".$data['PRD_ID']."'
            AND PRODUCT_TIME = SUBSTR(NOW()+0,1,8)
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $IS_TODAY = $this->db->query($sql)->row()->IS_TODAY;
      if($IS_TODAY == "Y"){
        $sql = "
          UPDATE PRODUCT_PRICE_TB
          SET PRODUCT_PRICE_SUPPLY = '".$data['PRD_PRICE']."'
            , PRODUCT_PRICE_WHOLESALE = '".($data['PRD_PRICE']+1000)."'
            , PRODUCT_PRICE_CUNSUMER = '".($data['PRD_PRICE']+2000)."'
          WHERE PRODUCT_ID = '".$data['PRD_ID']."'
            AND PRODUCT_TIME = SUBSTR(NOW()+0,1,8)
        ";
      }else{
        $sql = "
          INSERT INTO PRODUCT_PRICE_TB
          VALUES(
             '".$data['PRD_ID']."'
            , SUBSTR(NOW()+0,1,8)
            , ".$data['PRD_PRICE']."
            , ".($data['PRD_PRICE']+1000)."
            , ".($data['PRD_PRICE']+2000)."
          )
        ";
      }
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function updateProductPriceByID($param){
      $sql = "
        SELECT CASE WHEN COUNT(1)>0 THEN 'Y' ELSE 'N' END IS_TODAY
          FROM PRODUCT_PRICE_TB
          WHERE PRODUCT_ID = '".$param['PRODUCT_ID']."'
            AND PRODUCT_TIME = SUBSTR(NOW()+0,1,8)
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $IS_TODAY = $this->db->query($sql)->row()->IS_TODAY;
      if($IS_TODAY == "Y"){
        $sql = "
          UPDATE PRODUCT_PRICE_TB
          SET PRODUCT_PRICE_SUPPLY    = '".$param['PRODUCT_PRICE_SUPPLY']."'
            , PRODUCT_PRICE_WHOLESALE = '".$param['PRODUCT_PRICE_WHOLESALE']."'
            , PRODUCT_PRICE_CUNSUMER  = '".$param['PRODUCT_PRICE_CUNSUMER']."'
          WHERE PRODUCT_ID = '".$param['PRODUCT_ID']."'
            AND PRODUCT_TIME = SUBSTR(NOW()+0,1,8)
        ";
      }else{
        $sql = "
          INSERT INTO PRODUCT_PRICE_TB
          VALUES(
              '".$param['PRODUCT_ID']."'
            , SUBSTR(NOW()+0,1,8)
            , '".$param['PRODUCT_PRICE_SUPPLY']."'
            , '".$param['PRODUCT_PRICE_WHOLESALE']."'
            , '".$param['PRODUCT_PRICE_CUNSUMER']."'
          )
        ";
      }
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function updateProductDisplay($param){
      $sql = "
        UPDATE PRODUCT_TB
           SET IS_DISPLAY = '".$param['IS_DISPLAY']."'
         WHERE PRODUCT_ID = '".$param['PRODUCT_ID']."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function deleteProductByID($id){
      $sql = "
        DELETE FROM PRODUCT_TB
        WHERE PRODUCT_ID = '".$id."'
      ";
      $this->db->query($sql);
      $sql = "
        DELETE FROM PRODUCT_PRICE_TB
        WHERE PRODUCT_ID = '".$id."'
      ";
      return $this->db->query($sql);
    }

    function getPaymentListGridData($param,$mode,$url){
      $sql = "
      SELECT
          A.ORDER_ID
        , A.ORDER_TIME
        , CONCAT(C.PRODUCT_NAME,' 포함 ', COUNT(1),'품종') AS PRODUCT
        , A.USER_ID
        , A.IS_PAID
        , A.IS_FORDER
        , A.ORDER_STAT
        , SUM(B.order_price * B.order_amount) AS PAY_PRICE
        , A.DELIVERY_DATE
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
           , PRODUCT_TB C
           , (
              SELECT
                B.PRODUCT_ID
              , B.PRODUCT_TIME
              , B.PRODUCT_PRICE_WHOLESALE
              , B.PRODUCT_PRICE_CUNSUMER
              FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                      FROM PRODUCT_PRICE_TB
                  GROUP BY PRODUCT_ID
                  ) A
                , PRODUCT_PRICE_TB B
              WHERE A.PRODUCT_ID = B.PRODUCT_ID
                AND A.PRODUCT_TIME = B.PRODUCT_TIME
           ) D
           , USER_TB E
        WHERE A.ORDER_ID = B.ORDER_ID
         AND B.product_id = C.PRODUCT_ID
         AND B.PRODUCT_ID = D.PRODUCT_ID
         AND A.ORDER_STAT <> '99'
         AND A.USER_ID = E.USER_ID";
      if(!empty($param['ODID'])){
        $sql = $sql."
         AND A.ORDER_ID LIKE '%".$param['ODID']."%'
        ";
      }
      if(!empty($param['FRDT']) && !empty($param['TODT'])){
        $sql = $sql."
         AND A.ORDER_TIME BETWEEN ".str_replace("-","",$param['FRDT'])." AND ".str_replace("-","",$param['TODT'])."
        ";
      }
      if(!empty($param['USER_INFO_DV']) && !empty($param['USER_INFO_VALUE'])){
        $sql = $sql."
         AND A.".$param['USER_INFO_DV']." LIKE '%".$param['USER_INFO_VALUE']."%'
        ";
      }
      if(!empty($param['IS_PAID'])){
        $sql = $sql."
         AND A.IS_PAID = '".$param['IS_PAID']."'
        ";
      }

      if(!empty($param['IS_FORDER'])){
        $sql = $sql."
         AND A.IS_FORDER = '".$param['IS_FORDER']."'
        ";
      }

      if($url == 'createForder'){
        $sql = $sql."
         AND A.IS_FORDER = 'N'
        ";
      }else if($url == 'readyProduct'){
        $sql = $sql."
         AND A.ORDER_STAT = '20'
        ";
      }

      $sql = $sql."
         GROUP BY A.ORDER_ID
         ORDER BY A.ORDER_TIME DESC, A.ORDER_ID
      ";
      if(empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit 0,10
        ";
      }else if(!empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($param['PAGE']*10)-10).",10
        ";
      }
      $result = $this->db->query($sql);
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result->result());
      return $result;
    }

    function getOrderListGridData($param,$mode,$url){
      $sql = "
      SELECT
          A.ORDER_ID
        , F.ID AS FORDER_ID
        , CONCAT(SUBSTR(A.ORDER_TIME,1,4),'.',SUBSTR(A.ORDER_TIME,5,2),'.',SUBSTR(A.ORDER_TIME,7,2)) AS ORDER_TIME
        , CONCAT(C.PRODUCT_NAME,' 포함 ', COUNT(1),'품종') AS PRODUCT
        , A.USER_ID
        , A.IS_PAID
        , A.IS_FORDER
        , A.ORDER_STAT
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '주문업무' AND CODE_DV = '주문진행상태' AND CODE = A.ORDER_STAT) AS ORDER_STAT_NM
        , F.PROGRESS AS FORDER_STAT
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '발주업무' AND CODE_DV = '발주진행상태' AND CODE = F.PROGRESS) AS FORDER_STAT_NM
        , SUM(B.order_price * B.order_amount) AS PAY_PRICE
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
           , PRODUCT_TB C
           , (
              SELECT
                B.PRODUCT_ID
              , B.PRODUCT_TIME
              , B.PRODUCT_PRICE_WHOLESALE
              , B.PRODUCT_PRICE_CUNSUMER
              FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                      FROM PRODUCT_PRICE_TB
                  GROUP BY PRODUCT_ID
                  ) A
                , PRODUCT_PRICE_TB B
              WHERE A.PRODUCT_ID = B.PRODUCT_ID
                AND A.PRODUCT_TIME = B.PRODUCT_TIME
           ) D
           , USER_TB E
           , FORDER_BASE_TB F
        WHERE A.ORDER_ID = B.ORDER_ID
         AND B.product_id = C.PRODUCT_ID
         AND B.PRODUCT_ID = D.PRODUCT_ID
         AND A.USER_ID = E.USER_ID
         AND A.FORDER_ID = F.ID";

      if(!empty($param['ODID'])){
        $sql = $sql."
         AND A.ORDER_ID LIKE '%".$param['ODID']."%'
        ";
      }
      if(!empty($param['FRDT']) && !empty($param['TODT'])){
        $sql = $sql."
         AND A.ORDER_TIME BETWEEN ".str_replace("-","",$param['FRDT'])." AND ".str_replace("-","",$param['TODT'])."
        ";
      }
      if(!empty($param['USER_INFO_DV']) && !empty($param['USER_INFO_VALUE'])){
        $sql = $sql."
         AND A.".$param['USER_INFO_DV']." LIKE '%".$param['USER_INFO_VALUE']."%'
        ";
      }
      if(!empty($param['IS_PAID'])){
        $sql = $sql."
         AND A.IS_PAID = '".$param['IS_PAID']."'
        ";
      }

      if(!empty($param['IS_FORDER'])){
        $sql = $sql."
         AND A.IS_FORDER = '".$param['IS_FORDER']."'
        ";
      }

      if(!empty($param['PROGRESS'])){
        $sql = $sql."
         AND F.PROGRESS = '".$param['PROGRESS']."'
        ";
      }

      if($url == 'readyProduct'){
        $sql = $sql."
         AND A.ORDER_STAT = '20'
        ";
      }

      if($url == 'onDelivery'){
        $sql = $sql."
         AND A.ORDER_STAT = '30'
        ";
      }

      $sql = $sql."
         GROUP BY A.ORDER_ID
         ORDER BY A.ORDER_TIME DESC, A.ORDER_ID
      ";
      if(empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit 0,10
        ";
      }else if(!empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($param['PAGE']*10)-10).",10
        ";
      }
      $result = $this->db->query($sql);
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result->result());
      return $result;
    }

    function getOrderAllListGridData($param,$mode,$url){
      $sql = "
      SELECT
          AA.ORDER_ID
        , AA.FORDER_ID
        , CONCAT(SUBSTR(AA.ORDER_TIME,1,4),'.',SUBSTR(AA.ORDER_TIME,5,2),'.',SUBSTR(AA.ORDER_TIME,7,2)) AS ORDER_TIME
        , AA.PRODUCT
        , AA.USER_ID
        , AA.IS_PAID
        , AA.IS_FORDER
        , AA.ORDER_STAT
        , AA.ORDER_STAT_NM
        , AA.PAY_PRICE
      	, BB.ID AS FORDER_ID
      	, BB.PROGRESS AS FORDER_STAT
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '발주업무' AND CODE_DV = '발주진행상태' AND CODE = BB.PROGRESS) AS FORDER_STAT_NM
        FROM (
            SELECT
                A.ORDER_ID
              , A.FORDER_ID
              , A.ORDER_TIME
              , CONCAT(C.PRODUCT_NAME,' 포함 ', COUNT(1),'품종') AS PRODUCT
              , A.USER_ID
              , A.IS_PAID
              , A.IS_FORDER
              , A.ORDER_STAT
              , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV = '주문업무' AND CODE_DV = '주문진행상태' AND CODE = A.ORDER_STAT) AS ORDER_STAT_NM
              , SUM(B.order_price * B.order_amount) AS PAY_PRICE
              FROM ORDER_TB A
                 , ORDER_ITEM_TB B
                 , PRODUCT_TB C
                 , (
                    SELECT
                      B.PRODUCT_ID
                    , B.PRODUCT_TIME
                    , B.PRODUCT_PRICE_WHOLESALE
                    , B.PRODUCT_PRICE_CUNSUMER
                    FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                            FROM PRODUCT_PRICE_TB
                        GROUP BY PRODUCT_ID
                        ) A
                      , PRODUCT_PRICE_TB B
                    WHERE A.PRODUCT_ID = B.PRODUCT_ID
                      AND A.PRODUCT_TIME = B.PRODUCT_TIME
                 ) D
                 , USER_TB E
              WHERE A.ORDER_ID = B.ORDER_ID
               AND B.product_id = C.PRODUCT_ID
               AND B.PRODUCT_ID = D.PRODUCT_ID
               AND A.USER_ID = E.USER_ID
               GROUP BY A.ORDER_ID
               ORDER BY A.ORDER_TIME DESC, A.ORDER_ID
            ) AA LEFT JOIN FORDER_BASE_TB BB
      		ON AA.FORDER_ID = BB.ID
          WHERE 1=1";

      if(!empty($param['ODID'])){
        $sql = $sql."
         AND AA.ORDER_ID LIKE '%".$param['ODID']."%'
        ";
      }
      if(!empty($param['FOID'])){
        $sql = $sql."
         AND AA.FORDER_ID LIKE '%".$param['FOID']."%'
        ";
      }
      if(!empty($param['FRDT']) && !empty($param['TODT'])){
        $sql = $sql."
         AND AA.ORDER_TIME BETWEEN ".str_replace("-","",$param['FRDT'])." AND ".str_replace("-","",$param['TODT'])."
        ";
      }
      if(!empty($param['USER_INFO_DV']) && !empty($param['USER_INFO_VALUE'])){
        $sql = $sql."
         AND AA.".$param['USER_INFO_DV']." LIKE '%".$param['USER_INFO_VALUE']."%'
        ";
      }
      if(!empty($param['IS_PAID'])){
        $sql = $sql."
         AND AA.IS_PAID = '".$param['IS_PAID']."'
        ";
      }

      if(!empty($param['ORDER_STAT'])){
        $sql = $sql."
         AND AA.ORDER_STAT = '".$param['ORDER_STAT']."'
        ";
      }

      if(!empty($param['FORDER_STAT'])){
        $sql = $sql."
         AND BB.PROGRESS = '".$param['FORDER_STAT']."'
        ";
      }

      $sql = $sql."
         GROUP BY AA.ORDER_ID
         ORDER BY AA.ORDER_TIME DESC, AA.ORDER_ID
      ";
      if(empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit 0,10
        ";
      }else if(!empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($param['PAGE']*10)-10).",10
        ";
      }
      $result = $this->db->query($sql);
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result->result());
      return $result;
    }

    function setPaymentConf($orderID){
      $sql = "
        UPDATE ORDER_TB
        SET IS_PAID = 'Y'
        WHERE ORDER_ID = '".$orderID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $this->db->query($sql);
    }

    function setPaymentConfCancle($orderID){
      $sql = "
        UPDATE ORDER_TB
        SET IS_PAID = 'N'
        WHERE ORDER_ID = '".$orderID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $this->db->query($sql);
    }

    function setOrderCancle($orderID){
      $sql = "
        UPDATE ORDER_TB
        SET ORDER_STAT = '99'
        WHERE ORDER_ID = '".$orderID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $this->db->query($sql);
    }

    function getOrderDetailById($id){
      $sql = "
      SELECT
          A.ORDER_ID
        , A.ORDER_TIME
        , E.USER_ID
        , E.USER_NAME
        , F.RECIP_NAME
        , CONCAT('(',F.RECIP_POSTCODE,')',F.RECIP_ADDR,' ',F.RECIP_ADDR_DETAILS) AS ADDR
        , CONCAT(F.RECIP_TEL_H,'-',F.RECIP_TEL_B,'-',F.RECIP_TEL_T) AS RECIP_PHONE
        , C.PRODUCT_ID
        , C.IMG_EXTENSION
        , C.PRODUCT_NAME
        , B.ORDER_AMOUNT
        , B.ORDER_PRICE
        , A.USER_ID
        , A.IS_PAID
        , A.ORDER_STAT
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
           , PRODUCT_TB C
           , (
              SELECT
                B.PRODUCT_ID
              , B.PRODUCT_TIME
              , B.PRODUCT_PRICE_WHOLESALE
              , B.PRODUCT_PRICE_CUNSUMER
              FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                      FROM PRODUCT_PRICE_TB
                  GROUP BY PRODUCT_ID
                  ) A
                , PRODUCT_PRICE_TB B
              WHERE A.PRODUCT_ID = B.PRODUCT_ID
                AND A.PRODUCT_TIME = B.PRODUCT_TIME
           ) D
           , USER_TB E
           , USER_ADDRESS_TB F
        WHERE A.order_id = B.ORDER_ID
         AND B.product_id = C.PRODUCT_ID
         AND B.PRODUCT_ID = D.PRODUCT_ID
         AND A.USER_ID = E.USER_ID
         AND A.ORDER_ID = F.ORDER_ID
         AND A.ORDER_ID = '".$id."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getForderBaseByOrderId($dataArray){
      $sql = "
      SELECT
          C.PRODUCT_ID AS ID
        , C.IMG_EXTENSION
        , C.PRODUCT_NAME AS NAME
        , SUM(B.ORDER_AMOUNT) AS QTY
        , B.ORDER_PRICE AS PRODUCT_PRICE
        , (SUM(B.ORDER_AMOUNT)*B.ORDER_PRICE) AS BUY_PRICE
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
           , PRODUCT_TB C
           , (
              SELECT
                B.PRODUCT_ID
              , B.PRODUCT_TIME
              , B.PRODUCT_PRICE_WHOLESALE
              , B.PRODUCT_PRICE_CUNSUMER
              FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                      FROM PRODUCT_PRICE_TB
                  GROUP BY PRODUCT_ID
                  ) A
                , PRODUCT_PRICE_TB B
              WHERE A.PRODUCT_ID = B.PRODUCT_ID
                AND A.PRODUCT_TIME = B.PRODUCT_TIME
           ) D
        WHERE A.order_id = B.order_id
        AND B.product_id = C.product_id
        AND B.product_id = D.PRODUCT_ID
        AND A.ORDER_ID IN (";
                $itemCnt = 0;
                foreach($dataArray as $ITEM){
                  if($itemCnt == 0){
                    $sql = $sql.$ITEM;
                  }else{
                    $sql = $sql.", ".$ITEM;
                  }
                  $itemCnt++;
                }
                $sql = $sql.")
        GROUP BY C.PRODUCT_ID, C.PRODUCT_NAME, D.PRODUCT_PRICE_WHOLESALE
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getForderDetailByOrderId($dataArray){
      $sql = "
      SELECT
          C.PRODUCT_ID AS ID
        , C.IMG_EXTENSION
        , C.PRODUCT_NAME AS NAME
        , SUM(B.ORDER_AMOUNT) AS QTY
        , B.ORDER_PRICE AS PRODUCT_PRICE
        , (SUM(B.ORDER_AMOUNT)*B.ORDER_PRICE) AS BUY_PRICE
        , E.FORDER_DETAIL_DV AS FORDER_TYPE
        , E.IS_PURCHASED
        , E.PURCHASED_AMOUNT
        , E.PURCHASED_PRICE
        , E.PURCHASED_SHOP
        , E.MEMO
        , F.MEMO1 AS FMEMO1
        , F.MEMO2 AS FMEMO2
        , F.DELIVERY_FEE
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
           , PRODUCT_TB C
           , (
              SELECT
                B.PRODUCT_ID
              , B.PRODUCT_TIME
              , B.PRODUCT_PRICE_WHOLESALE
              , B.PRODUCT_PRICE_CUNSUMER
              FROM (SELECT PRODUCT_ID, MAX(PRODUCT_TIME) AS PRODUCT_TIME
                      FROM PRODUCT_PRICE_TB
                  GROUP BY PRODUCT_ID
                  ) A
                , PRODUCT_PRICE_TB B
              WHERE A.PRODUCT_ID = B.PRODUCT_ID
                AND A.PRODUCT_TIME = B.PRODUCT_TIME
           ) D
           , FORDER_DETAIL_TB E
           , FORDER_BASE_TB F
        WHERE A.order_id = B.order_id
        AND B.product_id = C.product_id
        AND B.product_id = D.PRODUCT_ID
        AND A.FORDER_ID = E.ID
        AND B.PRODUCT_ID = E.PRODUCT_ID
        AND E.ID = F.ID
        AND A.ORDER_ID IN (";
                $itemCnt = 0;
                foreach($dataArray as $ITEM){
                  if($itemCnt == 0){
                    $sql = $sql.$ITEM;
                  }else{
                    $sql = $sql.", ".$ITEM;
                  }
                  $itemCnt++;
                }
                $sql = $sql.")
        GROUP BY C.PRODUCT_ID, C.PRODUCT_NAME, D.PRODUCT_PRICE_WHOLESALE
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getSequency($WORK_DV,$DATE){
      /******************
      WORK_DV
      01 : 공통코드업무
      02 : 회원업무
      03 : 주문업무
      04 : 발주업무
      05 : 게시판업무
      06 : 가계부업무
      ******************/
      $sql="";

      if($WORK_DV=='01'){
        $sql = "
          SELECT
              IF(COUNT(1)>0,'Y','N') AS YN
            FROM COMMON_CODE_TB
           WHERE SUBSTR(IDXKEY,5,14) = '".$DATE."'";
      }else if($WORK_DV=='03'){
        $sql = "
          SELECT
              IF(COUNT(1)>0,'Y','N') AS YN
            FROM ORDER_TB
           WHERE SUBSTR(ORDER_ID,5,14) = '".$DATE."'";
      }else if($WORK_DV=='04'){
        $sql = "
          SELECT
              IF(COUNT(1)>0,'Y','N') AS YN
            FROM FORDER_BASE_TB
           WHERE SUBSTR(ID,5,14) = '".$DATE."'";
      }else if($WORK_DV=='05'){
        $sql = "
          SELECT
              IF(COUNT(1)>0,'Y','N') AS YN
            FROM SUPPORT_BOARD_TB
           WHERE SUBSTR(IDXKEY,5,14) = '".$DATE."'";
      }else if($WORK_DV=='06'){
        $sql = "
          SELECT
              IF(COUNT(1)>0,'Y','N') AS YN
            FROM LEDGER_TB
           WHERE SUBSTR(IDXKEY,5,14) = '".$DATE."'";
      }
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $IS_DATE = $this->db->query($sql)->row()->YN;
      if($IS_DATE == 'N'){
        return '01';
      }else{
        $sql;
        if($WORK_DV=='01'){
          $sql = "
            SELECT (SELECT LPAD(COALESCE(MAX(SUBSTR(IDXKEY,19,2)),0)+1,2,0) FROM COMMON_CODE_TB WHERE SUBSTR(IDXKEY,5,14) = '".$DATE."') AS SEQ FROM DUAL
          ";
        }else if($WORK_DV=='03'){
          $sql = "
            SELECT (SELECT LPAD(COALESCE(MAX(SUBSTR(ID,19,2)),0)+1,2,0) FROM ORDER_TB WHERE SUBSTR(ID,5,14) = '".$DATE."') AS SEQ FROM DUAL
          ";
        }else if($WORK_DV=='04'){
          $sql = "
            SELECT (SELECT LPAD(COALESCE(MAX(SUBSTR(ID,19,2)),0)+1,2,0) FROM FORDER_BASE_TB WHERE SUBSTR(ID,5,14) = '".$DATE."') AS SEQ FROM DUAL
          ";
        }else if($WORK_DV=='05'){
          $sql = "
            SELECT (SELECT LPAD(COALESCE(MAX(SUBSTR(IDXKEY,19,2)),0)+1,2,0) FROM SUPPORT_BOARD_TB WHERE SUBSTR(IDXKEY,5,14) = '".$DATE."') AS SEQ FROM DUAL
          ";
        }else if($WORK_DV=='06'){
          $sql = "
            SELECT (SELECT LPAD(COALESCE(MAX(SUBSTR(IDXKEY,19,2)),0)+1,2,0) FROM LEDGER_TB WHERE SUBSTR(IDXKEY,5,14) = '".$DATE."') AS SEQ FROM DUAL
          ";
        }
        custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
        return $this->db->query($sql)->row()->SEQ;
      }
    }

    function getSearchProduct($keyword){
      $sql = "
        SELECT PRODUCT_NAME, PRODUCT_ID FROM PRODUCT_TB WHERE PRODUCT_NAME LIKE '%".$keyword."%'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getSearchOrder($FODID, $KEYWORD){
      $sql = "
      SELECT
          A.ORDER_ID
        , A.USER_ID
        , B.USER_NAME
        , C.CERTI_NAME
        FROM ORDER_TB A
        LEFT JOIN CERTIFICATE_TB C
        ON A.USER_ID = C.USER_ID
        , USER_TB B
        WHERE A.USER_ID = B.USER_ID
        AND A.FORDER_ID = '".$FODID."'
        AND (A.USER_ID LIKE '%".$KEYWORD."%' OR B.USER_NAME LIKE '%".$KEYWORD."%' OR C.CERTI_NAME LIKE '%".$KEYWORD."%')
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function searchPRDinOrderDetail($ODID, $PRD_ID){
      $sql = "
        SELECT CASE WHEN COUNT(1)>0 THEN 'Y' ELSE 'N' END AS IS_PRD
          FROM ORDER_ITEM_TB
          WHERE ORDER_ID = '".$ODID."'
            AND PRODUCT_ID = '".$PRD_ID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->row()->IS_PRD;
    }

    function addOrderDetail($ODID, $PRD_ID, $QTY){
      // 고객 등급에 따른 가격 입력이 되어야 할 듯
      $sql = "
        INSERT INTO ORDER_ITEM_TB(
          SELECT
        	  '".$ODID."'
        	, '".$PRD_ID."'
        	, '".$QTY."'
        	, CASE WHEN (SELECT USER_TYPE FROM USER_TB WHERE USER_ID = A.USER_ID) IN (1,2,3,4)
        	       THEN (SELECT PRODUCT_PRICE_WHOLESALE FROM PRODUCT_PRICE_TB WHERE PRODUCT_ID = '".$PRD_ID."' ORDER BY PRODUCT_TIME DESC LIMIT 1)
        	       WHEN (SELECT USER_TYPE FROM USER_TB WHERE USER_ID = A.USER_ID) = 5
        			 THEN (SELECT PRODUCT_PRICE_CUNSUMER FROM PRODUCT_PRICE_TB WHERE PRODUCT_ID = '".$PRD_ID."' ORDER BY PRODUCT_TIME DESC LIMIT 1)
        	  END AS ORDER_PRICE
        	, '0'
        	, '0'
        	FROM ORDER_TB A
        	   , ORDER_ITEM_TB B
          WHERE A.ORDER_ID = B.ORDER_ID
            AND B.ORDER_ID = '".$ODID."'
            LIMIT 1
        )
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function addForderDetail($FODID, $ODID, $PRD_ID, $QTY){
      $sql = "
        INSERT INTO FORDER_DETAIL_TB(
          SELECT
            '".$FODID."' AS ID
          , '".$PRD_ID."' AS PRODUCT_ID
          , '01' AS FORDER_DETAIL_DV
          , '".$QTY."' AS PRODUCT_AMOUNT
          , (CASE WHEN (SELECT USER_TYPE FROM USER_TB WHERE USER_ID = A.USER_ID) IN (1,2,3,4)
          	       THEN (SELECT PRODUCT_PRICE_WHOLESALE FROM PRODUCT_PRICE_TB WHERE PRODUCT_ID = '".$PRD_ID."' ORDER BY PRODUCT_TIME DESC LIMIT 1)
          	       WHEN (SELECT USER_TYPE FROM USER_TB WHERE USER_ID = A.USER_ID) = 5
          			 THEN (SELECT PRODUCT_PRICE_CUNSUMER FROM PRODUCT_PRICE_TB WHERE PRODUCT_ID = '".$PRD_ID."' ORDER BY PRODUCT_TIME DESC LIMIT 1)
          	  END)*3 AS PAY_PRICE
          , 'N' AS IS_PURCHASED
          , NULL
          , NULL
          , NULL
          , NULL
          FROM ORDER_TB A
          	   , ORDER_ITEM_TB B
            WHERE A.ORDER_ID = B.ORDER_ID
              AND B.ORDER_ID = '".$ODID."'
            LIMIT 1
        )
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function insertFORDER_BASE($HashMap){
      $sql ="
        INSERT INTO FORDER_BASE_TB(id,forder_dv,created)
        VALUES('".$HashMap['id']."','".$HashMap['forder_dv']."','".$HashMap['created']."')
      ";
      return $this->db->query($sql);
    }

    function deleteFORDER_BASEById($HashMap){
      $sql ="
        DELETE FROM FORDER_BASE_TB
        WHERE id = '".$HashMap['id']."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function setForderIDtoORDER($ORDER_ID,$FORDER_ID){
      $sql = "
        UPDATE ORDER_TB
        SET forder_id = '".$FORDER_ID."', order_stat = '20', is_forder='Y'
        WHERE order_id = '".$ORDER_ID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function unsetForderIDtoORDER($ORDER_ID,$FORDER_ID){
      $sql = "
        UPDATE ORDER_TB
        SET forder_id = '', order_stat = '10', is_forder='N'
        WHERE order_id = '".$ORDER_ID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function insertFORDER_DETAIL($hashmap,$id){
      $sql = "
        INSERT INTO FORDER_DETAIL_TB(id,product_id,product_amount,pay_price, forder_detail_dv)
        VALUES('".$id."','".$hashmap->ID."','".$hashmap->QTY."','".$hashmap->BUY_PRICE."','01')
      ";
      return $this->db->query($sql);
    }

    function deleteFORDER_DETAILById($id){
      $sql = "
        DELETE FROM FORDER_DETAIL_TB
        WHERE id = '".$id."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function updateForderMemo($param){
      $sql = "
        UPDATE FORDER_BASE_TB
        SET MEMO1 = '".$param['MEMO1']."'
          , MEMO2 = '".$param['MEMO2']."'
        WHERE ID = '".$param['FODID']."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function getForderRequestList($param,$mode,$url){
      $sql = "
      SELECT
          A.ID
         , A.FORDER_DV
         , E.CODE_NM AS FORDER_NM
         , CONCAT(SUBSTR(A.CREATED,1,4),'-',SUBSTR(A.CREATED,5,2),'-',SUBSTR(A.CREATED,7,2)) AS FORDER_DATE
         , CONCAT(C.PRODUCT_NAME, ' 포함 ', COUNT(1),' 품종') AS PRODUCT
         , SUM(B.PAY_PRICE) AS PAY_PRICE
         , A.PROGRESS
         , D.CODE_NM AS PROGRESS_NM
        FROM FORDER_BASE_TB A
           , FORDER_DETAIL_TB B
           , PRODUCT_TB C
           , (SELECT
                CODE_NM
              , CODE
                FROM COMMON_CODE_TB
               WHERE WORK_DV = '발주업무'
                 AND CODE_DV = '발주진행상태'
              ) D
           , (SELECT
                   CODE_NM
                 , CODE
                FROM COMMON_CODE_TB
               WHERE WORK_DV = '발주업무'
                 AND CODE_DV = '발주구분'
                 ) E
              WHERE A.ID = B.ID
         AND B.PRODUCT_ID = C.PRODUCT_ID
         AND A.PROGRESS = D.CODE
         AND A.FORDER_DV = E.CODE
         ";
      if(!empty($param['FOID'])){
        $sql = $sql."
          AND A.ID LIKE '%".$param['FOID']."%'
        ";
      }
      if(!empty($param['FRDT']) && !empty($param['TODT'])){
        $sql = $sql."
         AND SUBSTR(A.CREATED,1,8) BETWEEN '".str_replace("-","",$param['FRDT'])."' AND '".str_replace("-","",$param['TODT'])."'
        ";
      }
      if(!empty($param['PROGRESS'])){
        $sql = $sql."
          AND A.PROGRESS = '".$param['PROGRESS']."'
        ";
      }

      if($url=='writeForder'){
        $sql = $sql."
          AND A.PROGRESS IN ('10')
        ";
      }
      if($url=='writeModifiedForder'){
        $sql = $sql."
          AND A.PROGRESS IN ('20')
        ";
      }
      if($url=='writeConfirmedForder'){
        $sql = $sql."
          AND A.PROGRESS IN ('30')
        ";
      }
      if($url=='forderConfirm'){
        $sql = $sql."
          AND A.PROGRESS IN ('40')
        ";
      }
      $sql = $sql."
        GROUP BY A.ID
        ORDER BY A.CREATED DESC
      ";

      if(empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".((1*10)-10).",10
        ";
      }else if(!empty($param['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($param['PAGE']*10)-10).",10
        ";
      }

      $result = $this->db->query($sql);
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result->result());
      return $result;
    }

    function updateForderProgress($forderID,$PRG){
      $sql = "
        UPDATE FORDER_BASE_TB
        SET PROGRESS = '".$PRG."'
        WHERE ID = '".$forderID."'
      ";
      var_dump($sql);
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $this->db->query($sql);
    }

    function cancleForder($forderID){
      $sql = "
      UPDATE ORDER_TB
          SET FORDER_ID = ''
            , IS_FORDER = 'N'
        WHERE FORDER_ID = '".$forderID."'
      ";
      $this->db->query($sql);
      $sql = "
      UPDATE FORDER_BASE_TB
         SET PROGRESS = '99'
        WHERE ID = '".$forderID."'
      ";
      return $this->db->query($sql);
    }

    function updateOrderProgress($orderID,$PRG){
      $sql = "
        UPDATE ORDER_TB
        SET ORDER_STAT = '".$PRG."'
        WHERE ORDER_ID = '".$orderID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $this->db->query($sql);
    }

    function getOrderIDByFODID($FODID){
      $sql = "
      SELECT ORDER_ID FROM ORDER_TB
       WHERE FORDER_ID = '".$FODID."'
       AND IS_FORDER = 'Y'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function updateFORDER_DETAIL1($FODID,$hashMap,$mode){
      if($hashMap['IS_PURCHASED']=="Y" && $mode=='2'){
        $sql = "
          SELECT CASE WHEN COUNT(1)>0 THEN 'Y' ELSE 'N' END IS_DATE
          FROM PRODUCT_PRICE_TB
          WHERE PRODUCT_ID = '".$hashMap['PRD_ID']."'
          AND PRODUCT_TIME = SUBSTR(NOW()+0,1,8)
        ";
        $IS_DATE = $this->db->query($sql)->row()->IS_DATE;

        if($IS_DATE == "Y"){
          $sql="
            UPDATE PRODUCT_PRICE_TB
            SET PRODUCT_PRICE_SUPPLY = '".($hashMap['PRD_PRICE'])."'
              , PRODUCT_PRICE_WHOLESALE = '".($hashMap['PRD_PRICE']+1000)."'
              , PRODUCT_PRICE_CUNSUMER = '".($hashMap['PRD_PRICE']+2000)."'
            WHERE PRODUCT_ID = '".$hashMap['PRD_ID']."'
          ";
          $this->db->query($sql);
        }else{
          $sql="
            INSERT INTO PRODUCT_PRICE_TB
            VALUES(
              '".$hashMap['PRD_ID']."'
            , SUBSTR(NOW()+0,1,8)
            , '".($hashMap['PRD_PRICE'])."'
            , '".($hashMap['PRD_PRICE']+1000)."'
            , '".($hashMap['PRD_PRICE']+2000)."'
            )
          ";
          $this->db->query($sql);
        }
      }

      $sql = "
        UPDATE FORDER_DETAIL_TB
        SET PURCHASED_AMOUNT = '".$hashMap['PRD_QTY']."'
          , PURCHASED_PRICE = '".$hashMap['PRD_PRICE']."'
          , IS_PURCHASED = '".$hashMap['IS_PURCHASED']."'";
      if($hashMap['IS_PURCHASED'] == "N"){
        $sql=$sql."
          , FORDER_DETAIL_DV = '99'
        ";
      }
      $sql=$sql."
          , PURCHASED_SHOP = '".$hashMap['PURCHASE_SHOP']."'
          , MEMO = '".$hashMap['MEMO']."'
        WHERE ID = '".$FODID."'
          AND PRODUCT_ID = '".$hashMap['PRD_ID']."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function updateFORDER_DETAIL2($FODID,$hashMap,$mode){
      $sql = "
        SELECT FORDER_DETAIL_DV FROM FORDER_DETAIL_TB
        WHERE ID = '".$FODID."'
          AND PRODUCT_ID = '".$hashMap['PRD_ID']."'
      ";
      $FORDER_DETAIL_DV = $this->db->query($sql)->row()->FORDER_DETAIL_DV;

      $sql = "
        UPDATE FORDER_DETAIL_TB
        SET PURCHASED_AMOUNT = '".$hashMap['PRD_QTY']."'
          , PURCHASED_PRICE = '".$hashMap['PRD_PRICE']."'
          , IS_PURCHASED = '".$hashMap['IS_PURCHASED']."'";
      if($hashMap['IS_PURCHASED'] == "N"){
        $sql=$sql."
          , FORDER_DETAIL_DV = '99'
        ";
      }else{
        if($FORDER_DETAIL_DV == "01"){
          $sql=$sql."
            , FORDER_DETAIL_DV = '01'
          ";
        }else{
          $sql=$sql."
            , FORDER_DETAIL_DV = '02'
          ";
        }

      }
      $sql=$sql."
          , PURCHASED_SHOP = '".$hashMap['PURCHASE_SHOP']."'
          , MEMO = '".$hashMap['MEMO']."'
        WHERE ID = '".$FODID."'
          AND PRODUCT_ID = '".$hashMap['PRD_ID']."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function updateFORDER_BASE1($FODID,$deliveryFee,$submitMode,$memo1, $memo2){
      $sql = "
        SELECT PROGRESS FROM FORDER_BASE_TB WHERE ID = '".$FODID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      $PROGRESS = $this->db->query($sql)->row()->PROGRESS;
      if($PROGRESS=='20'){
        $PROGRESS = '30';
      }else if($PROGRESS=='30'){
        $PROGRESS = '40';
      }
      $sql = "
        UPDATE FORDER_BASE_TB
        SET DELIVERY_FEE = '".$deliveryFee."'
          , MEMO1 = '".$memo1."'
          , MEMO2 = '".$memo2."'
        ";
      if($submitMode==2){
        $sql = $sql."
          , PROGRESS = '".$PROGRESS."'
        ";
      }
      $sql = $sql."
        WHERE ID = '".$FODID."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function getCommonCode($WORK_DV,$CODE_DV){
      $sql = "
        SELECT
          CODE_NM
        , CODE
          FROM COMMON_CODE_TB
         WHERE WORK_DV = '".$WORK_DV."'
           AND CODE_DV = '".$CODE_DV."'
        ORDER BY CODE
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getAllCommonCode($getData,$mode){
      $sql = "
      SELECT
          IDXKEY
        , WORK_DV
        , CODE_DV
        , CODE_NM
        , CODE
        , IS_USE
        , CREATED
        FROM COMMON_CODE_TB
        WHERE 1=1
      ";
      if(!empty($getData['WORK_DV'])){
        $sql = $sql."
          AND WORK_DV = '".$getData['WORK_DV']."'
        ";
      }
      if(!empty($getData['CODE_DV'])){
        $sql = $sql."
          AND CODE_DV = '".$getData['CODE_DV']."'
        ";
      }
      if(!empty($getData['CODE_NM'])){
        $sql = $sql."
          AND CODE_NM = '".$getData['CODE_NM']."'
        ";
      }
      if(!empty($getData['CODE'])){
        $sql = $sql."
          AND CODE = '".$getData['CODE']."'
        ";
      }
      $sql = $sql."
        ORDER BY WORK_DV , CODE_DV, CODE
      ";
      if(empty($getData['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".((1*10)-10).",10
        ";
      }else if(!empty($getData['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($getData['PAGE']*10)-10).",10
        ";
      }
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function getWorkDV(){
      $sql = "
        SELECT DISTINCT(WORK_DV)
          FROM COMMON_CODE_TB
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function getCodeDV($WORK_DV){
      $sql = "
        SELECT DISTINCT(CODE_DV)
          FROM COMMON_CODE_TB
         WHERE WORK_DV = '".$WORK_DV."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->result();
    }

    function updateCommonCode($Param){
      $sql = "
        UPDATE COMMON_CODE_TB
           SET WORK_DV = '".$Param['WORK_DV']."'
             , CODE_DV = '".$Param['CODE_DV']."'
             , CODE_NM = '".$Param['CODE_NM']."'
             , CODE = '".$Param['CODE']."'
             , IS_USE = '".$Param['IS_USE']."'
         WHERE IDXKEY = '".$Param['IDX']."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function insertCommonCode($Param){
      $sql = "
        INSERT INTO COMMON_CODE_TB
        VALUES(
          '".$Param['IDX']."', '".$Param['WORK_DV']."', '".$Param['CODE_DV']."', '".$Param['CODE_NM']."', '".$Param['CODE']."', '".$Param['IS_USE']."', NOW()+0
          )
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function deleteCommonCode($Param){
      $sql = "
        DELETE FROM COMMON_CODE_TB
        WHERE IDXKEY = '".$Param['IDX']."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }
    function getSQL($sql){
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function getBoardByType($getData,$mode,$type){
      if($type == "01"){
        $column1 = "ROWNUM";
        $column2 = "ORDER BY ROWNUM DESC";
      }else if($type == "02"){
        $column1 = "(SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '게시판카테고리' AND CODE = CATEGORY) AS CATEGORY";
        $column2 = "ORDER BY ROWNUM DESC";
      }else if($type == "03"){
        $column1 = "(SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '게시판진행상태' AND CODE = BOARD_STAT) AS BOARD_STAT";
        $column2 = "ORDER BY ROWNUM DESC";
      }

      $sql = "
      SELECT
        IDXKEY
      , ".$column1;

      $sql = $sql."
      , ROWNUM
      , USER_ID
      , TITLE
      , TEXT
      , CREATED
      FROM SUPPORT_BOARD_TB
      WHERE BOARD_DV = '".$type."'";

      if(!empty($getData['ROWNUM'])){
        $sql = $sql."
          AND ROWNUM = '".$getData['ROWNUM']."'
        ";
      }
      if(!empty($getData['CATE'])){
        $sql = $sql."
          AND CATEGORY = '".$getData['CATE']."'
        ";
      }
      if(!empty($getData['TITLE'])){
        $sql = $sql."
          AND TITLE LIKE '%".$getData['TITLE']."%'
        ";
      }
      if(!empty($getData['TEXT'])){
        $sql = $sql."
          AND TEXT LIKE '%".$getData['TEXT']."%'
        ";
      }
      if(!empty($getData['PROGRESS'])){
        $sql = $sql."
          AND BOARD_STAT = '".$getData['PROGRESS']."'
        ";
      }
      $sql = $sql."
      ".$column2;
      if(empty($getData['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".((1*10)-10).",10
        ";
      }else if(!empty($getData['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($getData['PAGE']*10)-10).",10
        ";
      }
      $result = $this->db->query($sql);
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result->result());
      return $result;

    }

    function getBoardByID($id){
      $sql = "
        SELECT * FROM SUPPORT_BOARD_TB
        WHERE IDXKEY = '".$id."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql)->row();
    }

    function ajaxUpdateRetext($id, $retext){
      $sql = "
        UPDATE SUPPORT_BOARD_TB
        SET RETEXT = '".$retext."'
          , BOARD_STAT = '30'
        WHERE IDXKEY = '".$id."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function ajaxDeleteBoard($id){
      $sql = "
        DELETE FROM SUPPORT_BOARD_TB
        WHERE IDXKEY = '".$id."'
      ";
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $this->db->query($sql);
    }

    function ajaxWriteBoard($id, $title, $text, $type, $cate){
      $sql= "
        SELECT
            IF(MAX(ROWNUM) IS NULL,1,MAX(ROWNUM)+1) AS ROWNUM
          FROM SUPPORT_BOARD_TB
         WHERE BOARD_DV = '".$type."'";
      $ROW_NUM = $this->db->query($sql)->row()->ROWNUM;
      $sql = "
        INSERT INTO SUPPORT_BOARD_TB(IDXKEY, ROWNUM, BOARD_DV, ";

    if(!empty($cate)){
      $sql = $sql."
        CATEGORY,
      ";
    }

    $sql = $sql." TITLE, TEXT, USER_ID, BOARD_STAT ,CREATED)
        VALUES(
            '".$id."'
          , '".$ROW_NUM."'
          , '".$type."'
          ";

      if(!empty($cate)){
        $sql = $sql."
          , '".$cate."'
        ";
      }

      $sql = $sql."
          , '".$title."'
          , '".$text."'
          , '".$this->session->userdata('user_id')."'
          , '10'
          , NOW()+0
          )
      ";
      return $this->db->query($sql);
    }

    function ajaxUpdateBoard($id,$title,$text){
      $sql = "
        UPDATE SUPPORT_BOARD_TB
        SET TITLE = '".$title."'
          , TEXT = '".$text."'
        WHERE IDXKEY = '".$id."'
      ";
      return $this->db->query($sql);
    }

    function getBoardCate(){
      $sql = "
        SELECT
          CODE,
          CODE_NM
          FROM COMMON_CODE_TB
         WHERE CODE_DV = '게시판카테고리'
           AND IS_USE = 'Y'
      ";
      return $this->db->query($sql)->result();
    }

    function updateProductImage($PRODUCT_CD,$IMG_EXTENSION,$FILE_SISE){
      $sql = "
        UPDATE PRODUCT_TB
        SET IMG_EXTENSION = '".$IMG_EXTENSION."'
          , IMG_SIZE = '".$FILE_SISE."'
        WHERE PRODUCT_ID = '".$PRODUCT_CD."'
      ";
      return $this->db->query($sql);
    }

    function selectPRD($PRODUCT_CD){
      $sql = "
        SELECT CASE WHEN COUNT(1)>0 THEN 'Y' ELSE 'N' END AS IS_PRD FROM PRODUCT_TB
        WHERE PRODUCT_ID = '".$PRODUCT_CD."'
      ";
      return $this->db->query($sql)->row()->IS_PRD;
    }

    function getAccountGridDataByDays($param){
      $sql = "
      SELECT
      	  Z.ORDER_ID
      	, Z.FORDER_ID
      	, Z.DELIVERY_DATE
        , Z.DELIVERY_TYPE
        , Z.DELIVERY_FEE
      	, Z.USER_ID
      	, Z.USER_NAME
      	, Z.SHOP_NAME
      	, Z.PRODUCT_ID
      	, Z.PRODUCT_CATE
      	, Z.PRODUCT_NAME
      	, Z.PURCHASED_AMOUNT
      	, Z.ORDER_AMOUNT
      	, Z.ORDER_PRICE
      	, Z.PURCHASED_PRICE
      	, Z.IS_PURCHASED
      	, Z.ORDER_PRICE*Z.ORDER_AMOUNT AS TT_ORDER_PRICE
      	, Z.PURCHASED_PRICE*Z.ORDER_AMOUNT AS TT_PURCHASED_PRICE
      	, CASE WHEN Z.IS_PURCHASED = 'Y' THEN Z.ORDER_PRICE*Z.ORDER_AMOUNT - Z.PURCHASED_PRICE*Z.ORDER_AMOUNT ELSE 0 END AS BENEFIT
      	, Z.SUM_ORDER_PRICE + Z.DELIVERY_FEE AS SUM_ORDER_PRICE
      	, Z.SUM_PURCHASED_PRICE
      	, Z.SUM_ORDER_PRICE - Z.SUM_PURCHASED_PRICE AS SUM_BENEFIT
        , CASE WHEN Z.ORDER_STAT = 40 THEN '배송완료' ELSE '미배송' END AS IS_DELIVERY
        , Z.TT_EXPENSES
        , CASE WHEN Z.IS_PAID='Y' THEN '입금' ELSE '미입금' END AS IS_PAID
      	FROM
             (SELECT
                A.ORDER_ID
              , C.ID AS FORDER_ID
              , A.DELIVERY_DATE
              , A.USER_ID
              , D.USER_NAME
              , (SELECT CERTI_NAME FROM CERTIFICATE_TB WHERE USER_ID = A.USER_ID) AS SHOP_NAME
              , B.PRODUCT_ID
              , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '상품상세구분코드' AND CODE = E.PRODUCT_CATE_KIND) AS PRODUCT_CATE
              , E.PRODUCT_NAME
              , (SELECT PURCHASED_AMOUNT FROM FORDER_DETAIL_TB WHERE ID = C.ID AND PRODUCT_ID = B.PRODUCT_ID) AS PURCHASED_AMOUNT
              , B.ORDER_PRICE
              , B.ORDER_AMOUNT
              , (SELECT PURCHASED_PRICE FROM FORDER_DETAIL_TB WHERE ID = C.ID AND PRODUCT_ID = B.PRODUCT_ID) AS PURCHASED_PRICE
              , (SELECT IS_PURCHASED FROM FORDER_DETAIL_TB WHERE ID = C.ID AND PRODUCT_ID = B.PRODUCT_ID) AS IS_PURCHASED
              , (SELECT SUM(CASE WHEN CC.IS_PURCHASED = 'Y' THEN BB.ORDER_PRICE ELSE 0 END * BB.ORDER_AMOUNT)
                   FROM ORDER_TB AA ,ORDER_ITEM_TB BB ,FORDER_DETAIL_TB CC
                   WHERE AA.ORDER_ID = BB.ORDER_ID
                     AND AA.FORDER_ID = CC.ID
                    AND BB.PRODUCT_ID = CC.PRODUCT_ID
                    AND AA.ORDER_ID = A.ORDER_ID) AS SUM_ORDER_PRICE
               , (SELECT SUM(CASE WHEN CC.IS_PURCHASED = 'Y' THEN CC.PURCHASED_PRICE ELSE 0 END * BB.ORDER_AMOUNT)
                   FROM ORDER_TB AA ,ORDER_ITEM_TB BB  ,FORDER_DETAIL_TB CC
                  WHERE AA.ORDER_ID = BB.ORDER_ID
                    AND AA.FORDER_ID = CC.ID
                    AND BB.PRODUCT_ID = CC.PRODUCT_ID
                    AND AA.ORDER_ID = A.ORDER_ID) AS SUM_PURCHASED_PRICE
               , A.ORDER_STAT
               , A.IS_PAID
               , (SELECT SUM(CASE WHEN B.IS_PURCHASED = 'Y' THEN B.PURCHASED_AMOUNT ELSE 0 END * B.PURCHASED_PRICE)+A.DELIVERY_FEE FROM FORDER_BASE_TB A, FORDER_DETAIL_TB B WHERE A.ID = B.ID AND A.ID = A.FORDER_ID) AS TT_EXPENSES
               ,(SELECT CODE FROM COMMON_CODE_TB
          	      WHERE CODE_DV = '배송비'
          			    AND CODE_NM = (SELECT CODE_NM FROM COMMON_CODE_TB
          			                    WHERE CODE_DV = '배송방법'
          									          AND CODE = A.DELIVERY_TYPE)
          		   ) AS DELIVERY_FEE
               ,(SELECT CODE_NM FROM COMMON_CODE_TB
                  WHERE CODE_DV = '배송방법'
                    AND CODE = A.DELIVERY_TYPE
                   ) AS DELIVERY_TYPE
              FROM ORDER_TB A
                 , ORDER_ITEM_TB B
                 , FORDER_BASE_TB C
                 , USER_TB D
                 , PRODUCT_TB E
              WHERE A.ORDER_ID = B.ORDER_ID
               AND A.FORDER_ID = C.ID
               AND A.USER_ID = D.USER_ID
               AND C.PROGRESS = '40'
               AND B.PRODUCT_ID = E.PRODUCT_ID
               AND DELIVERY_DATE BETWEEN '".$param['FRDT']."' AND '".$param['TODT']."') Z
        ORDER BY Z.DELIVERY_DATE , Z.USER_ID , Z.PRODUCT_ID
      ";
      return $this->db->query($sql)->result();
    }

  function getAccountGridDataByDaysTT($param){
    $sql = "
    SELECT (
      SELECT SUM(ORDER_PRICE) AS ORDER_PRICE FROM (
        SELECT
          SUM(B.ORDER_AMOUNT * CASE WHEN C.IS_PURCHASED = 'Y' THEN B.ORDER_PRICE ELSE 0 END)
          + (SELECT CODE FROM COMMON_CODE_TB
              WHERE CODE_DV = '배송비'
              AND CODE_NM = (SELECT CODE_NM FROM COMMON_CODE_TB
                              WHERE CODE_DV = '배송방법'
                          AND CODE = A.DELIVERY_TYPE)
           ) AS ORDER_PRICE

        FROM ORDER_TB A
           , ORDER_ITEM_TB B
           , FORDER_DETAIL_TB C
        WHERE A.ORDER_ID = B.ORDER_ID
         AND A.FORDER_ID = C.ID
         AND B.PRODUCT_ID = C.PRODUCT_ID
         AND A.DELIVERY_DATE BETWEEN '".$param['FRDT']."' AND '".$param['TODT']."'
        GROUP BY A.ORDER_ID
      ) BB) AS ORDER_PRICE
      ,(
      SELECT SUM(PURCHASED_PRICE) AS PURCHASED_PRICE FROM (
      SELECT
         SUM(D.PURCHASED_AMOUNT * D.PURCHASED_PRICE) + C.DELIVERY_FEE AS PURCHASED_PRICE
        FROM FORDER_BASE_TB C
           , FORDER_DETAIL_TB D
       WHERE C.ID = D.ID
         AND (SELECT DELIVERY_DATE FROM ORDER_TB WHERE FORDER_ID = C.ID LIMIT 1) BETWEEN '".$param['FRDT']."' AND '".$param['TODT']."'
       GROUP BY C.ID
      ) AA) AS PURCHASED_PRICE
      FROM DUAL
    ";
    return $this->db->query($sql)->row();
  }

  function insertUserCertiInfo($param){
    $sql = "
      INSERT INTO CERTIFICATE_TB(USER_ID, CERTI_TYPE, CERTI_NAME, CERTI_NUM, CERTI_TEL_H, CERTI_TEL_B, CERTI_TEL_T)
      VALUES('".$param['USER_ID']."', 6, '".$param['SHOP_NM']."', '".$param['CERTI_NUM']."', NULL, NULL, NULL)
    ";
    return $this->db->query($sql);
  }

  function getPaymentInfo(){
    $sql = "
    SELECT
    (
  	SELECT
  	    CODE
  	  FROM COMMON_CODE_TB
  	 WHERE WORK_DV = '상점정보'
  	   AND CODE_DV = '결제정보'
  	   AND CODE_NM = '예금주명'
    ) AS HOLDER_NM
    , (
  	SELECT
  	   CODE
  	  FROM COMMON_CODE_TB
  	 WHERE WORK_DV = '상점정보'
  	   AND CODE_DV = '결제정보'
  	   AND CODE_NM = '입금계좌'
    ) AS BANK_ACCOUNTS
    , (
  	SELECT
  	    CODE
  	  FROM COMMON_CODE_TB
  	 WHERE WORK_DV = '상점정보'
  	   AND CODE_DV = '결제정보'
  	   AND CODE_NM = '입금은행'
    ) AS BANK_NM
    FROM DUAL
    ";
    custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
    return $this->db->query($sql)->row();
  }
}

?>
