<?php 
    require __DIR__."/./header.php";
    require __DIR__."/../vendor/Include/config.php";
    require __DIR__."/../vendor/Include/Item_class.php";
    
    $config = new Config_db();
    $db = $config->connect();
    $items = new Items($db);

    if(isset($_SESSION['username'])){ ?>
        <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php
                require_once __DIR__."/./sidebar.php";
            ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                
                    <!-- Topbar Navbar -->
                    <?php
                        require_once __DIR__."/./navbar.php";
                    ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-sm-flex align-items-center justify-content-center mb-4">
                                            <h3>POS(Point Of Sales) Report</h3>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <?php 
                                                if(isset($_GET['status']) && isset($_GET['sales'])){
                                                    if($_GET['status'] == false){ ?>
                                                        <h3 class="text-success"><?php echo $_GET['sales']; ?></h3>
                                                    <?php }
                                                    else{ ?>
                                                        <h3 class="text-danger"><?php echo $_GET['sales']; ?></h3>
                                                    <?php }
                                                }
                                            ?>
                                        </div>
                                        <form action="../vendor/Services/item_ops.php" method="post">
                                            <div class="form-group">
                                              <label for="">Amount Dispensed</label>
                                              <input type="number"
                                                class="form-control" name="dispense" id="" aria-describedby="helpId" placeholder="Amount Dispensed">
                                            </div>
                                            <div class="form-group">
                                              <label for="">Amount Recieved</label>
                                              <input type="number"
                                                class="form-control" name="recieved" id="" aria-describedby="helpId" placeholder="Amount Recieved">
                                            </div>
                                            <!-- <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="status" id="" >
                                                IF TRANSACTION SUCCESSFULLY ONLY PLEASE
                                              </label>
                                            </div> -->
                                            <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>">
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" name="save_expense_pos" class="btn btn-primary">Save Report</button>
                                            </div>
                                        </form>
                                    </div>
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
                    <div class="modal-body">
                        <div class="text-center">
                            <span>Hello <?php echo $_SESSION['username']. ","; ?></span>
                        Select "Logout" below if you are ready to end your current session.
                        </div>
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
