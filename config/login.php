<?php 
    session_start();
    include 'connection.php';

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $login = mysqli_query($conn,"SELECT * from user where username='$username' and password='$password'");
    $cek = mysqli_num_rows($login);
    $data_login = mysqli_fetch_array($login);

    if($cek > 0) {    
        if($data_login["level"] == "admin") {
            $_SESSION['username'] = $username;
            header("location:../admin/dashboard.php");
            // echo $data_login["level"];
        } else if ($data_login["level"] == "user") {
            $_SESSION['username'] = $username;
            $_SESSION['kd_dept'] = $data_login["kd_dept"];
            header("location:../user/dashboard.php");
        } else{
            header("location:../index.php?pesan=gagal");
        }
    } else {
        header("location:../index.php?pesan=gagal");
    } 
?>