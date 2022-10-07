<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
        
    </div>
    <div class="sidebar-brand-text mx-3">iCare Pharmacy</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">
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
                    <a class="nav-link" href="index.php">
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
<!-- Nav Item - Dashboard -->

<!-- Divider -->
<hr class="sidebar-divider">

<!-- new product -->
<li class="nav-item">
    <a class="nav-link" href="./form_product.php">
        <i class="fas fa-plus-circle    "></i>
        <span>ADD PRODCUT</span></a>
</li>

<!-- complain -->
<li class="nav-item">
    <a class="nav-link" href="../404.php">
        <i class="fas fa-comment    "></i>
        <span>MAKE COMPLAIN</span></a>
</li>
<!-- SALES -->
<li class="nav-item">
    <a class="nav-link" href="../404.php">
        <i class="fas fa-list    "></i>
        <span>MY SALES</span></a>
</li>
<!-- view store -->
<li class="nav-item">
    <a class="nav-link" href="./store.php">
        <i class="fas fa-building    "></i>
        <span>VIEW STORE</span></a>
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
<!-- SALES PRODUCT -->
<li class="nav-item">
    <a class="nav-link" href="../sales/index.php">
        <i class="fas fa-money-bill    "></i>
        <span>SALE PRODUCT</span></a>
</li>
<!-- PROFILE -->
<li class="nav-item">
    <a class="nav-link" href="./my_profile.php">
        <i class="fas fa-user-shield    "></i>
        <span>PROFILE</span></a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>