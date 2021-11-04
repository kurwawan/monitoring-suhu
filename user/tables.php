<?php
    session_start();
    if (!isset($_SESSION["username"])) {
        header("location:../index.php");
    }
    
    include '../config/connection.php';
    // $connect = new PDO("mysql:host=localhost;port=3308;dbname=iot", "root", "");

    $get_id_alat = $_GET["id_alat"];

    $session_username = $_SESSION['username'];
    $kode_department = $_SESSION["kd_dept"];

    $kode_dept = $kode_department;

    $result_parameter = mysqli_query(
        $conn, 
        "SELECT * FROM parameter where id='$get_id_alat'"
    );
    $row_parameter = mysqli_fetch_assoc($result_parameter);
    $min_suhu = (float)$row_parameter["min_suhu"];
    $max_suhu = (float)$row_parameter["max_suhu"];
    $min_lembab = (float)$row_parameter["min_kelembaban"];
    $max_lembab = (float)$row_parameter["max_kelembaban"];

    $idalat = $row_parameter["id_alat"];
    $kode_locator = $row_parameter["kode_locator"];
    $ruang = $row_parameter["ruang"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Data - Monitoring Suhu & Kelembaban</title>
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
                        <h1 class="h3 mb-0 text-gray-800"><?= $ruang; ?> - <?= $kode_locator; ?> - <?= $idalat; ?></h1>
                    </div>   

                    <!-- Tambahan Button -->
                    <div class="justify-content-between mb-3">
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn btn-success shadow-sm" data-toggle="modal" data-target="#modalSearch">
                            <i class="fas fa-search fa-sm text-white-50"></i> Cari Data
                        </button>
                        <div class="modal fade" id="modalSearch" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cari Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php
                                        $tanggal_awal = "";
                                        $waktu_awal = "";
                                        $tanggal_akhir = "";
                                        $waktu_akhir = "";

                                        if (isset($_POST['search'])) {
                                            $tanggal_awal = $_POST['tgl_awal'];
                                            $waktu_awal = $_POST['wkt_awal'];
                                            $tanggal_akhir = $_POST['tgl_akhir'];
                                            $waktu_akhir = $_POST['wkt_akhir'];
                                        }
                                    ?>
                                    <form action="" method="POST">
                                        <div class="modal-body">   
                                            <div class="form-group">
                                                <label>Tanggal Awal</label>
                                                <input type="date" name="tgl_awal" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jam Awal</label>
                                                <input type="time" name="wkt_awal" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Akhir</label>
                                                <input type="date" name="tgl_akhir" class="form-control time" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jam Akhir</label>
                                                <input type="time" name="wkt_akhir" class="form-control" required>
                                            </div> 
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="search">CARI</button>
                                            <!-- <input type="submit" class="btn btn-primary" name="btncari" value="CARI DATA"> -->
                                        </div>
                                    </form>  
                                </div>
                            </div>
                            
                        </div>
                        
                        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn btn-primary shadow-sm" data-toggle="modal" data-target="#modalExport">
                            <i class="fas fa-download fa-sm text-white-50"></i> Export Excel
                        </button>
                        <div class="modal fade" id="modalExport" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Export Data</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <form action="export.php?id=<?= $get_id_alat; ?>" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group" style="display: none;">
                                                <!-- <label>Format Excel</label> -->
                                                <select name="file_type" class="form-control input-sm" data-live-search="true" id="ddselect" required>
                                                    <!-- <option value="Xlsx">Xlsx</option> -->
                                                    <option value="Xls">Xls</option>
                                                    <!-- <option value="Csv">Csv</option> -->
                                                </select>
                                            </div> 
                                            <div class="form-group">
                                                <label>Tanggal Awal</label>
                                                <input type="date" name="tgl_awal_exp" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jam Awal</label>
                                                <input type="time" name="wkt_awal_exp" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Akhir</label>
                                                <input type="date" name="tgl_akhir_exp" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jam Akhir</label>
                                                <input type="time" name="wkt_akhir_exp" class="form-control" required>
                                            </div> 
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="download">DOWNLOAD</button>
                                        </div>
                                    </form>  

                                </div>
                            </div>
                            
                        </div>

                    </div>
                     <!-- End Tambahan Button -->
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">    
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Waktu</th>
                                            <!-- <th>Ruang</th> -->
                                            <th>Suhu (°C)</th>
                                            <th>Kelembaban (%)</th>
                                            <!-- <th>ID Alat</th> -->
                                            <!-- <th>Kode Dept.</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $search_tgl_awal = $tanggal_awal;
                                        $search_tgl_akhir = $tanggal_akhir;
                                        $search_wkt_awal = $waktu_awal;
                                        $search_wkt_akhir = $waktu_akhir;

                                        $no=1;
                                        if (isset($_POST['search'])) {
                                            $query = "SELECT * FROM suhu_kelembaban 
                                                    where id_alat='$idalat'
                                                        AND substring(waktu,1,17) BETWEEN concat('$tanggal_awal', concat(' ','$waktu_awal')) and concat('$tanggal_akhir', concat(' ','$waktu_akhir'))
                                                    order by id desc";
                                        } else {
                                            $query = "SELECT * FROM suhu_kelembaban where id_alat='' and suhu <> '' order by id desc";
                                        }
                                        $result = mysqli_query($conn, $query);
                                        while ($data_a = mysqli_fetch_assoc($result)) {
                                                $suhu = (float)$data_a["suhu"];
                                                $lembab = (float)$data_a["kelembaban"];
                                                if (($suhu >= $min_suhu && $suhu <= $max_suhu)
                                                     && ($lembab >= $min_lembab && $lembab <= $max_lembab)) {           
                                            ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td><?= $data_a["waktu"]; ?></td>
                                                    <td><?= $data_a["suhu"]; ?></td>
                                                    <td><?= $data_a["kelembaban"]; ?></td>
                                                </tr>
                                                <?php } else { ?>
                                                <tr class="cond">
                                                    <td class="fontcolor"><?= $no++; ?></td>
                                                    <td class="fontcolor"><?= $data_a["waktu"]; ?></td>
                                                    <td class="fontcolor"><?= $data_a["suhu"]; ?></td>
                                                    <td class="fontcolor"><?= $data_a["kelembaban"]; ?></td>
                                                </tr>
                                                <?php } ?>          
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
