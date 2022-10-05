<!-- SIDEBAR -->
<section id="sidebar">
    <a href="/truyen-cover/admin/index.php" class="brand">
        <i class='bx bxs-smile'></i>
        <span class="text">TRUYỆN COVER</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="/truyen-cover/admin/index.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="/truyen-cover/admin/truyen-tranh/index.php">
                <i class='bx bx-book-add'></i>
                <span class="text">Quản lý truyện tranh</span>
            </a>
        </li>
        <li>
            <a href="/truyen-cover/admin/the-loai/index.php">
                <i class='bx bx-category-alt'></i>
                <span class="text">Quản lý thể loại</span>
            </a>
        </li>
        <li>
            <a href="/truyen-cover/admin/binh-luan/index.php">
                <i class='bx bxs-message-dots'></i>
                <span class="text">Quản lý bình luận</span>
            </a>
        </li>
        <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin'):?>

        <li>
            <a href="/truyen-cover/admin/tai-khoan/index.php">
                <i class='bx bx-group'></i>
                <span class="text">Quản lý tài khoản</span>
            </a>
        </li>
        <?php endif?>
        <br />
        <li>
            <a href="/truyen-cover/index.php">
                <i class='bx bx-desktop'></i>
                <span class="text">Trang người dùng</span>
            </a>
        </li>
        <li>
            <a href="/truyen-cover/admin/auth/dang-xuat.php" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>