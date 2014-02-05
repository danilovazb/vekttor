<?php
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");


	

	
	
	
	if($_GET['acao'] == 'update_qtd_item'){
		
				$id_item = $_POST['id_item'];
				$qtd     = moedaBrToUsa($_POST['qtd']);
				
			mysql_query($t="UPDATE estoque_beneficiamento_item 
							SET 
								qtd_realizada = '$qtd'
							WHERE id = '$id_item' AND
							vkt_id='$vkt_id'
			");
			
	}
	
	if($_GET['acao'] == 'add_derivado'){
		
					$beneficiamento_id = $_POST['beneficiamento_id'];
					$produto_id        = $_POST['produdo_id'];
					$produto           = $_POST['produto'];
					$qtd               = $_POST['qtd'];
					$obs_item          = $_POST['obs_item'];
					
					$sql = " INSERT INTO estoque_beneficiamento_item
									SET
										beneficiamento_id = '".$beneficiamento_id."',
										qtd_realizada     = '".$qtd."',
										produto_id        = '".$produto_id."',	
										obs_recebimento   = '".$obs_item."'
						    ";
					mysql_query($sql);
						//mysql_query($sql);
		
		echo '
		
				<tr>
                    <td width="200" style="border-left:1px solid #CACACA">'.$produto.'</td>
                    <td width="35"></td>
                    <td width="55">'.$qtd.'</td>
                    <td width="130"><input type="text" name="obs_item" value="'.$obs_item.'" style="height:14px; width:124px;"></td>
                </tr>
		
		';
	}
	if($_GET['acao'] == 'desgelo'){
	
				$desgelo        = $_POST['desgelo'];
				$aparas         = $_POST['aparas'];
				$descarte       = $_POST['descarte'];
				$perda          = $_POST['perda'];
				$realizada      = $_POST['qtd_realizada'];
				$beneficiamento = $_POST['beneficiamento'];
				
				$sql="UPDATE estoque_beneficiamento_pedido
								SET 
									desgelo = '$desgelo',
									aparas  = '$aparas',
									descarte= '$descarte',
									perda   = '$perda',
									qtd_realizada = '$realizada'									
								WHERE
									id = $beneficiamento
								";
				mysql_query($sql);
	
	}
	
	if($_GET['acao'] == 'obs_item'){
		
			$obs_item       = $_POST['obs_item'];
			$beneficiamento = $_POST['beneficiamento'];
			$produto_id     = $_POST['produto_id'];
			
				$sql=" UPDATE estoque_beneficiamento_item
						
							SET
								obs_recebimento = '$obs_item'
							WHERE 
								id = '$beneficiamento'
							
				";
				
				mysql_query($sql);
	}

?>