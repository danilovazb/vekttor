<?php
if($_POST['action']=="Enviar Para Fila"){
	manipulaFila($_POST);
}

if($_POST['action']=="Atendimento"){
	EnviaAtendimento($_POST);
}

if($_POST['action']=="Concluir"){
	ConcluiAtendimento($_POST['id']);
}


if($_POST['action']=="Cancelar"){
	CancelarAtendimento($_POST['id']);
}

if($_POST['action']=='Abrir Atendimento'&&$atendimento_id>0){
	echo "<script>window.open('modulos/odonto/atendimento/form.php?atendimento_id=".$atendimento_id."','carregador')</script>";
}

$disabled=''; 
if($_GET['id']>0){
	$fila = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_fila_espera WHERE id='".$_GET['id']."'")); 
	$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$fila->cliente_fornecedor_id."'"));
	if($fila->status=='Concluido'||$fila->status=='Cancelado'){
		$disabled="disabled='disabled'";
	}
		//echo $t;
}
/*
	verifica se o usuário logado é um odontologo	
*/
$verifica_odontologo = mysql_fetch_object(mysql_query($t=
	"SELECT 
		* 
	FROM 
		usuario u,
		odontologo_odontologo oo 
	WHERE 
		u.id=oo.usuario_id AND
		oo.usuario_id='$usuario_id'"));
//echo "Odontologo: $verifica_odontologo->usuario_id";
if($verifica_odontologo->id>0){
	$usuario_logado = $verifica_odontologo->usuario_id;
	$filtro_campo = "agenda_id='$verifica_odontologo->agenda_id'";
	$agendas = mysql_query($t="SELECT * FROM agenda WHERE id = '$verifica_odontologo->agenda_id' AND vkt_id='$vkt_id'");
	//echo $t;
}else{
	$usuario_logado = $usuario_id;
	$filtro_campo = "usuario_id='$usuario_id'";
	$agendas = mysql_query($t="SELECT * FROM agenda WHERE usuario_id = '$usuario_logado' AND vkt_id='$vkt_id'");
	//echo $t;
}
?>