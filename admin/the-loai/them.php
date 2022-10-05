<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thể loại</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-styles.php'); ?>
</head>

<body>
    <!-- Mở kết nối -->
    <?php include_once(__DIR__ . '/../../backend/dbconnect.php'); 

    // check validation thể loại lỗi php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // kiểm tra có nhấn nút cập nhật chưa
    if (isset($_POST['btn_add_the_loai'])) {
        $the_loai_ten = $_POST['the_loai_ten'];
        $the_loai_mo_ta = $_POST['the_loai_mo_ta'];

        // tạo biến chứa lỗi
        $errors = [];

        // check required và lenght
        if (empty($the_loai_ten)) {
            $errors['$the_loai_ten'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $the_loai_ten,
                'msg' => 'Vui lòng nhập tên thể loại'
            ];
        } else if (!empty($the_loai_ten) && strlen($the_loai_ten) < 3) {
            $errors['$the_loai_ten'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $the_loai_ten,
                'msg' => 'Tên thể loại phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($the_loai_ten) && strlen($the_loai_ten) > 50) {
            $errors['$truyen_ma'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $the_loai_ten,
                'msg' => 'Tên thể loại không được vượt quá ký tự'
            ];
        }

        if (empty($the_loai_mo_ta)) {
            $errors['$the_loai_mo_ta'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $the_loai_mo_ta,
                'msg' => 'Vui lòng nhập tên thể loại'
            ];
        } else if (!empty($the_loai_mo_ta) && strlen($the_loai_mo_ta) < 3) {
            $errors['$the_loai_mo_ta'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $the_loai_mo_ta,
                'msg' => 'Tên thể loại phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($the_loai_mo_ta) && strlen($the_loai_mo_ta) > 50) {
            $errors['$the_loai_mo_ta'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $the_loai_mo_ta,
                'msg' => 'Tên thể loại không được vượt quá 50 ký tự'
            ];
        }
    }
        // end check required và lenght
    ?>

    <!-- thêm thông tin -->
    <?php if(isset($_POST['btn_add_the_loai'])) : ?>
    <?php if( !isset($errors) OR (empty($errors))): 
    $sql = <<<EOT
		INSERT INTO the_loai(the_loai_ten,the_loai_mo_ta) 
		VALUES ('$the_loai_ten','$the_loai_mo_ta');
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
		echo '<script> location.href="/truyen-cover/admin/the-loai/index.php?result=success";</script>';

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
                            <a href="#">Quản lý thể loại</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/the-loai/index.php">Danh sách thể loại</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/the-loai/them.php">Thêm mới thể loại</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Thêm thể loại</h3>
                    </div>
                    <div class="add-update">
                        <!-- vùng thể loại lỗi -->

                        <?php if(isset($_POST['btn_add_the_loai'])) : ?>
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
                        <!-- end vùng thể loại lỗi -->

                        <!-- form nhập liệu -->
                        <form class="add-update-list" id="frm_add_update_the_loai" action="" method="post">
                            <div class="col">
                                <label for="the_loai_ten" class="form-label">Tên thể loại</label>
                                <input type="text" class="form-control" id="the_loai_ten" name="the_loai_ten">
                            </div>
                            <div class="col">
                                <label for="the_loai_mo_ta" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="the_loai_mo_ta" name="the_loai_mo_ta"></textarea>
                            </div>
                            <br />
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary" id="btn_add_the_loai"
                                    name="btn_add_the_loai"><i class="fa-solid fa-floppy-disk"></i> Lưu thông
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
    <script>
    CKEDITOR.replace('the_loai_mo_ta');
    </script>
    <!-- end script -->
</body>

</html>