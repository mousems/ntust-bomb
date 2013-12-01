<?php

include(dirname(__FILE__)."converter.class.php");

// 輸入 UTF-8 編碼的繁體中文
// 輸出 UTF-8 編碼且 URL Encode 的簡體中文
function nexmo_conv( $string )
{
	$conv = new converter;
	$string = $conv->convert('UTF','BIG', $string);
	$string = $conv->convert('BIG','GB', $string);
	$string = iconv('GBK', 'UTF-8//IGNORE', $string);
	$string = urlencode($string);
	return $string;
}

function sendvoicef($to , $text){

	$url="https://rest.nexmo.com/tts/json?api_key="."641a3794"."&api_secret="."cba9477f"."&to=".$to."&text=".$text."&lg=zh-cn";

	return (file_get_contents($url));

}

	$file=fopen("sendlist","r");
	while (!feof($file)) {
		$str .= fgets($file);
	}
	fclose($file);
	$sendlist=split(",\n", $str);

	foreach($sendlist as $index => $to){
		if($index!=0){
			if(preg_match("/0([0-9]{9})/", $to, $matches)){
				$to="+886".$matches[1];
			}
			if(preg_match("/(\+886[0-9]{9})/", $to, $matches)){
				$to=$matches[1];
			}
			//$nexmo_sms->sendText( $to, $from, $sendlist[0] );
			echo sendvoicef($to , nexmo_conv($sendlist[0]))."\n";
		}
	}

?>