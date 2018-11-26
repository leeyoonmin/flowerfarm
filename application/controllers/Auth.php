<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

    }

    public function ajaxCheckID(){ //-----------------------------아이디 중복확인 SERVICE
      $id = $this->input->post('id');
      $this->load->model('user_model');
      $result = $this->user_model->checkID($id);
      echo json_encode(array('result'=>true, 'duplicate'=>$result->DUPLICATE));
    }

    public function ajaxFindID(){ //-----------------------------아이디 찾기 SERVICE
      $name = $this->input->post('name');
      $tel1 = $this->input->post('tel1');
      $tel2 = $this->input->post('tel2');
      $tel3 = $this->input->post('tel3');
      $this->load->model('user_model');
      $result = $this->user_model->findUserID($name,$tel1,$tel2,$tel3);
      echo json_encode(array('result'=>true, 'id'=>$result));
    }

    public function ajaxFindPW(){ //-----------------------------아이디 찾기 SERVICE
      $id = $this->input->post('id');
      $tel1 = $this->input->post('tel1');
      $tel2 = $this->input->post('tel2');
      $tel3 = $this->input->post('tel3');
      $this->load->model('user_model');
      $result = $this->user_model->checkUserIDandTel($id,$tel1,$tel2,$tel3);
      if($result->IS_CHECK == "Y"){
        $random_num = str_pad(mt_rand(1,9999),4,0);
        $this->session->set_userdata('random_num',$random_num);
        $this->sms->sendSMS($tel1.$tel2.$tel3, "[꽃팜]인증번호를 입력해주세요.\n[".(int)$random_num."]\n인증번호는 3분 이내에만 유효합니다.", "", "");
        echo json_encode(array('result'=>true));
      }else{
        echo json_encode(array('result'=>false));
      }
    }

    public function checkRandomNum(){
      $CODE = $this->input->post('checkNum');
      if($this->session->userdata('random_num')==$CODE){
        echo json_encode(array('result'=>true));
      }else{
        echo json_encode(array('result'=>false));
      }
    }

    public function resetPWPrc(){
  		$PW = $this->input->post('password');
      $ID = $this->input->post('id');
      $PW = password_hash($PW, PASSWORD_BCRYPT);
      $this->load->model('user_model');
      $this->user_model->resetPassword($PW,$ID);
      $this->load->view('module/alert',array('text'=>'비밀번호가 재설정되었습니다.\n변경된 비밀번호로 로그인하세요.'));
      $this->load->view('module/redirect',array('url'=>'/M_auth/login'));
  	}

    public function joinPrc(){ //-----------------------------회원가입 SERVICE
      $this->load->model('user_model');
      $this->load->model('certificate_model');
      $postData = $this->input->post();
      $postData['pw'] = password_hash($postData['pw'], PASSWORD_BCRYPT);
      if(empty($postData['type'])){
        $postData['type'] = '5';
      }
      if(empty($postData['cellphone'])){
        $postData['cellphone'] = NULL;
      }
      if(empty($postData['certificate_num'])){
        $postData['certificate_num'] = NULL;
      }
      $hashMap = array(
          'id'=>$postData['id']
        , 'pw'=>$postData['pw']
        , 'type'=>$postData['type']
        , 'name'=>$postData['name']
        , 'tel1'=>$postData['tel1']
        , 'tel2'=>$postData['tel2']
        , 'tel3'=>$postData['tel3']
      );
      $res1 = $this->user_model->add($hashMap);
      if($res1){
        $hashMap = array(
          'user_id' => $postData['id']
        , 'certi_name' => $postData['name']
        , 'certi_tel_h' => $postData['tel1']
        , 'certi_tel_b' => $postData['tel2']
        , 'certi_tel_t' => $postData['tel3']
        , 'certi_num' => $postData['certificate_num']
        , 'certi_type' => $postData['type']
        );
        if($postData['type'] != '5'){
          $res2 = $this->certificate_model->add($hashMap);
        }else{
          $res2 = true;
        }

        if($res2){
          $this->session->set_userdata('is_login', true);
          $this->session->set_userdata('user_level', $postData['type']);
          $this->session->set_userdata('user_id', $postData['id']);
          $this->session->set_userdata('user_name', $postData['name']);
          $this->load->view('module/redirect',array('url'=>'/M_auth/joinResult/'.$postData['id']));
        }else{
          $this->load->view('module/alert',array('text'=>'회원가입에 실패하였습니다.\n실패가 계속될 경우 관리자에게 문의부탁드립니다.'));
          $this->load->view('module/redirect',array('url'=>'/M_auth/join'));
        }
      }else{
        $this->load->view('module/alert',array('text'=>'회원가입에 실패하였습니다.\n실패가 계속될 경우 관리자에게 문의부탁드립니다.'));
        $this->load->view('module/redirect',array('url'=>'/M_auth/join'));
      }
    }

    public function ajaxJoinPrc(){ //-----------------------------회원가입 SERVICE
      $this->load->model('user_model');
      $this->load->model('certificate_model');
      $postData = $this->input->post();
      $postData['pw'] = password_hash($postData['pw'], PASSWORD_BCRYPT);
      if(empty($postData['type'])){
        $postData['type'] = '5';
      }
      $hashMap = array(
          'id'=>$postData['id']
        , 'pw'=>$postData['pw']
        , 'type'=>$postData['type']
        , 'name'=>$postData['name']
        , 'tel1'=>$postData['tel1']
        , 'tel2'=>$postData['tel2']
        , 'tel3'=>$postData['tel3']
      );
      $res1 = $this->user_model->add($hashMap);
      if($res1){
          $this->session->set_userdata('is_login', true);
          $this->session->set_userdata('user_level', $postData['type']);
          $this->session->set_userdata('user_id', $postData['id']);
          $this->session->set_userdata('user_name', $postData['name']);
          echo json_encode(array('result'=>true));
        }else{
          echo json_encode(array('result'=>false));
        }
    }

    function loginPrc(){ //----------------------------로그인 SERVICE
      $id = $this->input->post('id');
      $pw = $this->input->post('password');
      $this->load->model('user_model');
      $pw_conf = $this->user_model->getPasswordByID($id);
      if(!empty($pw_conf)){
        $pw_conf = $pw_conf->USER_PW;
      }
      if(password_verify($pw, $pw_conf)){
        $userData = $this->user_model->getUserDataByID($id);
        $this->session->set_userdata('is_login', true);
        $this->session->set_userdata('user_level', $userData->user_type);
        $this->session->set_userdata('user_id', $userData->user_id);
        $this->session->set_userdata('user_name', $userData->user_name);
        $prevURL = $this->session->userdata('prevURL');
        if(!empty($prevURL)){
          $this->load->view('module/redirect',array('url'=>"/".$prevURL));
        }else{
          $this->load->view('module/redirect',array('url'=>'/M_main'));
        }
      }else{
        $this->load->view('module/alert',array('text'=>'로그인 정보가 올바르지 않습니다.'));
        echo "<script>history.back(-2);</script>";
      }
    }

    function logout(){//-------------------------------------------------------------------------------------------------로그아웃 SERVICE
      $this->load->view('module/alert',array('text'=>$this->session->userdata('user_name').'님 다음에 또 뵙겠습니다.'));
      $this->session->set_userdata('is_login', false);
      $this->session->set_userdata('user_level', '');
      $this->session->set_userdata('user_id', '');
      $this->session->set_userdata('user_name', '');
      $this->session->set_userdata('prevURL', '');
      $this->load->view('module/redirect',array('url'=>'/M_main'));
    }
}
