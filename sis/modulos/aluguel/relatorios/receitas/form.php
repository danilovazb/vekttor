<?
//Includes
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
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
<div style="width:630px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Equipamentos</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$aluguel->id?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"><strong>ITENS</strong></a>
            <a onclick="aba_form(this,1)">CUSTOS</a>
            <a onclick="aba_form(this,2)">LUCRO</a>    		
         </legend>
			Período: <?=$qtd_dias_locacao->dias?> Dias
            <table cellpadding="0" cellspacing="0" width="100%" >
                 <thead>
                        <tr>
                          <td width="250">Descriçao</td>
                          <td width="70">Quantidade</td>
                          <td width="70">Valor</td>
                          <td width="70">Valor Total</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
										
						$array_equipamentos = array();
						$c=0;
						while($itens=mysql_fetch_object($itens_aluguel)){							
						
							$equipamento = mysql_fetch_object(mysql_query($t="SELECT 
																			*,ae.id as id_equip 
																		   FROM 
																			aluguel_equipamentos_itens aei,
																			aluguel_equipamentos ae 
																		   WHERE 
																		   	aei.id='$itens->id' AND
																			aei.equipamento_id=ae.id AND
																			aei.vkt_id='$vkt_id'"));
							if(!in_array($equipamento->id_equip,$array_equipamentos)){
								$array_equipamentos[$c]=$equipamento->id_equip;
								$c++;	
							}
						
						}	
						$total_qtd = 0;
						$total_valor_aluguel_equipamento = 0;
						$total_locacao = 0;	 
						foreach($array_equipamentos as $equipamento_id){
							$equipamento = mysql_fetch_object(mysql_query("SELECT * FROM aluguel_equipamentos WHERE id='$equipamento_id'"));
							$vlr_equipamento =mysql_fetch_object(mysql_query($t="SELECT 
																				SUM(ae.vlr_aluguel) as valor, COUNT(*) as qtd
																			  FROM
																			  	aluguel_equipamentos ae,
																				aluguel_equipamentos_itens aei,
																				aluguel_locacao_itens ali
																			  WHERE
																			  	ae.id=$equipamento_id AND
																				ae.id=aei.equipamento_id AND
																				aei.id=ali.item_equipamento_id AND
																				ali.locacao_id='".$_GET['id']."' AND
																				ae.vkt_id='$vkt_id'
																			  ")); 
							if($vlr_equipamento->qtd>0){
								$total_qtd+=$vlr_equipamento->qtd;
								$total_valor_aluguel_equipamento+=$vlr_equipamento->valor;
								$valor = (($equipamento->vlr_aluguel*$qtd_dias_locacao->dias)/$equipamento->periodo)*$vlr_equipamento->qtd;
								$total_locacao +=$valor; 	
											
							
							
					?>
                    		<tr>
                            	<td width="250"><?=$equipamento->descricao?></td>
                          		<td width="70"><?=$vlr_equipamento->qtd?></td>
                          		<td width="70"><?=MoedaUsaToBr($vlr_equipamento->valor)?></td>
                          		<td width="70"><?=MoedaUsaToBr($valor)?></td>
                                <td></td>
                            </tr>
                    <?php
							}
						}						
					?>
                </tbody>
             </table>
             </div>
             <div id="excluir_item_produto"></div>
                        
            <table cellpadding="0" cellspacing="0" width="100%" >
            		<thead>
            			<tr>
							  <td width="250"></td>
							  <td width="70"><?=$total_qtd?></td>
                              <td width="70"><?=moedaUsaToBr($total_valor_aluguel_equipamento)?></td>
                              <td width="70"><?=moedaUsaToBr($total_locacao)?></td>
							  <td></td>
						</tr>
                      </thead> 
              </table>
       </fieldset>
		<fieldset style="display:none;">
		
             <legend>
            <a onclick="aba_form(this,0)">ITENS</a>
            <a onclick="aba_form(this,1)"><strong>CUSTOS</strong></a>
            <a onclick="aba_form(this,2)">LUCRO</a>    		
         </legend>
    		
        
	
            <table cellpadding="0" cellspacing="0" width="100%" >
                 <thead>
                        <tr>
                          <td width="250">NOME</td>
                          <td width="70">Valor</td>
                          <td width="70">Quantidade</td>
                          <td width="70">Valor Total</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            			                        
            <table cellpadding="0" cellspacing="0" width="100%" >
            		<?php
						$custos = mysql_query($t="SELECT * FROM aluguel_custos WHERE locacao_id='".$_GET['id']."'");
						//echo $t;
						$vlr_total_custo=0;
						$total_item=0;
						while($custo=mysql_fetch_object($custos)){
							$vlr_total_custo+=$custo->valor*$custo->qtd;
							$total_item+=$custo->qtd;
					?>
                    <tbody id="tbody">
            			<tr>
							  <td width="250"><?=$custo->nome?></td>
							  <td width="70"><?=MoedaUsaToBr($custo->valor)?></td>
                              <td width="70"><?=$custo->qtd?></td>
                              <td width="70"><?=MoedaUsaToBr($custo->valor*$custo->qtd)?></td>
							  <td></td>
						</tr>
                      </tbody>
                   <?php
						}
				   ?> 
              </table>
              <table cellpadding="0" cellspacing="0" width="100%" >
            		<thead>
            			<tr>
							  <td width="250"></td>
							  <td width="70"></td>
                              <td width="70"><?=$total_item?></td>
                              <td width="70"><?=moedaUsaToBr($vlr_total_custo)?></td>                              
							  <td></td>
						</tr>
                      </thead> 
              </table>
       </fieldset>
       <fieldset style="display:none;">
		
             <legend>
            <a onclick="aba_form(this,0)">ITENS</a>
            <a onclick="aba_form(this,1)">CUSTOS</a>
            <a onclick="aba_form(this,2)"><strong>LUCRO</strong></a>    		
         </legend>
    		<?php
				if(!$aluguel->comissao_vendedor>0){$comissao_vendedor="0,00";}else{$comissao_vendedor=$aluguel->comissao_vendedor*$total_locacao/100;}
			?>
            <strong>VALOR DA LOCAÇAO :</strong> <?=moedaUsaToBr($total_locacao)?>
            <div style="clear:both"></div>
            <strong>VALOR DOS CUSTOS :</strong><?=moedaUsaToBr($vlr_total_custo)?>
            <div style="clear:both"></div>
            <strong>COMISSAO DO VENDEDOR:</strong><?=moedaUsaToBr($comissao_vendedor)?>
            <div style="clear:both"></div>
            <strong>LUCRO:</strong> <?=moedaUsaToBr($total_locacao-$vlr_total_custo-$comissao_vendedor)?>	
       </fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<input name="action" type="button"  value="Imprimir" id="imprimir" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>