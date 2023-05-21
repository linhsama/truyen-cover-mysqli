<?php 
    //mysql://b4d90a3aebc398:6d2f4ef9@us-cdbr-east-06.cleardb.net/heroku_95b5f48f3ea586c?reconnect=true

    // $conn = mysqli_connect('us-cdbr-east-06.cleardb.net', 'b4d90a3aebc398', '6d2f4ef9', 'heroku_95b5f48f3ea586c') or die('Xin lỗi, database không kết nối được.');
    $conn = mysqli_connect('localhost', 'root', '', 'heroku_95b5f48f3ea586c') or die('Xin lỗi, database không kết nối được.');

    // Tùy chỉnh kết nối
    // Set charset là utf-8 đối với kết nối này. Dùng để gõ tiếng Việt, Nhật, Thái, Trung Quốc ...
    // Lưu ý: gõ với bộ gõ UNIKEY, bảng mã là UNICODE
    $conn->query("SET NAMES 'utf8mb4'"); 
    $conn->query("SET CHARACTER SET UTF8MB4");  
    $conn->query("SET SESSION collation_connection = 'utf8mb4_unicode_ci'");
?>