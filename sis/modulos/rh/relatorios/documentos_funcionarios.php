<?
//echo 'teste';
	//seleciona as empresas
	$cliente_fornecedor= mysql_query($t="SELECT *, cf.id as cliente_forencedor_id FROM 
	rh_empresas re,
	cliente_fornecedor cf 
	WHERE 
	re.cliente_fornecedor_id = cf.id AND
	cf.tipo='Cliente' AND 
	cf.tipo_cadastro='Jurídico' AND 
	re.vkt_id ='$vkt_id' AND 
	re.status='1' 
	$busca_add 
	$filtro 
	ORDER BY cf.razao_social");
	//echo $t.mysql_error();	

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
				$("#dados_funcionario").css("display","block");
				$("#dados_pis").css("display","none");
		
			}
			
			if(aba=="PIS"){ 
				$("#form_cliente").css("display","block");
				$("#dados_funcionario").css("display","none");
				$("#dados_pis").css("display","block");
		
			}
		
			if(aba=="Documentos"){ 
													
				$("#form_documentos").css("display","block");
		
			}
			
			if(aba=="Dependentes"){ 
													
				$("#form_dependentes").css("display","block");
		
			}	
			
			if(aba=="Contrato"){ 
													
				$("#form_contrato").css("display","block");
		
			}	
			
			
		}
		
	});
	
	$('#admissao,#demissao').live('click',function(){
	
		var funcionario_id = $(this).attr('funcionario_id');
		var empresa_id     = $(this).attr('empresa_id');
	
		window.open("modulos/rh/funcionarios/form.php?id="+funcionario_id+"&empresa1id="+empresa_id,"carregador")
		
		
	});
	
	$('.form_float').ready(function(){
		
		$('.form_float').css('display','none');
	});
	
	$("#cliente_fornecedor").live('change',function(){
		location.href='?tela_id=<?=$_GET['tela_id']?>&empresa_id='+$(this).val();
	});

</script>

<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">    
<form action="" method="get" >
    <select name="cliente_fornecedor" id="cliente_fornecedor" style="margin-top:3px;">
    	
        <option value="">Todas as Empresas</option>
        <?
			while($cliente = mysql_fetch_object($cliente_fornecedor)){
				
				if($_GET['empresa_id']==$cliente->id){
					$selected="selected='selected'";
					
				}
				
				echo "<option value='$cliente->id' $selected>$cliente->nome_fantasia</option>";
				$selected='';
			}
		?>
    
    
    </select>
    
    
    <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    
</form> 
  </div>
<div id='dados'>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="220">Funcionario</td>
          	<td width="80">Nascimento</td>
          	<td width="90">CPF</td>
			<td width="150">Carteira</td>
			<td width="80">PIS</td>
            <td></td>
        </tr>
    </thead>
</table>

<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="cf.nome_fantasia";
	}
	
	$filtro_empresa = '';
	
	if(!empty($_GET['empresa_id'])){
		$filtro_empresa = " cf.id='".$_GET['empresa_id']."' AND"; 
	}
	
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="
		SELECT *, cf.id as cliente_fornecedor_id FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		$filtro_empresa
		re.vkt_id ='$vkt_id' 
		$busca_add 
		$filtro
		ORDER BY ".$ordem);
		
	
	while($r=mysql_fetch_object($q)){
		
		$funcionarios = mysql_query("SELECT * FROM rh_funcionario WHERE empresa_id='$r->cliente_fornecedor_id'");
			
		if($total%2){$sel='class="al"';}else{$sel='';}
		$total++;

		$empresa =	"<strong>$r->nome_fantasia</strong>";
		$cnpj	 = "<strong>$r->cnpj_cpf</strong>";
	
	?>
<thead>
<tr <?=$sel?>>
<td colspan="6"><?=$empresa." ".$cnpj?></td>
</tr>
</thead>		
	<?php
		while($funcionario = mysql_fetch_object($funcionarios)){
	?>
    	<tbody>
			<td width="220"><?=$funcionario->id." ".$funcionario->nome?></td>
          	<td width="80"><?=DataUsaToBr($funcionario->data_nascimento)?></td>
          	<td width="90"><?=$funcionario->cpf?></td>
			<td width="150"><?=$funcionario->carteira_profissional_numero?></td>
			<td width="80"><?=$funcionario->pis?></td>
            <td>
            	<button type="button" onclick="window.open('modulos/rh/relatorios/impressao_documentos_funcionarios.php?f=<?=$funcionario->id?>')" class="botao_imprimir">
					<img src="../fontes/img/imprimir.png">
				</button>
            </td>
		</tbody>
	<?php		
		}
	}
	?>
 
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230">&nbsp;</td>
           <td width="120">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="80">&nbsp;</td>
           <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'></div>