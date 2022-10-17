<?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); ?>
<?php include_once(__DIR__ . '/../../../backend/custom_fomart.php'); ?>

<!-- danh sach chapter -->
<?php
// Lấy thông tin truyện
if(isset($_GET['truyen_id']) && isset($_GET['chapter_id']) && isset($_GET['chapter_so'])) {
    $truyen_id = $_GET['truyen_id'];
    $chapter_id = $_GET['chapter_id'];
    $chapter_current = $_GET['chapter_so'];
    
    // Lấy thông tin truyện
    $sql = <<<EOT
    SELECT *
    FROM (truyen LEFT JOIN chapter ON chapter.truyen_id = truyen.truyen_id) 
    LEFT JOIN chapter_noi_dung ON chapter_noi_dung.chapter_id = chapter.chapter_id 
    WHERE truyen.truyen_id = '$truyen_id' AND chapter.chapter_id = '$chapter_id'
EOT;
    $result = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $data[] = array(
       // Thông tin truyện
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

      // Danh sách chapter
      'chapter_id' => $row['chapter_id'],
      'chapter_so' => $row['chapter_so'],
      'chapter_ten' => $row['chapter_ten'],
      'truyen_id' => $row['truyen_id'],  

      // hình ảnh
      'chapter_noi_dung_id' => $row['chapter_noi_dung_id'],
      'chapter_noi_dung' => $row['chapter_noi_dung'],
    );
    

    // Lấy thông tin chapter số
    $sql_chapter_so = <<<EOT
    SELECT MIN(chapter.chapter_so) AS chapter_min, MAX(chapter.chapter_so) AS chapter_max
    FROM truyen LEFT JOIN chapter ON chapter.truyen_id = truyen.truyen_id
    WHERE truyen.truyen_id = '$truyen_id'
    EOT;

    $result_chapter_so = mysqli_query($conn, $sql_chapter_so);
    $data_chapter_so= [];
        while ($row = mysqli_fetch_array($result_chapter_so, MYSQLI_ASSOC)) {
            $data_chapter_so = array(
            'chapter_min' => $row['chapter_min'],
            'chapter_max' => $row['chapter_max'],
            );
        }
}
 // Lấy thông tin chapter 
 $sql_chapter = <<<EOT
 SELECT *
 FROM truyen LEFT JOIN chapter ON chapter.truyen_id = truyen.truyen_id
 WHERE truyen.truyen_id = '$truyen_id' AND chapter_so != '$chapter_current'
 ORDER BY chapter_id DESC
 EOT;

 $result_chapter = mysqli_query($conn, $sql_chapter);
 $data_chapter= [];
     while ($row = mysqli_fetch_array($result_chapter, MYSQLI_ASSOC)) {
         $data_chapter[] = array(
         'chapter_id' => $row['chapter_id'],
         'chapter_so' => $row['chapter_so'],
         'chapter_ten' => $row['chapter_ten'],
         );
     }
}

// Lấy thông tin luot thich 
$sql_luot_thich = <<<EOT
SELECT COUNT(*) AS luot_thich
FROM (tuong_tac INNER JOIN chapter ON tuong_tac.chapter_id = chapter.chapter_id)
INNER JOIN truyen ON truyen.truyen_id = chapter.truyen_id
WHERE tuong_tac_loai = '2' AND truyen.truyen_id = '$truyen_id' 
EOT;

$result_luot_thich = mysqli_query($conn, $sql_luot_thich);
$data_luot_thich= [];
    while ($row = mysqli_fetch_array($result_luot_thich, MYSQLI_ASSOC)) {
        $data_luot_thich = array(
        'luot_thich' => $row['luot_thich'],
        );
    }

    // Lấy thông tin luot theo doi 
$sql_luot_theo_doi = <<<EOT
SELECT COUNT(*) AS luot_theo_doi
FROM (tuong_tac INNER JOIN chapter ON tuong_tac.chapter_id = chapter.chapter_id)
INNER JOIN truyen ON truyen.truyen_id = chapter.truyen_id
WHERE tuong_tac_loai = '3' AND truyen.truyen_id = '$truyen_id' 
EOT;

$result_luot_theo_doi = mysqli_query($conn, $sql_luot_theo_doi);
$data_luot_theo_doi= [];
    while ($row = mysqli_fetch_array($result_luot_theo_doi, MYSQLI_ASSOC)) {
        $data_luot_theo_doi = array(
        'luot_theo_doi' => $row['luot_theo_doi'],
        );
    }

// Tăng lượt xem

$luot_xem = $data[0]['truyen_luot_xem'] + 1;

$sql_luot_xem = <<<EOT
UPDATE truyen SET truyen_luot_xem = '$luot_xem' WHERE truyen_id = '$truyen_id' 
EOT;
$result_luot_xem = mysqli_query($conn, $sql_luot_xem);


