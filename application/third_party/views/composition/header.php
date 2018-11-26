<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>꽃팜</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/static/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/static/css/basic.css">
    <link rel="stylesheet" type="text/css" href="/static/css/header_footer.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/font-nanum/1.0/nanumgothic/nanumgothic.css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>
<body>
<div class="wrap">
    <div class="banner-area">
        <div class="banner-top">
            <img src="/static/img/header_banner_top.png">
            <a class="top-banner-hide"><i class="fas fa-times fa-lg"></i></a>
        </div>
    </div>
    <header>
        <div class="header-util">
            <li id="cart">
                <a href="/cart">장바구니</a>
            </li>
            <li id="mypage">
                <a href="<?php echo base_url();?>mypage">마이페이지</a>
            </li>
            <?php
            if(isset($_SESSION['is_login']) && $_SESSION['is_login'] == true){
                ?>
                <li>
                    <a href="/auth/logout">로그아웃</a>
                </li>
                <?php
            }else{
                ?>
                <li id="register">
                    <a href="/auth/join ">회원가입</a>
                </li>
                <li id="login">
                    <a href="/auth/login">로그인</a>
                </li>
                <?php
            }
            ?>
        </div>
        <div class="header-main">
            <div class="logo">
                <a href="/"><img class="logo-img" src="/static/img/ff_logo.png"></a>
            </div>
            <div class="search-box">
                <div>
                    <input class="search-input" name="search" onkeypress="if( event.keyCode==13 ){search();}">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
            <div class="header-ad">
                <a>
                    <img class="banner-img" src="/static/img/header_banner_right.png">
                </a>
            </div>
        </div>
        <div class="header-navbar">
            <div class="navbar-menu">
                <li><a href="<?php echo base_url();?>product/1">도매</a></li>
                <li><a href="<?php echo base_url();?>product/2">부자재</a></li>
                <li><a href="<?php echo base_url();?>currentPrice">시세</a></li>
                <?php
                $usrType=$this->session->userdata('user_type');
                $baseURL = base_url();
                if($usrType==2 || $usrType==3){
                  echo "<li><a href=$baseURL"."mypage/reciept_seller>영수증</a></li>";
                }
                else if($usrType==4 || $usrType==5){
                    echo "<li><a href=$baseURL"."mypage/reciept>영수증</a></li>";
                }
                else{
                    echo "<li><a href=$baseURL"."mypage/reciept>영수증</a></li>";
                }
                ?>

            </div>
        </div>
    </header>