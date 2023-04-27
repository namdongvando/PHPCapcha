<?php
namespace PHPCapcha;

class Capcha
{
    private static $security_code = "phpcapcha_namdong92@gmail.com_security_code";
    const permitted_chars = '0123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
    public function __construct($config = null)
    {
        self::$security_code = $config["Name"] ?? "phpcapcha_namdong92@gmail.com_security_code";
    }

    public static function setName($name = "phpcapcha_namdong92@gmail.com_security_code")
    {
        self::$security_code = $name;
    }
    private static function getName()
    {
        return self::$security_code ?? "phpcapcha_namdong92@gmail.com_security_code";
    }
    public static function getValue()
    {
        return $_SESSION[self::$security_code] ?? null;
    }
    static function generate_string($input, $strength = 10)
    {
        $input_length = strlen($input);
        $random_string = '';
        for ($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    public static function CreateImg($string_length = 6)
    {

        $_SESSION[self::$security_code] = $_SESSION[self::$security_code] ?? "";
        $image = imagecreate(200, 50) or die("Cannot Initialize new GD image stream");
        imageantialias($image, true);
        $colors = [];
        $red = rand(125, 175);
        $green = rand(125, 175);
        $blue = rand(125, 175);
        for ($i = 0; $i < 5; $i++) {
            $colors[] = imagecolorallocate($image, $red - 20 * $i, $green - 20 * $i, $blue - 20 * $i);
        }
        imagefill($image, 0, 0, $colors[0]);
        for ($i = 0; $i < 10; $i++) {
            imagesetthickness($image, rand(2, 10));
            $line_color = $colors[rand(1, 4)];
            imagerectangle(
                $image,
                rand(-10, 190),
                rand(-10, 10),
                rand(-10, 190),
                rand(40, 60),
                $line_color
            );
        }
        $black = imagecolorallocate($image, 0, 0, 0);
        $gray = imagecolorallocate($image, 255, 255, 255);
        $colos200 = imagecolorallocate($image, 200, 200, 200);
        $white = imagecolorallocate($image, 150, 105, 150);
        $textcolors = [
            $black,
            $white,
            $gray,
            $colos200
        ];
        $fonts = [
            dirname(__FILE__) . '/fonts/Acme.ttf',
            dirname(__FILE__) . '/fonts/Ubuntu.ttf',
            dirname(__FILE__) . '/fonts/Acme.ttf',
            dirname(__FILE__) . '/fonts/Ubuntu.ttf'
        ];

        $captcha_string = self::generate_string(self::permitted_chars, $string_length);
        $_SESSION[self::$security_code] = $captcha_string;
        // var_dump($fonts[array_rand($fonts)]);
        for ($i = 0; $i < $string_length; $i++) {
            $letter_space = 170 / $string_length;
            $initial = 15;
            imagettftext(
                $image,
                24,
                rand(-15, 15),
                $initial + $i * $letter_space,
                rand(25, 45),
                $textcolors[array_rand($textcolors)],
                $fonts[array_rand($fonts)],
                $captcha_string[$i]
            );
        }
        header('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    }


    public static function setPropTable($prop)
    {
        $tbl = "";
        foreach ($prop as $key => $value) {
            $tbl .= $key . ' = "' . $value . '" ';
        }
        return $tbl;
    }

    public static function Img($src, $prop)
    {
        $propHtml = self::setPropTable($prop);
        return <<<HTML
        <img src="{$src}" {$propHtml} >        
HTML;
    }
    public static function CapchaElement($id, $linkImg, $prop = [])
    {
        $classicon = $prop["class-icon"] ?? "";
        $lblRefesh = "";
        if (!$classicon) {
            $lblRefesh = "Refresh";
        }
        $prop["id"] = $id;
        $img = self::Img($linkImg, $prop);
        return <<<HTML
    {$img}
    <label 
        onclick="document.getElementById('{$id}').src='{$linkImg}'+ Date.now()" class="btn btn-success">
        <i class="{$classicon}" style="line-height: 30px;">{$lblRefesh}</i>
    </label> 
HTML;


    }

}
?>