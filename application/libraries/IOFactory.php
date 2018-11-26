<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 12.
 * Time: PM 2:19
 */
defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('PHPExcel/PHPExcel_IOFactory');

class IOFactory extends PHPExcel_IOFactory{
    function __construct(){
        parent::__construct();
    }
}

?>