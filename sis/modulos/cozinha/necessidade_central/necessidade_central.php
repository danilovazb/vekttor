<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
$tela_id=$tela->id;
include '_functions.php';
include '_ctrl.php';
//pr($_POST);
?>
<script>

$(document).ready(function(){
	$("#dados tr:nth-child(2n+1)").addClass('al');
	
	$("#cotar_todos").click(function(){
		if($(this).is(':checked')){
			$(".cotar").attr('checked',true)
			$(".cotar").parent().parent().find("input").removeAttr( "disabled")
		}else{
			$(".cotar").attr('checked',false)
			//$(".cotar").parent().parent().find("input").attr( "disabled",'disabled')
			
		}
	})
	
})

$(".cotar").live('click',function(){
	if($(this).is(":checked")){
			$(this.parentNode.parentNode).find("input").removeAttr( "disabled");
			//$(this).val('1');		
			//console.log($(this))
	}else{
			$(this.parentNode.parentNode).find("input").attr( "disabled",'disabled');	
			$(this).removeAttr( "disabled");
			//$(this).val('');
			//console.log($(this));
	}
});

$(".mostrar_detalhes").live('click',function(){
	$(".escondido").hide();
	id=$(this).attr('id')
	$("#modal"+id).show();
	$("#modal"+id+" .sub-janela").show();
	$(".janela").show();
	$(".mostrar_detalhes").show();
});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
	.g{background:url(../fontes/img/bb.jpg); font-weight:bold; }
	.escondido{  position:absolute; display:none; color:black !important;left:70%;}
	.modal-body table tr td{ background:white !important;color:black !important;}
	.modal-body table tr td:hover{ background:white !important; color:black !important;}
</style>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onKeyDown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some"><<</div>

<a href="#" class='s1'>
	SISTEMA
</a>
       
<a href="./" class='s2'>
  	Cozinha 
</a>
<a href="" class="navegacao_ativo">
<span></span>    <?=$tela->nome?>
</a>
</div>
<div id="barra_info">
   
<form method="get">
Filtrar:
    
      
  
    <input type="hidden" name="tela_id" value="117" />
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
    <label>
    	<select name="grupo_id">
        
        	<option value="0">Grupo de Produto</option>
         <? $grupo_produtos_q=mysql_query("SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
		 	
			while($grupo=mysql_fetch_object($grupo_produtos_q)){
				if($_GET['grupo_id']==$grupo->id){ $sel="selected='selected'";}else{$sel='';}
		 		
		 ?>   
         	<option <?=$sel?> value="<?=$grupo->id?>"><?=$grupo->nome?></option>
         <?
			}
		 ?>
        </select>
    </label>
     <label>
    	<select name="almoxarifado_id">
        
        	
         <? $almoxarifados=mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); 
		 	$c=0;
			while($almoxarifado=mysql_fetch_object($almoxarifados)){
				if($_GET['almoxarifado_id']==$almoxarifado->id){ $sel="selected='selected'";}else{$sel='';}
				if($c==0){$primeira_unidade=$almoxarifado->id;}
		 		$c++;
		 ?>   
         	<option <?=$sel?> value="<?=$almoxarifado->id?>"><?=$almoxarifado->nome?></option>
         <?
			}
		 ?>
        </select>
    </label>
    
    <label>
      <select name="produto_necessidade" style="width:90px;">
         <option value="0" <? if( $_GET["produto_necessidade"] == 0) echo 'selected="selected"'; ?> >Todos</option>
         <option value="1" <? if( $_GET["produto_necessidade"] == 1) echo 'selected="selected"'; ?> >Somente necessidade</option>
      </select>
    </label>
    
    <input type="submit" value="Ir" />
    
    <input name="action" type="button" value="Gerar Cotação de acordo Necessidades" onClick="document.getElementById('produtos_para_cotacao').submit(); console.log()" style="margin:3px; float:right"  />
