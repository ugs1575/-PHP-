<?php 
include "DB_Connection.php";

$no = $_GET["no"];

/* 조회수 올리기 */
$sql2 = "update board set hits = hits +1 where no = ".$no;
$result2 = mysqli_query($dbconnect, $sql2) or die("SQL 에러2");

$sql = "select no, title, writer, hits, reg_date, text, grpno, depth, grpord from board where no = " .$no;
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러");
$row = mysqli_fetch_array($result);

?>