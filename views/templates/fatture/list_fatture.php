		<!-- Page Content -->
		
				<div class="container-fluid">
					<div class='row'>
						<div class='col-lg-3'> <label>anno</label> <select class="form-control" id='optionAnno' onchange='refresh();'>

										<?php
											foreach($anni_list as $row){
												echo"<option>".$row['anno']."</option>";
											}
										?>
                                         <option>tutti</option>
									</select> </div>
						<div class='col-lg-3'> <label>Cliente</label> <select class="form-control" id='optionCliente' onchange='refresh();'>
										<option>tutti</option>
										<?php
											foreach($clienti_list as $row){
												echo"<option value='".$row['id']."'>".$row['cliente_nome']."</option>";
											}
										?>
									</select> </div>
						<div class='col-lg-3'> <label>Status</label> <select class="form-control" id='optionStatus' onchange='refresh();'>
										<option>tutti</option>
										<?php
											$status_list=[0=>'in pagamento','pagata','sospesa'];
											$index=0;
											foreach($status_list as $row){
												echo"<option value='{$index}'>".$row."</option>";
												$index++;
											}
										?>
									</select> </div>
					</div>
					<div class="panel panel-green">
						<div class="panel-heading">elenco fatture</div>
						<div class="panel-body">
							<table class="table table-hover-color table-condesed" id="elencoFatture">
								
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

								</tbody>
							</table>
						</div>
						
					</div>
					<!-- /panel -->
					<div id="popup-form">
						<div class='panel panel-info'>
							<div><input type='button' class='btn btn-danger' onclick='closePopup();' value='X chiudi'></div>
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
        <script>
	        $(document).ready(function()
	        {
		        refresh();
			        });
        </script>
