<?php
include("../../../_config.php");
include("../../../_functions_base.php");
	
		$data_ini = $_GET['data_ini'];
		$data_fim = $_GET['data_fim'];
		
			
		
		$data_ini = dataBrToUsa($data_ini);
		$data_fim = dataBrToUsa($data_fim);
		
		
		if(!empty($_GET['contrato'])){
				$contrato_id = $_GET['contrato'];	
				$contrato = " AND contrato_id = ".$contrato_id;
		}
			
		$sql = mysql_query("
						SELECT *, 
							cf.razao_social as razao,
							cc.data as data_cc,
							cc.id   as c_id			 			  
						
						FROM cozinha_controle_consumo cc
						
						JOIN cozinha_contratos ct
	  					  	ON cc.contrato_id=ct.id
					    JOIN cliente_fornecedor cf
	                      	ON ct.cliente_id = cf.id
	  
	 	 				WHERE cc.vkt_id = '$vkt_id'
						
						AND cc.data >= '".$data_ini."'
	 	 				AND cc.data <= '".$data_fim."'
						
						$contrato
						
				");
				
				while($r=mysql_fetch_object($sql)){
					$valor_cafe   = ($r->consumido_cafe * $r->cafe_valor);
					$valor_almoco = ($r->consumido_almoco * $r->almoco_valor);
					$valor_lanche = ($r->consumido_lanche * $r->lanche_valor);
					$valor_janta =  ($r->consumido_jantar * $r->janta_valor);
				}
					$total = ($valor_cafe+$valor_almoco+$valor_lanche+$valor_janta)
		
		
?>
 <label style="width:100px;">Valor
          <div style="padding:2px;"><input name="valor" id="valor" style="width:70px;" value="<?=moedaUsaToBr($total)?>" /></div>
 </label>