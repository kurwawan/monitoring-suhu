<?php 
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:../index.php");
    }

    include '../config/connection.php';

    $session_username = $_SESSION['username'];
    $kode_department = $_SESSION["kd_dept"];

    $query_param = "SELECT * FROM parameter 
                    WHERE kd_dept = '$kode_department'";
    $result_param = mysqli_query($conn, $query_param);
?>

<!DOCTYPE html>
<html lang="en">

<head> 
    <title>Parameter - Monitoring Suhu & Kelembaban</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Parameter</h1>
                    </div>                

                    <div class="card shadow mb-4">
                        <div class="card-body">
                        <?php
                            if(isset($_GET['update_parameter'])){
                                if($_GET['update_parameter']=="success") {
                                    echo "
                                        <div class='alert alert-success alert-dismissible fade show'>
                                            <strong>Data berhasil dirubah</strong>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        ";
                                }
                            } 
                        ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">    
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Lokasi</th>
                                            <th>Kode Locator</th>
                                            <th>No. Alat</th>
                                            <th>Suhu Min. (°C)</th>
                                            <th>Suhu Max. (°C)</th>
                                            <th>Kelembaban Min. (%)</th>
                                            <th>Kelembaban Max. (%)</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = 1;
                                        while ($row_param = mysqli_fetch_assoc($result_param)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row_param["ruang"]; ?></td>
                                            <td><?= $row_param["kode_locator"]; ?></td>
                                            <td><?= $row_param["id_alat"]; ?></td>
                                            <td><?= $row_param["min_suhu"]; ?></td>
                                            <td><?= $row_param["max_suhu"]; ?></td>
                                            <td><?= $row_param["min_kelembaban"]; ?></td>
                                            <td><?= $row_param["max_kelembaban"]; ?></td>
                                            <td>
                                                <a href="" type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modalEdit<?= $row_param['id']; ?>">
                                                    <i class="fas fa-edit fa-sm text-white-50"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="modalEdit<?= $row_param['id']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update <?= $row_param["ruang"]; ?> - <?= $row_param["kode_locator"]; ?> - <?= $row_param["id_alat"]; ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="parameter_update.php" method="POST">
                                                        <?php
                                                            $id = $row_param['id'];
                                                            $query_edit = mysqli_query(
                                                                $conn, 
                                                                "SELECT * FROM parameter where id='$id'"
                                                            );
                                                            
                                                            while ($result_edit = mysqli_fetch_array(($query_edit))) {
                                                        ?>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="param_id" class="form-control" value="<?= $result_edit['id']; ?>" required>
                                                            <div class="form-group">
                                                                <label>Suhu Minimum</label>
                                                                <input type="text" name="param_min_suhu" class="form-control" value="<?= $result_edit['min_suhu']; ?>" onkeypress="validate(event)" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Suhu Maximum</label>
                                                                <input type="text" name="param_max_suhu" class="form-control" value="<?= $result_edit['max_suhu']; ?>" onkeypress="validate(event)" required>
                                                            </div>                                                       
                                                            <div class="form-group">
                                                                <label>Kelembaban Minimum</label>
                                                                <input type="text" name="param_min_kel" class="form-control" value="<?= $result_edit['min_kelembaban']; ?>" onkeypress="validate(event)" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kelembaban Maximum</label>
                                                                <input type="text" name="param_max_kel" class="form-control" value="<?= $result_edit['max_kelembaban']; ?>" onkeypress="validate(event)" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="update">UPDATE</button>
                                                        </div>
                                                        <?php } ?>
                                                    </form>  
                                                </div>
                                            </div>        
                                        </div>
                                        <!-- End Modal Edit -->
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
    <script>
        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
            // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>

</body>

</html>