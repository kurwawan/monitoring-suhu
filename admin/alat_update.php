<?php
    include '../config/connection.php';

    $upt_id = $_POST['alat_id'];
    $upt_alat_kd_dept = $_POST['alat_kd_dept'];
    $upt_lokasi = $_POST['alat_lokasi'];
    $upt_kode_locator = $_POST['alat_kode_locator'];
    $upt_no_alat = $_POST['alat_no_alat'];
    $upt_delay = $_POST['alat_delay'];

    $update = mysqli_query(
        $conn, 
        "UPDATE parameter SET
            kd_dept = '$upt_alat_kd_dept', 
            ruang = '$upt_lokasi',
            kode_locator = '$upt_kode_locator',
            id_alat = '$upt_no_alat',
            delay = $upt_delay
        WHERE id = '$upt_id'"
    );

    if ($update) {
        header("location:alat.php");
    }
?>