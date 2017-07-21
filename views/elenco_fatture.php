<!DOCTYPE html>
<html lang="it">

<head>
	<title>Nurse Advisor - Elenco fatture</title>
	<style>
#popup-form {
	display: none;
	position: fixed;
	background: rgb(255, 250, 250);
	height: auto;
	top: 25%;
	left: 50%;
	width: auto;
	font-size: 12px;
}
	</style>
	<?php $this->load->view('templates/header');?> </head>

<body>
	<div id="wrapper">
		<!-- navigation bars -->
		<?php	 $this->load->view('templates/nav');?>
			<!-- Page Content -->
			<div id="page-wrapper">
				<div class="container-fluid">
					<div class='row'>
						<div class='col-lg-3'> <label>anno</label> <select class="form-control" id='optionAnno' onchange='refresh();'>
										<option>tutti</option>
										<?php
											foreach($anni_list as $row){
												echo"<option>".$row['anno']."</option>";
											}
										?>
									</select> </div>
					</div>
					<div class="panel panel-primary">
						<div class="panel-heading">elenco fatture 2016</div>
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="elencoFatture">
								<thead>
									<tr>
										<th>Numero</th>
										<th>Cliente</th>
										<th>Data</th>
										<th>Lordo €</th>
										<th>IRPEF €</th>
										<th>Enpapi €</th>
										<th>pagata</th>
									</tr>
								</thead>
								<tbody>
									<?php	$this->load->view('templates/elenco_fatture/list');?>
								</tbody>
							</table>
						</div>
					</div>
					<!-- panel -->
					<div id="popup-form">
						<div class='panel panel-info'>
							<div><input type='button' class='btn btn-danger' onclick='closePopup(event);' value='X chiudi'></div>
							<div class='panel-heading'></div>
							<div id='slide'>
								<div class='table-responsive'>
									<table class='table table-striped table-bordered table-hover' id='dettaglioFattura'>
										<thead>
											<tr>
												<th>descrizione</th>
												<th>quantità</th>
												<th>€ unitario</th>
												<th>totale</th>
											</tr>
										</thead>
										<tbody id="popup-dettagli-fattura"></tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>
	<!-- /#wrapper -->
<script>

</script>


	<?php $this->load->view('templates/footer');?>
	</body>

</html>