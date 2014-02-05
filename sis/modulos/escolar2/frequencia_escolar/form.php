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
		<form onsubmit="return validaForm(this)" style=" " class="form_float" method="post" autocomplete="off">

            <input name="id" type="hidden" id="id" value="<?php echo $d->id; ?>" />
            
            <fieldset id="campos_1" style="">
                <legend>
                     <a onclick="aba_form(this,0)"><strong>Dados da Escola</strong></a>
                     


               </legend>
                
                <label style="width:100%; margin-right:23px;">
                    Nome
                    <input type="text" id="nome_unidade" name="nome_unidade" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?php echo $d->nome?>" />
                </label>
                
                <label>
                    CEP
                    <input type="text" id="cep" name="cep" value="<?php echo $d->cep?>" valida_minlength="9" retorno="focus|Coloque o CEP corretamente" busca='modulos/escolar2/busca/busca_endereco.php,@r0,@r0-value>cep|@r1-value>endereco|@r2-value>bairro|@r3-value>cidade|@r4-value>estado,0' autocomplete="off" mascara="_____-___"/>
                </label>
                
                <label style="width:100%;">
                    Endere&ccedil;o
                    <input type="text" id="endereco" name="endereco" value="<?php echo $d->endereco?>" />
                </label>
                
                <label style="width:143px;">
                    Bairro
                    <input type="text" id="bairro" name="bairro" value="<?php echo $d->bairro?>" />
                </label>
                
                <label style="width:143px;">
                    Cidade
                    <input type="text" id="cidade" name="cidade" value="<?php echo $d->cidade?>" />
                </label>
                
                <label style="width:45px;">
                    Estado
                    <input type="text" id="estado" name="estado" value="<?php echo $d->estado?>" />
                </label>
                
                <label style="width:45px;">
                    Número
                    <input type="text" id="numero" name="numero" value="<?php echo $d->numero?>" />
                </label>
                
                <label style="width:200px;">
                    Complemento
                    <input type="text" id="complemento" name="complemento" value="<?php echo $d->complemento?>" />
                </label>
                
                <label style="width:125px;">
                    Telefone
                    <input type="text" id="telefone" name="telefone" mascara='(__)____-____' sonumero='1' retorno="focus|Coloque o telefone corretamente" value="<?php echo $d->telefone?>" />
                </label>
                
                <label style="width:100%;">
                    E-Mail
                    <input type="text" id="email" name="email" valida_email="1" retorno="focus|Coloque o email corretamente" value="<?php echo $d->email?>" />
                </label>
                
                <label style="width:30px;">
                    Média
                    <input type="text" id="media" name="media" retorno="focus|Digite a média" value="<?php echo MoedaUsaToBR($d->media)?>" decimal="2"/>
                </label>
                <?php
					$salas = mysql_query("SELECT * FROM escolar2_salas WHERE vkt_id='$vkt_id' AND unidade_id = '$d->id'");
				?>
                <label style="width:75px;">
                	Qtd. de salas<input id="qtd_salas" sonumero="1" maxlength="3" type="text" value="<?=@mysql_num_rows($salas)?>"/>
                </label>
                
                <div id="preenchimento_salas" style=" clear:both; overflow:auto; max-height:200px;">
                	<?php
                								
						while($sala = mysql_fetch_object($salas)){
                	?>
                    	<div class='sala'>
                        	<label style="width:100px;">
                            	Nome da sala
                                <input name='nome[]' type="text" value="<?=$sala->nome?>"/>
                                <input name='sala_id[]' type="hidden" value="<?=$sala->id?>"/>
                           </label>
                           <label style="width:110px;">
                           		Capacidade máxima
                                <input name='capacidade_max[]' type="text" value="<?=$sala->capacidade_maxima?>"/>
                           </label>
                           <label style="width:130px;">
                           		Capacidade Pedagógica
                                <input name='capacidade_ped[]' type="text" value="<?=$sala->capacidade_pedagogica?>"/>
                           </label>
                       	</div>
                    <?php
						}
					?>
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