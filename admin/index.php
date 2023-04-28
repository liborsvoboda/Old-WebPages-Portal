<?php
include ("./dbconnect.php");
include ("./knihovna.php");
@$dnes=date("Y-m-d");
@$dnescs=date("d.m.Y");

function authenticate_user(){
header('WWW-Authenticate: Basic realm="Prihlaseni do Administrace: KLIKNETEZDE.CZ"');
header('HTTP/1.0 401 Unauthorized');
}

if (!isset($_SERVER['PHP_AUTH_USER'])){
authenticate_user();
} else {

// výběrový dotaz

$query=("SELECT ljmeno FROM login WHERE ljmeno='$_SERVER[PHP_AUTH_USER]'
AND lheslo=MD5('$_SERVER[PHP_AUTH_PW]') and prava like '%,a,%'");



$results=mysql_query($query);
 @$test=mysql_num_rows($results);
if ($test == 0 ) {

authenticate_user();
}
}
if (@$test == 0 or @$test =="" ) {
?><html>
<head>
<title><?echo mysql_result(mysql_query("select hodnota from setting where nazev='sitename' "),0,0);?></title>
<link rel="icon" href="<?echo mysql_result(mysql_query("select hodnota from setting where nazev='url'"),0,0);?>/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?echo mysql_result(mysql_query("select hodnota from setting where nazev='url'"),0,0);?>/favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>


<body style=margin:0px>
<BR><BR><?
echo"Vaše přihlášení se nezdařilo prosím kontaktujte vašeho Providera na tel:724 986 873";}

if (@$test <> 0 ) {


$loginname= $_SERVER['PHP_AUTH_USER'];




mysql_query ("update login  set lastlogin = '$dnes' where ljmeno = '$loginname' ")or Die(MySQL_Error());










$menu=@$_POST["menu"];if (@$menu=="") {@$menu=decode(@$_GET["menu"]);}
$poradi=@$_POST["poradi"];if (@$poradi=="") {@$poradi=decode(@$_GET["poradi"]);}
$poradinew=@$_POST["poradinew"];
$seo=@$_POST["seo"];
$nazev=@$_POST["nazev"];if (@$nazev=="") {@$nazev=decode(@$_GET["nazev"]);}
$tlacitko=@$_POST["tlacitko"];
$typ=@$_POST["typ"];
$id=@$_POST["id"];
$submenu=@$_POST["submenu"];if (@$submenu=="") {@$submenu=decode(@$_GET["submenu"]);}
@$idmenu=@$_POST["idmenu"];
@$idsub=@$_POST["idsub"];if (@$idsub=="") {@$idsub=decode(@$_GET["idsub"]);}
@$zaznam = stripslashes( $_POST['FCKeditor1'] ) ;



function permalink($permalink) {
    $permalink = str_replace(" ", "-", $permalink);
    $permalink = str_replace(
        array('Á','Ä','É','Ë','Ě','Í','Ý','Ó','Ö','Ú','Ů','Ü','Ž','Š','Č','Ř','Ď','Ť','Ň','Ľ','á','ä','é','ë','ě','í','ý','ó','ö','ú','ů','ü','ž','š','č','ř','ď','ť','ň','ľ'),
        array('a','a','e','e','e','i','y','o','o','u','u','u','z','s','c','r','d','t','n','l','a','a','e','e','e','i','y','o','o','u','u','u','z','s','c','r','d','t','n','l'),
        $permalink);
    $permalink = strtolower($permalink);
    $permalink = str_replace(array('<', '>'), "-", $permalink);
    $permalink = preg_replace("/[^[:alpha:][:digit:]_]/", "-", $permalink);
    $permalink = preg_replace("/[-]+/", "-", $permalink);
    $permalink = trim($permalink, "-");
    return $permalink;
}


function sitemap(){
$sitemap="/var/www/kliknetezde.cz/sitemap.xml";$sitem1=mysql_query("select nazev,id,submenu from menu order by poradi,id");
$sitem="<?xml version='1.0' encoding='UTF-8'?>\r\n<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\r\n";
$sitem.="<url><loc>".mysql_result(mysql_query("select hodnota from setting where nazev='url' "),0,0)."</loc><changefreq>always</changefreq><priority>0.75</priority></url>\r\n";
$sitem.="<url><loc>".mysql_result(mysql_query("select hodnota from setting where nazev='url' "),0,0)."/</loc><changefreq>always</changefreq><priority>0.75</priority></url>\r\n";
@$sitel=0;while(@$sitel<mysql_num_rows(@$sitem1)):
if (mysql_result(@$sitem1,$sitel,2)=="NE") {$sitem.="<url><loc>".mysql_result(mysql_query("select hodnota from setting where nazev='url' "),0,0)."/".mysql_result($sitem1,$sitel,1)."-".permalink(mysql_result($sitem1,$sitel,0)).".html</loc><changefreq>always</changefreq><priority>0.75</priority></url>\r\n";}

if (mysql_result(@$sitem1,$sitel,2)=="ANO") {$sitem2=mysql_query("select nazev,id from submenu where id_menu='".securesql(mysql_result($sitem1,$sitel,1))."' order by poradi,id");@$site2=0;while(@$site2<mysql_num_rows(@$sitem2)):
$sitem.="<url><loc>".mysql_result(mysql_query("select hodnota from setting where nazev='url' "),0,0)."/".mysql_result($sitem1,$sitel,1)."-".permalink(mysql_result($sitem1,$sitel,0))."_".mysql_result($sitem2,$site2,1)."-".permalink(mysql_result($sitem2,$site2,0)).".html</loc><changefreq>always</changefreq><priority>0.75</priority></url>\r\n";
@$site2++;endwhile;}

@$sitel++;endwhile;
$sitem.="</urlset>\r\n";
$f=fopen($sitemap,"w");fwrite($f,$sitem);fclose($f);
}?>


<?if (@$menu=="Menu Profilu" and @$tlacitko=="Uložit Položku Menu Profilu"){
	if (@$_POST["profil"]) {
	mysql_query("insert into menu_profilu (poradi,nazev,soubor,save_tlacitko)VALUES('".securesql($poradi)."','".securesql(@$_POST["profil"])."','".securesql(@$_POST["soubor"])."','".securesql(@$_POST["savetl"])."')");
	}
	if (@$_POST["profil1"] and !@$_POST["profil"]) {
    mysql_query("update menu_profilu set poradi='".securesql($poradi)."',soubor='".securesql(@$_POST["soubor"])."',save_tlacitko='".securesql(@$_POST["savetl"])."' where nazev='".securesql(@$_POST["profil1"])."' ");
	}
@$tlacitko="";if (@$_POST["profil"]){@$_POST["profil1"]=@$_POST["profil"];unset($_POST["profil"]);}}




if (@$menu=="HiddenBox Skupiny" and  @$tlacitko=="Uložit Nastavení") {if (@$_POST["afteradults"]=="on"){$afteradults="ANO";}else {$afteradults="NE";}
mysql_query("update tool_groups set after18='".securesql($afteradults)."' where nazev='".securesql(@$_POST["sgroup"])."' ");
echo"<script>alert('Skupina byla Aktualizována');</script>";unset($_POST["afteradults"]);
}


if (@$menu=="HiddenBox Skupiny" and @$_POST["newgroup"]) {$control=mysql_num_rows(mysql_query("select id from tool_groups where nazev='".securesql(@$_POST["newgroup"])."'"));
if ($control){echo "<script>alert('Skupina již existuje');</script>";}
else {mysql_query("insert into tool_groups (nazev,after18,datumvkladu)VALUES('".securesql(@$_POST["newgroup"])."','NE','$dnes')");
@$_POST["sgroup"]=@$_POST["newgroup"];unset($_POST["newgroup"]);}}




if (@$menu=="HiddenBox" and @$tlacitko=="Uložit Nástroj"){if (@$_POST["lista"]=="on") {$lista="ANO";} else {$lista="NE";}
@$docasny = @$_FILES['ikona']['tmp_name'];@$mime = @$_FILES['ikona']['type'];@$obsah = implode('', file("$docasny"));
	if (@$_POST["nastroj"]) {	if (@$mime) {mysql_query("insert into nastroje (poradi,nazev,hlavicka,kod,parametry,ikona,mikona,popisek,zobrazit,datumvkladu,movescript,googlescript,group_name)VALUES('".securesql($poradi)."','".securesql(@$_POST["nastroj"])."','".securesql(@$_POST["hlavicka"])."','".htmlspecialchars (@$_POST["kod"])."','".securesql(@$_POST["parametry"])."','".mysql_escape_string($obsah)."','".securesql($mime)."','".securesql(@$_POST["popisek"])."','".securesql($lista)."','".securesql($dnes)."','".securesql(@$_POST["movescript"])."','".securesql(@$_POST["googlescript"])."','".securesql(@$_POST["sgroup"])."')");}
	else {mysql_query("insert into nastroje (poradi,nazev,hlavicka,kod,parametry,popisek,zobrazit,datumvkladu,movescript,googlescript,group_name)VALUES('".securesql($poradi)."','".securesql(@$_POST["nastroj"])."','".securesql(@$_POST["hlavicka"])."','".htmlspecialchars (@$_POST["kod"])."','".securesql(@$_POST["parametry"])."','".securesql(@$_POST["popisek"])."','".securesql($lista)."','".securesql($dnes)."','".securesql(@$_POST["movescript"])."','".securesql(@$_POST["googlescript"])."','".securesql(@$_POST["sgroup"])."')");}	}
	if (@$_POST["nastroj1"] and !@$_POST["nastroj"]) {
	if (@$mime) {mysql_query("update nastroje set poradi='".securesql($poradi)."',hlavicka='".securesql(@$_POST["hlavicka"])."',kod='".htmlspecialchars (@$_POST["kod"])."',parametry='".securesql(@$_POST["parametry"])."',ikona='".mysql_escape_string($obsah)."',mikona='".securesql($mime)."',popisek='".securesql(@$_POST["popisek"])."',zobrazit='".securesql($lista)."',datumvkladu='".securesql($dnes)."',movescript='".securesql(@$_POST["movescript"])."',googlescript='".securesql(@$_POST["googlescript"])."',group_name='".securesql(@$_POST["sgroup"])."' where nazev='".securesql(@$_POST["nastroj1"])."' ");}
    else {mysql_query("update nastroje set poradi='".securesql($poradi)."',hlavicka='".securesql(@$_POST["hlavicka"])."',kod='".htmlspecialchars (@$_POST["kod"])."',parametry='".securesql(@$_POST["parametry"])."',popisek='".securesql(@$_POST["popisek"])."',zobrazit='".securesql($lista)."',datumvkladu='".securesql($dnes)."',movescript='".securesql(@$_POST["movescript"])."',googlescript='".securesql(@$_POST["googlescript"])."',group_name='".securesql(@$_POST["sgroup"])."' where nazev='".securesql(@$_POST["nastroj1"])."' ");}
	}
@$tlacitko="";if (@$_POST["nastroj"]){@$_POST["nastroj1"]=@$_POST["nastroj"];unset($_POST["nastroj"]);}}?>


<?if (@$menu=="Přidat Položku Menu" and @$tlacitko=="Uložit"){if (@$_POST["lista"]=="on") {$lista="ANO";} else {$lista="NE";}if (@$_POST["reqlogin"]=="on") {$reqlogin="ANO";} else {$reqlogin="NE";}if (@$_POST["subshow"]=="on") {$subshow="ANO";} else {$subshow="NE";}@$docasny = @$_FILES['ikona']['tmp_name'];@$mime = @$_FILES['ikona']['type'];@$obsah = implode('', file("$docasny"));
mysql_query ("INSERT INTO menu (poradi,nazev,seo,typ,submenu,datumvkladu,ikona,mikona,lista,after_login,subshow) VALUES ('".securesql($poradi)."','".securesql($nazev)."','".securesql($seo)."','".securesql($typ)."','".securesql($submenu)."','".securesql($dnes)."','".mysql_escape_string($obsah)."','".securesql($mime)."','".securesql($lista)."','".securesql($reqlogin)."','".securesql($subshow)."')") or Die(MySQL_Error());
@$menu="Upravit Obsah Menu";sitemap();@$tlacitko="";}?>

<?if (@$menu=="Přidat Položku SubMenu" and @$tlacitko=="Uložit"){if (@$_POST["lista"]=="on") {$lista="ANO";} else {$lista="NE";}if (@$_POST["reqlogin"]=="on") {$reqlogin="ANO";} else {$reqlogin="NE";}
@$docasny = @$_FILES['ikona']['tmp_name'];@$mime = @$_FILES['ikona']['type'];@$obsah = implode('', file("$docasny"));
mysql_query ("INSERT INTO submenu (id_menu,poradi,nazev,seo,typ,datumvkladu,ikona,mikona,lista,after_login) VALUES ('".securesql($idmenu)."','".securesql($poradi)."','".securesql($nazev)."','".securesql($seo)."','".securesql($typ)."','".securesql($dnes)."','".mysql_escape_string($obsah)."','".securesql($mime)."','".securesql($lista)."','".securesql($reqlogin)."')") or Die(MySQL_Error());
@$menu="Upravit Obsah SubMenu";sitemap();}?>

<?if (@$menu=="Upravit Obsah Menu" and @$tlacitko=="Uložit Obsah"){if (@$_POST["lista"]=="on") {$lista="ANO";} else {$lista="NE";}if (@$_POST["reqlogin"]=="on") {$reqlogin="ANO";} else {$reqlogin="NE";}if (@$_POST["subshow"]=="on") {$subshow="ANO";} else {$subshow="NE";}@$docasny = @$_FILES['ikona']['tmp_name'];@$mime = @$_FILES['ikona']['type'];@$obsah = implode('', file("$docasny"));
	if (@$mime) {mysql_query ("update menu set poradi='".securesql($poradinew)."',nazev='".securesql($nazev)."',seo='".securesql($seo)."',typ='".securesql($typ)."',submenu='".securesql($submenu)."', zaznam = '$zaznam', datumvkladu = '".securesql($dnes)."',ikona='".mysql_escape_string($obsah)."',mikona='".securesql($mime)."',lista='".securesql($lista)."',after_login='".securesql($reqlogin)."',subshow='".securesql($subshow)."' where poradi = '".securesql($poradi)."' ")or Die(MySQL_Error());}
	else {mysql_query ("update menu set poradi='".securesql($poradinew)."',nazev='".securesql($nazev)."',seo='".securesql($seo)."',typ='".securesql($typ)."',submenu='".securesql($submenu)."', zaznam = '$zaznam', datumvkladu = '".securesql($dnes)."',lista='".securesql($lista)."',after_login='".securesql($reqlogin)."',subshow='".securesql($subshow)."' where poradi = '".securesql($poradi)."' ")or Die(MySQL_Error());}
@$tlacitko="";@$poradi=@$poradinew;sitemap();}?>

<?if (@$menu=="Upravit Obsah SubMenu" and @$tlacitko=="Uložit Obsah"){if (@$_POST["lista"]=="on") {$lista="ANO";} else {$lista="NE";}if (@$_POST["reqlogin"]=="on") {$reqlogin="ANO";} else {$reqlogin="NE";}
@$docasny = @$_FILES['ikona']['tmp_name'];@$mime = @$_FILES['ikona']['type'];@$obsah = implode('', file("$docasny"));
	if (@$mime) {mysql_query ("update submenu  set poradi='".securesql($poradinew)."',nazev='".securesql($nazev)."',seo='".securesql($seo)."',typ='".securesql($typ)."', zaznam = '$zaznam', datumvkladu = '".securesql($dnes)."',ikona='".mysql_escape_string($obsah)."',mikona='".securesql($mime)."',lista='".securesql($lista)."',after_login='".securesql($reqlogin)."' where id = '".securesql($idsub)."' ")or Die(MySQL_Error());}
else {mysql_query ("update submenu  set poradi='".securesql($poradinew)."',nazev='".securesql($nazev)."',seo='".securesql($seo)."',typ='".securesql($typ)."', zaznam = '$zaznam', datumvkladu = '".securesql($dnes)."',lista='".securesql($lista)."',after_login='".securesql($reqlogin)."' where id = '".securesql($idsub)."' ")or Die(MySQL_Error());}
@$tlacitko="";@$poradi=@$poradinew;sitemap();}?>

<?if (@$menu=="Menu Profilu" and @$_GET["odstranit"]<>""){
mysql_query ("delete from menu_profilu where nazev = '".securesql(@$_GET["odstranit"])."' ")or Die(MySQL_Error());}?>

<?if (@$menu=="HiddenBox" and @$_GET["odstranit"]<>""){
mysql_query ("delete from nastroje where nazev = '".securesql(@$_GET["odstranit"])."' ")or Die(MySQL_Error());}?>

<?if (@$menu=="Odstranit Položku Menu" and @$poradi<>""){
mysql_query ("delete from menu where poradi = '".securesql($poradi)."' ")or Die(MySQL_Error());@$menu="";sitemap();}?>

<?if (@$submenu=="Odstranit Položku SubMenu" and @$idsub<>""){
mysql_query ("delete from submenu where id = '".securesql($idsub)."' ")or Die(MySQL_Error());@$menu="";sitemap();}?>



<?if (@$menu=="Znamení" and @$tlacitko=="Uložit Znamení"){
mysql_query ("INSERT INTO znameni (poradi,nazev,obdobi,text) VALUES ('".securesql($poradi)."','".securesql($nazev)."','".securesql(@$_POST["obdobi"])."','".securesql(@$zaznam)."' ) ") or Die(MySQL_Error());$tlacitko="";}?>

<?if (@$menu=="Fotogalerie" and @$tlacitko=="Uložit Nový"){
mysql_query ("INSERT INTO fotogalerie (poradi,nazev,datumvkladu,id_menu) VALUES ('".securesql($poradi)."','".securesql($nazev)."','".securesql($dnes)."','".securesql(@$_POST["id_menu"])."' ) ") or Die(MySQL_Error());}?>

<?if (@$menu=="Fotogalerie" and @$tlacitko=="Uložit Změny"){
mysql_query ("update fotogalerie set poradi='".securesql($poradi)."',nazev='".securesql($nazev)."', datumvkladu = '".securesql($dnes)."',id_menu='".securesql(@$_POST["id_menu"])."' where id = '".securesql($id)."' ")or Die(MySQL_Error());@$tlacitko="";@$poradi=@$poradinew;}?>

<?if (@$menu=="Fotogalerie" and @$tlacitko=="Odstranit"){
mysql_query ("delete from fotogalerie where id = '".securesql($id)."' ")or Die(MySQL_Error());@$tlacitko="";@$poradi=@$poradinew;}?>

<?if (@$menu=="Nastavení Hlavních Hodnot" and @$tlacitko=="Uložit Hodnoty"){
@$cykl=0;while(@$_POST["set".$cykl]<>""):$seta=@$_POST["set".$cykl];$value=@$_POST["hodnota".$cykl];
mysql_query ("update setting  set hodnota='".securesql($value)."',datumvkladu = '".securesql($dnes)."' where nazev = '".securesql($seta)."' ")or Die(MySQL_Error());
@$cykl++;endwhile;
@$tlacitko="";}?>



<html>
<head>
<title><?echo mysql_result(mysql_query("select hodnota from setting where nazev='sitename' "),0,0);?></title>
<link rel="icon" href="<?echo mysql_result(mysql_query("select hodnota from setting where nazev='url'"),0,0);?>/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="<?echo mysql_result(mysql_query("select hodnota from setting where nazev='url'"),0,0);?>/favicon.ico" type="image/x-icon">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
    $u_agent = $_SERVER['HTTP_USER_AGENT'];$ub = '';
    if(preg_match('/MSIE/i',$u_agent)) {$ub = "ie";}
    elseif(preg_match('/Firefox/i',$u_agent)) {$ub = "firefox";}
    elseif(preg_match('/Safari/i',$u_agent)) {$ub = "safari";}
    elseif(preg_match('/Chrome/i',$u_agent)) {$ub = "chrome";}
    elseif(preg_match('/Flock/i',$u_agent)) {$ub = "flock";}
    elseif(preg_match('/Opera/i',$u_agent)) {$ub = "opera";}
 if(@$ub=="ie") {?>
  <script type="text/javascript" src="fckeditor/editor/js/mootoolsie.js"></script>
  <script type="text/javascript" src="fckeditor/editor/js/slimboxie.js"></script>
   <?}
 else {?>
  <script type="text/javascript" src="fckeditor/editor/js/mootoolsff.js"></script>
  <script type="text/javascript" src="fckeditor/editor/js/slimboxff.js"></script>
 <?}?>
<link rel="stylesheet" href="fckeditor/editor/css/slimbox.css" type="text/css" media="screen" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

</head>


<body style=margin:0px;width:100%>
<center><table style=width:100%><tr><td><span style="font-size: 26pt"><b>ADMINISTRACE <font color="#723FF8"><?echo mysql_result(mysql_query("select hodnota from setting where nazev='sitename' "),0,0);?></font></b></span></td>

<td align=center><b><font color="#000000">Počet Návštěv:<br /></font></b>
<?include "./pocitadlo/pocitadlo.php";?></td></tr></center>

<?include "./menu.php";?><br />
<center><table width=80% border=2 bgcolor=#687177>



<form  NAME=myForm action="index.php" method="post" enctype="multipart/form-data">   <input name="poradi" type="hidden" value="<?echo@$poradi;?>">
<tr><td align=right style=width:50%><b><big>Vyber Volbu</big></b></td><td style=width:50%><select size="1" name="menu" onchange=submit(this)>
<option><?echo@$menu;?></option>
<?if (@$menu<>"Přidat Položku Menu" and mysql_num_rows(@$hlavicka1)<30) {?><option >Přidat Položku Menu</option><?}?>
<?if (@$menu=="Upravit Obsah Menu" and mysql_result(mysql_query("select * from menu where poradi='".securesql($poradi)."'"),0,7)=="ANO") {?><option>Přidat Položku SubMenu</option><?}?>
<?if (@$menu<>"HiddenBox Skupiny" and mysql_num_rows(@$hlavicka1)<30) {?><option >HiddenBox Skupiny</option><?}?>
<?if (@$menu<>"HiddenBox" and mysql_num_rows(@$hlavicka1)<30) {?><option >HiddenBox</option><?}?>
<?if (@$menu<>"Menu Profilu" and mysql_num_rows(@$hlavicka1)<30) {?><option >Menu Profilu</option><?}?>
<option disabled></option>
<?if (@$menu<>"Znamení") {?><option>Znamení</option><?}?>
<?if (@$menu<>"Nastavení Hlavních Hodnot") {?><option>Nastavení Hlavních Hodnot</option><?}?>
<?if (@$menu<>"Fotogalerie") {?><option>Fotogalerie</option><?}?>
</select></td></tr>



<?
if (@$menu=="Menu Profilu") {$data1=mysql_query("select * from menu_profilu order by poradi");?>
<tr bgcolor=#ECB44A><td align=right width=50%><b>Zadej / Vyber Název Menu Profilu:</b></td><td width=50%><input name="profil" type="text" value="<?echo @$_POST["profil"];?>" onblur=submit(this) style=width:100px>
<select size="1" name="profil1" style=width:100px onchange=submit(this)>
<?if (@$_POST["profil1"]) {echo"<option>".@$_POST["profil1"]."</option>";}echo"<option></option>";
@$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["nastroj1"]<>mysql_result(@$data1,$cykl,2)) {echo "<option>".mysql_result(@$data1,$cykl,2)."</option>";}
@$cykl++;endwhile;?></select> <?if (@$_POST["profil1"]) {echo"<input type=button name=tlacitko value=Odstranit  onClick=`if(confirm('Chcete skutečně Položku Menu Profilu: ".@$_POST["profil1"]." Odstranit?')) window.location.href('index.php?menu=".code('Menu Profilu')."&odstranit=".@$_POST["profil1"]."')` >";}?></td></tr>

<?if (@$_POST["profil"] or @$_POST["profil1"]) {$data1=mysql_query("select * from menu_profilu where nazev='".securesql(@$_POST["profil1"])."' ");?>
<tr bgcolor=#ECB44A><td align=right><b>Zadej Pořadí:</b></td><td><input name="poradi" type="text" value="<?if (@$_POST["profil1"]) {echo mysql_result(@$data1,0,1);}?>" style=width:100px> (10,20,30)</td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadej Název Souboru:</b></td><td><input name="soubor" type="text" value="<?if (@$_POST["profil1"]) {echo mysql_result(@$data1,0,3);}?>" style=width:100px></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zobrazit Save Tlačítko:</b></td><td>
<select size="1" name="savetl">
<?echo "<option>".mysql_result($data1,0,4)."</option>";
if (mysql_result($data1,0,4)<>"ANO") {echo "<option>ANO</option>";}
if (mysql_result($data1,0,4)<>"NE") {echo "<option>NE</option>";}?>
</select></td></tr>
<tr><td colspan=2 align=center><br /><input type=submit name="tlacitko" value="Uložit Položku Menu Profilu"></td></tr>
<?}}?>


<?
if (@$menu=="HiddenBox Skupiny") {$data1=mysql_query("select * from tool_groups order by nazev");?>
<tr bgcolor=#ECB44A><td align=right width=50%><b>Zadej / Vyber Skupinu:</b></td><td width=50%><input name="newgroup" type="text" value="<?echo @$_POST["nastroj"];?>" onblur=submit(this) style=width:100px>
<select size="1" name="sgroup" style=width:100px onchange=submit(this)>
<?if (@$_POST["sgroup"]) {echo"<option>".@$_POST["sgroup"]."</option>";} else {echo"<option></option>";}
@$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["sgroup"]<>mysql_result($data1,$cykl,1)) {echo"<option>".mysql_result($data1,$cykl,1)."</option>";}
@$cykl++;endwhile;
?>
</select>

<? //skupina vybrana
if (@$_POST["sgroup"]){$data2=mysql_query("select * from tool_groups where nazev='".securesql(@$_POST["sgroup"])."' order by nazev");?><tr bgcolor=#ECB44A><td align=right width=50%><b>Nad 18 Let:</b></td><td width=50%><input name="afteradults" type="checkbox" <?if (mysql_result($data2,0,2)=="ANO") {echo"checked";}?> > <input name=tlacitko type="submit" value="Uložit Nastavení"></td></tr>
<?}}


