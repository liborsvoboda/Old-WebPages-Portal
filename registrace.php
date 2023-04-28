<?session_start();
session_register("lnamed");
include("./admin/dbconnect.php");
include("./admin/knihovna.php");



if (@$_POST["tlacitko"]){

// systemovy obr
if (StrPos (" " . @$_POST["truefoto"], "./picture/")) {
	//@$docasny = @$_FILES['truefoto']['tmp_name'];@$mime = @$_FILES['truefoto']['type'];
	@$obsah = implode('', file(@$_POST["truefoto"]));resizeimage(@$_POST["truefoto"],"100","0");
	@$obsah1 = implode('', file(@$_POST["truefoto"]));$mime="image/png";
}

// vlastni obr
if (StrPos (" " . @$_POST["truefoto"], "./loadavatar.php")) {$rozdel=explode("=", @$_POST["truefoto"]);
	$loaddata=mysql_query("select * from fototemp where id='".securesql($rozdel[1])."'")or Die(MySQL_Error());
		@$obsah=mysql_result($loaddata,0,1);@$obsah1=mysql_result($loaddata,0,3);@$mime=mysql_result($loaddata,0,2);
	mysql_query("delete from fototemp where id='".securesql($rozdel[1])."'");
}

$kod=md5(uniqid(mt_rand()));
mysql_query("insert into registrace (lnamed,lpassword,osoba,titul,inicialy,narozeniny,znameni,ulice,cislopopisne,mesto,psc,okres,okreszk,kraj,zeme,zemezk,telefon_home,telefon_work,mobil,email,www,skype,icq,securcode,potvrzeno,datumvkladu,ikona,sikona,mime)VALUES('".securesql(@$_POST["lname"])."','".securesql(MD5(@$_POST["lpassword"]))."','".securesql(@$_POST["osoba"])."','".securesql(@$_POST["titul"])."','".securesql(@$_POST["fullname"])."','".securesql(dbdate(@$_POST["narozen"]))."','".securesql(@$_POST["znameni"])."','".securesql(@$_POST["ulice"])."','".securesql(@$_POST["cp"])."','".securesql(@$_POST["mesto"])."','".securesql(@$_POST["psc"])."','".securesql(@$_POST["okres"])."','".securesql(@$_POST["zk_okres"])."','".securesql(@$_POST["kraj"])."','".securesql(@$_POST["zeme"])."','".securesql(@$_POST["zk_zeme"])."','".securesql(@$_POST["hometel"])."','".securesql(@$_POST["worktel"])."','".securesql(@$_POST["mobil"])."','".securesql(@$_POST["email"])."','".securesql(@$_POST["web"])."','".securesql(@$_POST["skype"])."','".securesql(@$_POST["icq"])."','".securesql($kod)."','NE','".date("Y-m-d H:i:s")."','".mysql_escape_string($obsah)."','".mysql_escape_string($obsah1)."','".securesql($mime)."')")or Die(MySQL_Error());
$idreg=mysql_insert_id();

$body="<body style=background:silver><table margin=0 border=0 cellpadding=2 cellspacing=0 align=center width=600px height=100% style=background:transparent;align:center;>
<tr><td colspan=3 width=100% height=30px ><center><h1>Potvrzení Registrace nového uživatele</h1></center></td></tr>
<tr style=vertical-align:top><td style=width:100px;vertical-align:top;align:center;text-align:center; rowspan=4>
<img src='http://www.kliknetezde.cz/loadavatar.php?idr=".code($idreg)."' width=100px></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:150px>Osoba :</td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:240px>
<input type=text value='".@$_POST["osoba"]."' style=width:100%;color:black; readonly=yes></td></tr>
<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Přihlašovací Jméno:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px>
<input name=lname type=text value='".@$_POST["lname"]."' style=width:100%;text-align:center;background:#FFB0B0; readonly=yes></td></tr>
<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Přihlašovací Heslo:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px> <input type=text value='".@$_POST["lpassword"]."' readonly=yes style=width:100%;text-align:center;background:#FFB0B0;></td></tr>
<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Potvrzení Registrace:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px><a href='http://www.kliknetezde.cz/aktivace.php?kod=".$kod."'>Pro aktivaci účtu KlikněteZde</a></td></tr>
<tr><td colspan=3 style=text-align:center;font-size:20px;><hr /><b>Osobní</b>
<table style=width:100%>
<tr><td width=25% style=font-size:8pt><b>Jméno a Příjmení:</b></td><td width=55%><input type=text value='".@$_POST["fullname"]."' style=width:100%;background-color:#FFB0B0;text-align:center; readonly=yes></td>
<td width=10%>titul:</td><td width=10%><input type=text value='".@$_POST["titul"]."' readonly=yes style=width:55px></td></tr>
<tr><td width=25% style=font-size:10pt><b>Datum Narození:</b></td> <td width=55%>
<input type=text  value='".@$_POST["narozen"]."' readonly=yes style=width:80%;vertical-align:top;background-color:#FFB0B0;text-align:center; /></td>
<td width=20% colspan=2 style=font-size:10pt><input type=text value='".@$_POST["znameni"]."' readonly=yes style=width:100%;text-align:center;background:silver;></td></tr>
<tr><td width=25%>Ulice:</td> <td width=55%><input type=text value='".@$_POST["ulice"]."' readonly=yes style=width:100%;text-align:center;></td>
<td width=10%>Č.P.:</td><td width=10%><input type=text value='".@$_POST["cp"]."' readonly=yes style=width:55px></td></tr>
<tr><td width=25%>Město:</td> <td width=55%><input type=text value='".@$_POST["mesto"]."' readonly=yes style=width:100%;text-align:center;></td>
<td width=10%>PSČ:</td><td width=10%><input type=text value='".@$_POST["psc"]."' readonly=yes style=width:55px></td></tr>
<tr><td width=25%>Okres:</td> <td width=55%>
<input type=text value='".@$_POST["okres"]."' readonly=yes style=width:100%></td>
<td width=10%>Zkratka:</td><td width=10%><input type=text value='".@$_POST["zk_okres"]."' readonly=yes style=width:55px;text-align:center;background:silver;font-weight:bold;></td></tr>
<tr><td width=25%>Kraj:</td> <td width=55%><input type=text value='".@$_POST["kraj"]."' readonly=yes style=width:100%;text-align:center;background:silver;font-weight:bold; ></td>
<td width=10%></td><td width=10%></td></tr>
<tr><td width=25%>Země:</td> <td width=55%>
<input type=text value='".@$_POST["zeme"]."' style=width:100% readonly=yes></td>
<td width=10%>Zkratka:</td><td width=10%><input type=text value='".@$_POST["zk_zeme"]."' readonly=yes style=width:55px;text-align:center;background:silver;font-weight:bold;></td></tr>
</table></td></tr>
<tr><td colspan=3 style=text-align:center;font-size:20px;><hr /><b>Kontakty</b>
<table style=width:100%;>
<tr><td width=25%>Telefon domů:</td> <td width=75%><input type=text value='".@$_POST["hometel"]."' readonly=yes style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Telefon do zam.:</td> <td width=75%><input type=text value='".@$_POST["worktel"]."' readonly=yes style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Mobil:</td> <td width=75%><input type=text value='".@$_POST["mobil"]."' readonly=yes style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Email:</td> <td width=75%><input type=text value='".@$_POST["email"]."' readonly=yes style=width:100%;text-align:center;background:#FFB0B0;></td></tr>
<tr><td width=25%>Web Stránka:</td> <td width=75%><input type=text value='".@$_POST["web"]."' readonly=yes style=width:100%;text-align:left;></td></tr>
<tr><td width=25%>Skype Kontakt:</td> <td width=75%><input type=text value='".@$_POST["skype"]."' readonly=yes style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>ICQ Kontakt:</td> <td width=75%><input type=text value='".@$_POST["icq"]."' readonly=yes style=width:100%;text-align:center;></td></tr>
</table></td></tr></table></body>";

  require "./class.phpmailer.php";
  $mail = new PHPMailer();
  $mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
  $mail->Host = "109.164.71.198";  // zadáme adresu SMTP serveru
  $mail->SMTPAuth = true;               // nastavíme true v případě, že server vyžaduje SMTP autentizaci
  $mail->Username = "admin@kliknetezde.cz";   // uživatelské jméno pro SMTP autentizaci
  $mail->Password = "lsvoboda1980";            // heslo pro SMTP autentizaci
  $mail->From = "Info@KlikneteZde.Cz";   // adresa odesílatele skriptu
  $mail->FromName = "Uživatelská Registrace KlikneteZde.Cz"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
  $mail->AddAddress (@$_POST["email"],"");
  $mail->Subject = "Registrace nového uživatele: ".@$_POST["lname"];    // nastavíme předmět e-mailu
  $mail->Body = $body;  // nastavíme tělo e-mailu




?>
<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body style="background:transparent;align:center;width:98%;height:98%;z-index:150;" >
<center><h1>Dokončení registrace nového uživatele</h1>
Děkujeme za Vaši přízeň.
<br /><br />Věříme že se Vám naše služby na stránkách budou líbit, a že jsme získali věrné stoupence,<br /> kteří nám pomohou
zkvalitňovat obsah internetu tak, aby byl ku prospěchu všech.<br /><br />
Nyní si už jen aktivujte svůj účet z formuláře, který přišel na Váš e-mail<br /> a můžete začít plně využívat veškeré možnosti, které Vám náš web nabízí.
<br /><br />Svůj registrační formulář si pečlivě uchovejte.
<br /><br />Přejeme spoustu ušetřeného času, a příjemně strávených chvil na internetu.</center>
</body>

<?




  //  $mail->WordWrap = 100;   // je vhodné taky nastavit zalomení (po 50 znacích)
  $mail->CharSet = "utf-8";   // nastavíme kódování, ve kterém odesíláme e-mail

  if(!$mail->Send()) {  // odešleme e-mail
     echo 'Došlo k chybě při odeslání e-mailu.';
     echo 'Chybová hláška: ' . $mail->ErrorInfo;
  }



} else {

?>
<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  <link rel="stylesheet" href="./css/kalendar.css" type="text/css" media="screen" />
  <script type="text/javascript" charset="iso-8859-1" src="./js/kalendar.js"></script>
  <script type="text/javascript" charset="utf-8" src="./js/kalendarcs.js"></script>
  <script type="text/javascript">
    datedit("narozen","dd.mm.yyyy",false);
  </script>

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
<?@$cykl1++;endwhile;?>
}


