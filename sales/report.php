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
                            <h1 class="h3 mb-0 text-gray-800 text-primary"><a href="./index.php" class="nav-link"> <i class="fas fa-arrow-left    "></i> Back</a></h1>
                            <form action="" method="post">
                                <button type="button" id="print" class="btn btn-primary"> <i class="fas fa-file-pdf    "></i> Save PDF Report</button>
                            </form>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12 col-xl-12 col-sm-12">
                                <div class="card">
                                    <div class="card-body print_area">
                                        <div class="text-center">
                                            <h3 id="report_title" style="font-family: Tahoma;
                                            font-weight: 700;
                                            color: #000;">Financial Report Generated by <?php echo $_SESSION['username']; ?></h3>
                                            <hr>
                                        </div>
                                        <?php
                                            if(isset($_GET['sales']) && isset($_GET['status'])){
                                                if($_GET['status'] == true){ ?>
                                                    <span class="text-danger"><i class="fas fa-exclamation text-danger"></i><?php echo " ".$_GET['sales'];?></span>
                                                <?php }
                                                else{ ?>
                                                    <span class="text-success"><i class="fas fa-check-circle text-success   "></i></i><?php echo " New Sale recorded";?></span>
                                            <?php }
                                            }
                                        ?>
                                        <table class="table table-bordered table-sm  " style="font-family: Tahoma;
                                            font-weight: 700;
                                            color: #000;">
                                            <thead >
                                                <tr>
                                                    <th>S/N</th>
                                                    <th >Credit</th>
                                                    <th >Debit</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td >
                                                            <div class="d-flex justify-content-between">
                                                                <span>Sales </span>
                                                                <span>-</span>
                                                                <span><?php echo "N".number_format($items->getUserSales($_SESSION['username'])); ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                        <div >
                                                            <!-- generate is incured expenses -->
                                                            <ul class="list-unstyled">
                                                                <small><strong>Expenses</strong></small><hr class="my-0">
                                                                <?php 

                                                                    $json_data = json_decode($items->getUserExpenses($_SESSION['username']));
                                                                    if($json_data != null){
                                                                        foreach ($json_data as $key => $value) { ?>
                                                                             <li>
                                                                               <div class="d-flex justify-content-between">
                                                                                    <span><?php echo $value->expense_title; ?></span>
                                                                                    <span>-</span>
                                                                                    <span><?php echo "N".number_format($value->cost); ?></span>
                                                                               </div>
                                                                            </li>
                                                                        <?php }
                                                                    }
                                                                    echo "<hr class='my-0'><hr class='my-0'>";
                                                                    
                                                                    /* POS EXPENSES */
                                                                    echo "<small class='mt-2'><strong>POS Transactions/Transfers</strong></small><hr class='my-0'>";
                                                                    $json_data = json_decode($items->getUserPOS($_SESSION['username']));
                                                                    if($json_data != null){ ?>
                                                                        <div class="d-flex justify-content-between">
                                                                            <span><?php echo "N".number_format($json_data->amount_income); ?></span>
                                                                           
                                                                        </div>
                                                                    <?php }
                                                                ?>
                                                               
                                                            </ul>
                                                                
                                                            </div>
                                                        </td>
                                                    </tr> 
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr >
                                                        <td colspan="2">
                                                            <ul class="list-unstyled">
                                                                
                                                                <li><h6><strong>TOTAL CREDIT: N<?php echo number_format($json_data->amount_income + $items->getUserSales($_SESSION['username'])) ?></strong></h6></li>
                                                                <li><h6><strong>GRAND TOTAL: N<?php echo number_format($json_data->amount_income + $items->getUserSales($_SESSION['username']) - $items->getUserExpensesCost($_SESSION['username']) ) ?></strong></h6></li>
                                                            </ul>
                                                        </td>
                                                        <td>
                                                            <ul class="list-unstyled">
                                                            <li><h6><strong>Total Expenses N<?php echo number_format($items->getUserExpensesCost($_SESSION['username'])) ?></strong></h6></li>
                                                                <li><h6><strong>TOTAL DEBIT: N<?php echo number_format($items->getUserExpensesCost($_SESSION['username'])) ?></strong></h6></li>
                                                                <li><h6><strong></strong></h6></li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tfoot>
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
                <footer class="sticky-footer bg-white mt-2">
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
        <!-- page print lib -->
        <script src="../vendor/printThis/printThis.js"></script>            
        <script>
            $('#print').click(()=>{
                $('.print_area').printThis(
                    {
                        debug: false,               // show the iframe for debugging
                        importCSS: true,            // import parent page css
                        importStyle: true,         // import style tags
                        printContainer: true,       // print outer container/$.selector
                        loadCSS: ["http://localhost/pharmacy/css/sb-admin-2.css"],// path to additional css file - use an array [] for multiple
                        pageTitle: "",              // add title to print page
                        removeInline: false,        // remove inline styles from print elements
                        removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
                        printDelay: 333,            // variable print delay
                        header: null,               // prefix to html
                        footer: "",               // postfix to html
                        base: true,                // preserve the BASE tag or accept a string for the URL
                        formValues: true,           // preserve input/form values
                        canvas: false,              // copy canvas content
                        doctypeString: '...',       // enter a different doctype for older markup
                        removeScripts: false,       // remove script tags from print content
                        copyTagClasses: false,      // copy classes from the html & body tag
                        beforePrintEvent: null,     // function for printEvent in iframe
                        beforePrint: null,          // function called before iframe is filled
                        afterPrint: null            // function called before iframe is removed
                    }
                );
            });
            
            
        </script>  
        </body>

        </html>
    <?php }
?>
