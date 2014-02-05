<?php
//Includes
// configuraчуo inicial do sistema
include("../../../_config.php");
// funчѕes base do sistema
include("../../../_functions_base.php");

	if($_GET['acao'] == 'desperdicio'){
			$id          = $_POST['ficha_id'];
			$desperdicio = moedaBrToUsa($_POST['desperdicio']);
			
				$sql=" UPDATE cozinha_cardapio_dia_refeicao
							SET 
								desperdicio = '$desperdicio'
							WHERE id = $id
						";
				mysql_query($sql);
	}
?>