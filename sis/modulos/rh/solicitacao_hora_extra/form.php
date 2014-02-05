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
<div style="width:320px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Solicitacao Hora Extra</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
       
        <label style="width:200px;">
        	Empresa
			<select name="empresa_id" id="empresa_id" valida_minlength="2" retorno"focus|Selecione uma Empresa">
          	
            <option value="">Selecione uma Empresa</option>  	
            
            <?php
				while($r=mysql_fetch_object($q)){
					if($solicitacao_hora_extra->empresa_id==$r->id){
						$selected="selected='selected'";
					}
					echo "<option value='$r->id' $selected>$r->razao_social</option>";				
				}
			?>    
                
            </select>
        </label>
        
        <div style="clear:both"></div>
        
        <?php
			if($solicitacao_hora_extra->id>0){
				$display="block";
				
			}else{
				$display="none";
			}
		?>
        
        <div id="divfuncionario" style="display:<?=$display?>">
        	<?=$funcionarios?>
        </div>
        
        <label style="width:90px;">
        	Data
			<input type="text" name="data" id="data" calendario="1" sonumero="1" value="<?=DataUsaToBr($solicitacao_hora_extra->data)?>" mascara="__/__/____"/>
        </label>
        
        <div style="clear:both"></div>
        
          <label style="width:90px;">
        	Hora Início
			<input type="text" name="hora_inicio" id="hora_inicio" sonumero="1" value="<?=substr($solicitacao_hora_extra->hora_inicio,0,5)?>" mascara="__:__"/>
        </label>
        
               
        <label style="width:90px;">
        	Hora Fim
			<input type="text" name="hora_fim" id="hora_fim" sonumero="1" value="<?=substr($solicitacao_hora_extra->hora_fim,0,5)?>" mascara="__:__"/>
        </label>
        
         <div style="clear:both"></div>
        
        <label>
        	Observação
			<textarea name="obs" id="obs" style="height:100px;"/>
            	<?=$solicitacao_hora_extra->observacao?>
            </textarea>
        </label>
              
	</fieldset>
	<input name="id" type="hidden" value="<?=$solicitacao_hora_extra->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($solicitacao_hora_extra->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input type="submit" id="action" name="action" value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>