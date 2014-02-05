<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
include("../../financeiro/_functions_financeiro.php");
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
<div style="width:420px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Configuração de pagamento</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
		
        
        <label>
        	Conta
            <select id="conta_id" name="conta_id">
            	<?php
					$contas = mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id='$vkt_id'");
					echo mysql_error();
				?>
                <option value="">SELECIONE UMA CONTA</option>
                <?php
					while($conta = mysql_fetch_object($contas)){
						if($config->conta_id==$conta->id){
							$selected="selected='selected'";
						}
						echo "<option value='$conta->id' $selected>$conta->nome</option>";
						$selected='';
					}
				?>
            </select>
        </label>
        
        <label style="width:285px;">Centro de custo<br>
        </label>
        
        <div style="clear:both;">
        <label>
          <select name="centro_custo_id" id='centro_custo_id'>
                        <?
                            exibe_option_sub_plano_ou_centro('centro',0,$config->centro_custo_id,0);
                        ?>
                      </select>
                     </label>
        </div>
        <label style="width:285px;">Plano de conta<br>
        	<select name="plano_conta_id" id="plano_conta_id">
                        <?
        
                    exibe_option_sub_plano_ou_centro('plano',0,$config->plano_conta_id,0);
        
                        ?>
                      </select>
		</label>
	</fieldset>
	<input name="id" type="hidden" value="<?=$config->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<? if($select->id > 0){ ?>
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
