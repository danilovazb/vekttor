<?php

//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div style="top:30px; left:50px;" class="exibe_formulario" id="exibe_formulario">
<div id='aSerCarregado'>
    <div style="width:400px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Unidades</span>
            </div>
        </div>
		<form onsubmit="return validaForm(this)" class="form_float" method="post">

            <input name="id" type="hidden" value="<?php echo $_GET['id']; ?>" />
            
            <fieldset id="campos_1">
                <legend>
                     <a onclick="aba_form(this,0)"><strong>Dados da Escola</strong></a>
                     <a onclick="aba_form(this,1)">Dados Bancarios</a>
                    <a onclick="aba_form(this,2)">Termo</a>
               </legend>
                
                <label style="width:100%; margin-right:23px;">
                    Nome
                    <input type="text" id="nome" name="nome" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?php echo $d->nome?>" />
                </label>
                
                <label style="width:100%;">
                    Endere&ccedil;o
                    <input type="text" id="endereco" name="endereco" value="<?php echo $d->endereco?>" />
                </label>
                
                <label style="width:143px;">
                    Bairro
                    <input type="text" id="bairro" name="bairro" value="<?php echo $d->bairro?>" />
                </label>
                
                <label style="width:144px;">
                    Telefone
                    <input type="text" id="telefone" name="telefone" mascara='(__)____-____' sonumero='1' value="<?php echo $d->telefone?>" />
                </label>
                
                <label style="width:100%;">
                    E-Mail
                    <input type="text" id="email" name="email" valida_email="1" retorno="focus|Coloque o email corretamente" value="<?php echo $d->email?>" />
                </label>
                
                <label style="width:30px;">
                    Média
                    <input type="text" id="media" name="media" retorno="focus|Digite a média" value="<?php echo MoedaUsaToBR($d->media)?>" decimal="2"/>
                </label>
                
  </fieldset>
              <fieldset id="campos_2" style="display:none;">
                <legend>
                     <a onclick="aba_form(this,0)">Dados da Escola</a>
                     <a onclick="aba_form(this,1)"><strong>Dados Bancarios</strong></a>
                    <a onclick="aba_form(this,2)">Termo</a>
               </legend>

                <label style="width:100%;">
                    Banco
                    <select id="banco" name="banco" onchange="trocaBanco(this);">
						<?php
                        
                        $dados = array("","Caixa Econômica", "Banco do Brasil");
                        
                        foreach ( $dados as $valor ){
							if ( $d->banco == $valor ) {
								echo "<option value=\"$valor\" selected=\"selected\">$valor</option>";
							} else {
								echo "<option value=\"$valor\">$valor</option>";
							}
                        }
                        
                        ?>
                    </select>
                </label>
                
                <label style="width:80px;">
                    Agência
                    <input type="text" id="agencia" name="agencia" value="<?php echo $d->agencia?>" />
                </label>
                
                <label style="width:95px;">
                    Conta (XXXX-X)
                    <input type="text" id="conta" name="conta" value="<?php echo $d->conta?>" />
                </label>
                <div style="clear:both"></div>
                
                <div id="caixaf" style="<?php if($d->banco != "Caixa Econômica" && !empty($d->banco)) echo "display: none"; ?>">
                    <label style="width:80px;">
                        Cedente
                        <input type="text" id="conta_cedente" name="conta_cedente" value="<?php echo $d->conta_cedente; ?>" />
                    </label>
                    
                    <label style="width:95px;">
                        Dígito Verif.
                        <input type="text" id="conta_cedente" name="conta_cedente_dv" value="<?php echo $d->conta_cedente_dv; ?>" />
                    </label>
                    
                    <label style="width:96px;">
                        Carteira
                        <select name="tipo_boleto" id="tipo_boleto">
                        <?php
                            
                            $dados = array("90" => "CR - 90", "80" => "SR - 80", "81" => "SR - 81", "82" => "SR - 82");
                            
                            foreach ( $dados as $chave => $valor ){
                                if ( $d->tipo_boleto == $chave ) {
                                    echo "<option value=\"$chave\" selected=\"selected\">$valor</option>";
                                } else {
                                    echo "<option value=\"$chave\">$valor</option>";
                                }
                            }
                            
                        ?>
                        </select>
                    </label>
                </div>
                
                <div id="bbf" style="<?php if($d->banco != "Banco do Brasil") echo "display: none"; ?>">
                    <label style="width:80px;">
                        Convênio
                        <input type="text" id="convenio" name="convenio" value="<?php echo $d->convenio; ?>" />
                    </label>
                    
                    <?php
                        if( empty($d->contrato) ){
                            if( !is_object($d) ){
								$d = new stdClass();	
							}
							$d->contrato = "00000";	
                        }
                    ?>
                    <label style="width:80px;">
                        Contrato
                        <input type="text" id="contrato" name="contrato" value="<?php echo $d->contrato; ?>" />
                    </label>
                    
                    <label style="width:80px;">
                        Carteira
                        <input type="text" id="carteira" name="carteira" value="<?php echo $d->carteira; ?>" />
                    </label>
                    
                </div> 
                
                Caso o Curso não tenha dados bancarios o sistema irá assumir esses  Dados
                </fieldset>
                              <fieldset id="campos_3" style="display:none;">
                <legend>
                     <a onclick="aba_form(this,0)">Dados da Escola</a>
                     <a onclick="aba_form(this,1)">Dados Bancarios</a>
                    <a onclick="aba_form(this,2)"><strong>Termo</strong></a>
               </legend>
      
                <label style="width:100%;">
                        Termos
                        <textarea type="text" style="height:400px" id="termos" name="termos"><?php echo $d->termos; ?></textarea>
                    </label>
            </fieldset>
            
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $d->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
                <?php } ?>
                <input name="action" type="submit"  value="Salvar" style="float:right" />
                
                <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
</div>
<script>
	top.openForm();
</script>