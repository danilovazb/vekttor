<?
include("../../../_config.php");
include("../../../_functions_base.php");

$periodo_id='23';

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Resumo de Matriculas</title>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
}
td{ border-bottom:1px solid #000; border-left:1px solid #000}
table{ border-top:1px solid #000; border-right:1px solid #000}
</style>
<script src="http://code.jquery.com/jquery-1.7.1.js"></script>

</head>

<body>

<div id="chart_div" style="width:900px"></div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});	  
    google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dia');
        data.addColumn('number', 'Pagos');
        data.addColumn('number', 'Matricula');
        data.addRows([
          <?
		  //print_r($info_grafico);
		 // $info = implode(",",$info_grafico);
		 // echo $info;
		 
		 $q=  mysql_query("SELECT date(data_criacao) as dt  FROM `escolar_matriculas` WHERE periodo_id='$periodo_id' group by date(data_criacao) ORDER BY dt  ASC");
		 
		  while($r=mysql_fetch_object($q)){
			$m = @mysql_result(mysql_query("SELECT COUNT(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND date(data_criacao) = '$r->dt' "),0,0);
			$p = @mysql_result(mysql_query("SELECT COUNT(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND date(data_criacao) = '$r->dt' AND pago='S' "),0,0);
			
			$ds = explode('-',$r->dt);
			
			
		  	echo "['".$ds[2].'/'.$ds[1]."',$p , $m],";
		  }
		
		  ?>
        ]);

        var options = {
          width: 900, 
		  height: 340,
          title: 'Matriculas por dia ',
          hAxis: {title: 'Dias/Matriculas', titleTextStyle: {color: 'red'}},
			strictFirstColumnType: true,
		  pointSize: 5,
       };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

    </script>

<div id="chart_pago" style="width:450px;float:left"></div>
<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartReligiao);
		function drawChartReligiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			['Pago',<?
			echo @mysql_result(mysql_query("SELECT count(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND pago ='S'"),0,0);
			?>],['Não Pago',<?
			echo @mysql_result(mysql_query("SELECT count(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND pago in ('N','C')"),0,0);
			?>]       
        ]);

        var options = {
          width: 450, height: 450,
          title: '% Pagos'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_pago'));
        chart.draw(data, options);
      	}
	  	</script>

<div id="chart_matriculas" style="width:450px; float:left"></div>
<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartReligiao);
		function drawChartReligiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			['Matriculas',<?
			echo @mysql_result(mysql_query("SELECT count(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND tipo_matricula ='MATRÍCULA'"),0,0);
			?>],['Rematricula',<?
			echo @mysql_result(mysql_query("SELECT count(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND tipo_matricula ='REMATRÍCULA'"),0,0);
			?>]       
        ]);

        var options = {
          width: 450, height: 450,
          title: 'Matriculas vs. Rematriculas Geral'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_matriculas'));
        chart.draw(data, options);
      	}
	  	</script>


<div id="chart_matriculas_pagas" style="width:450px; float:left"></div>
<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartReligiao);
		function drawChartReligiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			['Matriculas',<?
			echo @mysql_result(mysql_query("SELECT count(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND tipo_matricula ='MATRÍCULA' AND pago='S'"),0,0);
			?>],['Rematricula',<?
			echo @mysql_result(mysql_query("SELECT count(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND tipo_matricula ='REMATRÍCULA'  AND pago='S'"),0,0);
			?>]       
        ]);

        var options = {
          width: 450, height: 450,
          title: 'Matriculas vs. Rematriculas Pagos'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_matriculas_pagas'));
        chart.draw(data, options);
      	}
	  	</script>





