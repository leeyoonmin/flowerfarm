<?php
class Addr_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    // 회원 주소 입력
    function add($input)
    {
        $result = $this->db->insert('USER_ADDRESS_TB', array(
            'order_id' => $input['order_id'],
            'user_id' => $input['user_id'],
            'user_addr' => $input['user_addr'],
            'user_addr_details' => $input['user_addr_details'],
            'user_addr_zipcode' => $input['user_addr_zipcode'],
            'user_req' => $input['user_req'],
            'user_addr_default'=> 1,
            'recip_name'=> $input['recip_name'],
            'recip_phone' => $input['recip_phone']
        ));

        return $result; //성공 시, true 반환
    }
    function get_latest_orderID($id){
        return $this->db->query("SELECT MAX(order_id) AS order_id FROM ORDER_TB WHERE user_id='$id'")->row();
    }
    // 회원 주소 가져오기
    function get($user_id){
        return $this->db->get_where('USER_ADDRESS_TB', array('user_id' => $user_id, 'user_addr_default' => 1))->row();
    }
}


