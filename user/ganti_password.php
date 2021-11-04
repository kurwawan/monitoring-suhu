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
    <title>Ganti Password - Monitoring Suhu & Kelembaban</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Ganti Password</h1>
                    </div>

                    <?php
                        if(isset($_GET['ubah_pass'])){
                            if($_GET['ubah_pass']=="passw") {
                                echo "
                                    <div class='alert alert-success alert-dismissible fade show'>
                                        <strong>Data berhasil dirubah</strong>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    ";
                            } else if ($_GET['ubah_pass']=="passw_salah") {
                                echo "
                                    <div class='alert alert-danger alert-dismissible fade show'>
                                        <strong>Password tidak sesuai !</strong>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    ";
                            } else if (($_GET['ubah_pass']=="passw_tidak_sesuai")) {
                                echo "
                                    <div class='alert alert-danger alert-dismissible fade show'>
                                        <strong>Password tidak sesuai !</strong>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                        </button>
                                    </div>
                                    ";
                            }
                        } 
                    ?>
                    <div class="d-sm-flex justify-content-between">
                        <form action="password.php" method="post">
                            <div class="form-group">
                                <input type="hidden" class="form-control form-control-user mb-4" placeholder="Masukkan Password Lama" name="pass_username" value="<?= $_SESSION['username']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" placeholder="Masukkan Password Lama" name="pass_lama" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" placeholder="Masukkan Password Baru" name="pass_baru" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" placeholder="Konfirmasi Password Baru" name="pass_confirm" required>
                            </div>
                            <div class="form-group">
                                <!-- <input type="submit" class="btn btn-primary btn-user btn-block" value="SIMPAN"> -->
                                <button type="submit" class="btn btn-primary btn-user btn-block">SIMPAN</button>
                            </div>
                        </form>                                                                    
                    </div>
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