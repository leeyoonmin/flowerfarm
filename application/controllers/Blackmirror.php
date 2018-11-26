<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blackmirror extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');

    }

    function importHead($import){//-------------------------- 레이아웃 시작 로드
  		$this->load->view('blackmirror/layout/initialize');//-- 메타 & 헤더
  		$this->load->view('blackmirror/css', array('css'=>$import));//--------- layout.css 및 CSS파일 로드
  		$this->load->view('blackmirror/header');//------ 탑 헤더 & 슬라이더 메뉴
  	}

    function importFooter($import){//-------------------------- 레이아웃 종료 로드
  		$this->load->view('blackmirror/slideMenu');
  		$this->load->view('blackmirror/js', array('js'=>$import));//----------- layout.js 및 JS파일 로드
  	}

    function index(){//--------------------------------------------------------- 가계부 메인 VIEW
      $this->importHead(array(''));//-------------------- 레이아웃 시작



      $this->importFooter(array(''));//------------------ 레이아웃 종료
    }
}
