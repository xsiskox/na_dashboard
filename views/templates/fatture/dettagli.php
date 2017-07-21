<?php
$totaleImponibile=0;
$totaleNonImponibile=0;
foreach($list as $row)
					{
						$totaleRiga=floatval($row['quantita']*$row['prezzo_unitario']);					
						if($row['imponibile']==1){$totaleImponibile+=$totaleRiga;}else{$totaleNonImponibile+=$totaleRiga;}
						$style=($row['imponibile']==1?"class='success' ":"class='active'");
						echo"<tr ".$style."><td>".$row['descrizione']."</td>";
						echo"<td>".$row['quantita']."</td>";
						echo"<td>".number_format($row['prezzo_unitario'],2,',','.')."</td>";
						//echo"<td>".number_format($row['imponibile'],2,',','.')."</td>";
						echo"<td>".number_format($totaleRiga,2,',','.')."</td>";
						echo"</tr>";	
					}
					echo "<tr class='info'><td>imponibile: €".number_format($totaleImponibile,2,',','.')."</td><td>non imponibile:€".number_format($totaleNonImponibile,2,',','.')."</td></tr>";
					echo 'hello';
?>