if (@$menu=="HiddenBox") {$data1=mysql_query("select * from nastroje order by poradi");?>
<tr bgcolor=#ECB44A><td align=right width=50%><b>Zadej / Vyber Název Nástroje:</b></td><td width=50%><input name="nastroj" type="text" value="<?echo @$_POST["nastroj"];?>" onblur=submit(this) style=width:100px>
<select size="1" name="nastroj1" style=width:100px onchange=submit(this)>
<?if (@$_POST["nastroj1"]) {echo"<option>".@$_POST["nastroj1"]."</option>";}echo"<option></option>";
@$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (@$_POST["nastroj1"]<>mysql_result(@$data1,$cykl,2)) {echo "<option>".mysql_result(@$data1,$cykl,2)."</option>";}
@$cykl++;endwhile;?></select> <?if (@$_POST["nastroj1"]) {echo"<input type=button name=tlacitko value=Odstranit  onClick=`if(confirm('Chcete skutečně HiddenBox: ".@$_POST["nastroj1"]." Odstranit?')) window.location.href('index.php?menu=".code('HiddenBox')."&odstranit=".@$_POST["nastroj1"]."')` >";}?></td></tr>


<?if (@$_POST["nastroj"] or @$_POST["nastroj1"]) {$data2=mysql_query("select * from tool_groups order by nazev");
$data1=mysql_query("select * from nastroje where nazev='".securesql(@$_POST["nastroj1"])."' ");?>
<tr bgcolor=#ECB44A><td align=right width=50%><b>Vyber Skupinu Nástroje:</b></td><td width=50%>
<select size="1" name="sgroup" style=width:200px><?
echo"<option>".mysql_result($data1,0,14)."</option>";
@$cykl=0;while(@$cykl<mysql_num_rows($data2)):
if (mysql_result($data2,$cykl,1)<>mysql_result($data1,0,14)) {echo"<option>".mysql_result($data2,$cykl,1)."</option>";}
@$cykl++;endwhile;?></select></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadej Pořadí:</b></td><td><input name="poradi" type="text" value="<?if (@$_POST["nastroj1"]) {echo mysql_result(@$data1,0,1);}?>" style=width:100px> (10,20,30)</td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Hlavička:</b></td><td><input name="hlavicka" type="text" value='<?if (@$_POST["nastroj1"]) {echo stripslashes(mysql_result(@$data1,0,4));}?>' style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Popisek (alt/title/text):</b></td><td><input name="popisek" type="text" value="<?if (@$_POST["nastroj1"]) {echo mysql_result(@$data1,0,9);}?>" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zobrazit / Ikona (32x32):</td><td align=center><?if (mysql_result(@$data1,0,8)) {echo "<img src='./hidikona.php?id=".mysql_result(@$data1,0,1)."' style=align:center><br />";}?><input name="lista" type="checkbox" <?if (@$_POST["nastroj1"] and mysql_result(@$data1,0,10)=="ANO") {echo " Checked ";}?> ><input name="ikona" type="file" value="" style=width:90%></td></tr>
<tr bgcolor=#ECB44A><td align=center><b>Parametry Menu</b><br /><textarea name="parametry" rows=15 style=width:100% wrap="on"><?if (@$_POST["nastroj1"]) {echo stripslashes(mysql_result(@$data1,0,6));}?></textarea></td>
<td align=center><b>Kód Těla</b><br /><textarea name="kod" rows=15 style=width:100% wrap="on"><?if (@$_POST["nastroj1"]) {echo mysql_result(@$data1,0,5);}?></textarea></td></tr>
<tr bgcolor=#ECB44A><td colspan=2 align=center><b>MOVE SCRIPT</b><br /><textarea name="movescript" rows=20 style=width:100% wrap="on"><?if (@$_POST["nastroj1"]) {echo stripslashes(mysql_result(@$data1,0,12));}?></textarea></td></tr>
<tr bgcolor=#ECB44A><td colspan=2 align=center><b>Google SCRIPT</b><br /><textarea name="googlescript" rows=10 style=width:100% wrap="on"><?if (@$_POST["nastroj1"]) {echo stripslashes(mysql_result(@$data1,0,13));}?></textarea></td></tr>
<tr><td colspan=2 align=center><br /><input type=submit name="tlacitko" value="Uložit Nástroj"></td></tr>
<?}}?>



