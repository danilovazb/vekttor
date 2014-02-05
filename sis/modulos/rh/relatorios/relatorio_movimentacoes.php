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
				
				if($_GET['cliente_fornecedor']==$cliente->id){
					$selected="selected='selected'";
					
				}
				
				echo "<option value='$cliente->id' $selected>$cliente->razao_social</option>";
				$selected='';
			}
		?>
    
    
    </select>
    
    <select name="mes" id="mes" style="margin-top:3px;">
    
    <?
		foreach($mes_extenso as $mes => $m){
			
			$valor = $mes+1;
			
			if($_GET['mes']==$valor){
				$selected="selected='selected'";
			}
			else if(empty($_GET['mes'])&&$valor==date('m')){
				$selected="selected='selected'";
				
			}
				echo "<option value='$valor' $selected>$m</option>";
				
			
			$selected='';
		
		}
	?>
    <label>
    	Ano<input type="text" style="width:30px;height:10px;margin-left:5px;" name="ano" id="ano" value="<? if(!empty($_GET['ano'])){echo $_GET['ano'];}else{ echo date("Y");}?>" />
    </label>
     <input type="submit" name="filtrar" id="filtrar" value="Filtrar" />
    
    </select>
    
    <button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" 
    onclick="window.open('modulos/rh/relatorios/impressao_movimentacao.php?cliente_fornecedor='+$('#cliente_fornecedor').val()+'&mes='+$('#mes').val()+'&ano='+$('#ano').val())" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
    
    <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    
</form> 
  </div>
<div id='dados'>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="200">Empresa</td>
            <td width="120">CNPJ</td>
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
    <tbody>
	
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
	
	if(!empty($_GET['cliente_fornecedor'])){
		$filtro_empresa = "cf.id='".$_GET['cliente_fornecedor']."' AND"; 
	}
	
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, cf.id as cliente_fornecedor_id FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		$filtro_empresa
		re.vkt_id ='$vkt_id' 
		$busca_add 
		$filtro 
		ORDER BY ".$ordem);
	//echo $t.mysql_error();
	while($r=mysql_fetch_object($q)){
		if($total%2){$sel='class="al"';}else{$sel='';}
		$total++;

		$empresa =	"<strong>$r->nome_fantasia</strong>";
		$cnpj	 = "<strong>$r->cnpj_cpf</strong>";
	
		
		if(empty($_GET['mes'])){
			$filtro_mes = "month(now())";
		}else{
			$filtro_mes = $_GET['mes'];
		}
		
		if(empty($_GET['ano'])){
			$filtro_ano = "YEAR(now())";
		}else{
			$filtro_ano = $_GET['ano'];
		}
		
		//consulta datas de admissoes
		$mq = mysql_query($t="SELECT * FROM rh_funcionario WHERE empresa_id='$r->id' AND month(data_admissao) = $filtro_mes AND YEAR(data_admissao) = $filtro_ano ");
		//echo $t.mysql_error();

		//consulta demissoes
		$mq2 = mysql_query($t="SELECT 
					* 
				   FROM 
					rh_funcionario_demitidos rh_fd,
					rh_funcionario rh_f 
				   WHERE
				   rh_fd.funcionario_id = rh_f.id AND 
					rh_fd.empresa_id='$r->id' AND 
					month(rh_fd.data_demissao) = $filtro_mes AND 
					YEAR(rh_fd.data_demissao) = $filtro_ano");


		$qt = mysql_num_rows($mq);
		$qt2 = mysql_num_rows($mq2);
		if($qt>0||$qtd2>0){
	?>
<tr <?=$sel?>>
<td width="200"><?=$empresa?></td>
<td width="120"><?=$cnpj?></td>
<td width="220"></td>
<td width="80"></td>
<td width="90"></td>
<td width="150"></td>
<td width="80"></td>
<td></td>
</tr>
<?
		
		$ff=0;
		while($rr = mysql_fetch_object($mq)){
			
		if($total%2){$sel='class="al"';}else{$sel='';}
			$total++;
			$ff++;
?>
<tr <?=$sel?>id="admissao" funcionario_id="<?=$rr->id?>" empresa_id="<?=$r->id?>">
<td width="200" align="right">Admissao</td>
<td width="120"> <?=DataUsaToBr($rr->data_admissao)?></td>
<td width="220"><?=$rr->nome?></td>
<td width="80"><?=DataUsaToBr($rr->data_nascimento)?></td>
<td width="90"><?=$rr->cpf?></td>
<td width="150"><?="$rr->carteira_profissional_numero/$rr->carteira_profissional_serie - $rr->carteira_profissional_estado_emissor"?></td>
<td width="80"><?=$rr->pis?></td>
<td></td>
</tr>
<?
		}
		//echo $t;					
		while($rr = mysql_fetch_object($mq2)){
		if($total%2){$sel='class="al"';}else{$sel='';}
			$total++;
			$ff++;
?>
<tr <?=$sel?> id="demissao" funcionario_id="<?=$rr->id?>" empresa_id="<?=$r->id?>">
<td width="200" align="right">Demissao</td>
<td width="120"> <?=DataUsaToBr($rr->data_demissao)?></td>
<td width="220"><?=$rr->nome?></td>
<td width="80"><?=DataUsaToBr($rr->data_nascimento)?></td>
<td width="90"><?=$rr->cpf?></td>
<td width="150"><?="$rr->carteira_profissional_numero/$rr->carteira_profissional_serie - $rr->carteira_profissional_estado_emissor"?></td>
<td width="80"><?=$rr->pis?></td>
<td></td>
</tr>
<?
		}
		}//if $qtd >0
	}
	?>	
    </tbody>
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