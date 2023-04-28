<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php

$dness = Date("Ymd");

//save
if (@$_POST["saveds"]=="save"){$data1=mysql_query("select * from nastroje order by poradi");$nastroje=",";@$cykl=0;while(@$cykl<mysql_num_rows(@$data1)):
if (@$_POST["vybrano".mysql_result($data1,$cykl,1)]=="on"){$nastroje.=mysql_result($data1,$cykl,1).",";}
@$cykl++;endwhile;
mysql_query("update registrace set nastroje18='".securesql($nastroje)."' where lnamed='".securesql($_SESSION["lnamed"])."'");$nastroje="";}
// endsave

    $u_agent = $_SERVER['HTTP_USER_AGENT'];$ub = '';
    if(preg_match('/MSIE/i',$u_agent)) {$ub = "ie";}
    elseif(preg_match('/Firefox/i',$u_agent)) {$ub = "firefox";}
    elseif(preg_match('/Safari/i',$u_agent)) {$ub = "safari";}
    elseif(preg_match('/Chrome/i',$u_agent)) {$ub = "chrome";}
    elseif(preg_match('/Flock/i',$u_agent)) {$ub = "flock";}
    elseif(preg_match('/Opera/i',$u_agent)) {$ub = "opera";}

?>
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

<script type="text/JavaScript">
function doScroll(){
  if (window.name) window.scrollTo(0, window.name);
}
</script>
</head>

<body style="background:transparent;align:center;width:98%;height:98%;z-index:150;vertical-align:top" onload="doScroll()" onunload="window.name=document.body.scrollTop">
<table margin=0 border=0 cellpadding="2" cellspacing="0" align=center width=100% height=100% style=background:transparent;align:center;vertical-align:top;>
<form name=nastroje method=post>

<?// kontrola souhlasu s erotikou
$loginfo=mysql_query("select * from registrace where lnamed='".securesql($_SESSION["lnamed"])."' ");
if (mysql_result($loginfo,0,33)=="ANO") {

// kontrola datumu nar.
if (str_replace("-","",mysql_result($loginfo,0,6))>date("Ymd",strtotime(" - 18 year"))) {?><script>alert('Opravte si datum narození! \n\nDle datumu narození Vám ještě není 18 let!\n\nModuly s erotickým obsahem Vám mohou být zablokovány!');</script><?}


?><input name="saveds" type="hidden" value="save">
<?$nastroje=mysql_result(mysql_query("select nastroje18 from registrace where lnamed='".securesql($_SESSION["lnamed"])."'"),0,0);
$data1=mysql_query("select * from tool_groups where after18='ANO' order by nazev,id");
$cykl=0;while (@$cykl<mysql_num_rows($data1)):

echo "<tr style=vertical-align:top height=10px><td width=100% align=center vertical-align=top><h3 style=vertical-align:top;margin:0;cellpadding:0;cellspacing:0; >".mysql_result($data1,$cykl,1)."</h3></td></tr>";
echo "<tr style=vertical-align:top><td ><table border=0 style=vertical-align:top;margin:0;cellpadding:0;cellspacing:5; ><tr style=vertical-align:top>";

	$data2=mysql_query("select * from nastroje where group_name='".securesql(mysql_result($data1,$cykl,1))."' order by nazev,id");
	$cykl2=0;while (@$cykl2<mysql_num_rows($data2)):

		echo"<td align=center><h5 style=vertical-align:top;margin:0;cellpadding:0;cellspacing:0; >".mysql_result(@$data2,$cykl2,2)."<input name=vybrano".mysql_result(@$data2,$cykl2,1)." type=checkbox ";if (StrPos (" " . $nastroje, ",".mysql_result(@$data2,$cykl2,1).",")) {echo " checked ";} echo "onclick=submit(this)></h5><br /><img src=./admin/hidikona.php?id=".mysql_result(@$data2,$cykl2,1)."></td>";

	$cykl2++;endwhile;
	echo"</tr></table>";if ((@$cykl+1)<mysql_num_rows($data1)) {echo"<hr>";}echo"</td></tr>";

@$cykl++;endwhile;

} else {?><script type="text/JavaScript">
if (confirm("Stisknutím tlačítka 'OK' potvrzuji, že:\n\n1.je mi více než 18 let a že jsem dosáhl zletilosti;\n2.pokud se nacházím ve státě, ve kterém je hranice zletilosti stanovena odlišně od předpisů České republiky, potvrzuji, že splňuji veškeré podmínky zletilosti v daném státě a že je mi více než 18 let\n    a že vstup na tyto stránky není omezen a/nebo zakázán předpisem státu, v němž se nacházím a/nebo jehož jsem státním příslušníkem;\n3.souhlasím s tím, že sexuálně orientovaný materiál jsem oprávněn užívat jen v soukromí, a to výlučně pro svou osobní potřebu;\n4.souhlasím také s tím, že veškerý materiál v této sekci podléhá autorskému zákonu a bez souhlasu autora jej nesmím šířit, a to ani části;\n5.sexuálně orientované materiály mne neurážejí, nepohoršují a/nebo jinak neohrožují a do uvedené sekce vstupuji dobrovolně;\n6.neposkytnu a ani přímo či nepřímo neumožním přístup do této sekce osobám mladším 18 let ani jiným osobám, které nesplňují podmínky uvedené v tomto prohlášení.\nPokud nesplňujete byť i jen jednu podmínku uvedenou pod body 1 až 6, opusťte prosím ihned tuto sekci.\nPokud splňujete všechny podmínky uvedené pod body 1 až 6, jste oprávnění vstoupit.\n\nSouhlasím a potvrzuji výše uvedené")) {window.open("./souhlas.php","","toolbar=0,fullscreen=0, width=300, height=100, directories=0, location=0, status=0, menubar=0, resizable=0, scrollbars=0, titlebar=0");
<?if ($ub=="ie") {?>window.location.href("<?echo $_SERVER['HTTP_REFERER'];?>");<?} else {?>window.location.assign("<?echo $_SERVER['HTTP_REFERER']."?";?>");<?}?>
} else {<?if ($ub=="ie") {?>window.location.href("<?echo $_SERVER['HTTP_REFERER'];?>");<?} else {?>window.location.assign("<?echo $_SERVER['HTTP_REFERER']."?";?>");<?}?>
}

</script>
<?}?>




</form>
</table>
</body>