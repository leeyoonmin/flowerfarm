<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
     function __construct(){
        parent::__construct();

     }
    function index()
    {
      $this->load->model('test_model');
      $data = $this->test_model->get_user_data();
      echo json_encode(array('result'=>true, 'object'=>$data));
    }
}
