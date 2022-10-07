    <?php 
    if(isset($_GET['chapter_id']) && isset($_GET['truyen_id'])){
        $chapter_id = $_GET['chapter_id'];
        $truyen_id = $_GET['truyen_id'];
    }else{
		echo '<script> location.href="/../frontend/pages/loi.php";</script>';
    }

    // select dữ liệu
    $sql = <<<EOT
    SELECT truyen_ten,chapter_ten
    FROM truyen INNER JOIN chapter ON truyen.truyen_id = chapter.truyen_id
    WHERE chapter.chapter_id = '$chapter_id'
EOT; 
    $result = mysqli_query($conn, $sql); 
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    ?>
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
                            <a href="#">Quản lý nội dung chapter</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="index.php?direction=chapter&truyen_id=<?=$truyen_id?>">Danh
                                sách
                                chapter</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active"
                                href="index.php?direction=them-chapter-noi-dung&chapter_id=<?=$chapter_id?>&truyen_id=<?=$truyen_id?>">Thêm
                                mới
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
                        <!-- form nhập liệu -->
                        <form class="dropzone" id="frmThemMoi" method="post" enctype="multipart/form-data"
                            action="index.php?direction=xu-ly-upload">
                            <div class="form-row">
                                <input type="hidden" class="form-control" id="truyen_id" name="truyen_id"
                                    value="<?=$truyen_id?>">
                                <input type="hidden" class="form-control" id="chapter_id" name="chapter_id"
                                    value="<?=$chapter_id?>">
                            </div>
                            <br />
                            <div class="form-group-col text-center">
                                <button type="submit" class="btn btn-primary" name="btnLuu" id="btnLuu"> <i
                                        class="fa-solid fa-cloud-arrow-up"></i> Cập nhật nội dung chapter</button>
                            </div>
                        </form>

                    </div>

                </div>
        </main>
    </section>
    <!-- end content -->

    <!-- script -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>
    <script>
Dropzone.options.frmThemMoi = { // camelized version of the `id`
    paramName: "chapter_noi_dung", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    accept: function(file, done) {
        done();
    }
}
    </script>