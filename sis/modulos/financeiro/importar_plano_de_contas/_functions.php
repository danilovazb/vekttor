<?

function importarPlanoDeContas($dados){
	$modelo_id = $dados['modelo_id'];
	inserir(0,0,$modelo_id,$dados);
	alert("Importação realizada com sucesso.");
	echo "<script>window.location='?tela_id=51'</script>";
	
}
function inserir($pai_id,$pai_modelo,$modelo_id,$dados){
	$pai_nivel[$pai_modelo]=$pai_id;
	if(count($dados['selecionado'])==0){
		alert("Escolha no mínimo 1 plano de conta");
		echo "<script>window.location='?tela_id=562&id_grupo=$modelo_id'</script>";
		return false;
	}elseif(count($dados['selecionado'])>0){
		$modelos_q = mysql_query($a="SELECT * FROM financeiro_centro_custo_modelo WHERE modelo_grupo_id='$modelo_id' AND centro_custo_id='$pai_modelo' ");
		while($modelo=mysql_fetch_object($modelos_q)){
			
			if(in_array($modelo->id,$dados['selecionado'])){
				
				$inseriu=mysql_query($x="INSERT INTO financeiro_centro_custo SET ordem='$modelo->ordem',centro_custo_id='{$pai_nivel[$pai_modelo]}', cliente_id='{$_SESSION[usuario]->cliente_vekttor_id}', nome='$modelo->nome', descricao='$modelo->descricao',tipo='$modelo->tipo', plano_ou_centro='$modelo->plano_ou_centro', exibir_soma='$modelo->exibir_soma'");
				
				if($inseriu){
					
					$pai_id=mysql_insert_id();
					inserir($pai_id,$modelo->id,$modelo_id,$dados);
					
				}
			}
			
		}
	}
}
?>