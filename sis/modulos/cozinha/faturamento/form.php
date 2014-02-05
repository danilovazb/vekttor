<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_function.php");
include("_ctrl.php");

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
    
    <span>Faturamento</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'>
		<legend>
			<strong>Informações</strong>
		</legend>
		
        <!-- select na tabela projetos -->
        <label style="width:250px;">
		<select name="contrato_id" id="contrato_id" >
			<option value="0"> Contrato </option>
            	<?
                	$sql=mysql_query("SELECT 
											distinct cc.cliente_id,cf.razao_social,cc.id as contrato_id
										FROM 
											cozinha_contratos cc
										
										JOIN cliente_fornecedor cf
										  
										  ON cf.id=cc.cliente_id
										
										WHERE vkt_id = '$vkt_id' ");
						while($r=mysql_fetch_object($sql)){
							if($faturamento->contrato_id == $r->contrato_id){$sel='selected="selected"';} else{$sel="";}
				?>
				<option <?=$sel?> value="<?=$r->contrato_id?>"><?=$r->contrato_id?> - <?=$r->razao_social?></option>
                <?
						}
				?>
		</select>
        </label> 
           
        <div style="clear:both; margin:8px;"></div>
        <label>
        		Nota Fiscal<br/>
                	<input type="text" name="nota_fiscal" id="nota_fiscal" size="25">
        </label>
        <div style="clear:both;"></div>
         <label>
        		Descriçao<br/>
                	<input type="text" name="descricao" id="descricao" size="25">
        </label><br/>
        <div style="clear:both;"></div>
        <div>Periodo</div>
        <label style="width:220px;" >
          <div style="float:left; padding:4px;">
          <input name="data_inicio" id="data_inicio" style="width:70px;" mascara='__/__/____' value="<?=$data_ini?>" calendario='1' />
          </div>
          <div style="float:left;padding:4px;">
          
          <input name="data_fim" id="data_fim" style="width:70px;" mascara='__/__/____' calendario='1' value="<?=$data_fim?>" />
          </div>
        </label><br/>
            
        <div style="clear:both; margin:8px;"></div>
        <label style="width:70px;" >Vencimento
          <div style="padding:2px">
          <input name="vencimento" id="vencimento" style="width:70px;" maxlength="5" value="<?=$faturamento->vencimento?>" /></div>
        </label>
        
        <label style="width:100px;" id="valor_contrato">Valor
          <div style="padding:2px;"><input name="valor" id="valor" style="width:70px;" value="<?=moedaUsaToBr($faturamento->valor)?>" /></div>
        </label>

            
	</fieldset>
	<input name="id" type="hidden" value="<?=$faturamento->id?>" />	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($faturamento->id > 0){
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