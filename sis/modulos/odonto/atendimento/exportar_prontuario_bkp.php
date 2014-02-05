<?php
include("../../../_config.php");
include("../../../_functions_base.php");
global $vkt_id;		
$ano_atual = date("Y");
		
/*$paciente = mysql_fetch_object(mysql_query( " SELECT * FROM cliente_fornecedor WHERE id = '10446' " ));
list($ano_nascimento,$mes,$dia) = explode("-",$paciente->nascimento);	
		
$sql_atendimento = (mysql_query(" SELECT * FROM odontologo_atendimentos WHERE cliente_fornecedor_id = '$paciente->id' "))
*/
		
?>
<script>
	document.onload(){
		if(<?=$_GET['tela_id']?>0){
			window.open("http://vkt.srv.br/~nv/sis/modulos/odonto/atendimento/exportar_prontuario.php");
		}
	}
</script>
<style>
table{ border:1px solid #333; border-collapse:collapse;}
table tr td,th { border:1px solid #333; padding:2px;}
</style>	
   <table cellpadding="0" cellspacing="0">
   	<thead>
      <tr>
        <th>Nome do  Paciente</th>
        <th>Nascimento</th>
        <th>Idade</th>
        <th>RG</th>
        <th>Telefone</th>
        <th>Endere&ccedil;o</th>
     </tr>
  </thead>
    <tbody>
    	<tr style="background:#CCC;">
        	<td><?=$paciente->razao_social;?></td>
            <td><?=dataUsaToBr($paciente->nascimento)?></td>
            <td><? echo $ano_atual - $ano_nascimento;?></td>
            <td><?=$paciente->rg?></td>
            <td><?=$paciente->telefone1?></td>
            <td><?=$paciente->endereco?></td>
        </tr>
    </tbody>
    <tbody>
      <?php
      	while($atendimento=mysql_fetch_object($sql_atendimento)){					
	  ?>
       <tr>
      	<td>Ultimas consultas</td>
        <td> Data </td>
        <td> Procedimentos </td>
        <td colspan="3"> Observação </td>
      </tr>
      <?php
      	$sql_consultas_paciente = mysql_query(" SELECT * FROM odontologo_consultas WHERE odontologo_atendimento_id = '$atendimento->id' AND cliente_fornecedor_id = '$paciente->id' ");
			while($consultas=mysql_fetch_object($sql_consultas_paciente)){
				
				$consultas_item = mysql_fetch_object(mysql_query($t=" 
				
				SELECT *,consulta_item.obs AS obs_procedimentos FROM odontologo_consulta_has_odontologo_atendimento_item AS consulta_item
				JOIN odontologo_atendimento_item AS procedimento_item ON procedimento_item.id =  consulta_item.odontologo_atendimento_item_id
				WHERE consulta_item.odontologo_consulta_id = '$consultas->id'  "));
				
				$servico = mysql_fetch_object(mysql_query(" SELECT * FROM servico WHERE id = '$consultas_item->servico_id' "));
			
      ?>
      <tr>
      	<td></td>
        <td><?=dataUsaToBr($consultas->data)?></td>
        <td><?=$servico->nome?></td>
        <td colspan="3" ><?=$consultas_item->obs_procedimentos;?></td>
      </tr>
      <?php
			} //fim while consultas
		} //fim while atendimento
	  ?>
    </tbody>
   </table>