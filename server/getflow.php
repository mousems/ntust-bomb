<?php
//
// A very simple PHP example that sends a HTTP POST to a remote site
//

//$ch = curl_init();

//curl_setopt($ch, CURLOPT_URL,"http://netweb.ntust.edu.tw/dormweb/flowquery.aspx");
//curl_setopt($ch, CURLOPT_URL,"http://mousems.com/data/getposts.php");
//curl_setopt($ch, CURLOPT_POST, 1);
  $RB_1 = "詳細流量查詢";
  $un = "MB";
  $do_date = date("Y/m/d");
  $ipdata = $_GET['ip'];
  $Bbase = "查詢";
  $hip = $ipdata;
  $msg_sysadm = "，請撥分機6212洽管理者！";
  $p_ip = $ipdata;
  $pdate = date("Y/m/d");
  $page_size = "32760";
  $sel_str = "dodate=\'*****\'";
  $tablename = "ipflowtable";
  $tot_columns = "4";
  $hmaxlen= "10,14,14,14,13,10,13,6,6,13,20,15,15,15,15";
  $un_v = "1";


$data=	array(
	"RB_1"=>$RB_1,
        "un"=>$do_date,
        "do_date"=>$do_date,
        "ipdata"=>$ipdata,
        "Bbase"=>$Bbase,
        "hip"=>$hip,
	"msg_sysadm"=>$msg_sysadm,
        "p_ip"=>$p_ip,
        "pdate"=>$pdate,
        "page_size"=>$page_size,
        "sel_str"=>$sel_str,
        "tablename"=>$tablename,
        "tot_columns"=>$tot_columns,
        "hmaxlen"=>$hmaxlen,
        "un_v"=>$un_v,
	"__VIEWSTATE"=>"dDwtNDY0NjA5NTM4O3Q8O2w8aTwyPjs+O2w8dDw7bDxpPDE+O2k8Mz47aTw1PjtpPDc+O2k8MTM+Oz47bDx0PDtsPGk8MT47aTw3PjtpPDk+Oz47bDx0PHA8cDxsPFRleHQ7PjtsPOWci+eri+WPsOeBo+enkeaKgOWkp+WtuCDlsI3lpJbntrLot6/mtYHph4/mn6XoqaIo5qCh5YWn57ay6Lev5bCI55SoKTs+Pjs+Ozs+O3Q8cDxwPGw8VGV4dDs+O2w855m75YWl5pel5pyf77yaMjAxMy8wOS8xMTs+Pjs+Ozs+O3Q8O2w8aTwwPjs+O2w8dDw7bDxpPDE+O2k8Mj47PjtsPHQ8O2w8aTwwPjs+O2w8dDx0PDs7bDxpPDA+Oz4+Ozs+Oz4+O3Q8O2w8aTwxPjs+O2w8dDx0PHA8cDxsPERhdGFUZXh0RmllbGQ7PjtsPFN0cmluZ1RleHQ7Pj47Pjt0PGk8ND47QDxCeXRlcztLQjtNQjtHQjs+O0A8Qnl0ZXM7S0I7TUI7R0I7Pj47Pjs7Pjs+Pjs+Pjs+Pjs+Pjt0PDtsPGk8Nz47PjtsPHQ8cDxwPGw8VGV4dDs+O2w8XGU7Pj47Pjs7Pjs+Pjt0PHA8cDxsPFRleHQ7PjtsPFw8YnJcPuazqOaEj++8muWboOe1seioiOWfuua6luS4jeWQjO+8jOiri+WLv+iIh+WAi+S6uumbu+iFpuavlOi8g++8jOWmguacieWVj+mhjOiri21haWzliLAgY2Nwb3N0bWFuQG1haWwubnR1c3QuZWR1LnR3IOiojuirluOAgjs+Pjs+Ozs+O3Q8cDxwPGw8VmlzaWJsZTs+O2w8bzxmPjs+Pjs+O2w8aTwxPjtpPDM+Oz47bDx0PHA8cDxsPFRleHQ7PjtsPOips+e0sOa1gemHj+afpeipojs+Pjs+Ozs+O3Q8QDA8cDxwPGw8UGFnZVNpemU7PjtsPGk8MzI3NjA+Oz4+Oz47Ozs7Ozs7Ozs7Pjs7Pjs+Pjt0PHA8cDxsPFZpc2libGU7PjtsPG88Zj47Pj47PjtsPGk8MT47aTw1PjtpPDc+O2k8OT47PjtsPHQ8cDxwPGw8VGV4dDs+O2w8Kjs+Pjs+Ozs+O3Q8cDxwPGw8VGV4dDs+O2w8XGU7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPDA7Pj47Pjs7Pjt0PHA8cDxsPFRleHQ7PjtsPFxlOz4+Oz47Oz47Pj47Pj47Pj47Ppf2zHKqaCod+LFGKkOAC/xfwyL2",
	"tinsert"=>"",
	"od_str"=>"",
	"dorm"=>"",
	"__EVENTARGUMENT"=>""

);

// in real life you should use something like:
// curl_setopt($ch, CURLOPT_POSTFIELDS, 
//          http_build_query(array('postvar1' => 'value1')));

// receive server response ...

//curl_setopt($ch, CURLOPT_POSTFIELDS,$data);

//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//$server_output = curl_exec ($ch);
//curl_close ($ch);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://netweb.ntust.edu.tw/dormweb/flowquery.aspx");
//curl_setopt($ch, CURLOPT_URL, "http://mousems.com/data/getposts.php");
curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $data )); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$AA =curl_exec($ch); 
curl_close($ch);
//if(curl_errno($ch)){//出错则显示错误信息
//    print curl_error($ch);

//}
preg_match('/VIEWSTATE"\svalue="\S{1,}"/', $AA , $matches);
$a=$matches[0];
$a=str_replace('VIEWSTATE' ,"" ,$a);
$a=str_replace(' value=' ,"" ,$a);
$a=str_replace('"' , "" ,$a);
$a=base64_decode($a);


preg_match('/[0-9,]{1,};IP=/', $a , $matchesa);
$a=@str_replace(';IP=',"",$matchesa[0]);
    //新增或修改資料unique欄位內容重覆時mysql會回報錯誤

$a=str_replace(',' , "" ,$a);
if($a==""){$a=0;}
$a=(int)($a/1000000);
echo ($a);
// further processing ....

?>