<?
if (@$menu=="Přidat Položku Menu") {?>
<tr bgcolor=#ECB44A><td align=right><b>Zadej Pořadí:</b></td><td><input name="poradi" type="text" value="" style=width:100px> (10,20,30)</td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Hlavní Lišta / Ikona (32x32):</td><td><input name="lista" type="checkbox"><input name="ikona" type="file" value="" style=width:90%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadej Název Nového Menu:</b></td><td><input name="nazev" type="text" value="" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadej SEO pro Vyhledávače (hesla o obsahu stránky):</b></td><td><input name="seo" type="text" value="" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zobrazit až po přihlášení:</b></td><td><input name="reqlogin" type="checkbox" ></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zobrazit Obsah i v případě Submenu:</b></td><td><input name="subshow" type="checkbox" ></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Přiřadit Submenu:</b></td><td><select size="1" name="submenu">
<?if (@$submenu=="" or @$submenu=="NE"){echo"<option>NE</option><option>ANO</option>";} else {echo"<option>ANO</option><option>NE</option>";}?>
</select></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Typ:</b></td><td><select size="1" name="typ"><option>Standard</option><option>Load Object</option><option>Include</option></select></td></tr>
<tr><td colspan=2 align=center><br /><input type=submit name="tlacitko" value="Uložit"></td></tr>
<?}?>



