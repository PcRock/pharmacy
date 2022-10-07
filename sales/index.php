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
                            <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-prescription-bottle text-success    "></i> Medication</h1>
                            <div class="dropdown">
                                <a class=" nav" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                            <h3><i class="fa fa-cart-plus" aria-hidden="true"><sup><span class="badge badge-danger"><?php echo $items->getTmp_SalesInt($_SESSION['username']); ?></span></sup></i></h3>
                                        </a>
                                <div class="dropdown-menu p-2 pt-3" aria-labelledby="triggerId">
                                    <div class="d-flex justify-content-center ">
                                        <h5><strong>iCare Pharmacy</strong></h5>
                                    </div>
                                    <div class="d-flex justify-content-center"><span>Date: <?php echo date('d-M-Y H:i:s'); ?></span></div>
                                    <!-- <div class="text-center text-uppercase"><span>Cart Items</span></div>< --><hr class="my-1">
                                    <div class="d-flex-justify-content-between">
                                        <span>Rendered By: <?php echo $_SESSION['username']; ?></span>
                                    </div>
                                    <table class="table table-bordered table-sm table-inverse table-responsive-sm">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Name</th>
                                                <th>Qantity</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $json_data = json_decode($items->getTmp_Sales($_SESSION['username']));
                                                $cost = 0;
                                                if($json_data != null){

                                                    foreach ($json_data as $key => $item) { 
                                                            $cost += $item->total;
                                                        ?>
                                                        
                                                        <tr>
                                                            <td scope="row"><?php echo $item->drug_name; ?></td>
                                                            <td><?php echo $item->qantity; ?></td>
                                                            <td><?php echo $item->total; ?></td>
                                                            <td><a href="?user=<?php echo $_SESSION['username'] ?>&del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash text-danger   "></i></a></td>
                                                        </tr> 
                                                    <?php }
                                                }
                                                if(isset($_GET['del']) && isset($_GET['user'])){
                                                    $username = $_GET['user'];
                                                    $drug_id = $_GET['del'];
                                                    $json_data = json_decode($items->deleteFromCart($username,$drug_id));
                                                    
                                                }
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                        <h4>Total - N<?php echo number_format($cost); ?></h4>
                                    <form action="../vendor/Services/item_ops.php" method="post">
                                        <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                                        <div class="text-center">
                                            <button type="submit" name="render" class="btn btn-primary">Render</button>
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
                                        <?php
                                            if(isset($_GET['sales']) && isset($_GET['status'])){
                                                if($_GET['status'] == true){ ?>
                                                    <span class="text-danger"><i class="fas fa-exclamation text-danger"> </i><?php echo " ".$_GET['sales'];?></span>
                                                <?php }
                                                else{ ?>
                                                    <span class="text-success"><i class="fas fa-check-circle text-success   "></i></i><?php echo " New Sale recorded";?></span>
                                            <?php }
                                            }
                                        ?>
                                        <table class="table table-bordered table-sm table-inverse table-responsive-sm table-responsive-lg" id="dataTable">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Classification</th>
                                                    <th>Strength</th>
                                                    <th>Treatment</th>
                                                    <th>Location</th>
                                                    <th>Price</th>
                                                    <!-- <th>Quantity</th>  -->
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
                                                                    <!-- <td><?php //echo $item->quanity; ?></td>  -->
                                                                    <td>
                                                                        <div class="d-flex">
                                                                            <a class="nav-link"  href="?render=<?php echo $item->drug_id; ?>"><i class="fas fa-cart-plus text-primary   "></i></a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php }
                                                        }
                                                        if(isset($_GET['render'])){
                                                            $product_id = $_GET['render'];
                                                            $json_data = json_decode($items->addToCart($product_id,$_SESSION['username']));
                                                            if($json_data != null){
                                                                if($json_data->status == false){ ?>
                                                                    <p class="text-success"><i class="fas fa-check-circle  text-success  "></i><?php echo $json_data->message; ?></p>
                                                                <?php }
                                                                else{ ?>
                                                                    <p class="text-danger"><i class="fas fa-exclamation-circle text-danger   "></i><?php echo $json_data->message; ?></p>

                                                                <?php }
                                                            }
                                                        }
                                                        elseif(isset($_GET['render_error'])){ ?>
                                                            <p class="text-danger"><i class="fas fa-exclamation-circle text-danger   "></i><?php echo $_GET['render_error']; ?></p>
                                                        <?php }
                                                    ?> 
                                                    
                                                </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-xl-3 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title text-center">Cart List <i class="fas fa-cart-plus  text-primary  "></i></h4>
                                        <table class="table table-bordered table-sm table-inverse ">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Name</th>
                                                <th>Qty</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $json_data = json_decode($items->getTmp_Sales($_SESSION['username']));
                                                $cost = 0;
                                                if($json_data != null){

                                                    foreach ($json_data as $key => $item) { 
                                                            $cost += $item->unit_price;
                                                        ?>
                                                        
                                                        <tr>
                                                            <td scope="row"><?php echo $item->drug_name; ?></td>
                                                            <td>
                                                            <form action="../vendor/Services/item_ops.php" method="post">
                                                                <div class="d-flex">
                                                                    <input type="hidden" name="drug_id" value="<?php echo $item->drug_id ?>">
                                                                    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                                                                    <input type="number" name="quantity" value=<?php echo $item->qantity ?> style="width: 40px;">
                                                                    <select name="sale_type" id="" style="width: 40px;">
                                                                        <option value="Pack">Pack</option>
                                                                        <option value="Satchet">Satchet</option>
                                                                        <option value="Tabs">Tabs</option>
                                                                    </select>
                                                                    <button name="upate_sale_type" class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save    "></i></button>
                                                                </div>
                                                            </form>
                                                            </td>
                                                            
                                                        </tr> 
                                                    <?php }
                                                }
                                                ?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Reciept -->
                                <div class="card mt-3" >
                                    <div class="card-body">
                                    <div class="print_area">
                                        <div class="d-flex justify-content-center ">
                                            <center><h5 style="font-family: 'Times New Roman', Times, serif;
                                            font-weight: 700;
                                            color: #000;"><strong>iCare Pharmacy</strong></h5></center>
                                        </div>
                                        <div class="d-flex justify-content-center"><span style="font-family: 'Times New Roman', Times, serif;
                                            font-weight: 700;
                                            color: #000;">Date: <?php echo date('d-M-Y H:i:s'); ?></span></div>
                                        <!-- <div class="text-center text-uppercase"><span>Cart Items</span></div>< --><hr class="my-1">
                                        <div class="d-flex-justify-content-between">
                                            <span style="font-family: 'Times New Roman', Times, serif;
                                            font-weight: 700;
                                            color: #000;">Rendered By: <?php echo $_SESSION['username']; ?></span>
                                        </div>
                                        <table class="table table-bordered table-sm  " style="font-family: 'Times New Roman', Times, serif;
                                            font-weight: 700;
                                            color: #000;">
                                            <thead class="">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Qantity</th>
                                                    <th>Price</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $json_data = json_decode($items->getTmp_Sales($_SESSION['username']));
                                                    $cost = 0;
                                                    if($json_data != null){

                                                        foreach ($json_data as $key => $item) { 
                                                                $cost += $item->total;
                                                            ?>
                                                            
                                                            <tr>
                                                                <td scope="row"><?php echo $item->drug_name; ?></td>
                                                                <td><?php echo $item->qantity; ?></td>
                                                                <td><?php echo $item->total; ?></td>
                                                            </tr> 
                                                        <?php }
                                                    }
                                                    if(isset($_GET['del']) && isset($_GET['user'])){
                                                        $username = $_GET['user'];
                                                        $drug_id = $_GET['del'];
                                                        $json_data = json_decode($items->deleteFromCart($username,$drug_id));
                                                        
                                                    }
                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                            <h4 style="font-family: 'Times New Roman', Times, serif;
                                            font-weight: 900;
                                            color: #000;">Total = N<?php echo number_format($cost); ?></h4>
                                        </div> 
                                        <form action="">
                                            <button type="button" id="print" class="btn btn-warning"><i class="fas fa-print    "></i> Receipt</button>
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
        <!-- page print lib -->
        <script src="../vendor/printThis/printThis.js"></script>   
        <script src="../vendor/printThis/jquery-printme.js"></script>         
        <script>
            $('#print').click(()=>{
                $('.print_area')./* printThis(
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
                ); */
                printMe(
                    /* { "path": ["../css/css/bootstrap.css"] } */
                );
            });
            
            
        </script>                           
        </body>

        </html>
    <?php }
?>
