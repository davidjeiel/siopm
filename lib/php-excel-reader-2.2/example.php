<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once 'excel_reader2.php';

$data = new Spreadsheet_Excel_Reader("CRI_Maio.xls");

?>
<html>
<head>
<style>

</style>
</head>

<body>

<?php 


	$tabela = "<table border='1'> <th>Data do Evento</th> <th>Ativo</th> <th>Evento</th> <th>Valor (R$)</th>"; 
	$td ="</td><td>";

		for( $i=1; $i <= $data->rowcount($sheet_index=0); $i++ ){ 
			
			$dataEvento = (strlen($data->val($i, 1)) > 0)? $data->val($i, 1): $dataEvento;
			$ativo = (strlen($data->val($i, 2)) > 0)? $data->val($i, 2): $ativo;
			
			$tabela .= "<tr><td>". $dataEvento . $td . $ativo . $td . $data->val($i, 5)	. $td. $data->val($i, 6). "</td></tr>"; 
		} 

$tabela .= "</table> Total: " . $data->rowcount($sheet_index=0); 

echo $tabela;
?> 



</body>

</html>
<!-- Agora é listar os dados das linhas e colunas.  -->

