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
    <title>Thêm truyện tranh</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-styles.php'); ?>
</head>

<body>
    <!-- Mở kết nối -->
    <?php include_once(__DIR__ . '/../../backend/dbconnect.php'); 

    // check validation hiển thị lỗi php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // kiểm tra có nhấn nút cập nhật chưa
    if (isset($_POST['btn_add_truyen_tranh'])) {
        $truyen_ma = $_POST['truyen_ma'];
        $truyen_ten = $_POST['truyen_ten'];
        $truyen_tac_gia = $_POST['truyen_tac_gia'];
        $truyen_mo_ta = $_POST['truyen_mo_ta'];
        $truyen_tinh_trang = $_POST['truyen_tinh_trang'];
        $truyen_trang_thai = $_POST['truyen_trang_thai'];

        // tạo biến chứa lỗi
        $errors = [];

        // check required và lenght
        if (empty($truyen_ma)) {
            $errors['$truyen_ma'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $truyen_ma,
                'msg' => 'Vui lòng nhập mã truyện'
            ];
        } else if (!empty($truyen_ma) && strlen($truyen_ma) < 3) {
            $errors['$truyen_ma'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $truyen_ma,
                'msg' => 'Mã truyện phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($truyen_ma) && strlen($truyen_ma) > 50) {
            $errors['$truyen_ma'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $truyen_ma,
                'msg' => 'Mã truyện không được vượt quá ký tự'
            ];
        }

        if (empty($truyen_ten)) {
            $errors['$truyen_ten'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $truyen_ten,
                'msg' => 'Vui lòng nhập tên truyện'
            ];
        } else if (!empty($truyen_ten) && strlen($truyen_ten) < 3) {
            $errors['$truyen_ten'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $truyen_ten,
                'msg' => 'Tên truyện phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($truyen_ten) && strlen($truyen_ten) > 50) {
            $errors['$truyen_ten'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $truyen_ten,
                'msg' => 'Tên truyện không được vượt quá 50 ký tự'
            ];
        }

        if (empty($truyen_tac_gia)) {
            $errors['$truyen_tac_gia'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $truyen_tac_gia,
                'msg' => 'Vui lòng nhập tác giả'
            ];
        } else if (!empty($truyen_tac_gia) && strlen($truyen_tac_gia) < 3) {
            $errors['$truyen_tac_gia'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $truyen_tac_gia,
                'msg' => 'Tác giả phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($truyen_tac_gia) && strlen($truyen_tac_gia) > 50) {
            $errors['$truyen_tac_gia'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $truyen_tac_gia,
                'msg' => 'Tác giả không được vượt quá ký tự'
            ];
        }

        if (empty($truyen_mo_ta)) {
            $errors['$truyen_mo_ta'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $truyen_mo_ta,
                'msg' => 'Vui lòng nhập mô tả'
            ];
        } else if (!empty($truyen_mo_ta) && strlen($truyen_mo_ta) < 3) {
            $errors['$truyen_mo_ta'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $truyen_mo_ta,
                'msg' => 'Mô tả phải có ít nhất 3 ký tự'
            ];
        }else if (!empty($truyen_mo_ta) && strlen($truyen_mo_ta) > 2000) {
            $errors['$truyen_mo_ta'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 2000,
                'value' => $truyen_mo_ta,
                'msg' => "Mô tả không được vượt quá 2000 ký tự. Số ký tự vừa nhập là: ".strlen($truyen_mo_ta)
            ];
        }
             // select dữ liệu
             $sql = <<<EOT
             SELECT the_loai_id, the_loai_ten, the_loai_mo_ta
             FROM the_loai
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
    } 
        // end check required và lenght
    ?>

    <!-- thêm thông tin -->
    <?php if(isset($_POST['btn_add_truyen_tranh'])) : ?>
    <?php if( !isset($errors) OR (empty($errors))): 

        $upload_dir = __DIR__ . "/../../assets/uploads/truyen-tranh/";
        $tentaptin = date('YmdHis').'_'.$_FILES['truyen_anh_dai_dien']['name'];
        $res = move_uploaded_file($_FILES['truyen_anh_dai_dien']['tmp_name'],$upload_dir.$tentaptin);
        if($res){
            $ten_tap_tin = 'truyen-tranh/'.$tentaptin;
            $sql = <<<EOT
            INSERT INTO truyen(truyen_ma,truyen_ten,truyen_tac_gia, truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,truyen_trang_thai) 
            VALUES ('$truyen_ma','$truyen_ten','$truyen_tac_gia', '$truyen_mo_ta','$ten_tap_tin','$truyen_tinh_trang', '$truyen_trang_thai');
EOT;
            mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
 }
 echo '<script> location.href="/truyen-cover/admin/truyen-tranh/index.php?result=success";</script>';

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
                            <a href="#">Quản lý truyện</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/truyen-tranh/index.php">Danh sách truyện</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/truyen-tranh/them.php">Thêm mới truyện</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Thêm truyện</h3>
                    </div>
                    <div class="add-update">
                        <!-- vùng hiển thị lỗi -->

                        <?php if(isset($_POST['btn_add_truyen_tranh'])) : ?>
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
                        <!-- end vùng hiển thị lỗi -->

                        <!-- form nhập liệu -->
                        <form class="add-update-list" id="frm_add_update_truyen_tranh" action="" method="post"  enctype="multipart/form-data">
                            <div class="col">
                                <label for="truyen_ma" class="form-label">Mã truyện</label>
                                <input type="text" class="form-control" id="truyen_ma" name="truyen_ma">
                            </div>
                            <div class="col">
                                <label for="truyen_ten" class="form-label">Tên truyện</label>
                                <input type="text" class="form-control" id="truyen_ten" name="truyen_ten">
                            </div>
                            <div class="col">
                                <label for="truyen_tac_gia" class="form-label">Tác giả</label>
                                <input type="text" class="form-control" id="truyen_tac_gia" name="truyen_tac_gia">
                            </div>
                            <div class="col">
                                <label for="truyen_mo_ta" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="truyen_mo_ta" name="truyen_mo_ta"></textarea>
                            </div>
                            <div class="form-group col">
                                <label for="truyen_anh_dai_dien">Hình đại diện</label>
                                <div class="preview-img-container text-center">
                                    <img src="/truyen-cover/assets/default-image_600.png" id="preview-img" witdh="200px"
                                        height="220px" />
                                </div>
                                <input type="file" class="form-control" id="truyen_anh_dai_dien"
                                    name="truyen_anh_dai_dien" accept=".jpg, .jpeg, .png, .gif" />
                            </div>
                            <div class="col">
                                <label for="truyen_tinh_trang" class="form-label">Tình trạng truyện</label>
                                <select class="form-select form-control" id="truyen_tinh_trang"
                                    name="truyen_tinh_trang">
                                    <option value="1">Đang cập nhật</option>
                                    <option value="2">Hoàn thành</option>
                                    <option value="3">Tạm ngừng</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="truyen_trang_thai" class="form-label">Trạng thái</label>
                                <select class="form-select form-control" id="truyen_trang_thai"
                                    name="truyen_trang_thai">
                                    <option value="1">Công bố</option>
                                    <option value="2">Ẩn</option>
                                </select>
                            </div>
                            <br />
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary" id="btn_add_truyen_tranh"
                                    name="btn_add_truyen_tranh"><i class="fa-solid fa-floppy-disk"></i> Lưu thông
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
    CKEDITOR.replace('truyen_mo_ta');

    const reader = new FileReader();
    const fileInput = document.getElementById("truyen_anh_dai_dien");
    const img = document.getElementById("preview-img");

    fileInput.addEventListener('change', e => {
        const f = e.target.files[0];
        reader.readAsDataURL(f);
    })

    reader.onload = e => {
        img.src = e.target.result;
    }
    </script>
    <!-- end script -->
</body>

</html>