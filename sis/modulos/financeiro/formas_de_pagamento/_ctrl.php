<?
/*
*	Ricardo Monteiro e Lima
*	08/10/13
*/
if($_GET['ordem']!=''){
	$ordem = $_GET['ordem'];
	$ordem_tipo = $_GET['ordem_tipo'];
}else{
	$ordem = "nome";
	$ordem_tipo = "ASC";
}
if($_GET['id']>0){$forma_pagamento_id=$_GET['id'];}
if($_POST['id']>0){$forma_pagamento_id=$_POST['id'];}

if($_POST['action']=="Salvar"){
	manipulaFormaPagamento($_POST);
}

if($_POST['action']=="Excluir"){
	excluirFormaPagamento($forma_pagamento_id);
}

if($forma_pagamento_id>0){
	$forma_pagamento=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_formas_pagamento WHERE id='$forma_pagamento_id'"));
}