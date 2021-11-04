<?php
    include '../config/connection.php';

    $del_alat_id = $_POST['alat_del_id'];

    $delete = mysqli_query(
        $conn,
        "DELETE FROM parameter WHERE id='$del_alat_id'"
    );

    if ($delete) {
        header("location:alat.php");
    }
?>