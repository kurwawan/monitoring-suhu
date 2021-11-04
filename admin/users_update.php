<?php
    include '../config/connection.php';

    $upt_id = $_POST['user_id'];
    $upt_dept = $_POST['user_dept'];
    $upt_user = $_POST['user_username'];
    $upt_pass = $_POST['user_pass'];
    // $upt_lv = $_POST['user_level'];
    $upt_kd_dept = $_POST['user_kd_dept'];

    if ($upt_pass == '') {
        $update = mysqli_query(
            $conn, 
            "UPDATE user SET
                nama = '$upt_dept', 
                username = '$upt_user',
                kd_dept = '$upt_kd_dept'
            WHERE id = '$upt_id'"
        );

        $update_kode_dept = mysqli_query(
            $conn, 
            "UPDATE parameter SET
                kd_dept = '$upt_kd_dept'
            WHERE id_user = '$upt_id'"
        );
    }  else {
        $update = mysqli_query(
            $conn, 
            "UPDATE user SET
                nama = '$upt_dept', 
                username = '$upt_user', 
                password = md5('$upt_pass'),
                kd_dept = '$upt_kd_dept'
            WHERE id = '$upt_id'"
        );
        
        $update_kode_dept = mysqli_query(
            $conn, 
            "UPDATE parameter SET
                kd_dept = '$upt_kd_dept'
            WHERE id_user = '$upt_id'"
        );
    }   

    if ($update_kode_dept) {
        header("location:users.php");
    }
?>