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

var tabAtual = 1
 
mudarTab = function(numeroTab) {
	$("#tab_"+tabAtual).toggle()
	$("#tab_"+numeroTab).toggle()
	tabAtual = numeroTab
}
/*$("#promocao").live('change',function(){
	location.href="?tela_id=<?=$_GET['tela_id']?>&promocao_id="+$(this).val();
});*/

$("#adicionaparticipante").live('click',function(){
	
	var participante     = $("#participante").val();
	var participante_id = $("#participante_id").val();
	var promocao_id	= $("#promocao").val();
	alert(participante_id);
	var dados = 'participante_id='+participante_id+'&promocao_id='+promocao_id;
	
	
	$.ajax({
				url: 'modulos/eleitoral/participante_promocao/adiciona_participante.php',
				type: 'POST',
				data: dados,
				success: function(data) {
					/*------ COLOCA O TOTAL NO FINAL DA TABELA ----*/
					alert(data);																
					//if(data.length>2){								
					//alert(data);
				
					//}
				},
		});	
	
	$("#dados").append("<tr class='aplicavel'><td>"+participante+"</td></tr>");
	
});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Eleitoral 
</a>
<a href="" class="navegacao_ativo">
<span></span>  Promoçoes</a></div>
<div id="barra_info">
	<form method="get">
    <label>
    	Quantidade <input type="text" name="quantidade" id="quantidade" value="<?=$_GET['quantidade']?>" style="width:30px;height:10px;">
  <!--<input type="submit" name="filtrar" value="Filtrar" />-->  	
 </label>
	<select name="promocao" id="promocao" style="margin-top:3px;">
   		<option value="">SELECIONE UMA PROMOÇAO</option>
		<?php
			$promocoes = mysql_query($t="SELECT * FROM eleitoral_promocao WHERE vkt_id='$vkt_id'");
			//echo $t;
			while($promocao = mysql_fetch_object($promocoes)){
		?>
        	<option value="<?=$promocao->id?>" <? if($_GET['promocao']==$promocao->id){ echo "selected='selected'";}?>><?=$promocao->descricao?></option>
        <?php
			}
		?>
        <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>"
    </select>
  <input type="submit" name="filtrar" value="Sortear" />  	
 </label>
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td style="width:50px;">Codigo</td>
            <td style="width:200px;">Participante</td>
   			<td style="width:200px;">E-mail</td>
            <td style="width:90px;">Telenone</td>
            <td style="width:300px;">Endereco</td>
            <td style="width:150px;">Premio</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody id="dados">
    <?
	if($_GET['quantidade']>0){
		$limite = "LIMIT ".$_GET['quantidade'];
	}else{
		$limite = "LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]);
	}
	$registros=@mysql_result(mysql_query($t="SELECT COUNT(*) FROM eleitoral_participante_promocao WHERE vkt_id=$vkt_id AND promocao_id='".$_GET['promocao']."'"),0,0); 
	//echo $registros;
	$promocoes=mysql_query($t="SELECT * FROM eleitoral_participante_promocao WHERE vkt_id=$vkt_id AND promocao_id='".$_GET['promocao']."'  ORDER BY RAND() $limite");
	//echo $t;
	
	while($promocao=mysql_fetch_object($promocoes)){
		$participante = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_eleitores WHERE id='$promocao->eleitor_id'"));
	?>
    	<tr class="aplicavel">
   	 	   	 <td style="width:50px;"><?=$participante->id?></td>
             <td style="width:200px;"><?=$participante->nome?></td>
             <td style="width:200px;"><?=$participante->email?></td>
             <td style="width:90px;"><?=$participante->telefone1?></td>
             <td style="width:300px;"><?=$participante->endereco.", ".$participante->bairro." - ".$participante->cidade."/".$participante->estado?></td>
             <td style="width:150px;"><?=$participante->descricao_bens?></td>
               <td></td>
        </tr>
    <?
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
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&promocao=<?=$_GET['promocao']?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador],array('promocao'=>$_GET['promocao']))?>
    </div>
</div>