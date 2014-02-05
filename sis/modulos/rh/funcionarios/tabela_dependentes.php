<?
//Includes
if($host){}else{

include("../../../_config.php");
include("../../../_functions_base.php");
include("_function_funcionario.php");
include("_ctrl_funcionario.php");
}

?>
<div id='socios_interno'>
<table  cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:100px;">Dependente</td>
                        <td style="width:50px;">Dt Nascimento</td>
                        <td style="width:50px;">Escolaridade</td>
                        <td style="width:50px;">Parentesco</td>
                        <td style="width:150px;">Plano de Saude</td>
                         <td style="width:30px;">Remover</td>                     
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$dependentes = mysql_query($t="SELECT * FROM  rh_funcionario_dependentes WHERE vkt_id='$vkt_id' AND funcionario_id='$id'");
					
					//echo $t;
					while($dependente = @mysql_fetch_object($dependentes)){
						$nome = $dependente->nome;
						$descolaridade = $escolaridade[$dependente->escolaridade];
						
						if($_GET['adicionar_dependente']=='1'||$_GET['remove_dependente']=='1'){
							
							$nome=utf8_encode($nome);
							$descolaridade=utf8_encode($descolaridade);
						}
				 ?>
                 	<tr id_dependente="<?=$dependente->id?>">
                        <td style="width:100px;" class="edita_socio"><?=$nome?></td>
                        <td style="width:30px;"><?=DataUsaToBr($dependente->data_nascimento)?></td>
                        <td style="width:50px;"><?=$descolaridade?></td>
                        <td style="width:30px;"><?=$dependente->grau_parentesco?></td>
                        <td style="width:150px;"><?=ucwords($dependente->plano_saude)?></td>
                        <td style="width:30px;"><img src='../fontes/img/menos.png' id='remove_dependente'></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
  </table>

  </div>