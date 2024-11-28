<?php
require_once 'includes/load.php';
require_once 'vendor2/autoload.php';

if (isset($_POST)) {
//   print_r_html($_POST);

  if (empty(trim($_POST['origin'])) || empty(trim($_POST['destination'])) || empty(trim($_POST['driver']))  || empty(trim($_POST['plate_no'])) || empty(trim($_POST['trucker'])) || empty(trim($_POST['inb_reference_no'])) || empty(trim($_POST['pallet_type'])) || empty(trim($_POST['qty'])) || empty(trim($_POST['remarks']))) {

    $_SESSION['msg_heading'] = "Error!";
    $_SESSION['msg'] = "Error: Failed. All fields are required.";
    $_SESSION['msg_type'] = "error";
    redirect("outgoing_pallet");

  }else{
    
    // print_r_html($_POST);

    $ref_no = generate_reference_no($db,80);
    $origin = $db->escape_string($_POST['origin']);
    $destination = $db->escape_string($_POST['destination']);
    $driver = $db->escape_string($_POST['driver']);
    $plate_no = $db->escape_string($_POST['plate_no']);
    $trucker = $db->escape_string($_POST['trucker']);
    $inb_ref_no = $db->escape_string($_POST['inb_reference_no']);
    $pallet_type = $db->escape_string($_POST['pallet_type']);
    $qty = $db->escape_string($_POST['qty']);
    $remarks = $db->escape_string($_POST['remarks']);
    $created_by = $db->escape_string($_SESSION['name']);
    $date_received = $db->escape_string($_POST['date_received']);
    $transaction_type = 'OUT';

    // print_r_html($ref_no);

    /** DB INSERT */
    $insert_to_db = $db->query('INSERT INTO tb_pallet_exchange (ref_no,transaction_type, origin,destination,driver,plate_no, trucker, inb_ref_no, pallet_type,qty, remarks, date_received, created_by) 
    VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?)', $ref_no,$transaction_type, $origin, $destination,$driver,$plate_no, $trucker, $inb_ref_no, $pallet_type, $qty, $remarks, $date_received, $created_by);

    if($insert_to_db -> affected_rows()){
      // $_SESSION['msg_heading'] = "Success!";
      // $_SESSION['msg'] = "You have successfully created pallet inbound!";
      // $_SESSION['msg_type'] = "success";
      redirect("print_incoming_pallet?db_id=".$db->insert_id());
    }else{
      $_SESSION['msg_heading'] = "Error!";
      $_SESSION['msg'] = "Error: Data Processing Error Please Contact your IT Administrator.";
      $_SESSION['msg_type'] = "error";
      redirect("outgoing_pallet");
    }

  }

} else {
  $_SESSION['msg_heading'] = "Error!";
  $_SESSION['msg'] = "Error: Failed. Please try again.";
  $_SESSION['msg_type'] = "error";
  redirect("outgoing_pallet");
}
