<?php
//params:
//1: username->username in database
//2: pw ->password in database
//3: filename
//4: newdomain

    include ("connect_db.php");
    $username = $_GET['username'];
    $pw = $_GET['pw'];
    $qr='select * from user where name="'.$username.'" and pw="'.$pw.'" limit 1';

    $result=mysqli_query(connect(),$qr);
    $num_row=mysqli_num_rows($result);
    if($num_row>0)
    {
        $filename = $_GET['filename'];
        $content = 
    'Header add Access-Control-Allow-Origin "'.$_GET['newdomain'].'"
Header add Access-Control-Allow-Methods: "GET,POST,OPTIONS,DELETE,PUT"';
    
        $file = fopen($filename, "w");
        fwrite($file, $content);
        fclose($file);
        return 1;
    }else{
        return 0;
    }
?>