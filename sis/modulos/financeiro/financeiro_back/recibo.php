<?

include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");

if(isset($_GET[movimento_id])){
	$r = mysql_fetch_object(mysql_query($trace="SELECT 
	date_format(r.data_vencimento ,'%d/%m/%Y') as dt1,
	date_format(r.data_registro ,'%Y%m%d') as dt2,
	r.valor_cadastro AS valor,
	r.id,
	e.nome_fantasia as para,
	e.id as p_id,
	e.bairro as bairro1,
	e.endereco as endereco1,
	e.cnpj_cpf as cnpj,
	r.descricao ,
	r.tipo
	FROM 
		financeiro_movimento r , cliente_fornecedor as e
	WHERE 
		r.id='{$_GET[movimento_id]}'
	AND
		e.id=r.internauta_id 
	"));

if($r->tipo!='pagar'){
	$r->emitente	= $empresa[nome];
	$r->endereco2 	= $empresa[endereco];
	$r->bairro2 	= $empresa[bairro];
	$r->cnpj2 		= $empresa[cnpj];
	

}else{
	$r->emitente	= $r->para;
	$r->endereco2 	= $r->endereco ;
	$r->bairro2 	= $r->bairro;
	$r->cnpj2 		= $r->cnpj;
	
	$r->para		= $empresa[nome];
	$r->endereco 	= $empresa[endereco];
	$r->bairro 		= $empresa[bairro];
	$r->cnpj 		= $empresa[cnpj];

}


	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Recibo Vekttor</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Tahoma, Arial, Verdana;
	font-size: 13px;
}
 td div{ position:absolute;}
-->
</style></head>

<body>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
<div style="margin-left:380px; top:45px;"><?=$r->dt2.$r->id?></div>
<div style="margin-left:100px; top:115px;"><?=$r->endereco1.', '.$r->bairro1?></div>
<div style="margin-left:140px; top:145px;"><?=numero(number_format($r->valor,2,',',''),'moeda')?></div>
<div style="margin-left:40px; top:395px;"><?=$r->emitente?></div>
<div style="margin-left:40px; top:430px;"><?=$r->endereco2.', '.$r->bairro2?></div>
<div style="margin-left:40px; top:467px;"><?=$r->cnpj2?></div>
<div style="margin-left:430px;top: 385px;"><?=$r->dt1?></div>
<div style="margin-left: 570px; top:45px;"><?=number_format($r->valor,2,',','.')?></div>
<div style="margin-left: 140px; top:84px; "><?=$r->para?></div>
<div style="margin-left:40px;top:175px;width:665px; height:80px; text-indent:70px;"><?=$r->descricao?></div>
	
	
	<img src="rc_g.gif" width="750" /></td>
  </tr>
  <tr>
    <td style="border-top:1px dotted #000000;	">
<div style="margin-left:380px; top:558px;"><?=$r->dt2.$r->id?></div>
<div style="margin-left:100px; top:628px;"><?=$r->endereco1.', '.$r->bairro1?></div>
<div style="margin-left:140px; top:658px;"><?=number_format($r->valor,2,',','')?></div>
<div style="margin-left:40px; top:908px;"><?=$r->emitente?></div>
<div style="margin-left:40px; top:943px;"><?=$r->endereco2.', '.$r->bairro2?></div>
<div style="margin-left:40px; top:980px;"><?=$r->cnpj2?></div>
<div style="margin-left:430px;top:905px;"><?=$r->dt1?></div>
<div style="margin-left: 570px; top:558px;"><?=number_format($r->valor,2,',','.')?></div>
<div style="margin-left: 140px; top:597px; "><?=$r->para?></div>
<div style="margin-left:40px;top:688px;width:665px; height:80px; text-indent:70px;"><?=$r->descricao?></div>
<img src="rc_g.gif" width="750" /></td>
  </tr>
</table>
</body>
</html>
<?
}else{
	echo "recibo nao encontrado" ;
}
?>
