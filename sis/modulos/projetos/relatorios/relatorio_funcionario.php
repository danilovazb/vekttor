<?
function 

?><link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=91" class='s1'>
  	Projetos
</a>
<a href="?" class='s2'>
  	Relatórios
</a>
<a href="?tela_id=92" class='navegacao_ativo'>
<span></span>    Relatório de Funcionários
</a>
</div>

<div id="barra_info">
<form method="get">
<input type="hidden" name="tela_id" value="95" />
<!-- select na tabela projetos -->
<select name="projeto_id" id='projeto_id' onchange="this.parentNode.submit()">
<option value="0">Todos os Projetos</option>
<?php 
	$sql = mysql_query("SELECT * FROM projetos ");
	
		while($p=mysql_fetch_object($sql)){
		if($_GET['projeto_id']==$p->id){$projeto_sel='selected="selected"';}else{$projeto_sel='';}
?>
	<option <?=$projeto_sel?> value="<?php echo $p->id;?>"><?php echo $p->nome;?></option>
<?php 	}?>
</select>

</form>
</div>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="150"><?=linkOrdem("Colaborador","nome",1)?></td>
          <td width="90">Estimado total</td>
          <td width="90">Estimado feito</td>
          <td width="70">Concluído</td>
          <td width="80">Saldo</td>
          <td width="80">Pendente</td>
          
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	//$q = mysql_query($trace="SELECT * FROM projetos_atividades WHERE vkt_id='$vkt_id' $filtro_projeto $filtro_funcionario $filtro_tipo_atividade ");
	
	$funcionarios_q=mysql_query("SELECT * FROM usuario");
	
	while($funcionario=mysql_fetch_object($funcionarios_q)){	
		$total++;
		
		$estimado=mysql_fetch_object(mysql_query($trace="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_estimado_horas))),'%H:%i') AS horas FROM projetos_atividades WHERE funcionario_id='{$funcionario->id}' $filtro_projeto "));
		if($estimado->horas==NULL){$estimado2='00:00';}else{$estimado2=$estimado->horas;}
		$estimado_feito=mysql_fetch_object(mysql_query($trace="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_estimado_horas))),'%H:%i') AS horas FROM projetos_atividades WHERE funcionario_id='{$funcionario->id}' $filtro_projeto AND situacao='1'"));
		if($estimado_feito->horas==NULL){$estimado_feito2='00:00';}else{$estimado_feito2=$estimado_feito->horas;}
		$finalizado=mysql_fetch_object(mysql_query($trace="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_finalizado_hora))),'%H:%i') AS horas FROM projetos_atividades WHERE funcionario_id='{$funcionario->id}' AND situacao='1' $filtro_projeto "));
		if($finalizado->horas==NULL){$finalizado2='00:00';}else{$finalizado2=$finalizado->horas;}
		
		$saldo=mysql_fetch_object(mysql_query($trace="SELECT TIME_FORMAT(SEC_TO_TIME( SUM(TIME_TO_SEC('{$estimado_feito2}')) - SUM(TIME_TO_SEC('{$finalizado2}')) ),'%H:%i') as horas "));
		
		$pendente=mysql_fetch_object(mysql_query($trace="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_estimado_horas))),'%H:%i') AS horas FROM projetos_atividades WHERE funcionario_id='{$funcionario->id}' AND situacao='0' $filtro_projeto "));
		if($pendente->horas==NULL){$pendente2='00:00';}else{$pendente2=$pendente->horas;}
		
		
		
		
		echo mysql_error();
		if($total%2){$sel='class="al"';}else{$sel='';}
		//echo $trace.'<p></p>';
	?>
            <tr <?=$sel?> id="<?=$r->id?>">
              <td width="150"><?=$funcionario->nome?></td>
              <td width="90"><?=$estimado2?></td>
              <td width="90"><?=$estimado_feito2?></td>
              <td width="70"><?=$finalizado2?></td>
              <td width="80"><?=$saldo->horas?></td>
              <td width="80"><?=$pendente2?></td>
              <td></td>
            </tr>
	<?
	}
	?>
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>



</div>

<div id='rodape'>
	
</div>
