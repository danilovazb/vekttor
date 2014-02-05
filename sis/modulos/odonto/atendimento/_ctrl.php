<?
if($_GET['atendimento_id']>0){$atendimento_id=$_GET["atendimento_id"];$id=$_GET['atendimento_id'];}
if($_POST['atendimento_id']>0){$atendimento_id=$_POST["atendimento_id"];$id=$_GET['atendimento_id'];}
//salva o atendimento
if($_POST['action']=='Salvar'||$_POST['action_aba']=='Salvar'){
	if($atendimento_id>0){
		manipulaCliente('editar',$_POST);
	}else{
		manipulaCliente('add',$_POST);
	}
}
if($_POST['action_aba']=='Editar Análise'&&$_POST['procedimento_editavel_item_id']>0&&$_POST['tipo_procedimento']!=''){
	editaAnaliseDente($_POST['tipo_procedimento'],$_POST);
	
}

if($_POST['action_aba']=='Excluir Análise' && $_POST['procedimento_editavel_item_id']>0 && $_POST['tipo_procedimento']!=''){
	excluirAnaliseDente($_POST['tipo_procedimento'],$_POST);
}

//adiciona uma análise ao dente, tanto nova quanto passada
if($_POST['action_aba']=='Incluir Análise'&& $atendimento_id>0){
	if($_POST['procedimento_id']>0){		
		adicionaAnaliseDente('procedimento',$_POST);
	}
	if($_POST['procedimento_passado_id']>0){
		adicionaAnaliseDente('historico',$_POST);
	}
}

if($_POST['action_aba']=='Incluir Consulta'&&$atendimento_id>0){
	incluirConsulta($_POST);
}

if($_GET['action']=='Excluir Consulta'&&$_GET['consulta_id']){
	excluirConsulta($_GET['consulta_id']);
}

if($_POST['action_aba']=='Incluir Exame'&& $atendimento_id>0){
	
	$id = incluirExame($_POST);
	
		echo "<script>nl= top.document.getElementById('dados_exames').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length-1;top.document.getElementById('dados_exames').getElementsByTagName('tbody')[0].getElementsByTagName('tr')[nl].setAttribute('id_exame','$id')</script>";
}

if($_POST['action']=='Remove Exame'){
	
	excluirExame($_POST);
}


if($_GET['action']=='aprova'&&$_GET['procedimento_id']>0){
	manipulaAprovacao('aprova',$_GET['procedimento_id']);
}
if($_GET['action']=='desaprova'&&$_GET['procedimento_id']>0){
	manipulaAprovacao('desaprova',$_GET['procedimento_id']);
}

if($_GET['action']=='alterapreco'&&$_GET['procedimento_id']>0&&$_GET['valor_procedimento_item']!=''){
	manipulaPreco($_GET['procedimento_id'],$_GET['valor_procedimento_item']);
}

if($_GET['action']=='abreprocedimento'&&$_GET['procedimento_id']>0&&$_GET['tipo_procedimento']!=''){
	retornaInfoProcedimento($_GET['procedimento_id'],$_GET['tipo_procedimento']);
}


if($_POST['salva_formulario_contrato_cliente']== '1'){
	
	if($_POST['modelo_id']>0){
		manipulaContratoCliente($_POST,$vkt_id);	
	}
}

if($_POST['action_aba']=="RemoverFoto"){
	ExcluirFoto($_POST);
}

if($_POST['action']=="Concluir Consulta"){
	ConcluirConsulta($_POST);
}


if($_GET['cliente_id']>0){
	$cliente_fornecedor=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$_GET['cliente_id']."'"));
}


if($atendimento_id>0){
	$atendimento=mysql_fetch_object(mysql_query("SELECT * FROM odontologo_atendimentos WHERE id='$atendimento_id' AND vkt_id='$vkt_id'"));
	$cliente_fornecedor=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$atendimento->cliente_fornecedor_id'"));
	$convenio=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id= '$atendimento->convenio_id'"));
	$consulta=mysql_fetch_object(mysql_query("SELECT * FROM odontologo_consultas WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento->id' AND status='em andamento' ORDER BY id DESC LIMIT 1 "));
	$verifica_fila=mysql_fetch_object(mysql_query("SELECT * FROM odontologo_fila_espera WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id' AND (status='Em atendimento' OR status='Em espera' ) ORDER BY id DESC LIMIT 1 "));
	echo mysql_error();
}