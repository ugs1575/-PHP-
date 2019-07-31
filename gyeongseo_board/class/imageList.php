<?php

require_once("../class/DB_Connection.php");

if(isset($_GET['category'])){
    $category = $_GET['category'];
}

//한 페이지에 보여줄 리스트 수;
$record_per_page = 12;

//한 페이지에 보여줄 블럭 수
$page_per_block = 4;

//현재 페이지
$now_page = 1;

if(isset($_GET['page'])){
    $now_page = $_GET['page'];
}

//현재 블럭
$now_block = ceil($now_page / $page_per_block); 
    
$sql = "select no, title, repreImg from board where depth=0 order by no desc";


$result = mysqli_query($dbconnect,$sql) or die("sql 에러");

//전체 리스트 수
$total_record = mysqli_num_rows($result);

$sql = "select no, title, repreImg from board where depth=0 order by no desc";

$sql .= " limit ".$record_per_page * ($now_page - 1).",".$record_per_page;

$result = mysqli_query($dbconnect,$sql) or die("sql 에러2");

$total_record2 = mysqli_num_rows($result);



?>