<?php 
    if(isset($_GET['direction'])){
    switch($_GET['direction']){
        case "dashboard":
            require __DIR__."/dashboard/index.php";
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
        

       
        default:
            break;

    }
}
?>