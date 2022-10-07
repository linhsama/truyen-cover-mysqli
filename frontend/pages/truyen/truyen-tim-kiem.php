<div class="container-cs">
    <br/>
    <div class="container-lm">
        <section>
            <?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
            <?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>

            <!-- truyện đã đang cập nhật -->
            <!-- truyen_tinh_trang = 1 -->
            <?php

    if(isset($_GET['key'])){
        $key = $_GET['key'];
    }
    $sql = <<<EOT
        SELECT truyen_id,truyen_ma,truyen_ten,truyen_tac_gia,truyen_mo_ta,truyen_anh_dai_dien,truyen_tinh_trang,
        truyen_luot_xem,truyen_ngay_dang,truyen_trang_thai
        FROM truyen 
        WHERE truyen_trang_thai = "1" AND truyen.truyen_ten LIKE '%$key%'
        ORDER BY truyen_id DESC
    EOT;
        $result = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
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
            <a href="index.php?truyen-manga=tat-ca-truyen-da-hoan-thanh/">
                <div class="section-title color-5">KẾT QUẢ TÌM KIẾM</div>
            </a>
            <?php if(!empty($data)):?>

            <?php foreach($data as $item):?>
            <div class="item-medium">
                <a href="index.php?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
                    <div class="item-thumbnail">
                        <img src="./assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
                        <span class="background-5"><?=thousand_format($item['truyen_luot_xem'])?> <i class="fas fa-eye"></i></span>
                    </div>
                </a>
                <a href="index.php?truyen-manga=danh-sach-chapter&truyen_id=<?=$item['truyen_id']?>">
                    <h3 class="item-title"><?=$item['truyen_ten']?></h3>
                </a>
            </div>
            <?php endforeach?>
            <?php else:?>
            Không có truyện nào
            <?php endif?>
            <!-- floating-action -->
            <?php require_once __DIR__.'/../../partials/floating-action.php'?>
        </section>
    </div>
</div>