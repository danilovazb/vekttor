<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<script>
$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
	$('#modulo_mais').live('click',function(){
			var html = $('<div> <label>Materia<input type="text" name="nome" size="30"></label></div><div style="clear:both"></div>');
			$("#result_mateira").append(html);
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
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a><a href="?tela_id=231" class="navegacao_ativo">
<span></span>Turma
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
   <td width="40">Codigo</td>
   <td width="200">Nome da Turma</td>
   <td width="150">Curso</td>
    <td width="150">Modulo</td>
   <td width="80">Sala</td>
   <td width="80">Status</td>
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
   <td width="200">DSVKTSM101</td>
   <td width="150">Desenvolvimento de Sistemas</td>
   <td width="150">Iniciante - Módulo 1</td>
   <td width="80">1</td>
   <td width="80">Ativo</td>
   <td></td>
   </tr>
   <tr>
      <td width="40">2</td>
   <td width="200">DSVKTSM202</td>
   <td width="150">Desenvolvimento de Sistemas</td>
   <td width="80">Avan&ccedil;ado - M&oacute;dulo 2</td>
   <td width="80">2</td>
   <td>Ativo</td>
   </tr>
   <tr>
      <td width="40">3</td>
   <td width="200">STVKTSM101</td>
    <td width="150">Segurança do trabalho</td>
   <td width="80">Iniciante  - Módulo 1</td>
   <td width="80">3</td>
   <td width="80">Ativo</td>
   <td></td>
   </tr>
   <tr>
      <td width="40">4</td>
   <td width="200">STVKTSM202</td>
    <td width="150">Segurança do trabalho</td>
   <td width="80">Avançado  - Módulo 2</td>
   <td width="80">4</td>
   <td width="80">Ativo</td>
   <td></td>
   </tr>
   <tr>
      <td width="40">5</td>
   <td width="200">DGVKTSM101</td>
    <td width="150">Designer</td>
   <td width="80">Iniciante</td>
   <td width="80">5</td>
   <td width="80">Ativo</td>
   <td></td>
   </tr>
   <tr>
      <td width="40">6</td>
   <td width="200">DGVKTSM202</td>
    <td width="150">Designer</td>
   <td width="80">Avançado</td>
   <td width="80">6</td>
   <td width="80">Ativo</td>
   <td></td>
   </tr>
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND a.nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT count(*) FROM escolar_alunos a, escolar_alunos_bolsistas ab WHERE ab.vkt_id=$vkt_id $busca_add ORDER BY a.id DESC"),0,0);
   //echo $t;
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="codigo_totvs";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($t="SELECT a.*,ab.* FROM escolar_alunos a, escolar_alunos_bolsistas ab WHERE  a.id=ab.aluno_id AND ab.vkt_id='$vkt_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form.php?id=<?=$r->aluno_id?>','carregador')">
   <td width="40">Codigo</td>
   <td width="200">Nome</td>
   <td width="150">Email</td>
   <td width="80">Telefone</td>
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
