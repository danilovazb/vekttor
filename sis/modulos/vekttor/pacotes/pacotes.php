<?
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});

$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="?tela_id=277" class='s1'>
  	Sistema
</a>
<a href="?tela_id=277" class='s2'>
  	Vekttor
</a>
<a href="?tela_id=277" class='navegacao_ativo'>
<span></span>    Pacotes
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
  <a href="modulos/vekttor/pacotes/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		window.open('modulos/vekttor/pacotes/form.php?id='+id,'carregador');
	});
});
$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
	
	$(".exibe_modulos").live('click',function(){
		id = $(this).attr('r');
		$(".exibe_modulos").css('font-weight','normal');
		$(this).css('font-weight','bold');
			$(".submodulos").hide();

		$("#div"+id).show();	
	
	})
	
	$("#marcarTodos").live("click",function(){
		//alert(this.checked);
		if(this.checked==true){
			$(this).parent().parent().find(".modulo_id").attr("checked","checked");			
		}else{
			$(this).parent().parent().find(".modulo_id").removeAttr("checked");
			
		}
	});
$(".modulo_id").live('click',function(){
			var id = $(this).attr('id');
			if($(this).is(':checked')){
				$("#pcDel input[value='"+id+"']").remove();
			} else if($(this).is(":not(:checked)")){
				var label = $('<input type="text" name="itemDelete[]" id="itemDelete" style="width:80px;" value="'+id+'">');
				$("#pcDel").append(label);
			}
})
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60">Codigo</td>
          <td width="300">Nome</td>
          <td width="80">Implanta&ccedil;&atilde;o</td>
          <td width="80">Treinamento</td>
          <td width="80">Mensalidade</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		$fim='';
		if(!empty($_GET['busca'])){
				if(is_numeric($_GET['busca']))
					$fim.=" WHERE id = '".$_GET['busca']."'";
				else
					$fim.=" WHERE nome LIKE '%".$_GET['busca']."%'";	
		}
		// necessario para paginacao
   		$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM pacotes $fim"),0,0);
		
		$sql = mysql_query($t="SELECT *	FROM pacotes $fim ORDER BY nome  LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));			
		//echo mysql_error();	
				while($pacote=mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$pacote->id?>" >
          <td width="60"><?=$pacote->id?></td>
          <td width="300"><?=substr($pacote->nome,0,100);?></td>
          <td width="80"><?=moedaUsaToBr($pacote->valor_implantacao)?></td>
          <td width="80"><?=moedaUsaToBr($pacote->valor_treinamento);?></td>
          <td width="80"><?=moedaUsaToBr($pacote->valor_mensalidade);?></td>
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
