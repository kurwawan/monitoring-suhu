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
    <title>Management Alat - Monitoring Suhu & Kelembaban</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Management Alat</h1>
                    </div>

                    <button type="button" class="d-none d-sm-inline-block btn btn-sm btn btn-primary shadow-sm mb-3" data-toggle="modal" data-target="#modalTambahAlat">
                        <i class="fas fa-plus-circle fa-sm text-white-50"></i> Tambah Alat
                    </button>

                    <div class="modal fade" id="modalTambahAlat" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah Alat</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form action="alat_add.php" method="POST">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Departemen</label>
                                            <select name="dept" class="form-control selectpicker" data-live-search="true" id="ddselect">
                                                <?php
                                                    $query_dept = mysqli_query(
                                                        $conn, 
                                                        "SELECT MIN(nama) as nama FROM user where username<>'admin' group by nama"
                                                    );
                                                    while ($result_dept = mysqli_fetch_array($query_dept)) {                                                                   
                                                ?>
                                                <option value="<?= $result_dept['nama']; ?>">
                                                    <?= $result_dept["nama"]; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group" name="" id="">
                                            <label>Alat (No. Alat - Kode Locator - Lokasi - Update Delay)</label>
                                            <table class="" id="table_field">
                                                <tr>
                                                    <td><input type="text" name="no_alat[]" class="form-control" placeholder="No. Alat" required/></td>
                                                    <td><input type="text" name="kode_locator_alat[]" class="form-control" placeholder="Kode Locator" required/></td>
                                                    <td><input type="text" name="lokasi_alat[]" class="form-control" placeholder="Lokasi" required/></td>
                                                    <td><input type="text" name="delay[]" class="form-control" placeholder="Update Delay" required/></td>
                                                    <td><button type="button" name="add" id="add" class="btn btn-primary ml-2">+</button></td>  
                                                </tr>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="">TAMBAH</button>
                                    </div>
                                </form> 
                            </div>
                        </div>        
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <?php
                                if(isset($_GET['cek'])) {
                                    if($_GET['cek']=="alat") {
                                        echo "
                                        <div class='alert alert-danger alert-dismissible fade show'>
                                            <strong>Nomor Alat sudah tersedia !</strong>
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
                                            <th>Departemen</th>
                                            <th>Kode Departemen</th>
                                            <th>Lokasi</th>
                                            <th>Kode Locator</th>
                                            <th>No. Alat</th>
                                            <th>Delay Update</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $no=1;
                                            $query_management_alat = mysqli_query(
                                                $conn,
                                                "SELECT B.nama, A.kd_dept, A.ruang, A.id_alat, A.id, A.kode_locator, A.delay FROM parameter A, user B 
                                                    WHERE A.id_user = B.id
                                                    ORDER BY B.id DESC"
                                            );
                                            while ($result_management_alat = mysqli_fetch_array($query_management_alat)) {
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $result_management_alat[0]; ?></td>
                                            <td><?= $result_management_alat[1]; ?></td>
                                            <td><?= $result_management_alat[2]; ?></td>
                                            <td><?= $result_management_alat[5]; ?></td>
                                            <td><?= $result_management_alat[3]; ?></td>
                                            <td><?= $result_management_alat[6]; ?></td>
                                            <td>
                                                <a href="" type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modalEdit<?= $result_management_alat[4]; ?>">
                                                    <i class="fas fa-edit fa-sm text-white-50"></i>
                                                </a>
                                                <a href="" type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modalDelete<?= $result_management_alat[4]; ?>">
                                                    <i class="fas fa-trash-alt fa-sm text-white-50"></i>
                                                </a>
                                            </td>

                                        </tr>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="modalEdit<?= $result_management_alat[4]; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Alat</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="alat_update.php" method="POST">
                                                        <?php
                                                            $id = $result_management_alat[4];
                                                            $query_edit = mysqli_query(
                                                                $conn, 
                                                                "SELECT B.nama, A.kd_dept, A.ruang, A.id_alat, A.id, A.kode_locator, A.delay FROM parameter A, user B 
                                                                    WHERE A.id_user = B.id
                                                                    AND A.ID='$id'"
                                                            );
                                                            
                                                            while ($result_edit_alat = mysqli_fetch_array(($query_edit))) {
                                                        ?>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="alat_id" class="form-control" value="<?= $result_edit_alat[4]; ?>" required>
                                                            <div class="form-group">
                                                                <label>Departemen</label>
                                                                <input type="text" name="alat_dept" class="form-control" value="<?= $result_edit_alat[0]; ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kode Departemen</label>
                                                                <input type="text" name="alat_kd_dept" class="form-control" value="<?= $result_edit_alat[1]; ?>" readonly>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Lokasi</label>
                                                                <input type="text" name="alat_lokasi" class="form-control" value="<?= $result_edit_alat[2]; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Kode Locator</label>
                                                                <input type="text" name="alat_kode_locator" class="form-control" value="<?= $result_edit_alat[5]; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>No. Alat</label>
                                                                <input type="text" name="alat_no_alat" class="form-control" value="<?= $result_edit_alat[3]; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Update Delay</label>
                                                                <input type="text" name="alat_delay" class="form-control" value="<?= $result_edit_alat[6]; ?>" required>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success" name="update">UPDATE</button>
                                                        </div>
                                                    </form>  
                                                </div>
                                            </div>        
                                        </div>
                                        <!-- End Modal Edit -->

                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="modalDelete<?= $result_management_alat[4]; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="alat_delete.php" method="POST">
                                                        <?php
                                                            $id = $result_management_alat[4];
                                                            $query_edit = mysqli_query(
                                                                $conn, 
                                                                "SELECT B.nama, A.kd_dept, A.ruang, A.id_alat, A.id FROM parameter A, user B 
                                                                    WHERE A.id_user = B.id
                                                                    AND A.ID='$id'"
                                                            );
                                                            while ($result_edit_alat = mysqli_fetch_array(($query_edit))) {
                                                        ?>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="alat_del_id" class="form-control" value="<?= $result_edit_alat[4]; ?>" required>
                                                            <label>Hapus nomor alat <?= $result_edit_alat[3]; ?> pada ruang <?= $result_edit_alat[2]; ?> ?</label>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger" name="update">HAPUS</button>
                                                        </div>
                                                        <?php } ?>
                                                    </form>  
                                                </div>
                                            </div>        
                                        </div>
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
    
    <script type="text/javascript">
    $(document).ready(function() {
        var html = '<tr><td><input type="text" name="no_alat[]" class="form-control mt-2" placeholder="Nomor Alat" required/></td><td><input type="text" name="kode_locator_alat[]" class="form-control mt-2" placeholder="Kode Locator" required/></td><td><input type="text" name="lokasi_alat[]" class="form-control mt-2" placeholder="Lokasi" required/></td><td><input type="text" name="delay[]" class="form-control mt-2" placeholder="Update Delay" required/></td><td><button type="button" name="remove" id="remove" class="btn btn-danger ml-2">x</button></td> </tr>';
        var x = 1;
        
        $("#add").click(function(){
            $("#table_field").append(html);
        });
        
        $("#table_field").on('click','#remove',function(){
            $(this).closest('tr').remove();
        });
    });
    </script>

</body>

</html>