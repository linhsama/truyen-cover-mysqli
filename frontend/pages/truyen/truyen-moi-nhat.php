<?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
<?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>
<!-- truyện mới -->
<?php
    $sql_truyen_moi = <<<EOT
        SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
        truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
        FROM truyen 
        WHERE truyen_trang_thai = "1"
        ORDER BY truyen_id DESC
        LIMIT 8
    EOT;
        $result_truyen_moi = mysqli_query($conn, $sql_truyen_moi);
        $data_truyen_moi = [];
        while ($row = mysqli_fetch_array($result_truyen_moi, MYSQLI_ASSOC)) {
            $data_truyen_moi[] = array(
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
            );
        }
?>

<!-- Truyện-mới -->
<section>
    <div class="column-left new">
        <a href="index.php?truyen-manga=tat-ca-truyen-moi">
            <div class="section-title color-4">TRUYỆN MỚI</div>
        </a>
        <?php foreach ($data_truyen_moi as $item):?>
        <?php if(!empty($item['truyen_id'])):?>
        <div class="item-large">
            <a href="index.php?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
                <div class="item-thumbnail">
                    <img src="./assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
                    <span class="background-4"><?=get_time_ago($item['truyen_ngay_dang']);?>
                    </span>
                </div>
            </a>
            <a href="index.php?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
                <h3 class="item-title color-4"><?=$item['truyen_ten']?></h3>
            </a>
            <span class="item-views"><?=thousand_format($item['truyen_luot_xem'])?> lượt xem</span>
            <div class="item-children">
                Chap mới nhất
                <?php
                $id = $item['truyen_id'];
                $sql_chap_moi = <<<EOT
                SELECT chapter_id,chapter_so,chapter_ten,chapter_ngay_cap_nhat,chapter_trang_thai
                FROM truyen INNER JOIN chapter ON chapter.truyen_id = truyen.truyen_id 
                WHERE truyen_trang_thai = "1" AND truyen.truyen_id = '$id'
                ORDER BY chapter.chapter_id DESC
                LIMIT 4
    
    EOT;
        $result_chap_moi = mysqli_query($conn, $sql_chap_moi);
        $data_chap_moi = [];
        while ($row = mysqli_fetch_array($result_chap_moi, MYSQLI_ASSOC)) {
            $data_chap_moi[] = array(
                'chapter_id' => $row['chapter_id'],
                'chapter_so' => $row['chapter_so'],
                'chapter_ten' => $row['chapter_ten'],
                'chapter_trang_thai' => $row['chapter_trang_thai'],
                'chapter_ngay_cap_nhat' => strtotime($row['chapter_ngay_cap_nhat']),
            );
        }
        if(empty($data_chap_moi)){
            echo '<br/> <i>Đang cập nhật...</i>';
        }
?>
                <?php foreach ($data_chap_moi as $item_chap_moi):?>
                <?php if(!empty($item_chap_moi['chapter_id'])):?>
                <a
                    href="index.php?truyen-manga=noi-dung-chapter&truyen_id=<?=$item['truyen_id']?>&chapter_id=<?=$item_chap_moi['chapter_id']?>&chapter_so=<?=$item_chap_moi['chapter_so']?>">
                    <span class="child-name"></span><?=$item_chap_moi['chapter_ten']?></span>
                    <span class="child-update"><?=get_time_ago($item_chap_moi['chapter_ngay_cap_nhat'])?></span>
                </a>
                <?php endif?>
                <?php endforeach?>
            </div>
        </div>
        <?php endif?>
        <?php endforeach?>
    </div>

</section>