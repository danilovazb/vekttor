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
})
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
<a href="?tela_id=231" class='s2'>
    Escolar 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Turma
</a>
</div>
<div id="barra_info">
<input type="button" name="voltar" value="&laquo;" onclick="location.href='?tela_id=259&materia=<?=$_SESSION['materia_id']?>&periodo_id=<?=$_SESSION['periodo_id']?>&sala=<?=$_SESSION['sala']?>&sala_materia=<?=$_SESSION['sala_materia']?>'">
	Materia: <strong style="text-transform:capitalize;">Português<?php echo $materia;?></strong>
    <a href="modulos/escolar/area_professor/aula/form_nova_aula.php?sala_materia=<?=$_GET['sala_materia']?>" target="carregador" class="mais"></a>

</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Aluno</td>
           <td width="60">Faltas</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	
            <tr id="<?=$r->id?>">
               <td width="40">01</td>            
               <td width="250">Ana da Paixão Monteiro</td>
               <td width="60">20</td>
               <td></td>
            </tr>
            
            <tr id="<?=$r->id?>">
               <td width="40">02</td>            
               <td width="250">Adriano de Abreu</td>
               <td width="60">12</td>
               <td></td>
            </tr>
            
             <tr id="<?=$r->id?>">
               <td width="40">03</td>            
               <td width="250">Marcos da Silva Conceição</td>
               <td width="60">17</td>
               <td></td>
            </tr>
            
            <tr id="<?=$r->id?>">
               <td width="40">04</td>            
               <td width="250">Edvandro Neves Favacho</td>
               <td width="60">15</td>
               <td></td>
            </tr>
            
             <tr id="<?=$r->id?>">
               <td width="40">05</td>            
               <td width="250">Rogério Vasconcelos Amaral</td>
               <td width="60">09</td>
               <td></td>
            </tr>
            
             <tr id="<?=$r->id?>">
               <td width="40">06</td>            
               <td width="250">Julio de Souza Neto</td>
               <td width="60">16</td>
               <td></td>
            </tr>
            
             <tr id="<?=$r->id?>">
               <td width="40">07</td>            
               <td width="250">Eduardo Martins Gomes</td>
               <td width="60">13</td>
               <td></td>
            </tr>
            
            <tr id="<?=$r->id?>">
               <td width="40">08</td>            
               <td width="250">Talmerina da Conceição</td>
               <td width="60">14</td>
               <td></td>
            </tr>
            
             <tr id="<?=$r->id?>">
               <td width="40">09</td>            
               <td width="250">Tamires Bradão Souza</td>
               <td width="60">11</td>
               <td></td>
            </tr>
            
            <tr id="<?=$r->id?>">
               <td width="40">10</td>            
               <td width="250">Marcos Assunção</td>
               <td width="60">12</td>
               <td></td>
            </tr>
            
            
        
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
           <td width="60">&nbsp;</td>
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
