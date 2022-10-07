<?php
    // kiểm tra get có id không
    if(isset($_GET['the_loai_id'])){
        $the_loai_id = $_GET['the_loai_id'];
    }else{
        echo '<script> location.href="/truyen-cover/loi.php"; </script>';
    }
    // end kiểm tra get có id không

    // selcet thông tin từ id
    $data_old = <<<EOT
        SELECT * 
        FROM the_loai
        WHERE the_loai_id = $the_loai_id;
EOT;
    $result_old = mysqli_query($conn, $data_old);
    $data_old = mysqli_fetch_array($result_old, MYSQLI_ASSOC);
    // end selcet thông tin từ id
    
    // check validation thể loại lỗi php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // kiểm tra có nhấn nút cập nhật chưa
    if (isset($_POST['btn_update_the_loai'])) {
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
                'msg' => 'Vui lòng nhập mô tả thể loại'
            ];
        } else if (strlen($the_loai_mo_ta) < 3) {
            $errors['$the_loai_mo_ta'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $the_loai_mo_ta,
                'msg' => 'Mô tả thể loại phải có ít nhất 3 ký tự'
            ];
        } else if (strlen($the_loai_mo_ta) > 200) {
            $errors['$the_loai_mo_ta'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 200,
                'value' => $the_loai_mo_ta,
                'msg' => 'Mô tả thể loại không được vượt quá 200 ký tự'
            ];
        }
    } 
        // end check required và lenght
    ?>

<!-- cập nhật thông tin -->
<?php if(isset($_POST['btn_update_the_loai'])) : ?>
<?php if( !isset($errors) || (empty($errors))): 
    $sql = <<<EOT
		UPDATE the_loai SET 
            the_loai_ten = '$the_loai_ten',
            the_loai_mo_ta = '$the_loai_mo_ta'
        WHERE the_loai_id = '$the_loai_id';
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
		echo '<script> location.href="index.php?direction=the-loai&status=success";</script>';
    ?>
<?php endif; ?>
<?php endif; ?>
<!-- end cập nhật thông tin -->

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
                        <a class="active" href="index.php?direction=the-loai">Danh sách thể loại</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active"
                            href="index.php?direction=sua-the-loai&the_loai_id=<?=$data_old["the_loai_id"]?>">Cập
                            nhật thể loại</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-data">
            <div class="index">
                <div class="head">
                    <h3>Cập nhật thể loại</h3>
                </div>
                <div class="add-update">

                    <!-- tạo vùng thể loại lỗi -->
                    <?php if(isset($_POST['btn_update_the_loai'])) : ?>
                    <?php if( isset($errors) && (!empty($errors))): ?>
                    <div id="errors-container" class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
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
                    <!-- end tạo vùng thể loại lỗi -->

                    <!-- form nhập liệu -->
                    <?php if(empty($data_old)): ?>
                    <h1>Dữ liệu rỗng! <a href="index?result=error">Quay lại</a></h1>
                    <?php else : ?>
                    <form class="add-update-list" id="frm_update_the_loai" action="" method="post">
                        <div class="col">
                            <label for="the_loai_ten" class="form-label">Tên thể loại</label>
                            <input type="text" class="form-control" id="the_loai_ten" name="the_loai_ten"
                                value="<?= $data_old['the_loai_ten']?>">
                        </div>
                        <div class="col">
                            <label for="the_loai_mo_ta" class="form-label">Mô tả thể loại</label>
                            <textarea class="form-control" id="the_loai_mo_ta"
                                name="the_loai_mo_ta"><?= $data_old['the_loai_mo_ta']?></textarea>
                        </div>
                        <br />
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary" id="btn_update_the_loai"
                                name="btn_update_the_loai"><i class="fa-solid fa-floppy-disk"></i> Lưu thông
                                tin</button>
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
CKEDITOR.replace('the_loai_mo_ta');
</script>