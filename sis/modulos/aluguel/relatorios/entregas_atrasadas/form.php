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
    
    <span>Itens Locados</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$equipamento->equipamento_id?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	  <fieldset id="campos_1">
<!-- *********************** AQUI FORMULARIO DE CADASTRO DE ITENS****-->
 		<legend>
           <strong>Itens Locados</strong>
          </legend>
            <input type="hidden" name="item_id" id="item_id" style="width:50px;">
             <div style="clear:both;"></div>
            
          	<table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="350">Descricao</td>
                          <td width="100">Status</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
						
						$itens_locacao = mysql_query($t="SELECT 
														* 
													FROM 
														aluguel_locacao_itens ali,
														aluguel_equipamentos ae 
													 WHERE
													 	ali.item_equipamento_id = ae.id AND  
													 	ali.locacao_id = '".$_GET['id']."' AND
														ali.vkt_id = '$vkt_id'
														");//echo $t;
						$itens_nao_devolvidos = 0;
						while($item=mysql_fetch_object($itens_locacao)){							
							if($item->status_item=='1'){
								$status = 'Locado';
								$itens_nao_devolvidos+=1;
							}else{
								$status = 'Disponível';
							}
					?>
                    		<tr>
                            	<td width='350'>
                                	<?=$item->descricao?>
                                                	
                                </td>
                                <td width='100'>
                                	<?=$status?>
                                                                                         	
                                </td>
                                <td></td>
                            </tr>
                    <?php
							
						}
						$total_itens = mysql_fetch_object(mysql_query($t="SELECT 
												COUNT(*) as qtd  
										FROM 
										  	aluguel_equipamentos ae,
											aluguel_equipamentos_itens aei																							 
										WHERE
										 	ae.id=aei.equipamento_id AND
											ae.id='".$_GET['id']."' AND 
											ae.vkt_id='$vkt_id'"));
											
					?>
                </tbody>
             </table>
             </div>
             <div id="excluir_item_produto"></div>
                        
            <table cellpadding="0" cellspacing="0" width="100%" >
            		<thead>
            			<tr>
							  <td width="21%">N&ordm; Itens</td>
							  <td width="10%" id="total_item"><?=mysql_num_rows($itens_locacao)?></td>
                              <td width="25%">Não Devolvidos</td>
							  <td width="10%" id="item_disponivel"><?php echo $itens_nao_devolvidos;?></td>
                              <td></td>
						</tr>
                      </thead> 
              </table>
      </fieldset>
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Fechar" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>