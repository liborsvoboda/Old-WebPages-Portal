<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">



<script type="text/javascript">
    function GetFotoId(myVal) {
  if (myVal!=undefined)   {   document.getElementById('obrazek').src = './loadavatar.php?id=' + myVal;document.getElementById('truefoto').value='./loadavatar.php?id=' + myVal;}
    }

function changeimage(selectsex){
if (selectsex.options[selectsex.selectedIndex].value=='Anonym' && document.getElementById('obrazek').src.search("./picture/") != "-1"){document.getElementById('obrazek').src="./picture/silueta.png";document.getElementById('truefoto').value="./picture/silueta.png";}
if (selectsex.options[selectsex.selectedIndex].value=='Muž' && document.getElementById('obrazek').src.search("./picture/") != "-1"){document.getElementById('obrazek').src="./picture/muz.png";document.getElementById('truefoto').value="./picture/muz.png";}
if (selectsex.options[selectsex.selectedIndex].value=='Žena' && document.getElementById('obrazek').src.search("./picture/") != "-1"){document.getElementById('obrazek').src="./picture/zena.png";document.getElementById('truefoto').value="./picture/zena.png";}
if (selectsex.options[selectsex.selectedIndex].value=='Pár' && document.getElementById('obrazek').src.search("./picture/") != "-1"){document.getElementById('obrazek').src="./picture/par.png";document.getElementById('truefoto').value="./picture/par.png";}
}

function kraje(vybran){
var krif="";var zkrsel="";var krsel="";<?$datazk=mysql_query("select * from okresy_kraje order by id");$cykl1=-1;while(@$cykl1<mysql_num_rows($datazk)):?>krif="<?echo mysql_result($datazk,$cykl1,1);?>";krsel="<?echo mysql_result($datazk,$cykl1,3);?>";zkrsel="<?echo mysql_result($datazk,$cykl1,2);?>";if (krif==vybran.options[vybran.selectedIndex].value) {document.getElementById('zk_okres').value=zkrsel;document.getElementById('kraj').value=krsel;}
<?@$cykl1++;endwhile;?>}

function zemes(vybran){
<?$datazk=mysql_query("select * from zeme where zeme<>'' order by id");$cykl1=-1;
while(@$cykl1<mysql_num_rows($datazk)):?>
krif="<?echo mysql_result($datazk,$cykl1,3);?>";zkrsel="<?echo mysql_result($datazk,$cykl1,2);?>";if (krif==vybran.options[vybran.selectedIndex].value) {document.getElementById("zk_zeme").value=zkrsel;}
<?@$cykl1++;endwhile;?>}

function znamenis(){
<?$datazk=mysql_query("select * from znameni order by poradi");$cykl1=0;while(@$cykl1<mysql_num_rows($datazk)):?>
krsel=<?echo (int)mysql_result($datazk,$cykl1,3);?>;zkrsel=<?echo (int)mysql_result($datazk,$cykl1,4);?>;krif="<?echo mysql_result($datazk,$cykl1,2);?>";
reverse=document.getElementById('narozen').value.substring(0,5).replace(".", "");freverse=reverse.substring(2,4)+reverse.substring(0,2);
if ((freverse>=krsel && freverse<=zkrsel && krif!="KOZOROH") || ((freverse>=krsel || freverse<=zkrsel) && krif=="KOZOROH")) {document.getElementById('znameni').value=krif;}
<?@$cykl1++;endwhile;?>}

</script>

