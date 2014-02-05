<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
global $vkt_id;
?>
<style>
	#pagina{
		width:840px;
		background:#FFFFFF;
		margin:0px auto;
	}
</style>
<div id='conteudo'>
<!-- -->
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >

<script>
</script>
<div id="pagina" style="text-align:justify">
<?php
	$contrato = mysql_fetch_object(mysql_query($t="SELECT 
														* 
													FROM
														rh_empresa_has_contratos
													 WHERE
													 	id='".$_GET['id']."'
														"));
	
	$cliente_fornecedor = mysql_fetch_object(mysql_query("
		SELECT 
			* 
		FROM
			cliente_fornecedor
		WHERE
			id = '$contrato->empresa_id' 
	"));
	 													
		
	$texto = $contrato->contrato;
	
	$mods = array(
		'@contratante_razaosocial'=>"$cliente_fornecedor->razao_social",
		'@contratante_endereco'=>"$cliente_fornecedor->endereco, $cliente_fornecedor->bairro, $cliente_fornecedor->cidade-$cliente_fornecedor->estado - $cliente_fornecedor->cep",
		'@contratante_cnpj'=>"$cliente_fornecedor->cnpj_cpf",
		'@contratante_nomecontato'=>"$cliente_fornecedor->nome_contato",
		/*'@carteiraprofissional_numero'=>"$cliente_fornecedor->carteira_profissional_numero",
		'@carteiraprofissional_serie'=>"$cliente_fornecedor->carteira_profissional_serie",
		'@contratado_vpf'=>"$cliente_fornecedor->cpf",
		'@contratado_rg'=>"$cliente_fornecedor->rh",
		'@contratado_cargo'=>"$cliente_fornecedor->cargo",
		'@contratado_salario'=>"$cliente_fornecedor->salario",
		'@contratado_endereco'=>"$cliente_fornecedor->endereco, $cliente_fornecedor->bairro, $cliente_fornecedor->cidade-$cliente_fornecedor->estado - $cliente_fornecedor->cep",*/
	);
	
	
	
	foreach ($mods as $key => $value) {
		$texto = str_replace($key,$value,$texto);
	}
	
	
?>
<div id="titulo" style="text-align:center;width:100%;font-weight:bold;font-size:20px;"><?=$contrato->nome?></div>
<div style="clear:both"></div>
<?php
	echo $texto;
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
 </div>