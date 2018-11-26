<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 18.
 * Time: PM 5:29
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class mypage extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url','custlog');
        $this->load->model('mypage_model');
        $this->load->model('admin_model');
    }

    function importHead($import){//-------------------------- 레이아웃 시작 로드
  		$this->load->view('M_layout/initialize');//-- 메타 & 헤더
  		$this->load->view('M_layout/css', array('css'=>$import));//--------- layout.css 및 CSS파일 로드
  		$this->load->view('M_layout/header');//------ 탑 헤더 & 슬라이더 메뉴
  	}

  	function importFooter($import){//-------------------------- 레이아웃 종료 로드
      $this->load->model('common_model');
  		$shopInfo = $this->common_model->getShopInfo();
  		$this->load->view('M_layout/footer', array('shopInfo'=>$shopInfo));//------- 풋터 로드
  		$this->load->view('M_layout/slideMenu');
  		$this->load->view('M_layout/js', array('js'=>$import));//----------- layout.js 및 JS파일 로드
  	}

    function index() //---------------------------------------------------------------------------------------------- 마이페이지 - 메인 VIEW
    {
        // 로그인해야 사용가능하도록
        if($this->session->userdata('is_login') != true){
          $this->session->set_userdata('prevURL',$this->uri->uri_string());
    			$this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
    			$this->load->view('module/redirect', array('url'=>'/M_auth/login'));
    		}
        $this->importHead(array('mypage'));//-------------------- 레이아웃 시작
        $this->load->view('M_layout/page_title',array('page_title'=>'mypage'));

        $this->load->model('user_model');
        $monthPrice = $this->mypage_model->getThisMonthOrder($this->session->userdata('user_id'));
        $weekPrice = $this->mypage_model->getThisWeekOrder($this->session->userdata('user_id'));
        $userData = $this->user_model->getUserDataByID($this->session->userdata('user_id'));
        $this->load->view('M_mypage/main', array('userData'=>$userData , 'monthPrice'=>$monthPrice, 'weekPrice'=>$weekPrice));

    		$this->importFooter(array('mypage'));//------------------ 레이아웃 종료
    }

    function myInfo(){//---------------------------------------------------------------------------------------------- 마이페이지 - 내정보관리 VIEW
      // 로그인해야 사용가능하도록
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
      $this->importHead(array('mypage'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'myInfo'));

      $this->load->model('user_model');
      $userData = $this->user_model->getUserDataByID($this->session->userdata('user_id'));
      $addrData = $this->mypage_model->getUserAddr($this->session->userdata('user_id'));
      $this->load->view('M_mypage/myInfo', array('userData'=>$userData));

      $this->importFooter(array('mypage'));//------------------ 레이아웃 종료
    }

    function myInfoLogin(){//---------------------------------------------------------------------------------------------- 마이페이지 - 내정보수정 - 로그인 VIEW
      // 로그인해야 사용가능하도록
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
      $this->importHead(array('mypage'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'myInfo'));

      $this->load->view('M_mypage/myInfoLogin');

      $this->importFooter(array('mypage'));//------------------ 레이아웃 종료
    }

    function myInfoLoginPrc(){//---------------------------------------------------------------------------------------------- 마이페이지 - 내정보수정 - 로그인 Service
      // 로그인해야 사용가능하도록
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }

      $this->load->model('user_model');
      $password = $this->input->post('password');
      $pw_conf = $this->user_model->getPasswordByID($this->session->userdata('user_id'))->USER_PW;
      if(password_verify($password, $pw_conf)){
        $this->session->set_userdata('is_myInfo',true);
        $this->load->view('module/redirect', array('url'=>'/mypage/myInfoModify'));
      }else{
        $this->load->view('module/alert', array('text'=>'비밀번호를 확인해주세요.'));
        $this->load->view('module/redirect', array('url'=>'/mypage/myInfoLogin'));
      }

    }

    function myInfoModify(){//---------------------------------------------------------------------------------------------- 마이페이지 - 내정보수정 VIEW
      // 로그인해야 사용가능하도록
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
      $this->importHead(array('mypage'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'myInfo'));

      $this->load->model('user_model');
      $userData = $this->user_model->getUserDataByID($this->session->userdata('user_id'));
      $addrData = $this->mypage_model->getUserAddr($this->session->userdata('user_id'));
      $this->load->view('M_mypage/myInfoModify', array('userData'=>$userData));

      $this->importFooter(array('mypage'));//------------------ 레이아웃 종료
    }

    function myInfoModifyPrc(){//---------------------------------------------------------------------------------------------- 마이페이지 - 내정보수정 Service
      // 로그인해야 사용가능하도록
      if($this->session->userdata('is_login') != true){
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
      $postData = $this->input->post();
      $this->load->model('user_model');
      $this->user_model->updateMyinfo($postData);
      $this->load->view('module/redirect', array('url'=>'/mypage/myInfo'));
    }

    function passwordModifyPrc(){//---------------------------------------------------------------------------------------------- 마이페이지 - 비밀번호수정  Service
      // 로그인해야 사용가능하도록
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
      $password = $this->input->post('password');
      $password = password_hash($password, PASSWORD_BCRYPT);
      $this->load->model('user_model');
      $this->user_model->updatePassword($password);
      $this->load->view('module/redirect', array('url'=>'/mypage/myInfo'));
    }

    function orderList(){
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
      $this->importHead(array('mypage'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'order_info'));

      $getDate = $this->input->get();
      $this->load->model('order_model');
      $orderList = $this->order_model->getOrderListByID($this->session->userdata('user_id'), $getDate);
      $this->load->view('M_mypage/orderList', array('orderList'=>$orderList, 'getData'=>$getDate));

      $this->importFooter(array('mypage'));//------------------ 레이아웃 종료
    }

    function orderDetail($id){
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
      $this->importHead(array('mypage'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'order_info'));

      $this->load->model('order_model');
      $prev = $this->input->get('prev');
      $orderInfo = $this->order_model->getOrderDetailByID($id);
      $this->load->view('M_mypage/orderDetail', array('orderInfo'=>$orderInfo, 'prev'=>$prev));

      $this->importFooter(array('mypage'));//------------------ 레이아웃 종료
    }

    function cancleList(){
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
      $this->importHead(array('mypage'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'order_info'));

      $getDate = $this->input->get();
      $this->load->model('order_model');
      $orderList = $this->order_model->getCancleListByID($this->session->userdata('user_id'), $getDate);
      $this->load->view('M_mypage/cancleList', array('orderList'=>$orderList, 'getData'=>$getDate));

      $this->importFooter(array('mypage'));//------------------ 레이아웃 종료
    }

    function ajaxOrderCancle(){//---------------------------------------------------------------------------------------------- 마이페이지 - 주문취소  Ajax --Service
      $orderID = $this->input->post('id');
      $this->load->model('order_model');
      $IS_FORDER = $this->order_model->getForderStatByOrderID($orderID)->IS_FORDER;
      if($IS_FORDER=='Y'){
        echo json_encode(array('result'=>false, 'is_forder'=>$IS_FORDER));
      }else{
        $this->order_model->orderCancel($orderID);
        echo json_encode(array('result'=>true, 'is_forder'=>$IS_FORDER));
      }
    }

    function support($type){
      $this->importHead(array('mypage','board'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'support'));

      $get_data = $this->input->get();
      $this->load->model('mypage_model');
      $boardCate = $this->mypage_model->getBoardCate();
      $gridData = $this->mypage_model->getBoardByType($get_data,'IQY',$type);
      $rowCount = $this->mypage_model->getBoardByType($get_data,'COUNT',$type);

      if($type == "03" && $this->session->userdata('is_login') != true){
        $this->load->view('M_mypage/noLoginSupport');
      }else{
        $this->load->view('M_mypage/supportList', array('type'=>$type, 'boardCate'=>$boardCate, 'getData'=>$get_data, 'gridData'=>$gridData->result(), 'rowCount'=>$rowCount->num_rows()));
      }


      $this->importFooter(array('mypage','board'));//------------------ 레이아웃 종료
    }

    function writeBoard(){
      $this->importHead(array('mypage','board'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'support'));

      $this->load->view('M_mypage/writeBoard');

      $this->importFooter(array('mypage','board'));//------------------ 레이아웃 종료
    }

    function writeBoardPrc(){
      $postData = $this->input->post();
      $this->load->model('mypage_model');
      $this->load->model('admin_model');
      $ID = $this->makeID('05');
      $postData['id'] = $ID;
      $this->mypage_model->insertBoard($postData,'03');
      $this->load->view('module/redirect', array('url'=>'/mypage/support/03'));
    }

    function modifyBoard(){
      $this->importHead(array('mypage','board'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'support'));
      $idxkey = $this->input->post('idxkey');
      $board = $this->mypage_model->getBoardByID($idxkey);
      $this->load->view('M_mypage/modifyBoard',array('board'=>$board));
      $this->importFooter(array('mypage','board'));//------------------ 레이아웃 종료
    }

    function modifyBoardPrc(){
      $postData = $this->input->post();
      $this->mypage_model->updateBoard($postData);
      $this->load->view('module/redirect', array('url'=>'/mypage/support/03'));
    }



    function makeID($WORK_DV){//------------------------------------------------------------------------인덱스키 생성 SERVICE
      $seq = $this->admin_model->getSequency($WORK_DV,date('YmdHis',time()));
      return $WORK_DV.'01'.date('YmdHis',time()).$seq;
    }

    function ajaxDeleteBoard(){//----------------------------------------------------------------------- 마이페이지 - 1:1문의 게시판 삭제  Ajax --Service
      $idxkey = $this->input->post('idxkey');
      $result = $this->mypage_model->deleteBoardByID($idxkey);
      if($result){
        echo json_encode(array('result'=>true));
      }else{
        echo json_encode(array('result'=>false));
      }
    }

    function transBiz(){//----------------------------------------------------------------------- 마이페이지 - 사업자회원전환신청 페이지 VIEW
      $this->importHead(array('mypage','board'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'mypage'));

      $this->load->view('M_mypage/transBiz');

      $this->importFooter(array('mypage','board'));//------------------ 레이아웃 종료
    }

    function transBizPrc(){//----------------------------------------------------------------------- 마이페이지 - 사업자회원전환신청 SERVICE
      $postData = $this->input->post();
      $postData['USER_ID'] = $this->session->userdata('user_id');
      $this->admin_model->updateUserGrade($this->session->userdata('user_id'),'06');
      $this->session->set_userdata('user_level','6');
      $this->admin_model->insertUserCertiInfo($postData);
      $this->load->view('module/alert', array('text'=>'신청이 완료되었습니다.\n승인이 완료되면 [사업자회원]의\n혜택을 받으실 수 있습니다.'));
      $this->load->view('module/redirect', array('url'=>'/mypage'));
    }

}

?>