</script>


<style>
input[id='lpassword'],
.passwordStrengthBar {
    width: 90%;
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
?>



</head>

<body style="background:transparent;align:center;width:98%;height:98%;z-index:150;color:#000080;" >
<table margin=0 border=0 cellpadding="2" cellspacing="0" align=center width=100% height=100% style=background:transparent;align:center;>
<form name=obecne method=post>
<tr><td colspan=3 width=100% height=30px ><center><h1>Registrace nového uživatele</h1></center></td></tr><? if(@$ub=="ie") {$vyska=395;} if (@$ub=="firefox") {$vyska=400;} if (@$ub<>"ie" and @$ub<>"firefox") {$vyska=450;}?>
<tr style=vertical-align:top><td style=width:100px;vertical-align:top;align:center;text-align:center; rowspan=4><img id=obrazek src="./picture/silueta.png" width=100px><br /><input type="button" value="Nahrát své Foto" onclick="window.open('./avatar.php','Avatar','toolbar=0, directories=0, location=0, statusbar=0, menubar=0, resizable=0, scrollbars=0, titlebar=0,width=460,height=<?echo $vyska;?>')" style=width:100%;font-size:8pt;></td>
<input type=hidden id=truefoto name=truefoto value='./picture/silueta.png'>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:150px>Osoba :</td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:240px>
<select size="1" name="osoba" onchange=changeimage(this) >
	<option value='Anonym'>Anonym</option>
	<option value='Muž'>Muž</option>
	<option value='Žena'>Žena</option>
	<option value='Pár'>Pár</option>
</select></td></tr>

<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Přihlašovací Jméno:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px> <input id=lname name="lname" type="text" value="" onkeyup=checkuser(lname.value); style=width:90%;text-align:center;background:#FFB0B0;> <span id="checkuser"></span></td></tr>

<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Přihlašovací Heslo:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px> <input id=lpassword name="lpassword" type="password" value="" style=width:90%;text-align:center;background:#FFB0B0;></td></tr>
<tr><td style=vertical-align:top;align:center;text-align:left;height:28px;width:180px><b>Opakujte Heslo:</b></td>
<td style=vertical-align:top;align:center;text-align:left;height:28px;width:225px> <input id=lpassword1 name="lpassword1" type="password" value="" style=width:90%;text-align:center;background:#FFB0B0; onkeyup="checkPass(); return false;"> <span id="confirmMessageImg" class="confirmMessage"></span></td></tr>

<tr><td colspan=3 style=text-align:center;font-size:20px;><hr /><b>Osobní</b>
<table style=width:100%>
<tr><td width=25% style=font-size:8pt><b>Jméno a Příjmení:</b></td><td width=55%><input name="fullname" type="text" value="" style=width:100%;background-color:#FFB0B0;text-align:center;></td>
<td width=10%>titul:</td><td width=10%><input name="titul" type="text" value="" style=width:55px></td></tr>

<tr><td width=25% style=font-size:10pt><b>Datum Narození:</b></td> <td width=55%>
<input type="text" name="narozen" id="narozen" value="" onchange=znamenis(this.value); style=width:80%;vertical-align:top;background-color:#FFB0B0;text-align:center; /></td>
<td width=20% colspan=2 style=font-size:10pt><input id=znameni name="znameni" type="text" value="" style=width:93%;text-align:center;background:silver; readonly=yes></td></tr>

<tr><td width=25%>Ulice:</td> <td width=55%><input name="ulice" type="text" value="" style=width:100%;text-align:center;></td>
<td width=10%>Č.P.:</td><td width=10%><input name="cp" type="text" value="" style=width:55px></td></tr>

<tr><td width=25%>Město:</td> <td width=55%><input name="mesto" type="text" value="" style=width:100%;text-align:center;></td>
<td width=10%>PSČ:</td><td width=10%><input name="psc" type="text" value="" style=width:55px></td></tr>

<tr><td width=25%>Okres:</td> <td width=55%><select size="1" name="okres" style=width:100%; onchange=kraje(this);>
<option value=''></option>
<?$data1=mysql_query("select * from okresy_kraje order by okres,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
echo "<option value='".mysql_result($data1,$cykl,1)."'>".mysql_result($data1,$cykl,1)."</option>";
@$cykl++;endwhile;?></select></td>
<td width=10%>Zkratka:</td><td width=10%><input id=zk_okres name="zk_okres" type="text" value="" style=width:55px;text-align:center;background:silver;font-weight:bold; readonly=yes></td></tr>

<tr><td width=25%>Kraj:</td> <td width=55%><input id=kraj name="kraj" type="text" value="" style=width:100%;text-align:center;background:silver;font-weight:bold; readonly=yes></td>
<td width=10%></td><td width=10%></td></tr>


<tr><td width=25%>Země:</td> <td width=55%><select size="1" name="zeme" style=width:100%; onchange=zemes(this)>
<option value=''></option>
<?$data1=mysql_query("select * from zeme where zeme<>'' order by zeme,id");
$cykl=0;while(@$cykl<mysql_num_rows($data1)):
echo "<option value='".mysql_result($data1,$cykl,3)."'>".mysql_result($data1,$cykl,3)."</option>";
@$cykl++;endwhile;?></select></td>
<td width=10%>Zkratka:</td><td width=10%><input id=zk_zeme name="zk_zeme" type="text" value="" style=width:55px;text-align:center;background:silver;font-weight:bold; readonly=yes></td></tr>
</table></td></tr>

<tr><td colspan=3 style=text-align:center;font-size:20px;><hr /><b>Kontakty</b>
<table style=width:100%;>
<tr><td width=25%>Telefon domů:</td> <td width=75%><input name="hometel" type="text" value="" style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Telefon do zam.:</td> <td width=75%><input name="worktel" type="text" value="" style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Mobil:</td> <td width=75%><input name="mobil" type="text" value="" style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>Email:</td> <td width=75%><input name="email" type="text" value="@" onblur="return checkEmail(this)" style=width:100%;text-align:center;background:#FFB0B0;></td></tr>
<tr><td width=25%>Web Stránka:</td> <td width=75%><input name="web" type="text" value="http:\\" style=width:100%;text-align:left;></td></tr>
<tr><td width=25%>Skype Kontakt:</td> <td width=75%><input name="skype" type="text" value="" style=width:100%;text-align:center;></td></tr>
<tr><td width=25%>ICQ Kontakt:</td> <td width=75%><input name="icq" type="text" value="" style=width:100%;text-align:center;></td></tr>
</table></td></tr>

<tr><td align=right style=vertical-align:top colspan=3 width=100%><hr>
<table margin=0 border=0 cellpadding="0" cellspacing="0" width=100%><tr><td width=50% align=left style=color:red;><b><sup>1)</sup> barevné kolonky jsou povinné</b></td>
<td width=50% align=right><input name=tlacitko type="submit" value=" Dokončit Registraci"></td></tr></table>
</td></tr>


</form>
</table>


</body>

<script type="text/javascript" src="./js/jquery.min.js"></script>
<script type="text/javascript" src="./js/password.js"></script>

<?}?>
