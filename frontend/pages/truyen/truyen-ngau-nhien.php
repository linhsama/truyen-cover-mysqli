<?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
<?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>

<!-- truyện ngẫu nhiên -->
<?php

    if(isset($_GET['truyen_id'])){
        $truyen_id = $_GET['truyen_id'];
    }

    $sql_ngau_nhien = <<<EOT
    SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
    truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
    FROM truyen 
    WHERE truyen_trang_thai = "1" AND truyen_id NOT IN (SELECT truyen_id FROM truyen WHERE truyen_id = $truyen_id)
    ORDER BY RAND()        
    LIMIT 6
    EOT;
        $result_ngau_nhien = mysqli_query($conn, $sql_ngau_nhien);
        $data_ngau_nhien = [];
        while ($row = mysqli_fetch_array($result_ngau_nhien, MYSQLI_ASSOC)) {
            $data_ngau_nhien[] = array(
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

<!-- TRUYỆN NGẪU NHIÊN-->
<section>
    <div class="section-title color-3">TRUYỆN NGẪU NHIÊN</div>
    <?php foreach($data_ngau_nhien as $item):?>
    <?php if(!empty($item['truyen_id'])):?>
    <div class="item-medium">
        <a href="/truyen-cover?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
            <div class="item-thumbnail">
                <img src="/truyen-cover/assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
                <span class="background-3"><?=thousand_format($item['truyen_luot_xem'])?> <i class="fas fa-eye"></i></span>
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
</section>