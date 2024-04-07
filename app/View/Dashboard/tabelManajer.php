<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul
        class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion"
        id="accordionSidebar"
    >
        <!-- Sidebar - Brand -->
        <a
            class="sidebar-brand d-flex align-items-center justify-content-center"
            href="/dashboard-admin"
        >
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Dashboard Admin</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0"/>

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="/dashboard-admin">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a
            >
        </li>

        <!-- Nav Item - Manager Table -->
        <li class="nav-item">
            <a class="nav-link" href="/dashboard-admin/manager">
                <i class="fas fa-fw fa-table"></i>
                <span>Manager</span></a
            >
        </li>

        <!-- Nav Item - Employees Table -->
        <li class="nav-item">
            <a class="nav-link" href="/dashboard-admin/employee">
                <i class="fas fa-fw fa-table"></i>
                <span>Employees</span></a
            >
        </li>

        <!-- Nav Item - Attedance Table -->
        <li class="nav-item">
            <a class="nav-link" href="/dashboard-admin/attedance">
                <i class="fas fa-fw fa-table"></i>
                <span>Attedance</span></a
            >
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block"/>

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
            <nav
                class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
            >
                <!-- Sidebar Toggle (Topbar) -->
                <button
                    id="sidebarToggleTop"
                    class="btn btn-link d-md-none rounded-circle mr-3"
                >
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="searchDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div
                            class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                            aria-labelledby="searchDropdown"
                        >
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control bg-light border-0 small"
                                        placeholder="Search for..."
                                        aria-label="Search"
                                        aria-describedby="basic-addon2"
                                    />
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
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
              <span class="mr-2 d-none d-lg-inline text-gray-600 small"
              ><?= $model['admin']['name'] ?? '' ?></span
              >
                            <img
                                class="img-profile rounded-circle"
                                src="../assets/img/undraw_profile.svg"
                            />
                        </a>
                        <!-- Dropdown - User Information -->
                        <div
                            class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown"
                        >
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a
                                class="dropdown-item"
                                href="#"
                                data-toggle="modal"
                                data-target="#logoutModal"
                            >
                                <i
                                    class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                                ></i>
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
                <div>
                    <!-- Table Manager -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Manager Table</h6>
                            <button class="btn btn-outline-success ml-auto" data-toggle="modal"
                                    data-target="#addEmployeeModal"> Add Manager +
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama Manajer</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Delete</th>
                                        <th>Update</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($model['admin']['manajer_list'] !== null): ?>
                                        <?php foreach ($model['admin']['manajer_list'] as $manajer): ?>
                                            <tr>
                                                <td><?= $manajer->username ?></td>
                                                <td><?= $manajer->nama_manajer ?></td>
                                                <td><?= $manajer->alamat_manajer ?></td>
                                                <td><?= $manajer->no_telp_manajer ?></td>
                                                <td>
                                                    <form method="post" action="/dashboard-admin/manager">
                                                        <input type="hidden" name="username"
                                                               value="<?= $manajer->username ?>">
                                                        <input type="hidden" name="action" value="delete">
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                                            data-target="#updateModal<?= $manajer->username ?>">
                                                        Update
                                                    </button>
                                                    <!-- Update Modal -->
                                                    <div class="modal fade" id="updateModal<?= $manajer->username ?>"
                                                         tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="updateModalLabel">Update
                                                                        Employee</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" action="/dashboard-admin/manager">
                                                                        <input type="hidden" name="username"
                                                                               value="<?= $manajer->username ?>">
                                                                        <input type="hidden" name="action"
                                                                               value="update">
                                                                        <div class="form-group">
                                                                            <label for="updateName">Nama
                                                                                Karyawan</label>
                                                                            <input type="text" class="form-control"
                                                                                   id="updateName" name="updateName"
                                                                                   value="<?= $manajer->nama_manajer ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="updateAddress">Address</label>
                                                                            <input type="text" class="form-control"
                                                                                   id="updateAddress"
                                                                                   name="updateAddress"
                                                                                   value="<?= $manajer->alamat_manajer ?>">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="updatePhoneNumber">Phone
                                                                                Number</label>
                                                                            <input type="text" class="form-control"
                                                                                   id="updatePhoneNumber"
                                                                                   name="updatePhoneNumber"
                                                                                   value="<?= $manajer->no_telp_manajer ?>">
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Update
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div>

                <div>
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

            <!-- Create Employee Modal -->
            <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog"
                 aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEmployeeModalLabel">Add Manager</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/dashboard-admin/manager">
                                <input type="hidden" name="action" value="create">
                                <div class="form-group">
                                    <label for="addUsername">Username</label>
                                    <input type="text" class="form-control" id="addUsername" name="addUsername"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="addPassword">Password</label>
                                    <input type="password" class="form-control" id="addPassword" name="addPassword" required>
                                </div>

                                <div class="form-group">
                                    <label for="addName">Nama Manajer</label>
                                    <input type="text" class="form-control" id="addName" name="addName" required>
                                </div>
                                <div class="form-group">
                                    <label for="addAddress">Address</label>
                                    <input type="text" class="form-control" id="addAddress" name="addAddress" required>
                                </div>
                                <div class="form-group">
                                    <label for="addPhoneNumber">Phone Number</label>
                                    <input type="text" class="form-control" id="addPhoneNumber" name="addPhoneNumber"
                                           required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Manager</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Logout Modal-->
            <div
                class="modal fade"
                id="logoutModal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true"
            >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button
                                class="close"
                                type="button"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Select "Logout" below if you are ready to end your current session.
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">
                                Cancel
                            </button>
                            <a class="btn btn-primary" href="/logout">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
