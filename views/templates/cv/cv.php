<?php
$my_cv=$this->na_cv->get_sections();
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
				<div class="actions"><a href="#" class="btn btn-sm btn-white"><i class="fa fa-edit"></i>&nbsp;
        Edit</a>&nbsp;<a href="#" class="btn btn-sm btn-white"><i class="fa fa-user"></i>&nbsp;
        User</a></div></div><div class="portlet-body"><form role="form" class="form-horizontal form-separated" id="formCV'.$cv_index++.'"><div class="form-body">';
				$keys=array_keys($section);
				foreach($keys as $key)
				{
					echo '<div class="form-group form-inline"><label class="col-md-3 control-label">'.$key.'</label>
								<div class="col-md-9"><input class="form-control mrl" value="'.$section[$key].'" name="'.$meta_key_array[$key].'"/>
								<span class="text-warning mts help-block-right">Help block on the right</span></div></div>';
					
				}
				echo '</div></form><div id="cv_update" name="submitForm" class="btn btn-success btn-lg btn-block">Fatto</div></div></div>';
				

}
?>

