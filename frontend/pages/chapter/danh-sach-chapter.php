<?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>

<!-- danh sach chapter -->
<?php
    if(isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
    }

    // chap mới nhất
    $sql_chapter_moi = <<<EOT
    SELECT truyen.truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
    truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai, chapter_so, chapter_id, chapter_ten
    FROM truyen LEFT JOIN chapter ON truyen.truyen_id = chapter.truyen_id
    WHERE truyen_trang_thai = "1" AND truyen.truyen_id = '$truyen_id'
    ORDER BY chapter_id DESC
    LIMIT 1
    EOT;
        $result_chapter_moi= mysqli_query($conn, $sql_chapter_moi);
        $data_chapter_moi = mysqli_fetch_array($result_chapter_moi, MYSQLI_ASSOC);

    // chap đầu
    $sql_chapter_dau_tien = <<<EOT
    SELECT chapter_so, chapter_id, chapter_ten, chapter_ngay_cap_nhat
    FROM chapter
    WHERE truyen_id = '$truyen_id'
    ORDER BY chapter_id ASC
    EOT;
        $result_chapter_dau_tien = mysqli_query($conn, $sql_chapter_dau_tien);
        $data_chapter_dau_tien = [];
        while ($row = mysqli_fetch_array($result_chapter_dau_tien, MYSQLI_ASSOC)) {
            $data_chapter_dau_tien[] = array(
                'chapter_so' => $row['chapter_so'],
                'chapter_id' => $row['chapter_id'],
                'chapter_ten' => $row['chapter_ten'],
                'chapter_ngay_cap_nhat' => date('d/m/Y',strtotime($row['chapter_ngay_cap_nhat'])),
            );
        }
    // danh sach chapter
    $sql_danh_sach_chap = <<<EOT
    SELECT chapter_so, chapter_id, chapter_ten, chapter_ngay_cap_nhat, truyen_id
    FROM chapter
    WHERE truyen_id = '$truyen_id'
    ORDER BY chapter_id DESC
    EOT;
        $result_danh_sach_chap = mysqli_query($conn, $sql_danh_sach_chap);
        $data_danh_sach_chap = [];
        while ($row = mysqli_fetch_array($result_danh_sach_chap, MYSQLI_ASSOC)) {
            $data_danh_sach_chap[] = array(
                'truyen_id' => $row['truyen_id'],
                'chapter_so' => $row['chapter_so'],
                'chapter_id' => $row['chapter_id'],
                'chapter_ten' => $row['chapter_ten'],
                'chapter_ngay_cap_nhat' => date('d/m/Y',strtotime($row['chapter_ngay_cap_nhat'])),
            );
        }
   
?>

<div class="container-cs">
    <div class="container-lm">
        <section>
            <div class="column-left manga-info">
                <div class="manga-thumbnail">
                    <img src="/truyen-cover/assets/uploads/<?=$data_chapter_moi['truyen_anh_dai_dien']?>">
                    <?php if(!empty($data_chapter_moi['chapter_so'])):?>
                    <div class="read-continue background-3">
                        <a
                            href="/truyen-cover?truyen-manga=noi-dung-chapter&truyen_id=<?=$data_chapter_moi['truyen_id']?>&chapter_id=<?=$data_chapter_moi['chapter_id']?>&chapter_so=<?=$data_danh_sach_chap['0']['chapter_so']?>">
                            &gt;&gt; đọc chap mới nhất</a>
                    </div>
                    <?php endif?>
                </div>
                <h1 class="manga-title"><?=$data_chapter_moi['truyen_ten'] ?></h1>
                <div class="manga-author">
                    <label>Tác giả</label>
                    <span><?=$data_chapter_moi['truyen_tac_gia'] ?></span>
                </div>
                <div class="manga-status">
                    <label>Tình trạng</label>
                    <span>
                        <?php 
                        if($data_chapter_moi['truyen_tinh_trang'] == 1){
                            echo "Đang cập nhật...";
                        }elseif($data_chapter_moi['truyen_tinh_trang'] == 2){
                            echo "Đã hoàn thành";
                        }elseif($data_chapter_moi['truyen_tinh_trang'] == 3){
                            echo "Tạm ngưng";
                        }
                        ?>
                    </span>
                </div>

                <div class="manga-latest">
                    <label>Mới nhất</label>
                    <span>
                        <?php if(empty($data_danh_sach_chap)):?>
                        <a href="#" class="color-2">Đang cập nhật...</a>
                        <?php else:?>
                        <a class="color-1"
                            href="/truyen-cover?truyen-manga=noi-dung-chapter&truyen_id=<?=$data_chapter_moi['truyen_id']?>&chapter_id=<?=$data_chapter_moi['chapter_id']?>&chapter_so=<?=$item_danh_sach_chap['chapter_so']?>">Chapter <?=$data_chapter_moi['chapter_so'] ?></a>
                    </span>
                    <?php endif?>

                </div>
                <div class="manga-views">
                    <label>Lượt đọc</label>
                    <span><?=$data_chapter_moi['truyen_luot_xem'] ?></span>
                </div>

                <?php if(!empty($data_chapter_dau_tien[0]['chapter_id'])):?>
                <div class="manga-read">
                    <a class="background-7"
                        href="/truyen-cover?truyen-manga=noi-dung-chapter&truyen_id=<?=$data_chapter_moi['truyen_id']?>&chapter_id=<?=$data_chapter_moi['chapter_id']?>&chapter_so=<?=$data_chapter_dau_tien['0']['chapter_so']?>">Đọc
                        từ đầu</a>
                </div>
                <?php endif?>

                <div class="section-title color-1">Nội dung</div>
                <div class="manga-content">
                    <?=$data_chapter_moi['truyen_mo_ta']?>
                </div>
                <div class="section-title color-1">Danh sách chap</div>

                <?php if(empty($data_danh_sach_chap)):?>
                <p class="ml-5">Đang cập nhật...</p>
                <?php else:?>

                <div class="manga-chapter">
                    <div class="chapter-header">
                        <span class="chapter-name">Tên chap</span>
                        <span class="chapter-update">cập nhật</span>
                    </div>

                    <?php foreach ($data_danh_sach_chap as $item_danh_sach_chap):?>
                    <?php if(!empty($item_danh_sach_chap['chapter_id'])):?>
                    <a
                        href="/truyen-cover?truyen-manga=noi-dung-chapter&truyen_id=<?=$item_danh_sach_chap['truyen_id']?>&chapter_id=<?=$item_danh_sach_chap['chapter_id']?>&chapter_so=<?=$item_danh_sach_chap['chapter_so']?>">
                        <div class="chapter-list ps-container">
                            <div class="chapter-data_chapter_moi chapter-item">
                                <span class="chapter-name">
                                    <?=$item_danh_sach_chap['chapter_ten']?>
                                </span>
                                <span class="chapter-update">
                                    <?=$item_danh_sach_chap['chapter_ngay_cap_nhat']?>
                                </span>

                            </div>
                        </div>
                    </a>
                    <?php endif?>
                    <?php endforeach?>
                </div>
                <?php endif?>

            </div>

            <!-- truyen top view -->
            <?php require_once __DIR__.'../../truyen/truyen-top-view.php'?>

        </section>

        <!-- truyen mới nhất -->
        <section>

        </section>

        <!-- truyen ngau nhien -->
        <section>
            <?php require_once __DIR__.'/../truyen/truyen-ngau-nhien.php'?>
        </section>
    </div>
</div>