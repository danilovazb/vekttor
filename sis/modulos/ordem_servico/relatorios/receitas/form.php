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
    
    <span>OS</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"><strong>SERVIÇOS</strong></a>
    		<a onclick="aba_form(this,1)">PRODUTO</a>
            <a onclick="aba_form(this,2)">DESPESAS</a>
            <a onclick="aba_form(this,3)">COMISSAO FUNCIONÁRIO</a>
         	<a onclick="aba_form(this,4)">LUCRO</a>
         </legend>
	
    	   <table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="250">Identificacao</td>
                          <td width="70">Quantidade</td>
                          <td width="70">Valor</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
						$total_servico = 0;
						while($servico=mysql_fetch_object($servicos)){							
							$s= mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id='$servico->servico_id'"));
							$total_servico+=($servico->valor_servico*$servico->qtd_servico);
					?>
                    		<tr>
                            	<td width='250'>
                                	<?=$s->nome?>                  	
                                </td>
                                <td width='70'>
                                	<?=$servico->qtd_servico?>                                                      	
                                </td>
                                <td width='70'>
                                	<?=moedaUsaToBr($servico->valor_servico)?>                                                      	
                                </td>
                                <td></td>
                            </tr>
                    <?php
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
							  <td width="70"><?=@mysql_num_rows($servicos)?></td>
                              <td width="70"><?=moedaUsaToBr($total_servico)?></td>
							  <td></td>
						</tr>
                      </thead> 
              </table>
    </fieldset>
	  <fieldset id="campos_2" style="display:none">
<!-- *********************** AQUI FORMULARIO DE CADASTRO DE ITENS****-->
 		 <legend>
            <a onclick="aba_form(this,0)">SERVIÇOS</a>
    		<a onclick="aba_form(this,1)"><strong>PRODUTO</strong></a>
            <a onclick="aba_form(this,2)">DESPESAS</a>
            <a onclick="aba_form(this,3)">COMISSAO FUNCIONÁRIO</a>
            <a onclick="aba_form(this,4)">LUCRO</a>         	
         </legend>
         	<table cellpadding="0" cellspacing="0" width="100%" >
                 <thead>
                        <tr>
                          <td width="250">Nome</td>
                          <td width="70">Quantidade</td>
                          <td width="70">Valor</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
						$total_produto = 0;
						while($produto=mysql_fetch_object($produtos)){							
							
							$s= mysql_fetch_object(mysql_query($t="SELECT * FROM produto WHERE id='$produto->produto_id'"));
							//echo $t;
							$total_produto+=($produto->valor_produto*$produto->qtd_produto);
					?>
                    		<tr>
                            	<td width='250'>
                                	<?=$s->nome?>                  	
                                </td>
                                <td width='70'>
                                	<?=$produto->qtd_produto?>                                                      	
                                </td>
                                <td width='70'>
                                	<?=moedaUsaToBr($produto->valor_produto)?>                                                      	
                                </td>
                                <td></td>
                            </tr>
                    <?php
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
							  <td width="70"><?=@mysql_num_rows($produtos)?></td>
                              <td width="70"><?=moedaUsaToBr($total_produto)?></td>
							  <td></td>
						</tr>
                      </thead> 
              </table>
      </fieldset>
	  <fieldset id="campos_3" style="display:none">
<!-- *********************** AQUI FORMULARIO DE CADASTRO DE ITENS****-->
 		 <legend>
            <a onclick="aba_form(this,0)">SERVIÇOS</a>
    		<a onclick="aba_form(this,1)">PRODUTO</a>
            <a onclick="aba_form(this,2)"><strong>DESPESAS</strong></a>
            <a onclick="aba_form(this,3)">COMISSAO FUNCIONÁRIO</a>
            <a onclick="aba_form(this,4)">LUCRO</a>          	
         </legend>
            <table cellpadding="0" cellspacing="0" width="100%" >
                 <thead>
                        <tr>
                          <td width="250">Descriçao</td>
                          <td width="70">Quantidade</td>
                          <td width="70">Valor</td>
                          <td width="70">Total Item</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
						$total_custo = 0;
						while($custo=mysql_fetch_object($custos_os)){							
							//$s= mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$funcionario->funcionario_id'"));
							$total_custo+=$custo->total_item;
					?>
                    		<tr>
                            	<td width="250"><?=$custo->descricao?></td>
                          		<td width="70"><?=$custo->qtd?></td>
                          		<td width="70"><?=$custo->valor?></td>
                          		<td width="70"><?=$custo->total_item?></td>
                                 <td></td>
                            </tr>
                    <?php
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
							  <td width="70"><?=mysql_num_rows($custos_os)?></td>
                              <td width="70"><?=moedaUsaToBr($total_custo)?></td>
							  <td></td>
						</tr>
                      </thead> 
              </table>
       </fieldset>
		<fieldset id="campos_4" style="display:none">
<!-- *********************** AQUI FORMULARIO DE CADASTRO DE ITENS****-->
 		 <legend>
            <a onclick="aba_form(this,0)">SERVIÇOS</a>
    		<a onclick="aba_form(this,1)">PRODUTO</a>
            <a onclick="aba_form(this,2)">DESPESAS</a>
            <a onclick="aba_form(this,3)"><strong>COMISSAO FUNCIONÁRIO</strong></a>
            <a onclick="aba_form(this,4)">LUCRO</a>          	
         </legend>
         <table cellpadding="0" cellspacing="0" width="100%" >
                 <thead>
                        <tr>
                          <td width="250">Identificacao</td>
                          <td width="70">Valor</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
						$total_funcionario = 0;
						while($funcionario=mysql_fetch_object($comissao_funcionario)){							
							$s= mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$funcionario->funcionario_id'"));
							$total_funcionario+=$funcionario->valor_funcionario;
					?>
                    		<tr>
                            	<td width='250'>
                                	<?=$s->nome?>                  	
                                </td>
                                <td width='70'>
                                	<?=moedaUsaToBr($funcionario->valor_funcionario)?>                                                    	
                                </td>
                                <td></td>
                            </tr>
                    <?php
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
							  <td width="70"><?=moedaUsaToBr($total_funcionario)?></td>
							  <td></td>
						</tr>
                      </thead> 
              </table>
       </fieldset>
       <fieldset id="campos_5" style="display:none">
<!-- *********************** AQUI FORMULARIO DE CADASTRO DE ITENS****-->
 		 <legend>
            <a onclick="aba_form(this,0)">SERVIÇOS</a>
    		<a onclick="aba_form(this,1)">PRODUTO</a>
            <a onclick="aba_form(this,2)">DESPESAS</a>
            <a onclick="aba_form(this,3)">COMISSAO FUNCIONÁRIO</a>
            <a onclick="aba_form(this,4)"><strong>LUCRO</strong></a>          	
         </legend>
         <label>
         	Valor da OS<br>
            <input type="text" value="<?=moedaUsaToBr($total_servico+$total_produto)?>" />   
       	 </label>
         <div style="clear:both"></div>
         <label>
         	Despesas<br>
            <input type="text" value="<?=moedaUsaToBr($total_custo)?>" />   
       	 </label>
         <div style="clear:both"></div>
         <label>
         	Desp. Peças<br>
            <input type="text" value="<?=moedaUsaToBr($soma_vlr_produtos)?>" />   
       	 </label>
         <div style="clear:both"></div>
         <label>
         	Comissao Funcionário<br>
            <input type="text" value="<?=moedaUsaToBr($total_funcionario)?>" />   
       	 </label>
         <div style="clear:both"></div>
         <label>
         	Comissao Vendedor<br>
            <?php
				if($os->comissao_vendedor>0){
					$comissao_vendedor = $os->comissao_vendedor*($total_servico+$total_produto)/100;
				}else{
					$comissao_vendedor = 0.00;
				}
			?>
            <input type="text" value="<?php echo moedaUsaToBr($comissao_vendedor);?>" />   
       	 </label>
         <div style="clear:both"></div>
         <label>
         	Lucro<br>
            <input type="text" value="<?=moedaUsaToBr($total_servico+$total_produto-$total_funcionario-$total_custo-$comissao_vendedor-$soma_vlr_produtos)?>" />   
       	 </label>
         <div style="clear:both"></div>
       </fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($equipamento->id > 0){
?>
<input name="action" type="submit" value="Excluir" id="Excluir" style="float:left" />
<?
}

?>

<input name="action" type="button"  value="Imprimir" id="imprimir" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>