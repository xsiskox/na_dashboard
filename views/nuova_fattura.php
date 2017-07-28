<!DOCTYPE html>
<html lang="en">

<head>
	<title>Nurse Advisor - Nuova Fattura</title>
	<?php $this->load->view('templates/header');?>
</head>

<body>
	<div id="wrapper">
		<!-- navigation bars -->
		<?php	$this->load->view('templates/nav');?>
			<!-- Page Content -->
			<div id="page-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<h1 class="page-header"> Nuova Fattura <?php echo $user->ID;?> </h1>
						</div>
						<!-- /.col-lg-12 -->
					</div>
					<!-- /.row -->
					<form id="formFattura" action='<?php echo site_url('dashboard/?/nuova_fattura/add_fattura'); ?>' method='post'>
						<input type="number" value='<?php echo $user->ID;?>' name='userID' hidden='hidden'>
						<div class="panel panel-primary">
							<div class="panel-heading">Dati Fattura</div>
							<div class="row">
								<div class="col-md-12"> <label>cliente</label>
								<select class="form-control" name="formCliente" id="cliente">
								<?php
											foreach($elencoClienti as $row){
												echo"<option value='".$row['id']."'>".$row['cliente_nome']."</option>";
											}
										?>
								
							</select>
								</div>
							</div>
							<div class="row"> </div>
							<div class="row">
								<div class="col-md-12 separator"></div>
							</div>
							<div class="row">
								<div class='col-sm-4'>
									<div class="input-group date" id="datepicker"> <input type="text" class="form-control" id="inputDate" name="formDataFattura" placeholder="data fattura"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span> </div>
								</div>
								<div class="col-md-2">  <input type="text" id="numeroFattura" class="form-control" name="formNumeroFattura" readonly="readonly" value="<?php echo $numeroFattura;?>" /> </div>
							</div>
							<!--/.row-->
							<div class="row">
								<div class="col-md-12 separator"> </div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<div class="input-group"> <span class="input-group-addon">
								<label><input type="checkbox" name="formCheckIrpef" onchange="showTotale();" checked="checked"> IRPEF %</label>
									</span> <input type="text" name="formIrpef" class="form-control" onchange="showTotale();" value="20" /> </div>
									<!-- input group -->
								</div>
								<!-- col-md-2-->
								<div class="col-md-4">
									<div class="input-group"> <span class="input-group-addon">
									<label><input type="checkbox" name="formCheckEnpapi" onchange="showTotale();" checked="checked">  ENPAPI %</label>
									</span> <input type="text" class="form-control" onchange="showTotale();" name="formEnpapi" value="4"></div>
								</div>
								<!-- input-group -->
								<div class="col-md-4">
									<div class="input-group"> <span class="input-group-addon">
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
											<td>
												<div class="dettagli-fattura-footer">
													<div class="dettagli-fattura-btn-salva"> <button type="submit" name="submit" class="btn btn-primary" id="inviaFattura" disabled="disabled"><span class="glyphicon glyphicon-ok glyphicon-btn-submit" aria-hidden="true"> salva</span></button> </div>
													<div class="dettagli-fattura-checkbox-invia">
														<div> <input type="checkbox" class="" name="inviaFatturaCommercialista" /><label class="padding">Commercialista (invia copia)</label> </div>
														<div> <input type="checkbox" class="" name="inviaFatturaCliente" /><label class="padding">Cliente (invia copia)</label> </div>
													</div>
												</div>
											</td>
											<td></td>
											<td></td>
											<td><output name='totaleDettagli' class='input-box-number form-control' id='totaleFattura'></output></td>
										</tr ></tbody>
								</table>
							</div>
									<!-- /.table-responsive -->
									<!-- /.panel-body -->
					</form>
					<div class="panel panel-primary">
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
					</div>
					<!-- /.container-fluid -->
					</div>
					</div>
					</div>
					<!-- /#wrapper -->
					<?php $this->load->view('templates/footer');?>
					<!-- +++++++++++++++++++++++++++++++++ functions ++++++++++++++++++++++++ -->
	<script>
