<?php
$idobr=base64_decode(@$_GET["id"]);include ("./dbconnect.php");
@$ikona = mysql_query("select movescript from nastroje where poradi='".mysql_real_escape_string($idobr)."'");
//header("Content-Disposition:attachment;filename='movescript".$idobr.".js'");

echo stripslashes (mysql_result($ikona,0,0));?>
