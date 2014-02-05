<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<div id='socios_interno'>
<table  cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:200px;">Nome</td>
                        <td style="width:30px;">RG</td>
                        <td style="width:30px;">CPF</td>
                        <td style="width:30px;">Remover</td>                        
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$socios = mysql_query($t="SELECT * FROM  rh_empresa_has_socios ehs, cliente_fornecedor cf WHERE ehs.vkt_id='$vkt_id' AND ehs.empresa_id=cf.id AND ehs.empresa_id='$cliente_fornecedor->id'");
					$qtd_socios = mysql_num_rows($socios);
					//echo $t; 
					while($socio = @mysql_fetch_object($socios)){
						$dados_socio = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$socio->socio_id'"));
						if($_POST['acao2']=='socio'||$_GET[associa_socio]==1||$_GET[remove_socio]==1){
							$nome_socio = utf8_encode($dados_socio->razao_social);
							$rg_socio = utf8_encode($dados_socio->rg);
							$cpf_socio=utf8_encode($dados_socio->cnpj_cpf);
						}else{
							$nome_socio = $dados_socio->razao_social;
							$rg_socio = $dados_socio->rg;
							$cpf_socio= $dados_socio->cnpj_cpf;
						}
				 ?>
                 	<tr id_socio="<?=$dados_socio->id?>">
                        <td style="width:200px;" class="edita_socio"><?=$nome_socio?></td>
                        <td style="width:30px;"><?=$rg_socio?></td>
                        <td style="width:30px;"><?=$cpf_socio ?></td>
                        <td style="width:30px;"><img src='../fontes/img/menos.png' id='remove_socio'></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
  </table>
  <input type="hidden" name="qtd_socios" id="qtd_socios" value="<?=$qtd_socios?>"/>
  </div>