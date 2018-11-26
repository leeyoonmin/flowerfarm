<?php
class Certificate_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    // 사업자 정보 입력
    function add($inputs)
    {
        $check = $this->db->insert('CERTIFICATE_TB', array(
            'user_id' => $inputs['user_id'],
            'certi_name' => $inputs['certi_name'],
            'certi_tel_h' => $inputs['certi_tel_h'],
            'certi_tel_b' => $inputs['certi_tel_b'],
            'certi_tel_t' => $inputs['certi_tel_t'],
            'certi_num' => $inputs['certi_num'],
            'certi_type' => $inputs['certi_type'],
        ));

        return $check;
    }
}
