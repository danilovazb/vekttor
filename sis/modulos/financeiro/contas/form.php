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
<div style="width:450px">
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
			<a onclick="aba_form(this,0)"><strong>Informações</strong></a>
            <a onclick="aba_form(this,1)">Instrunções do Boleto</a>
		</legend>
		<label style="width:311px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$conta->nome?>" autocomplete='off' maxlength="44"/>
		</label>
       <div style="clear:both"></div>
		<?
	   	if(!$conta->id>0){
	   ?>
       <label > Saldo Inicial
        	<input name="saldo_inicial" style="width:80px; display:block;" sonumero="1" value="" decimal="2" />
        </label>  
      <?
		}
	  ?>  
      <div style="clear:both"></div>
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
 	                   <option></option>
						<?php
                        //$dados = array("","Caixa Econômica", "Banco do Brasil","Bradesco");
                        foreach ( $bancos_codigos as $codigo=>$nome ){
							if ( $conta->codigo_banco == $codigo ) {
								echo "<option value=\"$codigo\" selected=\"selected\">$nome</option>";
							} else {
								echo "<option value=\"$codigo\">$nome</option>";
							}
                        }
                        ?>
                  </select>
          </label>
                 <div style="clear:both; "></div>
               
                
       
                    
                   
          <?php
		  /* tipo boleto/carteira caixa
		  $dados = array("90" => "CR - 90", "80" => "SR - 80", "81" => "SR - 81", "82" => "SR - 82");
		  
		  foreach ( $dados as $chave => $valor ){
			  if ( $conta->tipo_boleto_ == $chave ) {
				  echo "<option value=\"$chave\" selected=\"selected\">$valor</option>";
			  } else {
				  echo "<option value=\"$chave\">$valor</option>";
			  }
		  }
		 */ 
		  ?>
          <label id="codigo_cedente" style="display:<?=$codigo_cedente?>;" class='dvboletos'> Código Cedente
                <input name="codigo_cedente" style="width:80px; " value="<?=$conta->codigo_cedente  ?>" />
          </label>             
          <label id="conta_cedente" class='dvboletos' style="display:<?=$conta_cedente?>">
            Conta Cedente
            <input type="text"  name="conta_cedente" value="<?php echo $conta->_conta_cedente; ?>" />
        </label>
        <label id="conta_cedente_dv" class='dvboletos' style="display:<?=$conta_cedente_dv?>" > 
            Dígito Verif. Conta Cedente
            <input type="text"  name="conta_cedente_dv" value="<?php echo $conta->_conta_cedente_dv; ?>" />
        </label>
        <label id="carteira" class='dvboletos' style="width:60px;display:<?=$carteira?>">
                        Carteira
                        <input type="text"  name="carteira" value="<?=$conta->_carteira; ?>" />
        </label>
		<label id="variacao_carteira" class='dvboletos' style="width:70px;display:<?=$convenio_carteira?>">
                        Var Carteira
                        <input type="text"  name="variacao_carteira" value="<?=$conta->_variacao_carteira; ?>" rel="tip" title="Variação da Carteira"/>
        </label>

        <label id="contrato" class='dvboletos' style="width:80px;display:<?=$contrato?>">
                        Contrato
                        <input type="text"  name="contrato" value="<?=$conta->_contrato; ?>" />
		</label>
         <!--<label id="tipo_boleto"  class='dvboletos'> Tipo de boleto / Carteira
        	<input name="tipo_boleto" style="width:80px; display:block;" value="<?=$conta->_tipo_boleto  ?>" />
        </label>-->
        
        <label id="convenio"  class='dvboletos' style="display:<?=$convenio?>;" > Convenio
        	<input name="convenio" style="width:80px; display:block;" value="<?=$conta->_convenio  ?>" />
        </label>  
        
        <div style="clear:both"></div>
        
        <label id="num_inicio_boleto"  class='dvboletos' style="display:block;width:120px;"> Iniciar boleto em
        	<input name="num_inicio_boleto" style="width:80px; " sonumero="1" value="<?=$conta->num_inicio_boleto  ?>" />
        </label>     
       
      
        
		<label style="width:311px;">
        Descricao
			<textarea name="comentario" id="comentario"><?=$conta->comentario?></textarea>
		</label>
		<label >
        
			<input type="checkbox" name="preferencial" <? if($conta->preferencial==1){echo "checked";}?>  value="1" style="width:inherit; display:compact">Abrir Preferencialmente Nesta Conta
		</label>
	</fieldset>
    <fieldset  id='campos_1' style="display:none;">
		<legend>
			<a onclick="aba_form(this,0)">Informações</a>
            <a onclick="aba_form(this,1)"><strong>Instrunções do Boleto</strong></a>
		</legend>
       <?php
	   	for($i=1;$i<=5;$i++){
	   ?>
        <label style="display:block;width:300px;">
        	Instrunção <?=$i?>
            <?php
            	$campo = "instruncao$i";
			?>
            <input name="instruncao[]" value="<?=$conta->$campo?>" />
        </label>
        <?php
		 }
        ?>
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