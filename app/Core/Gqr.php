<?php
namespace App\Core;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Gqr 
{

    public static $data ='';
    public static $size = 100;
    public static $margin = 5;

    public static function code()
    {
        $writer = new PngWriter();

        // Create QR code
        $qrCode = new QrCode(
            data: self::$data,
            encoding: new Encoding('UTF-8'),
            size: self::$size,
            margin: self::$margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );
        
        // Create generic logo
        // $logo = new Logo(
        //     path: ASSETS.'img/h3.jpg',
        //     resizeToWidth: 100,
        //     resizeToHeight: 100,
            
        //     punchoutBackground: true,
            
        // );
        
        // Create generic label
        // $label = new Label(
        //     text: 'Label',
        //     textColor: new Color(255, 0, 0)
        // );
        
        $result = $writer->write($qrCode, null);
        
        return $result->getDataUri();
    }
    

    public static function qrReserve($code, $size = 100, $margin = 5) {
        self::$data = $code;
        self::$size = $size;
        self::$margin = $margin;
        return self::code();
    }

   

}
