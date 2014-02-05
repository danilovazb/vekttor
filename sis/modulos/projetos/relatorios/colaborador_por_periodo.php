<?

require "modulos/projetos/atividades/colaborador/_function_colaborador_geral.php";
function z($n){
	if($n<10){
		$n = '0'.$n;
	}
	return $n;
}
function tts($time){
	return mysql_result(mysql_query("SELECT TIME_TO_SEC('$time')"),0,0);
}
function stt($time){
	return substr(mysql_result(mysql_query("SELECT SEC_TO_TIME('$time')"),0,0),0,-3);
}

$semana_l = array("Dom","Seg","Tet","Qua","Qui","Sex","Sab") ;
?>
<style>
#dados td{margin:0; padding:0;}
#dados td{text-align:center;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
<a href="?" class='s1'>
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
<?
  if(empty($_GET[inicio])){
			$inicio = date("Y-m-01");
			$fim=date("Y-m-t");
		  }
			$inicio = "2012-04-25";
			$fim	= "2012-05-05	";
		  
		  $dias = mysql_result(mysql_query($t="select datediff('$fim','$inicio')"),0,0)+1;
	$tamanho_tabela = 150+(40*$dias)+80;
?>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" >
<thead>
    	<tr>
          <td > Período <?=dataUsaToBr($inicio)?> a <?=dataUsaToBr($fim)?></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->

<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" >
<thead>
    	<tr>
          <td width="150">Colaborador</td>
          <?
		
          for($d=1;$d<=$dias;$d++){
			  $dd=$d-1;
			  $sinfo = mysql_result(mysql_query("SELECT date_format(DATE_ADD('$inicio', interval $dd day),'%w')"),0,0);
			  $dinfo = mysql_result(mysql_query("SELECT date_format(DATE_ADD('$inicio', interval $dd day),'%d')"),0,0);
			  
			  
		  ?>
          <td width="40" style="font-size:9px;"><?=$semana_l[$sinfo].' '. $dinfo?></td>
          <?
		  }
		  ?>
          <td>Total</td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" id="tabela_dados" >
    <tbody>
	<?php 
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	//$q = mysql_query($trace="SELECT * FROM projetos_atividades WHERE vkt_id='$vkt_id' $filtro_projeto $filtro_funcionario $filtro_tipo_atividade ");
	
	$funcionarios_q=mysql_query("SELECT * FROM usuario WHERE id in(5,7,9,15,32)");
	
	while($funcionario=mysql_fetch_object($funcionarios_q)){	
		$total++;
		
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		
	?>
        <tr <?=$sel?> id="<?=$r->id?>">
              <td width="150" style="text-align:right;"><?=$funcionario->id.$funcionario->nome?></td>
              
          <?
		
          for($d=1;$d<=$dias;$d++){
			  
			  $dd = $d-1;
			  
			  $dia_info = mysql_result(mysql_query("SELECT DATE_ADD('$inicio', interval $dd day)"),0,0);

			  $time = soma_horas_dia_concluidas($dia_info,$funcionario->id);
			  $s 						=tts($time);
			  $sec[$dia_info][] 		=  $s;
			  $secd[$funcionario->id][] =  $s;

		  ?>
          <td width="40"><?=$time?></td>
          <?
		  }
		  ?>
          <td><?=stt($total_colaborador[$funcionario->id][]=array_sum( $secd[$funcionario->id]));?></td>
        </tr>
	<?
	}
	?>
    </tbody>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" >
<thead>
    	<tr>
          <td width="150">Total</td>
          <?
		
          for($d=1;$d<=$dias;$d++){
			  $dd=$d-1;
			  $dinfo = mysql_result(mysql_query("SELECT DATE_ADD('$inicio', interval $dd day)"),0,0);
			  
			  
		  ?>
          <td width="40" style="font-size:9px;"><?=stt($total_tempo[]=array_sum( $sec[$dinfo]));?></td>
          <?
		  }
		  ?>
          <td><?=stt(array_sum($total_tempo));?></td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" >
