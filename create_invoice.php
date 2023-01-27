<?php 
session_start();
include('inc/header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName']) {	
	$invoice->saveInvoice($_POST);
	header("Location:invoice_list.php");	
}
?>
<title>JH COMPANY INVOICE SYSTEM</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('inc/container.php');?>
<div class="container content-invoice">
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 
		<div class="load-animate animated fadeInUp">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<img src="images/header-nbg.png" alt="">

					<?php include('menu.php');?>	
				</div>		    		
			</div>
			<input id="currency" type="hidden" value="$">
			<div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<h4>EXPÉDITEUR / SHIPPER:</h4>					
					<div class="form-group">
						<input type="text" class="form-control" name="shipperName" id="shipperName" placeholder="FROM" autocomplete="off">
					</div>
					<div class="form-group">
						<input class="form-control" name="loadPort" id="loadPort" placeholder="LOAD PORT"></input>
					</div>					
				</div>      		
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
					<h4>RECEVEUR / RECEIVER:</h4>
					<div class="form-group">
						<input type="text" class="form-control" name="companyName" id="companyName" placeholder="TO" autocomplete="off">
					</div>
					<div class="form-group">
						<input class="form-control"  name="finalPort" id="finalPort" placeholder="FINAL PORT"></input>
					</div>
					
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-hover" id="invoiceItem">	
						<tr>
							<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
							<th width="15%">N° DU COLI</th>
							<th width="38%">DESCRIPTION DU COLI</th>
							<th width="15%">QUANTITÉ</th>
							<th width="15%">PRIX UNITAIRE</th>								
							<th width="15%">MONTANT</th>
						</tr>							
						<tr>
							<td><input class="itemRow" type="checkbox"></td>
							<td><input type="text" name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
							<td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td>			
							<td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
							<td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
							<td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
						</tr>						
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<button class="btn btn-danger delete" id="removeRows" type="button">- Effacer</button>
					<button class="btn btn-success" id="addRows" type="button">+ Ajouter</button>
				</div>
			</div>
			<div class="row">	
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<h4>CNT N°: </h4>
					<div class="form-group">
						<input type="text" class="form-control" name="cntN" id="cntN" placeholder="Numéro du contenaire" autocomplete="off">
					</div>
					
					<h4>GROSS WEIGHT: </h4>
					<div class="form-group">
						<input type="text" class="form-control" name="grossWeight" id="grossWeight" placeholder="Poids brut" autocomplete="off">
					</div>
					
					<h4>NET WEIGHT: </h4>
					<div class="form-group">
						<input type="text" class="form-control" name="netWeight" id="netWeight" placeholder="Poids net" autocomplete="off">
					</div>
					
					<div class="form-group">
						<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
						<input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Enrégistrer" class="btn btn-success submit_btn invoice-save-btm">						
					</div>
					
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<span class="form-inline">
						<div class="form-group">
								<label>TOTAL: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon currency">$</div>
									<input value="<?php echo $invoiceValues['order_total']; ?>" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
								</div>
						</div>
						
							<div class="form-group">
								<label>FOB: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon currency">$</div>
									<input value="<?php echo $invoiceValues['fob']; ?>" type="number" class="form-control" name="fob" id="fob" placeholder="Montant FOB">
								</div>
							</div>							
							
							<div class="form-group">
								<label>FRET: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon currency">$</div>
									<input value="<?php echo $invoiceValues['fret']; ?>" type="number" class="form-control" name="fret" id="fret" placeholder="Montant FRET">
								</div>
							</div>							
							
							<div class="form-group">
								<label>ASS: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-addon currency">$</div>
									<input value="<?php echo $invoiceValues['ass']; ?>" type="number" class="form-control" name="ass" id="ass" placeholder="Montant ASS">
								</div>
							</div>						
						
					</span>
				</div>
			</div>
			<div class="clearfix"></div>		      	
		</div>
	</form>			
</div>
</div>	
<?php include('inc/footer.php');?>