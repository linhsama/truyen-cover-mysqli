<?php
           
        // Thu thập thông tin 
        $chapter_id = $_POST['chapter_id'];
        $truyen_id = $_POST['truyen_id'];
        
        if(strlen($_FILES['chapter_noi_dung']['name'])>0){
            $path = __DIR__ . "/../../assets/uploads/".$data_old['chapter_noi_dung'];
            unlink($path);
             
            $upload_dir = __DIR__ . "/../../assets/uploads/truyen-tranh/";
            $tentaptin = date('YmdHis').'_'.$_FILES['chapter_noi_dung']['name'];
        
            move_uploaded_file($_FILES['chapter_noi_dung']['tmp_name'],$upload_dir.$tentaptin);
            $ten_tap_tin = 'truyen-tranh/'.$tentaptin;
         
            }else{
                $ten_tap_tin = $data_old['chapter_noi_dung'];
            }
            $sql = <<<EOT
            INSERT INTO chapter_noi_dung(chapter_noi_dung, chapter_id) 
            VALUES ('$ten_tap_tin', '$chapter_id');
    EOT;
    
    mysqli_query($conn, $sql) or die ("<b>Có lỗi khi thực hiện câu lệnh SQL: </b> ". mysqli_error($conn). "<br/> <b>Câu lệnh vừa thực thi: </b> $sql");
    echo "<script> location.href='index.php?direction=chapter-noi-dung&chapter_id=$chapter_id&truyen_id=$truyen_id&status=success'; </script>";
   
?>