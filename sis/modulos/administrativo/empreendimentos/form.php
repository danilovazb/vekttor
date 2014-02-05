<?
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_ctrl.php");
include("_functions.php"); 

?><link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado'>
<div style="width:600px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Empreendimentos</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		<a onclick="aba_form(this,0)"><strong>Informacoes</strong></a>
		<a onclick="aba_form(this,1)">Administrador</a>
        <a onclick="aba_form(this,2)">Financeiro</a>
        <a onclick="aba_form(this,3)">Contrato</a>
		</legend>
		<label style="width:475px;">
			Nome 
			<input type="text" id='nome' name="nome" valida_minlength='5'  value="<?=$r->nome?>" maxlength="255"/>
		</label>
        <label style="width:475px;">
			Razao Social 
		<input type="text" id='razao_social' name="razao_social" valida_minlength='5'  value="<?=$r->razao_social?>" maxlength="255"/>
		</label>
        <label style="width:115px;">
			CNPJ 
			<input type="text" id='cnpj' name="cnpj" valida_minlength='5'  value="<?=$r->cnpj?>" maxlength="255" mascara='__.___.___/____-__'/>
		</label>
        <label style="width:170px;">
			Logradouro
			<input type="text" id='logradouro' name="logradouro" valida_minlength='5'  value="<?=$r->logradouro?>" maxlength="255"/>
        </label>
         <label style="width:20px;">
			No
			<input type="text" id='numero' name="numero" value="<?=$r->numero?>" maxlength="255"/>
         </label>
         <label style="width:115px;">
			Bairro
			<input type="text" id='bairro' name="bairro" valida_minlength='5'  value="<?=$r->Bairro?>" maxlength="255"/></label>
            <label style="width:115px;">
			Cidade
			<input type="text" id='cidade' name="cidade" valida_minlength='5'  value="<?=$r->cidade?>" maxlength="255"/></label>
            <label style="width:115px;">
			Estado
			<input type="text" id='estado' name="estado" valida_minlength='5'  value="<?=$r->estado?>" maxlength="255"/></label>
         <label style="width:300px;">
			Complemento
			<input type="text" id='complemento' name="complemento"  value="<?=$r->logradouro?>" maxlength="255"/>		</label>       
		<label style="width:160px;">
			Orçamento
			<input type="text" name="orcamento" id="orcamento" value="<?=moedaUsaToBr($r->orcamento)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right"  />
		</label>
		<label style="width:160px">
			Início
			<input name="inicio" id='inicio' type="text" value="<?=dataUsaToBr($r->inicio)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Data Simples' />
		</label>
		<label style="width:160px">
			Fim
			<input name="fim" id='fim' type="text" value="<?=dataUsaToBr($r->fim)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Data Simples' />
		</label>
        <label style="width:160px">
			Obs.
			<textarea name="obs"><?=$r->obs?></textarea>
		</label>
		<input name="id" type="hidden" value="<?=$r->id?>" />
		<input name="tipo" type="hidden" value="Empreendimento" />
	</fieldset>
    <fieldset  id='campos_2' style="display:none;">
		<legend>
		<a onclick="aba_form(this,0)">Informacoes</a>
		<a onclick="aba_form(this,1)"><strong>Administrador</strong></a>
        <a onclick="aba_form(this,2)">Financeiro</a>
        <a onclick="aba_form(this,3)">Contrato</a>
		</legend>
		<label style="width:475px;">
			Administrador 
			<input type="text" id='administrador' name="administrador" valida_minlength='5'  value="<?=$r->administrador?>" maxlength="255"/>
		</label>
        <label style="width:115px;">
			Naturalidade 
			<input type="text" id='administrador_naturalidade' name="administrador_naturalidade" valida_minlength='5'  value="<?=$r->administrador_naturalidade?>" maxlength="255"/>
		</label>
        <label style="width:170px;">
			Profissao
			<input type="text" id='administrador_profissao' name="administrador_profissao" valida_minlength='5'  value="<?=$r->administrador_profissao?>" maxlength="255"/>
        </label>
         <label style="width:100px;">
			Estado Civil
			<select name='administrador_estado_civil'>
            	<option value="solteiro" <? if($r->administrador_estado_civil=='solteiro'){echo 'selected=selected';}?>>Solteiro(a)</option>
                <option value="noivo" <? if($r->administrador_estado_civil=='noivo'){echo 'selected=selected';}?>>Noivo(a)</option>
                <option value="casado" <? if($r->administrador_estado_civil=='casado'){echo 'selected=selected';}?>>Casado(a)</option>
                <option value="uniao estavel" <? if($r->administrador_estado_civil=='uniao estavel'){echo 'selected=selected';}?>>Casado(a)</option>
            </select>
         </label>
         <label style="width:115px;">
			RG No
			<input type="text" id='administrador_rg' name="administrador_rg" valida_minlength='5'  value="<?=$r->administrador_rg?>" maxlength="255"/></label>
         <label style="width:100px;">
			Orgao Expedidor
			<input type="text" id='administrador_orgao_expedidor' name="administrador_orgao_expedidor" valida_minlength='5'  value="<?=$r->administrador_orgao_expedidor?>" maxlength="255"/>		
          </label>       
		<label style="width:140px;">
			CPF
			<input type="text" name="administrador_cpf" id="administrador_cpf" value="<?=$r->administrador_cpf?>" maxlength="23" mascara='___.___.___-__' sonumero="1" />
		</label>
		<label style="width:470px">
			Endereço
			<input name="administrador_endereco" id='administrador_endereco' type="text" value="<?=$r->administrador_endereco?>" maxlength="100" />
		</label>
		<label style="width:160px">
			Bairro
			<input name="administrador_bairro" id='administrador_bairro' type="text" value="<?=$r->administrador_bairro?>" maxlength="23"/>
		</label>
        <label style="width:80px">
			Cidade
			<input name="administrador_cidade" id='administrador_cidade' type="text" value="<?=$r->administrador_cidade?>" maxlength="23"/>
		</label>
        <label style="width:80px">
			Estado
			<input name="administrador_estado" id='administrador_estado' type="text" value="<?=$r->administrador_estado?>" maxlength="23"/>
		</label>
		<input name="id" type="hidden" value="<?=$r->id?>" />
		<input name="tipo" type="hidden" value="Empreendimento" />
	</fieldset>
    
    <fieldset id="campos_3" style="display:none;">
    <legend>
		<a onclick="aba_form(this,0)">Informacoes</a>
		<a onclick="aba_form(this,1)">Administrador</a>
        <a onclick="aba_form(this,2)"><strong>Financeiro</strong></a>
        <a onclick="aba_form(this,3)">Contrato</a>
		</legend>
        <label style="width:150px;">
			Conta
			  <select name="conta_id" id="conta_id" <?=$desabilita_finalizado?> >
					<option value='0'  >Selecione 1 Conta</option> 
              <?
              $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
			  while($b= mysql_fetch_object($q)){
				if($obj->id>0){
					if($b->id==$obj->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}else{
					if($b->id==$_GET['conta_id']){$sel = "selected='selected'";}else{$sel = "";}
				}
					echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
				}
			  ?>
			    
		    </select>
        </label>
        <label style="width:120px;">
            
			Centro de Custos
			<select name="centro_custo_id[]" id=''>
              	<?
    
				exibe_option_sub_plano_ou_centro('centro',0,$rcp->plano_id,0);

				?>
              </select>
        </label>
        <label style="width:120px;">
			Plano de Conta
			<select name="plano_de_conta_id[]">
              	<?

			exibe_option_sub_plano_ou_centro('plano',0,$rcp->plano_id,0);

				?>
              </select>
        </label>
        <label></label>
    </fieldset>
    <fieldset id="campos_4" style="display:none;">
    <legend>
		<a onclick="aba_form(this,0)">Informacoes</a>
		<a onclick="aba_form(this,1)">Administrador</a>
        <a onclick="aba_form(this,2)">Financeiro</a>
        <a onclick="aba_form(this,3)"><strong>Contrato</strong></a>
	</legend>
    <label>Contrato
    	<textarea name="contrato_texto"></textarea>
    </label>
    
    </fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Salvar" style="float:right"  />

<?
if($r->id > 0 ){
?>
<input name="action" type="submit" value="Excluir" style="float:left"  />

<input name="action" type="button"  value="Disponibilidades" style="float:right; margin-right:5px;" onclick="location.href='?tela_id=60&empreendimento_id=<?=$r->id?>'" />

<input name="action" type="button"  value="Tipos" style="float:right; margin-right:5px;" onclick="location.href='?tela_id=65&empreendimento_id=<?=$r->id?>'" />

<input name="action" type="button"  value="Negociacao" style="float:right; margin-right:5px;" onclick="location.href='?tela_id=58&empreendimento_id=<?=$r->id?>'" />

<input name="action" type="button"  value="Planejamento" style="float:right; margin-right:5px;" onclick="location.href='?tela_id=62&empreendimento_id=<?=$r->id?>'" disabled="disabled" />
<?
}
?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>