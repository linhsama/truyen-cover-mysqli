<?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
<?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>
<!-- chap mới -->
<?php
    $sql_chapter_moi = <<<EOT
        SELECT truyen.truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
        truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai, chapter_id, chapter_so,chapter_ten
        FROM truyen inner join chapter on truyen.truyen_id = chapter.truyen_id  AND chapter_trang_thai = 1
        WHERE truyen_trang_thai = "1" and chapter_moi = "1"
        ORDER BY chapter_id DESC
        LIMIT 6
    EOT;
        $result_chapter_moi = mysqli_query($conn, $sql_chapter_moi);
        $data_chapter_moi = [];
        while ($row = mysqli_fetch_array($result_chapter_moi, MYSQLI_ASSOC)) {
            $data_chapter_moi[] = array(
                'truyen_id' => $row['truyen_id'],
                'truyen_ma' => $row['truyen_ma'],
                'truyen_ten' => $row['truyen_ten'],
                'truyen_tac_gia' => $row['truyen_tac_gia'],
                'truyen_mo_ta' => $row['truyen_mo_ta'],
                'truyen_anh_dai_dien' => $row['truyen_anh_dai_dien'],
                'truyen_tinh_trang' => $row['truyen_tinh_trang'],
                'truyen_luot_xem' => $row['truyen_luot_xem'],
                'truyen_ngay_dang' => strtotime($row['truyen_ngay_dang']),
                'truyen_trang_thai' => $row['truyen_trang_thai'],
                'chapter_id' => $row['chapter_id'],
                'chapter_so' => $row['chapter_so'],
                'chapter_ten' => $row['chapter_ten'],
            );
        }
?>
<a href="index.php?truyen-manga=tat-ca-truyen-da-hoan-thanh">
    <div class="section-title color-5">CHAPTER MỚI</div>
</a>
<?php foreach($data_chapter_moi as $item):?>
<?php if(!empty($item['truyen_id'])):?>
<div class="item-medium">
    <a
        href="index.php?truyen-manga=noi-dung-chapter&truyen_id=<?=$item['truyen_id']?>&chapter_id=<?=$item['chapter_id']?>&chapter_so=<?=$item['chapter_so']?>">
        <div class="item-thumbnail">
            <img src="./assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
            <span class="background-10"><?=$item['chapter_ten']?> <i class="fa-solid fa-star"></i></span>
        </div>
    </a>


    <a
        href="index.php?truyen-manga=noi-dung-chapter&truyen_id=<?=$item['truyen_id']?>&chapter_id=<?=$item['chapter_id']?>&chapter_so=<?=$item['chapter_so']?>">
        <h3 class="item-title"><?=$item['truyen_ten']?></h3>
    </a>
</div>
<?php endif?>
<?php endforeach?>