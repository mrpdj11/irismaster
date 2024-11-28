<?php
require_once 'includes/load.php';
require_once 'vendor2/autoload.php';


if (isset($_POST)) {

  // /**
  //  * Adding of items Process Logic
  //     *1. Add the item details in the Items Table in Database that is the "items" table
  //     *2. Check the item status if status = 301 add the item details in the available_items database table
  //     *2.1 if status = 300 add to lock_items database table
  // */

  if (are_fields_filled($_POST)) {

    // print_r_html($_POST);
    $id = remove_junk($_POST['db_id']);
    $ship_to_code = remove_junk($_POST['ship_to_code']);
    $customer_name = $_POST['customer_name'];
    $address = remove_junk($_POST['address']);
    $pallet_type = remove_junk($_POST['pallet_type']);
    $window_time = remove_junk($_POST['window_time']);
    $req_shelf_life = remove_junk($_POST['req_shelf_life']);

    $update_customer_details = $db->query('UPDATE tb_customer set ship_to_code = ?, ship_to_name=?,ship_to_address = ?, req_shelf_life = ?, window_time = ? , pallet_requirement=? WHERE id = ?', $ship_to_code, $customer_name, $address, $req_shelf_life, $window_time, $pallet_type, $id);

    if ($update_customer_details->affected_rows()) {
      $_SESSION['msg_heading'] = "Well Done!";
      $_SESSION['msg'] = "{$ship_to_code}-{$customer_name} Customer Details is now UPDATED!";
      $_SESSION['msg_type'] = "success";
      redirect("admin_manage_customer", false);
    } else {


      $_SESSION['msg_heading'] = "Transaction Error!";
      $_SESSION['msg'] = "Update Failed. If this persist please Contact your System Administrator.";
      $_SESSION['msg_type'] = "error";
      redirect("admin_manage_customer", false);
    }
  } else {
    $_SESSION['msg_heading'] = "Transaction Error!";
    $_SESSION['msg'] = "In Order to Confirm the Transaction. Please Fill all Fields.";
    $_SESSION['msg_type'] = "error";
    redirect("admin_manage_customer", false);
  }
}else{
    $_SESSION['msg_heading'] = "Transaction Forbidden!";
    $_SESSION['msg'] = "Please issue valid action.";
    $_SESSION['msg_type'] = "error";
    redirect("admin_manage_customer", false);
}
