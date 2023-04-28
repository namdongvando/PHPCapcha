## Project Overview
## System Requirements
PHP >= 7.0
## Installation Instructions
Composer is the easiest way to manage dependencies in your project. Create a file named composer.json with the following:
```json
{
    "require": {
       "namdongvando/phpcaptcha": "^0.10"
    }
}
```
And run Composer to install captcha:

```bash
composer require namdongvando/phpcaptcha
```

## Code Samples
captcha.php
```php

session_start();
include_once "../src/Captcha.php";
use PHPCaptcha\captcha;

$lenght = $_GET["l"] ?? 6;
captcha::CreateImg($lenght);


```
```php
<?php
include_once "../src/Captcha.php";
session_start();
use PHPcaptcha\Captcha;

if (isset($_POST["btn"])) {
    if ($_POST["captcha"] == Captcha::getValue()) {
        var_dump($_POST["captcha"]);
        var_dump(Captcha::getValue());
        echo "ok";
    }
}



?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP captcha</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="text-center">Hello World</h1>

        <form action="" method="POST" role="form">
            <legend>Đăng Ký</legend>
            <div class="form-group">
                <label for="">Tài Khoản</label>
                <input type="text" value="username" required="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Mật Khẩu</label>
                <input type="text" value="password" required="" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" required="" value="email@dmail.abc" class="form-control">
            </div>
            <?php
            echo captcha::captchaElement("idcaptchaImg", "/examples/captcha.php?l=6&v=1", ["class-icon" => "glyphicon glyphicon-refresh"]);
            ?>
            <div class="form-group">
                <label for="">captcha</label>
                <input type="text" name="captcha" required="" class="form-control" placeholder="Input captcha">
            </div>
            <button type="submit" name="btn" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
 
```
