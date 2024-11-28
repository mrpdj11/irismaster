<?php
require_once 'includes/load.php';

if (is_login_auth()) {

    /** SESSION BASE TO TIME TODAY */
  
    if (is_session_expired()) {
      $_SESSION['msg'] = "<b>SESSION EXPIRED:</b> Please Login Again.";
      $_SESSION['msg_type'] = "danger";
  
      unset($_SESSION['user_id']);
      unset($_SESSION['name']);
      unset($_SESSION['user_type']);
      unset($_SESSION['user_status']);
  
      unset($_SESSION['login_time']);
  
      /**TIME TO DAY + 315360000 THAT EQUIVALENT TO 10 YEARS*/
  
      redirect("login", false);
    }
} else {
redirect("login", false);
}

    $date_today = date('Y-m-d');

    $pallet_transaction_summary = $db->query('SELECT * FROM tb_pallet_exchange')->fetch_all();
    

if(!empty($pallet_transaction_summary)){
  
    $file_name = "Pallet Transaction Summary".date('Y-M-d').".csv";
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$file_name");
    header("Content-Type: text/csv;");
  
    $file = fopen('php://output', 'w');
  
    $header = array("Reference No.", "Transaction Date", "Transaction Type", "Document Ref.", "Origin","Ship To","Driver","Plate No.","Trucker","Pallet Type","Qty","Remarks","Created By");
    fputcsv($file, $header);

    foreach ($pallet_transaction_summary as $asar_key => $row) {
        $data = array();
        $data[] = $row["ref_no"];
        $data[] = $row["date_received"];
        $data[] = $row["transaction_type"];
        $data[] = $row["inb_ref_no"];
        $data[] = $row["origin"];
        $data[] = $row["destination"];
        $data[] = $row["driver"];
        $data[] = $row["plate_no"];
        $data[] = $row["trucker"];
        $data[] = $row["pallet_type"];
        $data[] = $row["qty"];
        $data[] = $row["remarks"];
        $data[] = $row["created_by"];
        fputcsv($file, $data);
      }
      fclose($file);
      exit;

    }else{
      $_SESSION['msg_heading'] = "Download Failed!";
      $_SESSION['msg'] = "No Available Pallet Exchange Transaction to Export.";
      $_SESSION['msg_type'] = "warning";
      redirect("index");
    }


?>