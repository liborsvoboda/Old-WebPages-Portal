<?session_start();
session_register("lnamed");
session_register("vyska");session_register("sirka");
session_register("token");$token=$_SESSION["token"];
if (@$token=="") {$token = md5(uniqid(mt_rand()));$_SESSION["token"] = $token; }


include("./admin/dbconnect.php");
include("./admin/knihovna.php");
if (@$_POST["user"] and @$_POST["password"]) {include "./login.php";}
$dnes = Date("Y-m-d");
@$cas=StrFTime("%H:%M:%S", Time());

?>
<html>
<head>
<meta name="google-site-verification" content="XSq8LlGyJ4Z2m6oiiDUDuv6cjIvBfbru6-p9kQahunI" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="icon" href='<?echo mysql_result(mysql_query("select hodnota from setting where nazev='url'"),0,0);?>/favicon.ico' type="image/x-icon">
<link rel="shortcut icon" href='<?echo mysql_result(mysql_query("select hodnota from setting where nazev='url'"),0,0);?>/favicon.ico' type="image/x-icon">
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?

// pocitadlo
$ipadresa = getenv('HTTP_X_FORWARDED_FOR');
if ($ipadresa == ""){$ipadresa = getenv('REMOTE_ADDR'); }  // promìnná obsahující IP adresu návštìvníka
@$overeni = mysql_num_rows(mysql_query("select Ip from pocitadlo where Ip = '".securesql($ipadresa)."' and `Datum` = '".securesql($dnes)."' and session='".securesql($token)."' "));
if (@$overeni=="0") {mysql_query("insert into pocitadlo(Ip,Datum,cas,session) value ('".securesql($ipadresa)."','".securesql($dnes)."','".securesql($cas)."','".securesql($token)."')");}
// konec pocitadla

// vybrane menu a keywords
$tomenu=explode("/",$_SERVER['REQUEST_URI']);$tomenu=explode("_",$tomenu[1]);$tomenu1=explode("-",$tomenu[0]);$pmenu=$tomenu1[0];$tomenu1=explode("-",$tomenu[1]);$pmenu1=$tomenu1[0];

// odstraneni fav
if ($pmenu1=="favd" and @$_POST["vyska"]=="") {mysql_query("delete from oblibene where lnamed='".securesql($_SESSION["lnamed"])."' and nazev='".securesql(str_replace(".html","",$tomenu1[1]))."' ");
echo "<script>alert('Oblíbená Stránka: ".str_replace(".html","",$tomenu1[1])." byla odstraněna');</script>";}
if ($pmenu1=="favd") {$pmenu="";$pmenu1="";}

if (!$pmenu) {$pmenu=mysql_result(mysql_query("select id from menu order by poradi limit 1"),0,0);}
$keyword=mysql_result(mysql_query("select hodnota from setting where nazev='seo'"),0,0);if (!$pmenu1 or $pmenu1=="fav") {$keyword.=@mysql_result(mysql_query("select seo from menu where id='".securesql($pmenu)."' "),0,0);}if ($pmenu1 and $pmenu1<>"fav") {$keyword.=@mysql_result(mysql_query("select seo from menu where id='".securesql($pmenu)."' "),0,0).@mysql_result(mysql_query("select seo from submenu where id='".securesql($pmenu1)."' "),0,0);}

?>
<title><?echo mysql_result(mysql_query("select hodnota from setting where nazev='sitename' "),0,0);?></title>
<meta name="keywords" content="<?echo @$keyword;?>">
    <?php
    $u_agent = $_SERVER['HTTP_USER_AGENT'];$ub = '';
    if(preg_match('/MSIE/i',$u_agent)) {$ub = "ie";}
    elseif(preg_match('/Firefox/i',$u_agent)) {$ub = "firefox";}
    elseif(preg_match('/Safari/i',$u_agent)) {$ub = "safari";}
    elseif(preg_match('/Chrome/i',$u_agent)) {$ub = "chrome";}
    elseif(preg_match('/Flock/i',$u_agent)) {$ub = "flock";}
    elseif(preg_match('/Opera/i',$u_agent)) {$ub = "opera";}

 if(@$ub=="ie") {?>
  <script type="text/javascript" src="./admin/fckeditor/editor/js/mootoolsie.js"></script>
  <script type="text/javascript" src="./admin/fckeditor/editor/js/slimboxie.js"></script>
   <?}
 else {?>
  <script type="text/javascript" src="./admin/fckeditor/editor/js/mootoolsff.js"></script>
  <script type="text/javascript" src="./admin/fckeditor/editor/js/slimboxff.js"></script>
 <?}?>

