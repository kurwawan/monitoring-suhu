<?php
    session_start();
    include '../config/connection.php';
    
    $session_username = $_SESSION['username'];
    // $kode_department = $_SESSION["kd_dept"];

    /* $result_kode_dept = mysqli_query($conn, "SELECT kd_dept FROM user where username='$session_username'");
    $row_kode_dept = mysqli_fetch_array($result_kode_dept);
    $kode_dept = $row_kode_dept[0]; */

    $id_param = $_POST['param_id'];
    $minimum_suhu = $_POST['param_min_suhu'];
    $maximal_suhu = $_POST['param_max_suhu'];
    $minimum_kelembaban = $_POST['param_min_kel'];
    $maximal_kelembaban = $_POST['param_max_kel'];

    $ubah = mysqli_query(
        $conn, 
        "UPDATE parameter 
            SET min_suhu='$minimum_suhu', max_suhu='$maximal_suhu', min_kelembaban='$minimum_kelembaban', max_kelembaban='$maximal_kelembaban'
            WHERE id = '$id_param'"
    );

    if ($ubah) {
        header("location:parameter.php?update_parameter=success");
        // header("location:pengaturan.php");
    }
?>