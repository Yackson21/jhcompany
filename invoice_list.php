<?php 
session_start();
include('inc/header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>
<title>JH COMPANY INVOICE SYSTEM</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('inc/container.php');?>
	<div class="container">		
  <img src="images/header-nbg.png" alt="">
	  <?php include('menu.php');?>			  
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>No DE FACTURE</th>
            <th>DATE CONCUE</th>
            <th>EXPÉDITEUR</th>
            <th>RECEVEUR</th>
            <th>MONTANT</th>
            <th>Imprimer</th>
            <th>Modifier</th>
            <th>Effacer</th>
          </tr>
        </thead>
        <?php		
		$invoiceList = $invoice->getInvoiceList();
        foreach($invoiceList as $invoiceDetails){
			$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
            echo '
              <tr>
                <td>'.$invoiceDetails["order_id"].'</td>
                <td>'.$invoiceDate.'</td>
                <td>'.$invoiceDetails["order_sender_name"].'</td>
                <td>'.$invoiceDetails["order_receiver_name"].'</td>
                <td>'.$invoiceDetails["order_total"].'</td>
                <td><a href="print_invoice.php?invoice_id='.$invoiceDetails["order_id"].'" title="Print Invoice"><span class="glyphicon glyphicon-print"></span></a></td>
                <td><a href="edit_invoice.php?update_id='.$invoiceDetails["order_id"].'"  title="Edit Invoice"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="#" id="'.$invoiceDetails["order_id"].'" class="deleteInvoice"  title="Delete Invoice"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
        }       
        ?>
      </table>	
</div>	
<?php include('inc/footer.php');?>