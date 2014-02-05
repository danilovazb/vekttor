<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];



//Cadastra Registro
if($_POST['action']=='Salvar'&&empty($id)){
	//cadastraEmpreendimento($nome,$tipo,$orcamento,$inicio,$fim,$obs)
	$cadastra=cadastraObra($_POST['nome'],$_POST['tipo'],$_POST['orcamento'],$_POST['inicio'],$_POST['fim'],$_POST['obs']);
	salvaUsuarioHistorico("Formulário - Obra",'Cadastrou um Novo','empreendimento',$id);
}
//Altera Registro
if($_POST['action']=='Salvar'&&isset($id)){
	$altera=alteraObra($id,$_POST['nome'],$_POST['tipo'],$_POST['orcamento'],$_POST['inicio'],$_POST['fim'],$_POST['obs']);
	salvaUsuarioHistorico("Formulário - Obra",'Alterou o ID $id','empreendimento',$id);
}
//Exclui Usuario
if($_POST['action']=='Excluir'&&isset($id)){
	
	$disponibilidades = @mysql_result(("SELECT count(*) FROM disponibilidade WHERE empreendimento_id='$id'"),0,0);
	$negociacoes 	  = @mysql_result(("SELECT count(*) FROM negociacao WHERE empreendimento_id='$id'"),0,0);
	
	if($disponibilidades >0 || $negociacoes>0){
		if($negociacoes>0){
			$erro[] = "Existe uma negociação para este Empreendimento";
		}
		if($disponibilidades>0){
			$erro[] = "Existe uma disponibilidade para este Empreendimento";
		}
		
		echo "<script>alert('".implode('\n',$erro)."')</script>";
	}
	
	if($disponibilidades ==0 && $negociacoes==0){
		$exclui=excluiObra($id);
	}
	
	salvaUsuarioHistorico("Formulário - Obra",'Excluiu o ID $id','empreendimento',$id);
	
}
//Pega informações
if($id>0){
	$r=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Empreendimento",'Exibe','empreendimento',$id);
}

?>