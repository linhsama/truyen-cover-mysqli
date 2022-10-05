<?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
<?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>


<!-- truyện đã hoàn thành -->
<!-- truyen_tinh_trang = 2 -->
<?php
    $sql_hoan_thanh = <<<EOT
        SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
        truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
        FROM truyen 
        WHERE truyen_trang_thai = "1" AND truyen_tinh_trang = '2'
        ORDER BY truyen_id DESC
        LIMIT 12
    EOT;
        $result_hoan_thanh = mysqli_query($conn, $sql_hoan_thanh);
        $data_hoan_thanh = [];
        while ($row = mysqli_fetch_array($result_hoan_thanh, MYSQLI_ASSOC)) {
            $data_hoan_thanh[] = array(
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

<!-- truyen-da-hoan-thanh -->
<a href="/truyen-cover?truyen-manga=tat-ca-truyen-da-hoan-thanh">
    <div class="section-title color-5">ĐÃ HOÀN THÀNH</div>
</a>
<?php foreach($data_hoan_thanh as $item):?>
<?php if(!empty($item['truyen_id'])):?>
<div class="item-medium">
    <a href="/truyen-cover?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
        <div class="item-thumbnail">
            <img src="/truyen-cover/assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
            <span class="background-5"><?=thousand_format($item['truyen_luot_xem'])?><i class="fas fa-eye"></i></span>
        </div>
    </a>
    <a href="/truyen-cover?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
        <h3 class="item-title"><?=$item['truyen_ten']?></h3>
    </a>
</div>
<?php else:?>
Chưa có truyện nào hoàn thành...
<?php endif?>
<?php endforeach?>