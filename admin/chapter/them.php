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
    <title>Thêm chapter</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-styles.php'); ?>
</head>

<body>
    <!-- Mở kết nối -->

    <?php 
    if(isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
    }else{
		echo '<script> location.href="/truyen-cover/frontend/pages/loi.php";</script>';
    }


    include_once(__DIR__ . '/../../backend/dbconnect.php');

    // select dữ liệu
    $sql_chapter_so = <<<EOT
    SELECT * FROM chapter WHERE truyen_id = '$truyen_id' ORDER BY chapter_so desc
EOT; 
    $result_chapter_so  =mysqli_query($conn, $sql_chapter_so); 
    $data_chapter_so = mysqli_fetch_array($result_chapter_so, MYSQLI_ASSOC);

        // check validation chapter lỗi php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        // kiểm tra có nhấn nút cập nhật chưa
        if (isset($_POST['btn_add_chapter'])) {
        $chapter_so = $_POST['chapter_so'];
        $chapter_ten = $_POST['chapter_ten'];
        $chapter_trang_thai = $_POST['chapter_trang_thai'];

        // tạo biến chứa lỗi
        $errors = [];

        // check required và lenght
            if (empty($chapter_ten)) {
                $errors['$chapter_ten'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $chapter_ten,
                'msg' => 'Vui lòng nhập tên chapter'
            ];
            } else if (!empty($chapter_ten) && strlen($chapter_ten) < 3) { $errors['$chapter_ten'][]=[ 'rule'=>
                'minlenght',
                'rule_value' => 3,
                'value' => $chapter_ten,
                'msg' => 'Tên chapter phải có ít nhất 3 ký tự'
                ];
                } else if (!empty($chapter_ten) && strlen($chapter_ten) > 1000) {
                $errors['$chapter_ten'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 1000,
                'value' => $chapter_ten,
                'msg' => 'Tên chapter không được vượt quá 1000 ký tự'
                ];
            }
        }
                // end check required và lenght
    ?>

    <!-- thêm thông tin -->
    <?php if(isset($_POST['btn_add_chapter'])) : ?>
    <?php if( !isset($errors) OR (empty($errors))): 
    $sql = <<<EOT
		INSERT INTO chapter(chapter_so,chapter_ten,chapter_trang_thai,truyen_id) 
		VALUES ('$chapter_so','$chapter_ten','$chapter_trang_thai','$truyen_id');
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
		echo "<script> location.href='/truyen-cover/admin/chapter/index.php?truyen_id=$truyen_id&result=success';</script>";

    ?>
    <?php endif; ?>
    <?php endif; ?>
    <!-- end thêm thông tin -->

    <!-- navigation -->
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
                            <a class="active" href="/truyen-cover/admin/chapter/index.php">Danh sách
                                chapter</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/chapter/them.php">Thêm mới
                                chapter</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Thêm chapter</h3>
                    </div>
                    <div class="add-update">
                        <!-- vùng chapter lỗi -->

                        <?php if(isset($_POST['btn_add_chapter'])) : ?>
                        <?php if( isset($errors) && (!empty($errors))): ?>

                        <div id="errors-container" class="alert alert-danger alert-dismissible fade show mt-2"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul>
                                <?php foreach($errors as $fields):?>
                                <?php foreach($fields as $field):?>
                                <li><?php echo $field['msg'] ?></li>
                                <?php endforeach; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <?php endif; ?>
                        <?php endif; ?>
                        <!-- end vùng chapter lỗi -->

                        <!-- form nhập liệu -->
                        <form class="add-update-list" id="frm_add_update_chapter" action="" method="post">
                            <div class="col">
                                <label for="chapter_so" class="form-label">Chapter số</label>
                                <input type="text" class="form-control" id="chapter_so" name="chapter_so"
                                    value=<?=$data_chapter_so['chapter_so'] + 1?> readonly="">
                            </div>
                            <div class="col">
                                <label for="chapter_ten" class="form-label">Tên chapter</label>
                                <input type="text" class="form-control" id="chapter_ten" name="chapter_ten">
                            </div>
                            <div class="col">
                                <label for="chapter_trang_thai" class="form-label">Trạng thái</label>
                                <select class="form-select form-control" id="chapter_trang_thai"
                                    name="chapter_trang_thai">
                                    <option value="1">Công bố</option>
                                    <option value="2">Ẩn</option>
                                </select>
                            </div>
                            <br />
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary" id="btn_add_chapter"
                                    name="btn_add_chapter"><i class="fa-solid fa-floppy-disk"></i> Lưu thông
                                    tin</button>
                            </div>
                            <!-- form nhập liệu -->

                    </div>
                </div>
        </main>
    </section>
    <!-- end content -->

    <!-- script -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>
    <!-- end script -->
</body>

</html>