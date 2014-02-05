<?php

//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<script src="../../../../fontes/js/jquery.min.js"></script>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
    <div style="width:400px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Arquivo do Banco</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">
            
            <fieldset id="campos_1">
                <legend>
                    <strong>Importação de Arquivos</strong>
                </legend>
                
                
               
                <label style="width:100%; margin-right:23px;">
                     Selecione um arquivo de extrato .ofx que você deseja importar
                     <input type="file" name="arquivo" id="arquivo" />
                </label>
                
                <label style="width:100%;">
                    Este extrato é de qual conta bancária
                    <select name="conta_id" id="conta_id" valida_minlength="1" retorno="focus|Selecione um Banco">
<?
	$qb= mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id='$vkt_id' order by preferencial DESC");
	$tb = mysql_num_rows();
while($rb= mysql_fetch_object($qb)){
?>
						<option value="<?=$rb->id?>" <?php if($configuracao_cobranca->banco==$rb->id){ echo "selected='selected'";}?>><?=$rb->nome?></option>
<?
}
if($tb<1){echo "<option>Antes de Importar você precisa Cadastrar uma conta</option>";}
?>                   	</select>
                </label>
                
                <label style="width:100%;">
                    O que você deseja fazer com esses dados  ?
                    <select>
                    <option value="1">Lançar diretamente nas movimentações de caixa</option>
                    <option value="2">Revisar um por um antes de lançar</option>
                </select>
                
            </fieldset>
            
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <input name="action" type="submit"  value="Importar" style="float:right" />
                
                <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script>