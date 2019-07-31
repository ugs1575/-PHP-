<?php
require_once 'DB_Connection.php';
$no = $_GET["no"];
$dir = "C:\\xampp3\htdocs\gyeongseo_board\upload\\";


//imgName불러와서 업로드한 파일 삭제
$sql = "select no, imgName from img where no = ".$no;
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러");
if ($result) {
    while($row = mysqli_fetch_array($result)) {
        if(file_exists($dir.$row["imgName"])){
            if(!unlink($dir."\\".$row["imgName"])){
                echo "파일 삭제 실패";
            }
        }
        //img테이블에서 삭제
        $sql2 = "delete from img where no=".$no;
        $result2 = mysqli_query($dbconnect, $sql2) or die("SQL 에러2");
    }
}



//board테이블에서 삭제
$sql = "delete from board where no=".$no;
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러3");
//답글들도 삭제
$sql = "delete from board where parentNo=".$no;
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러3");
if($result == true){
  echo "<script>alert('글 삭제가 완료되었습니다.');
                document.location.href='../section/list.html';
        </script>"; 
} else {
    echo "Invalid Query";
} 
?>