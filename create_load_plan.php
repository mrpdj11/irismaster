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

  print_r_html('Automated Load Plan Algo');

  // $db_for_loadplan =  $db->query('SELECT 
  // a.id,
  // a.to_no,
  // a.transaction_type,
  // a.uploading_file_name,
  // a.delivery_order_no,
  // a.pcppi_shipment_no,
  // a.so_date,
  // a.rdd,
  // a.so_no,
  // a.delivering_plant,
  // a.ship_to_code,
  // a.sku_code,
  // a.material_description,
  // a.req_qty_case,
  // a.allocated_qty,
  // a.picked_qty,
  // a.allocated_by,
  // a.created_by,
  // a.`status`,
  // a.truck_allocation_status,
  // a.fill_rate_status,
  // a.upload_date,
  // tb_items.material_description,
  // tb_items.weight_per_case,
  // tb_items.cbm_per_case,
  // tb_customer.ship_to_name,
  // tb_customer.ship_to_address
  // FROM tb_transfer_order a
  // LEFT JOIN tb_items ON tb_items.sap_code = a.sku_code
  // LEFT JOIN tb_customer ON tb_customer.ship_to_code = a.ship_to_code
  // -- WHERE a.truck_allocation_status = ? AND a.rdd >= ? AND a.allocated_qty <> ?
  // WHERE a.truck_allocation_status = ? AND a.allocated_qty <> ?
  // ORDER BY a.so_no',"Pending",0)->fetch_all();  

  $db_for_loadplan =  $db->query('SELECT 
  a.id,
  a.to_no,
  a.transaction_type,
  a.rdd,
  a.so_no,
  a.ship_to_code,
  a.sku_code,
  a.req_qty_case,
  a.allocated_qty,
  a.picked_qty,
  a.`status`,
  a.truck_allocation_status,
  tb_items.material_description,
  tb_items.weight_per_case,
  tb_items.cbm_per_case,
  tb_customer.ship_to_name,
  tb_customer.ship_to_address
  FROM tb_transfer_order a
  LEFT JOIN tb_items ON tb_items.sap_code = a.sku_code
  LEFT JOIN tb_customer ON tb_customer.ship_to_code = a.ship_to_code
  -- WHERE a.truck_allocation_status = ? AND a.rdd >= ? AND a.allocated_qty <> ?
  WHERE a.truck_allocation_status = ? AND a.allocated_qty <> ?
  ORDER BY a.so_no',"Pending",0)->fetch_all();  

  print_r_html($db_for_loadplan);

?>