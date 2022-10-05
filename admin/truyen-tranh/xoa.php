<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?>
<?php
    //Lấy thông tin từ người dùng gửi
    if(isset($_GET['truyen_id'])){
    $truyen_id = $_GET['truyen_id'];
    // mở kết nối
    include_once(__DIR__ . '/../../backend/dbconnect.php'); 
    // lấy thông tin từ id
    $sql = <<<EOT
    SELECT truyen_id 
    FROM truyen
    WHERE truyen_id = $truyen_id
EOT;
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // kiểm tra có id trong database không
    if(!empty($data)){
        // xóa dữ liệu trong data
        $sql = <<<EOT
        DELETE FROM truyen
        WHERE truyen_id = $truyen_id;
EOT;
        mysqli_query($conn, $sql);
        // điều hướng về trang danh sách
        echo "<script>location.href = 'index.php?result=success';</script>";
    }
    }
?>