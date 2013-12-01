<?php

$start_time=date('U');

include(dirname(__FILE__)."/function.php");
$Wormdb = mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
mysql_select_db ($db_name);



$a=file_get_contents("tmp");
$a=split(";", $a);

$totalcount= count($a);


foreach ($a as $key => $value) {
	if($value!=''){

		$a=mysql_query($value);
		preg_match("/`flow`\='(\d*)'.*`ip`\='(\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3})'/", $value, $matches);
		echo ($key+1)."/".$totalcount." ".$matches[2]." => flow=".$matches[1].$crlf;
	
	}
}



echo "total:".(date('U')-$start_time)."s".$crlf;
?>