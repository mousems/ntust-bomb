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





/*
        				$subject = '台科防爆網 信箱確認信';
						$message = '
						<html>
						<body>
						<p>請打開連結以驗證：</p><a href="http://'.$test.'ntust-bomb.org/check_email.php?token='.$token.'</a>
						<br />
						<p>或：http://'.$test.'ntust-bomb.org/check_email.php?token='.$token.'</p>
						</body>
						</html>
						';

						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
						$headers .= 'From: NTUST-bomb-service <noreply@ntust-bomb.org>' . "\r\n";

						// Mail it
						mail($user_schoolid.'@mail.ntust.edu.tw', $subject, $message, $headers);
						//mail('mousems.kuo@gmail.com', $subject, $message, $headers);
*/





						require 'PHPMailer-master/PHPMailerAutoload.php';

						$mail = new PHPMailer;

						$mail->isSMTP();                                      // Set mailer to use SMTP
						$mail->Host = 'mail.ntust.edu.tw';  // Specify main and backup server
						$mail->SMTPAuth = true;                               // Enable SMTP authentication
						$mail->Username = 'b10115012';                            // SMTP username
						$mail->Password = 'eo3su32l4';                           // SMTP password
						$mail->SMTPSecure = '';                            // Enable encryption, 'ssl' also accepted

						$mail->setLanguage('zh', '/optional/path/to/language/directory/');
						$mail->From = 'b10115012@mail.ntust.edu.tw';
						$mail->FromName = 'NTUST-Bomb';
						//$mail->addAddress($user_schoolid.'@mail.ntust.edu.tw', $user_schoolid);  // Add a recipient
						$mail->addAddress('mousems.kuo@gmail.com', $user_schoolid);  // Add a recipient
						$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
						$mail->isHTML(true);                                  // Set email format to HTML

						$mail->Subject = 'NTUST BOMB email address authorization ';
						//$mail->Body    = '<html><body><a href="http://'.$test.'ntust-bomb.org/check_email.php?token='.$token.'</a></body></html>';
						$mail->AltBody = 'http://'.$test.'ntust-bomb.org/check_email.php?token='.$token.'';

						if(!$mail->send()) {
						   echo '<p>送信失敗，有時候回沒辦法連線到。</p><a href="index.php">返回首頁</a>';
						   exit;
						}




        				//$result = mysql_query("UPDATE `account` SET `email_ok`='".$token."' WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");

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