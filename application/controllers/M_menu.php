<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu extends CI_Controller {
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

	public function productList($type)//-----------------------------------------메인화면 VIEW
	{
		if(empty($type)){
			$this->load->view('module/alert', array('text'=>'잘못된 접근입니다.\n메인페이지로 이동합니다.'));
			$this->load->view('module/redirect', array('url'=>'/M_main'));
		}
		$this->importHead(array('menu'));//-------------------- 레이아웃 시작
		$this->load->view('M_layout/page_title',array('page_title'=>'mart01'));
    $getData = $this->input->get();
		if(empty($getData['page'])){
			$getData['page'] = 1;
		}
		if(empty($getData['is_img'])){
			$getData['is_img'] = false;
		}
    $this->load->model('product_model');
		$cateKind = $this->product_model->getProductCate('상품상세구분코드');
		$cateColor = $this->product_model->getProductCate('상품색상구분코드');
		$cateShape = $this->product_model->getProductCate('상품형태구분코드');
		$cateArea = $this->product_model->getProductCate('상품원산지구분코드');
		$gridData = $this->product_model->getDisplayProductList($getData, $type);
		$gridDataCount = $this->product_model->getDisplayProductCount($getData, $type)->num_rows();
    $this->load->view('M_menu/productList',array('gridData'=>$gridData, 'gridDataCount'=>$gridDataCount, 'getData'=>$getData,'cateArea'=>$cateArea, 'cateKind'=>$cateKind, 'cateColor'=>$cateColor, 'cateShape'=>$cateShape));
		$this->importFooter(array('menu','hangul'));//------------------ 레이아웃 종료
	}

	public function cart(){
		if($this->session->userdata('is_login') != true){
			$this->session->set_userdata('prevURL',$this->uri->uri_string());
			$this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
			$this->load->view('module/redirect', array('url'=>'/M_auth/login'));
		}
		$this->importHead(array('cart'));//-------------------- 레이아웃 시작
		$this->load->view('M_layout/page_title',array('page_title'=>'cart'));

		$this->load->model('cart_model');
		$delivery_info = $this->cart_model->getDeliveryInfo();
		$this->load->view('M_menu/cart', array('delivery_info'=>$delivery_info));

		$this->importFooter(array('cart'));//------------------ 레이아웃 종료
	}

	public function order(){
		$getData = $this->input->get();
		if($this->session->userdata('is_login') != true){
			$this->session->set_userdata('prevURL',$this->uri->uri_string());
			$this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
			$this->load->view('module/redirect', array('url'=>'/M_auth/login'));
		}
		$this->importHead(array('order'));//-------------------- 레이아웃 시작

		$this->load->model('user_model');
		$this->load->model('order_model');
		$userData = $this->user_model->getUserDataByID($this->session->userdata['user_id']);
		$userDefaultAddr = $this->user_model->getUserDefaultAddrByID($this->session->userdata['user_id']);
		$shopData = $this->order_model->getPaymentInfo();
		$this->load->view('M_menu/writeOrder', array('user'=>$userData, 'getData'=>$getData, 'addr'=>$userDefaultAddr, 'shopData'=>$shopData));

		$this->importFooter(array('order'));//------------------ 레이아웃 종료
	}

	public function ajaxGetOrderAddrList(){
		$this->load->model('user_model');
		$userAddr = $this->user_model->getUserAddrByID($this->session->userdata['user_id']);
		echo json_encode(array('result'=>true, 'addrList'=>$userAddr));
	}

	public function ajaxUpdateDefaultAddr(){
		$id = $this->input->post('id');
		$this->load->model('user_model');
		$userAddr = $this->user_model->updateDefaultAddr($id);
		echo json_encode(array('result'=>true));
	}

	public function ajaxLoadMoreList(){
		$getData = $this->input->post('getData');
		$this->load->model('product_model');
		$gridData = $this->product_model->getDisplayProductList($getData, '01');
		echo json_encode(array('result'=>true, 'data'=>$gridData));
	}
}
