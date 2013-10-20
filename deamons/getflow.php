<?php
function printout($type , $string){
	 echo "[".date("Y/m/d H:i:s")."] ".$type.":".$string.'
';
}


include("../function.php");

$datea=date("U");

while (date("U")<$datea+30) {
	printout('info' , "sleeping...");
	sleep(10);
	continue;
}









?>