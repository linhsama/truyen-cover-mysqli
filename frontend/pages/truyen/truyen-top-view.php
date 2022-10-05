<?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>

<!-- truyện nhiều lượt đọc -->
<?php
    $sql_top_view = <<<EOT
    SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
    truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
    FROM truyen
    WHERE truyen_trang_thai = "1"
    ORDER BY truyen_luot_xem DESC
    LIMIT 3
    
    EOT;
        $result_top_view = mysqli_query($conn, $sql_top_view);
        $data_top_view = [];
        while ($row = mysqli_fetch_array($result_top_view, MYSQLI_ASSOC)) {
            $data_top_view[] = array(
                'truyen_id' => $row['truyen_id'],
                'truyen_ma' => $row['truyen_ma'],
                'truyen_ten' => $row['truyen_ten'],
                'truyen_tac_gia' => $row['truyen_tac_gia'],
                'truyen_mo_ta' => $row['truyen_mo_ta'],
                'truyen_anh_dai_dien' => $row['truyen_anh_dai_dien'],
                'truyen_tinh_trang' => $row['truyen_tinh_trang'],
                'truyen_luot_xem' => $row['truyen_luot_xem'],
                'truyen_ngay_dang' => date('Y-m-d H:i:s',strtotime($row['truyen_ngay_dang'])),
                'truyen_trang_thai' => $row['truyen_trang_thai'],
            );
        }
?>
<!-- Top view  -->
<div class="column-right">
    <a href="/truyen-cover?truyen-manga=tat-ca-truyen-top-view">
        <div class="section-title color-9">Top View</div>
    </a>
    <?php foreach($data_top_view as $item):?>

    <div class="item-large">
        <a href="/truyen-cover?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
            <div class="item-poster">
                <img src="/truyen-cover/assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
                <span class="background-9"><?=$item['truyen_luot_xem']?> lượt xem <i class="fas fa-eye"></i></span>
            </div>
        </a>
        <a href="/truyen-cover?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
            <h3 class="item-title"><?=$item['truyen_ten']?></h3>
        </a>
    </div>
    <?php endforeach?>

</div>