<?
if (@$menu=="Nastavení Hlavních Hodnot") {?>
<tr bgcolor=#ECB44A><td align=right><b>Název Hodnoty</b></td><td>Hodnota</td></tr>
<?@$cykl=0;@$data1=mysql_query("select * from setting order by id");
while(@$cykl<mysql_num_rows(@$data1)):
?><tr><td><input name="set<?echo$cykl;?>" type="text" value="<?echo mysql_result(@$data1,$cykl,1);?>" style=width:100% readonly=yes></td><td><input name="hodnota<?echo$cykl;?>" type="text" value="<?echo mysql_result(@$data1,$cykl,2);?>" style=width:100%></td></tr><?
@$cykl++;endwhile;?>
<tr><td colspan=2 align=center><br /><input type=submit name="tlacitko" value="Uložit Hodnoty"></td></tr>
<?}?>





<?
if (@$menu=="Přidat Položku SubMenu") {@$idmenu=mysql_result(mysql_query("select * from menu where poradi='".securesql($poradi)."'"),0,0);?>
<input name="idmenu" type="hidden" value="<?echo $idmenu;?>">
<tr bgcolor=#ECB44A><td align=right><b>Zadej Pořadí:</b></td><td><input name="poradi" type="text" value="" style=width:100px> (10,20,30)</td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Hlavní Lišta / Ikona (40x32):</td><td><input name="lista" type="checkbox"><input name="ikona" type="file" value="" style=width:90%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadej Název Nového SubMenu:</b></td><td><input name="nazev" type="text" value="" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadej SEO pro Vyhledávače (hesla o obsahu stránky):</b></td><td><input name="seo" type="text" value="" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zobrazit až po přihlášení:</b></td><td><input name="reqlogin" type="checkbox" ></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Typ:</b></td><td><select size="1" name="typ"><option>Standard</option><option>Load Object</option><option>Include</option></select></td></tr>
<tr><td colspan=2 align=center><br /><input type=submit name="tlacitko" value="Uložit"></td></tr>
<?}?>


