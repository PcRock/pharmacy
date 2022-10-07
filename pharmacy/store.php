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
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                            
                            <a href="../sales/report.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                        </div>

                        <!-- Content Row -->
                        <div class="row">

                            <!-- Buccal -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=buccals#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/Sublingual.png" width="95" height="95" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Buccals</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- CAPSULES -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=capsules#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/page 45 image.jpg" width="95" height="95" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Capsules</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- DROPS -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=drops#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/shutterstock_20792725-e1530655175591.jpg" width="80" height="80" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Drops</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- INHALERS -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=inhalers#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/inhaler_1229322-768x593.jpg" width="80" height="80" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Inhalers</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Content Row -->
                        <div class="row">

                            <!-- INJECTIONS -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=injections#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/g6-768x425.jpg" width="75" height="80" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Injections</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- IMPLANTS/PATCHES -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=implants#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/mirena.jpg" width="70" height="55" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Implants</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- SURGICALS -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=surgicals#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/istockphoto-1144691333-1024x1024.jpg" width="80" height="80" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Surgicals</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- SUPPOSITORIES -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=suppositories#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/ProbioTech-wants-probiotic-suppository-to-be-counted-as-supplement_wrbm_large.jpg" width="65" height="80" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Suppository</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Content Row -->
                        <div class="row">

                            <!-- SYRUP -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=syrups#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/2d4053a3-3dc2-40c3-a026-6735cd3fc5da.png" width="80" height="80" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Syrups</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- TABLETS -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=tablets#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/depositphotos_82795524-stock-photo-coloured-pills-and-capsules-on.jpg" width="80" height="80" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Tablets</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- TOPICALS -->
                            <div class="col-xl-3 col-md-6 mb-4">
                                <a href="?product=true&class_name=topicals#product_list" class="nav-link">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="d-flex justify-content-between">
                                                    <img src="../img/store/gettyimages-930857676-1562066365 (1).jpg" width="65" height="55" class="img-fluid" alt="">
                                                    <div class="h5 ml-2 mb-0 font-weight-bold text-gray-800">Topicals</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            
                        </div>
                        <?php 
                            if(isset($_GET['product'])){ ?>
                                <!-- Content Row -->
                                <div class="row" id="product_list">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <h1 class="display-4 text-center">Product List</h1>
                                            <table class="table table-bordered table-sm table-inverse table-responsive-sm" id="dataTable">
                                                <thead class="thead-inverse">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Classification</th>
                                                        <th>Strength</th>
                                                        <th>Treatment</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        require __DIR__."/../vendor/Include/config.php";
                                                        require __DIR__."/../vendor/Include/Item_class.php";
                                                        
                                                        $config = new Config_db();
                                                        $db = $config->connect();
                                                        $item = new Items($db);
                                                        if(isset($_GET['class_name'])){
                                                            $class_name = $_GET['class_name'];

                                                            switch ($class_name) {
                                                                
                                                                case 'buccals':
                                                                    $json_data = json_decode($item->getBuccal());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->available_quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'capsules':
                                                                    $json_data = json_decode($item->getCapsules());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem_name; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'drops':
                                                                    $json_data = json_decode($item->getDrops());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'inhalers':
                                                                    $json_data = json_decode($item->getInhalers());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'injections':
                                                                    $json_data = json_decode($item->getInjections());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo $item->selling_price; ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'implants':
                                                                    $json_data = json_decode($item->getImplant());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'surgicals':
                                                                    $json_data = json_decode($item->getSurgicalItem());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'suppositories':
                                                                    $json_data = json_decode($item->getSuppositories());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'syrups':
                                                                    $json_data = json_decode($item->getSyrup());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'topicals':
                                                                    $json_data = json_decode($item->getTopical());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                case 'tablets':
                                                                    $json_data = json_decode($item->getTablets());

                                                                    if($json_data != null){

                                                                        foreach ($json_data as $key => $item) { ?>
                                                                            <tr>
                                                                                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                                                                                <td><?php echo $item->class_name; ?></td>
                                                                                <td><?php echo $item->composition; ?></td>
                                                                                <td><?php echo $item->treatment_type; ?></td>
                                                                                <td>N<?php echo number_format($item->selling_price); ?></td>
                                                                                <td><?php echo $item->quantity; ?></td>
                                                                                <td>
                                                                                    <div class="d-flex">
                                                                                    <div class="d-flex">
                                                                                        <a class="nav-link" href="./form_product.php?edit=<?php echo $item->drug_id; ?>"><i class="fas fa-edit text-primary   "></i></a>
                                                                                        <a href="./index.php?del=<?php echo $item->drug_id; ?>" class="nav-link"><i class="fas fa-trash  text-danger  "></i></a>
                                                                                    </div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php }
                                                                    }
                                                                    break;
                                                                default:
                                                                    # code...
                                                                    break;
                                                            }
                                                        }
                                                        
                                                    ?> 
                                                        
                                                    </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        ?>
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

