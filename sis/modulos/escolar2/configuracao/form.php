<?php
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
disabled{ background:#CCC;}
</style>
<div style="top:30px; left:50px;" class="exibe_formulario" id="exibe_formulario">
<div id='aSerCarregado'>
    <div style="width:520px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Configura&ccedil;&otilde;es</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="id" type="hidden" value="<?php echo $conta->id?>" />
            
            <fieldset id="campos_1">
                <legend>
                <strong>Configura&ccedil;&otilde;es</strong>
                </legend>
                
                
                  <div style="margin-bottom:15px; padding:5px;">Cobrar?
          
                    <input type="radio" <? if($conta->cobrar == 1) { echo 'checked="checked"';}?> name="cobrar" id="cobrar" value="sim" > Sim
           
                	<input type="radio" <? if($conta->cobrar == 2) { echo 'checked="checked"';}?> name="cobrar" id="cobrar" value="nao"> N&atilde;o
                    
                  </div> 
                
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
					if($r->id==$conta->conta_id){$sel = "selected='selected'";}else{$sel = "";}
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
					exibe_option_sub_plano_ou_centro('centro',0,$conta->centro_custo_id,0);
				?>
              </select>
        </label>
        <label style="width:120px;">
			Plano de Conta
			<select name="plano_de_conta_id[]" id="plano_de_conta_id">
              	<?

			exibe_option_sub_plano_ou_centro('plano',0,$conta->plano_conta_id,0);

				?>
              </select>
        </label>
        <div style="clear:both;"></div>
    	<label>
    			Informa&ccedil;&otilde;es da Conta<br/>
    				<textarea name="obsConta" id="obsConta" cols="40"><?=$conta->obs_conta?></textarea>
    	</label>    
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