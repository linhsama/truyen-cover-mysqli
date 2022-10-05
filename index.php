<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truyện Cover</title>

    <!-- CSS dùng chung cho toàn bộ trang web -->
    <?php include_once(__DIR__ . '/frontend/layouts/styles.php'); ?>

</head>

<body>
    <!-- header -->
    <?php include_once(__DIR__ . '/frontend/partials/header.php'); ?>
    <!-- end header -->

    <!-- body -->
    <div class="main-container">
        <?php include_once(__DIR__ . '/backend/controller.php'); ?>
    </div>
    <!-- end body -->

    <!-- footer -->
    <?php include_once(__DIR__ . '/frontend/partials/footer.php'); ?>
    <!-- end footer -->

    <!-- Nhúng file quản lý phần SCRIPT JAVASCRIPT -->
    <?php include_once(__DIR__ . '/frontend/layouts/scripts.php'); ?>

</body>

</html>