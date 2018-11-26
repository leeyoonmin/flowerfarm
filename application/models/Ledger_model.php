<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 5.
 * Time: PM 1:50
 */

class Ledger_model extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->helper('custlog');
    }

    function getMonthData($year,$month,$day,$type){
      $sql = "
      SELECT
      	  AA.USER_ID
      	, AA.TYPE_NM
      	, AA.TYPE_CD
      	, AA.DATE
      	, SUM(AA.AMOUNT) AS AMOUNT
        FROM(
      SELECT
      	  A.USER_ID
      	, '지출' AS TYPE_NM
      	, '02' AS TYPE_CD
      	, SUBSTR(A.ORDER_TIME,1,8) AS DATE
       	, SUM(B.ORDER_PRICE*B.ORDER_AMOUNT)
      	  +(CASE WHEN A.DELIVERY_TYPE = '01'
      	         THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '직접배송')
      	         WHEN A.DELIVERY_TYPE = '02'
      	         THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '퀵서비스')
      	         WHEN A.DELIVERY_TYPE = '03'
      	         THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '택배배송')
      				ELSE 0 END) AS AMOUNT
      	, 'N' AS IS_LEDGER
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
       WHERE A.ORDER_ID = B.ORDER_ID
         AND A.ORDER_STAT <> 99
         AND A.USER_ID = '".$this->session->userdata('user_id')."'
         AND SUBSTR(A.ORDER_TIME,1,4) = '".$year."'";
         if(!empty($month)){
           $sql=$sql."
           AND SUBSTR(A.ORDER_TIME,5,2) = '".$month."'
           ";
         }
         if(!empty($day)){
           $sql=$sql."
           AND SUBSTR(A.ORDER_TIME,7,2) = '".$day."'
           ";
         }
      $sql=$sql."
       GROUP BY SUBSTR(A.ORDER_TIME,1,6)
       UNION ALL
       SELECT
        A.USER_ID
        , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '장부입출구분코드' AND CODE = A.TYPE) AS TYPE_NM
        , A.TYPE AS TYPE_CD
        , SUBSTR(A.DATE,1,8) AS DATE
        , SUM(A.AMOUNT) AS AMOUNT
        , 'Y' AS IS_LEDGER
        FROM LEDGER_TB A
           , LEDGER_CATE_TB B
        WHERE A.USER_ID = B.USER_ID
         AND A.TYPE = B.TYPE
         AND A.CATE = B.CATE_CODE
         AND SUBSTR(A.DATE,1,4) = '".$year."'";
         if(!empty($month)){
           $sql=$sql."
           AND SUBSTR(A.DATE,5,2) = '".$month."'
           ";
         }
         if(!empty($day)){
           $sql=$sql."
           AND SUBSTR(A.DATE,7,2) = '".$day."'
           ";
         }
      $sql=$sql."
         AND A.USER_ID = '".$this->session->userdata('user_id')."'
        GROUP BY A.USER_ID , A.TYPE, A.DATE
        ) AA
        WHERE 1=1
        GROUP BY TYPE_NM, TYPE_CD, DATE
        ";
        $result = $this->db->query($sql)->result();
        custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result);
        return $result;
    }

    function getMonthDataByMonth($year,$month,$day,$type){
      $sql = "
      SELECT
        AA.IDXKEY
      , AA.USER_ID
      , AA.TYPE_NM
      , AA.TYPE_CD
      , AA.CATE
      , AA.DATE
      , AA.DATE_STR
      , AA.AMOUNT
      , AA.IS_LEDGER
      , AA.TEXT
      FROM(
    SELECT
        A.ORDER_ID AS IDXKEY
      , A.USER_ID
      , '지출' AS TYPE_NM
      , '02' AS TYPE_CD
      , SUBSTR(A.ORDER_TIME,1,8) AS DATE
      , '꽃팜구매' AS CATE
      , CONCAT(SUBSTR(A.ORDER_TIME,1,4),'-',SUBSTR(A.ORDER_TIME,5,2),'-',SUBSTR(A.ORDER_TIME,7,2)) AS DATE_STR
      , SUM(B.ORDER_PRICE*B.ORDER_AMOUNT)
        +(CASE WHEN A.DELIVERY_TYPE = '01'
               THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '직접배송')
               WHEN A.DELIVERY_TYPE = '02'
               THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '퀵서비스')
               WHEN A.DELIVERY_TYPE = '03'
               THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '택배배송')
            ELSE 0 END) AS AMOUNT
      , 'N' AS IS_LEDGER
      , CONCAT((SELECT PRODUCT_NAME FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID),'외 ',COUNT(1),'종') AS TEXT
      FROM ORDER_TB A
         , ORDER_ITEM_TB B
     WHERE A.ORDER_ID = B.ORDER_ID
       AND A.ORDER_STAT <> 99
     GROUP BY USER_ID, SUBSTR(A.ORDER_TIME,1,8)
     UNION ALL
     SELECT
        A.IDXKEY AS IDXKEY
      , A.USER_ID
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '장부입출구분코드' AND CODE = A.TYPE) AS TYPE_NM
      , A.TYPE AS TYPE_CD
      , SUBSTR(A.DATE,1,8) AS DATE
      , B.CATE_NAME AS CATE
      , CONCAT(SUBSTR(A.DATE,1,4),'-',SUBSTR(A.DATE,5,2),'-',SUBSTR(A.DATE,7,2)) AS DATE_STR
      , A.AMOUNT
      , 'Y' AS IS_LEDGER
      , A.TEXT
      FROM LEDGER_TB A
         , LEDGER_CATE_TB B
      WHERE A.USER_ID = B.USER_ID
       AND A.TYPE = B.TYPE
       AND A.CATE = B.CATE_CODE
      ) AA
      WHERE 1=1
      AND AA.USER_ID = '".$this->session->userdata('user_id')."'
      AND SUBSTR(AA.DATE,1,4) = '".$year."'
      AND SUBSTR(AA.DATE,5,2) = '".$month."'
      ";
      if($day!="00"){
        $sql = $sql."
          AND SUBSTR(AA.DATE,7,2) = '".$day."'
        ";
      }
      if(!empty($type)){
        $sql = $sql."
          AND AA.TYPE_CD = '".$type."'
        ";
      }
      $sql = $sql."
        ORDER BY DATE_STR
      ";
      $result = $this->db->query($sql)->result();
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result);
      return $result;
    }

    function getDailyData($year,$month,$type){
      $sql = "
      SELECT
       AA.TYPE_NM
      , AA.TYPE_CD
      , AA.DATE
      , AA.DATE_STR
      , SUM(AA.AMOUNT) AS AMOUNT
      FROM(
    SELECT
    	  A.USER_ID
      , '지출' AS TYPE_NM
      , '02' AS TYPE_CD
      , SUBSTR(A.ORDER_TIME,1,8) AS DATE
      , CONCAT(SUBSTR(A.ORDER_TIME,1,4),'년 ',SUBSTR(A.ORDER_TIME,5,2),'월') AS DATE_STR
      , SUM(B.ORDER_PRICE*B.ORDER_AMOUNT)
        +(CASE WHEN A.DELIVERY_TYPE = '01'
               THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '직접배송')
               WHEN A.DELIVERY_TYPE = '02'
               THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '퀵서비스')
               WHEN A.DELIVERY_TYPE = '03'
               THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '택배배송')
            ELSE 0 END) AS AMOUNT
      FROM ORDER_TB A
         , ORDER_ITEM_TB B
     WHERE A.ORDER_ID = B.ORDER_ID
       AND A.ORDER_STAT <> 99
     GROUP BY USER_ID, SUBSTR(A.ORDER_TIME,1,8)

     UNION ALL

     SELECT
     	 A.USER_ID
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '장부입출구분코드' AND CODE = A.TYPE) AS TYPE_NM
      , A.TYPE AS TYPE_CD
      , SUBSTR(A.DATE,1,8) AS DATE
      , CONCAT(SUBSTR(A.DATE,1,4),'년 ',SUBSTR(A.DATE,5,2),'월') AS DATE_STR
      , A.AMOUNT
      FROM LEDGER_TB A
         , LEDGER_CATE_TB B
      WHERE A.USER_ID = B.USER_ID
       AND A.TYPE = B.TYPE
       AND A.CATE = B.CATE_CODE
      ) AA
      WHERE 1=1
      AND AA.USER_ID = '".$this->session->userdata('user_id')."'
      AND SUBSTR(AA.DATE,1,4) = '".$year."'
      AND SUBSTR(AA.DATE,5,2) = '".str_pad($month,2,0, STR_PAD_LEFT)."'
      GROUP BY AA.DATE , AA.TYPE_CD
      ";
      $result = $this->db->query($sql)->result();
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result);
      return $result;
    }

    function getCateByType($type){
      $sql = "
      SELECT
          CATE_CODE
        , CATE_NAME
        FROM LEDGER_CATE_TB
        WHERE USER_ID = '".$this->session->userdata('user_id')."'
        AND TYPE = '".$type."'
      ";
      $result = $this->db->query($sql)->result();
      custlogR('sql',__class__,__function__,$this->session->userdata('user_id'),$sql,$result);
      return $result;
    }

    function insertLedger($hashMap){
      $sql = "
      INSERT INTO LEDGER_TB(IDXKEY, USER_ID, TYPE, CATE, DATE, AMOUNT, TEXT)
      VALUES(
          '".$hashMap['IDXKEY']."'
        , '".$hashMap['USER_ID']."'
        , '".$hashMap['TYPE']."'
        , '".$hashMap['CATE']."'
        , '".$hashMap['DATE']."000000"."'
        , '".$hashMap['AMOUNT']."'
        , '".$hashMap['TEXT']."'
        )
      ";
      $result = $this->db->query($sql);
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $result;
    }
    function updateLedger($hashMap){
      $sql = "
        UPDATE LEDGER_TB
        SET TYPE = '".$hashMap['TYPE']."'
        , CATE = '".$hashMap['CATE']."'
        , DATE = '".$hashMap['DATE']."000000"."'
        , AMOUNT = '".$hashMap['AMOUNT']."'
        , TEXT = '".$hashMap['TEXT']."'
        WHERE IDXKEY = '".$hashMap['IDXKEY']."'
      ";
      $result = $this->db->query($sql);
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $result;
    }

    function getLedgerByIDXKEY($IDXKEY,$IS_LEDGER){
      if($IS_LEDGER == 'Y'){
        $sql = "
        SELECT
           A.IDXKEY AS IDXKEY
         , A.USER_ID
         , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '장부입출구분코드' AND CODE = A.TYPE) AS TYPE_NM
         , A.TYPE AS TYPE_CD
         , SUBSTR(A.DATE,1,8) AS DATE
         , B.CATE_CODE AS CATE_CD
         , B.CATE_NAME AS CATE
         , CONCAT(SUBSTR(A.DATE,1,4),'-',SUBSTR(A.DATE,5,2),'-',SUBSTR(A.DATE,7,2)) AS DATE_STR
         , A.AMOUNT
         , 'Y' AS IS_LEDGER
         , A.TEXT
         FROM LEDGER_TB A
            , LEDGER_CATE_TB B
         WHERE A.USER_ID = B.USER_ID
           AND A.TYPE = B.TYPE
           AND A.CATE = B.CATE_CODE
           AND A.IDXKEY = '".$IDXKEY."'
        ";
      }else{
        $sql = "
        SELECT
            A.ORDER_ID AS IDXKEY
          , A.USER_ID
          , '지출' AS TYPE_NM
          , '02' AS TYPE_CD
          , SUBSTR(A.ORDER_TIME,1,8) AS DATE
          , '꽃팜구매' AS CATE
          , CONCAT(SUBSTR(A.ORDER_TIME,1,4),'-',SUBSTR(A.ORDER_TIME,5,2),'-',SUBSTR(A.ORDER_TIME,7,2)) AS DATE_STR
          , SUM(B.ORDER_PRICE*B.ORDER_AMOUNT)
            +(CASE WHEN A.DELIVERY_TYPE = '01'
                   THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '직접배송')
                   WHEN A.DELIVERY_TYPE = '02'
                   THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '퀵서비스')
                   WHEN A.DELIVERY_TYPE = '03'
                   THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '택배배송')
                ELSE 0 END) AS AMOUNT
          , 'N' AS IS_LEDGER
          , CONCAT((SELECT PRODUCT_NAME FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID),'외 ',COUNT(1),'종') AS TEXT
          FROM ORDER_TB A
             , ORDER_ITEM_TB B
         WHERE A.ORDER_ID = B.ORDER_ID
           AND A.ORDER_STAT <> 99
           AND A.ORDER_ID = '".$IDXKEY."'
         GROUP BY USER_ID, SUBSTR(A.ORDER_TIME,1,8)
        ";
      }

      $result = $this->db->query($sql)->row();
      custlog('sql',__class__,__function__,$this->session->userdata('user_id'),$sql);
      return $result;
    }

    function deleteLedgerByIDXKEY($IDXKEY){
      $sql="
        DELETE FROM LEDGER_TB
        WHERE IDXKEY = '".$IDXKEY."'
      ";
      return $this->db->query($sql);
    }

    function deleteCate($TYPE, $CATE){
      $sql = "
        DELETE FROM LEDGER_CATE_TB
        WHERE USER_ID = '".$this->session->userdata('user_id')."'
        AND TYPE = '".$TYPE."'
        AND CATE_CODE = '".$CATE."'
      ";
      return $this->db->query($sql);
    }

    function checkCATE_SEQ($cate,$type){
      $sql="
      SELECT CASE WHEN COUNT(1)>0 THEN 'Y' ELSE 'N' END AS IS_SEQ
        FROM LEDGER_CATE_TB
       WHERE USER_ID = '".$this->session->userdata('user_id')."'
         AND TYPE = '".$type."'
         AND CATE_CODE = '".$cate."'
      ";
      return $this->db->query($sql)->row()->IS_SEQ;
    }

    function insertLedgerCate($type, $cate, $text){
      $sql = "
        INSERT INTO LEDGER_CATE_TB(USER_ID, TYPE, CATE_CODE, CATE_NAME)
        VALUES('".$this->session->userdata('user_id')."', '".$type."', '".$cate."', '".$text."')
      ";
      return $this->db->query($sql);
    }

    function updateLedgerCate($type, $cate, $text){
      $sql = "
        UPDATE LEDGER_CATE_TB
        SET CATE_NAME = '".$text."'
        WHERE USER_ID = '".$this->session->userdata('user_id')."'
        AND TYPE = '".$type."'
        AND CATE_CODE = '".$cate."'
      ";
      return $this->db->query($sql);
    }

    function getChartData($year, $month){
      $sql = "
      SELECT
         AA.TYPE_NM
        , AA.TYPE_CD
        , AA.CATE
        , AA.CATE_CD
        , SUM(AA.AMOUNT) AS AMOUNT
        FROM(
          SELECT
              A.ORDER_ID AS IDXKEY
            , A.USER_ID
            , '지출' AS TYPE_NM
            , '02' AS TYPE_CD
            , SUBSTR(A.ORDER_TIME,1,8) AS DATE
            , '꽃팜구매' AS CATE
            , '00' AS CATE_CD
            , CONCAT(SUBSTR(A.ORDER_TIME,1,4),'-',SUBSTR(A.ORDER_TIME,5,2),'-',SUBSTR(A.ORDER_TIME,7,2)) AS DATE_STR
            , SUM(B.ORDER_PRICE*B.ORDER_AMOUNT)
              +(CASE WHEN A.DELIVERY_TYPE = '01'
                     THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '직접배송')
                     WHEN A.DELIVERY_TYPE = '02'
                     THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '퀵서비스')
                     WHEN A.DELIVERY_TYPE = '03'
                     THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '택배배송')
                  ELSE 0 END) AS AMOUNT
            , 'N' AS IS_LEDGER
            , CONCAT((SELECT PRODUCT_NAME FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID),'외 ',COUNT(1),'종') AS TEXT
            FROM ORDER_TB A
               , ORDER_ITEM_TB B
           WHERE A.ORDER_ID = B.ORDER_ID
             AND A.ORDER_STAT <> 99
           GROUP BY USER_ID, SUBSTR(A.ORDER_TIME,1,8)
           UNION ALL
           SELECT
              A.IDXKEY AS IDXKEY
            , A.USER_ID
            , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '장부입출구분코드' AND CODE = A.TYPE) AS TYPE_NM
            , A.TYPE AS TYPE_CD
            , SUBSTR(A.DATE,1,8) AS DATE
            , B.CATE_NAME AS CATE
            , B.CATE_CODE AS CATE_CD
            , CONCAT(SUBSTR(A.DATE,1,4),'-',SUBSTR(A.DATE,5,2),'-',SUBSTR(A.DATE,7,2)) AS DATE_STR
            , A.AMOUNT
            , 'Y' AS IS_LEDGER
            , A.TEXT
            FROM LEDGER_TB A
               , LEDGER_CATE_TB B
            WHERE A.USER_ID = B.USER_ID
             AND A.TYPE = B.TYPE
             AND A.CATE = B.CATE_CODE
            ) AA
            WHERE 1=1
            AND AA.USER_ID = '".$this->session->userdata('user_id')."'
            AND SUBSTR(DATE,1,4) = '".$year."'";
            if(!empty($month)){
              $sql = $sql."
              AND SUBSTR(DATE,5,2) = lpad('".$month."',2,0)";
            }
            $sql = $sql."
            GROUP BY CATE
            ORDER BY TYPE_CD, AMOUNT DESC
      ";
      return $this->db->query($sql)->result();
    }

    function getChartData2($year,$type,$cate){
      $sql = "
      SELECT
         AA.TYPE_NM
        , AA.TYPE_CD
        , AA.CATE
        , AA.CATE_CD
        ,SUBSTR(AA.DATE,5,2) AS MONTH
        , AA.AMOUNT AS AMOUNT
        FROM(
          SELECT
              A.ORDER_ID AS IDXKEY
            , A.USER_ID
            , '지출' AS TYPE_NM
            , '02' AS TYPE_CD
            , SUBSTR(A.ORDER_TIME,1,8) AS DATE
            , '꽃팜구매' AS CATE
            , '00' AS CATE_CD
            , CONCAT(SUBSTR(A.ORDER_TIME,1,4),'-',SUBSTR(A.ORDER_TIME,5,2),'-',SUBSTR(A.ORDER_TIME,7,2)) AS DATE_STR
            , SUM(B.ORDER_PRICE*B.ORDER_AMOUNT)
              +(CASE WHEN A.DELIVERY_TYPE = '01'
                     THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '직접배송')
                     WHEN A.DELIVERY_TYPE = '02'
                     THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '퀵서비스')
                     WHEN A.DELIVERY_TYPE = '03'
                     THEN (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = '택배배송')
                  ELSE 0 END) AS AMOUNT
            , 'N' AS IS_LEDGER
            , CONCAT((SELECT PRODUCT_NAME FROM PRODUCT_TB WHERE PRODUCT_ID = B.PRODUCT_ID),'외 ',COUNT(1),'종') AS TEXT
            FROM ORDER_TB A
               , ORDER_ITEM_TB B
           WHERE A.ORDER_ID = B.ORDER_ID
             AND A.ORDER_STAT <> 99
           GROUP BY USER_ID, SUBSTR(A.ORDER_TIME,1,8)
           UNION ALL
           SELECT
              A.IDXKEY AS IDXKEY
            , A.USER_ID
            , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '장부입출구분코드' AND CODE = A.TYPE) AS TYPE_NM
            , A.TYPE AS TYPE_CD
            , SUBSTR(A.DATE,1,8) AS DATE
            , B.CATE_NAME AS CATE
            , B.CATE_CODE AS CATE_CD
            , CONCAT(SUBSTR(A.DATE,1,4),'-',SUBSTR(A.DATE,5,2),'-',SUBSTR(A.DATE,7,2)) AS DATE_STR
            , A.AMOUNT
            , 'Y' AS IS_LEDGER
            , A.TEXT
            FROM LEDGER_TB A
               , LEDGER_CATE_TB B
            WHERE A.USER_ID = B.USER_ID
             AND A.TYPE = B.TYPE
             AND A.CATE = B.CATE_CODE
            ) AA
            WHERE 1=1
            AND AA.USER_ID = '".$this->session->userdata('user_id')."'
            AND SUBSTR(DATE,1,4) = '".$year."'
            AND AA.TYPE_CD = '".$type."'
            AND AA.CATE_CD = '".$cate."'
            GROUP BY MONTH
            ORDER BY CAST(MONTH as SIGNED)
      ";
      return $this->db->query($sql)->result();
    }
}


?>
