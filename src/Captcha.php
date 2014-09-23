<?php 
namespace Devfactory\Captcha;

use Session, Hash, URL;

class Captcha {
    public static function createMath($id){
        $digit = '0123456789';
        $ops_char   = '+*';
        
        $first_digit = (int) mt_rand(0,9);
        $last_digit  = (int) mt_rand(0,9);

        $ops = $ops_char[mt_rand(0,1)];
        
        $result = -1;
        if($ops == '+'){
            $result = $first_digit + $last_digit;
        }else if($ops == '*'){
            $result = $first_digit * $last_digit;
        }
        
        Session::put('capchaHash' . $id, Hash::make($result));
        $capcha_text = $first_digit." ".$ops." "$last_digit;

        $image = imagecreate(160, 70);
        $background = imagecolorallocatealpha($image, 239, 239, 239, 1);
        $textColor = imagecolorallocatealpha($image, 0, 0, 0, 1);
        $x = 5;
        $y = 50;
        $angle = 0;

        for($i = 0; $i < 7; $i++) {
            $fontSize = mt_rand(15, 35);
            $text = substr($captchaText, $i, 1);
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, __DIR__ . '/../public/fonts/impact.ttf', $text);

            $x = $x + 17 + mt_rand(1, 10);
            $y = mt_rand(40, 65);
            $angle = mt_rand(0, 10);
        }

        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        header('Pragma: no-cache');
        header('Content-type: image/jpeg');

        ob_start ();
        imagejpeg($image, null, 100);		
        $image_data = ob_get_contents (); 
        ob_end_clean (); 
        imagedestroy($image);
	
        return base64_encode ($image_data);
    }

    public static function create($id){
        $captchaText = (string) mt_rand(100000, 999999); strtoupper(substr(md5(microtime()), 0, 7));
        Session::put('captchaHash' . $id, Hash::make($captchaText));

        $image = imagecreate(160, 70);
        $background = imagecolorallocatealpha($image, 239, 239, 239, 1);
        $textColor = imagecolorallocatealpha($image, 0, 0, 0, 1);
        $x = 5;
        $y = 50;
        $angle = 0;

        for($i = 0; $i < 7; $i++) {
            $fontSize = mt_rand(15, 35);
            $text = substr($captchaText, $i, 1);
            imagettftext($image, $fontSize, $angle, $x, $y, $textColor, __DIR__ . '/../public/fonts/impact.ttf', $text);

            $x = $x + 17 + mt_rand(1, 10);
            $y = mt_rand(40, 65);
            $angle = mt_rand(0, 10);
        }

        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        header('Pragma: no-cache');
        header('Content-type: image/jpeg');

        ob_start ();
        imagejpeg($image, null, 100);		
        $image_data = ob_get_contents (); 
        ob_end_clean (); 
        imagedestroy($image);
	
        return base64_encode ($image_data);
    }
  
    public static function validate($value, $parameters) {
        if(Hash::check($value, Session::get('captchaHash' . $parameters[0] ))) {
            return true;
        }
        return false;
    }

    public static function img($id) {
        return '<img src="data:image/jpeg;base64,' . Captcha::create($id) . '"/>';
    }

    public static function img_math($id, $class=""){
        if($class != ''){
            return '<img '.' class="'.$class.'" '.'src="data:image/jpeg;base64,' . Captcha::create($id) . '"/>';
        }
        return '<img src="data:image/jpeg;base64,' . Captcha::create($id) . '"/>';
    }
}