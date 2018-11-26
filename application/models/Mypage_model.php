<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 5.
 * Time: PM 1:50
 */

class mypage_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }
    function get_pw($id){
        $data = $this->db->query("SELECT user_pw FROM USER_TB WHERE user_id='$id'")->result();
        foreach ($data as $row){
            return $row->user_pw;
        }
    }
    function get_user($id){
        return $this->db->query("SELECT user_name, user_cellphone, user_pw, user_type, user_addr FROM USER_TB
                                 WHERE user_id='$id'")->result();
    }
    function modify($data,$column,$id,$table){
        $this->db->query("UPDATE $table SET $column='$data' WHERE user_id='$id'");
    }
    function get_order($id){ //product_id 가져오도록 수정
        return $this->db->query("SELECT b.order_item_index, a.order_id, a.order_time, b.product_id, c.product_name, c.product_id, a.is_paid, b.order_amount, b.order_price FROM ORDER_TB AS a
                                 JOIN ORDER_ITEM_TB AS b ON a.order_id = b.order_id
                                 JOIN PRODUCT_TB AS c ON b.product_id=c.product_id
                                 WHERE a.user_id='$id'ORDER BY order_id DESC")->result();
    }
    function get_latest_order($id,$start_index){

        return $this->db->query("SELECT order_id, order_time,order_index FROM ORDER_TB
                                 WHERE user_id='$id' AND order_index<=$start_index AND $start_index-5<order_index
                                 ORDER BY order_id DESC")->result();
    }
    function get_detail($orderid,$id){
        return $this->db->query("SELECT a.order_time, b.product_id, c.product_name, b.order_amount, b.order_price, d.recip_name, d.recip_phone, d.user_addr, d.user_addr_details, a.is_paid, a.pay_type FROM ORDER_TB AS a
                                 JOIN ORDER_ITEM_TB AS b ON a.order_id = b.order_id
                                 JOIN PRODUCT_TB AS c ON b.product_id=c.product_id
                                 JOIN USER_ADDRESS_TB AS d ON a.order_id =d.order_id
                                 WHERE a.order_id='$orderid' AND a.user_id='$id' ")->result();
    }
    function get_largest_index($id){
        return $this->db->query("SELECT MAX(order_index) AS start_index FROM ORDER_TB WHERE user_id='$id'")->row();



    }
    function delete_order_item($id,$order_item_index,$order_id){
        $count=$this->db->query("SELECT COUNT(*) AS count FROM ORDER_ITEM_TB WHERE order_id='$order_id'")->row()->count;
        if($count==1){

            $delete_index= $this->db->query("SELECT order_index FROM ORDER_TB WHERE order_id= '$order_id' AND user_id= '$id'")->row()->order_index;
            $max_index= $this->db->query("SELECT MAX(order_index) AS order_index FROM ORDER_TB WHERE user_id='$id'")->row()->order_index;

            $this->db->query("DELETE FROM ORDER_ITEM_TB WHERE order_item_index='$order_item_index'");
            $this->db->query("DELETE FROM ORDER_TB WHERE user_id='$id'AND order_id='$order_id'");
            $this->db->query("DELETE FROM USER_ADDRESS_TB WHERE user_id='$id'AND order_id='$order_id'");

            if($delete_index<$max_index){
                for($i=$delete_index+1; $i<=$max_index; $i++){
                    $this->db->query("UPDATE ORDER_TB SET order_index= $i-1 WHERE user_id='$id' AND order_index=$i ");
                }
            }    // 주문 목록 지울때 order_index 재정렬

        }
        else{
            $this->db->query("DELETE FROM ORDER_ITEM_TB WHERE order_item_index='$order_item_index'");

        }

    }

    function getThisMonthOrder($userID){
      $sql="
      SELECT
        SUM(ORDER_PRICE) + SUM(DELIVERY_FEE) AS MONTH_PRICE
        FROM(
        SELECT
          A.ORDER_ID
        , DELIVERY_TYPE
        , COUNT(1) AS COUNT
        , SUM(B.ORDER_PRICE * B.ORDER_AMOUNT) AS ORDER_PRICE
        , (SELECT
             BB.CODE
            FROM COMMON_CODE_TB AA
               , COMMON_CODE_TB BB
           WHERE AA.WORK_DV ='주문업무'
             AND AA.CODE_DV='배송방법'
             AND AA.CODE = A.DELIVERY_TYPE
             AND AA.WORK_DV = BB.WORK_DV
             AND BB.CODE_DV='배송비'
             AND AA.CODE_NM = BB.CODE_NM) AS DELIVERY_FEE
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
        WHERE USER_ID = '".$userID."'
          AND A.ORDER_ID = B.ORDER_ID
          AND SUBSTR(A.ORDER_TIME,1,6) = SUBSTR(NOW()+0,1,6)
          AND ORDER_STAT <> '99'
        GROUP BY ORDER_ID
        ) MONTH
      ";
      return  $this->db->query($sql)->row()->MONTH_PRICE;
    }

    function getThisWeekOrder($userID){
      $timestamp = strtotime("-1 week");
      $sql="
      SELECT
        SUM(ORDER_PRICE) + SUM(DELIVERY_FEE) AS MONTH_PRICE
        FROM(
        SELECT
          A.ORDER_ID
        , DELIVERY_TYPE
        , COUNT(1) AS COUNT
        , SUM(B.ORDER_PRICE * B.ORDER_AMOUNT) AS ORDER_PRICE
        , (SELECT
             BB.CODE
            FROM COMMON_CODE_TB AA
               , COMMON_CODE_TB BB
           WHERE AA.WORK_DV ='주문업무'
             AND AA.CODE_DV='배송방법'
             AND AA.CODE = A.DELIVERY_TYPE
             AND AA.WORK_DV = BB.WORK_DV
             AND BB.CODE_DV='배송비'
             AND AA.CODE_NM = BB.CODE_NM) AS DELIVERY_FEE
        FROM ORDER_TB A
           , ORDER_ITEM_TB B
        WHERE USER_ID = '".$userID."'
          AND A.ORDER_ID = B.ORDER_ID
          AND SUBSTR(A.ORDER_TIME,1,8) BETWEEN '".date("Ymd", $timestamp)."' AND '".date("Ymd", time())."'
          AND ORDER_STAT <> '99'
        GROUP BY ORDER_ID
        ) MONTH
      ";
      return  $this->db->query($sql)->row()->MONTH_PRICE;
    }

    function getUserAddr($id){
      $sql="
      SELECT
         CONCAT('(',recip_postcode,')',recip_addr, recip_addr_details) AS ADDR
        , CONCAT(recip_tel_h, '-', recip_tel_b, '-', recip_tel_t) AS TEL
        , user_addr_default AS IS_DEFAULT
        FROM USER_ADDRESS_TB
        WHERE USER_ID = '".$id."'
          AND user_addr_default = 'Y'
      ";
    }

    function getBoardCate(){
      $sql="
        SELECT
          CODE, CODE_NM
          FROM COMMON_CODE_TB
         WHERE CODE_DV = '게시판카테고리'
           AND IS_USE = 'Y'
      ";
      return  $this->db->query($sql)->result();
    }

    function getBoardByType($getData,$mode,$type){
      if($type == "01"){
        $column1 = "ROWNUM";
        $column2 = "ORDER BY ROWNUM DESC";
      }else if($type == "02"){
        $column1 = "(SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '게시판카테고리' AND CODE = CATEGORY) AS CATEGORY";
        $column2 = "ORDER BY CATEGORY DESC";
      }else if($type == "03"){
        $column1 = "(SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '게시판진행상태' AND CODE = BOARD_STAT) AS BOARD_STAT , BOARD_STAT AS BOARD_STAT_CD";
        $column2 = "ORDER BY ROWNUM DESC";
      }

      $sql = "
      SELECT
        IDXKEY
      , ".$column1."
      , TITLE
      , TEXT
      , RETEXT
      , CREATED
      FROM SUPPORT_BOARD_TB
      WHERE BOARD_DV = '".$type."'";

      if($type == '03'){
        $sql = $sql."
          AND USER_ID = '".$this->session->userdata('user_id')."'
        ";
      }

      $sql = $sql.$column2."
      ";

      if(empty($getData['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".((1*5)-5).",5
        ";
      }else if(!empty($getData['PAGE']) && $mode=="IQY"){
        $sql = $sql."
        limit ".(($getData['PAGE']*5)-5).",5
        ";
      }

      return $this->db->query($sql);
    }

    function insertBoard($hashMap,$type){
      $sql= "
        SELECT
            IF(MAX(ROWNUM) IS NULL,1,MAX(ROWNUM)+1) AS ROWNUM
          FROM SUPPORT_BOARD_TB
         WHERE BOARD_DV = '".$type."'";
      $ROW_NUM = $this->db->query($sql)->row()->ROWNUM;
      $sql="
        INSERT INTO SUPPORT_BOARD_TB(IDXKEY, ROWNUM, BOARD_DV, TITLE, TEXT, USER_ID, BOARD_STAT, CREATED)
        VALUES('".$hashMap['id']."', '".$ROW_NUM."', '03', '".$hashMap['title']."', '".$hashMap['text']."', '".$this->session->userdata('user_id')."', '20', NOW()+0)
      ";
      return $this->db->query($sql);
    }

    function deleteBoardByID($idxkey){
      $sql = "
        DELETE FROM SUPPORT_BOARD_TB
        WHERE IDXKEY = '".$idxkey."'
      ";
      return $this->db->query($sql);
    }

    function getBoardByID($idxkey){
      $sql = "
        SELECT * FROM SUPPORT_BOARD_TB
        WHERE IDXKEY = '".$idxkey."'
      ";
      return $this->db->query($sql)->row();
    }

    function updateBoard($hashMap){
      $sql = "
        UPDATE SUPPORT_BOARD_TB
        SET TITLE = '".$hashMap['title']."'
          , TEXT = '".$hashMap['text']."'
        WHERE IDXKEY = '".$hashMap['idxkey']."'
      ";
      return $this->db->query($sql);
    }

    function getTradingStatement($ORDER_ID){
      $sql = "
      SELECT
         CONCAT((SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '상품상세구분코드' AND CODE = C.PRODUCT_CATE_KIND),'_',C.PRODUCT_NAME) AS PRODUCT_NAME
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '상품색상구분코드' AND CODE = C.PRODUCT_CATE_COLOR) AS COLOR
      , B.ORDER_AMOUNT AS QTY
      , B.ORDER_PRICE AS PRICE
      , B.ORDER_AMOUNT * B.ORDER_PRICE AS TT_PRICE
      , E.IS_PURCHASED
      , CASE WHEN E.IS_PURCHASED = 'N' THEN '취소' END AS MEMO
      , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '배송방법' AND CODE = A.DELIVERY_TYPE) AS DELIVERY_TYPE
      , A.ORDER_TIME
      , (SELECT CODE FROM COMMON_CODE_TB WHERE CODE_DV = '배송비' AND CODE_NM = (SELECT CODE_NM FROM COMMON_CODE_TB WHERE CODE_DV = '배송방법' AND CODE = A.DELIVERY_TYPE)) AS DELIVERY_FEE
      , A.USER_ID
      , (SELECT USER_NAME FROM USER_TB WHERE USER_ID = A.USER_ID) AS USER_NM
    	, (SELECT CERTI_NAME FROM CERTIFICATE_TB WHERE USER_ID = A.USER_ID) AS SHOP_NM
      , A.FORDER_ID
      , D.PROGRESS
      FROM ORDER_TB A
         , ORDER_ITEM_TB B
         , PRODUCT_TB C
         , FORDER_BASE_TB D
         , FORDER_DETAIL_TB E
      WHERE A.ORDER_ID = B.ORDER_ID
       AND B.PRODUCT_ID = C.PRODUCT_ID
       AND A.FORDER_ID = D.ID
       AND E.ID = D.ID
       AND E.PRODUCT_ID = B.PRODUCT_ID
       AND A.ORDER_ID = '".$ORDER_ID."'
      ";
      return $this->db->query($sql)->result();
    }
}

?>
