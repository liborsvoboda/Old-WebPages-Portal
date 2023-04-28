<?
include ("./"."dbconnect.php");
function PrevedNaUTF($vstup_str)
{// vytvoøím si asociativní pole pro 18 znakù ve tvaru "pùvodní znak"=>kód UTF8
  $tabulkaUTF = array("È"=>268, "è"=>269,
                      "Ï"=>270, "ï"=>271,
                      "Ì"=>282, "ì"=>283,
                      "Ò"=>327, "ò"=>328,
                      "Ø"=>344, "ø"=>345,
                      "Š"=>352, "š"=>353,
                      ""=>356, ""=>357,
                      "Ù"=>366, "ù"=>367,
                      "Ž"=>381, "ž"=>382);
  $vystup_str = ""; // vynuluji výstupní øetìzec
  for($i=0; $i < strlen($vstup_str); $i++) // projdu všechny znaky vstupního øetìzce
  {
    if ($tabulkaUTF[$vstup_str[$i]]) // pokud se znak nachází v tabulce
      $vystup_str .= "&#" . $tabulkaUTF[$vstup_str[$i]] . ";"; // zamìním jej
    else
      $vystup_str .= $vstup_str[$i]; // jinak vezmu pùvodní znak
  }
  return $vystup_str; // vracím pøekódovaný øetìzec
}


function PrevedNaISO($vstup_str)
{
  return strtr($vstup_str, "\x8A\x8D\x8E\x9A\x9D\x9E",
                        "\xA9\xAB\xAE\xB9\xBB\xBE");
}






@$id=base64_decode(@$_GET["id"]);
$datum = Date("Y-m-d");  // promìnná obsahující dnešní datum v potøebném formátu
$datumcs = Date("d.m.Y");  // promìnná obsahující dnešní datum v potøebném formátu
//$datum="2010-02-17";

  $obrazek = imagecreatetruecolor(800,290);

  $seda = imagecolorallocate($obrazek,244,244,244);
  $tmaveseda = imagecolorallocate($obrazek,193,193,193);
  $cerna = imagecolorallocate($obrazek,0,0,0);
  $modra = imagecolorallocate($obrazek,0,0,255);
  $zelena = imagecolorallocate($obrazek,78,181,43);
  $cervena = imagecolorallocate($obrazek,255,0,0);

  imagefilledrectangle($obrazek,0,0,800,290,$seda);

  imagesetthickness ($obrazek, 1);

imageline ($obrazek, 788,230, 788,280,$cerna);
imageline ($obrazek, 12, 230, 788, 230,$cerna);
imageline ($obrazek, 12, 255, 788, 255,$cerna);
imageline ($obrazek, 12,230, 12,280,$cerna);
imageline ($obrazek, 12, 280, 788, 280,$cerna);

//if (false === var_dump( function_exists('imageantialias'))) echo 'error1';
//if (false === var_dump( function_exists('imagecreatetruecolor'))) echo 'error2';

//$font = imageloadfont('gdfonts/azimov.gdf');
//imagestring($obrazek, $font, 50, 50, 'Hello', $cerna);