</form>




<?if (@$menu=="Fotogalerie") {?>
<tr bgcolor=#ECB44A><td colspan=2 align=center><b>Fotogalerie</b> (obrázky 800x600px poměr 4/3)</td></tr>
<tr><td colspan=2><table width=100% align=center border=1><tr><?
@$data1=mysql_query("select * from fotogalerie order by poradi DESC");@$seznam=mysql_num_rows(@$data1);if (@$seznam=="") {@$seznam=1;}
@$cykl=-1;while(@$cykl<@$seznam):
if (@$cykl/8== round(@$cykl/8,0) and @$cykl>0) {?></tr><tr><?}    //novy radek
?><td style=width:12.5%;vertical-align:bottom; align=center>
<form action="index.php" method="post">
<input name="menu" type="hidden" value="<?echo@$menu;?>"><input name="id" type="hidden" value="<?echo mysql_result(@$data1,$cykl,0);?>">

<?if (@$cykl<mysql_num_rows(@$data1) and @$cykl>=0) { //script pro vykresleni obrazku
if (mysql_result(@$data1,$cykl,4)=="") {echo"<br /><br /><br /><center>Foto není k dispozici</center><br /><br />";?>
<input type="button" value="Vložit Foto" style=width:110px;font-size:8pt; onclick="window.open('addimage.php?id=<?echo base64_encode(mysql_result(@$data1,$cykl,0));?>','','width=400,height=550,scrollbars') ;return false;"><br />
<input name="poradi" type="text" value="<?if (@mysql_result(@$data1,$cykl,1)<>"") {echo @mysql_result(@$data1,$cykl,1);}?>" style=width:20%;font-size:9px>
<input name="nazev" type="text" value="<?if (@mysql_result(@$data1,$cykl,2)<>"") {echo @mysql_result(@$data1,$cykl,2);} else {echo'Název Galerie';}?>" style=width:74%;font-size:9px><br />
<select size="1" name="id_menu" style=width:100%;font-size:8pt>
<?if (mysql_result(@$data1,$cykl,6)<>0){echo"<option value=\"".mysql_result(@$data1,$cykl,6)."\">".mysql_result(mysql_query("select nazev from menu where id='".securesql(mysql_result(@$data1,$cykl,6))."' "),0,0)."</option>";}
@$data2=mysql_query("select id,nazev from menu order by poradi ASC");
@$cyklus=0;while(@$cyklus<mysql_num_rows(@$data2)):
if (mysql_result(@$data1,$cykl,6)<>mysql_result(@$data2,$cyklus,0)) {echo"<option value=\"".mysql_result(@$data2,$cyklus,0)."\">".mysql_result(@$data2,$cyklus,1)."</option>";}
@$cyklus++;endwhile;
?></select><br />
<input type="submit" name=tlacitko value="Uložit Změny" style=font-size:9px;width:50%><input type="submit" name=tlacitko value="Odstranit" style=font-size:9px;width:47%><?}

else {?>
<a rel="lightbox" href="obrazek.php?id=<?echo base64_encode(mysql_result(@$data1,$cykl,0));?>" border=0 title="<?echo mysql_result(@$data1,$cykl,1).' '.mysql_result(@$data1,$cykl,2);?>"><img src="obrazek.php?id=<?echo base64_encode(mysql_result(@$data1,$cykl,0));?>" width=110pt alt="<?echo mysql_result(@$data1,$cykl,1).' '.mysql_result(@$data1,$cykl,2);?>" border="0"></a>
<input type="button" value="Nahradit Foto" style=width:110px;font-size:8pt onclick="window.open('addimage.php?id=<?echo base64_encode(mysql_result(@$data1,$cykl,0));?>','','width=400,height=550,scrollbars')"><br />
<input name="poradi" type="text" value="<?if (@mysql_result(@$data1,$cykl,1)<>"") {echo @mysql_result(@$data1,$cykl,1);}?>" style=width:20%;font-size:9px>
<input name="nazev" type="text" value="<?if (@mysql_result(@$data1,$cykl,2)<>"") {echo @mysql_result(@$data1,$cykl,2);} else {echo'Název Galerie';}?>" style=width:74%;font-size:9px><br />
<select size="1" name="id_menu" style=width:100%;font-size:8pt>
<?if (mysql_result(@$data1,$cykl,6)<>0){echo"<option value=\"".mysql_result(@$data1,$cykl,6)."\">".mysql_result(mysql_query("select nazev from menu where id='".securesql(mysql_result(@$data1,$cykl,6))."' "),0,0)."</option>";}
@$data2=mysql_query("select id,nazev from menu order by poradi ASC");
@$cyklus=0;while(@$cyklus<mysql_num_rows(@$data2)):
if (mysql_result(@$data1,$cykl,6)<>mysql_result(@$data2,$cyklus,0)) {echo"<option value=\"".mysql_result(@$data2,$cyklus,0)."\">".mysql_result(@$data2,$cyklus,1)."</option>";}
@$cyklus++;endwhile;
?></select><br />
<input type="submit" name=tlacitko value="Uložit Změny" style=font-size:9px;width:50%><input type="submit" name=tlacitko value="Odstranit" style=font-size:9px;width:47%><?}
?></td><?}

if (@$cykl==-1) { //script pro pridani obrazku
?><br /><br /><center>Vložit Nové Foto</center><br /><br /><br />
<input name="poradi" type="text" value="<?if (@mysql_result(@$data1,$cykl,1)<>"") {echo @mysql_result(@$data1,$cykl,1);}?>" style=width:20%;font-size:9px>
<input name="nazev" type="text" value="<?if (@mysql_result(@$data1,$cykl,2)<>"") {echo @mysql_result(@$data1,$cykl,2);} else {echo'Název Galerie';}?>" style=width:74%;font-size:9px><br />
<select size="1" name="id_menu" style=width:110px;font-size:8pt>
<?@$data2=mysql_query("select id,nazev from menu order by poradi ASC");
@$cyklus=0;while(@$cyklus<mysql_num_rows(@$data2)):
echo"<option value=\"".mysql_result(@$data2,$cyklus,0)."\">".mysql_result(@$data2,$cyklus,1)."</option>";
@$cyklus++;endwhile;?></select><br />
<input type="submit" name=tlacitko value="Uložit Nový" style=font-size:9px;width:50%><input type="button" name=tlacitko value="" style=font-size:9px;width:47%>
</td><?// dopocet 8 td
}?></form><?
@$cykl++;endwhile;while (@$cykl/8<>round(@$cykl/8,0)):?><td style=width:12.5></td><?@$cykl++;endwhile;
?></tr></table></td></tr><?}?>





