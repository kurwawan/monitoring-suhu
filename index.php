<?php 
    session_start();
    /* include 'config/connection.php'; 
    include 'config/login.php' */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login - Monitoring Suhu & Kelembaban</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

     <!-- Custom fonts for this template-->
    <link href="front-end/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="front-end/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="front-end/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Monitoring Suhu dan Kelembaban</h1>
                                    </div>
                                    <?php
                                        if(isset($_GET['pesan'])){
                                            if($_GET['pesan']=="gagal"){
                                                // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
                                                echo "
                                                <div class='alert alert-danger alert-dismissible fade show mb-4'>
                                                    <strong>Username dan Password Salah !</strong>
                                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                        <span aria-hidden='true'>&times;</span>
                                                    </button>
                                                </div>
                                                ";
                                            }
                                        } 
                                    ?>
                                    <form class="user" action="config/login.php" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputUsername" placeholder="Username..." name="username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="front-end/vendor/jquery/jquery.min.js"></script>
    <script src="front-end/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="front-end/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="front-end/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="front-end/vendor/chart.js/Chart.min.js"></script>
    
    <script src="front-end/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="front-end/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="front-end/js/demo/chart-area-demo.js"></script>
    <script src="front-end/js/demo/chart-pie-demo.js"></script>

    <script src="front-end/js/demo/datatables-demo.js"></script>
</body>

</html>