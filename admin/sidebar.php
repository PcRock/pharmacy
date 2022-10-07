<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3">iCare Pharmacy</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <?php 
        if(isset($_SESSION['role'])){
            switch ($_SESSION['role']) {
                case 'Admin': ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span></a>
                    </li>
                   <?php break;
                case 'Pharm': ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="../pharmacy/index.php">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span></a>
                    </li>
                   <?php break;
                default:
                    # code...
                    break;
            }
        }
    ?>
    
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- new product -->
    <li class="nav-item">
        <a class="nav-link" href="../pharmacy/form_product.php">
            <i class="fas fa-plus-circle    "></i>
            <span>ADD PRODCUT</span></a>
    </li>
    <!-- NEW STAFF -->
    <?php 
        if(isset($_SESSION['role'])){
            if($_SESSION['role'] == 'Admin'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="./new_staff.php" >
                        <i class="fas fa-user-plus    "></i>
                        <span>New Staff</span>
                    </a>
                </li>
            <?php }
        }
    ?>
    <!-- ATTENDANCE -->
    <?php 
        if(isset($_SESSION['role'])){
            if($_SESSION['role'] == 'Admin'){ ?>
                <li class="nav-item">
                <a class="nav-link" href="../404.php" >
                    <i class="fas fa-book-open    "></i>
                    <span>ATTENDANCE</span>
                </a>
                </li>
            <?php }
        }
    ?>
    <!-- business matrix -->
    <?php 
        if(isset($_SESSION['role'])){
            if($_SESSION['role'] == 'Admin'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="./business.php" >
                        <i class="fas fa-chart-bar    "></i>
                        <span>BUSINESS MATRIX</span>
                    </a>
                </li>
            <?php }
        }
    ?>
    <!-- VIEW STORE-->
    <li class="nav-item">
        <a class="nav-link" href="../pharmacy/store.php" >
            <i class="fas fa-building    "></i>
            <span>VIEW STORE</span>
        </a>
    </li>
    <!-- VIEW STAFF-->
    <?php 
        if(isset($_SESSION['role'])){
            if($_SESSION['role'] == 'Admin'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="../404.php" >
                        <i class="fas fa-users    "></i>
                        <span>VIEW STAFF</span>
                    </a>
                </li>
            <?php }
        }
    ?>
    <!-- VIEW COMPLAINS-->
    <?php 
        if(isset($_SESSION['role'])){
            if($_SESSION['role'] == 'Admin'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="../404.php" >
                        <i class="fas fa-comment    "></i>
                        <span>VIEW COMPLAINS</span>
                    </a>
                </li>
            <?php }
        }
    ?>
    <!-- VIEW PROFILE-->
    <li class="nav-item">
        <a class="nav-link" href="./my_profile.php" >
            <i class="fas fa-user    "></i>
            <span>PROFILE</span>
        </a>
    </li>
   <!-- Financial Report-->
   <li class="nav-item">
        <a class="nav-link" href="../sales/report.php" >
            <i class="fas fa-user    "></i>
            <span>GENERATE REPORT</span>
        </a>
    </li>
    <!-- miscelleneous -->
    <li class="nav-item">
        <a class="nav-link" href="../sales/expenses.php">
            <i class="fas fa-list    "></i>
            <span>MISCELLENEOUS</span></a>
    </li>
    <!-- POS REPORT -->
    <li class="nav-item">
        <a class="nav-link" href="../sales/pos_transactions.php">
            <i class="fas fa-list    "></i>
            <span>POS REPORT</span></a>
    </li>
    <!-- POS REPORT -->
    <li class="nav-item">
        <a class="nav-link" href="../sales/index.php">
            <i class="fas fa-list    "></i>
            <span>Sele Product</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

   

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>