<?php
class User_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    // 회원 정보 입력
    function add($inputs)
    {
        $this->db->set('user_created', 'NOW()+0', false);
        $check = $this->db->insert('USER_TB', array(
                        'user_id' => $inputs['id'],
                        'user_name' => $inputs['name'],
                        'user_pw' => $inputs['pw'],
                        'user_type' => $inputs['type'],
                        'user_tel_h' => $inputs['tel1'],
                        'user_tel_b' => $inputs['tel2'],
                        'user_tel_t' => $inputs['tel3'],
            ));

        return $check;
    }

    // 회원 정보 가져오기
    function get($user_id)
    {
        return $this->db->get_where('USER_TB', array('user_id'=>$user_id))->row();
    }

    function checkID($ID){
      $sql = "
      SELECT
        IF(COUNT(1)>0,'Y','N') AS DUPLICATE
        FROM USER_TB
        WHERE USER_ID = '".$ID."'
      ";
      return $this->db->query($sql)->row();
    }

    function getPasswordByID($id){
      $sql = "
        SELECT
          USER_PW
          FROM USER_TB
          WHERE USER_ID = '".$id."'
      ";
      return $this->db->query($sql)->row();
    }
    function findUserID($name,$tel1,$tel2,$tel3){
      $sql = "
        SELECT
          USER_ID
          FROM USER_TB
          WHERE USER_NAME = '".$name."'
            AND USER_TEL_H = '".$tel1."'
            AND USER_TEL_B = '".$tel2."'
            AND USER_TEL_T = '".$tel3."'
      ";
      return $this->db->query($sql)->row();
    }

    function checkUserIDandTel($id,$tel1,$tel2,$tel3){
      $sql = "
        SELECT
          CASE WHEN COUNT(1)>0 THEN 'Y' ELSE 'N' END IS_CHECK
          FROM USER_TB
          WHERE USER_ID = '".$id."'
            AND USER_TEL_H = '".$tel1."'
            AND USER_TEL_B = '".$tel2."'
            AND USER_TEL_T = '".$tel3."'
      ";
      return $this->db->query($sql)->row();
    }

    function getUserDataByID($id){
      $sql = "
        SELECT
           A.*
          , (SELECT CODE_NM FROM COMMON_CODE_TB WHERE WORK_DV='회원업무' AND CODE_DV='회원구분' AND CODE=A.USER_TYPE) AS user_type_nm
          FROM USER_TB A
          WHERE USER_ID = '".$id."'
      ";
      return $this->db->query($sql)->row();
    }

    function getUserAddrByID($id){
      $sql = "
      SELECT
          ORDER_ID
        , RECIP_POSTCODE
        , RECIP_ADDR
        , RECIP_ADDR_DETAILS
        , RECIP_TEL_H
        , RECIP_TEL_B
        , RECIP_TEL_T
        , USER_ADDR_DEFAULT
        , REQ_MSG
        FROM USER_ADDRESS_TB
        WHERE USER_ID = '".$id."'
        GROUP BY RECIP_POSTCODE, RECIP_ADDR, RECIP_ADDR_DETAILS, RECIP_TEL_H, RECIP_TEL_B, RECIP_TEL_T
      ";
      return $this->db->query($sql)->result();
    }

    function getUserDefaultAddrByID($id){
      $sql = "
      SELECT
          ORDER_ID
        , RECIP_POSTCODE
        , RECIP_ADDR
        , RECIP_ADDR_DETAILS
        , RECIP_TEL_H
        , RECIP_TEL_B
        , RECIP_TEL_T
        , REQ_MSG
        FROM USER_ADDRESS_TB
        WHERE USER_ID = '".$id."'
         AND USER_ADDR_DEFAULT = 'Y'
      ";
      return $this->db->query($sql)->row();
    }

    function updateDefaultAddr($id){
      $sql = "
      UPDATE USER_ADDRESS_TB
      SET USER_ADDR_DEFAULT = 'N'
       WHERE USER_ID = '".$this->session->userdata('user_id')."'
         AND USER_ADDR_DEFAULT = 'Y'
      ";
      $this->db->query($sql);
      $sql = "
      UPDATE USER_ADDRESS_TB
      SET USER_ADDR_DEFAULT ='Y'
       WHERE USER_ID = '".$this->session->userdata('user_id')."'
         AND ORDER_ID = '".$id."'
      ";
      return $this->db->query($sql);
    }

    function updateMyinfo($hashMap){
      $sql = "
        UPDATE USER_TB
        SET USER_NAME = '".$hashMap['name']."'
         , USER_BIRTH = '".$hashMap['birth']."'
         , USER_SEX = '".$hashMap['sex']."'
         , USER_TEL_H = '".$hashMap['tel1']."'
         , USER_TEL_B = '".$hashMap['tel2']."'
         , USER_TEL_T = '".$hashMap['tel3']."'
        WHERE USER_ID = '".$this->session->userdata('user_id')."'
      ";
      return $this->db->query($sql);
    }

    function updatePassword($password){
      $sql = "
        UPDATE USER_TB
        SET USER_PW = '".$password."'
        WHERE USER_ID = '".$this->session->userdata('user_id')."'
      ";
      return $this->db->query($sql);
    }

    function resetPassword($password, $id){
      $sql = "
        UPDATE USER_TB
        SET USER_PW = '".$password."'
        WHERE USER_ID = '".$id."'
      ";
      return $this->db->query($sql);
    }


}
