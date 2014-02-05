<?
require("../../../_config.php");
include("../../../_functions_base.php");
/* Exibição de campos */
if(!empty($_GET['email'])){$exibe_email=", tablecliente.email as email";}
if(!empty($_GET['endereco'])){$exibe_endereco = ", tablecliente.endereco, tablecliente.cep";}
if(!empty($_GET['telefone'])){$exibe_tel = ", tablecliente.telefone1 as telefone, tablecliente.telefone2 as celular";}

/* Filtros */
$filtro_ramo="";
$filtro_bairro="";
$filtroAniversario = "";
	if($_GET['grupo_id']>0){ 
		$filtro_grupo =" AND tablecliente.grupo_id = '{$_GET[grupo_id]}'";
		$selectGrupo = ",tablecliente.grupo_id";
	}
	if(!empty($_GET['bairro'])){ 
		$filtro_bairro=" AND tablecliente.bairro = '{$_GET[bairro]}'";
		$selectBairro = ", tablecliente.bairro";
	}
	if(!empty($_GET['ramo'])){ 
		$filtro_ramo=" AND tablecliente.ramo_atividade = '".(($_GET['ramo']))."'";
		$selectRamo = ", tablecliente.ramo_atividade ";
	}
	if(!empty($_GET['aniversariante'])){
		$filtroAniversario = "AND month(nascimento) = '".$_GET['aniversariante']."'";
		$selectNascimento = ", tablecliente.nascimento ";	
	}
	
	$filtroTipo = (!empty($_GET["tipo"])) ? " AND tipo = '{$_GET['tipo']}'" : NULL; 


$clientes=mysql_query($t="
SELECT 
	tablecliente.razao_social,
	tablecliente.cnpj_cpf,
	tablecliente.cidade
	
	$selectBairro
	$selectRamo
	$exibe_email
	$exibe_tel
	$exibe_endereco
	$selectGrupo
	$selectNascimento
FROM 
	cliente_fornecedor AS tablecliente
WHERE 
	cliente_vekttor_id = '$vkt_id'
	$filtro_ramo
	$filtro_bairro
	$filtro_grupo
	$filtroAniversario
	$filtroTipo
	
");
//echo $t;
//echo $t."<br>".mysql_error();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Relatório de Eleitores</title>
<style>
body{ font-size:8px;font-family:Tahoma, Geneva, sans-serif;}
/*body{ font-family:Tahoma, Geneva, sans-serif; font-size:10pt;}*/
table tbody tr td{ font-size:13px;}
table thead tr { font-size:13px; font-weight:bold;}
</style>
</head>
<body>
<h2>Relatório de eleitores</h2>
<table cellpadding="4" cellspacing="0" border="1">
	<thead>
    	<tr>
        	<td>Razao</td>
            <td>CNPJ/CPF</td>
            <? if(!empty($_GET['email'])){ echo "<td>Email</td>"; } ?>
            <? if(!empty($_GET['ramo'])){ echo "<td>Ramo</td>";} ?>
            <? if(!empty($_GET['bairro'])){ echo "<td>Bairro</td>";} ?>
            <? if(!empty($_GET['telefone'])){ echo "<td>Telefone</td>";} ?>
            <? if(!empty($_GET['endereco'])){ echo "<td>CEP</td><td>Endere&ccedil;o</td>";} ?>
            <? if(!empty($_GET['grupo_id'])){ echo "<td>Grupo</td>"; } ?>
            <? if(!empty($_GET['aniversariante'])){ echo "<td>Anivers&aacute;rio</td>"; } ?> 
            <td>Cidade</td>      
        </tr>
    </thead>
    <tbody>
    <? 
	if($_GET["exportar"]=="Exportar"){
		$alteralinha ="0";
		$info[] = strtoupper("Nome;");
		$info[] = strtoupper("CNPJ/CPF;");
		
		if(!empty($_GET['email'])){$info[] = strtoupper("EMAIL;");}
		if(!empty($_GET['ramo'])){$info[] = strtoupper("RAMO DE ATIVIDADE;");}
		if(!empty($_GET['bairro'])){$info[] = strtoupper("BAIRRO;");}
		if(!empty($_GET['telefone'])){$info[] = strtoupper("TELEFONE;");}
		if(!empty($_GET['endereco'])){$info[] = strtoupper("CEP;ENDERECO;");}
		if(!empty($_GET['grupo_id'])){$info[] = strtoupper("GRUPO;");}
		if(!empty($_GET['aniversariante'])){$info[] = strtoupper("ANIVERSARIANTE;");}
		$info[] = strtoupper("CIDADE;\n");
	}
	while($cliente=mysql_fetch_object($clientes)){
		if(!empty($_GET['grupo_id']) and (!empty($cliente->grupo_id))){
			$grupo = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor_grupo WHERE id = '$cliente->grupo_id' "));
		}
	?>
    	<tr>
        	<td><?=$cliente->razao_social?></td>
            <td><?=$cliente->cnpj_cpf?></td>
            <? if($_GET['email']=='1'){  echo "<td>".$cliente->email."</td>"; } ?>
            <? if(!empty($_GET['ramo'])){ echo "<td>".$cliente->ramo_atividade."</td>";} ?>
            <? if(!empty($_GET['bairro'])){ echo "<td>".$cliente->bairro."</td>";} ?>
            <? if(!empty($_GET['telefone'])){ echo "<td>".$cliente->telefone."</td>";} ?>
            <? if(!empty($_GET['endereco'])){ echo "<td>".$cliente->cep."</td><td>".$cliente->endereco."</td>";} ?>
            <? if(!empty($_GET['grupo_id'])){ echo "<td>".$grupo->nome."</td>";} ?>
            <? if(!empty($_GET['aniversariante'])){ echo "<td>".dataUsaToBr($cliente->nascimento)."</td>"; } ?> 
            <td><?=$cliente->cidade?></td>
        </tr>
    <?php 
	if($_GET["exportar"]=="Exportar"){
			$alteralinha ="0";
			
			$info[] = strtoupper(("$cliente->razao_social;"));
			$info[] = strtoupper(("$cliente->cnpj_cpf;"));
			if(!empty($_GET['email'])){$info[] = strtoupper("$cliente->email;");}
			if(!empty($_GET['ramo'])){$info[] = strtoupper("$cliente->ramo_atividade;");}
			if(!empty($_GET['bairro'])){$info[] = strtoupper("$cliente->bairro;");}
			if(!empty($_GET['telefone'])){$info[] = strtoupper("$cliente->telefone;");}
			if(!empty($_GET['endereco'])){$info[] = strtoupper("$cliente->cep;$cliente->endereco;");}
			if(!empty($_GET['grupo_id'])){$info[] = strtoupper("$grupo->nome;");}
			if(!empty($_GET['aniversariante'])){$info[] = strtoupper(dataUsaToBr($cliente->nascimento));}
			$info[] = strtoupper(("$cliente->cidade;\n"));
			
		}
	}
	
	if($_GET["exportar"]=="Exportar"){
		$infos = implode("",$info);
	
		$file = "relatorios_eleitores.csv";
		@unlink("$file");
		$handle = fopen($file, 'a');
		fwrite($handle,$infos);
		fclose($handle);

		$i =date("Ymdhis");
		echo "<script>location='$file?$i'</script>";
		exit();
	}
	?>
    </tbody>
</table>

</body>
</html>