<?
require '../../../_config.php';
include '../../../_functions_base.php';

		$contrato_id=$_GET[contrato_id];
		$filtro_inicio 	= $_GET[filtro_inicio];
		$filtro_fim		= $_GET[filtro_fim];
	
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
		++$total_dias;
		echo $total_dias;
	?>
<style type="text/css">
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
}
pre{ display:none}
</style>


<div id="retorno">

  <div  style="padding:10px 0px 10px 0px "><strong>Período:</strong> <?=dataUsaToBr($filtro_inicio)?> - <?=dataUsaToBr($filtro_fim)?> <br />
                <strong>Unidade: </strong>Central <strong>Pedido: </strong>075000</div>
       
	<table   border="1" cellpadding="1" cellspacing="0" bordercolor="#000000" width="<?=300+(($total_dias+1)*120)?>">
   	  <thead>
      	 <tr>
        	<td width='100' ><strong style="padding-left:10px;">Data</strong></td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $dia_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%d') "),0,0);
				 $dia_numero=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%w') "),0,0);
			 ?>
            <td width='150' ><strong style="padding-left:5px;"><?=$semana_abreviado[$dia_numero]?>,<?=$dia_oficial?></strong></td>
            <?
			 }
			?>
         
		</tr>
        <tr>
            <td width='100'>Café</td>
            <? 
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width='150'><span></span><? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='cafe' ");
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?> 
            </td>
            <?
			 }
			?>
        </tr>
        <tr>
        	<td width='100'>Almoço</td>
            <? 
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width='150'><span></span>
            <? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='almoco' ");
				//echo $t;
				//echo mysql_error();
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
            </td>
            <?
			 }
			?>
        </tr>
        <tr>
        	<td width='100'>Lanche</td>
            <?
			 for($i=0;$i<$total_dias;$i++){
			$data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width='150'><span></span>
            <? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='lanche' ");
				//echo $t;
				//echo mysql_error();
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
            </td>
            <?
			 }
			?>
        </tr>
        <tr>
        	<td >Jantar</td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width='150'><span></span>
            <? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='janta' ");
				//echo $t;
				//echo mysql_error();
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
            </td>
            <?
			 }
			?>
            </tr>
                    
            <tr>
        	<td >Seia</td>
            <?
			 for($i=0;$i<$total_dias;$i++){
				 $data_oficial=mysql_result(mysql_query("SELECT DATE_FORMAT(DATE_ADD('$filtro_inicio', INTERVAL $i DAY),'%Y-%m-%d') "),0,0);
			?>
            <td width='150'><span></span>
            <? 
				$fichas_q = mysql_query($t="
				SELECT f.nome as ficha, c.pessoas as pessoas
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f 
				WHERE 
				contrato_id='$contrato_id' 
				AND data='$data_oficial' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='seia' ");
				//echo $t;
				//echo mysql_error();
				while($ficha=mysql_fetch_object($fichas_q)){
					echo "<span style='display:block;'>{$ficha->pessoas} - {$ficha->ficha}</span>";
				}
				?>
            </td>
            <?
			 }
			?>
                    </tr>
      </thead>
      <tbody>  
      </tbody>
      <tfoot>
      
      </tfoot>
</table>

</div>
<br /><br /><br />
<div style="page-break-before: always;"> </div>

