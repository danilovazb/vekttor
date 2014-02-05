<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
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
    
    <span>Produto</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informações</strong></a>
			<a onclick="aba_form(this,1)">Componentes</a>
		</legend>
		<label style="width:311px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$obj->nome?>" autocomplete='off' maxlength="44" disabled="disabled"/>
		</label><br />
		<label style="width:151px">
		Grupo
            <select name="produto_grupo_id" disabled="disabled">
				<?
				$q=mysql_query("SELECT id,nome FROM produto_grupo");
				while($r=mysql_fetch_object($q)){
				?>
            	<option <? if($r->id==$obj->produto_grupo_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome?></option>
				<?
				}
				?>
            </select>
        </label>
		<label style="width:151px">
		Unidade
            <select name="unidade" disabled="disabled">
				
            	<option <? if($obj->unidade=="Fardo")echo 'selected="selected"'; ?>  value="Fardo">Fardo</option>
				<option <? if($obj->unidade=="Kg")echo 'selected="selected"'; ?>  value="Kg">Kg</option>
				<option <? if($obj->unidade=="g")echo 'selected="selected"'; ?>  value="g">g</option>
				<option <? if($obj->unidade=="Litro")echo 'selected="selected"'; ?>  value="Litro">Litro</option>
				<option <? if($obj->unidade=="Ml")echo 'selected="selected"'; ?>  value="Ml">Ml</option>
				<option <? if($obj->unidade=="Caixa")echo 'selected="selected"'; ?>  value="Caixa">Caixa</option>
				<option <? if($obj->unidade=="Unidade")echo 'selected="selected"'; ?>  value="Unidade">Unidade</option>
				<option <? if($obj->unidade=="Saco")echo 'selected="selected"'; ?>  value="Saco">Saco</option>
				<option <? if($obj->unidade=="Pacote")echo 'selected="selected"'; ?>  value="Pacote">Pacote</option>
				<option <? if($obj->unidade=="Lata")echo 'selected="selected"'; ?>  value="Lata">Lata</option>
				
            </select>
        </label>
		<br />
		<label style="width:144px; margin-right:23px;">
			Estoque Min.:
			<input type="text" name="estoque_min" id="estoque_min" value="<?=moedaUsaToBr($obj->estoque_min)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" />
		</label>
		<label style="width:144px; margin-right:23px;">
			Estoque Max.:
			<input name="estoque_max" id='estoque_max' type="text" value="<?=moedaUsaToBr($obj->estoque_max)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" />
		</label><br />
		<label style="width:144px; margin-right:23px;">
			Custo:
			<input name="custo" id='custo' type="text" value="<?=moedaUsaToBr($obj->custo)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" />
		</label>
		<label style="width:144px; margin-right:23px;">
			Preço Compra:
			<input name="preco_compra" id='preco_compra' type="text" value="<?=moedaUsaToBr($obj->preco_compra)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" />
		</label><br />
		<label style="width:144px; margin-right:23px;">
			Preço Venda:
			<input name="preco_venda" id='preco_venda' type="text" value="<?=moedaUsaToBr($obj->preco_venda)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" />
		</label><br />
		<label style="width:311px;">
			Descrição:
			<textarea name="cond_pag" disabled="disabled"><?=$obj->descricao?></textarea>
		</label>
	</fieldset>
	
	<fieldset id='campos_2' style="display:none" >
		<legend>
			<a onclick="aba_form(this,0)">Informações</a>
			<a onclick="aba_form(this,1)"><strong>Componentes</strong></a>
		</legend>
		
		<div class="titulo_options">
			<label style="width:144px; margin-right:23px;">
				Produto
			</label>
			<label style="width:144px">
			   Quantidade
			</label>
        	<span style="clear:both; display:block"></span>
		</div>
		
		
    	<div>
			<?
			$x=mysql_query("SELECT c.*,h.* FROM produto_has_produto as h,produto as c, produto as p
							WHERE p.id=h.produto_id 
							AND c.id=h.componente_id
							AND p.id='".$obj->id."'");
							
			while($y=mysql_fetch_object($x)){
			?>
			<div class="linha_add">
				<img src="../fontes/img/menos.png" width="18" height="18" style="float:right; margin-top:2px" onclick="del_element(this)" /> 
				
				<label style="width:144px; margin-right:23px;">
					<select name="prod_comp_id[]" disabled="disabled">
					<?
					$f=mysql_query("SELECT id,nome,unidade FROM produto");
					while($s=mysql_fetch_object($f)){
						?>
						<option <? if($y->componente_id==$s->id)echo 'selected="selected"'; ?>  value="<?=$s->id?>"><?=$s->nome." (un:".$s->unidade.")"?></option>
						<?
					}
					?>
					</select>
				</label>
				<label style="width:144px;">
					<input name="prod_comp_qtd[]" type="text" value="<?=moedaUsaToBr($y->componente_qtd)?>" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" >
				</label>
				
				<span style="clear:both; display:block"></span>
	
		    </div>
			<?
			}
			?>
			
		</div>
			
	</fieldset>
	
	<input name="id" type="hidden" value="<?=$obj->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>