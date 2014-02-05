<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
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
<script>
	$(document).ready(function(){
		$("#dados tr:nth-child(2n+1)").addClass('al');
	})
	function checa_cpf(t){
	ultima = t.value.substr(13,1);
	//alert(id);
	if(ultima!='_' && t.value.length=='14' ){
		window.open('modulos/escolar2/cadastros/funcionarios/form.php?cnpj_cpf='+t.value,'carregador')	
		}
	}
	
	$(document).ready(function(){
			$("tr:odd").addClass('al');
});
</script>
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a><a href="?tela_id=232" class="navegacao_ativo">
<span></span><?=ucwords($tela->nome)?>
</a>
</div>
<div id="barra_info">
	<label>
    	<select name="turma_id">
        <?
		//$ensino_q=mysql_query("SELECT * FROM escolar2_ensino WHERE vkt_id='$vkt_id' ");
		$turmas_q=mysql_query("SELECT * FROM escolar2_turmas WHERE vkt_id='$vkt_id'");
		while($turma=mysql_fetch_object($turmas_q)){
		?>
        	<option><?=$turma->nome?></option>
        <? } ?>
        </select>
    </label>
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
   <tr>
   	   <td width="200">Professor</td>
       <td width="200">Segunda</td>
       <td width="200">Terça</td>
       <td width="200">Quarta</td>
       <td width="200">Quinta</td>
       <td width="200">Sexta</td>
       <td width="200">Sábado</td>
       <td width="200">Domingo</td>
       <td></td>
   </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
			
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	Registros 
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
