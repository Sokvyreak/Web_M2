<?php 
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; Filename=Orders_Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
require "report-orders.php";
?>