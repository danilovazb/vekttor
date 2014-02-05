<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include ("_functions.php");
include('_ctrl_sala.php');
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s1'>
    Escolar 
</a>
<a href="?tela_id=211" class='s2'>
    Salas
</a>
<a href="?tela_id=227" class="navegacao_ativo">
<span></span>Alunos 
</a>
</div>
<div id="barra_info">
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">Codigo</td>
            <td width="230"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
          	<td width="130"><?=linkOrdem("CPF","cnpj_cpf",0)?></td>
          	<td width="110"><?=linkOrdem("Dt de Nascimento","Data de Nascimento",0)?></td>
          	<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	// necessario para paginacao
$alunos=mysql_query($t="SELECT em.id as matricula,ea.*
						FROM 
						escolar_matriculas em,
						escolar_alunos ea
						WHERE 
							em.aluno_id = ea.id
						AND 
							em.sala_id='$sala_id'");
	if(mysql_num_rows($alunos)>0){
    $registros= mysql_result(mysql_query($t="SELECT em.*,ea.nome,ea.cpf,ea.data_nascimento
						FROM 
						escolar_matriculas em,
						escolar_alunos ea
						WHERE 
							em.aluno_id = ea.id
						AND 
							em.sala_id='$sala_id'"),0,0);
	}						//echo $t;
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome_fantasia";
	}
	while($aluno=mysql_fetch_object($alunos)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form_alunos.php?mat_id=<?=$aluno->matricula?>&sala_id=<?=$_GET['sala_id']?>','carregador')">
<td width="50" align="right"><?=str_pad($aluno->id,5,"0",STR_PAD_LEFT)?></td>
<td width="230"><?=$aluno->nome?></td>
<td width="130"><?=$aluno->cpf?></td>
<td width="110"><?=$aluno->data_nascimento?></td>
<td></td>
</tr>
<?
	}
	?>	
    </tbody>
</table>
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
<div id='rodape'></div>
