<?
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

print_r($r);
?><link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado'>
<div style="width:600px">
	<div>
		<div class='t3'></div>
		<div class='t1'></div>
		<div  class="dragme" >
			<a class='f_x' onclick="form_x(this)">
			</a>
			<span>Tipo de Disponibilidade</span></div>
	</div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
		<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
		<fieldset  id='campos_1' >
			<legend>
			<strong>Informações</strong>
			</legend>
			<label style="width:370;"> Nome
				<input type="text" id='nome' name="nome" value="<?=$r->nome?>" maxlength="255"/>
			</label>
			<label style="width:120;"> Valor
				<input type="text" id='valor' name="valor" value="<?=moedaUsaToBr($r->valor)?>" maxlength="255" decimal='2' style="text-align:right" />
			</label>
            <div style="clear:both;"></div>
            <label style="width:80px;"> Área privativa
				<input type="text" id='area_privativa' name="area_privativa" value="<?=$r->area_privativa?>"  style="text-align:right" />
			</label>
            <label style="width:80px;"> Fração ideal
				<input type="text" id='fracao_ideal' name="fracao_ideal" value="<?=$r->fracao_ideal?>" style="text-align:right" />
			</label>

			<label style="width:512px;"> Descrição
				<textarea id='descricao' name="descricao" value="" /><?=$r->obs?></textarea>
			</label>
			<input name="id" type="hidden" value="<?=$r->id?>" />
		</fieldset>
		<!--Fim dos fiels set-->
		
		<div style="width:100%; text-align:center" >
			<input name="action" type="submit" value="Excluir" style="float:left" />
			<input name="action" type="submit"  value="Salvar" style="float:right"  />
			<input name="action" type="button" onclick="location='?tela_id=58&empreendimento_id=<?=$r->empreendimento_id?>&disponibilidade_tipo_id=<?=$r->id?>'"  value="Negociação" style="float:right"  />
			<div style="clear:both"></div>
		</div>
	</form>
 </label>
</div>
<script>top.openForm()</script>