<?session_start();
session_register("lnamed");
$idobr=@$_GET["id"];include ("./dbconnect.php");
@$ikona = mysql_query("select googlescript from nastroje where poradi='".mysql_real_escape_string($idobr)."'");

// funkce pro nahrazeni retezce za hodnoty z db
function narozky($a){
$nar=mysql_result(mysql_query("select date_format(narozeniny,'%d.%m.%Y') from registrace where lnamed='".mysql_real_escape_string($_SESSION["lnamed"])."' "),0,0);
$repnar=str_replace("narozky",$nar,$a);
return $repnar;
}

//header("Content-Disposition:attachment;filename='movescript".$idobr.".js'");
echo stripslashes (narozky(mysql_result($ikona,0,0)));?>
