<?php
	include("../../../_config.php");
	include("../../../_functions_base.php");
	include ("_functions.php");
	include ("_ctrl.php");
	global $usuario_id;
	global $vkt_id;
	if(empty($_GET['ano'])){
	$ano=date('Y');
}else{
	$ano=$_GET['ano'];
}
?>
<style>
table thead{
	background-color:#CCC;
}
table tbody,.coluna_pago,.coluna_pendente{
	font-size:14px;
}
.coluna_pago,.coluna_pendente{
	text-align:center;
}
.valores{
	text-align:right;
}
table{
	border-collapse:collapse;
}
table tr td{
	border:solid 1px #000000;
}
</style>
<div id="info_filtro">
	<?php
		if(is_file("vekttor/clientes/img/$vkt_id.png")){
	?>
    <div style="float:left">
    	
        <img src="vekttor/clientes/img/<?=$vkt_id?>.png">
    </div>
    <?php
		}
	?>
	<div style="float:left" style="padding-top:5px;height:100%">
		<strong><?=strtoupper($empresa[nome])?></strong>
		<div style="clear:both"></div>
    	<strong>Fauramento Por Salas</strong>
    	<div style="clear:both"></div>
    	<strong>Ano:</strong> <?=$ano?>
        <strong>Sala:</strong> <?=$sala->nome?>
    	
	</div>
    <div style="clear:both"></div>
<table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
            	<td width="200">Aluno</td>
              	<td width="150">Responsável</td>
				<?php
					foreach($mes_extenso as $mes){
						echo "<td colspan='2' style='text-align:center'>".substr($mes,0,3)."</td>";
					}
				?>
                <td>&nbsp;</td>
            </tr>
         </thead>
       <thead>
            <tr>
            	<td colspan="2">&nbsp;</td>
              	<?php
					foreach($mes_extenso as $mes){
						echo "<td width='30' class='coluna_pago'>Pago</td>";
						echo "<td width='29' title='Pendente' rel='tip' class='coluna_pendente'>Pend.</td>";
					}
				?>
                <td>&nbsp;</td>
            </tr>
        </thead>
           <tbody>
            <?php
            	
				$matriculas_salas = mysql_query(
						"
							SELECT *, ea.nome as nome_aluno, em.id as id_matricula FROM
								escolar2_turmas et,
								escolar2_matriculas em,
								cliente_fornecedor cf,
								escolar2_alunos ea
							WHERE
								et.vkt_id='$vkt_id' AND
								et.id = em.turma_id AND
								em.aluno_id = ea.id AND
								em.responsavel_id = cf.id AND
								et.sala_id = '$sala->id'								
						");
					while($matricula = mysql_fetch_object($matriculas_salas)){
						
						
				
            ?>
                <tr>
                    <td width="149"><?=$matricula->nome_aluno?></td>
              		<td width="150"><?=$matricula->razao_social?></td>
                	
					<?php
												
						$c=1;
						foreach($mes_extenso as $mes){
							$mensalidade_pendentes = mysql_result(
								mysql_query($t="SELECT SUM(valor_cadastro) as total FROM
									financeiro_movimento
								WHERE
									cliente_id='$vkt_id' AND
									doc='$matricula->id_matricula' AND
									origem_tipo = 'Mensalidade escolar' AND
									status='0' AND
									MONTH(data_vencimento)='$c' AND
									YEAR(data_vencimento)='$ano'
									"),0,0);
							$mensalidade_pagas = mysql_result(
								mysql_query($t="SELECT SUM(valor_cadastro) as total FROM
									financeiro_movimento
								WHERE
									cliente_id='$vkt_id' AND
									doc='$matricula->id_matricula' AND
									origem_tipo = 'Mensalidade escolar' AND
									status='1' AND
									MONTH(data_vencimento)='$c' AND
									YEAR(data_vencimento)='$ano'
									"),0,0);																
					?>
                    <td width="29" style="font-size:10px;" onclick="" class="valores"><? if(!$mensalidade_pagas>0){echo "0,00";}else{echo moedaUsaToBr($mensalidade_pagas);}?></td>
                    <td width="30" style="font-size:10px;" class="valores"><? if(!$mensalidade_pendentes>0){echo "0,00";}else{echo moedaUsaToBr($mensalidade_pendentes);}?></td>                    
                    <?
							$total_pago[$c-1] += $mensalidade_pagas;
							$total_pendente[$c-1] += $mensalidade_pendentes;
							$c++;
							 
						}
					?>
                	<td>&nbsp;</td>
                 </tr>
              		<?
				}
					?>
            </tbody>    
        <thead>
             <tr >
                    <td colspan="2">&nbsp;</td>
              		
                    <?php
						for($c=0;$c<sizeof($total_pago);$c++){
					?>
                    <td width="29" style="font-size:9px;" onclick="" class="valores"><? echo moedaUsaToBr($total_pago[$c])?></td>
                    <td width="30" style="font-size:9px;" class="valores"><? echo moedaUsaToBr($total_pendente[$c])?></td>
            		<?php
						}
					?>
                    <td>&nbsp;</td>
            </tr>
        </thead>
    </table>     