var countRows = 0;
var maxTableRows = 20;
var indexRow = 0;

function checkFieldForm()
{
	var addRow = false;
	var form = document.getElementById("formFattura");
	var descrizione = form.elements["descrizione[]"];
	var qt = form.elements["qta[]"];
	var prezzo = form.elements["prezzoUnitario[]"];
	//var value;
	var indexTable = descrizione.length;
	if (indexTable < 1 || indexTable == null)
	{
		if (document.getElementById("descrizione1").value == "" || document.getElementById("qta1").value == "" || document.getElementById("pu1").value == "")
		{
			addRow = false;
		}
		else
		{
			//window.alert('ms');
			addRow = true;
		}
	}
	else
	{
		for (var i = 0; i < indexTable; i++)
		{
			if ((descrizione[i].value != "" && descrizione[i].value != null) &&
				(qt[i].value != "" && qt[i].value != null) &&
				(prezzo[i].value != "" && prezzo[i].value != null))
			{
				addRow = true;
			}
			else
			{
				addRow = false;
				break;
			}
		}
	}
	//varControl.value = "toggle";
	toggleAddRow(addRow);
	toggleSubmit(addRow);
}
//Nuova fattura: abilita/disabilita il bottone + 
function toggleAddRow(add)
{
	//varControl.value = add;
	if (add == true)
	{
		document.getElementById("buttonAddRow").removeAttribute("disabled");
	}
	else
	{
		var element = document.getElementById("buttonAddRow");
		element.setAttribute("disabled", "disabled");
	}
}

function calculate(index)
{
	var qta = document.getElementById("qta" + index).value;
	var prezzo = document.getElementById("pu" + index).value;
	document.getElementById("tot" + index).value = prezzo * qta;
	showTotale();
	checkFieldForm();
}

function showTotale()
{
	var form = document.getElementById("formFattura");
	var totaleRiga = form.elements['totale[]'];
	var imponibileCheckbox = form.elements['imponibile[]'];
	var applicaIrpef = form.elements.formCheckIrpef.checked;
	var irpef = form.elements.formIrpef.value;
	var applicaEnpapi = form.elements.formCheckEnpapi.checked;
	var enpapi = form.elements.formEnpapi.value;
	var applicaIva = form.elements.formCheckIva.checked;
	var iva = form.elements.formIva.value;
	var totaleImponibile = 0.0;
	var totaleNonImponibile = 0.0;
	var totaleFattura = 0.0;
	var count = totaleRiga.length;
	if (count == null)
	{
		if (imponibileCheckbox.checked)
		{
			totaleImponibile += Number(totaleRiga.value);
		}
		else
		{
			totaleNonImponibile += Number(totaleRiga.value);
		}
	}
	else
	{
		for (i = 0; i < count; i++)
		{
			if (imponibileCheckbox[i].checked)
			{
				totaleImponibile += Number(totaleRiga[i].value);
			}
			else
			{
				totaleNonImponibile += Number(totaleRiga[i].value);
			}
		}
	}
	totaleFattura = totaleImponibile + totaleNonImponibile;
	var totaleIrpef = ((applicaIrpef) ? totaleImponibile * Number(irpef) / 100 : 0);
	var totaleEnpapi = ((applicaEnpapi) ? totaleImponibile * Number(enpapi) / 100 : 0);
	var totaleNetto = totaleImponibile - totaleIrpef + totaleEnpapi;
	var totaleIva = ((applicaIva) ? totaleImponibile * Number(iva) / 100 : 0);
	document.getElementById("totaleFattura").innerHTML = totaleFattura;
	document.getElementById("totaleImponibile").innerHTML = totaleImponibile;
	document.getElementById("totaleRitenutaIrpef").innerHTML = totaleIrpef;
	document.getElementById("totaleContributoEnpapi").innerHTML = totaleEnpapi;
	document.getElementById("totaleNetto").innerHTML = totaleNetto;
	document.getElementById("totaleNonImponibile").innerHTML = totaleNonImponibile;
	document.getElementById("totalePagare").innerHTML = totaleNetto + totaleNonImponibile + totaleIva;
	document.getElementById("totaleIva").innerHTML = totaleIva;
}

