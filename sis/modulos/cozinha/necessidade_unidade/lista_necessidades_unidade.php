<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
$tela_id=$tela->id;
include '_functions.php';
include '_ctrl.php';
pr($_POST);
?>
<script>

$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
})
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s2'>
  	Cozinha 
</a>
<a href="?tela_id=203" class="navegacao_ativo">
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">
   
<form method="get" action="">
Filtrar:
    
      
  
    <input type="hidden" name="unidade_id" value="<?=$_GET['unidade_id']?>" />
    Inicio
    <?
    if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
		
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
	
	?>
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     Fim
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    <? if($tela_id=='203'){ ?>
    <label>Unidade:
        <select name="forma_pagamento">
          <option value="0" >Contrato Evadin</option>
        </select>
    </label>
    <? } ?>
    <input type="submit" value="Ir" />
    
    <input name="action" type="button" value="Gerar Transfer�ncia de Mercadorias" onclick="document.getElementById('produtos_para_cotacao').submit()" style="margin:3px; float:right"  />
    <label>
	<input name="action" type="button" value="Salvar" style="margin:3px; float:right" onclick="location='?tela_id=203'" />
    </label>
<label>
	<input name="action" type="button" value="Imprimir" style="margin:3px; float:right" onclick="window.open('modulos/cozinha/remessa/impressao_pedido.php')"  />
</label>

</form>
	
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><?=linkOrdem("Produto.","nome",1)?></td>
          	<td width="100">Em Estoque</td>
            <td width="80">Necessidade</td>
            <td width="80">Estoque Min</td>
            <td width="80">Qtd Cotacao</td>
            <td width="50">Cotar</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
<?
	//selecionar contratos
	$produtos=array();
	$contratos_q=mysql_query("SELECT * FROM cozinha_contratos WHERE vkt_id='$vkt_id' AND unidade_id='$unidade_id' ");
	while($contrato=mysql_fetch_object($contratos_q)){
		//selecionar fichas do contrato e seus respectivos pessoas, e a soma da quantidade de pessoas q vao comer
		$fichas_contrato_q=mysql_query($q="
		SELECT
			DISTINCT(cf.id) as ficha_id, cf.peso as peso_receita, 
			cf.percapta_leve as peso_leve, cf.percapta_medio as peso_medio, cf.percapta_pesado as peso_pesado, cf.percapta_extra as peso_extra,
			SUM(ccr.pessoas) as pessoas, cc.pesagem as pesagem_contrato, cc.unidade_id as unidade_id
		FROM
			cozinha_cardapio_dia_refeicao as ccr,
			cozinha_fichas_tecnicas as cf,
			cozinha_contratos as cc
		WHERE
			ccr.ficha_tecnica_id=cf.id
			AND ccr.contrato_id = cc.id
			AND cc.id='{$contrato->id}'
			AND ccr.data >= '$filtro_inicio' AND ccr.data <= '$filtro_fim'	
		GROUP BY cf.id
		");
		echo $q;
		echo mysql_error();
		
		
		//listar fichas e calcular o fator multiplicador para qtd de ingredientes
		while($fichas_contrato=mysql_fetch_object($fichas_contrato_q)){	
			echo '<b>Ficha ID</b>: '.$fichas_contrato->ficha_id.' <b>Pessoas que v�o comer</b> : '.$fichas_contrato->pessoas;
			echo " <b>peso da receita:</b> ".$fichas_contrato->peso_receita.' ';
			echo " <b>pesagem contrato:</b> ".$fichas_contrato->pesagem_contrato.' ';
			if($fichas_contrato->pesagem_contrato=='leve'){
				$fator_multiplicador = $fichas_contrato->peso_leve/$fichas_contrato->peso_receita;
			}
			if($fichas_contrato->pesagem_contrato=='medio'){
				$fator_multiplicador = $fichas_contrato->peso_medio/$fichas_contrato->peso_receita;
			}
			if($fichas_contrato->pesagem_contrato=='pesado'){
				$fator_multiplicador = $fichas_contrato->peso_pesado/$fichas_contrato->peso_receita;
			}
			if($fichas_contrato->pesagem_contrato=='muito pesado'){
				$fator_multiplicador = $fichas_contrato->peso_extra/$fichas_contrato->peso_receita;
			}
			echo "<b>Fator Multiplicador</b>: ".$fator_multiplicador.'<br>';
			//pegar os produtos de cada ficha
			$ingredientes_q=mysql_query($xi="
			SELECT 
				p.id as produto_id, p.nome as nome, cfp.qtd as qtd, p.estoque_min as estoque_min, p.unidade_uso as unidade_uso
			FROM 
				cozinha_ficha_has_produto as cfp, produto as p
			WHERE 
				cfp.ficha_id='{$fichas_contrato->ficha_id}' AND p.id=cfp.produto_id ");
			//listar os produtos e fazer o calculo de qtd de ingredientes de cada produto
			while($ingrediente=mysql_fetch_object($ingredientes_q)){
				
				echo  " -- <b>produto:</b>{$ingrediente->nome} <b>-></b> QTD :{$ingrediente->qtd} * $fator_multiplicador * {$fichas_contrato->pessoas} =  ".$ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas."<br>";
				if(!$produtos[$ingrediente->produto_id]){
					$produtos[$ingrediente->produto_id]['nome'] = $ingrediente->nome;
					$produtos[$ingrediente->produto_id]['estoque_min'] = $ingrediente->estoque_min;
					$produtos[$ingrediente->produto_id]['unidade_id'] = $fichas_contrato->unidade_id;
					$produtos[$ingrediente->produto_id]['unidade_uso'] = $ingrediente->unidade_uso;
					$produtos[$ingrediente->produto_id]['em_estoque'] = checaEstoque($ingrediente->produto_id,0,$fichas_contrato->unidade_id);
				}
				$produtos[$ingrediente->produto_id]['qtd']+=($ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas);
			}
			
		}
	}
	//pr($produtos);
?>
<form id="produtos_para_cotacao" method="post" action="">
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
    	<? foreach($produtos as $produto_id=>$produto){ ?>
    	<tr onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')">   
        
            <td width="150"><?=$produto['nome']?></td>
          	<td width="100"><?=$produto['em_estoque']?></td>
            <td width="80"><?=$produto['qtd']?></td>
            <td width="80"><?=$produto['estoque_min']?></td>
            <td width="80" align="left">
            <? if($produto['em_estoque']>$produto['qtd']){$qtd_para_cotar=0;} $qtd_para_cotar= $produto['qtd']-$produto['em_estoque']; ?>
            	<input name="qtd_digitada[]" type="text" style=" width:50px; height:10px;" sonumero='1' value="<?=$qtd_para_cotar?>" /></td>
            <td width="50">
            	<input name="produto_id[]" value="<?=$produto_id?>" type="checkbox" />
                <input name="qtd_sistema[]" value="<?=$qtd_para_cotar?>" type="hidden" />
                <input name="unidade_uso[]" value="<?=$produto['unidade_uso']?>" type="hidden" />
            </td>
            <td></td>
         <? } ?>   
            
        </tr>

    </tbody>
</table>
</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><a>Total: <?=$total?></a></td>
            <td width="400">&nbsp;</td>
            <td></td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
	

</div>
