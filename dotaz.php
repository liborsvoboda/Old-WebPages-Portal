<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body style="align:center;text-align:center;color:#000080;background:transparent;width:100%;margin:0px;padding-top:0px;"><center>
<?php
//$adr=explode("/",$_SERVER['REQUEST_URI']);
if (!@$_REQUEST["FCKeditor1"]) {?>
<form method=POST>
<span><h1>Napište Nám</h1></span>
<table margin=0 border=0 cellpadding="0" cellspacing="0" width=690px style=background:transparent;>
<tr><td colspan=3 style=height:450px;>
<?include("./admin/fckeditor/fckeditor.php") ;
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = '/admin/fckeditor/' ;
$oFCKeditor->ToolbarSet ='Basic';
$oFCKeditor->Height ='450px';
$oFCKeditor->Value = "Zde napište svůj dotaz...";
$oFCKeditor->Create() ;?>
</td></tr>
<tr><td colspan=3 width=690px><input type="text" name="adresa" style="width:100%;color:#000080;filter:alpha(opacity=65); -moz-opacity:0.65;opacity:0.65; -khtml-opacity:0.65;resize:none;" value="Zde napište svůj e-mail" onClick=select() /></td></tr>
<tr><td rowspan=2 width=428px><img id="siimage" align=left style="vertical-align:top;padding-right: 0px;filter:alpha(opacity=65); -moz-opacity:0.65; opacity:0.65; -khtml-opacity:0.65;" border=0 src="./captcha/securimage_show.php?sid=<?echo md5(time());?>"/></td>
<td width=24px><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="24" height="24" id="SecurImage_as3" align="middle">
			    <param name="allowScriptAccess" value="sameDomain" />
			    <param name="allowFullScreen" value="false" />
			    <param name="movie" value="./captcha/securimage_play.swf?audio=./captcha/securimage_play.php?&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
			    <param name="quality" value="high" />
			    <param name="bgcolor" value="#ffffff" />
			    <embed src="./captcha/securimage_play.swf?audio=./captcha/securimage_play.php?&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="24" height="24" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			  </object></td><td width=238px><input type="text" name="code" style="width:100%;text-align:center;color:#000080;filter:alpha(opacity=65);-moz-opacity:0.65;opacity:0.65;-khtml-opacity:0.65;resize:none;" value="Sem opište kód" onClick=select() /></td></tr>
			  <tr><td width=24px><a tabindex="-1" style="border-style: none" href="" title="Refresh Image" onclick="document.getElementById('siimage').src ='./captcha/securimage_show.php?sid=' + Math.random(); return false"><img src="./captcha/images/refresh.png" alt="Reload Image" border="0" width="24" height="24" onclick="this.blur()" align="bottom" /></a></td>
<td width=238px><input type="submit" value="Odeslat Zprávu" style=width:100%></td></tr></table></form>
<?php
} else {
  include ("./captcha/securimage.php");
  $img = new Securimage();
  $valid = $img->check($_REQUEST["code"]);

  if($valid == true) {
  include "./class.phpmailer.php";
  $mail = new PHPMailer();
  $mail->IsSMTP();  // k odeslání e-mailu použijeme SMTP server
  $mail->Host = "109.164.71.198";  // zadáme adresu SMTP serveru
  $mail->SMTPAuth = true;               // nastavíme true v případě, že server vyžaduje SMTP autentizaci
  $mail->Username = "admin@kliknetezde.cz";   // uživatelské jméno pro SMTP autentizaci
  $mail->Password = "lsvoboda1980";            // heslo pro SMTP autentizaci
  $mail->From = "info@kliknetezde.cz";   // adresa odesílatele skriptu
  $mail->FromName = "Info KlikneteZde.Cz"; // jméno odesílatele skriptu (zobrazí se vedle adresy odesílatele)
  $mail->AddAddress("postmaster@kliknetezde.cz","Rychlá Zpráva");
  $mail->Subject = "Rychlá zpráva ze stránek KlikneteZde.cz";    // nastavíme předmět e-mailu
  $mail->Body ="Nová Zpráva od: ".@$_REQUEST["adresa"]."\r\n".@$_REQUEST["FCKeditor1"];
  $mail->WordWrap = 300;   // je vhodné taky nastavit zalomení (po 50 znacích)
  $mail->CharSet = "utf-8";   // nastavíme kódování, ve kterém odesíláme e-mail

  if(!$mail->Send()) { // odešleme e-mail
    // echo 'Došlo k chybě při odeslání e-mailu.';?><br /><?
  echo 'Chybová hláška: ' . $mail->ErrorInfo; } else {?>
<form method=POST>
<span><h1>Napište Nám</h1></span>
<table margin=0 border=0 cellpadding="0" cellspacing="0" width=690px>
<tr><td colspan=3 style=height:450px;>
<?include("./admin/fckeditor/fckeditor.php") ;
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = '/admin/fckeditor/' ;
$oFCKeditor->ToolbarSet ='Basic';
$oFCKeditor->Height ='450px';
$oFCKeditor->Value = "Zde napište svůj dotaz...";
$oFCKeditor->Create() ;?>
</td></tr>
<tr><td colspan=3><input type="text" name="adresa" style="width:690px;color:#000080;filter:alpha(opacity=65); -moz-opacity:0.65;opacity:0.65; -khtml-opacity:0.65;resize:none;" value="Zde napište svůj e-mail" onClick=select() /></td></tr>
<tr><td rowspan=2 width=428px><img id="siimage" align=left style="vertical-align:top;padding-right: 0px;filter:alpha(opacity=65); -moz-opacity:0.65; opacity:0.65; -khtml-opacity:0.65;" border=0 src="./captcha/securimage_show.php?sid=<?echo md5(time());?>"/></td>
<td width=24px><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="24" height="24" id="SecurImage_as3" align="middle">
			    <param name="allowScriptAccess" value="sameDomain" />
			    <param name="allowFullScreen" value="false" />
			    <param name="movie" value="./captcha/securimage_play.swf?audio=./captcha/securimage_play.php?&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
			    <param name="quality" value="high" />
			    <param name="bgcolor" value="#ffffff" />
			    <embed src="./captcha/securimage_play.swf?audio=./captcha/securimage_play.php?&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="24" height="24" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			  </object></td><td width=238px><input type="text" name="code" style="width:100%;text-align:center;color:#000080;filter:alpha(opacity=65); -moz-opacity:0.65;opacity:0.65; -khtml-opacity:0.65;resize:none;" value="Sem opište kód" onClick=select() /></td></tr>
			  <tr><td width=24px><a tabindex="-1" style="border-style: none" href="" title="Refresh Image" onclick="document.getElementById('siimage').src ='./captcha/securimage_show.php?sid=' + Math.random(); return false"><img src="./captcha/images/refresh.png" alt="Reload Image" border="0" width="24" height="24" onclick="this.blur()" align="bottom" /></a></td>
<td width=238px><input type="submit" value="Odeslat Zprávu" style=width:100%></td></tr></table>
</form><script>alert("Vaše zpráva nám byla úspěšně odeslána. \nDěkujeme za Váš zájem, kontaktovat Vás budeme co možná nejdříve. ");</script>
<?}} else {?>
<form method=POST>
<span><h1>Napište Nám</h1></span>
<table margin=0 border=0 cellpadding="0" cellspacing="0" width=690px>
<tr><td colspan=3 style=height:450px;>
<?include("./admin/fckeditor/fckeditor.php") ;
$oFCKeditor = new FCKeditor('FCKeditor1') ;
$oFCKeditor->BasePath = '/admin/fckeditor/' ;
$oFCKeditor->ToolbarSet ='Basic';
$oFCKeditor->Height ='450px';
$oFCKeditor->Value = stripslashes( $_POST['FCKeditor1'] );
$oFCKeditor->Create() ;?>
</td></tr>
<tr><td colspan=3><input type="text" name="adresa" style="width:690px;color:#000080;filter:alpha(opacity=65); -moz-opacity:0.65;opacity:0.65; -khtml-opacity:0.65;resize:none;" value="<?echo @$_REQUEST["adresa"];?>"/></td></tr>
<tr><td rowspan=2 width=428px><img id="siimage" align=left style="vertical-align:top;padding-right: 0px;filter:alpha(opacity=65); -moz-opacity:0.65; opacity:0.65; -khtml-opacity:0.65;" border=0 src="./captcha/securimage_show.php?sid=<?echo md5(time());?>"/></td>
<td width=24px><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="24" height="24" id="SecurImage_as3" align="middle">
			    <param name="allowScriptAccess" value="sameDomain" />
			    <param name="allowFullScreen" value="false" />
			    <param name="movie" value="./captcha/securimage_play.swf?audio=./captcha/securimage_play.php?&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
			    <param name="quality" value="high" />
			    <param name="bgcolor" value="#ffffff" />
                <embed src="./captcha/securimage_play.swf?audio=./captcha/securimage_play.php?&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="24" height="24" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			  </object></td><td width=238px><input type="text" name="code" style="width:100%;background:#F72B30;text-align:center;color:#000080;filter:alpha(opacity=65); -moz-opacity:0.65;opacity:0.65; -khtml-opacity:0.65;resize:none;" value="Chybný kód" onClick=select() /></td></tr>
			  <tr><td width=24px><a tabindex="-1" style="border-style: none" href="" title="Refresh Image" onclick="document.getElementById('siimage').src ='./captcha/securimage_show.php?sid=' + Math.random(); return false"><img src="./captcha/images/refresh.png" alt="Reload Image" border="0" width="24" height="24" onclick="this.blur()" align="bottom" /></a></td>
<td width=238px><input type="submit" value="Odeslat Zprávu" style=width:100%></td></tr></table>
</form><?}
}

?></center></body>

