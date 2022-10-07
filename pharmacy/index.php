<?php
    require __DIR__."/./header.php";

    if(isset($_SESSION['username'])){ ?>
        <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <?php 
                require __DIR__."/./sidebar.php";
                require __DIR__."/../vendor/Include/config.php";
                require __DIR__."/../vendor/Include/Item_class.php";
                
                $config = new Config_db();
                $db = $config->connect();
                $items = new Items($db);
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
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                            <?php 
                                if(isset($_GET['update'])){ 
                                    $message = $_GET['update'];
                                    echo "<h4 class='text-success'> Product $message </h4>";
                                }
                            ?>
                            <a href="../sales/report.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <!-- New product -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./form_product.php" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">New Product</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-plus fa-2x text-gray-300   "></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- View Store -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="./store.php" class="nav-link">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">View Store</div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fas fa-building  fa-2x text-gray-300  "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!-- Expired Products -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="../admin/expired_products.php" class="nav-link">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Expired <sup><span class="badge badge-danger"><?php echo $items->getExpiredProductInt(); ?></span></sup></div>
                                            </div>
                                            <div class="col-auto">
                                            <i class="fas fa-trash fa-2x text-gray-300   "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>

                            <!-- Pending Requests Card Example -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="../admin/product_out_stock.php" class="nav-link">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    </div>
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
                        </div>
                        <div class="row">
                            <!-- Sale Product -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="../sales/index.php" class="nav-link">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Sale Product<i class="fas fa-product-hunt    "></i></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-coins fa-2x text-gray-300   "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            <!-- My Sales Today -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="" class="nav-link">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">My Sales</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-bill   fa-2x text-gray-300 "></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="display-4 text-center">Product List</h1>
                                    <table class="table table-bordered table-sm table-inverse table-responsive-sm table-responsive-md table-responsive-lg" id="dataTable">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Name</th>
                                                <th>Classification</th>
                                                <th>Strength</th>
                                                <th>Treatment</th>
                                                <th>Location</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                
                                                $json_data = json_decode($items->getAllItem());

                                                if($json_data != null){

                                                    foreach ($json_data as $key => $item) { ?>
                                                        <tr>
                                                            <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                            <td><?php echo $item->class_name; ?></td>
                                                            <td><?php echo $item->composition; ?></td>
                                                            <td><?php echo $item->treatment_type; ?></td>
                                                            <td><?php echo $item->location_name; ?></td>
                                                            <td>N<?php echo $item->selling_price; ?></td>
                                                            <td><?php echo $item->quanity; ?></td>
                                                            <td>
                                                                <div class="d-flex">
                                                                <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                <a href="?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php }
                                                }
                                                if(isset($_GET['del'])){
                                                    $name = $_GET['del'];
                                                    $json_data = json_decode($items->deleteFromStore($name));
                                                    if($json_data != null){
                                                       
                                                        if($json_data->status == false){
                                                            echo "<h3 class ='text-success text-center'>$json_data->message  <i class='fas fa-check-circle text-success'></i></h3>";
                                                        }
                                                        else{
                                                            echo "<h3 class ='text-danger text-center'>$json_data->message</h3>";
                                                        }
                                                    }
                                                }
                                            ?> 
                                                
                                            </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
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

