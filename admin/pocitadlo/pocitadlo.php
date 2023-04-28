<?
// zobrazeni pocitadla
  @$cislo = mysql_query("select Id from pocitadlo order by Id");
  @$numb = mysql_num_rows(@$cislo);          // pocet zaznamu
  @$cislop = mysql_result(@$cislo,$numb-1,0);
  $cislou=strlen($cislop);

@$dneska = mysql_num_rows(mysql_query("select id from pocitadlo where `Datum` = '$dnesnidatum'"));

?><table border=0 cellpadding="0" cellspacing="0" style="border-collapse: collapse" title="Pro zobrazení grafů klikněte" onclick="window.open('pocitadlo/pocitadlografy.php','window','width=822,height=800,scrollbars') ;return false;"><tr style="cursor:pointer;"><td><?
$cy=0;while ($cy <9) :
if ($cislou >$cy) {
if ($cislop[$cy]==1) {?><IMG src="pocitadlo/picture/1.jpg"><?}
if ($cislop[$cy]==2) {?><IMG src="pocitadlo/picture/2.jpg"><?}
if ($cislop[$cy]==3) {?><IMG src="pocitadlo/picture/3.jpg"><?}
if ($cislop[$cy]==4) {?><IMG src="pocitadlo/picture/4.jpg"><?}
if ($cislop[$cy]==5) {?><IMG src="pocitadlo/picture/5.jpg"><?}
if ($cislop[$cy]==6) {?><IMG src="pocitadlo/picture/6.jpg"><?}
if ($cislop[$cy]==7) {?><IMG src="pocitadlo/picture/7.jpg"><?}
if ($cislop[$cy]==8) {?><IMG src="pocitadlo/picture/8.jpg"><?}
if ($cislop[$cy]==9) {?><IMG src="pocitadlo/picture/9.jpg"><?}
if ($cislop[$cy]==0) {?><IMG src="pocitadlo/picture/0.jpg"><?}
}
$cy++;
endwhile;

?></td></tr></table>