<?

if($_POST['action']== 'Salvar'){
	if($_POST['id'] > 0){
		altera_atividade($_POST);
		if($_GET[tela_id]==96){
			$tela_id = 96;
		}else{
			$tela_id = 92;
		}
		echo "<script>top.location='../../../?tela_id=$tela_id&projeto_id=$_POST[projeto_id]&funcionario_id=$_POST[funcionario_id]&status=$_POST[oldstatus]'
		</script>";
		exit();
	}else{
		adiciona_atividade($_POST);
		echo "<script>
		top.location='../../../../?tela_id=96&projeto_id=$_GET[projeto_id]'
		</script>";
		exit();	
	}
	
}
if($_POST['action']== 'Excluir'){
	deletar_atividade($_POST['id']);
		if($_GET[tela_id]==96){
			$tela_id = 96;
		}else{
			$tela_id = 92;
		}
		echo "<script>top.location='../../../?tela_id=$tela_id&projeto_id=$_POST[projeto_id]&funcionario_id=$_POST[funcionario_id]'</script>";
		exit();

}

if($_GET['id']>0){

	$id = $_GET['id'];
	
	$registro = mysql_fetch_object(mysql_query("SELECT *,
					date_format(data_hora_inicio,'%H:%i' ) as hora_inicio,
					date_format(data_hora_fim,'%H:%i' ) as hora_fim  ,
					
					date_format(data_cadastro,'%d/%m/%Y às %H:%i' ) as cadastro,
					DATEDIFF(data_cadastro,NOW() ) as dias , 
					TIMEDIFF(NOW(),data_cadastro ) as horas ,
					DATEDIFF(data_cadastro,data_hora_fim ) as dias_concluidas,
					TIMEDIFF(data_hora_fim,data_cadastro ) as horas_concluidas
				
	 FROM projetos_atividades WHERE id='$id' AND vkt_id='$vkt_id'"));
	
	
	$p = mysql_fetch_object(mysql_query("SELECT * FROM projetos WHERE id='".$registro->projeto_id."'"));
	if($p==NULL){$projeto='Não informado';}else{$projeto=$p->nome;}
	
	$c = mysql_fetch_object(mysql_query("SELECT razao_social,id FROM cliente_fornecedor WHERE id='".$p->cliente_fornecedor_id."'"));
	if($c==NULL){$razao_social='Não informado';}else{$razao_social=$c->razao_social;}



	$a_q = mysql_query("SELECT nome,id FROM projetos_atividades_tipos WHERE id='".$registro->atividade_tipo_id."'");
	
	$a=mysql_fetch_object($a_q);
	
	$u = mysql_fetch_object(mysql_query("SELECT id,nome FROM usuario WHERE id='".$registro->funcionario_id."'"));
}

	

?>