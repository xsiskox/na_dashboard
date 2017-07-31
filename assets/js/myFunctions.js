
function closePopup(e)
{/*-- chiude la finestra dettagli fattura nella vista elenco fatture --*/
	
	$('#slide').slideUp('fast');
	$('#popup-form').fadeOut();
}
function showTableDettagli(table)
{/*-- mostra la finestra pop-up dettagli fattura --*/
	var index = table.rowIndex;
	var tableRow = document.getElementById("elencoFatture").rows[index];
	var id = tableRow.cells[0].innerHTML;
	var popup = $('#popup-form');
	var slide = $('#slide');
	var panelHeading = popup.find('div').filter('.panel-heading');
	var url = "?/dashboard/get_dettaglio/";
	popup.draggable();
	popup.width('600px');
	popup.fadeIn();
	slide.slideUp('fast');
	panelHeading.html("N.: " + tableRow.cells[1].innerHTML + "<div>cliente: " + tableRow.cells[2].innerHTML + "</div><div>data: " + tableRow.cells[3].innerHTML + "</div>");
	$.ajax(
		{
			type:'post',
			url:url,
			data:
			{
				"fattura":id
			},
			success:function(data)
			{
				var element=$('#dettaglioFattura');
				element.find('tbody').html(data);
				slide.slideDown('fast');
			}
		}
	);
}
function viewContent(method)
{
	var url = "?/dashboard/"+method+"/";
	var param={'msg':''};
	switch(method)
	{
		case 'elenco_fatture':
			var anno = $('#optionAnno').val();
			param={'anno':anno};
			break;
	}
	$.ajax(
		{
			type: 'post',
			url: url,
			data:param,
			success: function (data) {$('#page-wrapper').html(data);}
		}
	);
}

function refresh()
{/*-- aggiorna elenco fatture (filtra le fatture in base anno,cliente,pagato) --*/
	var anno = $('#optionAnno').val();
	var cliente=$('#optionCliente').val();
	var status=$('#optionStatus').val();
	//var url="<?php echo site_url('dashboard/Elenco_fatture/refresh_view');?>";
	var url = "?/dashboard/refresh_view/";
	$.ajax(
	{
		type: "post",
		url: url,
		data:
		{
			"anno": anno,
			"cliente":cliente,
			"status":status
		},
		success: function(data)
		{
			var element=$('#elencoFatture');
			element.find('tbody').html(data);
		}
	});
}
/*-- ------------------------------------------ --*/
/**
 * nuova fattura view
 */


