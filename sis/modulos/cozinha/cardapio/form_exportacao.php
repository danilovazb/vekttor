<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
 $refeicoes=array('cafe'=>'Café','almoco'=>'Almoço','lanche'=>'Lanche','janta'=>'Janta','seia'=>'Seia');
$dia_semana=mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[data]}','%w')"),0,0);
$data_completa=mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[data]}','%d/%m/%Y')"),0,0);

$pessoas=mysql_result(mysql_query("SELECT {$_GET[refeicao]}_dia FROM cozinha_contratos WHERE id='{$_GET[contrato_id]}' "),0,0);
pr($_GET);
?>
<script></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
   
    <span>Exportação</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Exportar cardápio do <?=$refeicoes[$_GET['refeicao']]?> do dia <?=$_GET['data_selecionada']?> para: </strong>
		</legend>
        <div style="clear:both;"></div>
        
        <?php
			$data_inicio = DataBrToUsa($_GET['data_inicio']);
			$data_fim = DataBrToUsa($_GET['data_fim']);
			$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$data_fim','$data_inicio') as total_dias"),0,0);
			
			//echo "$data_inicio , $data_fim , $total_dias";
			
			for($i=0;$i<=$total_dias;$i++){
				
				
				
				$fichas_q = mysql_result(mysql_query($t="
				SELECT COUNT(*)
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g 
				WHERE 
				contrato_id='".$_GET['contrato_id']."'
				AND f.grupo_cardapio_id=g.id
				AND data='$i' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='".utf8_decode($_GET['refeicao'])."'
				ORDER BY g.nome,f.nome ASC 
				"),0,0);
				
				$disabled='';
				
				$data_ex = mysql_result(mysql_query($trace="SELECT date_add('$data_inicio',interval $i  day)"),0,0);
				
				if($fichas_q>0||$i==DataBrToUsa($_GET['data_selecionada'])){
					$disabled="disabled='disabled'";
				}
		?>
        
        <input type="checkbox" name="data_exportacao[]" class="data_exportacao" value="<?=$data_ex?>" <?=$disabled?>> <?=DataUsaToBr($data_ex)?> 
		<div style="clear:both"></div>
		<?php
		
			}
		?>

	</fieldset>
    <input type="hidden" name="data"  value="<?=$_GET[data]?>" />
    <input type="hidden" name="refeicao" value="<?=$_GET[refeicao]?>" />
    <input type="hidden" name="contrato_id" value="<?=$_GET[contrato_id]?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Exportar" style="float:right"  />
<input name="contrato_id" type="hidden"  value="<?=$_GET['contrato_id']?>" style="float:right"  />
<input name="tipo_refeicao" type="hidden"  value="<?=utf8_decode($_GET['refeicao'])?>" style="float:right"  />
<input name="data_selecionada" type="hidden"  value="<?=$_GET['data_selecionada']?>" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
<script>
$("#fichas tr:odd").addClass('al');
</script>
</div>
</div>
</div>

<script>top.openForm()</script>