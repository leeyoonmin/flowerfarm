<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ledger_model');
    }

    function importHead($import){//-------------------------- 레이아웃 시작 로드
      // 로그인해야 사용가능하도록
      if($this->session->userdata('is_login') != true){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'로그인이 필요한 페이지입니다.\n로그인페이지로 이동합니다.'));
        $this->load->view('module/redirect', array('url'=>'/M_auth/login'));
      }
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

    function month(){//--------------------------------------------------------- 가계부 메인 VIEW
      $this->importHead(array('ledger'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'ledger'));

      $year = $this->input->get('year');
      $month = $this->input->get('month');
      if(empty($year)){
        $year = date("Y",time());
      }
      if(empty($month)){
        $month = date("m",time());
      }

      $monthData = $this->ledger_model->getMonthData($year,"","","");
      $cateType1 = $this->ledger_model->getCateByType('01');
      $cateType2 = $this->ledger_model->getCateByType('02');
      $this->load->view('M_ledger/month', array('year'=>$year, 'month'=>$month, 'monthData'=>$monthData, 'cateType1'=>$cateType1, 'cateType2'=>$cateType2));
      $this->importFooter(array('ledger'));//------------------ 레이아웃 종료
    }

    function daily(){//--------------------------------------------------------- 가계부 메인 VIEW
      $this->importHead(array('ledger'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'ledger'));

      $year = $this->input->get('year');
      $month = $this->input->get('month');
      $day = $this->input->get('day');
      if(empty($year)){
        $year = date("Y",time());
      }
      if(empty($month)){
        $month = date("m",time());
      }
      if(empty($day)){
        $day = date("d",time());
      }

      $dailyData = $this->ledger_model->getMonthDataByMonth($year,$month,$day,"");
      $cateType1 = $this->ledger_model->getCateByType('01');
      $cateType2 = $this->ledger_model->getCateByType('02');
      $this->load->view('M_ledger/daily', array('year'=>$year, 'month'=>$month, 'day'=>$day, 'dailyData'=>$dailyData, 'cateType1'=>$cateType1, 'cateType2'=>$cateType2));
      $this->importFooter(array('ledger'));//------------------ 레이아웃 종료
    }

    function calendar(){//--------------------------------------------------------- 가계부 메인 VIEW
      $this->importHead(array('ledger'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'ledger'));

      $year = $this->input->get('year');
      $month = $this->input->get('month');
      if(empty($year)){
        $year = date("Y",time());
      }
      if(empty($month)){
        $month = date("m",time());
      }

      $dailyData = $this->ledger_model->getDailyData($year,$month,"");
      $cateType1 = $this->ledger_model->getCateByType('01');
      $cateType2 = $this->ledger_model->getCateByType('02');
      $this->load->view('M_ledger/calendar', array('year'=>$year, 'month'=>$month, 'dailyData'=>$dailyData, 'cateType1'=>$cateType1, 'cateType2'=>$cateType2));
      $this->importFooter(array('ledger'));//------------------ 레이아웃 종료
    }

    function writeLedger(){
      $this->importHead(array('ledger'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'ledger'));

      $cateType1 = $this->ledger_model->getCateByType('01');
      $cateType2 = $this->ledger_model->getCateByType('02');
      $this->load->view('M_ledger/writeLedger', array('cateType1'=>$cateType1, 'cateType2'=>$cateType2));

      $this->importFooter(array('ledger'));//------------------ 레이아웃 종료
    }

    function updateLedgerPrc(){
      $postData = $this->input->post();
      $CATE = "";
      if($postData['TYPE'] == '01'){
        $CATE = $postData['CATE_1'];
      }else if($postData['TYPE'] == '02'){
        $CATE = $postData['CATE_2'];
      }
      $hashMap = array(
        'IDXKEY' => $postData['IDXKEY'],
        'USER_ID' => $this->session->userdata('user_id'),
        'TYPE' => $postData['TYPE'],
        'DATE' => date('Ymd', strtotime($postData['DATE'])),
        'CATE' => $CATE,
        'TEXT' => $postData['TEXT'],
        'AMOUNT' => preg_replace("/[^0-9]/", "",$postData['PRICE'])
      );
      $this->ledger_model->updateLedger($hashMap);
      $this->load->view('module/redirect',  array('url'=>'/ledger/daily?year='.date('Y', strtotime($postData['DATE'])).'&month='.date('m', strtotime($postData['DATE'])).'&day='.date('d', strtotime($postData['DATE']))));
    }

    function addLedgerPrc(){
      $postData = $this->input->post();
      $CATE = "";
      if($postData['TYPE'] == '01'){
        $CATE = $postData['CATE_1'];
      }else if($postData['TYPE'] == '02'){
        $CATE = $postData['CATE_2'];
      }
      $hashMap = array(
        'IDXKEY' => $this->makeID('06'),
        'USER_ID' => $this->session->userdata('user_id'),
        'TYPE' => $postData['TYPE'],
        'DATE' => date('Ymd', strtotime($postData['DATE'])),
        'CATE' => $CATE,
        'TEXT' => $postData['TEXT'],
        'AMOUNT' => preg_replace("/[^0-9]/", "",$postData['PRICE'])
      );
      $this->ledger_model->insertLedger($hashMap);
      $this->load->view('module/redirect',  array('url'=>'/ledger/daily?year='.date('Y', strtotime($postData['DATE'])).'&month='.date('m', strtotime($postData['DATE'])).'&day='.date('d', strtotime($postData['DATE']))));
    }

    function deleteLedger($IDXKEY){
      $getData = $this->ledger_model->getLedgerByIDXKEY($IDXKEY,'Y');
      if($getData->USER_ID==$this->session->userdata('user_id')){
        $this->ledger_model->deleteLedgerByIDXKEY($IDXKEY);
      }else{
        $this->load->view('module/alert', array('text'=>'잘못된 접근입니다.'));
      }
      $this->load->view('module/redirect',  array('url'=>'/ledger/daily?year='.date('Y', strtotime($getData->DATE)).'&month='.date('m', strtotime($getData->DATE)).'&day='.date('d', strtotime($getData->DATE))));
    }

    function updateLedger($IDXKEY){
      $this->importHead(array('ledger'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'ledger'));
      $ledger = $this->ledger_model->getLedgerByIDXKEY($IDXKEY,'Y');
      $cateType1 = $this->ledger_model->getCateByType('01');
      $cateType2 = $this->ledger_model->getCateByType('02');
      $this->load->view('M_ledger/updateLedger', array('ledger'=>$ledger, 'cateType1'=>$cateType1, 'cateType2'=>$cateType2));

      $this->importFooter(array('ledger'));//------------------ 레이아웃 종료
    }

    function makeID($WORK_DV){//------------------------------------------------------------------------인덱스키 생성 SERVICE
      $this->load->model('admin_model');
      $seq = $this->admin_model->getSequency($WORK_DV,date('YmdHis',time()));
      return $WORK_DV.'01'.date('YmdHis',time()).$seq;
    }

    function editCate(){
      $this->importHead(array('ledger'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'ledger'));
      $cateType1 = $this->ledger_model->getCateByType('01');
      $cateType2 = $this->ledger_model->getCateByType('02');
      $this->load->view('M_ledger/editCate', array('cateType1'=>$cateType1, 'cateType2'=>$cateType2));

      $this->importFooter(array('ledger'));//------------------ 레이아웃 종료
    }

    function ajaxDeleteCate(){
      $TYPE = $this->input->post('TYPE');
      $CATE = $this->input->post('CATE');
      $this->ledger_model->deleteCate($TYPE,$CATE);
      echo json_encode(array('result'=>true));
    }

    function ajaxAddCate(){
      $LIST = $this->input->post('LIST');
      $count = 1;
      foreach($LIST as $item){
        if(empty($item['cate'])){
          $IS_SEQ = "Y";
          while($IS_SEQ == "Y"){
            if($count < 100){
              $IS_SEQ = $this->ledger_model->checkCATE_SEQ(str_pad($count,2,'0',STR_PAD_LEFT), $item['type']);
              if($IS_SEQ=="Y") $count++;
            }else{
              $this->load->view('module/alert', array('text'=>'카테고리 최대 갯수를 초과했습니다.(100개)'));
              $this->load->view('module/redirect',  array('url'=>'/ledger/editCate'));
            }
          }
          if($item['text']!=""){
            $this->ledger_model->insertLedgerCate($item['type'], str_pad($count,2,'0',STR_PAD_LEFT), $item['text']);
          }
        }else{
          if($item['text']!=""){
            $this->ledger_model->updateLedgerCate($item['type'], $item['cate'], $item['text']);
          }
        }
      }
      echo json_encode(array('result'=>true));
    }

    function dashboard(){//--------------------------------------------------------- 가계부 메인 VIEW
      $this->importHead(array('ledger'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'ledger'));

      $year = $this->input->get('year');
      $month = $this->input->get('month');
      $mode = $this->input->get('mode');

      if(empty($year)){
        $year = date("Y",time());
      }
      if(empty($month)){
        $month = date("m",time());
      }
      if(empty($mode)){
        $mode = 'm';
      }
      if($mode=='m'){
        $chartData = $this->ledger_model->getChartData($year,$month);
      }else if($mode == 'y'){
        $chartData = $this->ledger_model->getChartData($year,'');
      }

      $this->load->view('M_ledger/dashboard', array('year'=>$year, 'month'=>$month, 'mode'=>$mode, 'chartData'=>$chartData));
      $this->importFooter(array('ledger'));//------------------ 레이아웃 종료
    }

    function dashboardDetail(){//--------------------------------------------------------- 가계부 메인 VIEW
      $this->importHead(array('ledger'));//-------------------- 레이아웃 시작
      $this->load->view('M_layout/page_title',array('page_title'=>'ledger'));

      $year = $this->input->get('year');
      $type = $this->input->get('type');
      $cate = $this->input->get('cate');
      $catenm = $this->input->get('catenm');

      if(empty($year)){
        $year = date("Y",time());
      }

      $chartData = $this->ledger_model->getChartData2($year,$type,$cate);

      $this->load->view('M_ledger/dashboardDetail', array('year'=>$year, 'chartData'=>$chartData, 'type'=>$type, 'cate'=>$cate, 'catenm'=>$catenm));
      $this->importFooter(array('ledger'));//------------------ 레이아웃 종료
    }
}
