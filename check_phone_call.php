<?php
include(dirname(__FILE__)."/function.php");

$Wormdb = @mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
mysql_select_db ($db_name);








//facebook===========

require 'facebook.php';
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $secret,
));

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
          

          $fbid=$user_profile['id'];
          $uid=fbid_to_uid($fbid);

          if($uid!=''){


        			$result = mysql_query("SELECT `lasttestcall`,`phone` from `account` WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");
 
          		while($row = mysql_fetch_array($result))
            			{
      							$lasttestcall=$row['lasttestcall'];   
                    $phone=$row['phone'];   
        				}



                if(date("Y/m/d" , $lasttestcall) != date("Y/m/d")){
                    //call
                    $flow=(int)Getflow_toDB($ip);

                    sendvoice($phone , "台科防爆網 提醒您 您的流量目前是".$flow , $uid);


                    $result2=mysql_query("UPDATE `account` SET `lasttestcall`='".date("U")."' WHERE `uid`='".$uid."'");

                    header("location:index.php?msg=testcallok");


                }else{
                    header("location:index.php?msg=testcallfail");


                }




          }else{
                        //already reg
             header("location:index.php");

          }



  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
	header("location:index.php?msg=fb_not_login");
  }
}else{
	header("location:index.php?msg=fb_not_login");
}





?>