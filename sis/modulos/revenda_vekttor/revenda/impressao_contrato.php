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
														revenda_franquia rf,
														cliente_fornecedor cf,
														clientes_vekttor cv
													 WHERE
													 	rf.cliente_fornecedor_id = cf.id AND 
														rf.cliente_vekttor_id = cv.id AND
														rf.id='".$_GET['id']."'
														"));
	 													
	//echo $t;
	$mods = array(
	'@contratante_razaosocial'=>"$contrato->razao_social",
	'@contratante_cnpj'=>"$contrato->cnpj_cpf",
	'@contratante_endereco'=>"$contrato->endereco, $contrato->bairro, $contrato->cidade-$contrato->estado - $contrato->cep",
	'@contratante_nomecontato'=>"$contrato->nome_contato",
	'@contratante_cpf'=>"$contrato->cnpj_cpf"
	);
	
	$texto = $contrato->contrato;

	foreach ($mods as $key => $value) {
		$texto = str_replace($key,$value,$texto);
	}
	
	
	echo $texto;
	
?>
</p>
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