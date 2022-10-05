<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật chapter nội dung</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-styles.php'); ?>
</head>

<body>
    <!-- Mở kết nối -->
    <?php include_once(__DIR__ . '/../../backend/dbconnect.php'); 
   
    // kiểm tra get có id không
    if(isset($_GET['chapter_id']) && isset($_GET['truyen_id']) && isset($_GET['chapter_noi_dung_id'])){
        $chapter_id = $_GET['chapter_id'];
        $truyen_id = $_GET['truyen_id'];
        $chapter_noi_dung_id = $_GET['chapter_noi_dung_id'];
    }else{
        echo '<script> location.href="/truyen-cover/loi.php"; </script>';
    }
    // end kiểm tra get có id không

    // selcet thông tin từ id
    $data_old = <<<EOT
        SELECT * 
        FROM chapter_noi_dung
        WHERE chapter_noi_dung_id = $chapter_noi_dung_id;
EOT;
        $result_old = mysqli_query($conn, $data_old);
        $data_old = mysqli_fetch_array($result_old, MYSQLI_ASSOC);


     if(isset($_POST['btn_upload'])){
        $chapter_id = $_POST['chapter_id'];
        $chapter_noi_dung_id = $_POST['chapter_noi_dung_id'];
 
         // Lấy thông tin file
         $upload_dir = __DIR__ . "/../../assets/uploads/";
         $ten_tap_tin = $data_old['chapter_noi_dung'];

         // Kiểm tra file có tồn tại chưa
         $url = getimagesize($upload_dir.$ten_tap_tin);

         if (is_array($url)) {
            // 2. Xóa dữ liệu trong data
            unlink($upload_dir.$ten_tap_tin);
         }
         $upload_dir = __DIR__ . "/../../assets/uploads/truyen-tranh/";
         $tentaptin = date('YmdHis').'_'.$_FILES['chapter_noi_dung']['name'];
         move_uploaded_file($_FILES['chapter_noi_dung']['tmp_name'],$upload_dir.$tentaptin);
         $ten_tap_tin = 'truyen-tranh/'.$tentaptin;
         
         // chuẩn bị câu lệnh sửa
         $sql = <<<EOT
         UPDATE chapter_noi_dung SET
            chapter_id = '$chapter_id',
            chapter_noi_dung = '$ten_tap_tin'
         WHERE chapter_noi_dung_id = '$chapter_noi_dung_id';
 EOT;
         mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
        echo "<script> location.href='/truyen-cover/admin/chapter-noi-dung/index.php?chapter_id=$chapter_id&truyen_id=$truyen_id&result=success'; </script>";
        }
        ?>

    <!--End Kiểm tra dữ liệu-->
    <?php include_once(__DIR__ . '/../../frontend/partials/admin-sidebar.php'); ?>
    <!-- end navigation -->

    <!-- content -->
    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
        </nav>
        <main>
            <div class="head-title">
                <div class="left">
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Quản lý chapter</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active"
                                href="/truyen-cover/admin/chapter-noi-dung/index.php?truyen_id=<?=$truyen_id?>&chapter_id=<?=$chapter_id?>">Danh
                                sách nội dung chapter</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active"
                                href="/truyen-cover/admin/chapter-noi-dung/sua.php?chapter_id=<?=$chapter_id?>&truyen_id=<?=$truyen_id?>">Cập
                                nhật nội dung chapter</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Cập nhật nội dung chapter</h3>
                    </div>
                    <div class="add-update">
                        <!-- form nhập liệu -->
                        <?php if(empty($data_old)): ?>
                        <h1>Dữ liệu rỗng! <a href="index?result=error">Quay lại</a></h1>
                        <?php else : ?>
                        <form class="add-update-list" name="frm_update_chapter_noi_dung" action="" method="post"
                            enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="chapter_noi_dung">Hình ảnh</label>
                                <div class="preview-img-container text-center">
                                    <img src="/truyen-cover/assets/uploads/<?=$data_old['chapter_noi_dung'];?>"
                                        id="preview-img" height="400px" />
                                    <br />
                                    <div class="input-group btn-update">
                                        <input type="file" class="form-control" id="chapter_noi_dung"
                                            name="chapter_noi_dung" accept=".jpg, .jpeg, .png, .gif" required="" />
                                        <input type="hidden" class="form-control" name="chapter_id"
                                            value="<?=$chapter_id ?>" ?>
                                        <input type="hidden" class="form-control" name="chapter_noi_dung_id"
                                            value="<?=$chapter_noi_dung_id ?>" ?>

                                        <button type="submit" class="btn btn-primary" id="btn_upload"
                                            name="btn_upload"><i class="fa-solid fa-floppy-disk"></i>
                                            Cập
                                            nhật
                                            nội dung</button>
                                    </div>
                                </div>
                        </form>
                        <?php endif?>
                        <!-- end form nhập liệu -->
                    </div>
                </div>
        </main>
    </section>
    <!-- end content -->

    <!-- script -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>
    <script>
    const reader = new FileReader();
    const fileInput = document.getElementById("chapter_noi_dung");
    const img = document.getElementById("preview-img");

    fileInput.addEventListener('change', e => {
        const f = e.target.files[0];
        reader.readAsDataURL(f);
    })

    reader.onload = e => {
        img.src = e.target.result;
    }
    </script>

</body>

</html>