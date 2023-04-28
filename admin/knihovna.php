<?
function securesql($a){ // ochrana pred utokem
$a=mysql_real_escape_string($a);
return $a;
}

function csdate($a){    // transformace na ceske datum
if (StrPos (" " . $a, "-")) {$latka=explode ("-",$a);$a=$latka[2].".".$latka[1].".".$latka[0];}
return $a;
}

function dbdate($a){    // transformace na db datum
if (StrPos (" " . $a, ".")) {$latka=explode (".",$a);$a=$latka[2]."-".$latka[1]."-".$latka[0];}
return $a;
}

function code($a){    // zakodovani REQUEST hodnoty
$a=base64_encode($a);
return $a;
}

function decode($a){   // dekodovani REQUEST hodnoty
$a=base64_decode($a);
return $a;
}

function resizeimage($originalImage,$toWidth,$toHeight){
    // Get the original geometry and calculate scales
    list($width, $height) = getimagesize($originalImage);

    $xscale=$width/$toWidth;
    $yscale=$height/$toHeight;

    // Recalculate new size with default ratio
    if ($yscale>$xscale){
        $new_width = round($width * (1/$yscale));
        $new_height = round($height * (1/$yscale));
    }
    else {
        $new_width = round($width * (1/$xscale));
        $new_height = round($height * (1/$xscale));
    }

    // Resize the original image
    $imageResized = imagecreatetruecolor($new_width, $new_height);
    $imageTmp     = imagecreatefromjpeg ($originalImage);
    imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagejpeg($imageResized,$originalImage,100);
    return $imageResized;
}

?>