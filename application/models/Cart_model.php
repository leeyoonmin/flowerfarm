<?php
class Cart_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getDeliveryInfo(){
      $sql = "
        SELECT
              A.CODE AS DELIVERY_CODE
            , A.CODE_NM AS DELIVERY_TYPE
            , B.CODE AS DELIVERY_FEE
          FROM COMMON_CODE_TB A
             , COMMON_CODE_TB B
         WHERE A.CODE_DV = '배송방법'
           AND B.CODE_DV = '배송비'
           AND A.CODE_NM = B.CODE_NM
      ";
      return $this->db->query($sql)->result();
    }

    public function getStockCheck($id,$qty){
      $sql = "
        SELECT
          CASE WHEN PRODUCT_AMOUNT >= ".$qty." THEN 'Y' ELSE 'N' END AS IS_STOCK
          FROM PRODUCT_TB
         WHERE PRODUCT_ID = '".$id."'
      ";
      return $this->db->query($sql)->row();
    }
}
