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
    <meta name="viewport" content="width=device-width, initial-pinItDow=1.0">
    <title>Quản lý bình luận</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-styles.php'); ?>
</head>

<body>
    <?php if(!$_SESSION['admin']){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
    ?>
    <!-- mở kết nối -->
    <?php include_once(__DIR__ . '/../../backend/dbconnect.php'); 

    // select dữ liệu
    
    $sql = <<<EOT
    SELECT tuong_tac_id,tuong_tac_noi_dung,tuong_tac_loai, 
        chapter.chapter_id, chapter.chapter_ten, 
        tai_khoan.tai_khoan_id, ten_hien_thi
    FROM (tuong_tac inner join tai_khoan on tuong_tac.tai_khoan_id = tai_khoan.tai_khoan_id) inner join chapter on tuong_tac.chapter_id = chapter.chapter_id  
    WHERE tuong_tac_loai = 4
    ORDER BY tuong_tac_id DESC
EOT;
        $result = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'tuong_tac_id' => $row['tuong_tac_id'],
                'tuong_tac_noi_dung' => $row['tuong_tac_noi_dung'],
                'tuong_tac_loai' => $row['tuong_tac_loai'],
                'tuong_tac_thoi_gian' => $row['tuong_tac_thoi_gian'],
                'tuong_tac_trang_thai' => $row['tuong_tac_trang_thai'],
                'chapter_id' => $row['chapter_id'],
                'tai_khoan_id' => $row['tai_khoan_id'],
                'ten_hien_thi' => $row['ten_hien_thi'],
                'chapter_ten' => $row['chapter_ten'],
            );
        }
        ?>

    <!-- end select dữ liệu -->

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
                            <a href="#">Quản lý bình luận</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/binh-luan/index.php">Quản lý bình luận</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Quản lý bình luận</h3>
                    </div>

                    <br />
                    <br />
                    <table id="table_tai-khoan" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nội dung</th>
                                <th>Thời gian</th>
                                <th>Chapter</th>
                                <th>Tài khoản</th>
                                <th>Trạng thái</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item):?>
                            <tr>
                                <td><?=$item['tuong_tac_id']?></td>
                                <td><?=$item['tuong_tac_noi_dung']?></td>
                                <td><?=$item['tuong_tac_thoi_gian']?></td>
                                <td><?=$item['chapter_ten']?></td>
                                <td><?=$item['ten_hien_thi']?></td>
                                <td>
                                    <?php if($item['tuong_tac_trang_thai'] == 1) : ?>
                                    <i class="fa-solid fa-eye" style="color: blue;"></i> Hiện
                                    <?php elseif($item['tuong_tac_trang_thai'] == 2) : ?>
                                    <i class="fa-solid fa-eye-slash" style="color: red;"></i> Ẩn
                                    <?php endif?>
                                </td>
                                <td class="text-center font-weight-bold">
                                    <div class="btn-group btn-group-sm">
                                        <a href="sua.php?tuong_tac_id=<?=$item['tuong_tac_id']?>"
                                            class="btn btn-warning mr-2"><i class="fa fa-pencil" aria-hidden="true"></i>
                                            Ẩn</a>
                                        <?php if(isset($_SESSION['admin'])&& $_SESSION['admin']=='admin'):?>
                                        <button type="button" class="btn btn-danger btn-delete"
                                            data-tuong_tac_id=<?=$item['tuong_tac_id']?>>
                                            <i class="fa fa-trash" aria-hidden="true"></i> Xóa
                                        </button>
                                        <?php endif?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <!-- end content -->

    <!-- scripts -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>

    <script>
    $('#table_tai-khoan').DataTable({});
    // var table = $('#table_tai-khoan').DataTable({
    //     lengthChange: false,
    //     buttons: ['excel', 'print']
    // });

    // table.buttons().container()
    //     .appendTo('#table_tai-khoan_wrapper .col-md-6:eq(0)');

    $(function() {
        $('.btn-delete').on('click', function() {
            var result = confirm("Bạn chắc chắn muốn xóa ?");
            if (result == true) {
                var id = $(this).attr('data-tuong_tac_id');
                location.href = ("xoa.php?tuong_tac_id=" + id);
            }
        });
    });
    </script>

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