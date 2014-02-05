<?
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php"); 
?>
<script src="<?=$caminho?>/negociacao.js"></script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<script>
function preencheValor(){
	valor = $("#tipo_id option:selected").attr('title');
	$("#valor").val(moedaUsaToBR(valor));
}
</script>

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
<span></span>Negocia&ccedil;&atilde;o</a>

</div>
<div id="barra_info">
    <a href="<?=$caminho?>form.php?disponibilidade_tipo_id=<?=$_GET[disponibilidade_tipo_id]?>&empreendimento_id=<?=$empreendimento->id?>" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="180"><?=linkOrdem("Descrição","nome",1)?></td>
            <td width="160">Tipo de Disponibilidade</td>
          	<td width="98">Entrada</td>
          	<td width="98">Parcelas</td>
          	<td width="98">Contrutora</td>
          	<td width="98">Parcelas</td>
          	<td width="98">Periodo</td>
          	<td width="98">Banco</td>
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
	if($_GET['disponibilidade_tipo_id']){
		$filtro_tipo=" AND disponibilidade_tipo_id='{$_GET['disponibilidade_tipo_id']}' ";
	}
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($trace="SELECT * FROM negociacao WHERE vkt_id='$vkt_id' AND empreendimento_id='$_GET[empreendimento_id]' $filtro_tipo  ORDER BY ".$ordem." ".$_GET['ordem_tipo']." ");
	//echo $trace."<br>";
	while($r=mysql_fetch_object($q)){
		$tipo_disp=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade_tipo WHERE id ='{$r->disponibilidade_tipo_id}' "));
		$total++;
		
	?>      
    	<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
          	<td width="180"><?=$r->nome?></td>
            <td width="160"><?=$tipo_disp->nome?></td>
          	<td width="98"><?=moedaUsaToBr($r->ato_porcentagem)?> %</td>
          	<td width="98"><?=$r->ato_parcelas?></td>
          	<td width="98"><?=$r->construtora_porcentagem?></td>
          	<td width="98"><?=$r->construtora_parcelas?></td>
          	<td width="98"><?=$r->construtora_periodo?></td>
          	<td width="98"><?=$r->construtora_banco?></td>
           	<td width=""></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209">&nbsp;</td>
          	<td width="98">&nbsp;</td>
          	<td width="98">&nbsp;</td>
          	<td width="98">&nbsp;</td>
          	<td width="98">&nbsp;</td>
          	<td width="98">&nbsp;</td>
          	<td width="98">&nbsp;</td>
            <td width=""></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	
</div>
