<?php 
    
    require __DIR__."/./header.php";

    if(isset($_SESSION['username'])){ ?>
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
                        <div class="d-sm-flex align-items-center justify-content-center mb-4">
                            <h1 class="display-4">Register New Staff</h1>
                            
                        </div>

                        <!-- Content Row -->

                        <div class="row">
                            <!-- Area Chart -->
                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Staff Registiration</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <!-- New Staff Registration Form -->
                                        <div class="row">
                                            <div class="col-lg-5 col-sm-12">
                                                
                                                <img src="../img/store/drug_s.jpg" alt="" class="img-fluid" srcset="">
                                                <div class="d-flex justify-content-center">
                                                    <p class="write-up">Wherever the art of Medicine is Loved, there is also a love of Humanity</p>
                                                </div>
                                            </div>
                                            <!-- login form -->
                                            <div class="col-lg-6 col-sm-12">
                                                <p class="text-center text-warning h3 ">Staff Bio-Data</p>
                                                <!-- Error Messages -->
                                                <?php
                                                    if (isset($_GET['form']) && isset($_GET['status'])) {
                                                        $message = $_GET['form'];
                                                        $status = $_GET['status'];
                                                        if($status == false){
                                                            echo "<p class='text-success text-center'><strong>$message</strong></p>";
                                                        }
                                                        elseif($status == true){
                                                            echo "<p class='text-danger text-center'><strong>$message</strong></p>";
                                                        }
                                                        
                                                    }
                                                ?>
                                                    <form action="../vendor/Services/user_ops.php" method="post" autocomplete="off">
                                                        <div class="row">
                                                            <div class="col-lg-7 col-sm-12">
                                                                <div class="from-group">
                                                                    <input type="text" name="name" id="" class="form-control m-2"  placeholder="Enter your Fullname">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-sm-12">
                                                                <div class="form-group">
                                                                    <input type="text" name="username" id="" class="form-control m-2" placeholder="Enter your Username ">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6 col-sm-12">
                                                                <div class="from-group">
                                                                    <input type="email" name="email" id="" class="form-control m-2"  placeholder="Enter your Email">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <input type="tel" name="phone_no" id="" class="form-control m-2" placeholder="Enter your Mobile Number">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row my-1">
                                                            <div class="col-lg-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <input type="date" name="dob" class="form-control m-2" placeholder="Birthday Date">
                                                                    <small class="mx-4">Birthday Date</small>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-sm-12">
                                                                <div class="form-group">
                                                                    <select name="role" id="" class="form-control m-2">
                                                                        <option value="Admin">Admin</option>
                                                                        <option value="Pharm">Pharm</option>
                                                                        <option value="Salesman">Salesman</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" name="pwd" id="" class="form-control m-2" placeholder="Enter your Password">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" name="confirm_pwd" id="" class="form-control m-2" placeholder="Re-type your Password">
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name="address" id="" cols="10" rows="5" class="form-control m-2" placeholder="Enter your Residential Address"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <button type="submit" name="reg" class="form-control m-3 btn btn-warning text-light">Get me Started!!</button>
                                                        </div>
                                                    </form>
                                            </div>
                                    </div>
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
