<?

$professor = mysql_fetch_object(mysql_query($p="SELECT *, p.id AS professor_id  FROM cliente_fornecedor as cf, escolar_professor as p
WHERE cf.id=p.cliente_fornecedor_id 
AND cf.id = '".$_GET['professor_id']."' "));
$aula = mysql_fetch_object(mysql_query("SELECT * FROM escolar_aula WHERE id = '".$_GET['aula_id']."'"));
$materia = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_materias WHERE id = '".$_GET['materia_id']."'"));
//$aluno = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '".$_SESSION['aluno']->id."' "));
?>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<a href="#" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s1'>
  	Escolar
</a>
<a href="#" class='s2'>
    Aulas 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Forum
</a>
</div>
<style>
table#tabela_dados tbody tr td:hover{background:none; color:inherit;}
table#tabela_dados tbody tr td{margin:0px; padding:0px; font-size:14px;}
table#tabela_dados tbody tr{
	color:#333;
	padding:2px;
	background:url(modulos/escolar/area_aluno/forum/img/bgn2.png) repeat-x;
}
table#tabela_dados tbody tr.pergunta{background:#F4F4EA; color:#F7F7EE;  color:#333333; }
table#tabela_dados tbody tr.pergunta div strong{padding-left:3px; font-size:13px;}
</style>
<script>
$(".excluir").live('click',function(){
			var iconCarregando = $("<span >Aguarde...</span>");
			var post_id = $(this).attr('id');
			var d       = $(this).parent().parent().parent();
			var f       = $(this).parent().parent().parent().prev();
			
			//alert(post_id);
			var dados = 'id='+post_id;
			$.ajax({
				url:'modulos/escolar/area_aluno/forum/recebe_ultima_mensagem.php?acao=excluir_post',
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
					//f.remove().fadeOut("slow");
					d.hide('slow', function(){ d.remove(); });
					f.hide('slow', function(){ f.remove(); });
				},
				error: function(xhr,er) {
					$('#aqui_carreca').html('<p class="destaque">Lamento! Ocorreu um erro. Por favor tente mais tarde.')
				}	
			})
})
</script>
<script>
$("#enviar").live('click',function(){
	    var iconCarregando = $("<span >Aguarde...</span>");
		var msg = $("#msg").val();
		var dados = 'msg='+msg+'&professor=<?=$professor->id?>&aluno=<?=$_SESSION['aluno']->id?>&aula=<?=$_GET['aula_id']?>&pergunta_id=<?=$_GET['pergunta_id']?>';
		$('#aguarde').css('display', 'block');
		//alert(dados);
			$.ajax({
				url:'modulos/escolar/area_aluno/forum/recebe_ultima_mensagem.php?acao=ultima',
				type:'POST',
				dataType:'html',
				data:dados,
				beforeSend: function(){
					$('#aguarde').html(iconCarregando);
				},
				complete: function() {
					$(iconCarregando).remove();
				},
				success:function(data){
					$("#ultima_msg").hide().append(data).fadeIn(800);
				},
				error: function(xhr,er) {
					$('#aguarde').html('<p class="destaque">Lamento! Ocorreu um erro. Por favor tente mais tarde.')
				}	
			})
		//alert(msg);
})
</script>

<div id="barra_info">
<div id="aqui_carreca" style="position:absolute; background:#FFFFB3; color:#333; font-weight:bold;"></div>
<? if(!empty($_SESSION['aluno']->id)){?>
<input type="button" name="voltar" value="&laquo;" onclick="location.href='?tela_id=300&aula_id=<?=$_GET['aula_id']?>'">
<?
	} else if(empty($_SESSION['aluno']->id)) {
?>
<input type="button" name="voltar" value="Todas Perguntas" onclick="location.href='?tela_id=296&professor=<?=$professor->professor_id?>'">
<?
	}
?>
<strong >Mat&eacute;ria:</strong> <span style="text-transform:capitalize"><?=$materia->nome;?></span>
<strong>Professor : </strong> <?=$professor->razao_social;?>
<strong> Data Aula : </strong> <?=dataUsaToBr($aula->data);?>

</div>
<table cellpadding="0" cellspacing="0" width="100%" sty>
    <thead>
    	<tr>
           <td><div>FORUM</div></td>
         </tr>
    </thead>
</table>
<div id='dados'>

