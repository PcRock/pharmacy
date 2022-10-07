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
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-center"><h1 class="display-4 text-center">Running/Out of Stock</h1></h4><hr class="my-1">
                                        <table class=table table-bordered table-sm table-inverse table-responsive-sm" id="dataTable">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Medication</th>
                                                    <th>Strength</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $json_data = json_decode($items->getRunningOutProducts());
                                                        if($json_data != null){
                                                            foreach($json_data as $value){ ?>
                                                                <tr>
                                                                    <td scope="row"><?php echo $value->sn; ?></td>
                                                                    <td><?php echo $value->drug_name." ". $value->drug_chem_name; ?></td>
                                                                    <td><?php echo $value->composition; ?></td>
                                                                    <td><?php echo $value->available_quantity; ?></td>
                                                                    <td><a href="../pharmacy/form_product.php?edit=<?php echo $value->drug_id; ?>"><i class="fas fa-edit    "></i></a></td>
                                                                </tr>
                                                            <?php }
                                                        }
                                                        else{
                                                            echo "null";
                                                        }
                                                    ?>
                                                </tbody>
                                        </table>
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
