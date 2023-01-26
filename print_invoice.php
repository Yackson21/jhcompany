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
$output .= ' 
	
	<table width="100%" cellpadding="5">
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>COMMERCIAL INVOICE</b></td>
	</tr><br/>
	<tr>
	<td colspan="2" align="left" style="font-size:18px"><b>SHIPPER</b> : '.$invoiceValues['order_sender_name'].'</td>	
	</tr>
	</table>	
	
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">	
	<b>TO </b>: '.$invoiceValues['order_receiver_name'].'<br />		
	LOAD PORT : <b>'.$invoiceValues['order_sender_address'].'</b><br />
	FINAL PORT : <b>'.$invoiceValues['order_receiver_address'].'</b><br />
	</td>

	<td width="35%">         
	Invoice No. : '.$invoiceValues['order_id'].'<br />
	Invoice Date : '.$invoiceDate.'<br />
	</td>
	</tr>
	</table>
	<br />
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
	<td align="right" colspan="5">ASS: </td>
	<td align="left">'.$invoiceValues['ass'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Amount Paid: </td>
	<td align="left">'.$invoiceValues['amount_paid'].'</td>
	</tr>	
	<tr>
	<td align="right" colspan="5"><b>Amount Due:</b></td>
	<td align="left">'.$invoiceValues['amount_due'].'</td><br/>
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
   