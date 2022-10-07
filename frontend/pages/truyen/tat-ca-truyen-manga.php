<div class="container-cs">
    <br/>
    <div class="container-lm">
        <section>
            <?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
            <?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>

            <!-- truyện đã đang cập nhật -->
            <!-- truyen_tinh_trang = 1 -->
            <?php
    $sql_dang_cap_nhat = <<<EOT
        SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
        truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
        FROM truyen 
        WHERE truyen_trang_thai = "1"
        ORDER BY truyen_id DESC
    EOT;
        $result_dang_cap_nhat = mysqli_query($conn, $sql_dang_cap_nhat);
        $data_dang_cap_nhat = [];
        while ($row = mysqli_fetch_array($result_dang_cap_nhat, MYSQLI_ASSOC)) {
            $data_dang_cap_nhat[] = array(
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

            <!-- truyện đã đang cập nhật -->
            <a href="index.php?truyen-manga=tat-ca-truyen-dang-cap-nhat">
                <div class="section-title color-8">TRUYỆN MANGA</div>
            </a>
            <?php foreach($data_dang_cap_nhat as $item):?>
            <div class="item-medium">
                <a href="index.php?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
                    <div class="item-thumbnail">
                        <img src="./assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
                        <span class="background-8"><?=thousand_format($item['truyen_luot_xem'])?><i class="fas fa-eye"></i></span>
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