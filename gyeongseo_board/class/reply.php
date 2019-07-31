<?php
include "DB_Connection.php";

$no = $_POST["no"];
//답글 등록
$grpno = $_POST["grpno"];
$title = $_POST["title"];
$writer = $_POST["writer"];
$text = $_POST["text"];
$password = $_POST["password"];
$depth = $_POST["depth"];
$depth++;
$grpord = $_POST["grpord"];


$sql = "update board set grpord = grpord + 1 where grpno = ".$grpno." and grpord > ".$grpord;
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러2");


//답글 등록하기
$grpord++;
$sql = "insert into board(title, writer, text, password, grpno, depth, grpord, parentNo) values
    ('".$title."','".$writer."','".$text."','".$password."','".$grpno."','".$depth."','".$grpord."','".$no."')";
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러3");




//이미지 테이블 foreign key no등록을 위해, 방금전 등록했던 글번호 가져오기
$no = mysqli_insert_id($dbconnect);


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
            $sql3 = "insert into img(imgName, no) values
                    ('".$name_file[$i]."','".$no."')";
            $result3 = mysqli_query($dbconnect, $sql3) or die("SQL 에러5");
            if(!move_uploaded_file($tmp_name_file[$i], $dir.$name_file[$i])){
                echo "failed for ".$name_file[$i];
            }
        }
    }
}



if($result == true){
    echo "<script>alert('답글 등록이 완료되었습니다.');
            document.location.href='../section/list.html';
    </script>";
} else {
    echo "Invalid Query";
}

?>