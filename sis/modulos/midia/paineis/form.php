<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include('_functions.php');
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:700px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Paineis</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="POST">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_0' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Dados</strong></a>
            <a onclick="aba_form(this,1)">Planos</a>
		</legend>
		<label style="width:311px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$painel->nome?>" autocomplete='off' maxlength="30"/>
		</label>
        <label>Descrição
        	<input id="descricao" value="<?=$painel->descricao?>" name="descricao" type="text" />
        </label>
        <div style="clear:both"></div>
        <label>Endereço
        	<input id="endereco" value="<?=$painel->endereco?>" name="endereco" type="text" />
        </label>
        <label>Nº
        	<input id="numero" value="<?=$painel->numero?>" size="1" name="numero" type="text" />
        </label>
        <label>Bairro
        	<input id="bairro" value="<?=$painel->bairro?>" size="10" name="bairro" type="text" />
        </label>
        <label>Cidade
        	<input id="cidade" value="<?=$painel->cidade?>" size="10" name="cidade" type="text" />
        </label>
        <label>Estado
        	<input id="estado" value="<?=$painel->estado?>" size="10" name="estado" type="text" />
        </label>
      <div style="clear:both"></div>
       <legend>
       Funcionamento
       </legend>
       	<table cellpadding="1" cellspacing="0" width="100%" style=" ">
        	<thead>
            	<tr>
                	<td>&nbsp;</td>
                	<td>Seg</td>
                    <td>Ter</td>
                    <td>Qua</td>
                    <td>Qui</td>
                    <td>Sex</td>
                    <td>Sab</td>
                    <td>Dom</td>
                </tr>
            </thead>
            <tbody style="background-color:white;">
            	<tr>
                	<td><strong>Inicio</strong></td>
                	<td><input type="text" mascara="__:__"	name="seg_ini"	sonumero="1"  value="<?=$painel->seg_ini?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"	name="ter_ini"  sonumero="1"  value="<?=$painel->ter_ini?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"	name="qua_ini"  sonumero="1"  value="<?=$painel->qua_ini?>" size="3" maxlength="5" /></td>
                   <td><input type="text"  mascara="__:__"  name="qui_ini"	sonumero="1"  value="<?=$painel->qui_ini?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  name="sex_ini"  sonumero="1"  value="<?=$painel->sex_ini?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  name="sab_ini"  sonumero="1"  value="<?=$painel->sab_ini?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  name="dom_ini"  sonumero="1"  value="<?=$painel->dom_ini?>" size="3" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><strong>Fim</strong></td>
                	<td><input type="text" mascara="__:__"	name="seg_fim"  sonumero="1"  value="<?=$painel->seg_fim?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"	name="ter_fim"  sonumero="1"  value="<?=$painel->ter_fim?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"	name="qua_fim"  sonumero="1"  value="<?=$painel->qua_fim?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"	name="qui_fim"  sonumero="1"  value="<?=$painel->qui_fim?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"	name="sex_fim"  sonumero="1"  value="<?=$painel->sex_fim?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"	name="sab_fim"  sonumero="1"  value="<?=$painel->sab_fim?>" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"	name="dom_fim"  sonumero="1"  value="<?=$painel->dom_fim?>" size="3" maxlength="5" /></td>
                </tr>
            </tbody>
        </table>
        <div style="clear:both; margin-bottom:5px;margin-top:5px; "><strong>Dados para lançamento em contas a receber</strong></div>
        <label>
        	<select name="financeiro_conta_id">
            <option value="0">Conta</option>
            <?
            $contas_q=mq("SELECT id, nome FROM financeiro_contas WHERE cliente_vekttor_id='$vkt_id' ORDER BY nome ASC");
			while($conta=mf($contas_q)){
				if($painel->financeiro_conta_id==$conta->id){$sel="selected='selected'";}else{$sel='';}
			?>
            	<option <?=$sel?> value="<?=$conta->id?>">
                <?=$conta->nome?>
                </option>
            <?
			}
			?>
            </select>
            </label>
            <label>
            <select name="financeiro_centro_de_custo_id">
            <option value="0">Centro de custo</option>
            <?
            $centro_q=mq("SELECT id, nome FROM financeiro_centro_custo WHERE cliente_id='$vkt_id' AND plano_ou_centro='centro' ORDER BY nome ASC");
			while($centro=mf($centro_q)){
				if($painel->financeiro_centro_de_custo_id==$centro->id){$sel="selected='selected'";}else{$sel='';}
			?>
            	<option <?=$sel?> value="<?=$centro->id?>">
                <?=$centro->nome?>
                </option>
            <?
			}
			?>
            </select>
            </label>
            <label>
            <select name="financeiro_plano_de_conta_id">
            <option value="0">Plano de conta</option>
             <?
            $planos_q=mq("SELECT id, nome FROM financeiro_centro_custo WHERE cliente_id='$vkt_id' AND plano_ou_centro='plano' ORDER BY nome ASC");
			while($plano=mf($planos_q)){
				if($painel->financeiro_plano_de_conta_id==$plano->id){$sel="selected='selected'";}else{$sel='';}
			?>
            	<option <?=$sel?> value="<?=$plano->id?>">
                <?=$plano->nome?>
                </option>
            <?
			}
			?>
            </select>
            </label>
            
	</fieldset>
    <fieldset  id='campos_1' style="display:none;">
		<legend>
			<a onclick="aba_form(this,0)">Dados</a>
            <a onclick="aba_form(this,1)"><strong>Planos</strong></a>
		</legend>
        <table cellpadding="1" cellspacing="0" width="100%" style=" ">
        	<thead>
            	<tr>
                	<td>Nome</td>
                	<td>Inserções</td>
                    <td>Dias</td>
                    <td>Valor</td>
                    <td>Descrição</td>
                </tr>
            </thead>
            <tbody style="background-color:white;">
            <? 
			$i=0;
			$planos_q=mq("SELECT * FROM paineis_planos WHERE painel_id='$painel->id' ORDER BY id ASC "); 
			while($plano=mf($planos_q)){
			if($i%2==0){$al=" al ";}else{$al="";}
			?>
            	<tr class="<?=$al?>">
                	<td><input type="text" name="planos[<?=$i?>][nome]" value="<?=$plano->nome?>" /></td>
                	<td><input type="text" sonumero="1"  value="<?=$plano->insercoes?>" name="planos[<?=$i?>][insercoes]" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="<?=$plano->dias?>" name="planos[<?=$i?>][dias]" size="3" /></td>
                    <td>
                    	R$
                        <input type="text" decimal="1" value="<?=moedaUsaToBr($plano->valor)?>" size="8" name="planos[<?=$i?>][valor]" maxlength="5" />
                        <input type="hidden" name="planos[<?=$i?>][id]" value="<?=$plano->id?>" />
                    </td>
                     <td>
                        <input type="text"  value="<?=($plano->descricao)?>"  name="planos[<?=$i?>][descricao]" maxlength="30" />
                    </td>
                </tr>
            <? 
			$i++;
			}
			for($y=$i;$y<=10;$y++){
				if($y%2==0){$al=" al ";}else{$al="";}
			?>
            	<tr class="<?=$al?>">
                	<td><input type="text" name="planos[<?=$y?>][nome]" value="" /></td>
                	<td><input type="text" sonumero="1"  value="" name="planos[<?=$y?>][insercoes]" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="" name="planos[<?=$y?>][dias]" size="3" /></td>
                    <td>
                    	R$
                        <input type="text" decimal="1" value="" size="8" name="planos[<?=$y?>][valor]" maxlength="5" />
                        <input type="hidden" name="planos[<?=$y?>][id]" value="" />
                    </td>
                    <td>
                        <input type="text"  value=""  name="planos[<?=$y?>][descricao]" maxlength="30" />
                    </td>
                </tr>
            <?
			}
			?>
            </tbody>
        </table>
    </fieldset>
	<input name="id" type="hidden" value="<?=$painel->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($painel->id>0){
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