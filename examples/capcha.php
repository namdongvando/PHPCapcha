<?php
session_start();
include_once "../src/Capcha.php";
use PHPCapcha\Capcha;

$lenght = $_GET["l"] ?? 6;
Capcha::CreateImg($lenght);

?>