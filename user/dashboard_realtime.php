                        <?php
                            session_start();
                            include '../config/connection.php';
                            $kode_department = $_SESSION["kd_dept"];

                            $query = "SELECT MIN(u.kd_dept) as kd_dept, MIN(sk.ruang) as ruang, MIN(sk.id_alat) as id_alat , MIN(sk.waktu) as waktu, MIN(sk.suhu) as suhu, MIN(sk.kelembaban) as kelembaban 
                                        FROM suhu_kelembaban sk, user u, parameter p
                                        where u.kd_dept = sk.kd_dept
                                        and p.id_alat = sk.id_alat
                                        and u.kd_dept = '$kode_department'
                                        GROUP by sk.id_alat
                                        ORDER BY MIN(sk.id) DESC";
                            $result_data = mysqli_query($conn, $query); 

                            while ($data = mysqli_fetch_assoc($result_data)) :
                                $alat = $data["id_alat"];

                            $result = mysqli_query($conn, "SELECT * FROM suhu_kelembaban where id_alat='$alat' order by id desc limit 1");
                            $get_row = mysqli_fetch_assoc($result);
                        ?>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Lokasi</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    echo $get_row["ruang"];
                                                    // echo $data["ruang"];
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Suhu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    echo $get_row['suhu'] . ' °C';
                                                    // echo $data["suhu"] . ' °C';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-thermometer-half fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Kelembaban</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php
                                                        echo $get_row['kelembaban'] . ' %';
                                                        // echo $data['kelembaban'] . ' %';
                                                    ?>
                                                </div>
                                            </div>
                                        <div class="col-auto">
                                            <i class="fas fa-water fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Tanggal & Waktu
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php 
                                                    echo $get_row['waktu']; 
                                                    /* echo $data['waktu']; */
                                                ?>
                                            </div>
                                        </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            endwhile;
                        ?>