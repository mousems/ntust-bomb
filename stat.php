<?php
include(dirname(__FILE__)."/function.php");

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

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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




    <script type="text/javascript">
$(function () {
        $('#highchartscont').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Monthly Average Temperature'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Temperature (째C)'
                }
            },
            tooltip: {
                enabled: false,
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'째C';
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Tokyo',
                data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            }, {
                name: 'London',
                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            }]
        });
    });
    

    </script>

</head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="text-muted">台科防爆網<iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Ffacebook.com%2Fntustbomb&amp;width=450&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;send=false&amp;appId=518849124871148" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:21px;" allowTransparency="true"></iframe></h3>
        <ul class="nav nav-justified">
          <li><a href="index.php">Home</a></li>
          <li class="active"><a href="dashboard.php">Dashboard</a></li>
        </ul>
      </div>

<?
        $Wormdb = @mysql_connect($db_host, $db_user, $db_pass) or die ('錯誤:數據庫連接失敗');
        mysql_select_db ($db_name);
        $result = mysql_fetch_array(mysql_query("SELECT count(*) as count from `dormiptable`"));
        $stat_total=@$result[count];
        $result = mysql_fetch_array(mysql_query("SELECT time from `dormiptable`ORDER BY `time` DESC LIMIT 1"));
        $stat_time=date("Y-m-d H:i:s",@$result[time]);
        $result = mysql_fetch_array(mysql_query("SELECT count(*) as count from `dormiptable` where `hostname`like'D1%'"));
        $stat_d1=@$result[count];

        $result = mysql_fetch_array(mysql_query("SELECT count(*) as count from `dormiptable` where `hostname`like'D2%'"));
        $stat_d2=@$result[count];

        $result = mysql_fetch_array(mysql_query("SELECT count(*) as count from `dormiptable` where `hostname`like'D4%'"));
        $stat_d3=@$result[count];



?>

      <div class="jumbotron"> 
        <h2>系統狀態</h2>
        <p class="lead">此處可檢視目前系統監控狀態。</p>
      </div>

      <!-- Example row of columns -->
      <div class="row">
        <div class="col-lg-6">
          <h2>統計資訊</h2>
          <p>監控IP數量：<?=$stat_total;?></p>
          <p>上次更新時間：<?=$stat_time;?></p>
          <p>第一宿舍：<?=$stat_d1;?></p>
          <p>第二宿舍：<?=$stat_d2;?></p>
          <p>第三宿舍：<?=$stat_d3;?></p>
        </div>
        <div class="col-lg-6">
          <h2>優點</h2>
          <ul>
            <li>不用安裝軟體。</li>
            <li>不用任何費用，但歡迎贊助:)</li>
            <li>以電話通知你。</li>
          </ul>
       </div>
      </div>



      <div class="highchartscont">



      </div>





      <div class="footer">
        <p>&copy; <a href="https://facebook.com/mousems">MouseMs</a>@台科大學生會資訊室 2013</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap-min.js"></script>
    <script src="js/highcharts.js"></script>
    <script src="js/modules/exporting.js"></script>

  </body>
</html>
