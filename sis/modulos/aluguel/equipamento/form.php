<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
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
    <input type="hidden" name="id" id="id" value="<?=$equipamento->equipamento_id?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"> | <strong>Dados Principais</strong> |</a>
    		<a onclick="aba_form(this,1)">Itens | </a>
         </legend>
	
    	<label style="width:300px;">
        	Descriç&atilde;o
        	<input type="text" name="descricao" id="descricao" value="<?=$equipamento->descricao?>" retorno="focus|Digite uma Descriçao" valida_minlength='1'/>
        </label>
        <label style="width:150px;">
        	Modelo
        	<input type="text" name="modelo" id="modelo" value="<?=$equipamento->modelo?>"/>
        </label>
        <div style="clear:both"></div>
        <label style="width:300px;">
        	Fabricante
        	<input type="text" name="fabricante" id="fabricante" value="<?=$equipamento->fabricante?>"/>
        </label>
        <label style="width:100px;">
        	Valor do Aluguel
        	<input type="text" name="vlr_aluguel" id="vlr_aluguel" decimal="2" sonumero="1" value="<?=MoedaUsaToBr($equipamento->vlr_aluguel)?>" retorno="focus|Digite um valor para o aluguel" valida_minlength='1'/>
        </label>
    	<div style="clear:both"></div>
        <label style="width:70px;">
        	Período(Dias)
        	<input type="text" name="periodo" id="periodo" sonumero="1" value="<?=$equipamento->periodo?>" retorno="focus|Digite o período de aluguel" valida_minlength='1'/>
        </label>
        <label style="width:95px;">
        	Data de Cadastro
        	<input type="text" name="data_cadastro" id="data_cadastro" readonly="readonly"  value="<?php if(empty($equipamento)){echo date("d/m/Y");}else{ echo DataUsaToBr($equipamento->data_cadastro);}?>" />
        </label>
    </fieldset>
	  <fieldset id="campos_2" style="display:none">
<!-- *********************** AQUI FORMULARIO DE CADASTRO DE ITENS****-->
 		<legend>
             <a onclick="aba_form(this,0)">| Dados Principais |</a>
    		<a onclick="aba_form(this,1)"><strong>Itens</strong> | </a>
          </legend>
            <input type="hidden" name="item_id" id="item_id" style="width:50px;">
            <label style="width:50px;">
            	Quantidade
                <input type="text"  name="qtd_itens" id="qtd_itens" <?php if(empty($equipamento)){ echo "retorno='focus|Digite uma quantidade' valida_minlength='1' value='1'";}?>/>
            </label>
            <br>
            <input type="checkbox" name="identificar" id="identificar"/>Identificar Itens
            <div style="clear:both;"></div>
            <?
				if(@mysql_num_rows($equipamento_itens)>0){
					echo "<a href='#' id='remove_todos_itens'>Remover Itens Disponíveis</a>";
				}
			?>
          	<table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="350">Identificacao</td>
                          <td width="70">Status</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
						if($_GET[id]>0&&mysql_num_rows($equipamento_itens)>0){
						//soma itens disponíveis
						$it_disp=0;
						while($item=mysql_fetch_object($equipamento_itens)){							
							//verifica se item está na tabela locacao itens
							/*$item_locacao = mysql_query($t=" SELECT 
																				* 
																			  FROM 
																			  	aluguel_equipamentos_itens aei,
																				aluguel_locacao_itens ali
																			WHERE
																				aei.id=ali.item_equipamento_id AND
																				aei.id='$item->id'	
																			");*/
							//echo $t;
							if($item->status==1){
								$status='Disponível';
								$s=1;								
								$it_disp++;
							}else{
								$status='Indisponível';
								$s=2;
							}
					?>
                    		<tr>
                            	<td width='350'>
                                	<?=$item->numero_serie?>
                                    <input type="hidden" name="id_item_equipamento[]" class="id_item_equipamento" value="<?=$item->id?>" />                  	
                                </td>
                                <td width='70'>
                                	<?=$status?>
                                    <input type="hidden" name="status_item[]" class="status_item" value="<?=$s?>" />                                                      	
                                </td>
                                <td><img src='../fontes/img/menos.png' id='excluir_item'></td>
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
							  <td width="21%">N&ordm; Itens</td>
							  <td width="10%" id="total_item"><? if($_GET[id]>0&&mysql_num_rows($equipamento_itens)>0){ echo mysql_num_rows($equipamento_itens);}?></td>
                              <td width="25%">Disponíveis</td>
							  <td width="10%" id="item_disponivel"><?php echo $it_disp;?></td>
                              <td></td>
						</tr>
                      </thead> 
              </table>
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

<input name="action" type="submit"  value="Salvar" id="Salvar" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>