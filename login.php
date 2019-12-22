<?php 
session_start();
include ("connect_db.php");
?>
<form method="POST">
    <input type="text" name="name" placeholder="Username">
    <input type="text" name="pw" placeholder="Password">
    <button type="submit" name="bt">Login</button>
</form>
<?php
if(isset($_POST['bt']))
{   
    if(empty($_POST['name']) || empty($_POST['pw'])){
        echo '<div style="color:red;font-weight:bold">Enter Username and Password !</div>';
    }else{
        $name=$_POST['name'];
        $pw=$_POST['pw'];
        $qr='select * from user where name="'.$name.'" and pw="'.$pw.'" limit 1';
        //comfirm
        $result=mysqli_query(connect(),$qr);
        $num_row=mysqli_num_rows($result);
        if($num_row>0)
        {
            $_SESSION['logined']=true;     
            echo '<script>window.location.href="adminhls.php"</script>';
        }else{
            echo '<div style="color:red;font-weight:bold">Username or Password is wrong !</div>';
        }
    }
}
?>