<?session_start();
header('Content-type: text/html; charset=utf-8');

include ("./"."dbconnect.php");
?>

<html>
<head>
<link rel="icon" href="http://www.intershow.cz/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="http://www.intershow.cz/favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?echo mysql_result(mysql_query("select hodnota from setting where nazev='sitename' "),0,0);?> Fotogalerie</title>
    <?php
    $u_agent = $_SERVER['HTTP_USER_AGENT'];$ub = '';
    if(preg_match('/MSIE/i',$u_agent)) {$ub = "ie";}
    elseif(preg_match('/Firefox/i',$u_agent)) {$ub = "firefox";}
    elseif(preg_match('/Safari/i',$u_agent)) {$ub = "safari";}
    elseif(preg_match('/Chrome/i',$u_agent)) {$ub = "chrome";}
    elseif(preg_match('/Flock/i',$u_agent)) {$ub = "flock";}
    elseif(preg_match('/Opera/i',$u_agent)) {$ub = "opera";}

 if(@$ub=="ie") {?>
  <script type="text/javascript" src="js/mootoolsie.js"></script>
  <script type="text/javascript" src="js/slimboxie.js"></script>
 <?}
 else {?>
  <script type="text/javascript" src="js/mootoolsff.js"></script>
  <script type="text/javascript" src="js/slimboxff.js"></script>
 <?}?>

<link rel="stylesheet" href="css/slimbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="cssmain.css" type="text/css">
</head>

<body bgcolor="#FEF0BA" text="#000000">

<?
$lastid=@$_POST["id"];
if (@$lastid==""){$lastid=base64_decode(@$_GET["id"]);}

@$tlacitko=@$_POST["tlacitko"];

if (@$tlacitko=="Uložit Foto"){
@$dnes=date("Y-n-d");

@$docasny = @$_FILES['soubor']['tmp_name']; // Umístění dočasného souboru
@$mime = @$_FILES['soubor']['type']; // MIME typ
// Načteme obsah dočasného souboru
@$obsah = implode('', file("$docasny"));
mysql_query ("update fotogalerie set mime='$mime', soubor='".mysql_escape_string($obsah)."', datumvkladu='$dnes' where id='$lastid'")or Die(MySQL_Error());
@$tlacitko="";?>
<?}


@$mimeexist1 = mysql_query("select mime from fotogalerie where id='$lastid' order by nazev,id");
@$mimeexist = mysql_result($mimeexist1,0,0);?>

<script type="text/JavaScript">
window.resizeTo(430,700)
</script>


<center><table border=2>
<form action="addimage.php" method="POST" enctype="multipart/form-data">

<tr bgcolor="#C0FFFF"><td colspan=2 align=center>Vložení Fota / Nahrazení Fota <br />(obrázky 800x600px poměr 4/3)</td></tr>

<input type=hidden name=id value="<?echo@$lastid;?>">
<? if (@$mimeexist=="") {?><tr><td >Vložit Foto:</td><?} else {?><tr><td >Nahradit Foto:</td><?}?><td><input type="file" name="soubor" >
<tr><td colspan=2 align=center><BR><input type="submit" name=tlacitko value="Uložit Foto"><BR></td></tr>
<tr><td colspan=2><BR></td></tr>
</form>


<? if (@$mimeexist<>"") {?><tr><td colspan=2><center><img src="obrazek.php?id=<?echo base64_encode(@$lastid);?>" width=300></td></tr><?}?>

</table><p align="center"><button onClick="window.close()">Zavřít Okno</button></p></center>