if (@$id==1) {
imageline ($obrazek, 45,30, 45,210,$cerna);
imageline ($obrazek, 35, 200, 758, 200,$cerna);
imagestring ($obrazek, 5, 300, 4, PrevedNaISO("Pøehled Dnešní Návštìvnosti ($datumcs)"), $cerna);
imagestring ($obrazek, 2, 763, 180, "Hodina", $modra);imagestring ($obrazek, 2, 15, 235, "Hod.", $modra);
imagestring ($obrazek, 2, 2, 1, PrevedNaISO(" Poèet"), $modra);imagestring ($obrazek, 2, 15, 260, PrevedNaISO("Náv."), $modra);
imagestring ($obrazek, 2, 2, 14, PrevedNaISO("Návštìv"), $modra);

// nacte data
@$cykl=0;While (@$cykl<24):

if (@$cykl<10) {$dotaz="0".@$cykl;} else {$dotaz=@$cykl;}

@$data1 = mysql_query("select * from pocitadlo where Datum='$datum' and cas like '$dotaz:%' order by Datum,cas");
$data[$cykl]=mysql_num_rows(@$data1);if (@$max<$data[$cykl]) {@$max=$data[$cykl];}
@$cykl++;Endwhile;

// vykresli osu Y
@$cykl=0;While (@$cykl<10):
Imagestring ($obrazek, 3, 12, 17*$cykl+30, Ceil ((@$max/10)*(10-$cykl)), $zelena);
imageline ($obrazek, 43,17*$cykl+37, 47,17*$cykl+37,$cerna);
@$cykl++;Endwhile;

// vykresli osu x a data
@$cykl=0;While (@$cykl<24):
imageline ($obrazek,31*$cykl+45, 198,31*$cykl+45, 202,$cerna);
Imagestring ($obrazek, 3, 31*$cykl+38, 203, $cykl+1, $zelena);

If (@$cykl==0) {Imageline ($obrazek, 45+($cykl*31),Ceil (176-($data[$cykl]/(@$max/165))+26), 76+(($cykl)*31),Ceil (165-($data[$cykl+1]/(@$max/165))+35),$cervena);}
if (@$cykl>0 and @$cykl<23) {Imageline ($obrazek, 45+($cykl*31),Ceil (174-($data[$cykl]/(@$max/165))+26), 76+(($cykl)*31),Ceil (165-($data[$cykl+1]/(@$max/165))+35),$cervena);}
Imagestring ($obrazek, 3, 47+($cykl*31), Ceil (174-($data[$cykl]/(@$max/165))+15), $data[$cykl], $cerna);

imageline ($obrazek, 45+($cykl*29),230, 45+($cykl*29),280,$cerna);
Imagestring ($obrazek, 3, 53+($cykl*29), 235, $cykl+1, $cerna);
Imagestring ($obrazek, 3, 49+($cykl*29), 260, $data[$cykl], $cervena);
@$suma=@$suma+$data[$cykl];

@$cykl++;Endwhile;

imageline ($obrazek, 45+($cykl*29),230, 45+($cykl*29),280,$cerna);
Imagestring ($obrazek, 3, 53+($cykl*29), 235, "SUMA", $modra);
Imagestring ($obrazek, 3, 49+($cykl*29), 260, $suma, $cervena);
}








if (@$id==2) {
imageline ($obrazek, 45,30, 45,210,$cerna);
imageline ($obrazek, 35, 200, 758, 200,$cerna);
imagestring ($obrazek, 5, 300, 4, PrevedNaISO("Pøehled Týdenní Návštìvnosti"), $cerna);
imagestring ($obrazek, 2, 763, 180, "Den", $modra);imagestring ($obrazek, 2, 15, 235, "Den", $modra);
imagestring ($obrazek, 2, 2, 1, PrevedNaISO(" Poèet"), $modra);imagestring ($obrazek, 2, 15, 260, PrevedNaISO("Náv."), $modra);
imagestring ($obrazek, 2, 2, 14, PrevedNaISO("Návštìv"), $modra);



@$rok= date('Y');@$mesic= date('n');@$den= date('d');$cdne= date('w', mktime(0,0,0,$mesic,$den,$rok));
if (@$cdne==0){@$cdne=7;}
// nacte data
@$cykl=0;While (@$cykl<7):

$datumback = Date("Y-m-d", StrToTime("-".(6-$cykl)." day +".(7-$cdne)." day" ));

@$data1 = mysql_query("select * from pocitadlo where Datum ='$datumback' order by Datum ASC");
$data[$cykl]=mysql_num_rows(@$data1);if (@$max<$data[$cykl]) {@$max=$data[$cykl];}
@$cykl++;Endwhile;

// vykresli osu Y
@$cykl=0;While (@$cykl<10):
Imagestring ($obrazek, 3, 12, 17*$cykl+30, Ceil ((@$max/10)*(10-$cykl)), $zelena);
imageline ($obrazek, 43,17*$cykl+37, 47,17*$cykl+37,$cerna);
@$cykl++;Endwhile;

// vykresli osu x a data
@$cykl=0;While (@$cykl<7):

$datumback = Date("d.m.Y", StrToTime("-".(6-$cykl)." day +".(7-$cdne)." day" ));

imageline ($obrazek,101*$cykl+45, 198,101*$cykl+45, 202,$cerna);
Imagestring ($obrazek, 2, 101*$cykl+48, 203, $datumback, $zelena);

If (@$cykl==0) {Imageline ($obrazek, 45+($cykl*101),@Ceil (176-($data[$cykl]/(@$max/165))+26), 146+(($cykl)*101),@Ceil (165-($data[$cykl+1]/(@$max/165))+35),$cervena);}
if (@$cykl>0 and @$cykl<23) {Imageline ($obrazek, 45+($cykl*101),@Ceil (174-($data[$cykl]/(@$max/165))+26), 146+(($cykl)*101),@Ceil (165-($data[$cykl+1]/(@$max/165))+35),$cervena);}
Imagestring ($obrazek, 3, 47+($cykl*101), @Ceil (174-($data[$cykl]/(@$max/165))+15), $data[$cykl], $cerna);

imageline ($obrazek, 45+($cykl*99),230, 45+($cykl*99),280,$cerna);
Imagestring ($obrazek, 3, 53+($cykl*99), 235, $datumback, $cerna);
Imagestring ($obrazek, 3, 80+($cykl*99), 260, $data[$cykl], $cervena);
@$suma=@$suma+$data[$cykl];

@$cykl++;Endwhile;

imageline ($obrazek, 45+($cykl*99),230, 45+($cykl*99),280,$cerna);
Imagestring ($obrazek, 3, 53+($cykl*99), 235, "SUMA", $modra);
Imagestring ($obrazek, 3, 54+($cykl*99), 260, $suma, $cervena);
}








