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
			//console.log($(this))
	}else{
			$(this.parentNode.parentNode).find("input").attr( "disabled",'disabled');	
			$(this).removeAttr( "disabled");
			//console.log($(this));
	}
});
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>

.escondido{  position:absolute; display:none; color:black !important; }
</style>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">>></div>
        <a href="#" class='s1'>
  			SISTEMA
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
    <label>
	<? $unidades_q=mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); ?>
	<select name="unidade_id_origem" id='unidade_id_origem'style="margin:3px"  >
		<option value="0">Unidade Origem</option>
        <? while($unidade=mysql_fetch_object($unidades_q)){ 
		if($_GET['unidade_id_origem']==$unidade->id){$sel='selected="selected"';}else{ $sel='';}
		?>
        <option <?=$sel?> value="<?=$unidade->id?>"><?=$unidade->nome?></option>
   <? } ?>
	</select>
    </label>
    <label>
	<? $unidades_q=mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id' ORDER BY nome ASC"); ?>
	<select name="unidade_id_destino" id='unidade_id_destino'style="margin:3px"  >
		<option value="0">Unidade Destino</option>
        <? while($unidade=mysql_fetch_object($unidades_q)){ 
		if($_GET['unidade_id_destino']==$unidade->id){$sel='selected="selected"';}else{ $sel='';}
		?>
        <option <?=$sel?> value="<?=$unidade->id?>"><?=$unidade->nome?></option>
   <? } ?>
	</select>
    </label>
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
    <input type="submit" value="Ir" />
    <input type="hidden" name="tela_id" value="203" />
    
    <input name="action" type="button" value="Imprimir ingredientes" onclick="window.open('<?=$caminho?>/necessidade_unidade_detalhes.php?filtro_inicio=<?=$_GET['filtro_inicio']?>&filtro_fim=<?=$_GET['filtro_fim']?>&unidade_id_destino=<?=$_GET['unidade_id_destino']?>')" style="margin:3px; float:right"  />
    
    <input name="action" type="button" value="Gerar Transfer�ncia de Mercadorias" onclick="document.getElementById('produtos_para_cotacao').submit()" style="margin:3px; float:right"  />
</form>
	
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><?=linkOrdem("Produto.","nome",1)?></td>
          	<td width="	80">Est. Origem</td>
            <td width="	80">Est. Destino</td>
            <td width="80">Necessidade</td>
            <td width="100">Necessidade Emb.</td>
            <td width="80">Estoque Min</td>
            <td width="140">Qtd Cotacao</td>
            <td width="190">Obs</td>
            <td width="90">Transferir <input id="cotar_todos" type="checkbox" checked="checked" /> </td>
            <td></td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->

