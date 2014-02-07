<?
function salvaPainel($dados){
	global $vkt_id;
	if($dados['id']>0){$id=$dados['id'];}
	if($id>0){
		$sql_ini	=" UPDATE 			";
		$sql_fim	=" WHERE id='$id' 	";
	}else{
		$sql_ini	=" INSERT INTO 		";
	}
	$sql			= "
	$sql_ini paineis
		SET
			vkt_id='$vkt_id',
			financeiro_conta_id				='{$dados['financeiro_conta_id']}',
			financeiro_centro_de_custo_id 	='{$dados['financeiro_centro_de_custo_id']}',
			financeiro_plano_de_conta_id  	='{$dados['financeiro_plano_de_conta_id']}',
			nome							='{$dados['nome']}',
			descricao						='{$dados['descricao']}',
			endereco						='{$dados['endereco']}',
			numero							='{$dados['numero']}',
			bairro							='{$dados['bairro']}',
			cidade							='{$dados['cidade']}',
			estado							='{$dados['estado']}',
			seg_ini							='{$dados['seg_ini']}',
			seg_fim							='{$dados['seg_fim']}',
			ter_ini							='{$dados['ter_ini']}',
			ter_fim							='{$dados['ter_fim']}',
			qua_ini							='{$dados['qua_ini']}',
			qua_fim							='{$dados['qua_fim']}',
			qui_ini							='{$dados['qui_ini']}',
			qui_fim							='{$dados['qui_fim']}',
			sex_ini							='{$dados['sex_ini']}',
			sex_fim							='{$dados['sex_fim']}',
			sab_ini							='{$dados['sab_ini']}',
			sab_fim							='{$dados['sab_fim']}',
			dom_ini							='{$dados['dom_ini']}',
			dom_fim							='{$dados['dom_fim']}'
	$sql_fim
	";
	$salvou=mysql_query($sql);
	if($id>0){
		$painel_id=$id;
	}else{
		$painel_id=mysql_insert_id();
	}
	if($salvou){
		foreach($dados['planos'] as $i=>$p){
			if(trim($p['nome'])!=''){
				salvaPlanoPainel($p,$painel_id);
			}else{
				if(($p['id']*1)>0){
					deletaPlanoPainel(array('id'=>$p['id']));
					
				}
			}
		}
	}
	return $painel_id;
}
	
function salvaPlanoPainel($dados,$painel_id){
	global $vkt_id;
	if($dados['id']>0){$id=$dados['id'];}
	if($id>0){
		$sql_ini	=" UPDATE ";
		$sql_fim	=" WHERE id	='$id' ";
	}else{
		$sql_ini	=" INSERT INTO ";
	}
		$sql		= "
	$sql_ini paineis_planos
		SET
			nome			='{$dados['nome']}',
			painel_id		='$painel_id',
			insercoes		='{$dados['insercoes']}',
			dias			='{$dados['dias']}',
			valor			='".moedaBrToUsa($dados['valor'])."',
			descricao		='{$dados['descricao']}'
	$sql_fim
	";
	$salvou=mysql_query($sql);
}
	
function deletaPainel($id){
	if($id>0){
		$deletou=mysql_query("DELETE FROM paineis WHERE id='$id'");
		if($deletou){
			deletaPlanoPainel(array('painel_id'=>$id));
		}
	}
	
}

function deletaPlanoPainel($params){
	$i=0;
	$sql="";
	foreach($params as $parametro=>$valor){
		if($i==0){
			$sql.=" WHERE $parametro = '$valor' ";
		}else{
			$sql.=" AND $parametro = '$valor' ";
		}
		$i++;
	}
	$deletou=mysql_query($a="DElETE FROM paineis_planos $sql ");
	//echo $a."<br/>";
}