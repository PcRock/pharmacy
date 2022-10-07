<?php
/* session_start(); */

class Items {
    /* drug information */
    private $drug_name;
    private $drug_chem_name;
    private $composition;
    private $class_name;
    private $location;
    private $manufac_name;
    private $manufac_address;
    private $manufac_phone_no;
    private $manufac_email;
    private $dtarget;
    private $form_name;
    private $quantity_supp_pack;
    private $quantity_tabs_pack;
    private $available_quantity;
    private $supp_price;
    private $selling_price;
    private $discont;
    private $sold_price;
    private $mfg_lic_no;
    private $batch_no;
    private $mfg_date;
    private $exp_date;
    private $nafdac_reg;
    private $treatment_type;
    private $priority;
    private $salling_perc ;
    private $quantity_supp;
    private $price_pack;
    private $price_satchet;
    private $price_tabs;
    public $requires;
    public $syrup,$topical,$tablets,$capsule,$suppositiores,$drops,$inhalers,$injection,$implants,$surgicals,$buccals;
    /* public $item_name,$item_composition,$item_location,$item_manufacr_name,$item_manufact_addrss,$item_manufact_phone,
    $item_manufact_email,$item_target, */
    public $item_content;
    private $username;
    private $name;
    private $email;
    private $phone_no;
    private $dob;
    private $address;
    private $role;
    private $pwd;
    public $conn;
    public $response;

    public function __construct($db)
    {
        $this->conn = null;
        $this->conn = $db;
        $this->response = array();
    }

    public function addNewItem(
        $drug_name, $composition,$class_name,$location,
        $dtarget,$form_name,$quantity_supp_pack,$quantity_tabs_pack,$supp_price,$exp_date,$mfg_date,
        $treatment_type,$quantity_supp,$supp_type,$percent,$drug_chem_name
    ){

        if(empty($drug_name)||empty($composition)||empty($class_name)||
        empty($dtarget)||empty($form_name)||empty($quantity_supp_pack)||empty($quantity_tabs_pack)||empty($supp_price)
        ||empty($mfg_date)||empty($exp_date)||empty($treatment_type)||empty($quantity_supp)||empty($supp_type) ||empty($percent)
        ){
            
            $this->response['status'] = true;
            $this->response['message'] = "Oops! Form Input is Empty";
        }
        else{

            /* Selling price calculation */
            $this->salling_perc = $percent/100;
            $add_price = $supp_price * $this->salling_perc;
            $new_price = $supp_price; //+ $add_price;

            /* insert drug information */
            $this->drug_name = ucfirst(htmlspecialchars(strip_tags($drug_name)));
            $this->drug_chem_name = ucwords(htmlspecialchars(strip_tags($drug_chem_name)));
            $this->composition = htmlspecialchars(strip_tags($composition));

            if (date("Y-m-d") >= $exp_date) {
                
                $this->response['status'] = true;
                $this->response['message'] = "Oops! Product Already Expired";

            } 
            else {
            /* INSERT DRUG INFORMATION */
            $sql_insert_drug_info = "INSERT INTO drug_info (drug_id,drug_name,drug_chem_name,composition)
                VALUES(:drug_id,:drug_name,:drug_chem_name,:composition)";

            $stmt = $this->conn->prepare($sql_insert_drug_info);
            $drug_id = uniqid(true);
            if($stmt->execute([
                'drug_id' => $drug_id,
                'drug_name' => $this->drug_name,
                'drug_chem_name' => $this->drug_chem_name,
                'composition' => $this->composition
            ])){

                $this->class_name = htmlspecialchars(strip_tags($class_name));
                $sql_insert_class_name = "INSERT INTO classification (class_name, drug_name,drug_id) 
                VALUES(:class_name, :drug_name,:drug_id)";
                $stmt = $this->conn->prepare($sql_insert_class_name);
                if ($stmt->execute([
                    'class_name' => $this->class_name,
                    'drug_name' => $this->drug_name,
                    'drug_id' => $drug_id
                ])) {
                    
                    $this->location = ucfirst(htmlspecialchars(strip_tags($location)));
                    $insert_drug_location = "INSERT INTO drug_location (location_name, drug_name, drug_id)
                    VALUES(:location_name, :drug_name, :drug_id)";
                    $stmt = $this->conn->prepare($insert_drug_location);
                    if ($stmt->execute([
                        'location_name' => $this->location,
                        'drug_name' => $this->drug_name,
                        'drug_id' => $drug_id
                    ])) {
                        $manufac_address= "";
                        $manufac_email= "";
                        $manufac_name= "";
                        $manufac_phone_no = "";
                        $this->manufac_address = ucwords(htmlspecialchars(strip_tags($manufac_address)));
                        $this->manufac_email = htmlspecialchars(strip_tags($manufac_email));
                        $this->manufac_name = ucwords(htmlspecialchars(strip_tags($manufac_name)));
                        $this->manufac_phone_no = htmlspecialchars(strip_tags($manufac_phone_no));

                        $insert_drug_manufacture = "INSERT INTO drug_manufacture (manufacturer_name,manufacturer_addrss,manufacturer_phone,manufacturer_email, drug_name,drug_id)
                        VALUES(:manufacturer_name,:manufacturer_addrss,:manufacturer_phone,:manufacturer_email, :drug_name,:drug_id)";
                        $stmt = $this->conn->prepare($insert_drug_manufacture);
                        if ($stmt->execute([
                            'manufacturer_name' => $this->manufac_name,
                            'manufacturer_addrss' => $this->manufac_address,
                            'manufacturer_phone' => $this->manufac_phone_no,
                            'manufacturer_email' => $this->manufac_email,
                            'drug_name' => $this->drug_name,
                            'drug_id' => $drug_id
                        ])) {
                            
                            $this->dtarget = htmlspecialchars(strip_tags($dtarget));
                            $insert_drug_target = "INSERT INTO drug_target(dtarget, drug_name,drug_id)VALUES(:dtarget, :drug_name,:drug_id)";
                            $stmt = $this->conn->prepare($insert_drug_target);
                            if ($stmt->execute([
                                'dtarget' => $this->dtarget,
                                'drug_name' => $this->drug_name,
                                'drug_id' => $drug_id
                            ])) {
                                
                                $this->form_name = htmlspecialchars(strip_tags($form_name));
                                $this->quantity_supp_pack = htmlspecialchars(strip_tags($quantity_supp_pack));
                                $this->quantity_tabs_pack = htmlspecialchars(strip_tags($quantity_tabs_pack));
                                $this->quantity_supp = htmlentities(strip_tags($quantity_supp));

                                //available quantity
                                $available_quantity = ($this->quantity_supp_pack * $this->quantity_tabs_pack) * $this->quantity_supp;
                                $available_satchet = $available_quantity/$this->quantity_tabs_pack;
                                $available_pack = $available_satchet/$this->quantity_supp_pack;

                                $date_supp = date('d-M-Y');
                                $insert_drug_formation = "INSERT INTO formation_drug(form_name,quantity_satch_pack,qauntity_tabs_pack, drug_name,quantity_supp,date_supp,available_pack,available_satchet,available_tabs,available_quantity,drug_id)
                                VALUES(:form_name,:quantity_satch_pack,:qauntity_tabs_pack, :drug_name,:quantity_supp,:date_supp,:available_pack,:available_satchet,:available_tabs,:available_quantity,:drug_id)";
                                $stmt = $this->conn->prepare($insert_drug_formation);
                                
                                if ($stmt->execute([
                                    'form_name' => $this->form_name,
                                    'quantity_satch_pack' => $this->quantity_supp_pack,
                                    'qauntity_tabs_pack' => $this->quantity_tabs_pack,
                                    'drug_name' => $this->drug_name,
                                    'quantity_supp' => $this->quantity_supp,
                                    'date_supp' => $date_supp,
                                    'available_pack' => $available_pack,
                                    'available_satchet' => $available_satchet,
                                    'available_tabs' => $available_quantity,
                                    'available_quantity' => $available_quantity,
                                    'drug_id' => $drug_id
                                ])) {
                                    

                                    if($supp_type === 'Pack'){

                                        $total_tabs_pack = $this->quantity_supp_pack * $this->quantity_tabs_pack;
                                        $this->supp_price = $supp_price;
                                        $this->selling_price = $new_price;
                                        $this->price_pack = $new_price;
                                        $this->price_satchet = round($new_price/$this->quantity_supp_pack);
                                        $this->price_tabs = round($new_price/$total_tabs_pack);
                                    }
                                    elseif ($supp_type === 'Satchet') {

                                        $total_tabs_pack = $this->quantity_supp_pack * $this->quantity_tabs_pack;
                                        $this->supp_price = $supp_price;
                                        $this->selling_price = $new_price;
                                        $this->price_satchet = $new_price;
                                        $this->price_pack = $new_price * $this->quantity_supp_pack;
                                        $this->price_tabs = round($new_price/$this->quantity_tabs_pack);

                                    }
                                    elseif ($supp_type === 'Tabs') {
                                        
                                        $total_tabs_pack = $this->quantity_supp_pack * $this->quantity_tabs_pack;
                                        $this->supp_price = $supp_price;
                                        $this->selling_price = $new_price;
                                        $this->price_tabs = $new_price;
                                        $this->price_satchet = $new_price * $this->quantity_tabs_pack;
                                        $this->price_pack = $this->price_satchet*$this->quantity_supp_pack;

                                    }
                                    else {
                                        /* echo insertion into production_info successful */
                                        $this->response['status'] = true;
                                        $this->response['message'] = "Oops! Price not well Captured";
                                    }
                                    
                                    $insert_drug_price = "INSERT INTO price_drug(drug_id,supp_price,selling_price, drug_name,pack,satchet,tabs)
                                    VALUES(:drug_id,:supp_price,:selling_price, :drug_name,:pack,:satchet,:tabs)";
                                    $stmt = $this->conn->prepare($insert_drug_price);
                                    if ($stmt->execute([
                                        'supp_price' => $this->supp_price,
                                        'selling_price' => $this->selling_price,
                                        'drug_name' => $this->drug_name,
                                        'pack' => $this->price_pack,
                                        'satchet' => $this->price_satchet,
                                        'tabs' => $this->price_tabs,
                                        'drug_id' => $drug_id
                                    ])) {
                                        $mfg_lic_no= "";
                                        $batch_no= "";
                                        $nafdac_reg = "";
                                        $this->mfg_lic_no = htmlspecialchars(strip_tags($mfg_lic_no));
                                        $this->batch_no = htmlspecialchars(strip_tags($batch_no));
                                        $this->mfg_date = htmlspecialchars(strip_tags($mfg_date));
                                        $this->exp_date = htmlspecialchars(strip_tags($exp_date));
                                        $this->nafdac_reg = htmlspecialchars(strip_tags($nafdac_reg));

                                        $insert_drug_production = "INSERT INTO production_info(mfg_lic_no,batch_no,mfg_date,exp_date,nafdac_reg, drug_name,drug_id)
                                        VALUES(:mfg_lic_no,:batch_no,:mfg_date,:exp_date,:nafdac_reg, :drug_name, :drug_id)";
                                        $stmt = $this->conn->prepare($insert_drug_production);
                                        if ($stmt->execute([
                                            'mfg_lic_no'=>$this->mfg_lic_no,
                                            'batch_no'=>$this->batch_no,
                                            'mfg_date'=>$this->mfg_date,
                                            'exp_date' => $this->exp_date,
                                            'nafdac_reg'=>$this->nafdac_reg,
                                            'drug_name' => $this->drug_name,
                                            'drug_id' => $drug_id
                                        ])) {
                                            $priority = "";
                                            $this->treatment_type = ucfirst(htmlspecialchars(strip_tags($treatment_type)));
                                            $this->priority = htmlspecialchars(strip_tags($priority));
                                            
                                            $insert_drug_treatment = "INSERT INTO treatment(drug_id,treatment_type,priority, drug_name)
                                            VALUES(:drug_id,:treatment_type,:priority, :drug_name)";
                                            $stmt = $this->conn->prepare($insert_drug_treatment);
                                            if ($stmt->execute([
                                                'treatment_type' => $this->treatment_type,
                                                'priority' => $this->priority,
                                                'drug_name' => $this->drug_name,
                                                'drug_id' => $drug_id
                                            ])) {
                                                
                                                
                                                $this->response['status'] = false;
                                                $this->response['message'] = "Product Added Successful";
                                            } 
                                            else {
                                                /* echo insertion into treatment failed */
                                                $sql_del = "DELETE production_info,price_drug,formation_drug,drug_target,drug_manufacture,drug_location,classification FROM production_info
                                                JOIN price_drug ON production_info.drug_id = price_drug.drug_id JOIN formation_drug ON production_info.drug_id = formation_drug.drug_id
                                                JOIN drug_target ON production_info.drug_id = drug_target.drug_id JOIN drug_manufacture ON production_info.drug_id = drug_manufacture.drug_id
                                                JOIN drug_location ON production_info.drug_id = drug_location.drug_id JOIN classification ON production_info.drug_id = classification.drug_id
                                                WHERE drug_id = :drug_id";
                                                $stmt = $this->conn->prepare($sql_del);

                                                if ($stmt->execute(['drug_id'=>$drug_id])) {
                                                    
                                                    $sql_del = "DELETE FROM drug_info WHERE drug_id = '$drug_id'";
                                                    $stmt = $this->conn->prepare($sql_del);
                                                    if ($stmt->execute()) {
                                                        
                                                        $this->response['status'] = true;
                                                        $this->response['message'] = "Failed Treatment No Saved:" . $this->conn->getMessage();
                                                    } 
                                                    else {
                                                        
                                                        $this->response['status'] = true;
                                                        $this->response['message'] = "Error drug Info deleted:" . $this->conn->getMessage();
                                                    }
                                                    
                                                    

                                                } else {

                                                    $this->response['status'] = true;
                                                    $this->response['message'] = "Error drug Info deleted:" . $this->conn->getMessage();
                                                    
                                                }
                                                
                                            }
                                            
                                        } else {
                                            /* echo insertion into production_info failed */
                                            $sql_del = "DELETE price_drug,formation_drug,drug_target,drug_manufacture,drug_location,classification FROM price_drug JOIN formation_drug ON
                                            price_drug.drug_id = formation_drug.drug_id JOIN drug_target ON
                                            price_drug.drug_id = drug_target.drug_id JOIN drug_manufacture ON
                                            price_drug.drug_id = drug_manufacture.drug_id JOIN drug_location ON
                                            price_drug.drug_id = drug_location.drug_id JOIN classification ON
                                            price_drug.drug_id = classification.drug_id
                                            WHERE price_drug.drug_id = :drug_id";

                                            $stmt = $this->conn->prepare($sql_del);
                                            if ($stmt->execute(['drug_id'=>$drug_id])) {
                                                
                                                $sql_del = "DELETE FROM drug_info WHERE drug_id = :drug_id";
                                                $stmt = $this->conn->prepare($sql_del);
                                                if ($stmt->execute(['drug_id'=>$drug_id])) {
                                                        
                                                    
                                                } 
                                                else {
                                                    
                                                }

                                            } else {

                                                
                                                
                                            }
                                            
                                        }
                                        
                                    } else {
                                        /* echo insertion into drug_price failed */
                                        $sql_del = "DELETE formation_drug,drug_target,drug_manufacture,drug_location,classification FROM formation_drug JOIN 
                                        drug_target ON formation_drug.drug_id = drug_target.drug_id JOIN drug_manufacture ON formation_drug.drug_id = drug_manufacture.drug_id
                                        JOIN drug_location ON formation_drug.drug_id = drug_location.drug_id JOIN classification ON formation_drug.drug_id = classification.drug_id
                                        WHERE formation_drug.drug_id = :drug_id";

                                        $stmt = $this->conn->prepare($sql_del);
                                        if ($stmt->execute(['drug_id' => $drug_id])) {
                                            
                                            $sql_del = "DELETE FROM drug_info WHERE drug_iddrug_id = :drug_iddrug_id";
                                            $stmt = $this->conn->prepare($sql_del);
                                            if ($stmt->execute(['drug_id' => $drug_id])) {
                                                        
                                                /* header("Location: ../../pharm_activities/reg_item.php?form=failed_price_no_record_saved ".mysqli_error($this->conn));
                                                exit(); */
                                            } 
                                            else {
                                                /* echo "Erro drug Info dele".mysqli_error($this->conn); */
                                            }

                                        } else {

                                            /* header("Location: ../../pharm_activities/reg_item.php?form=failed_price ".mysqli_error($this->conn));
                                            exit(); */
                                            
                                        }
                                        
                                    }
                                    
                                } else {
                                    /* echo insertion into drug_formation failed */
                                    $sql_del = "DELETE drug_target,drug_manufacture,drug_location,classification FROM drug_target JOIN drug_manufacture
                                    ON drug_target.drug_id = drug_manufacture.drug_id JOIN drug_location ON drug_target.drug_id = drug_location.drug_id
                                    JOIN classification ON drug_target.drug_id = classification.drug_id
                                    WHERE drug_target.drug_id = :drug_id";

                                    $stmt = $this->conn->prepare($sql_del);
                                    if ($stmt->execute(['drug_id' => $drug_id])) {
                                        
                                        $sql_del = "DELETE FROM drug_info WHERE drug_id = :drug_id";
                                        $stmt = $this->conn->prepare($sql_del);
                                        if ($stmt->execute(['drug_id' => $drug_id])) {
                                                        
                                            /* header("Location: ../../pharm_activities/reg_item.php?form=failed_drug_formation_no_record_saved ".mysqli_error($this->conn));
                                            exit(); */
                                        } 
                                        else {
                                            /* echo "Erro drug Info dele".mysqli_error($this->conn); */
                                        }

                                    } else {

                                        /* header("Location: reg_item.php?form=failed_drug_formation ".mysqli_error($this->conn));
                                        exit(); */
                                        /* echo mysqli_error($this->conn); */
                                    }
                                    
                                }
                                
                            } else {
                                /* echo insertion into drug_target failed */

                                $sql_del = "DELETE drug_manufacture,drug_location,classification FROM drug_manufacture JOIN drug_location ON drug_manufacture.drug_id = drug_location.drug_id
                                JOIN classification ON drug_manufacture.drug_id = classification.drug_id WHERE drug_manufacture.drug_id = :drug_id";

                                $stmt = $this->conn->prepare($sql_del);
                                if ($stmt->execute(['drug_id' => $drug_id])) {
                                    
                                        $sql_del = "DELETE FROM drug_info WHERE drug_id = :drug_id";
                                        $stmt = $this->conn->prepare($sql_del);
                                        if ($stmt->execute(['drug_id' => $drug_id])) {
                                                        
                                            /* header("Location: ../../pharm_activities/reg_item.php?form=failed_drug_target_formation_no_record_saved ".mysqli_error($this->conn));
                                            exit(); */
                                        } 
                                        else {
                                            /* echo "Erro drug Info dele".mysqli_error($this->conn); */
                                        }

                                } else {

                                    /* header("Location: ../../pharm_activities/reg_item.php?form=failed_drug_target ".mysqli_error($this->conn));
                                    exit(); */
                                    
                                }
                                
                            }
                            
                        } else {
                            /* echo insertion into drug_manufacture failed */
                            $sql_del = "DELETE drug_location,classification FROM drug_location JOIN classification ON drug_location.drug_id = classification.drug_id
                            WHERE drug_location.drug_id = :drug_id";

                            $stmt = $this->conn->prepare($sql_del);
                            if ($stmt->execute(['drug_id' => $drug_id])) {
                                
                                $sql_del = "DELETE FROM drug_info WHERE drug_id = :drug_id";
                                $stmt = $this->conn->prepare($sql_del);
                                if ($stmt->execute(['drug_id' => $drug_id])) {
                                                        
                                    /* header("Location: ../../pharm_activities/reg_item.php?form=failed_drug_target_formation_no_record_saved ".mysqli_error($this->conn));
                                    exit(); */
                                } 
                                else {
                                    /* echo "Erro drug Info dele".mysqli_error($this->conn); */
                                }

                            } else {

                                /* header("Location: ../../pharm_activities/reg_item.php?form=failed_manufact ".mysqli_error($this->conn));
                                exit(); */
                                
                            }
                                
                        }
                        
                    } else {
                        /* echo insertion into drug_location failed */
                        $sql_del = "DELETE FROM classification WHERE drug_id = :drug_id";

                        $stmt = $this->conn->prepare($sql_del);
                        if ($stmt->execute(['drug_id' => $drug_id])) {
                            
                            $sql_del = "DELETE FROM drug_info WHERE drug_id = :drug_id";
                            $stmt = $this->conn->prepare($sql_del);
                            if ($stmt->execute(['drug_id' => $drug_id])) {
                                                        
                                    /* header("Location: ../../pharm_activities/reg_item.php?form=failed_drug_target_formation_no_record_saved ".mysqli_error($this->conn));
                                    exit(); */
                                } 
                                else {
                                    /* echo "Erro drug Info dele".mysqli_error($this->conn); */
                                }

                        } else {

                            /* header("Location: ../../pharm_activities/reg_item.php?form=failed_location ".mysqli_error($this->conn));
                            exit(); */
                            
                        }
                        
                    }
                    
                } else {
                    
                    /* header("Location: ../../pharm_activities/reg_item.php?form=failed_classification ".mysqli_error($this->conn));
                        exit(); */
                    
                }
                
            }
            else{
                /* echo insertion into drug_info failed */
                /* header("Location: ../../pharm_activities/reg_item.php?form=failed_information ".mysqli_error($this->conn));
                exit();  */
                
            }

            }
            
        }
        return json_encode($this->response);
    }

