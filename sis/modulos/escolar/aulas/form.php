<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:635px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    <span>Gerenciamento - Aula</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="hidden" name="exibe" id="exibe" value="<?=$exibe?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
		<fieldset  id='campos_2'>
			<legend><strong>Aula - Informa&ccedil;&otilde;es Gerais</strong></legend>
            
            <label style="width:75px;">Data Aula<br/>
            	<input type="text" name="dta_aula" id="dta_aula" value="<?=dataUsaToBr($aula->data);?>" disabled="disabled">
            </label>
            <label>Turma<br/>
            	<input type="text" name="turma" value="<?=$smp->turma?>" disabled="disabled">
            </label>
            <label>Mat&eacute;ria<br/>
            	<input type="text" name="materia" value="<?=$materia->nome?>" disabled="disabled">
            </label>
            <label style="width:100px;">Per&iacute;odo<br/>
            	<input type="text" name="periodo" value="<?=$periodo->nome;?>" disabled="disabled">
            </label>
            <div style="clear:both;"></div>
            <label style="width:183px;">Professor<br/>
            	<input type="text" name="professor" disabled="disabled" style="width:183px;" value="<?=$professor->nome_fantasia?>">
            </label>
            <label style="width:140px;">Curso<br/>
            	<input type="text" name="curso" disabled="disabled" style="width:140px;" value="<?=$curso->nome?>">
            </label>
            <label>Status
            	<select name="status" id="status">
                	<option <? if($aula->status == 0){echo 'selected="selected"';}?> value="0">Abrir</option>
                    <option <? if($aula->status == 1){echo 'selected="selected"';}?> value="1">Finalizada</option>
                </select>
            </label>
            <div style="clear:both;"></div>
            <label style="width:345px;">Escola<br/>
            	<input type="text" name="escola" value="<?=$escola->nome?>" disabled="disabled">
            </label>
            <div style="clear:both;"></div>
            <label>Descri&ccedil;&atilde;o<br/>
            	<textarea name="descricao" disabled="disabled"><?=$aula->descricao?></textarea>
            </label>
           
            <label>Observa&ccedil;&atilde;o<br/>
            	<textarea name="observacao" id="observacao" disabled="disabled"><?=$aula->obs?></textarea>
            </label>
            <div style="clear:both;"></div>
             <label style="width:345px;">Texto da Aula<br/>
            	<textarea name="texto_aula" cols="60" rows="5" disabled="disabled"><?=$aula->texto_aula?></textarea>
            </label>
        </fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($bolsista->aluno_id>0){
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