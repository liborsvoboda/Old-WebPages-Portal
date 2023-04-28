<?session_start();
session_register("lnamed");

@$dnes=date("Y-m-d");
include "./admin/dbconnect.php";
include("./admin/knihovna.php");


if (@$_GET["favorite"] and @$_GET["favorite"]<>"null") {$favname=explode("/",@$_GET["favorite"]);$control=mysql_num_rows(mysql_query("select id from oblibene where nazev='".securesql($favname[2])."' "));

if (!$control) {mysql_query("insert into oblibene (lnamed,nazev,odkaz)VALUES('".$_SESSION['lnamed']."','".securesql($favname[2])."','".securesql(@$_GET["favorite"])."')")or Die(MySQL_Error());?><SCRIPT language="JavaScript">
alert('Stránka byla úspěšně uložena');
window.location.href="<?echo $_GET["favorite"];?>";
</script><?}

else {?><SCRIPT language="JavaScript">
alert('Stránka je již v seznamu. Nebyla Uložena.');
window.location.href="<?echo $_GET["favorite"];?>";
</script><?}
}


if (!@$_GET["favorite"] or @$_GET["favorite"]=="null"){?>
<SCRIPT language="JavaScript">
var favorite="";
favorite=self.prompt("Zadej odkaz oblíbené stránky","http://www.");
if (favorite=='' ||favorite=='null' || favorite=='http://www.'){window.location.href="./help.php?quest=favorites";} else
{window.location.href="./addfavorite.php?favorite="+favorite;}
</script>
<?}?>


