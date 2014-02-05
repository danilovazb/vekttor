<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_function_funcionario.php");
include("_ctrl_funcionario.php");
?>
<div id='socios_interno'>
<table  cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:200px;">Nome</td>
                        <td style="width:50px;">Data de Nascimento</td>
                        <td style="width:50px;">Grau de Parentesco</td>
                         <td style="width:30px;">Remover</td>                     
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$dependentes = mysql_query($t="SELECT * FROM  rh_funcionario_dependentes WHERE vkt_id='$vkt_id' AND funcionario_id='$id'");
					
					//echo $t;
					while($dependente = @mysql_fetch_object($dependentes)){
				 ?>
                 	<tr id_dependente="<?=$dependente->id?>">
                        <td style="width:200px;" class="edita_socio"><?=$dependente->nome?></td>
                        <td style="width:30px;"><?=DataUsaToBr($dependente->data_nascimento)?></td>
                        <td style="width:30px;"><?=$dependente->grau_parentesco?></td>
                        <td style="width:30px;"><img src='../fontes/img/menos.png' id='remove_dependente'></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
  </table>

  </div>