<?if (@$menu=="Znamení") {?><form action="index.php" method="post" enctype="multipart/form-data">
<input name="menu" type="hidden" value="<?echo@$menu;?>">

<?@$data1=mysql_query("select * from znameni where nazev='".securesql($poradi)."'");?>
<tr bgcolor=#ECB44A><td align=right><b>Zadané Pořadí:</b></td><td><input name="poradi" type="text" value="<?echo mysql_result(@$data1,0,2);?>" style=width:100px> (10,20,30)</td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Název Znamení: </b></td><td><input name="nazev" type="text" value="<?echo mysql_result(@$data1,0,1);?>" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Období: </b></td><td><input name="obdobi" type="text" value="<?echo mysql_result(@$data1,0,1);?>" style=width:100%></td></tr>
</select></td></tr>
<?include("./fckeditor/fckeditor.php");?>
<tr><td colspan=2 style=height:100%;align:left align=left>
<?$oFCKeditor = new FCKeditor('FCKeditor1') ;
  $oFCKeditor->BasePath = './fckeditor/' ;
  $oFCKeditor->Value = mysql_result(@$data1,0,5) ;
  $oFCKeditor->Create() ;?>
<br><input type="submit" name=tlacitko value="Uložit Znamení" align=right></td></tr></form>
<?}?>






