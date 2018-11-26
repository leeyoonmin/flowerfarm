<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('customLog'))
{
    //인자로 들어오는 값을 2번 쓰는 잉여함수
    function custlog($parameter)
    {
        return $parameter . "  " .  $parameter;
    }
}
?>
