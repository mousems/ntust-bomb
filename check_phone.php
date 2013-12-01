<?php
include(dirname(__FILE__)."function.php");

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



					if(!empty($_GET['token'])){


					    $result = mysql_query("SELECT * from `account` WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");
					 
					    	while($row = mysql_fetch_array($result))
					    	{
								$token_real=$row['phone_ok'];
							}





						if($_GET['token']==$token_real){

								$result = mysql_query("UPDATE `account` SET `phone_ok`='1' WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");

                				header("location:index.php?msg=phoneok");
                				die();
						}else{

                				header("location:index.php?msg=phoneerror");
                				die();
							
						}


					}


        			$result = mysql_query("SELECT * from `account` WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");
 
          			while($row = mysql_fetch_array($result))
            			{
							$token_real=$row['phone_ok'];        					
							$user_schoolid=$row['schoolid'];
							$user_uid=$row['uid'];
							$user_phone=$row['phone'];
							$email_ok=$row['email_ok'];
        				}

        			if($email_ok!='1'){


                		//header("location:index.php?msg=emailfirst");
                		//die();
        			}

        			if($token_real==0){
        				//email
        				$token=date("s").rand(1,100);

        				$result = mysql_query("UPDATE `account` SET `phone_ok`='".$token."' WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");
						sendmessage($user_phone , "這裡是台科防爆網，您的驗證碼是：".$token , $user_uid);
						log_do($user_uid , "phone=".$user_phone." schoolid =".$user_schoolid." token=".$token , "check sms sent.");


                		header("location:index.php?msg=smsed");
        			}else if($token_real==1){

                		header("location:index.php");


        			}else{

                 		header("location:index.php?msg=smsleave");

        			}

          			//email






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