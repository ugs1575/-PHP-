<?php
include "DB_Connection.php";

//게시판 글 등록
$title = $_POST["title"];
$writer = $_POST["writer"];
$text = $_POST["text"];
$password = $_POST["password"];


//글번호 가져오기
$no = mysqli_insert_id($dbconnect);
//확장자 체크 결과
$extension_result = true;
//sql문 실행 결과
$result = true;

//대표이미지와 글 등록
if(isset($_FILES['repreImg'])){
    //대표이미지 이름
    $name_file = $_FILES['repreImg']['name'];
    //확장자 확인
    $extension = pathinfo($name_file,PATHINFO_EXTENSION);
    if($extension=='png'||$extension=='jpg'||$extension=='gif'){
        //대표이미지가 선택 되어 있으면
        if($name_file!=''){
            //temp 경로 이름
            $tmp_name_file = $_FILES['repreImg']['tmp_name'];
            //업로드 할 경로
            $dir = "C:\\xampp3\htdocs\gyeongseo_board\upload\\";
            //글등록
            $sql = "insert into board(title, writer, text, password, repreImg) values
                    ('".$title."','".$writer."','".$text."','".$password."','".$name_file."')";
            $result = mysqli_query($dbconnect, $sql) or die("SQL 에러");
            
            if(!move_uploaded_file($tmp_name_file, $dir.$name_file)){
                echo "failed for ".$name_file;
            }
        }
    }else{
        $extension_result = false;
    }

}



//글번호 가져오기
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
             //확장자 확인
             $extension = pathinfo($name_file[$i],PATHINFO_EXTENSION);
             if($extension=='png'||$extension=='jpg'||$extension=='gif'){
                $sql = "insert into img(imgName, no) values
                ('".$name_file[$i]."',".$no.")";
                $result = mysqli_query($dbconnect, $sql) or die("SQL 에러2");
                if(!move_uploaded_file($tmp_name_file[$i], $dir.$name_file[$i])){
                    echo "failed for ".$name_file[$i];
                }
             }else{
                 $extension_result = false;
             }
         }
    }
}



if($result==true && $extension_result==false){
    echo "<script>
            alert('이미지 파일만 등록 가능합니다.');
            document.location.href='../section/imageCreate.html';
          </script>";
}else if($result==true && $extension_result==true){
    echo "<script>
            alert('글 등록이 완료되었습니다.');
            document.location.href='../section/list.html';
          </script>";
}else if($result==false){
    echo "Invalid Query";
}


?>