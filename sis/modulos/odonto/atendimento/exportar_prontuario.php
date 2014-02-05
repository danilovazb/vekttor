<?php
include("../../../_config.php");
include("../../../_functions_base.php");
global $vkt_id;
$ano_atual = date("Y");		
if(empty($_GET['acao'])){
	echo "<script>window.open('modulos/odonto/atendimento/exportar_prontuario.php?acao=exibir')</script>";
}
?>

<style>
table{ border-collapse:collapse;width:650px;margin-bottom:20px;font-family:Arial, Helvetica, sans-serif;font-size:10px;}
table thead{text-align:center;font-weight:bold;}
table tr td { border:1px solid #333; padding:2px;}
</style>
     <?php
      	$sql_atendimento = mysql_query($t="SELECT 
											* 
										FROM
											cliente_fornecedor cf,
											odontologo_atendimentos oo											
										WHERE
											oo.vkt_id='$vkt_id' AND
											oo.cliente_fornecedor_id = cf.id");
											
		while($atendimento=mysql_fetch_object($sql_atendimento)){					
	  			
			
	  ?>
<table>
   	<thead>
      <tr style="background:#CCC;">
        <td style="width:200px;">Nome do  Paciente</td>
        <td style="width:80px;">Nascimento</td>      
        <td style="width:70px;">RG</td>
        <td style="width:80px;">Telefone</td>
        <td style="width:340px;">Endere&ccedil;o</td>
     </tr>
  </thead>
      <tbody>
    	<tr>
        	<td style="width:200px;"><?=$atendimento->razao_social;?></td>
            <td style="width:80px;"><?=dataUsaToBr($atendimento->nascimento)?></td>
           
            <td style="width:70px;"><?=$atendimento->rg?></td>
            <td style="width:80px;"><?=$atendimento->telefone1?></td>
            <td style="width:340px;"><?=$atendimento->endereco?></td>
        </tr>
     	</tbody>
      <thead>
      	<tr>       
      		<td colspan="5" style="text-align:center;background:#CCC;">Próximos Procedimentos</td>        
      	</tr>      
      	<tr>
      		<td> Procedimento</td>
        	<td>  Data  </td>
        	<td colspan="3"> Observação </td>
      	</tr>
      </thead>
	  <tbody>
	  <?php
	  	$procedimentos_pendentes = mysql_query("SELECT * FROM
														odontologo_atendimento_item oai,
														servico s
													WHERE
														oai.vkt_id = '$vkt_id' AND
														oai.servico_id = s.id AND
														oai.cliente_fornecedor_id = '$atendimento->cliente_fornecedor_id' AND
														oai.status != '3' AND
														oai.status != '2'
													");
      	while($consultas=mysql_fetch_object($procedimentos_pendentes)){
						
      ?>
     <tr>
      	<td><?=$consultas->nome?></td>
        <td><?=dataUsaToBr($consultas->data_conclusao)?></td>
        <td colspan="3" ><?=$consultas->obs;?></td>
     </tr>
     <?
		}
	 ?>
     </tbody>
     <thead>
      <tr>       
      	<td colspan="5" style="text-align:center;background:#CCC;">Procedimentos Concluídos</td>        
      </tr>      
      <tr>
      	<td> Procedimento</td>
        <td>  Data  </td>
        <td colspan="3"> Observação </td>
      </tr>
      </thead>
	  <tbody>
	  <?php
	  	$procedimentos_pendentes = mysql_query("SELECT * FROM
														odontologo_atendimento_item oai,
														servico s
													WHERE
														oai.vkt_id = '$vkt_id' AND
														oai.servico_id = s.id AND
														oai.cliente_fornecedor_id = '$atendimento->cliente_fornecedor_id' AND
														oai.status = '2'
													");
      	while($consultas=mysql_fetch_object($procedimentos_pendentes)){
						
      ?>
     	<tr>
      		<td><?=$consultas->nome?></td>
        	<td><?=dataUsaToBr($consultas->data_conclusao)?></td>
        	<td colspan="3" ><?=$consultas->obs;?></td>
     	</tr>
     </tbody>
     
   </table>
	  <?php
			} //fim while consultas
		} //fim while atendimento
	  ?>   