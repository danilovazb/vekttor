<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?><div id='navegacao'>

<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s1'>
    Administrativo 
</a>
<a href="?tela_id=37" class='s2'>
    Clientes Fornecedores 
</a>
<a href="?tela_id=68&cliente_fornecedor_id=<?=$_GET['cliente_fornecedor_id']?>" class="navegacao_ativo">
<?
if($_GET['cliente_fornecedor_id']>0){
	$interesse=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$_GET['cliente_fornecedor_id']."'"));
}
?>
<span></span>Arquivos<?=" de ".$interesse->nome_fantasia?>
</a>
</div>
<div id="barra_info">
    
	<a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><?=linkOrdem("Nome","nome",1)?></td>
          	<td width="105"><?=linkOrdem("Arquivo","arquivo",0)?></td>
          	<td width="250"><?=linkOrdem("Observação","obs",0)?></td>
			<td width="105">Opções</td>
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
		$busca_add = "AND tipo like '%{$_GET[busca]}%'";
	}
	
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM interesse $busca_add"),0,0);
    
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="tipo";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query("SELECT * FROM cliente_fornecedor_arquivo WHERE usuario_id='".$_SESSION['usuario']->id."' AND cliente_fornecedor_id='".$_GET['cliente_fornecedor_id']."' $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	
	while($r=mysql_fetch_object($q)){
		
		$total++;
		
	?>      
    	<tr>
          	<td width="150"><?=$r->tipo?></td>
            <td width="105"><?=$r->arquivo?></td>
          	<td width="250"><?=$r->obs?></td>
			<td width="105"><a href="./upload/<?=$r->arquivo?>">Download</a> | <a href="?tela_id=69&cliente_fornecedor_id=<?=$_GET['cliente_fornecedor_id']?>&excluir=<?=$r->id?>">Excluir</a></td>
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
            <td width="150">&nbsp;</td>
            <td width="105">&nbsp;</td>
            <td width="250">&nbsp;</td>
		 	<td width="105">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
</div>

