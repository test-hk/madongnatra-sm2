<?php
//params:
//1: username->username in database
//2: pw ->password in database
//3: filename
//4: content

    include ("connect_db.php");
    $username = $_POST['username'];
    $pw = $_POST['pw'];
    $qr='select * from user where name="'.$username.'" and pw="'.$pw.'" limit 1';

    $result=mysqli_query(connect(),$qr);
    $num_row=mysqli_num_rows($result);
    if($num_row>0)
    {
        $filename = $_POST['filename'];
        $content = $_POST['content'];
    
        $file = fopen($filename, "w");
        fwrite($file, $content);
        fclose($file);
        return 1;
    }else{
        return 0;
    }
?>