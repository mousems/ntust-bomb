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


        $dorm1_list_ip=array("");
        $dorm1_list_flow=array("");
        $result = mysql_query("SELECT flow,hostname,ip from `dormiptable` where `hostname`like'D1%' ORDER BY `flow` DESC LIMIT 10");
 
          while($row = mysql_fetch_array($result))
            {
                @array_push($dorm1_list_ip , $row[ip]);
                @array_push($dorm1_list_flow , $row[flow]);
            }

        $result = mysql_fetch_array(mysql_query("SELECT AVG(flow) as avg from `dormiptable` where `hostname`like'D1%'"));
        $stat_d1_avg=@$result[avg];

        $result = mysql_fetch_array(mysql_query("SELECT AVG(flow) as avg from `dormiptable` where `hostname`like'D2%'"));
        $stat_d2_avg=@$result[avg];

        $result = mysql_fetch_array(mysql_query("SELECT AVG(flow) as avg from `dormiptable` where `hostname`like'D4%'"));
        $stat_d3_avg=@$result[avg];


        $dorm2_list_ip=array("");
        $dorm2_list_flow=array("");
        $result = mysql_query("SELECT flow,hostname,ip from `dormiptable` where `hostname`like'D2%' ORDER BY `flow` DESC LIMIT 10");
 
          while($row = mysql_fetch_array($result))
            {
                @array_push($dorm2_list_ip , $row[ip]);
                @array_push($dorm2_list_flow , $row[flow]);
            }
        $dorm3_list_ip=array("");
        $dorm3_list_flow=array("");
        $result = mysql_query("SELECT flow,hostname,ip from `dormiptable` where `hostname`like'D4%' ORDER BY `flow` DESC LIMIT 10");
 
          while($row = mysql_fetch_array($result))
            {
                @array_push($dorm3_list_ip , $row[ip]);
                @array_push($dorm3_list_flow , $row[flow]);
            }

        $dorm1_str="'".$dorm1_list_flow[1]."'";
        $dorm2_str="'".$dorm2_list_flow[1]."'";
        $dorm3_str="'".$dorm3_list_flow[1]."'";
          for ($i=2; $i <=10 ; $i++) { 
            $dorm1_str.=","."'".$dorm1_list_flow[$i]."'";
            $dorm2_str.=","."'".$dorm2_list_flow[$i]."'";
            $dorm3_str.=","."'".$dorm3_list_flow[$i]."'";
          }



?>

    <script type="text/javascript">
$(function () {
        $('#highchartscont').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '三宿舍流量平均值'
            },
            subtitle: {
                text: 'Source: WorldClimate.com'
            },
            xAxis: {
                categories: [
                    '宿舍'
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: '流量 (MB)'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} MB</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {

                column: {
                    dataLabels: {
                        enabled: true
                    },
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: '第一宿舍',
                data: [<?=$stat_d1_avg;?>]
    
            }, {
                name: '第二宿舍',
                data: [<?=$stat_d2_avg;?>]
    
            }, {
                name: '第三宿舍',
                data: [<?=$stat_d3_avg;?>]
    
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
        <div id="highchartscont" class="col-lg-6">
          <h2>優點</h2>
          <ul>
            <li>不用安裝軟體。</li>
            <li>不用任何費用，但歡迎贊助:)</li>
            <li>以電話通知你。</li>
          </ul>
       </div>
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
