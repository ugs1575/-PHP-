<?php
    $host = "192.168.0.230";
    $user = "testadmin";
    $pw = "test123!@";
    $db = "ugs_board";
    $dbconnect = new mysqli($host, $user, $pw, $db);
    $dbconnect -> set_charset("utf-8");

    if(mysqli_connect_errno()) {
        echo '데이터 베이스 접속 실패';
    }
?>
