
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
<!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <h5 class="text-success"> <i class="fas fa-smile    "></i> Greeting From iCare Pharmacy to <?php echo $_SESSION['username']; ?></h5>
    <ul class="navbar-nav ml-auto">
        <!-- MODEL TREATMENT SALES -->
        <li class="nav-item dropdown no-arrow">
            
            <a class="nav-link dropdown-toggle"  data-toggle="modal" data-target="#treatment" href="#" id="userDropdown" role="button">
                <i class="fas fa-stethoscope text-primary   "></i>
            </a>
            <!-- Modal -->
            <div class="modal fade" id="treatment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Treatment Rendered Form</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                            <form action="../vendor/Services/item_ops.php" method="post">
                                <input type="hidden" name="drug_id" value="1632de708214fe">
                                <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>">
                                <div class="form-group">
                                  <label for="">SELECT TREATMENT DONE</label>
                                  <select class="form-control" name="treatment" id="treatment">
                                    <option value="Blood Glucos Test">Blood Glucos Test</option>
                                    <option value="Illness">Illness</option>
                                    <option value="Malaria Parasite">Malaria Parasite Testing</option>
                                    <option value="Pyhoid">Pyhoid Testing</option>
                                    <option value="Wound Dressing">Wound Dressing</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="">Cost of Treatment</label>
                                  <input type="number"
                                    class="form-control" placeholder="Enter Cost of Treatment" name="cost" id="cost" aria-describedby="helpId" placeholder="">
                                </div>
                                <button type="submit" name="save_treatment" class="btn btn-primary">Save Treatment</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['username']; ?></span>
                <img class="img-profile rounded-circle"
                    src="../img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="?logout" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>