<?php
//Includes
// configuraç?o inicial do sistema
include("../../../_config.php");
// funç?es base do sistema
include("../../../_functions_base.php");
// funç?es do modulo empreendimento
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
	$contratante = mysql_fetch_object(mysql_query($t="SELECT 
														* 
													FROM
														odontologo_contrato_cliente cc,
														cliente_fornecedor cf
													 WHERE
													 	cc.cliente_id = cf.id AND
													 	cc.id='".$_GET['id']."'
														"));//echo $t." ".mysql_error();
	 													
	
	$contratado = mysql_fetch_object(mysql_query($t="SELECT 
														* 
													FROM
														clientes_vekttor cv
													 WHERE
													 	id = $vkt_id
													 	"));
		
	$mods = array(
		'@contratante_razaosocial'=>"$contratante->razao_social",
		'@contratante_cnpj'=>"$contratante->cnpj_cpf",
		'@contratante_cnpj'=>"$contratante->cnpj_cpf",
		'@contratante_nomecontato'=>"$contratante->nome_contato",
		'@contratante_cpf'=>"$contratante->cnpj_cpf",
		'@contratado_razaosocial'=>"$contratado->nome_fantasia",
		'@contratado_cnpj'=>"$contratado->cnpj",
		'@contratado_endereco'=>"$contratado->endereco, $contratado->bairro, $contratado->cidade-$contratado->estado - $contratado->cep",
	);
		
	$texto = $contratante->html_contrato;

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