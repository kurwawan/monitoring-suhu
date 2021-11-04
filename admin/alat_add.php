<?php
    include '../config/connection.php';

    $add_dept = $_POST['dept'];

    $add_id_alat = $_POST['no_alat'];
    $add_lokasi = $_POST['lokasi_alat'];
    $add_kode_locator = $_POST['kode_locator_alat'];
    $add_delay = $_POST['delay'];

    $q_check = mysqli_query(
        $conn, 
        "SELECT * FROM user WHERE nama='$add_dept'"
    );
    $data = mysqli_fetch_array($q_check);

    $id_user = $data['id'];
    $kode_dept = $data['kd_dept'];
    
    foreach ($add_id_alat as $key => $value) {
        $cek_kode_locator = mysqli_query(
            $conn,
            "SELECT * FROM parameter where kode_locator='".$add_kode_locator[$key]."'"
        );
        $data_kode_locator = mysqli_fetch_array($cek_kode_locator);
        
        if ($data_no_alat) {
            header("location:alat.php?cek=alat");
        } else {
            $add_parameter = mysqli_query(
                $conn, 
                "INSERT INTO parameter (id_user, kd_dept, id_alat, ruang, kode_locator, delay, min_suhu, max_suhu, min_kelembaban, max_kelembaban, updated_at) 
                    VALUES ('$id_user', '$kode_dept', '".$add_id_alat[$key]."', '".$add_lokasi[$key]."', '".$add_kode_locator[$key]."', '".$add_delay[$key]."', '0', '0', '0', '0', now())"
            );

            header("location:alat.php");
        }
    }
?>