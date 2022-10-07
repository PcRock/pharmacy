
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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">

</head>

<body id="" style="background-color: gray;">

    <div class="container">
        <!-- Form Container -->
        <div class="row py-3">
            <div class="col-12 py-5">
                <div class="card p-5 ">
                    <div class="card-body">
                        <div class="row">
                            <!-- welcome sms -->
                            <div class="col-lg-7 col-sm-12">
                                <img src="./img/store/drugs.jpg" alt="" class="img-fluid" srcset="">
                                <div class="d-flex justify-content-center">
                                <p class="write-up">Our job is Improving the quality of life. Not just Delaying Death</p>
                                </div>
                            </div>
                             <!-- login form -->
                            <div class="col-lg-5 col-sm-12" >
                                <p class="display-4 text-center text-warning">Welcome Back <i class="fas fa-smile    "></i></p>
                                <?php
                                    if(isset($_GET['form']) && isset($_GET['status'])){
                                        $message = $_GET['form'];
                                        $status = isset($_GET['status']);
                                        if($status == false){
                                            echo "<p class='text-success text-center'><strong>$message</strong></p>";
                                        }
                                        elseif($message == true){
                                            echo "<p class='text-danger text-center'><strong>$message</strong></p>";
                                        }
                                        
                                    }
                                    
                                ?>
                                <form action="./vendor/Services/user_ops.php" method="post" autocomplete="off">
                                    <?php 
                                        if(isset($_GET['attack'])){
                                            
                                            $message = $_GET['attack'];

                                            if($message == 'send_success'){ ?>

                                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        <span class="sr-only">Close</span>
                                                    </button>
                                                    <strong><P class="text-justify">
                                                        Oops!! Sorry for security reason this Account have been Temporarily Disable.
                                                        Please Report to your employer to Reset your Account. Thank you 
                                                    </P></strong><i class="fa fa-quote-left" aria-hidden="true">PcRock PcFire Technology</i>

                                                </div>
                                            <?php }else{?>
                                                <div class="from-group ">
                                                    <input type="text" name="username" id="" class="form-control mb-2"  placeholder="Enter your username">
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" name="pwd" id="" class="form-control mb-1" placeholder="Enter your Password">
                                                </div>
                                                <div class="form-group">
                                                    <button type="submit" name="login" class="form-control  btn btn-warning text-light">Get me in!!</button>
                                                </div>
                                                <p class="text-center">
                                                    <a href="./forgot-password.php" class="text-center">Forget Password</a>
                                                </p>
                                            <?php }
                                        }       
                                        else{ ?>
                                            <div class="from-group">
                                                <input type="text" name="username" id="" class="form-control mb-2"  placeholder="Enter your username">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="pwd" id="" class="form-control " placeholder="Enter your Password">
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" name="login" class="form-control mt-3 btn btn-warning text-light">Get me in!!</button>
                                            </div>
                                            <p class="text-center">
                                                <a href="./forgot-password.php" class="text-center nav-link">Forget Password</a>
                                            </p>
                                        <?php }
                                    ?>
                                    
                                 </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Conainer -->
    </div>
  </body>
</html>
