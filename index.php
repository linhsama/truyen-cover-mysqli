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

    <!-- facebook plugin -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0"
        nonce="jB1NhBGh"></script>

    <!-- vchat plugin -->
    <script lang="javascript">
    var __vnp = {
        code: 17256,
        key: '',
        secret: '3fe6709227ffc978238ab858c433ec09'
    };
    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.defer = true;
        ga.src = '//core.vchat.vn/code/tracking.js';
        var s = document.getElementsByTagName('script');
        s[0].parentNode.insertBefore(ga, s[0]);
    })();
    </script>

</html>