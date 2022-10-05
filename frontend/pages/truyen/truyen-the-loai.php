<div class="container-cs container-the-loai">
    <br/>
    <div class="container-lm">
        <section>
            <?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
            <?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>

            <?php 
                if(isset($_GET['the-loai'])){
                    $the_loai = $_GET['the-loai'];
                }
            ?>
            <!-- truyện nhiều lượt đọc -->
            <?php
    $sql_top_view = <<<EOT
    SELECT *
    FROM (truyen LEFT JOIN truyen_the_loai ON truyen.truyen_id = truyen_the_loai.truyen_id)
    LEFT JOIN the_loai ON the_loai.the_loai_id = truyen_the_loai.the_loai_id
    WHERE the_loai.the_loai_id = '$the_loai'
        
    EOT;
        $result = mysqli_query($conn, $sql_top_view);
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
                'truyen_ngay_dang' => date('Y-m-d H:i:s',strtotime($row['truyen_ngay_dang'])),
                'truyen_trang_thai' => $row['truyen_trang_thai'],
                'the_loai_ten' => $row['the_loai_ten'],
                'the_loai_mo_ta' => $row['the_loai_mo_ta'],
            );
        }
?>
            <!-- Top view  -->
            <?php if(isset($data)): ?>
            <div class="section-title color-8"><?=$data[0]['the_loai_ten']?> </div>
            <div class="section-description color-7"><b>Mô tả: </b><?=$data[0]['the_loai_mo_ta']?> </div>
            <?php foreach($data as $item):?>
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
            <?php endforeach?>
            <?php else: ?>
                <h1>thể loại này chưa có truyện</h1>
            <?php endif?>
        </section>
    </div>
</div>