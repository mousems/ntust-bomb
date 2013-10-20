<?php
include("function.php");

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
								$token_real=$row['email_ok'];
							}

						if($_GET['token']==$token_real){

								$result = mysql_query("UPDATE `account` SET `email_ok`='1' WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");

                				header("location:index.php?msg=tokenok");
                				die();
						}else{

                				header("location:index.php?msg=tokenerror");
                				die();
							
						}


					}





        			$result = mysql_query("SELECT * from `account` WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");
 
          			while($row = mysql_fetch_array($result))
            			{
							$token_real=$row['email_ok'];        					
							$user_schoolid=$row['schoolid'];
							$user_uid=$row['uid'];
        				}


        			if($token_real==0){
        				//email
        				$token=md5(date("hi").date("s").rand(1,100));

        				$subject = '台科防爆網 信箱確認信';

						$message = '
						<html>
						<body>
						請打開連結以驗證：<a href="http://'.$test.'ntust-bomb.org/check_email.php?token='.$token.'"http://'.$test.'ntust-bomb.org/check_email.php?token='.$token.'</a>
						<br />
						或：http://'.$test.'ntust-bomb.org/check_email.php?token='.$token.'
						</body>
						</html>
						';

						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

						// Additional headers
						$headers .= 'From: NTUST-bomb-service <b10115012@mail.ntust.edu.tw>' . "\r\n";

						// Mail it
						//mail($user_schoolid.'@mail.ntust.edu.tw', $subject, $message, $headers);
						mail('mousems.kuo@gmail.com', $subject, $message, $headers);

        				$result = mysql_query("UPDATE `account` SET `email_ok`='".$token."' WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");

						log_do($user_uid , "schoolid =".$user_schoolid." token=".$token , "check email sent.");


                		header("location:index.php?msg=emailed");
        			}else if($token_real==1){

                		header("location:index.php");


        			}else{

                 		header("location:index.php?msg=tokenleave");

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