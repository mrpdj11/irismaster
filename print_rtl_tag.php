<?php
ob_start();
require_once 'includes/load.php';
?>
<?php
/** To Generate Printable PDF */
include_once 'fpdf/fpdf.php'; // fpdf
include_once 'fpdf/easytable/exfpdf.php'; // exfpdf
include_once 'fpdf/easytable/easyTable.php'; // easytable

require 'vendor2/autoload.php'; // Barcode Generator
?>


<?php

  //print_r_html($_GET);
  if(!isset($_GET)){
    /**ERROR */
      $_SESSION['msg_heading'] = "Transaction Failed!";
      $_SESSION['msg'] = "Invalid Transaction ID!";
      $_SESSION['msg_type'] = "error";
      redirect("outbound_incoming_dispatch");
  }else{

    $update_to_status = $db->query('UPDATE tb_picklist SET status = ? WHERE id = ?','Ready to Load',$_GET['picklist_id']);

    if(!$update_to_status->affected_rows()){
      /**ERROR */
      $_SESSION['msg_heading'] = "Printing Failed!";
      $_SESSION['msg'] = "Picklist Printing Can Only Be Done Once!";
      $_SESSION['msg_type'] = "error";
      redirect("validate_picking?so_no={$_GET['so_no']}");
    }else{

      $get_picklist_details = $db->query('SELECT
      a.id AS picklist_id,
      a.ref_no,
      a.ia_id,
      a.to_id,
      a.allocated_lpn,
      a.allocated_sku_code,
      a.allocated_qty,
      a.allocated_expiry,
      a.bin_loc,
      tb_items.material_description,
      tb_transfer_order.so_date,
      tb_transfer_order.rdd,
      tb_transfer_order.upload_date
      FROM tb_picklist a
      LEFT JOIN tb_items ON tb_items.sap_code = a.allocated_sku_code
      LEFT JOIN tb_transfer_order ON tb_transfer_order.id = a.to_id
      WHERE a.so_no = ?',$_GET['so_no'])->fetch_all();
      
      //print_r_html($get_picklist_details);

      $generator = new Picqer\Barcode\BarcodeGeneratorPNG();


      file_put_contents('rtl_barcode_images/picklist_id-' . $_GET['picklist_id'] . '.png', $generator->getBarcode($_GET['picklist_id'], $generator::TYPE_CODE_128, 10, 100));

      /**
       * Start of Printing
       */
      $pdf = new exFPDF('P', 'mm', 'A4');
      $pdf->AliasNbPages();
      $pdf->SetMargins(3,3,3);
      $pdf->SetFont('Arial', '', 10);
      $pdf->AddPage();

      // Header

      $tb_header=new easyTable($pdf, 3);
      $tb_header->rowStyle('border:0');
      $tb_header->easyCell('', 'img:img/agl_logo.png, w35; align:C; valign:M ;rowspan:3');
      $tb_header->easyCell('Arrowgo-Logistics Inc.', 'font-size:10; font-style:BI; align:C; valign:B');
      $tb_header->easyCell('', ' align:C; valign:M ;rowspan:3');
      $tb_header->printRow();

      $tb_header->rowStyle('border:0');
      $tb_header->easyCell('Arrowgo-Logistics Inc. Warehouse Complex'."\n".'11M Villarica Road,Brgy. Patubig, Marilao Bulacan', 'font-size:7; font-style:I; align:C; valign:T');
      $tb_header->printRow();

      $tb_header->rowStyle('border:0');
      $tb_header->easyCell('Ready to Load Tag', 'font-size:15; font-style:B; align:C; valign:M');
      $tb_header->printRow();
      $tb_header->endTable(2);  

      $tb_details = new easyTable($pdf, '{60,2,37,37,37,37}');
      $tb_details->rowStyle('border:T;font-size:8; font-style:B');
      $tb_details->easyCell('', 'img:rtl_barcode_images/picklist_id-'.$_GET['picklist_id'].'.png, w40, h10; align:C; valign:T;rowspan:2');
      $tb_details->easyCell('');
      $tb_details->easyCell('REF No:','valign:B');
      $tb_details->easyCell('SO Date:','valign:B');
      $tb_details->easyCell('SO No:','valign:B');
      $tb_details->easyCell('RDD:','valign:B');
      $tb_details->printRow();
 

      $tb_details->rowStyle('border:0;font-size:7');
      $tb_details->easyCell('','valign:T');
      $tb_details->easyCell('TEST','valign:T');
      $tb_details->easyCell('TEST','valign:T');
      $tb_details->easyCell('TEST','valign:T');
      $tb_details->easyCell('TEST','valign:T');
      $tb_details->printRow();
      $tb_details->endTable(3);

      /**
       * Output With file name
       */
      $pdf->Output(); //To Print and to indicate the filename
      


    }
  
  
  }
  

   



?>