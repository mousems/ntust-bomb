<?php
include("function.php");

$FlowData=array("");
array_pop($FlowData);

array_push($FlowData, array(date('U'),date('U')));

array_push($FlowData, array(date('U'),date('U')));
array_push($FlowData, array(date('U'),date('U')));
array_push($FlowData, array(date('U'),date('U')));
array_push($FlowData, array(date('U'),date('U')));

print_r(array_pop($FlowData));
?>
