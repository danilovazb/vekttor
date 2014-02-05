<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="?tela_id=301" class='s1'>
  	SISTEMA
</a>

<a href="?" class='s2'>
  	OS
</a>
<a href="?tela_id=301" class='navegacao_ativo'>
<span></span>    SERVI&Ccedil;OS
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
      <span style="float:right">
  Período: 
  <?php 
	if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "01/".date("m/Y")." a ".date("t/m/Y");
	}else{
			echo $_GET['de']." a ".$_GET['ate'];
	}?>
  </span>
  <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["de"];?>" height="7"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$_GET["ate"];?>" height="7"/>
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
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
          <td width="60"><?=linkOrdem("Codigo","Codigo",1)?></td>
          <td width="200">Descricao</td>
          <td width="70">Vendido</td>
          <td width="70">Valor</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php
	
		if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro = " AND o.data_aprovacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
		}else{
			$mes_atual=date("m");
			$filtro = "AND MONTH(data_aprovacao) = '$mes_atual'";
		}
		
			if(!empty($_GET['busca'])){
			$busca = "AND s.nome LIKE '%".$_GET['busca']."%'";
		}
		
		$registros= mysql_result(mysql_query("SELECT 
												COUNT(distinct(item.servico_id)) 
											FROM 
												os_item AS item, 
												os As o,
												servico as s 
											WHERE item.os_id=o.id AND 
												item.servico_id <> '' AND
												item.servico_id=s.id AND
												o.vkt_id = '$vkt_id' $filtro $busca"),0,0);
		
		$s_servico = mysql_query($t=" SELECT 
										distinct(servico_id) 
									  FROM os_item AS item, 
									  	os As o,
										servico as s 
									  WHERE item.os_id=o.id AND 
									  	item.servico_id <> '' AND
										item.servico_id=s.id AND
									 	o.vkt_id = '$vkt_id' $filtro $busca
										LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		
				//echo $t;
				$servico_vendido=array();
				$c=0;
				while($servico=mysql_fetch_object($s_servico)){
					$qtd_servico = mysql_fetch_object(mysql_query($t="SELECT count(servico_id) as qtd FROM os_item AS item, os As o 
																		WHERE item.os_id=o.id 
																	  AND servico_id <> '' 
																	  AND servico_id = '$servico->servico_id'
																		"));
					$valor = mysql_fetch_object(mysql_query("SELECT sum(valor_servico) as valor FROM os_item AS item, os As o 
															WHERE item.os_id=o.id 
															AND servico_id <> '' and servico_id = '$servico->servico_id' $filtro "));
					$nome = mysql_fetch_object(mysql_query(" SELECT * FROM servico WHERE vkt_id = '$vkt_id' AND id = '$servico->servico_id'"));	
					
					$servico_vendido[$c]['qtd']=$qtd_servico->qtd;
					$servico_vendido[$c]['valor']=moedaUsaToBr($valor->valor);
					$servico_vendido[$c]['id']=$servico->servico_id;
					$servico_vendido[$c]['nome']=$nome->nome;
					
					
					$c++;											
				}
					rsort($servico_vendido);
			
			foreach($servico_vendido as $servico){						
	?>
          
    	<tr <?=$sel?>>
          <td width="60"><?=$servico['id']?></td>
          <td width="200"><?=$servico['nome']?></td>
          <td width="70"><?=$servico['qtd']?></td>
          <td width="70"><?=$servico['valor']?></td>
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