function checkFieldForm()
{
	var addRow = false;
	var submit=false;
	var form = document.getElementById("formFattura");
	var dataFattura=document.getElementById('inputDate');
	var descrizione = form.elements["descrizione[]"];
	var qt = form.elements["qta[]"];
	var prezzo = form.elements["prezzoUnitario[]"];
	//var value;
	var elementType=descrizione.nodeName;
	if (elementType==='INPUT')
	{
		addRow=(!(document.getElementById("descrizione1").value === "" || document.getElementById("qta1").value === "" || document.getElementById("pu1").value === ""));
	}
	else
	{
		var indexTable = descrizione.length;
		for (var i = 0; i < indexTable; i++)
		{
			if ((descrizione[i].value !== "" && descrizione[i].value !== null) &&
				(qt[i].value !== "" && qt[i].value !== null) &&
				(prezzo[i].value !=="" && prezzo[i].value !== null))
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
	
	if(addRow){submit=(!(dataFattura.value==="" || dataFattura.value===undefined));}
	else{submit=addRow;}
	toggleAddRow(addRow);
	toggleSubmit(submit);
}

//Nuova fattura: abilita/disabilita il bottone + 
function toggleAddRow(add)
{
	//varControl.value = add;
	if (add === true)
	{
		document.getElementById("buttonAddRow").removeAttribute("disabled");
	}
	else
	{
		var element = document.getElementById("buttonAddRow");
		element.setAttribute("disabled", "disabled");
	}
}
function formatNumeral(index)
{
	var prezzo=document.getElementById("pu"+index);
	prezzo.value=numeral(prezzo.value).format('0.00');
}
function calculate(index)
{
	var qta = document.getElementById("qta" + index).value;
	var prezzo = document.getElementById("pu" + index).value;
	document.getElementById("tot" + index).value = numeral(prezzo * qta).format('0.00');
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
	var totaleFattura;
	var count = totaleRiga.length;

	if (count===undefined)
	{
		if (imponibileCheckbox.checked)
		{
			totaleImponibile += Number(totaleRiga.value);
		}
		else {
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
	totaleFattura = numeral(totaleImponibile + totaleNonImponibile).format('0.00');
	var totaleIrpef = ((applicaIrpef) ? totaleImponibile * Number(irpef) / 100 : 0);
	var totaleEnpapi = ((applicaEnpapi) ? totaleImponibile * Number(enpapi) / 100 : 0);
	var totaleNetto = totaleImponibile - totaleIrpef + totaleEnpapi;
	var totaleIva = ((applicaIva) ? totaleImponibile * Number(iva) / 100 : 0);
	document.getElementById("totaleFattura").innerHTML = totaleFattura;
	document.getElementById("totaleImponibile").innerHTML = numeral(totaleImponibile).format('0.00');
	document.getElementById("totaleRitenutaIrpef").innerHTML = numeral(totaleIrpef).format('0.00');
	document.getElementById("totaleContributoEnpapi").innerHTML = numeral(totaleEnpapi).format('0.00');
	document.getElementById("totaleNetto").innerHTML = numeral(totaleNetto).format('0.00');
	document.getElementById("totaleNonImponibile").innerHTML = numeral(totaleNonImponibile).format('0.00');
	document.getElementById("totalePagare").innerHTML =numeral(totaleNetto + totaleNonImponibile + totaleIva).format('0.00');
	document.getElementById("totaleIva").innerHTML = numeral(totaleIva).format('0.00');
}

function toggleSubmit(add)
{
	if (add === true)
	{
		document.getElementById("add_fattura").removeAttribute("disabled");
	}
	else
	{
		var element = document.getElementById("add_fattura");
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
		var htmlinputQuantita = "<td><div class=form-group has-success'>	<input type='number' step='0.01' class='input-box-number form-control has-success' id='qta" + indexRow + "' name='qta[]' onchange='calculate(" + indexRow + ");' ></div></td>";
		var htmlInputPrezzoUnitario = "<td><div class='input-group'><span class='input-group-addon'>€</span><input type='number' step='0.01' class='form-control' id='pu" + indexRow + "' name='prezzoUnitario[]' onchange='calculate(" + indexRow + ");' onblur='formatNumeral(" + indexRow + ");'></div></td>";
		var htmlTotaleRiga = "<td><div class='input-group'><span class='input-group-addon'>€</span><output id='tot" + indexRow + "' name='totale[]' class='form-control'></div></td>";
		
		if (indexRow === 1)
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
	console.log('countRows:'+countRows);
}

function deleteRow(index)
{ //Nuova fattura:eleimina una riga dalla tabella dettagli fattura
	countRows = (countRows > 1 ? --countRows : 0);
	document.getElementById("row" + index).outerHTML = "";
	console.log('countRows:'+countRows);
	showTotale();
	checkFieldForm();
}
function parseNumber()
{
	parseFloat($(this).val()).toFixed(2);
}
function invoicePDF(fattura)
{
	var doc = new jsPDF("p", "mm", "a4");

	var fontSize = 10;
	var startX = 30;
	var startY = 10;
	var footerY = 260;
	doc.setFontSize(fontSize);
	doc.setFont("arial");
	doc.setLineWidth(0.5);
	var x = startX;
	var y = startY;
	var offset = 5;
	var h = 30;
	var w = 50;
	var prestazione="Compenso per prestazioni Infermieristiche (assistenza generale)";
	var imponibile="imponibile € ";
	var irpef="Ritenuta IRPEF (20%) € ";
	var enpapi="Contributo ENPAPI (4%) € ";
	var netto="netto fattura € ";
	var iva="iva(22%) € ";
	var pagare="totale fattura € ";
	var footerText="A partire dal 1° gennaio 2012 in ottemperanza alle previsioni di cui alla legge 12 luglio 2011, n.133 gdgdfgs gdsgfdg gdgfgs g dgg gd gfgfdg sf g " +
		"fdsfdfasdfsdafsdfsdfsdsdfsaf fdsd fds fdsfsdf sfdsf f dsf dsf sdfd fdsf fsdfd fs dfsdf" +
		"fdsfdfsfsfs dfdg fg gt gdfsgg f hdgh sf";
	fattura.intestazione="studio associato pinco pallino";
	fattura.piva="22";
	fattura.indirizzo="via della pace";
	fattura.tel="56789555";
	doc.text(x, y,fattura.intestazione);
	y += offset;
	doc.text(x, y, fattura.piva);
	y += offset;
	doc.text(x, y, fattura.indirizzo);
	y += offset;
	doc.text(x, y, fattura.tel);
	y += offset;
	doc.line(x, y, x + 100, y); // horizontal line
	y += offset * 3;
	x = 150;
	doc.text(x, y, fattura.cliente[0].cliente_nome);
	y += offset;
	doc.text(x, y,fattura.cliente[0].cliente_indirizzo);
	y += offset;
	doc.text(x, y,fattura.cliente[0].cap+" "+fattura.cliente[0].cliente_citta);
	x = startX;
	y += offset * 3;
	doc.rect(x, y, w, h, 'stroke');
	y += offset;
	x += offset;
	doc.text(x, y, 'fattura n.:' + fattura.data[0].fattura_numero);
	y += offset;
	doc.text(x, y, 'data:' + fattura.data[0].fattura_data);
	y += offset;
	doc.text(x, y, 'P.IVA:' + fattura.cliente[0].cliente_piva);
	y += offset;
	doc.text(x, y, 'cliente:' + fattura.cliente[0].cliente_nome);
	y += 20;
	x = startX;
	doc.text(x, y, prestazione);
	y += offset * 2;
	doc.text(x, y, imponibile + fattura.data[0].lordo.toFixed(2));
	y += offset;
	doc.text(x, y, irpef + fattura.data[0].irpef.toFixed(2));
	y += offset;
	doc.text(x, y, enpapi + fattura.data[0].enpapi.toFixed(2));
	y += offset;
	doc.text(x, y, netto + fattura.netto.toFixed(2));
	
	//stampa label iva se >0
	if (fattura.iva>0){y += offset;doc.text(x, y, iva + fattura.iva.toFixed(2));}
	y += offset;
	doc.text(x, y, pagare + fattura.pagare.toFixed(2));
	y = footerY;
	doc.line(x, y, x + 100, y);
	y += offset;
	doc.setFontStyle("bold");
	doc.text(x, y, "footer");
	y += offset;
	doc.setFontStyle("normal");
	doc.text(x, y, "(1)");
	doc.save("hello js.pdf");
}
function btnInvoiceDownload(e,index)
	{
		var tableRow = document.getElementById("elencoFatture").rows[index];
		var id = tableRow.cells[0].innerHTML;
		e.stopPropagation();
		$.ajax({
				type: 'POST',
				url: '?/dashboard/set_invoice_pdf/'+id,
				success:function(data)
				{
					var dati = JSON.parse(data);
					/*dati.imponibile=3244234.565;
					dati.irpef=454543.67756;
					dati.enpapi=123454.5555;
					dati.nonImponibile=112323.567;
					dati.netto = dati.imponibile - dati.irpef;
					dati.totale = dati.netto + dati.enpapi;
					dati.pagare = dati.totale + dati.iva + dati.nonImponibile;*/
					console.log(dati);
					invoicePDF(dati);
				}
			});
			
	}

$(document).ready(function()
{/*-- nav bar action --*/
	var url = "?/dashboard/sidebar_items/";
	var menu_items;
	
	$.ajax(
	{
		type: "post",
		url: url,
		data:
		{
			"request": "request"
		},
		success: function(data)
		{
			menu_items=JSON.parse(data);
			
		}
	});
	$(document).on("click", "[name='menuButton']", function()
	{
		console.log($(this));
		var $menuItem=$(this)[0].id;
		console.log("value="+$menuItem);
		console.log(menu_items);
		for (var i=0;i<menu_items.length;i++)
		{
			if(menu_items[i].title===$menuItem)
			{
				
				viewContent(menu_items[i].method);
			
				break;
			}
		}
		
		
	});
	$(document).on("click","[name='submitForm']",function()
	{// post forms input
		console.log($(this)+'	'+document.forms);
		var btn=$(this)[0].id;
		if (document.forms.length>0)
		{
			var forms='';
			for (var i=0;i<document.forms.length;i++){forms+="#"+document.forms[i].id+",";}
			var index=forms.lastIndexOf(",");
			forms=forms.substring(0,index);
			console.log(forms+'	'+document.forms[0].id);
			$.ajax({
				type:'post',
				url:"?/dashboard/"+$(this)[0].id+"/",
				data:$(forms).serialize(),
				success:function(result)
				{
					console.log(result);
					console.log(btn);
					viewContent(btn);
				}
			});
		}
	});
	
	
	
});

