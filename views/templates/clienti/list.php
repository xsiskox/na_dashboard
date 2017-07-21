<?php
foreach($list as $row)
{
	
	echo'<tr>';
	echo'<td style="display:none;">'.$row['id'].'</td>';
	echo'<td style="width:7em">'.$row['cliente_nome'].'</td>';
	echo'<td style="width:7em">'.$row['cliente_piva'].'</td>';
	echo'<td style="width:7em">'.$row['cliente_indirizzo'].'</td>';
	echo'<td><button title="scarica questa fattura" onclick="" type="button" class="btn btn-default" aria-label="Left Align"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></button>'.
	'<button type="button" class="btn btn-default" aria-label="Left Align"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button></td>';
	echo'</tr>';
	
}