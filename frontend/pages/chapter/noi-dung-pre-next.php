    <?php
        //Include file cấu hình kết nối đến database, khởi tạo kết nối $conn
    include_once(__DIR__ . '/../../../backend/dbconnect.php'); 

        // Lấy chapter_id
        if(isset($_GET['truyen_id'])&& isset($_GET['chapter_so'])) {
            $truyen_id = $_GET['truyen_id'];
            $chapter_so = $_GET['chapter_so'];
            $sql_chapter_id = <<<EOT

            SELECT chapter_id
            FROM truyen LEFT JOIN chapter ON chapter.truyen_id = truyen.truyen_id
            WHERE truyen.truyen_id = '$truyen_id' AND chapter.chapter_so = '$chapter_so'
    EOT;
            // Yêu cầu PHP thực thi QUERY
            $result_chapter_id = mysqli_query($conn, $sql_chapter_id);
            // Khi thực thi các truy vấn dạng SELECT, dữ liệu lấy về cần phải phân tích để sử dụng
            $data_chapter_id = [];
                while ($row = mysqli_fetch_array($result_chapter_id, MYSQLI_ASSOC)) {
                    $data_chapter_id = array(
                    'chapter_id' => $row['chapter_id'],
                    );
                }
        $chapter_id = $data_chapter_id['chapter_id'];
            echo "<script> location.href='index.php?truyen-manga=noi-dung-chapter&truyen_id=$truyen_id&chapter_id=$chapter_id&chapter_so=$chapter_so'</script>";
        }

?>