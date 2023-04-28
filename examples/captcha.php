<?php

session_start();
include_once "../src/Captcha.php";
use PHPCaptcha\Captcha;

$lenght = $_GET["l"] ?? 6;
Captcha::CreateImg($lenght);

?>