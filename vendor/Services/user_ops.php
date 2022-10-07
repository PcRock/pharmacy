<?php
   
require __DIR__."/../Include/users_class.php";
require __DIR__."/../Include/config.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    /* INSTANCIATE DB */
    $config = new Config_db();
    $db = $config->connect();

    $user = new Users($db);

    if (isset($_POST['login'])) {
       
        $json_data = json_decode($user->login(
            $_POST['username'],
            $_POST['pwd']
        ));

        if($json_data != null ){

            if($json_data->status == false){
                
                switch ($json_data->message) {
                    case 'Admin':
                        header("Location: ../../admin/index.php");                
                    break;
                    case 'Pharm':
                        header("Location: ../../pharmacy/index.php");                     
                        break;
                    case 'Salesman':
                        header("Location: ../../sales/index.php");                     
                        break;
                    default:
                        
                        break;
                }
            }
            elseif($json_data->status == true){
                header("Location: ../../index.php?form=".$json_data->message."&status=".$json_data->status);
            }
        }
 
     } 
     else if(isset($_POST['reg'])) {
         
        $json_data = json_decode($user->register(
            $_POST['username'],
            $_POST['name'],$_POST['email'],
            $_POST['phone_no'],$_POST['dob'],
            $_POST['address'],$_POST['role'],
            $_POST['pwd'],$_POST['confirm_pwd'],
           
        ));
        if($json_data != null){

            if($json_data->status == false){
                header("Location: ../../admin/new_staff.php?form=".$json_data->message."&status=".$json_data->status);
            }
            elseif($json_data->status == true){
                header("Location: ../../admin/new_staff.php?form=".$json_data->message."&status=".$json_data->status);
            }
        }
        else{
            echo "null";
        }
         
     }
     elseif(isset($_POST['send_username'])){
         
         /* $user->createNewPwd($_POST['username']); */
         $user->sendEmail('pcrockpcfire@gmail.com','');
     }
     elseif(isset($_POST['reset_pwd'])){
         
         /* $user->passwordReset(
             $_POST['email'],$_POST['selector'],$_POST['validator'],
             $_POST['pwd'],$_POST['confirm_pwd']
         ); */
         $message = "";
         $user->sendEmail('yusufmalum@gmail.com',$message);
     }
     elseif(isset($_POST['save_profile'])){
         $user->UpdateUserProfile($_POST['username'],$_POST['name'],$_POST['email'],
         $_POST['mobile_number'],$_POST['address']);
     }
     elseif(isset($_POST['save_img_profile'])){
 
         /* echo $_FILES['file']['name']."<br>";
         echo $_FILES['file']['tmp_name']."<br>";
         echo $_FILES['file']['size']."<br>";
         echo $_FILES['file']['type']."<br>";
         echo $_FILES['file']['error']."<br>";  */
         $user->UpdateProfileImg($_POST['username'],$_FILES['file']['name'],$_FILES['file']['tmp_name'],
         $_FILES['file']['size'],$_FILES['file']['type'],$_FILES['file']['error']
     );  
     }
     elseif(isset($_POST['logout'])){
        $json_data = json_decode($user->logOut($_POST['username']));

        if($json_data != null){

            if($json_data->status == false){
                header("Location: ../../index.php");
                //echo $json_data->message;
            }
            elseif($json_data == true){
                echo $json_data->message;
            }
        }
     }
     elseif (isset($_POST['reset_password'])) {
        $user->resetPassword($_POST['username']);
     }
     elseif (isset($_POST['mobile_number_check'])) {
        $user->checkMobileNumber($_POST['username'],$_POST['phone_no']);

     }
     elseif (isset($_POST['reset'])) {
        $json_data = json_decode($user->updatePassword($_POST['username'], $_POST['password'], $_POST['confirm_password']));

        if($json_data != null){
            if($json_data->status == false){
                header("Location: ../../forgot-password_password.php?request=$json_data->message");
            }
            else{

            }
        }

     }
     
}
elseif($_SERVER['REQUEST_METHOD'] == 'GET'){

}
   
    

    
    
    
    
?>