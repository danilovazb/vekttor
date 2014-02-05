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
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Contas</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		<label style="width:311px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$conta->nome?>" autocomplete='off' maxlength="44"/>
		</label>
        <label style="float:left; margin-right:15px; width:100px;" > Agência <span style="font-size:9px; color:#999">Sem Digito</span>
        	<input name="agencia" value="<?=$conta->agencia ?>" width="60px" />
        </label>
        <label>Digito<br />
        	<input size="1" style="width:20px;" value="<?=$conta->agencia_digito ?>" name="agencia_digito" type="text" />
        </label>
        <div style="clear:both;"></div>
        <label style="width:100px;" > Conta <span style="font-size:9px; color:#999">Sem Digito</span>
        	<input name="conta" style="width:100px;" value="<?=$conta->conta  ?>" />
        </label>
        <label>Digito<br />
        	<input size="1" style="width:20px;" value="<?=$conta->conta_digito?>" name="conta_digito" type="text" />
        </label>
        <div style="clear:both; "><strong>Dados para Geração de Boleto</strong></div>
         <label style="width:100px;">
                    Banco
                    <select id="banco" name="banco" onchange="trocaBanco(this);">
						<?php
                        $dados = array("","Caixa Econômica", "Banco do Brasil","Bradesco");
                        foreach ( $dados as $valor ){
							if ( $conta->_banco == $valor ) {
								echo "<option value=\"$valor\" selected=\"selected\">$valor</option>";
							} else {
								echo "<option value=\"$valor\">$valor</option>";
							}
                        }
                        ?>
                    </select>
                </label>
                <div id="caixa" class='dvboletos' style="<?php if($conta->_banco != "Caixa Econômica" ) echo "display: none"; ?>">
                    <label style="width:60px;">
                        Cedente
                        <input type="text" id="conta_cedente" name="conta_cedente" value="<?php echo $conta->_conta_cedente; ?>" />
                    </label>
                    
                    <label style="width:70px;">
                        Dígito Verif.
                        <input type="text" id="conta_cedente" name="conta_cedente_dv" value="<?php echo $conta->_conta_cedente_dv; ?>" />
                    </label>
                    
                    <label style="width:70px;">
                        Carteira
                        <select name="tipo_boleto_" id="tipo_boleto_">
                        <?php
                            
                            $dados = array("90" => "CR - 90", "80" => "SR - 80", "81" => "SR - 81", "82" => "SR - 82");
                            
                            foreach ( $dados as $chave => $valor ){
                                if ( $conta->tipo_boleto_ == $chave ) {
                                    echo "<option value=\"$chave\" selected=\"selected\">$valor</option>";
                                } else {
                                    echo "<option value=\"$chave\">$valor</option>";
                                }
                            }
                            
                        ?>
                        </select>
                    </label>
                </div>
                <div id="brasil" class='dvboletos' style="<?php if($conta->_banco != "Banco do Brasil") echo "display: none"; ?>">
                    <label style="width:80px;">
                        Convênio
                        <input type="text" id="convenio" name="convenio" value="<?= $conta->_convenio; ?>" />
                    </label>
                    
                    
                    <label style="width:80px;">
                        Contrato
                        <input type="text" id="contrato" name="contrato" value="<?=$conta->_contrato; ?>" />
                    </label>
                    
                    <label style="width:60px;">
                        Carteira
                        <input type="text" id="carteira" name="carteira" value="<?=$conta->_carteira; ?>" />
                    </label>
                    
                    
                    </div>
<div id="bradesco" class='dvboletos' style="<?php if($conta->_banco != "Bradesco") echo "display: none"; ?>">      <label> Tipo de boleto / Carteira
        	<input name="tipo_boleto" style="width:80px; display:block;" value="<?=$conta->_tipo_boleto  ?>" />
        </label></div>  
		<label style="width:311px;">
        Descricao
			<textarea name="comentario" id="comentario"><?=$conta->comentario?></textarea>
		</label>
		<label >
        
			<input type="checkbox" name="preferencial" <? if($conta->preferencial==1){echo "checked";}?>  value="1" style="width:inherit; display:compact">Abrir Preferencialmente Nesta Conta
		</label>
	</fieldset>
	<input name="id" type="hidden" value="<?=$conta->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($conta->id>0){
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