        <?php
            $query_global = "SELECT MIN(u.kd_dept) as kd_dept, MIN(p.ruang) as ruang, MIN(p.id) as id_alat 
                                FROM user u, parameter p, suhu_kelembaban sk
                                where u.id = p.id_user
                                and u.kd_dept = '$kode_department'
                                and p.id_alat = sk.id_alat
                                GROUP by p.id_alat
                                ORDER BY MIN(p.id) ASC";
            $result_data_global = mysqli_query($conn, $query_global);
        ?>
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-0">
                    <i class="fas fa-building"></i>
                </div>
                <div class="sidebar-brand-text mx-3">IFARS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>               

                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                        aria-controls="collapseTwo">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Lokasi</span>
                    </a>
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                        <?php 
                            while ($lokasi = mysqli_fetch_assoc($result_data_global)) :
                                $alat_lokasi = $lokasi["id_alat"];
                                $lokasi_alat = $lokasi["ruang"];

                                $result = mysqli_query($conn, "SELECT * FROM parameter where id='$alat_lokasi'");
                                $row = mysqli_fetch_assoc($result);
                                if (isset($row["ruang"])) {
                        ?>
			    <a class="collapse-item" href="tables.php?id_alat=<?= $alat_lokasi; ?>"><?= $row['ruang']; ?></a>
                        <?php } else { ?>
                            <a class="collapseitem" href="">Data not available</a>
                        <?php } ?>
                        <?php endwhile; ?>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="parameter.php">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Parameter</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="ganti_password.php">
                        <i class="fas fa-fw fa-unlock-alt"></i>
                        <span>Ganti Password</span></a>
                </li>
                
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
