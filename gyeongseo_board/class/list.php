<?php

require_once("../class/DB_Connection.php");

if(isset($_GET['category'])){
    $category = $_GET['category'];
}

//한 페이지에 보여줄 리스트 수;
$record_per_page = 10;

//한 블럭에 보여줄 페이지 수
$page_per_block = 5;

//현재 페이지
$now_page = 1;

if(isset($_GET['page'])){
    $now_page = $_GET['page'];
}

//현재 블럭
$now_block = ceil($now_page / $page_per_block); 
    
$sql = "select no, title, writer, reg_date, hits, grpno, depth, grpord from board";
//검색했을 경우, 검색 결과 불러오기
if(isset($_GET['word'])){
    $word = $_GET['word'];
    $sql .= " where ".$category." like '%".$word."%'"; 
}
$sql .= " order by grpno desc, grpord asc";

$result = mysqli_query($dbconnect,$sql) or die("sql 에러");

//전체 리스트 수
$total_record = mysqli_num_rows($result);

$sql = "select no, title, writer, reg_date, hits, grpno, depth, grpord from board";
//검색했을 경우, 페이징
if(isset($_GET['word'])){
    $word = $_GET['word'];
    $sql .= " where ".$category." like '%".$word."%'";
}
$sql .= " order by grpno desc, grpord asc limit ".$record_per_page * ($now_page - 1).",".$record_per_page;

$result = mysqli_query($dbconnect,$sql) or die("sql 에러2");



?>