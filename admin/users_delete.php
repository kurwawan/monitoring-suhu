<?php
    include '../config/connection.php';

    $del_id = $_POST['user_id'];

    $delete = mysqli_query(
        $conn,
        "DELETE FROM user WHERE id='$del_id'"
    );

    $delete_alat = mysqli_query(
        $conn,
        "DELETE FROM parameter WHERE id_user='$del_id'"
    );
    
    if ($delete) {
        header("location:users.php");
    }
?>