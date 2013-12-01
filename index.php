<?php
include("function.php");
$str='';

if(check118($ip)){
        $dorm=GetDormStr($ip);
        if($dorm!=0){
                $str.= $dorm."<br />";
        }else{
                $str.="反解資訊：".(gethostbyaddr($ip))."<br />";
        }

        $str.= "IP:".$ip."<br />流量:".getflow($ip)."MB";

}else{

        $str.= "IP:".$ip."<br />"."您的IP非位於台科大，無法提供流量資訊";
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

</script></head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="text-muted">台科防爆網<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fntustbomb&amp;width=450&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;send=false&amp;appId=518849124871148" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></h3>
        <ul class="nav nav-justified">
          <li class="active"><a href="index.php">Home</a></li>
          <li><a href="dashboard.php">Dashboard</a></li>
        </ul>
      </div>

<?php
if(!empty($_GET['msg'])){
  if($_GET['msg']=='not118dorm'){$msgtitle="danger"; $msg="目前暫不開放非住宿生使用本服務，或系統無法成功偵測您是住宿生，請確定您使用宿舍IP連線！";}
  if($_GET['msg']=='not118ip'){$msgtitle="danger";  $msg="您的IP非來自台科大，或系統無法成功偵測，請確定您使用台科大宿舍IP連線！";}
  if($_GET['msg']=='already_reg'){$msgtitle="warning";  $msg="您已是會員。";}
  if($_GET['msg']=='fb_not_login'){$msgtitle="danger";  $msg="未連接facebook登入系統。";}
  if($_GET['msg']=='hacker'){$msgtitle="danger";  $msg="Do Not Hack Me :)";}
  if($_GET['msg']=='phoneerror'){$msgtitle="warning";  $msg="電話格式錯誤：09xxxxxxxx";}
  if($_GET['msg']=='emailed'){$msgtitle="success";  $msg="認證信傳送成功，請查看學校信箱確認！若無法驗證成功請：用學校信箱寄信給<a href='mailto:b10115012@mail.ntust.edu.tw'>管理員</a>，然後附上您的FB網址。";}
  if($_GET['msg']=='smsed'){$msgtitle="success";  $msg="手機驗證簡訊傳送成功，請查看手機確認，並填寫至dashboard，若無法驗證成功請聯絡管理員。";}
  if($_GET['msg']=='tokenleave'){$msgtitle="warning";  $msg="您之前傳送過認證信了，請重新確認，若無法驗證成功請：用學校信箱寄信給<a href='mailto:b10115012@mail.ntust.edu.tw'>管理員</a>，然後附上您的FB網址。";}
  if($_GET['msg']=='smsleave'){$msgtitle="warning";  $msg="您之前傳送過認證簡訊了，請重新確認，若無法驗證成功請：用學校信箱寄信給<a href='mailto:b10115012@mail.ntust.edu.tw'>管理員</a>，然後附上您的手機號碼，管理員會與你聯絡確認。";}
  if($_GET['msg']=='tokenok'){$msgtitle="success";  $msg="信箱驗證成功。";}
  if($_GET['msg']=='tokenerror'){$msgtitle="danger";  $msg="信箱驗證失敗。";}
  if($_GET['msg']=='phoneok'){$msgtitle="success";  $msg="手機驗證成功。";}
  if($_GET['msg']=='phoneerror'){$msgtitle="danger";  $msg="手機驗證失敗。";}
  if($_GET['msg']=='emailfirst'){$msgtitle="danger";  $msg="請先驗證信箱。";}
  if($_GET['msg']=='testcallok'){$msgtitle="success";  $msg="測試電話已播出，請準備接聽。";}
  if($_GET['msg']=='testcallfail'){$msgtitle="danger";  $msg="您今天已經測試過電話了，請明天再來玩玩:P";}
  if($_GET['msg']=='nomail'){$msgtitle="warning";  $msg="若無法驗證成功請：用學校信箱寄信給<a href='mailto:b10115012@mail.ntust.edu.tw'>管理員</a>，然後附上您的FB網址。";}






 




?>

      <div class="alert alert-<?=$msgtitle;?>">
        <?=$msg;?>
      </div>
<?php
}
?>    

      <!-- Jumbotron -->
      <div class="jumbotron"> 
	<img src="logo.jpg" height="400" witch="400">
        <p class="lead">會從伺服器端隨時監控您的流量，免安裝任何軟體，快爆流量時由系統打電話通知你，讓你放心的上網。</p>
        <p class="lead">目前設計僅提供服務給500位使用者！</p>
        <p><a class="btn btn-primary" href="dashboard.php">現在就註冊 &raquo;</a></p>
      </div>
      <div class="jumbotron">
	<h2>您目前的流量資訊</h2>
	<p><?php echo $str; ?></p>
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
            <li>不用任何費用，但歡迎贊助:)</li>
            <li>以電話通知你。</li>
          </ul>
          
       </div>
        <div class="col-lg-4">
          <h2>注意事項</h2>
          <p>系統10分鐘檢查一次，4.5GB打電話通知</p>
          <p>打電話給你沒接到，被斷網我也沒辦法了orz</p>
          <p>目前設計給台科大住宿生（有線網路）</p>
          <p>若有特殊需求請<a href="mailto:b10115012@mail.ntust.edu.tw">聯絡作者</a></p>
        </div>
      </div>
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
