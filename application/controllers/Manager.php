<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url','custlog');
        $this->load->model('admin_model');
    }

    function importHead($import){//-------------------------- 레이아웃 시작 로드
      if($this->session->userdata('user_level') != 1 && $this->session->userdata('user_level') != 2 && $this->session->userdata('user_level') != 3){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'매니저 권한이 없습니다.'));
        $this->load->view('module/redirect',  array('url'=>'/M_auth/login'));
      }
      $this->load->view('admin/layout/initailize');//-- 메타 & 헤더
      $this->load->view('admin/layout/css', array('css'=>$import));//--------- layout.css 및 CSS파일 로드
      $this->load->view('admin/layout/managerHeader');//------ 탑 헤더 & 슬라이더 메뉴
    }

    function importFooter($import){//-------------------------- 레이아웃 종료 로드
      $this->load->view('admin/layout/footer');//------- 풋터 로드
      $this->load->view('admin/layout/js', array('js'=>$import));//----------- layout.js 및 JS파일 로드
    }

    function index(){//--------------------------------------------------------------------------------어드민 메인 VIEW
      $this->importHead(array());//-------------------- 레이아웃 시작
      $this->load->view('admin/dashboard');
      $this->importFooter(array());//------------------ 레이아웃 종료
    }

    function compress($source, $destination, $quality) {
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);
        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);
        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);
        imagejpeg($image, $destination, $quality);
        return $destination;
    }

    function productList(){
      $get_data = $this->input->get();
      $this->importHead(array('product'=>'product'));//-------------------- 레이아웃 시작
      $combo1 = $this->admin_model->getProductCateDV();
      $combo2 = $this->admin_model->getProductCateColor();
      $combo3 = $this->admin_model->getProductCateShape();
      $gridData = $this->admin_model->getProductListByUserID($get_data,'IQY');
      $rowCount = $this->admin_model->getProductListByUserID($get_data,'COUNT');
      $this->load->view('admin/product/productList', array('gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows(), 'combo1'=>$combo1, 'combo2'=>$combo2, 'combo3'=>$combo3));
      $this->importFooter(array('product'=>'product'));//------------------ 레이아웃 종료
    }

    function ajaxGetProductByID(){
        $id = $this->input->post('id');
        $ajaxData = $this->admin_model->getProductList(array('ID'=>$id),'IQT');
        echo json_encode(array('result'=>true, 'object'=>$ajaxData->result()));
    }

    function uploadProduct(){
      $postData = $this->input->post();

      $SEQ = $this->admin_model->getProductID();

      $ext = substr($_FILES['PRD_IMG']['name'],-3);
      $name = $SEQ.".".$ext;
      $uploads_dir = './static/uploads/product';
      $allowed_ext = array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF');
      $error = $_FILES['PRD_IMG']['error'];

      if(!empty($_FILES['PRD_IMG']['name'])){
        // 오류 확인
        if( $error != UPLOAD_ERR_OK ) {
        	switch( $error ) {
        		case UPLOAD_ERR_INI_SIZE:
        		case UPLOAD_ERR_FORM_SIZE:
              $this->load->view('module/alert', array('text'=>'파일이 너무 큽니다.'));
              $this->load->view('module/redirect',  array('url'=>'/manager/productList'));
        			break;
        		case UPLOAD_ERR_NO_FILE:
              $this->load->view('module/alert', array('text'=>'파일이 첨부되지 않았습니다.'));
              $this->load->view('module/redirect',  array('url'=>'/manager/productList'));
        			break;
        		default:
              $this->load->view('module/alert', array('text'=>'파일이 제대로 업로드되지 않았습니다.'));
              $this->load->view('module/redirect',  array('url'=>'/manager/productList'));
        	}
        	exit;
        }

        // 확장자 확인
        if( !in_array($ext, $allowed_ext) ) {
          $this->load->view('module/alert', array('text'=>'허용되지 않는 확장자입니다.'));
          $this->load->view('module/redirect',  array('url'=>'/manager/productList'));
        	exit;
        }

        if(true){
          if($ext == "jpg" || $ext == "jpeg"){
              $image = imagecreatefromjpeg($_FILES['PRD_IMG']['tmp_name']);
          }else if($ext == "png"){
              //$image = imagecreatefrompng($_FILES['PRD_IMG']['tmp_name']);
          }else if($ext == "bmp" || $ext == "wbmp"){
              $image = imagecreatefromwbmp($_FILES['PRD_IMG']['tmp_name']);
          }else if($ext == "gif"){
              $image = imagecreatefromgif($_FILES['PRD_IMG']['tmp_name']);
          }
          if($ext != "png") $exif = exif_read_data($_FILES['PRD_IMG']['tmp_name']);
          if(!empty($exif['Orientation'])) {
              switch($exif['Orientation']) {
                  case 8:
                      $image = imagerotate($image,90,0);
                      break;
                  case 3:
                      $image = imagerotate($image,180,0);
                      break;
                  case 6:
                      $image = imagerotate($image,-90,0);
                      break;
              }
              if($ext == "jpg" || $ext == "jpeg"){
                  imagejpeg($image,$_FILES['PRD_IMG']['tmp_name']);
              }else if($ext == "png"){
                  imagepng($image,$_FILES['PRD_IMG']['tmp_name']);
              }else if($ext == "bmp" || $ext == "wbmp"){
                  imagewbmp($image,$_FILES['PRD_IMG']['tmp_name']);
              }else if($ext == "gif"){
                  imagegif($image,$_FILES['PRD_IMG']['tmp_name']);
              }
            }
          }

        // 파일 이동
        $result = move_uploaded_file( $_FILES['PRD_IMG']['tmp_name'], "$uploads_dir/$name");

        // 파일 리사이즈 후 복사하기
        $d = $this->compress("$uploads_dir/$name", "$uploads_dir/$name", 50);
        $imageSize = filesize("$uploads_dir/$name");
      }else{
        $imageSize = NULL;
      }

      if(!empty($postData['IS_NEW'])){ $postData['IS_NEW'] = "Y"; }else{ $postData['IS_NEW'] = "N"; }
      if(!empty($postData['IS_RECOMMAND'])){ $postData['IS_RECOMMAND'] = "Y"; }else{ $postData['IS_RECOMMAND'] = "N"; }
      if(!empty($_FILES['PRD_IMG']['name'])){
        $postData['IMG_EXTENSION'] = substr($_FILES['PRD_IMG']['name'],-3);
      }else{
        $postData['IMG_EXTENSION'] = NULL;
      }

      if(empty($postData['PRD_ID'])){
        $postData['PRD_ID'] = $SEQ;
        $postData['IMG_SIZE'] = $imageSize;
        $this->admin_model->insertProduct($postData);
        $this->admin_model->insertProductPrice($postData);
      }else{
        $postData['IMG_SIZE'] = $imageSize;
        $this->admin_model->updateProduct($postData);
        $this->admin_model->updateProductPrice($postData);
      }

      $this->load->view('module/redirect',  array('url'=>'/manager/productList?PRD_NM='.$postData['PRD_NM']));
    }

    function ajaxDeleteProduct(){
      $id = $this->input->post('id');
      $ajaxData = $this->admin_model->getProductList(array('ID'=>$id),'IQT')->row();
      $this->admin_model->deleteProductByID($id);
      if(!empty($ajaxData->IMG_EXTENSION)){
        unlink('./static/uploads/product/'.$ajaxData->PRODUCT_ID.".".$ajaxData->IMG_EXTENSION);
      }
      echo json_encode(array('result'=>true));
    }
}
