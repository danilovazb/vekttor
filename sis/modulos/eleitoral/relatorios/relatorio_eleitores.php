<?
require("../../../_config.php");
include("../../../_functions_base.php");
function trataTxt($var) {

	$var = strtolower($var);
	
	$var = preg_replace("[á?â??]","a",$var);	
	$var = preg_replace("[é??]","e",$var);	
	$var = preg_replace("[í]","e",$var);	
	$var = preg_replace("[ó?ô??]","o",$var);	
	$var = preg_replace("[ú??ü]","u",$var);	
	$var = str_replace("ç","c",$var);
	
	return $var;
}
$de = $_GET['qtd_registros_inicio']-1;
$qtd_eleitores = $_GET['qtd_registros'] - $de;
/* Exibição de campos */
if($_GET['email']=='1'){$exibe_email=", e.email as email";}
if($_GET['endereco']=='1'){$exibe_endereco = ", e.endereco, e.bairro, e.cep";}
if($_GET['telefone']=='1'){$exibe_tel = ", e.telefone1 as telefone, e.telefone2 as celular";}


/* Filtros */
if($_GET['mes_aniversariante']>0){ $filtro_grupo =" AND MONTH(e.data_nascimento) = '".$_GET['mes_aniversariante']."'";}
if($_GET['grupo_social_id']>0){ $filtro_grupo =" AND e.grupo_social_id = '{$_GET[grupo_social_id]}'";}
if($_GET['regiao_id']>0){ $filtro_regiao =" AND e.regiao_id= '{$_GET['regiao_id']}'";}
if($_GET['bairro']>0){ $filtro_bairro=" AND e.bairro= '{$_GET['bairro']}'";}
if($_GET['profissao_id']>0){ $filtro_profissao=" AND e.profissao_id= '{$_GET['profissao_id']}'";}
if($_GET['sexo']=='m'){ $filtro_sexo=" AND e.sexo= 'masculino'";}
if($_GET['sexo']=='f'){ $filtro_sexo=" AND e.sexo= 'feminino'";}
if(!empty($_GET['cidade'])){ $filtro_cidade=" AND e.cidade= '{$_GET['cidade']}'";}
if(!empty($_GET['estado'])){ $filtro_estado=" AND e.estado= '{$_GET['estado']}'";}
if(!empty($_GET['cep_inicio'])&&!empty($_GET['cep_fim'])){
	
	$filtro_cep = "AND e.cep BETWEEN '".$_GET['cep_inicio']."' AND '".$_GET['cep_fim']."'";

}else if(!empty($_GET['cep_inicio'])){
	
	$filtro_cep = "AND e.cep >= '".$_GET['cep_inicio']."'";
	
}

