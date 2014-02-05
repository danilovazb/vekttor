<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
	
	$("#grupo_id").live("change",function(){
		var grupo_id = $(this).val();
		//alert(grupo_id);
		if(grupo_id!="novo"){
			$("#botoes").text("");
			$("#botoes").append("<input type='button' value='Editar' id='edt_grupo'><input type='button' value='filtrar' id='filtrar'>");
		}else if(grupo_id=="novo"){
			window.open('modulos/administrativo/clientes/form_grupo.php','carregador');
		}else{
			$("#botoes").text("");
		}
	});
	$("#edt_grupo").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		//alert(grupo_id);
		window.open('modulos/administrativo/clientes/form_grupo.php?grupo_id='+grupo_id,'carregador');
	});
	$("#filtrar").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		location.href='?tela_id=15&grupo_id='+grupo_id+'&filtro=filtrar';
	});
	/*$("#botoes button").on("click",function(event){
			window.open('modulos/administrativo/clientes/form_exportar.php','carregador');	
	});*/
	$("#exportar").live("click",function(event){
			//alert('ater');
			
			window.open('modulos/administrativo/clientes/form_exportar.php?tipo=Cliente','carregador');	
	});
	
	$("#aniversariante").live("click",function(event){
			//alert('ater');
			location.href='?tela_id=15&aniversariantes=sim';	
	});
	/*$("#foto_cliente").live("change",function(){
		var input = $("<input>").attr("type", "hidden").attr("name", "action").val("Salvar");
		$('#form_cliente').append($(input));
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		
	});*/
	$('.remover_foto').live('click',function(){
		
		$('.div_foto_cliente').css('display','none');
		$('#action2').val("ExcluirFoto");
		
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		$("#form_cliente").attr("target","");
		$('#action2').val("");
	});
	
	
	$('#add_documento').live('click',function(){
		
		var descricao_documento = $("#descricao_documento").val();
		$('#action2').val("adicionarDocumento");
		
				
		$("#dados_documentos").append("<tr><td style='width:250px;'><img src='../fontes/img/menos.png' class='remove_documento'>"+descricao_documento+"</td><td style='width:30px;' align='center'><a class='download_documento'><img src='../fontes/img/baixar.png' class='download'/></a></td></tr>");
		//var
		
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		$("#form_cliente").attr("target","");
		$('#action2').val("");
		
	});
	
	$('.remove_documento').live('click',function(){
		var id =  $(this).parent().parent().attr('id');
		
		$("#id_documento_exclusao").val(id);
		
		$('#action2').val("excluirDocumento");		
		
		$("#form_cliente").attr("target","carregador");
		$("#form_cliente").submit();
		$("#form_cliente").attr("target","");
		$('#action2').val("");
		$(this).parent().parent().remove();
	});
	
	$('.download_documento').live('click',function(){
		var id =  $(this).parent().parent().attr('id');
		
		window.open("modulos/administrativo/clientes/downloadDocumento.php?documento_id="+id,"carregador");
	});	
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id='some'>«</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    Administrativo 
</a>
<a href="" class="navegacao_ativo">
<span></span>    Clientes 
</a>
</div>
<div id="barra_info">
    <select name="grupo_id" id="grupo_id" style="float:left; margin-top:3px;" title="Adicionar Grupo de Clientes" data-placement="right">
    	<option value="">Grupos</option>
        <option value="novo">Adicionar</option>
		<?php
			$grupos = mysql_query("SELECT * FROM cliente_fornecedor_grupo WHERE tipo = 'C' AND vkt_id='$vkt_id'");
			while($grupo = mysql_fetch_object($grupos)){
				$existe = @mysql_num_rows(mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND grupo_id='$grupo->id'"));
		?>
        	<option value="<?=$grupo->id?>" <?php if($grupo->id==$_GET['grupo_id']){ echo "selected='selected'";}?>><?=$grupo->nome?> (<?=$existe?>)</option>
        <?php
			}
		?>
    </select>
    <div id="botoes" style="float:left;margin-top:3px;">
    	<?php
			if($_GET['grupo_id']>0){
				echo "<input type='button' value='Editar' id='edt_grupo'><input type='button' value='filtrar' id='filtrar'>";
			}
		?>
     
    </div>
     <button type="button" name="exportar" id="exportar" title="Exportar Clientes" data-placement="right" style="float:left; margin-top:3px;"> Exportar </button>
     <button type="button" name="aniversariante" id="aniversariante" title="Lista os aniversariandes de hoje" data-placement="right" style="float:left; margin-top:3px;">Aniversariante de Hoje</button>  
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
       
            <td width="230"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
          	<td width="130"><?=linkOrdem("CNPJ/CPF","cnpj_cpf",0)?></td>
          	<td width="110"><?=linkOrdem("Telefone","telefone1",0)?></td>
          	<td width="80"><?=linkOrdem("Tipo","tipo_cadastro",0)?></td>
			<td width="110">Grupo</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['filtro']=="filtrar"&&$_GET['grupo_id']>0){
		$filtro = "AND grupo_id='".$_GET['grupo_id']."'";
	}
	if($_GET['aniversariantes']=='sim'){
	// necessario para paginacao
   		$filtro = "AND DAY(nascimento)='".date('d')."' AND MONTH(nascimento)='".date('m')."'";
	}
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome_fantasia";
	}
	$registros= mysql_result(mysql_query("SELECT count(*) FROM cliente_fornecedor WHERE tipo='Cliente' AND cliente_vekttor_id ='$vkt_id' $busca_add ORDER BY nome_fantasia"),0,0);
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT * FROM cliente_fornecedor WHERE tipo='Cliente' AND cliente_vekttor_id ='{$_SESSION['usuario']->cliente_vekttor_id}' $busca_add $filtro ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">
<td width="230"><?=$r->nome_fantasia?></td>
<td width="130"><?=$r->cnpj_cpf?></td>
<td width="110"><?=$r->telefone1?></td>
<td width="80"><?=$r->tipo_cadastro?></td>
<td width="110"><?
           $grupo = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor_grupo WHERE id='$r->grupo_id'"));
		   echo $grupo->nome;
			?></td>
<td></td>
</tr>
<?
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
       
            <td width="230"><a>Total: <?=$total?></a></td>
          	<td width="130"></td>
          	<td width="110"></td>
          	<td width="80"></td>
			<td width="110"></td>
            <td></td>
        </tr>
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