<?if (@$menu=="Upravit Obsah Menu" and @$poradi<>"" and @$nazev<>"") {?><form action="index.php" method="post" enctype="multipart/form-data">
<input name="menu" type="hidden" value="<?echo@$menu;?>"><input name="poradi" type="hidden" value="<?echo@$poradi;?>">

<?@$data1=mysql_query("select * from menu where poradi='".securesql($poradi)."'");?>
<tr bgcolor=#ECB44A><td align=right><b>Zadané Pořadí:</b></td><td><input name="poradinew" type="text" value="<?echo mysql_result(@$data1,0,2);?>" style=width:100px> (10,20,30)</td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Hlavní Lišta / Ikona (32x32):</td><td align=center><?if (mysql_result(@$data1,0,9)) {echo "<img src='./ikona.php?id=".code(mysql_result(@$data1,0,0))."' style=align:center><br />";}?><input name="lista" type="checkbox" <?if (mysql_result(@$data1,0,10)=="ANO") {echo " checked ";}?> ><input name="ikona" type="file" value="" style=width:90%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadaný Název Menu: </b></td><td><input name="nazev" type="text" value="<?echo mysql_result(@$data1,0,1);?>" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadané SEO pro Vyhledávače (hesla o obsahu stránky):</b></td><td><input name="seo" type="text" value="<?echo mysql_result(@$data1,0,3);?>" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zobrazit až po přihlášení:</b></td><td><input name="reqlogin" type="checkbox" <?if (mysql_result($data1,0,11)=="ANO") {echo " checked ";}?> ></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zobrazit Obsah i v případě Submenu:</b></td><td><input name="subshow" type="checkbox" <?if (mysql_result($data1,0,12)=="ANO") {echo " checked ";}?> ></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Přiřadit Submenu:</b></td><td><select size="1" name="submenu">
<?if (mysql_result($data1,0,7)=="NE"){echo"<option>NE</option><option>ANO</option>";} else {echo"<option>ANO</option><option>NE</option>";}?>
</select></td></tr>

<tr bgcolor=#ECB44A><td align=right><b>Typ:</b></td><td><select size="1" name="typ">
<?echo "<option>".mysql_result($data1,0,4)."</option>";
if (mysql_result($data1,0,4)<>"Standard") {echo "<option>Standard</option>";}
if (mysql_result($data1,0,4)<>"Include") {echo "<option>Include</option>";}
if (mysql_result($data1,0,4)<>"Load Object") {echo "<option>Load Object</option>";}
?></select></td></tr>

<?include("./fckeditor/fckeditor.php");?>
<tr><td colspan=2 style=height:100%;align:left align=left>
<?$oFCKeditor = new FCKeditor('FCKeditor1') ;
  $oFCKeditor->BasePath = './fckeditor/' ;
  $oFCKeditor->Value = mysql_result(@$data1,0,5) ;
  $oFCKeditor->Create() ;?>
<br><input type="submit" name=tlacitko value="Uložit Obsah" align=right></td></tr></form>
<?}?>






