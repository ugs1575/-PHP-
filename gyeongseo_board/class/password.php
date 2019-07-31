<?php 
require_once 'DB_Connection.php';

$function = $_POST["function"];
$no = $_POST["no"];
$password = $_POST["password"];

$sql ="select password from board where no=".$no;
$result = mysqli_query($dbconnect, $sql) or die("SQL 에러");

$row = mysqli_fetch_array($result);

/* 비밀번호를 입력안했을 경우 경고창 */
if($password!=$row["password"] && $password==""){
    echo "<script>alert('비밀번호를 입력해주세요');history.back();</script>";
/* 비밀번호가 일치 하지 않을 경우 경고창 */
}else if($password!=$row["password"] && $password!=""){
    echo "<script>alert('비밀번호가 일치하지 않습니다. 다시 입력해주세요');history.back();</script>";
}else{
    /* 비밀번호가 일치 했을 때, 수정모드일 경우 수정폼으로, 삭제모드일 경우 삭제폼으로 */
    if($function=="update"){
        header("Location: ../section/create.html?function=".$function."&no=".$no);
    }else{
        //해당글에 답글이 있는지 조사
        $sql = "select count(*) from board where parentNo=".$no;
        $result = mysqli_query($dbconnect, $sql) or die("SQL 에러");
        $row = mysqli_fetch_array($result);
        if($row[0]>0){
            header("Location: ../section/confirm.html?no=".$no);
        }else{
            header("Location: ./delete.php?no=".$no);
        }
           
    }
  
}
?>