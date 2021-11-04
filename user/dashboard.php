<?php 
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:../index.php");
    }
    include '../config/connection.php';
    
                        
    $kode_department = $_SESSION["kd_dept"];
?>

<!DOCTYPE html>
<html lang="en">

<head> 
    <title>Dashboard - Monitoring Suhu & Kelembaban</title>
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row" id="link_wrapper">
                    </div>
                    <!-- Content Row -->

                    <div class="row">

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            

        </div>
        <!-- End of Content Wrapper -->

        <!-- Footer -->
        <?php include '../include/footer.php' ?>
        <!-- End of Footer -->

    </div>
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