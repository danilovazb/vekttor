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
<span></span>  Importaçao Rádio</a></div>
<div id="barra_info">
<form method="get">
	 
<input type="button" name="importar" id="importar" value="Importar" style="float:right;margin-top:3px;" onClick="window.open('<?=$caminho?>/form.php','carregador')">

</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           
             <td></td>
          
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<!--<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="tabela_dados">
    		<?php
				$filtro='';		
				//if(!empty($_GET['filtrar'])){
					
					
					if(!empty($_GET['de'])&&!empty($_GET['ate'])){
						$filtro.="AND data_hora BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
					}
					
					$filtro.=" ORDER BY RAND()";					
				
					if(!empty($_GET['quantidade'])){
						$filtro.=" LIMIT ".$_GET['quantidade']."";
					}else{
						$filtro.=" LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]);
					}
				//}
				
				
				
					$registros= @mysql_result(mysql_query("SELECT * FROM eleitoral_sms_importados WHERE vkt_id='$vkt_id' $filtro"),0,0);
					$mensagens = mysql_query($t="SELECT * FROM eleitoral_sms_importados WHERE vkt_id='$vkt_id' $filtro");
					
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
			
		?>        						
	
    </tbody>
</table>-->
</div>
</div>
<div id='rodape'>
	<!--Registros 
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
    </div>-->
</div>