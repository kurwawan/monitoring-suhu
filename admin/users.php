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
    <title>Management User - Monitoring Suhu & Kelembaban</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Management User</h1>
                    </div>

                    <button type="button" class="d-none d-sm-inline-block btn btn-sm btn btn-primary shadow-sm mb-3" data-toggle="modal" data-target="#modalTambah">
                        <i class="fas fa-plus-circle fa-sm text-white-50"></i> Tambah User
                    </button>                                    
                
                    <div class="modal fade" id="modalTambah" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Tambah User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="users_add.php" method="POST">
                                    <div class="modal-body">
                                    
                                        <div class="form-group">
                                            <label>Departemen</label>
                                            <input type="text" name="user_add_dept" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" name="user_add_username" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="user_add_pass" class="form-control" required>
                                        </div> 
                                        <div class="form-group">
                                            <label>Kode Departemen</label>
                                            <input type="text" name="user_add_kode_dept" class="form-control" required>
                                        </div>

                                        <div class="form-group" name="" id="">
                                            <label>Alat (No. Alat - Kode Locator - Lokasi - Update Delay))</label>
                                            <table class="" id="table_field">
                                                <tr>
                                                    <td><input type="text" name="user_id_alat[]" class="form-control" placeholder="Nomor Alat" required/></td>
                                                    <td><input type="text" name="user_kode_locator[]" class="form-control" placeholder="Kode Locator" required/></td>
                                                    <td><input type="text" name="user_lokasi[]" class="form-control" placeholder="Lokasi" required/></td>
                                                    <td><input type="text" name="user_delay[]" class="form-control" placeholder="Update Delay" required/></td>
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
                                if(isset($_GET['cek'])){
                                    if($_GET['cek']=="username") {
                                        echo "
                                        <div class='alert alert-danger alert-dismissible fade show'>
                                            <strong>Username sudah tersedia !</strong>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        ";
                                    } else if($_GET['cek']=="department") {
                                        echo "
                                        <div class='alert alert-danger alert-dismissible fade show'>
                                            <strong>Department sudah tersedia !</strong>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        ";
                                    } else if($_GET['cek']=="kode_dept") {
                                        echo "
                                        <div class='alert alert-danger alert-dismissible fade show'>
                                            <strong>Kode Department sudah tersedia !</strong>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        ";
                                    } else if($_GET['cek']=="alat") {
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
                                            <th>Username</th>
                                            <th>Kode Departemen</th>
                                            <th>No. Alat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $no = 1;
                                        $result = mysqli_query(
                                            $conn, 
                                            "SELECT * FROM user where username <> 'admin'"
                                        );
                                        while ($data = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $data["nama"]; ?></td>
                                            <td><?= $data["username"]; ?></td>
                                            <td><?= $data["kd_dept"]; ?></td>
                                            <td>
                                                <?php
                                                    $data_id = $data["id"];
                                                    $query_id_alat = mysqli_query(
                                                        $conn,
                                                        "SELECT B.id_alat from user A, parameter B where A.id = B.id_user and A.id = '$data_id'"
                                                    );
                                                    
                                                    while ($result_id_alat = mysqli_fetch_array($query_id_alat)) {
                                                        echo $result_id_alat[0] . '<br>';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="" type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#modalEdit<?= $data['id']; ?>">
                                                    <i class="fas fa-edit fa-sm text-white-50"></i>
                                                </a>
                                                <a href="" type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modalDelete<?= $data['id']; ?>">
                                                    <i class="fas fa-trash-alt fa-sm text-white-50"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="modalEdit<?= $data['id']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update User</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="users_update.php" method="POST">
                                                        <?php
                                                            $id = $data['id'];
                                                            $query_edit = mysqli_query(
                                                                $conn, 
                                                                "SELECT * FROM user where id='$id'"
                                                            );
                                                            
                                                            while ($result_edit = mysqli_fetch_array(($query_edit))) {
                                                        ?>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="user_id" class="form-control" value="<?= $result_edit['id']; ?>" required>
                                                            <div class="form-group">
                                                                <label>Departemen</label>
                                                                <input type="text" name="user_dept" class="form-control" value="<?= $result_edit['nama']; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Username</label>
                                                                <input type="text" name="user_username" class="form-control" value="<?= $result_edit['username']; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Password</label>
                                                                <input type="password" name="user_pass" class="form-control">
                                                            </div>                                                         
                                                            <div class="form-group">
                                                                <label>Kode Dept.</label>
                                                                <input type="text" name="user_kd_dept" class="form-control" value="<?= $result_edit['kd_dept']; ?>" required>
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

                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="modalDelete<?= $data['id']; ?>" role="dialog" arialabelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="users_delete.php" method="POST">
                                                        <?php
                                                            $id = $data['id'];
                                                            $query_edit = mysqli_query(
                                                                $conn, 
                                                                "SELECT * FROM user where id='$id'"
                                                            );
                                                            while ($result_edit = mysqli_fetch_array(($query_edit))) {
                                                        ?>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="user_id" class="form-control" value="<?= $result_edit['id']; ?>" required>
                                                            <label>Hapus data user <?= $result_edit['nama']; ?> ?</label>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger" name="update">HAPUS</button>
                                                        </div>
                                                        <?php } ?>
                                                    </form>  
                                                </div>
                                            </div>        
                                        </div>
                                        <!-- End Moda Delete -->
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
        var html = '<tr><td><input type="text" name="user_id_alat[]" class="form-control mt-2" placeholder="Nomor Alat" required/></td><td><input type="text" name="user_kode_locator[]" class="form-control mt-2" placeholder="Kode Locator" required/></td><td><input type="text" name="user_lokasi[]" class="form-control mt-2" placeholder="Lokasi" required/></td><td><input type="text" name="user_delay[]" class="form-control mt-2" placeholder="Update Delay" required/></td><td><button type="button" name="remove" id="remove" class="btn btn-danger ml-2">x</button></td></tr>';
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