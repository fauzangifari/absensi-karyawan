<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard-karyawan">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Dashboard Karyawan</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="/dashboard-karyawan">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                             aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small"
                                           placeholder="Search for..." aria-label="Search"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $model['karyawan']['name'] ?? '' ?></span>
                            <img class="img-profile rounded-circle"
                                 src="../assets/img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Selamat Datang, <span
                            class="font-weight-bold"><?= $model['karyawan']['name'] ?? '' ?></span></h1>

                <div class="row">
                    <div class="col-xl-12 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Absensi Kehadiran Karyawan
                                </h6>
                            </div>

                            <?php if (isset($model['karyawan']['error'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= $model['karyawan']['error'] ?>
                                </div>
                            <?php } ?>

                            <!-- Card Body -->
                            <div class="card-body">
                                <form method="post" action="/dashboard-karyawan">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="username_karyawan" name="username"
                                               value="<?= $model['karyawan']['username'] ?? '' ?>" readonly
                                               hidden="hidden">

                                        <label for="exampleFormControlInput1">Nama Karyawan</label>
                                        <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan"
                                               value="<?= $model['karyawan']['name'] ?? '' ?>" readonly>

                                        <label for="exampleFormControlInput1">Tanggal</label>
                                        <input type="text" class="form-control" id="tanggal" name="tanggal_absen"
                                               readonly>

                                        <label for="exampleFormControlInput1">Jam Masuk</label>
                                        <input type="text" class="form-control" id="jam_masuk" name="jam_masuk"
                                               readonly>

                                        <label for="exampleFormControlInput1">Jam Keluar</label>
                                        <input type="text" class="form-control" id="jam_keluar" name="jam_keluar"
                                               value="16:00:00" readonly>

                                        <label for="exampleFormControlInput1">Keterangan</label>
                                        <!--                                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>-->
                                        <select class="form-control" id="keterangan" name="keterangan" required>
                                            <option value="Hadir">Hadir</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Cuti">Cuti</option>
                                        </select>

                                        <div id="reasonBox" style="display: none;">
                                            <label for="exampleFormControlInput1">Alasan</label>
                                            <input type="text" class="form-control" id="alasan" name="alasan">

                                            <label for="exampleFormControlInput1">File Pendukung</label>
                                            <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx">
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Fauzan Gifari 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const currentTime = new Date();
        const hours = currentTime.getHours();
        const minutes = currentTime.getMinutes();
        const seconds = currentTime.getSeconds();

        const formattedTime = (hours < 10 ? '0' : '') + hours + ':' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

        const year = currentTime.getFullYear();
        const month = (currentTime.getMonth() + 1 < 10 ? '0' : '') + (currentTime.getMonth() + 1);
        const day = (currentTime.getDate() < 10 ? '0' : '') + currentTime.getDate();

        const formattedDate = year + '-' + month + '-' + day;

        document.getElementById('jam_masuk').value = formattedTime;
        document.getElementById('tanggal').value = formattedDate;

        document.getElementById('keterangan').addEventListener('change', function () {
            const reasonBox = document.getElementById('reasonBox');
            if (this.value === 'Izin' || this.value === 'Sakit' || this.value === 'Cuti') {
                reasonBox.style.display = 'block';
                reasonBox.required = true;
            } else {
                reasonBox.style.display = 'none';
            }
        });

    </script>