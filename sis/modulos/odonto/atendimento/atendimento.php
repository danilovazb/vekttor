<?
include('../../../_config.php');
$caminho =$tela->caminho; 
?>
<script src="<?=$caminho?>script_dentes.js"></script>
<?
include("_functions.php");
include("_ctrl.php");

?>

<link href="<?=$tela->caminho?>/odonto.css" type="text/css" rel="stylesheet">
<script type="text/javascript"  src="<?=$tela->caminho?>/odonto.js"></script>

<!-- <script type="text/javascript" src="http://malsup.github.com/jquery.form.js"></script>-->

<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="atendimento_id" id="atendimento_id">
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" autocomplete="off" busca="modulos/odonto/buscas/busca_atendimentos.php,@r1,@r1-value>busca|@r0-value>atendimento_id,0" name="busca" id="busca" 
    onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Odontólogo 
</a>
<a href="#" class="navegacao_ativo">
<span id='informdata' data='<?=date('d/m/Y')?>'></span>  Atendimento
</a>
</div>
<div id="barra_info">

<!--<script type="text/javascript" src="scripts_exames.js"></script>-->
<a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>	
          	<td width="250">Clientes</td>
            <td width="180">Última Consulta</td>
            <td width="150">Situação</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
	<tbody>
    <? 
	if(!empty($_GET['busca'])){
		$filtro = " AND c.razao_social LIKE '%".$_GET['busca']."%'";
	}
	
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM odontologo_atendimentos as a,cliente_fornecedor as c WHERE a.vkt_id='$vkt_id' AND a.cliente_fornecedor_id=c.id $filtro ORDER BY c.razao_social"),0,0);
	
	$atendimentos_q=mysql_query($t="SELECT c.*, a.id as atendimento_id FROM odontologo_atendimentos as a,cliente_fornecedor as c WHERE a.vkt_id='$vkt_id' AND a.cliente_fornecedor_id=c.id $filtro ORDER BY c.razao_social LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])); 
	
	while($atendimento=mysql_fetch_object($atendimentos_q)){
		$checa_consulta_q=mysql_query("SELECT DATE_FORMAT(data,'%d/%m/%Y') as data FROM odontologo_consultas WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento->atendimento_id' AND status='em andamento'");
		$verifica_fila=mysql_fetch_object(mysql_query("SELECT * FROM odontologo_fila_espera WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$atendimento->id' ORDER BY id DESC LIMIT 1"));
		$tem_consulta=mysql_num_rows($checa_consulta_q);
		if($verifica_fila){$status=$verifica_fila->status;}else{$status='Cadastrado';}
		if($tem_consulta>0)
		{
			$consulta=mysql_fetch_object($checa_consulta_q);
			$alerta_consulta="<span style='color:red'>Consulta em aberto:".$consulta->data."</span>";
		}
		else
		{
			$ultima_consulta_q=mysql_query("
			SELECT DATE_FORMAT(data,'%d/%m/%Y') as data FROM odontologo_consultas WHERE vkt_id='$vkt_id' AND odontologo_atendimento_id='$atendimento->atendimento_id' AND status='concluido' ORDER BY id DESC");
			$ultima_consulta=mysql_fetch_object($ultima_consulta_q);
			if($ultima_consulta){$alerta_consulta="<span style='color:green'>".$ultima_consulta->data."</span>";}else{$alerta_consulta="<span style='color:green'>Cliente sem consultas</span>";}
			
		}
	?>
		<tr onclick="window.open('<?=$caminho?>/form.php?atendimento_id=<?=$atendimento->atendimento_id?>','carregador')">
        	<td width="250"><?=$atendimento->razao_social?></td>
            <td width="180"><?=$alerta_consulta?></td>
            <td width="150"><?=$status?></td>
            <td></td>
        </tr>
    <? } ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    
    	<tr>
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
