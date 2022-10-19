<?php
    $sql = <<<EOT
        SELECT tai_khoan_id,ten_hien_thi,ten_tai_khoan,mat_khau,phan_quyen,trang_thai
        FROM tai_khoan
        ORDER BY tai_khoan_id DESC
EOT;
        $result = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'tai_khoan_id' => $row['tai_khoan_id'],
                'ten_hien_thi' => $row['ten_hien_thi'],
                'ten_tai_khoan' => $row['ten_tai_khoan'],
                'mat_khau' => $row['mat_khau'],
                'phan_quyen' => $row['phan_quyen'],
                'trang_thai' => $row['trang_thai'],
            );
        }
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
                            <a href="#">Quản lý tài khoản</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="index.php?direction=tai-khoan">Danh sách tài khoản</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Danh sách tài khoản</h3>
                    </div>

                    <br />
                    <br />
                    <table id="table_tai-khoan" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên hiển thị</th>
                                <th>Tên tài khoản</th>
                                <th>Mật khẩu</th>
                                <th>Trạng thái</th>
                                <th>Phân quyền</th>
                                <th class="text-center">
                                    <a href="index.php?direction=them-tai-khoan">
                                        <div class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</div>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item):?>
                            <tr>
                                <td><?=$item['tai_khoan_id']?></td>
                                <td><?=$item['ten_hien_thi']?></td>
                                <td><?=$item['ten_tai_khoan']?></td>
                                <td><?=$item['mat_khau']?></td>
                                <td class="text-center">
                                    <?php if($item['trang_thai'] == 1) : ?>
                                    <i class="fa-solid fa-unlock"></i>
                                    <?php elseif($item['trang_thai'] == 2) : ?>
                                    <i class="fa-solid fa-lock"></i>
                                    <?php endif?>
                                </td>
                                <td>
                                    <?php if($item['phan_quyen'] == 0) : ?>
                                    <div class="admin">amin</div>
                                    <?php elseif($item['phan_quyen'] == 1) : ?>
                                    <p class="mod">mod</p>
                                    <?php elseif($item['phan_quyen'] == 2) : ?>
                                    <p class="user">user</p>
                                    <?php endif?>
                                </td>
                                <td class="text-center font-weight-bold">

                                    <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin'):?>
                                        <?php if($item['phan_quyen'] != 0) : ?>
                                        <div class="btn-group btn-group-sm">
                                            <a href="index.php?direction=sua-tai-khoan&tai_khoan_id=<?=$item['tai_khoan_id']?>"
                                                class="btn btn-warning mr-2"><i class="fa fa-pencil" aria-hidden="true"></i>
                                                Sửa</a>
                                            <button type="button" class="btn btn-danger btn-delete"
                                                data-tai_khoan_id=<?=$item['tai_khoan_id']?>>
                                                <i class="fa fa-trash" aria-hidden="true"></i> Xóa
                                            </button>
                                        </div>
                                        <?php elseif($item['phan_quyen'] == 0) : ?>
                                        <div class="btn-group btn-group-sm">
                                            <a href="index.php?direction=sua-tai-khoan&tai_khoan_id=<?=$item['tai_khoan_id']?>"
                                                class="btn btn-warning mr-2"><i class="fa fa-pencil" aria-hidden="true"></i>
                                                Sửa</a>
                                        </div>
                                        <?php endif?>
                                    <?php endif?>
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
    

    $(function() {
        $('.btn-delete').on('click', function() {
            var result = confirm("Bạn chắc chắn muốn xóa ?");
            if (result == true) {
                var id = $(this).attr('data-tai_khoan_id');
                location.href = ("index.php?direction=sua-tai-khoan&tai_khoan_id=" + id);
            }
        });
    });
    </script>
</body>

</html>