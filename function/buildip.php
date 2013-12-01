<?php
include("function.php");
$Wormdb = mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
mysql_select_db ($db_name);

$result = mysql_query("SELECT * from `runtime` ORDER BY  `runtime`.`time` ASC Limit 1");
while($row = mysql_fetch_array($result)){
	$modnum=$row['uid'];
	$a=mysql_query("UPDATE `runtime` SET time='".@date('U')."' where `uid`='".$row['uid']."'");
}

echo "執行：".$modnum.'
';

$result = mysql_query("SELECT * from `dormiptable` where MOD(uid,10)=".$modnum);
                
while($row = mysql_fetch_array($result)){

	$ip=$row['ip'];
	$ip_short=str_replace("140.118.", "", $ip);
	$flow=Getflow($ip_short);
	$a=mysql_query("UPDATE `dormiptable` SET  `flow`='".$flow."',time='".@date('U')."' where `ip`='".$ip."'");
	echo $ip." => flow=".$flow.'
';
}
?>