<?php
@$dnest=date('Y-m-d H:i:s');

if (@$_POST["user"] and @$_POST["password"]){  include ("./logcaptcha/securimage.php");
  $img = new Securimage();
  $valid = $img->check($_REQUEST["code"]);


  if($valid == true) {$results=mysql_query("select id from registrace where lnamed='".securesql($_POST['user'])."' and lpassword='".securesql(MD5($_POST['password']))."' and potvrzeno='ANO' ");}
  else {?><script>window.location.assign('<?echo $_SERVER["HTTP_REFERER"];?>');</script><?}}




if (!mysql_num_rows($results)) {?><?echo"<center>Vaše přihlášení se nezdařilo prosím kontaktujte <a href=mailto:libor.svoboda@kliknetezde.cz>Administrátora</a></center>";
?><script language="JavaScript">setTimeout('window.location.href="http://www.kliknetezde.cz"', 10000);</script><?}


if (mysql_num_rows($results)) {
session_destroy();
session_start();
session_register("lnamed");
$_SESSION['lnamed']=$_POST['user'];
mysql_query ("update registrace  set lastlogin = '$dnest' where lnamed = '".securesql($_POST['user'])."' ")or Die(MySQL_Error());
?><script>window.location.assign('<?echo $_SERVER["HTTP_REFERER"];?>');</script>
<?}?>


<?if (@$_GET["act"]=="logout") {session_start();
session_unset($_SESSION['lnamed']);
session_destroy();

?><script>window.location.assign('http://www.kliknetezde.cz');</script>
<?}?>




