<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
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

	public function orderPrc()//-----------------------------------------메인화면 VIEW
	{
    $postData = $this->input->post();
    $IDXKEY = $this->makeID('03');
    $hashMap = array(
      'user_id'=>$this->session->userdata('user_id'),
      'order_id'=>$IDXKEY,
      'order_name'=>$postData['name'],
      'pay_type'=> $postData['payType'],
      'delivery_method'=>$postData['deliveryMethod'],
      'delivery_date'=>$postData['deliveryDate'],
      'postcode'=>$postData['postcode'],
      'addr'=>$postData['addr'],
      'detail_addr'=>$postData['detail_address'],
      'tel1'=>$postData['tel1'],
      'tel2'=>$postData['tel2'],
      'tel3'=>$postData['tel3'],
      'req_msg'=>$postData['req_msg']
    );
    $this->load->model('order_model');
    $result1 = $this->order_model->insertOrder($hashMap);
    $result2 = $this->order_model->insertOrderAddr($hashMap);
    if($result1 && $result2){
      foreach($this->cart->contents() as $item){
        $hashMap['product_id'] = $item['id'];
        $hashMap['order_price'] = $item['price'];
        $hashMap['order_amount'] = $item['qty'];
        $result3 = $this->order_model->insertOrderItem($hashMap);
        if(!$result3){
          $this->load->view('module/alert',array('text'=>'주문이 실패되었습니다.\n오류가 계속될 경우 관리자에게 문의부탁드립니다.'));
          $this->load->view('module/redirect',array('url'=>'/M_menu/cart'));
        }
      }
    }else{
      $this->load->view('module/alert',array('text'=>'주문이 실패되었습니다.\n오류가 계속될 경우 관리자에게 문의부탁드립니다.'));
      $this->load->view('module/redirect',array('url'=>'/M_menu/cart'));
    }
    $this->cart->destroy();
    $this->load->view('module/redirect', array('url'=>'/mypage/orderDetail/'.$IDXKEY));
	}

  function makeID($WORK_DV){//------------------------------------------------------------------------인덱스키 생성 SERVICE
    $this->load->model('admin_model');
    $seq = $this->admin_model->getSequency($WORK_DV,date('YmdHis',time()));
    return $WORK_DV.'01'.date('YmdHis',time()).$seq;
  }

}
