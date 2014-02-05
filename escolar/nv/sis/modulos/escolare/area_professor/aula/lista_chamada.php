<?
session_start();
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE usuario_id = '$usuario_id'"));
?>
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
	$('#modulo_mais').live('click',function(){
			var html = $('<div> <label>Materia<input type="text" name="nome" size="30"></label></div><div style="clear:both"></div>');
			$("#result_mateira").append(html);
	});
$(document).ready(function(){
	$("#tabela_dados tr td#descricao").live("click",function(){
		var id = $(this).parent().attr('id');
			//alert(id);
		window.open('modulos/escolar/area_professor/aula/form_nova_aula.php?id='+id,'carregador');
	});
});
$(".mais").live('click',function(){
	/*var qtdAula = $("#qtdAula").val();
	var limitAula = $("#limitAula").val();
	
	if(qtdAula < limitAula){
			return true;
	} else{
		  alert("Você não pode mas criar Aula!");
		  return false;	
	}*/
});
$('#clickChamada').live('click',function(){
	var status = $(this).prev('input').val();
	var aula = $(this).parent().parent().attr('id'); 
	var turma = $("#turma").val();
	var salaMateria = $("#sala_materia").val();
	  if(status == 0){
		  location.href='?tela_id=260&sala='+turma+'&aula='+aula+'&sala_materia='+salaMateria;
	  }
	   else{
		  alert('A chamda já foi finalizada, para acessar comunique a Coordenação');
		  return false;
	   }	
});


		
	
</script>
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
<a href="?tela_id=231" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=231" class='s1'>
  	Escolar
</a>
<a href="?tela_id=231" class='s2'>
    Turma 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Aulas
</a>
</div>
<div id="barra_info">
	<!-- input hidden -->
    	<input type="hidden" name="limitAula" id="limitAula" value="<?=$smp->limite_aula;?>">
        <input type="hidden" name="qtdAula" id="qtdAula" value="<?=$qtdAula->qtdAula?>">
        <input type="hidden" name="turma" id="turma" value="<?=$sala?>">
        <input type="hidden" name="sala_materia" id="sala_materia" value="<?=$_GET['sala_materia']?>">
    <!-- -->
	Materia: <strong style="text-transform:capitalize;"> Português <?php echo $materia;?></strong>
    <a href="modulos/escolar/area_professor/aula/form_nova_aula.php?sala_materia=<?=$_GET['sala_materia']?>" target="carregador" class="mais"></a>
	<button type="button" onclick="location.href='?tela_id=267&materia=<?=$_SESSION['materia_id']?>&turma=<?=$sala?>&professor=<?=$professor->id?>'">Total Faltas</button>
    <input type="button" name="todas_perguntas" onclick="location.href='?tela_id=292&professor=<?=$professor->id?>'" value="Todas Perguntas Forum">
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Descriçao Aula</td>
           <td width="70">Data</td>
           <td width="98">Açao</td>
           <td width="70">Aula</td>
           <td width="150">Op&ccedil;&otilde;es</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   
            <tr id="<?=$r->id?>">
               <td width="40"><?=$r->id?></td>
               <td width="250" id="descricao">1&ordm; Aula de Portugues</td>
               <td width="70"><?=dataUsaToBr($r->data)?></td>
               <td width="98">
               	<input type="hidden" name="statusChamada" id="statusChamada" value="<?=$r->status?>">
                <a href="#" id="clickChamada"> <? if($r->status == 0){ echo "Fazer Chamada";} else{ echo "Chamada Fechada";}?></a>
               </td>
               <td width="70">
               	<?
                	if($r->status == 0){
				?>
                		<strong>Aberta</strong>
                <?
					} else{
				?>
               			<strong>Finalizada</strong>
                <?
					}
				?>
               </td>
               <td width="150">
               	<a href="#" onclick="location.href='?tela_id=286&aula=<?=$r->id?>'">Arquivo</a> | 
                <a href="#" onclick="location.href='?tela_id=291&aula=<?=$r->id?>&professor=<?=$professor->id?>'">Responder Forum</a>
                </td>
               <td></td>
            </tr>
            <!--- --->
            
            <tr id="<?=$r->id?>">
               <td width="40"><?=$r->id?></td>
               <td width="250" id="descricao">Aula de Matemática - Assunto P.A </td>
               <td width="70"><?=dataUsaToBr($r->data)?></td>
               <td width="98">
               	<input type="hidden" name="statusChamada" id="statusChamada" value="<?=$r->status?>">
                <a href="#" id="clickChamada"> <? if($r->status == 0){ echo "Fazer Chamada";} else{ echo "Chamada Fechada";}?></a>
               </td>
               <td width="70">
               	<?
                	if($r->status == 0){
				?>
                		<strong>Aberta</strong>
                <?
					} else{
				?>
               			<strong>Finalizada</strong>
                <?
					}
				?>
               </td>
               <td width="150">
               	<a href="#" onclick="location.href='?tela_id=286&aula=<?=$r->id?>'">Arquivo</a> | 
                <a href="#" onclick="location.href='?tela_id=291&aula=<?=$r->id?>&professor=<?=$professor->id?>'">Responder Forum</a>
                </td>
               <td></td>
               
               <!--- --->
            
            <tr id="<?=$r->id?>">
               <td width="40"><?=$r->id?></td>
               <td width="250" id="descricao"> Aula de Geografia</td>
               <td width="70">01/03/2012</td>
               <td width="98">
               	<input type="hidden" name="statusChamada" id="statusChamada" value="<?=$r->status?>">
                <a href="#" id="clickChamada"> <? if($r->status == 0){ echo "Fazer Chamada";} else{ echo "Chamada Fechada";}?></a>
               </td>
               <td width="70">
               	<?
                	if($r->status == 0){
				?>
                		<strong>Aberta</strong>
                <?
					} else{
				?>
               			<strong>Finalizada</strong>
                <?
					}
				?>
               </td>
               <td width="150">
               	<a href="#" onclick="location.href='?tela_id=286&aula=<?=$r->id?>'">Arquivo</a> | 
                <a href="#" onclick="location.href='?tela_id=291&aula=<?=$r->id?>&professor=<?=$professor->id?>'">Responder Forum</a>
                </td>
               <td></td>
               
           <!--- --->
            
            <tr id="<?=$r->id?>">
               <td width="40"><?=$r->id?></td>
               <td width="250" id="descricao"> Aula de Ingles</td>
               <td width="70">23/03/2012</td>
               <td width="98">
               	<input type="hidden" name="statusChamada" id="statusChamada" value="<?=$r->status?>">
                <a href="#" id="clickChamada"> <? if($r->status == 0){ echo "Fazer Chamada";} else{ echo "Chamada Fechada";}?></a>
               </td>
               <td width="70">
               	<?
                	if($r->status == 0){
				?>
                		<strong>Aberta</strong>
                <?
					} else{
				?>
               			<strong>Finalizada</strong>
                <?
					}
				?>
               </td>
               <td width="150">
               	<a href="#" onclick="location.href='?tela_id=286&aula=<?=$r->id?>'">Arquivo</a> | 
                <a href="#" onclick="location.href='?tela_id=291&aula=<?=$r->id?>&professor=<?=$professor->id?>'">Responder Forum</a>
                </td>
               <td></td>
   
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
