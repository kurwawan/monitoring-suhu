<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:../index.php");
    }
    
    include '../config/connection.php';

    $session_username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Data Update - Monitoring Suhu & Kelembaban</title>
    <?php include '../include/header.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include '../include/navbar.php' ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-2">
                        <h1 class="h3 mb-0 text-gray-800">Update Data</h1>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">    
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Waktu</th>
                                            <th>Ruang</th>
                                            <th>Suhu (°C)</th>
                                            <th>Kelembaban (%)</th>
                                            <th>No. Alat</th>
                                            <th>Kode Dept.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = 1;
                                        $query_result = mysqli_query(
                                            $conn, 
                                            "SELECT MIN(id_alat) as id_alat 
                                                FROM suhu_kelembaban 
                                                GROUP BY id_alat"
                                        );
                                        while ($data = mysqli_fetch_array($query_result)) {    
                                            $row_alat = $data["id_alat"];

                                            $query_all_alat = mysqli_query(
                                                $conn,
                                                "SELECT * FROM suhu_kelembaban where id_alat='$row_alat' order by id desc limit 1"
                                            );
                                           $all_alat = mysqli_fetch_assoc($query_all_alat);  
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $all_alat["waktu"]; ?></td>
                                            <td><?= $all_alat["ruang"]; ?></td>
                                            <td><?= $all_alat["suhu"]; ?></td>
                                            <td><?= $all_alat["kelembaban"]; ?></td>
                                            <td><?= $all_alat["id_alat"]; ?></td>
                                            <td><?= $all_alat["kd_dept"]; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include '../include/footer.php' ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <?php include '../include/script.php' ?>

</body>

</html>