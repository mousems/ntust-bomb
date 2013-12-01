<?php


include(dirname(__FILE__)."/../function.php");


function printout($type , $string){
	 echo "[".date("Y/m/d H:i:s")."] ".$type.":".$string.'
';
}

function getallflow(){

	global $db_host, $db_name, $db_user, $db_pass;

	$Wormdb = @mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
	mysql_select_db ($db_name);

	$result = mysql_query("SELECT `ip`,`uid` from `dormiptable` order by `flow` desc");
				
				
	while($row = mysql_fetch_array($result))
		{
			$ip=$row['ip'];
			$flow=(int)Getflow_toDB($ip);

			printout("flow_success " , $ip." -> ".$flow.'MB');
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

							sendvoice($phone , "台科防爆網 提醒您 您的流量目前是".$flow , $uid);

							printout('info' , "Call ! ");
							$result2=mysql_query("UPDATE `account` SET `lastalarm`='".date("U")."' WHERE `uid`='".$uid."'");

					}else{

							printout('info' , "Already Called...");
					}



			}








		}
}



while (1) {
	
	$datea=date("U");


	//if(date("i") % 10 == 1){
		printout('info' , "Get all flow start.");
		getallflow();
		printout('info' , "Get all flow done.");
	//}

	$dateb=date("U");

	$plus=600-($dateb-$datea);

	printout('info' , "sleeping for ".$plus." sec...");

	if($plus<0){
		log_do(0,"take over 600 sec" , "error");
		printout('warning' , "take over 600sec!!!===================================================================================================");
	}else{
		sleep($plus);
	}
	continue;
}












?>
