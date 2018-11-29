<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url','custlog');
        $this->load->model('admin_model');
    }

    function importHead($import){//-------------------------- 레이아웃 시작 로드
      if($this->session->userdata('user_level') != 1){
        $this->session->set_userdata('prevURL',$this->uri->uri_string());
        $this->load->view('module/alert', array('text'=>'관리자 권한이 없습니다.'));
        $this->load->view('module/redirect',  array('url'=>'/M_auth/login'));
      }
      $this->load->view('admin/layout/initailize');//-- 메타 & 헤더
      $this->load->view('admin/layout/css', array('css'=>$import));//--------- layout.css 및 CSS파일 로드
      $this->load->view('admin/layout/header');//------ 탑 헤더 & 슬라이더 메뉴
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

    function shopInfo(){
      $get_data = $this->input->get();
      $this->importHead(array('shop'=>'shop'));//-------------------- 레이아웃 시작

      $this->importFooter(array('shop'=>'shop'));//------------------ 레이아웃 종료
    }

    function slideBanner(){
      $get_data = $this->input->get();
      $this->importHead(array('shop'=>'shop'));//-------------------- 레이아웃 시작
      $gridData1 = $this->admin_model->getPCSlideInfo();
      $gridData2 = $this->admin_model->getMSlideInfo();
      $this->load->view('admin/shop/slideBanner', array('gridData1'=>$gridData1, 'gridData2'=>$gridData2));
      $this->importFooter(array('shop'=>'shop'));//------------------ 레이아웃 종료
    }

    function slideBannerUpdate(){
      $type = $this->input->post('type');
      $mode = $this->input->post('mode');
      $id = $this->input->post('id');

      $name = $_FILES['PRD_IMG']['name'];
      $ext = substr($_FILES['PRD_IMG']['name'],-3);

      if($mode == "modify"){
        $fileInfo = $this->admin_model->getFileName($id)->CODE;
        $is_del = unlink('./static/img/slide/'.$fileInfo);
        $this->admin_model->updateFileName($id,$name);
      }else if($mode == "add"){
        $id= $this->makeID('01');
        $this->admin_model->insertFileName($id,$name,$type);
      }

        $uploads_dir = './static/img/slide';
        $allowed_ext = array('jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF');

        // 변수 정리
        $error = $_FILES['PRD_IMG']['error'];

        // 오류 확인
        if( $error != UPLOAD_ERR_OK ) {
        	switch( $error ) {
        		case UPLOAD_ERR_INI_SIZE:
        		case UPLOAD_ERR_FORM_SIZE:
              $this->load->view('module/alert', array('text'=>'파일이 너무 큽니다.'));
              $this->load->view('module/redirect',  array('url'=>'/admin/addproduct'));
        			break;
        		case UPLOAD_ERR_NO_FILE:
              $this->load->view('module/alert', array('text'=>'파일이 첨부되지 않았습니다.'));
              $this->load->view('module/redirect',  array('url'=>'/admin/addproduct'));
        			break;
        		default:
              $this->load->view('module/alert', array('text'=>'파일이 제대로 업로드되지 않았습니다.'));
              $this->load->view('module/redirect',  array('url'=>'/admin/addproduct'));
        	}
        	exit;
        }

        // 확장자 확인
        if( !in_array($ext, $allowed_ext) ) {
          $this->load->view('module/alert', array('text'=>'허용되지 않는 확장자입니다.'));
          $this->load->view('module/redirect',  array('url'=>'/admin/addproduct'));
        	exit;
        }

        if(true){
          if($ext == "jpg" || $ext == "jpeg"){
              $image = imagecreatefromjpeg($_FILES['PRD_IMG']['tmp_name']);
          }else if($ext == "png"){
              $image = imagecreatefrompng($_FILES['PRD_IMG']['tmp_name']);
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

        if($result){
            $this->load->view('module/alert', array('text'=>'업로드 완료.'));
            $this->load->view('module/redirect',  array('url'=>'/admin/slideBanner'));
          }else{
            unlink($uploads_dir."/".$name);
            $this->load->view('module/alert', array('text'=>'업로드 실패.'));
            $this->load->view('module/redirect',  array('url'=>'/admin/slideBanner'));
        }
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

    function slideBannerDelete(){
      $id = $this->input->post('id');
      $fileInfo = $this->admin_model->getFileName($id)->CODE;
      $this->admin_model->deleteCommonCode(array('IDX'=>$id));
      $is_del = unlink('./static/img/slide/'.$fileInfo);
      echo json_encode(array('result'=>true));
    }

    function inquiryUserInfo(){
      $get_data = $this->input->get();
      $this->importHead(array('user'=>'user'));//-------------------- 레이아웃 시작

      $gridData = $this->admin_model->getUserInfoBase($get_data,'IQY','inquiryUserInfo');
      $rowCount = $this->admin_model->getUserInfoBase($get_data,'COUNT','inquiryUserInfo');
      $this->load->view('admin/user/inquiryUserInfo', array('gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('user'=>'user'));//------------------ 레이아웃 종료
    }

    function userGradeMng(){
      $get_data = $this->input->get();
      $this->importHead(array('user'=>'user'));//-------------------- 레이아웃 시작

      $gridData = $this->admin_model->getUserInfoBase($get_data,'IQY','inquiryUserInfo');
      $rowCount = $this->admin_model->getUserInfoBase($get_data,'COUNT','inquiryUserInfo');
      $this->load->view('admin/user/userGradeMng', array('gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('user'=>'user'));//------------------ 레이아웃 종료
    }

    function updateUserGrade(){
      $id = $this->input->post('id');
      $grade = $this->input->post('grade');
      foreach($id as $item){
        $this->admin_model->updateUserGrade($item,$grade);
      }
      echo json_encode(array('result'=>true));
    }

    function setUserNick(){
      $get_data = $this->input->get();
      $this->importHead(array('user'=>'user'));//-------------------- 레이아웃 시작

      $gridData = $this->admin_model->getUserInfoBase($get_data,'IQY','inquiryUserInfo');
      $rowCount = $this->admin_model->getUserInfoBase($get_data,'COUNT','inquiryUserInfo');
      $this->load->view('admin/user/setUserNick', array('gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('user'=>'user'));//------------------ 레이아웃 종료
    }

    function updateUserNickName(){
      $param = $this->input->post();
      $this->admin_model->updateUserNickName($param);
      echo json_encode(array('result'=>true));
    }

    function productList(){
      $get_data = $this->input->get();
      $this->importHead(array('product'=>'product'));//-------------------- 레이아웃 시작
      $combo1 = $this->admin_model->getProductCateDV();
      $combo2 = $this->admin_model->getProductCateColor();
      $combo3 = $this->admin_model->getProductCateShape();
      $combo4 = $this->admin_model->getProductCateArea();
      if(empty($get_data['VIEW_CNT'])){
        $get_data['VIEW_CNT'] = 'false';
      }
      $gridData = $this->admin_model->getProductList($get_data,'IQY');
      $rowCount = $this->admin_model->getProductList($get_data,'COUNT');
      $this->load->view('admin/product/productList', array('gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows(), 'combo1'=>$combo1, 'combo2'=>$combo2, 'combo3'=>$combo3, 'combo4'=>$combo4));
      $this->importFooter(array('product'=>'product'));//------------------ 레이아웃 종료
    }

    function productImgMng(){
      $get_data = $this->input->get();
      $this->importHead(array('product'=>'product'));//-------------------- 레이아웃 시작

      $dir = "./static/uploads/product";

      if($handle = opendir($dir)){
        $PRD_CNT = 0;
        while (false !== ($file = readdir($handle))){
          $PRD_CD = substr($file,0,6);
          if($PRD_CD == "." || $PRD_CD == ".." || $PRD_CD == "noImag"){

          }else{
            $PRODUCT_CD = substr($file,0,6);
            $IMG_EXTENSION = substr($file,-3);
            $FILE_SISE = filesize($dir."/".$file);
            //$this->admin_model->updateProductImage($PRODUCT_CD,$IMG_EXTENSION,$FILE_SISE);
            $IS_PRD = $this->admin_model->selectPRD($PRODUCT_CD);
            if($IS_PRD=='N'){
              unlink($dir."/".$file);
            }
            $PRD_CNT++;
          }
        }
        echo "총 이미지 수 : ".$PRD_CNT."<BR>";
      }

      $this->importFooter(array('product'=>'product'));//------------------ 레이아웃 종료
    }

    function productCateMng(){
      $this->importHead(array('product'=>'product'));//-------------------- 레이아웃 시작

      $DATA = $this->admin_model->getProductCateAll();
      $this->load->view('admin/product/productCateMng', array('gridData'=>$DATA->result(), 'rowCount'=>$DATA->num_rows()));

      $this->importFooter(array('product'=>'product'));//------------------ 레이아웃 종료
    }

    function ajaxUpdateProductCate(){
      $IDXKEY = $this->input->post('idxkey');
      $MODE = $this->input->post('mode');
      if($MODE=='up'){
        $CURRENT_CODE = $this->admin_model->getProductCateCodeByID($IDXKEY);
        if($CURRENT_CODE=='01'){
          echo json_encode(array('result'=>false, 'err_msg'=>'첫번째 카테고리입니다.'));
        }else{
          $NEXT_CODE = str_pad(($CURRENT_CODE),2,0,STR_PAD_LEFT);

          $IS_CODE = 'N';
          while($IS_CODE=='N'){
            $NEXT_CODE = str_pad(($NEXT_CODE-1),2,0,STR_PAD_LEFT);
            $IS_CODE = $this->admin_model->findNextProductCate($NEXT_CODE);
          }
          $this->admin_model->updateProductCate($NEXT_CODE, '00');
          $this->admin_model->updateProductCate($CURRENT_CODE, $NEXT_CODE);
          $this->admin_model->updateProductCate('00', $CURRENT_CODE);
          echo json_encode(array('result'=>true));
        }
      }else if($MODE=='down'){
        $CURRENT_CODE = $this->admin_model->getProductCateCodeByID($IDXKEY);
        if($CURRENT_CODE=='99'){
          echo json_encode(array('result'=>false, 'err_msg'=>'마지막 카테고리입니다.'));
        }else{
          $NEXT_CODE = str_pad(($CURRENT_CODE),2,0,STR_PAD_LEFT);

          $IS_CODE = 'N';
          while($IS_CODE=='N'){
            $NEXT_CODE = str_pad(($NEXT_CODE+1),2,0,STR_PAD_LEFT);
            $IS_CODE = $this->admin_model->findNextProductCate($NEXT_CODE);
          }
          $this->admin_model->updateProductCate($NEXT_CODE, '00');
          $this->admin_model->updateProductCate($CURRENT_CODE, $NEXT_CODE);
          $this->admin_model->updateProductCate('00', $CURRENT_CODE);
          echo json_encode(array('result'=>true));
        }
      }
    }

    function ajaxAddProductCate(){
      $cateName = $this->input->post('cateName');
      $NEXT_CODE = '01';
      $IS_CODE = 'Y';
      while($IS_CODE=='Y'){
        $NEXT_CODE = str_pad(($NEXT_CODE+1),2,0,STR_PAD_LEFT);
        $IS_CODE = $this->admin_model->findNextProductCate($NEXT_CODE);
      }

      $IDXKEY = $this->makeID('01');

      $Param = array(
        'IDX'=>$IDXKEY,
        'WORK_DV'=>'상품정보',
        'CODE_DV'=>'상품상세구분코드',
        'CODE_NM'=>$cateName,
        'CODE'=>$NEXT_CODE,
        'IS_USE'=>'Y',

      );
      $this->admin_model->insertCommonCode($Param);
      echo json_encode(array('result'=>true));
    }

    function ajaxDeleteProductCate(){
      $IDXKEY = $this->input->post('idxkey');
      $CURRENT_CODE = $this->admin_model->getProductCateCodeByID($IDXKEY);
      $KIND_COUNT = $this->admin_model->countProductCateKindByCode($CURRENT_CODE);
      if($KIND_COUNT == 0){
        $this->admin_model->deleteCommonCOde(array('IDX'=>$IDXKEY));
        echo json_encode(array('result'=>true));
      }else{
        echo json_encode(array('result'=>false, 'err_msg'=>'해당 카테고리에 상품이 할당되어 있어 삭제가 불가능합니다.'));
      }
    }

    function ajaxGetProductByID(){
        $id = $this->input->post('id');
        $ajaxData = $this->admin_model->getProductList(array('ID'=>$id),'IQT');
        echo json_encode(array('result'=>true, 'object'=>$ajaxData->result()));
    }

    function uploadProduct(){
      $postData = $this->input->post();
      $SEQ = $this->admin_model->getProductID();
      if(!empty($postData['PRD_ID'])){
        $SEQ = $postData['PRD_ID'];
      }
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
              $this->load->view('module/redirect',  array('url'=>'/admin/productList'));
        			break;
        		case UPLOAD_ERR_NO_FILE:
              $this->load->view('module/alert', array('text'=>'파일이 첨부되지 않았습니다.'));
              $this->load->view('module/redirect',  array('url'=>'/admin/productList'));
        			break;
        		default:
              $this->load->view('module/alert', array('text'=>'파일이 제대로 업로드되지 않았습니다.'));
              $this->load->view('module/redirect',  array('url'=>'/admin/productList'));
        	}
        	exit;
        }

        // 확장자 확인
        if( !in_array($ext, $allowed_ext) ) {
          $this->load->view('module/alert', array('text'=>'허용되지 않는 확장자입니다.'));
          $this->load->view('module/redirect',  array('url'=>'/admin/productList'));
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
        $result = move_uploaded_file($_FILES['PRD_IMG']['tmp_name'], "$uploads_dir/$name");

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
      $this->load->view('module/redirect',  array('url'=>'/admin/productList'.$postData['URL']));
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

    function productPriceMng(){
      $get_data = $this->input->get();
      $this->importHead(array('product'=>'product'));//-------------------- 레이아웃 시작
      $combo1 = $this->admin_model->getProductCateDV();
      $combo2 = $this->admin_model->getProductCateColor();
      $combo3 = $this->admin_model->getProductCateShape();
      $combo4 = $this->admin_model->getProductCateArea();
      $rowCount = $this->admin_model->getProductList($get_data,'COUNT');
      $this->load->view('admin/product/productPriceMng', array('gridData'=>$rowCount->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows(), 'combo1'=>$combo1, 'combo2'=>$combo2, 'combo3'=>$combo3, 'combo4'=>$combo4));
      $this->importFooter(array('product'=>'product'));//------------------ 레이아웃 종료
    }

    function ajaxUpdateProduct(){
      $postData = $this->input->post();
      $this->admin_model->updateProductPriceByID($postData);
      $this->admin_model->updateProductDisplay($postData);
      echo json_encode(array('result'=>true, 'today'=>date('Y.m.d',time())));
    }

    function paymentList(){//--------------------------------------------------------------------------------입금전 관리 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $gridData = $this->admin_model->getPaymentListGridData($get_data,'IQY','paymentList');
      $rowCount = $this->admin_model->getPaymentListGridData($get_data,'COUNT','paymentList');
      $this->load->view('admin/order/paymentList', array('gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function paymentConfServ(){//--------------------------------------------------------------------------------입금확인 SERVICE
      $post_data = $this->input->post('order_id');
      foreach($post_data as $item){
        $this->admin_model->setPaymentConf($item);
      }
    }

    function paymentConfCancleServ(){//--------------------------------------------------------------------------------입금확인취소 SERVICE
      $post_data = $this->input->post('order_id');
      foreach($post_data as $item){
        $this->admin_model->setPaymentConfCancle($item);
      }
    }

    function orderCancleServ(){//--------------------------------------------------------------------------------주문취소 SERVICE
      $post_data = $this->input->post('order_id');
      foreach($post_data as $item){
        $this->admin_model->setOrderCancle($item);
      }
    }

    function readyProduct(){//--------------------------------------------------------------------------------상품준비중 관리 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $gridData = $this->admin_model->getOrderListGridData($get_data,'IQY','readyProduct');
      $rowCount = $this->admin_model->getOrderListGridData($get_data,'COUNT','readyProduct');
      $comboData = $this->admin_model->getCommonCode('발주업무','발주진행상태');
      $this->load->view('admin/order/readyProduct', array('comboData'=>$comboData,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function onDelivery(){//--------------------------------------------------------------------------------배송중 관리 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $gridData = $this->admin_model->getOrderListGridData($get_data,'IQY','onDelivery');
      $rowCount = $this->admin_model->getOrderListGridData($get_data,'COUNT','onDelivery');
      $comboData = $this->admin_model->getCommonCode('발주업무','발주진행상태');
      $this->load->view('admin/order/onDelivery', array('comboData'=>$comboData,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function orderAllList(){//--------------------------------------------------------------------------------전체 주문조회 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $gridData = $this->admin_model->getOrderAllListGridData($get_data,'IQY','');
      $rowCount = $this->admin_model->getOrderAllListGridData($get_data,'COUNT','');
      $comboData1 = $this->admin_model->getCommonCode('주문업무','주문진행상태');
      $comboData2 = $this->admin_model->getCommonCode('발주업무','발주진행상태');
      $this->load->view('admin/order/orderAllList', array('comboData1'=>$comboData1, 'comboData2'=>$comboData2,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function updateOrderProgress(){//---------------------------------------------------------- 발주상태변경 SERVICE
      $FORDER_ID = $this->input->post('order_id');
      $PROGRESS = $this->input->post('progress');
      foreach($FORDER_ID as $item){
        $this->admin_model->updateOrderProgress($item,$PROGRESS);
      }
    }

    function createForder(){//--------------------------------------------------------------------------------발주요청 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $gridData = $this->admin_model->getPaymentListGridData($get_data,'IQY','createForder');
      $rowCount = $this->admin_model->getPaymentListGridData($get_data,'COUNT','createForder');
      $comboData = $this->admin_model->getCommonCode('주문업무','주문진행상태');
      $this->load->view('admin/order/createForder', array('comboData'=>$comboData,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function popupOrderDetail($id){ //-------------------------------------------------------------------------- 주문조회 -> 상세팝업 VIEW
      $gridData = $this->admin_model->getOrderDetailById($id);
      $paymentInfo = $this->admin_model->getPaymentInfo();
      $this->load->view('admin/order/popOrderDetail', array('gridData'=>$gridData, 'paymentInfo'=>$paymentInfo));
    }

    function popupForderPreview(){//------------------------------------------------------------------------------- 발주조회 -> 상세팝업 VIEW
      $get_data = $this->input->get('IDA');
      $dataArray = array();
      for($arrCnt=0;strlen($get_data)/20>$arrCnt;$arrCnt++){
        $dataArray[$arrCnt] = substr($get_data,$arrCnt*20,20);
      }
      $gridData = $this->admin_model->getForderBaseByOrderId($dataArray);
      $this->load->view('admin/order/popForderPreview', array('gridData'=>$gridData,'dataArray'=>$dataArray));
    }

    function writeForder(){
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $comboData = $this->admin_model->getCommonCode('발주업무','발주진행상태');
      $gridData = $this->admin_model->getForderRequestList($get_data,'IQY','writeForder');
      $rowCount = $this->admin_model->getForderRequestList($get_data,'COUNT','writeForder');
      $this->load->view('admin/order/writeForder', array('comboData'=>$comboData,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function createForderServ(){//------------------------------------------------------------------------------ 발주신청 SERVICE
      $getData = $this->input->post('IDA');
      $dataArray = array();
      for($arrCnt=0;strlen($getData)/20>$arrCnt;$arrCnt++){
        $dataArray[$arrCnt] = substr($getData,$arrCnt*20,20);
      }
      $gridData = $this->admin_model->getForderBaseByOrderId($dataArray);
      $ID = $this->makeID('04');
      $hashMap = array(
        'id'=>$ID,
        'forder_dv'=>'01',
        'created'=>date('YmdHis',time())
      );
      $result1 = $this->admin_model->insertFORDER_BASE($hashMap);
      if($result1){
        foreach($dataArray as $ORDER_ID){
          $result2 = $this->admin_model->setForderIDtoORDER($ORDER_ID,$ID);
          if($result2 == false){
            echo "<script>alert('발주서생성에 실패했습니다.');</script>";
            foreach($dataArray as $ORDER_ID){
              $this->admin_model->unsetForderIDtoORDER($ORDER_ID,$ID);
            }
            $this->admin_model->deleteFORDER_BASEById($hashMap);
            echo "<script>window.close();</script>";
          }
        }
      }else{
        echo "<script>alert('발주서생성에 실패했습니다.');</script>";
        echo "<script>window.close();</script>";
      }
      if($result2){
        foreach($gridData as $item){
          $result3 = $this->admin_model->insertFORDER_DETAIL($item,$hashMap['id']);
          if($result3==false){
            foreach($dataArray as $ORDER_ID){
              $this->admin_model->unsetForderIDtoORDER($ORDER_ID,$ID);
            }
            $this->admin_model->deleteFORDER_BASEById($hashMap);
            $this->admin_model->deleteFORDER_DETAILById($ID);
            echo "<script>alert('발주서생성에 실패했습니다.');</script>";
            echo "<script>window.close();</script>";
          }
        }
      }
      if($result3){
        echo "<script>alert('발주서생성을 완료했습니다.');</script>";
        echo "<script>window.opener.location.reload();</script>";
        echo "<script>window.close();</script>";
      }
    }

    function makeID($WORK_DV){//------------------------------------------------------------------------인덱스키 생성 SERVICE
      $seq = $this->admin_model->getSequency($WORK_DV,date('YmdHis',time()));
      return $WORK_DV.'01'.date('YmdHis',time()).$seq;
    }

    function writeModifiedForder(){//----------------------------------------------------------------- 발주요청 리스트 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $comboData = $this->admin_model->getCommonCode('발주업무','발주진행상태');
      $gridData = $this->admin_model->getForderRequestList($get_data,'IQY','writeModifiedForder');
      $rowCount = $this->admin_model->getForderRequestList($get_data,'COUNT','writeModifiedForder');
      $this->load->view('admin/order/writeModifiedForder', array('comboData'=>$comboData,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function popupWriteForder(){//------------------------------------------------------------------------------- 발주서작성2 -> 팝업 VIEW
      $FODID = $this->input->get('FODID');
      $MODE = $this->input->get('MODE');
      $MODIFY = $this->input->get('MODIFY');
      if(empty($MODIFY)){
        $MODIFY = 'true';
      }
      $ClassData = $this->admin_model->getOrderIDByFODID($FODID);
      $dataArray = array();
      $arrayCnt = 0;

      foreach($ClassData as $item){
        $dataArray[$arrayCnt] = $item->ORDER_ID;
        $arrayCnt++;
      }

      if(empty($dataArray)){
        echo "<script>alert('생성된 발주서가 없습니다.');</script>";
        echo "<script>window.close();</script>";
      }else{
        $gridData = $this->admin_model->getForderDetailByOrderId($dataArray);
        if($MODIFY=='true'){
          if($MODE=='10'){
            $this->load->view('admin/order/popWriteForder', array('gridData'=>$gridData,'dataArray'=>$dataArray, 'FODID'=>$FODID, 'MODIFY'=>$MODIFY));
          }else if($MODE=='20'){
            $this->load->view('admin/order/popWriteModifiedForder', array('gridData'=>$gridData,'dataArray'=>$dataArray, 'FODID'=>$FODID, 'MODIFY'=>$MODIFY));
          }else if($MODE=='30'){
            $this->load->view('admin/order/popWriteConfirmedForder', array('gridData'=>$gridData,'dataArray'=>$dataArray, 'FODID'=>$FODID, 'MODIFY'=>$MODIFY));
          }else if($MODE=='init'){
            $this->load->view('admin/order/popInitForderWrite', array('gridData'=>$gridData,'dataArray'=>$dataArray, 'FODID'=>$FODID, 'MODIFY'=>$MODIFY));
          }
        }else{
          $this->load->view('admin/order/popWriteForderComplete', array('gridData'=>$gridData,'dataArray'=>$dataArray, 'FODID'=>$FODID, 'MODE'=>$MODE));
        }
      }
    }

    function searchProduct(){
      $keyword = $this->input->post('keyword');
      $searchData = $this->admin_model->getSearchProduct($keyword);
      echo json_encode(array('result'=>true, 'data'=>$searchData));
    }

    function searchOrder(){
      $keyword = $this->input->post('keyword');
      $FODID = $this->input->post('FODID');
      $searchData = $this->admin_model->getSearchOrder($FODID,$keyword);
      echo json_encode(array('result'=>true, 'data'=>$searchData));
    }

    function addProductToForder(){
      $FODID = $this->input->get('FODID');
      $productList = $this->admin_model->getSearchProduct('');
      $orderList = $this->admin_model->getSearchOrder($FODID,'');
      $this->load->view('admin/order/addProductToForder', array('productList'=>$productList, 'orderList'=>$orderList, 'FODID'=>$FODID));
    }

    function addProductToForderServ(){
      $FODID = $this->input->post('FODID');
      $ODID = $this->input->post('ORDER_ID');
      $PRD_LIST = $this->input->post('PRD_LIST');
      foreach($PRD_LIST as $item){
        $PRD_ID = $item['PRD_ID'];
        $QTY = $item['QTY'];
        $IS_PRD = $this->admin_model->searchPRDinOrderDetail($ODID,$PRD_ID);
        if($IS_PRD == "Y"){

        }else if($IS_PRD == "N"){
          $this->admin_model->addOrderDetail($ODID, $PRD_ID, $QTY);
          $this->admin_model->addForderDetail($FODID, $ODID, $PRD_ID, $QTY);
        }
      }
      echo json_encode(array('result'=>true));
    }

    function completeForderServ(){
      $FODID = $this->input->post('FODID');
      $MEMO1 = $this->input->post('fmemo1');
      $MEMO2 = $this->input->post('fmemo2');
      $hashMap = array(
        'FODID'=>$FODID ,
        'MEMO1'=>$MEMO1 ,
        'MEMO2'=>$MEMO2
      );
      $this->admin_model->updateForderMemo($hashMap);
      $this->admin_model->updateForderProgress($FODID, '20');
      echo "<script>opener.parent.location.reload();</script>";
      echo "<script>window.close();</script>";


    }

    function ajaxUpdateForderPRG(){
      $FODID = $this->input->post('forderID');
      $PROGRESS = $this->input->post('progress');
      $PROGRESS = $PROGRESS-10;
      $this->admin_model->updateForderProgress($FODID, $PROGRESS);
      echo json_encode(array('result'=>true));
    }

    function writeForderSaveServ(){//--------------------------------------------------------------------------- 발주서 저장 SERVICE
      $postData = $this->input->post();
      $hashMap = array();
      $deliveryFee =  preg_replace("/[^0-9]/", "",$postData['delivery_fee']);
      $submitMode =  $postData['mode'];
      $FODID = $postData['FODID'];
      for($rowCnt=1; count($postData)/6>=$rowCnt; $rowCnt++){
        $PRD_QTY = $postData[$rowCnt."_qty"];
        $PRD_QTY = preg_replace("/[^0-9]/", "",$PRD_QTY);
        $PRD_PRICE = $postData[$rowCnt."_price"];
        $PRD_PRICE = preg_replace("/[^0-9]/", "",$PRD_PRICE);
        $hashMap[$rowCnt] = array(
          'PRD_ID'=>$postData[$rowCnt."_id"],
          'IS_PURCHASED'=>$postData[$rowCnt."_isPurchased"],
          'PRD_QTY'=>$PRD_QTY,
          'PRD_PRICE'=>$PRD_PRICE,
          'PURCHASE_SHOP'=>$postData[$rowCnt."_purchaseShop"],
          'MEMO'=>$postData[$rowCnt."_memo"]
        );
      }
      $result1 = true;
      foreach($hashMap as $item){
        $result1 = ($result1 && $this->admin_model->updateFORDER_DETAIL1($FODID,$item,$submitMode));
      }
      if($result1){
        $result2 = $this->admin_model->updateFORDER_BASE1($FODID,$deliveryFee,$submitMode,$postData['fmemo1'],$postData['fmemo2']);
        $result2 = true;
        if($result2){
          if($submitMode==1){
            echo "<script>location.href='/admin/popupWriteForder?FODID=".$FODID."&MODE=20';</script>";
          }else if($submitMode==2){
            echo "<script>opener.parent.location.reload();</script>";
            echo "<script>window.close();</script>";
          }
        }else{
          echo "<script>alert('발주서 저장에 실패했습니다.');</script>";
          echo "<script>location.href='/admin/popupWriteForder?FODID=".$FODID."';</script>";
        }
      }else{
        echo "<script>alert('발주서 저장에 실패했습니다.');</script>";
        echo "<script>location.href='/admin/popupWriteForder?FODID=".$FODID."';</script>";
      }
    }

    function writeConfirmedForderSaveServ(){//--------------------------------------------------------------------------- 발주서 저장 SERVICE
      $postData = $this->input->post();
      $hashMap = array();
      $deliveryFee =  preg_replace("/[^0-9]/", "",$postData['delivery_fee']);
      $submitMode =  $postData['mode'];
      $FODID = $postData['FODID'];
      for($rowCnt=1; count($postData)/6>=$rowCnt; $rowCnt++){
        $PRD_QTY = $postData[$rowCnt."_qty"];
        $PRD_QTY = preg_replace("/[^0-9]/", "",$PRD_QTY);
        $PRD_PRICE = $postData[$rowCnt."_price"];
        $PRD_PRICE = preg_replace("/[^0-9]/", "",$PRD_PRICE);
        $hashMap[$rowCnt] = array(
          'PRD_ID'=>$postData[$rowCnt."_id"],
          'IS_PURCHASED'=>$postData[$rowCnt."_isPurchased"],
          'PRD_QTY'=>$PRD_QTY,
          'PRD_PRICE'=>$PRD_PRICE,
          'PURCHASE_SHOP'=>$postData[$rowCnt."_purchaseShop"],
          'MEMO'=>$postData[$rowCnt."_memo"]
        );
      }
      $result1 = true;
      foreach($hashMap as $item){
        $result1 = ($result1 && $this->admin_model->updateFORDER_DETAIL2($FODID,$item,$submitMode));
      }
      if($result1){
        $result2 = $this->admin_model->updateFORDER_BASE1($FODID,$deliveryFee,$submitMode,$postData['fmemo1'],$postData['fmemo2']);
        $result2 = true;
        if($result2){
          if($submitMode==1){
            echo "<script>location.href='/admin/popupWriteForder?FODID=".$FODID."&MODE=30';</script>";
          }else if($submitMode==2){
            echo "<script>opener.parent.location.reload();</script>";
            echo "<script>window.close();</script>";
          }
        }else{
          echo "<script>alert('발주서 저장에 실패했습니다.');</script>";
          echo "<script>location.href='/admin/popupWriteForder?FODID=".$FODID."';</script>";
        }
      }else{
        echo "<script>alert('발주서 저장에 실패했습니다.');</script>";
        echo "<script>location.href='/admin/popupWriteForder?FODID=".$FODID."';</script>";
      }
    }

    function writeConfirmedForder(){//----------------------------------------------------------------- 발주품수령 리스트 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $comboData = $this->admin_model->getCommonCode('발주업무','발주진행상태');
      $gridData = $this->admin_model->getForderRequestList($get_data,'IQY','writeConfirmedForder');
      $rowCount = $this->admin_model->getForderRequestList($get_data,'COUNT','writeConfirmedForder');
      $this->load->view('admin/order/writeConfirmedForder', array('comboData'=>$comboData,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function forderConfirm(){//----------------------------------------------------------------- 발주품수령 리스트 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $comboData = $this->admin_model->getCommonCode('발주업무','발주진행상태');
      $gridData = $this->admin_model->getForderRequestList($get_data,'IQY','forderConfirm');
      $rowCount = $this->admin_model->getForderRequestList($get_data,'COUNT','forderConfirm');
      $this->load->view('admin/order/forderConfirm', array('comboData'=>$comboData,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function popupAddForder($forderID){
      $ClassData = $this->admin_model->getOrderIDByFODID($forderID);
      $dataArray = array();
      $arrayCnt = 0;
      foreach($ClassData as $item){
        $dataArray[$arrayCnt] = $item->ORDER_ID;
        $arrayCnt++;
      }
      $gridData = $this->admin_model->getForderDetailByOrderId($dataArray);
      $this->load->view('admin/order/popAddForder', array('gridData'=>$gridData));
    }

    function updateForderProgress(){//---------------------------------------------------------- 발주상태변경 SERVICE
      $FORDER_ID = $this->input->post('forder_id');
      $PROGRESS = $this->input->post('progress');
      foreach($FORDER_ID as $item){
        $this->admin_model->updateForderProgress($item,$PROGRESS);
      }
    }

    function ajaxCancleForder(){
      $FORDER_ID = $this->input->post('forder_id');
      foreach($FORDER_ID as $item){
        $this->admin_model->cancleForder($item);
      }
    }

    function forderAllList(){//----------------------------------------------------------------- 전체 발주리스트 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('order'=>'order'));//-------------------- 레이아웃 시작
      $comboData = $this->admin_model->getCommonCode('발주업무','발주진행상태');
      $gridData = $this->admin_model->getForderRequestList($get_data,'IQY','');
      $rowCount = $this->admin_model->getForderRequestList($get_data,'COUNT','');
      $this->load->view('admin/order/forderAllList', array('comboData'=>$comboData,'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('order'=>'order'));//------------------ 레이아웃 종료
    }

    function commonCodeMng(){//----------------------------------------------------------------- 공통코드관리 VIEW
      $get_data = $this->input->get();
      $this->importHead(array('common'=>'common'));//-------------------- 레이아웃 시작
      $comboData1 = $this->admin_model->getWorkDV();
      $comboData2=array();
      if(!empty($get_data['WORK_DV'])){
        $comboData2 = $this->admin_model->getCodeDV($get_data['WORK_DV']);
      }
      $gridData = $this->admin_model->getAllCommonCode($get_data,'IQY');
      $rowCount = $this->admin_model->getAllCommonCode($get_data,'COUNT');
      $this->load->view('admin/common/commonCodeMng', array('comboData1'=>$comboData1, 'comboData2'=>$comboData2, 'gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));
      $this->importFooter(array('common'=>'common'));//------------------ 레이아웃 종료
    }

    function ajaxGetCodeDVByWorkDV(){  //----------------------------------------------------------------- AJAX 업무구본코드로 코드구분코드 가져오기 AJAX
      $WORK_DV = $this->input->post('WORK_DV');
      $result = $comboData = $this->admin_model->getCodeDV($WORK_DV);
      if($result){
        echo json_encode(array('result'=>true, 'object'=>$result));
      }
      else{
        echo json_encode(array('result'=>false, 'object'=>$result));
      }
    }
    function updateCommonCode(){
      $postData = $this->input->post();
      $result="";
      if(empty($postData['IDX'])){
        $postData['IDX'] = $this->makeID('01');
        $result = $this->admin_model->insertCommonCode($postData);
      }else{
        if(empty($postData['WORK_DV']) && empty($postData['CODE_DV']) && empty($postData['CODE_NM']) && empty($postData['CODE'])){
          $result = $this->admin_model->deleteCommonCode($postData);
        }
        else{
          $result = $this->admin_model->updateCommonCode($postData);
        }
      }

      if($result){
        echo json_encode(array('result'=>true));
      }
      else{
        echo json_encode(array('result'=>false));
      }
    }

    function sqlMng(){//----------------------------------------------------------------- 공통코드관리 VIEW
      $SQL = $this->input->post('SQL');
      $this->importHead(array('common'=>'common'));//-------------------- 레이아웃 시작
      if(empty($SQL)){
        $this->load->view('admin/common/sqlMng');
      }else{

        try{
          $gridData = $this->admin_model->getSQL($SQL);
        }
        catch(Exception $e){
          $gridData = $e->getMessage();
          $SQL = $e->getMessage();
        }

        $this->load->view('admin/common/sqlMng', array('SQL'=>$SQL, 'gridData'=>$gridData->result()));
      }
      $this->importFooter(array('common'=>'common'));//------------------ 레이아웃 종료
    }

    function addproduct(){
        $this->load->view('composition/header');
        $this->load->view('admin/product_upload');
        $this->load->view('composition/footer');
    }

    function check(){
        $id = $this->session-> userdata('user_id');
        $start_index=$this->input->get('start_index');
        if(empty($start_index)){
            $start_index=1;
        }
        if($start_index==null){
            $start_index=1;
        }

        $data['product_info']=$this->admin_model->get_product($id,$start_index);
        $data['last_index']=$this->admin_model->get_last_index($id);
        $data['start_index']=$start_index;

        $this->load->view('composition/header');
        $this->load->view('admin/product_view',$data);
        $this->load->view('composition/footer');
    }

    function deleteProduct(){
        $data = $this->input->post('chk');
        $id = $this->session-> userdata('user_id');
        foreach ($data as $value) {
            $this->admin_model->delete_product($value, $id);
        }

    }

    function modifyPopup($type){
        $id = $this->session-> userdata('user_id');
        $pid = $this->input->get('pid');

         switch($type){
             case "product_name" :
             case "product_amount" :
                 if($type=="product_name")
                     $data['type']="상품명";
                 if($type=="product_amount")
                     $data['type']="재고량";
                 $data['product'] = $this->admin_model->get_pInfo($pid,$id,$type);
                 $this->load->view('admin/modify_product_1',$data);
                 break;
             case "product_price_w" :
             case "product_price_r" :
                 $data['type']="도매/소매가";
                 $data['product'] = $this->admin_model->get_pInfo($pid,$id,$type);
                 $this->load->view('admin/modify_product_2',$data);
                 break;
             case "product_id" :   //이미지에 쓰임
                 if($type=="product_id")
                     $data['type']="이미지";
                 $data['product'] = $this->admin_model->get_pInfo($pid,$id,$type);
                 $this->load->view('admin/modify_product_3',$data);
                 break;
         }
    }

    function modify_product1(){
        $pname = $this->input->post('pname');
        $pamount = $this->input->post('pamount');
        $pid = $this->input->post('pid');
        if($pamount==""){
        $this->admin_model->modify_product1_1($pname,$pid);
        echo  "<script type='text/javascript'>";
        echo "opener.parent.location.reload();";
        echo "window.close();";
        echo "</script>";
        }
        if($pname==""){
        $this->admin_model->modify_product1_2($pamount,$pid);
        echo  "<script type='text/javascript'>";
        echo "opener.parent.location.reload();";
        echo "window.close();";
        echo "</script>";
        }
    }

    function modify_product2(){
        $price_w = $this->input->post('price_w');
        $price_r = $this->input->post('price_r');
        $pid = $this->input->post('pid');
        $today = date("Y-m-d");
        $this->admin_model->modify_product2($price_w,$price_r,$pid,$today);
        echo  "<script type='text/javascript'>";
        echo "opener.parent.location.reload();";
        echo "window.close();";
        echo "</script>";
    }

    function modify_product3(){
        if(!isset($_SESSION['is_login'])){
            echo "<script>alert('로그인 후, 이용해주세요.'); window.location.href='/auth/login'; </script>";
            return;
        }
        $pid = $this->input->post('pid');
        $file1 = $this->input->post('file1');
        $file2 = $this->input->post('file2');
        $file3 = $this->input->post('file3');
        $file4 = $this->input->post('file4');

        $config['upload_path'] = './static/uploads/products';
        $config['allowed_types'] = 'png';
        $config['max_size'] = 500;
        $config['max_width'] = 1024;
        $config['max_height'] = 768;

        $this->load->library('upload', $config);

        $_FILES['file']['name'] = "test.png";

        if(! $this->upload->do_upload()){
            echo "error";
        }
        else{
            echo "sucess";
        }
    }
    function test(){
      echo $this->admin_model->test();
    }

    function noticeMng(){
      $get_data = $this->input->get();
      $this->importHead(array('board'=>'board'));//-------------------- 레이아웃 시작

        $gridData = $this->admin_model->getBoardByType($get_data,'IQY','01');
        $rowCount = $this->admin_model->getBoardByType($get_data,'COUNT','01');
        $this->load->view('admin/board/noticeMng', array('gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));


      $this->importFooter(array('board'=>'board'));//------------------ 레이아웃 종료
    }

    function faqMng(){
      $get_data = $this->input->get();
      $this->importHead(array('board'=>'board'));//-------------------- 레이아웃 시작
        $comboData = $this->admin_model->getBoardCate();
        $gridData = $this->admin_model->getBoardByType($get_data,'IQY','02');
        $rowCount = $this->admin_model->getBoardByType($get_data,'COUNT','02');
        $this->load->view('admin/board/faqMng', array('gridData'=>$gridData->result(), 'comboData'=>$comboData, 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));


      $this->importFooter(array('board'=>'board'));//------------------ 레이아웃 종료
    }

    function questionMng(){
      $get_data = $this->input->get();
      $this->importHead(array('board'=>'board'));//-------------------- 레이아웃 시작

        $gridData = $this->admin_model->getBoardByType($get_data,'IQY','03');
        $rowCount = $this->admin_model->getBoardByType($get_data,'COUNT','03');
        $this->load->view('admin/board/questionMng', array('gridData'=>$gridData->result(), 'getData'=>$get_data, 'rowCount'=>$rowCount->num_rows()));


      $this->importFooter(array('board'=>'board'));//------------------ 레이아웃 종료
    }

    function ajaxGetBoard(){
      $id = $this->input->post('id');
      $ajaxData = $this->admin_model->getBoardByID($id);
      echo json_encode(array('result'=>true, 'data'=>$ajaxData));
    }

    function ajaxUpdateRetext(){
      $id = $this->input->post('id');
      $retext = $this->input->post('retext');
      $ajaxData = $this->admin_model->ajaxUpdateRetext($id,$retext);
      echo json_encode(array('result'=>$ajaxData));
    }

    function ajaxDeleteBoard(){
      $id = $this->input->post('id');
      $ajaxData = $this->admin_model->ajaxDeleteBoard($id);
      echo json_encode(array('result'=>$ajaxData));
    }

    function ajaxWriteBoard(){
      $title = $this->input->post('title');
      $text = $this->input->post('text');
      $type = $this->input->post('type');
      $cate = $this->input->post('cate');
      $id = $this->makeID('05');
      $ajaxData = $this->admin_model->ajaxWriteBoard($id,$title,$text,$type,$cate);
      echo json_encode(array('result'=>true));
    }

    function ajaxUpdateBoard(){
      $title = $this->input->post('title');
      $text = $this->input->post('text');
      $type = $this->input->post('type');
      $id = $this->input->post('id');
      $ajaxData = $this->admin_model->ajaxUpdateBoard($id,$title,$text);
      echo json_encode(array('result'=>true));
    }

    function accountsList(){//------------------------------------------------------------------회계관리 - 회계장부조회
      $get_data = $this->input->get();
      $this->importHead(array('account'=>'account'));//-------------------- 레이아웃 시작

      if(empty($get_data['FRDT'])){
        $get_data['FRDT'] = date('Y-m-d', strtotime("-7 days"));
      }
      if(empty($get_data['TODT'])){
        $get_data['TODT'] = date('Ymd',time());
      }
      $gridData = $this->admin_model->getAccountGridDataByDays($get_data);
      $gridData2 = $this->admin_model->getAccountGridDataByDaysTT($get_data);

      $this->load->view('admin/account/accountList', array('getData'=>$get_data, 'gridData2'=>$gridData2, 'gridData'=>$gridData));

      $this->load->view('admin/layout/importCalendar');
      $this->importFooter(array('account'=>'account'));//------------------ 레이아웃 종료
    }




}