// Lưu vào truyện đã xem nếu có đăng nhập

if(isset($_SESSION['user_tai_khoan_id'])){
    $tai_khoan_id = $_SESSION['user_tai_khoan_id'];
    $chapter_id = $_GET['chapter_id'];
    $truyen_id = $_GET['truyen_id'];

    // Kiểm tra truyện đã lưu chưa
    $sql_select_truyen_da_thich = <<<EOT
    SELECT * 
    FROM (tuong_tac INNER JOIN chapter ON tuong_tac.chapter_id = chapter.chapter_id)
    INNER JOIN truyen ON truyen.truyen_id = chapter.truyen_id
    WHERE tuong_tac_loai = '1' AND truyen.truyen_id = '$truyen_id' AND tai_khoan_id = '$tai_khoan_id' 
    EOT;
    $result_select_truyen_da_thich = mysqli_query($conn, $sql_select_truyen_da_thich);
    $data_select_truyen_da_thich =  mysqli_fetch_array($result_select_truyen_da_thich, MYSQLI_ASSOC);

    if(!empty($data_select_truyen_da_thich)){
        $tuong_tac_id = $data_select_truyen_da_thich['tuong_tac_id'];

        $sql_update_truyen_da_xem = <<<EOT
        UPDATE tuong_tac SET chapter_id = '$chapter_id' WHERE tuong_tac_id =  '$tuong_tac_id'
        EOT;
        $result_update_truyen_da_xem = mysqli_query($conn, $sql_update_truyen_da_xem);
    }else{
        $sql_insert_truyen_da_xem = <<<EOT
        INSERT INTO tuong_tac (tuong_tac_loai, chapter_id, tai_khoan_id) VALUES ('1','$chapter_id','$tai_khoan_id')
        EOT;
        $result_insert_truyen_da_xem = mysqli_query($conn, $sql_insert_truyen_da_xem);
    }
}

?>

