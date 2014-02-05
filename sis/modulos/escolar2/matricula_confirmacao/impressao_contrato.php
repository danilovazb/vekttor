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
	
	$matricula_id = $_GET["matricula_id"];
	
	$matricula = mysql_fetch_object(mysql_query($t="
		SELECT * FROM 
			escolar2_matriculas AS matricula 
		JOIN 
			escolar2_turmas AS turma ON turma.id = matricula.turma_id
		WHERE 
			matricula.id = '$matricula_id' AND matricula.vkt_id='$vkt_id'"));
			
	//Aluno 
	$contratante = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id = '$matricula->responsavel_id' AND cliente_vekttor_id='$vkt_id' "));
	//echo $t."<br>";
	// Escola 		
	$contratado = mysql_fetch_object(mysql_query($t=" SELECT * FROM escolar2_unidades WHERE id = $matricula->unidade_id AND vkt_id='$vkt_id'"));
	//echo $t; 													
	
		
	$mods = array(
		'@contratante_razaosocial'=>"$contratante->razao_social",
		'@contratante_endereco'=>"$contratante->endereco, $contratante->bairro, $contratante->cidade-$contratante->estado - $contratante->cep",
		'@contratante_rg'=>"$contratante->rg / $contratante->local_emissao",
		'@contratante_cpf'=>"$contratante->cnpj_cpf",
		'@contratante_nomecontato'=>"$contratante->nome_contato",
		'@contratado_nome'=>"$contratado->nome",
		'@contratado_ctps'=>"$contratado->carteira_profissional_numero $contratado->carteira_profissional_serie / $contratado->carteira_profissional_estado_emissor",
		'@contratado_ctps_serie'=>"$contratado->carteira_profissional_serie",
		'@contratado_ctps_uf'=>"$contratado->carteira_profissional_estado_emissor",
		'@contratado_cbo'=>"$contratado->cbo",
		'@contratado_rg'=>"$contratado->rg / $contratado->local_emissao",
		'@contratado_cargo'=>"$contratado->cargo",
		'@contratado_duracao'=>"$contratado->duracao",
		'@contratado_hora_trabalho_inicio'=>"$contratado_hora_trabalho_inicio",
		'@contratado_hora_trabalho_fim'=>"$contratado_hora_trabalho_fim",
		'@contratado_remuneracao'=>MoedaUsaToBr($contratado->salario)." (".numero(number_format($contratado->salario,2,',',''),'moeda').")",
		'@contratado_hr_inicio'=>$contratado->hora_inicio_expediente,
		'@contratado_hr_fim'=>$contratado->hora_fim_expediente,
		'@contratado_endereco'=>"$contratado->endereco, $contratado->bairro, $contratado->cidade-$contratado->estado - $contratado->cep",
		'@contratado_data_admissao'=>"$contratado->data_admissao",
	);
	
	
		$texto = $matricula->contrato;

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