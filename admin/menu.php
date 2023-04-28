<center><table border=1 ><tr border=1 align=center>
<?
@$hlavicka1=mysql_query("select * from menu order by poradi");
while (@$vypis< mysql_num_rows(@$hlavicka1)):
?>
<td bgcolor=#C6A26C align=center style=vertical-align:top><img src="./picture/delete.png" width=20px alt="Odstranit Menu: <?echo mysql_result($hlavicka1,$vypis,2);?>" border="0" style="cursor: pointer;" onClick="if(confirm('Chcete skutečně Menu:  <?echo mysql_result($hlavicka1,$vypis,2)." ".mysql_result($hlavicka1,$vypis,1);?> Odstranit?')) window.location.assign('./index.php?menu=<? echo base64_encode('Odstranit Položku Menu')?>&poradi=<? echo base64_encode(mysql_result($hlavicka1,$vypis,2));?>');"><br />
<input type="button" onclick="window.location.assign('./index.php?poradi=<?echo base64_encode(mysql_result($hlavicka1,$vypis,2));?>&nazev=<?echo base64_encode(mysql_result($hlavicka1,$vypis,1));?>&menu=<?echo base64_encode('Upravit Obsah Menu');?>')" value="<?echo mysql_result($hlavicka1,$vypis,2)." ".mysql_result($hlavicka1,$vypis,1);?>">

<?
if (mysql_result($hlavicka1,$vypis,7)=="ANO") {?><br /><br /><b>SUBMENU</b><br /><?
@$id=mysql_result($hlavicka1,$vypis,0);@$data2=mysql_query("select * from submenu where id_menu='$id' order by poradi");@$write=0;
while (@$write<mysql_num_rows(@$data2)):
?><table width=100% border=0px cellpadding="0" cellspacing="0"><tr><td align=left><input type="button" value="<?echo mysql_result($data2,$write,2)." ".mysql_result($data2,$write,3);?>" onclick="window.location.assign('./index.php?idsub=<?echo base64_encode(mysql_result($data2,$write,0));?>&menu=<?echo base64_encode('Upravit Obsah SubMenu');?>')" ></td>
<td align=right><img src="./picture/delete.png" width=20px alt="Odstranit Menu: <?echo mysql_result($data2,$write,2);?>" border="0" style="cursor: pointer;" onClick="if(confirm('Chcete skutečně SubMenu:  <?echo mysql_result($data2,$write,2)." ".mysql_result($data2,$write,3);?> Odstranit?')) window.location.assign('./index.php?submenu=<? echo base64_encode('Odstranit Položku SubMenu')?>&idsub=<? echo base64_encode(mysql_result($data2,$write,0));?>');"></td></tr></table>
<?
@$write++;endwhile;

}?></td><?
@$vypis++;endwhile;
?>
</tr></table></center>

