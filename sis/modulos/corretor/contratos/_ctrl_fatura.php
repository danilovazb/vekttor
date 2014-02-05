<?
$comissao=false;
if($_GET['id_fatura']>0){$id_fatura = $_GET['id_fatura'];}
if($_POST['id_fatura']>0){$id_fatura = $_POST['id_fatura'];}
if($_GET['comissao']){$comissao=true;}else{$comissao=false;}
if($_POST['comissao']){$comissao=true;}else{$comissao=false;}

//verifica se é fatura da comissao

$situacao = array(0=>'Pendente',1=>'Pago');
if($_POST['action']=='Salvar'&&$id_fatura>0){
	alteraVencimentoFatura($id_fatura,$_POST['data_vencimento'],$comissao);
}

if($id_fatura>0){
	if($comissao){
		$fatura=mysql_fetch_object(mysql_query("SELECT * FROM faturas_comissao WHERE id='$id_fatura'"));
		echo mysql_error();
	}else{
		$fatura=mysql_fetch_object(mysql_query("SELECT * FROM faturas WHERE id='$id_fatura'"));
		echo mysql_error();
	}
	
}