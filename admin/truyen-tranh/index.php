<?php 
    // select dữ liệu
    $sql = <<<EOT
    SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_anh_dai_dien,
    truyen_mo_ta,truyen_tinh_trang,truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
    FROM truyen
    ORDER BY truyen_id DESC
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
                        <a class="active" href="index.php?direction=truyen-tranh">Danh sách truyện
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
                            <th>#</th>
                            <th>Tên truyện</th>
                            <th>Tác giả</th>
                            <th>Mô tả</th>
                            <th>Thể loại</th>
                            <th>Tình trạng</th>
                            <th>Lượt xem</th>
                            <th>Ngày đăng</th>
                            <th>Trạng thái</th>
                            <th class="text-center">
                                <a href="index.php?direction=them-truyen-tranh">
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
                            <td><img src="../assets/uploads/<?=$item['truyen_anh_dai_dien']?>" style="height:100px" />
                            </td>
                            <td><?=$item['truyen_ten']?></td>
                            <td><?=$item['truyen_tac_gia']?></td>
                            <td class="mo-ta"><?=$item['truyen_mo_ta']?></td>
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

                                    <button type="button" class="btn btn-secondary btn-the-loai"
                                        data-truyen_id=<?=$item['truyen_id']?>>
                                        <i class="fa-solid fa-book-bible"></i> Thêm thể loại
                                    </button>

                                    <button type="button" class="btn btn-warning btn-update"
                                        data-truyen_id=<?=$item['truyen_id']?>>
                                        <i class="fa fa-edit" aria-hidden="true"></i> Sửa
                                    </button>
                                </div>

                                <div class="btn-group">

                                    <button type="button" class="btn btn-primary btn-chapter"
                                        data-truyen_id=<?=$item['truyen_id']?>>
                                        <i class="fa-solid fa-book-bible"></i> Thêm chapter
                                    </button>

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
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</section>
<!-- end content -->
<?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>

<script>
$('#table_truyen-tranh').DataTable({});

$(function() {
    $('.btn-delete').on('click', function() {
        var result = confirm("Bạn chắc chắn muốn xóa ?");
        if (result == true) {
            var id = $(this).attr('data-truyen_id');
            location.href = ("index.php?direction=xoa-truyen-tranh&truyen_id=" + id);
        }
    });

    $('.btn-update').on('click', function() {
        var id = $(this).attr('data-truyen_id');
        location.href = ("index.php?direction=sua-truyen-tranh&truyen_id=" + id);
    });


    $('.btn-the-loai').on('click', function() {
        var id = $(this).attr('data-truyen_id');
        location.href = ("index.php?direction=truyen-the-loai&truyen_id=" + id);
    });


    $('.btn-chapter').on('click', function() {
        var id = $(this).attr('data-truyen_id');
        location.href = ("index.php?direction=chapter&truyen_id=" + id);
    });
});
</script>