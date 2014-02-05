<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
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
   
    <span>Abrir Necessidade</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		</legend>
        <div style="clear:both;"></div>
        
        <?php
			$data_inicio = DataUsaToBr($_GET['filtro_inicio']);
			$data_fim = DataUsaToBr($_GET['filtro_fim']);
			$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$data_fim','$data_inicio') as total_dias"),0,0);
			$unidade_origem = mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY id ASC LIMIT 1"));
			$unidade_destino        = mysql_fetch_object(mysql_query("
			SELECT 
				*, cu.id as cozinha_unidade_id
			FROM 
				cozinha_unidades cu,
				cozinha_contratos cc 
			WHERE 
				cc.unidade_id = cu.id AND
				cc.id = '".$_GET['contrato_id']."'
			"));
			//echo "$data_inicio , $data_fim , $total_dias";
			echo "<strong>Contrato: </strong>".$_GET['contrato_id']." <div style=''clear:both;margin-bottom:10px;'></div>";
			echo "<strong>Origem: </strong>$unidade_origem->nome <div style=''clear:both;margin-bottom:10px;'></div>";	
			echo "<strong>Destino: </strong>$unidade_destino->nome <div style=''clear:both;margin-bottom:10px;'></div>";	
			echo "<strong>Período: </strong>De $data_inicio à $data_fim<div style=''clear:both;margin-bottom:10px;'></div>";	
						
		?>

	</fieldset>
    <input type="hidden" name="data"  value="<?=$_GET[data]?>" />
    <input type="hidden" name="refeicao" value="<?=$_GET[refeicao]?>" />
    <input type="hidden" name="contrato_id" value="<?=$_GET[contrato_id]?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="button"  value="Abrir Necessidade" style="float:right"  onClick="window.open('?filtro_inicio=<?=$data_inicio?>&filtro_fim=<?=$data_fim?>&unidade_id_origem=<?=$unidade_origem->id?>&unidade_id_destino=<?=$unidade_destino->cozinha_unidade_id?>&grupo_id=0&tela_id=203')" t/>
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