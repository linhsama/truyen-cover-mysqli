    <?php 
         // kiểm tra get có id không
    if(isset($_GET['chapter_id']) && isset($_GET['truyen_id'])){
        $chapter_id = $_GET['chapter_id'];
        $truyen_id = $_GET['truyen_id'];
    }else{
        echo '<script> location.href="/../loi.php"; </script>';
    }
 // select dữ liệu
 $sql = <<<EOT
    SELECT truyen.truyen_id,truyen_ten,chapter.chapter_id,chapter_ten,chapter_noi_dung_id,chapter_noi_dung
    FROM (truyen LEFT JOIN chapter ON truyen.truyen_id = chapter.truyen_id)
    LEFT JOIN chapter_noi_dung ON chapter.chapter_id = chapter_noi_dung.chapter_id WHERE chapter.chapter_id = '$chapter_id'
EOT; 
     $result = mysqli_query($conn, $sql);
     $data = [];
     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
         $data[] = array(
             'chapter_noi_dung_id' => $row['chapter_noi_dung_id'],
             'chapter_noi_dung' => $row['chapter_noi_dung'],
             'chapter_id' => $row['chapter_id'],
             'chapter_ten' => $row['chapter_ten'],
             'truyen_ten' => $row['truyen_ten'],
             'truyen_id' => $row['truyen_id'],
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
                            <a href="#">Quản lý nội dung chapter</a>
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
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active"
                                href="index.php?direction=chapter-noi-dung&truyen_id=<?=$truyen_id?>&chapter_id=<?=$chapter_id?>">Danh
                                sách chapter nội dung</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="index">
                    <div class="head">
                        <h3>Danh sách chapter</h3>
                    </div>

                    <p class="text-title-truyen"><?=$data[0]['truyen_ten']?></p>
                    <p class="text-title-chapter"><?=$data[0]['chapter_ten']?></p>

                    <table id="table_chapter" class="table" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th>ID</th>
                                <th>Hình ảnh</th>
                                <th class="text-center">
                                    <a
                                        href="index.php?direction=them-chapter-noi-dung&truyen_id=<?=$data[0]['truyen_id']?>&chapter_id=<?=$data[0]['chapter_id']?>">
                                        <div class="btn btn-primary"><i class="fa fa-plus"></i> Thêm mới</div>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php foreach ($data as $item):?>
                            <?php if(!empty($item['chapter_noi_dung_id'])):?>
                            <tr>
                                <td><?=$item['chapter_noi_dung_id']?></td>
                                <td>
                                    <img src="../assets/uploads/<?=$item['chapter_noi_dung']?>" class="img-fluid"
                                        style="width:100px !important;" />
                                </td>

                                <td class="text-center font-weight-bold">
                                    <div class="btn-group btn-group-sm">
                                        <a href="index.php?direction=sua-chapter-noi-dung&chapter_id=<?=$item['chapter_id']?>&truyen_id=<?=$item['truyen_id']?>&chapter_noi_dung_id=<?=$item['chapter_noi_dung_id']?>"
                                            class="btn btn-warning mr-2"><i class="fa fa-pencil" aria-hidden="true"></i>
                                            Sửa</a>

                                        <?php if(isset($_SESSION['admin'])&& $_SESSION['admin']=='admin'):?>
                                        <button type="button" class="btn btn-danger btn-delete"
                                            data-chapter_id=<?=$item['chapter_id']?>
                                            data-truyen_id=<?=$data[0]['truyen_id']?>
                                            data-chapter_noi_dung_id=<?=$data[0]['chapter_noi_dung_id']?>>
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
            var chapter_noi_dung_id = $(this).attr('data-chapter_noi_dung_id');
            location.href = ("index.php?direction=xoa-chapter&chapter_id=" + chapter_id + "&truyen_id=" + truyen_id +
                "&chapter_noi_dung_id=" + chapter_noi_dung_id);
        }
    });
});
    </script>