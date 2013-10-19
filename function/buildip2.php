<?php

$start_time=date('U');

include("function.php");
$Wormdb = mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
mysql_select_db ($db_name);

function UpdateFlowData($flow , $ip){

	$a=mysql_query("UPDATE `dormiptable` SET  `flow`='".$flow."',time='".@date('U')."' where `ip`='".$ip."'");

}

$threads=2;//how many threads per cycle
$buffer=35;//ip per request

//select a thread
$result = mysql_query("SELECT * from `runtime` WHERE `uid`<'".$threads."' ORDER BY  `runtime`.`time` ASC Limit 1");
while($row = mysql_fetch_array($result)){
	$modnum=$row['uid'];
	$a=mysql_query("UPDATE `runtime` SET time='".@date('U')."' where `uid`='".$row['uid']."'");
}



echo "now running thread:".($modnum+1).'/'.$threads.$crlf;


//select all ip from a thread
$result = mysql_query("SELECT * from `dormiptable` where MOD(uid,".$threads.")=".$modnum);


// build a null array
$iparray=array(null);
array_pop($iparray);

//get total counts
$ip_counttotal = mysql_query("SELECT COUNT(*) as counta from `dormiptable` where MOD(uid,".$threads.")=".$modnum);
while($row = @mysql_fetch_array($ip_counttotal)){
	$ip_counttotal = $row['counta'];
}
$ip_counti=1;


while($row = mysql_fetch_array($result)){

	$ip=$row['ip'];
	$ip_short=str_replace("140.118.", "", $ip);


	array_push($iparray, $ip_short);

	if(count($iparray)==$buffer){
		
		echo "so far we takes ".(date('U')-$start_time)."s".$crlf;
		echo "Getting flows...";



		$flows_start_time=date('U');
		$flows=Getflow_many($iparray);
		echo (date('U')-$flows_start_time)."s".$crlf;


		for($i=0; $i<$buffer; $i++){

			$flow=$flows[$i]->flow;
			$ip="140.118.".$flows[$i]->ip;
			UpdateFlowData($flow , $ip);
			echo "thread:".($modnum+1).'/'.$threads." ".$ip_counti."/".$ip_counttotal." ".$ip." => flow=".$flow.$crlf;
			$ip_counti++;


		}


		$iparray=array(null);
		array_pop($iparray);



	}



}


echo "Getting flows...".$crlf;
$flows_start_time=date('U');
$flows=Getflow_many($iparray);
echo (date('U')-$flows_start_time)."s".$crlf;
for($i=0; $i<count($iparray); $i++){

	$flow=$flows[$i]->flow;
	$ip="140.118.".$flows[$i]->ip;
	UpdateFlowData($flow , $ip);
	echo "thread:".($modnum+1).'/'.$threads." ".$ip_counti."/".$ip_counttotal." ".$ip." => flow=".$flow.$crlf;
	$ip_counti++;

}

echo "done. total takes ".(date('U')-$start_time)."s".$crlf;
?>