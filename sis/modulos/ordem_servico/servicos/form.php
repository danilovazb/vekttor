<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

echo $servico->extensao;
if(empty($servico->extensao)){
	$tam_form = "450px";
}else{
	$tam_form = "600px";
}

?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div>
<div id='aSerCarregado'>
<div style="width:<?=$tam_form?>">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Servicos</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        
       <?
       if(!empty($servico->extensao)){
	   ?>
        <div style="float:right" id="div_foto">
        	<img src="modulos/ordem_servico/servicos/fotos/<?=$servico->id.".".$servico->extensao?>" width="150" height="150"/>
            <div style="clear:both"></div>
            <a href="#" id="remover_foto">Remover Foto</a>
        </div>
        <?
	    }
		?>
        <div style="float:left">
		<label style="width:330px;">
        Descriçao
		<input type="text" name="descricao" valida_minlength="3" 
        retorno="focus|Digite no mínimo 3 caracteres no campo descriçao"
        value="<?=$servico->nome?>"/>
        </label>
        
        <div style="clear:both"></div>
               
        <label style="width:100px;" valida_minlength="1" 
        retorno="focus|Selecione uma unidade">
        Unidade
        <select name="unidade" id="unidade">
        	<option <? if($servico->und==''){echo 'selected=selected';}?>>Selecione</option>
            <option <? if($servico->und=='Fardo'){echo 'selected=selected';}?>>Fardo</option>
            <option <? if($servico->und=='Kg'){echo 'selected=selected';}?>>Kg</option>
            <option <? if($servico->und=='g'){echo 'selected=selected';}?>>g</option>
            <option <? if($servico->und=='Litro'){echo 'selected=selected';}?>>Litro</option>
            <option <? if($servico->und=='ml'){echo 'selected=selected';}?>>ml</option>
            <option <? if($servico->und=='Caixa'){echo 'selected=selected';}?>>Caixa</option>
            <option <? if($servico->und=='Unidade'){echo 'selected=selected';}?>>Unidade</option>
            <option <? if($servico->und=='Saco'){echo 'selected=selected';}?>>Saco</option>
            <option <? if($servico->und=='Pacote'){echo 'selected=selected';}?>>Pacote</option>
            <option <? if($servico->und=='Lata'){echo 'selected=selected';}?>>Lata</option>
            <option <? if($servico->und=='Metro'){echo 'selected=selected';}?>>Metro</option>
            <option <? if($servico->und=='m2'){echo 'selected=selected';$displayund="block";}?> value="m2">m2</option>
        </select>
		</label>
        
            
        <label style="width:80px;">
        Valor
		<input type="text" name="vl_normal" valida_minlength="1" 
        retorno="focus|Digite um valor no campo Valor Normal"
        value="<?=moedaUsaToBr($servico->valor_normal)?>"/>
        </label>
        
        <label style="width:100px;">
        Valor Colaborador
		<input type="text" name="vl_colaborador" valida_minlength="1" 
        retorno="focus|Digite um valor no campo Valor Colaborador"
        value="<?=moedaUsaToBr($servico->valor_colaborador)?>"/>
        </label>
        <div style="clear:both"></div>
        <label style="width:115px;">
        Tempo de Execuçao
		<input type="text" name="tempo_execucao" mascara="__:__" valida_minlength="1" 
        retorno="focus|Digite um valor no campo Tempo de Execuçao"
        value="<?=substr($servico->tempo_execucao,0,5);?>"/>
        </label>
        
        <label style="width:115px;">
        Grupo
        <select name="grupo_servico" id="grupo_servico">
        <option></option>
		<?php
			$grupos = mysql_query("SELECT * FROM servico_grupo WHERE vkt_id='$vkt_id'");
			while($grupo=mysql_fetch_object($grupos)){
		?>
        	<option value="<?=$grupo->id?>" <?php if($grupo->id==$servico->grupo_id){ echo "selected='selected'";}?>><?=$grupo->nome?></option>
        <?php
			}
		?>
        </select>
        </label>
        
        <div style="clear:both"></div>
        
          
        <label style="width:115px;">
        	Código Interno <input type="text" name="codigo_interno" id="codigo_interno" value="<?=$servico->codigo_interno?>"/>
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:115px;">
        	Foto <input type="file" name="foto_servico" id="foto_servico"/>
        </label>
                
                     
        <div style="clear:both"></div> 
        <label style="width:330px;">
        Observaçao
		<textarea name="obs"><?=$servico->observacao?></textarea>
        </label>
        </div>
	</fieldset>
	<input name="id" id="id" type="hidden" value="<?=$servico->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($servico->id > 0){
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