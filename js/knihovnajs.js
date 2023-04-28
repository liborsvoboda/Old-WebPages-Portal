<!--// 3 ochrany proti navratu zpet, zmacknuti F5 jako reload, a zakaz praveho tlacitka mysi//-->
<SCRIPT LANGUAGE="JavaScript">
javascript:window.history.forward(0);
</SCRIPT>

<script language="JavaScript">
if (document.all){
document.onkeydown = function (){    var key_f5 = 116; // 116 = F5
if (key_f5==event.keyCode){ event.keyCode = 27;return false;}}}
</script>

<script language ="javascript">
function Disable() {
if (event.button == 2)
{
alert("Akce je Zakázána!!")
}}
document.onmousedown=Disable;
</script>

 <!--// skrolovani zpet na misto stranky odkud byl vyvolan reload jeste musi byt nastaven v body  onload="doScroll()" onunload="window.name=document.body.scrollTop"//-->
<script type="text/JavaScript">
function doScroll(){
  if (window.name) window.scrollTo(0, window.name);
}
</script>


<STYLE type="text/css">
<!--
#loading {
	width:240px;
	background-color: #FFFFFF;
	position: absolute;
	left: 50%;
	top: 35%;
	margin-left: -120px;
	text-align: center;
	border: 3px #A4A4A4 solid;
}

#login {
	width:300px;
	background-color: #FFFFFF;
	position: absolute;
	left: 50%;
	top: 35%;
	margin-left: -150px;
	text-align: center;
	border: 5px #004171 solid;
}
-->
</STYLE>

<SCRIPT style="text/javascript">
document.write('<DIV id="loading" style=z-index:100><BR>Počkejte Prosím...<br /><img src="picture/loading.gif" border="0"><br /><a href=<?echo $_SERVER["HTTP_REFERER"];?> title="Načtení se může někdy zadrhnout z důvodu nedostupnosti externího modulu. Zkuste stránku Načíst Znovu">Načíst Znovu</a></DIV>');
window.onload=function(){
	document.getElementById("loading").style.display="none";doScroll();
}

document.write('<DIV id=login style=z-index:10000;color:#000080;><form action="<?echo $_SERVER["HTTP_REFERER"];?>" method=post><table border=0 cellpading=0 cellspacing=0 style=color:#000080;><tr><td colspan=2 align=center><b>Přihlášení Uživatele.....</b></td></tr><tr><td>Jméno:</td><td><input name="user" type="text" value="" style=width:180px;text-align:center;></td></tr><tr><td>Heslo:</td><td><input name="password" type="password" value="" style=width:180px;text-align:center;></td></tr><tr><td></td><td><img id="siimage" align=left style="vertical-align:top;padding-right:0px;" border=0 src="./logcaptcha/securimage_show.php?sid=<?echo md5(time());?>"/><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="24" height="24" id="SecurImage_as3" align="middle"><param name="allowScriptAccess" value="sameDomain" /><param name="allowFullScreen" value="false" /><param name="movie" value="./logcaptcha/securimage_play.swf?audio=./logcaptcha/securimage_play.php?&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="./logcaptcha/securimage_play.swf?audio=./logcaptcha/securimage_play.php?&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="24" height="24" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object></td></tr><tr><td></td><td><input type="text" name="code" style="width:180px;vertical-align:top;text-align:center;color:black;resize:none;background:#DD4448" value="Sem opište kód" onClick=select() /></td></tr><tr><td><a href=http://www.kliknetezde.cz/34-registrace-noveho-uzivatele.html >Nová Registrace</a></td><td align=right><input type="submit" value="Přihlásit"></td></tr></table></form></DIV>');
document.getElementById("login").style.display="none";

function login(){var pocet=0;

if (document.getElementById("login").style.display!="none") {pocet=1;document.getElementById("login").style.display="none";}
if (document.getElementById("login").style.display=="none" && pocet==0) {document.getElementById("login").style.display="inline";}
}

function logout(){window.open('./logout.php','','toolbar=0,fullscreen=0, width=300, height=100, directories=0, location=0, status=0, menubar=0, resizable=0, scrollbars=0, titlebar=0');
<?if ($ub=="ie") {?>window.location.href('http://www.kliknetezde.cz');<?} else {?>window.location.assign('http://www.kliknetezde.cz');<?}?>}

</SCRIPT>
