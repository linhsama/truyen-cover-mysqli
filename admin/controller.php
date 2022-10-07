<?php 
    if(isset($_GET['direction'])){
    switch($_GET['direction']){
        case "dashboard":
            require __DIR__."/dashboard/index.php";
            break;
       
        case "tai-khoan":
            require __DIR__."/tai-khoan/index.php";
            break;
        case "them-tai-khoan":
            require __DIR__."/tai-khoan/them.php";
            break;
        case "sua-tai-khoan":
            require __DIR__."/tai-khoan/sua.php";
            break;
        case "xoa-tai-khoan":
            require __DIR__."/tai-khoan/xoa.php";
            break;


        case "the-loai":
            require __DIR__."/the-loai/index.php";
            break;
        case "them-the-loai":
            require __DIR__."/the-loai/them.php";
            break;
        case "sua-the-loai":
            require __DIR__."/the-loai/sua.php";
            break;
        case "xoa-the-loai":
            require __DIR__."/the-loai/xoa.php";
            break;
       
        case "truyen-tranh":
            require __DIR__."/truyen-tranh/index.php";
            break;
        case "them-truyen-tranh":
            require __DIR__."/truyen-tranh/them.php";
            break;
        case "sua-truyen-tranh":
            require __DIR__."/truyen-tranh/sua.php";
            break;
        case "xoa-truyen-tranh":
            require __DIR__."/truyen-tranh/xoa.php";
            break;

        case "truyen-the-loai":
            require __DIR__."/truyen-tranh/truyen-the-loai.php";
            break;
        case "xu-ly-truyen-the-loai":
            require __DIR__."/truyen-tranh/xu-ly-truyen-the-loai.php";
            break;

        case "chapter":
            require __DIR__."/chapter/index.php";
            break;
        case "them-chapter":
            require __DIR__."/chapter/them.php";
            break;
        case "sua-chapter":
            require __DIR__."/chapter/sua.php";
            break;
        case "xoa-chapter":
            require __DIR__."/chapter/xoa.php";
            break;
       
        case "chapter-noi-dung":
            require __DIR__."/chapter-noi-dung/index.php";
            break;
        case "them-chapter-noi-dung":
            require __DIR__."/chapter-noi-dung/them.php";
            break;
        case "sua-chapter-noi-dung":
            require __DIR__."/chapter-noi-dung/sua.php";
            break;
        case "xoa-chapter-noi-dung":
            require __DIR__."/chapter-noi-dung/xoa.php";
            break;
        case "xu-ly-upload":
            require __DIR__."/chapter-noi-dung/xu-ly-upload.php";
                break;
        default:
            break;
    }
}else{
    echo "<script>location.href='index.php?direction=dashboard'</script>";
}
?>