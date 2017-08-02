<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"> Nuova Fattura
				<?php echo wp_get_current_user()->ID;?> </h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<form id="formFattura">
		<div class="panel panel-blue">
			<div class="panel-heading">Dati Fattura</div>
			<div class="row">
				<div class="col-md-12">
					<div class="input-group has-warning">
						<span class="input-group-addon">Cliente</span>
						<select class="form-control" name="formCliente" id="cliente">
						<?php
							foreach($elencoClienti as $row){
								echo"<option value='".$row['id']."'>".$row['cliente_nome']."</option>";
							}
							?>
					</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class='col-md-6'>
					<div class="input-group has-warning date" id="datepicker"> <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span><input type="text" class="form-control" id="inputDate" name="formDataFattura" placeholder="data fattura" onchange="checkFieldForm();"> </div>
				</div>
				<div class="col-md-6">
					<div class="input-group has-warning"> <span class="input-group-addon"><label>Numero Fattura</label></span> <input type="text" id="numeroFattura" name="formNumeroFattura" value="<?php echo $numeroFattura;?>" hidden="hidden" /> <output class="form-control"><?php echo $numeroFattura;?></output> </div>
				</div>
			</div>
			<!--/.row-->
			<div class="row">
				<div class="col-md-4">
					<div class="input-group has-warning"> <span class="input-group-addon">
								<label><input type="checkbox" name="formCheckIrpef" onchange="showTotale();" checked="checked"> IRPEF %</label>
									</span> <input type="text" name="formIrpef" class="form-control" onchange="showTotale();" value="20" /> </div>
					<!-- input group -->
				</div>
				<!-- col-md-2-->
				<div class="col-md-4">
					<div class="input-group has-warning"> <span class="input-group-addon">
									<label><input type="checkbox" name="formCheckEnpapi" onchange="showTotale();" checked="checked">  ENPAPI %</label>
									</span> <input type="text" class="form-control" onchange="showTotale();" name="formEnpapi" value="4"></div>
				</div>
				<!-- input-group -->
				<div class="col-md-4">
					<div class="input-group has-warning"> <span class="input-group-addon">
								<label><input type="checkbox" name="formCheckIva" onchange="showTotale();">  IVA %</label>
									</span> <input type="text" class="form-control" name="formIva" onchange="showTotale();" value="22"></div>
				</div>
				<!-- input-group -->
			</div>
			<!--/.row-->
			<div class="row">
				<div class="col-md-12 separator"> </div>
			</div>
		</div>
		<!-- panel primary -->
		<div class="panel panel-primary">
			<div class="panel-heading">Dettagli Fattura</div>
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="dettaglioFattura">
					<thead>
						<tr>
							<th>Descrizione</th>
							<th>Quantità</th>
							<th>€ Unitario</th>
							<th>Totale</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr id="rowTotale">
							<td></td>
							<td></td>
							<td></td>
							<td>
								<div class="input-group"> <span class="input-group-addon">€</span> <output name='totaleDettagli' class='input-box-number form-control' id='totaleFattura'></output> </div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /.table-responsive -->
		</div>
		<!-- /.panel-body -->
	</form>
	<div class="panel panel-info">
		<div class="panel-heading">Totale Fattura</div>
		<dl class="dl-horizontal"> <dt>totale imponibile €</dt>
			<dd id="totaleImponibile"></dd> <dt>ritenuta IRPEF €</dt>
			<dd id="totaleRitenutaIrpef"></dd> <dt>contributo ENPAPI €</dt>
			<dd id="totaleContributoEnpapi"></dd> <dt>totale fattura €</dt>
			<dd id="totaleNetto"></dd> <dt>totale iva €</dt>
			<dd id="totaleIva"></dd> <dt>totale non imponibile €</dt>
			<dd id="totaleNonImponibile"></dd> <dt>da pagare €</dt>
			<dd id="totalePagare"></dd>
		</dl>
		<div class="row">
			<div class="col-sm-12">
<!--                button id='metodo da chiamare'-->
				<div> <button type="submit" name="submitForm" class="btn btn-success btn-lg btn-block" id="add_fattura" disabled="disabled"><span class="glyphicon glyphicon-ok glyphicon-btn-submit" aria-hidden="true"> salva</span></button> </div>
			</div>
		</div>
		<div class="input-group"> <span class="input-group-addon">
						<label><input type="checkbox" name="inviaFatturaCommercialista"> Invia copia al Commercialista   <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></label>
			</span>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="input-group"> <span class="input-group-addon">
					 <label><input type="checkbox" name="inviaFatturaCliente"> Invia copia al Cliente   <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></label>
					</span>
				</div>
				<!-- /input-group -->
			</div>
			<!-- /.col -->
		</div>
		<!-- row -->
	</div>
</div>
<!-- /.container-fluid -->
<script>
$(document).ready(function()
{
	$('#datepicker').datepicker(
	{
		format: "dd/mm/yyyy",
		language: "it",
		todayHighlight: true,
		autoclose: true
	});
	$(document).on("click", "input[name='imponibile[]']", function()
	{
		console.log($(this));
		//console.log($(this).index());
		//var $check = $('input[name^="imponibile[]"]');
		var check = $(this).attr('id');
		console.log('id=' + check);
		var setValue = ($(this)[0].checked ? 1 : 0);
		console.log('value=' + setValue);
		var index = check.replace(/[^0-9]/g, '');
		var imponibileFlag = 'imponibileFlag' + index;
		console.log("index:" + index);
		console.log('imponibileFlag:' + imponibileFlag);
		var $imponibile = $('#' + imponibileFlag);
		console.log($imponibile);
		$imponibile.val(setValue);
	});
});
var countRows = 0;
var maxTableRows = 20;
var indexRow = 0;
insertRow();
</script>