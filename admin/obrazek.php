<?php
$idobr=base64_decode(@$_GET["id"]);

// database connection
include ("./"."dbconnect.php");

   @$sql = mysql_query("select soubor from fotogalerie where id='$idobr'");
   @$sql1 = mysql_query("select mime from fotogalerie where id='$idobr'");

 $foto= mysql_result($sql,0,0);
  $typ= mysql_result($sql1,0,0);
  Header ("Content-type: $typ");

 print $foto.".jpg";?>
