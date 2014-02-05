<?
//Includes
include("../../../_functions_base.php");
include("../../../_config.php");
include("_functions.php");
include("_ctrl.php");
// funções base do sistema


?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Negociações Restritas</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		  <strong>Informações </strong></strong></legend>
          <label><strong>Empreendimento:</strong> <?=$empreendimento->nome?></label>
          <div style="clear:both"></div>
          <label><strong>Negociação</strong>: <?=$negociacao->nome?></label>
          <div style="clear:both"></div>
          
          
		<label style="width:311px;">
			Cliente
			<input type="text" id='nome' name="nome" value="" autocomplete='off' busca='modulos/administrativo/negociacoes_restritas/buscar_clientes.php?negociacao_id=<?=$negociacao->id?>,@r0 @r2,@r1-value>cliente_id,0' maxlength="44"/>
		</label><br />
        <input type="hidden" name="cliente_id" id="cliente_id" /><br />
		<input name="negociacao_id" type="hidden" value="<?=$negociacao->id?>" />
        <label><strong>Cliente Relacionados:</strong></label><div style="clear:both;"></div>
        <? while($empreendimento_existente=mysql_fetch_object($empreendimentos_existentes_q)){ 
		$e=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id = '{$empreendimento_existente->cliente_id}'"));
		?>
        <label><?=$e->razao_social?> <span><a href="?deletar=<?=$e->id?>&negociacao_id=<?=$id?>&tela_id=172"  style="color:red;">X</a></span></label><div style="clear:both;"></div>
        <? }?>
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($usuario->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>