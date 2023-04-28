<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">


<?
if (@$_POST["tlacitko"] and @$_FILES['foto']['tmp_name']) {
include("./admin/dbconnect.php");include("./admin/knihovna.php");$dnes = Date("Y-m-d")." ".StrFTime("%H:%M:%S", Time());
@$docasny = @$_FILES['foto']['tmp_name'];@$mime = @$_FILES['foto']['type'];@$obsah = implode('', file("$docasny"));resizeimage($docasny,"100","0");@$obsah1 = implode('', file("$docasny"));
mysql_query ("insert into fototemp (snimek,snimeksmal,mime,datumvkladu)VALUES('".mysql_escape_string($obsah)."','".mysql_escape_string($obsah1)."','".securesql($mime)."','".$dnes."')")or Die(MySQL_Error());
$id=mysql_insert_id();
mysql_query("delete from fototemp where datumvkladu<'".date("Y-m-d",strtotime("-1 day"))." ".StrFTime("%H:%M:%S", Time())."'")or Die(MySQL_Error());
}?>

<script type="text/javascript">
function closeWindow() {
     var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;
     if (ie7)
           {           window.opener.GetFotoId(<?echo @$id;?>);
           window.close();
           }     else   {
           this.focus();
           self.opener.GetFotoId(<?echo @$id;?>);
           self.opener = this;
           self.close();
           }
}
</script>

</head>



<body style=background:silver;color:#000080;margin:0px;padding:0;align:center;text-align:center; <?if (@$_POST["tlacitko"]){echo "onload='closeWindow();'";}?> >
<h3>Vložení Profilové Fotky / Avatara</h3><form method="POST" enctype="multipart/form-data">
<input name="foto" type="file" value="" style=width:80% ><input name=tlacitko type="submit" value="Vložit Foto" style=width:20%;font-size:12><br />

<div style=width:100%;background:#EAEAEA;font-size:10pt;color:blue>Upravit vaše foto na avatara lze tímto programem
<?include "./avatar/avatar.html";?></div></form></body>