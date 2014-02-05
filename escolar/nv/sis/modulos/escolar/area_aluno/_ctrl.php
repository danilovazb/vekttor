<?php
$aluno_id=$_SESSION['aluno']->id;
$aluno=selecionaAluno($aluno_id,$_GET['matricula']);
$notas=selecionaNota($aluno_id);
$mat=selecionaMatriculas($_SESSION['aluno']->id);
?>