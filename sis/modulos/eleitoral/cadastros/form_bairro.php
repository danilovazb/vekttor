<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
print_r($_POST);
print_r($_GET);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Setor</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Bairro</strong>
		</legend>
        <label style="width:250px">
   		Bairro<input type="text" name="nome" id="nome" value="<?=$bairro_q->nome?>">
    	</label>
        <div style="clear:both">
        <label style="width:250px">
        Regiao<select name="regiao_id">
		<?        
		if($bairro_q->id>0){
			$nomeregiao=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_regioes WHERE id='".$bairro_q->regiao_id."'"));
		?>
        	<option value="<?= $nomeregiao->id ?>"><?= $nomeregiao->sigla ?></option>
		<?
        }else{
		?>
        	<option value="0">Selecione uma regiao</option>
		<?
        }
        $query_r = mysql_query("SELECT * FROM eleitoral_regioes");
			while($regiao=mysql_fetch_object($query_r)){
				if($regiao->id!=$nomeregiao->id){
		?>
   		        	<option value="<?= $regiao->id?>"><?= $regiao->sigla?></option>
         <?
				}
			}
		 ?>
          </select>
    	</label>
    <input name="idbairro" type="hidden" value="<?=$bairro_q->id?>" />
	
<!--Fim dos fiels set-->
</fieldset>
<div style="width:100%; text-align:center" >
<?
if($bairro_q->id>0){
?>
<input name="actionbairro" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="actionbairro" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>