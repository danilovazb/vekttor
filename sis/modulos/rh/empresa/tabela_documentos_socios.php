<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
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
				 	
				 	$documentos = mysql_query($t="SELECT * FROM   cliente_fornecedor_arquivo WHERE cliente_fornecedor_id='$socio_id'");
					
					//echo $t;
					while($documento = @mysql_fetch_object($documentos)){
				 ?>
                 	<tr id_documento="<?=$documento->id?>">
                        <td style="width:250px;"><? if(empty($_GET['remove_documento'])||empty($_POST['acao2'])){ echo $documento->descricao;}else{echo utf8_encode($documento->descricao);}?></td>
                       	<td style="width:15px;"><img src="../fontes/img/baixar.png" class="imprimir_documento_empresa"/></td>
                        <td style="width:15px;"><img src='../fontes/img/menos.png' id='remove_documento_socio'></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
  </table>

  </div>