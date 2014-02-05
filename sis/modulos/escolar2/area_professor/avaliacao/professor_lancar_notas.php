<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
	$('#curso_id').live('change',function(){
		var curso=$("select#curso_id").val();
			//alert(curso);
		$('#result_curso').load('modulos/escolar/exemplo_matricula/curso_turma.php?curso='+curso);
	})
	$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
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
<a href="?tela_id=249" class='s2'>
    Escolar 
</a>
<a href="?tela_id=249" class="navegacao_ativo">
<span></span>Modulos
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">Codigo</td>
           <td width="300">Turmas</td>
           <td width="70">Avaliaçao</td>
   		   <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	    	<tr>
                   <td width="40">1</td>
                   <td width="300"><strong>DSVKTSM202 - </strong> Desenvolvimento de Sistemas</td>
                   <td width="70">&nbsp;</td>
                   <td></td>
            </tr>
            <tr>
                   <td width="40"></td>
                   <td width="200"><div style="margin-left:20px;"><strong>  Materias</strong></div></td>
                   <td width="70">&nbsp;</td>
                   <td>&nbsp;</td>
            </tr>
            <tr>
                   <td width="40" ></td>
                   <td width="200"><div style="margin-left:40px;text-transform:uppercase"> &bull; Logica de Programaçao</div></td>
                   <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
                   <td>&nbsp;</td>
            </tr>
            <tr>
                   <td width="40" ></td>
                   <td width="200"><div style="margin-left:40px;text-transform:uppercase"> &bull; Ingles Tecnico</div></td>
                   <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
                   <td>&nbsp;</td>
            </tr>
            <tr>
               <td width="40" ></td>
               <td width="200"><div style="margin-left:40px;text-transform:uppercase"> &bull; Estrutura de Dados</div></td>
               <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
               <td>&nbsp;</td>
            </tr>
            <!-- -->
            <tr>
                   <td width="40">2</td>
                   <td width="300"><strong>STVKTSM101 - </strong> Segurança do Trabalho</td>
                   <td width="70">&nbsp;</td>
                   <td></td>
            </tr>
            <tr>
                   <td width="40"></td>
                   <td width="200"><div style="margin-left:20px;"><strong>Materias</strong></div></td>
                   <td width="70" >&nbsp;</td>
                   <td>&nbsp;</td>
            </tr>
            <tr>
                   <td width="40"></td>
                   <td width="200" ><div style="margin-left:40px;text-transform:uppercase"> &bull; TÉCNICAS DE PROMOÇAO E DIVULGAÇAO</div></td>
                   <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
                   <td>&nbsp;</td>
            </tr>
             <tr>
                   <td width="40"></td>
                   <td width="200" ><div style="margin-left:40px;text-transform:uppercase"> &bull; LEGISLAÇAO APLICADA</div></td>
                   <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
                   <td>&nbsp;</td>
            </tr>
            <tr>
                   <td width="40"></td>
                   <td width="200"><div style="margin-left:40px;text-transform:uppercase"> &bull; HIGIENE DO TRABALHO</div></td>
                   <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
                   <td>&nbsp;</td>
            </tr>
            <!-- -->
            <tr>
                   <td width="40">3</td>
                   <td width="300"><strong>DGVKTSM101 - </strong> Designer </td>
                   <td width="70">&nbsp;</td>
                   <td></td>
            </tr>
            <tr>
                   <td width="40"></td>
                   <td width="200"><div style="margin-left:20px;"><strong>Materias</strong></div></td>
                   <td width="70">&nbsp;</td>
                   <td>&nbsp;</td>
            </tr>
            <tr>
                   <td width="40"></td>
                   <td width="200"><div style="margin-left:40px;text-transform:uppercase"> &bull; Processos de Fabricaçao</div></td>
                   <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
                   <td>&nbsp;</td>
            </tr>
             <tr>
                   <td width="40"></td>
                   <td width="200"><div style="margin-left:40px;text-transform:uppercase"> &bull; Historia do Designer Industrial</div></td>
                   <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
                   <td>&nbsp;</td>
            </tr>
            <tr>
                   <td width="40"></td>
                   <td width="200"><div style="margin-left:40px;text-transform:uppercase"> &bull; Teoria da Comunicaçao</div></td>
                   <td width="70"><a href="?tela_id=254">Avaliaçao</a></td>
                   <td>&nbsp;</td>
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
