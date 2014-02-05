<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
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
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Configurações da Conta</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
    <input type="hidden" name="id" value="<?=$registro->id?>">
	<fieldset  id='campos_1' >
		<legend>
			<strong>Configurações</strong>
		</legend>
		<div style="clear:both;"></div>
                 <label style="width:150px;">
                  Conta
                  <select name="conta_id" id="conta_id">
                        <option value='0'  >Selecione 1 Conta</option> 
                  <?
                  $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
                  while($r= mysql_fetch_object($q)){
                    $saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
                    $saldo=number_format($saldo,2,',','.');
                    if($obj->id>0){
                        if($r->id==$obj->conta_id){$sel = "selected='selected'";}else{$sel = "";}
                    }else{
                        if($r->id==$registro->conta_id){$sel = "selected='selected'";}else{$sel = "";}
                    }
                        echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
                    }
                  ?>
                    
                 </select>
                </label>    
                 <label style="width:120px;">
                    
                    Centro de Custos
                    <select name="centro_custo_id[]" id='centro_custo_id'>
                        <?
                            exibe_option_sub_plano_ou_centro('centro',0,$registro->centro_custo_id,0);
                        ?>
                      </select>
                </label>
                <label style="width:120px;">
                    Plano de Conta
                    <select name="plano_de_conta_id[]" id="plano_de_conta_id">
                        <?
        
                    exibe_option_sub_plano_ou_centro('plano',0,$registro->plano_conta_id,0);
        
                        ?>
                      </select>
                </label>
        		<div style="clear:both;"></div>
                <label>
                	Almoxarifado 
                    <select name="almoxarifado_id">
                    	<?
                        	$sql = mysql_query(" SELECT * FROM cozinha_unidades WHERE vkt_id = '$vkt_id' ");
							while($almoxarifado = mysql_fetch_object($sql)){
								if($registro->almoxarifado_id == $almoxarifado->id){ $sel= 'selected="selected"';} else { $sel= '';}
						?> 
                    	<option <?=$sel?> value="<?=$almoxarifado->id?>"> <?=$almoxarifado->nome?></option>
                    	<?
							}
						?>
                    </select>
                </label>
	</fieldset>
	<input name="id" type="hidden" value="<?=$registro->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id > 0){
?>
<!--<input name="action" type="submit" value="Excluir" style="float:left" />-->
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