<div style="width:100%; clear:both;"></div>
<strong> Total de Matriculas<br />
</strong>
<table cellpadding="2" cellspacing="0">
  <tr>
    <td><strong>Matricula</strong></td>
    <td><strong>Valor</strong></td>
    <td><strong>Alunos Novos</strong></td>
    <td><strong>Alunos do Periodo Passado</strong></td>
    <td><strong>Matriculas N&atilde;o Pagas</strong></td>
    <td><strong>Total</strong></td>
  </tr>
  <?
	  
	  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND pago='S'"),0,0);
	  $matriculas_n_p = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE periodo_id='$periodo_id' AND pago in ('C','N')"),0,0);
	  $valor = @mysql_result(mysql_query($t="SELECT sum(valor_pago) FROM escolar_matriculas WHERE  periodo_id='$periodo_id' AND pago in ('S')"),0,0);
	//  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id'"),0,0);
	//  echo $t;
	
	
	
	  $matriculas_r = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE  periodo_id='$periodo_id' AND pago='S' AND tipo_matricula ='REMATRÍCULA' "),0,0);
	  $matriculas_m = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE  periodo_id='$periodo_id' AND pago='S' AND tipo_matricula ='MATRÍCULA'"),0,0);
  ?>
  <tr>
    <td align="right"><?=number_format($matriculas,'0',',','.');?></td>
    <td align="right">R$
      <?=number_format($valor,'2',',','.');?></td>
    <td align="right"><?=number_format($matriculas_m,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_r,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p+$matriculas,'0',',','.');?></td>
  </tr>
