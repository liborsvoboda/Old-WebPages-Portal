<?session_start();
session_register("lnamed");
include("./admin/dbconnect.php");
include("./admin/knihovna.php");
mysql_query("update registrace set alt18='ANO',alt18date='".date('Y-m-d H:i:s')."' where lnamed='".securesql($_SESSION["lnamed"])."'") or Die(MySQL_Error());
?>
<head>
<meta name="google-site-verification" content="XSq8LlGyJ4Z2m6oiiDUDuv6cjIvBfbru6-p9kQahunI" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link rel="icon" href='<?echo mysql_result(mysql_query("select hodnota from setting where nazev='url'"),0,0);?>/favicon.ico' type="image/x-icon">
<link rel="shortcut icon" href='<?echo mysql_result(mysql_query("select hodnota from setting where nazev='url'"),0,0);?>/favicon.ico' type="image/x-icon">
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head><body margin=0><?echo"<center>Počkejte Prosím...<br />Povoluji zónu s erotickým obsahem...<br /><img src=./picture/loading1.gif border=0></center>";?>
<script type="text/javascript">
function closew(){
     var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;
     if (ie7)
           {
           window.open('','_parent','');
           window.close();
           }     else   {
           this.focus();
           self.opener = this;
           self.close();
           }}

setTimeout(closew,3000);
</script>
</body>

