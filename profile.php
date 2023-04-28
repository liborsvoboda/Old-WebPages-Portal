<?session_start();
session_register("lnamed");
session_register("vyska");session_register("sirka");
include("./admin/dbconnect.php");
include("./admin/knihovna.php");

?>
<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?if (@$_POST["setmenu"]=="Obecné" or (!@$_POST["setmenu"] and $_SESSION["lnamed"])){?>
  <link rel="stylesheet" href="./css/kalendar.css" type="text/css" media="screen" />
  <script type="text/javascript" charset="iso-8859-1" src="./js/kalendar.js"></script>
  <script type="text/javascript" charset="utf-8" src="./js/kalendarcs.js"></script>
  <?include "./js/size.js";?>
  <script type="text/javascript">
    datedit("narozen","dd.mm.yyyy",false);
  </script>
<?}?>

</head>

<body style="background:transparent;align:center;width:98%;height:98%;z-index:150;vertical-align:top;overflow-x:hidden;overflow-y:hidden;">
<table margin=0 border=0 cellpadding="0" cellspacing="0" align=center width=100% height=100% style=background:transparent;align:center;vertical-align:top; >
<form method=post>
<script>sizepost();</script>
<tr style=vertical-align:top height=30px><td colspan=2 ><h1>Nastavení Profilu</h1></td></tr>


<tr style=vertical-align:top height=100%><td style="width:30%;height:80%;vertical-align:top;"><select scrolling=no name="setmenu" size=32 style=width:100%;height:600px;vertical-align:top;font-size:16px;font-weight:bold;overflow:auto; onclick=submit(this)>
<?$data1=mysql_query("select * from menu_profilu order by poradi");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
if (mysql_result($data1,$cykl,2)==@$_POST["setmenu"] or (!@$_POST["setmenu"] and $cykl==0)) {$selected=" selected ";@$_POST["setmenu"]=mysql_result($data1,$cykl,2);} else {$selected="";}
echo"<option ".$selected.">".mysql_result($data1,$cykl,2)."</option>";
@$cykl++;endwhile;?></select></td>

<td width=70% style=vertical-align:top><?include "./setting/".mysql_result(mysql_query("select soubor from menu_profilu where nazev='".securesql(@$_POST["setmenu"])."' "),0,0);?></td></tr>

<tr style=vertical-align:top><td align=right colspan=2 width=100% style=vertical-align:top>
<?if (mysql_result(mysql_query("select save_tlacitko from menu_profilu where nazev='".securesql(@$_POST["setmenu"])."' "),0,0)=="ANO"){?>
<hr><table margin=0 border=0 cellpadding="0" cellspacing="0" width=100%><tr><td width=50% align=left style=color:red;><b><sup>1)</sup> červené kolonky jsou povinné</b></td>
<td width=50% align=right><input name=tlacitko type="submit" value=" Uložit Profil"></td></tr></table>
<?}?>
</td></tr>

<!--//Výška dokumentu//-->
<?if (@$_SESSION["vyska"]=="" and @$_REQUEST["vyska"]=="") {?><script>size();</script><?} else {$_SESSION["vyska"]=@$_REQUEST["vyska"];$_SESSION["sirka"]=@$_REQUEST["sirka"];}?>
<!--//KOnec Výšky dokumentu//-->

</form></table></body>
