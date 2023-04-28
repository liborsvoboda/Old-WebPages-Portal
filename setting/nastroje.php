<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
//save
if (@$_POST["saved"]=="save"){$data1=mysql_query("select * from nastroje order by poradi");$nastroje=",";@$cykl=0;while(@$cykl<mysql_num_rows(@$data1)):
if (@$_POST["vybrano".mysql_result($data1,$cykl,1)]=="on"){$nastroje.=mysql_result($data1,$cykl,1).",";}
@$cykl++;endwhile;
mysql_query("update registrace set nastroje='".securesql($nastroje)."' where lnamed='".securesql($_SESSION["lnamed"])."'");$nastroje="";}
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

<body style="background:transparent;align:center;width:98%;height:98%;z-index:150;" onload="doScroll()" onunload="window.name=document.body.scrollTop">
<table margin=0 border=0 cellpadding="2" cellspacing="0" align=center width=100% height=100% style=background:transparent;align:center;>
<form name=nastroje method=post><input name="saved" type="hidden" value="save">
<?$nastroje=mysql_result(mysql_query("select nastroje from registrace where lnamed='".securesql($_SESSION["lnamed"])."'"),0,0);
$data1=mysql_query("select * from tool_groups where after18='NE' order by nazev,id");
$cykl=0;while (@$cykl<mysql_num_rows($data1)):

echo "<tr style=vertical-align:top height=10px><td width=100% align=center vertical-align=top><h3 style=vertical-align:top;margin:0;cellpadding:0;cellspacing:0; >".mysql_result($data1,$cykl,1)."</h3></td></tr>";
echo "<tr style=vertical-align:top><td><table border=0 style=vertical-align:top;margin:0;cellpadding:0;cellspacing:5;  ><tr>";

	$data2=mysql_query("select * from nastroje where group_name='".securesql(mysql_result($data1,$cykl,1))."' order by nazev,id");
	$cykl2=0;while (@$cykl2<mysql_num_rows($data2)):

		echo"<td align=center><h5 style=vertical-align:top;margin:0;cellpadding:0;cellspacing:0; >".mysql_result(@$data2,$cykl2,2)."<input name=vybrano".mysql_result(@$data2,$cykl2,1)." type=checkbox ";if (StrPos (" " . $nastroje, ",".mysql_result(@$data2,$cykl2,1).",")) {echo " checked ";} echo "onclick=submit(this)></h5><br /><img src=./admin/hidikona.php?id=".mysql_result(@$data2,$cykl2,1)."></td>";




	$cykl2++;endwhile;
	echo"</tr></table>";if ((@$cykl+1)<mysql_num_rows($data1)) {echo"<hr>";}echo"</td></tr>";

@$cykl++;endwhile;

?>


</table>


</form>
</table>
</body>

