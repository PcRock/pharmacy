
<?php

session_start();

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;

class Users {
    private $username;
    private $name;
    private $email;
    private $phone_no;
    private $dob;
    private $address;
    private $role;
    private $pwd;
    private $confirm_pwd;
    public $response;
    public $conn;
    public $con = null;

    public function __construct($db)
    {
        $this->con = $db;
        $this->conn = $this->con;
        
    }

    /* user reg and validations */

    public function register($username,$name,$email,$phone_no,$dob,$address,$role,$pwd,$confirm_pwd){
        
        $username = ucfirst(htmlspecialchars(strip_tags($username)));
        $name = ucwords(htmlspecialchars(strip_tags($name)));
        $email = htmlspecialchars(strip_tags($email));
        $phone_no = htmlspecialchars(strip_tags($phone_no) );
        $dob = htmlspecialchars(strip_tags($dob) );
        $address = htmlspecialchars(strip_tags($address) );
        $role = htmlspecialchars(strip_tags($role) );
        $pwd = htmlspecialchars(strip_tags($pwd) );
        $confirm_pwd = htmlspecialchars(strip_tags($confirm_pwd) );
        
        if(empty($name)||empty($email)||empty($dob)||empty($phone_no)||empty($username)||empty($address)||empty($pwd)||empty($confirm_pwd)||empty($role)){
            
            $this->response['status'] = true;
            $this->response['message'] = "Oops! Form input Fields Empty";
        }
        else{
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $this->response['status'] = true;
                $this->response['message'] = "Invalid Email Address";
                
            }
            else{
                $sql_check = "SELECT * FROM user_reg WHERE phone_no = :phone_no || email = :email || username = :username ";
                $stmt = $this->conn->prepare($sql_check);
                $stmt->execute([
                    'phone_no' => $phone_no,
                    'email' => $email,
                    'username' => $username
                ]);
                if($stmt->rowCount() > 0){
                    
                    $this->response['status'] = true;
                    $this->response['message'] = "Oops! Mobile Number OR Email OR Username already in use";
                    
                }
                else{
                    if ($pwd !== $confirm_pwd) {
                        
                        $this->response['status'] = true;
                        $this->response['message'] = "Oops! Password NOT Matched please re-type";
                        

                    } else {
                        $hash_password = password_hash($pwd, PASSWORD_DEFAULT);

                        $this->username = $username;
                        $this->name = $name;
                        $this->email = $email;
                        $this->phone_no = $phone_no;
                        $this->dob = $dob;
                        $this->address = $address;
                        $this->role = $role;
                        $this->pwd = $hash_password;
                        
                        $insert = "INSERT INTO user_reg (username,fullname,email,phone_no,date_of_birth,user_address,role,pwd,account_status)
                        VALUES(:username,:name,:email,:phone_no,
                        :dob,:address,:role,:pwd,:account_status)";

                        $stmt = $this->conn->prepare($insert);
                            
                        if($stmt->execute(
                            [
                                'username' => $this->username,
                                'name' => $this->name,
                                'email' => $this->email,
                                'phone_no' => $this->phone_no,
                                'dob' => $this->dob,
                                'address' => $this->address,
                                'role' => $this->role,
                                'pwd' => $this->pwd,
                                'account_status' => 'free'
                            ]
                        ))
                        {

                            $this->response['status'] = false;
                            $this->response['message'] = "Successfull Registered";
                            
                        }
                        else{
                            
                            $this->response['status'] = true;
                            $this->response['message'] = "Registation Failed".$stmt->getMessage();
                            
                        }
                    }
                    
                    }
                }
            }
            return json_encode($this->response);
    }
    /* Forget password */
    public function createNewPwd($username){

        $message = "Unauthorized Access Detected on Your Account";
        if (empty($username)) {
            echo "Empty field";
        } 
        else {
         
            /* crytographic securing token */
        $selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        
        $url = '../forgot-password.php?selector='.$selector.'validator='.bin2hex($token);

        $expires = date('U') + 1800;

        $username = mysqli_real_escape_string($this->conn,$username);

        $sql = "DELETE FROM forget_pwd WHERE username = '$username'";

        if (mysqli_query($this->conn,$sql)) {
            
            $hashToken = password_hash($token, PASSWORD_DEFAULT);
            $useremail = "";

            $sql_insert = "INSERT INTO forget_pwd (selector, validator, pwd_exp,username) 
            VALUES(:selector,:hashToken,:expires,:username)";
            $stmt = $this->conn->prepare($sql_insert);

            if($stmt->execute([
                'selector' => $selector,
                'hashToken' => $hashToken,
                'expires' => $expires,
                'username' => $username
            ])){
                $sql_result = "SELECT * FROM user_reg WHERE username = :username";
                $stmt = $this->conn->prepare($sql_result);
                if($stmt->execute(['username' => $username])){

                    if($stmt->rowCount() > 0){
                        
                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($rows);
                            $this->sendEmail($email, $message);
                        
                        }
                        
                }
                else{
                   
                    $this->response['status'] = false;
                    $this->response['message'] = "No result found ".$stmt->getMessage();
                    exit();
                }

                }
                else{
                    /* Error message */
                    
                    $this->response['status'] = false;
                    $this->response['message'] = "error in sql query".$stmt->getMessage();
                    exit();
                }
                
            }
            else{
                /* error insert query */
                
                $this->response['status'] = false;
                $this->response['message'] = "error inserj query ".$stmt->getMessage();
                exit();
            }
        } else {
            /* Query Error  */
            
            $this->response['status'] = false;
            $this->response['message'] = "error in query ".$stmt->getMessage();
            exit();
        }

        }
        
        return json_encode($this->response);
    }
    /* Password reset script  */
    public function passwordReset($selector,$validator,$pwd,$confrm_pwd){
        
        $pwd = htmlspecialchars(strip_tags($pwd));
        $confirm_pwd = htmlspecialchars(strip_tags($confrm_pwd));

        if(empty($validator)||empty($selector)||empty($pwd)||empty($confirm_pwd)){
            /* Error message  */
            $this->response['status'] = false;
            $this->response['message'] = "Validator Empty";
            exit();
        }
        else{
            
            $token = hex2bin($validator);
            $sql_check = "SELECT * FROM forget_pwd WHERE selector = '$selector'";
            $stmt = $this->conn->prepare($sql_check);
            if ($stmt->execute([
                'selector' => $selector
            ])) {
                
                if ($stmt->rowCount() > 0) {
                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        if(password_verify($token,$validator)){

                            if ($pwd_exp >= date('U')) {
                                
                                /* Update password */
                                $hash_pwd = password_hash($pwd, PASSWORD_DEFAULT);
                                $update_sql = "UPDATE TABLE user_reg SET pwd = :hash_pwd WHERE username = :username";
                                $stmt = $this->conn->prepare($update_sql);
                                if($stmt->execute([
                                    'hash_pwd' => $hash_pwd,
                                    'username' => $username
                                ])){
                                   
                                    $this->response['status'] = false;
                                    $this->response['message'] = "Password Updated";
                                    exit();
                                }
                                else{
                                   
                                    $this->response['status'] = false;
                                    $this->response['message'] = "Password Updated failed";
                                    exit();
                                }
                            } else {
                                
                                $this->response['status'] = false;
                                $this->response['message'] = "Token Expired";
                                exit();
                            }
                            
                        }
                        else {
                           
                            $this->response['status'] = false;
                            $this->response['message'] = "Invalid token";
                            exit();
                        }
                    }
                }
                else{

                }
                
            } else {
                
            }
            
        }
        return json_encode($this->response);

    }
    /* loggin script */
    public function login($username, $pwd){

        $username = htmlspecialchars(strip_tags($username) );
        $pwd_i = htmlspecialchars(strip_tags($pwd) );

        if (!empty($username) || !empty($pwd_i)) {
            
            $select = "SELECT * FROM user_reg WHERE username = :username && account_status != :freeze";
            $stmt = $this->conn->prepare($select);
            if($stmt->execute([
                'username' => $username,
                'freeze' => 'freeze'
            ])){

                if($stmt->rowCount() > 0){
                    
                    if ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($rows);
                        if (password_verify($pwd_i,$pwd)) {

                            $_SESSION['username'] = $username;
                            $_SESSION['email'] = $email;
                            $_SESSION['role'] = $role;
                            
                            $loggin = date("h:i:s");
                            $date = date("d/m/Y");

                            $sql = "INSERT INTO attendance_tbl(username,loggin_time,date_curr)
                            VALUES(:username,:loggin,:date)";
                            $stmt = $this->conn->prepare($sql);
                            if($stmt->execute([
                                'username' => $username,
                                'loggin' => $loggin,
                                'date' => $date
                            ])){

                                $this->response['status'] = false;
                                $this->response['message'] = $role; 
                                
                            }
                            else{
                                
                                $this->response['status'] = true;
                                $this->response['message'] = "failed Attendance";                       
                                exit();
                            }
                            
                         } 
                         else {
                             
                            $select_loggin = "SELECT * FROM loggin_info WHERE username = :username";
                            $stmt =$this->conn->prepare($select_loggin);

                            if($stmt->execute(['username'=>$username])){

                                if ($stmt->rowCount() > 0) {
                                    
                                    if($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        
                                        $new_att = $data_rsl['attempt'] + 1;
                                        $update_sql = "UPDATE loggin_info SET attempt = :new_att  WHERE username = :username";
                                        $stmt = $this->conn->prepare($update_sql);

                                    if ($stmt->execute([
                                        'new_att' => $new_att,
                                        'username' => $username
                                    ])) {

                                        $select_loggin = "SELECT * FROM loggin_info WHERE username = :username";
                                        $stmt = $this->conn->prepare($select_loggin);
                                        
                                        if ($stmt->execute(['username' => $username])) {
                                            
                                            if($stmt->rowCount() > 0){

                                                if($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                    extract($data_rsl);
                                                    if($attempt > 3){
                                                        
                                                        /* freeze account*/
                                                        $update_account = "UPDATE user_reg SET account_status = :account_status WHERE username = :username";
                                                        $stmt = $this->conn->prepare($update_account);

                                                        if($stmt->execute(['account_status' => 'freeze', 'username' => $username])){
                                                            $sql_del = "DELETE FROM loggin_info WHERE username = '$username'";

                                                            $stmt = $this->conn->prepare($sql_del);
                                                            if($stmt->execute()){
                                                                $this->sendEmail();
                                                            }
                                                            
                                                        }
                                                        else{
                                                            
                                                            $this->response['status'] = true;
                                                            $this->response['message'] = "update failed";
                                                            
                                                        }
                                                        /* Delete user form loggin error */
                                                                          
                                                    }
                                                    else{
                                                        
                                                        $this->response['status'] = true;
                                                        $this->response['message'] = "Incorrect Password";
                                                        
                                                    }
    
                                                }
                                                else{
                                                    $this->response['status'] = true;
                                                    $this->response['message'] = "Select Loggin Error";
                                                    
                                                }
                                                
                                            }
                                        } else {
                                            //echo "Select Update loggin info query Error ".mysqli_error($this->conn); 
                                            
                                            $this->response['status'] = true;
                                            $this->response['message'] = "Select Update loggin info query Error";
                                            
                                        }
                                        
                                        
                                    } else {
                                        //echo "Update loggin info query Error ".mysqli_error($this->conn); 
                                        $this->response['status'] = true;
                                        $this->response['message'] = "Update loggin info query Error";
                                        
                                    }
                                    }
                                    else{
                                        
                                        $this->response['status'] = true;
                                        $this->response['message'] = "Error";
                                        
                                    }
                                    
                                } 
                                else {
                                    /* Insert into table */
                                    $attempt = 1;
                                    $insert_sql = "INSERT INTO loggin_info (attempt,username,email) 
                                    VALUES(:attempt, :username,:email)";
                                    $stmt = $this->conn->prepare($insert_sql);

                                    if($stmt->execute([
                                        'attempt' => $attempt,
                                        'username' => $username,
                                        'email' => $email
                                    ])){
                                        
                                        $this->response['status'] = false;
                                        $this->response['message'] = "Incorrect password";
                                        
                                    }
                                    else{
                                        //echo "Insert loggin info query Error ".mysqli_error($this->conn);
                                       
                                    }
                                }
                                
                            }
                            else {
                                
                                $this->response['status'] = true;
                                $this->response['message'] = "Select loggin info query Error";
                                
                            }
                           
                         }
                    }
                    else{
                        
                    }
                }
                else{
                    
                    $this->response['status'] = true;
                    $this->response['message'] = "No Record Found";
                    
                }
            }else{
                $this->response['status'] = true;
                $this->response['message'] = "Select Query Failed";
            }
        } else {
          
            $this->response['status'] = true;
            $this->response['message'] = "Form Empty";
            
        }
        
        return json_encode($this->response);
    }
    /* Display profile image */
    public function displayProfileImage($username){

        $sql= "SELECT * FROM user_reg WHERE username = '$username'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);

        if($stmt->rowCount() > 0){
            if ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                
                $this->response['status'] = false;
                $this->response['message'] = $data_rsl['profile_img'];
            }
        }
        else{

        }

        return json_encode($this->response);
    }

    /* display logout profile image */
    public function displayImageLogout($username){

        $sql= "SELECT * FROM user_reg WHERE username = '$username'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['username' => $username]);

        if($stmt->rowCount() > 0){
            if ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                
                $this->response['status'] = false;
                $this->response['message'] = $data_rsl['profile_img'];
            }
        }
        else{

        }

        return json_encode($this->response);

    }

    /* send email script for incorrect password for login */
    public function sendEmail(){
                                         
        header("Location: ../../index.php?attack=send_success");
        
    }

    //Select all users in Store
    public function getAllUsers(){
        $users['data'] = array();
        $sql_user = "SELECT * FROM user_reg ";
        $stmt = $this->conn->prepare($sql_user);
        $stmt->execute($stmt);

        if ($stmt->rowCount() > 0) {
            
            while ($user_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($user_rsl);
                echo "
                <div class='staff-info p-0 text-primary'>
                <p class='py-0 my-0'>$user_rsl[fullname]</p>
                <p class='py-0 my-0'>$user_rsl[fullname]</p>
                <p class='py-0 my-0'><i class='fas fa-sign-in-alt    '></i> <i class='fas fa-clock    '></i>: </p>
                <p class='py-0 my-0'><i class='fas fa-sign-out-alt    '></i> <i class='fas fa-clock    '></i>: </p>
              </div>
                ";
                $data = array(
                    'fullname' => $fullname
                );
                array_push($users['data'], $data);
            }
            return json_encode($users['data']);
        } else {
            echo "<div class='alert alert-danger text-center' role='alert'>
                <strong>Error No User Found ".mysqli_error($this->conn)."</strong> 
                </div>";
            $this->response['status'] = true;
            $this->response['message'] = "Error No User Found ";

            return json_encode($this->response);
        }
        
    }
    /* logout script */
    public function logOut($username){

        $date = date("d/m/Y");
        $sql = "SELECT * FROM attendance_tbl WHERE username = :username AND date_curr = :date";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(
            [
                'username' => $username,
                'date' => $date
            ]
        );
        if($stmt->rowCount() > 0 ){

            $loggout = date("h:i:s");
            $sql_update = "UPDATE attendance_tbl SET loggout_time = :loggout WHERE username = :username";
            $stmt = $this->conn->prepare($sql_update);

            if($stmt->execute(['loggout' => $loggout, 'username' => $username])){
                
                require_once __DIR__."/./Item_class.php";
                $item = new Items($this->conn);
                $json_data = json_decode($item->financialReport($username));

                if($json_data != null){
                    $sales = 0;
                    $transfer = 0;
                    $expenses = 0;
                    
                    $sales = $json_data->total_sales;
                    $transfer = $json_data->transfer;
                    $expenses = $json_data->total_expenses;
                   
                    require __DIR__."/./PHPMailer/Exception.php";
                    require __DIR__."/./PHPMailer/OAuth.php";
                    require __DIR__."/./PHPMailer/PHPMailer.php";
                    require __DIR__."/./PHPMailer/SMTP.php";

                    /* $mail = new PHPMailer(true);
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'pcrockpcfire@gmail.com';
                    $mail->Password = 'ProgrammeR@&7777';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom('pcrockpcfire@gmail.com','PcRock PcFire Technology');
                    $mail->addAddress('yusufmalum@gmail.com');
                    $mail->isHTML(true);
                    $mail->Subject = "Finanal Report by ".$username;
                    
                    $bodyContent = "<p>This is a brief Summary of Transaction by $username</p>";
                    
                    $grand_income = $sales + $transfer;
                    $total = $grand_income - $expenses;
                    $bodyContent .= "<table>
                        <tr>
                            <th>Total Sales</th>
                            <th>Total Transfer</th>
                            <th>Total Expensenses</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td>$sales</td>
                                <td>$transfer</td>
                                <td>$expenses</td>
                            </tr>
                        </tbody>
                        <tfooter>
                            <tr colspan=3>
                                <td>
                                    Grand Income = $total
                                </td>
                            </tr>
                        </tfooter>
                    </table>";
                    $mail->Body = $bodyContent;
                    if(!$mail->send()){
                        $this->response['status'] = true;
                        $this->response['message'] = "Failed Sending Mail ".$mail->ErrorInfo;
                    }
                    else{
                        session_destroy();
                        $this->response['status'] = false;
                    } */
                    $recipent = "yusufmalum@gmail.com";
                    $subject = "Finanal Report by ".$username;
                    $bodyContent = "<p>This is a brief Summary of Transaction by $username</p>";
                    
                    $grand_income = $sales + $transfer;
                    $total = $grand_income - $expenses;
                    $bodyContent .= "<table>
                        <tr>
                            <th>Total Sales</th>
                            <th>Total Transfer</th>
                            <th>Total Expensenses</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td>$sales</td>
                                <td>$transfer</td>
                                <td>$expenses</td>
                            </tr>
                        </tbody>
                        <tfooter>
                            <tr colspan=3>
                                <td>
                                    Grand Income = $total
                                </td>
                            </tr>
                        </tfooter>
                    </table>";
                    $header = "From: PcRock PcFire Technology";
                    if(!mail($recipent,$subject,$bodyContent,$header)){
                        
                        $this->response['status'] = true;
                        $this->response['message'] = "Failed Sending Mail";
                    }
                    else{
                        session_destroy();
                        $this->response['status'] = false;
                        $this->response['message'] = "Mail Sent";
                    }
                    
                } 
                else{
                    $recipent = "yusufmpero@outlook.com";
                    $subject = "Finanal Report by ".$username;
                    $bodyContent = "<p>This is a brief Summary of Transaction by $username</p>";
                    
                    $grand_income = $sales + $transfer;
                    $total = $grand_income - $expenses;
                    $bodyContent .= "<table>
                        <tr>
                            <th>Total Sales</th>
                            <th>Total Transfer</th>
                            <th>Total Expensenses</th>
                        </tr>
                        <tbody>
                            <tr>
                                <td>$sales</td>
                                <td>$transfer</td>
                                <td>$expenses</td>
                            </tr>
                        </tbody>
                        <tfooter>
                            <tr colspan=3>
                                <td>
                                    Grand Income = $total
                                </td>
                            </tr>
                        </tfooter>
                    </table>";
                    $header = "From: PcRock PcFire Technology";
                    if(!mail($recipent,$subject,$bodyContent,$header)){
                        
                        $this->response['status'] = true;
                        $this->response['message'] = "Failed Sending Mail";
                    }
                    else{
                        session_destroy();
                        $this->response['status'] = false;
                        $this->response['message'] = "Mail Sent";
                    }
                }
                //$this->response['message'] = "Logged Out";
            }
            else{
                
                $this->response['status'] = true;
                $this->response['message'] = "Failed";
            }
        }
        else{
            $this->response['status'] = true;
            $this->response['message'] = "not found";
        }

        return json_encode($this->response);
        
    }
    /* update user profile information  */
    public function UpdateUserProfile($username,$name,$email,$phone_num,$address){

        if(!empty($username) || !empty($name) || !empty($email) || !empty($phone_num) || !empty($address)){

            $username = htmlspecialchars(strip_tags($username));
            $name = htmlspecialchars(strip_tags($name));
            $email = htmlspecialchars(strip_tags($email));
            $phone_num = htmlspecialchars(strip_tags($phone_num));
            $address = htmlspecialchars(strip_tags($address));

            if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
                
                $this->response['status'] = true;
                $this->response['message'] = "Incoorect Email Address";
            } else {
                $sql_update = "UPDATE user_reg SET fullname= :name, user_address = :address,
                phone_no = :phone_num, email = :email WHERE username = :username"; 
                $stmt = $this->conn->prepare($sql_update);

                if($stmt->execute([
                    'name' => $name,
                    'address' => $address,
                    'phone_num' => $phone_num,
                    'email' => $email,
                    'username' => $username

                ])){
                    
                
                $this->response['status'] = false;
                $this->response['message'] = "Successfully";

                }
                else {
                
                    $this->response['status'] = true;
                    $this->response['message'] = "Update_failed";

                }
            }
            
            
        }
        else{
            
            $this->response['status'] = true;
            $this->response['message'] = "Form Empty";
        }

        return json_encode($this->response);
    }
    /* Update User profile Image */
    public function UpdateProfileImg($username,$file_name,$file_tmp,$file_size,$file_type,$file_error){

        $file_name_new = htmlspecialchars(strip_tags($file_name));
        $file_size_new = htmlspecialchars(strip_tags($file_size));
        $file_type_new = htmlspecialchars(strip_tags($file_type));
        $folder = "../../user/Profile_Images/";

        if(empty($file_name_new)||empty($file_size_new)||empty($file_type_new)){
           
            $this->response['status'] = true;
            $this->response['message'] = "Profile Image Empty";
        }
        else{

            $allowed_ext = ["jpg","jpeg","png"];
            $img_ext = end(explode(".",$file_name_new));
            if(in_array($img_ext,$allowed_ext)){
                $file_new_name = str_replace(" ","_",strtolower($file_name_new));

                $file_new_size = $file_size_new/1024;

                if($file_error){
                    
                    $this->response['status'] = true;
                    $this->response['message'] = "Profile image Error";
                }
                else{
                    if(move_uploaded_file($file_tmp,$folder.basename($file_new_name))){

                        $sql = "UPDATE user_reg SET profile_img= '$file_new_name' WHERE username = '$username'";
                        $stmt = $this->conn->prepare($sql);

                        if($stmt->execute(['file_new_name'=> $file_new_name,'username' => $username])){
                            
                            $this->response['status'] = false;
                            $this->response['message'] = "Profile_image_saved";
                        }
                        else{
                            
                            $this->response['status'] = true;
                            $this->response['message'] = "Profile_image_saved_not_db";
                        }
                        
                    }
                    else{
                        
                        $this->response['status'] = true;
                        $this->response['message'] = "Profile_image_not";
                    }
                }
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Profile_image_Extension";
            }
        }
        return json_encode($this->response);
    }
    /* view users employed in store */
    public function viewAllUsers(){
        $sn = 0;
        $users_info['data'] = array();
        $select_sql = "SELECT * FROM user_reg";

        $stmt = $this->conn->prepare($select_sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            
            while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($data_rsl);
                $sn++;
                $data = array(
                    'username' => $username,
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone_no' => $phone_no,
                    'address' => $address,
                    'account_status' => $update_account
                );
                array_push($users_info['data'], $data);
                /* echo "
                
                    <tr>
                      <td scope='row'>$sn</td>
                      <td>$data_rsl[username]</td>
                      <td>$data_rsl[fullname]</td>
                      <td>$data_rsl[email]</td>
                      <td>$data_rsl[phone_no]</td>
                      <td>$data_rsl[user_address]</td>
                      <td class='text-warming'>$data_rsl[account_status]</td>
                      <td>
                        <a href='../../view_staff.php?view=$data_rsl[username]' id='view'><i class='fas fa-clipboard text-primary'    ></i></a>
                        <a href='../../view_staff.php?del=$data_rsl[username]'><i class='fas fa-trash text-danger '  ></i></a>
                        <a href='../../view_staff.php?unfreeze=$data_rsl[username]'><i class='fas fa-running text-success'   ></i></a>
                      </td>
                    </tr>
                  
                "; */
            }
            return json_encode($users_info['data']);
        } else {
            
            $this->response['status'] = true;
            $this->response['message'] = "No Staff";
           
            return json_encode($this->response);
        }
        
        
    }
    /* view users employed in store */
    public function viewAttendance(){
        $sn = 0;
        $staff['data'] = array();
        $select_sql = "SELECT * FROM `attendance_tbl` ";

        $stmt = $this->conn->prepare($select_sql);

        if ($stmt->rowCount() > 0) {
            
            while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($data_rsl);
                $sn++;
                $data = array(
                    'username' => $username,
                    'date_curr' => $date_curr,
                    'loggin_time' => $loggin_time,
                    'logout_time' => $loggout_time
                );
                array_push($staff['data'],$data);
                /* echo "
                
                    <tr>
                      <td scope='row'>$sn</td>
                      <td>$data_rsl[username]</td>
                      <td>$data_rsl[date_curr]</td>
                      <td>$data_rsl[loggin_time]</td>
                      <td>$data_rsl[loggout_time]</td>
                      <td>
                        <a href='../../staff_attendance.php?view_att=$data_rsl[username]' id='view'><i class='fas fa-clipboard text-primary'    ></i></a>
                        <a href='../../staff_attendance.php?del_att=$data_rsl[username]'><i class='fas fa-trash text-danger '  ></i></a>
                      </td>
                    </tr>
                  
                "; */
            }
            return json_encode($staff['data']);
        } else {
            //header("Location: ../../admin_activities/staff_attendance.php");
            exit;
        }
        
        
    }
    /* View a specific user select from list of users in list */
    public function viewUser($username){

        $select_sql = "SELECT * FROM user_reg WHERE username = :username";
        $users['data'] = array();

        $stmt = $this->conn->prepare($select_sql);
        $stmt->execute(['username' => $username]);
        if ($stmt->rowCount() > 0) {
            
            while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($data_rsl);
                $data = array(
                    'username' => $username,
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone_on' => $phone_no,
                    'user_address' => $user_address
                );
               /*  echo "
                
                    <ul id='profile_data'>
                      
                      <li id='profile_data_items'>Username: $data_rsl[username]</li>
                      <li id='profile_data_items'>Name: $data_rsl[fullname]</li>
                      <li id='profile_data_items'>Email: $data_rsl[email]</li>
                      <li id='profile_data_items'>Phone Num:$data_rsl[phone_no]</li>
                      <li id='profile_data_items'>Address: $data_rsl[user_address]</li>
                    
                    </ul>
                      <hr>
                        
                        <a href='../../view_staff.php?del=$data_rsl[username]' class='btn '><i class='fas fa-trash text-danger '  ></i></a>
                "; */
                array_push($users['data'], $data);
            }
            return json_encode($users['data']);

        } else {
            
            $this->response['status'] = true;
            $this->response['message'] = "No Staff";
            exit;
        }
        return json_encode($this->response);
    }
    /* Delete a specific user selected from list of users in list */
    public function delUser($username){
        $sql = "DELETE FROM user_reg WHERE username = :username";
        $stmt = $this->conn->prepare($sql);

        if($stmt->execute(['username' => $username])){
           
           $this->response['status'] = false;
           $this->response['message'] = "Staff have been Deleted...";
           exit;
        }
        else{
            
            $this->response['status'] = true;
            $this->response['message'] = "User Not Deleted";
            exit;
        }
        return json_encode($this->response);
    }
    /* Delete a specific user selected from list of users in list attendence */
    public function delUserAttendance($username){
        $sql = "DELETE FROM attendance_tbl WHERE username = :username";
        $stmt = $this->conn->prepare($sql);

        if($stmt->execute(['username' => $username])){
            
            $this->response['status'] = false;
            $this->response['message'] = "User Attedance Deleted";
            exit;
        }
        else{
            $this->response['status'] = true;
            $this->response['message'] = "User Attendance NOT Deleted";
            exit;
        }
        return json_encode($this->response);
    }
    /* Search for a user in the store */
    public function searchUser($key){
        $sn = 0;
        $sql = "SELECT * FROM user_reg WHERE username = :key || fullname = :key";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['key' => $key]);
        if($stmt->rowCount() > 0){

            while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($data_rsl);
                $sn++;
                $data = array(
                    'username' => $username,
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone_on' => $phone_no,
                    'user_address' => $user_address
                );
                /* echo "
                    <tr>
                      <td scope='row'>$sn</td>
                      <td>$data_rsl[username]</td>
                      <td>$data_rsl[fullname]</td>
                      <td>$data_rsl[email]</td>
                      <td>$data_rsl[phone_no]</td>
                      <td>$data_rsl[user_address]</td>
                      <td>
                        <a href='../../view_staff.php?view=$data_rsl[username]'><i class='fas fa-clipboard text-primary'    ></i></a>
                        <a href='../../view_staff.php?del=$data_rsl[username]'><i class='fas fa-trash text-danger '  ></i></a>
                      </td>
                    </tr>
                "; */
            }
            return json_encode($data);
        }
        else{
            
            $this->response['status'] = true;
            $this->response['message'] = "Oops!! Sorry Such User was found";

            return json_encode($this->response);
        }
    }
    /* Get user profile information */
    public function myProfileInfo($username){
        $user['info'] = array();
        $select_sql = "SELECT * FROM user_reg WHERE username = :username";

        $stmt = $this->conn->prepare($select_sql);
        $stmt->execute(['username' => $username]);
        if($stmt->rowCount() > 0){

            while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($data_rsl);
                $data = array(
                    'username' => $username,
                    'fullname' => $fullname,
                    'email' => $email,
                    'phone_no' => $phone_no,
                    'date_of_birth' => $date_of_birth,
                    'user_address' => $user_address
                );
                array_push($user['info'], $data);
                /* echo" 
                <ul id='profile_data'>
                    <li id='profile_data_item'>Username: $data_rsl[username] <input type='text' value='$data_rsl[username]' class='form-control d-none' name='username' id='username' placeholder='Edit Username'></li>
                    <li id='profile_data_item'>Name: $data_rsl[fullname] <input type='text' value='$data_rsl[fullname]' class='form-control d-none' name='name' id='name' placeholder='Edit Name'><i id='edit_name' class='fas fa-edit  text-primary  '></i></li>
                    <li id='profile_data_item'>Email: $data_rsl[email] <input type='email' value='$data_rsl[email]' class='form-control d-none' name='email' id='email' placeholder='Email Address'><i id='edit_email' class='fas fa-edit  text-primary  '></i></li>
                    <li id='profile_data_item'>Phone Number: $data_rsl[phone_no]<input type='tel' value='$data_rsl[phone_no]' class='form-control d-none' name='mobile_number' id='mobile_number' placeholder='Phone Number'><i id='edit_mobile' class='fas fa-edit  text-primary  '></i></li>
                    <li id='profile_data_item'>Date of Birth: $data_rsl[date_of_birth] <input type='date' value='$data_rsl[date_of_birth]' class='form-control d-none' name='date' id='date' ><i id='edit_date' class='fas fa-edit  text-primary  '></i></li>
                    <li id='profile_data_item'>Address: $data_rsl[user_address] <div class='form-group'>
                        <textarea class='form-control d-none' name='address' value='$data_rsl[user_address]' id='address' rows='3'></textarea>
                    </div><i id='edit_address' class='fas fa-edit  text-primary  '></i></li>
                </ul>
                "; */
            }
            return json_encode($user['info']);
        }
        else{
            
            $this->response['status'] = true;
            $this->response['message'] = "User Not Found";

            return json_encode($this->response);
        }
    }
    /* unfreeze user */
    public function unfreezeUser($username){
        $sql_select = "SELECT * FROM user_reg WHERE username = :username";
        $stmt = $this->conn->prepare($sql_select);

        if($stmt->execute(['username' => $username])){
            if($stmt->rowCount() > 0){

                if($data_user = $stmt->fetch(PDO::FETCH_ASSOC)){

                    $update_account = "UPDATE user_reg SET account_status = :account_status WHERE username = :username";
                    $stmt = $this->conn->prepare($update_account);

                    if($stmt->execute(['account_status' => '', 'username' => $username])){
                        
                        $this->response['status'] = false;
                        $this->response['message'] = "Account Unfreezed";
                    }
                    else{
                        $this->response['status'] = true;
                        $this->response['message'] = "Account Unfreezed Failed";
                    }
                }
            }
            else{

            }
        }
        else{

        }
        return json_encode($this->response);
    }
    /* PASSWORD RESET  */
    public function resetPassword($username){

        $sql = "SELECT * FROM `user_reg` WHERE user_reg.username = :username;";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute(['username' => $username]);

        if($stmt->rowCount() > 0){
             while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $_SESSION['username'] = $username;
             }
             header("Location: ../../forgot-password_mobile.php");
        }
        else{
            header("Location: ../../forgot-password.php?request='User NOT Found'");
        }

    }
    /* MOBILE NUMBER AUTHENTICATION */
    public function checkMobileNumber($username,$phone_no){

        $sql = "SELECT * FROM `user_reg` WHERE user_reg.username = :username AND user_reg.phone_no = :phone_no;";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute(['username' => $username,'phone_no'=> $phone_no]);

        if($stmt->rowCount() > 0){
             while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $_SESSION['username'] = $username;
             }
             header("Location: ../../forgot-password_password.php");
        }
        else{
            header("Location: ../../forgot-password.php?request='User NOT Found'");
        }

    }
    /* UPDATE PASSWORD */
    public function updatePassword($username, $password, $confirm_password){

        $password = htmlspecialchars(strip_tags($password));
        $confirm_password = htmlspecialchars(strip_tags($confirm_password));

        if(empty($password) || empty($password)){
            $this->response['status'] = true;
            $this->response['message'] = "Form Input Empty";
        }
        else{
            $sql = "SELECT * FROM `user_reg` WHERE user_reg.username = :username;";
            $stmt = $this->conn->prepare($sql);
    
            $stmt->execute(['username' => $username]);
    
            if($stmt->rowCount() > 0){
                $sql_update = "UPDATE `user_reg` SET `pwd` = :pwd WHERE `user_reg`.`username` = :username;";

                if($password === $confirm_password){
                    $stmt = $this->conn->prepare($sql_update);
                    $rsl = $stmt->execute(['pwd' => password_hash($password,PASSWORD_DEFAULT), 'username' => $username]);
                    
                    if($rsl ){
                        $this->response['status'] = false;
                        $this->response['message'] = "Password Reset Successfully";
                    }
                }
                else{
                    $this->response['status'] = true;
                    $this->response['message'] = "Password NOT MATCHED";
                }
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "User Does NOT EXIST";
            }
        }
        return json_encode($this->response);
    }
}

?>
                      