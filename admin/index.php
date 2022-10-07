<?php 
    
    require __DIR__."/./header.php";

    require __DIR__."/../vendor/Include/config.php";
    require __DIR__."/../vendor/Include/Item_class.php";
    
    $config = new Config_db();
    $db = $config->connect();
    $items = new Items($db);

    if($_SESSION['username']){ ?>
        <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php 
                require __DIR__."/./sidebar.php";
            ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php
                        require __DIR__."/./navbar.php";
                    ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>;
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <!-- New Staff -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./new_staff.php" class="nav-link">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    New Staff</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">New Staff</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user  fa-2x text-gray-300  "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!-- Business Matric -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./business.php" class="nav-link">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    My Business Matric</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Business </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-piggy-bank  fa-2x text-gray-300  "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!-- view Store -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="../pharmacy/store.php" class="nav-link">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    My Store</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Store </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-building fa-2x text-gray-300  "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./business.php#sales_table" class="nav-link">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Sales Record</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Sales </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-list fa-2x text-gray-300   "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                        <!-- Content Row -->
                        <div class="row">

                            <!-- Expired -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./expired_products.php" class="nav-link">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Products</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Expired <sup><span class="badge badge-danger"><?php echo $items->getExpiredProductInt(); ?></span></sup> </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-calendar  fa-2x text-gray-300  "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!-- Running out-->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./product_out_stock.php" class="nav-link">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Out of Stock</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Stock <sup><span class="badge badge-danger"><?php echo $items->getRunningOutProductInt(); ?></span></sup></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-battery-empty fa-2x text-gray-300   "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!-- view Store -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./business.php" class="nav-link">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Miscelleneous</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Expenses </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300   "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./business.php" class="nav-link">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Staff Report</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Attendance </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-check fa-2x text-gray-300   "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>
                       <div class="row">
                            <!-- Expense Report -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./expenses.php" class="nav-link">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Expenditures</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Expenses Report </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-receipt fa-2x text-gray-300   "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <!-- POS and transfers transactions -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./transfers.php" class="nav-link">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Transfers</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">POS Transaction</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-credit-card fa-2x text-gray-300   "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
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
                            <span>Developed By PcRock PcFire Technology 2021</span>
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
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                    <form action="../vendor/Services/user_ops.php" method="post">
                        <div class="form-group">
                        <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" name="logout" class="btn btn-primary">Logout</button>
                        </div>
                    </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="../vendor/jquery/jquery.min.js"></script>
        <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="../vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/chart-area-demo.js"></script>
        <script src="../js/demo/chart-pie-demo.js"></script>

        <!-- Page level plugins -->
        <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="../js/demo/datatables-demo.js"></script>

        </body>

        </html>
    <?php }
?>
