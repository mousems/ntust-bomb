<?php
$db_host = ("127.0.0.1");
$db_user = ("ntustbomb");
$db_pass = ("YjNXXsMxNdSDqW4Z");
$db_name = ("ntustbomb");
$crlf = '
';

function Check118($ip){
	return preg_match("/140.118.[0-9]{1,3}[.][0-9]{1,3}/","140.118.".$ip);
}
function Check118dorm($ip){
	return preg_match("/d([1-3])-([0-9]{4})-([1-6]).dorm.ntust.edu.tw/", gethostbyaddr("140.118.".$ip));
}
function GetDormStr($ip){ //第X宿舍X房X床
	if(!Check118($ip)){
		return 0;
	}else{
		preg_match("/d([1-3])-([0-9]{4})-([1-6]).dorm.ntust.edu.tw/", gethostbyaddr("140.118.".$ip), $matches);
		return "第".$matches[1]."宿舍".$matches[2]."房".$matches[3]."床\n";
	}
}
function Getflow($ip){
	if(!Check118($ip)){
		return 0;
	}else{
		$flow=file_get_contents("http://140.118.34.204/getflow.php?ip=140.118.".$ip);
		return $flow;
	}
}

//input ip array , output flow array
function Getflow_many($iparray){
	$getdata="";
	while(count($iparray)>1){
		$getdata.=array_pop($iparray).",";
	}
	if(count($iparray)==1){
		$getdata.=array_pop($iparray);	
	}

	$flow=file_get_contents("http://140.118.127.30/getflow.php?ip=".$getdata);
	$flow=json_decode($flow);
	return $flow;
}



function getAddrByHost($host, $timeout = 5) {
  $returnString = '';
  $query = `nslookup -timeout=$timeout -retry=1 $host`;
  if (preg_match('/\nAddress: (.*)\n/', $query, $matches)){
    $returnString = trim($matches[1]);
  }
  return $returnString;

}
function get2digit($num){
	if($num<10){
		return '0'.$num;
	}else{
		return $num;
	}

}


//echo getAddrByHost("D1-0117-1.dorm.ntust.edu.tw");
?>
