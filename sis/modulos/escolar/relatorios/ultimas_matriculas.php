<?
include("../../../_config.php");
include("../../../_functions_base.php");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Ultimas Matriculas</title>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 9px;
}
thead{color:#FFF}
table{border-right:1px solid #000; border-top:1px solid #000;}
td{ border-left:1px solid #000; border-bottom:1px solid #000;}
</style>
</head>

<body><table border="0" cellpadding="2" cellspacing="0">
<thead>
  <tr>
    <td bgcolor="#000000">&nbsp;</td>
    <td bgcolor="#000000"><strong>N&ordm;</strong></td>
    <td bgcolor="#000000"><strong>Responsavel</strong></td>
    <td bgcolor="#000000"><strong>CPF</strong></td>
    <td bgcolor="#000000"><strong>Aluno</strong></td>
    <td bgcolor="#000000"><strong>Idade</strong></td>
    <td bgcolor="#000000"><strong>Escola</strong></td>
    <td bgcolor="#000000"><strong>Curso</strong></td>
    <td bgcolor="#000000"><strong>Modulo</strong></td>
    <td bgcolor="#000000"><strong>Horario</strong></td>
    <td bgcolor="#000000"><strong>Valor</strong></td>
    <td bgcolor="#000000"><strong>Vencimento</strong></td>
    <td bgcolor="#000000"><strong>Pago</strong></td>
    <td bgcolor="#000000">DT Matricula</td>
  </tr>
  </thead>
  <?
  
  
  		  $periodo_atual =mysql_fetch_object(mysql_query($t="SELECT *
															FROM escolar_periodos AS p
															WHERE vkt_id = '7'
															AND (
															(
															date( now( ) )
															BETWEEN p.inicio_matricula
															AND p.fim_matricula
															)
															OR (
															date( now( ) )
															BETWEEN p.inicio_rematricula
															AND p.fim_rematricula
															)
															)
															ORDER BY id DESC
															LIMIT 1"));

  		$m  = mysql_query($t="SELECT * FROM escolar_matriculas WHERE periodo_id='$periodo_atual->id' and vkt_id='$vkt_id' ORDER BY id DESC");
		//echo $t;
		
		while($matricula=mysql_fetch_object($m)){
		$responsavel= mysql_fetch_object(mysql_query("SELECT * FROM  cliente_fornecedor WHERE id='$matricula->responsavel_id'"));
		$aluno		= mysql_fetch_object(mysql_query("SELECT *,
		(YEAR(CURDATE())-YEAR(a.data_nascimento))
		- (RIGHT(CURDATE(),5)< RIGHT(a.data_nascimento,5))
		AS idade FROM escolar_alunos as a WHERE a.id='$matricula->aluno_id'"));
		$unidade	= mysql_fetch_object(mysql_query("SELECT * FROM escolar_escolas WHERE id='$matricula->escola_id'"));
		$curso 		= mysql_fetch_object(mysql_query("SELECT * FROM escolar_cursos WHERE id='$matricula->curso_id'"));
		$modulo		= mysql_fetch_object(mysql_query("SELECT * FROM escolar_modulos WHERE id='$matricula->modulo_id'"));
		$horario	= mysql_fetch_object(mysql_query("SELECT * FROM escolar_horarios WHERE id='$matricula->horario_id'"));
		
		$quantidade_de_matriculas = mysql_fetch_object(mysql_query("SELECT count(*) as qtd FROM escolar_matriculas WHERE responsavel_id='$matricula->responsavel_id' AND periodo_id='$matricula->periodo_id'"));

		
$i++;
  
  ?>
  <tr>
    <td><?=$i?></td>
    <td><?=$matricula->id?></td>
    <td><?="$responsavel->id-$responsavel->razao_social".dataUsaToBr($responsavel->nascimento)?></td>
    <td><?=$responsavel->cnpj_cpf?></td>
    <td><?="$aluno->id-$aluno->nome($quantidade_de_matriculas->qtd)"?></td>
    <td><?=$aluno->idade?></td>
    <td><?=$unidade->nome?></td>
    <td><?=$curso->nome?></td>
    <td><?=$modulo->nome?></td>
    <td><?=$horario->nome?></td>
    <td><?=$matricula->valor?></td>
    <td><?=$matricula->data_vencimento?></td>
    <td><?=$matricula->pago?></td>
    <td><?=$matricula->data_criacao?></td>
  </tr>
  <?
		}
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>