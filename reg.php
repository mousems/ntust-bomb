<?php
include(dirname(__FILE__)."function.php");




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







if ($user) {
          $fbid=$user_profile['id'];
          $fbname=$user_profile['name'];
          $uid=fbid_to_uid($fbid);

          if($uid==''){
                  //continue


                  if($dorm==1){
                        //dorm only
                        if(Check118dorm($ip)=="0"){
                              header("location:index.php?msg=not118dorm&info=".Check118dorm($ip));


                        }else{


                              $token=md5($fbid."iamarandomkey1234".$ip);

                        }



                  }else{
                        //all 118

                        if(Check118($ip)=="1"){
                              header("location:index.php?msg=not118ip");




                        }else{


                              $token=md5($fbid."iamarandomkey1234".$ip);
                          
                        }


                  }




          }else{
                  //already reg
                  header("location:dashboard.php?msg=already_reg");

          }


}else{
          header("location:index.php?msg=fb_not_login");

}
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

</script>

<style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>


  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="text-muted">台科防爆網<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fntustbomb&amp;width=450&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;send=false&amp;appId=518849124871148" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></h3>
        <ul class="nav nav-justified">
          <li><a href="index.php">Home</a></li>
          <li><a href="dashboard.php">Dashboard</a></li>
        </ul>
      </div>
      <br />




      <!-- Jumbotron -->
      <form class="form-signin" action="reg_do.php" method="post">
        <h2 class="form-signin-heading">註冊</h2>
        <p>Facebook:<A HREF="https://facebook.com/<?=$fbid;?>" target="_blank"><?=$fbname;?></A> connected.</p>
        <p>IP:<?=$ip;?></p>
        <input type="text" name="schoolid" class="input-block-level" placeholder="台科大學號" >
        <input type="text" name="phone" class="input-block-level" placeholder="手機號碼（09xxxxxxxx）">
        <input type="hidden" name="ip"  value="<?=$ip;?>">
        <input type="hidden" name="fbid"  value="<?=$fbid;?>">
        <input type="hidden" name="token" value="<?=$token;?>">
        <button class="btn btn-large btn-primary" type="submit">送出</button>

      </form>






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
