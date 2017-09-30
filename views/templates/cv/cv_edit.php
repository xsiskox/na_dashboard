<?php
$my_cv=$this->na_cv->get_sections();
$icons=$this->na_cv->get_icons();
$sezioni=array_keys($my_cv);
$cv_index=0;
$portlet_color="";
foreach($sezioni as $sez)
{
	$section=$my_cv[$sez];
	switch($sez)
		{
			case $this->na_cv::IP:
				$meta_key_array=array_flip($this->na_cv->get_metakey_ip());
				$portlet_color='portlet-green';
				break;
			case $this->na_cv::CP:
				$meta_key_array=array_flip($this->na_cv->get_metakey_cp());
				$portlet_color='portlet-pink';
				break;
			case $this->na_cv::EP:
				$meta_key_array=array_flip($this->na_cv->get_metakey_ep());
				$portlet_color='portlet-blue';
				break;
			case $this->na_cv::IFO:
				$meta_key_array=array_flip($this->na_cv->get_metakey_if());
				$portlet_color='portlet-yellow';
				break;
		}
	echo'<div class="portlet box '.$portlet_color.'"><div class="portlet-header"><div class="caption">'.$sez.'</div>
				<div class="actions"><a href="#" class="btn btn-sm btn-white" name="submitForm" id="cv_update"><i class="fa fa-check"></i>&nbsp;
        Salva</a>&nbsp;<a href="#" class="btn btn-sm btn-white"><i class="fa fa-user"></i>&nbsp;
        User</a></div></div><div class="portlet-body"><form role="form" class="form-horizontal form-separated" id="formCV'.$cv_index++.'"><div class="form-body">';
				$keys=array_keys($section);
				foreach($keys as $key)
				{
                    $i = $meta_key_array[$key];
                    if (array_key_exists($i, $icons)) {
                        $icon = ($icons[$i] !== "") ? $icons[$i] : "";
                    }
                    else{$icon="";}
					/*echo '<div class="form-group form-inline"><label class="col-md-3 control-label">'.$key.'</label>
								<div class="col-md-9"><input class="form-control mrl" value="'.$section[$key].'" name="'.$meta_key_array[$key].'"/>
								<span class="text-warning mts help-block-right">Help block on the right</span></div></div>';*/

                    echo "<div class='form-group'><label class='col-md-3 control-label'>".$key."</label><div class='col-md-8'><div class='input-icon right'><i class='fa {$icon}'></i><input name='$meta_key_array[$key]' type='text' placeholder='{$key}' class='form-control' value='{$section[$key]}'></div></div></div>";
				}

    echo '</div></form><div id="cv_update" name="submitForm" class="btn btn-success btn-lg btn-block">Fatto</div></div></div>';
				

}
?>

<!--<div class="panel panel-grey">
	<div class="panel-heading">Checkout form</div>
	<div class="panel-body pan">
		<form action="#">
			<div class="form-body pal">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-icon"><i class="fa fa-user"></i><input id="inputFirstName" type="text" placeholder="First Name" class="form-control"></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-icon"><i class="fa fa-user"></i><input id="inputLastName" type="text" placeholder="Last Name" class="form-control"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-icon"><i class="fa fa-envelope"></i><input id="inputEmail" type="text" placeholder="E-mail" class="form-control"></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-icon"><i class="fa fa-phone"></i><input id="inputPhone" type="text" placeholder="Phone" class="form-control"></div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group"><select class="form-control">
								<option>Country</option>
							</select></div>
					</div>
					<div class="col-md-4">
						<div class="form-group"><input id="inputCity" type="text" placeholder="City" class="form-control"></div>
					</div>
					<div class="col-md-4">
						<div class="form-group"><input id="inputPostCode" type="text" placeholder="Post code" class="form-control"></div>
					</div>
				</div>
				<div class="form-group"><input id="inputAddress" type="text" placeholder="Address" class="form-control"></div>
				<div class="form-group"><textarea rows="5" placeholder="Additional info" class="form-control"></textarea></div>
				<hr>
				<div class="form-group">
					<div class="radio"><label class="radio-inline"><div class="iradio_minimal-grey checked" style="position: relative;"><input id="optionsVisa" type="radio" name="optionsRadios" value="Visa" checked="checked" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>&nbsp;
							Visa</label><label class="radio-inline"><div class="iradio_minimal-grey" style="position: relative;"><input id="optionsMasterCard" type="radio" name="optionsRadios" value="MasterCard" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>&nbsp;
							MasterCard</label><label class="radio-inline"><div class="iradio_minimal-grey" style="position: relative;"><input id="optionsPayPal" type="radio" name="optionsRadios" value="PayPal" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>&nbsp;
							PayPal</label></div>
				</div>
				<div class="form-group"><input id="inputNameCard" type="text" placeholder="Name on card" class="form-control"></div>
				<div class="row">
					<div class="col-md-9">
						<div class="form-group"><input id="inputCardNumber" type="text" placeholder="Card number" class="form-control"></div>
					</div>
					<div class="col-md-3">
						<div class="form-group"><input id="inputCVV2" type="text" placeholder="CVV2" class="form-control"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group mbn"><label class="pts">Expiration date</label></div>
					</div>
					<div class="col-md-5">
						<div class="form-group"><select class="form-control">
								<option>Month</option>
							</select></div>
					</div>
					<div class="col-md-3">
						<div class="form-group mbn"><input id="inputYear" type="text" placeholder="Year" class="form-control"></div>
					</div>
				</div>
			</div>
			<div class="form-actions text-right pal">
				<button type="submit" class="btn btn-primary">Continue</button>
			</div>
		</form>
	</div>
</div>-->