</form>
	
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><?=linkOrdem("Produto.","nome",1)?></td>
          	<td width="80">Est. Destino</td>
            <td width="80">Necessidade</td>
            <td width="100" rel="tip" title="Necessidade Embalagem">Necess. Emb.</td>
            <td width="80">Estoque Min</td>
            <td width="140">Qtd Cotacao</td>
            <td width="190">Obs</td>
            <td width="60">Cotar <input id="cotar_todos" type="checkbox" checked="checked" /> </td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<?


	
	//selecionar contratos
	$produtos=array();
	/*if(empty($_GET['almoxarifado_id'])){
		$fim = "AND unidade_id='$primeira_unidade'";
	}else{
		$fim = "AND unidade_id='".$_GET['almoxarifado_id']."'";
	}*/
	$contratos_q=mysql_query($t="SELECT *,cc.id as contrato_id FROM 
								cozinha_contratos cc,
								cliente_fornecedor cf			
								 WHERE 
								 cc.vkt_id='$vkt_id' AND 
								 cc.cliente_id=cf.id AND
								 cc.status='1'");
	
	while($contrato=mysql_fetch_object($contratos_q)){
		//echo $contrato->id."<br>";
		//selecionar fichas do contrato e seus respectivos pessoas, e a soma da quantidade de pessoas q vao comer
		//echo "oi";
		/*
		$fichas_contrato_q=mysql_query($q="
		SELECT
			DISTINCT(cf.id) as ficha_id, cf.peso as peso_receita, ccr.tipo_refeicao as refeicao,
			cf.percapta_leve as peso_leve, cf.percapta_medio as peso_medio, cf.percapta_pesado as peso_pesado, cf.percapta_extra as peso_extra,
			SUM(ccr.pessoas) as pessoas, cc.pesagem as pesagem_contrato, cc.unidade_id as unidade_id, ccr.data as data_ficha, DATE_FORMAT(ccr.data,'%w') as data_ficha_semana
		FROM
			cozinha_cardapio_dia_refeicao as ccr,
			cozinha_fichas_tecnicas as cf,
			cozinha_contratos as cc
		WHERE
			ccr.ficha_tecnica_id=cf.id
			AND ccr.contrato_id = cc.id
			AND cc.id='{$contrato->contrato_id}'
			AND ccr.data>='$filtro_inicio' AND ccr.data <= '$filtro_fim'	
		GROUP BY cf.id
		");*/
		$fichas_contrato_q=mysql_query($q="
		SELECT
			cf.id as ficha_id, cf.nome as ficha_nome, cf.peso as peso_receita, ccr.tipo_refeicao as refeicao, cof.razao_social as cliente,
			cf.percapta_leve as peso_leve, cf.percapta_medio as peso_medio, cf.percapta_pesado as peso_pesado, cf.percapta_extra as peso_extra,
			ccr.pessoas as pessoas, ccr.data as data_ficha, DATE_FORMAT(ccr.data,'%w') as data_ficha_semana, cc.pesagem as pesagem_contrato, cc.unidade_id as unidade_id
		FROM
			cozinha_cardapio_dia_refeicao as ccr,
			cozinha_fichas_tecnicas as cf,
			cozinha_contratos as cc,
			cliente_fornecedor as cof
		WHERE
			ccr.ficha_tecnica_id=cf.id
			AND ccr.contrato_id = cc.id
			AND cof.id=cc.cliente_id
			AND cc.id='{$contrato->contrato_id}'
			AND ccr.data >= '$filtro_inicio' AND ccr.data <= '$filtro_fim'	
		ORDER BY ccr.data ASC
		");
		
		echo mysql_error();
		
		
		//listar fichas e calcular o fator multiplicador para qtd de ingredientes dps
		while($fichas_contrato=mysql_fetch_object($fichas_contrato_q)){	
			//echo "Nome da ficha".$fichas_contrato->ficha_nome."<br>";
			//echo "<b>Contrato ID</b>:".$contrato->id;
			//echo ' <b>Ficha ID</b>: '.$fichas_contrato->ficha_id.' <b>Pessoas que vão comer</b> : '.$fichas_contrato->pessoas;
			//echo " <b>peso da receita:</b> ".$fichas_contrato->peso_receita.' ';
			//echo " <b>pesagem contrato:</b> ".$fichas_contrato->pesagem_contrato.' ';
			if($fichas_contrato->pesagem_contrato=='leve'){
				$fator_multiplicador = @($fichas_contrato->peso_leve/$fichas_contrato->peso_receita);
			}
			if($fichas_contrato->pesagem_contrato=='medio'){
				$fator_multiplicador = @($fichas_contrato->peso_medio/$fichas_contrato->peso_receita);
			}
			if($fichas_contrato->pesagem_contrato=='pesado'){
				$fator_multiplicador = @($fichas_contrato->peso_pesado/$fichas_contrato->peso_receita);
			}
			if($fichas_contrato->pesagem_contrato=='muito pesado'){
				$fator_multiplicador = @($fichas_contrato->peso_extra/$fichas_contrato->peso_receita);
			}
			//echo "<b>Fator Multiplicador</b>: ".$fator_multiplicador." $fichas_contrato->peso_pesado / $fichas_contrato->peso_receita<br>";
			//if($_GET['grupo_id']>0){$filtro_grupo=" AND p.produto_grupo_id='{$_GET['grupo_id']}' ";}
			if($_GET['grupo_id']>0){
				$grupos_produtos = mysql_query("SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id' AND id=".$_GET['grupo_id']);
			}else{
				$grupos_produtos = mysql_query("SELECT * FROM produto_grupo WHERE vkt_id='$vkt_id'");
			}
			while($grupo=mysql_fetch_object($grupos_produtos)){
			/*echo "
    			<td colspan='8' class='g'>$grupo->nome</td>
    		";*/
			
			
			$ingredientes_q=mysql_query($xi="
			SELECT 
				p.id as produto_id, p.nome as nome, cfp.qtd as qtd, p.estoque_min as estoque_min, p.unidade_uso as unidade_uso, p.unidade_embalagem, p.conversao2 as conversao2
			FROM 
				cozinha_ficha_has_produto as cfp, produto as p
			WHERE 
				cfp.ficha_id='{$fichas_contrato->ficha_id}' AND p.id=cfp.produto_id AND
				p.produto_grupo_id='$grupo->id'
			ORDER BY p.nome ASC");
			//echo $xi.'<br/>';
				while($ingrediente=mysql_fetch_object($ingredientes_q)){
				if(!empty($_GET['almoxarifado_id'])){
					$unidade_id=$_GET['almoxarifado_id'];
				}else{
					$unidade_id=$primeira_unidade;
				}
				//echo  " -- <b>produto:</b>{$ingrediente->nome} <b>-></b> QTD :{$ingrediente->qtd} * $fator_multiplicador * {$fichas_contrato->pessoas} =  ".$ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas."<br>";
				//if(!$produtos[$grupo->nome]){
					
					$produtos[$grupo->nome][$ingrediente->nome]['nome'] = $ingrediente->nome;
					$produtos[$grupo->nome][$ingrediente->nome]['estoque_min'] = $ingrediente->estoque_min;
					$produtos[$grupo->nome][$ingrediente->nome]['unidade_id'] = $fichas_contrato->unidade_id;
					$produtos[$grupo->nome][$ingrediente->nome]['em_estoque'] = checaEstoque($ingrediente->produto_id,0,$unidade_id);
					$produtos[$grupo->nome][$ingrediente->nome]['unidade_uso'] = $ingrediente->unidade_uso;
					$produtos[$grupo->nome][$ingrediente->nome]['unidade_embalagem'] = $ingrediente->unidade_embalagem;
					$produtos[$grupo->nome][$ingrediente->nome]['conversao2'] = $ingrediente->conversao2;
					$produtos[$grupo->nome][$ingrediente->nome]['produto_id'] = $ingrediente->produto_id;
					
					$produtos[$grupo->nome][$ingrediente->nome]['fichas'][]=$fichas_contrato->ficha_nome;
					$produtos[$grupo->nome][$ingrediente->nome]['fichas_qtd'][]=($ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas);
					$produtos[$grupo->nome][$ingrediente->nome]['fichas_data_semana'][]=$semana_abreviado[$fichas_contrato->data_ficha_semana];
					$produtos[$grupo->nome][$ingrediente->nome]['fichas_data'][]=$fichas_contrato->data_ficha;
					$produtos[$grupo->nome][$ingrediente->nome]['fichas_refeicao'][]=$fichas_contrato->refeicao;
					$produtos[$grupo->nome][$ingrediente->nome]['fichas_pessoas'][]=$fichas_contrato->pessoas;
					$produtos[$grupo->nome][$ingrediente->nome]['fichas_cliente'][]=$fichas_contrato->cliente;

					$produtos[$grupo->nome][$ingrediente->nome]['qtd']+=($ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas);
				}
			}
		}
	}
	//pr($produtos);
	//exit();
?>
<form id="produtos_para_cotacao" method="post" action="">
<input type="hidden" name="necessidade_inicio" value="<?=$filtro_inicio?>" />
<input type="hidden" name="necessidade_fim" value="<?=$filtro_fim?>" />
<!--<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">-->
    	<? 
			ksort($produtos);
			$grupo_anterior='';
			$y=0;
			foreach($produtos as $grupo=>$item){
				echo "
    					<table width='100%'>
						<thead>
						<tr class='g'><td colspan='10'>".$grupo."</td></tr>
    					</thead>
						</table>
					";
			?>
            <table cellpadding="0" cellspacing="0" width="100%">
    			<tbody dir="dados">	
    				<?	foreach($item as $produto=>$campo){ 
					  
						//if( !empty($qtd_para_cotar) )
					  
					  //if( !empty($_GET["produto_necessidade"]) )
					  if($campo['em_estoque']>$campo['qtd']){
						  $qtd_para_cotar=0;
					  }
					  else{ 
					  	$qtd_para_cotar= number_format((($campo['qtd']-$campo['em_estoque'])/$campo['conversao2']),2,',','.');
					  }
					  
					  if( (!empty($qtd_para_cotar)) or ($qtd_para_cotar == 0)  and ($_GET["produto_necessidade"] == 0) ) {		
					?>	
						<tr>
								<td width='150'><?=$campo['nome']?></td>
								<td width='80' align="right"><?=$campo['em_estoque']." ".$campo['unidade_uso']?></td>
                                <td width='80' align="right"><?=moedaUsaToBr($campo['qtd'])." ".substr($campo['unidade_uso'],0,2)?></td>
            					<td width="100" align="right"><?=moedaUsaToBr($campo['qtd']/$campo['conversao2'])." ".substr($campo['unidade_embalagem'],0,2)?></td>
                                <td width='80' align="right"><?=$campo['estoque_min']." ".substr($campo['unidade_embalagem'],0,2)?></td>
            					<td width="140" align="left"> 
           					 <? if($campo['em_estoque']>$campo['qtd']){$qtd_para_cotar=0;}else{ $qtd_para_cotar= number_format((($campo['qtd']-$campo['em_estoque'])/$campo['conversao2']),2,',','.');} ?>
            
            <input name="qtd_digitada[]" type="text" style=" width:50px; height:10px;" value="<?=$qtd_para_cotar?>" /> <?=substr($campo['unidade_embalagem'],0,2)." de ".limitador_decimal_br($campo['conversao2'])." ".substr($campo['unidade_uso'],0,2)?></td>
                   				<td width="190"><input type="text" name="obs[]" style="height:10px; width:175px;" /></td>
            					<td width="60" align="center">
                                  <input name="qtd_sistema[]" value="<?=$qtd_para_cotar?>" type="hidden" />
                                  <input name="produto_id[]" class="cotar" value="<?=$campo['produto_id']?>" type="checkbox" checked="checked" />
                                  <input name="unidade_embalagem[]" value="<?=$campo['unidade_embalagem']?>" type="hidden" />
                                  <input name="conversao2[]" value="<?=$campo['conversao2']?>" type="hidden" /> 
            					</td>
                                <td align="left">
                                      <div  id="modal<?=$y?>" class="escondido"  style="z-index:10">
                                       <div class="janela" style="width:550px;">
                                       <div class="modal-header-2">
                                          <a href="#" style="color:#CCC; font-weight:bold;float:right;" class="modal_close">x</a>
                                         <span><?=$nome?>&nbsp;</span>
                                       </div>
                                       <div class="modal-body" >
                                        <table cellpadding="0" cellspacing="0" style="background:white !important;">
                                        <thead>
                                          <tr>
                                              <td>Ficha Técnica</td>
                                              <td>Cliente</td>
                                              <td>Qtd</td>
                                              <td>Pessoas</td>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        
                                      <? $data='';
                                          foreach($campo['fichas'] as $i=>$v){
                                              
                                              if($campo['fichas_data'][$i]!=$data){
                                                  ?>
                                                  <tr><td style=" background-color:#999 !important; color:white !important;" colspan="4"><?=dataUsaToBR($campo['fichas_data'][$i])?></td></tr>
                                                  <?
                                                  $data=$campo['fichas_data'][$i];
                                              }
                                              ?>
                                            <tr>
                                                <td><?=$v?></td>
                                                <td><?=$campo['fichas_cliente'][$i]?></td>
                                                <td><?=qtdUsaToBR($campo['fichas_qtd'][$i],3)?></td>
                                                <td><?=$campo['fichas_pessoas'][$i]?></td>
                                            </tr>
                                         <? } ?>
                                        </tbody>
                                        </table> 
                                       </div><!-- fim modal-body -->
                                       <div class="modal-footer">
                                       </div>
                                   </div>
                                      </div>  <!-- fim modal -->
                                       <span class="mostrar_detalhes" id="<?=$y?>" >Detalhes</span>
                                </td>	
						</tr>
					  <?
						$y++;
					  } 
					  else if(  (!empty($qtd_para_cotar)) and ($_GET["produto_necessidade"] > 0) ) { ?>
						  <tr>
								<td width='150'><?=$campo['nome']?></td>
								<td width='80' align="right"><?=$campo['em_estoque']." ".$campo['unidade_uso']?></td>
                                <td width='80' align="right"><?=moedaUsaToBr($campo['qtd'])." ".substr($campo['unidade_uso'],0,2)?></td>
            					<td width="100" align="right"><?=moedaUsaToBr($campo['qtd']/$campo['conversao2'])." ".substr($campo['unidade_embalagem'],0,2)?></td>
                                <td width='80' align="right"><?=$campo['estoque_min']." ".substr($campo['unidade_embalagem'],0,2)?></td>
            					<td width="140" align="left"> 
           					 <? if($campo['em_estoque']>$campo['qtd']){$qtd_para_cotar=0;}else{ $qtd_para_cotar= number_format((($campo['qtd']-$campo['em_estoque'])/$campo['conversao2']),2,',','.');} ?>
            
            <input name="qtd_digitada[]" type="text" style=" width:50px; height:10px;" value="<?=$qtd_para_cotar?>" /> <?=substr($campo['unidade_embalagem'],0,2)." de ".limitador_decimal_br($campo['conversao2'])." ".substr($campo['unidade_uso'],0,2)?></td>
                   				<td width="190"><input type="text" name="obs[]" style="height:10px; width:175px;" /></td>
            					<td width="60" align="center">
                                  <input name="qtd_sistema[]" value="<?=$qtd_para_cotar?>" type="hidden" />
                                  <input name="produto_id[]" class="cotar" value="<?=$campo['produto_id']?>" type="checkbox" checked="checked" />
                                  <input name="unidade_embalagem[]" value="<?=$campo['unidade_embalagem']?>" type="hidden" />
                                  <input name="conversao2[]" value="<?=$campo['conversao2']?>" type="hidden" /> 
            					</td>
                                <td align="left">
                                      <div  id="modal<?=$y?>" class="escondido"  style="z-index:10">
                                       <div class="janela" style="width:550px;">
                                       <div class="modal-header-2">
                                          <a href="#" style="color:#CCC; font-weight:bold;float:right;" class="modal_close">x</a>
                                         <span><?=$nome?>&nbsp;</span>
                                       </div>
                                       <div class="modal-body" >
                                        <table cellpadding="0" cellspacing="0" style="background:white !important;">
                                        <thead>
                                          <tr>
                                              <td>Ficha Técnica</td>
                                              <td>Cliente</td>
                                              <td>Qtd</td>
                                              <td>Pessoas</td>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        
                                      <? $data='';
                                          foreach($campo['fichas'] as $i=>$v){
                                              
                                              if($campo['fichas_data'][$i]!=$data){
                                                  ?>
                                                  <tr><td style=" background-color:#999 !important; color:white !important;" colspan="4"><?=dataUsaToBR($campo['fichas_data'][$i])?></td></tr>
                                                  <?
                                                  $data=$campo['fichas_data'][$i];
                                              }
                                              ?>
                                            <tr>
                                                <td><?=$v?></td>
                                                <td><?=$campo['fichas_cliente'][$i]?></td>
                                                <td><?=qtdUsaToBR($campo['fichas_qtd'][$i],3)?></td>
                                                <td><?=$campo['fichas_pessoas'][$i]?></td>
                                            </tr>
                                         <? } ?>
                                        </tbody>
                                        </table> 
                                       </div><!-- fim modal-body -->
                                       <div class="modal-footer">
                                       </div>
                                   </div>
                                      </div>  <!-- fim modal -->
                                       <span class="mostrar_detalhes" id="<?=$y?>" >Detalhes</span>
                                </td>	
						</tr>
						<?  
						  
					  } 
					  
                    }
			}
			/*foreach($produtos as $id=>$produto){ 
				
				
				if($produto['grupo']!=$grupo_anterior){
					echo "
    					<tr><td colspan='10' class='g'>".$produto['grupo']."</td></tr>
    				";
					$grupo_anterior=$produto['grupo'];
				}
		?>
    	<tr>
        	
            <td width="150"><?=$produto['nome']?></td>
          	<td width="80"><?=$produto['em_estoque']?> <?=$produto['unidade_uso']?></td>
            <td width="80"><?=moedaUsaToBr($produto['qtd'])?> <?=substr($produto['unidade_uso'],0,2)?></td>
            <td width="80"><?=$produto['estoque_min']?></td>
            <td width="120" align="left">
            <? if($produto['em_estoque']>$produto['qtd']){$qtd_para_cotar=0;}else{ $qtd_para_cotar= number_format((($produto['qtd']-$produto['em_estoque'])/$produto['conversao2']),2,',','.');} ?>
            
            <input name="qtd_digitada[]" type="text" style=" width:50px; height:10px;" value="<?=$qtd_para_cotar?>" /> <?=$produto['unidade_embalagem']?></td>
            <td width="190"><input type="text" name="obs[]" style="height:10px; width:175px;" /></td>
            <td width="60" align="center">
            	<input name="qtd_sistema[]" value="<?=$qtd_para_cotar?>" type="hidden" />
            	<input name="produto_id[]" class="cotar" value="<?=$id?>" type="checkbox" checked="checked" />
                <input name="unidade_embalagem[]" value="<?=$produto['unidade_embalagem']?>" type="hidden" />
                <input name="conversao2[]" value="<?=$produto['conversao2']?>" type="hidden" />
            </td>
            <td></td>
         <? */?>   
            
        </tr>
    </tbody>
    
</table>
</form>
<div style="height:350px;"></div>
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
