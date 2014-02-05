<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
print_r($_POST);
print_r($_GET);
$item_id = $_GET['item_id'];
$necessidade_id = $_GET['necessidade_id'];
$produto=mysql_fetch_object(mysql_query("SELECT * FROM produto WHERE id='".$_GET['produto_id_item']."'"));
$item_id = mysql_result(mysql_query("SELECT id FROM cozinha_necessidade_item WHERE produto_id='$produto->id' AND necessidade_id='$necessidade_id'"),0,0);
//alert($item_id);
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
    
    <span>Planejamento</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<input type="hidden" name="item_id" id="item_id" value="<?=$item_id?>"/>
    <input type="hidden" name="necessidade_id" id="necessidade_id" value="<?=$necessidade_id?>"/>
    <input type="hidden" name="produto_id" id="produto_id" value="<?=$produto->id?>"/>
     <input type="hidden" name="gramatura_produto" id="gramatura_produto" value="<?=$produto->gramatura?>"/>
    <!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Planejamento</strong>
		</legend>
        
        <div></strong>Produto:</strong> <?=$produto->nome?></div>
        <div style="clear:both"></div>
		<table cellpadding="0" cellspacing="0" width="100%" id="tbl_planejamento">
                <thead>
                        <tr>
                          <td style="border-left:1px solid #CCC;">Contrato</td>
                          <td style="width:45px;">Pessoas</td>
                          <td style="width:45px;">Gramatura</td>
                          <td style="width:65px;">Valor Total</td>
                         </tr>
               </thead>
                
		<?
			$contratos = mysql_query($t="
			SELECT 
				*,cc.id as contrato_id 
			FROM 
				cozinha_contratos cc,
				cliente_fornecedor cf
			WHERE
				cc.vkt_id='$vkt_id' AND
				cc.cliente_id=cf.id AND
				cc.status='1'");
				//echo $t;
			while($contrato = mysql_fetch_object($contratos)){
				//verifica se já tem planejamento para este contrato e este produto
				$existe_planejamento = mysql_fetch_object(mysql_query("
					SELECT 
						* 
					FROM 
						cozinha_cotacao_planejamento 
					WHERE 
						item_necessidade_id='$item_id' AND
						contrato_id='$contrato->contrato_id'
				"));
				if(!$existe_planejamento->id>0){
					$qtd_pessoas=$contrato->almoco_mes;
					$gramatura  =$produto->gramatura; 
				}else{
					$qtd_pessoas=$existe_planejamento->qtd_pessoas;
					$gramatura  =$existe_planejamento->gramatura;
				}
				$total_planejamento=$qtd_pessoas*$gramatura;
				$total_geral+=$total_planejamento;
		?>
        	<tbody>
            	<tr>
                	<td>
						<?=$contrato->contrato_id." - ".$contrato->razao_social?>
                     	<input type="hidden" class="contrato_id" name="contrato_id[]" value="<?=$contrato->contrato_id?>" />
                        <input type="hidden" class="planejamento_id" name="planejamento_id[]" value="<?=$existe_planejamento->id?>" />
                     </td>
                    <td style="width:45px;"><input type="text" name="qtd_pessoas[]" class="qtd_pessoas" style="width:35px;height:10px;" value="<?=limitador_decimal_br($qtd_pessoas,3)?>"/></td>
                    <td style="width:45;"><input type="text" name="f_gramatura[]" class	="f_gramatura" style="width:35px;height:10px;" value="<?=limitador_decimal_br($gramatura,3)?>"/></td>
                    <td style="width:65px;" class="valor_total_planejamento"><?=limitador_decimal_br($total_planejamento)?></td>
                </tr>
            </tbody>
		<?			
			}
		?>
        <thead>
                        <tr>
                          <td style="border-left:1px solid #CCC;"></td>
                          <td style="width:45px;"></td>
                          <td style="width:45px;"></td>
                          <td style="width:65px;"  ><span id="total_planejamento"><?=limitador_decimal_br($total_geral)?></span> <?=substr($produto->unidade_uso,0,2)?></td>
                         </tr>
               </thead>
       </table>
       <div style="clear:both"></div>
       
       
        
	</fieldset>
	
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="acao" type="submit" id="acao" value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>