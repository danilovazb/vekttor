<?php
session_start();

//include("_functions.php");
//include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="?tela_id=281" class='s1'> SISTEMA </a>
<a href="?" class='s2'> OS </a>
<a href="?tela_id=280" class='navegacao_ativo'>
<span></span>    Produtos na Empresa
</a>
<form class='form_busca' action="" method="get">
   	 <a id="clickbusca"></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
  <form method="get" autocomplete="off">
	
  <input type="hidden" name="tela_id" value="548" />
  </form>
</div>

<script>
$(document).ready(function(){
	$("tr:odd").addClass('al');
});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="50">O.S Nº</td>
          <td width="150">Equipamento</td>
          <td width="150">Cliente</td>
          <td width="70">Nº série</td>
          <td width="90">Marca</td>
          <td width="70">Modelo</td>
          <td width="80">Data entrada</td>
          <td width="80">Data entrega</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
  <tbody>
      <?php 
     		
			$filter = !empty($_GET["busca"]) ? "AND oe.numero_serie = '".trim($_GET["busca"])."' " : NULL;
			
			$sql = mysql_query($t=" SELECT *, oe.nome AS nomeEquipamento, os.data_cadastro AS dataEntrada FROM os  
			JOIN os_has_equipamento AS oep ON oep.os_id = os.id
			JOIN os_equipamento AS oe ON oe.id = oep.equipamento_id  
			JOIN cliente_fornecedor AS cliente ON cliente.id = os.cliente_id
			WHERE os.vkt_id = '$vkt_id'  $filter ");
			
			while($reg=mysql_fetch_object($sql)){
			
      ?>      
      <tr>
          <td width="50"><?=$reg->os_id?></td>
          <td width="150"><?=$reg->nomeEquipamento?></td>
          <td width="150"><?=$reg->razao_social?></td>
          <td width="70"><?=$reg->numero_serie?></td>
          <td width="90"><?=$reg->marca?></td>
          <td width="70"><?=$reg->modelo?></td>
          <td width="80"><?=dataUsaToBr($reg->dataEntrada)?></td>
          <td width="80"><?=dataUsaToBr($reg->data_entrega)?></td>
          <td></td>
      </tr>
    <?php
			}
    ?>
  </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
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
