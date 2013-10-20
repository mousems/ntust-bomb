<?php
include("function.php");



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
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

//facebook===========



?>
<!DOCTYPE html>
<html lang="zh-tw">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="MouseMs">
    <meta name="og:title" content="台科防爆網 防止你爆流量的好幫手">
    <meta name="og:description" content="台科防爆網：會從伺服器端隨時監控您的流量，免安裝任何軟體，快爆流量時由系統打電話通知你，讓你放心的上網。">
    <meta name="og:type" content="website">
    <meta name="og:image" content="">
    
    <link rel="shortcut icon" href="ico/favicon.png">

    <title>台科防爆網 防止你爆流量的好幫手</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/justified-nav.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-35851793-2', 'ntust-bomb.org');
  ga('send', 'pageview');

</script></head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="text-muted">台科防爆網<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fntustbomb&amp;width=450&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;send=false&amp;appId=518849124871148" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></h3>
        <ul class="nav nav-justified">
          <li><a href="index.php">Home</a></li>
          <li class="active"><a href="dashboard.php">Dashboard</a></li>
        </ul>
      </div>

<?php
if(!empty($_GET['msg'])){
  if($_GET['msg']=='regok'){$msgtitle="warning"; $msg="恭喜您註冊成功，接下來請認證信箱與手機號碼。";}

 




?>

      <div class="alert alert-<?=$msgtitle;?>">
        <?=$msg;?>
      </div>
<?php
}

if ($user) {
  $fbid=$user_profile['id'];
  $uid=fbid_to_uid($fbid);

  if($uid==''){
      header("location:reg.php");

  }else{
        

        if(!empty($_GET['checkflow'])){


            if($_GET['checkflow']=="yes"){
              
              Getflow_toDB($ip);
             
            }
        }

        $Wormdb = @mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
        mysql_select_db ($db_name);


        $fbid=mysql_real_escape_string($fbid);
        $result = mysql_query("SELECT * from `account` WHERE fbid='".$fbid."' ORDER BY `uid` DESC LIMIT 1");
 
          while($row = mysql_fetch_array($result))
            {
                //$uid
                //$fbid
                $user_uid=$uid;
                $user_fbid=$fbid;
                $user_fbname=$user_profile['name'];
                $user_schoolid=$row['schoolid'];
                $user_ip=$row['ip'];
                $user_phone=$row['phone'];          
                $user_phone_ok=$row['phone_ok'];

                  if($user_phone_ok=='1'){
                      $str_phone_ok='';
                  }else if($user_phone_ok=='0'){
                      $str_phone_ok='您尚未驗證，請<a href="check_phone.php">點此驗證</a>';
                  }else{
                      $str_phone_ok='<form method="get" action="check_phone.php"><input type="text" name="token" class="input-block-level" placeholder="請輸入手機驗證碼" ></form>';
                  }



                $user_lastalarm=$row['lastalarm'];
                $user_email_ok=$row['email_ok'];


                  if($user_email_ok=='1'){
                      $str_email_ok='';
                  }else{
                      $str_email_ok='請<a href="check_email.php">點此驗證</a>';
                  }


            }


        $result = mysql_query("SELECT * from `dormiptable` WHERE ip='".$user_ip."' ORDER BY `uid` DESC LIMIT 1");
 
          while($row = mysql_fetch_array($result))
            {
                $user_flow=$row['flow'];          
                $user_time=$row['time'];

                  if($user_time==0){
                      $str_time='系統從未檢查過流量。';
                  }else{
                      $str_time=$user_flow.'MB ('.date("Y/m/d H:i:s",$user_time).'）';
                  }

                  $str_time.=" <a href='dashboard.php?checkflow=yes'>馬上檢查</a>";

            }

//login success
?>
      <!-- Jumbotron -->
      <div class="jumbotron">        
        <h2>DashBoard</h2>
        <p class="lead">此處能檢視您的帳號狀況。</p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="col-lg-4">
          <h2>帳號資訊</h2>
          <p>facebook:<a target="_blank" href="http://facebook.com/"<?=$user_fbid;?>><?=$user_fbname;?></a></p>
          <p>Phone:0<?=$user_phone." ".$str_phone_ok;?></p>
          <p>e-mail:<?=$user_schoolid;?>@mail.ntust.edu.tw <?=$str_email_ok;?></p>
          <p>ip:<?=$user_ip;?></p>
          <p>host:<?php echo(gethostbyaddr($user_ip));?></p>


        </div>
        <div class="col-lg-4">
          <h2>流量資訊</h2>
          <?php

                  if($user_phone_ok!='1' | $user_email_ok!='1'){
                      echo "<h4>信箱與電話都要驗證才能使用服務</h4>";
                  }
          ?>
                    <?php
              if(Check118dorm($user_ip)){
                echo "<p>dorm:".GetDormStr($user_ip)."</p>";
              }
                    ?>
          <p>流量：<?=$str_time;?></p>


       </div>
        <div class="col-lg-4">
          <h2>注意事項</h2>
          <li>系統10分鐘檢查一次，台科網路10分鐘可以傳輸1100MB，故設計於4.5GB通知（約在5.6GB斷網）。</li>
          <li>打電話給你沒接到，被斷網我也沒辦法了orz</li>
          <li>目前設計給台科大住宿生（有線網路）</li>
          <li>未來或許會支援台科全網段監控...看心情和系統負擔...</li>
          <li>若有特殊需求請<a href="mailto:b10115012@mail.ntust.edu.tw">聯絡作者</a></li>
        </div>
      </div>

<?php
  }
  // login success
} else {
  // login fail
  $loginUrl = $facebook->getLoginUrl(
    array(
    'canvas' => 1,
    'fbconnect' => 0,
    'scope' => 'email',
    'next' => 'http://'.$test.'ntust-bomb.org',
    'redirect_uri' => 'http://'.$test.'ntust-bomb.org/dashboard.php'
    )
  );
?>
      <div class="jumbotron">        
        <h1>DashBoard</h1>
        <p class="lead">請按下方按鈕，以facebook登入。</p>
        <a href="<?=$loginUrl;?>"><img src="facebookbutton.jpg"></a>
      </div>

<?php
  // login fail
  }


?>

      <!-- Site footer -->
      <div class="footer">
        <p>&copy; <a href="https://facebook.com/mousems">MouseMs</a>@台科大學生會資訊室 2013</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-min.js"></script>
  </body>
</html>
