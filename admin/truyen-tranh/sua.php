<?php
    
    // kiểm tra get có id không
    if(isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
    }else{
        echo '<script> location.href="/../loi.php"; </script>';
    }
    // end kiểm tra get có id không

    // selcet thông tin từ id
    $data_old = <<<EOT
        SELECT * 
        FROM truyen
        WHERE truyen_id = $truyen_id;
EOT;
    $result_old = mysqli_query($conn, $data_old);
    $data_old = mysqli_fetch_array($result_old, MYSQLI_ASSOC);
    // end selcet thông tin từ id
    
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
} 
    // end check required và lenght
    ?>


<!-- cập nhật thông tin -->
<?php if(isset($_POST['btn_add_truyen_tranh'])) : ?>
<?php if( !isset($errors) || (empty($errors))): 

 // Lấy thông tin file

    if(strlen($_FILES['truyen_anh_dai_dien']['name'])>0){
    $path = __DIR__ . "/../../assets/uploads/".$data_old['truyen_anh_dai_dien'];
    if(isset($path)){
        unlink($path);
    }
     
    $upload_dir = __DIR__ . "/../../assets/uploads/truyen-tranh/";
    $tentaptin = date('YmdHis').'_'.$_FILES['truyen_anh_dai_dien']['name'];

    move_uploaded_file($_FILES['truyen_anh_dai_dien']['tmp_name'],$upload_dir.$tentaptin);
    $ten_tap_tin = 'truyen-tranh/'.$tentaptin;
    
    include_once(__DIR__ . '/resizeImage.php'); 
    $image = new ResizeImage();
    $image->load($upload_dir.$tentaptin);
    $image->resize(200,300);
    $image->save($upload_dir.$tentaptin);
 
    }else{
        $ten_tap_tin = $data_old['truyen_anh_dai_dien'];
    }
    $sql = <<<EOT
		UPDATE truyen SET 
        truyen_ma = '$truyen_ma',
        truyen_ten = '$truyen_ten',
        truyen_tac_gia ='$truyen_tac_gia',
        truyen_mo_ta = '$truyen_mo_ta',
        truyen_anh_dai_dien = '$ten_tap_tin',
        truyen_tinh_trang = '$truyen_tinh_trang',
        truyen_trang_thai = '$truyen_trang_thai'
        WHERE truyen_id = '$truyen_id';
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
		echo '<script> location.href="index.php?direction=truyen-tranh&status=success";</script>';
    ?>
<?php endif; ?>
<?php endif; ?>
<!-- end cập nhật thông tin -->

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
                        <a href="#">Quản lý truyện tranh</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="index.php?direction=truyen-tranh">Danh sách truyện
                            tranh</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active"
                            href="index.php?direction=sua-truyen-tranh&truyen_id=<?=$data_old["truyen_id"]?>">Cập
                            nhật truyện tranh</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-data">
            <div class="index">
                <div class="head">
                    <h3>Cập nhật truyện tranh</h3>
                    <a href="truyen-the-loai.php?truyen_id=<?=$data_old['truyen_id']?>" class="btn btn-secondary"><i
                            class="fa-solid fa-book-bible"></i> Cập nhật truyện thể loại
                    </a>
                    <a href="../chapter/index.php?truyen_id=<?=$data_old['truyen_id']?>" class="btn btn-primary"><i
                            class="fa-solid fa-book-bible"></i> Cập nhật chapter
                    </a>
                </div>

                <div class="add-update">
                    <!-- tạo vùng hiển thị lỗi -->
                    <?php if(isset($_POST['btn_add_truyen_tranh'])) : ?>
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
                    <!-- end tạo vùng hiển thị lỗi -->

                    <!-- form nhập liệu -->
                    <?php if(empty($data_old)): ?>
                    <h1>Dữ liệu rỗng! <a href="index?result=error">Quay lại</a></h1>
                    <?php else : ?>
                    <form class="add-update-list" id="frm_update_truyen_tranh" action="" method="post"
                        enctype="multipart/form-data">

                        <div class="col">
                            <label for="truyen_ma" class="form-label">Mã truyện</label>
                            <input type="text" class="form-control" id="truyen_ma" name="truyen_ma"
                                value=<?= $data_old['truyen_ma']?>>
                        </div>
                        <div class="col">
                            <label for="truyen_ten" class="form-label">Tên truyện</label>
                            <input type="text" class="form-control" id="truyen_ten" name="truyen_ten"
                                value=<?= $data_old['truyen_ten']?>>
                        </div>
                        <div class="col">
                            <label for="truyen_tac_gia" class="form-label">Tác giả</label>
                            <input type="text" class="form-control" id="truyen_tac_gia" name="truyen_tac_gia"
                                value=<?= $data_old['truyen_tac_gia']?>>
                        </div>
                        <div class="col">
                            <label for="truyen_mo_ta" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="truyen_mo_ta"
                                name="truyen_mo_ta"><?= $data_old['truyen_mo_ta']?></textarea>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="truyen_anh_dai_dien">Hình ảnh</label>
                                <input type="file" class="form-control" id="truyen_anh_dai_dien"
                                    name="truyen_anh_dai_dien" accept=".jpg, .jpeg, .png, .gif" />

                                <div class="preview-img-container text-center">
                                    <img src="../assets/uploads/<?=$data_old['truyen_anh_dai_dien'];?>" id="preview-img"
                                        height="200px" />
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label for="truyen_tinh_trang" class="form-label">Tình trạng truyện</label>
                            <select class="form-select form-control" id="truyen_tinh_trang" name="truyen_tinh_trang">
                                <?php if($data_old['truyen_tinh_trang']==1) :?>
                                <option value="1">Đang cập nhật</option>
                                <option value="2">Hoàn thành</option>
                                <option value="3">Tạm ngừng</option>
                                <?php elseif($data_old['truyen_tinh_trang']==2) :?>
                                <option value="2">Hoàn thành</option>
                                <option value="1">Đang cập nhật</option>
                                <option value="3">Tạm ngừng</option>
                                <?php elseif($data_old['truyen_tinh_trang']==3) :?>
                                <option value="3">Tạm ngừng</option>
                                <option value="1">Đang cập nhật</option>
                                <option value="2">Hoàn thành</option>
                                <?php else:?>
                                <option value="1">Đang cập nhật</option>
                                <option value="2">Hoàn thành</option>
                                <option value="3">Tạm ngừng</option>
                                <?php endif?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="truyen_trang_thai" class="form-label">Trạng thái</label>
                            <select class="form-select form-control" id="truyen_trang_thai" name="truyen_trang_thai">
                                <?php if($data_old['truyen_trang_thai']==1) :?>
                                <option value="1">Công bố</option>
                                <option value="2">Ẩn</option>
                                <?php elseif($data_old['truyen_trang_thai']==2) :?>
                                <option value="2">Ẩn</option>
                                <option value="1">Công bố</option>
                                <?php else:?>
                                <option value="1">Công bố</option>
                                <option value="2">Ẩn</option>
                                <?php endif?>
                            </select>
                        </div>
                        <br />
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary" id="btn_add_truyen_tranh"
                                name="btn_add_truyen_tranh"><i class="fa-solid fa-floppy-disk"></i> Lưu thông
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