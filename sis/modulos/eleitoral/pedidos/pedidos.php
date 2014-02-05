<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_functions.php");
include("_ctrl.php");

?>
<script>

$(document).ready(function(){
	$("#dados tr.aplicavel:nth-child(2n+1)").addClass('al');
})

</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_GET['busca']?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/colaborador/busca_coodernador.php,@r0,@r2-value>responsavel_id,0' autocomplete="off"/>
    <input type="hidden" id="responsavel_id" name="responsavel_id" value="<?=$_GET['responsavel_id']?>" />
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Eleitoral 
</a>
<a href="" class="navegacao_ativo">
<span></span>  Pedidos 
</a>
</div>
<div id="barra_info">
   <form method="get" autocomplete="off">
    De<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 

mascara='__/__/____' calendario='1' size="10"  value="<?= $_GET["de"];?>"/>
	Ate<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 

mascara='__/__/____' calendario='1' size="10" value="<?= $_GET["ate"];?>"/>   
   <select name="setor_pedido" id="setor_pedido" onchange="">
   	<?
       	$setores_q = mysql_query("SELECT * FROM eleitoral_setor WHERE vkt_id=$vkt_id");
		if($_GET['setor_pedido']!=0){
			$nomesetor = mysql_fetch_object(mysql_query("SELECT * FROM 

eleitoral_setor where id=".$_GET['setor_pedido']));	
	?>
		<option value="<?=$nomesetor->id?>"><?= $nomesetor->nome;?></option>
    <? }
	?>
    	<option value="0">SETOR DO PEDIDO</option>
	<?
		
		while($setor=mysql_fetch_object($setores_q)){
			if($setor->id!=$_GET['setor_pedido']){
	?>
       <option value="<?=$setor->id?>"><? echo $setor->nome;?></option>
       
	 <?
			}
		}
	 ?>
	</select>
	<select name="status_pedido" id="status_pedido">
    	<option value="todos">STATUS DO PEDIDO</option>
        <option value="emandamento" <? if($_GET['tipo_contato']=='emandamento'){echo 

"selected";} ?>>Em Andamento</option>
        <option value="naoresolvido" <? if($_GET['tipo_contato']=='naoresolvido'){echo 

"selected";}?>>Nao Resolvidos</option>
        <option value="resolvido" <? if($_GET['tipo_contato']=='resolvido'){echo 

"selected";}?>>Resolvidos</option>
	</select>
  <input type="submit" name="filtrar" value="Filtrar" />
  <input type="hidden" name="tela_id" value="132" />
<a href="<?=$caminho?>/form_pedido.php" target="carregador" class="mais"></a>
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="100"><?=linkOrdem("Identificacao","Identificacao",1)?></td>
            <td width="100"><?=linkOrdem("Data do Pedido","Data do Pedido",0)?></td>
            <td width="160"><?=linkOrdem("Eleitor","Eleitor",1)?></td>
            <td width="160"><?=linkOrdem("Responsavel","Responsavel",0)?></td>
            <td width="100"><?=linkOrdem("Setor","Setor",0)?></td>            
            <td width="100"><?=linkOrdem("Prazo Restante","Prazo Restante",0)?></td>
            <td width="100"><?=linkOrdem("Prioridade","Prioridade",0)?></td>
            <td><?=linkOrdem("Status","Status",0)?></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaç?o o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="dados">
<?
if(empty($_GET['busca'])){
//laço do status do pedido
for($i=1;$i<=3;$i++){
	if($i==1){$status_pedido='emandamento';}else if($i==2){$status_pedido='naoresolvido';}else{$status_pedido='resolvido';};
	//laço da prioridade do pedido
	for($j=1;$j<=3;$j++){
		if($j==1){$prioridade='alta';}else if($j==2){$prioridade='media';}else{$prioridade='baixa';};
			
		
			$query = "SELECT * FROM eleitoral_pedidos WHERE vkt_id='$vkt_id' ";
			
			if($_GET['setor_pedido']!=0){
				$query.=" AND setor_id=".$_GET['setor_pedido'];
			}
			if(($_GET['de']!="") && ($_GET['ate']!="")){
				$query.="  AND data_inicio 
				BETWEEN '".DataBrToUSA($_GET['de'])."' AND '".DataBrToUSA($_GET['ate'])."'";
			}
			
			if(!empty($_GET['responsavel_id'])){
				$query.=" AND responsavel_id='".$_GET['responsavel_id']."'";
			}
			
			if(isset($_GET['status_pedido'])&&$_GET['status_pedido']!='todos'){
				$query.=" AND status_pedido='".$_GET['status_pedido']."'";
			}
			$query.=" AND prioridade='$prioridade' 
			ORDER BY data_retorno ASC";
			//echo $query;
			$query = mysql_query($query);
			
			//echo $query;
			while($pedido = mysql_fetch_object($query)){
				//Calcula Prazo Restante do Pedido
			$prazo_restante=SubtraiData($pedido->id);
			if(($prazo_restante<0) && ($pedido->status_pedido=='emandamento')){
					$pedido->status_pedido=AtualizaStatusPedido($pedido->id);
			}
?>            
			 <tr class="aplicavel" onclick="window.open('<?=$caminho?>/form_pedido.php?id=<?=$pedido->id?>','carregador')">
            <td width="100"><?=$pedido->id?></td>
            <td width="100"><?=DataUsatoBr($pedido->data_inicio)?></td>
        <?
           	$eleitor = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_eleitores WHERE id='".$pedido->eleitor_id."'"));
		?>
           <td width="160"><?=$eleitor->nome?></td>
        <?
           	$coordenador = mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_colaboradores WHERE id='".$pedido->coordenador_id."'"));
			//echo $trace;
		?>
           <td width="160"><?=$coordenador->nome?></td>
         <?
           	$setor = mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_setor WHERE id='".$pedido->setor_id."'"));
			//echo $trace;
		 ?>
            <td width="100"><?=$setor->nome?></td>
            <td width="100"><?=$prazo_restante." dias"?></td>
            <td width="100"><?=$pedido->prioridade?></td>
             <td>
            <?
				if($pedido->status_pedido == 'resolvido'){ 
		  	 		echo "<img src='../fontes/img/accept.png'>";} 
		   		else if($pedido->status_pedido == 'emandamento'){
			   		echo "<img src='../fontes/img/exclamation.png'>";
		   		}else{
			   		echo "<img src='../fontes/img/_error.png'>";
		   		}
		    ?>
            </td>
        </tr>
     <? 
	 		if(!empty($_GET['tipo_contato'])){
				$i=4;
			}
	 	}
	}
}
}else{
	for($i=1;$i<=3;$i++){
	if($i==1){$status_pedido='emandamento';}else if($i==2){$status_pedido='naoresolvido';}else{$status_pedido='resolvido';};
	//laço da prioridade do pedido
	for($j=1;$j<=3;$j++){
		if($j==1){$prioridade='alta';}else if($j==2){$prioridade='media';}else{$prioridade='baixa';};
	$query = mysql_query($trace="SELECT * FROM eleitoral_pedidos WHERE coordenador_id='".$_GET['responsavel_id']."' AND status_pedido='$status_pedido' AND prioridade='$prioridade' 
			ORDER BY data_retorno ASC");
	//echo $trace;
	while($pedido = mysql_fetch_object($query)){
		$prazo_restante=SubtraiData($pedido->id);
		if(($prazo_restante<0) && ($pedido->status_pedido=='emandamento')){
			$pedido->status_pedido=AtualizaStatusPedido($pedido->id);
		}
	?>
		 <tr class="aplicavel" onclick="window.open('<?=$caminho?>/form_pedido.php?id=<?=$pedido->id?>','carregador')">
            <td width="100"><?=$pedido->id?></td>
            <td width="100"><?=DataUsatoBr($pedido->data_inicio)?></td>
        <?
           	$eleitor = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_eleitores WHERE id='".$pedido->eleitor_id."'"));
		?>
           <td width="160"><?=$eleitor->nome?></td>
        <?
           	$coordenador = mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_colaboradores WHERE id='".$pedido->coordenador_id."'"));
			//echo $trace;
		?>
           <td width="160"><?=$coordenador->nome?></td>
         <?
           	$setor = mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_setor WHERE id='".$pedido->setor_id."'"));
			//echo $trace;
		 ?>
            <td width="100"><?=$setor->nome?></td>
            <td width="100"><?=$prazo_restante."dias"?></td>
            <td width="100"><?=$pedido->prioridade?></td>
             <td>
            <?
				if($pedido->status_pedido == 'resolvido'){ 
		  	 		echo "<img src='../fontes/img/accept.png'>";} 
		   		else if($pedido->status_pedido == 'emandamento'){
			   		echo "<img src='../fontes/img/exclamation.png'>";
		   		}else{
			   		echo "<img src='../fontes/img/_error.png'>";
		   		}
		    ?>
            </td>
        </tr>
     <? 
	}
	}
}
}
	 ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><a>Total: <?=$total?></a></td>
            <td width="400">&nbsp;</td>
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
