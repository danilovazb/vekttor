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
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>
    Imobiliária 
</a>
<a href="?tela_id=37" class="navegacao_ativo">
<span></span>Cadastro de Clientes 
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="130"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
          	<td width="130"><?=linkOrdem("CNPJ/CPF","cnpj_cpf",0)?></td>
          	<td width="110"><?=linkOrdem("Telefone","telefone1",0)?></td>
          	<td width="80"><?=linkOrdem("Tipo","tipo_cadastro",0)?></td>
            <td></td>
        </tr>
    </thead>
</table>
<script type="text/javascript">
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM cliente_fornecedor WHERE tipo='Cliente' AND cliente_vekttor_id='$vkt_id' AND usuario_id IS NOT NULL $busca_add ORDER BY nome_fantasia"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome_fantasia";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query("SELECT * FROM cliente_fornecedor WHERE tipo='Cliente' AND cliente_vekttor_id='$vkt_id' AND usuario_id ='$usuario_id' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		$total++;
		
	?>
	
    	<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
            <td width="130"><?=$r->nome_fantasia?></td>
          	<td width="130"><?=$r->cnpj_cpf?></td>
          	<td width="110"><?=$r->telefone1?></td>
          	<td width="80"><?=$r->tipo_cadastro?></td>
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
           <td width="130"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="200">&nbsp;</td>
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
