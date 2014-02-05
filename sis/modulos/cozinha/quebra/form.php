<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
include '_functions.php';
include '_ctrl.php';
// funções do modulo empreendimento
 $refeicoes=array('cafe'=>'Café','almoco'=>'Almoço','lanche'=>'Lanche','janta'=>'Janta','seia'=>'Seia');
$dia_semana=mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[data]}','%w')"),0,0);
$data_completa=mysql_result(mysql_query("SELECT DATE_FORMAT('{$_GET[data]}','%d/%m/%Y')"),0,0);

?>
<script></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div>
<div id='aSerCarregado'>
<div style="width:420px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
   
    <span>Quebra</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong><?=$refeicoes[$_GET[refeicao]]?> - <?=$semana_extenso[$dia_semana]?>  - <?=$data_completa?></strong>
		</legend>
        <div style="clear:both;">
        
          <br />
          <table style=" float:left; clear:both; width:340px;" cellpadding="0" cellspacing="0">
            
            <thead>
        <tr>
        	<td width="150">Ficha<div id="result_teste"></div></td>
            <td>Pessoas</td>
            <td>KG Desperd&iacute;cio</td>
            </tr>
        </thead>
        <tbody style="background-color:white;" id="fichas">
        <? 
		$itens_dia_q=mysql_query("
		SELECT 
			f.nome as ficha, f.id as ficha_id, c.pessoas as pessoas, c.id as id_c, c.desperdicio as desperdicio
		FROM 
			cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
		WHERE 
			f.id=c.ficha_tecnica_id
			AND contrato_id='{$_GET[contrato_id]}' 
			AND data='{$_GET[data]}'
			AND c.vkt_id='$vkt_id'
			AND  FIND_IN_SET('{$_GET[refeicao]}',tipo_refeicao) "); 
			while($item=mysql_fetch_object($itens_dia_q)){
			?>
            <tr>
                <td>
                   <?=$item->ficha.' - '.$item->id_c?>
                </td>
                <td><?=$item->pessoas?>
                    <input type="hidden" name="ficha_id" id="ficha_id" value="<?=$item->id_c?>">
                    <input type="hidden" name="pessoas[]" style="height:10px;" sonumero="1" value="<?=$item->pessoas?>"  size="5" />
                </td>
                <td><input type="text" name="desperdicio" id="desperdicio" style="height:10px;" sonumero="1" value="<?=$item->desperdicio?>"  size="5" /></td>
            </tr>
            <? } ?>
            
            
           
            
        </tbody>
        </table>
        </div>

	</fieldset>
    <input type="hidden" name="data"  value="<?=$_GET[data]?>" />
    <input type="hidden" name="refeicao" value="<?=$_GET[refeicao]?>" />
    <input type="hidden" name="contrato_id" value="<?=$_GET[contrato_id]?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Salvar" style="float:right"  />
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