<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_main extends CI_Controller {
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
		$this->importHead(array('menu'));//-------------------- 레이아웃 시작

		$this->load->model('product_model');
		$this->load->model('admin_model');
		$slideBanner1 = $this->admin_model->getPCSlideInfo();
		$slideBanner2 = $this->admin_model->getMSlideInfo();
		$newList = $this->product_model->getNewProduct();
		$recommandList = $this->product_model->getRecommandProduct();
		$bestSeller = $this->product_model->getBsetSellerProduct();
		$this->load->view('M_menu/main', array('recommand'=>$recommandList,'newList'=>$newList, 'bestSeller'=>$bestSeller, 'slideBanner1'=>$slideBanner1, 'slideBanner2'=>$slideBanner2));

		$this->importFooter(array('menu'));//------------------ 레이아웃 종료
	}

}