if (@$id==3) {
imageline ($obrazek, 45,30, 45,210,$cerna);
imageline ($obrazek, 35, 200, 758, 200,$cerna);
imagestring ($obrazek, 5, 300, 4, PrevedNaISO("Pøehled Mìsíèní Návštìvnosti"), $cerna);
imagestring ($obrazek, 2, 763, 180, "Týden", $modra);imagestring ($obrazek, 2, 15, 235, "Týden", $modra);
imagestring ($obrazek, 2, 2, 1, PrevedNaISO(" Poèet"), $modra);imagestring ($obrazek, 2, 15, 260, PrevedNaISO("Náv."), $modra);
imagestring ($obrazek, 2, 2, 14, PrevedNaISO("Návštìv"), $modra);

// nacte data
@$rok= date('Y');@$mesic= date('n');@$den= date('d');$cdne= date('w', mktime(0,0,0,$mesic,$den,$rok));
if (@$cdne==0){@$cdne=7;}



@$cykl=0;While (@$cykl<5):

$datumback = Date("Y-m-d", StrToTime("-".(4-$cykl)." weeks +".(1-$cdne)." day" ));
$datum = Date("Y-m-d", StrToTime("-".(3-$cykl)." weeks +".(0-$cdne)." day" ));

@$data1 = mysql_query("select * from pocitadlo where Datum >='$datumback' and Datum <='$datum' order by Datum ASC");
$data[$cykl]=mysql_num_rows(@$data1);if (@$max<$data[$cykl]) {@$max=$data[$cykl];}
@$cykl++;Endwhile;

// vykresli osu Y
@$cykl=0;While (@$cykl<10):
Imagestring ($obrazek, 3, 12, 17*$cykl+30, Ceil ((@$max/10)*(10-$cykl)), $zelena);
imageline ($obrazek, 43,17*$cykl+37, 47,17*$cykl+37,$cerna);
@$cykl++;Endwhile;

// vykresli osu x a data
@$cykl=0;While (@$cykl<5):

$datumback = Date("d.m.Y", StrToTime("-".(4-$cykl)." weeks +".(1-$cdne)." day" ));
$datum = Date("d.m.Y", StrToTime("-".(3-$cykl)." weeks +".(0-$cdne)." day" ));

imageline ($obrazek,142*$cykl+45, 198,142*$cykl+45, 202,$cerna);
Imagestring ($obrazek, 1, 142*$cykl+48, 203, $datumback." - ".$datum, $zelena);

If (@$cykl==0) {Imageline ($obrazek, 45+($cykl*142),Ceil (176-($data[$cykl]/(@$max/165))+26), 187+(($cykl)*142),Ceil (165-($data[$cykl+1]/(@$max/165))+35),$cervena);}
if (@$cykl>0 and @$cykl<23) {Imageline ($obrazek, 45+($cykl*142),Ceil (174-($data[$cykl]/(@$max/165))+26), 187+(($cykl)*142),Ceil (165-($data[$cykl+1]/(@$max/165))+35),$cervena);}
Imagestring ($obrazek, 3, 47+($cykl*142), Ceil (174-($data[$cykl]/(@$max/165))+15), $data[$cykl], $cerna);

imageline ($obrazek, 45+($cykl*140),230, 45+($cykl*140),280,$cerna);
Imagestring ($obrazek, 1, 53+($cykl*140), 235, $datumback." - ".$datum, $cerna);
Imagestring ($obrazek, 3, 80+($cykl*140), 260, $data[$cykl], $cervena);
@$suma=@$suma+$data[$cykl];

@$cykl++;Endwhile;

imageline ($obrazek, 45+($cykl*140),230, 45+($cykl*140),280,$cerna);
Imagestring ($obrazek, 3, 53+($cykl*140), 235, "SUMA", $modra);
Imagestring ($obrazek, 3, 54+($cykl*140), 260, $suma, $cervena);
}








