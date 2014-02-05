<?

// funçoes do modulo empreendimento

include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

</script>

<div id='conteudo'>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Escolar
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span>    Lista Alunos
</a>
</div>

<div id="barra_info">
  <select onchange="location='?tela_id=230&periodo=<?=$_GET[periodo]?>&sala=<?=$_GET[sala]?>&horario=<?=$_GET[horario]?>&pago='+this.value" style="margin-top:3px">
  <?
  $s[$_GET[pago]]='selected="selected"';
  ?>
  	<option value="S" <?=$s[S]?>>Pago</option>
  	<option value="N" <?=$s[N]?>>Não Pago</option>
  </select>
  <input type="button" value="Imprimir" style="float:right;margin-right:3px; margin-top:3px;" onclick="window.open('<?=$tela->caminho?>/alunos_lista_print.php<?
  
  $gt = array_keys($_GET);
  for($i=0;$i<count($gt);$i++){
	  if($i==0){$divisor='?';}else{$divisor='&';}
	  echo $divisor.$gt[$i].'='.$_GET[$gt[$i]];
  }
  
  ?>')"/>
  <?
  	if($_GET[pago]!='N'){
  ?>
  <input type="button" value="Gerar Boletins" style="float:right;margin-right:3px; margin-top:3px;" onclick="window.open('modulos/escolar/aluno/boletim_escolar.php?periodo=<?=$_GET[periodo]?>&escola=<?=$_GET[escola]?>&curso=<?=$_GET[curso]?>&modulo=<?=$_GET[modulo]?>&horario=<?=$_GET[horario]?>')"/>
  <?
	}
  ?>
</div>
<script>
	$(".oa").live("click",function(){
		var id = $(this).attr('id_aluno');
	
		window.open('modulos/escolar/alunos_inscritos/form.php?aluno_id='+id,'carregador');
	});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
    	  <td width="20">&nbsp;</td>
          <td width="230">Responsavel</td>
          <td width="230">Aluno</td>
          <td width="45">Idade</td>
          <td width="75">Tipo</td>
          <td width="90">Sala</td>
          <td width="150">Horario</td>
          <td width="100">Módulo</td>
          <td width="150">Curso</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>
resize();
function xx(id,t){
	window.open('<?=$tela->caminho?>/_updata_saala.php?muda_sala='+t.value+'&matricula_id='+id,'carregador')
}
</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		echo $t;
		
				while($r=mysql_fetch_object($_matricula)){
						 $aluno = @mysql_fetch_object(mysql_query($al=" SELECT *,(YEAR(CURDATE())- YEAR (a.data_nascimento)) - (RIGHT(CURDATE(),5)<RIGHT(a.data_nascimento,5)) AS age FROM escolar_alunos as a WHERE a.id = '$r->aluno_id' "));
						 $responsavel = @mysql_fetch_object(mysql_query($al=" SELECT * FROM cliente_fornecedor WHERE id = '$r->responsavel_id' "));
						 $sala = mysql_fetch_object(mysql_query($sa=" SELECT * FROM escolar_salas WHERE id = '$r->sala_id' "));
						 $horarios = mysql_fetch_object(mysql_query($h=" SELECT * FROM escolar_horarios WHERE id = '$r->horario_id'"));
						 $modulos = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_modulos WHERE id = '$r->modulo_id'"));
						 $curso = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_cursos WHERE id = '$r->curso_id'"));
						 
					
						$l++;
		
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" >
    	  <td width="20"><?=$l?></td>
          <td width="230"><?=$r->id.' '.$responsavel->nome_fantasia ;?></td>
          <td width="230" class="oa" id_aluno='<?=$aluno->id?>' ><?=$aluno->nome;?></td>
          <td width="45"><?=$aluno->age;?></td>
          <td width="75"><?=$r->tipo_matricula?></td>
          <td width="90"><?=$sala->nome;?><!--<input size="3" type="text" onblur="xx(<?=$r->matricula_id?>,this)" value="<?=$sala->id?>" /> --></td>
          <td width="150"><?
			if(strlen($horarios->nome)>0){
						 echo $horarios->nome; 
					 }else{
					 	echo converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." às ".substr($horarios->horario_fim ,0,5); 
					 }
			?></td>
          <td width="100"><?=$modulos->nome?></td>
          <td width="150"><?=$curso->nome?></td>

          <td></td>
        </tr>
<?php
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

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="300"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
