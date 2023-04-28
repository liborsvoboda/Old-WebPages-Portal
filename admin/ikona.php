<?php
$idobr=base64_decode(@$_GET["id"]);include ("./dbconnect.php");
   @$ikona = mysql_query("select ikona,mikona from menu where id='".mysql_real_escape_string($idobr)."'");
Header ("Content-type: ".mysql_result($ikona,0,1));
print mysql_result($ikona,0,0).".jpg";?>
