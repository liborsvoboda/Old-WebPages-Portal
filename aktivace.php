<head>
<meta http-equiv="Content-language" content="cs">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body><?

if (@$_GET["kod"]){
include("./admin/knihovna.php");

if (mysql_num_rows($aktivace)==1 and mysql_result($aktivace,0,25)=='NE') {
?>
<script>
alert("Vítejte <?echo mysql_result($aktivace,0,4)." ".mysql_result($aktivace,0,5);?>. Vaše aktivace účtu proběhla úspěšně. Nyní se přihlašte.");
window.location.href('http://www.kliknetezde.cz');
</script><?}

if (mysql_num_rows($aktivace)==1 and mysql_result($aktivace,0,25)=='ANO') {?>
<script>
alert("Vítejte <?echo mysql_result($aktivace,0,4)." ".mysql_result($aktivace,0,5);?>. Váš účet je již aktivován. Nyní se přihlašte.");
window.location.href('http://www.kliknetezde.cz');
</script>
<?}

if (mysql_num_rows($aktivace)==0) {?>
<script>
alert("Toto je nekorektní pokus o aktivaci účtu. Bude vyhodnocen a v případě ohrožení bezpečnosti bude vaše IP adresa pro naše stránky zablokována.");
window.location.href('http://www.bsa.org');
</script>
<?}

</body>