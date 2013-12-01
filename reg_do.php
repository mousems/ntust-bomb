<?php
include("function.php");

	$Wormdb = @mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
	mysql_select_db ($db_name);


$schoolid=mysql_real_escape_string($_POST['schoolid']);
$phone=mysql_real_escape_string($_POST['phone']);

if(!preg_match("/0[\d]{9}/", $phone)){

	header("location:index.php?msg=phoneerror");
}


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

          if($uid==''){


          	$d = mysql_query('INSERT INTO `account` (`fbid`,`schoolid`,`ip`,`hostname`,`phone`,`phone_ok`,`lastalarm`,`alarmcount`,`email_ok`)VALUES ("'.$fbid.'","'.$schoolid.'","'.$ip.'","'.(gethostbyaddr($ip)).'","'.$phone.'","0","0","0","0")');
          	
          	$d = mysql_query('INSERT INTO `dormiptable` (`uid`,`hostname`,`ip`,`time`,`flow`)VALUES ("'.(fbid_to_uid($fbid)).'","'.(gethostbyaddr($ip)).'","'.$ip.'","0","0")');
          	Getflow_toDB($ip);
          	//echo ('INSERT INTO `account` (`fbid`,`schoolid`,`ip`,`hostname`,`phone`,`phone_ok`,`lastalarm`,`alarmcount`,`flowcount`)VALUES ("'.$fbid.'","'.$schoolid.'","'.$ip.'","'.(gethostbyaddr($ip)).'","'.$phone.'","0","0","0","0")');
            header("location:dashboard.php?msg=regok");




          }else{
                  //already reg
                  header("location:index.php?msg=already_reg");

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