    /* Fetch all drugs in store  */
    public function getAllItem(){
        $drug_information['data'] = array();
        $select_sql = "SELECT
                drug_info.drug_id,
                drug_info.drug_name,
                drug_info.drug_chem_name,
                drug_info.composition,
                formation_drug.available_quantity,
                price_drug.selling_price,
                classification.class_name,
                formation_drug.form_name,
                formation_drug.available_quantity,
                treatment.treatment_type,
                drug_location.location_name
            FROM
                drug_info
            JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
            JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
            JOIN classification ON drug_info.drug_id = classification.drug_id
            JOIN treatment ON drug_info.drug_id = treatment.drug_id
            JOIN drug_location ON drug_info.drug_id = drug_location.drug_id";//LIMIT 0,6

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute()){
            if($stmt->rowCount() > 0){

                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($rows);

                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'composition' => $composition,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'treatment_type' => $treatment_type,
                        'selling_price' => number_format($selling_price),
                        'location_name' => $location_name,
                        'drug_id' => $drug_id,
                        'quanity' => $available_quantity
                        
                    );

                    array_push($drug_information['data'], $data);
                   
                }
                return json_encode($drug_information['data']);
            }
            else{
                
                $this->response['status'] = true;
                $this->response['message'] = "Error No result found";
            }
        }
        else{
           
            $this->response['status'] = true;
            $this->response['message'] = "Error Select Query";
        }
    }

    public function getSyrup(){
        $syrup_drugs['data'] = array();
        $sn = 1;
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            price_drug.selling_price,
            treatment.treatment_type,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        WHERE
            formation_drug.form_name = :syrups
        ORDER BY
            drug_info.drug_name ASC";
        
        $stmt = $this->conn->prepare($select_sql);
        $syrup = 'Syrups';

        if($stmt->execute(['syrups'=> $syrup])){
            if($stmt->rowCount() > 0){
                $this->syrup = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'selling_price' => $selling_price,
                        'treatment_type' => $treatment_type,
                        'composition' => $composition,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'drug_id' => $drug_id
                    );
                    array_push($syrup_drugs['data'],$data);
                    
                }
                return json_encode($syrup_drugs['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No result found";
            }
        }
        else{
            
            $this->response['status'] = true;
            $this->response['message'] = "Error Select Query";
        }
    }

    public function getTablets(){
        
        $sn =0; 
        $tablet_drugs['data'] = array();
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            price_drug.selling_price,
            treatment.treatment_type,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        WHERE
            formation_drug.form_name = :Tablet
        ORDER BY
            drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);
        $tablet = 'Tablet';
        if($stmt->execute(['Tablet'=> $tablet])){
            if($stmt->rowCount() > 0){
                $this->tablets = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'selling_price' => $selling_price,
                        'treatment_type' => $treatment_type,
                        'composition' => $composition,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'drug_id' => $drug_id
                    );
                    array_push($tablet_drugs['data'],$data);
                    
                }
                return json_encode($tablet_drugs['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            
            $this->response['status'] = true;
            $this->response['message'] = "Error Select Query";
        }
    }

    public function getCapsules(){
        
        $sn = 0;
        $capsule = "Capsule";
        $capsule_drug['data'] = array();
        $select_sql = "SELECT
        drug_info.drug_id,
        drug_info.drug_name,
        drug_info.drug_chem_name,
        drug_info.composition,
        classification.class_name,
        formation_drug.form_name,
        formation_drug.available_quantity,
        price_drug.selling_price,
        treatment.treatment_type
    FROM
        drug_info
    JOIN classification ON drug_info.drug_id = classification.drug_id
    JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
    JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
    JOIN treatment ON drug_info.drug_id = treatment.drug_id
    WHERE
        formation_drug.form_name = :capsule
    ";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['capsule'=>$capsule])){
            if($stmt->rowCount() > 0){
                $this->capsule = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem_name' => $drug_chem_name,
                        'selling_price' => $selling_price,
                        'composition' => $composition,
                        'treatment_type' => $treatment_type,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'drug_id' => $drug_id
                    );
                    array_push($capsule_drug['data'],$data);
                    
                }
                return json_encode($capsule_drug['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
            $this->response['message'] = "Error Select Query";
        }
    }

    public function getTopical(){
        
        $sn = 0;
        $topical = 'Topical';
        $topical_drugs['data'] = array();
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            treatment.treatment_type,
            price_drug.selling_price,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        WHERE
        classification.class_name = :topical
        ORDER BY
            drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['topical'=>$topical])){
            if($stmt->rowCount() > 0){
                $this->topical = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'selling_price' => $selling_price,
                        'treatment_type' => $treatment_type,
                        'composition' => $composition,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'drug_id' => $drug_id
                    );
                    array_push($topical_drugs['data'],$data);
                    
                }
                return json_encode($topical_drugs['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
                $this->response['message'] = "Error Select Query";
        }
    }

    public function getSuppositories(){
        
        $sn = 0;
        $suppositories = 'Suppository';
        $suppositories_drugs['data'] = array();
        $select_sql = "SELECT
                drug_info.drug_id,
                drug_info.drug_name,
                drug_info.drug_chem_name,
                price_drug.selling_price,
                treatment.treatment_type,
                drug_info.composition,
                classification.class_name,
                formation_drug.form_name,
                formation_drug.available_quantity
            FROM
                drug_info
            JOIN classification ON drug_info.drug_id = classification.drug_id
            JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
            JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
            JOIN treatment ON drug_info.drug_id = treatment.drug_id
            WHERE
                formation_drug.form_name = :suppository
            ORDER BY
                drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['suppository'=>$suppositories])){
            if($stmt->rowCount() > 0){
                $this->suppositories = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'composition' => $composition,
                        'drug_chem' => $drug_chem_name,
                        'selling_price' => $selling_price,
                        'treatment_type' => $treatment_type,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'drug_id' => $drug_id
                    );
                    array_push($suppositories_drugs['data'],$data);
                    
                }
                return json_encode($suppositories_drugs['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
                $this->response['message'] = "Error Select Query";
        }
    }

    public function getDrops(){
        
        $sn = 0;
        $drops = 'Drop';
        $drug_drugs['data'] = array();
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity,
            price_drug.selling_price,
            treatment.treatment_type
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        WHERE
            formation_drug.form_name = :drops
        ORDER BY
            drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['drops'=>$drops])){
            if($stmt->rowCount() > 0){
                $this->drops = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'composition' => $composition,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'drug_id' => $drug_id,
                        'selling_price' => $selling_price,
                        'treatment_type' => $treatment_type
                    );
                    array_push($drug_drugs['data'],$data);
                    
                }
                return json_encode($drug_drugs['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
                $this->response['message'] = "Error Select Query";
        }
    }

    public function getInhalers(){
        
        $sn = 0;
        $inhalers = 'Inhaler';
        $inhaler_drug['data'] = array();
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            treatment.treatment_type,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity,
            price_drug.selling_price
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        WHERE
            formation_drug.form_name = :inhaler
        ORDER BY
            drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['inhaler'=>$inhalers])){
            if($stmt->rowCount() > 0){
                $this->inhalers = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'composition' => $composition,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'treatment_type' => $treatment_type,
                        'selling_price' => number_format($selling_price),
                        'drug_id' => $drug_id
                    );
                    array_push($inhaler_drug['data'],$data);
                    
                }
                return json_encode($inhaler_drug['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
                $this->response['message'] = "Error Select Query";
        }
    }

    public function getInjections(){
        
        $sn = 0;
        $injection = 'Injection';
        $injection_drug['data'] = array();
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            treatment.treatment_type,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity,
            price_drug.selling_price
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        WHERE
            formation_drug.form_name = :injection
        ORDER BY
            drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['injection'=>$injection])){
            if($stmt->rowCount() > 0){
                $this->injection = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'treatment_type' => $treatment_type,
                        'selling_price' => $selling_price,
                        'composition' => $composition,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'selling_price' => number_format($selling_price),
                        'drug_id' => $drug_id
                    );
                    array_push($injection_drug['data'],$data);
                    
                }
                return json_encode($injection_drug['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
                $this->response['message'] = "Error Select Query";
        }
    }

    public function getImplant(){
        
        $sn = 0;
        $implants = 'Implant';
        $implants_drug['data'] = array();
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            treatment.treatment_type,
            price_drug.selling_price,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        WHERE
            formation_drug.form_name = :implant
        ORDER BY
            drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['implant'=>$implants])){
            if($stmt->rowCount() > 0){
                $this->implant = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'treatment_type' => $treatment_type,
                        'selling_price' => $selling_price,
                        'composition' => $composition,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'selling_price' => number_format($selling_price),
                        'drug_id' => $drug_id
                    );
                    array_push($implants_drug['data'],$data);
                    
                }
                return json_encode($implants_drug['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
                $this->response['message'] = "Error Select Query";
        }
    }

    public function getBuccal(){
        
        $sn = 0;
        $buccals = 'Buccal';
        $buccals_drug['data'] = array();
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity,
            treatment.treatment_type,
            price_drug.selling_price
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        WHERE
            formation_drug.form_name = :buccal
        ORDER BY
            drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['buccal'=>$buccals])){
            if($stmt->rowCount() > 0){
                $this->buccals = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'composition' => $composition,
                        'available_quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'treatment_type' => $treatment_type,
                        'selling_price' => number_format($selling_price),
                        'drug_id' => $drug_id
                    );
                    array_push($buccals_drug['data'],$data);
                    
                }
                return json_encode($buccals_drug['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
                $this->response['message'] = "Error Select Query";
        }
    }

    public function getSurgicalItem(){
        
        $sn = 0;
        $surgicals = 'Surgicals';
        $surgical_drugs['data'] = array(); 
        $select_sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.drug_chem_name,
            treatment.treatment_type,
            price_drug.selling_price,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.available_quantity
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        WHERE
            formation_drug.form_name = :surgicals
        ORDER BY
            drug_info.drug_name ASC";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['surgicals'=>$surgicals])){
            if($stmt->rowCount() > 0){
                $this->surgicals = $stmt->rowCount();
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($rows);
                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_chem' => $drug_chem_name,
                        'composition' => $composition,
                        'quantity' => $available_quantity,
                        'class_name' => $class_name,
                        'form_name' => $form_name,
                        'drug_id' => $drug_id,
                        'treatment_type' => $treatment_type,
                        'selling_price' => number_format($selling_price)
                    );
                    array_push($surgical_drugs['data'],$data);
                    
                }
                return json_encode($surgical_drugs['data']);
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Error No Result Found";
            }
        }
        else{
            $this->response['status'] = true;
                $this->response['message'] = "Error Select Query";
        }
    }
    /* Get TEMP CART INT */
    public function getTmp_SalesInt($username){

        $select_sql = "SELECT drug_name, qantity,unit_price,total FROM 
        tmp_sales WHERE username = :username";
        $sales_tmp['data'] = array();
        $stmt = $this->conn->prepare($select_sql);
        $num = 0;
        if($stmt->execute(['username' => $username])){
            if($stmt->rowCount() > 0){
                $num = $stmt->rowCount();
            }
            else{
                $num= 0;
            }
        }
        return $num;
    }
    public function getTmp_Sales($username){
        
        $select_sql = "SELECT drug_name,drug_id,qantity,unit_price,total FROM tmp_sales 
        WHERE username = :username";
        $sales_tmp['data'] = array();
        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['username' => $username])){
            if($stmt->rowCount() > 0){

                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($rows);

                    $data = array(
                        'drug_name' => $drug_name,
                        'drug_id' => $drug_id,
                        'qantity' => $qantity,
                        'unit_price' => $unit_price,
                        'total' => $total
                    );
                    array_push($sales_tmp['data'],$data);
                    /* echo
                    "
                    <tr>
                        <td>
                        <div class='d-inline-block'>
                            <a href='?sales_type=Pack&drug_name=$rows[drug_name]'>Pack</a>
                            <a href='?sales_type=Satchet&drug_name=$rows[drug_name]'>Satchet</a>
                            <a href='?sales_type=Tabs&drug_name=$rows[drug_name]'>Tabs</a>
                        </div>
                        </td>
                        <td>$rows[drug_name]</td>
                        <td>$rows[qantity]</td>
                        <td>".number_format($rows['unit_price'])."</td>
                        <td>".number_format($rows['total'])."</td>
                        <td >
                            <a href='?item_id=$rows[drug_name]&plus=$rows[drug_name]'><i class='fa fa-plus-circle px-2 text-sucess' aria-hidden='true'></i></a>
                            <a href='?item_id=$rows[drug_name]&minus=$rows[drug_name]'><i class='fa fa-minus-circle px-2 text-warning' aria-hidden='true'></i></a>
                            <a href='?item_id=$rows[drug_name]&del=$rows[drug_name]'><i class='fas fa-trash-alt  text-danger  '></i></a>
                        </td>
                    </tr>   
                    "; */
                }
                return json_encode($sales_tmp['data']);
            }
            else{
               
                $this->response['status'] = true;
                $this->response['message'] = "Cart empty at the moment";
            }
        }
        else{
            
        }
    }

    public function addToCart($drug_id,$username){
        /* Sales Records */
        $default_quantity = 0;
        $date = date('d/M/Y');
        
        /* Sales at random */
        $sql_rand = "SELECT drug_info.drug_id,drug_info.drug_name,drug_info.composition,price_drug.selling_price,formation_drug.available_quantity FROM drug_info 
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id 
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id 
        WHERE drug_info.drug_id = :drug_id";
        
        $stmt =$this->conn->prepare($sql_rand);

        if($stmt->execute([
            'drug_id' => $drug_id
        ])){

            if($stmt->rowCount() > 0){

                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($data);
                    if($available_quantity > 0){
                        /* Insert into tmp_record */
                        $insert_rec = "INSERT INTO tmp_sales (drug_id,username,qantity,unit_price,total,date_time,drug_name) 
                        VALUES(:drug_id,:username,:qantity,:unit_price,:total,:date_time,:drug_name)";
                        $stmt = $this->conn->prepare($insert_rec);
                        if ($stmt->execute([
                            'drug_id' => $drug_id,
                            'username' =>$username,
                            'qantity' =>  $default_quantity,
                            'unit_price' => $selling_price,
                            'total' => $selling_price,
                            'date_time' => $date,
                            'drug_name' => $drug_name
                        ])) {
                           
                            $this->getTmp_Sales($username);
                            
                            $this->response['status'] = false;
                            $this->response['message'] = "Added Successful ";

                        } else {
                            
                            $this->getTmp_Sales($username);
                            
                            $this->response['status'] = true;
                            $this->response['message'] = "Adding to Cart Failed ";
                        }
                        
                    }
                    else{
                       
                    $this->getTmp_Sales($username);
                    $this->response['status'] = true;
                    $this->response['message'] = "<strong>$drug_name</strong> Not Available in store ";
                    }
                }
            }
            else{
                /* Error message  */
                
                $this->response['status'] = true;
                $this->response['message'] = "Not Found ";
            }
        }
        else{
            /* Error message  */
            //header("Location: sales_item.php?acr=error_in_rand_query ".mysqli_error($this->conn));
            
            $this->response['status'] = true;
            $this->response['message'] = $drug_name ."Adding Insert Failed";
        }

        return json_encode($this->response);
    }

    /* Update Available product quantity in store */
    public function updateItem($drug_id){
        /* update available quantity */

        $available_new = $this->quantity_supp_pack * $this->quantity_tabs_pack * $this->quantity_supp;
                                    
        $select_sql = "SELECT formation_drug.drug_id,formation_drug.available_quantity FROM formation_drug 
        WHERE formation_drug.drug_name = :drug_id";

        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['drug_id' => $drug_id])){
            if($stmt->rowCount() > 0){

                if ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($rows);
                    $avail_quan = $available_quantity + $available_new;
                    $update_sql = "UPDATE formation_drug SET available_quantity = :available_quantity 
                    WHERE formation_drug.drug_id = :drug_id";
                    $stmt = $this->conn->prepare($update_sql);
                    if ($stmt->execute([
                        'available_quantity' => $avail_quan,
                        'drug_id' => $drug_id
                    ])) {
                        # code...
                    }
                    else{
                        
                        $this->response['status'] = true;
                        $this->response['message'] = "Failled updating quantity";
                    }
                }
                
            }
            else{
                /* echo insertion into production_info successful */
                
                $this->response['status'] = true;
                $this->response['message'] = "Failled Not Found";
            }
        }
        else{
            /* echo insertion into production_info successful */
            
            $this->response['status'] = true;
            $this->response['message'] = "Failled selecting query";
        }

        return json_encode($this->response);
    }
    /* Add Quantity */
    public function addQuantity($username,$drug_id,$quantity_input){

        /* Sales in pack */
        $sql_select_pack = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            price_drug.pack,
            formation_drug.available_pack
        FROM
            drug_info
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        WHERE
            drug_info.drug_id = :drug_id";
        /* Sales in satch */
        
        $sql_select_sat = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            price_drug.satchet,
            formation_drug.available_satchet
        FROM
            drug_info
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        WHERE
            drug_info.drug_id = :drug_id";
        
        /* Sales in tab */
        $sql_select_tabs = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            price_drug.tabs,
            formation_drug.available_tabs
        FROM
            drug_info
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        WHERE
            drug_info.drug_id = :drug_id";

        /* Update Sales Quantity and Price  */
        $new_quantity = 0;
        $new_sql = "SELECT * FROM tmp_sales WHERE drug_id = :drug_id && username = :username";
        $stmt = $this->conn->prepare($new_sql);

        if ($stmt->execute([
            'drug_id' => $drug_id,
            'username' => $username
        ])) {
            
            if ($stmt->rowCount() > 0) {
                
                if ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($rows);
                    $sales_type = $sale_type;
                    $present_quantity = $qantity;

                    switch ($sales_type) {

                        case 'Pack':
                            $stmt = $this->conn->prepare($sql_select_pack);

                            if ($stmt->execute(['drug_id'=>$drug_id])) {

                                if ($stmt->rowCount() > 0) {
                                    
                                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($data);
                                        $store_available = $available_pack;
                                        $price = $pack;

                                        if ($quantity_input <= $store_available) {
                                            
                                            $new_quantity = $quantity_input;
                                            $total = $new_quantity * $price;

                                            $update_sql = "UPDATE tmp_sales SET qantity = :qantity, 
                                            unit_price = :unit_price , total = :total 
                                            WHERE drug_id = :drug_id && username = :username";
                                            $stmt = $this->conn->prepare($update_sql);
                                            if ($stmt->execute([
                                                'qantity' => $new_quantity,
                                                'unit_price' => $price,
                                                'total' => $total,
                                                'drug_id' => $drug_id,
                                                'username' => $username
                                            ])) {

                                                $this->getTmp_Sales($username);

                                            } else {
                                                
                                                $this->response['status'] = true;
                                                $this->response['message'] = "Oops!! Sorry Update failed";

                                            }
                                            
                                        } 
                                        else {
                                           
                                            $this->response['status'] = true;
                                            $this->response['message'] = "Oops!! Sorry Available item in (Pack) only is". $store_available. "pack";
                                        }
                                        
                                    }
                                } 
                                else {
                                    
                                $this->response['status'] = true;
                                $this->response['message'] = "No result Found in Pack";
                                }
                                
                            } else {
                               
                                $this->response['status'] = true;
                                $this->response['message'] = "Pack query failed". $this->conn->getMessage();
                            }
                            
                            break;

                            case 'Satchet':
                                $stmt = $this->conn->prepare($sql_select_sat);

                                if ($stmt->execute([
                                    'drug_id'=>$drug_id
                                ])) {

                                    if ($stmt->rowCount() > 0) {
                                        
                                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            extract($data);
                                            $store_available = $available_satchet;
                                            $price = $satchet;

                                            if ($quantity_input <= $store_available) {
                                            
                                                $new_quantity = $quantity_input;
                                                $total = $new_quantity * $price;

                                                $update_sql = "UPDATE tmp_sales SET qantity = :quantity, unit_price = :price, 
                                                total = :total WHERE drug_id = :drug_id && username = :username";
                                                $stmt = $this->conn->prepare($update_sql);

                                                if ($stmt->execute([
                                                    'quantity' => $new_quantity,
                                                    'price' => $price,
                                                    'total' => $total,
                                                    'drug_id' => $drug_id,
                                                    'username' => $username
                                                ])) {

                                                    $this->getTmp_Sales($username);

                                                } else {
                                                    
                                                    $this->response['status'] = true;
                                                    $this->response['message'] = "Oops!! Sorry Update failed". $this->conn->getMessage();

                                                }
                                                
                                            } 
                                            else {
                                                
                                                $this->response['status'] = true;
                                                $this->response['message'] = "Oops!! Sorry Available item (Satchet) is $store_available satchet";
                                            }
                                            
                                        }
                                    } 
                                    else {
                                        
                                    $this->response['status'] = true;
                                    $this->response['message'] = "No result Found in Pack";
                                    }
                                    
                                } else {
                                    
                                    $this->response['status'] = true;
                                    $this->response['message'] = "Pack query failed";
                                }
                                
                                break;

                                case 'Tabs':
                                    $stmt = $this->conn->prepare($sql_select_tabs);
    
                                    if ($stmt->execute(['drug_id'=>$drug_id])) {
    
                                        if ($stmt->rowCount() > 0) {
                                            
                                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                extract($data);
                                                $store_available = $available_tabs;
                                                $price = $tabs;
    
                                                if ($quantity_input <= $store_available) {
                                            
                                                    $new_quantity = $quantity_input;
                                                    $total = $new_quantity * $price;
    
                                                    $update_sql = "UPDATE tmp_sales SET qantity = :quantity, unit_price = :price, 
                                                    total = :total WHERE drug_id = :drug_id && username = :username";
                                                    $stmt =$this->conn->prepare($update_sql);
                                                    if ($stmt->execute([
                                                        'quantity' => $new_quantity,
                                                        'price' => $price,
                                                        'total' => $total,
                                                        'drug_id' => $drug_id,
                                                        'username' => $username
                                                    ])) {
    
                                                        $this->getTmp_Sales($username);
    
                                                    } else {
                                                        
                                                        $this->response['status'] = true;
                                                        $this->response['message'] = ">Oops!! Sorry Update failed". $this->conn->getMessage();
    
                                                    }
                                                    
                                                } 
                                                else {
                                                    
                                                    $this->response['status'] = true;
                                                    $this->response['message'] = ">Oops!! Sorry Available item (Tabs) is $store_available tabs";
                                                }
                                                
                                            }
                                        } 
                                        else {
                                            
                                            $this->response['status'] = true;
                                            $this->response['message'] = ">No result Found in Pack";
                                        }
                                        
                                    } else {
                                        
                                        $this->response['status'] = true;
                                        $this->response['message'] = "Pack query failed";
                                    }
                                    
                                    break;
                        
                        default:
                            
                            $this->getTmp_Sales($username);
                            exit(); 
                            break;
                    }
                }
            } 
            else {
                
                $this->response['status'] = true;
                $this->response['message'] = "No result Found ";
            }
            
        } 
        else {
            
        }
          return json_encode($this->response);
    }
    /* minus Quantity */
    public function minusQuantity($username,$drug_id){

            /* Sales in pack */
            $sql_select_pack = "SELECT drug_info.drug_id,drug_info.drug_name,price_drug.pack,formation_drug.available_pack FROM drug_info JOIN price_drug ON drug_info.drug_id = price_drug.drug_id 
            JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
            WHERE drug_info.drug_id = :drug_id";
            /* Sales in satch */
            
            $sql_select_sat = "SELECT drug_info.drug_id,drug_info.drug_name,price_drug.satchet,formation_drug.available_satchet FROM drug_info JOIN price_drug ON drug_info.drug_id = price_drug.drug_id 
            JOIN formation_drug ON drug_info.drug_name = formation_drug.drug_id
            WHERE drug_info.drug_id = :drug_id";
            
            /* Sales in tab */
            $sql_select_tabs = "SELECT drug_info.drug_id,drug_info.drug_name,price_drug.tabs,formation_drug.available_tabs FROM drug_info JOIN price_drug ON drug_info.drug_id = price_drug.drug_id 
            JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
            WHERE drug_info.drug_id = :drug_id";
            /* Update Sales Quantity and Price  */
            
            $new_quantity = 0;
            $tmp_sql = "SELECT * FROM tmp_sales WHERE WHERE drug_info.drug_id = :drug_id = :WHERE drug_info.drug_id = :drug_id && username = :username";
            $stmt = $this->conn->prepare($tmp_sql);

            if ($stmt->execute([
                'drug_id' => $drug_id,
                'username' => $username
            ])) {
                
                if ($stmt->rowCount() > 0) {
                    
                    if ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($rows);
                        $sales_type = $sale_type;
                        $present_quantity = $qantity;

                        switch ($sales_type) {

                            case 'Pack':
                                $stmt = $this->conn->prepare($sql_select_pack);

                                if ($stmt->execute([
                                    'drug_id' => $drug_id
                                ])) {

                                    if ($stmt->rowCount() > 0) {
                                        
                                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            extract($data);
                                            $store_available = $available_pack;
                                            $price = $pack;

                                            if ($present_quantity <= $store_available) {
                                                
                                                $new_quantity = $present_quantity - 1;
                                                $total = $new_quantity * $price;

                                                $update_sql = "UPDATE tmp_sales SET qantity = :qantity, unit_price = :unit_price , 
                                                total = :total WHERE drug_id = :drug_id && username = :username";
                                                $stmt = $this->conn->prepare($update_sql);

                                                if ($stmt->execute([
                                                    'qantity' => $new_quantity,
                                                    'unit_price' => $price,
                                                    'total' => $total,
                                                    'drug_id' => $drug_id,
                                                    'username' => $username
                                                ])) {

                                                    $this->getTmp_Sales($username);

                                                } else {
                                                    
                                                    $this->response['status'] = true;
                                                    $this->response['message'] = "Oops!! Sorry Update failed";
                                                }
                                                
                                            } 
                                            else {
                                                
                                                $this->response['status'] = true;
                                                $this->response['message'] = "Oops!! Sorry Available item in Store $store_available";
                                            }
                                            
                                        }
                                    } 
                                    else {
                                        
                                        $this->response['status'] = true;
                                        $this->response['message'] = "No result Found in Pack";
                                    }
                                    
                                } else {
                                    
                                    $this->response['status'] = true;
                                    $this->response['message'] = "Pack query failed". $this->conn->getMessage();
                                }
                                
                                break;

                                case 'Satchet':
                                    $stmt = $this->conn->prepare($sql_select_sat);
    
                                    if ($stmt->execute([
                                        'drug_iddrug_iddrug_id' => $drug_iddrug_iddrug_id
                                    ])) {
    
                                        if ($stmt->rowCount() > 0) {
                                            
                                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                extract($data);
                                                $store_available = $available_satchet;
                                                $price = $satchet;
    
                                                if ($present_quantity <= $store_available) {
                                                    
                                                $new_quantity = $present_quantity - 1;
                                                if($new_quantity < 1){
                                                    
                                                    $this->response['status'] = true;
                                                    $this->response['message'] = "Oops!! Sorry Can't Sell Less than 1". $this->conn->getMessage();
                                                }
                                                else {
                                                    $total = $new_quantity * $price;

                                                    $update_sql = "UPDATE tmp_sales SET qantity = :qantity, unit_price = :price , 
                                                    total = :total WHERE drug_iddrug_id = :drug_iddrug_id && username = :username";
                                                    $stmt = $this->conn->prepare($update_sql);
                                                    if ($stmt->execute(
                                                        [
                                                            'qantity' => $qantity,
                                                            'unit_price' => $price,
                                                            'total' => $total,
                                                            'drug_iddrug_id' => $drug_iddrug_id,
                                                            'username' => $username
                                                        ]

                                                    )) {
    
                                                        $this->getTmp_Sales($username);
    
    
                                                    } else {
                                                        
                                                        
                                                        $this->response['status'] = true;
                                                        $this->response['message'] = "Oops!! Sorry Update failed". $this->conn->getMessage();
    
                                                    }
                                                }
                                                
                                                    
                                                } 
                                                else {
                                                    
                                                    $this->response['status'] = true;
                                                    $this->response['message'] = "Oops!! Sorry Available item in Store $store_available ";
                                                }
                                                
                                            }
                                        } 
                                        else {
                                            
                                            $this->response['status'] = true;
                                            $this->response['message'] = "No result Found in Pack". $this->conn->getMessage();
                                        }
                                        
                                    } else {
                                        
                                        $this->response['status'] = true;
                                        $this->response['message'] = "Pack query failed". $this->conn->getMessage();
                                    }
                                    
                                    break;

                                    case 'Tabs':
                                        $sql_tabs = $this->conn->prepare($sql_select_tabs);
                                        
                                        if ($stmt->execute([
                                            'drug_name' => $drug_name
                                        ])) {
        
                                            if ($stmt->rowCount() > 0) {
                                                
                                                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                    
                                                    $store_available = $available_tabs;
                                                    $price = $tabs;
        
                                                    if ($present_quantity <= $store_available) {
                                                        
                                                        $new_quantity = $present_quantity - 1;
                                                        $total = $new_quantity * $price;
        
                                                        $update_sql = "UPDATE tmp_sales SET qantity = '$new_quantity', unit_price = '$price' ,
                                                        total = '$total' WHERE drug_id = '$drug_id' && username = '$username'";
                                                        $stmt = $this->conn->prepare($update_sql);
                                                        if ($stmt->execute([
                                                            'qantity' => $qantity,
                                                            'unit_price' => $price,
                                                            'total' => $total,
                                                            'drug_id' => $drug_id,
                                                            'username' => $username
                                                        ])) {
        
                                                            $this->getTmp_Sales($username);
        
                                                        } else {
                                                            
                                                            $this->response['status'] = true;
                                                            $this->response['message'] = "Oops!! Sorry Update failed". $this->conn->getMessage();
                                                        }
                                                        
                                                    } 
                                                    else {
                                                        
                                                        $this->response['status'] = true;
                                                        $this->response['message'] = "Oops!! Sorry Available item in Store $store_available ". $this->conn->getMessage();
                                                    }
                                                    
                                                }
                                            } 
                                            else {
                                                
                                                $this->response['status'] = true;
                                                $this->response['message'] = "No result Found in Pack". $this->conn->getMessage();
                                            }
                                            
                                        } else {
                                            
                                            $this->response['status'] = true;
                                            $this->response['message'] = "Pack query failed". $this->conn->getMessage();
                                        }
                                        
                                        break;
                            
                            default:
                                
                                
                                $this->response['status'] = true;
                                $this->response['message'] = "Oops!! Sale Type NOT Selected". $this->conn->getMessage();
                                $this->getTmp_Sales($username);
                                exit(); 
                                break;
                        }
                    }
                } 
                else {
                    
                $this->response['status'] = true;
                $this->response['message'] = "No result Found ". $this->conn->getMessage();
                }
                
            } 
            else {
               
                $this->response['status'] = true;
                $this->response['message'] = "Select Query Failed". $this->conn->getMessage();
            }
            


           return json_encode($this->response); 
    }
    /* Update Sales type */
    public function updateSalesType($username,$drug_id,$type,$quantity){

        /* Update Sales Quantity and Price  */
        $update_sql = "UPDATE
            tmp_sales
        SET
            sale_type = :type
        WHERE
            drug_id = :drug_id && username = :username";
        $stmt = $this->conn->prepare($update_sql);
        if ($stmt->execute([
            'type' => $type,
            'drug_id' => $drug_id,
            'username' => $username
        ])) {
            
            $this->response['status'] = false;
            $this->response['message'] = "Sales Type Updated";
            $this->addQuantity($username,$drug_id,$quantity);
        } else {
            
            $this->response['status'] = true;
            $this->response['message'] = "Adding Update Failed". $this->conn->getMessage();
        }

        return json_encode($this->response);
        
    }
    /* Delete From Cart */
    public function deleteFromCart($username,$drug_id){

        $del_sql = "DELETE FROM tmp_sales WHERE drug_id = :drug_id && username = :username";
        $stmt = $this->conn->prepare($del_sql);
        if ($stmt->execute([
            'drug_id' => $drug_id,
            'username' =>$username
        ])) {
           
            $this->getTmp_Sales($username);
            
            
        } else {
            
            $this->response['status'] = true;
            $this->response['message'] = "Removing items from cart Failed". $this->conn->getMessage();
        }
        return json_encode($this->response);
    }
    
    public function saveSale($username){
        
        $date = date('d-M-Y H:i:s');
        $invoice = 0;
        
        /* SELECT from tmp_sales */
        $select_sql = "SELECT * FROM tmp_sales WHERE username = :username";
        $stmt = $this->conn->prepare($select_sql);

        if($stmt->execute(['username' => $username])){
            
            if($stmt->rowCount() > 0){

                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($data);
                    if($qantity > 0){
                        $this->response['status'] = false;
                        $this->response['message'] = $this->updateItemSales($username);
                    }
                    else{
                        $this->response['status'] = true;
                        $this->response['message'] = "Can't Render Zero(0) Item, Add Qauntity";
                    }
                    
                }
            }
            else {
                
                $this->response['status'] = true;
                $this->response['message'] = "Error No Sales Found...";
            }
        }
        else{
            
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting Sales". $this->conn->getMessage();
        }

        return json_encode($this->response);
    }
    /* save treatment */
    public function saveTreatment($username,$product,$treatment,$cost){
        $cost = htmlspecialchars(strip_tags($cost));
        $username = htmlspecialchars(strip_tags($username));
        $treatment = htmlspecialchars(strip_tags($treatment));
        $product = htmlspecialchars(strip_tags($product));

        if(empty($cost) || empty($username) || empty($treatment) || empty($product)){

            $this->response['status'] = true;
            $this->response['message'] = "Form Input Field Empty";
        }   
        else{
            /* INSERT INTO SALES */
            $date = date('d/M/Y');
            $invoice = rand(10000,1000000);
            $sql = "INSERT INTO sales_record(
                drug_id,
                sold_by,
                quantity,
                drug_name,
                sold_price,
                date_time,
                invoice
            )
            VALUES(
                :drug_id,
                :sold_by,
                :quantity,
                :drug_name,
                :sold_price,
                :date_time,
                :invoice
            );";
            $stmt = $this->conn->prepare($sql);
            if($stmt->execute([
                'drug_id' => $product,
                'sold_by' => $username,
                'quantity' => 1,
                'drug_name' => $treatment,
                'sold_price' => $cost,
                'date_time' => $date,
                'invoice' => $invoice
            ])){
                $this->response['status'] = false;
                $this->response['message'] = "Treatment Saved";
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "Treatment Not Saved";
            }
        }
        return json_encode($this->response);
    }
    public function getDrugName(){

        $sql = "SELECT * FROM drug_info";
        $stmt  = $this->conn->prepare($sql);
        $drug_name['data'] = array();
        if($stmt->execute()){

            if ($stmt->rowCount() > 0) {
                
                while($drug_name = $stmt->fetch(PDO::FETCH_ASSOC)){
                    
                    $data = array(
                        'drug_name' => $drug_name['drug_name'],
                        'drug_id' => $drug_name['drug_id']
                    );
                    array_push($drug_name['data'],$data);
                    //echo "<option value = ".$drug_name['drug_name'].">".$drug_name['drug_name']." ".$drug_name['composition']."<option>";
                }
                return json_encode($drug_name['data']);
            } else {
                
                    $this->response['status'] = true;
                    $this->response['message'] = "No Drugs found". $this->conn->getMessage();
                    exit();
            }
            
        }
        else{
            
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting Drugs". $this->conn->getMessage();
            exit();
        }
    }

    public function getNotification(){

        $sql_select = "SELECT drug_info.drug_id,drug_info.drug_name,production_info.exp_date,production_info.mfg_date,formation_drug.available_quantity FROM drug_info
        JOIN production_info ON drug_info.drug_id = production_info.drug_id JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id";

        $stmt = $this->conn->prepare($sql_select);
        $num = 0;
        if ($stmt->execute()) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($data);
                    if (date('Y-m-d') >= $exp_date || $available_quantity < 50) {
                        
                        $num++;
                        
                    } 
                    else{
                       $num;
                    }
                }
                
            } else {
                
                $num;
            }
            
        } else {
            
        }

        return $num;
        
    }

    public function doseCalculator($drug_id,$duration,$length,$times){

        if ($length > 0) {
            $sql_select = "SELECT drug_info.drug_id,formation_drug.available_quantity,formation_drug.qauntity_tabs_pack FROM drug_info
        JOIN formation_drug ON drug_info.drug_iddrug_id = formation_drug.drug_iddrug_id WHERE drug_info.drug_iddrug_id = :drug_id";

        $requires_pack = 0;
        $requires_tab= 0;
        $requires_sat = 0;

        $admin_quantity = 0;

        $stmt = $this->conn->prepare($sql_select);
        if ($stmt->execute(['drug_id' => $drug_id])) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($data);
                    switch ($duration) {
                        case 'Days':
                            
                            $admin_quantity = $length * $times;
                            $requires_sat = $admin_quantity/$qauntity_tabs_pack;
                            $this->requires = $admin_quantity;
                            
                            $this->response['status'] = false;
                            $this->response['message'] = round($requires_sat);
                            break;

                            case 'Month':
                                $day = 31*$length;
                                $admin_quantity = $day * $times;
                                $requires_sat = $admin_quantity/$qauntity_tabs_pack;
                                echo "<strong> ".round($requires_sat)."</strong>";
                                $this->requires = $admin_quantity;

                                $this->response['status'] = false;
                                $this->response['message'] = round($requires_sat);
                                break;

                            case 'Weeks':
                                $day = 7*$length;
                                $admin_quantity = $day * $times;
                                $requires_sat = $admin_quantity/$qauntity_tabs_pack;
                                $this->requires = $admin_quantity;
                                
                                $this->response['status'] = false;
                                $this->response['message'] = round($requires_sat);
                                break;
                        
                        default:
                            # code...
                            break;
                    }
                }
            } 
            else {
                
                $this->response['status'] = true;
                $this->response['message'] ="No Drug Found". $stmt->getMessage();
            }
            
        } 
        else {
            
            $this->response['status'] = true;
            $this->response['message'] ="Error in Selecting Drugs". $stmt->getMessage();
        }
        } 
        else {
            
            $this->response['status'] = true;
            $this->response['message'] ="Length is short should grater than 0". $stmt->getMessage();
        }
        
        
        return json_encode($this->response);
    }
    public function requiredDose(){

        echo $this->requires;
    }

    /* Search for item */

    public function searchItem($data){
        $medication['data'] = array();
        $search_sql = "SELECT drug_info.drug_id,drug_info.drug_name,drug_info.composition,classification.class_name,formation_drug.form_name,treatment.treatment_type,formation_drug.available_quantity,price_drug.selling_price,drug_location.location_name FROM
        drug_info JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id JOIN price_drug ON drug_info.drug_id = price_drug.drug_id JOIN treatment
        ON drug_info.drug_id = treatment.drug_id JOIN classification ON drug_info.drug_id = classification.drug_id 
        JOIN drug_location ON drug_info.drug_id = drug_location.drug_id 
        WHERE drug_info.drug_id LIKE :item OR treatment.treatment_type LIKE :item";

        $stmt = $this->conn->prepare($search_sql);
        $item = "%$data%";
        if ($stmt->execute([
            'item' => $item
        ])) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($rsl);

                    $data = array(
                       'drug_name' => $drug_name,
                       'composition' => $composition,
                       'form_name' => $form_name,
                       'treatment_type' => $treatment_type,
                       'selling_price' => number_format($selling_price),
                       'location_name' => $location_name,
                       'drug_id' => $location_name
                    );
                    array_push($medication['data'], $data);
                    
                }
                return json_encode($medication['data']);
            } 
            else {
               
                $this->response['status'] = true;
                $this->response['message'] = "Oops!! Sorry i Can't find any of It ";
            }
            
        } 
        else {
            
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting Drugs";
        }
        
        return json_encode($this->response);
    }

    public function saveAll($username){

        $sql = "SELECT * FROM tmp_sales WHERE username = :username";
        $invoice = rand(10000,1000000);
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute(['username' => $username])) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($rsl);

                    $insert_sales = "INSERT INTO sales_record(drug_id,drug_name,sold_by,quantity,sold_price,date_time,invoice,sale_type) 
                    VALUE(:drug_id,:drug_name,:username,:qantity,:total,:date_time,:invoice,:sale_type)";
                    $stmt = $this->conn->prepare($insert_sales);
                    if ($stmt->execute([
                        'drug_id' => $drug_id,
                        'drug_name' => $drug_name,
                        'username' => $username,
                        'qantity' => $qantity,
                        'total' => $total,
                        'date_time' => $date_time,
                        'invoice' => $invoice,
                        'sale_type' => $sale_type
                    ])) {
                        
                        $this->deleteFromCart($username,$drug_id);
                        $this->saveSale($username);

                        //header("Location: ../../sales_activities/sale_item.php");
                    } 
                    else {
                        
                        $this->response['status'] = true;
                        $this->response['message'] = "Error in saving Sales ";
                    }
                    
                }
            } 
            else {
                
                $this->response['status'] = true;
                $this->response['message'] = "No result found";
            }
            
        } 
        else {
            
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting Drugs";
        }

        return json_encode($this->response);
        
    }
    /* REVOKE TRANSACTION */
    public function revokeTransaction($sales_id){
        $date = date('d/M/Y');
        $sql = "SELECT
                sales_record.quantity,
                sales_record.drug_id,
                sales_record.sale_type,
                formation_drug.quantity_satch_pack,
                formation_drug.qauntity_tabs_pack,
                formation_drug.available_quantity,
                formation_drug.available_tabs
            FROM
                sales_record
            JOIN formation_drug ON
                sales_record.drug_id = formation_drug.drug_id
            WHERE
                sales_record.sale_id = :sale_id ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute(['sale_id'=> $sales_id]);

        if($stmt->rowCount() > 0){

            $drug_id = "";
            $new_available_quantity = 0;
            $sale_id = 0;
            $revoked_tabs = 0;
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                
                switch ($sale_type) {
                    case 'Pack':
                        $pack_tabs = $quantity_satch_pack * $qauntity_tabs_pack;
                        $revoked_tabs = $quantity * $pack_tabs;
                        $new_available_quantity = $revoked_tabs + $available_quantity;
                        /* UPDATE FORMULATION TABLE */
                        $sql_update_formulation = "UPDATE
                            formation_drug
                                SET
                                    formation_drug.available_quantity = :available,
                                    formation_drug.available_tabs = :available
                                WHERE
                                    formation_drug.drug_id = :drug_id";

                        $stmt_update_formulation = $this->conn->prepare($sql_update_formulation);
                        if($stmt_update_formulation->execute([
                            'available' => $new_available_quantity,
                            'drug_id' => $drug_id
                        ])){

                            $sql_delete_sales = "DELETE FROM `sales_record` WHERE `sales_record`.`sale_id` = :sale_id";
                            $stmt_delete = $this->conn->prepare($sql_delete_sales);

                            if($stmt_delete->execute(['sale_id' => $sales_id])){
                                $this->response['status'] = false;
                                $this->response['message'] = "Product Revoked Successfully";
                            }

                        }
                        else{
                            $this->response['status'] = true;
                            $this->response['message'] = "Failed to Update Formulation Quantity";
                        }
                        break;
                    case 'Satchet':
                        $pack_tabs =  $qauntity_tabs_pack;
                        $revoked_tabs = $quantity * $pack_tabs;
                        $new_available_quantity = $revoked_tabs + $available_quantity;
                        /* UPDATE FORMULATION TABLE */
                        $sql_update_formulation = "UPDATE
                            formation_drug
                                SET
                                    formation_drug.available_quantity = :available,
                                    formation_drug.available_tabs = :available
                                WHERE
                                    formation_drug.drug_id = :drug_id";

                        $stmt_update_formulation = $this->conn->prepare($sql_update_formulation);
                        if($stmt_update_formulation->execute([
                            'available' => $new_available_quantity,
                            'drug_id' => $drug_id
                        ])){

                            $sql_delete_sales = "DELETE FROM `sales_record` WHERE `sales_record`.`sale_id` = :sale_id";
                            $stmt_delete = $this->conn->prepare($sql_delete_sales);

                            if($stmt_delete->execute(['sale_id' => $sales_id])){
                                $this->response['status'] = false;
                                $this->response['message'] = "Product Revoked Successfully";
                            }

                        }
                        else{
                            $this->response['status'] = true;
                            $this->response['message'] = "Failed to Update Formulation Quantity";
                        }
                        break;
                    case 'Tabs':
                        //$pack_tabs = $quantity_satch_pack * $qauntity_tabs_pack;
                        $revoked_tabs = $quantity ;
                        $new_available_quantity = $revoked_tabs + $available_quantity;
                        /* UPDATE FORMULATION TABLE */
                        $sql_update_formulation = "UPDATE
                            formation_drug
                                SET
                                    formation_drug.available_quantity = :available,
                                    formation_drug.available_tabs = :available
                                WHERE
                                    formation_drug.drug_id = :drug_id";

                        $stmt_update_formulation = $this->conn->prepare($sql_update_formulation);
                        if($stmt_update_formulation->execute([
                            'available' => $new_available_quantity,
                            'drug_id' => $drug_id
                        ])){

                            $sql_delete_sales = "DELETE FROM `sales_record` WHERE `sales_record`.`sale_id` = :sale_id";
                            $stmt_delete = $this->conn->prepare($sql_delete_sales);

                            if($stmt_delete->execute(['sale_id' => $sales_id])){
                                $this->response['status'] = false;
                                $this->response['message'] = "Product Revoked Successfully";
                            }

                        }
                        else{
                            $this->response['status'] = true;
                            $this->response['message'] = "Failed to Update Formulation Quantity";
                        }
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
            
             
        }
        else{
            $this->response['status'] = true;
            $this->response['message'] = "Product NOT Found In Sales";
        }
        return json_encode($this->response);
    }  
    /* UDPATE ITEM SALES */
    public function updateItemSales($username){
        
        $sql = "SELECT * FROM tmp_sales WHERE username = :username";
        $invoice = rand(10000,1000000);
        $drug_name = "";
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute(['username' => $username ])) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    
                    $drug_id = $data['drug_id'];

                    $select_sql = "SELECT
                            drug_info.drug_id,
                            drug_info.drug_name,
                            formation_drug.available_quantity,
                            formation_drug.available_pack,
                            formation_drug.available_satchet,
                            formation_drug.available_tabs,
                            formation_drug.quantity_satch_pack,
                            formation_drug.qauntity_tabs_pack
                        FROM
                            drug_info
                        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
                        WHERE
                            formation_drug.drug_id = :drug_id";
                                    
                    $stmt = $this->conn->prepare($select_sql);
        
                    if($stmt->execute(['drug_id' => $drug_id])){
        
                        //$this->deleteFromCart($username,$drug_name);
                        if ($stmt->rowCount() > 0) {
                                            
                            while ($rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {

                                switch ($data['sale_type']) {
        
                                    case 'Pack':
        
                                        //remaining calculations
                                        $quantity = $data['qantity'] * $rsl['quantity_satch_pack'] * $rsl['qauntity_tabs_pack'];//unit in tabs
                                        $new_available = $rsl['available_quantity'] - $quantity;//unit in tabs
                                        $available_pack = $rsl['available_pack'] - $data['qantity'];//unit in pack
                                        $remain_satchet = $data['qantity']* $rsl['quantity_satch_pack'];//unit in satchet
                                        $available_satchet = $rsl['available_satchet'] - $remain_satchet;//unit in satchet
        
                                        $update_sql = "UPDATE
                                                formation_drug
                                            SET
                                                available_quantity = :new_available,
                                                available_pack = :available_pack,
                                                available_satchet = :available_satchet,
                                                available_tabs = :new_available
                                            WHERE
                                                drug_id = :drug_id";
                                        $stmt = $this->conn->prepare($update_sql);
        
                                        if ($stmt->execute([
                                            'new_available' => $new_available,
                                            'available_pack' => $available_pack,
                                            'available_satchet' => $available_satchet,
                                            'new_available' => $new_available,
                                            'drug_id' => $drug_id

                                        ])) {
                                                            
                                            $this->saveAll($username,$drug_id);
                                            
                                            $this->response['status'] = false;
                                            $this->response['message'] = "New Sale Recorded";

                                        } else {
                                            
                                            $this->response['status'] = true;
                                            $this->response['message'] = "New Sale Record failed";
                                        }
                                                        
                                        break;
                                    case 'Satchet':
        
                                        $quantity = $data['qantity'] * $rsl['qauntity_tabs_pack'];//unit in tabs
                                        $new_available = $rsl['available_quantity'] - $quantity;//unit in tabs
                                        $available_satchet = $rsl['available_satchet'] - $data['qantity'];//unit in satchet
                                        $available_pack =  $rsl['available_pack'] - ($data['qantity']/$rsl['quantity_satch_pack']);//unit in pack
            
                                        $update_sql = "UPDATE
                                                formation_drug
                                            SET
                                                available_quantity = :new_available,
                                                available_satchet = :available_satchet,
                                                available_tabs = :new_available,
                                                available_pack = :available_pack
                                            WHERE
                                                drug_id = :drug_id ";
                                        $stmt = $this->conn->prepare($update_sql);
            
                                        if ($stmt->execute([
                                            'new_available' => $new_available,
                                            'available_satchet' => $available_satchet,
                                            'new_available' => $new_available,
                                            'available_pack' => $available_pack,
                                            'drug_id' => $drug_id
                                        ])) {
                                                                
                                            if($this->saveAll($username,$drug_name)){

                                                $this->response['status'] = false;
                                                $this->response['message'] = "New Sale Recorded";
                                            }
                                            else{
                                                $this->response['status'] = true;
                                                $this->response['message'] = "New Sale Recorded Failed";
                                            }
                                            
                                        } else {
                                            $this->response['status'] = true;
                                            $this->response['message'] = "Update Formultion Failed";
                                        }
                                                            
                                        break;
                                    case 'Tabs':
        
        
                                        $quantity = $data['qantity'] ;
                                        $new_available = $rsl['available_quantity'] - $quantity;//unit in tabs
                                        $available_satchet = $data['qantity'] / $rsl['qauntity_tabs_pack'];//unit in satchet
                                        $available_pack = $rsl['available_pack'] - ($data['qantity']/($rsl['quantity_satch_pack'] * $rsl['qauntity_tabs_pack']));//unit in pack
                
                                        $update_sql = "UPDATE
                                                formation_drug
                                            SET
                                                available_quantity = :new_available,
                                                available_satchet = :available_satchet,
                                                available_tabs = :new_available,
                                                available_pack = :available_pack
                                            WHERE
                                                drug_id = :drug_id";
                                        $stmt = $this->conn->prepare($update_sql);
                
                                        if ($stmt->execute([
                                            'new_available' => $new_available,
                                            'available_satchet' => $available_satchet,
                                            'new_available' => $new_available,
                                            'available_pack' => $available_pack,
                                            'drug_id' => $drug_id
                                        ])) {
                                                                    
                                            $this->saveAll($username,$drug_id);
                                            $this->response['status'] = false;
                                            $this->response['message'] = "New Sale Recorded";
                           
                                        } else {
                                            $this->response['status'] = true;
                                            $this->response['message'] = "New Sale Record Failed";
                                        }
                                                                
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            }
        
                        } else {
                            $this->response['status'] = true;
                            $this->response['message'] = "Not Found in Store";
                        }
                                        
                    }
                    else{
                        
                    $this->response['status'] = true;
                    $this->response['message'] = "Select Formation failed in Sales";
                    
                    } 
                    
                }
            } 
            else {
                $this->response['status'] = true;
                $this->response['message'] = "Not Found";
            }
            
        } 
        else {
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting";
        }

        return json_encode($this->response);
    }

    /* Get all sold products */
    public function getSales(){
        
        $sn = 0;
       
        $sales['data'] = array();
        $sql_sales = "SELECT * FROM sales_record ORDER BY date_time  DESC ";
        $stmt = $this->conn->prepare($sql_sales);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            
            while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($data_rsl);
                ++$sn;
                $data = array(
                    'sn' => $sn,
                    'sold_by' => $sold_by,
                    'drug_name' => $drug_name,
                    'date_time' => $date_time,
                    'sold_price' => $sold_price,
                    'quantity' => $quantity,
                    'invoice' => $invoice,
                    'sale_type' => $sale_type,
                    'sale_id' => $sale_id,
                    'drug_id' => $drug_id
                );
                
                array_push($sales['data'],$data);
            }
            return json_encode($sales['data']);
        } else {
            
            $this->response['status'] = true;
            $this->response['message'] = "Error No Result Sales Found ";

            return json_encode($this->response);
        }
        
    }
    /* GET SALES INDVIDAUL USERS */
    public function getSalesIndividual($username){
        
        $sn = 0;
        $date = date('d/M/Y');
        $sales['data'] = array();
        $sql_sales = "SELECT * FROM sales_record WHERE sales_record.sold_by = :username AND sales_record.date_time = :date_time ORDER BY date_time  DESC ";
        $stmt = $this->conn->prepare($sql_sales);
        $stmt->execute(['username' => $username, 'date_time' => $date]);
        if ($stmt->rowCount() > 0) {
            
            while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($data_rsl);
                ++$sn;
                $data = array(
                    'sn' => $sn,
                    'sold_by' => $sold_by,
                    'drug_name' => $drug_name,
                    'date_time' => $date_time,
                    'sold_price' => $sold_price,
                    'quantity' => $quantity,
                    'invoice' => $invoice,
                    'sale_type' => $sale_type,
                    'sale_id' => $sale_id,
                    'drug_id' => $drug_id
                );
                
                array_push($sales['data'],$data);
            }
            return json_encode($sales['data']);
        } else {
            
            return json_encode(null);
        }
    }
    /* Search sales from sales records */
    public function searchSales($search){
    $sn = 0;
    $search_sales['data'] = array();
    $search_sql = "SELECT * FROM sales_record WHERE invoice = :search";
    $stmt = $this->conn->prepare($search_sql);
    $stmt->execute(['search' => $search]); 
    if($stmt->rowCount() > 0){
        while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ++$sn;
            extract($data_rsl);
            $data = array(
                'sn' => $sn,
                'sold_by' => $sold_by,
                'drug_name' => $drug_name,
                'date_time' => $date_time,
                'sold_price' => $sold_price,
                'quantity' => $quantity,
                'invoice' => $invoice
            );
            
            array_push($search_sales['data'], $data);
        }
        return json_encode($search_sales['data']);
    }
    else {
        
            $this->response['status'] = true;
            $this->response['message'] = "Error No Result Sales Found";

            return json_encode($this->response);
    }
    } 
    /* Search Expirec products */
    public function searchExpired($search){
    $sn = 0;
    $search_sql = "SELECT production_info.drug_name,production_info.exp_date,formation_drug.available_quantity FROM production_info
    JOIN formation_drug ON production_info.drug_name = formation_drug.drug_name WHERE production_info.drug_name LIKE '%$search%'";
    $result = mysqli_query($this->conn,$search_sql);

    if(mysqli_num_rows($result) > 0){
        while ($data_rsl = mysqli_fetch_assoc($result)) {
            ++$sn;
            echo "
            <tr>
            <td scope='row'>$sn</td>
            <td>$data_rsl[drug_name]</td>
            <td>$data_rsl[exp_date]</td>
            <td>$data_rsl[available_quantity]</td>
            </tr>
            ";
        }
    }
    else {
        echo "<div class='alert alert-danger text-center' role='alert'>
            <strong>Error No Result Sales Found ".mysqli_error($this->conn)."</strong> 
            </div>";
    }
    } 
    
    /* Increase sales Percentage */

    public function increasePercentage($percentage){
        
    $new_percentage = $percentage/100;
    $this->salling_perc = $new_percentage;

    }
    /* List all expired products in store */
    public function listExpiredProducts(){
    $expired_product['data'] = array();
    $date = date('Y-m-d');
    $select_sql = "SELECT production_info.drug_name,production_info.exp_date,production_info.mfg_date,formation_drug.available_quantity
    FROM production_info join formation_drug on production_info.drug_name = formation_drug.drug_name WHERE :date >= production_info.exp_date  ";

    $stmt = $this->conn->prepare($select_sql);
        $num = 0;
        if ($stmt->execute(['date' => $date])) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    
                   extract($data);
                    $num++;
                    $data = array(
                        'num' => $num,
                        'drug_name' => $drug_name,
                        'available_quantity' => $available_quantity
                    );
                    
                    array_push($expired_product['data'],$data);
                }
                return json_encode($expired_product['data']);
                
            } else {
               
                $this->response['status'] = true;
                $this->response['message'] = "No Expired Product ";
    
            }
            
        } else {
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting";

            return json_encode($this->response);
        }
    }
    /* Expired items num */
    public function listExpiredProductsInt(){
        
        $date = date('Y-m-d');
        $select_sql = "SELECT production_info.drug_name,production_info.exp_date,production_info.mfg_date,formation_drug.available_quantity
        FROM production_info join formation_drug on production_info.drug_name = formation_drug.drug_name WHERE :date >= production_info.exp_date  ";
    
        $stmt = $this->conn->prepare($select_sql);
            $num = 0;
            if ($stmt->execute(['date' => $date])) {
                
                $num = $stmt->rowCount();
                
            } else {
                $this->response['status'] = true;
                $this->response['message'] = "Error in Selecting";
    
                return json_encode($num);
            }
        }
    /* List all running out products instore */

    public function listRunningOutProducts(){

        $select_sql = "SELECT
            formation_drug.available_quantity,
            formation_drug.drug_name,
            formation_drug.form_name,
            drug_info.drug_name,
            drug_info.drug_chem_name
        FROM
            formation_drug
        JOIN drug_info ON drug_info.drug_id = formation_drug.drug_id
        WHERE
            formation_drug.available_quantity < 2 ";

        $ruuning_out['data'] = array();
        $stmt = $this->conn->prepare($select_sql);
        $num = 0;
        if ($stmt->execute()) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($data);
                    $num++;
                    $data = array(
                        'num' => $num,
                        'drug_name' => $drug_name,
                        'drug_chem_name' => $drug_chem_name,
                        'available_quantity' => $available_quantity
                    );
                    array_push($ruuning_out['data'], $data);
                    
                }
                return json_encode($ruuning_out['data']);
                
            } else {
            
                $this->response['status'] = true;
                $this->response['message'] = "No Running Out Products";
            }
            
        } else {
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting";
            return json_encode($this->response);
        }
        
    }
    /* List all running out products instore */

    public function listRunningOutProductsInt(){

        $select_sql = "SELECT formation_drug.available_quantity,formation_drug.drug_name,formation_drug.form_name FROM formation_drug
        where formation_drug.available_quantity < 2 ";
        $ruuning_out['data'] = array();
        $stmt = $this->conn->prepare($select_sql);
        $num = 0;
        if ($stmt->execute()) {
            $num = $stmt->rowCount();
            
            return $num;

        } else {
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting";
            return json_encode($this->response);
        }
        
    }
    /* get daily earings */
    public function getdailyEarning(){
    
        $totalEarning = 0;

        $date = date('d/M/Y');
        
        $sql = "SELECT * FROM sales_record WHERE date_time = :date";

        $stmt = $this->conn->prepare($sql);
        
        if($stmt->execute(['date' => $date])){
            
            if ($stmt->rowCount() > 0) {

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                    extract($row);
                    $totalEarning += $sold_price;
                }
                
            }
        
            else {
            $totalEarning = 0;
            }
        }
            return $totalEarning;
    }
    /* get Monthly Earning */
    public function getMonthlyEarning(){
        $today = date("d/M/Y");
        $totalEarningmonth = 0;

        $sql = "SELECT * FROM sales_record ";

        $stmt = $this->conn->prepare($sql);
        
        if($stmt->execute()){

            if ($stmt->rowCount() > 0) {
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);

                    $month = substr($date_time,3,3);
                    $year = substr($date_time,7,4);
                    
                    if(in_array($month, explode("/",$today)) && in_array($year, explode("/",$today))){

                        $totalEarningmonth += $sold_price; 
                    }
                    
                }
            }
        
            else {
            $totalEarningmonth = 0;
            }
        }
            return $totalEarningmonth;
       
    }
    /* get yearly Earning */
    public function getYearlyEarning(){
        $today = date("d/M/Y");
        $totalEarningyearly = 0;

        $sql = "SELECT * FROM sales_record ";

        $stmt = $this->conn->prepare($sql);
        
        if($stmt->execute()){

            if ($stmt->rowCount() > 0) {
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);

                    $year = substr($date_time,7,4);
                    
                    if(in_array($year, explode("/",$today))){

                        $totalEarningyearly += $sold_price; 
                    }
                    
                }
            }
        
            else {
            $totalEarningyearly = 0;
            }
        }
            return $totalEarningyearly;
    }
    /* GET BUSINESS MATRIC LOGIC */
    public function businessMatric(){
        $today = date("d/M/Y");
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        $income = 0;
        $earning['data'] = array();
        $new_month = "";
        $year = substr($today ,7,4);
        foreach ($months as $key => $monthConst) {

            $new_month = "%".$monthConst."%";
            $new_year = "%".$year."%";

            $sql = "SELECT
                SUM(sales_record.sold_price) AS total_sales,
                sales_record.date_time
            FROM
                sales_record
            WHERE
                sales_record.date_time LIKE :month_check 
                AND sales_record.date_time LIKE :year_check";

            $stmt = $this->conn->prepare($sql);
        
            if($stmt->execute([
                'month_check' => $new_month,
                'year_check' => $new_year
            ])){
    
                if ($stmt->rowCount() > 0) {
                    
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        $income = $total_sales;

                        if($income != null){
                            $data = array(
                                'month' => $monthConst,
                                'earning' =>$income
                            );
                        }
                        else{
                            $data = array(
                                'month' => $monthConst,
                                'earning' =>0
                            );
                        }

                        array_push($earning['data'],$data);
                    }
                }
                else{
                    $data = array(
                        'month' => $monthConst,
                        'earning' => 0
                    );
                    array_push($earning['data'],$data);
                }
            }
        }
        
        echo json_encode($earning['data']);

    }
    /* GENERATE MONTHLY REPORT */
    public function monthly_report($month, $income){
        $earning['data'] = array();

        $data = array(
            'month' => $month,
            'earning' => $income
        );

        array_push($earning['data'],$data);

        echo json_encode($earning['data']);
    }
    /* view Selected drug information  */
    public function viewSelectedItem($drug){
    $selected_item['data'] = array();
    $sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.composition,
            classification.class_name,
            formation_drug.form_name,
            treatment.treatment_type,
            treatment.priority,
            price_drug.selling_price,
            price_drug.satchet,
            drug_target.dtarget,
            drug_manufacture.manufacturer_name
        FROM
            drug_info
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN drug_target ON drug_info.drug_id = drug_target.drug_name
        JOIN drug_manufacture ON drug_info.drug_id = drug_manufacture.drug_id
        WHERE
            drug_info.drug_id = :drug";

    $stmt = $this->conn->prepare($sql);
    if($stmt->execute(['drug' => $drug])){

    if ($stmt->rowCount() > 0) {
        while($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($data_rsl);
            $data = array(
                'drug_name' => $drug_name,
                'drug_id' => $drug_id,
                'composition' => $composition,
                'class_name' => $class_name,
                'form_name' => $form_name,
                'treatment_type' => $treatment_type,
                'priority' => $priority,
                'selling_price' => number_format($selling_price),
                'dtarget' => $dtarget
            );

            array_push($selected_item['data'], $data);
            
        }
        return json_encode($selected_item['data']);
    } else {
        $this->response['status'] = true;
        $this->response['message'] = "No Result Found";
       
    }
    

    }
    else{
        $this->response['status'] = true;
        $this->response['message'] = "Error in Selecting";
        return json_encode($this->response);
    }
}
/* delete item Permently from store */
public function deleteFromStore($name){
    
    $sql_class = "DELETE FROM classification WHERE drug_id = :data_name";
    $sql_target = "DELETE FROM drug_target WHERE drug_id = :data_name";
    $sql_manufacture = "DELETE FROM drug_manufacture WHERE drug_id = :data_name";
    $sql_location = "DELETE FROM drug_location WHERE drug_id = :data_name";
    $sql_formation = "DELETE FROM formation_drug WHERE drug_id = :data_name";
    $sql_price = "DELETE FROM price_drug WHERE drug_id = :data_name";
    $sql_treatment = "DELETE FROM treatment WHERE drug_id = :data_name";
    $sql_production = "DELETE FROM production_info WHERE drug_id = :data_name";
    $sql_info = "DELETE FROM drug_info WHERE drug_id = :data_name";
    $stmt = $this->conn->prepare($sql_class);
    if ($stmt->execute(['data_name' => $name])) {
        $stmt = $this->conn->prepare($sql_target);
        if ($stmt->execute(['data_name' => $name])) {
            $stmt = $this->conn->prepare($sql_manufacture);
            if ($stmt->execute(['data_name' => $name])) {
                $stmt = $this->conn->prepare($sql_location);
                if ($stmt->execute(['data_name' => $name])) {
                    $stmt = $this->conn->prepare($sql_formation);
                    if ($stmt->execute(['data_name' => $name])) {
                        $stmt = $this->conn->prepare($sql_price);
                        if ($stmt->execute(['data_name' => $name])) {
                            $stmt = $this->conn->prepare($sql_treatment);
                            if ($stmt->execute(['data_name' => $name])) {
                                $stmt = $this->conn->prepare($sql_production);
                                if ($stmt->execute(['data_name' => $name])) {
                                    $stmt = $this->conn->prepare($sql_info);
                                    if ($stmt->execute(['data_name' => $name])) {
                          
                                        $this->response['status'] = false;
                                        $this->response['message'] = "Item Deleted ";
                                        
                                    } else {
                                        
                                        $this->response['status'] = true;
                                        $this->response['message'] = "Error in Delete Query Information";
                                    }
                                    
                                } else {
                                    
                                    $this->response['status'] = true;
                                    $this->response['message'] = "Error in Delete Query Productionn";
                                }
                                
                            } else {
                                
                                $this->response['status'] = true;
                                $this->response['message'] = "Error in Delete Query Treatment";
                            }
                            
                        } else {
                            
                            $this->response['status'] = true;
                            $this->response['message'] = "Error in Delete Query price";
                        }
                        
                    } else {
                        
                        $this->response['status'] = true;
                        $this->response['message'] = "Error in Delete Query Formation";
                    }
                    
                } else {
                    
                    $this->response['status'] = true;
                    $this->response['message'] = "Error in Delete Query Location ";
                }
                
            } else {
                
                $this->response['status'] = true;
                $this->response['message'] = "Error in Delete Query Manufacture";
            }
            
        } else {
            
            $this->response['status'] = true;
            $this->response['message'] = "Error in Delete Query Target";
        }
        
    } else {
        
        $this->response['status'] = true;
        $this->response['message'] = "Error in Delete Query Class";
    }

    return json_encode($this->response);
    
}
/*get Item to deit information  */

