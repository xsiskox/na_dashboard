<div class="panel panel-primary">
	<div class="panel-heading"> Checkout form</div>
	<div class="panel-body">
		<form id="formCliente">
			<div class="form-body pal">
				<div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon">
								<i class="glyphicon glyphicon-user"></i>
							</span>
							<input type="text" class="form-control"  name="inputRagsoc" placeholder="srl spa onlus privato ..." onchange="checkForm();">
						</div>
					</div>
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							 <input  type="text" placeholder="cognome e nome" name="inputName" class="form-control" /></div>
						</div>
					</div>
				
				<div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
							<input name="inputEmail[]" type="text" placeholder="E-mail" class="form-control" />
						</div>
					</div>
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon"> <i class="fa fa-phone"></i></span>
							<input name="inputPhone[]" type="text" placeholder="telefono" class="form-control" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon"> <i class="fa fa-phone"></i></span>
							<input name="inputPiva" type="text" placeholder="partita iva o codice fiscale" class="form-control" />
						</div>
					</div>
				</div>
				<hr />
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="inputCAP" placeholder="CAP" class="form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input name="inputCity" type="text" placeholder="citta(provincia)" class="form-control" />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input name="inputProvincia" type="text" placeholder="provincia (sigla)" class="form-control" />
						</div>
					</div>
				
				</div>
					
				<div class="form-group"> <input name="inputAddress" type="text" placeholder="indirizzo: via piazza q.re ecc." class="form-control" /></div>
				<div class="form-group"> <textarea rows="5" placeholder="informazioni aggiuntive" class="form-control" name="inputInfo"></textarea></div>
				<hr />
			</div>
			
		<div class="row">
					<div class="col-md-6">
						<div id="new_mail" name="add_mail" class="btn btn-warning btn-lg btn-block"><i class="fa fa-envelope"></i>  aggiuni mail  <i class="fa fa-envelope"></i></div>
					</div>
					<div class="col-md-6">
						<div id="new_phone" name="add_phone" class="btn btn-warning btn-lg btn-block">aggiuni telefono  <i class="fa fa-phone"></i></div>
					</div>
				</div>
		<div class="row">
			<div class="col-md-6" id="show_new_mail"></div>
			<div class="col-md-6" id="show_new_phone"></div>
		</div>
				<hr />
		<div class="row">
				<div class="col-md-12"><div  id="add_cliente" name="submitForm" class="btn btn-success btn-lg btn-block">Fatto</divr></div>
		</div>
	</div>
		</form>	

	</div>
	<script>
		var index_field=0;
	$(document).on("click", "#new_mail", function()
	{
		console.log($(this));
		
		var field='<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span><input name="inputEmail[]" type="text" placeholder="E-mail" class="form-control" /><span class="input-group-btn"><button type="button" name="delete_field" class="btn btn-primary">-</div>';
		if(++index_field<5){$('#show_new_mail').append(field);}
		else{index_field=5;}
		console.log(index_field);
	});
	$(document).on('click',"button[name='delete_field']",function(){
		console.log($(this));
		console.log(index_field);
		var element=$(this).parents('div .input-group');
		
		if(--index_field>=0){element.remove();}
		else{index_field=0;}
		console.log(element);
		
	});
	function checkForm()
	{
		console.log($(this));
	}
	</script>