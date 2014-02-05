<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>COBRANÇA</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        
       <?php
	   		if($cobranca->id>0){
				echo "EMPRESA: ".$cliente_fornecedor->razao_social;
			}
	   ?>
       
        <label style="width:300px;">
        	Descriçao
		<input type="text" name="descricao" id="descricao" valida_minlength="3" value="<?=$cobranca->descricao?>"/>
        </label>
        
       <label style="width:107px">
            Data de Vencimento
            <input type="text" id='data_vencimento' name="data_vencimento" value="<? if(empty($cobranca->data_vencimento)){ echo date("d")."/".date("m")."/".date("Y");}else{ echo DataUsaToBr($cobranca->data_vencimento);}?>" calendario="1" mascara="__/__/____"/>
           	           
        </label>
        
        <?php
	   		if($cobranca->id>0){
		?>
               
        <label style="width:80px;">
        	Valor
		<input type="text" name="valor" id="valor" valida_minlength="3" value="<?=moedaUsaToBr($cobranca->valor)?>" decimal="2" sonumero="1"/>
        </label>
        <?php
				if($cobranca->situacao=='0'){
		?>
        <div style="clear:both"></div>
        
       		
     
        		<input type="checkbox" name="confirma_pagamento" id="confirma_pagamento"/>Confirmar Pagamento
		       
        <div style="clear:both"></div>
        
        <?
				}
			}
			
			if($cobranca->situacao==0){
				$exibe_data_pagamento = "none";
			}else{
				$exibe_data_pagamento = "block";
			}
	   ?>
        
      <label style="width:107px;margin-top:10px;display:<?=$exibe_data_pagamento?>" id="div_data_pagamento">
          Data de Pagamento
          <input type="text" id='data_pagamento' name="data_pagamento" value="<? if(empty($cobranca->data_pagamento)||$cobranca->data_pagamento="00/00/0000"){ echo date("d")."/".date("m")."/".date("Y");}else{ echo DataUsaToBr($cobranca->data_pagamento);}?>" calendario="1" mascara="__/__/____"/>
                 
      </label>
        
        
	</fieldset>
	<input name="id" id="id" type="hidden" value="<?=$cobranca->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($cobranca->id > 0){
?>
<input name="action" type="submit"  value="Excluir" style="float:left"/>
<input name="action" type="button" id="imprimir_1_boletos" value="Imprimir Boleto"/>
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