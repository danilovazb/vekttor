<?php
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
<div style="width:680px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme">
	<a class='f_x' onClick="form_x(this)"></a>
    <span>Pacote</span>
</div>
</div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
    <input name="id" type="hidden" value="<?=$pacote->id?>" />
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'>
		  <legend>
            <a onclick="aba_form(this,0)">  <strong>Informa&ccedil;&otilde;es</strong> </a>
    		<a onclick="aba_form(this,1)"> Pacote </a>
          </legend>
        
		<label style="width:330px;">
        Descriçao
		<input type="text" name="nome" valida_minlength="3" 
        retorno="focus|Digite no mínimo 3 caracteres no campo descriçao"
        value="<?=$pacote->nome?>"/>
        </label>
        <div style="clear:both"></div>            
        <label style="width:110px;">
        Valor Implanta&ccedil;&atilde;o
			<input type="text" name="valor_implantacao" decimal="2" valida_minlength="1" retorno="focus|Digite um valor no campo Valor Normal" value="<?=moedaUsaToBr($pacote->valor_implantacao)?>"/>
        </label>
        <label style="width:110px;">
        Valor Treinamento <input type="text" name="valor_treinamento" decimal="2" valida_minlength="1" retorno="focus|Digite um valor no campo Valor Colaborador"
        value="<?=moedaUsaToBr($pacote->valor_treinamento)?>"/>
        </label>
        <div style="clear:both"></div>
        <label style="width:115px;">
        Valor Mensalidade <input type="text" name="valor_mensalidade" decimal="2" valida_minlength="1" retorno="focus|Digite um valor no campo Valor Normal"
        value="<?=moedaUsaToBr($pacote->valor_mensalidade);?>"/>
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:330px;">
        Observaçao
		<textarea name="obs"><?=$pacote->observacao?></textarea>
        </label>
        
	</fieldset>	
<!--Fim dos fiels set-->
<!-- ABA TELA -->
<fieldset style="display:none">
		<legend>
            <a onclick="aba_form(this,0)"> Informa&ccedil;&otilde;es</a>
    		<a onclick="aba_form(this,1)"> <strong> Pacote </strong> </a>
          </legend>
         <div style="clear:both"></div>
         <div style="float:left; width:200px;clear:none">
           <?
            $qasdas= mysql_query($trace="SELECT * FROM sis_modulos WHERE modulo_id ='0' order by ordem_menu ");
            	while($modulo=mysql_fetch_object($qasdas)){
					
			?>
			<a href="#" class='exibe_modulos' r='<?=$modulo->id?>'  style="text-decoration:none;color:black; display:block;"><?=$modulo->nome?></a>
           	<?
				}
			?>
            </div>
            <div class="divisao_options" style="float:left; width:400px; clear:none">
  			<?
            $qasdas= mysql_query($trace="SELECT * FROM sis_modulos WHERE modulo_id ='0' order by ordem_menu ");
            	while($modulo=mysql_fetch_object($qasdas)){
					
			?>
            <div id="div<?=$modulo->id?>" class='submodulos' style="display:none;float:left; ">
            	<?
                $q1= mysql_query("SELECT * FROM sis_modulos WHERE modulo_id ='$modulo->id'");
                while($r1=mysql_fetch_object($q1)){
					
					$seTem = @mysql_result(mysql_query($t="SELECT sis_modulo_id FROM pacote_item WHERE sis_modulo_id ='$r1->id' AND pacote_id='$pacote->id'"),0,0);
					$id = mysql_fetch_object(mysql_query($r="SELECT id,sis_modulo_id FROM pacote_item WHERE sis_modulo_id ='$r1->id' AND pacote_id='$pacote->id'"));
					//echo $t;
					if($seTem>0){$check = 'checked="checked"';}else{$check ='';}
                ?>
                	
					<label style="width:159px">
						<input type="checkbox" id="<?=$id->id?>"  value="<?=$r1->id?>" class="modulo_id" name="modulo_id[]" <?=$check?>>
						<?=$r1->nome?>
					</label>  
                <?
				}
				
				?>
                
                <div style="clear:both"></div>
                    <label style="width:159px">
						<input type="checkbox"  id="marcarTodos">Marcar Todos
						
					</label>
            </div>
           	<?
				}
			?>            
            </div>
<div id="pcDel" style="display:none"></div>
</fieldset>

<div style="width:100%; text-align:center" >
<?
if($pacote->id > 0){
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