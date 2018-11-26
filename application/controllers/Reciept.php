<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reciept extends CI_Controller {
     function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');

     }
    function index()
    {

    }
    function inputdata(){
        $data= array(
            'out_order_id' => '',
            'user_id' =>$this->session-> userdata('user_id'),
            'order_seller'=> $this->input->post('seller'),
            'product_name'=> $this->input->post('product_name'),
            'order_amount'=> $this->input->post('amount'),
            'order_time' => $this->input->post('day'),
            'order_price'=> $this->input->post('price')
             );
        $this->load->model('reciept_model');
        $this->reciept_model->input_outOrder_product($data);
        $id = $this->session->userdata('user_id');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $this->showOutOrder($id,$start,$end);
    }
    function deletedata()
    {
        $data = $this->input->post('chk');
        $id = $this->session-> userdata('user_id');
        $this->load->model('reciept_model');
        foreach ($data as $value) {
            $this->reciept_model->delete_outOrder_product($value, $id);
        }
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $this->showOutOrder($id,$start,$end);
    }
    function showOutOrder($id,$start,$end){
        $this->load->model('reciept_model');
        if (isset($start)) {

            $data['outOrder_product'] = $this->reciept_model->get_outOrder_product($id, $start, $end);
            $data['out_all_price'] = number_format($this->reciept_model->get_all_price('OUT_ORDER_TB', $id, $start, $end));
            $data['start']=$start;
            $this->load->view('mypage/reciept/out_order_product', $data);

        }
    }
    function action($start){
        $end=date("Y-m-d",strtotime($start."+1month-1day"));
        $this->load->model('reciept_model');
        $this->load->library('excel');
        $object = new PHPExcel();
        $object->setActiveSheetIndex(0);

        $table_columns = array("판매처", "품종", "수량", "날짜", "가격","총가격");
        $column = 0;
        foreach ($table_columns as $field){
            $object->getActiveSheet()->setCellValueByColumnAndRow($column,1,$field);
            $column++;
        }

        $id = $this->session-> userdata('user_id');
        $employee_data = $this->reciept_model->excelfile($id,$start,$end);
        $total =0;
        $excel_row =2;
        foreach ($employee_data as $row){
            $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(0,$excel_row, $row->order_seller);
            $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(1,$excel_row, $row->product_name);
            $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(2,$excel_row, $row->order_amount);
            $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(3,$excel_row, $row->order_time);
            $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(4,$excel_row, $row->order_price);
            $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(5,$excel_row, $row->all);
            $total += $row->all;
            $excel_row++;
        }
        $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(0,++$excel_row, '총액');
        $object->getActiveSheet()->setCellValueExplicitByColumnAndRow(5,$excel_row, $total);
        //마지막 총액
        $object_writer = PHPExcel_IOFactory::createWriter($object,'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="영수증.xls"');
        $object_writer->save('php://output');
    } // 엑셀파일 추출
    function show_all_order($start){
        $end=date("Y-m-d",strtotime($start."+1month-1day"));
        $this->load->model('reciept_model');
        $id = $this->session->userdata('user_id');
        $data['all_product']=$this->reciept_model->show_all_order($id,$start,$end);
        $this->load->view('mypage/reciept/all_product', $data);
    }




}