$eleitores_q=mysql_query($t="
SELECT 
	e.id,
	e.nome,
	e.data_nascimento,
	e.cep,
	e.endereco,
	e.bairro,
	e.telefone1,
	e.telefone2
	$exibe_email 
	$exibe_endereco
	$exibe_tel
	
	
FROM 
	eleitoral_eleitores as e
WHERE 
	e.vkt_id='$vkt_id'
$filtro_bairro
$filtro_grupo
$filtro_profissao
$filtro_regiao
$filtro_sexo
$filtro_cidade
$filtro_estado
$filtro_cep
ORDER BY e.id DESC
LIMIT $de,$qtd_eleitores
");
//echo $t;
if(!empty($_GET['exportar_telefones'])){
	include 'relatorio_sms.php';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Relatório de Eleitores</title>
<style>
body{ font-family:Tahoma, Geneva, sans-serif; font-size:11px;}
table thead{ font-weight:bold;}
</style>
</head>
<body>
<h2>xRelatório de eleitores</h2>
<table cellpadding="4" cellspacing="0" border="1">
	<thead>
    	<tr>
        	<td>Nome</td>
            <td>Nascimento</td>
            <? if($_GET['email']=='1'){ ?> <td>Email</td> <? } ?>
            <? if($_GET['telefone']=='1'){ ?> 
            <td>Telefone</td>
            <td>Celular</td>
            <? } ?>
            <td>Profissão</td>
            <? if($_GET['endereco']=='1'){ ?>
            <td>Endereço</td>
            <td>CEP</td>
            <? } ?>
            <td>Bairro</td>
            <td>Região</td>
            <td>Grupo Social</td>
            
        </tr>
    </thead>
    <tbody>
    <? 
	if($_GET["exportar"]=="Exportar"){
		$alteralinha ="0";
		$info[] = strtoupper("Nome;Nascimento;");
		if($_GET['email']=='1'){$info[] = strtoupper("Email;");}
		if($_GET['telefone']=='1'){$info[] = strtoupper("Telefone;Celular;");}
		$info[] = strtoupper("Profissao;");
		if($_GET['endereco']=='1'){$info[] = strtoupper("Endereco;CEP");}
		$info[] = strtoupper("Bairro;Regiao;Grupo Social\n");
	}
	if(!empty($_GET["exportar_telefones"])){
		$info[] = strtoupper("Celular\n");
	}
	
	
		
	while($eleitor=mysql_fetch_object($eleitores_q)){ 
		if(empty($_GET["exportar_telefones"])){
	?>
    	<tr>
        	<td><?=$eleitor->nome?></td>
            <td><?=dataUsaToBr($eleitor->data_nascimento).' ('.$eleitor->idade.')'?></td>
            <? if($_GET['email']=='1'){ ?><td><?=$eleitor->email?></td> <? } ?>
            <? if($_GET['telefone']=='1'){ ?> 
            <td><?=$eleitor->telefone?></td>
            <td><?=$eleitor->celular?></td>
            <? } ?>
            <td><?=$eleitor->profissao?></td>
            <? if($_GET['endereco']=='1'){ ?>
            <td><?=$eleitor->endereco?></td>
            <td><?=$eleitor->cep?></td>
            <? } ?>
            <td><?=$eleitor->bairro?></td>
            <td><?=$eleitor->regiao?></td>
            <td><?=$eleitor->grupo?></td>
        </tr>
    <?php 
			if($_GET["exportar"]=="Exportar"){
				$alteralinha ="0";
				$idade_eleitor = dataUsaToBr($eleitor->data_nascimento).' ('.$eleitor->idade.')';
				$info[] = strtoupper("$eleitor->nome;$idade_eleitor;");
				if($_GET['email']=='1'){$info[] = strtoupper(tratatxt("$eleitor->email;"));}
				if($_GET['telefone']=='1'){$info[] = strtoupper("$eleitor->telefone;$eleitor->celular;");}
				$info[] = strtoupper("$eleitor->profissao;");
				if($_GET['endereco']=='1'){$info[] = strtoupper("$eleitor->endereco;$eleitor->cep;");}
				$info[] = strtoupper("$eleitor->bairro;$eleitor->regiao;$eleitor->grupo\n");
			}
		}else{
				if(!empty($eleitor->telefone1)){
					$telefone_original = $eleitor->telefone1;
				}else{
					$telefone_original = $eleitor->telefone2;
				}
				if(!empty($telefone_original)){
				$tamtelefone = strlen($telefone_original);
				
				$telefone = str_replace("-","",$telefone_original);
				$telefone = str_replace(" ","",$telefone);
				$telefone = str_replace(")","",$telefone);
				$telefone = str_replace("(","",$telefone);
				$telefone = str_replace(".","",$telefone);
				$telefone = trim($telefone);
				
				$caracteres = strlen($telefone);
				$caracter_inicio = $caracteres-8;
				$telefone = substr($telefone,$caracter_inicio,8);
				
				if(!empty($telefone)&&strlen($telefone)>7&&(substr($telefone,0,1)=='8'||substr($telefone,0,1)=='9')){
					
					//
					$info[] = strtoupper("$telefone,\n");
				}
				}
		}
	}
	
	
	if($_GET["exportar"]=="Exportar"||!empty($_GET["exportar_telefones"])){
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