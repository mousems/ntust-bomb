<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require 'facebook.php';
include("function.php");

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $secret,
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

// Login or logout url will be needed depending on current user state.


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

if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
//login success
?>
      <!-- Jumbotron -->
      <div class="jumbotron">        
        <h1>DashBoard</h1>
        <p class="lead">會從伺服器端隨時監控您的流量，免安裝任何軟體，快爆流量時由系統打電話通知你，讓你放心的上網。</p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="col-lg-4">
          <h2>這是什麼？</h2>
          <p>註冊後，我們將24小時監控你的宿舍流量，接近4.5GB時打電話騷擾你，避免流量爆炸。</p>
        </div>
        <div class="col-lg-4">
          <h2>優點</h2>
          <ul>
            <li>不用安裝軟體。</li>
            <li>不用任何費用。</li>
            <li>以電話通知你。</li>
          </ul>
          
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
  // login success
} else {
  // login fail
  $loginUrl = $facebook->getLoginUrl(
    array(
    'canvas' => 1,
    'fbconnect' => 0,
    'scope' => 'email',
    'next' => 'http://ntust-bomb.org',
    'redirect_uri' => 'http://ntust-bomb.org/dashboard.php'
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
  </body>
</html>
