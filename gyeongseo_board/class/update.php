<?php 
require_once 'DB_Connection.php';

$no = $_POST["no"];
$dir = "C:\\xampp3\htdocs\gyeongseo_board\upload\\";


//삭제한 파일들 지우기
if(isset($_POST["imgSno"])){
    $imgSno = $_POST["imgSno"];
    print_r ($imgSno);
    $array = explode(",", $imgSno);
    for($i=0; $i<count($array)-1; $i++){
        $sql = "select imgName from img where imgNo = ".$array[$i];
        $result = mysqli_query($dbconnect, $sql) or die("SQL 에러");
        $row = mysqli_fetch_array($result);
        if(file_exists($dir.$row["imgName"])){
            if(unlink($dir."\\".$row["imgName"])){
                echo $array[$i];
                $sql2 = "delete from img where imgNo=".$array[$i];
                $result2 = mysqli_query($dbconnect, $sql2) or die("SQL 에러2");
            }else{
                echo "파일 삭제 실패";
            }
        }
    }
}



//추가파일 업로드
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
            $result3 = mysqli_query($dbconnect, $sql3) or die("SQL 에러3");
            if(!move_uploaded_file($tmp_name_file[$i], $dir.$name_file[$i])){
                echo "failed for ".$name_file[$i];
            }
        }
    }
}

//글정보 수정
$sql4 = "update board 
        set title='".$_POST['title']."',
            writer='".$_POST['writer']."', 
            text='".$_POST['text']."',
            password='".$_POST['password']."'
        where no=".$no;

$result4 = mysqli_query($dbconnect, $sql4) or die("SQL 에러4");

if($result4 == true){
    echo "<script>alert('글 수정이 완료되었습니다.');
                document.location.href='../section/read.html?no=".$no."';
          </script>";
} else {
    echo "Invalid Query";
}

?>