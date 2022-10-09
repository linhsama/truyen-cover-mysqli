<?php if(!$_SESSION['admin']){
		echo '<script> location.href="index.php?auth/dang-nh&/script>';
    }
    ?>
<?php if(isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
    }else{
		//echo '<script> location.href="/truyen-cover/frontend/pages/loi.php";</script>';
    }?>
<!-- Mở kết nối -->
<?php include_once(__DIR__ . '/../../backend/dbconnect.php'); 
 // select dữ liệu
 $sql = <<<EOT
    SELECT * FROM truyen LEFT JOIN chapter ON truyen.truyen_id = chapter.truyen_id WHERE truyen.truyen_id = '$truyen_id' ORDER BY chapter.chapter_id DESC
EOT; 
     $result = mysqli_query($conn, $sql);
     $data = [];
     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         $data[] = array(
             'chapter_id' => $row['chapter_id'],
             'chapter_so' => $row['chapter_so'],
             'chapter_ten' => $row['chapter_ten'],
             'chapter_ngay_cap_nhat' => date('H:m:s d/m/Y',strtotime($row['chapter_ngay_cap_nhat'])),
             'chapter_trang_thai' => $row['chapter_trang_thai'],
             'truyen_id' => $row['truyen_id'],
             'truyen_ten' => $row['truyen_ten'],
             'chapter_moi' => $row['chapter_moi'],
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
                        <a href="#">Quản lý truyện tranh</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="index.php?direction=truyen-tranh">Danh sách truyện
                            tranh</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="index.php?direction=chapter&truyen_id=<?=$truyen_id?>">Danh
                            sách chapter</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-data">
            <div class="index">
                <div class="head">
                    <h3>Danh sách chapter</h3>
                </div>

                <p class="text-title-chapter"><?=$data['0']['truyen_ten']?></p>

                <table id="table_chapter" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Chapter số</th>
                            <th>Tên chapter</th>
                            <th>Ngày cập nhật</th>
                            <th>Trạng thái</th>
                            <th>Chapter mới</th>
                            <th class="text-center">
                                <a href="index.php?direction=them-chapter&truyen_id=<?=$truyen_id?>">
                                    <div class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</div>
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $item):?>
                        <?php if(!empty($item['chapter_id'])):?>
                        <tr>
                            <td><?=$item['chapter_id']?></td>
                            <td><?=$item['chapter_so']?></td>
                            <td><?=$item['chapter_ten']?></td>
                            <td><?=$item['chapter_ngay_cap_nhat']?></td>
                            <td class="text-center">
                                <?php if($item['chapter_trang_thai'] == 1) : ?>
                                <p class="trang_thai_cong_bo">Công bố</p>
                                <?php elseif($item['chapter_trang_thai'] == 2) : ?>
                                <p class="trang_thai_an">Ẩn</p>
                                <?php endif?>
                            </td>
                            <td class="text-center">
                                <?php if($item['chapter_moi'] == 1) : ?>
                                <p class="trang_thai_cong_bo">Mới</p>
                                <?php elseif($item['chapter_moi'] == 0) : ?>
                                <p class="trang_thai_an">Đã cũ</p>
                                <?php endif?>
                            </td>
                            <td class="text-center font-weight-bold">
                                <div class="btn-group btn-group-sm">
                                    <a href="index.php?direction=chapter-noi-dung&chapter_id=<?=$item['chapter_id']?>&truyen_id=<?=$item['truyen_id']?>"
                                        class="btn btn-secondary mr-2"><i class="fa-regular fa-file-image"></i>
                                        Cập nhật nội dung</a>
                                    <a href="index.php?direction=sua-chapter&chapter_id=<?=$item['chapter_id']?>&truyen_id=<?=$item['truyen_id']?>"
                                        class="btn btn-warning mr-2"><i class="fa fa-pencil" aria-hidden="true"></i>
                                        Sửa</a>
                                    <?php if(isset($_SESSION['admin'])&& $_SESSION['admin']=='admin'):?>
                                    <button type="button" class="btn btn-danger btn-delete"
                                        data-chapter_id=<?=$item['chapter_id']?>
                                        data-truyen_id=<?=$data[0]['truyen_id']?>>
                                        <i class="fa fa-trash" aria-hidden="true"></i> Xóa
                                    </button>
                                    <?php endif?>

                                </div>
                            </td>
                        </tr>
                        <?php endif?>

                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    </div>
    </main>
</section>
<!-- end content -->

<!-- script -->
<?php include_once(__DIR__ . '/../../frontend/layouts/admin-scripts.php'); ?>
<script>
$('#table_chapter').DataTable({});

$(function() {
    $('.btn-delete').on('click', function() {
        var result = confirm("Bạn chắc chắn muốn xóa ?");
        if (result == true) {
            var chapter_id = $(this).attr('data-chapter_id');
            var truyen_id = $(this).attr('data-truyen_id');
            location.href = ("index.php?direction=xoa-chapter&chapter_id=" + chapter_id +
                "&truyen_id=" + truyen_id);
        }
    });
});
</script>