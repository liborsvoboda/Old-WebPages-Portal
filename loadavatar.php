<?php
include ("./admin/dbconnect.php");
if (@$_GET["id"]) {@$ikona = mysql_query("select snimeksmal,mime from fototemp where id='".mysql_real_escape_string(@$_GET["id"])."'");}
if (@$_GET["idr"]) {@$ikona = mysql_query("select sikona,mime from registrace where id='".mysql_real_escape_string(base64_decode(@$_GET["idr"]))."'");}
if (@$_GET["idrbig"]) {@$ikona = mysql_query("select ikona,mime from registrace where id='".mysql_real_escape_string(base64_decode(@$_GET["idrbig"]))."'");}
Header ("Content-type: ".mysql_result($ikona,0,1));
print mysql_result($ikona,0,0).".jpg";?>
