<?php
$totaleFatturato=0;
$totaleEnpapi=0;
$totaleIrpef=0;
$index=1;
foreach($list as $row)
{
	$totaleFatturato+=floatval($row['lordo']);
	$totaleEnpapi+=floatval($row['enpapi']);
	$totaleIrpef+=floatval($row['irpef']);
	$status=$row['pagato'];
	$labelStatus='';
	$labelPagamento='';
	switch($status)
	{
		case 0:$labelStatus='label-warning';$labelPagamento='da pagare';
			break;
		case 1:$labelStatus='label-success';$labelPagamento='pagato';
			break;
		case 2:$labelStatus='label-danger';$labelPagamento='sospesa';
			break;
	}
	echo'<tr onclick="showTableDettagli(this)">';
	echo'<td style="display:none;">'.$row['fattura_id'].'</td>';
	echo'<td style="width:7em">'.$row['fattura_numero'].'</td>';
	echo'<td>'.$row['cliente_nome'].'</td>';
	echo'<td style="width:7em">'.date_format(date_create($row['fattura_data']),'d/m/Y').'</td>';
	echo'<td>'.number_format($row['lordo'],2,',','.').'</td>';
	echo'<td style="width:5em">'.number_format($row['irpef'],2,',','.').'</td>';
	echo'<td style="width:5em">'.number_format($row['enpapi'],2,',','.').'</td>';
	echo'<td><span class="label '.$labelStatus.'">'.$labelPagamento.'</span></td>';
	echo'<td><button title="scarica questa fattura" onclick="btnInvoiceDownload(event,'.$index.')" type="button" class="btn btn-default" aria-label="Left Align"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></button>'.
	'<button type="button" class="btn btn-default" aria-label="Left Align"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button></td>';
	echo'</tr>';
	$index++;
}
?>