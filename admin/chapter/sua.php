<?php
    // kiểm tra get có id không
    if(isset($_GET['chapter_id']) && isset($_GET['truyen_id'])){
        $chapter_id = $_GET['chapter_id'];
        $truyen_id = $_GET['truyen_id'];
    }

    // end kiểm tra get có id không

    // selcet thông tin từ id
    $data_old = <<<EOT
        SELECT * 
        FROM chapter
        WHERE chapter_id = $chapter_id;
EOT;
    $result_old = mysqli_query($conn, $data_old);
    $data_old = mysqli_fetch_array($result_old, MYSQLI_ASSOC);
    // end selcet thông tin từ id
    
    // check validation chapter lỗi php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

     // kiểm tra có nhấn nút cập nhật chưa
     if (isset($_POST['btn_update_chapter'])) {
        $chapter_so = $_POST['chapter_so'];
        $chapter_ten = $_POST['chapter_ten'];
        $chapter_trang_thai = $_POST['chapter_trang_thai'];
        $chapter_moi = $_POST['chapter_moi'];

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

<!-- cập nhật thông tin -->
<?php if(isset($_POST['btn_update_chapter'])) : ?>
<?php if( !isset($errors) || (empty($errors))): 
    $sql = <<<EOT
		UPDATE chapter SET 
            chapter_ten = '$chapter_ten',
            chapter_trang_thai = '$chapter_trang_thai',
            chapter_moi = '$chapter_moi',
            truyen_id = '$truyen_id'
        WHERE chapter_id = '$chapter_id';
EOT;
		mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
		echo "<script> location.href='index.php?direction=chapter&truyen_id=$truyen_id&status=success';</script>";
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
                        <a href="#">Quản lý chapter</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="index.php?direction=chapter&truyen_id=<?=$data_old["truyen_id"]?>">Danh
                            sách chapter</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active"
                            href="index.php?direction=sua-chapter&chapter_id=<?=$data_old["chapter_id"]?>&truyen_id=<?=$data_old["truyen_id"]?>">Cập
                            nhật chapter</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-data">
            <div class="index">
                <div class="head">
                    <h3>Cập nhật chapter</h3>
                </div>
                <div class="add-update">

                    <!-- tạo vùng chapter lỗi -->
                    <?php if(isset($_POST['btn_update_chapter'])) : ?>
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
                    <!-- end tạo vùng chapter lỗi -->

                    <!-- form nhập liệu -->
                    <?php if(empty($data_old)): ?>
                    <?php else : ?>
                    <form class="add-update-list" id="frm_update_chapter" action="" method="post">
                        <div class="col">
                            <label for="chapter_so" class="form-label">Chapter số</label>
                            <input type="text" class="form-control" id="chapter_so" name="chapter_so"
                                value=<?=$data_old['chapter_so']?> readonly="">
                        </div>
                        <div class="col">
                            <label for="chapter_ten" class="form-label">Tên chapter</label>
                            <input type="text" class="form-control" id="chapter_ten" name="chapter_ten"
                                value=<?=$data_old['chapter_ten']?>>
                        </div>
                        <div class="col">
                            <label for="chapter_trang_thai" class="form-label">Trạng thái</label>
                            <select class="form-select form-control" id="chapter_trang_thai" name="chapter_trang_thai">
                                <?php if($data_old['chapter_trang_thai']==1):?>
                                <option value="1">Công bố</option>
                                <option value="2">Ẩn</option>
                                <?php elseif($data_old['chapter_trang_thai']==2):?>
                                <option value="2">Ẩn</option>
                                <option value="1">Công bố</option>
                                <?php endif?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="chapter_moi" class="form-label">Chapter mới</label>
                            <select class="form-select form-control" id="chapter_moi" name="chapter_moi">
                                <?php if($data_old['chapter_moi']==1):?>
                                <option value="1">Mới</option>
                                <option value="0">Đã cũ</option>
                                <?php elseif($data_old['chapter_moi']==0):?>
                                <option value="0">Đã cũ</option>
                                <option value="1">Mới</option>
                                <?php endif?>
                            </select>
                        </div>
                        <br />
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary" id="btn_update_chapter"
                                name="btn_update_chapter"><i class="fa-solid fa-floppy-disk"></i> Lưu thông
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