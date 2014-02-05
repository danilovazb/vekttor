<?php
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
		 
		if($_GET['acao'] == 'cadastra'){
				$transferencia_id = $_POST['transferencia'];
				$produto_id       = $_POST['produto_id'];
				$origem           = $_POST['origem'];
				$destino          = $_POST['destino'];
				$qtd              = $_POST['qtd'];
				
				// Consulta na tabela produto para pegar suas informaçoes Ex.: valor_ini = preco_compra 
				$produto = mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id = ".$produto_id." AND vkt_id = '$vkt_id'"));
				$estoque_mov_origem = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_mov WHERE produto_id = '".$produto_id."' AND almoxarifado_id = '".$origem."' AND vkt_id = '$vkt_id' ORDER BY id DESC LIMIT 1"));
				$estoque_mov_destino = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_mov WHERE produto_id = '".$produto_id."' AND almoxarifado_id = '".$destino."' AND vkt_id = '$vkt_id' ORDER BY id DESC LIMIT 1"));
				
				$saldo_origem = $estoque_mov_origem->saldo / $produto->conversao2;
				$saldo_destino = $estoque_mov_destino->saldo / $produto->conversao2;
				// saldo / conversao2
				
				// insere o produto na tabela estoque_transferencia_item sendo um item do produto
				mysql_query(" INSERT INTO estoque_transferencia_item 
							SET 
								vkt_id           = '$vkt_id',
								transferencia_id = '$transferencia_id',
								produto_id       = '$produto_id',
								qtd_enviada      = '".qtdBrToUsa($qtd)."',
								valor_ini        = '".$produto->preco_compra."',
								ocorrencia       = '$ocorrencia',
								unidade          = '".$produto->unidade_embalagem."',
								fatorconversao   = '".$produto->conversao."',
								recebido         = 'nao'
				");				
		
				$dados[] = array("produto_id"=>$produto->id,"produto_nome"=>utf8_encode($produto->nome),"conversao2"=>$produto->conversao2,"saldo_origem"=>substr($saldo_origem,0,4),"saldo_destino"=>substr($saldo_destino,0,4), "embalagem"=>substr($produto->unidade_embalagem,0,3),"qtd"=>$qtd,"id"=>mysql_insert_id());
				echo json_encode($dados);
				//print_r($dados);
		} // fim de if acao
		
		if($_GET['acao'] == 'upqtd'){
				$qtd              = qtdBrToUsa($_POST['qtd'],2);
				$produto          = $_POST['id_p'];
				$transferencia_id = $_POST['trans_id'];
				$item_id          = $_POST['item_id'];
				$unidade_tipo     = $_POST['und'];
				$fator_conversao  = $_POST['conversao'];
				
				if($unidade_tipo=='unidade_uso'){
					$qtd = $qtd/$fator_conversao;  
				}
				
				//$qtd = $qtd);
				
				
				mysql_query($t=" UPDATE estoque_transferencia_item SET qtd_enviada = '$qtd', unidade_tipo='$unidade_tipo' WHERE produto_id = '$produto' AND transferencia_id = '$transferencia_id' AND vkt_id = '$vkt_id' AND id = '$item_id'");	
				
				echo $qtd;
				
		}
		
		if($_GET['acao'] == 'exclui'){
				$produto = $_POST['produto'];
				$item_id = $_POST['item_id'];
				mysql_query(" DELETE FROM estoque_transferencia_item WHERE id = '".$item_id."' AND vkt_id = '$vkt_id' ");	
		}
		
		if($_GET['acao'] == 'cancelar'){
				$trans_id = $_POST['trans_id'];
				mysql_query(" UPDATE estoque_transferencia SET status = '3' WHERE id = '".$trans_id."' AND vkt_id = '$vkt_id' ");
				//mysql_query(" DELETE FROM estoque_transferencia_item WHERE transferencia_id = '".$trans_id."'");
		}
		if($_GET['acao'] == 'oc_pedido'){
				$trans_id  = $_POST['trans_id'];
				$oc_pedido = $_POST['oc_pedido'];
				mysql_query(" UPDATE estoque_transferencia SET ocorrencia_pedido = '$oc_pedido' WHERE id='$trans_id' AND vkt_id = '$vkt_id' ");
		} // atualiza ocorrencia item do pedido
		if($_GET['acao'] == 'oc_pedido_item'){
				
				$oc_item          = iconv('utf-8','iso-8859-1',$_POST['oc_item']);
				$produto_id       = $_POST['p'];
				$item_id          = $_POST['item_id'];
				$transferencia_id = $_POST['trans_id'];
				
				mysql_query($t=" UPDATE estoque_transferencia_item SET ocorrencia = '$oc_item' WHERE produto_id = '$produto_id' AND transferencia_id = '$transferencia_id' AND vkt_id = '$vkt_id' AND id = '$item_id'
				");	
				
		}
		if($_GET['acao'] == 'marcar'){
				
				$item_id=$_GET['item_id'];
				$marcado=$_GET['marcado'];
				
				mysql_query($t=" UPDATE estoque_transferencia_item SET marcado = '$marcado' WHERE id = '$item_id' AND vkt_id = '$vkt_id'
				");	
				
		}
		if($_GET['acao']=='altera_comensal'){
			$comensal=MoedaBrToUsa($_POST['comensal']);
			$transferencia_id=$_POST['transferencia_id'];
			$id_origem=$_POST['id_origem'];
			$id_destino=$_POST['id_destino'];
			mysql_query($t="UPDATE estoque_transferencia SET comensal='$comensal' WHERE id='$transferencia_id' AND vkt_id='$vkt_id'");
			//alert($t);
			//echo "<script>location.href='?tela_id=518&acao=edit&id=$transferencia_id&id_origem=$id_origem&id_destino=$id_destino&status=0'";
			
			exit();
		}
		if($_GET['acao']=='altera_gramatura'){
			$gramatura=qtdBrToUsa($_POST['gramatura']);
			$produto_id=$_POST['produto_id'];
			$transferencia_id=$_POST['transferencia_id'];
			$item_id=$_POST['item_id'];
			mysql_query($t="UPDATE estoque_transferencia_item SET gramatura='$gramatura' WHERE id='$item_id'");
			mysql_query($t1="UPDATE produto SET gramatura='$gramatura' WHERE id='$produto_id' AND vkt_id='$vkt_id'");
			//alert($t);
			//echo "<script>location.href='?tela_id=518&acao=edit&id=$transferencia_id&id_origem=$id_origem&id_destino=$id_destino&status=0'";
			echo $t."<br>".$t1;
			exit();
		}
		if($_GET['acao'] == 'duplica_item'){
				
				$item_id=$_POST['item_id'];
				$comensais = $_POST['comensais'];	
				$al=$_POST['al'];
				$cont_tbody= $_POST['cont_tbody'];			
				
				if($al=='al'){
					$al='';
				}else{
					$al='al';
				}
				
				$item_transferencia=mysql_fetch_object(mysql_query($t="SELECT *, eti.id as item_id FROM estoque_transferencia_item eti, estoque_transferencia et, produto p
				WHERE 
				eti.id = '$item_id' AND 
				eti.transferencia_id=et.id AND
				eti.produto_id=p.id AND
				eti.vkt_id = '$vkt_id'"));	
				//echo $t." ".$item_transferencia->id;
				mysql_query("INSERT INTO estoque_transferencia_item 
							SET 
								vkt_id           = '$vkt_id',
								transferencia_id = '".$item_transferencia->transferencia_id."',
								produto_id       = '".$item_transferencia->produto_id."',
								qtd_enviada      = '".$item_transferencia->qtd_enviada."',
								valor_ini        = '".$item_transferencia->valor_ini."',
								ocorrencia       = '".$item_transferencia->ocorrencia."',
								unidade          = '".$item_transferencia->unidade."',
								fatorconversao   = '".$item_transferencia->conversao."',
								recebido         = '".$item_transferencia->recebido."',
								unidade_tipo     = '".$item_transferencia->unidade_tipo."',
								marcado          = '".$item_transferencia->marcado."'
					");
					$item_transferencia_id = mysql_insert_id();
				
							//saldo destino
			$estoque_mov_destino = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_mov WHERE produto_id = '".$item_transferencia->produto_id."' AND almoxarifado_id = '".$item_transferencia->unidade_id_origem."' AND 
			vkt_id = '$vkt_id' ORDER BY id DESC LIMIT 1"));
			$saldo_destino = ($estoque_mov_destino->saldo / $item_transferencia->conversao2);
				   //saldo origem
				   $estoque_mov_origem = mysql_fetch_object(mysql_query(" SELECT * FROM estoque_mov WHERE produto_id = '".$item_transferencia->produto_id."' AND almoxarifado_id = '".$item_transferencia->unidade_id_origem."' AND vkt_id = '$vkt_id' ORDER BY id DESC LIMIT 1"));
				   $saldo_origem = ($estoque_mov_origem->saldo / $item_transferencia->conversao2);
				   $qtd = $item_transferencia->qtd_enviada;
				   if($item_transferencia->unidade_tipo=="unidade_uso"){
				   		$qtd = $qtd*$item_transferencia->conversao2;
				   }
			if($item_transferencia->marcado=='sim'){$marcado="checked='checked'";}	
        
		$t="
		<tr id='$item_transferencia->produto_id' class='$al' item-id='$item_transferencia_id' cont_tbody='$cont_tbody'>
          <td width='30'></td>
          <td width='30'><input type='checkbox' name='marcado[]' class='marcado'
		  $marcado/></td>
          <td width='160'>".utf8_encode($item_transferencia->nome)."</td>
          <td width='60'>".qtdUsatoBr($item_transferencia->gramatura,2)."</td>
          
          <td width='60' class='qtd_calc'>".qtdUsatoBr(($item_transferencia->gramatura*$comensais),2)." ".substr($item_transferencia->unidade_uso,0,2)."</td>
          <td class='dg'>
            <input type='hidden' name='produtoID[]' id='produtoID' value='$item_transferencia->produto_id'>
            <input type='hidden' name='conversao2[]' id='conversao2' value='$item_transferencia->conversao2'>
            <input type='text' $disable name='qtd_bd[]' id='qtd_bd' class='qtd_pedida'  size='5' lang='qtd_pedida$cont' style='font-size:11px;' 
            value='".qtdUsatoBr($qtd,2)."' />		
            <select class='und' name='und[]' style='width:50px;'>
            	<option value='unidade_embalagem' $disable $sel[unidade_embalagem]>".substr($item_transferencia->unidade_embalagem,0,2)." ".qtdUsaToBr($item_transferencia->conversao2).' '.substr($item_transferencia->unidade_uso,0,2)."
                </option>
                <option value='unidade_uso'  $sel[unidade_uso]>".substr($item_transferencia->unidade_uso,0,2)."</option></select>
          	<input type='hidden' name='conversao[] class='conversao' value='$item_transferencia->conversao2'/>
          </td>
          <td width='75' align='right'>
		  <input type='hidden' name='saldo_origem[]' id='saldo_origem' value='$saldo_origem' class='saldoOrigem$cont'>
		  ".substr($saldo_origem,0,4)." ".substr($item_transferencia->unidade_embalagem,0,3)."
          </td>
          <td width='75' align='right'>".substr($saldo_destino,0,4)." ".substr($item_transferencia->unidade_embalagem,0,3)."</td>
          <td width='150' align='right'><input type='text' name='oc_pedido_item' id='oc_pedido_item' value='$item_transferencia->ocorrencia' $disable style='font-size:11px;'></td>
          
          	   	
          
          <td><a target='carregador' class='mais' style='float:left'></a></td>
        </tr>";
		echo $t;
}
?>
		