<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?>
<?php
    //Lấy thông tin từ người dùng gửi
    if(isset($_GET['tai_khoan_id'])){
    $tai_khoan_id = $_GET['tai_khoan_id'];
    // mở kết nối
    include_once(__DIR__ . '/../../backend/dbconnect.php'); 
    // lấy thông tin từ id
    $sql = <<<EOT
        SELECT tai_khoan_id 
        FROM tai_khoan
        WHERE tai_khoan_id = $tai_khoan_id;
EOT;
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // kiểm tra có id trong database không
    if(!empty($data)){
        // xóa dữ liệu trong data
        $sql = <<<EOT
        DELETE FROM tai_khoan
        WHERE tai_khoan_id = $tai_khoan_id AND phan_quyen != '0';
EOT;
        mysqli_query($conn, $sql);
        // điều hướng về trang danh sách
        echo "<script>location.href = 'index.php?result=success';</script>";
    }else{
        echo "<script>location.href = 'index.php?result=error';</script>";
    }
    }
?>