<?
include("_functions.php");
include("_ctrl.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	RH
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<script>
	$(".link_form").live("click",function(){
		
		var aba = $(this).text();
		var id = $("#id").val();
					
		if(id<=0){
			alert('Por favor, Digite os dados do Funcionário e clique em Salvar');
		}else{
			
			$(".form_float").css("display","none");
			
				
			if(aba=="Dados"){ 	
				$("#form_cliente").css("display","block");
			}
		
			if(aba=="Documentos"){ 
				$("#form_documentos").css("display","block");
			}
			
			if(aba=="Dependentes"){ 
				$("#form_dependentes").css("display","block");
			}	
			
		}
		
	});
	
	$("#adicionar_documento").live("click",function(){
		
		$("#form_documentos").submit();
		
	});
	
	$("#remove_documento").live('click',function(){
		var documento_id=$(this).parent().parent().attr("id_documento");
		var funcionario_id   =$("#id").val();
		//var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "funcionario_id="+funcionario_id+"&documento_id="+documento_id+"&remove_documento=1";
		//alert(dados);			
		$("#dados_documentos").load("modulos/rh/funcionarios/tabela_documentos.php?"+dados);		
	});
	
	function replaceAll(string, token, newtoken) {
		while (string.indexOf(token) != -1) {
 			string = string.replace(token, newtoken);
		}
		return string;
	}
	
	$("#adicionar_dependente").live("click",function(){
	
					
				var funcionario_id   =$("#id").val();
				var nome   =replaceAll($("#nome_dependente").val()," ","_");
				
							
				var data_nascimento   =$("#data_nascimento_dependente").val();
				var grau_parentesco   =$("#grau_parentesco_dependente").val();
				
				//alert(numparcelas);		
				var dados = "funcionario_id="+funcionario_id+'&nome='+nome+"&data_nascimento="+data_nascimento+"&grau_parentesco="+grau_parentesco+"&adicionar_dependente=1";
				
				$("#nome_dependente").val('');
				$("#data_nascimento_dependente").val('');
				
				
				$("#dados_dependentes").load("modulos/rh/funcionarios/tabela_dependentes.php?"+dados);		
											
	
	});
	
	$("#remove_dependente").live('click',function(){
		var dependente_id=$(this).parent().parent().attr("id_dependente");
		var funcionario_id   =$("#id").val();
		//var empresa_id   =$("#cliente_fornecedor_id").val();
				
						//alert(numparcelas);		
		var dados = "funcionario_id="+funcionario_id+"&dependente_id="+dependente_id+"&remove_dependente=1";
		//alert(dados);			
				$("#dados_dependentes").load("modulos/rh/funcionarios/tabela_dependentes.php?"+dados);		
	});
	
	$("#f_quando_estrangeiro").live('change',function(){
		
		if($(this).val()=="sim"){
			$("#estrangeiro").css("display","block");			
		}else{
			$("#estrangeiro").css("display","none");	
		}
	});
	
	$("#seguro_desemprego").live('click',function(){
		
		var funcionario_id = $("#funcionario_id").val();
		var modelo = 'seguro_desemprego';
		
		
		//alert(modelo);
		window.open('modulos/rh/seguro_desemprego/cd_mod2.php?modelo='+modelo+'&funcionario_id='+funcionario_id);
	});	
	
	$("#comunicado_dispensa").live('click',function(){
		var funcionario_id = $("#funcionario_id").val();
		var modelo = 'comunicado_dispensa';
		window.open('modulos/rh/seguro_desemprego/cd_mod2.php?modelo='+modelo+'&funcionario_id='+funcionario_id);
	});
	
	$(".imprimir_relatorio").live('click',function(){
		
		var id=$("#funcionario_id").val();
		var relatorio = $(this).val();
		
		switch(relatorio){
			case 'Ficha de Empregado 1': window.open('modulos/rh/funcionarios/ficha_registro_empregado.php?id='+id);break;
			case 'Ficha de Empregado 2': window.open('modulos/rh/funcionarios/ficha_registro_empregado2.php?id='+id);break;
			case 'Imprimir PIS': window.open('modulos/rh/funcionarios/ficha_pis.php?id='+id);break;
			case 'Termo de Opçao': window.open('modulos/rh/funcionarios/termo_opcao.php?id='+id);break;
		}
		//window.open('modulos/rh/funcionarios/impressao_contrato_experiencia.php?id='+id);
	});

  $("#resumo_funcionario").live("click",function(){
	  var id = $("#funcionario_id").val();
	  window.open('modulos/rh/demissao_funcionario/impressao_demissao.php?funcionario_id='+id);
  });
  
  $("#mes_inteiro").live( "click", function() {
	  if($(this).is(":checked")){
		  $("#dias").attr('disabled','disabled');
		  $("#dias").css('background','#ccc');
	  } else if($(this).not(":checked")){
		  $("#dias").removeAttr('disabled');
		  $("#dias").css('background','#F5F5F5');
	  }	
  });
  $("#data_aviso_previo").live("blur",function(){
		  
		  //DEMISSAO
		  var valor = $(this).val();
		  $("#data_demissao").val(valor);
		  var d = valor.split("/");
		  var mes_demissao = d[1]*1;
		  
		  //ADMISSAO
		  var data_admissao = $("#data_admissao").val();
		  var a = data_admissao.split("-");
		  var mes_admissao = a[1]*1;
		  var result = 0;
		  
		  //CALCULO 
		  if(mes_admissao > mes_demissao){
		   result = (12 + 1) - (mes_admissao - mes_demissao);
			  
		  }else{
		   result = (mes_demissao - mes_admissao) + 1;
		  
		  }
		   
		  //RESULTADO 
		  $("#ferias_proporcional").val(result); 
		  $("#dias").val(d[0]);
		  $("#decimo_proporcional").val(d[1]);
		  
  });

  $("#cumprir_aviso_previo").live("click",function(){
	  var aviso_previo = $("#data_aviso_previo").val(); 
	  var data_aviso_previo = aviso_previo.split("/");
	  var dta_afastamento = new Date(parseInt(data_aviso_previo[2], 10),parseInt(data_aviso_previo[1], 10) - 1,parseInt(data_aviso_previo[0], 10));
	  dta_afastamento.setDate(dta_afastamento.getDate() + 30);
	  
	  var dia = dta_afastamento.getDate(); 
	  var mes = (dta_afastamento.getMonth() + 1);
	  var ano = dta_afastamento.getFullYear();
	  //alert(dia+"/"+mes+"/"+ano); 
  });
</script>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="hidden" name="empresaid" value="<?=$_GET['empresaid']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">    
<strong>EMPRESA:</strong> <?=$empresa->razao_social?> <strong>CNPJ:</strong><?=$empresa->cnpj_cpf?>
  <!--<a href="modulos/rh/funcionarios/form.php?empresa1id=<?$empresa->id?>" target="carregador" class="mais"></a>-->
	<form action="" method="get" style="float:right;margin-right:15px;margin-top:4px;">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="hidden" name="empresaid" value="<?=$_GET['empresaid']?>" />
    
    
	<?php
		if($_GET['status_funcionarios']=='demitidos'){		
	?>
	<input type="hidden" name="status_funcionarios" value="admitidos" />
    <input type="submit" value="Funcionários Admitidos" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
    <?php
		}else{
	?>
    <input type="hidden" name="status_funcionarios" value="demitidos" />
    <input type="submit" value="Funcionários Demitidos" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>    
    <?php
		}
	?>
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Funcionário","nome",1)?></td>
          	<td width="98" >Cargo</td>
       	 	<td width="98" >Status</td>
            <td width="98" >Período de Férias</td>
            <td width="98" >Retorno de Férias</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
	//$empresa_id=$_GET['empresa_id'];
	if(!empty($_GET['busca'])){
		$filtro = " AND nome like '%".$_GET['busca']."%'";
	}
	
	if(!empty($_GET['status_funcionarios'])){
		$status_funcionario = "status='".$_GET['status_funcionarios']."'";
	}else{
		$status_funcionario = "status='admitidos'";
	}
	
	$registros= mysql_result(mysql_query("SELECT count(*) FROM 
					  	rh_funcionario f
					  WHERE 
					  	empresa_id='".$empresa->id."' AND
						$status_funcionario AND
					  	vkt_id='$vkt_id'
						$filtro"),0,0);
	$q = mysql_query($t="SELECT * FROM 
					  	rh_funcionario
					  	
					  WHERE 
					  	empresa_id='".$empresa->id."' AND
						$status_funcionario AND
						vkt_id='$vkt_id'						
						$filtro
						ORDER BY nome
						LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	
	while($r=mysql_fetch_object($q)){
		
		//verifica se o usuário está em férias
		$ferias = mysql_fetch_object(mysql_query("SELECT 
														* 
													FROM 
														rh_ferias 
													WHERE 
														MONTH(data_inicio) = MONTH( NOW() ) AND 
														YEAR(data_inicio)  = YEAR( NOW() )"));
		
		
		
		
		if($ferias->id>0){
			$status = "Em férias";
			$periodo_ferias = "De ".DataUsaToBr($ferias->data_inicio)." à ".DataUsaToBr($ferias->data_fim);
			$data_retorno_ferias = mysql_fetch_object(mysql_query("SELECT DATE_ADD($ferias->data_inicio, INTERVAL 30 DAY) as data_retorno"));
			$data_retorno_ferias = $data_retorno_ferias->data_retorno;	
		}else{
			$status = " - ";
			$periodo_ferias = " - ";
			$data_retorno_ferias = "-";
		}
				
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
	?>       
    	<tr <?=$sel ?> onclick="window.open('modulos/rh/demissao_funcionario/form.php?id=<?=$r->id?>&empresa1id=<?=$_GET['empresaid']?>','carregador')" >
          	<td width="209" ><?=$r->nome?></td>
          	<td width="98" align="right"><?=$r->cargo?></td>
            <td width="98" ><?=$status?></td>
            <td width="98" ><?=$periodo_ferias?></td>
            <td width="98" ><?=$data_retorno_ferias?></td>
            <td></td>
        </tr>
      
<?
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"></td>
            <td width="98"align="right"></td>
            <td width=""></td>
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
<script>
$('#sub93').show();
$('#sub418').show()
</script>