<?php
if (isset($_GET['username'])) {

include("./admin/dbconnect.php");
include("./admin/knihovna.php");
$check = mysql_query("SELECT lnamed FROM registrace WHERE lnamed='".securesql($_GET['username'])."' "); // Run A Query To See If The Username exists

if (mysql_num_rows($check) > 0) {$checkcolor="#FFB0B0";$status = " <img src=./picture/ntick.png alt=\"Jméno je Obsazené\" title=\"Jméno je Obsazené\" >";}
else {$checkcolor="#66cc66";$status = " <img src=./picture/tick.png alt=\"Jméno je Volné\" title=\"Jméno je Volné\" >";}

if ($_GET['username'] == "") {$checkcolor="#FFB0B0";$status = " <img src=./picture/ntick.png alt=\"Jméno musíte zadat\" title=\"Jméno musíte zadat\" >";}
?>
document.getElementById('lname').style.backgroundColor = '<? echo $checkcolor; ?>';
document.getElementById('checkuser').innerHTML = '<? echo $status; ?>';
<?
mysql_close(); // Closing The Connection
}
?>