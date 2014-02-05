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
});

$("#observacao").live("blur",function(){
	var obstext = $(this).val();
	var matricula = $(this).parent().parent().attr('id');
	var aula      = $("#aula").val();
	var observacao = obstext.replace(/^\s+|\s+$/g,"");
		
	 $.post('modulos/escolar2/area_professor/aula/recebe_presenca.php',
	  	{acao:"insere_observacao",aula:aula,matricula:matricula,observacao:observacao},function(data){
		  console.log(data);
	  });
});


</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>

<a href="" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s2'>
    Escolar 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Chamada
</a>
</div>
<div id="barra_info">
    <!--<a href="<?$caminho?>/form.php" target="carregador" class="mais"></a>-->  
    <input type="hidden" name="url_voltar" id="url_voltar" value="<?=$_SESSION["url_voltar"]?>">
    <button onclick="location.href='<?=$_SESSION["url_voltar"]?>'">&laquo; Voltar </button>  
    <span><strong> Aula: </strong><?=$aula->descricao?> | <strong> Matéria:</strong> <?=$sql_serie_materia->nome?></span>
    <a target="_blank" href="modulos/escolar2/area_professor/aula/impressao_observacao.php?aula=<?=$_GET["aula_id"]?>&turma=<?=$aula->turma_id?>&materia_id=<?=$aula->serie_has_materia_id?>" style="float:right; margin-top:3px; margin-right:10px;" ><img src="../fontes/img/imprimir.png"></a> 
</div>
<!--<div id="result"></div>-->
<input type="hidden" name="aula" id="aula" value="<?=$aula_id?>">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	 <tr>
               <td width="60">Matricula</td>
               <td width="240">Aluno</td>
               <td width="200">Observação</td>
               <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    	
    	
    	<?
        	
				while($result_matricula=mysql_fetch_object($sql_turma)){
					
					$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_alunos WHERE id = '$result_matricula->aluno_id'"));
					
					$aluno_obs = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_obs_aluno_aula WHERE aula_id = '$aula_id' AND matricula_aluno_id = '$result_matricula->id'"));
					
					
					
					if( strlen($aluno->nome) > 35 )
						$nome_aluno = substr($aluno->nome,0,35)."...";
					else 
						$nome_aluno = $aluno->nome;
					
		?>
	    	<tr id="<?=$result_matricula->id?>">
               <td width="60"><?=$result_matricula->id?></td>
               <td width="240" style="text-transform:uppercase;"><?=$nome_aluno;?></td>
   			   <td width="200" class="mudar">
               <input type="text"   matricula="<?=$aluno->id?>" name="observacao" id="observacao" style="width:183px;" value="<?=$aluno_obs->observacao?>">
               </td>
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
