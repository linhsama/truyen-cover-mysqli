<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?><?php
     include_once(__DIR__ . '/../../backend/dbconnect.php'); 
           
        // Thu thập thông tin 
        $chapter_id = $_POST['chapter_id'];
        $truyen_id = $_POST['truyen_id'];
        
        $upload_dir = __DIR__ . "/../../assets/uploads/truyen-tranh/";
        $tentaptin = date('YmdHis').'_'.$_FILES['chapter_noi_dung']['name'];
        $res = move_uploaded_file($_FILES['chapter_noi_dung']['tmp_name'],$upload_dir.$tentaptin);
        if($res){
            $ten_tap_tin = 'truyen-tranh/'.$tentaptin;
            $sql = <<<EOT
            INSERT INTO chapter_noi_dung(chapter_noi_dung, chapter_id) 
            VALUES ('$ten_tap_tin', '$chapter_id');
    EOT;
    mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");

}
   echo "<script> location.href='/truyen-cover/admin/chapter-noi-dung/index.php?chapter_id=$chapter_id&truyen_id=$truyen_id&result=success'; </script>";
   
?>