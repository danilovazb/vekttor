<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_function_funcionario.php");
include("_ctrl_funcionario.php");
?>
<div id='documentos_funcionario'>
<table  cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:250px;">Descriçao</td>
                        <td style="width:15px;">Download</td>
                         <td style="width:15px;">Remover</td>                     
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$documentos = mysql_query($t="SELECT * FROM   rh_funcionarios_documentos WHERE vkt_id='$vkt_id' AND funcionario_id='$id'");
					
					//echo $t;
					while($documento = @mysql_fetch_object($documentos)){
				 ?>
                 	<tr id_documento="<?=$documento->id?>">
                        <td style="width:250px;" class="edita_socio"><?=$documento->descricao?></td>
                       	<td style="width:15px;"><img src="../fontes/img/baixar.png" class="imprimir_documentos"/></td>
                        <td style="width:15px;"><img src='../fontes/img/menos.png' id='remove_documento'></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
  </table>

  </div>