public function itemInformation($name){
    
    $sql = "SELECT
            drug_info.drug_id,
            drug_info.drug_name,
            drug_info.composition,
            drug_info.drug_chem_name,
            drug_location.location_name,
            drug_manufacture.manufacturer_name,
            drug_manufacture.manufacturer_addrss,
            drug_manufacture.manufacturer_phone,
            drug_manufacture.manufacturer_email,
            drug_target.dtarget,
            classification.class_name,
            formation_drug.form_name,
            formation_drug.quantity_satch_pack,
            formation_drug.qauntity_tabs_pack,
            formation_drug.quantity_supp,
            formation_drug.date_supp,
            price_drug.supp_price,
            production_info.mfg_lic_no,
            production_info.batch_no,
            production_info.mfg_date,
            production_info.exp_date,
            production_info.nafdac_reg,
            treatment.treatment_type,
            treatment.priority
        FROM
            drug_info
        JOIN drug_location ON drug_info.drug_id = drug_location.drug_id
        JOIN drug_manufacture ON drug_info.drug_id = drug_manufacture.drug_id
        JOIN drug_target ON drug_info.drug_id = drug_target.drug_id
        JOIN classification ON drug_info.drug_id = classification.drug_id
        JOIN formation_drug ON drug_info.drug_id = formation_drug.drug_id
        JOIN price_drug ON drug_info.drug_id = price_drug.drug_id
        JOIN production_info ON drug_info.drug_id = production_info.drug_id
        JOIN treatment ON drug_info.drug_id = treatment.drug_id
        WHERE
            drug_info.drug_id = :name;
    ";

    $stmt = $this->conn->prepare($sql);
    if ($stmt->execute(['name' => $name])) {
        
        if ($stmt->rowCount() > 0) {
            
            if ($date_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($date_rsl);
                $product_info = array(
                    'drug_id' => $drug_id,
                    'drug_name' => $drug_name,
                    'composition' => $composition,
                    'drug_chem_name' => $drug_chem_name,
                    'location_name' => $location_name,
                    'manufacturer_name' => $manufacturer_name,
                    'manufacturer_addrss' => $manufacturer_addrss,
                    'manufacturer_phone' => $manufacturer_phone,
                    'manufacturer_email' => $manufacturer_email,
                    'class_name' => $class_name,
                    'form_name' => $form_name,
                    'quantity_satch_pack' => $quantity_satch_pack,
                    'qauntity_tabs_pack' => $qauntity_tabs_pack,
                    'quantity_supp' => $quantity_supp,
                    'date_supp' => $date_supp,
                    'supp_price' => $supp_price,
                    'mfg_lic_no' => $mfg_lic_no,
                    'batch_no' => $batch_no,
                    'mfg_date' => $mfg_date,
                    'exp_date' => $exp_date,
                    'nafdac_reg' => $nafdac_reg,
                    'treatment_type' => $treatment_type,
                    'priority' => $priority
                );
            }
            return json_encode($product_info);
        } else {
            
            $this->response['status'] = true;
            $this->response['message'] = "Error No Result Found ";
        }
        
    } else {
        
        $this->response['status'] = true;
        $this->response['message'] = "Error in Selecting Query";
        return json_encode($this->response);
    }

    
}
/* update item info */
public function itemInfoUpdate($name,$composition,$drug_chem_name,$drug_id){

    $sql_update = "UPDATE drug_info SET drug_name = :name, composition = :composition, 
    drug_chem_name = :drug_chem_name WHERE drug_id = :drug_id";
    $stmt = $this->conn->prepare($sql_update);

    if(empty($name)||empty($composition)||empty($drug_chem_name)){
        $this->response['status'] = true;
        $this->response['message'] = "Empty Fields";
    }
    else{
        if ($stmt->execute([
            'drug_id' => $drug_id,
            'composition' => $composition,
            'drug_chem_name' => $drug_chem_name,
            'name' => $name
        ])) {
            $this->response['status'] = false;
            $this->response['message'] ="Updated";
        } else {
            $this->response['status'] = true;
            $this->response['message'] ="Failed";
        }
    }
    return json_encode($this->response);
}
/* update class info */
public function itemclassUpdate($name,$class_name){
    
    $sql_update = "UPDATE classification SET class_name = :class_name WHERE drug_id = :name";
    
    $stmt = $this->conn->prepare($sql_update);

    if(empty($name)){
        $this->response['status'] = true;
        $this->response['message'] = "Empty Fields";
    }
    else{
        if ($stmt->execute([
            'name' => $name,
            'class_name' => $class_name
            
        ])) {
            $this->response['status'] = false;
            $this->response['message'] ="Updated";
        } else {
            $this->response['status'] = true;
            $this->response['message'] ="Failed";
        }
    }
    return json_encode($this->response);
}
/* update formation info */
public function itemFormationUpdate($name,$satchet,$tab,$supp,$form_name){
    $sql_select = "SELECT * FROM formation_drug WHERE drug_id = :name";
    $stmt = $this->conn->prepare($sql_select);
    
    if (!$stmt->execute(['name' => $name ])) {
        # code...
    } else {
        if ($stmt->rowCount() > 0) {
            
            while($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)){

                $new_qty = $supp;

                $available_quantity = ($satchet * $tab * $new_qty) + $data_rsl['available_quantity'];
                $available_satchet = ($available_quantity/$tab) + $data_rsl['available_satchet'];
                $available_pack = ($available_satchet/$satchet) + $data_rsl['available_satchet'];

                $date_supp = date('d-M-Y');

                $sql_update = "UPDATE
                    formation_drug
                SET
                    form_name = :form_name,
                    quantity_satch_pack = :satchet,
                    qauntity_tabs_pack = :tab,
                    quantity_supp = :new_qty,
                    available_quantity = :available_quantity,
                    available_pack = :available_pack,
                    available_satchet = :available_satchet,
                    available_tabs = :available_quantity
                WHERE
                    drug_id = :name";
                
                if(empty($name)){
                    
                    $this->response['status'] = true;
                    $this->response['message'] ="Form Empty";
                }
                else{
                    $stmt = $this->conn->prepare($sql_update);
                    if ($stmt->execute([
                        'form_name' => $form_name,
                        'satchet' => $satchet,
                        'tab' => $tab,
                        'new_qty' => $new_qty,
                        'available_quantity' => $available_quantity,
                        'available_pack' => $available_pack,
                        'available_satchet' => $available_satchet,
                        'available_quantity' => $available_quantity,
                        'name' => $name
                    ])) {
                        $this->response['status'] = false;
                        $this->response['message'] ="Updated";
                    } else {
                        
                    }
                }
            }
        } else {
            
        }
        
    }
    return json_encode($this->response);
    
}
/* update price info */
public function itemPriceUpdate($name,$price,$percent){
    $new_name = "";
    $new_name = htmlspecialchars($name);
    $sql = "SELECT
    price_drug.drug_name,
    price_drug.drug_id,
    formation_drug.quantity_satch_pack,
    formation_drug.qauntity_tabs_pack
    FROM
        price_drug
    JOIN formation_drug ON price_drug.drug_id = formation_drug.drug_id
    WHERE
        price_drug.drug_id = :name_data";
    
    $stmt = $this->conn->prepare($sql);
    $new_percentage = $percent/100;
    $profit = ($price * $new_percentage) + $price;
    $price_satchet = 0;
    $price_tabs = 0;
    
    if (!$stmt->execute([
        'name_data' => $new_name
    ])) {
        # code...
    } else {
        if ($stmt->rowCount() > 0) {
            
            while ($data_rsl = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $total_tabs = $data_rsl['quantity_satch_pack'] * $data_rsl['qauntity_tabs_pack'];

                $price_satchet = $profit/$data_rsl['quantity_satch_pack'];

                $price_tabs = $profit/$total_tabs;

                $sql_update = "UPDATE
                    price_drug
                SET
                    supp_price = :price,
                    selling_price = :profit,
                    pack = :profit,
                    satchet = :price_satchet,
                    tabs = :price_tabs
                WHERE
                price_drug.drug_id = :name_data";

                $stmt = $this->conn->prepare($sql_update);
                if(empty($name)){

                    $this->response['status'] = true;
                    $this->response['message'] ="Empty Field";
                }
                else{
                    if ($stmt->execute([
                        'price' => $price,
                        'profit' => $profit,
                        'price_satchet' => $price_satchet,
                        'price_tabs' => $price_tabs,
                        'name_data' => $new_name
                    ])) {
                        $this->response['status'] = false;
                        $this->response['message'] =$new_name;
                    } else {
                        
                    }
                }
            }
        } else {
            # code...
        }
        
    }
    return json_encode($this->response);
}
/* update Production info */
public function itemProductionUpdate($name,$mfg_date,$exp_date){

    $sql_update = "UPDATE
        production_info
    SET
        mfg_date = :mfg_date,
        exp_date = :exp_date
       
    WHERE
    drug_id = :name";
    
    if(empty($name)){
        $this->response['status'] = true;
        $this->response['message'] ="Empty Form";
    }
    else{
        $stmt = $this->conn->prepare($sql_update);
        if ($stmt->execute([
            'mfg_date' => $mfg_date,
            'exp_date' => $exp_date,
            'name' => $name
        ])) {
            $this->response['status'] = false;
            $this->response['message'] =$name;
        } else {
            
        }
    }
    return json_encode($this->response);
}
/* update Manufact info */
public function itemManufactUpdate($name,$mf_name,$mf_email,$mf_contact,$mf_address){
    
    $sql_update = "UPDATE drug_manufacture SET manufacturer_name = :mf_name, 
    manufacturer_email = :mf_email,
    manufacturer_phone = :mf_contact, manufacturer_addrss = :mf_address
    WHERE drug_id = :name";
    $stmt = $this->conn->prepare($sql_update);
    if(empty($name)){
        $this->response['status'] = true;
        $this->response['message'] ="Form Empty";
    }
    else{
        if ($stmt->execute([
            'mf_name' => $mf_name,
            'mf_email' => $mf_email,
            'mf_contact' => $mf_contact,
            'mf_address' => $mf_address,
            'name' => $name
        ])) {
            $this->response['status'] = false;
            $this->response['message'] =$name;
        } else {
            $this->response['status'] = true;
            $this->response['message'] ="Update Failed";
        }
    }
    return json_encode($this->response);
}
/* update treatment info */
public function itemTreatmentUpdate($name,$type){
    
    $sql_update = "UPDATE treatment SET treatment_type = :type
    WHERE drug_id = :name";
    $stmt = $this->conn->prepare($sql_update);
    if(empty($name)){
        $this->response['status'] = true;
        $this->response['message'] ="Empty";
    }
    else{
        if ($stmt->execute([
            'type' => $type,
            'name' => $name
        ])) {
            $this->response['status'] = false;
            $this->response['message'] ="Updated";
        } else {
            $this->response['status'] = true;
            $this->response['message'] ="Update Failed";
        }
    }
    return json_encode($this->response);
}
/* update loction info */
public function itemLocationUpdate($name,$location){

    $sql_update = "UPDATE drug_location SET location_name = :location WHERE drug_id = :name";
    $stmt = $this->conn->prepare($sql_update);
    if(empty($name)){
        $this->response['status'] = true;
        $this->response['message'] ="Empty";
    }
    else{
        if ($stmt->execute([
            'location' => $location,
            'name' => $name
        ])) {
            $this->response['status'] = false;
            $this->response['message'] ="Updated";
        } else {
            $this->response['status'] = true;
            $this->response['message'] ="Update Failed";
        }
    }
    return json_encode($this->response);
}
/* update Treatment info */
public function itemTargetUpdate($name, $target){
    
    $sql_update = "UPDATE drug_target SET dtarget = :target WHERE drug_id = :name";
    $stmt = $this->conn->prepare($sql_update);
    if(empty($name)){
        $this->response['status'] = true;
        $this->response['message'] ="Empty";
    }
    else{
        if ($stmt->execute([
            'target' => $target,
            'name' => $name
        ])) {
            $this->response['status'] = false;
            $this->response['message'] ="Updated";
        } else {
            $this->response['status'] = true;
            $this->response['message'] ="Update Failed";
        }
    }
    return json_encode($this->response);
}
/* Get all Expired Products */
public function getExpiredProducts(){

    $date = date('Y-m-d');
    $expired_products['data'] = array();
    $select_sql = "SELECT
    production_info.drug_name,
    production_info.drug_id,
    production_info.exp_date,
    formation_drug.available_quantity,
    formation_drug.form_name,
    formation_drug.drug_id,
    price_drug.selling_price,
    drug_info.drug_chem_name,
    drug_info.composition
FROM
    production_info
JOIN formation_drug ON production_info.drug_id = formation_drug.drug_id
JOIN price_drug ON production_info.drug_id = price_drug.drug_id
JOIN drug_info ON drug_info.drug_id = production_info.drug_id
            WHERE
                :date >= production_info.exp_date
    ";

    $stmt = $this->conn->prepare($select_sql);
        $num = 0;
        if ($stmt->execute(['date' => $date])) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $num++;
                    extract($data);
                    $data = array(
                        'sn' => $num,
                        'drug_name' => $drug_name,
                        'drug_chem_name' => $drug_chem_name,
                        'composition' => $composition,
                        'drug_id' => $drug_id,
                        'exp_date' => $exp_date,
                        'available_quantity' => $available_quantity,
                        'form_name' => $form_name,
                        'selling_price' => $selling_price
                        
                    );
                    array_push($expired_products['data'],$data);
                }
                return json_encode($expired_products['data']);
                
            } else {
                
                $this->response['status'] = true;
                $this->response['message'] = "No Expired Product";
            }
            
        } else {
            
            $this->response['status'] = true;
            $this->response['message'] = "Error in Selecting Drugs";

            return json_encode($this->response);
        }
    }
    /* GET EXPIRED PRODUCT INT */
    public function getExpiredProductInt(){

        $date = date('Y-m-d');
        $expired_products['data'] = array();
        $select_sql = "SELECT
            production_info.drug_name,
            production_info.drug_id,
            production_info.exp_date,
            formation_drug.available_quantity,
            formation_drug.form_name,
            formation_drug.drug_id,
            price_drug.selling_price
        FROM
            production_info
        JOIN formation_drug ON production_info.drug_id = formation_drug.drug_id
        JOIN price_drug ON production_info.drug_id = price_drug.drug_id
                WHERE
                    :date >= production_info.exp_date
        ";
    
        $stmt = $this->conn->prepare($select_sql);
            
            if ($stmt->execute(['date' => $date ])) {
                
                if ($stmt->rowCount() > 0) {

                    return $stmt->rowCount();
                    
                } else {
                    
                    return 0;
                }
                
            } else {
                
                $this->response['status'] = true;
                $this->response['message'] = "Error in Selecting Drugs";
    
                return json_encode($this->response);
            }
        }
   
    /* GEt all running out products instore */
    public function getRunningOutProducts(){
        $outofstock['data'] = array();
        $select_sql = "SELECT
            formation_drug.available_quantity,
            formation_drug.drug_name,
            formation_drug.form_name,
            formation_drug.drug_id,
            drug_info.drug_chem_name,
            drug_info.composition
        FROM
            formation_drug
        JOIN drug_info ON drug_info.drug_id = formation_drug.drug_id
        WHERE
            formation_drug.available_quantity < 2
                ";

        $stmt = $this->conn->prepare($select_sql);
        $sn = 0;
        if ($stmt->execute()) {
            
            if ($stmt->rowCount() > 0) {
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sn++;
                    extract($row);

                    $data = array(
                        'sn' => $sn,
                        'drug_name' => $drug_name,
                        'drug_chem_name' => $drug_chem_name,
                        'composition' => $composition,
                        'drug_id' => $drug_id,
                        'form_name' => $form_name,
                        'available_quantity' => $available_quantity
                    );

                    array_push($outofstock['data'],$data);
                }
                
                return json_encode($outofstock['data']);
                
            } else {
                $this->response['status'] = true;
                $this->response['message'] = "NO out of Stock yet";
            }
            
        } else {
            $this->response['status'] = true;
            $this->response['message'] = "Error in SQL Syntax";

            return json_encode($this->response);
        }
        
    }
    /* GET PRODUCTION INFORMATION FROM STORE */
    public function getProductsInformation($drug_id){
        $sql = "SELECT * FROM `drug_info` WHERE drug_info.drug_id = :drug_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['drug_id' => $drug_id]);
        $products = array();
        if($stmt->rowCount() > 0){

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                return $drug_name." ".$drug_chem_name."$composition";
            }
        }
        
    }
    /* GEt all running out products INT instore */
    public function getRunningOutProductInt(){
        $outofstock['data'] = array();
        $select_sql = "SELECT
                formation_drug.available_quantity,
                formation_drug.drug_name,
                formation_drug.form_name,
                formation_drug.drug_id
            FROM
                formation_drug
            WHERE
                formation_drug.available_quantity < 2
            ";

        $stmt = $this->conn->prepare($select_sql);
        
        if ($stmt->execute()) {
            
            if ($stmt->rowCount() > 0) {
                
                return $stmt->rowCount();
                
            } else {
            
                return 0;
            }
            
        } else {
            $this->response['status'] = true;
            $this->response['message'] = "Error in SQL Syntax";

            return json_encode($this->response);
        }
        
    }
