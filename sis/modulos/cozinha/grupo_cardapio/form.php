<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo grupo cardápio

include("_functions.php");
include("_ctrl_grupo_cardapio.php");

print_r($_POST);
print_r($_GET);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Grupo Cardapio</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		<label style="width:311px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?= $grupo_cardapio->nome;?>" autocomplete='off' maxlength="44"/>
		</label>
        <div>ORDEM</div>
        
        <? 
		function marcaRefeicao($ficha){ if($ficha==1){echo "checked='checked'"; } } ?>
     <div style="width:50px; float:left" >
			<input name="cafe" type="checkbox" id="cafe" value="1" <? marcaRefeicao($grupo_cardapio->cafe); ?> /> Café
			<input name="cafe_ordem" type="text" id='cafe_ordem' value="<?= $grupo_cardapio->cafe_ordem;?>" size="2" />
		</div>
   		  <div style="width:70px; float:left">
			 <input name="almoco" type="checkbox" id="almoco" value="1" <? marcaRefeicao($grupo_cardapio->almoco); ?> />Almoço
			<input name="almoco_ordem" type="text" id='almoco_ordem' value="<?= $grupo_cardapio->almoco_ordem;?>" size="2" />
		</div>
   		  <div style="width:70px; float:left">
			 <input name="lanche" type="checkbox" id="lanche" value="1" <? marcaRefeicao($grupo_cardapio->lanche); ?> />Lanche
			<input name="lanche_ordem" type="text" id='lanche_ordem' value="<?= $grupo_cardapio->lanche_ordem;?>" size="2" />
		</div>
   		  <div style="width:70px; float:left">
			<input name="janta" type="checkbox" id="jantar" value="1" <? marcaRefeicao($grupo_cardapio->janta); ?> />Jantar
			<input name="janta_ordem" type="text" id='janta_ordem' value="<?= $grupo_cardapio->janta_ordem;?>" size="2" />
           
		</div>
   		  <div style="width:70px; float:left">
			<input name="ceia" type="checkbox" id="ceia" value="1" <? marcaRefeicao($grupo_cardapio->ceia); ?> />Ceia
			<input name="ceia_ordem" type="text" id='ceia_ordem' value="<?= $grupo_cardapio->ceia_ordem;?>" size="2" />
		</div>
         <div style="clear:both; font-size:10px; color:#666">
        Você define a ordem que eseles devem aparecer em cada refeição
        
        </div>
     <div style="clear:both;">  Descrição</div>
		<label style="width:311px;">
			<textarea name="descricao"><?=$grupo_cardapio->descricao?></textarea>
		</label>
     	</fieldset>
	<input name="id" type="hidden" value="<?=$grupo_cardapio->id?>"/>
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($grupo_cardapio->id>0){
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