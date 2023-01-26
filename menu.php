<ul class="nav navbar-nav">
<li class="dropdown">
	<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Invoice / Facture
	<span class="caret"></span></button>
	<ul class="dropdown-menu">
		<li><a href="invoice_list.php">Toutes les Factures / All Invoices</a></li>
		<li><a href="create_invoice.php">Nouvelle Facture / New Invoice</a></li>				  
	</ul>
</li>
<?php 
if($_SESSION['userid']) { ?>
	<li class="dropdown login">
		<button style="float:right" class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $_SESSION['user']; ?>
		<span class="caret"></span></button>
		<ul class="dropdown-menu">
			<li><a href="#">Compte</a></li>
			<li><a href="action.php?action=logout">Deconnexion</a></li>		  
		</ul>
	</li>
<?php } ?>
</ul>
<br /><br /><br /><br />