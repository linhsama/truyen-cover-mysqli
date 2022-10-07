<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/auth/dang-nhap.php";</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-pinItDow=1.0">
    <title>Quản lý thể loại</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-styles.php'); ?>
</head>

<body>
    <?php 
    // select dữ liệu
    $sql = <<<EOT
        SELECT the_loai_id, the_loai_ten, the_loai_mo_ta
        FROM the_loai
        ORDER BY the_loai_id DESC
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
                            <a href="#">Quản lý thể loại</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="index.php?direction=the-loai">Danh sách thể loại</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Danh sách thể loại</h3>
                    </div>

                    <br />
                    <br />
                    <table id="table_the_loai" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên thể loại</th>
                                <th>Mô tả</th>
                                <th class="text-center">
                                    <a href="index.php?direction=them-the-loai">
                                        <div class="btn-sm btn-primary"><i class="fa fa-plus"></i> Thêm mới</div>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item):?>
                            <tr>
                                <td><?=$item['the_loai_id']?></td>
                                <td><?=$item['the_loai_ten']?></td>
                                <td><?=$item['the_loai_mo_ta']?></td>
                                <td class="text-center font-weight-bold">
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-warning btn-update"
                                            data-the_loai_id=<?=$item['the_loai_id']?>>
                                            <i class="fa fa-edit" aria-hidden="true"></i> Sửa
                                        </button>
                                        <?php if(isset($_SESSION['admin'])&& $_SESSION['admin']=='admin'):?>
                                        <button type="button" class="btn btn-danger btn-delete"
                                            data-the_loai_id=<?=$item['the_loai_id']?>>
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
    $('#table_the_loai').DataTable({});
    // var table = $('#table_the_loai').DataTable({
    //     lengthChange: false,
    //     buttons: ['excel', 'print']
    // });

    // table.buttons().container()
    //     .appendTo('#table_tai-khoan_wrapper .col-md-6:eq(0)');

    $(function() {
        $('.btn-delete').on('click', function() {
            var result = confirm("Bạn chắc chắn muốn xóa ?");
            if (result == true) {
                var id = $(this).attr('data-the_loai_id');
                location.href = ("index.php?direction=xoa-the-loai&the_loai_id=" + id);
            }
        });
        $('.btn-update').on('click', function() {
            var id = $(this).attr('data-the_loai_id');
            location.href = ("index.php?direction=sua-the-loai&the_loai_id=" + id);
        });
    });
    </script>


</body>

</html>