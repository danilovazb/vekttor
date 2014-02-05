<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
	
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
	$("#nota_aluno").live('blur',function(){
		
				var avaliacao_id = $("#avaliacao").val();
				var nota         = $(this).val();
				var matricula    = $(this).attr('matricula');
				//alert(matricula);
				var dados = 'avaliacao='+avaliacao_id+'&nota='+nota+'&matricula='+matricula;
				$.ajax({
						url: 'modulos/escolar/area_professor/avaliacao/recebe_nota_aluno.php?acao=cadNota',
						type: 'POST',
						data: dados,
						success: function(data){
							$("#result").html(data);
						}							
				})
	})
</script>
<div id='conteudo'>
<div id='navegacao'>

<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>

<a href="?tela_id=249" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s2'>
    Escolar 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Nota
</a>
</div>
<div id="barra_info">
    <!--<a href="<?$caminho?>/form.php" target="carregador" class="mais"></a>-->
	<span><button type="button" onclick="location.href='?tela_id=270&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$sala?>'">&laquo;</button></span> <span><strong><?=$_GET['descricao']?></strong></span>
</div>
<!--<div id="result"></div>-->
<input type="hidden" name="avaliacao" id="avaliacao" value="<?=$avaliacao?>">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	 <tr>
               <td width="60">Matricula</td>
               <td width="200">Aluno</td>
               <td width="75">Nota</td>
               <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	<?
			$sql_escola = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_escolas WHERE vkt_id = '$vkt_id'"));
 			$media_instituicao = $sql_escola->media;
			
        	$alunos_recuperacao = mysql_query($rec=" SELECT * FROM escolar_media_final AS emf
          								JOIN escolar_alunos AS ea ON emf.aluno_id=ea.id
											WHERE emf.media_final < '$media_instituicao' AND emf.sala_materia_professor_id = '$sala_materia->id' ");
			
			while($aluno=mysql_fetch_object($alunos_recuperacao)){
				
					//$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '$aluno->aluno_id'"));
					$sql_avaliacao = mysql_fetch_object(mysql_query("SELECT * FROM escolar_notas WHERE avaliacao_id = '$avaliacao' AND matricula_aluno_id = '$aluno->aluno_id'"));
		?>
	    	<tr>
               <td width="60"><?=$aluno->aluno_id?></td>
               <td width="200"><?=$aluno->nome?></td>
   			   <td width="75"><input type="text" matricula="<?=$aluno->aluno_id?>"  sonumero='1' decimal="1"   name="nota_aluno" id="nota_aluno" value="<?=$sql_avaliacao->nota?>" style="width:50px; height:13px;"/></td>
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
<div id='rodape'>
	<?=$registros?> Registros 
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
