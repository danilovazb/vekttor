<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

if(empty($_GET['mes'])){
	$filtro_visitas = "AND data_visita BETWEEN '".DataBrToUsa($_GET['data_inicio'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
	$filtro_servicos = " AND os_i.data_aprovacao BETWEEN '".DataBrToUsa($_GET['data_inicio'])."' AND '".DataBrToUsa($_GET['data_fim'])."'";
}else{
	$filtro_visitas = "AND MONTH(data_visita)='".$_GET['mes']."'";
	$filtro_servicos = " AND MONTH(os_i.data_aprovacao)='".$_GET['mes']."'";
}
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:600px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Visita</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Visitas</strong></a>
            <a onclick="aba_form(this,1)">Serviços</a>
		</legend>
        

        <table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="100">Data</td>
                          <td width="300">Cliente</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:350px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
						
						$visitas = mysql_query($t="SELECT * FROM os_agenda_visita WHERE funcionario_id='".$_GET['id']."' $filtro_visitas");
						//	echo $t."<br>";
						//echo $t;
						while($visita=mysql_fetch_object($visitas)){							
							$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='$visita->cliente_id'"));
							//echo $t;
					?>
                    		<tr>
                            	<td width='100'>
                                	<?=DataUsaToBr($visita->data_visita)?>
                                </td>
                                <td width='300'>
                                	<?=$cliente->razao_social?>
                                                                                         	
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
							  <td width="21%">Total</td>
							  <td width="10%"><?=mysql_num_rows($visitas)?></td>
                           
                              <td></td>
						</tr>
                      </thead> 
              </table>
        
	</fieldset>
    <fieldset  id='campos_1' style="display:none;">
		<legend>
			<a onclick="aba_form(this,0)">Visitas</a>
            <a onclick="aba_form(this,1)"><strong>Serviços</strong></a>
		</legend>
        
	<table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="100">Data</td>
                          <td width="300">Cliente</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:350px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?php
						
						$servicos = mysql_query($t="SELECT * 
														FROM 
															os_item os_i,
															os os 
														WHERE
															os_i.os_id = os.id AND 
															os_i.funcionario_id='".$_GET['id']."' 
															$filtro");
						
						//echo $t."<br>";
						//echo $t;
						while($servico=mysql_fetch_object($servicos)){							
							$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='$servico->cliente_id'"));
							//echo $t;
					?>
                    		<tr>
                            	<td width='100'>
                                	<?=DataUsaToBr($servico->data_entrega)?>
                                </td>
                                <td width='300'>
                                	<?=$cliente->razao_social?>
                                                                                         	
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
							  <td width="21%">Total</td>
							  <td width="10%"><?=mysql_num_rows($servicos)?></td>
                           
                              <td></td>
						</tr>
                      </thead> 
              </table>

        
	</fieldset>
	<input name="id" id="id" type="hidden" value="<?=$agenda->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Fechar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>