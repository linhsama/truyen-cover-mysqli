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

    <?php if(isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
    }else{
		echo '<script> location.href="/truyen-cover/frontend/pages/loi.php";</script>';
    }?>
    <!-- Mở kết nối -->
    <?php include_once(__DIR__ . '/../../backend/dbconnect.php'); 
 // select dữ liệu
 $sql = <<<EOT
 SELECT * FROM the_loai WHERE the_loai_id NOT IN
  (SELECT the_loai_id FROM truyen_the_loai WHERE truyen_id = '$truyen_id')
EOT; 
     $result = mysqli_query($conn, $sql);
     $data = [];
     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         $data[] = array(
             'the_loai_id' => $row['the_loai_id'],
             'the_loai_ten' => $row['the_loai_ten'],
             'the_loai_mo_ta' => $row['the_loai_mo_ta'],
         );
     }

      // select dữ liệu
 $sql_the_loai = <<<EOT
 SELECT * 
 FROM the_loai INNER JOIN truyen_the_loai ON the_loai.the_loai_id = truyen_the_loai.the_loai_id
  WHERE truyen_id = '$truyen_id'
EOT; 
     $result_the_loai = mysqli_query($conn, $sql_the_loai);
     $data_the_loai = [];
     while ($row = mysqli_fetch_array($result_the_loai, MYSQLI_ASSOC)) {
         $data_the_loai[] = array(
             'truyen_the_loai_id' => $row['truyen_the_loai_id'],
             'the_loai_ten' => $row['the_loai_ten'],
         );
     }
// check validation hiển thị lỗi php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    // kiểm tra có nhấn nút cập nhật chưa
    if (isset($_POST['btn_add_the_loai_truyen'])) {
        if(empty($_POST['the_loai_id'])) {
            // tạo biến chứa lỗi
        $errors = [];

        // check required và lenght
        if (empty($the_loai_id)) {
            $errors['$the_loai_id'][] = [
                'msg' => 'Vui lòng chọn ít nhất 1 thể loại'
            ];
        } 
    }else{
        $the_loai_id = $_POST['the_loai_id'];
}
    }
         
        // kiểm tra có nhấn nút cập nhật chưa
        if (isset($_POST['btn_delete_the_loai_truyen'])) {
            if(empty($_POST['truyen_the_loai_id'])) {
                // tạo biến chứa lỗi
            $errors = [];
    
            // check required và lenght
            if (empty($truyen_the_loai_id)) {
                $errors['$truyen_the_loai_id'][] = [
                    'msg' => 'Vui lòng chọn ít nhất 1 thể loại'
                ];
            } 
        }else{
            $truyen_the_loai_id = $_POST['truyen_the_loai_id'];
    }
        }
    ?>

    <!-- thêm thông tin -->
    <?php if(isset($_POST['btn_add_the_loai_truyen'])) : ?>
    <?php if( !isset($errors) OR (empty($errors))): 
        foreach($the_loai_id as $selected) {
        $sql = <<<EOT
            INSERT INTO truyen_the_loai(truyen_id, the_loai_id) 
            VALUES ('$truyen_id','$selected');
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
    }
    echo "<script> location.href='/truyen-cover/admin/truyen-tranh/xu-ly-truyen-the-loai.php?truyen_id=$truyen_id';</script>";
    ?>

    <?php endif; ?>
    <?php endif; ?>

    <!-- thêm thông tin -->
    <?php if(isset($_POST['btn_delete_the_loai_truyen'])) : ?>
    <?php if( !isset($errors) OR (empty($errors))): 
        foreach($truyen_the_loai_id as $selected) {
        $sql = <<<EOT
            DELETE FROM truyen_the_loai WHERE truyen_the_loai_id = '$selected';
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
        echo "<script> location.href='/truyen-cover/admin/truyen-tranh/xu-ly-truyen-the-loai.php?truyen_id=$truyen_id';</script>";
    }
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
                            <a class="active" href="/truyen-cover/admin/truyen-tranh/index.php">Danh sách truyện
                                tranh</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/truyen-tranh/index.php">Cập nhật thể loại truyện
                                tranh</a>
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
                        <!-- vùng thể loại lỗi -->
                        <?php if(isset($_POST['btn_add_the_loai_truyen']) || isset($_POST['btn_delete_the_loai_truyen'])) : ?>
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
                        <div class="row">
                            <div class="col">
                                <form class="add-update-list" id="frm_add_the_loai_truyen" action="" method="post">
                                    <p class="text-title">Danh sách thể loại chưa thêm</p>
                                    <div class="btn-right">
                                        <button type="submit" name="btn_add_the_loai_truyen" class="btn-sm btn-success"
                                            onclick="return confirm('Bạn chắc chắn muốn thêm?')"><i
                                                class="fa-solid fa-plus"></i> Thêm</button>
                                    </div>
                                    <?php foreach ($data as $item):?>
                                    <label class="form-control">
                                        <input type="checkbox" name="the_loai_id[]" value="<?=$item['the_loai_id']?>">
                                        <?=$item['the_loai_ten']?>
                                    </label>
                                    <?php endforeach?>

                            </div>

                            </form>
                            <div class="col">
                                <form class="delete-list" id="frm_delete_the_loai_truyen" action="" method="post">
                                    <p class="text-title">Danh sách thể loại đã thêm</p>
                                    <div class="btn-right">
                                        <button type="submit" name="btn_delete_the_loai_truyen"
                                            class="btn-sm btn-danger"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa?')"><i
                                                class="fa-solid fa-minus"></i> Xóa</button>
                                    </div>
                                    <?php foreach ($data_the_loai as $item_the_loai):?>
                                    <label class="form-control">
                                        <input type="checkbox" name="truyen_the_loai_id[]"
                                            value="<?=$item_the_loai['truyen_the_loai_id']?>">
                                        <?=$item_the_loai['the_loai_ten']?>
                                    </label>
                                    <?php endforeach?>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- form nhập liệu -->
            </div>
            </div>
        </main>
    </section>
    <!-- end content -->

    <!-- script -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>
    <?php 
    if(isset($_GET['result']) && ($_GET['result']=='success')){
            echo '<script> toast.success("Thao tác thành công",500);</script>';
        }
    if(isset($_GET['result']) && ($_GET['result']=='error')){
            echo '<script> toast.error("Thao tác thành công",500);</script>';
        }
    
    ?>

</body>

</html>