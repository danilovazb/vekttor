<?
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
$situacao = array( 1 => "Pendente", 2 => "Efetivado");
$readonly = !empty($VendaEdit->id) ? 'disabled="disabled"' : NULL;
$arrayMes = array( "01"=>"0", "02"=>"1", "03"=>"2", "04"=>"3", "05"=>"4", "06"=>"5", "07"=>"6", "08"=>"7", "09"=>"8", "10"=>"9", "11"=>"10", "12"=>"11"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    <span>Venda Funcionário</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<input type="hidden" name="funcionario_id" id="funcionario_id" value="<?=$funcionarioID?>">
    <input type="hidden" name="empresa_id" id="empresa_id" value="<?=$empresaID?>">
    <input type="hidden" name="venda_id" id="venda_id" value="<?=$VendaEdit->id?>">
	<fieldset  id='campos_1'>
		<legend><strong>Informa&ccedil;&otilde;es</strong></legend>
        <? if($VendaEdit->status == 2){ ?>
        <p style="float:right; padding-top:2px;" class="badge badge-important"> Cancelada </p>
        <? } ?>
        
		<label>
        	 Funcionário: <br> <b> <?=$funcionario->nome?> </b> 
        </label>
        <div style="clear:both"></div>
        <label style="width:215px;">Descrição <?=$t?>
			<input type="text" name="descricao"  id="descricao" <?=$readonly?> re valida_minlength='5' retorno='focus|Coloque no minimo 5 caracter' value="<?=$VendaEdit->descricao?>"/>
        </label>
        <div style="clear:both"></div>
        <label style="width:110px;">Valor Venda
			<input type="text" name="valor_total" id="valor_total" <?=$readonly?> decimal="2" value="<?=moedaUsaToBr($VendaEdit->valor_total)?>"/>
        </label>
        
        <label style="width:90px;">QTD parcelas
			<input type="text" name="quantidade_parcelas" id="quantidade_parcelas" <?=$readonly?> value="<?=$vendaParcela->qtdParcela?>"/>
        </label>
        
        <div style="clear:both"></div>
        
        <? if(empty($VendaEdit->id)){  ?>
        <label style="width:110px;">Primeiro Vencimento
			<input type="text" name="data_parcela[]" id="data_parcela" calendario="1" />
        </label>
        
         <label style="width:100px;">Valor Parcela
			<input type="text" name="valor_parcela[]" id="valor_parcela-1" readonly="readonly" />
        </label>
        <? } else {?>
       <table cellpadding="0" cellspacing="0" width="100%" style="border-left:1px solid #ccc; background:#FFF;">
            <thead>
              <tr>
                <td width="80">Vencimento</td>
                <td width="90">Valor</td>
                <td width="100">Situação</td>
                <td width="80">&nbsp;</td>
              </tr>
             </thead>
             <tbody>
              <? $SqlItens = (mysql_query(" SELECT * FROM  ".PARCELA." WHERE venda_id = '".$VendaEdit->id."'   "));
				$i=0;
				while($parcela=mysql_fetch_object($SqlItens)) {
					list($anoParcela, $mesParcela, $diaParcela) = explode('-', $parcela->data_vencimento);
					
					$FolhaEmpresa = mysql_fetch_object(mysql_query($y=" SELECT * FROM rh_folha_empresa WHERE empresa_id = '".$empresaID."' AND vkt_id = '$vkt_id' AND mes = '".$arrayMes[$mesParcela]."' AND ano = '".$anoParcela."' "));
						
						if($FolhaEmpresa->status == 'em aberto')
							$statusParcela = $situacao[1];
						else if($FolhaEmpresa->status == 'fechada')
							$statusParcela = $situacao[2];
						else 
							$statusParcela = "Pendente";
					
					if($i%2==0){$s="class='al'";}else{$s='';}
			  ?>
              <tr <?=$s?> id="<?=$parcela->id?>" >
                <td width="80"><?=dataUsaToBr($parcela->data_vencimento)?></td>
                <td width="90"> R$ <?=moedaUsaToBr($parcela->valor_parcela)?></td>
                <td width="100"><?=$statusParcela?> </td>
                <td width="80">
                	<? if($VendaEdit->status == 1 && $parcela->status == 1){ ?>
                    <a href="#" class="cancelarItem" > Cancelar </a>
                    <? } else if($parcela->status == 3) echo "<b style='color:#d9534f'>Cancelada</b>"; ?>
                </td>
              </tr> 
              <? $i++; } ?>
            </tbody>
		</table>
        <? } ?>
        <div style="clear:both"></div>
        
        <div id="resultParcela"></div>
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$cargo_salario->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($VendaEdit->id > 0 && $VendaEdit->status == 1){
?>
<input name="action" type="submit" value="Cancelar Venda" style="float:left" />
<?
}
?>
<input name="action" type="submit" <?=$readonly?>  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>