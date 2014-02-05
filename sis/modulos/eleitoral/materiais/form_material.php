<?
//Includes
// configuração inicial do sistema
//include("file://///10.0.1.22/htdocs/clientes/nv/nv/_config.php");
// funções base do sistema
//include("file://///10.0.1.22/htdocs/clientes/nv/nv/_functions_base.php");
// funções do modulo empreendimento
//include("../_functions.php");
//include("../_ctrl.php");
print_r($_POST);
print_r($_GET);
?>
<link href="file://///10.0.1.22/htdocs/clientes/nv/fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
<div class='t3'></div>
<div class='t1'></div>
<div class="dragme" >
<a class='f_x' onclick="form_x(this)"></a>Materiais<span></span></div>
</div>
<form onsubmit="return validaForm(this)" class="form_float" method="post">
<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
  <fieldset id='campos_1' >
<legend>
<strong>Informacoes</strong>
</legend>
  <label style="width:311px;">
    Retirado por
      <input type="text" id='nome' name="nome" autocomplete='off' maxlength="44"/>
  </label>
  <div style="clear:both;"></div>
  <label style="width:180px;">
  Descricao 
  <input type="text" id='descricao' name="descricao" value="" autocomplete='off' maxlength="44"/> 
  </label>
  <label style="width:250px;">
    Quantidade	<input type="text" id='quantidade' name="quantidade" value="" autocomplete='off' maxlength="44"/>
  </label>
  <label style="width:250px;">
    Data da retirada <input type="text" id='dt_retirada' name="dt_retirada" value="" autocomplete='off' maxlength="44" mascara='__/__/____' calendario='1'/>
  </label>
   <div style="clear:both;"></div>
   <div style="clear:both;"></div>
  </fieldset>
<input name="id" type="hidden" value="<?=$unidade->id?>" />

<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<!---------------------------------------------------Dados cadastrais----------------------->
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<?
if($unidade->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit" value="Salvar" style="float:right" />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>

