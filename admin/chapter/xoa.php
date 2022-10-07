<?php
    //Lấy thông tin từ người dùng gửi
    if(isset($_GET['chapter_id']) && isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
        $chapter_id = $_GET['chapter_id'];
    // mở kết nối
    // lấy thông tin từ id
    $sql = <<<EOT
        SELECT chapter_id 
        FROM chapter
        WHERE chapter_id = $chapter_id;
EOT;
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // kiểm tra có id trong database không
    if(!empty($data)){
        // xóa dữ liệu trong data
        $sql = <<<EOT
        DELETE FROM chapter
        WHERE chapter_id = $chapter_id;
EOT;
        mysqli_query($conn, $sql);
        // điều hướng về trang danh sách
        echo "<script>location.href = 'index.php?direction=chapter&truyen_id=$truyen_id&status=success';</script>";
    }               
    }
?>