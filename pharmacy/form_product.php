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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Home -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <?php 
                                if(isset($_SESSION['role'])){
                                    switch ($_SESSION['role']) {
                                        case 'Admin': ?>
                                            <a href="../admin/index.php" class="nav-link">
                                           <?php break;
                                        case 'Pharm': ?>
                                        <a href="index.php" class="nav-link">
                                        <?php break;
                                        default:
                                            # code...
                                            break;
                                    }
                                }
                            ?>
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Home</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-home fa-2x text-gray-300   "></i>
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

                    <!-- Content Row -->
                    
                    <?php 
                        if(isset($_GET['edit'])){ 
                            
                            $name = $_GET['edit'];
                            
                            $json_data = json_decode($items->itemInformation($name));
                            
                            if($json_data != null){ ?>

                        <!-- Edit Product -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h1 class="display-4 text-center"><?php echo $json_data->drug_name.",". $json_data->drug_chem_name;  ?></h1>
                                        <?php
                                            if(isset($_GET['message']) && isset($_GET['status'])){
                                                $message = $_GET['message'];
                                                $status = $_GET['status'];

                                                if($status == false){ ?>
                                                    <div class="text-center">
                                                        <span class="text-success"><strong><?php echo $message; ?></strong></span>
                                                    </div>
                                                <?php }
                                                elseif($status == true){ ?>
                                                    <div class="text-center">
                                                        <span class="text-danger"><strong><?php echo $message; ?></strong></span>
                                                    </div>
                                                <?php }
                                            }
                                        ?>
                                        <form action="../vendor/Services/item_ops.php" method="post">
                                            <!-- Product Information -->
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                        <input type="text" required name="drug_name" value="<?php echo $json_data->drug_name?>" id="" class="form-control" placeholder="Generic Name" aria-describedby="helpId">
                                                        <input type="hidden" name="drug_id" value="<?php echo $json_data->drug_id ?>">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                    <input required type="text" value="<?php echo $json_data->drug_chem_name?>" name="drug_chem_name" id="" class="form-control" placeholder="Chemical Name" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                    <i class="fas fa-asterisk text-danger   "></i>
                                                    <input required type="text" value="<?php echo $json_data->composition?>" name="composition" id="" class="form-control" placeholder="Composition e.g 40mg" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- drug classification,location,target,treatment -->
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                    <select required name="class_name"  id="" class="form-control">
                                                    <option value="">Select Drug Classification</option>
                                                            <option value="Antacid">Antacid</option>
                                                            <option value="Anti Asmthatic">Anti Asmthatic</option>
                                                            <option value="Anti Alergy">Anti Alergy</option>
                                                            <option value="Antibiotics">Antibiotics</option>
                                                            <option value="Anti Diarreah">Anti Diarreah</option>
                                                            <option value="Anti Diabetics">Anti Diabetics</option>
                                                            <option value="Anti Fungals">Anti Fungals</option>
                                                            <option value="Anti hemorhoid">Anti hemorhoid</option>
                                                            <option value="Anti Helminths">Anti Helminths</option>
                                                            <option value="Anti Histamin">Anti Histamin</option>
                                                            <option value="Anti Hypertensive">Anti Hypertensive</option>
                                                            <option value="Anti Malaria">Anti Malaria</option>
                                                            <option value="Anti Spetics">Anti Spetics</option>
                                                            <option value="Anti viral">Anti viral</option>
                                                            <option value="Analgesics">Analgesics</option>
                                                            <option value="Anti Ulcer">Anti Ulcer</option>
                                                            <option value="Beverages">Beverages</option>
                                                            <option value="Blood Tonic">Blood Tonic</option>
                                                            <option value="Cough Syrup">Cough Syrup</option>
                                                            <option value="Contraceptive">Contraceptive</option>
                                                            <option value="Dressing">Dressing</option>
                                                            <option value="Energy Drink">Energy Drink</option>
                                                            <option value="Injectable">Injectable</option>
                                                            <option value="Man Power">Man Power</option>
                                                            <option value="Medical Device">Medical Device</option>
                                                            <option value="Multivitain">Multivitain</option>
                                                            <option value="Supplement">Supplement</option>
                                                            <option value="Others">Others</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                    <input type="text" required value="<?php echo $json_data->location_name?>" name="location_name" id="" class="form-control" placeholder="location in store eg. A12" aria-describedby="helpId">
                                                    <small>Box Location</small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                    <select required name="target" id="" class="form-control">
                                                        <option value="">Select Target</option>
                                                        <option value="Adult">Adult</option>
                                                        <option value="Children">Children</option>
                                                        <option value="General">General</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                    <input required type="text" value="<?php echo $json_data->treatment_type?>" name="treatment_type" id="" class="form-control" placeholder="Treatment e.g fever" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Production Information -->
                                            <div class="row">
                                                <div class="col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                    <i class="fas fa-asterisk text-danger   "></i>
                                                    <input required type="date" value="<?php echo $json_data->exp_date?>" name="exp_date" id="" class="form-control" placeholder="" aria-describedby="helpId">
                                                    <small id="helpId" class="text-muted">Expiry Date</small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-6">
                                                    <div class="form-group">
                                                    <i class="fas fa-asterisk text-danger   "></i>
                                                    <input required type="date" value="<?php echo $json_data->mfg_date?>" name="mfg_date" id="" class="form-control" placeholder="" aria-describedby="helpId">
                                                    <small id="helpId" class="text-muted">Manufacturing Date</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Product Formulation -->
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                    <i class="fas fa-asterisk text-danger   "></i>
                                                    <select required name="form_name" id="" class="form-control">
                                                    <option value="">Select Formulation</option>
                                                            <option value="Buccal">Buccal,Sublingual or Liquid</option>
                                                            <option value="Capsule">Capsule</option>
                                                            <option value="Cream">Cream</option>
                                                            <option value="Drop">Drop</option>
                                                            <option value="Gel">Gel</option> 
                                                            <option value="Infusion">Infusion</option>
                                                            <option value="Inhaler">Inhaler</option> 
                                                            <option value="Injection">Injection</option>
                                                            <option value="Implant">Implant, Patch</option>
                                                            <option value="Lozenges">Lozenges</option>
                                                            <option value=" ointment"> ointment</option>
                                                            <option value="solution">solution</option>
                                                            <option value="Suppository">Suppository</option>
                                                            <option value="Surgicals">Surgical</option>
                                                            <option value="Suspension">Suspension</option>
                                                            <option value="Syrups">Syrup</option>
                                                            <option value="Tablet">Tablet</option>
                                                            <option value="Topical">Topical</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                    <i class="fas fa-asterisk text-danger   "></i>
                                                    <input required type="number" value="<?php echo $json_data->quantity_satch_pack?>" name="quantity_satch_pack" id="" class="form-control" placeholder="Satchet per Pack" aria-describedby="helpId">
                                                    <small>Satchet per Pack</small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                    <i class="fas fa-asterisk text-danger   "></i>
                                                    <input type="number" value="<?php echo $json_data->qauntity_tabs_pack?>" name="qauntity_tabs_pack" id="" class="form-control" placeholder="Quantity Tabs per Satchet" aria-describedby="helpId">
                                                    <small>Tabs per Satchet</small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                    <i class="fas fa-asterisk text-danger   "></i>
                                                    <input type="number" name="quantity_supp" value="<?php echo $json_data->quantity_supp?>" id="" class="form-control" placeholder="Quantity Supplied" aria-describedby="helpId">
                                                    <small>Quantity Supplied</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Price Product -->
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                    <select required name="supp_type" id="" class="form-control">
                                                        <option value="">I Supplied in...</option>
                                                        <option value="Pack">Pack</option>
                                                        <option value="Satchet">Satchet</option>
                                                        <option value="Tabs">Tabs</option>
                                                    </select>
                                                    <small>Help me Know how you supplied</small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                    <input type="number" value=<?php echo $json_data->supp_price; ?> name="price_sup" class="form-control" id="" placeholder="Enter Price Supplied">
                                                    <small>Help me Know price you Supplied</small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                    <input type="number" name="percentage" class="form-control" id="" placeholder="Enter Percent Profit ">
                                                    <small>Example 10 for 10%,20 for 20%</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-primary" name="update_product" type="submit">Update Product</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }
                        }
                        else{ ?>
                            <!-- New Product -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h1 class="display-4 text-center">New Product</h1>
                                            <?php
                                                if(isset($_GET['message']) && isset($_GET['status'])){
                                                    $message = $_GET['message'];
                                                    $status = $_GET['status'];

                                                    if($status == false){ ?>
                                                        <div class="text-center">
                                                            <span class="text-success"><strong><?php echo $message; ?></strong></span>
                                                        </div>
                                                    <?php }
                                                    elseif($status == true){ ?>
                                                        <div class="text-center">
                                                            <span class="text-danger"><strong><?php echo $message; ?></strong></span>
                                                        </div>
                                                    <?php }
                                                }
                                            ?>
                                            <form action="../vendor/Services/item_ops.php" method="post">
                                                <!-- Product Information -->
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <i class="fas fa-asterisk text-danger   "></i>
                                                        <input type="text" required name="drug_name" id="" class="form-control" placeholder="Generic Name" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <i class="fas fa-asterisk text-danger   "></i>
                                                        <input required type="text" name="drug_chem_name" id="" class="form-control" placeholder="Chemical Name" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                        <input required type="text" name="composition" id="" class="form-control" placeholder="Composition e.g 40mg" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- drug classification,location,target,treatment -->
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                        <select name="class_name" id="" class="form-control">
                                                            <option value="">Select Drug Classification</option>
                                                            <option value="Antacid">Antacid</option>
                                                            <option value="Anti Asmthatic">Anti Asmthatic</option>
                                                            <option value="Anti Alergy">Anti Alergy</option>
                                                            <option value="Antibiotics">Antibiotics</option>
                                                            <option value="Anti Diarreah">Anti Diarreah</option>
                                                            <option value="Anti Diabetics">Anti Diabetics</option>
                                                            <option value="Anti Fungals">Anti Fungals</option>
                                                            <option value="Anti hemorhoid">Anti hemorhoid</option>
                                                            <option value="Anti Helminths">Anti Helminths</option>
                                                            <option value="Anti Hypertensive">Anti Hypertensive</option>
                                                            <option value="Anti Malaria">Anti Malaria</option>
                                                            <option value="Anti Spetics">Anti Spetics</option>
                                                            <option value="Anti viral">Anti viral</option>
                                                            <option value="Analgesics">Analgesics</option>
                                                            <option value="Anti Ulcer">Anti Ulcer</option>
                                                            <option value="Beverages">Beverages</option>
                                                            <option value="Blood Tonic">Blood Tonic</option>
                                                            <option value="Cough Syrup">Cough Syrup</option>
                                                            <option value="Contraceptive">Contraceptive</option>
                                                            <option value="Dressing">Dressing</option>
                                                            <option value="Energy Drink">Energy Drink</option>
                                                            <option value="Injectable">Injectable</option>
                                                            <option value="Man Power">Man Power</option>
                                                            <option value="Medical Device">Medical Device</option>
                                                            <option value="Multivitain">Multivitain</option>
                                                            <option value="Supplement">Supplement</option>
                                                            <option value="Others">Others</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                        <input type="text" required name="location_name" id="" class="form-control" placeholder="location in store eg. A12" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                        <select name="target" id="" class="form-control">
                                                            <option value="">Select Target</option>
                                                            <option value="Adult">Adult</option>
                                                            <option value="Children">Children</option>
                                                            <option value="General">General</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                        <input required type="text" name="treatment_type" id="" class="form-control" placeholder="Treatment e.g fever" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Production Information -->
                                                <div class="row">
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                        <input required type="date" name="exp_date" id="" class="form-control" placeholder="" aria-describedby="helpId">
                                                        <small id="helpId" class="text-muted">Expiry Date</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                        <input required type="date" name="mfg_date" id="" class="form-control" placeholder="" aria-describedby="helpId">
                                                        <small id="helpId" class="text-muted">Manufacturing Date</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Product Formulation -->
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                        <select name="form_name" id="" class="form-control">
                                                            <option value="">Select Formulation</option>
                                                            <option value="Buccal">Buccal,Sublingual or Liquid</option>
                                                            <option value="Capsule">Capsule</option>
                                                            <option value="Cream">Cream</option>
                                                            <option value="Drop">Drop</option>
                                                            <option value="Gel">Gel</option> 
                                                            <option value="Infusion">Infusion</option>
                                                            <option value="Inhaler">Inhaler</option> 
                                                            <option value="Injection">Injection</option>
                                                            <option value="Implant">Implant, Patch</option>
                                                            <option value="Lozenges">Lozenges</option>
                                                            <option value=" ointment"> ointment</option>
                                                            <option value="solution">solution</option>
                                                            <option value="Suppository">Suppository</option>
                                                            <option value="Surgicals">Surgical</option>
                                                            <option value="Suspension">Suspension</option>
                                                            <option value="Syrups">Syrup</option>
                                                            <option value="Tablet">Tablet</option>
                                                            <option value="Topical">Topical</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                        <input required type="number" name="quantity_satch_pack" id="" class="form-control" placeholder="Satchet per Pack" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                        <input type="number" name="qauntity_tabs_pack" id="" class="form-control" placeholder="Quantity Tabs per Satchet" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                        <i class="fas fa-asterisk text-danger   "></i>
                                                        <input type="number" name="quantity_supp" id="" class="form-control" placeholder="Quantity Supplied" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Price Product -->
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                        <select name="supp_type" id="" class="form-control">
                                                            <option value="">I Supplied in...</option>
                                                            <option value="Pack">Pack</option>
                                                            <option value="Satchet">Satchet</option>
                                                            <option value="Tabs">Tabs</option>
                                                        </select>
                                                        <small>Help me Know how you supplied</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                        <input type="num" name="price_sup" class="form-control" id="" placeholder="Enter Price Supplied">
                                                        <small>Help me Know price you Supplied</small>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                        <input type="num" name="percentage" class="form-control" id="" placeholder="Enter Percent Profit ">
                                                        <small>Example 10 for 10%,20 for 20%</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <button class="btn btn-primary" name="save_drug" type="submit">Save Product</button>
                                                </div>
                                            </form>
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

    </body>

    </html>
    <?php }
?>
