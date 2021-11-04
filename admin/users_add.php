<?php
    include '../config/connection.php';

    $add_dept = $_POST['user_add_dept'];
    $add_user = $_POST['user_add_username'];
    $add_pass = $_POST['user_add_pass'];
    // $add_lv = $_POST['user_add_level'];
    $add_kd_dept = $_POST['user_add_kode_dept'];

    /* $add_id_alat = count($_POST['user_id_alat']);
    $add_lokasi = count($_POST['user_lokasi']); */ 
    $add_id_alat = $_POST['user_id_alat'];
    $add_kode_locator = $_POST['user_kode_locator'];
    $add_lokasi = $_POST['user_lokasi'];
    $add_delay = $_POST['user_delay'];

    $q_check = mysqli_query(
        $conn, 
        "SELECT * FROM user WHERE username='$add_user'"
    );
    $data = mysqli_fetch_array($q_check);

    $q_check2 = mysqli_query(
        $conn, 
        "SELECT * FROM user WHERE nama='$add_dept'"
    );
    $data2 = mysqli_fetch_array($q_check2);

    $q_check3 = mysqli_query(
        $conn, 
        "SELECT * FROM user WHERE kd_dept='$add_kd_dept'"
    );
    $data3 = mysqli_fetch_array($q_check3);

    $data_no_alat;
    foreach ($add_id_alat as $key => $value) {
        $cek_no_alat = mysqli_query(
            $conn,
            "SELECT * FROM parameter where id_alat='".$add_id_alat[$key]."'"
        );
        $data_no_alat = mysqli_fetch_array($cek_no_alat);
    }

    if ($data) {
        header("location:users.php?cek=username");
    } else if ($data2) {
        header("location:users.php?cek=department");
    } else if ($data3) {
        header("location:users.php?cek=kode_dept");
    } else if ($data_no_alat) {
        header("location:users.php?cek=alat");
    } else {
        $add_user = mysqli_query(
                    $conn, 
                    "INSERT INTO user (nama, username, password, level, kd_dept) 
                        VALUES ('$add_dept', '$add_user', md5('$add_pass'), 'user', '$add_kd_dept')"
        );
        
        foreach ($add_id_alat as $key => $value) {

            if ($data_no_alat) {
                header("location:users.php?cek=alat");
            } else if ($data_kode_locator) {
                header("location:users.php?cek=kode_locator");
            } else {
                $add_parameter = mysqli_query(
                    $conn, 
                    "INSERT INTO parameter (id_user, kd_dept, id_alat, ruang, kode_locator, delay, min_suhu, max_suhu, min_kelembaban, max_kelembaban, updated_at)
                        SELECT id, kd_dept, '".$add_id_alat[$key]."', '".$add_lokasi[$key]."', '".$add_kode_locator[$key]."', '".$add_delay[$key]."', '0', '0', '0', '0', now() FROM user where kd_dept='$add_kd_dept'"
                );
            }
        }
        header("location:users.php");
    }     
?>