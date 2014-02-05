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
    
    <span>Compra</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' style="display:none" >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informações</strong></a>
			<a onclick="aba_form(this,1)">Produtos</a>
		</legend>
		<strong>Status:</strong> <? if($obj->status!="")echo $obj->status; else echo "Criando uma Nova Compra"; ?>
		<br />
		<label style="width:151px">
		Fornecedor
            <select name="cliente_fornecedor_id">
				<?
				$q=mysql_query("SELECT id,nome_fantasia FROM cliente_fornecedor WHERE tipo='Fornecedor'");
				while($r=mysql_fetch_object($q)){
				?>
            	<option <? if($r->id==$obj->cliente_fornecedor_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome_fantasia?></option>
				<?
				}
				?>
            </select>
        </label>
		<label style="width:151px">
		Empreendimento
            <select name="" disabled="disabled">
				<?
				$q=mysql_query("SELECT id,nome FROM empreendimento WHERE tipo='Obra'");
				while($r=mysql_fetch_object($q)){
				?>
            	<option <? if($r->id==$_SESSION['usuario']->obra_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome?></option>
				<?
				}
				?>
            </select>
			<input type="hidden" name="empreendimento_id" value="<?=$_SESSION['usuario']->obra_id?>" />
        </label>
		<br />
		<label style="width:144px; margin-right:23px;">
			D. Prevista:
			<input type="text" name="data_prevista" id="data_prevista" value="<?=dataUsaToBr($obj->data_prevista)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Favor preencher o campo corretamente' aceita_nulo='1' />
		</label>
		<label style="width:144px; margin-right:23px;">
			D. de Início:
			<input name="data_inicio" id='data_inicio' type="text" value="<?=dataUsaToBr($obj->data_inicio)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Favor preencher o campo corretamente' aceita_nulo='1' />
		</label><br />
		
		<label style="width:144px; margin-right:23px;">
			Valor Total:
			<input name="valor_total" id='valor_total' type="text" value="<?=moedaUsaToBr($obj->valor_total)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right" aceita_nulo='1' retorno='focus|Favor preencher o campo corretamente' />
		</label><br />
		<label style="width:311px;">
			Condição de Pagamento:
			<textarea name="cond_pag"><?=$obj->cond_pag?></textarea>
		</label>
	</fieldset>
	
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset id='campos_2' >
		<legend>
			<a onclick="aba_form(this,0)">Informações</a>
			<a onclick="aba_form(this,1)"><strong>Produtos</strong></a>
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
				
    	<div style="max-height:250px; width:370px; overflow:auto;">
			<?
			$x=mysql_query("SELECT *,c.id as id FROM compra_has_produto as c, produto as p
							WHERE p.id=c.produto_id 
							AND c.compra_id='".$obj->id."'");
							
			while($y=mysql_fetch_object($x)){
			?>
			<div class="linha_add">
				
				
				<label style="width:144px; margin-right:23px;">
					<select name="prod_comp_id[]" disabled="disabled">
					<?
					$f=mysql_query("SELECT id,nome,unidade FROM produto");
					while($s=mysql_fetch_object($f)){
						?>
						<option <? if($y->produto_id==$s->id)echo 'selected="selected"'; ?>  value="<?=$s->id?>"><?=$s->nome." (un:".$s->unidade.")"?></option>
						<?
					}
					?>
					</select>
				</label>
				<input name="produto_compra_id[]" value="<?=$y->id?>" type="hidden" />
				<label style="width:144px;">
					<?
					if($y->autorizar_produto_qtd!=NULL)$produto_qtd=$y->autorizar_produto_qtd;
					else $produto_qtd=$y->requisitar_produto_qtd;
					?>
					<input name="prod_comp_qtd[]" type="text" value="<?=moedaUsaToBr($produto_qtd)?>" decimal="2" sonumero="1" style="text-align:right" >
				</label>
				
				<span style="clear:both; display:block"></span>
	
		    </div>
			<?
			}
			?>
			
			<a name="ancora"></a>
		</div>
	</fieldset>
	
	<input name="id" type="hidden" value="<?=$obj->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($obj->id>0){
?>
<input name="action" type="submit" value="Cancelar" style="float:left" onclick="confirmCancelar(this)" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />

<input type="hidden" name="action_autorizar" id="action_autorizar" value=""  />

<input name="action" type="submit"  value="Autorizar" style="float:right;margin-right:10px" onclick="confirmAutorizar(this)"  />

<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>