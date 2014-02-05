<?
	include('../../../_config.php');
	include('../../../_functions_base.php');
	include('_functions.php');

	global $vkt_id;

	$produto_id=$_POST['produto_id'];
	$fornecedor_id=$_POST['fornecedor_id'];
	$necessidade_id=$_POST['necessidade_id'];
	
	if($produto_id>0){
		$produto = mysql_fetch_object(mysql_query($t="SELECT * FROM produto WHERE id = ".$produto_id));
	}
	if($_POST['acao']=="criar_cotacao"){
		
		//verifica se a necessidade já existe
		/*$existe_necessidade = mysql_query("SELECT * FROM cozinha_necessidade_item WHERE vkt_id='$vkt_id' AND
						necessidade_id = '$necessidade_id' AND
						produto_id='$produto_id'");
		
		if(!mysql_num_rows($existe_necessidade) > 0){*/
		
		//if()
		$item_id = $_POST['item_id'];
		if(!$item_id>0){
			$sql_inicio="INSERT INTO";
			$sql_fim="";
		}else{
			$sql_inicio="UPDATE";
			$sql_fim="WHERE id='$item_id'";
		}
		mysql_query($t=" $sql_inicio
						  cozinha_necessidade_item 
					  SET 
						  vkt_id='$vkt_id',
						  necessidade_id = '$necessidade_id',
						  produto_id='$produto_id',
						  cotar='sim'
						 $sql_fim
					  ");
					  
		$id=mysql_insert_id();
		if($item_id>0){
			echo $item_id;
		}else{
			echo mysql_insert_id();
		}
							  
		/*  echo "
		  <tr>
			<td width='110' title=".utf8_encode($produto->nome).">".utf8_encode($produto->nome)."
				<input type='hidden' class='produto_id_item' value='$produto->id' />
				<input type='hidden' id='produto_necessidade_id' value='$id' />
			</td>
            <td width='45'><input class='qtd' type='text' sonumero='1' name='qtd[]' size='3'/> ".substr($produto->unidade_embalagem,0,2)."</td>
		    <td width='35'>".number_format($produto->custo/$produto->conversao,2,',','.')."</td>
			<td width='100'>&nbsp;</td>
            <td width='45'>&nbsp;</td>
            <td width='100'>&nbsp;</td>
            <td width='45'>&nbsp;</td>
            <td width='100'>&nbsp;</td>
            <td width='45'>&nbsp;</td>
		    <td></td>
		  </tr>
		  ";*/
		  
		//}
		exit();
	}
	
	if($_POST['acao']=='excluir_item'){
		$item_id = $_POST['item_id'];
		mysql_query($t="UPDATE cozinha_necessidade_item SET cotar='nao' WHERE id=$item_id AND vkt_id='$vkt_id'");
		//mysql_query("DELETE FORM cozinha_cotacao_item WHERE necessidade_id='$necessidade_id'");
		echo $item_id;
		exit();
	}
	
	if($_POST['acao']=="edita_produto_cotacao"){
	
		$qtd = $_POST['qtd'];
		$item_id=$_POST['produto_necessidade_id'];
		$produto_id=$_POST['produto_id'];
		$necessidade_id=$_POST['necessidade_id'];		
		if($item_id>0){
			$sql_inicio="UPDATE";
			$sql_fim="WHERE id='$item_id'";
		}else{
			$sql_inicio = "INSERT INTO";
			$sql_fim    = ",
			necessidade_id='$necessidade_id',
			produto_id='$produto_id',			
			cotar='nao'";
		}
		mysql_query($t=
		"$sql_inicio
			cozinha_necessidade_item
		 SET
		 	vkt_id='$vkt_id',
			qtd_digitada='$qtd'			
		
			$sql_fim
		");
		
		if($item_id>0){
			echo $item_id;
		}else{
			echo mysql_insert_id();
		}
						
		exit(); 
	}
	
	if($_POST['acao']=="duplica_necessidade"){
	
		global $vkt_id;
	
		$necessidade_antiga_id = $_POST['necessidade_id'];
		
		//seleciona os itens da necessidade
		$necessidade_itens = mysql_query($t="SELECT * FROM cozinha_necessidade_item WHERE necessidade_id='$necessidade_antiga_id'");
		$retorno.=$t." ".mysql_error()."<br>";
		mysql_query($t="INSERT INTO 
						cozinha_necessidade 
					SET 
						necessidade_inicio='".DataBrToUsa($_POST['data_inicio'])."',
						necessidade_fim   ='".DataBrToUsa($_POST['data_final'])."'");	
		
		
		$nova_necessidade_id = mysql_insert_id();
		
		//insere os itens da nova necessidade
		while($necessidade_item = mysql_fetch_object($necessidade_itens)){
		
			mysql_query($t="INSERT INTO 
							cozinha_necessidade_item 
						SET
							vkt_id         = '$vkt_id',
							necessidade_id = '$nova_necessidade_id',
							produto_id     = '$necessidade_item->produto_id',
							qtd_digitada   = '$necessidade_item->qtd_digitada',
							obs            = '$necessidade_item->obs'");
			$retorno.=$t." ".mysql_error()."<br>";
		}
		
		//seleciona as cotações da antiga necessidade
		$cotacoes = mysql_query("SELECT * FROM cozinha_cotacao WHERE necessidade_id='$necessidade_antiga_id'");
		
		//insere as novas cotacoes
		while($cotacao = mysql_fetch_object($cotacoes)){
		
			mysql_query("INSERT INTO 
							cozinha_cotacao 
						SET
							vkt_id          = '$vkt_id',
							fornecedor_id   = '$cotacao->fornecedor_id',
							necessidade_id  = '$nova_necessidade_id',
							almoxarifado_id = '$cotacao->almoxarifado_id',
							data_cotacao    = '$cotacao->data_cotacao',
							situacao        = '$cotacao->situacao'");
		
			
			$nova_cotacao_id = mysql_insert_id();
		
			//seleciona os itens da cotação da antiga necessidade
			$cotacoes_itens = mysql_query("SELECT * FROM cozinha_cotacao_item WHERE necessidade_id='$necessidade_antiga_id'");
		
		
			//insere os itens da nova cotacao
			while($cotacao_item = mysql_fetch_object($cotacoes_itens)){
		
				mysql_query("INSERT INTO 
							cozinha_cotacao_item 
						SET
							vkt_id              = '$vkt_id',
							cotacao_id          = '$nova_cotacao_id',
							necessidade_id      = '$nova_necessidade_id',
							necessidade_item_id = '$cotacao_item->necessidade_item_id',
							produto_id          = '$cotacao_item->produto_id',
							qtd_pedida          = '$cotacao_item->qtd_pedida',
							valor_ini           = '$cotacao_item->valor_ini',
							marca               = '$cotacao_item->marca',
							unidade_tipo        = '$cotacao_item->unidade_tipo',
							unidade             = '$cotacao_item->unidade',
							fatorconversao      = '$cotacao_item->fatorconversao',
							fatorconversao2     = '$cotacao_item->fatorconversao2'");
		
			}
		
		}
		
		echo $nova_necessidade_id;
		
		exit();
		
	
	}
	
	
	//echo $t;
	$conta_produto_fornecedor=mysql_result(mysql_query("SELECT COUNT(*) FROM produto_has_fornecedor WHERE fornecedor_id='".$fornecedor_id."' AND produto_id='".$produto_id."' AND vkt_id='".$vkt_id."'"),0,0);
	if($conta_produto_fornecedor<1){
		$query=mysql_query($trace="INSERT INTO produto_has_fornecedor SET fornecedor_id='".$fornecedor_id."', produto_id='".$produto_id."', vkt_id='".$vkt_id."'");
		//echo $trace."<br><br>";
	}
	$item_necessidade = mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_necessidade_item WHERE necessidade_id='".$necessidade_id."' AND produto_id='".$produto_id."'"));
	//echo $t."<br>";
	echo "
		<tr>
        	<td width='90'>".utf8_decode($produto->nome)."	<input type='hidden' class='produto_id' name='produto_id[]' value='$produto->id'/></td>
		 <td width='0' style='display:none'><input type='hidden' class='item_necessidade_id' name='item_necessidade_id[]' value='$item_necessidade->id'/></td>
        	<td width='70'><input type='text' name='marca[]' class='marca' size='7' onblur='direciona(this)' value='$item_cotacao->marca' /></td>
           <td width='45'><span class='qtd_necessidade'>$item_necessidade->qtd_sistema</span>  $item_necessidade->unidade_uso</td>
            <td width='45'><input type='text' name='qtd[]' class='qtd' size='3' value='$item_cotacao->qtd_pedida' onblur='direciona(this)' sonumero='1'/></td>
           <td width='80'>
            <select name='unidade[]' class='und' onchange='direciona(this)'>
              <option  ut = 'compra' value='$produto->unidade'>$produto->unidade</option>			
              <option ut = 'embalagem' value='$produto->unidade_embalagem'>$produto->unidade_embalagem</option>
              <option ut = 'uso' value='$produto->unidade_uso'>$produto->unidade_uso</option>
            </select>
            <input type='hidden' name='conversao' class='conversao' value='$produto->conversao'/>
            <input type='hidden' name='conversao1' class='conversao2' value='$produto->conversao2'/>
            </td>
            <td width='60'><input type='text' name='valor[]' class='valor' value='$item_cotacao->valor_ini' size='5' onblur='direciona(this)' decimal='2'/></td>
        	<td width='50' align='right' class='cz'>".moedaUsaToBr($produto->custo)."</td>
			<td width='60' align='right' class='cz'><span class='qtd_unidade'>";
	       	if($item_cotacao->qtd_pedida>0){
				if($ut=='compra'){
					//echo $ut;
					$qtd_unidade   = $item_cotacao->qtd_pedida;
					$qtd_embalagem = $qtd_unidade*$item_cotacao->fatorconversao;
					$qtd_uso	   = $qtd_unidade*$item_cotacao->fatorconversao2*$item_cotacao->fatorconversao;
		
					$vlr_unidade   = $item_cotacao->valor_ini;
					$v_embalagem   = ($vlr_unidade/$item_cotacao->fatorconversao)/$qtd_unidade;
					$v_uso		   = $v_embalagem/$item_cotacao->fatorconversao2;
					//echo $vlr_unidade."<br>";
				}
				if($ut=='embalagem'){
					//echo $ut;
					$qtd_embalagem 	= $item_cotacao->qtd_pedida;
					$qtd_unidade 	= $item_cotacao->qtd_pedida/$item_cotacao->fatorconversao;
					$qtd_uso		= $item_cotacao->qtd_pedida*$item_cotacao->fatorconversao2;
		
					$v_embalagem	= $item_cotacao->valor_ini;
					$vlr_unidade 	= $v_embalagem*$item_cotacao->fatorconversao;
					$v_uso			= $v_embalagem/$item_cotacao->fatorconversao2;
					//echo $vlr_unidade."<br>";
				}
				if($ut=='uso'){
					//echo $ut;
					$qtd_uso		= $item_cotacao->qtd_pedida;
					$qtd_embalagem 	= $qtd_uso*$item_cotacao->fatorconversao2;
					$qtd_unidade 	= $item_cotacao->qtd_pedida/$item_cotacao->fatorconversao;
		
					$v_uso			= $item_cotacao->valor_ini;
					$v_embalagem	= $v_uso*$item_cotacao->fatorconversao2;
					$vlr_unidade 	= $v_embalagem*$item_cotacao->fatorconversao;
					//echo $vlr_unidade."<br>";
				}
				}
				$total = $item_cotacao->qtd_pedida * $item_cotacao->valor_ini;
			?>
			<?=number_format($qtd_unidade,2,",",".")?></span> <?=substr($produto->unidade,0,2)?>
        <?	echo"
            </td>
            <td width='50' align='right' class='v_compra cz'>".number_format($vlr_unidade,2,",",".")."</td>
            <td width='50' align='right' class='cz'><span class='qtd_embalagem'>$qtd_embalagem</span>".substr($produto->unidade_embalagem,0,2)."</td>
            <td width='50' align='right' class='v_embalagem cz'>".number_format($v_embalagem,2,",",".")."</td>
           <td width='50' align='right' class='cz'><span class='qtd_uso'>".number_format($qtd_uso,2,",",".")."</span>".substr($produto->unidade_uso,0,2)."</td>
           <td width='50' align='right' class='v_uso cz'>".number_format($v_uso,2,",",".")."</td>
            <td width='50' align='right' class='v_total'>".number_format($total,2,",",".")."</td>
            <td>
				<img src='../fontes/img/menos.png' width='18' height='18' onclick='removeItem(this)' class='remove'/>
				<span style='display:none;' id='item$cont' class='item'>$item_cotacao->id</span>
			</td>
	</tr>
	";
	?>