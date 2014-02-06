<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
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
<div style="width:600px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Paineis</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_0' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Dados</strong></a>
            <a onclick="aba_form(this,1)">Planos</a>
		</legend>
		<label style="width:311px;">
			Nome
			<input type="text" id='nome' name="nome" value="Painel Recife" autocomplete='off' maxlength="30"/>
		</label>
        <label>Descrição
        	<input id="descricao" value="Painel atrás do golden goal" name="descricao" type="text" />
        </label>
        <div style="clear:both"></div>
        <label>Endereço
        	<input id="endereco" value="Rua Recife" name="descricao" type="text" />
        </label>
        <label>Nº
        	<input id="num" value="171" size="1" name="num" type="text" />
        </label>
        <label>Bairro
        	<input id="" value="171" size="10" name="num" type="text" />
        </label>
        <label>Cidade
        	<input id="num" value="171" size="10" name="num" type="text" />
        </label>
        <label>Estado
        	<input id="num" value="171" size="10" name="num" type="text" />
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
                	<td><input type="text" mascara="__:__"  sonumero="1"  value="08:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="08:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="08:00" size="3" maxlength="5" /></td>
                   <td><input type="text"  mascara="__:__"  sonumero="1"  value="08:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="08:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="08:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="08:00" size="3" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><strong>Fim</strong></td>
                	<td><input type="text" mascara="__:__"  sonumero="1"  value="17:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="17:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="17:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="17:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="17:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="17:00" size="3" maxlength="5" /></td>
                    <td><input type="text" mascara="__:__"  sonumero="1"  value="17:00" size="3" maxlength="5" /></td>
                </tr>
            </tbody>
        </table>
        <div style="clear:both; margin-bottom:5px;margin-top:5px; "><strong>Dados para lançamento em contas a receber</strong></div>
        <label>
        	<select>
            	<option>
                Conta
                </option>
            </select>
            </label>
            <label>
            <select>
            	<option>
                Plano de Conta
                </option>
            </select>
            </label>
            <label>
            <select>
            	<option>
                Centro de Custo
                </option>
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
                </tr>
            </thead>
            <tbody style="background-color:white;">
            	<tr>
                	<td><input type="text" value="Plano Básico" /></td>
                	<td><input type="text" sonumero="1"  value="200" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="30" size="3" /></td>
                    <td>R$<input type="text" sonumero="1"  value="1800,00" size="8" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><input type="text" value="Plano Básico" /></td>
                	<td><input type="text" sonumero="1"  value="200" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="30" size="3" /></td>
                    <td>R$<input type="text" sonumero="1"  value="1800,00" size="8" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><input type="text" value="Plano Básico" /></td>
                	<td><input type="text" sonumero="1"  value="200" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="30" size="3" /></td>
                    <td>R$<input type="text" sonumero="1"  value="1800,00" size="8" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><input type="text" value="Plano Básico" /></td>
                	<td><input type="text" sonumero="1"  value="200" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="30" size="3" /></td>
                    <td>R$<input type="text" sonumero="1"  value="1800,00" size="8" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><input type="text" value="Plano Básico" /></td>
                	<td><input type="text" sonumero="1"  value="200" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="30" size="3" /></td>
                    <td>R$<input type="text" sonumero="1"  value="1800,00" size="8" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><input type="text" value="Plano Básico" /></td>
                	<td><input type="text" sonumero="1"  value="200" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="30" size="3" /></td>
                    <td>R$<input type="text" sonumero="1"  value="1800,00" size="8" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><input type="text" value="Plano Básico" /></td>
                	<td><input type="text" sonumero="1"  value="200" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="30" size="3" /></td>
                    <td>R$<input type="text" sonumero="1"  value="1800,00" size="8" maxlength="5" /></td>
                </tr>
                <tr>
                	<td><input type="text" value="Plano Básico" /></td>
                	<td><input type="text" sonumero="1"  value="200" size="3" /></td>
                    <td><input type="text" sonumero="1"  value="30" size="3" /></td>
                    <td>R$<input type="text" sonumero="1"  value="1800,00" size="8" maxlength="5" /></td>
                </tr>
            </tbody>
        </table>
    </fieldset>
	<input name="id" type="hidden" value="<?=$conta->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($conta->id>0){
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