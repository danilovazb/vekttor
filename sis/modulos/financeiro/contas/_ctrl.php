<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];



//Cadastra Registro
if(isset($_POST['action'])){
	$retorno = gerencia_conta($id,$_POST['nome'],$_POST['comentario'],$_POST['preferencial'],$id,$_POST['action'],$_POST['agencia'],$_POST['agencia_digito'],$_POST['conta'],$_POST['conta_digito'],$_POST['tipo_boleto'],$_POST);
	if($retorno!='ok'){
		echo "<script>alert('Erro $retorno')</script>";	
	}
	salvaUsuarioHistorico("Formulário - Conta",'Exibe','financeiro_contas',$id);
}
$convenio = "none";
$contrato = "none";
$carteira = "none";
$convenio_carteira = "none";
$codigo_cedente = "none";
$conta_cedente_dv = "none";
$conta_cedente = "none";
$iniciar_contrato_em = "block";
//Pega informações
if($id>0){
	$conta=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_contas WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Conta",'Exibe','financeiro_contas',$id);
	
	
	
	switch($conta->codigo_banco){
		case "001": //banco brasil
			$convenio = "block";
			$contrato = "block";
			$carteira = "block";
			$iniciar_contrato_em = "none";
		break;
		case "237": //bradesco
			$carteira = "block";
		break;
		case "104": //caixa
			$convenio = "block";
		break;
		case "409": //taú
			$carteira = "block";
		break;
		case "399": //HSBC
			$codigo_cedente = "block";
		break;
	}
}
?>