<?php
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});

$("#para").live('change',function(){
	
	$("#divbuscafuncionario").css("display","none");
	$("#divbuscacargo").css("display","none");
	$("#divbuscaempresa").css("display","none");
		$("#cargo_id").val('0');
		$("#buscacargo").val('');
		$("#buscaempresa").val('');
		$("#empresa id").val('0');
		$("#funcionario_id").val('0');
		$("#buscafuncionario").val('');
	
	/*if($(this).val()=="todos"){
		
		$("#divbuscacargo").css("display","block");	
	}*/
	if($(this).val()=="cargos"){
		$("#divbuscacargo").css("display","block");	
	}
	
	if($(this).val()=="funcionarios"){
		$("#divbuscafuncionario").css("display","block");		
	}
	
	if($(this).val()=="empresa"){
		$("#divbuscaempresa").css("display","block");		
	}
	if($(this).val()=="cargo_empresa"){
		
		$("#divbuscaempresa,#divbuscacargo").css("display","block");
			
	}	
});

function funcao_bsc2(resultado,acao,origem){	
	
	actions_W= acao.split('|');
	//alert(actions_W);
//	document.title=resultado.innerHTML+','+resultado.getAttribute('r0')+','+resultado.getAttribute('r1')+','+resultado.getAttribute('r2')+','+acao+','+origem+','+actions_W.length;
	
	//document.getElementById(origem).value=resultado.getAttribute('r0');
	
	for(w=0;w<actions_W.length;w++){
		vlores_e_locais = actions_W[w].split("-");
		local_e_acao = vlores_e_locais[1].split('>');
		
		valor = vlores_e_locais[0].replace(/@/g,'');
		local = local_e_acao[0];
		acao_W  = local_e_acao[1];
		
		if(local=='innerHTML'){
			document.getElementById(acao_W).innerHTML=resultado.getAttribute(valor);
		}else if(local=='value'){
			document.getElementById(acao_W).setAttribute('value',resultado.getAttribute(valor));
			document.getElementById(acao_W).value=resultado.getAttribute(valor);
		}else{
			document.getElementById(acao_W).setAttribute(local,resultado.getAttribute(valor));
		}
	}
	/*--------- funcoes para pegar valor e enviar a requisicao para o servidor via ajax ----------------------*/
	var empresa_id    = $("#empresa_id").val();
	var acao          = 'cargo';
	
	//linha = $("<tr><td>"+nome+"</td><td></td> <td></td> <td></td> <td></td> </tr>");ocorrencia	
	//linha.appendTo("#tbody");
	//alert(produto_id);
	
	//document.title=nlinhas;
	var dados = 'empresa_id='+empresa_id+'&acao=cargo';;
						
						$.ajax({
							url: 'modulos/rh/eventos/busca.php', 
							dataType: 'html',
							type: 'GET',
							data: dados,
							success: function(data, textStatus) {
								//$('#tbody').append(data);
								//$("tr:odd").addClass('al');
							},
						}); /* Fim Ajax*/					
}
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
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    Departamento Pessoal
</a>
<a href="?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">
<span></span>    <?=$tela->nome?> 
</a>
</div>
<div id="barra_info">
  <a href="modulos/rh/eventos/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/rh/eventos/form.php?id='+id,'carregador');
	});
});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60"><?=linkOrdem("Codigo","Codigo",1)?></td>
          <td width="200">Nome</td>
          <td width="80">Valor</td>
          <td width="100">Tipo</td>
          <td width="200">Empresa</td>
          <td width="200">Cargo</td>
          <td width="200">Funcionário</td>
          <td width="50">Tributado</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		/*if($cliente_tipo_id!='7'){
			$filtro_servicos=" WHERE c.imobiliaria_id='$login_id' ";
		}else{
			$filtro_corretores=' WHERE 1=1 ';
		}*/
		if(!empty($_GET['busca'])){
			$filtro = " AND nome like '%".$_GET['busca']."%'";
		}
		
		$registros= mysql_result(mysql_query("SELECT count(*) FROM rh_eventos WHERE vkt_id='$vkt_id'
							$filtro"),0,0);
		
		$sql = mysql_query($t="SELECT
								*
							FROM rh_eventos WHERE vkt_id='$vkt_id'
							$filtro
						");
						
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
					$empresa     = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$r->empresa_id'"));
					$cargo       = mysql_fetch_object(mysql_query($t="SELECT * FROM cargo_salario      WHERE id='$r->cargo_id  '"));
					$funcionario = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario     WHERE id='$r->funcionario_id'"));			
					
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" >
          <td width="60"><?=$r->id?></td>
          <td width="200"><?=$r->nome?></td>
          <td width="80"><?php if($r->forma_valor=='0'){ echo "R$ ".MoedaUsaToBr($r->valor);}else{ echo MoedaUsaToBr($r->valor)." %";} ?></td>
          <td width="100"><?php echo $r->vencimento_ou_desconto?></td>
          <td width="200"><?=$empresa->razao_social?></td>
          <td width="200"><?=$cargo->cargo?></td>
          <td width="200"><?=$funcionario->nome?></td>
          <td width="50"><?php if($r->tributado=='sim'){ echo "Sim";}else{echo "Não";}?></td>
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
