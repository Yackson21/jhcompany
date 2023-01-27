<?php
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	echo $_GET['invoice_id'];
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);		
}
$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceValues['order_date']));
$output = '';
$output .= '<h1 align="center">COMMERCIAL INVOICE</h1><br/><br/><br/>';
$output .= ' 
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">INV. N° : '.$invoiceValues['order_id'].'</td>         
	<td width="35%">INV. DATE :<b> '.$invoiceDate.'</b></td>	
	</tr>
	</table>

	<table width="100%" cellpadding="5">
	<tr>
	<td colspan="2"  style="font-size:18px"></td>
	</tr><br/>
	<tr>
	<td width="65%" colspan="2" align="left" style="font-size:18px">SHIPPER : <b>'.$invoiceValues['shipper'].'</b></td>
	<td width="35%" colspan="2" align="left" style="font-size:18px">LOAD PORT : <b>'.$invoiceValues['load_port'].'</b><br/>
	</td>	
	</tr>
	<tr>
	<td width="65%" colspan="2" align="left" style="font-size:18px">TO : <b>'.$invoiceValues['receiver'].'</b></td>		
	<td width="35%" colspan="2" align="left" style="font-size:18px">FINAL PORT : <b>'.$invoiceValues['final_port'].'</b></td>
	</tr>

	</table>
	
	
	<br/>
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">SN</th>
	<th align="left">MARKS and N°</th>
	<th align="left">DESCRIPTION OF GOODS</th>
	<th align="left">QUANTITY</th>
	<th align="left">UNIT PRICE</th>
	<th align="left">AMOUNT</th> 
	</tr>';
$count = 0;   
foreach($invoiceItems as $invoiceItem){
	$count++;
	$output .= '
	<tr>
	<td align="left">'.$count.'</td>
	<td align="left">'.$invoiceItem["item_code"].'</td>
	<td align="left">'.$invoiceItem["item_name"].'</td>
	<td align="left">'.$invoiceItem["order_item_quantity"].'</td>
	<td align="left">'.$invoiceItem["order_item_price"].'</td>
	<td align="left">'.$invoiceItem["order_item_final_amount"].'</td>   
	</tr>';
}
$output .= '
	<tr>
	<td align="right" colspan="5"><b>Sub Total</b></td>
	<td align="left"><b>'.$invoiceValues['order_total'].'</b></td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>FOB :</b></td>
	<td align="left">'.$invoiceValues['fob'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>FRET :</b></td>
	<td align="left">'.$invoiceValues['fret'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>ASS:</b> </td>
	<td align="left">'.$invoiceValues['ass'].'</td>
	</tr>	
	<tr>
	<td align="left" colspan="5"><b>TOTAL</b></td>
	<td align="left">'.$invoiceValues['order_total'].'</td><br/>
	</tr>';
$output .= '
	<table width="50%" cellpadding="5"  cellpadding="5" cellspacing="0">
	<tr>
	<td colspan="2" align="left" style="font-size:18px"><b>CNT N°: </b>'.$invoiceValues['cnt_n'].'</td>
	</tr>
	<tr>
	<td colspan="2" align="left" style="font-size:18px"><b>GROSS WEIGHT</b> : '.$invoiceValues['gross_weight'].'</td>	
	</tr>
	<tr>
	<td colspan="2" align="left" style="font-size:18px"><b>NET WEIGHT</b> : '.$invoiceValues['net_weight'].'</td>	
	</tr>
	
			';
$output .= '
	</table>
	</td>
	</table>
	</table>';
// create pdf of invoice	
$invoiceFileName = 'Invoice-'.$invoiceValues['order_id'].'.pdf';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>   
   