<div class="container-cs chapter-page">
    <div class="container-lm">

        <section>
            <div class="column-left manga-info">
                <div class="manga-thumbnail">
                    <img src="./assets/uploads/<?=$data[0]['truyen_anh_dai_dien']?>">
                </div>
                <h1 class="manga-title">
                    <?=$data[0]['chapter_ten']?>
                </h1>
                <div class="manga-author">
                    <label>Tác giả: </label></label>
                    <span><?=$data[0]['truyen_tac_gia']?></span>
                </div>
                <div class="manga-status">
                    <label>Tình trạng: </label>
                    <span>
                        <?php 
                        if($data[0]['truyen_tinh_trang'] == 1){
                            echo "Đang cập nhật...";
                        }elseif($data[0]['truyen_tinh_trang'] == 2){
                            echo "Đã hoàn thành";
                        }elseif($data[0]['truyen_tinh_trang'] == 3){
                            echo "Tạm ngưng";
                        }
                        ?>
                    </span>
                </div>
                <div class="manga-luot_xems">
                    <label>Lượt đọc: </label>
                    <span><?=thousand_format($data[0]['truyen_luot_xem'])?></span>
                </div>

                <input type="hidden" name="user_tai_khoan_id" id="user_tai_khoan_id"
                    value="<?=isset($_SESSION['user_tai_khoan_id'])?$_SESSION['user_tai_khoan_id']:0?>">
                <input type="hidden" name="truyen_id" id="truyen_id" value="<?=$truyen_id?>">
                <input type="hidden" name="chapter_id" id="chapter_id" value="<?=$chapter_id?>">

                <button class="manga-like" id="btn_thich">Thích
                    <span id="data_luot_thich"><?=$data_luot_thich['luot_thich']?></span></button>
                <button class="manga-follow" id="btn_theo_doi">Theo dõi
                    <span id="data_luot_theo_doi"><?= $data_luot_theo_doi['luot_theo_doi']?></span></button>

            </div>
            <div class="column-right manga-description">
                <span><?=$data[0]['truyen_mo_ta']?></span>
            </div>
            <script src="./assets/vendor/jquery/jquery.min.js"></script>

            <script>
            var check_thich = true;
            var check_theo_doi = true;
            var user_tai_khoan_id = $("#user_tai_khoan_id").val();

            // Xử lý sự kiện thích
            $("#btn_thich").click(function() {
                if (user_tai_khoan_id == 0) {
                    let res = confirm("Vui lòng đăng nhập để sử dụng chức năng này");
                    if (res == true) {
                        location.href = ("./backend/auth/dang-nhap.php");
                    }
                } else {
                    $.post("./frontend/pages/chapter/xu-ly-thich-theo-doi.php", {
                            btn_thich: "btn_thich",
                            user_tai_khoan_id: $("#user_tai_khoan_id").val(),
                            truyen_id: $("#truyen_id").val(),
                            chapter_id: $("#chapter_id").val(),
                        },
                        function(data, status) {
                            if (check_thich) {
                                check_thich = false;
                                $("#data_luot_thich").html(parseInt($("#data_luot_thich").text()) + 1);
                            } else {
                                check_thich = true;
                                $("#data_luot_thich").html(parseInt($("#data_luot_thich").text()) - 1);
                            }
                        });
                }
            });


            // Xử lý sự kiện theo dõi
            $("#btn_theo_doi").click(function() {
                if (user_tai_khoan_id == 0) {
                    let res = confirm("Vui lòng đăng nhập để sử dụng chức năng này");
                    if (res == true) {
                        location.href = ("./backend/auth/dang-nhap.php");
                    }
                } else {
                    $.post("./frontend/pages/chapter/xu-ly-thich-theo-doi.php", {
                            btn_theo_doi: "btn_theo_doi",
                            user_tai_khoan_id: $("#user_tai_khoan_id").val(),
                            truyen_id: $("#truyen_id").val(),
                            chapter_id: $("#chapter_id").val(),
                        },
                        function(data, status) {
                            if (check_theo_doi) {
                                check_theo_doi = false;
                                $("#data_luot_theo_doi").html(parseInt($("#data_luot_theo_doi").text()) +
                                    1);
                            } else {
                                check_theo_doi = true;
                                $("#data_luot_theo_doi").html(parseInt($("#data_luot_theo_doi").text()) -
                                    1);
                            }
                        });
                }
            });
            </script>
        </section>
        <hr>
    </div>
    <section class="chapter">
        <div class="manga-content chapter">
            <div class="manga-action">
                <div class="manga-action" id="manga-action">
                    <?php if($chapter_current > $data_chapter_so['chapter_min']):?>
                    <div class="button button-back">
                        <a
                            href="index.php?truyen-manga=noi-dung-pre-next&truyen_id=<?= $data[0]['truyen_id'];?>&chapter_so=<?=$chapter_current-1?>">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>
                    <?php endif ?>
                    <select class="chapter-select" onchange="location = this.value;">
                        <option current>
                            Chapter <?=$chapter_current?>
                        </option>
                        <?php foreach ($data_chapter as $item_chapter):?>

                        <option
                            value="index.php?truyen-manga=noi-dung-pre-next&truyen_id=<?= $data[0]['truyen_id'];?>&chapter_so=<?=$item_chapter['chapter_so']?>">
                            Chapter <?=$item_chapter['chapter_so']?>
                        </option>
                        <?php endforeach?>
                    </select>
                    <?php if($chapter_current < $data_chapter_so['chapter_max']):?>
                    <div class="button button-forward">
                        <a
                            href="index.php?truyen-manga=noi-dung-pre-next&truyen_id=<?= $data[0]['truyen_id'];?>&chapter_so=<?=$chapter_current+1?>">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>

        <?php foreach ($data as $item) : ?>
        <div class="chapter-content text-center">
            <img src="./assets/uploads/<?=$item['chapter_noi_dung']?>" class="img-fluid">
        </div>
        <?php endforeach?>

        <div class="manga-action">
            <div class="manga-action" id="manga-action">
                <?php if($chapter_current > $data_chapter_so['chapter_min']):?>
                <div class="button button-back">
                    <a
                        href="index.php?truyen-manga=noi-dung-pre-next&truyen_id=<?= $data[0]['truyen_id'];?>&chapter_so=<?=$chapter_current-1?>">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <?php endif ?>
                <select class="chapter-select" onchange="location = this.value;">
                    <option current>
                        Chapter <?=$chapter_current?>
                    </option>
                    <?php foreach ($data_chapter as $item_chapter):?>

                    <option
                        value="index.php?truyen-manga=noi-dung-pre-next&truyen_id=<?= $data[0]['truyen_id'];?>&chapter_so=<?=$item_chapter['chapter_so']?>">
                        Chapter <?=$item_chapter['chapter_so']?>
                    </option>
                    <?php endforeach?>
                </select>
                <?php if($chapter_current < $data_chapter_so['chapter_max']):?>
                <div class="button button-forward">
                    <a
                        href="index.php?truyen-manga=noi-dung-pre-next&truyen_id=<?= $data[0]['truyen_id'];?>&chapter_so=<?=$chapter_current+1?>">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <?php endif ?>
            </div>
        </div>
        <div class="manga-comment">
            <div class="fb-comments"
                data-href="https://truyencover.herokuapp.com/index.php?truyen-manga=noi-dung-chapter&truyen_id=<?= $data[0]['truyen_id'];?>&chapter_so=<?=$item_chapter['chapter_so']?>"
                data-width="100%" data-numposts="3"></div>
        </div>
        <!-- truyen ngau nhien -->
        <div class="manga-comment">
            <?php require_once __DIR__.'/../truyen/truyen-ngau-nhien.php'?>
        </div>
</div>