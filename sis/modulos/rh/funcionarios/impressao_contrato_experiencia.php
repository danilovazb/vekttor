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
	$id=$_GET['id'];
	
	$contratado = mysql_fetch_object(mysql_query($t="SELECT 
														* 
													FROM
														rh_funcionario
													 WHERE
													 	id = '$id' AND 
														vkt_id='$vkt_id'
													 	"));
	$data_admissao = explode("-",$contratado->data_admissao);
	
	$contratante = mysql_fetch_object(mysql_query($t="SELECT 
														* 
													FROM
														cliente_fornecedor
													 WHERE
													 	id = '$contratado->empresa_id' AND
													 	cliente_vekttor_id='$vkt_id'
														"));//echo $t." ".mysql_error();
	 													
	$salario_total =$contratado->salario;
	if($contratado->adicional_insalubridade>0){
		$salario_total = ($contratado->salario*($contratado->adicional_insalubridade/100))+$contratado->salario;
		$adicionias_remuneracao[] =  "mais $contratado->adicional_insalubridade% de insalubridade";
	}
	
	if($contratado->adicional_periculosidade>0){
		$salario_total = ($contratado->salario*($contratado->adicional_periculosidade/100))+$salario_total;	
		$adicionias_remuneracao[] =  "mais $contratado->adicional_periculosidade% de periculosidade";
	}
	if($contratado->adicional_noturno>0){
		$salario_total = ($contratado->salario*($contratado->adicional_noturno/100))+$salario_total;	
		$adicionias_remuneracao[] =  "mais $contratado->adicional_noturno% de adicional noturno";
	}
	
	if(count($adicionias_remuneracao)>0){
		$adicionias_remuneracao[] =  "totalizando R$ ".MoedaUsaToBr($salario_total);
	}
	
	$adicionias_remuneracao = ', '.@implode(', ',$adicionias_remuneracao);	
	$mods = array(
		'@contratante_razaosocial'=>"$contratante->razao_social",
		'@contratante_endereco'=>"$contratante->endereco, $contratante->bairro, $contratante->cidade-$contratante->estado - $contratante->cep",
		'@contratante_cpf_cnpj'=>"$contratante->cnpj_cpf",
		'@contratante_nomecontato'=>"$contratante->nome_contato",
		'@contratado_nome'=>"$contratado->nome",
		'@contratado_ctps'=>"$contratado->carteira_profissional_numero $contratado->carteira_profissional_serie / $contratado->carteira_profissional_estado_emissor",
		'@contratado_ctps_serie'=>"$contratado->carteira_profissional_serie",
		'@contratado_ctps_uf'=>"$contratado->carteira_profissional_estado_emissor",
		'@contratado_cbo'=>"$contratado->cbo",
		'@contratado_rg'=>"$contratado->rg",
		'@contratado_cargo'=>"$contratado->cargo",
		'@contratado_duracao'=>"$contratado->duracao",
		'@contratado_hora_trabalho_inicio'=>"$contratado_hora_trabalho_inicio",
		'@contratado_hora_trabalho_fim'=>"$contratado_hora_trabalho_fim",
		'@contratado_remuneracao'=>MoedaUsaToBr($contratado->salario).$adicionias_remuneracao." (".numero(number_format($salario_total,2,',',''),'moeda').")",
		'@contratado_hr_inicio'=>$contratado->hora_inicio_expediente,
		'@contratado_hr_fim'=>$contratado->hora_fim_expediente,
		'@contratado_endereco'=>"$contratado->endereco Nº. $contratado->numero, $contratado->bairro, $contratado->cidade-$contratado->estado - $contratado->cep",
		'@contratado_data_admissao'=>"$contratado->data_admissao",
		'@data_admissao'=>$data_admissao[2]."/".$data_admissao[1].'/'.$data_admissao[0],
		'@contratado_cpf'=>$contratado->cpf,
		'@data_atual'=>date("d/m/Y")
	);
	
	
		$texto = $contratado->contrato;

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


</div>

<div id='rodape'>
 </div>