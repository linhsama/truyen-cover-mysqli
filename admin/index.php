<?php session_start()?>

<?php if(!isset($_SESSION['admin'])){
		echo '<script> location.href="/truyen-cover/admin/auth/dang-nhap.php";</script>';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/../frontend/layouts/admin-styles.php'); ?>
    <link rel="stylesheet" href="/truyen-cover/assets/css/admin-dashboard.css" type="text/css" />
</head>

<body>

    <!-- navigation -->
    <?php 
    include_once(__DIR__ . '/../frontend/partials/admin-sidebar.php');
    include_once(__DIR__ . '/../backend/dbconnect.php'); 
    include_once(__DIR__ . '/../backend/custom_fomart.php'); 


// select dữ liệu
    $sql_tai_khoan = <<<EOT
    SELECT COUNT(tai_khoan_id) AS count_tai_khoan
    FROM tai_khoan
EOT; 
    $result_tai_khoan = mysqli_query($conn, $sql_tai_khoan);
    $data_tai_khoan =  mysqli_fetch_array($result_tai_khoan, MYSQLI_ASSOC);

    $sql_truyen = <<<EOT
    SELECT COUNT(truyen_id) AS count_truyen
    FROM truyen
EOT; 
    $result_truyen = mysqli_query($conn, $sql_truyen);
    $data_truyen=  mysqli_fetch_array($result_truyen, MYSQLI_ASSOC);

    $sql_chapter = <<<EOT
    SELECT COUNT(chapter_id) AS count_chapter
    FROM chapter
EOT; 
    $result_chapter = mysqli_query($conn, $sql_chapter);
    $data_chapter =  mysqli_fetch_array($result_chapter, MYSQLI_ASSOC);
      
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
                'truyen_ngay_dang' => strtotime($row['truyen_ngay_dang']),
                'truyen_trang_thai' => $row['truyen_trang_thai'],
            );
        }
   ?>


    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Dashboard</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="box-title-1"><i class="fa-solid fa-chart-simple"></i> THỐNG KÊ</div>
            <ul class="box-info">
                <li>
                    <i class='bx bxs-book-bookmark'></i>
                    <span class="text">
                        <h3>Truyện tranh</h3>
                        <p><?=$data_truyen['count_truyen'] ?></p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3>Người dùng</h3>
                        <p><?=$data_tai_khoan['count_tai_khoan'] ?></p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-book-heart'></i>
                    <span class="text">
                        <h3>Chapter</h3>
                        <p><?=$data_chapter['count_chapter'] ?></p>
                    </span>
                </li>
            </ul>
            <div class="box-title-2"><i class="fa-solid fa-ranking-star"></i> TOP LƯỢT XEM</div>
            <!-- Top -->
            <ul class="box-info">
                <!-- Top view  -->
                <?php $num = 0;?>
                <?php foreach($data_top_view as $item):?>
                <?php $num++?>
                <li>
                    <div class="item-poster">
                        <div class="box-title-3 background-<?=$num?>"><i class="fa-solid fa-star"></i> TOP <?=$num?></div>
                        <div class="item-thumbnail">
                            <img src="/truyen-cover/assets/uploads/<?=$item['truyen_anh_dai_dien']?>">
                        </div>
                        <div class="box-title-4"><?=$item['truyen_ten']?></div>
                        <div class="background-1"><i class="fas fa-eye"></i> <?=thousand_format($item['truyen_luot_xem'])?></div>
                        <div class="background-2"><i class="fas fa-clock"></i> <?=get_time_ago($item['truyen_ngay_dang'])?></div>
                    </div>
                    <?php endforeach?>
                </li>
            </ul>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/../frontend/layouts/admin-scripts.php'); ?>
</body>

</html>