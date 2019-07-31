<?php
include "DB_Connection.php";

//게시판 글 등록
$title = $_POST["title"]; 
$writer = $_POST["writer"];
$text = $_POST["text"];
$password = $_POST["password"];

$sql = "insert into board(title, writer, text, password) values
    ('".$title."','".$writer."','".$text."','".$password."')";
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러1");

//글번호 가져오기
$no = mysqli_insert_id($dbconnect);

//grpno등록
$sql = "update board set grpno=".$no." where no=".$no;
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러3");


//파일 업로드
if(isset($_FILES['fname'])){
    //파일 이름
    $name_file = $_FILES['fname']['name'];
    //파일이 선택 되어 있으면
    if($name_file[0]!=''){ 
        //temp 경로 이름
        $tmp_name_file = $_FILES['fname']['tmp_name'];
        //총 파일 갯수
        $total_file = count($tmp_name_file);
        //업로드 할 경로
        $dir = "C:\\xampp3\htdocs\gyeongseo_board\upload\\";
        for($i=0; $i<$total_file; $i++){
            $sql = "insert into img(imgName, no) values
                    ('".$name_file[$i]."','".$no."')";
            $result = mysqli_query($dbconnect, $sql) or die("SQL 에러4");
            if(!move_uploaded_file($tmp_name_file[$i], $dir.$name_file[$i])){
                echo "failed for ".$name_file[$i];
            }
        }
    }
}

if($result == true){
    echo "<script>alert('글 등록이 완료되었습니다.');
            document.location.href='../section/list.html';
    </script>";
} else {
    echo "Invalid Query";
}

?>