function toggleSubmit(add)
{
	if (add == true)
	{
		document.getElementById("inviaFattura").removeAttribute("disabled");
	}
	else
	{
		var element = document.getElementById("inviaFattura");
		element.setAttribute("disabled", "disabled");
	}
}

function insertRow()
{
	var table = document.getElementById("dettaglioFattura");
	var indexRows = (table.rows.length);
	//document.getElementById("righe").value="righe in tabella="+countRows;
	if (countRows >= maxTableRows)
	{
		window.alert('too many rows');
	}
	else
	{
		indexRow++;
		var htmlButtonRows = "";
		var htmlRow = "<tr id='row" + indexRow + "'>";
		var htmlImponibileCheckbox = "<td><input type='number' id='imponibileFlag" + indexRow + "' name='setImponibile[]' value=1 style='display:none'>";
		var htmlInputDescrizione = "<div class='form-group has-success input-group'><span class='input-group-addon'> <input type='checkbox' id='imponibile" + indexRow + "' checked='checked' name='imponibile[]' onchange='showTotale();' ></span><input type='text' class='input-box-descrizione form-control has-success' id='descrizione" + indexRow + "' name='descrizione[]' value='' onchange='checkFieldForm()' placeholder='descrizione...'>	</div></td>";
		var htmlinputQuantita = "<td><div class=form-group has-success'>	<input type='text' class='input-box-number form-control has-success' id='qta" + indexRow + "' name='qta[]' onchange='calculate(" + indexRow + ")' ></div></td>";
		var htmlInputPrezzoUnitario = "<td><div class=form-group has-success'>	<input type='number' step='0.01' onchange='parseNumber()' form-control has-success' id='pu" + indexRow + "' name='prezzoUnitario[]' onchange='calculate(" + indexRow + ")' ></div></td>";
		var htmlTotaleRiga = "<td><output class='input-box-number form-control has-success' id='tot" + indexRow + "' name='totale[]' ></td>";
		if (indexRow == 1)
		{
			htmlButtonRows = "<td> <button type='button' class='btn btn-primary' id='buttonAddRow' onclick='insertRow();' disabled='disabled'><span class='glyphicon glyphicon-plus' aria-hidden='true'></span></button> </td></tr>";
		}
		else
		{
			htmlButtonRows = "<td><button type='button' class='btn btn-primary btn-minus'   onclick='deleteRow(" + indexRow + ")'><span class='glyphicon glyphicon-minus' aria-hidden='true'></span>" + "</button></td></tr>";
		}
		table.insertRow(indexRows - 1).outerHTML = htmlRow + htmlImponibileCheckbox + htmlInputDescrizione + htmlinputQuantita + htmlInputPrezzoUnitario + htmlTotaleRiga + htmlButtonRows;
		countRows++;
		showTotale();
		toggleAddRow(false);
		toggleSubmit(false);
	}
}

function deleteRow(index)
{ //Nuova fattura:eleimina una riga dalla tabella dettagli fattura
	countRows = (countRows > 1 ? countRows-- : 0);
	document.getElementById("row" + index).outerHTML = "";
	showTotale();
	checkFieldForm();
}
function parseNumber()
{
	parseFloat($(this).val()).toFixed(2);
}
$(document).ready(function()
{
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
	$('#datepicker').datepicker(
	{
		format: "dd/mm/yyyy",
		language: "it",
		todayHighlight: true,
		autoclose: true
	});
	
});
insertRow();
					</script>
</body>

</html>