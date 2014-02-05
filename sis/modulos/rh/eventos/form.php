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
<div style="width:550px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Eventos</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete="off" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        
        <label style="width:450px;">
        	Nome
			<input type="text" name="nome" id="nome" value="<?=$evento->nome?>" valida_minlength="3" retorno="focus|Digite no mínimo 3 caracteres no campo Nome" />
        </label>
		
        <label style="width:450px;">
        	Descricao
			<textarea name="descricao" id="descricao" style="height:150px;"> <?=$evento->descricao?></textarea>
        </label>
        
        <label style="width:90px;">
        	Valor
			<input type="text" name="valor" sonumero="1" value="<?=moedaUsaToBr($evento->valor)?>" decimal="2"/>
        </label>
        
        <label style="width:80px;">
        	Forma Valor
			<select name="forma_valor" id="forma_valor">
            	<option value="0" <?php if($evento->forma_valor=="0"){ echo "selected='selected'";}?>>R$</option>
                <option value="1" <?php if($evento->forma_valor=="1"){ echo "selected='selected'";}?>>%</option>
            </select>
        </label>
        
         <label style="width:80px;">
        	Tipo
			<select name="vencimento_ou_desconto" id="vencimento_ou_desconto">
            	<option value="vencimento" <?php if($evento->vencimento_ou_desconto=="vencimento"){ echo "selected='selected'";}?>>Vencimento</option>
                <option value="desconto" <?php if($evento->vencimento_ou_desconto=="desconto"){ echo "selected='selected'";}?>>Desconto</option>
            </select>
        </label>
        
         
        <input type="checkbox" style="margin-top:20px;" <?php if($evento->tributado=='sim'){ echo "checked=checked";}?> name="tributado"/>Tributado
         
         <div style="clear:both"></div>
         
         <label rel="tip" title="O Desconto será efetuado para apenas um funcionário ou para todos aquele que se encaixem no critério do evento">
         	Regra Desconto
         	<select name="regra_desconto" id="regra_desconto">
         		<option name="nao" <?php if($evento->regra_desconto=="nao"){echo "selected='selected'";}?>>Não</option>
            	<option name="individual" <?php if($evento->regra_desconto=="individual"){echo "selected='selected'";}?>>Individual</option>
            	<option name="grupo" <?php if($evento->regra_desconto=="grupo"){echo "selected='selected'";}?>>Grupo</option>
         	</select>
         </label>
         
         <?php
		 	$displaydivcargo       ="none";
			$displaydivfuncionario ="none";
			$displaydivempresa     ="none";
		 ?>       
                
		 <label style="width:80px;" id="eventos_para" name="eventos_para">
        	Eventos para: 
			<select name="para" id="para">
            	<option value="todos">Todos</option>
                <option value="cargos" <?php if($evento->cargo_id>0){ echo "selected='selected'";$displaydivcargo="block";}?>>Cargos</option>
                <option value="funcionarios"<?php if($evento->funcionario_id>0){ echo "selected='selected'";$displaydivfuncionario="block";}?>>Funcionários</option>
                <option value="empresa"<?php if($evento->empresa_id>0){ echo "selected='selected'";$displaydivempresa="block";$displaydivcargo="none";$displaydivfuncionario="none";}?>>Empresa</option>
                <option value="cargo_empresa"<?php if($evento->empresa_id>0&&$evento->cargo_id>0){ echo "selected='selected'";$displaydivcargoempresa="block";$displaydivcargo="block";$displaydivfuncionario="none";}?>>Cargos/Empresa</option>               
            </select>
        </label>
        <div style="clear:both"></div>
        <div id="divbuscafuncionario" style="display:<?=$displaydivfuncionario?>">
        	<?php
				$funcionario = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$evento->funcionario_id'"));
			?>
            <label style="width:300px;">
            	Funcionário
                <input type="text" name="buscafuncionario" id="buscafuncionario" value="<?=$funcionario->nome?>" busca='modulos/rh/eventos/busca.php?acao=funcionario,@r1 @r2 @r3,@r0-value>funcionario_id|@r1-value>buscafuncionario,0'/> 
            	<input type="hidden" name="funcionario_id" id="funcionario_id" value="<?=$funcionario->id?>"/>
            </label>                      
        </div>
        <div id="divbuscaempresa" style="display:<?=$displaydivempresa?>">
        	<?php
				$empresa = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$evento->empresa_id'"));
			?>
            <label style="width:300px;">
            	Empresa
            <input type="text" name="buscaempresa" id="buscaempresa" busca='modulos/rh/eventos/busca.php?acao=empresa,@r1 @r2,@r0-value>empresa_id|@r1-value>buscaempresa,0' value="<?=$empresa->razao_social?>"/>
            <input type="hidden" name="empresa_id" id="empresa_id" value="<?=$empresa->id?>"/>
        	</label>
        </div>        
        <div id="divbuscacargo" style="display:<?=$displaydivcargo?>">
        	<?php
				$cargo = mysql_fetch_object(mysql_query("SELECT * FROM cargo_salario WHERE id='$evento->cargo_id'"));
			?>
            <label style="width:300px;">
            	Cargo
            <!--<input type="text" name="buscacargo" id="buscacargo" busca="modulos/rh/eventos/busca.php?acao=cargo&empresa_id=document.getElementById(empresa_id).value,@r1 @r2,@r0-value>cargo_id|@r1-value>buscacargo,0" value="<?=$cargo->cargo?>"/>
            -->
             <input type="text" name="buscacargo" id="buscacargo" 
            onkeyup="return vkt_ac(this,event,'0','modulos/rh/eventos/busca.php?acao=cargo&empresa_id='+document.getElementById('empresa_id').value,'@r1','funcao_bsc2(this,\'@r1-value>buscacargo|@r0-value>cargo_id\',\'cargo\')')" 
            value="<?=$cargo->cargo?>"/>
            <input type="hidden" name="cargo_id" id="cargo_id" value="<?=$cargo->id?>"/>
        	</label>
        </div>
                
    </fieldset>
	<input name="id" type="hidden" value="<?=$evento->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($evento->id > 0){
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