<?
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Vis&atilde;o geral de Matriculas</title>
<style>
	blockquote{margin-top:0; margin-bottom:0; margin-right:0; margin-left:15px; padding:0;}
	tbody td{ vertical-align:top; line-height:14px;}
	.cz{ color:#999999; cursor:default}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
table{ border-top:1px solid #000; border-right:1px solid #000;}
td{ border-left:1px solid #000; border-bottom:1px solid #000;}
</style>

</head>

<body>

<?

?>
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    	<tr>
    	  <td width="20">&nbsp;</td>
          <td width="230"><strong>Responsavel</strong></td>
          <td width="230"><strong>Aluno</strong></td>
          <td width="45"><strong>Idade</strong></td>
          <td width="75"><strong>Tipo</strong></td>
          <td width="90"><strong>Sala</strong></td>
          <td width="150"><strong>Horario</strong></td>
          <td width="100"><strong>Módulo</strong></td>
          <td width="150"><strong>Curso</strong></td>
          <td></td>
        </tr>
  <tbody>
    <?php 
		//echo $t;
		
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
      <td width="90"><?=$sala->nome;?>
        <!--<input size="3" type="text" onblur="xx(<?=$r->matricula_id?>,this)" value="<?=$sala->id?>" />--></td>
      <td width="150"><?
			if(strlen($horarios->nome)>0){
						 echo $horarios->nome; 
					 }else{
					 	echo converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." &agrave;s ".substr($horarios->horario_fim ,0,5); 
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


</body>
</html>