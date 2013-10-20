<?php


include("../function.php");


function printout($type , $string){
	 echo "[".date("Y/m/d H:i:s")."] ".$type.":".$string.'
';
}

function getallflow(){

	global $db_host, $db_name, $db_user, $db_pass;

	$Wormdb = @mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
	mysql_select_db ($db_name);

	$result = mysql_query("SELECT `ip`,`uid` from `dormiptable`  LIMIT 100");
				
				
	while($row = mysql_fetch_array($result))
		{
			$ip=$row['ip'];
			$flow=Getflow_toDB($ip);

			printout("flow_success " , $ip."->".$flow);
			if($flow>4500){
					//alarm


					$result2 = mysql_query("SELECT `uid`,`lastalarm`,`phone` from `account` WHERE `ip`='".$ip."' LIMIT 1");
								
								
					while($row2 = mysql_fetch_array($result2))
						{

							$lastalarm=$row2['lastalarm'];
							$phone=$row2['phone'];
							$uid=$row2['uid'];
						}

					if(date("Y/m/d" , $lastalarm) != date("Y/m/d")){
							//call

							sendvoice($phone , "您好 這裡是台科防爆網 提醒您 您的電腦流量快超過了 目前是".$flow." M B 請儘快停止上網以免被停權，謝謝。" , $uid);

							$result2=mysql_query("UPDATE `account` SET `lastalarm`='".date("U")."' WHERE `uid`='".$uid."'");


					}



			}








		}
}



$datea=date("U");

while (1) {
	
	//if(date("i") % 10 == 1){
		printout('info' , "Get all flow start.");
		getallflow();
		printout('info' , "Get all flow done.");
	//}

	printout('info' , "sleeping...");

	sleep(60);










	continue;
}












?>