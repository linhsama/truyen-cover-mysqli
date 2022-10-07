<?php
    //Lấy thông tin từ người dùng gửi
    if(isset($_GET['chapter_id']) && isset($_GET['truyen_id']) && isset($_GET['chapter_noi_dung_id'])){
        $chapter_id = $_GET['chapter_id'];
        $truyen_id = $_GET['truyen_id'];
        $chapter_noi_dung_id = $_GET['chapter_noi_dung_id'];
        // mở kết nối
    include_once(__DIR__ . '/../../backend/dbconnect.php'); 
    // lấy thông tin từ id
    $sql = <<<EOT
        SELECT * 
        FROM chapter_noi_dung
        WHERE chapter_noi_dung_id = $chapter_noi_dung_id;
EOT;
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // kiểm tra có id trong database không
    if(!empty($data)){
                
        // 5. Xóa file
        $uploadDir = __DIR__."/../../assets/uploads/";
        $fileDelete = $uploadDir . $data['chapter_noi_dung'];
        $a = unlink($fileDelete);
        // xóa dữ liệu trong data
        $sql = <<<EOT
        DELETE FROM chapter_noi_dung
        WHERE chapter_noi_dung_id = $chapter_noi_dung_id;
EOT;
        mysqli_query($conn, $sql);

                        
        // điều hướng về trang danh sách
        echo "<script> location.href='index.php?direction=chapter-noi-dung&chapter_id=$chapter_id&truyen_id=$truyen_id&status=success'; </script>";
    }               
    }
    
?>