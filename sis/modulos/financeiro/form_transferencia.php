<?

//Includes
// configuração inicial do sistema
include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento
include("_functions_financeiro.php");
include("_ctrl_financeiro.php"); 


?>
<style>
input,select,textarea{display:block; }
label{ float:left}
</style>
<link href="../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style=" width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Transferencia entre contas</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" id='form_transferencia_entre_contas' method="post" enctype="multipart/form-data" autocomplete='off'>
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
        
      <span style="color:#666">  As transferencias entre contas não influenciam no resultado financeiro da empresa.</span><br /><br />
		<label style="width:200px;">
			Conta Origem
			  <select name="conta_id_origem" id="conta_id_origem" <?=$desabilita_finalizado?> >
					<option value='0'  >Selecione 1 Conta</option> 
              <?
              $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
			  while($r= mysql_fetch_object($q)){
				$saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
				$saldo=number_format($saldo,2,',','.');
				
				if($r->id==$_GET['conta_id']){$sel = "selected='selected'";}else{$sel = "";}
					echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
				}
			  ?>
			    
		    </select>
        </label>
		<label style="width:200px;">
			Conta Destino
			  <select name="conta_id_destino" id="conta_id_destino" <?=$desabilita_finalizado?> >
					<option value='0'  >Selecione 1 Conta</option> 
              <?
              $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
			  while($r= mysql_fetch_object($q)){
				$saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
				$saldo=number_format($saldo,2,',','.');
				
				if($r->id==$obj->conta_id){$sel = "selected='selected'";}else{$sel = "";}
					echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
				}
			  ?>
			    
		    </select>
        </label>
        <label style="width:80px">Data
        	<input type="text" name="data_transferencia" mascara="__/__/____" value="<?=date("d/m/Y")?>" id="data_transferencia" calendario='1'>
        </label>
        <div style="clear:both;"></div>
		<label style="width:150px;">
			Valor R$
			  <input type="text"   decimal="2" sonumero='1' moeda='1'  style="text-align:right;" name="valor_transferido" id="valor_transferido" />
        </label>

	</fieldset>
	
	<input name="transferencia_entrecontas" type="hidden" value="1" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
  <input  type="button"  value="Confirmar Transferencia" onclick="confirma_transferencia()" style="float:right" /><div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()
top.document.getElementById('conta_id_origem').focus();
</script>