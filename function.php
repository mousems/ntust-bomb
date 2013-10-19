<?php
$office_server="140.118.34.204";
$db_host = "127.0.0.1";
$db_user = "ntustbomb";
$db_pass = "YjNXXsMxNdSDqW4Z";
$db_name = "ntustbomb";
$appId="518849124871148";
$secret="1a303aadbf7b0b51d1feeb6bfabc9a76";
$crlf = '
';

include("converter.class.php");

include ( "NexmoMessage.php" );


function log_do ($uid , $log , $kind){
	global $db_host, $db_name, $db_user, $db_pass;
	
	$Wormdb = @mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
	mysql_select_db ($db_name);
	$log=mysql_real_escape_string($log);
	$d = mysql_query('INSERT INTO `log` (`time`,`uid`,`log`,`kind`)VALUES ("'.date('U').'","'.$uid.'","'.$log.'","'.$kind.'")');
}


function nexmo_conv( $string )
{
	$conv = new converter;
	$string = $conv->convert('UTF','BIG', $string);
	$string = $conv->convert('BIG','GB', $string);
	$string = iconv('GBK', 'UTF-8//IGNORE', $string);
	$string = urlencode($string);
	return $string;
}
function sendvoice($to , $text , $uid=0){
	$to=phone_regex($to);
	$text=nexmo_conv($text);
	$url="https://rest.nexmo.com/tts/json?api_key=641a3794&api_secret=cba9477f&to=".$to."&text=".$text."&lg=zh-cn";
	$log=print_r(file_get_contents($url),true);
	log_do($uid,print_r($log,true),"call");
	return ($log);

}


//return object
function sendmessage($to , $text , $uid=0){

	$nexmo_sms = new NexmoMessage('641a3794' ,'cba9477f');

	$to=phone_regex($to);
	
	$log= $nexmo_sms->sendText( $to ,"ntustbomb" ,$text );
	log_do($uid,print_r($log,true),"sms");
	return print_r($log,true);

}

function phone_regex($to){


			if(preg_match("/0([0-9]{9})/", $to, $matches)){
				$to="+886".$matches[1];
			}
			if(preg_match("/(\+886[0-9]{9})/", $to, $matches)){
				$to=$matches[1];
			}
			if(preg_match("/^([0-9]{9})/", $to, $matches)){
				$to="+886".$matches[1];
			}


			return $to;
}


function Check118($ip){
	return preg_match("/140.118.[0-9]{1,3}[.][0-9]{1,3}/",$ip);
}
function Check118dorm($ip){
	return preg_match("/d([1-3])-([0-9]{4})-([1-6]).dorm.ntust.edu.tw/", gethostbyaddr($ip));
}
function GetDormStr($ip){ //第X宿舍X房X床
	if(!Check118($ip)){
		return 0;
	}else{
		preg_match("/d([1-3])-([0-9]{4})-([1-6]).dorm.ntust.edu.tw/", gethostbyaddr($ip), $matches);
		return "第".$matches[1]."宿舍".$matches[2]."房".$matches[3]."床\n";
	}
}
function Getflow($ip){
	if(!Check118($ip)){
		return 0;
	}else{
		$flow=file_get_contents("http://".$office_server."/getflow.php?ip=".$ip);
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

	$flow=file_get_contents("http://".$office_server."/getflow.php?ip=".$getdata);
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