<style>
input[id='lpassword1'],
.passwordStrengthBar {
    width: 100%;
}
.passwordStrengthBar div {
    height: 5px;
    width: 0;
}
.passwordStrengthBar div.strong {
    background-color: #32cd32;
}
.passwordStrengthBar div.medium {
    background-color: yellow;
}
.passwordStrengthBar div.weak {
    background-color: orange;
}
.passwordStrengthBar div.useless {
    background-color: red;
}
</style>
<?php
    $u_agent = $_SERVER['HTTP_USER_AGENT'];$ub = '';
    if(preg_match('/MSIE/i',$u_agent)) {$ub = "ie";}
    elseif(preg_match('/Firefox/i',$u_agent)) {$ub = "firefox";}
    elseif(preg_match('/Safari/i',$u_agent)) {$ub = "safari";}
    elseif(preg_match('/Chrome/i',$u_agent)) {$ub = "chrome";}
    elseif(preg_match('/Flock/i',$u_agent)) {$ub = "flock";}
    elseif(preg_match('/Opera/i',$u_agent)) {$ub = "opera";}

$ldata1=mysql_query("select * from registrace where lnamed='".securesql($_SESSION["lnamed"])."'");?>

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

</head>

<body style="background:transparent;align:center;width:98%;height:98%;z-index:150;" >
<table margin=0 border=0 cellpadding="2" cellspacing="0" align=center width=100% height=100% style=background:transparent;align:center;>
<form name=obecne method=post><? if(@$ub=="ie") {$vyska=395;} if (@$ub=="firefox") {$vyska=400;} if (@$ub<>"ie" and @$ub<>"firefox") {$vyska=450;}?>
<tr style=vertical-align:top><td style=width:100px;vertical-align:top;align:center;text-align:center; rowspan=4><img id=obrazek src="./loadavatar.php?idr=<?echo code(mysql_result($ldata1,0,0));?>" width=100px><br /><input type="button" value="Nahrát své Foto" onclick="window.open('./avatar.php','Avatar','toolbar=0, directories=0, location=0, statusbar=0, menubar=0, resizable=0, scrollbars=0, titlebar=0,width=460,height=<?echo $vyska;?>')" style=width:100%;font-size:8pt;></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:150px>Osoba :</td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:240px>
<select size="1" name="pohlavi" onchange=changeimage(this) >
<?echo "<option>".mysql_result($ldata1,0,3)."</option>";
if (mysql_result($ldata1,0,3)<>"Anonym"){echo"<option value=''>Anonym</option>";}
if (mysql_result($ldata1,0,3)<>"Muž"){echo"<option value='Muž'>Muž</option>";}
if (mysql_result($ldata1,0,3)<>"Žena"){echo"<option value='Žena'>Žena</option>";}
if (mysql_result($ldata1,0,3)<>"Pár"){echo"<option value='Pár'>Pár</option>";}?>
</select></td></tr>

<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Přihlašovací Jméno:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px> <input name="lname" type="text" value="<?echo $_SESSION["lnamed"];?>" style=width:100%;text-align:center;background:#FFB0B0; readonly=yes></td></tr>

<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Staré Heslo:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px> <input id=lpassword name="lpassword" type="password" value="" style=width:100%;text-align:center;background:#FFB0B0;></td></tr>
<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Nové Heslo:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px> <input id=lpassword1 name="lpassword1" type="password" value="" style=width:100%;text-align:center;background:#FFB0B0;></td></tr>

<tr><td colspan=3 style=text-align:center;font-size:20px;><hr /><b>Osobní</b>
<table style=width:100%>
<tr><td width=25% style=font-size:8pt><b>Jméno a Příjmení:</b></td><td width=55%><input name="fullname" type="text" value="<?echo mysql_result($ldata1,0,5);?>" style=width:100%;background-color:#FFB0B0;text-align:center;></td>
<td width=10%>titul:</td><td width=10%><input name="titul" type="text" value="<?echo mysql_result($ldata1,0,4);?>" style=width:55px></td></tr>

<tr><td width=25% style=font-size:10pt><b>Datum Narození:</b></td> <td width=55%>
<input type="text" name="narozen" id="narozen" value="<?echo csdate(mysql_result($ldata1,0,6));?>" onchange=znamenis(this.value); style=width:80%;vertical-align:top;background-color:#FFB0B0;text-align:center; /></td>
<td width=20% colspan=2 style=font-size:10pt><input id=znameni name="znameni" type="text" value="<?echo mysql_result($ldata1,0,7);?>" style=width:100%;text-align:center;background:silver; readonly=yes></td></tr>

