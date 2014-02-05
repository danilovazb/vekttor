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
    <div style="width:500px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Escola</span>
            </div>
        </div>
        <!-- width:458px; overflow:auto; max-height:600px; -->
		<form onsubmit="return validaForm(this)" style=" " class="form_float" method="post">

            <input name="id" type="hidden" value="<?php echo $_GET['id']; ?>" />
            
            <fieldset id="campos_1" style="">
                <legend>
                     <a onclick="aba_form(this,0)"><strong>Dados da Escola</strong></a>
                     


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
                <label style="width:75px;">
                	Qtd. de salas<input id="qtd_salas" sonumero="1" maxlength="3" type="text" />
                </label>
                
                <div id="preenchimento_salas" style=" clear:both; overflow:auto; max-height:200px;">
                
                </div>
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