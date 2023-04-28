<SCRIPT style="text/javascript">
function size(){
document.write('<form name=v method=post><input type=hidden name=vyska value="'+document.body.offsetHeight+'"><input type=hidden name=sirka value="'+document.body.offsetWidth+'"></form>');document.v.submit();
}
function sizepost(){
document.write('<input type=hidden name=vyska value="'+document.body.offsetHeight+'"><input type=hidden name=sirka value="'+document.body.offsetWidth+'">');
}

function sizeget(){
document.write('&vyska='+document.body.offsetHeight+'&sirka='+document.body.offsetWidth);
}
</SCRIPT>