<?php
class Common_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function getShopInfo(){
      $sql = "
        SELECT
              CODE
            , CODE_NM
          FROM COMMON_CODE_TB
         WHERE CODE_DV = '상점정보'
           AND IS_USE = 'Y'
      ";
      return $this->db->query($sql)->result();
    }
}
