<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('customLog'))
{
    //인자로 들어오는 값을 2번 쓰는 잉여함수
    function custLog($mode,$class,$function,$user_id,$message)
    {
      if($mode=='sql'){
        $logfile = fopen("log/".date('Ymd',time()).".log", "a") or die("Unable to open file!");
        $txt = "#SQL#".$class."->".$function." #ByID ".$user_id."# [".date('Y-m-d H:i:s]')." \r\n".$message."\r\n";

        fwrite($logfile, $txt);
        fclose($logfile);
      }
    }

    function custLogR($mode,$class,$function,$user_id,$message,$result)
    {
      if($mode=='sql'){
        $logfile = fopen("log/".date('Ymd',time()).".log", "a") or die("Unable to open file!");
        $txt = "#SQL#".$class."->".$function." #ByID ".$user_id."# [".date('Y-m-d H:i:s]')." \r\n".$message."\r\n";
        if(!empty($result)){
          $txt = $txt."==========================================================\r\n";
          $txt = $txt."\t\tResult\r\n";
          $txt = $txt."==========================================================\r\n";
          $sizeArr = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
          $keyArr = array();

          $cnt = 0;
          $maxSize = 0;

          foreach($result as $item){
            if($cnt != 99){
              foreach($item as $key=>$value){
                $keyArr[$cnt] = $value;
                $cnt++;
              }
            }
            $cnt = 99;
          }
          $cnt = 0;
          foreach($result as $item){
            foreach($item as $key=>$value){
              if($sizeArr[$cnt] < strlen($value)){
                $sizeArr[$cnt] = strlen($value);
              }
              $cnt++;
            }
            $cnt=0;
          }

          foreach($result as $item){
            foreach($item as $key=>$value){
              if($sizeArr[$cnt] < strlen($key)){
                $sizeArr[$cnt] = strlen($key);
              }
              $cnt++;
            }
            $cnt=0;
          }

          $cnt = 0;
          foreach($sizeArr as $size){
            if($size>1){
              $txt = $txt.str_pad($size, $size)." | ";
            }

            $cnt++;
          }
          $txt = $txt."\r\n";

          $cnt = 0;
          foreach($result[0] as $key=>$value){
            $txt = $txt.str_pad($key, $sizeArr[$cnt])." | ";
            $cnt++;
          }
          $txt = $txt."\r\n";
          $cnt = 0;
          foreach($result as $item){
            foreach($item as $key=>$value){
              $txt = $txt.str_pad($value, $sizeArr[$cnt])." | ";
              $cnt++;
            }
            $txt = $txt."\r\n";
            $cnt=0;
          }
        }else{
          $txt = $txt."==========================================================\r\n";
          $txt = $txt."\t\tEmpty Result\r\n";
          $txt = $txt."==========================================================\r\n";
        }

        fwrite($logfile, $txt);
        fclose($logfile);
      }
    }
}
?>
