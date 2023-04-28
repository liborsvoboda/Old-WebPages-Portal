<?php
function authenticate_user(){
header('WWW-Authenticate: Basic realm="Prihlaseni Zadatele o Vzdalenou Spravu"');
header('HTTP/1.0 401 Unauthorized');}
header('Content-Type: text/html; charset=utf-8');

$dnes = Date("dmY");

if (!isset($_SERVER['PHP_AUTH_USER'])){
authenticate_user();
} else {

if ($_SERVER[PHP_AUTH_USER] == "remote" and $_SERVER[PHP_AUTH_PW]==$dnes ) {@$next="Go";}
if ($_SERVER[PHP_AUTH_USER] == "root" and $_SERVER[PHP_AUTH_PW]==$dnes ) {@$next="Go";@$nextx="Go";}


if (($_SERVER[PHP_AUTH_USER] <> "remote" and $_SERVER[PHP_AUTH_USER] <> "root") or $_SERVER[PHP_AUTH_PW]<>$dnes ) { authenticate_user();}}


if (@$next<>"Go" ) {

?><BR><BR><BR>
<center><img src="picture/logo.jpg" border="0"></center>
<BR><BR> Nesprávné jméno nebo heslo.<BR><BR> Kontaktuje tým KlikneteZde.Cz na tel: 724 986 873 nebo na mail: <a href="mailto:Libor.Svoboda@KlikneteZde.Cz">Správce Služeb</a>
<table width=40%><tr><td align="center"><BR><BR>
<a href="http://www.KlikneteZde.Cz"><img alt="Zpět na KlikneteZde.Cz" title="Zpět na KlikneteZde.Cz" border="0" src="picture/www.jpg" /></a>
</td></tr></table>
<?}

if (@$next == "Go" ) {?>

<BR><BR><BR>
<center><img src="picture/logo.jpg" border="0"></center>
<BR>
<p align="center"><h1 align=center>Vítejte v Rozhraní pro Vytvoření Vzdálené Správy</h1></p>
<BR>
<center><table width=100%>
<tr><td align="center"><a href="vpn/TeamClient.exe" target=_blank>1. Klikněte a Spusťte tento odkaz pro vytvoření Spojení</a></td></tr>
<tr><td><BR></td></tr>

<tr><td align="center">Po Spuštění volejte Vaše Id a Password na Tel. Číslo: <b>+420 724 986 873</b> nebo pište na mail <a href="mailto:Libor.Svoboda@KlikneteZde.Cz"><b>Libor.Svoboda@KlikneteZde.Cz</b></a></td></tr>
<tr><td align="center"><br />Spojení bude Následně Spojeno a Okamžitá Podpora Vaší Plochy může Začít.</td></tr>
<?
if (@$nextx=="Go"){?>
<tr><td align="center"><a href="vpn/TeamRoot.exe" target=_blank>1. VPN Root</a></td></tr><?}?>

<tr><td><BR></td></tr>


</table>
</center>
<?}

?>

