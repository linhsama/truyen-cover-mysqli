<?php include_once(__DIR__ . '/../../../backend/dbconnect.php'); 
      // sự kiện bấm nút thích
      if(isset($_POST['btn_thich'])){
       $tai_khoan_id = $_POST['user_tai_khoan_id'];
       $truyen_id = $_POST['truyen_id'];
       $chapter_id = $_POST['chapter_id'];

       // Kiểm tra truyện đã lưu chưa
       $sql_select_truyen_da_thich = <<<EOT
       SELECT * 
       FROM (tuong_tac INNER JOIN chapter ON tuong_tac.chapter_id = chapter.chapter_id)
       INNER JOIN truyen ON truyen.truyen_id = chapter.truyen_id
       WHERE tuong_tac_loai = '2' AND truyen.truyen_id = '$truyen_id' AND tai_khoan_id = '$tai_khoan_id' 
       EOT;
       $result_select_truyen_da_thich = mysqli_query($conn, $sql_select_truyen_da_thich);
       $data_select_truyen_da_thich =  mysqli_fetch_array($result_select_truyen_da_thich, MYSQLI_ASSOC);
   
       if(!empty($data_select_truyen_da_thich)){
           $tuong_tac_id = $data_select_truyen_da_thich['tuong_tac_id'];
   
           echo $tuong_tac_id;

           $sql_update_truyen_da_thich = <<<EOT
           DELETE FROM tuong_tac WHERE tuong_tac_id =  '$tuong_tac_id'
           EOT;
           $result_update_truyen_da_thich = mysqli_query($conn, $sql_update_truyen_da_thich);
       }else{
           $sql_insert_truyen_da_thich = <<<EOT
           INSERT INTO tuong_tac (tuong_tac_loai, chapter_id, tai_khoan_id) VALUES ('2','$chapter_id','$tai_khoan_id')
           EOT;
           $result_insert_truyen_da_thich = mysqli_query($conn, $sql_insert_truyen_da_thich);
       }
   }
   
   // sự kiện bấm nút theo dõi
   if(isset($_POST['btn_theo_doi'])){
       $tai_khoan_id = $_POST['user_tai_khoan_id'];
       $truyen_id = $_POST['truyen_id'];
       $chapter_id = $_POST['chapter_id'];

       echo $tai_khoan_id;
       // Kiểm tra truyện đã lưu chưa
       $sql_select_truyen_theo_doi = <<<EOT
       SELECT * 
       FROM (tuong_tac INNER JOIN chapter ON tuong_tac.chapter_id = chapter.chapter_id)
       INNER JOIN truyen ON truyen.truyen_id = chapter.truyen_id
       WHERE tuong_tac_loai = '3' AND truyen.truyen_id = '$truyen_id' AND tai_khoan_id = '$tai_khoan_id' 
       
       EOT;
       $result_select_truyen_theo_doi = mysqli_query($conn, $sql_select_truyen_theo_doi);
       $data_select_truyen_theo_doi =  mysqli_fetch_array($result_select_truyen_theo_doi, MYSQLI_ASSOC);
   
       if(!empty($data_select_truyen_theo_doi)){
           $tuong_tac_id = $data_select_truyen_theo_doi['tuong_tac_id'];
   
           $sql_update_truyen_theo_doi = <<<EOT
           DELETE FROM tuong_tac WHERE tuong_tac_id =  '$tuong_tac_id'
           EOT;
           $result_update_truyen_theo_doi= mysqli_query($conn, $sql_update_truyen_theo_doi);
   
       }else{
           $sql_insert_truyen_theo_doi = <<<EOT
           INSERT INTO tuong_tac (tuong_tac_loai, chapter_id, tai_khoan_id) VALUES ('3','$chapter_id','$tai_khoan_id')
           EOT;
           $result_insert_truyen_theo_doi = mysqli_query($conn, $sql_insert_truyen_theo_doi);
       }
   
   }
?>