<tr><td width=25%>Ulice:</td> <td width=55%><input name="ulice" type="text" value="<?echo mysql_result($ldata1,0,8);?>" style=width:100%;text-align:center;></td>
<td width=10%>Č.P.:</td><td width=10%><input name="cp" type="text" value="<?echo mysql_result($ldata1,0,9);?>" style=width:55px></td></tr>

<tr><td width=25%>Město:</td> <td width=55%><input name="mesto" type="text" value="<?echo mysql_result($ldata1,0,10);?>" style=width:100%;text-align:center;></td>
<td width=10%>PSČ:</td><td width=10%><input name="psc" type="text" value="<?echo mysql_result($ldata1,0,11);?>" style=width:55px></td></tr>

<tr><td width=25%>Okres:</td> <td width=55%><select size="1" name="okres" style=width:100%; onchange=kraje(this);>
<?echo"<option>".mysql_result($ldata1,0,12)."</option>";
$data1=mysql_query("select * from okresy_kraje order by okres,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,1)."</option>";
@$cykl++;endwhile;?></select></td>
<td width=10%>Zkratka:</td><td width=10%><input id=zk_okres name="zk_okres" type="text" value="<?echo mysql_result($ldata1,0,13);?>" style=width:55px;text-align:center;background:silver;font-weight:bold; readonly=yes></td></tr>

<tr><td width=25%>Kraj:</td> <td width=55%><input id=kraj name="kraj" type="text" value="<?echo mysql_result($ldata1,0,14);?>" style=width:100%;text-align:center;background:silver;font-weight:bold; readonly=yes></td>
<td width=10%></td><td width=10%></td></tr>


<tr><td width=25%>Země:</td> <td width=55%><select size="1" name="zeme" style=width:100%; onchange=zemes(this)>
<?echo"<option>".mysql_result($ldata1,0,15)."</option>";
$data1=mysql_query("select * from zeme where zeme<>'' order by zeme,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
echo "<option value='".mysql_result($data1,$cykl,3)."'>".mysql_result($data1,$cykl,3)."</option>";
@$cykl++;endwhile;?></select></td>
<td width=10%>Zkratka:</td><td width=10%><input id=zk_zeme name="zk_zeme" type="text" value="<?echo mysql_result($ldata1,0,16);?>" style=width:55px;text-align:center;background:silver;font-weight:bold; readonly=yes></td></tr>
</table></td></tr>

<tr><td colspan=3 style=text-align:center;font-size:20px;><hr /><b>Kontakty</b>
<table style=width:100%;>
<tr><td width=25%>Telefon domů:</td> <td width=75%><input name="telefon" type="text" value="<?echo mysql_result($ldata1,0,17);?>" style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Telefon do zam.:</td> <td width=75%><input name="telefon" type="text" value="<?echo mysql_result($ldata1,0,18);?>" style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Mobil:</td> <td width=75%><input name="mtelefon" type="text" value="<?echo mysql_result($ldata1,0,19);?>" style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Email:</td> <td width=75%><input name="email" type="text" value="<?echo mysql_result($ldata1,0,20);?>" onblur="return checkEmail(this)" style=width:100%;text-align:center;background:#FFB0B0;></td></tr>
<tr><td width=25%>Web Stránka:</td> <td width=75%><input name="web" type="text" value="<?echo mysql_result($ldata1,0,21);?>" style=width:100%;text-align:left;></td></tr>
<tr><td width=25%>Skype Kontakt:</td> <td width=75%><input name="skype" type="text" value="<?echo mysql_result($ldata1,0,22);?>" style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>ICQ Kontakt:</td> <td width=75%><input name="icq" type="text" value="<?echo mysql_result($ldata1,0,23);?>" style=width:100%;text-align:center;></td></tr>
</table></td></tr>




</form>
</table>

</body>

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/passwordchange.js"></script>
