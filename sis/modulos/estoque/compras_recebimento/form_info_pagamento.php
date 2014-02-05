<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");

$id = $_GET["compra_id"];

 $status_pg = array(0=>"<span class='status pendente'>Pendente</span>",1=>"<span class='status pago'>Pago</span>",2=>"Cencelado");
 
?>
<style>
input,textarea{ display:block;}
</style>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:700px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Informa&ccedil;&otilde;es de Pagamento</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
    <input type="hidden" name="data_hoje" id="data_hoje" value="<?=date('d/m/Y')?>">
    <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$_GET["cliente_id"]?>">
	<fieldset  id='campos_1' >
		<legend>
			<strong>Pagamento</strong>
		</legend>
        
          <!-- ATENÇAO!! Aqui nao inserir o valida_minlength="1" porque está via javascript -->
          <input type="hidden" name="ContaID" id="ContaID" value="<?=$sqlConta->id?>"  retorno='focus|Nao Existe Conta Cadastrada'>
          <!-- forma de pagamento -->
          <div id="pg">
          
    
        
        <!-- fim campos do pagamento -->
        <div style="clear:both"></div>
        <input type="hidden" name="total_venda" id="total_venda" readonly="readonly" value="<?=moedaUsaToBr($total)?>">
           <? 
		   $count_parcela = mysql_fetch_object(mysql_query($t="SELECT COUNT(*) AS qtd_parcelas FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND doc='$id' AND origem_tipo='compra'"));
		
		   //if ($count_parcela->qtd_parcelas == 0) {?>
           <table cellpadding="0" cellspacing="0" width="80%" style="padding:9px;" >
                <thead>
                  <tr>
                    <td width="350">Parcelas descrição</td>
                    <td width="100">Vencimento</td>
                    <td width="140">Valor</td>
                    <td width="140">Status</td>
                  </tr>
               </thead>
               <tbody>
                 <?php
      					$sql_parcelas = mysql_query($t=" SELECT * FROM `financeiro_movimento` WHERE origem_id = '$id' AND origem_tipo = 'compra' AND cliente_id = '$vkt_id' "); 
						   //echo $t;
					while($dados=mysql_fetch_object($sql_parcelas)){  
						$cor++;
						if($cor%2){$sel='class="al"';}else{$sel='class="odd"';}        
				 ?> 
                   <tr <?=$sel?>style="background:#FFF">
                    <td width="350"><?=utf8_encode($dados->descricao)?></td>
                    <td width="100" id="total_parcela_diferenca"><?=dataUsaToBr($dados->data_vencimento)?></td>
                    <td width="140" id="total_parcela_diferenca"><?=moedaUsaToBr($dados->valor_cadastro)?></td>
                    <td width="140" id="total_parcela_diferenca"><?=$status_pg[$dados->status]?></td>
                  </tr>
                 <?php
					}
				 ?> 
           	   </tbody>
         </table>
      
        <div style="clear:both"></div>
        <!--<div style="padding:4px; background:#FFF; width:50%;"> 
         <!-- <input type="checkbox" name="efetivar_movimentacao" id="efetivar_movimentacao" value="1"> Efetivar movimenta&ccedil;&atilde;o ? -->
        <!--</div>-->
        <div style="clear:both"></div>
        <!--<div id="info_parcela_1" style="float:left;"></div>-->
        <div style="clear:both;"></div>
        <div class="info_parcela" style="float:left; max-height:150px; width:420px; overflow:auto"></div> 
        <!--<div style="float:left;" id="ParcelasData"></div>-->
        
        
        <div style="clear:both;"></div>
        
        <? if ($parcelas->qtdParcelaOS > 0) {?>
        <label style="border-bottom:1px solid #C9C9C9; width:360px; display:none; padding:3px" id="titulo_parcela">Informa&ccedil;&otilde;es da Parcela:</label>
        
        <label style="border-bottom:1px solid #C9C9C9; width:390px; display:block; padding:3px" id="tableDescricaoParcela">Detalhes da Parcela:</label>
        <div style="clear:both;"></div>
        
        <div>
        	<table cellpadding="0" cellspacing="0" width="50%" >
                <thead>
                  <tr>
                    <td width="300" style="border-left:1px solid #CCC;">Descri&ccedil;&atilde;o</td>
                    <td width="140">Vencimento</td>
                    <td width="160">Valor Parcela</td>
                    <td width="70">Status</td>
                  </tr>
               </thead>
               <tbody>
               <?
               		/*$sql = mysql_query(" SELECT * FROM financeiro_movimento WHERE doc = '".$reg_os->id."' AND cliente_id = '$vkt_id' ORDER BY data_vencimento ");				
						while($item_parcela=mysql_fetch_object($sql)){
							$total += $item_parcela->valor_cadastro;
							$cor++;
							if($cor%2){$sel='class="al"';}else{$sel='class="odd"';}*/
			   ?>
               			<tr <?=$sel?>>
                          <td style="border-left:1px solid #CCC;" width="300"><?=$item_parcela->descricao?></td>
                          <td width="140"><?=dataUsaToBr($item_parcela->data_vencimento)?></td>
                          <td width="160"><?=moedaUsaToBr($item_parcela->valor_cadastro)?></td>
                          <td width="70">
						  	<?
                          		/*if($item_parcela->status == '0')
									echo 'N&atilde;o Pago';
								else if($item_parcela->status == '1')
									echo 'Pago'*/
						  	?>
                          </td>
                        </tr>
               <?
						//}
			   ?>
               </tbody>
               <thead>
                        <tr>
                          <td colspan="2" style="padding-right:8px" align="right">Total</td>
                          <td><?=moedaUsaToBr($total)?></td>
                          <td></td>
                        </tr>         
               </thead>
           </table>
        </div>
        <? }?>
		
	</fieldset>
	<input name="id" type="hidden" value="<?=$_GET["venda_id"]?>" />
    <input type="hidden" name="venda_id" id="venda_id" value="<?=$_GET["venda_id"]?>">
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Enviar Financeiro" id="envia-financeiro" style="float:right; display:none;"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>