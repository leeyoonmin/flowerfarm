<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    function ajaxCartAddItem(){//--------------------// AJAX 장바구니 담기 SERVICE
      $postData = $this->input->post();

      $data = array(
        'id'      => $postData['id'],
        'qty'     => 1,
        'price'   => $postData['price'],
        'name'    => $postData['name'],
        'kind'    => $postData['kind'],
        'extension'    => $postData['extension']
      );

      $qty = 1;
      foreach($this->cart->contents() as $item){
        if($item['id']==$postData['id']){
          $qty = $item['qty'];
        }
      }

      $this->load->model('cart_model');
      $IS_STOCK = $this->cart_model->getStockCheck($data['id'],$qty+1)->IS_STOCK;
      if($IS_STOCK =='N'){
        echo json_encode(array('result'=>false));
      }else{
        $result = $this->cart->insert($data);
        $qty="";
        foreach($this->cart->contents() as $item){
          if($item['id']==$postData['id']){
            $qty = $item['qty'];
          }
        }
        echo json_encode(array('result'=>true, 'qty'=>$qty));
      }
    }

    function ajaxCartTotalPrice(){//--------------------// AJAX 장바구니 총 가격 출력 // SERVICE
      $prdCnt = 0;
      foreach($this->cart->contents() as $item){
        $prdCnt++;
      }
      echo json_encode(array('result'=>true, 'price'=>$this->cart->total(), 'count'=>number_format($prdCnt)));
    }

    function ajaxUpdateCartItemCount(){//--------------------// AJAX 장바구니 상품 수량 업데이트 // SERVICE
      $postData = $this->input->post();
      $retrunCnt = 0;
      $IS_STOCK = "Y";
      foreach($this->cart->contents() as $item){
        if($item['id']==$postData['id']){
          if($postData['qty']==""){
            if($postData['mode'] == "plus"){
              $data = array(
                'rowid' => $item['rowid'],
                'qty'   => $item['qty']+1
              );
              $this->load->model('cart_model');
              $IS_STOCK = $this->cart_model->getStockCheck($item['id'],$data['qty'])->IS_STOCK;
            }else if($postData['mode'] == "minus"){
              $data = array(
                'rowid' => $item['rowid'],
                'qty'   => $item['qty']-1
              );
            }
          }else{
            $data = array(
              'rowid' => $item['rowid'],
              'qty'   => 0
            );
          }

          $retrunCnt = $data['qty'];
        }
      }
      if($IS_STOCK == "N"){
        echo json_encode(array('result'=>false));
      }else{
        echo json_encode(array('result'=>true, 'qty'=>number_format($retrunCnt)));
        $this->cart->update($data);
      }
    }

    function ajaxDeleteCartItem(){
      $id = $this->input->post('id');
      foreach($this->cart->contents() as $item){
        if($item['id']==$id){
          $data = array(
            'rowid' => $item['rowid'],
            'qty'   => 0
          );
          $this->cart->update($data);
          echo json_encode(array('result'=>true));
        }
      }
    }
}