/* expense report */
public function saveExpenses($username,$expense_title,$cost){

    if(empty($username)||empty($expense_title)||empty($cost)){
        $this->response['status'] = true;
        $this->response['message'] = "Form Input is Empty";
    }
    else{
        $date = date("d-M-Y");
        $username = htmlspecialchars(strip_tags($username));
        $expense_title = ucwords(htmlspecialchars(strip_tags($expense_title)));
        $cost = htmlspecialchars(strip_tags($cost));
        $expense_id = uniqid(true);
        $sql_insert = "INSERT INTO expenses_tbl(expense_id,expense_title, cost, username,date_time)
        VALUES(:expense_id,:expense_title, :cost, :username,:date_time)";
        $stmt = $this->conn->prepare($sql_insert);

        if($stmt->execute([
            'expense_id' => $expense_id ,
            'expense_title' => $expense_title,
            'cost' => $cost,
            'username' => $username,
            'date_time' => $date
        ])){
            $this->response['status'] = false;
            $this->response['message'] = "Expense Saved Successfully";
        }
    }
    return json_encode($this->response);
}
/* pos report */
public function savePOSReport($username,$amount_dispensed,$amount_recieved){

    if(empty($username)||empty($amount_recieved)){
        $this->response['status'] = true;
        $this->response['message'] = "Form Input is Empty";
    }
    else{
        $date = date("d-M-Y");
        $username = htmlspecialchars(strip_tags($username));
        //$status = htmlspecialchars(strip_tags($status));
        $amount_dispensed = htmlspecialchars(strip_tags($amount_dispensed));
        $amount_recieved = htmlspecialchars(strip_tags($amount_recieved));

        $profit = $amount_recieved - $amount_dispensed;
        $transaction_id = uniqid(true);
        $sql_insert = "INSERT INTO pos_transactions(
            transaction_id,
            amount_dispensed,
            income,
            profit,
            username,
            date_time
    )
    VALUES(:transaction_id,
            :amount_dispensed,
            :income,
            :profit,
            :username,
            :date_time)";
        $stmt = $this->conn->prepare($sql_insert);

        if($stmt->execute([
            'transaction_id' => $transaction_id,
            'amount_dispensed' => $amount_dispensed,
            'income' => $amount_recieved,
            'profit' => $profit,
            'username' => $username,
            'date_time' => $date
        ])){
            $this->response['status'] = false;
            $this->response['message'] = "POS Saved Successfully";
        }
    }
    return json_encode($this->response);
}
/* GET ALL SALES BY USER */
public function getUserSales($username){
    $date = date("d/M/Y");
    $total_sales = 0;
    $sql = "SELECT
        sold_price
    FROM
        sales_record
    WHERE
        sold_by = :sold_by AND date_time = :date_time";
    
    $stmt = $this->conn->prepare($sql);
    if($stmt->execute([
        'sold_by'=> $username, 'date_time' => $date ] )){

            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $total_sales += $sold_price;
                }
            }
            else{
                return $total_sales = 0;
            }
    }
    return $total_sales;
}
/* GET ALL Expenses Value BY USER */
public function getUserExpensesCost($username){
    $date = date("d-M-Y");
    $total_sales = 0;
    $sql = "SELECT
        cost
    FROM
        expenses_tbl
    WHERE
        username = :username AND date_time = :date_time";
    
    $stmt = $this->conn->prepare($sql);
    if($stmt->execute([
        'username'=> $username, 'date_time' => $date ] )){

            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $total_sales += $cost;
                    
                }
            }
            else{
                return $total_sales = 0;
            }
    }
    return $total_sales;
}
/* GET ALL Expenses Value BY USER */
public function getUserExpenses($username){
    $date = date("d-M-Y");
    $expenses['data'] = array();
    $sql = "SELECT
        *
    FROM
        expenses_tbl
    WHERE
        username = :username AND date_time = :date_time";
    
    $stmt = $this->conn->prepare($sql);
    if($stmt->execute([
        'username'=> $username, 
        'date_time' => $date 
        ] )){

            if($stmt->rowCount() > 0){

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $data = array(
                        'expense_title' => $expense_title,
                        'cost' => $cost
                    );
                    array_push($expenses['data'], $data);
                }
                
            }
            else{
                $this->response['status'] = true;
                $this->response['message'] = "No Expenses";

            }
    }
    return json_encode($expenses['data']);
}
/* GET ALL SALES BY USER */
public function getUserPOS($username){
    $date = date("d-M-Y");
    $amount_dispensed = 0;
    $amount_income = 0;
    $profit = 0;
    $sql = "SELECT
        income,
        amount_dispensed,
        profit,
        status_trans
    FROM
        pos_transactions
    WHERE
        username = :username AND date_time = :date_time ";
        
    $stmt = $this->conn->prepare($sql);
    if($stmt->execute([
        'username'=> $username, 'date_time' => $date ] )){

            if($stmt->rowCount() > 0){
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    $amount_dispensed += $amount_dispensed;
                    $amount_income += $income;
                    $profit += $profit;
                    $data = array(
                        'amount_dispensed' => $amount_dispensed,
                        'amount_income' => $amount_income,
                        'profit' => $profit
                    );
                }
            }
            else{
                return  0;
            }
    }
    return json_encode($data);
}
/* get all pos/transfer report */
public function getAllPOSReport(){
    $pos_data['data'] = array();

    $sql = "SELECT * FROM pos_transactions";

    $stmt = $this->conn->prepare($sql);
    if($stmt->execute()){

        if($stmt->rowCount() > 0){
            $sn = 1;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $sn++;
                $data = array(
                    'amount_recieved' => $income,
                    'accountant' => $username,
                    'date_transaction' => $date_time,
                    'sn' => $sn
                );

                array_push($pos_data['data'],$data);
            }

            return json_encode($pos_data['data']);
        }
        else{
            $this->response['status'] = true;
            $this->response['message'] = 0;

            return json_encode($this->response);
        }
    }
}
/* get all expenses report */
public function getAllExpensesReport(){
    $pos_data['data'] = array();

    $sql = "SELECT * FROM expenses_tbl";

    $stmt = $this->conn->prepare($sql);
    if($stmt->execute()){

        if($stmt->rowCount() > 0){
            $sn = 1;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $sn++;
                $data = array(
                    'expense_title' => $expense_title,
                    'accountant' => $username,
                    'date_transaction' => $date_time,
                    'cost' => $cost,
                    'sn' => $sn
                );

                array_push($pos_data['data'],$data);
            }

            return json_encode($pos_data['data']);
        }
        else{
            $this->response['status'] = true;
            $this->response['message'] = 0;

            return json_encode($this->response);
        }
    }
}
/* GENERATE FINANCIAL REPORT */
public function financialReport($username){
    /* $date = date("d/M/Y"); */
    $amount_income = 0;
    $profit = 0;
    $amount_dispensed = 0;
    $total_credit = 0;
    $total_debit = 0;
    //get all sales
    $total_sales = $this->getUserSales($username);
    //get all expenses
    $total_expenses = $this->getUserExpensesCost($username);
    //get all pos trans
    $pos_trans = json_decode($this->getUserPOS($username));
    
    if($pos_trans != null){
        foreach ($pos_trans as $key => $value) {
            $amount_income += $value->amount_income;
            $amount_dispensed = $value->amount_dispensed;
            $profit = $profit;
        }
    }
    else{
        $total_credit =  $total_sales;
    $total_debit = $amount_dispensed + $total_expenses;
    $report_id = uniqid(true);
    $data = array(
        'total_credit' => $total_credit,
        'total_debit' => $total_debit,
        'total_sales' => $total_sales,
        'total_expenses' => $total_expenses,
        'transfer' => $amount_income
    );
    /* insert in report*/
    $sql = "INSERT INTO finanacial_report(
        report_id,
        total_credit,
        total_debit,
        net_profit,
        username
    )
    VALUES(
        :report_id,
        :total_credit,
        :total_debit,
        :net_profit,
        :username
        
    )";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
        'total_credit' => $total_credit,
        'total_debit' => $total_debit,
        'net_profit' => $total_credit - $total_debit,
        'username' => $username,
        'report_id' => $report_id
    ]);
    return json_encode($data);

    }

}
/*  View My Cart Items*/
public function viewMyCart($username){

    $sql = "SELECT * FROM tmp_sales WHERE username = '$username'";
    $result_tmp = mysqli_query($this->conn,$sql);
    
    if($result_tmp){

        if(mysqli_num_rows($result_tmp) > 0){
            $total = 0;
            echo "<table class='table table-condensed table-responsive my-3 mydataTable' id=' width='100%' cellspacing='0'>
            <thead>
                <tr>
                    <th>Name</th> 
                    <th>Quantity</th>
                    <th>Total</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tbody>";
            while ($tmp_data = mysqli_fetch_assoc($result_tmp)) {
                echo"<tr>
                <th>".$tmp_data['drug_name']."</th> 
                <th>".$tmp_data['qantity']."</th>
                <th>".number_format($tmp_data['total'])."</th>
                <th ><a href=?discount=true&sales_id=".$tmp_data['sales_id']." data-toggle='modal' data-target='#modelId'>-N</a></th>
                </tr>";
                $total += $tmp_data['total'];
            }
            echo "</tbody></table>";
            echo "<strong><h4>GRAND TOTAL        -      N".number_format($total)."</h4></strong>";
        }
        else{
            echo "<div class='alert alert-danger text-center' role='alert'>
            <strong>No Drugs in your Cart ".mysqli_error($this->conn)."</strong> 
            </div>";
        }
    }
    else{
        echo "<div class='alert alert-danger text-center' role='alert'>
            <strong>Error in Selecting Drugs ".mysqli_error($this->conn)."</strong> 
            </div>";
    }
}
}

?>