<?
	//selecionar contratos
	$produtos=array();
		
	$unidade_destino = $_GET['unidade_id_destino'];
	$contratos_q=mysql_query("SELECT * FROM cozinha_contratos WHERE vkt_id='$vkt_id' AND unidade_id='$unidade_id_origem' ");
	while($contrato=mysql_fetch_object($contratos_q)){
		//selecionar fichas do contrato e seus respectivos pessoas, e a soma da quantidade de pessoas q vao comer
		$fichas_contrato_q=mysql_query($q="
		SELECT
			cf.id as ficha_id, cf.nome as ficha_nome, cf.peso as peso_receita, ccr.tipo_refeicao as refeicao,
			cf.percapta_leve as peso_leve, cf.percapta_medio as peso_medio, cf.percapta_pesado as peso_pesado, cf.percapta_extra as peso_extra,
			ccr.pessoas as pessoas, ccr.data as data_ficha, DATE_FORMAT(ccr.data,'%w') as data_ficha_semana, cc.pesagem as pesagem_contrato, cc.unidade_id as unidade_id
		FROM
			cozinha_cardapio_dia_refeicao as ccr,
			cozinha_fichas_tecnicas as cf,
			cozinha_contratos as cc
		WHERE
			ccr.ficha_tecnica_id=cf.id
			AND ccr.contrato_id = cc.id
			AND cc.id='{$contrato->id}'
			AND ccr.data >= '$filtro_inicio' AND ccr.data <= '$filtro_fim'	
		");
		
		echo mysql_error();
		
		//listar fichas e calcular o fator multiplicador para qtd de ingredientes
		while($fichas_contrato=mysql_fetch_object($fichas_contrato_q)){	
			//echo '<b>Ficha ID</b>: '.$fichas_contrato->ficha_id.' <b>Pessoas que v�o comer</b> : '.$fichas_contrato->pessoas;
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
			//echo "<b>Fator Multiplicador</b>: ".$fator_multiplicador.'<br>';
			//pegar os produtos de cada ficha
			if($_GET['grupo_id']>0){$filtro_grupo=" AND p.produto_grupo_id='{$_GET['grupo_id']}' ";}
			$ingredientes_q=mysql_query($xi="
			SELECT 
				p.id as produto_id, p.nome as nome, cfp.qtd as qtd, p.estoque_min as estoque_min, p.unidade_uso as unidade_uso, p.unidade_embalagem as unidade_embalagem, p.conversao2 as conversao2, pg.nome as grupo
			FROM
				cozinha_ficha_has_produto as cfp, produto as p, produto_grupo as pg
			WHERE 
				cfp.ficha_id='{$fichas_contrato->ficha_id}' AND p.id=cfp.produto_id AND pg.id =p.produto_grupo_id
				$filtro_grupo ");
				//echo $xi;
			//listar os produtos e fazer o calculo de qtd de ingredientes de cada produto
			while($ingrediente=mysql_fetch_object($ingredientes_q)){
			
			$produtos[$ingrediente->grupo][$ingrediente->nome]['produto_id'] = $ingrediente->produto_id;	
			$produtos[$ingrediente->grupo][$ingrediente->nome]['estoque_min'] = $ingrediente->estoque_min;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['unidade_id'] = $fichas_contrato->unidade_id;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['unidade_uso'] = $ingrediente->unidade_uso;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['unidade_embalagem'] = $ingrediente->unidade_embalagem;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['conversao2'] = $ingrediente->conversao2;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['em_estoque'] = checaEstoque($ingrediente->produto_id,0,$fichas_contrato->unidade_id);
			$produtos[$ingrediente->grupo][$ingrediente->nome]['em_estoque_origem'] = checaEstoque($ingrediente->produto_id,0,$unidade_id_origem);
			$produtos[$ingrediente->grupo][$ingrediente->nome]['qtd']+=($ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas);
			$produtos[$ingrediente->grupo][$ingrediente->nome]['fichas'][]=$fichas_contrato->ficha_nome;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['fichas_qtd'][]=($ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas);
			$produtos[$ingrediente->grupo][$ingrediente->nome]['fichas_data'][]=$fichas_contrato->data_ficha;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['fichas_data_semana'][]=$semana_abreviado[$fichas_contrato->data_ficha_semana];
			$produtos[$ingrediente->grupo][$ingrediente->nome]['fichas_refeicao'][]=$fichas_contrato->refeicao;
			$produtos[$ingrediente->grupo][$ingrediente->nome]['fichas_pessoas'][]=$fichas_contrato->pessoas;
		}
			
		}
	}
?>
<form id="produtos_para_cotacao" method="post" action="">
<input type="hidden" name="necessidade_inicio" value="<?=$filtro_inicio?>" />
<input type="hidden" name="necessidade_fim" value="<?=$filtro_fim?>" />
<input type="hidden" name="unidade_id_origem" value="<?=$unidade_id_origem?>" />
<input type="hidden" name="unidade_id_destino" value="<?=$unidade_id_destino?>" />
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody dir="dados">
    	<? 
		ksort($produtos);
		$grupo_atual="";
		$y=0;
		foreach($produtos as $grupo=>$produto){
			if($grupo_atual!=$grupo){
				echo "<tr><td colspan='10' style='background:#999; color:white' >$grupo</td></tr>";
			}
			ksort($produto);
			foreach($produto as $nome=>$campo){
				$necessidade_embalagem = @($campo['qtd']/$campo['conversao2']);
		?>
    	<tr>   
        
            <td width="150"><?=$nome?><?=$campo['produto_id']?></td>
          	<td width="	80"><?=limitador_decimal_br($campo['em_estoque_origem'],0,2)." ".substr($campo['unidade_uso'],0,2)?></td>
            <td width="80"><?=limitador_decimal_br($campo['em_estoque'],0,2)?> <?=substr($campo['unidade_uso'],0,2)?></td>
            <td width="80"><?=moedaUsaToBr($campo['qtd'])?> <?=substr($campo['unidade_uso'],0,2)?></td>
            <td width="100"><?=limitador_decimal_br($necessidade_embalagem,0,2)." ".substr($campo['unidade_embalagem'],0,2)?></td>
            <td width="80"><?=limitador_decimal_br($campo['estoque_min'],0,2)?></td>
            <td width="140" align="left">
            <? if($campo['em_estoque']>$campo['qtd']){$qtd_para_cotar=0;}else{ $qtd_para_cotar= number_format(($campo['qtd']-$campo['em_estoque'])/$campo['conversao2'],2,',','.'); }?>
            
            	<input name="qtd_digitada[]" class="qtd_digitada" type="text" style=" width:50px; height:10px;" sonumero='1' value="<?=$qtd_para_cotar?>" /> <?=substr($campo['unidade_embalagem'],0,2)." de ".limitador_decimal_br($campo['conversao2'],0,2)." ".substr($campo['unidade_uso'],0,2)?></td>
                
                <td width="190"><input type="text" name="obs[]" style="height:10px; width:175px;" /></td>
            <td width="90" align="center">
            	<input name="produto_id[]" class="cotar" value="<?=$campo['produto_id']?>" type="checkbox" checked="checked" />
                <input name="qtd_sistema[]" value="<?=$qtd_para_cotar?>" type="hidden" />
                <input name="unidade_embalagem[]" value="<?=$campo['unidade_embalagem']?>" type="hidden" />
                <input name="conversao2[]" class="conversao2" value="<?=$campo['conversao2']?>" type="hidden" />
            </td>
            <td align="left">
            
            
            
            
            
            <!-- modal plano de contas -->        
          <div  id="modal<?=$y?>" class="escondido"  style="z-index:10">
             <div class="janela"  id="janela_plano_contas">
             <div class="modal-header-2">
                     <a href="#" style="color:#CCC; font-weight:bold;float:right;" class="modal_close">x</a>
               <span><?=$nome?></span>
             </div>
             <div class="modal-body" >
              
			<?
            foreach($campo['fichas'] as $i=>$v){
                echo "<strong>{$campo['fichas_refeicao'][$i]}</strong> {$campo['fichas_data_semana'][$i]}  ".dataUsaToBR($campo['fichas_data'][$i])."  $v ".moedaUsaToBR($campo['fichas_qtd'][$i])." {$campo['unidade_uso']} - {$campo['fichas_pessoas'][$i]} pessoas<br/>" ;
            } 
            ?>
               
             </div><!-- fim modal-body -->
             <div class="modal-footer">
             </div>
         </div>
      </div>
               <!-- fim modal -->
            <span class="mostrar_detalhes" id="<?=$y?>">Detalhes</span>
            </td>
         <? 
		 $y++;
		 	} 
			
		}
		?>   
        
        </tr>

    </tbody>
</table>
<div style="height:350px"></div>
</form>
<script>

$(".mostrar_detalhes").click(function(){
	$(".escondido").hide();
	id=$(this).attr('id')
	$("#modal"+id).show();
	$("#modal"+id+" .sub-janela").show();
	$(".mostrar_detalhes").show();
})
</script>
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
<script>
// Fecha aba de menu

		$("#menu").animate({
			'marginLeft': -210,
			
		  }, 0);
		$("#conteudo").animate({
			'marginLeft': 10
		  }, 0);
		$("#rodape").animate({
			'marginLeft': 10
		  }, 0);
				   $("#some").html("&raquo;")

////

</script>