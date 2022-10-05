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
    <title>Quản lý truyện tranh</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-styles.php'); ?>


    <style>
    .color_random {
        padding: 5px;
        border-radius: 10px;
        color: whitesmoke;
        font-size: 10px;
        text-align: center;
        width: fit-content;
        margin: 2px;
    }
    </style>


</head>

<body>
    
    <!-- mở kết nối -->
    <?php include_once(__DIR__ . '/../../backend/dbconnect.php'); 

    // select dữ liệu
    $sql = <<<EOT
    SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_anh_dai_dien,
    truyen_mo_ta,truyen_tinh_trang,truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
    FROM truyen
EOT; 
        $result = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'truyen_id' => $row['truyen_id'],
                'truyen_ma' => $row['truyen_ma'],
                'truyen_ten' => $row['truyen_ten'],
                'truyen_tac_gia' => $row['truyen_tac_gia'],
                'truyen_mo_ta' => $row['truyen_mo_ta'],
                'truyen_anh_dai_dien' => $row['truyen_anh_dai_dien'],
                'truyen_tinh_trang' => $row['truyen_tinh_trang'],
                'truyen_luot_xem' => $row['truyen_luot_xem'],
                'truyen_ngay_dang' => date('H:m:s d/m/Y',strtotime($row['truyen_ngay_dang'])),
                'truyen_trang_thai' => $row['truyen_trang_thai'],
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
                            <a href="#">Quản lý truyện tranh</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="/truyen-cover/admin/truyen-tranh/index.php">Danh sách truyện
                                tranh</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Quản lý truyện tranh</h3>
                    </div>
                    <table id="table_truyen-tranh" class="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Mã truyện</th>
                                <th>Tên truyện</th>
                                <th>Tác giả</th>
                                <th>Mô tả</th>
                                <th>Hình ảnh</th>
                                <th>Thể loại</th>
                                <th>Tình trạng</th>
                                <th>Lượt xem</th>
                                <th>Ngày đăng</th>
                                <th>Trạng thái</th>
                                <th class="text-center">
                                    <a href="them.php">
                                        <div class="btn-sm btn-primary"><i class="fa fa-plus"></i></div>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $item):
                                
                                $id = $item['truyen_id'];

                                $sql_the_loai = <<<EOT
                                SELECT * FROM (truyen LEFT JOIN truyen_the_loai ON truyen.truyen_id = truyen_the_loai.truyen_id) 
                                        LEFT JOIN the_loai ON truyen_the_loai.the_loai_id = the_loai.the_loai_id
                                WHERE truyen.truyen_id = '$id'
EOT;
                            $result_the_loai = mysqli_query($conn, $sql_the_loai);
                                $data_the_loai = [];
                                while ($row_the_loai = mysqli_fetch_array($result_the_loai, MYSQLI_ASSOC)) {
                                    $data_the_loai[] = array(
                                        'the_loai_ten' => $row_the_loai['the_loai_ten'],
                                    );
                                };
                                ?>
                            <tr>
                                <td><?=$item['truyen_id']?></td>
                                <td><?=$item['truyen_ma']?></td>
                                <td><?=$item['truyen_ten']?></td>
                                <td><?=$item['truyen_tac_gia']?></td>
                                <td class="mo-ta"><?=$item['truyen_mo_ta']?></td>
                                <td><img src="/truyen-cover/assets/uploads/<?=$item['truyen_anh_dai_dien']?>"
                                        style="height:100px" /></td>


                                <td>

                                    <?php  foreach ($data_the_loai as $item_the_loai):?>
                                    <?php 
                                    if(empty($item_the_loai['the_loai_ten'])):?>
                                    <p class="tinh_trang_dang_cap_nhat">Đang cập nhật...</p>
                                    <?php else:?>
                                    <p class="color_random"
                                        style="background:<?='#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);?>">
                                        <?=$item_the_loai['the_loai_ten']?>
                                    </p>
                                    <?php endif?>
                                    <?php endforeach?>

                                </td>
                                <td>
                                    <?php if($item['truyen_tinh_trang'] == 1) : ?>
                                    <p class="tinh_trang_dang_cap_nhat">Đang cập nhật...</p>
                                    <?php elseif($item['truyen_tinh_trang'] == 2) : ?>
                                    <p class="tinh_trang_hoan_thanh">Hoàn thành</p>
                                    <?php elseif($item['truyen_tinh_trang'] == 3) : ?>
                                    <p class="tinh_trang_tam_ngung">Tạm ngừng</p>
                                    <?php endif?>
                                </td>
                                <td><?=$item['truyen_luot_xem']?></td>
                                <td><?=$item['truyen_ngay_dang']?></td>

                                <td>
                                    <?php if($item['truyen_trang_thai'] == 1) : ?>
                                    <p class="trang_thai_cong_bo">Công bố</p>
                                    <?php elseif($item['truyen_trang_thai'] == 2) : ?>
                                    <p class="trang_thai_an">Ẩn</p>
                                    <?php endif?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="sua.php?truyen_id=<?=$item['truyen_id']?>"
                                            class="btn btn-warning mr-2"><i class="fa fa-pencil" aria-hidden="true"></i>
                                            Sửa
                                        </a>

                                        <?php if(isset($_SESSION['admin'])&& $_SESSION['admin']=='admin'):?>
                                        <button type="button" class="btn btn-danger btn-delete"
                                            data-truyen_id=<?=$item['truyen_id']?>>
                                            <i class="fa fa-trash" aria-hidden="true"></i> Xóa
                                        </button>
                                        <?php endif?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach ?>
                            </tbody=>
                    </table>
                </div>
            </div>
        </main>
    </section>
    <!-- end content -->

    <!-- scripts -->
    <?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>

    <script>
    $('#table_truyen-tranh').DataTable({});

    $(function() {
        $('.btn-delete').on('click', function() {
            var result = confirm("Bạn chắc chắn muốn xóa ?");
            if (result == true) {
                var id = $(this).attr('data-truyen_id');
                location.href = ("xoa.php?truyen_id=" + id);
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