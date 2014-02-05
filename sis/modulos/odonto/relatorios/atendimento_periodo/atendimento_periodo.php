<?
session_start();
$forma_pagamento = array("1"=>"Dinheiro","2"=>"Cheque","4"=>"Boleto","5"=>"Permuta","6"=>"Outros","7"=>"Transferencia","8"=>"Depósito",
						 "3"=>"Cartão de Crédito Visa","9"=>"Cartão de Crédito Master","10"=>"Débito Master","11"=>"Débito Visa","12"=>"Cielo Débito",
						 "13"=>"Cielo Débito");
//include("_functions.php");
//include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id          = $(this).attr('id');
		var data_inicio = $(this).attr('data_inicio');
		var data_fim    = $(this).attr('data_fim');
		
		window.open('modulos/odonto/relatorios/form_atendimento_odontologo.php?id='+id+'&data_inicio='+data_inicio+'&data_fim='+data_fim+'&acao=odontologo','carregador');
	});
});
$(".botao_imprimir").live('click',function(){
	window.open('modulos/tela_impressao.php?url=');
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	Odontologo
</a>
<a href="?tela_id=302" class='navegacao_ativo'>
<span></span>    Atendimento Período
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
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			$data_inicio="01/".date("m/Y");
			$data_fim=date("t/m/Y");
		}else{
			$data_inicio=$_GET['de'];
			$data_fim=$_GET['ate'];
		}?>
  <button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" id="impressao" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
  <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$data_inicio;?>" style="height:8px;"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$data_fim;?>" height="7" style="height:8px;"/>
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	</form>
    
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>

<div id='dados' >

<div id="info_filtro">
Atendimento Por Período.<br />
<?="Perído: ".$data_inicio." à ".$data_fim?>
</div>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="200">Paciente</td>
          <td width="200">Convenio</td>
          <td width="160">Procedimento</td>
          <td width="60">Valor</td>
          <td width="120">Forma de Pagamento</td>
          <td width="200">Observações</td>
           <td></td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro      = " AND data_cadastro BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
			$data_inicio = dataBrToUsa($_GET['de']);
			$data_fim    = dataBrToUsa($_GET['ate']);
		}else{
			$mes_atual=date("m");
			$filtro      = " AND MONTH(data_cadastro) = '$mes_atual'";
			$data_inicio = date("Y")."-$mes_atual-01";
			$data_fim = date("Y")."-$mes_atual-".date("t");
		}
		
		if(!empty($_GET['busca'])){
			$busca = "AND cf.razao_social LIKE '%".$_GET['busca']."%' OR cf.id LIKE '%".$_GET['busca']."%'";
		}
		
		$registros= @mysql_result(mysql_query("SELECT 
								COUNT(*)
							   FROM 
								odontologo_atendimento_item oo,
								servico s,
								cliente_fornecedor cf								
							   WHERE
							   	oo.vkt_id = '$vkt_id' AND
								oo.servico_id = s.id AND
								oo.cliente_fornecedor_id = cf.id AND
								oo.data_cadastro BETWEEN '".$data_inicio."' AND '".$data_fim."'
							  	$busca
								ORDER BY oo.id DESC"),0,0);

		$sql = mysql_query($t="SELECT 
								*, s.nome as nome_servico, oo.valor as valor_procedimento
							   FROM 
								odontologo_atendimento_item oo,
								servico s,
								cliente_fornecedor cf								
							   WHERE
							   	oo.vkt_id = '$vkt_id' AND
								oo.servico_id = s.id AND
								oo.cliente_fornecedor_id = cf.id AND
								oo.data_cadastro BETWEEN '".$data_inicio."' AND '".$data_fim."'
							  	$busca
								ORDER BY oo.id DESC
							   LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		echo mysql_error();	
		$cont=0;
		$valor_procedimento=0;
		$count_cliente=0;
		while($r=mysql_fetch_object($sql)){
			$convenio = mysql_fetch_object(mysql_query($t="SELECT * FROM
															odontologo_atendimentos oa, 
															cliente_fornecedor cf 
														WHERE
															oa.id = '$r->odontologo_atendimento_id' AND
															oa.convenio_id = cf.id
															"));
				
				
				 
				if($r->cliente_fornecedor_id==$cliente_anterior){
					
					
					
				}else{
					$count_cliente=0;
				}
				
				$movimento_financeiro = mysql_fetch_object(mysql_query($t="SELECT 
																						* 
																					FROM 
																						financeiro_movimento 
																					WHERE 
																						internauta_id='$r->cliente_fornecedor_id' AND 
																						doc='$r->odontologo_atendimento_id' AND
																						origem_tipo='odonto'
																						LIMIT $count_cliente,1
																					"));
				//echo "Movimento Fianceiro: ".$movimento_financeiro->id." ";
				$cliente_anterior = $r->cliente_fornecedor_id;
			 $cont++;
			 if($cont%2==0){$c="al";}else{$c="";}
			$valor_procedimento+=$r->valor_procedimento
	?>
    		<tr id="<?=$r->usuario_id?>" data_inicio="<?=$data_inicio?>" data_fim="<?=$data_fim?>">
            	<td width="200"><?=$r->razao_social?></td>
                <td width="200">
                <?
                if(empty($convenio->id)){
				    echo "-";
				}else{
					echo $convenio->razao_social;
					
				}
				?>
                 </td>
                <td width="160"><?=$r->nome_servico?></td>
                <td width="60" align="right"><?=moedaUsaToBr($r->valor_procedimento)?></td>
                <td width="120"><?=$forma_pagamento[$movimento_financeiro->forma_pagamento]?></td>
          		<td width="200"><?=$movimento_financeiro->nota?></td>
                <td></td>
	<?php
		}
	?>
    </tr>
    	
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>
<div id="total">
<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
          <td width="200">&nbsp;</td>
          <td width="200">&nbsp;</td>
          <td width="160">&nbsp;</td>
          <td width="60" align="right"><?=moedaUsaToBr($valor_procedimento)?></td>
          <td width="120">&nbsp;</td>
          <td width="200">&nbsp;</td>
           <td></td>
        </tr>
    </thead>
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
