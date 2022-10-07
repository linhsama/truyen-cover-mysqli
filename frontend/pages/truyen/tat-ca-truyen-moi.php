<div class="container-cs">
    <br/>   
<div class="container-lm">
        <section>
            <?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
            <?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>
            <?php
    $sql_truyen_moi = <<<EOT
    SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
    truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
    FROM truyen
    WHERE truyen_trang_thai = "1"
    ORDER BY truyen_id DESC
        
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
                'truyen_ngay_dang' =>strtotime($row['truyen_ngay_dang']),
                'truyen_trang_thai' => $row['truyen_trang_thai'],
            );
        }
?>
            <!-- Top view  -->
            <div class="section-title color-9">Truyện mới nhất</div>
            <?php foreach($data_truyen_moi as $item):?>
            <div class="item-medium">
                <a href="index.php?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
                    <div class="item-thumbnail">
                        <img src="./assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
                        <span class="background-10"><?=get_time_ago($item['truyen_ngay_dang'])?> <i class="fas fa-clock"></i></span>
                    </div>
                </a>
                <a href="index.php?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
                    <h3 class="item-title"><?=$item['truyen_ten']?></h3>
                </a>
            </div>
            <?php endforeach?>

        </section>
    </div>
</div>