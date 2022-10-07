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
                                            <h3>Select Transaction to Revoke</h3>
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
                                        <!-- TRASACTION LIST FOR REVOKE -->
                                        <table class="table table-bordered table-sm table-inverse table-responsive-sm table-responsive-lg" id="dataTable">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>Brand Name, Chemical Name & Strength</th>
                                                    <th>Quantity</th>
                                                    <th>Sale Type</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $products = json_decode($items->getSalesIndividual($_SESSION['username']));

                                                        if($products != null){

                                                            foreach ($products as $key => $product) { 
                                                                
                                                                $id = bin2hex($product->sale_id); 
                                                                $product_info = $items->getProductsInformation($product->drug_id);

                                                                if($product_info != null){
                                                                    $product_data = $product_info;
                                                                }
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $product_data; ?></td>
                                                                    <td><?php echo $product->quantity ?></td>
                                                                    <td><?php echo $product->sale_type ?></td>
                                                                    <td><?php echo $product->date_time ?></td>
                                                                    <td><?php echo "<a class='text-danger' href='?revoke_sales_id=$id'><i class='fas fa-cart-arrow-down    '></i></a>" ?></td>
                                                                </tr>
                                                            <?php }
                                                        }
                                                        
                                                        /* Revoke transaction  */
                                                        if(isset($_GET['revoke_sales_id'])){
                                                            $revoke_sales_id = hex2bin($_GET['revoke_sales_id']);
                                                            
                                                            $revoke_data = json_decode($items->revokeTransaction($revoke_sales_id));

                                                            if($revoke_data != null){
                                                                if($revoke_data->status == false){ ?>
                                                                   <div class="display-4 text-success">
                                                                    <?php echo $revoke_data->message; ?>
                                                                   </div>
                                                                <?php }
                                                                else{ ?>
                                                                    <div class="display-4 text-danger">
                                                                    <?php echo $revoke_data->message; ?>
                                                                   </div>
                                                                <?php }
                                                            }
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
