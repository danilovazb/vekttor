
<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<script>
	function ficha_venda(id){
		window.open('http://10.0.1.22/clientes/nv/nv/sis/modulos/corretor/interesses/ficha_venda.php?id='+id);
	}
	function exibeCampo(campo,campo2){
		//alert("oi");
		if(campo.value=='outro'){
			campo2.style.display='block';
		}else{
			campo2.style.display='none';
		}
	}
	$(document).ready(function(){
		$("tr:odd").addClass('al');
	});
</script>
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
<a href="?tela_id=67" class="navegacao_ativo">
<span></span>Interesses
</a>
</div>
<div id="barra_info">
    
	<a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200"><?=linkOrdem("Nome","nome",1)?></td>
          	<td width="100"><?=linkOrdem("Telefone","telefone ",0)?></td>
          	<td width="200"><?=linkOrdem("Email","email ",0)?></td>
			<td width="100">Data da P. Int.</td>
			<td width="100"><?=linkOrdem("Renda Mensal","renda ",0)?></td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND nome like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM interesse WHERE usuario_id='".$_SESSION['usuario']->id."' AND vkt_id='vkt_id' $busca_add"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query("
	SELECT 
		i.nome as nome, i.telefone_residencial as telefone_residencial, i.email as email, MAX(ii.data) as data, i.renda_familiar as renda_familiar
	FROM 
		interesse as i, interesse_interacao as ii 
	WHERE 
		i.usuario_id='".$_SESSION['usuario']->id."' AND i.vkt_id='$vkt_id' AND ii.interesse_id=i.id AND i.usuario_id='$usuario_id' $busca_add 
	GROUP BY 
		i.id 
	ORDER BY 
		ii.data DESC LIMIT  ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		$total++;
		
		$data=mysql_fetch_object(mysql_query($t="SELECT data FROM interesse_interacao WHERE interesse_id='".$r->id."' AND status='0' ORDER BY id DESC"));
		//echo $t;
	?>      
    	<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
          	<td width="200"><?=$r->nome?></td>
            <td width="100"><?=$r->telefone_residencial?></td>
          	<td width="200"><?=$r->email?></td>
			<td width="100"><?=dataUsaToBr($r->data)?></td>
			<td width="100"><?="R$ ".moedaUsaToBr($r->renda_familiar)?></td>
			<td width=""></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>
</div>

<?
//print_r($_POST);
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="200">&nbsp;</td>
            <td width="100">&nbsp;</td>
            <td width="200">&nbsp;</td>
			<td width="100">&nbsp;</td>
			<td width="100">&nbsp;</td>
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
