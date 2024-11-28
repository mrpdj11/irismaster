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

//  print_r_html($_GET);

 $db_details = $db->query('SELECT * FROM tb_pallet_exchange WHERE id = ?',$_GET['db_id'])->fetch_array();

//  print_r_html($db_details);
  
  $generator = new Picqer\Barcode\BarcodeGeneratorPNG();


  file_put_contents('pallet_exchange_bcodes/peb-db_id-' . $_GET['db_id'] . '.png', $generator->getBarcode($_GET['db_id'], $generator::TYPE_CODE_128, 10, 100));


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
  $tb_header->easyCell('', 'img:img/pepsi_logo.png, w15; align:C; valign:M ;rowspan:3');
  $tb_header->easyCell('Arrowgo-Logistics Inc.', 'font-size:10; font-style:BI; align:C; valign:B');
  $tb_header->easyCell('', ' align:C; valign:M ;rowspan:3');
  $tb_header->printRow();

  $tb_header->rowStyle('border:0');
  $tb_header->easyCell('12th Floor Avecshares Center'."\n".'1132 University Parkway North, Bonifacio Triangle,'."\n".'Bonifacio Global City, Taguig 1634', 'font-size:7; font-style:I; align:C; valign:T');
  $tb_header->printRow();

  $tb_header->rowStyle('border:0');
  $tb_header->easyCell('SwapStack', 'font-size:10; font-style:B; align:C; valign:M');
  $tb_header->printRow();
  $tb_header->endTable(2);  


  $tb_details = new easyTable($pdf, '{40,2,22,27,23,23,26,24,23}');
  $tb_details->rowStyle('border:T;font-size:7; font-style:B');
  $tb_details->easyCell('', 'img:pallet_exchange_bcodes/peb-db_id-'.$_GET['db_id'].'.png, w40, h10; align:C; valign:T;rowspan:2');
  $tb_details->easyCell('');
  $tb_details->easyCell('Doc No:','valign:B');
  $tb_details->easyCell('GR Ref. No.:','valign:B');
  $tb_details->easyCell('Trans. Date:','valign:B');
  $tb_details->easyCell('Trans. Type:','valign:B');
  $tb_details->easyCell('Forwarder:','valign:B');
  $tb_details->easyCell('Driver:','valign:B');
  $tb_details->easyCell('Plate No:','valign:B');
  $tb_details->printRow();
  


  $tb_details->rowStyle('border:0;font-size:7');
  $tb_details->easyCell('');
  $tb_details->easyCell('SS-'.$db_details['ref_no'],'valign:T');
  $tb_details->easyCell($db_details['inb_ref_no'],'valign:T');
  $tb_details->easyCell($db_details['date_received'],'valign:T');
  $tb_details->easyCell($db_details['transaction_type'],'valign:T');
  $tb_details->easyCell($db_details['trucker'],'valign:T');
  $tb_details->easyCell($db_details['driver'],'valign:T');
  $tb_details->easyCell($db_details['plate_no'],'valign:T');
  $tb_details->printRow();
  $tb_details->endTable(3);

  $tb_details_2 = new easyTable($pdf , '{90,120}', 'border:0');
  $tb_details_2->rowStyle('font-size:8; font-style:B');
  $tb_details_2->easyCell('SHIP FROM:','valign:M');
  $tb_details_2->easyCell('REMARKS:','valign:M;');
  $tb_details_2->printRow();


  $tb_details_2->rowStyle('font-size:7');
  $tb_details_2->easyCell($db_details['origin'],'valign:M');
  $tb_details_2->easyCell('Print Date: '.date('Y-m-d h:i A'),'valign:T; rowspan:2');
  $tb_details_2->printRow();

  $tb_details_2->rowStyle('font-size:7');
  $tb_details_2->easyCell('','valign:M');
  $tb_details_2->printRow();

  $tb_details_2->rowStyle('font-size:8');
  $tb_details_2->easyCell('','paddingY: 2');
  $tb_details_2->easyCell('OTHER INSTRUCTION/S:','valign:M; font-style:B');
  $tb_details_2->printRow();

  $tb_details_2->rowStyle('font-size:7');
  $tb_details_2->easyCell('','paddingY: 2');
  $tb_details_2->easyCell('1. Inbound Team/Checker shall issue this to the forwarder.','valign:M');
  $tb_details_2->printRow();


  $tb_details_2->rowStyle('font-size:7');
  $tb_details_2->easyCell('SHIP TO:','valign:M; font-style:B;font-size:8');
  $tb_details_2->easyCell('2. The forwarder shall review the information prior signing.','valign:M');
  $tb_details_2->printRow();

  $tb_details_2->rowStyle('font-size:7');
  $tb_details_2->easyCell($db_details['destination'],'valign:M');
  $tb_details_2->easyCell('3. Arrowgo shall secure a signed copy of the document and issue the same to the forwarder.','valign:M');
  $tb_details_2->printRow();

  $tb_details_2->rowStyle('font-size:7');
  $tb_details_2->easyCell('','valign:M; border:B');
  $tb_details_2->easyCell('4. Prior exit to the premise the driver shall show this to the Guard.','valign:M; border:B');
  $tb_details_2->printRow();
  $tb_details_2->endTable();

  
  /**
   * Remarks And Signatory
   */

   $table_remarks_sign = new easyTable($pdf, '{30,60,60,60}');

   $table_remarks_sign->rowStyle('font-size:8;valign:M;font-style:B;');
   $table_remarks_sign->easyCell('');
   $table_remarks_sign->easyCell('Checker:');
   $table_remarks_sign->easyCell('Driver:');
   $table_remarks_sign->easyCell('Released/Approved By:');
   $table_remarks_sign->printRow();


   $table_remarks_sign->rowStyle('font-size:8;valign:M;paddingY:3');
   $table_remarks_sign->easyCell('Signature:');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->printRow();

   
   $table_remarks_sign->rowStyle('font-size:8;valign:M;paddingY:3');
   $table_remarks_sign->easyCell('Name:');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->printRow();


   $table_remarks_sign->rowStyle('font-size:8;valign:M;paddingY:3;');
   $table_remarks_sign->easyCell('Date:');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->easyCell('______________________________');
   $table_remarks_sign->printRow();
   $table_remarks_sign->endTable();


  $tb_body = new easyTable($pdf , '{30,60,15,35,35,35}');
  $tb_body->rowStyle('font-size:8; font-style:B; paddingY:2; border:TB');
  $tb_body->easyCell('Pallet Code','valign:T; align:C');
  $tb_body->easyCell('Description','valign:T;align:C');
  $tb_body->easyCell('UoM','valign:T;align:C');
  $tb_body->easyCell('Actual Qty','valign:T;align:C');
  $tb_body->easyCell('BBD','valign:T; align:C');
  $tb_body->easyCell('Remarks','valign:T; align:C');
  $tb_body->printRow();

  
    $tb_body->rowStyle('font-size:8; paddingY:2');
    $tb_body->easyCell($db_details['pallet_type'],'valign:M; align:C');
    if(are_strings_equal($db_details['pallet_type'],"PL-01")){
        $tb_body->easyCell('Plastic Pallet (1mx1m)','valign:M;align:C');
    }
    if(are_strings_equal($db_details['pallet_type'],"PL-02")){
        $tb_body->easyCell('SMY Plastic Pallet','valign:M;align:C');
    }
    if(are_strings_equal($db_details['pallet_type'],"PL-03")){
        $tb_body->easyCell('RPPC/Red Pallet','valign:M;align:C');
    }
    if(are_strings_equal($db_details['pallet_type'],"PL-04")){
        $tb_body->easyCell('Loscam','valign:M;align:C');
    }
    if(are_strings_equal($db_details['pallet_type'],"PL-05")){
        $tb_body->easyCell('Sancar','valign:M;align:C');
    }
    if(are_strings_equal($db_details['pallet_type'],"PL-06")){
        $tb_body->easyCell($db_details['remarks'],'valign:M;align:C');
    }
   
    $tb_body->easyCell('Pc','valign:M; align:C');
    $tb_body->easyCell(number_format($db_details['qty'],2,'.'),'valign:M;align:C');
    $tb_body->easyCell('N/A','valign:M; align:C;');
    $tb_body->easyCell('','valign:M; align:C');
    $tb_body->printRow();
  
  

  $tb_body->rowStyle('font-size:8;');
  $tb_body->easyCell('','valign:M; align:C; colspan:6 ; paddingY:10');
  $tb_body->printRow();

  $tb_body->rowStyle('font-size:8;');
  $tb_body->easyCell('-Nothing Follows-','valign:M; align:C; colspan:6');
  $tb_body->printRow();
  $tb_body->endTable(120);


  /**
   * Output With file name
   */
  $pdf->Output(); //To Print and to indicate the filename


?>