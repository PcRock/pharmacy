<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="./img/logo.jpg" type="image/x-icon">
    <title>iCare Pharmacy</title>

    <!-- Custom fonts for this template-->
    <link href="./vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block ">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h1 style="font-weight: 900; font-size: 1800%;"><i class="fas fa-user-shield text-primary   "></i></h1>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Mobile Number Authentication <?php echo "<p class='text-primary'>$_SESSION[username]</p>"; ?></h1>
                                        <p class="mb-4">Please Provide us with your valid Registered phone number you used for your Account Registration!</p>
                                    </div>
                                    <!-- ERROR MESSAGE -->
                                    <?php 
                                        if(isset($_GET['request'])){

                                            if($_GET['request'] == 'User NOT Found'){

                                                echo "<span class='text-danger text-center'>User NOT Found</span>";
                                            }
                                        }
                                    ?>
                                   
                                    <form class="user" method='POST' action="./vendor/Services/user_ops.php">
                                        <div class="form-group">
                                            <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                >
                                        <div class="form-group">
                                            <input type="number" name="phone_no" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter your Mobile Number">
                                        </div>
                                        <button type="submit" name="mobile_number_check" class="btn btn-primary btn-user btn-block">Proceed</button>
                                    </form>
                                        
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="index.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>