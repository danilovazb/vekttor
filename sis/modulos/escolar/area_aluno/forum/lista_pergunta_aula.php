<?
session_start();
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php");
//$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE usuario_id = '$usuario_id'"));
//$aula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_aula WHERE vkt_id = '$vkt_id' AND id = '".$_GET['aula']."' "));
$aula_smp = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_aula WHERE vkt_id = '$vkt_id' AND id = '".$_GET['aula_id']."' "));
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
<a href="#" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s1'>
  	Escolar
</a>
<a href="#" class='s2'>
    Área do Professor 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Forum
</a>
</div>
<script>
$("#novo_topico").live("click",function(){
		var id = <?=$_GET['aula_id']?>;
		//alert(id);
		window.open('modulos/escolar/area_aluno/forum/form_pergunta.php?id='+id,'carregador');
});
</script>
<script>
$("table tbody tr td div#pergunta_descricao").live("click",function(){
	    var aula_id =  <?=$_GET['aula_id']?>;
		var pergunta_id = $(this).parent().parent().attr('id');
		//alert(pergunta_id);
		window.open('modulos/escolar/area_aluno/forum/form_pergunta.php?pergunta_id='+pergunta_id+'&aula_id='+aula_id,'carregador');
});
$(".excluir").live("click",function(){
			var iconCarregando = $("<span >Aguarde...</span>");
			var id = $(this).parent().parent().attr("id");
			var b  = $(this).parent().parent();
			var dados = 'id='+id;
			
			$.ajax({
				url:'modulos/escolar/area_aluno/forum/recebe_ultima_mensagem.php?acao=excluir_pergunta',
				type:'POST',
				dataType:'html',
				data:dados,
				beforeSend: function(){
					$('#aqui_carreca').html(iconCarregando);
				},
				complete: function() {
					$(iconCarregando).remove();
				},
				success:function(data){
					//$("#ultima_msg").hide().append(data).fadeIn(800);
					b.hide('slow', function(){ b.remove(); });
				},
				error: function(xhr,er) {
					$('#aqui_carreca').html('<p class="destaque">Lamento! Ocorreu um erro. Por favor tente mais tarde.')
				}	
			})
})
</script>
<div id="barra_info">
<div id="aqui_carreca" style="position:absolute; background:#FFFFB3; color:#333; font-weight:bold;"></div>
<!--<input type="button" name="voltar" value="&laquo;" onclick="location.href='?tela_id=259&materia=<?//$_SESSION['materia_id']?>&periodo_id=<?//$_SESSION['periodo_id']?>&sala=<?//$_SESSION['sala']?>&sala_materia=<?//$_SESSION['sala_materia']?>'">-->
<input type="button" name="voltar" value="&laquo;" onclick="location.href='?tela_id=287&salamateria_id=<?=$aula_smp->sala_materia_professor_id?>'">
<span style="float:right; padding-right:10px;"><input type="button" name="novo_topico" id="novo_topico" value="Novo T&oacute;pico"></span>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Descriçao Aula</td>
           <td width="70">Data</td>
           <td width="85">Status</td>
           <td width="54">Forum</td>
           <td width="40">A&ccedil;&atilde;o</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php
	
			$s_aula = (mysql_query(" SELECT * FROM escolar_aula WHERE vkt_id = '$vkt_id' AND id = '".$_GET['aula_id']."'"));
 					$j=0;		
					while($aula=mysql_fetch_object($s_aula)){
						$j++;
						
					$smp = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_sala_materia_professor WHERE id = '$aula->sala_materia_professor_id' "));
					//echo " Materia ".$smp->materia_id. "Professor:".$smp->professor_id;
					$professor_id = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE id = '$smp->professor_id' "));
	?> 
            <tr id="titulo_aula" style="background:#999; color:#FFF;">
               <td width="40"><?=$aula->id?></td>
               <td width="250" ><?=$aula->descricao?></td>
               <td width="70"><?=dataUsaToBr($aula->data)?></td>
               <td width="85">&nbsp;</td>
               <td width="54">&nbsp;</td>
               <td width="40">&nbsp;</td>
               <td></td>
            </tr>
            <tr id="titulo_aula" style="color:#000;">
               <td width="40"><?=$j?></td>
               <td width="250" ><strong>T&oacute;picos</strong></td>
               <td width="70">&nbsp;</td>
               <td width="85">&nbsp;</td>
               <td width="54">&nbsp;</td>
               <td width="40">&nbsp;</td>
               <td></td>
            </tr>
            <?
            	$s_forum = (mysql_query(" SELECT * FROM escolar_forum WHERE vkt_id = '$vkt_id' 
											AND 
												aula_id = '".$_GET['aula_id']."' 
											AND 
												status = '1'	
											"));
						while($forum=mysql_fetch_object($s_forum)){
							$pergunta = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_forum_pergunta WHERE id = '$forum->pergunta_id' AND vkt_id = '$vkt_id' "));
			?>
            
            <tr class="pergunta" id="<?=$forum->id?>">
               <td width="40"><?=$forum->id?></td>
               <td width="250" >
               <div id="pergunta_descricao" style="padding-left:10px;"><?=substr($pergunta->pergunta,0,38)?></div></td>
               <td width="70"><?=dataUsaToBr($forum->data_hora)?></td>
               <td width="85">
               	<?
                	if($forum->resposta == NULL){
						echo "Pendente";	
					} else{
						echo "Respondida";
					}
				?>
               </td>
               <td width="54"><button type="button" name="todas_perguntas" onclick="location.href='?tela_id=282&materia_id=<?=$smp->materia_id?>&professor_id=<?=$professor_id->cliente_fornecedor_id?>&aula_id=<?=$aula->id?>&pergunta_id=<?=$pergunta->id?>'"> <img src="modulos/escolar/area_aluno/forum/img/group.png" align="absbottom"></button></td>
               <td width="40"> <? if($forum->aluno_id == $_SESSION['aluno']->id){echo "<a href=\"#\" id=\"$forum->id\" class=\"excluir\">Excluir</a>";} ?> </td>
               <td></td>
            </tr>
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
           <td width="45">&nbsp;</td>
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

<script>
$(document).ready(function(){
	$("#tabela_dados tr.pergunta:nth-child(2n+1)").addClass('al');

})
</script>