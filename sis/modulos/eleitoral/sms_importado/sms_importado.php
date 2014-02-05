<?php

$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

include("_functions.php");
include("_ctrl.php");

?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<script>

$(document).ready(function(){
	$("#tabela_dados tr.aplicavel:nth-child(2n+1)").addClass('al');
})

var tabAtual = 1
 
mudarTab = function(numeroTab) {
	$("#tab_"+tabAtual).toggle()
	$("#tab_"+numeroTab).toggle()
	tabAtual = numeroTab
}	
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get" autocomplete="off">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <!--<input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>-->
    <input type="text" id='busca' name="busca" maxlength="44" value="<?=$_GET[busca]?>" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" busca='modulos/eleitoral/politicos/busca_politico.php,@r0,0'/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Eleitoral 
</a>
<a href="" class="navegacao_ativo">
<span></span>  Importacao SMS</a></div>
<div id="barra_info">
<form method="get">
<label style="width:400px;">
    Selecione uma promoção
    <select name="promocao_id" id="promocao_id"/>
    	<option value="">Todas As Promoções</option>
    	<?php
			$promocoes = mysql_query("SELECT * FROM eleitoral_promocao WHERE vkt_id='$vkt_id'");
			while($promocao = mysql_fetch_object($promocoes)){
				if($promocao->id==$_GET['promocao_id']){
					$selected="selected=selected"; 
				}
				echo "<option value='$promocao->id' $selected>$promocao->descricao</option>";
				$selected='';
			}
		?>
    </select>
  </label>
	<label>
    Quantidade <input type="text" name="quantidade" id="quantidade" value="<?=$_GET['quantidade']?>" style="width:30px;height:10px;">
  <!--<input type="submit" name="filtrar" value="Filtrar" />-->  	
 </label>
 <label>
    Período: <input type="text" name="de" id="de" value="<?=$_GET['de']?>" calendario="1" sonumero="1" mascara="__/__/____" style="width:75px;height:10px;">
  <!--<input type="submit" name="filtrar" value="Filtrar" />-->  	
 </label>
 <label>
    A <input type="text" name="ate" id="ate" value="<?=$_GET['ate']?>" calendario="1" sonumero="1" mascara="__/__/____" style="width:75px;height:10px;" >
   	
 </label>
 <label >
    Que tenha na mensagem: <input type="text" name="parte_mensagem" id="parte_mensagem" value="<?=$_GET['parte_mensagem']?>" style="width:250px;height:10px;" >
  <input type="submit" name="filtrar" value="Sortear" />  	
 </label>
 <input type="hidden" name="tela_id" value="398" />
 
<input type="button" name="importar" id="importar" value="Importar" style="float:right;margin-top:3px;" onClick="window.open('<?=$caminho?>/form.php','carregador')">
<input type="button" name="exportar" id="exportar" value="Exportar" style="float:right;margin-top:3px;" onClick="window.open('modulos/eleitoral/sms_importado/exportar_mensagem.php?de=<?=$_GET['de']?>&ate=<?=$_GET['ate']?>&quantidade=<?=$_GET['quantidade']?>','carregador')">
<input type="button" name="grafico" id="grafico" value="Gráfico" style="float:right;margin-top:3px;">


</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="120">Data - Hora</td>
             <td width="100">Telefone</td>
             <td>Mensagem</td>
          
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
    		<?php
				$filtro='';		
				
					
					if(!empty($_GET['promocao_id'])){
						$filtro.=" AND promocao_id=".$_GET['promocao_id'];
					}
					
					if(!empty($_GET['parte_mensagem'])){
						$filtro.=" AND mensagem LIKE '%".$_GET['parte_mensagem']."%'";
					}
					
					if(!empty($_GET['de'])&&!empty($_GET['ate'])){
						$filtro.=" AND data_hora BETWEEN '".dataBrToUsa($_GET['de'])." 00:00:00' AND '".dataBrToUsa($_GET['ate'])." 00:00:00'";
					}
					
					if(!empty($_GET['filtrar'])){
						$inicio = " SELECT DISTINCT(telefone),id ";
						$filtro.=" ORDER BY RAND()";					
					}else{
						$inicio = " SELECT *";
					}
					
					if(!empty($_GET['quantidade'])){
						
						$filtro.=" LIMIT ".$_GET['quantidade']."";
					}				
				
				
				
					$registros= @mysql_result(mysql_query("SELECT COUNT(*) FROM eleitoral_sms_importados WHERE vkt_id='$vkt_id'"),0,0);
					$mensagens = mysql_query($t="$inicio FROM eleitoral_sms_importados WHERE vkt_id='$vkt_id' $filtro");
					
					if(empty($_GET['filtrar'])){
						while($mensagem=mysql_fetch_object($mensagens)){
							$data = substr($mensagem->data_hora,0,10);
							$data = DataUsaToBr($data);
							$hora = substr($mensagem->data_hora,11,5);
							$telefone = substr($mensagem->telefone,3);
							$telefone = "(".substr($telefone,0,2).")".substr($telefone,2,4)."-".substr($telefone,6,4);
							$tam_mensagem = strlen($mensagem->mensagem);
			?>
            <tr class="aplicavel">
             <td width="120"><?=$data." - ".$hora?></td>
             <td width="100"><?=$telefone?></td>
             <td><?=substr($mensagem->mensagem,0,$tam_mensagem-2)?></td>
          
        </tr>
        <?php
						}
					}else{
						while($mensagem=@mysql_fetch_object($mensagens)){
							$m = mysql_fetch_object(mysql_query($t="SELECT * FROM eleitoral_sms_importados WHERE id='$mensagem->id'"));
							//echo $t;
							$data = substr($m->data_hora,0,10);
							$data = DataUsaToBr($data);
							$hora = substr($m->data_hora,11,5);
							$telefone = substr($m->telefone,3);
							$telefone = "(".substr($telefone,0,2).")".substr($telefone,2,4)."-".substr($telefone,6,4);
							$tam_mensagem = strlen($m->mensagem);
		?>
        			<tr class="aplicavel">
             		<td width="120"><?=$data." - ".$hora?></td>
             		<td width="100"><?=$telefone?></td>
             		<td><?=substr($m->mensagem,0,$tam_mensagem-2)?></td>
          
        </tr>
		<?			
						}
					}			
		?>        						
	
    </tbody>
</table>
</div>
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