<?php
    include '../config/connection.php';
    $add_dept = $_POST['user_add_dept'];
    $add_user = $_POST['user_add_username'];
    $add_pass = $_POST['user_add_pass'];
    $add_lv = $_POST['user_add_level'];
    $add_kd_dept = $_POST['user_add_kode_dept'];

    $add_id_alat = count($_POST['user_id_alat']); 

    if (isset($_POST["action"]) == "insert") {
        $q_check = mysqli_query(
            $conn, 
            "SELECT * FROM user WHERE username='$add_user' and nama='$add_dept'"
        );
        $data = mysqli_fetch_array($q_check);

        if ($data) {
            
        } else {
            $add_user = mysqli_query(
                $conn, 
                "INSERT INTO user (nama, username, password, level, kd_dept) 
                    VALUES ('$add_dept', '$add_user', md5('$add_pass'), '$add_lv', '$add_kd_dept')"
            );

            for ($i=0; $i < $add_id_alat; $i++) {
                $id_alat = $_POST['user_id_alat'][$i];

                $add_parameter = mysqli_query(
                    $conn, 
                    "INSERT INTO parameter (kd_dept, id_alat, min_suhu, max_suhu, min_kelembaban, max_kelembaban, updated_at) 
                        VALUES ('$add_kd_dept', '$id_alat', '0', '0', '0', '0', now())"
                );
            }

            if ($add_user) {
                header("location:users.php");
            }
        }
    }
?>