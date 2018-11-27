<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Controller {
	function __construct()
	{
			parent::__construct();
			$this->load->helper('url','custlog');
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

	public function index()//-----------------------------------------메인화면 VIEW
	{

	}

	public function login(){
		if($this->session->userdata('is_login')==true){
			$this->load->view('module/redirect',array('url'=>'/'));
		}
    $this->importHead(array('join'));//-------------------- 레이아웃 시작
		//$this->load->view('M_layout/page_title',array('page_title'=>'login'));
		$this->load->view('M_auth/login');
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
	}

	public function findID(){
    $this->importHead(array('join'));//-------------------- 레이아웃 시작
		$this->load->view('M_auth/findID');
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
	}

	public function findPW(){
    $this->importHead(array('join'));//-------------------- 레이아웃 시작
		$this->load->view('M_auth/findPW');
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
	}

	public function resetPW(){
		$CODE = $this->input->post('identifyCode');
		$post_data = $this->input->post();
		$user_id = $this->input->post('id');
		if($this->session->userdata('random_num')!=$CODE || empty($user_id)){
			$this->load->view('module/alert',array('text'=>'잘못된 접근입니다.'));
			$this->load->view('module/redirect',array('url'=>'/M_auth/findPW'));
		}
		$this->importHead(array('join'));//-------------------- 레이아웃 시작
		$this->load->view('M_auth/resetPW', array('USER_ID'=>$user_id));
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
	}

	public function joinSelect(){
		$this->importHead(array('join'));//-------------------- 레이아웃 시작
		$this->load->view('M_auth/joinSelect');
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
	}

  public function joinNormal(){
		$this->importHead(array('join'));//-------------------- 레이아웃 시작
		$this->load->view('M_auth/joinNormal');
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
	}

  public function joinBiz(){
		$this->importHead(array('join'));//-------------------- 레이아웃 시작
		$this->load->view('M_auth/joinBiz');
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
	}

  public function joinResult(){
    $this->importHead(array('join'));//-------------------- 레이아웃 시작
		$this->load->view('M_auth/joinResult');
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
  }

	public function join(){
		$this->importHead(array('join'));//-------------------- 레이아웃 시작
		$this->load->view('M_auth/join');
		$this->importFooter(array('join'));//------------------ 레이아웃 종료
	}

}
