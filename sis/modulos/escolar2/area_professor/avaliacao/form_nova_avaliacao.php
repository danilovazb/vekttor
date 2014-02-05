<?
//Includes
// configuração inicial do sistema
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php"); 
$disabled = "";
if($r->status == 2){
	$disabled = 'disabled="disabled"';
}
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:430px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Avaliaçao</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong> Avaliaç&atilde;o </strong>
		</legend>
        <input type="hidden" name="id" id="id" value="<?=$r->id?>">
        <input type="hidden" name="professor_as_turma_id" value="<?=$_GET['professor_as_turma']?>">
		
        <div style="clear:both;"></div>
        <label>
        	Data<br/>
            <input type="text" name="data_avaliacao" id="data_avaliacao" style="width:75px;" mascara="__/__/____" value="<?=dataUsaToBr($r->data);?>" calendario="1">
        </label>
        <label> Período <br/>
        	<select name="periodicidade_id" id="periodicidade_id">
            <option></option>
            	<?
				  $sql_bimestre = mysql_query(" SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id = '$vkt_id' AND unidade_id = {$_GET['unidade_id']} ORDER BY id");
					  while($r_bimestre=mysql_fetch_object($sql_bimestre)){
						if($r->periodicidade_id == $r_bimestre->id){$sel =  'selected="selected"';} else {$sel='';}
				?>
            	          <option <?=$sel?>  value="<?=$r_bimestre->id?>"><?=$r_bimestre->nome?></option>
            	<?
						}
				?>
            </select>
        </label><br/>
         
        <?
        	if($r->status == 2){
		?>
        <button type="button" id="visualizar_notas">Visualizar notas</button>
        <?
			}
		?>
        <div style="clear:both;"></div>
        <label style="width:300px;">Descriçao
		  <input type="text" id='descricao' name="descricao" value="<?=$r->descricao?>" autocomplete='off' maxlength="44"/>
		</label>
        <div style="clear:both;"></div>
            <label>Observação:<br/>
            	<textarea name="observacao" id="observacao" cols="35"><?php echo $r->observacao;?></textarea>
            </label>
       <div style="clear:both;"></div>
       <? if($r->nota_escrita == 1) { $sel='checked="checked"';} else {$sel='';}?>
       <input type="checkbox" id="nota_escrita" <?=$sel?> name="nota_escrita" <?=$disabled?> value="1"> Esta avaliação terá <strong>nota escrita</strong>
        
	</fieldset>
	
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($r->id > 0){
?>
<input name="action" type="submit" <?=$disabled?> value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  <?=$disabled?> value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>