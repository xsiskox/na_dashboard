<?php
$my_cv=$this->na_cv->get_sections();
$icons=$this->na_cv->get_icons();
$sezioni=array_keys($my_cv);
$cv_index=0;
$portlet_color="";
$method="edit_cv";
foreach($sezioni as $sez)
{
	$section=$my_cv[$sez];
	switch($sez)
		{
			case $this->na_cv::IP:
				$meta_key_array=array_flip($this->na_cv->get_metakey_ip());
				$portlet_color='portlet-green';
				$text_color='text-warning';
				break;
			case $this->na_cv::CP:
				$meta_key_array=array_flip($this->na_cv->get_metakey_cp());
				$portlet_color='portlet-pink';
                $text_color='text-pink';
				break;
			case $this->na_cv::EP:
				$meta_key_array=array_flip($this->na_cv->get_metakey_ep());
				$portlet_color='portlet-blue';
                $text_color='text-blue';
				break;
			case $this->na_cv::IFO:
				$meta_key_array=array_flip($this->na_cv->get_metakey_if());
				$portlet_color='portlet-yellow';
                $text_color='text-yellow';
				break;
		}
	echo"<div class='portlet box {$portlet_color}'><div class='portlet-header'><div class='caption'>{$sez}</div>
				<div class='actions'><a href='#' class='btn btn-sm btn-white' onclick='viewContent(\"$method\")'><i class='fa fa-edit'></i>&nbsp;
        Edit</a>&nbsp;<a href='#' class='btn btn-sm btn-white'><i class='fa fa-user'></i>&nbsp;
        User</a></div></div><div class='portlet-body'><dl class='dl-horizontal'>";
				$keys=array_keys($section);
				foreach($keys as $key)
				{

                    if ($section[$key]!=='') {
                        $i = $meta_key_array[$key];
                        if (array_key_exists($i, $icons)) {
                            $icon = ($icons[$i] !== "") ? $icons[$i] : "";
                        }
                        else{$icon="";}
                        $my_html = "<dt>{$key}   <span class='glyphicon $icon' aria-hidden='true'></span></dt><dd>{$section[$key]}</dd>
<br>";
                        echo $my_html;
                    }

				}

    echo "</dl></div></div>";


}
?>

