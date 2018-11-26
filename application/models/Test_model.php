<?php
class Test_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_user_data(){
      $sql="
        SELECT * FROM USER_TB
      ";
      return $this->db->query($sql)->result();
    }
}
