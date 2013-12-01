<?php

$start_time=date('U');

include(dirname(__FILE__)."function.php");
$Wormdb = mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
mysql_select_db ($db_name);


$FlowData=array("");
array_pop($FlowData);


$threads=4;//how many threads per cycle
$buffer=30;//ip per request

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
			array_push($FlowData, array($flow,$ip));
			echo "[Flow Got!] thread:".($modnum+1).'/'.$threads." ".$ip_counti."/".$ip_counttotal." ".$ip." => flow=".$flow.$crlf;
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
	array_push($FlowData, array($flow,$ip));
	echo "[Flow Got!] thread:".($modnum+1).'/'.$threads." ".$ip_counti."/".$ip_counttotal." ".$ip." => flow=".$flow.$crlf;
	$ip_counti++;

}


$ip_counti=1;
$flowsql="";
//all data into mysql
while(count($FlowData)>0){
	$flow=array_pop($FlowData);
	$flowsql.="UPDATE `dormiptable` SET  `flow`='".$flow[0]."',time='".@date('U')."' where `ip`='".$flow[1]."';";
	echo "[SQL WriteFile] thread:".($modnum+1).'/'.$threads." ".$ip_counti."/".$ip_counttotal." ".$flow[1]." => flow=".$flow[0].$crlf;
	$ip_counti++;
}

file_put_contents("tmp", $flowsql, FILE_APPEND);



echo "done. total takes ".(date('U')-$start_time)."s".$crlf;
?>