<link rel="stylesheet" href="./admin/fckeditor/editor/css/slimbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="./css/imageflow.css" type="text/css" />
<?$halffoto=round (mysql_num_rows(mysql_query("select id from fotogalerie "))/2,0);if ($halffoto<8) {$halffoto=1;}?>
<script type="text/javascript">var startID="<?echo @$halffoto;?>"</script>
<script type="text/javascript" src="./js/imageflow.js">var startID="<?echo @$halffoto;?>"</script>
<script type="text/javascript" src="./js/glossy.js"></script>
<?include "./js/knihovnajs.js";?>
<?include "./js/size.js";?>
<link rel="stylesheet" href="./admin/fckeditor/editor/css/slimbox.css" type="text/css" media="screen" />

<!--//pohyblivá okna//-->
<?if (!$_SESSION["lnamed"]) {
$data1=mysql_query("select * from nastroje where zobrazit='ANO' order by poradi ASC");
@$cykl=0;while(@$cykl<mysql_num_rows(@$data1)):

echo "
<script type=text/javascript src=./admin/movescript.php?id=".code(mysql_result($data1,$cykl,1))."></script>
";
	echo"<script type=text/javascript>YOffset".mysql_result($data1,$cykl,1)."=".((@$cykl*40)+50).";staticYOffset".mysql_result($data1,$cykl,1)."=".((@$cykl*40)+50).";
	".stripslashes(mysql_result($data1,$cykl,6))."
	startMenu".mysql_result($data1,$cykl,1)."(".stripslashes(mysql_result($data1,$cykl,4)).");
	addItem".mysql_result($data1,$cykl,1)."(\"".htmlspecialchars_decode (mysql_result($data1,$cykl,5))."\", \"\", \"\");
	endMenu".mysql_result($data1,$cykl,1)."();
	</script>";@$cykl++;endwhile;} else {
@$showtool=explode(",",mysql_result(mysql_query("select CONCAT (nastroje18,nastroje) from registrace where lnamed='".securesql($_SESSION["lnamed"])."'"),0,0));

$gounder=0;@$cykl=1;while($showtool[$cykl] or $showtool[($cykl+1)]):

if ($showtool[$cykl]){$gounder++;
$data1=mysql_query("select * from nastroje where poradi='".securesql($showtool[$cykl])."' order by poradi ASC");
echo "
<script type=text/javascript src=./admin/movescript.php?id=".code(mysql_result($data1,0,1))."></script>
";
	echo"<script type=text/javascript>YOffset".mysql_result($data1,0,1)."=".((@$gounder*40)+10).";staticYOffset".mysql_result($data1,0,1)."=".((@$gounder*40)+10).";
	".stripslashes(mysql_result($data1,0,6))."
	startMenu".mysql_result($data1,0,1)."(".stripslashes(mysql_result($data1,0,4)).");
	addItem".mysql_result($data1,0,1)."(\"".htmlspecialchars_decode (mysql_result($data1,0,5))."\", \"\", \"\");
	endMenu".mysql_result($data1,0,1)."();
	</script>";}
@$cykl++;endwhile;
}?>
<!--//Konec pohyblivých oken//-->
</head>




<body style="width:100%;height:<?if (@$_POST["sirka"]=="") {echo "100%";} else {echo @$_POST["sirka"]."px";}?>;overflow-x:hidden;overflow-y:hidden;margin:0px;color:black;background-:black;padding:0;text-align: -moz-center;align:center;text-align:center;" onunload="window.name=document.body.scrollTop">
<div style="position:absolute; width:100%; height:100%; margin:0px; padding:0px; left:0px; right:0px;z-index:1;overflow-x:hidden;overflow-y:hidden;"><img src="<?echo mysql_result(mysql_query("select hodnota from setting where nazev='pozadi'"),0,0);?>" width="100%" height="100%"></div>






<!--//menu//-->
<?
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
}?>

<script type="text/javascript">var MenuLinkedBy="AllWebMenus [4]",awmMenuName="kliknetezde",awmBN="852";awmAltUrl="";</script><script charset="UTF-8" src="./menu/kliknetezde.js" type="text/javascript"></script><script type="text/javascript">awmBuildMenu();</script>
<?echo"<ul id=menuitem style=display:none;><li title='Start'><img src=./menu/ikony/icon-start.png><ul>";

if ($_SESSION['lnamed']) {@$data1=mysql_query("select * from menu order by poradi ASC");}
if (!$_SESSION['lnamed']) {@$data1=mysql_query("select * from menu where after_login='NE' order by poradi ASC");}

$lista="";@$cykl=0;while(@$cykl<mysql_num_rows(@$data1)):
echo"<li>";
if (mysql_result($data1,$cykl,7)=="NE" or (mysql_result($data1,$cykl,7)=="ANO" and mysql_result($data1,$cykl,12)=="ANO")){echo"<a href='".mysql_result($data1,$cykl,0)."-".permalink(mysql_result($data1,$cykl,1)).".html'>";}echo"<img src='./admin/ikona.php?id=".code(mysql_result($data1,$cykl,0))."'> ".mysql_result($data1,$cykl,1);
if (mysql_result($data1,$cykl,7)=="NE" or (mysql_result($data1,$cykl,7)=="ANO" and mysql_result($data1,$cykl,12)=="ANO")){echo"</a>";}

	if (mysql_result($data1,$cykl,10)=="ANO") {$lista.="<li title='".mysql_result($data1,$cykl,1)."'><a href='".mysql_result($data1,$cykl,0)."-".permalink(mysql_result($data1,$cykl,1)).".html'><img src='./admin/ikona.php?id=".code(mysql_result($data1,$cykl,0))."'></a></li>";}

if (mysql_result($data1,$cykl,7)=="ANO"){echo"<ul>";

if ($_SESSION['lnamed']) {@$data2=mysql_query("select * from submenu where id_menu='".securesql(mysql_result($data1,$cykl,0))."' order by poradi ASC");}
if (!$_SESSION['lnamed']) {@$data2=mysql_query("select * from submenu where id_menu='".securesql(mysql_result($data1,$cykl,0))."' and after_login='NE' order by poradi ASC");}

	$cykl1=0;while(@$cykl1<mysql_num_rows(@$data2)):
	if (mysql_result($data2,$cykl1,10)=="ANO") {$lista.="<li title='".mysql_result($data2,$cykl1,3)."'><a href='".mysql_result($data1,$cykl,0)."-".permalink(mysql_result($data1,$cykl,1))."_".mysql_result($data2,$cykl1,0)."-".permalink(mysql_result($data2,$cykl1,3)).".html'><img src='./admin/subikona.php?id=".code(mysql_result($data2,$cykl1,0))."'></a></li>";}
	echo"<li><a href='".mysql_result($data1,$cykl,0)."-".permalink(mysql_result($data1,$cykl,1))."_".mysql_result($data2,$cykl1,0)."-".permalink(mysql_result($data2,$cykl1,3)).".html'><img src='./admin/subikona.php?id=".code(mysql_result($data2,$cykl1,0))."' height=20px> ".mysql_result($data2,$cykl1,3)."</a></li>";

// load oblibene
if (mysql_result($data1,$cykl,1)=="Oblíbené"){$cykl2=0;$data3=mysql_query("select * from oblibene where lnamed='".securesql($_SESSION["lnamed"])."' order by nazev,id");
	while (@$cykl2<mysql_num_rows($data3)):
	echo"<li><img src=./picture/delfav.png style=width:25px;height:18px ";?> onClick="if(confirm('Chcete Oblíbenou stránku: <?echo mysql_result($data3,$cykl2,2);?> Odstranit?')) window.location.assign('<?echo mysql_result($data1,$cykl,0)."-".permalink(mysql_result($data1,$cykl,1))."_favd-".mysql_result($data3,$cykl2,2).".html";?>');"<?echo" style=cursor:pointer > <a href='".mysql_result($data1,$cykl,0)."-".permalink(mysql_result($data1,$cykl,1))."_fav-".mysql_result($data3,$cykl2,2).".html' style=text-decoration:none;color:black; >".mysql_result($data3,$cykl2,2)."</a></li>";
@$cykl2++;endwhile;
	}// konec load oblibene

	@$cykl1++;endwhile;echo"</ul>";}echo"</li>";

@$cykl++;endwhile;echo"</li></ul>".$lista."</ul>";  // submenu pomoci <ul><li></li></ul>
?>

<!--//end menu//-->


<!--//text//-->
<?if ($ub=="ie") {$size=68;echo"<table width=100% border=0 cellpadding=0 cellspacing=0 margin=0 style=background:transparent><tr style=vertical-align:top><td style=width:100%>";} else {$size=67;}?>
<div style="position:absolute;width:100%;margin:0px;margin-top:0px;padding:0px;align:center;text-align:center;z-index:50;"><center>

<?
if ($pmenu1=="fav" and @$_POST["sirka"]) {$sirka=@$_POST["sirka"]-100;}
 else {$sirka=800;}?>


<div style="position:relative;width:<?echo $sirka;?>px;height:<?echo ($_POST['vyska']-$size);?>px;margin:0;margin-top:45px;margin-left:0px;padding-top:0px;padding-left:0px;padding-bottom:-45px;overflow:auto;overflow-x:hidden;background:silver;filter:alpha(opacity=85);-moz-opacity:0.85;opacity:0.85;-webkit-opacity:0.85;-khtml-opacity:0.85;-moz-box-shadow: 2px 2px 4px 4px#C0C0C0;-webkit-box-shadow: 2px 2px 4px 4px#C0C0C0;box-shadow: 2px 2px 4px 4px#C0C0C0;align:center;text-align:center;z-index:50;" >
<?if (!@$pmenu1) { //mainmenu	if (@mysql_result(mysql_query("select typ from menu where id='".securesql($pmenu)."' "),0,0)=="Standard") {echo @mysql_result(mysql_query("select zaznam from menu where id='".securesql($pmenu)."' "),0,0);}
	if (@mysql_result(mysql_query("select typ from menu where id='".securesql($pmenu)."' "),0,0)=="Load Object") {		if (@$ub=="ie") {echo "<iframe type=text/html src='".@mysql_result(mysql_query("select zaznam from menu where id='".securesql($pmenu)."' "),0,0)."' style=align:center;background:transparent;width:100%;height:100%;z-index:50; align=middle frameborder=0 allowtransparency=true scrolling=auto noresize=noresize></iframe>";}
		else {echo"<object type=text/html data='".@mysql_result(mysql_query("select zaznam from menu where id='".securesql($pmenu)."' "),0,0)."' style=align:center;background:transparent;width:100%;height:100%;z-index:50; align=middle frameborder=0 allowtransparency=true ></object>";}
	}
	if (@mysql_result(mysql_query("select typ from menu where id='".securesql($pmenu)."' "),0,0)=="Include") {include (mysql_result(mysql_query("select zaznam from menu where id='".securesql($pmenu)."' "),0,0));}
}
 else {  //submenu
 if ($pmenu1<>"fav") {	if (@mysql_result(mysql_query("select typ from submenu where id='".securesql($pmenu1)."' "),0,0)=="Standard") {echo @mysql_result(mysql_query("select zaznam from submenu where id='".securesql($pmenu1)."' "),0,0);}
	if (@mysql_result(mysql_query("select typ from submenu where id='".securesql($pmenu1)."' "),0,0)=="Load Object") {
		if (@$ub=="ie") {echo "<iframe type=text/html src='".@mysql_result(mysql_query("select zaznam from submenu where id='".securesql($pmenu1)."' "),0,0)."' style=align:center;background:transparent;width:100%;height:100%;z-index:50; align=middle frameborder=0 allowtransparency=true scrolling=auto noresize=noresize></iframe>";}
		else {echo"<object type=text/html data='".@mysql_result(mysql_query("select zaznam from submenu where id='".securesql($pmenu1)."' "),0,0)."' style=align:center;background:transparent;width:100%;height:100%;z-index:50; align=middle frameborder=0 allowtransparency=true ></object>";}
	}
	if (@mysql_result(mysql_query("select typ from submenu where id='".securesql($pmenu1)."' "),0,0)=="Include") {include (mysql_result(mysql_query("select zaznam from menu where id='".securesql($pmenu1)."' "),0,0));}
}

// zobrazeni oblibenych
 if ($pmenu1=="fav") {if (@$ub=="ie") {echo "<iframe type=text/html src='http://".str_replace(".html","",$tomenu1[1])."' style=align:center;background:transparent;width:100%;height:100%;z-index:50; align=middle frameborder=0 allowtransparency=true scrolling=auto noresize=noresize></iframe>";}
      	   else {echo "<object type=text/html data='http://".str_replace(".html","",$tomenu1[1])."' style=align:center;background:transparent;width:100%;height:100%;z-index:50; align=middle frameborder=0 allowtransparency=true ></object>";} }
}
?>


<!--//vodorovná reklama//-->
<?if (@mysql_result(mysql_query("select typ from menu where id='".securesql($pmenu)."' "),0,0)<>"Load Object"
and @mysql_result(mysql_query("select typ from submenu where id='".securesql($pmenu1)."' "),0,0)<>"Load Object"){?>
<p style="position:relative;height:100px;bottom:0px; margin:0px; padding:0px; left:0px;align:center;vertical-align:bottom;">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0978820814481571";
/* kliknetebotom */
google_ad_slot = "7433182589";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</p><?}?>
<!--//konec vodorovné reklama//-->

</div>
</center></div>
<?if ($ub=="ie") {echo"</td></tr></table>";}?>
<!--//end text//-->



<!--//svislá reklama//-->
<? if (@$_POST["sirka"]>1040 and $pmenu1<>"fav") {if (@$_POST["vyska"]>600) {$rpos=ceil((@$_POST["vyska"]-600)/2);} else {$rpos=50;}
if (@$_POST["vyska"]>660) {?>
<div style="position:absolute;width:120px;height:100%;right:0;margin:0px;margin-top:<?echo $rpos;?>px;padding:0px;z-index:50;filter:alpha(opacity=85);-moz-opacity:0.85;opacity:0.85;-webkit-opacity:0.85;-khtml-opacity:0.85;">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-0978820814481571";
/* bigright */
google_ad_slot = "2373058925";
google_ad_width = 120;
google_ad_height = 600;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div><?}?>
<?

}?>

<!--//konec svislá reklama//-->





<!--//logininfo//-->

<div style="position:absolute;width:150px;height:39px;top:2px;margin:0px;padding:0px;right:0px;background:white;align:center;z-index:10000;background:silver;filter:alpha(opacity=85);-moz-opacity:0.85;opacity:0.85;-webkit-opacity:0.85;-khtml-opacity:0.85;">

<?if ($_SESSION['lnamed']) {?>Přihlášen: <font face="Arial" size="3" color=blue><b><?echo $_SESSION['lnamed'];?></b></font>
<br /><a href="#" onclick=logout()>Odhlásit</a>
<?} else {?><a href="#" onclick=login()>Přihlásit</a><?}?>

</div>
<!--//end logininfo//-->



<!--//webservice//-->
<div style="position: absolute;width:100%;height:15px;bottom:0px; margin:0px; padding:0px; left:0px;background:black;align:center;z-index:10">
<font face="Arial" size="1"color=gold><b>© COPYRIGHT 2011 ALL RIGHTS RESERVED KLIKNETEZDE.CZ | • Web provozuje společnost © <a href=mailto:Libor.Svoboda@KlikneteZde.Cz style=color:gold>KLIKNETEZDE.CZ 2010</a></b></font>
</div>
<!--//webservice//-->


<!--//Výška dokumentu//-->
<?if (@$_SESSION["vyska"]=="" and @$_REQUEST["vyska"]=="") {?><script>size();</script><?} else {$_SESSION["vyska"]=@$_REQUEST["vyska"];$_SESSION["sirka"]=@$_REQUEST["sirka"];}?>
<!--//KOnec Výšky dokumentu//-->


</body>


</html>
