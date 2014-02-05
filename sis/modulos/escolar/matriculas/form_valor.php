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
<div style="width:410px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Matr&iacute;cula</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong> Alterar valor da matr&iacute;cula</strong>
		</legend>
        <div style="float:right"><sub> Pesquisar por matr&iacute;cula ou aluno</sub></div>
        <label style="width:90px;">
        	Matr&iacute;cula<br/>
            <input type="text" name="matricula" id="matricula" busca='modulos/escolar/matriculas/buscaAluno.php?acao=aluno,@r0,@r1-value>nome|@r0-value>matricula|@r2-value>valor_matricula'>
        </label>
		<label style="width:311px;">Aluno
		  <input type="text" id='nome' name="nome" busca='modulos/escolar/matriculas/buscaAluno.php?acao=aluno,@r0-@r1,@r1-value>nome|@r0-value>matricula|@r2-value>valor_matricula' value="<?=$registro->nome?>" autocomplete='off' maxlength="44"  />
		</label>
        <label style="width:90px;">
        	Valor<br/>
            <input type="text" name="valor_matricula" id="valor_matricula" decimal='2' sonumero='1'>
        </label>
	</fieldset>
	<input name="id" type="hidden" value="<?=$registro->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Atualizar Valor" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>