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
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informações</strong></a>
			<a onclick="aba_form(this,1)">Produtos</a>
		</legend>
		<strong>Status:</strong> <? if($obj->status!="")echo $obj->status; else echo "Criando uma Nova Compra"; ?>
		<br />
		<label style="width:151px">
		Fornecedor
            <select name="cliente_fornecedor_id" disabled="disabled">
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
            <select name="empreendimento_id" disabled="disabled">
				<?
				$q=mysql_query("SELECT id,nome FROM empreendimento");
				while($r=mysql_fetch_object($q)){
				?>
            	<option <? if($r->id==$obj->empreendimento_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome?></option>
				<?
				}
				?>
            </select>
        </label>
		<br />
		<label style="width:144px; margin-right:23px;">
			D. Prevista:
			<input type="text" name="data_prevista" id="data_prevista" value="<?=dataUsaToBr($obj->data_prevista)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Data Simples' disabled="disabled" />
		</label>
		<label style="width:144px; margin-right:23px;">
			D. de Início:
			<input name="data_inicio" id='data_inicio' type="text" value="<?=dataUsaToBr($obj->data_inicio)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Data Simples' disabled="disabled" />
		</label><br />
		<label style="width:144px; margin-right:23px;">
			D. de Encerramento:
			<input name="data_fim" id='data_fim' type="text" value="<?=dataUsaToBr($obj->data_fim)?>" maxlength="23" calendario='1' sonumero='1' valida_data='1'  mascara='__/__/____' retorno='focus|Data Simples' disabled="disabled" />
		</label>
		<label style="width:144px; margin-right:23px;">
			Valor Total:
			<input name="valor_total" id='valor_total' type="text" value="<?=moedaUsaToBr($obj->valor_total)?>" maxlength="23" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" />
		</label><br />
		<label style="width:311px;">
			Condição de Pagamento:
			<textarea disabled="disabled" name="cond_pag"><?=$obj->cond_pag?></textarea>
		</label>
	</fieldset>
	
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_2' style="display:none" >
		<legend>
			<a onclick="aba_form(this,0)">Informações</a>
			<a onclick="aba_form(this,1)"><strong>Produtos</strong></a>
		</legend>
		
		<div class="titulo_options">
			<label style="width:144px; margin-right:23px;">
				Produto
			</label>
			<label style="width:144px">
				Qtd. Requisitada
			</label>
			<label style="width:144px">
				Qtd. Autorizada
			</label>
			<label style="width:144px">
				Qtd. Efetivar
			</label>
			<label style="width:144px">
				Qtd. Finalizar
			</label>
			
        	<span style="clear:both; display:block"></span>
		</div>
		
		
    	<div>
			<?
			$x=mysql_query("SELECT * FROM compra_has_produto as c, produto as p
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
				<label style="width:144px;">
					<input name="prod_comp_qtd[]" type="text" value="<?=moedaUsaToBr($y->requisitar_produto_qtd)?>" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" >
				</label>
				<label style="width:144px;">
					<input name="prod_comp_qtd[]" type="text" value="<?=moedaUsaToBr($y->autorizar_produto_qtd)?>" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" >
				</label>
				<label style="width:144px;">
					<input name="prod_comp_qtd[]" type="text" value="<?=moedaUsaToBr($y->efetivar_produto_qtd)?>" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" >
				</label>
				<label style="width:144px;">
					<input name="prod_comp_qtd[]" type="text" value="<?=moedaUsaToBr($y->finalizar_produto_qtd)?>" decimal="2" sonumero="1" style="text-align:right" disabled="disabled" >
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


</form>
</div>
</div>
</div>
<script>top.openForm()</script>