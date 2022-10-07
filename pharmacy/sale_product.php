<?php 
    require __DIR__."/./header.php";
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
                            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-prescription-bottle text-success    "></i> Medication</h1>
                            <div class="dropdown">
                                <a class=" dropdown-toggle no-arrow nav" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                            <h3><i class="fa fa-cart-plus" aria-hidden="true"><sup><span class="badge badge-danger">4</span></sup></i></h3>
                                        </a>
                                <div class="dropdown-menu p-2" aria-labelledby="triggerId">
                                    <div class="text-center text-uppercase"><span>Cart List</span></div><hr class="my-1">
                                    <span>Cart Items: 4</span>
                                    <table class="table table-bordered table-sm table-inverse table-responsive-sm">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Name</th>
                                                <th>Qantity</th>
                                                <th>Price</th>
                                                <th >Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td scope="row">Omepraflex</td>
                                                    <td>2</td>
                                                    <td>600</td>
                                                    <td>
                                                        <a href=""><i class="fas fa-trash text-danger    "></i></a>
                                                    </td>
                                                </tr> 
                                            </tbody>
                                        </table>
                                        <h4>Total - N600</h4> 
                                    <form action="" method="post">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Render</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-9 col-xl-9 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- <form class="form-inline mr-auto w-100 navbar-search mb-2">
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
                                        </form> -->
                                        <table class="table table-bordered table-sm table-inverse table-responsive-sm" id="dataTable">
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
                                                    <tr>
                                                        <td scope="row">Omepraflex, Omeprazole Sodium</td>
                                                        <td>Injection</td>
                                                        <td>40mg</td>
                                                        <td>Ulcer</td>
                                                        <td>A12</td>
                                                        <td>N300</td>
                                                        <td>350</td>
                                                        <td><a class="nav-link" href=""><i class="fas fa-cart-plus text-primary   "></i></a></td>
                                                    </tr>
                                                    
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3 col-sm-12">
                                <div class="card">
                                    <img class="card-img-top" src="holder.js/100x180/" alt="">
                                    <div class="card-body">
                                        <h4 class="card-title text-center">Dose Calculator <i class="fas fa-calculator  text-primary  "></i></h4>
                                        <form action="" method="post">

                                            <div class="text-center">
                                                <button class="btn btn-primary btn-sm" type="submit">Calculate</button>
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
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
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
