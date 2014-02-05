<?
include("_functions.php");
include("_ctrl.php");
$usuario_id = $_GET["id"];

$professor = mysql_fetch_object(mysql_query($yu=" SELECT *, p.id as professor_id FROM escolar2_professores as p, rh_funcionario as f WHERE p.usuario_id = '$usuario_id' AND p.funcionario_id=f.id"));


if(!$_GET[data_referencia]){
	$data_inicio = date("Y-m-d");
}else{
	$data_inicio = $_GET[data_referencia];
}
$dia_semana_depois =  mysql_result(mysql_query($t="SELECT DATE_ADD('$data_inicio', INTERVAL 7 DAY)"),0,0);
$dia_semana_antes =  mysql_result(mysql_query($t="SELECT DATE_ADD('$data_inicio', INTERVAL -7 DAY)"),0,0);

?>

<style>
tbody tr:nth-child(even){ background:#F1F5FA;}
#tabela_dados tbody tr:hover td{background:none; color:#000; text-align:center; }
#tabela_dados .divisor:hover{background:url(../fontes/img/bb.jpg) #000; color:#000}
#tabela_dados tbody tr td{ text-align:center; padding:4px; }
#tabela_dados tbody tr td:hover{background:#F4F4F4;  }
#tabela_dados .divisor:hover{background:url(../fontes/img/bb.jpg) #000; color:#000;text-align:left}
#tabela_dados tbody .divisor{background:url(../fontes/img/bb.jpg) #000; padding:0; text-align:left}

div.turma{
	padding:5px 20px;	
}
.content-turmas-header{
	font-size:12px; color:#666; font-weight:800;	
	padding:5px;
}
.content-turmas{ 
	max-height:200px; 
	overflow:auto;
}
.body-turmas{ 
	background:#FFFFFF; 
	padding:3px;
}
.body-turmas:nth-child(even){ 
	background:#F1F5FA;
}
.frequencia{
	display:inline-block; 
	text-decoration:none; 
	padding:4px 6px 4px; font-size:11px;  font-weight:bold;  color:#fff;  text-shadow:0 -1px 0 rgba(0,0,0,0.25);  vertical-align:baseline;  width:115px;  
	text-align:center;
	border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;
}
.realizada{
	background-color:#b94a48;
	display:inline-block;text-decoration:none; 
	padding:4px 6px 4px; font-size:11px;  
	font-weight:bold;  color:#fff;  
	text-shadow:0 -1px 0 rgba(0,0,0,0.25);  vertical-align:baseline;  width:115px;  text-align:center;
	border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;
}

.lancar{background-color:#468847;}

</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>


</script>
<div id='conteudo'>
<div id='navegacao'>
 <div id="some">«</div>
<a href="?tela_id=231" class='s1'>
  	Inicio
</a>
<a href="#" class='s2'>
    Educcare 
</a>
<a href="?tela_id=<?=$tela->id?>" class="navegacao_ativo">
<span></span> Professores Horários </a>
</div>

<div id="barra_info">
	<button onclick="location.href='<?=$_SESSION["url_voltar"]?>'">&laquo; Voltar </button> 
	<input type="hidden" name="professor_id" id="professor_id" value="<?=$professor->professor_id?>"> 
  Professor: <strong><?=$professor->nome;?></strong>

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
        	<?
		  for($i=0;$i<7;$i++){  
			$semana_incio = mysql_result(mysql_query("SELECT DATE_FORMAT('$data_inicio','%w')"),0,0);
			if($semana_incio!=0){
				$adiciona =	$i-$semana_incio;
			}else{
				$adiciona =	$i;
			}

			$dia_hoje = mysql_result(mysql_query($t="SELECT DATE_ADD('$data_inicio', INTERVAL $adiciona DAY)"),0,0);
			$data_hoje = mysql_result(mysql_query($t="SELECT date_format('$dia_hoje', '%d/%m/%Y')"),0,0);
			$dia_semana = mysql_result(mysql_query("SELECT DATE_FORMAT('$dia_hoje','%w')"),0,0);
			?>
           <td width="140" style="padding:0 4px 0 4px;" >&nbsp;&nbsp;<?=$semana_abreviado[$dia_semana];?></td>
           <?
           }
		   ?>
           <td ></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
<?
$q = mysql_query("SELECT * FROM escolar2_horarios WHERE vkt_id='$vkt_id'");
while($h=mysql_fetch_object($q)){
?>
	<tr><td colspan="8" class='divisor'>  &nbsp;
    &nbsp;<strong><?=$h->nome?></strong></td></tr>
<?
$maximo_de_horarios_no_dia = mysql_fetch_object(mysql_query($t="
		SELECT  
			max(materias_por_dia) AS s 
		FROM  
			escolar2_professor_has_horario_dia as d,
			escolar2_turmas as t,
			escolar2_series as s
		WHERE 
			d.vkt_id='$vkt_id'
			AND d.professor_id='$professor->professor_id'
			AND d.turma_id = t.id
			AND t.serie_id = s.id
			AND d.horario_id='$h->id'
		"));

for($l=0;$l<$maximo_de_horarios_no_dia->s;$l++){
	
?>
   <tr>
<?
		  for($i=0;$i<7;$i++){  
			$semana_incio = mysql_result(mysql_query("SELECT DATE_FORMAT('$data_inicio','%w')"),0,0);
			if($semana_incio!=0){
				$adiciona =	$i-$semana_incio;
			}else{
				$adiciona =	$i;
			}

			$dia_hoje = mysql_result(mysql_query($t="SELECT DATE_ADD('$data_inicio', INTERVAL $adiciona DAY)"),0,0);// DATA YYYY-MM-DD
			$data_hoje = mysql_result(mysql_query($t="SELECT date_format('$dia_hoje', '%d/%m/%Y')"),0,0);// DATA DDD/MM/YY
			$dia_semana = mysql_result(mysql_query("SELECT DATE_FORMAT('$dia_hoje','%w')"),0,0);
			$r =  mysql_fetch_object(mysql_query($t="

	SELECT 
		d.*,
		t.nome as turma,
		t.id   as turma_id,
		h.nome as horario,
		ma.nome as materia,
		m.id   as serie_has_materia_id,
		s.nome as sala
	 FROM  
		escolar2_professor_has_horario_dia as d,
		escolar2_turmas as t,
		escolar2_horarios as h,
		escolar2_serie_has_materias as m,
		escolar2_materias as ma,
		escolar2_salas as s
	 WHERE 
			 d.vkt_id='$vkt_id'
		AND d.dia_semana='$dia_semana'
		AND d.horario_id='$h->id'
		AND d.tempo='$l'
		AND d.professor_id='$professor->professor_id'
		AND d.turma_id=t.id
		AND	d.horario_id=h.id
		AND d.serie_has_materia_id=m.id
		AND m.materia_id=ma.id
		AND t.sala_id=s.id
		"));
		
		$aula_aqui = "";
		if( !empty($r->turma_id) and !empty($r->serie_has_materia_id) ){
		
		$sql_aula_professor = mysql_fetch_object( mysql_query($ty=" 
			
			SELECT 		
				professor_turma.id AS professor_turma_id,
				professor_aula_dia.dia_semana   AS dia_semana,
				aula.id AS aula_id,
				aula.status AS status_aula
				
			FROM 
					escolar2_professor_has_turma       AS professor_turma,
					escolar2_professor_has_horario_dia AS professor_aula_dia,
					escolar2_aula AS aula
				 
			WHERE  
				professor_turma.vkt_id       = '$vkt_id'
			AND
				aula.professor_as_turma_id = professor_turma.id
			
			AND
				professor_turma.professor_id         = professor_aula_dia.professor_id
			AND
				professor_turma.turma_id             = professor_aula_dia.turma_id
			AND 
				professor_turma.serie_has_materia_id = professor_aula_dia.serie_has_materia_id
				
			
			
			AND 
				professor_turma.professor_id = '$professor->professor_id'
			AND 
				professor_turma.turma_id     = '$r->turma_id'
			AND 
				professor_turma.serie_has_materia_id         = '$r->serie_has_materia_id'
			AND
				professor_aula_dia.dia_semana = '$i'
			AND
				aula.data = '$dia_hoje'
		"));
		
		
		}

			  if($r->id>0){
				  $tx  = "<strong>$r->materia</strong><br>$r->turma - $r->sala";
			  }else{
				  $tx  ='';	
			  }
			  	$background = "";
			  	if( (!empty($sql_aula_professor->professor_turma_id)) and ($sql_aula_professor->status_aula == 2) ){
					$background = 'style="background:#B6DBB5;"';
				}
				
				if( !empty($sql_aula_professor->professor_turma_id) and $sql_aula_professor->status_aula == 1){
					$background = 'style="background:#FBCFA4; "';
				}   
			?>

               <td width="140"  class="nova_aula" turma="<?=$r->turma_id?>" materia="<?=$r->serie_has_materia_id?>" data="<?=$dia_hoje?>" > 
               	<a id="<?=$sql_aula_professor->aula_id?>"><?=$tx?></a>  
               </td>
<?
		  }
		  
		 
?>
            <td></td></tr>
<?

}

}
?>
    </tbody>
</table>


</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td>&nbsp;</td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
</div>
