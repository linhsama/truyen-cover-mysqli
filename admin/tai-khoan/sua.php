<?php   
    // kiểm tra get có id không
    if(isset($_GET['tai_khoan_id'])){
        $tai_khoan_id = $_GET['tai_khoan_id'];
    }
    // selcet thông tin từ id
    $data_old = <<<EOT
        SELECT * 
        FROM tai_khoan
        WHERE tai_khoan_id = $tai_khoan_id;
EOT;
    $status_old = mysqli_query($conn, $data_old);
    $data_old = mysqli_fetch_array($status_old, MYSQLI_ASSOC);
    // end selcet thông tin từ id
    
    // check validation hiển thị lỗi php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // kiểm tra có nhấn nút cập nhật chưa
    if (isset($_POST['btn_update_tai_khoan'])) {
        $ten_hien_thi = $_POST['ten_hien_thi'];
        $ten_tai_khoan = $_POST['ten_tai_khoan'];
        $mat_khau = $_POST['mat_khau'] == $data_old['mat_khau'] ? $data_old['mat_khau'] : md5($_POST['mat_khau']);
        $phan_quyen = $_POST['phan_quyen'];
        $trang_thai = $_POST['trang_thai'];

        // tạo biến chứa lỗi
        $errors = [];

        // check required và lenght
        if (empty($ten_hien_thi)) {
            $errors['$ten_hien_thi'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $ten_hien_thi,
                'msg' => 'Vui lòng nhập tên hiển thị'
            ];
        } else if (!empty($ten_hien_thi) && strlen($ten_hien_thi) < 3) {
            $errors['$ten_hien_thi'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $ten_hien_thi,
                'msg' => 'Tên hiển thị phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($ten_hien_thi) && strlen($ten_hien_thi) > 50) {
            $errors['$truyen_ma'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $ten_hien_thi,
                'msg' => 'Tên hiển thị không được vượt quá ký tự'
            ];
        }
        if (empty($ten_tai_khoan)) {
            $errors['$ten_tai_khoan'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $ten_tai_khoan,
                'msg' => 'Vui lòng nhập tên tài khoản'
            ];
        } else if (!empty($ten_tai_khoan) && strlen($ten_tai_khoan) < 3) {
            $errors['$ten_tai_khoan'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $ten_tai_khoan,
                'msg' => 'Tên tài khoản phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($ten_tai_khoan) && strlen($ten_tai_khoan) > 50) {
            $errors['$ten_tai_khoan'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $ten_tai_khoan,
                'msg' => 'Tên tài khoản không được vượt quá 50 ký tự'
            ];
        }
        if (empty($mat_khau)) {
            $errors['$mat_khau'][] = [
                'rule' => 'required',
                'rule_value' => true,
                'value' => $mat_khau,
                'msg' => 'Vui lòng nhập mật khẩu'
            ];
        } else if (!empty($mat_khau) && strlen($mat_khau) < 3) {
            $errors['$mat_khau'][] = [
                'rule' => 'minlenght',
                'rule_value' => 3,
                'value' => $mat_khau,
                'msg' => 'Mật khẩu phải có ít nhất 3 ký tự'
            ];
        } else if (!empty($mat_khau) && strlen($mat_khau) > 50) {
            $errors['$mat_khau'][] = [
                'rule' => 'maxlenght',
                'rule_value' => 50,
                'value' => $mat_khau,
                'msg' => 'Mật khẩu không được vượt quá 50 ký tự'
            ];
        }
    } 
        // end check required và lenght
    ?>

    <!-- cập nhật thông tin -->
    <?php if(isset($_POST['btn_update_tai_khoan'])) : ?>
    <?php if( !isset($errors) || (empty($errors))): 
    $sql = <<<EOT
		UPDATE tai_khoan SET 
            ten_hien_thi = '$ten_hien_thi',
            ten_tai_khoan = '$ten_tai_khoan',
            mat_khau ='$mat_khau',
            phan_quyen = '$phan_quyen',
            trang_thai = '$trang_thai'
        WHERE tai_khoan_id = '$tai_khoan_id';
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
		echo "<script> location.href='index.php?direction=tai-khoan&status=success';</script>";
    ?>
    <?php endif; ?>
    <?php endif; ?>

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
                            <a href="#">Quản lý tài khoản</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="index.php?direction=tai-khoan">Danh sách tài khoản</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active"
                                href="index.php?direction=sua-tai-khoan&tai_khoan_id=<?=$tai_khoan_id?>">Cập
                                nhật tài khoản</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Cập nhật tài khoản</h3>
                    </div>
                    <div class="add-update">

                        <!-- tạo vùng hiển thị lỗi -->
                        <?php if(isset($_POST['btn_update_tai_khoan'])) : ?>
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
                        <!-- end tạo vùng hiển thị lỗi -->

                        <!-- form nhập liệu -->
                        <?php if(empty($data_old)): ?>
                        <h1>Dữ liệu rỗng! <a href="index?status=error">Quay lại</a></h1>
                        <?php else : ?>
                        <form class="add-update-list" id="frm_update_tai_khoan" action="" method="post">
                            <div class="col">
                                <label for="ten_hien_thi" class="form-label">Tên hiển thị</label>
                                <input type="text" class="form-control" id="ten_hien_thi" name="ten_hien_thi"
                                    value="<?= $data_old['ten_hien_thi']?>">
                            </div>
                            <div class="col">
                                <label for="ten_tai_khoan" class="form-label">Tên tài khoản</label>
                                <input type="text" class="form-control" id="ten_tai_khoan" name="ten_tai_khoan"
                                    value="<?= $data_old['ten_tai_khoan']?>">
                            </div>
                            <div class="col">
                                <label for="mat_khau" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="mat_khau" name="mat_khau"
                                    value="<?= $data_old['mat_khau']?>">
                            </div>
                            <div class="col">
                                <label for="phan_quyen" class="form-label">Phân quyền</label>
                                <select class="form-select form-control" id="phan_quyen" name="phan_quyen">
                                    <?php if(isset($_SESSION['admin'])&& $_SESSION['admin']=='admin'):?>
                                    <?php if($data_old['phan_quyen'] == '0'):?>
                                    <option value="0">Admin</option>
                                    <option value="1">Mod</option>
                                    <option value="2">User</option>
                                    <?php elseif($data_old['phan_quyen'] == '1'):?>
                                    <option value="1">Mod</option>
                                    <option value="0">Admin</option>
                                    <option value="2">User</option>
                                    <?php elseif($data_old['phan_quyen'] == '2'):?>
                                    <option value="2">User</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Mod</option>
                                    <?php endif?>
                                    <?php else:?>
                                    <?php if($data_old['phan_quyen'] == '1'):?>
                                    <option value="1">Mod</option>
                                    <option value="0">Admin</option>
                                    <option value="2">User</option>
                                    <?php elseif($data_old['phan_quyen'] == '2'):?>
                                    <option value="2">User</option>
                                    <option value="0">Admin</option>
                                    <option value="1">Mod</option>
                                    <?php endif?>
                                    <?php endif?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="trang_thai" class="form-label">Trạng thái</label>
                                <select class="form-select form-control" id="trang_thai" name="trang_thai">
                                    <?php if($data_old['trang_thai'] == '1'):?>
                                    <option value="1">Kích hoạt</option>
                                    <option value="2">Khóa</option>
                                    <?php elseif($data_old['trang_thai'] == '2'):?>
                                    <option value="2">Khóa</option>
                                    <option value="1">Kích hoạt</option>
                                    <?php endif?>
                                </select>
                            </div>
                            <br />
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary" id="btn_update_tai_khoan"
                                    name="btn_update_tai_khoan"><i class="fa-solid fa-floppy-disk"></i> Lưu thông
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