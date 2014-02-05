<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include('_ctrl.php');

include('_functions.php');
 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style type="text/css">

</style>

<div>
<div id='aSerCarregado' >
<div style="width:880px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme">
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Ficha Técnica - <?=$ficha->nome?></span></div>
   
    </div>
	<form method="post" enctype="multipart/form-data" class="form_float"  onsubmit="return validaForm(this)" autocomplete="off" >
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informações</strong></a>
		<a onclick="aba_form(this,1)">Matéria Prima</a>
		</legend>
        <div style="float:left; width:410px">
		<label style="width:151px">
		Grupo 
            <select name="cardapio_id">
            <? $grupo_cardapio_q=mysql_query("SELECT * FROM cozinha_cardapios_grupos WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
			while($grupo=mysql_fetch_object($grupo_cardapio_q)){
				if($ficha->grupo_cardapio_id==$grupo->id){$sel='selected="selected"';}else{$sel='';}
			?>
            	<option <?=$sel?> value="<?=$grupo->id?>"><?=$grupo->nome?></option>
            <? } ?>
            </select>
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:200px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$ficha->nome?>" busca="modulos/cozinha/ficha_tecnica/busca_ficha_tecnica.php,@r0,@r0-value>nome|@r0-value>nome_cliente,0"/>
		</label>	
        
        
        <label style="width:160px;">
			Nome Para Cliente
			<input type="text" id='nome_cliente' name="nome_cliente" value="<?php if(empty($ficha->nome_cliente)){echo $ficha->nome;}else{echo $ficha->nome_cliente;}?>" busca="modulos/cozinha/ficha_tecnica/busca_ficha_tecnica.php,@r0,@r0-value>nome,0"/>
		</label>
        <div style="clear:both;"></div>
        
        <div   style="float: left; width: 299px; margin-top: 17px;" >
			<? function marcaRefeicao($refeicao,$ficha){ if(strstr($ficha->refeicao,$refeicao)){echo "checked='checked'"; } } ?>
            <input type="checkbox" name="refeicao[]" value="cafe" <? marcaRefeicao('cafe',$ficha); ?> /> Café  
            <input type="checkbox" name="refeicao[]" value="almoco" <? marcaRefeicao('almoco',$ficha); ?> />Almoço  
            <input type="checkbox" name="refeicao[]" value="lanche" <? marcaRefeicao('lanche',$ficha); ?> />Lanche 
            <input type="checkbox" name="refeicao[]" value="janta" <? marcaRefeicao('janta',$ficha); ?> />Janta 
            <input type="checkbox" name="refeicao[]" value="seia" <? marcaRefeicao('seia',$ficha); ?> />
            Ceia
        </div>
        
       <div style="clear:both"></div>
       <label style="width:110px;">
			Peso da Receita Kg
			  <input type="text" id='peso' name="peso" value="<?=qtdUsaToBr($ficha->peso)?>" />
		</label>
        
        <div style="clear:both; padding-top:10px;">  <b>Percapta Individual </b></div>
        
          <label style="width:60px">Leve (Kg)
            <input type="text" value="<?=number_format($ficha->percapta_leve,3,',','.')?>"  id="percapta_leve" name="percapta_leve"  
             onkeyup="calculaPerCapta('peso',this,'calculo_percapta_leve')"
             size="4"  />
            <span id="calculo_percapta_leve"><?=@(number_format($ficha->peso/$ficha->percapta_leve,2,',','.'))?></span>
          </label>
          
          <label style="width:60px">
            Médio (Kg)
             <input type="text" value="<?=number_format($ficha->percapta_medio,3,',','.')?>"  id="percapta_medio" name="percapta_medio"
              onkeyup="calculaPerCapta('peso',this,'calculo_percapta_medio')"
              size="4"  /><span id="calculo_percapta_medio"><?=@(number_format($ficha->peso/$ficha->percapta_medio,2,',','.'))?></span>
          </label>
               
          <label style="width:70px">
              Pesado (Kg)
            <input type="text" value="<?=number_format($ficha->percapta_pesado,3,',','.')?>" id="percapta_pesado" name="percapta_pesado"
              onkeyup="calculaPerCapta('peso',this,'calculo_percapta_pesado')"
              size="4"  /><span id="calculo_percapta_pesado"><?=@(number_format($ficha->peso/$ficha->percapta_pesado,2,',','.'))?></span>
          </label>
              
          <label style="width:90px">
              <span title='Muito Pesado'>M. Pesado (<span style="width:60px">K</span>g)</span>
             <input type="text" value="<?=number_format($ficha->percapta_extra,3,',','.')?>" id="percapta_extra" name="percapta_extra"
               onkeyup="calculaPerCapta('peso',this,'calculo_percapta_extra')"
               size="4"  /><span id="calculo_percapta_extra"><?=@(number_format($ficha->peso/$ficha->percapta_extra,2,',','.'))?></span>
          </label>
             
        
          <!-- PESSOAS -->
          
          <div style="clear:both; padding-top:10px;">  <b> Pessoas </b> </div>
          
          <label style="width:60px"> Leve (Kg)
            <input type="text" value="<?=moedaUsaToBr($ficha->peso/$ficha->percapta_leve)?>"  id="calculo_percapta_leve_pessoas" name="percapta_leve"  
             onkeyup="calculaPerCaptaPessoas('peso',this,'percapta_leve')"
             size="4"  />
            <span id="span_percapta_leve"><?=number_format($ficha->percapta_leve,3,',','.')?></span>
          </label>
          
          <label style="width:60px"> Médio (Kg)
             <input type="text" value="<?=@(number_format($ficha->peso/$ficha->percapta_medio,2,',','.'))?>"  id="calculo_percapta_medio_pessoas" name="percapta_medio"
              onkeyup="calculaPerCaptaPessoas('peso',this,'percapta_medio')"
              size="4"  /><span id="span_percapta_medio"><?=number_format($ficha->percapta_medio,3,',','.')?></span>
          </label>
               
          <label style="width:70px">
              Pesado (Kg)
            <input type="text" value="<?=@(number_format($ficha->peso/$ficha->percapta_pesado,2,',','.'))?>" id="calculo_percapta_pesado_pessoas" name="percapta_pesado"
              onkeyup="calculaPerCaptaPessoas('peso',this,'percapta_pesado')"
              size="4"  /><span id="span_percapta_pesado"><?=number_format($ficha->percapta_pesado,3,',','.')?></span>
          </label>
              
          <label style="width:90px">
              <span title='Muito Pesado'>M. Pesado (<span style="width:60px">K</span>g)</span>
             <input type="text" value="<?=@(number_format($ficha->peso/$ficha->percapta_extra,2,',','.'))?>" id="calculo_percapta_extra_pessoas" name="percapta_extra"
               onkeyup="calculaPerCaptaPessoas('peso',this,'percapta_extra')"
               size="4"  /><span id="span_percapta_extra"><?=number_format($ficha->percapta_extra,3,',','.')?></span>
          </label>
          
          <div style="clear:both"></div>
          <input type="checkbox" name="exibir_cliente" id="exibir_cliente" <?php if(($ficha->exibir_cliente=='1')||(!$ficha->id>0)){ echo "checked='checked'";}?>/> Exibir Para Cliente 
            
        </div>
        
		<div style="float:left; margin-left:20px;">
        <? if($ficha->id>0){ ?>
            <img src="modulos/cozinha/ficha_tecnica/imagens_produtos/<?=$ficha->id?>.jpg" width="300" style="float:left; " />
        <? } ?> 
            <label style=" float:left; clear:both;">
      	Foto    <input type="file" name="foto" id="foto" value="<?=$ficha->foto_src?>" />
        </label> 
		</div>
	</fieldset>
    <fieldset  id='campos_2' style="display:none;" >
		<legend>
			<a onclick="aba_form(this,0)">Informações</a>
		<a onclick="aba_form(this,1)"><strong>Matéria Prima</strong></a>
		</legend>
		
        
        <div style="clear:both;"><b>Adição de Matéria Prima</b></div>
        <table style=" float:left; width:800px;  " cellpadding="0" cellspacing="0">
        
        <thead>
        <tr>
        	<td width="180">Item</td>
            <td width="80">Quantidade</td>
            <td width="240">OBS</td>
            <td>Custo/Kg</td>
            <td>Total</td>
            <td></td>

        </tr>
        </thead>
        
        <script></script>
        <tbody style="background-color:white;" id="corpo_tabela_contrato">
        <? 
		$grupo_atual="";
		
		$produtos_ficha_q=mysql_query("SELECT p.id, p.nome, p.custo as custo, p.conversao as conversao, p.conversao2 as conversao2, cp.qtd as qtd, cp.obs as obs, cp.grupo as grupo FROM cozinha_ficha_has_produto as cp, produto as p WHERE cp.ficha_id='{$ficha->id}' AND p.id=cp.produto_id ORDER BY cp.grupo ASC "); 
		$qtd=mysql_num_rows($produtos_ficha_q);
		$p=1;
		$num=0;
		while($produto=mysql_fetch_object($produtos_ficha_q)){
			if($grupo_atual!=$produto->grupo){
			?>
            <tr class="produto_item <?=$classe?>">
        	<td style=" font-weight:bold;"	>
            <? 
			if($p==1){$validacao="valida_minlength='3' retorno='focus|Busque o nome do produto'";$validacao=''; $cont='';}else{ $cont=$p+1; }  ?>
            	<input type="hidden" class="numero_da_linha" value="<?=$p?>" />
                <input type="hidden" class="produto_id" id="produto_id<?=$p?>" name="produto_id[]" value="" />
                <input name="produto[]" class="produto_nome" id="produto<?=$p?>" value="" 
                busca='modulos/cozinha/ficha_tecnica/busca_materia_prima.php,@r0,@r1-value>produto_id<?=$p?>|@r2-innerHTML>produto_valor<?=$p?>,0' 
                <?=$validacao?>
                 autocomplete="off" >
            </td>
            <td>
            	<input type="text" onkeyup="calculaTotal(this);if(event.keyCode==13){produto_add_fica(this)}" class="produto_qtd" name="produto_qtd[]" size="6" /> Kg           	
            </td>
            <td> <input type="text" name="obs[]" style=" font-size:9px;" size="35" onKeyUp="if(event.keyCode==13){produto_add_fica(this)}"  /><input type="hidden" class="grupo_item" value="<?=$grupo_atual?>" name="grupo[]" /></td>
            <td>
            	R$<span id="produto_valor<?=$p?>" class="produto_valor">
                </span>
            </td>
            <td align="right">
            	<span class="produto_total_valor">R$0,00</span>
            </td>
            <td>
            	<img src="../fontes/img/mais.png" onclick="addProduto(this)" height="15" style="" />
            </td>
        </tr>	
            <tr class='grupo' ><td class="nome_grupo" colspan='5'><?=$produto->grupo?></td><td colspan='1'><img class='mais_e_menos' src='../fontes/img/menos.png' onclick='adicionaGrupo(this)'  height='15' /></td></tr>
                <?
				$p*=100;
				$classe=($classe=='al')?'':'al';
			}
		?>
        <tr class="produto_item <?=$classe?>"  >
        	<td style=" font-weight:bold;">
            	<input type="hidden" class="numero_da_linha" value="<?=$p?>" />
                <input type="hidden" class="produto_id" id="produto_id<?=$p?>" name="produto_id[]"  value="<?=$produto->id?>" />
                <input name="produto[]" class="produto_nome" id="produto<?=$p?>" value="<?=$produto->nome?>" 
                busca='modulos/cozinha/ficha_tecnica/busca_materia_prima.php,@r0,@r1-value>produto_id<?=$p?>|@r2-innerHTML>produto_valor<?=$p?>,0' 
                valida_minlength='3'
                retorno='focus|Busque o nome do produto' autocomplete="off" >
            </td>
            <td>
            	<input type="text" onkeyup="calculaTotal(this);if(event.keyCode==13){produto_add_fica(this)}" class="produto_qtd" value="<?=qtdUsaToBr($produto->qtd)?>" name="produto_qtd[]"  size="6" /> Kg
                <? $qtd_total += $produto->qtd; ?>      	
            </td>
            <td><input type="text" name="obs[]" value="<?=$produto->obs?>" size="35" style=" font-size:9px;" onKeyUp="if(event.keyCode==13){produto_add_fica(this)}" /><input type="hidden" value="<?=$produto->grupo?>" class="grupo_item" name="grupo[]"  /></td>
            <td>
            	R$<span id="produto_valor<?=$p?>" class="produto_valor">
                <?=number_format($valor_unit=($produto->custo/$produto->conversao/$produto->conversao2),5,',','.')?>
                </span>
            </td>
            <td align="right">
            	<span class="produto_total_valor">R$<?=number_format($vlr=($valor_unit*$produto->qtd),2,',','.')?></span>
            </td>
            <td>
            	<img src="../fontes/img/menos.png" onclick="addProduto(this)" height="15" class="mais_e_menos" />
            </td>
        </tr>
        <? 
		$p++; 
		$classe=($classe=='al')?'':'al';
		$num+=$vlr; $grupo_atual=$produto->grupo; } ?>
        <tr class="produto_item <?=$classe?>">
        	<td style=" font-weight:bold;"	>
            <? 
			if($p==1){$validacao="valida_minlength='3' retorno='focus|Busque o nome do produto'";$validacao=''; $cont='';}else{ $cont=$p+1; }  ?>
            	<input type="hidden" class="numero_da_linha" value="<?=$p?>" />
                <input type="hidden" class="produto_id" id="produto_id<?=$p?>" name="produto_id[]" value="" />
                <input name="produto[]" class="produto_nome" id="produto<?=$p?>" value="" 
                busca='modulos/cozinha/ficha_tecnica/busca_materia_prima.php,@r0,@r1-value>produto_id<?=$p?>|@r2-innerHTML>produto_valor<?=$p?>,0' 
                <?=$validacao?>
                 autocomplete="off">
            </td>
            <td>
            	<input type="text" onkeyup="calculaTotal(this)" class="produto_qtd" name="produto_qtd[]" size="6" /> Kg           	
            </td>
            <td> <input type="text" name="obs[]" style=" font-size:9px;" size="35"  onKeyUp="if(event.keyCode==13){produto_add_fica(this)}" /><input type="hidden" class="grupo_item" value="<?=$grupo_atual?>" name="grupo[]" /></td>
            <td>
            	R$<span id="produto_valor<?=$p?>" class="produto_valor">
                </span>
            </td>
            <td align="right">
            	<span class="produto_total_valor">R$0,00</span>
            </td>
            <td>
            	<img src="../fontes/img/mais.png" onclick="addProduto(this)" height="15" style="" />
            </td>
        </tr>
        <tr class="grupo">
        	<td colspan="5" class="nome_grupo">Adicionar Grupo</td>
            <td colspan="1" ><img class="mais_e_menos" src="../fontes/img/mais.png" onclick="adicionaGrupo(this)"  height="15" /></td>
        </tr>
        </tbody>
        <tfoot>
        	<tr>
        	  <td>Total</td><td align="right" id="total_qtd"><?=qtdUsaToBr($qtd_total)?></td>
              <td></td>
        	<td></td>
        	<td align="right" id="total">R$<?=number_format($num,2,',','.')?></td>
        	<td></td></tr>
        </tfoot>
        
        </table>
        
        <label style="width:580px; float:left; margin-top:20px;">
        Modo de Preparo
        	<textarea name="modo_preparo"><?=$ficha->modo_preparo?></textarea>
        </label>
        
        
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$ficha->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($ficha->id>0){
	if($ficha->status=='ativo'){
?>
<input name="action" type="submit" value="Inativar" style="float:left" />
<?
	}
    if($ficha->status=='inativo'){
?>
<input name="action" type="submit" value="Ativar" style="float:left" />
<?
	}
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