</table>
<strong><br />
<br />
Por Escola<br />
</strong>
<table cellpadding="2" cellspacing="0">
  <tr>
    <td><strong>Escola</strong></td>
    <td><strong>Matricula</strong></td>
    <td><strong>Valor</strong></td>
    <td><strong>Alunos Novos</strong></td>
    <td><strong>Alunos do Periodo Passado</strong></td>
    <td><strong>Matriculas N&atilde;o Pagas</strong></td>
    <td><strong>Total</strong></td>
  </tr>
  <?
  
  
  
  		  $soma_matricula = 0;
		  $soma_matricula_n_p = 0;
		  $soma_valor = 0;

  $q= mysql_query("SELECT *
FROM `escolar_escolas`  WHERE vkt_id='$vkt_id'");
  
  while($r=mysql_fetch_object($q)){
	  
	  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id' AND pago='S'"),0,0);


	  
	  $matriculas_r = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id' AND pago='S' AND tipo_matricula ='REMATRÍCULA' "),0,0);
	  $matriculas_m = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id' AND pago='S' AND tipo_matricula ='MATRÍCULA'"),0,0);
	  
	  
	  
	  
	  
	  $matriculas_n_p = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id' AND pago in ('C','N')"),0,0);
	  $valor = @mysql_result(mysql_query($t="SELECT sum(valor_pago) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id' AND pago in ('S')"),0,0);
	//  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id'"),0,0);
	//  echo $t;
	  
	  if($matriculas>0){
		  $soma_matricula += $matriculas;
		  $soma_matricula_n_p += $matriculas_n_p;
		  $soma_valor += $valor;
		  $soma_matriculas_m += $matriculas_m;
		  $soma_matriculas_r += $matriculas_r;
  ?>
  <tr>
    <td><?=$r->nome?></td>
    <td align="right"><?=number_format($matriculas,'0',',','.');?></td>
    <td align="right">R$ <?=number_format($valor,'2',',','.');?></td>
    <td align="right"><?=number_format($matriculas_m,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_r,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p+$matriculas,'0',',','.');?></td>
  </tr>
  <?
	  }
  }
  ?>
  
  <tr>
    <td><strong>Total</strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>R$ 
      <?=number_format($soma_valor,'2',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matriculas_m,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matriculas_r,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula_n_p,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula_n_p+$soma_matricula,'0',',','.');?>
    </strong></td>
  </tr>
</table>
<strong><br />
Por M&oacute;dulo<br />
</strong>
<table cellpadding="2" cellspacing="0">
  <tr>
    <td><strong>Modulo</strong></td>
    <td><strong>Matricula</strong></td>
    <td><strong>Valor</strong></td>
    <td><strong>Alunos Novos</strong></td>
    <td><strong>Alunos do Periodo Passado</strong></td>
    <td><strong>Matriculas N&atilde;o Pagas</strong></td>
    <td><strong>Total</strong></td>
    </tr>
<?
  		  $soma_matricula = 0;
		  $soma_matricula_n_p = 0;
		  $soma_valor = 0;
		  $soma_matriculas_r=0;
		  $soma_matriculas_m=0;

  $q= mysql_query("SELECT *
FROM `escolar_modulos`  WHERE vkt_id='$vkt_id' ORDER BY curso_id, id");
  
  while($r=mysql_fetch_object($q)){
	  $curso = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_cursos WHERE id='$r->curso_id'"));
	 
	  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago='S'"),0,0);
	  
	  
	  
	  $matriculas_r = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago='S' AND tipo_matricula ='REMATRÍCULA' "),0,0);
	  $matriculas_m = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago='S' AND pago='S' AND tipo_matricula ='MATRÍCULA'"),0,0);
	  
	  
	  
	  $matriculas_n_p = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago in ('C','N')"),0,0);
	  $valor = @mysql_result(mysql_query($t="SELECT sum(valor_pago) FROM escolar_matriculas WHERE modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago in ('S')"),0,0);
	//  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id'"),0,0);
	//  echo $t;
	  
	  if($matriculas>0){
		  $soma_matricula += $matriculas;
		  $soma_matricula_n_p += $matriculas_n_p;
		  $soma_valor += $valor;
		  $soma_matriculas_m += $matriculas_m;
		  $soma_matriculas_r += $matriculas_r;
  ?>

  <tr>
    <td><?="<strong>$curso->nome -</strong> $r->nome"?></td>
    <td align="right"><?=number_format($matriculas,'0',',','.');?></td>
    <td align="right">R$ <?=number_format($valor,'2',',','.');?></td>
    <td align="right"><?=number_format($matriculas_m,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_r,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p+$matriculas,'0',',','.');?></td>
  </tr>
<?
	  }
  }
?>  <tr>
    <td><strong>Total</strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>R$ 
      <?=number_format($soma_valor,'2',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matriculas_m,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matriculas_r,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula_n_p,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula_n_p+$soma_matricula,'0',',','.');?>
    </strong></td>
  </tr>
</table>
<br />
<br />
<strong>Por M&oacute;dulo Por Escola</strong><br />
<?
  $q0= mysql_query("SELECT *
FROM `escolar_escolas`  WHERE vkt_id='$vkt_id'");
	
  while($r0=mysql_fetch_object($q0)){
	  echo "<br /><strong>$r0->nome</strong>";
?>

<br />
<table cellpadding="2" cellspacing="0">
  <tr>
    <td><strong>Modulo</strong></td>
    <td><strong>Matricula</strong></td>
    <td><strong>Valor</strong></td>
    <td><strong>Alunos Novos</strong></td>
    <td><strong>Alunos do Periodo Passado</strong></td>
    <td><strong>Matriculas N&atilde;o Pagas</strong></td>
    <td><strong>Total</strong></td>
  </tr>
  <?
  		  $soma_matricula = 0;
		  $soma_matricula_n_p = 0;
		  $soma_valor = 0;
		  $soma_matriculas_r=0;
		  $soma_matriculas_m=0;
  $q= mysql_query("SELECT *
FROM `escolar_modulos`  WHERE vkt_id='$vkt_id' ORDER BY curso_id, id");
  
  while($r=mysql_fetch_object($q)){
	  $curso = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_cursos WHERE id='$r->curso_id'"));
	 
	  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas 		WHERE escola_id='$r0->id' AND modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago='S'"),0,0);
	  
	  
	  
	  $matriculas_r = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas 		WHERE escola_id='$r0->id' AND modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago='S' AND tipo_matricula ='REMATRÍCULA' "),0,0);
	  $matriculas_m = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas 		WHERE escola_id='$r0->id' AND modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago='S' AND pago='S' AND tipo_matricula ='MATRÍCULA'"),0,0);
	  
	  
	  
	  $matriculas_n_p = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas 	WHERE escola_id='$r0->id' AND modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago in ('C','N')"),0,0);
	  $valor = @mysql_result(mysql_query($t="SELECT sum(valor_pago) FROM escolar_matriculas 	WHERE escola_id='$r0->id' AND modulo_id='$r->id' AND periodo_id='$periodo_id' AND pago in ('S')"),0,0);
	//  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id'"),0,0);
	//  echo $t;
	  
	  if($matriculas>0){
		  $soma_matricula += $matriculas;
		  $soma_matricula_n_p += $matriculas_n_p;
		  $soma_valor += $valor;
		  $soma_matriculas_m += $matriculas_m;
		  $soma_matriculas_r += $matriculas_r;
  ?>
  <tr>
    <td><?="<strong>$curso->nome -</strong> $r->nome"?></td>
    <td align="right"><?=number_format($matriculas,'0',',','.');?></td>
    <td align="right">R$
      <?=number_format($valor,'2',',','.');?></td>
    <td align="right"><?=number_format($matriculas_m,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_r,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p+$matriculas,'0',',','.');?></td>
  </tr>
  <?
	  }
  }
?>
  <tr>
    <td><strong>Total</strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>R$
      <?=number_format($soma_valor,'2',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matriculas_m,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matriculas_r,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula_n_p,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula_n_p+$soma_matricula,'0',',','.');?>
    </strong></td>
  </tr>
</table>

<?
  }
?>
<br />
<strong>Por Horario</strong><br />
<table cellpadding="2" cellspacing="0">
  <tr>
    <td><strong>Horario</strong></td>
    <td><strong>Matricula</strong></td>
    <td><strong>Valor</strong></td>
    <td><strong>Alunos Novos</strong></td>
    <td><strong>Alunos do Periodo Passado</strong></td>
    <td><strong>Matriculas N&atilde;o Pagas</strong></td>
    <td><strong>Total</strong></td>
  </tr>
  <?
  		  $soma_matricula = 0;
		  $soma_matricula_n_p = 0;
		  $soma_valor = 0;
		  $soma_matriculas_r=0;
		  $soma_matriculas_m=0;
  $q= mysql_query("SELECT *
FROM `escolar_horarios`  WHERE vkt_id='$vkt_id' ORDER BY escola_id,curso_id,modulo_id, horario_inicio");
  
  while($r=mysql_fetch_object($q)){
	  $curso = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_cursos WHERE id='$r->curso_id'"));
	  $escola = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_escolas WHERE id='$r->escola_id'"));
	  $modulo = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_modulos WHERE id='$r->modulo_id'"));
	 
	  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE horario_id='$r->id' AND periodo_id='$periodo_id' AND pago='S'"),0,0);


	  
	  
	  $matriculas_r = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE horario_id='$r->id' AND periodo_id='$periodo_id' AND pago='S' AND tipo_matricula ='REMATRÍCULA' "),0,0);
	  $matriculas_m = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE horario_id='$r->id' AND periodo_id='$periodo_id' AND pago='S' AND pago='S' AND tipo_matricula ='MATRÍCULA'"),0,0);
	  



	  $matriculas_n_p = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE horario_id='$r->id' AND periodo_id='$periodo_id' AND pago in ('C','N')"),0,0);
	  $valor = @mysql_result(mysql_query($t="SELECT sum(valor_pago) FROM escolar_matriculas WHERE horario_id='$r->id' AND periodo_id='$periodo_id' AND pago in ('S')"),0,0);
	//  $matriculas = @mysql_result(mysql_query($t="SELECT count(*) FROM escolar_matriculas WHERE escola_id='$r->id' AND periodo_id='$periodo_id'"),0,0);
	//  echo $t;
	  
	  if($matriculas>0){
		  $soma_matricula += $matriculas;
		  $soma_matricula_n_p += $matriculas_n_p;
		  $soma_valor += $valor;
		  $soma_matriculas_m += $matriculas_m;
		  $soma_matriculas_r += $matriculas_r;
  ?>
  <tr>
    <td><?="$escola->nome -<strong>$curso->nome</strong> - $modulo->nome - $r->nome"?></td>
    <td align="right"><?=number_format($matriculas,'0',',','.');?></td>
    <td align="right">R$
      <?=number_format($valor,'2',',','.');?></td>
    <td align="right"><?=number_format($matriculas_m,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_r,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p,'0',',','.');?></td>
    <td align="right"><?=number_format($matriculas_n_p+$matriculas,'0',',','.');?></td>
  </tr>
  <?
	  }
  }
?>
  <tr>
    <td><strong>Total</strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>R$
      <?=number_format($soma_valor,'2',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matriculas_m,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matriculas_r,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula_n_p,'0',',','.');?>
    </strong></td>
    <td align="right"><strong>
      <?=number_format($soma_matricula_n_p+$soma_matricula,'0',',','.');?>
    </strong></td>
  </tr>
</table>
</body>
</html>