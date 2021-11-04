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
                        <span>Update Data</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                        aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Management</span>
                    </a>
                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                            <a class="collapse-item" href="users.php">User</a>
                            <a class="collapse-item" href="alat.php">Alat</a>
                        </div>
                    </div>
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