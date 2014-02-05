<?
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php"); 
?>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>


<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s1'>
  	Administrativo
</a>
<a href="?tela_id=17" class='s1'>
    Empreendimentos
</a>
<a href="?tela_id=17" class='s2'>
    <?=$empreendimento->nome?>
</a>
<a href="" class="navegacao_ativo">
<span></span>Tipo  de Disponibilidades 
</a>

</div>
<div id="barra_info">
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Tipo","nome",1)?></td>
          	<td width="98"><?=linkOrdem("Valor","valor ",0)?></td>
            <td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	<?
	
	
	
	// necessario para paginacao
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query("SELECT * FROM disponibilidade_tipo WHERE empreendimento_id='$_GET[empreendimento_id]'  ORDER BY ".$ordem." ".$_GET['ordem_tipo']." ");
	
	while($r=mysql_fetch_object($q)){
		$total++;
		
	?>      
    	<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
          	<td width="209"><?=$r->nome?></td>
            <td width="98" style="text-align:right; "><?=moedaUsaToBr($r->valor)?></td>
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
            <td width="209">&nbsp;</td>
          	<td width="98">&nbsp;</td>
            <td width="">&nbsp;</td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
