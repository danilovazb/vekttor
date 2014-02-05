<?php
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
disabled{ background:#CCC;}
</style>
<div style="top:30px; left:50px;" class="exibe_formulario" id="exibe_formulario">
<div id='aSerCarregado'>
    <div style="width:495px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Ensino</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="id" type="hidden" value="<?php echo $registro->id?>" />
            
            <fieldset id="campos_1">
                <legend>
                <strong>Ensino</strong>
                </legend>
                
                <label style="width:250px; ">
                    Nome
                    <input type="text" id="nome" name="nome" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?php echo $registro->nome?>" />
                </label>
          		 <label style="width:80px; ">
                    Ordem <br>
                    <input type="text" id="ordem_ensino" sonumero="1" style="width:70px;" name="ordem_ensino" valida_minlength="1" retorno="focus|Coloque no minimo 1 caracteres" value="<?php echo $registro->ordem_ensino?>" />
                </label>
                
                <!--<button type="button" id="salvar_ensino" style="margin-top:18px;">Salvar</button>-->
               
                <div style="clear:both;"></div>
                
                <!--<div>
                	<label >S&eacute;rie<br/>
                     <input type="hidden"  name="serie_id[]" value="<?=$serie->id?>"/>
                     <input style="width:210px;" type="text" disabled="disabled"  name="serie" id="serie" valida_minlength="0" retorno="focus|Coloque no minimo 5 caracteres" value="<?=$serie->nome?>" />  
                   </label>
                    <!-- -->
                   <!--<label style="width:70px;">Ordem S&eacute;rie<br/>
                     <input type="text" name="ordem_ensino" id="ordem_ensino" disabled="disabled" value="1" sonumero="1">
                   </label>
                   <!-- -->
                   <!--<label><br/>
                        <button style="margin-top:2px;" type="button" id="adiciona_serie" disabled="disabled">Adicionar</button>
                   </label>
                </div>-->
                <!-- -->
                <!--<div style="clear:both"></div>
                <div>
                <table cellpadding="0" cellspacing="0" style="width:100%;border-left:1px solid #CCC;">
                  <thead> 
                      <tr style="border-left:1px solid #999;">
                          <td width="130">S&eacute;rie</td>
                          <td width="30">Ordem Ensino</td>
                      </tr>
                  </thead>
                  <tbody id="lista_serie"></tbody>
                </table>
                </div>-->
              
          </fieldset>
          <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $registro->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
                <?php } ?>
                <input type="hidden" name="acao" value="salvar_ensino">
                <input name="action" type="submit" value="Salvar" style="float:right" />

                
              <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script></div>