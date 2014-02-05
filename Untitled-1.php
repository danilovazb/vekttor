<?
if(empty($_GET[mes])){
	$mes_b= date("m");
	$ano_b= date("Y");
}else{
	$mes_b= $_GET[mes];
	$ano_b= $_GET[ano];
}

$mes_s[$mes_b] = 'selected="selected"';
$ano_s[$ano_b] = 'selected="selected"';



?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<?
require("_function_atividade.php");
require("_ctrl_atividade.php");
//pr($_POST);
?>
<script>
</script>
<div id="some">&laquo;</div>
<div id='navegacao'>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
<a href="" class='s2'>
  	Projetos
</a>
<a href="" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">    
  <a href="<?=$tela->caminho?>form.php" target="carregador" class="mais"></a>
  <form method="get">
    Periodo
      <select name="mes" onchange="this.parentNode.submit()">
    	<option value="01"<?=$mes_s['01']?> >Janeiro</option>
    	<option value="02"<?=$mes_s['02']?> >Fevereiro</option>
    	<option value="03"<?=$mes_s['03']?> >Março</option>
    	<option value="04"<?=$mes_s['04']?> >Abril</option>
    	<option value="05"<?=$mes_s['05']?> >Maio</option>
    	<option value="06"<?=$mes_s['06']?> >Junho</option>
    	<option value="07"<?=$mes_s['07']?> >Julho</option>
    	<option value="08"<?=$mes_s['08']?> >Agosto</option>
    	<option value="09"<?=$mes_s['09']?> >Setembro</option>
    	<option value="10"<?=$mes_s['10']?> >Outubro</option>
    	<option value="11"<?=$mes_s['11']?> >Novembro</option>
    	<option value="12"<?=$mes_s['12']?> >Dezembro</option>
    </select>
      <select name="ano" onchange="this.parentNode.submit()">
      <?
      for($i=date("Y")-5;$i<date("Y")+1;$i++){
		echo "<option value='$i'".$ano_s[$i].">$i</option>";  
		}
	  ?>
    	
    </select>
    <input type="hidden" name="tela_id" value="90" />
    </form>
 
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Tipo","nome",1)?></td>
          	<td width="98" align="right">Horas no Mes</td>
          	<td></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	
	$q = mysql_query("SELECT * FROM projetos_atividades_tipos WHERE vkt_id='$vkt_id'");
	
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$total_no_mes=mysql_fetch_object(mysql_query($trace="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_finalizado_hora))),'%H') AS horas FROM projetos_atividades WHERE situacao='1' AND DATE_FORMAT(data_hora_fim,'%m')='$mes' AND DATE_FORMAT(data_hora_fim,'%Y')='$ano' AND atividade_tipo_id='{$r->id}' "));
		if($total_no_mes->horas==NULL){
			$total2='00:00';
		}else{
			$total2=$total_no_mes->horas;
		}
	?>      
    	<tr <?=$sel?> onclick="window.open('<?=$tela->caminho?>/form.php?id=<?=$r->id?>','carregador')" >
          	<td width="209"><?=$r->nome?></td>
          	<td width="98"align="right"><?=$total2?></td>
          	<td></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>


</div>
<div id='rodape'>
	
</div>