<?if (@$menu=="Upravit Obsah SubMenu" and @$idsub<>"") {?>
<form action="index.php" method="post" enctype="multipart/form-data">
<input name="menu" type="hidden" value="<?echo@$menu;?>"><input name="idsub" type="hidden" value="<?echo@$idsub;?>">

<?@$data1=mysql_query("select * from submenu where id='".securesql($idsub)."'");?>
<tr bgcolor=#ECB44A><td align=right><b>Zadané Pořadí:</b></td><td><input name="poradinew" type="text" value="<?echo mysql_result(@$data1,0,2);?>" style=width:100px> (10,20,30)</td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Hlavní Lišta / Ikona (40x32):</td><td align=center><?if (mysql_result(@$data1,0,9)) {echo "<img src='./subikona.php?id=".code(mysql_result(@$data1,0,0))."' style=align:center><br />";}?><input name="lista" type="checkbox" <?if (mysql_result(@$data1,0,10)=="ANO") {echo " checked ";}?> ><input name="ikona" type="file" value="" style=width:90%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadaný Název SubMenu:</b></td><td><input name="nazev" type="text" value="<?echo mysql_result(@$data1,0,3);?>" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zadej SEO pro Vyhledávače (hesla o obsahu stránky):</b></td><td><input name="seo" type="text" value="<?echo mysql_result(@$data1,0,4);?>" style=width:100%></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Zobrazit až po přihlášení:</b></td><td><input name="reqlogin" type="checkbox" <?if (mysql_result($data1,0,11)=="ANO") {echo " checked ";}?> ></td></tr>
<tr bgcolor=#ECB44A><td align=right><b>Typ:</b></td><td><select size="1" name="typ">
<?echo "<option>".mysql_result($data1,0,5)."</option>";
if (mysql_result($data1,0,5)<>"Standard") {echo "<option>Standard</option>";}
if (mysql_result($data1,0,5)<>"Include") {echo "<option>Include</option>";}
if (mysql_result($data1,0,5)<>"Load Object") {echo "<option>Load Object</option>";}
?></select></td></tr>

<?include("./fckeditor/fckeditor.php") ;?>
<tr><td colspan=2 style=height:100%>
<?php
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = 'fckeditor/' ;
$oFCKeditor->Value = mysql_result(@$data1,0,6);
$oFCKeditor->Create() ;?>
    <br>
    <input type="submit" name=tlacitko value="Uložit Obsah">
  </form>
</td></tr>
<?}?>




</center>
</table>
<?}?></body>
</html>



