<?php
    
require __DIR__."\..\Include\config.php";
require __DIR__."\..\Include\item_class.php";

$config = new Config_db();
$db = $config->connect();
$item = new Items($db);
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['save_drug'])){
    
        $json_data = json_decode($item->addNewItem(
            $_POST['drug_name'],$_POST['composition'],$_POST['class_name'],
            $_POST['location_name'],$_POST['target'],$_POST['form_name'],$_POST['quantity_satch_pack'],
            $_POST['qauntity_tabs_pack'],$_POST['price_sup'],
            $_POST['exp_date'],$_POST['mfg_date'],$_POST['treatment_type'],
            $_POST['quantity_supp'],$_POST['supp_type'],$_POST['percentage'],$_POST['drug_chem_name']
        ));

        if($json_data != null){

            if($json_data->status == false){
                
                header("Location: ../../pharmacy/form_product.php?message=".$json_data->message."&status=".$json_data->status);
            }
            elseif($json_data->status == true){
                header("Location: ../../pharmacy/form_product.php?message=".$json_data->message."&status=".$json_data->status);
            }
        }
    }
    elseif (isset($_POST['update_product'])) {
        $json_data = json_decode($item->itemInfoUpdate(
            $_POST['drug_name'],
            $_POST['composition'],
            $_POST['drug_chem_name'],
            $_POST['drug_id']
        ));
        if($json_data != null){
            if($json_data->status == false){
                $json_data = json_decode($item->itemclassUpdate(
                    $_POST['drug_id'],
                    $_POST['class_name']
                    
                ));
                if($json_data->status == false){
                    $json_data = json_decode($item->itemFormationUpdate(
                        $_POST['drug_id'],
                        $_POST['quantity_satch_pack'],
                        $_POST['qauntity_tabs_pack'],
                        $_POST['quantity_supp'],
                        $_POST['form_name']
                        ));
                    if($json_data->status == false){
                        $json_data = json_decode($item->itemPriceUpdate(
                            $_POST['drug_id'],
                            $_POST['price_sup'],
                            $_POST['percentage']));
                        if($json_data->status == false){
                            $json_data = json_decode($item->itemProductionUpdate(
                                $_POST['drug_id'],
                                $_POST['mfg_date'],
                                $_POST['exp_date']));
                            if($json_data->status == false){
                                $json_data = json_decode($item->itemManufactUpdate(
                                    $_POST['drug_id'],
                                    "",
                                    "",
                                    "",
                                    ""));
                                if($json_data->status == false){
                                    $json_data = json_decode($item->itemTreatmentUpdate(
                                        $_POST['drug_id'],
                                        $_POST['treatment_type']));
                                    if($json_data->status == false){
                                        $json_data = json_decode($item->itemLocationUpdate(
                                            $_POST['drug_id'],
                                            $_POST['location_name']
                                            ));
                                        if($json_data->status == false){
                                            $json_data = json_decode($item->itemTargetUpdate(
                                                $_POST['drug_id'],
                                                $_POST['target']));
                                            if($json_data->status == false){
                                                header("Location: ../../pharmacy/index.php?update=Updated Successfully");
                                            }
                                        }
                                        else{
                                            echo "Error target";
                                        }
                                    }
                                    else{
                                        echo "Error location";
                                    }
                                }
                                else{
                                    echo "Error treat";
                                }
                            }
                            else{
                                echo "Error manuf";
                            }
                        }
                        else{
                            echo "Error production";
                        }
                    }
                    else{
                        echo "Error price";
                    }
                }
                else{
                    echo "Error classification";
                }
            }
            else{
                echo "Error info";
            }
        }
        
    }
    elseif(isset($_POST['upate_sale_type'])){

        $json_data = json_decode($item->updateSalesType(
            $_POST['username'],
            $_POST['drug_id'],
            $_POST['sale_type'],
            $_POST['quantity']
           ));
        if($json_data != null){
            if($json_data->status == false){
                header("Location: ../../sales/index.php");
            }
            else{
                
                header("Location: ../../sales/index.php?render_error=".$json_data->message);
            }
        } 
        else{
            echo "NULL";
        }
    }
    elseif (isset($_POST['render'])) {
        $json_data = json_decode($item->saveSale($_POST['username']));
        if($json_data != null){
            if($json_data->status == false){
                header("Location: ../../sales/index.php?status=$json_data->status&sales=".$json_data->message);
            }
            else{
                header("Location: ../../sales/index.php?status=$json_data->status&sales=".$json_data->message);
            }
        }
    }
    /* COST EXPENSES */
    elseif(isset($_POST['save_expense'])){
        $json_data = json_decode($item->saveExpenses($_POST['username'],
        $_POST['expense_title'],$_POST['cost']));
        if($json_data != null){
            if($json_data->status == false){
                header("Location: ../../sales/expenses.php?status=$json_data->status&sales=".$json_data->message);
            }
            else{
                header("Location: ../../sales/expenses.php?status=$json_data->status&sales=".$json_data->message);
            }
        }
    }
    /* pos EXPENSES */
    elseif(isset($_POST['save_expense_pos'])){
        $json_data = json_decode($item->savePOSReport($_POST['username'],
        $_POST['dispense'],$_POST['recieved']));
        if($json_data != null){
            if($json_data->status == false){
                header("Location: ../../sales/pos_transactions.php?status=$json_data->status&sales=".$json_data->message);
            }
            else{
                header("Location: ../../sales/pos_transactions.php?status=$json_data->status&sales=".$json_data->message);
            }
        }
    }
    /* save treatment */
    elseif(isset($_POST['save_treatment'])){
        $json_data = json_decode($item->saveTreatment($_POST['username'],
        $_POST['drug_id'], $_POST['treatment'],$_POST['cost']));
        if($json_data != null){
            if($json_data->status == false){
                header("Location: ../../sales/index.php?status=$json_data->status&sales=".$json_data->message);
            }
            else{
                header("Location: ../../sales/index.php?status=$json_data->status&sales=".$json_data->message);
            }
        }
    }
    
}
elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $json_data = json_decode($item->getAllItem());

    if($json_data != null){

        foreach ($json_data as $key => $item) { ?>
            <tr>
                <td scope="row"><?php echo $item->drug_name." ".$item->drug_chem; ?></td>
                <td><?php echo $item->class_name; ?></td>
                <td><?php echo $item->composition; ?></td>
                <td><?php echo $item->treatment_type; ?></td>
                <td><?php echo $item->location_name; ?></td>
                <td>N<?php echo $item->selling_price; ?></td>
                <td><?php echo $item->quanity; ?></td>
                <td>
                    <div class="d-flex">
                        <a class="nav-link" href="?render=<?php echo $item->drug_id; ?>"><i class="fas fa-cart-plus text-primary   "></i></a>
                    </div>
                </td>
            </tr>
        <?php }  
    }
    /* DELETE PRODUCT */
    
}

?>