if (@$id==4) {
imageline ($obrazek, 45,30, 45,210,$cerna);
imageline ($obrazek, 35, 200, 758, 200,$cerna);
imagestring ($obrazek, 5, 300, 4, PrevedNaISO("Pøehled Roèní Návštìvnosti"), $cerna);
imagestring ($obrazek, 2, 763, 180, "Mìsíc", $modra);imagestring ($obrazek, 2, 15, 235, "Mìsíc", $modra);
imagestring ($obrazek, 2, 2, 1, PrevedNaISO(" Poèet"), $modra);imagestring ($obrazek, 2, 15, 260, PrevedNaISO("Náv."), $modra);
imagestring ($obrazek, 2, 2, 14, PrevedNaISO("Návštìv"), $modra);

// nacte data
@$cykl=0;While (@$cykl<12):

$datum = Date("Y-m-d", StrToTime("-".(11-$cykl)." month"));$casti = explode("-", $datum);@$datum=$casti[0]."-".$casti[1]."-";

@$data1 = mysql_query("select * from pocitadlo where Datum like '$datum%' order by Datum ASC");
@$data[$cykl]=mysql_num_rows(@$data1);if (@$max<$data[$cykl]) {@$max=$data[$cykl];}
@$cykl++;Endwhile;

// vykresli osu Y
@$cykl=0;While (@$cykl<10):
Imagestring ($obrazek, 3, 12, 17*$cykl+30, Ceil ((@$max/10)*(10-$cykl)), $zelena);
imageline ($obrazek, 43,17*$cykl+37, 47,17*$cykl+37,$cerna);
@$cykl++;Endwhile;

// vykresli osu x a data
@$cykl=0;While (@$cykl<12):

@$datum = Date("M.Y", StrToTime("-".(11-$cykl)." month"));

imageline ($obrazek,59*$cykl+45, 198,59*$cykl+45, 202,$cerna);
Imagestring ($obrazek, 1, 59*$cykl+48, 203, $datum, $zelena);

If (@$cykl==0) {Imageline ($obrazek, 45+($cykl*59),@Ceil (176-(@$data[$cykl]/(@$max/165))+26), 104+(($cykl)*59),@Ceil (165-(@$data[$cykl+1]/(@$max/165))+35),$cervena);}
if (@$cykl>0 and @$cykl<23) {Imageline ($obrazek, 45+($cykl*59),@Ceil (174-(@$data[$cykl]/(@$max/165))+26), 104+(($cykl)*59),@Ceil (165-(@$data[$cykl+1]/(@$max/165))+35),$cervena);}
Imagestring ($obrazek, 3, 47+($cykl*59), @Ceil (174-(@$data[$cykl]/(@$max/165))+15), @$data[$cykl], $cerna);

imageline ($obrazek, 45+($cykl*57),230, 45+($cykl*57),280,$cerna);
Imagestring ($obrazek, 1, 54+($cykl*57), 235, $datum, $cerna);
Imagestring ($obrazek, 3, 59+($cykl*57), 260, @$data[$cykl], $cervena);
@$suma=@$suma+@$data[$cykl];

@$cykl++;Endwhile;

imageline ($obrazek, 45+($cykl*57),230, 45+($cykl*57),280,$cerna);
Imagestring ($obrazek, 3, 59+($cykl*57), 235, "SUMA", $modra);
Imagestring ($obrazek, 3, 54+($cykl*57), 260, @$suma, $cervena);
}




  header('Content-Type: image/png');
  imagepng($obrazek);
  imagedestroy($obrazek);
  ?>