<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" style="margin:0px;">
    <tbody id="tbody">
        <?
        	$s_forum = mysql_query($rt=" SELECT * FROM escolar_forum WHERE vkt_id = '$vkt_id' 
											AND 
												aula_id  = '".$_GET['aula_id']."' 
											AND 
												pergunta_id = '".$_GET['pergunta_id']."'
											ORDER BY id ASC");
				
					while($forum=mysql_fetch_object($s_forum)){
					
						$data_hora = explode(' ',$forum->data_hora);
						$hora = $data_hora[1];
						$data = $data_hora[0];
						
						if(!empty($forum->aluno_id)){
								$aluno = mysql_fetch_object(mysql_query($a=" SELECT * FROM escolar_alunos WHERE id = '".$forum->aluno_id."' "));
						} else{
						$professor_forum = mysql_fetch_object(mysql_query($y="SELECT * FROM cliente_fornecedor as cf, escolar_professor as p
WHERE cf.id=p.cliente_fornecedor_id 
AND p.id = '".$forum->professor_id."' ")); 							
						}
		?>
            <tr id="<?=$forum->id?>" class="post">
               <td>
               	<div style="padding:4px; float:left;">
                	<strong>Postada em :</strong> <?=dataUsaToBr($data);?> - <?=$hora?> 
                    <?
                    	if(empty($forum->aluno_id)){
								echo "<strong> - Professor</strong>";
						}
					?>
                </div>
                </td>
            </tr>
             <tr  class="pergunta" style=" border:1px solid #CCC;">
               <td style="border:1px solid #CCC;">
                <div style="float:left; width:140px; height:160px; border-right:1px solid #CDCDCD; padding:8px; margin:8px;">
                   <div style="width:130px;  margin-left:-8px; text-align:center">
				   <? 
								//echo '<img src="modulos/escolar/area_aluno/forum/img/status_online.png" align="absbottom">';
						 
				   ?>
					<? if(!empty($forum->aluno_id)){
								echo LimitarString($aluno->nome,15);
						} 
						else{
							echo "<strong>Prof. </strong>".substr($professor_forum->razao_social,0,10);
						}
					?>
                    </div>
                   <div style="padding-top:2px"></div>
                   <?
                   		if(!empty($forum->aluno_id) and !empty($aluno->extensao)){
				   ?>
                	<div style="background:url(modulos/escolar/alunos_inscritos/img/<?=$aluno->id?>.<?=$aluno->extensao?>) 50px; width:110px; height:140px; background-position:center;  box-shadow:1px 1px 1px #666;">&nbsp;
                    </div>
                    <?
						} else{
					?>
                   <div style="background:url(modulos/escolar/area_aluno/forum/img/perfil-null.jpg); width:110px; height:140px; background-position:45%;  box-shadow:1px 1px 1px #666;">&nbsp;
                    </div>
                    <?
						}
						if($_SESSION['aluno']->id == $forum->aluno_id){
					?>
                    <div style="padding:2px; padding-left:10px; font-size:11px; margin-left:12px;" id="<?=$forum->id?>" class="excluir">Excluir Post</div>
                    <?
						}
					?>
                </div>
               	<div style="padding:5px; float:left;">
                   <div style="border-bottom:1px solid #CDCDCD; padding-bottom:5px; width:100%;">
                	<strong id="pergunta_feita">
                    	<? 
						$pergunta = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_forum_pergunta WHERE id = '$forum->pergunta_id' AND vkt_id = '$vkt_id' "));
						if($forum->status == '1')
								echo $pergunta->pergunta;
							else if($forum->status == '2')
							    echo "RE: ".$pergunta->pergunta;
						?>
                    </strong> 
                    <!--<span style="padding-left:5px;">Em: 12/02/2012 - 14:02:02</span>-->
                   </div>
                   <div id="resposta" style="font-size:12px; padding-bottom:2px; padding-top:8px;">
                    - <?
						if($forum->status == '1' and $forum->resposta != NULL){
                    		echo "<strong>Professor: </strong>".$forum->resposta;
						} else{
							echo $forum->resposta;
						}
					  ?> 
                   </div>
                </div>
                </td>
            </tr>
            <?
					}
			?>
    </tbody>
</table>
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" style="margin:0px;">
    <tbody id="ultima_msg">
    </tbody>
</table>
<div style="padding:10px; margin:8px;">
<div id="aguarde" style="position:absolute; background:#FFFFB3; color:#333; font-weight:bold;"></div>
	 <?
    
	 ?>
     <label>
		Enviar Coment&aacute;rio<br/>
        <textarea cols="50" name="msg" id="msg"></textarea>
     </label>
     <div style="clear:both"></div>
     <label>
     	<input type="submit" name="enviar" id="enviar" value="Enviar">
     </label>
     <?
     
	 ?>
     
</div>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230">&nbsp;</td>
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
  <div style="float:right; margin:0px 20px 0 0"></div>
</div>
