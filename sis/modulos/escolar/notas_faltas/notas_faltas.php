<em></em><?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<script>
	$(document).ready(function(){
		$("#dados tr:nth-child(2n+1)").addClass('al');
		$("#notas:odd").addClass('al');
		//$("tr:odd").addClass('al');
	})
	

	$("#horario_id").live('change',function(){
		//alert($(this).val());
		location.href='?tela_id=<?=$_GET['tela_id']?>&horario_id='+$(this).val();
	});
</script>
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a><a href="#" class="navegacao_ativo">
<span></span>Notas e Faltas
</a>
</div>
<div id="barra_info">
<?
	if($_GET['horario_id']>0){
		$horario = mysql_fetch_object(mysql_query("SELECT * FROM escolar_horarios WHERE id=".$_GET['horario_id']));
		$escola = mysql_fetch_object(mysql_query("SELECT * FROM escolar_escolas WHERE id=$horario->escola_id"));
		$curso = mysql_fetch_object(mysql_query("SELECT * FROM escolar_cursos WHERE id=$horario->curso_id"));
		echo "<strong>Escola:</strong> ".$escola->nome." <strong>Curso:</strong> ".$curso->nome;
	}
?>
<label>
<select name="horario_id" id="horario_id" style="width:300px;">
<option value="">SELECIONE UM HORÁRIO</option> 
<?					
$s_periodo = (mysql_query(" SELECT * FROM escolar_periodos WHERE vkt_id='$vkt_id' ORDER BY inicio_aulas  "));
while($periodo=mysql_fetch_object($s_periodo)){
  echo "<option disabled='disabled' style='margin-left:0'>".$periodo->nome."</option>";
  $s_escola = (mysql_query($t="SELECT distinct(h.escola_id),e.nome FROM escolar_horarios as h, escolar_escolas as e WHERE h.escola_id =e.id AND h.periodo_id='$periodo->id'  AND h.vkt_id='$vkt_id' "));
  while($escola=mysql_fetch_object($s_escola)){
    echo "<option disabled='disabled' style='margin-left:10px'>".$escola->nome."</option>";
	$s_cursos = (mysql_query(" SELECT distinct(h.curso_id),c.nome FROM escolar_horarios as h, escolar_cursos as c WHERE h.curso_id=c.id  AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id'"));		
	while($curso=mysql_fetch_object($s_cursos)){
	  echo "<option disabled='disabled' style='margin-left:20px'>".$curso->nome."</option>";
	  $s_modulos =mysql_query($t =" SELECT distinct(h.modulo_id),m.nome FROM escolar_horarios as h, escolar_modulos  as m  WHERE  h.modulo_id=m.id AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id' AND h.curso_id='$curso->curso_id'");
	  while($modulos=mysql_fetch_object($s_modulos)){
		echo "<option disabled='disabled' style='margin-left:30px'>".$modulos->nome."</option>";
		$s_horario = mq($t=" SELECT * FROM escolar_horarios WHERE modulo_id = '$modulos->modulo_id' AND periodo_id='$periodo->id' AND curso_id='$curso->curso_id' AND escola_id='$escola->escola_id'");
		while($horarios=mf($s_horario)){
			if($horarios->id==$_GET['horario_id']){$select='selected=selected';}else{$select='';}
			echo "<option value=".$horarios->id." $select style='margin-left:40px'>".$horarios->nome."</option>";
		}
	  }
	}
  }
}
		
				/*
						while($horario=mysql_fetch_object($horarios)){
							print("<option value=".$horario->id." $select>".$horario->periodo." ".$horario->escola." ".$horario->curso." ".$horario->horario_inicio."-".$horario->horario_fim."</option>");
				}*/
					?>
                </select>
</label>

    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<?
	 //echo $t;
	 $avaliacoes = mysql_query("SELECT 
															*, ea.id as av_id 
														FROM 
															escolar_avaliacao ea,
															escolar_sala_materia_professor smp,
															escolar_salas es
														WHERE
															ea.sala_materia_professor_id=smp.id AND
															smp.sala_id=es.id AND
															es.horario_id='".$_GET['horario_id']."' AND
															ea.vkt_id = '$vkt_id' 
															ORDER BY ea.id
													");
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
   <td width="40">Codigo</td>
   <td width="200">Nome</td>
   <td width="400">Notas</td>
   <td width="80">Faltas</td>
   
   <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<?
if(!empty($_GET['horario_id'])){
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	
	if(strlen($_GET[busca])>0){
		$busca = "AND ea.nome like '%{$_GET[busca]}%'";
	}
	
	
	
	// necessario para paginacao
    $registros= @mysql_result(mysql_query($t="SELECT 
						*
						FROM
							escolar_matriculas
							
						WHERE
							pago='s' AND
							vkt_id='$vkt_id'
							$filtro"),0,0);
   //echo $t;
		
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT 
						*
						FROM
							escolar_matriculas
							
						WHERE
							pago='s' AND
							horario_id=".$_GET['horario_id']." AND
							vkt_id='$vkt_id'
							
						 ");
	
					
	$array_avaliacoes = array();
	$c=0;
	while($av = mysql_fetch_object($avaliacoes)){
		$array_avaliacoes[$c]=$av->av_id;
		$c++;
	}
	
	if(mysql_num_rows($q)>0){
	while($r=mysql_fetch_object($q)){
		$aluno = mysql_fetch_object(mysql_query($t="SELECT 
													*, ea.id as ea_id 
												FROM escolar_alunos ea, 
													escolar_matriculas em
												WHERE 
													ea.id=em.aluno_id AND
													em.id='$r->id' 
												"));
		
		
	
		$faltas = mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as faltas 
														FROM 
															escolar_frequencia_aula efa,
															escolar_matriculas em,
															escolar_aula ea,
															escolar_sala_materia_professor smp,
															escolar_salas es
														WHERE 
															efa.matricula_aluno_id = em.aluno_id AND
															efa.aula_id = ea.id AND
															ea.sala_materia_professor_id = smp.id AND
															smp.sala_id = es.id AND 
															efa.matricula_aluno_id=$aluno->ea_id AND
															es.horario_id='".$_GET['horario_id']."' AND
															em.id='$r->id'
															AND efa.presenca='0'
															"));
				
	?>
     
<tr <?=$sel?>onclick="window.open('<?=$caminho?>/form.php?aluno_id=<?=$aluno->ea_id?>&horario_id=<?=$_GET['horario_id']?>&mat_id=<?=$r->id?>','carregador')">
   <td width="40"><?=$aluno->id?></td>
   <td width="200"><?=$aluno->nome?></td>
   <td width="400">
   <?php
   		$tam=400; 
		foreach($array_avaliacoes as $id_av){
   				
				$nota = mysql_fetch_object(mysql_query("SELECT * FROM escolar_notas WHERE avaliacao_id='$id_av' and matricula_aluno_id='$aluno->ea_id'"));					
				
				if(!empty($nota)){
					echo MoedaUsaToBr($nota->nota)." | ";
				}else{
					echo "0,00 | ";
				}
				
		}
		
	?>
   </td>
   <td width="80"><?=$faltas->faltas?></td>
   <td></td>
</tr>
<?
	}
	}
	?>	
    </tbody>
</table>
<?
}
?>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
