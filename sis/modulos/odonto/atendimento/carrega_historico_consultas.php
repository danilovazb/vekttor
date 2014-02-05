<?
include('../../../_config.php');
include('../../../_functions_base.php');
include("_functions.php");
include("_ctrl.php");
$atendimento_id=$_GET['atendimento_id'];
$procedimento_id=$_GET['procedimento_id'];
?>

<table cellpadding="0" cellspacing="0" width="100%" style="background:white;">
 <thead>
    <tr>
        <td style="width:45px;">Data</td>
        <td style="width:150px;">Servi&ccedil;o</td> 
        <td style="width:100px;">Dente | face</td> 
        <td style="width:210px;">Obs</td> 
    </tr>
 </thead>
 <tbody>
 <?php
 	$data='';
    $consultas_q = mysql_query($t="SELECT * FROM odontologo_consultas WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento_id' ORDER BY data DESC ");
    //echo $t;
	while($consulta = mysql_fetch_object($consultas_q)){
		//if(dataUsaToBr($consulta->data)!=$data){
			?>
                <tr style="background:#999; color:white;">
                    <td><?=dataUsaToBr($consulta->data)?></td><td></td><td></td><td><?=$consulta->obs?></td>
                </tr>
                
			<?
	//		$data=dataUsaToBr($consulta->data);
//		}
 ?>
    <? 
    $itens_q=mysql_query($b="
        SELECT 
            oci.obs as obs, s.nome as servico, oi.dente_id, oi.face_id
        FROM
            odontologo_consulta_has_odontologo_atendimento_item as oci,
            odontologo_atendimento_item as oi,
            servico as s
        WHERE 
            oci.odontologo_consulta_id='$consulta->id'
        AND
            oci.odontologo_atendimento_item_id=oi.id
        AND
            oi.servico_id=s.id
		");
			if(mysql_num_rows($itens_q)>0){
			
            while($item=mysql_fetch_object($itens_q)){
				$i++; if($i%2){$f="class='al'";}else{$f='';}
    ?>
    <tr <?=$f?>>
        <td style="width:45px;"></td>
        <td style="width:150px;"><?=utf8_encode($item->servico)?></td>
        <td style="width:100px;"><?=$item->dente_id?> | <?=$face[$item->face_id]?></td> 
        <td style="width:210px;" align="left"><?=utf8_encode($item->obs)?></td>          
    </tr>
  <?php
            }
		}else{
			?>
            <tr>
            	<td colspan="4">(Nao h&aacute; procedimentos para esta data)</td>
            </tr>
			<?
		}
    }
  ?>
 </tbody>
 <tfoot>
 <tr><td colspan="4">&nbsp;</td></tr>
 </tfoot>
</table>