<thead>
    	<tr>
          <td width="150">Atividades Concluidas</td>
          <?
		
          for($d=1;$d<=$dias;$d++){
			  $dd=$d-1;
			  $sinfo = mysql_result(mysql_query("SELECT date_format(DATE_ADD('$inicio', interval $dd day),'%w')"),0,0);
			  $dinfo = mysql_result(mysql_query("SELECT date_format(DATE_ADD('$inicio', interval $dd day),'%d')"),0,0);
			  
			  
		  ?>
          <td width="40" style="font-size:9px;">&nbsp;</td>
          <?
		  }
		  ?>
          <td>Total</td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" id="tabela_dados" >
    <tbody>
	<?php 
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	//$q = mysql_query($trace="SELECT * FROM projetos_atividades WHERE vkt_id='$vkt_id' $filtro_projeto $filtro_funcionario $filtro_tipo_atividade ");
	
	$funcionarios_q=mysql_query("SELECT * FROM usuario WHERE id in(5,7,9,15,32)");
	
			  $sec=array();
			  $secd=array();
	while($funcionario=mysql_fetch_object($funcionarios_q)){	
		$total++;
		
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		
	?>
        <tr <?=$sel?> id="<?=$r->id?>">
              <td width="150" style="text-align:right;"><?=$funcionario->id.$funcionario->nome?></td>
              
          <?
          for($d=1;$d<=$dias;$d++){
			  
			  $dd = $d-1;
			  
			  $dia_info = mysql_result(mysql_query("SELECT DATE_ADD('$inicio', interval $dd day)"),0,0);

			  $time = tempo_atividades_concluidas($dia_info,$funcionario->id);
			  $s 						=$time['segundos'];
			  $sec[$dia_info][] 		=  $s;
			  $secd[$funcionario->id][] =  $s;

		  ?>
          <td width="40"><?=$time[tempo]?></td>
          <?
		  }
		  ?>
          <td><?=stt(array_sum( $secd[$funcionario->id]));?></td>
        </tr>
	<?
	}
	?>
    </tbody>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" >
  <thead>
    <tr>
      <td width="150">Total</td>
      <?
		
          for($d=1;$d<=$dias;$d++){
			  $dd=$d-1;
			  $dinfo = mysql_result(mysql_query("SELECT DATE_ADD('$inicio', interval $dd day)"),0,0);
			  
			  
		  ?>
      <td width="40" style="font-size:9px;"><?=stt($totalatividade[]=array_sum($sec[$dinfo]));?></td>
      <?
		  }
		  ?>
      <td><?=stt(array_sum($totalatividade));?></td>
    </tr>
  </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" >
  <thead>
    	<tr>
          <td width="150">Slado de Atividades </td>
          <?
		
          for($d=1;$d<=$dias;$d++){
			  $dd=$d-1;
			  $sinfo = mysql_result(mysql_query("SELECT date_format(DATE_ADD('$inicio', interval $dd day),'%w')"),0,0);
			  $dinfo = mysql_result(mysql_query("SELECT date_format(DATE_ADD('$inicio', interval $dd day),'%d')"),0,0);
			  
			  
		  ?>
          <td width="40" style="font-size:9px;">&nbsp;</td>
          <?
		  }
		  ?>
          <td>Total</td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" id="tabela_dados" >
    <tbody>
	<?php
	
	$totalatividade =  array();
	
	
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	//$q = mysql_query($trace="SELECT * FROM projetos_atividades WHERE vkt_id='$vkt_id' $filtro_projeto $filtro_funcionario $filtro_tipo_atividade ");
	
	$funcionarios_q=mysql_query("SELECT * FROM usuario WHERE id in(5,7,9,15,32)");
	
			  $sec=array();
			  $secd=array();
	while($funcionario=mysql_fetch_object($funcionarios_q)){	
		$total++;
		
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		
	?>
        <tr <?=$sel?> id="<?=$r->id?>">
              <td width="150" style="text-align:right;"><?=$funcionario->id.$funcionario->nome?></td>
              
          <?
          for($d=1;$d<=$dias;$d++){
			  
			  $dd = $d-1;
			  
			  $dia_info = mysql_result(mysql_query("SELECT DATE_ADD('$inicio', interval $dd day)"),0,0);

			  $time = tempo_atividades_concluidas_saldo($dia_info,$funcionario->id);
			  $s 						=$time['segundos'];
			  $sec[$dia_info][] 		=  $s;
			  $secd[$funcionario->id][] =  $s;

		  ?>
          <td width="40"><?=$time[tempo]?></td>
          <?
		  }
		  ?>
          <td><?=stt($total_colaborador[$funcionario->id][]=array_sum( $secd[$funcionario->id]));?></td>
        </tr>
	<?
	}
	?>
    </tbody>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" >
<thead>
    	<tr>
          <td width="150">Total</td>
          <?
		
          for($d=1;$d<=$dias;$d++){
			  $dd=$d-1;
			  $dinfo = mysql_result(mysql_query("SELECT DATE_ADD('$inicio', interval $dd day)"),0,0);
			  
			  
		  ?>
          <td width="40" style="font-size:9px;"><?=stt($totalatividade[]=array_sum($sec[$dinfo]));?></td>
          <?
		  }
		  ?>
          <td><?=stt(array_sum($totalatividade));?></td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" id="tabela_dados" >
  <tbody>
	<?php 
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	//$q = mysql_query($trace="SELECT * FROM projetos_atividades WHERE vkt_id='$vkt_id' $filtro_projeto $filtro_funcionario $filtro_tipo_atividade ");
	
	$funcionarios_q=mysql_query("SELECT * FROM usuario WHERE id in(5,7,9,15,32)");
	
	while($funcionario=mysql_fetch_object($funcionarios_q)){	
		$total++;
		
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		
	?>
        <tr <?=$sel?> id="<?=$r->id?>">
              <td width="150" style="text-align:right;"><?=$funcionario->id.$funcionario->nome?></td>
              
          <?
			  $sec=array();
			  $secd=array();
          for($d=1;$d<=$dias;$d++){
			  
			  $dd = $d-1;
			  
			  $dia_info = mysql_result(mysql_query("SELECT DATE_ADD('$inicio', interval $dd day)"),0,0);


		  ?>
          <td width="40">&nbsp;</td>
          <?
		  }
		  ?>
          <td><?=stt(array_sum($total_colaborador[$funcionario->id]))?></td>
        </tr>
	<?
	}
	?>
    </tbody>
</table>
<table cellpadding="0" cellspacing="0" width="<?=$tamanho_tabela?>" >
<thead>
    	<tr>
          <td width="150">Total</td>
         
          <td  style="font-size:9px;">&nbsp;</td>
          <td width="60">&nbsp;</td>
        </tr>
    </thead>
</table>
</div>


</div>

<div id='rodape'>
	
</div>
