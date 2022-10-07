<?php session_start()?>
<?php 
    include_once(__DIR__ .'../../../backend/dbconnect.php');
    $sql = <<<EOT
    SELECT * 
    FROM the_loai
EOT;
    $result = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = array(
            'the_loai_id' => $row['the_loai_id'],
            'the_loai_ten' => $row['the_loai_ten'],
            );
        };
        ?>

<nav class="navbar">
    <div class="navbar-container" style="overflow: unset;">
        <div class="navbar-left">
            <a class="logo" href="./index.php">
                <img id="logo" src="./assets/logo.png">
            </a>
            <div class="navbar-toggle"><i class="fas fa-bars"></i></div>
            <div class="navbar-menu">
                <div class="navbar-search">
                    <input id="search-box" type="text" name="search" autocomplete="off">
                    <div class="icon">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
                <div class="navbar-item has-sub">
                    <a href="#"><i class="fas fa-list"></i>Danh Sách</a>
                    <ul class="navbar-item-sub">
                        <div class="menu-country">
                            <li><a href="index.php?truyen-manga=tat-ca-truyen-manga">Manga</a></li>
                            <!-- <li><a href="index.php?truyen-manhwa">Manhwa</a></li> -->
                        </div>
                        <div class="menu-genre">
                            <?php foreach($data as $item):?>
                            <li>
                                <a href="index.php?the-loai=<?=$item['the_loai_id']?>">
                                    <?=$item['the_loai_ten']?>
                                </a>
                            </li>
                            <?php endforeach?>
                        </div>
                    </ul>
                </div>
                <div class="navbar-item"><a href="index.php?truyen-manga=tat-ca-truyen-top-view"><i
                            class="fas fa-chart-line"></i>Truyện
                        Hot</a></div>
                <div class="navbar-close">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
        <div class="navbar-user">
            <?php if(!empty($_SESSION['user'])):?>
            <div class="navbar-avatar">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div class="navbar-user-action hidden">
                <a href="#">
                    <li><b><?=$_SESSION['user_ten_hien_thi']?></b></li>
                </a>
                <a href="index.php?truyen-manga=truyen-da-xem">
                    <li>Truyện đã xem</li>
                </a>
                <a href="index.php?truyen-manga=truyen-da-thich">
                    <li>Truyện Đã Thích</li>
                </a>
                <a href="index.php?truyen-manga=truyen-dang-theo-doi">
                    <li>Đang Theo Dõi</li>
                </a>
                <hr>
                <a href="./auth/chinh-sua.php">
                    <li>Chỉnh sửa</li>
                </a>
                <hr>
                <a href="./auth/dang-xuat.php">Đăng Xuất</a>
            </div>
            <?php else:?>
            <div class="navbar-avatar">
                <i class="fa-solid fa-user-lock"></i>
            </div>
            <div class="navbar-user-action hidden">
                <a href="./auth/dang-nhap.php">Đăng nhập</a>
            </div>
            <?php endif?>
        </div>
    </div>
</nav>