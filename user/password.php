<?php
    // session_start();
    include '../config/connection.php';
    include '../include/header.php';
    include '../include/script.php';
    $session_username = $_POST['pass_username'];
    
    $password_lama = $_POST['pass_lama'];
    $pass_lama_ok = md5($password_lama);

    $password_baru = $_POST['pass_baru'];
    $pass_baru_ok = md5($password_baru);

    $password_confirm = $_POST['pass_confirm'];
    $pass_confirm_ok = md5($password_confirm);

    $q_check = mysqli_query(
        $conn, 
        "SELECT * FROM user WHERE username='$session_username' and password='$pass_lama_ok'"
    );
    $data = mysqli_fetch_array($q_check);

    if ($data) {
        if ($password_confirm == $password_baru) {
            $ubah = mysqli_query(
                $conn, 
                "UPDATE user set password='$pass_baru_ok' WHERE id='$data[id]'"
            );
            if ($ubah) {
                header("location:ganti_password.php?ubah_pass=passw");
            }
        } else {
            header("location:ganti_password.php?ubah_pass=passw_salah");
        }
    } else {
        header("location:ganti_password.php?ubah_pass=passw_tidak_sesuai");
    }
?>