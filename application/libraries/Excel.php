<?php
/**
 * Created by PhpStorm.
 * User: messi
 * Date: 2018. 7. 12.
 * Time: PM 2:16
 */

defined('BASEPATH') OR exit('No direct script access allowed');
require_once ('PHPExcel.php');


class Excel extends PHPExcel{

    function __construct(){
        parent::__construct();
    }

}

?>