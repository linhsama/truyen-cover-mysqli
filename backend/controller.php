<?php 

    if(isset($_GET['tim-kiem'])){
        include_once(__DIR__ . '/../frontend/pages/truyen/truyen-tim-kiem.php'); 
    }else if(isset($_GET['the-loai'])){
        include_once(__DIR__ . '/../frontend/pages/truyen/truyen-the-loai.php'); 
    }else if(isset($_GET['truyen-manga'])){
        switch($_GET['truyen-manga']){
            case 'danh-sach-chapter':
                include_once(__DIR__ . '/../frontend/pages/chapter/danh-sach-chapter.php'); 
                break;
            case 'noi-dung-chapter':
                include_once(__DIR__ . '/../frontend/pages/chapter/noi-dung-chapter.php'); 
                break;
            case 'tat-ca-truyen-da-hoan-thanh':
                include_once(__DIR__ . '/../frontend/pages/truyen/tat-ca-truyen-da-hoan-thanh.php'); 
                break;
            case 'tat-ca-truyen-dang-cap-nhat':
                include_once(__DIR__ . '/../frontend/pages/truyen/tat-ca-truyen-dang-cap-nhat.php'); 
                break;
            case 'tat-ca-truyen-top-view':
                    include_once(__DIR__ . '/../frontend/pages/truyen/tat-ca-truyen-top-view.php'); 
                    break;
            case 'tat-ca-truyen-moi':
                include_once(__DIR__ . '/../frontend/pages/truyen/tat-ca-truyen-moi.php'); 
                break;
            case 'tat-ca-truyen-manga':
                include_once(__DIR__ . '/../frontend/pages/truyen/tat-ca-truyen-manga.php'); 
                break;
            case 'noi-dung-pre-next':
                include_once(__DIR__ . '/../frontend/pages/chapter/noi-dung-pre-next.php'); 
                break;
            case 'truyen-da-xem':
                include_once(__DIR__ . '/../frontend/pages/truyen/truyen-da-xem.php'); 
                break;
            case 'truyen-da-thich':
                include_once(__DIR__ . '/../frontend/pages/truyen/truyen-da-thich.php'); 
                break;
            case 'truyen-dang-theo-doi':
                include_once(__DIR__ . '/../frontend/pages/truyen/truyen-dang-theo-doi.php'); 
                break;
        }
    }
    else{
        include_once(__DIR__ . '/../frontend/pages/main.php'); 
    }
?>