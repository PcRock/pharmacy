<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            
        </div>
        <div class="sidebar-brand-text mx-3">iCare Pharmcy</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <?php 
        if(isset($_SESSION['role'])){
            switch ($_SESSION['role']) {
                case 'Admin': ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="../admin/index.php">
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
                case 'Salesman': ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="../sales/index.php">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span></a>
                    </li>
                   <?php break;
                
                default: ?>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span></a>
                    </li>
                   <?php break;
            }
        }
    ?>
    
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Report -->
    <li class="nav-item">
        <a class="nav-link" href="./report.php">
            <i class="fas fa-newspaper    "></i>
            <span>GENERATE REPORT</span></a>
    </li>
    <!-- complains -->
    <li class="nav-item">
        <a class="nav-link" href="../404.php">
            <i class="fas fa-comment    "></i>
            <span>MAKE COMPLAIN</span></a>
    </li>
    <!-- revoke transaction -->
    <li class="nav-item">
        <a class="nav-link" href="./revoke_transaction.php">
            <i class="fas fa-archway  text-primary  "></i>
            <span>REVOKE TRANSACTION</span>
        </a>
    </li>
    <!-- miscelleneous -->
    <li class="nav-item">
        <a class="nav-link" href="./expenses.php">
            <i class="fas fa-list    "></i>
            <span>MISCELLENEOUS</span></a>
    </li>
    <!-- POS REPORT -->
    <li class="nav-item">
        <a class="nav-link" href="./pos_transactions.php">
            <i class="fas fa-list    "></i>
            <span>POS REPORT</span></a>
    </li>
    <!-- sales -->
    <li class="nav-item">
        <a class="nav-link" href="../404.php">
            <i class="fas fa-table    "></i>
            <span>MY SALES</span></a>
    </li>
    <!-- profile -->
    <li class="nav-item">
        <a class="nav-link" href="./profile.php">
            <i class="fas fa-user-shield    "></i>
            <span>PROFILE</span></a>
    </li>
    <!-- Financial Report -->
    <?php
        if(isset($_SESSION['role'])){
            if($_SESSION['role'] == 'Salesman'){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="./report.php">
                        <i class="fas fa-receipt    "></i>
                        <span class="text-uppercase">Generate Report</span></a>
                </li>
            <?php }
        }
    ?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>