<?
session_start();
// funçoes do modulo empreendimento
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
include("_function.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#contrato_sombra{
	box-shadow: 1px 1px 1px #888;
	padding:5px;border:1px solid #C8C8C8;
	margin:3px; height:20px;	
}
table#dados_filtro1 tr td{
	/*padding:0px;*/	
}
</style>
<script>
$(document).ready(function(){
	$("tr:odd").addClass('al');
});
</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a><a href="./" class='s2'>
    Cozinha 
</a><a href="?tela_id=113" class='navegacao_ativo'>
<span></span> Controle Consumo
</a>
</div>

<div id="barra_info">
<form method="get">
<a href="<?=$tela->caminho?>/form.php" target="carregador" class="mais"></a>
<input type="hidden" name="tela_id" value="113" />

<!-- select na tabela projetos -->
<select name="contrato" id='contrato'>
<option value="0">Todos Contratos</option>
	<?
    		$sql=mysql_query(" SELECT *,cc.id as cc_id FROM cozinha_contratos cc 
					JOIN cliente_fornecedor cf
	  					ON cc.cliente_id=cf.id
					WHERE vkt_id = '$vkt_id' ");
					
				while($reg=mysql_fetch_object($sql)){
					if($_GET['contrato'] == $reg->cc_id){$sel='selected="selected"';} else{$sel='';}
	?>
	<option <?=$sel?> value="<?=$reg->cc_id?>"><?=$reg->cc_id?> - <?=$reg->razao_social?></option>
	<?
				}
	?>
</select>

<label>Data Inicio
          <input name="data_inicio" id="data_inicio" style="width:100px;" mascara='__/__/____' calendario='1' value="<?=$_GET['data_inicio']?>"/>
</label>

<!-- select na tabela projetos_atividades_tipos por status -->
<label>Data Fim
          <input name="data_fim" id="data_fim" style="width:100px;" mascara='__/__/____' calendario='1' value="<?=$_GET['data_fim']?>" />
</label>
<input type="submit" name="Filtrar" value="Filtrar">
</form>
</div>

<script>

$("#tabela_dados tr").live("click",function(){
	var controle_consumo_id = $(this).attr('id');	
	window.open('<?=$tela->caminho?>/form.php?id='+controle_consumo_id,'carregador');
});

</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="450"><?=linkOrdem("Refeição","nome",1)?></td>
          <td width="65">Planejado</td>
          <td width="65">Pedido</td>
          <td width="75">Consumido</td>
          <td width="75">Valor</td>
          <td>&nbsp;</td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
       <tbody>
       <?
	   			if(!empty($_GET['contrato'])){
						$contrato_id = $_GET['contrato'];
						$contrato = " AND contrato_id = ".$contrato_id;
				}
       			if(!empty($_GET['data_inicio']) and !empty($_GET['data_fim'])){
					$data_ini = dataBrToUsa($_GET['data_inicio']);
					$data_fim = dataBrToUsa($_GET['data_fim']);
					
						$data = "
								AND cc.data >= '".$data_ini."'
	 	 					    AND cc.data <= '".$data_fim."'
						";
				}
				
				
				$sql = mysql_query("
						SELECT *, 
							cf.razao_social as razao,
							cc.data as data_cc,
							cc.id   as c_id			 			  
						FROM cozinha_controle_consumo cc
						JOIN cozinha_contratos ct
	  					  	ON cc.contrato_id=ct.id
					    JOIN cliente_fornecedor cf
	                      	ON ct.cliente_id = cf.id
	  
	 	 				WHERE cc.vkt_id = '$vkt_id' $contrato $data
						
				");
				
				while($r=mysql_fetch_object($sql)){
					$valor_cafe   = ($r->consumido_cafe * $r->cafe_valor);
					$valor_almoco = ($r->consumido_almoco * $r->almoco_valor);
					$valor_lanche = ($r->consumido_lanche * $r->lanche_valor);
					$valor_janta =  ($r->consumido_jantar * $r->janta_valor);
					//$valor_seia =   ($r->consumido_seia   * $r->janta_valor);
	   ?>
    	<tr style="background:#999; color:#FFF;" id="<?=$r->c_id;?>">
          <th width="450" colspan="6" style="padding-left:4px;">Dia <?=dataUsaToBr($r->data_cc);?> - <?=$r->razao?></th>
        </tr>
        <tr id="<?=$r->c_id;?>">
              <td width="450">Café</td>
              <td width="65">0</td>
              <td width="65"><?=$r->pedido_cafe?></td>
              <td width="75"><?=$r->consumido_cafe?></td>
              <td width="75"><?=moedaUsaToBr($valor_cafe)?></td>
              <td>&nbsp;</td>
        </tr>
         <tr id="<?=$r->c_id;?>">
              <td width="450">Almo&ccedil;o</td>
              <td width="65">0</td>
              <td width="65"><?=$r->pedido_almoco?></td>
              <td width="75"><?=$r->consumido_almoco?></td>
              <td width="75"><?=moedaUsaToBr($valor_almoco)?></td>
              <td>&nbsp;</td>
         </tr>
          <tr id="<?=$r->c_id;?>">
              <td width="450">Lanche</td>
              <td width="65">0</td>
              <td width="65"><?=$r->pedido_lanche?></td>
              <td width="75"><?=$r->consumido_lanche?></td>
              <td width="75"><?=moedaUsaToBr($valor_lanche)?></td>
              <td>&nbsp;</td>
         </tr>
         <tr id="<?=$r->c_id;?>">
              <td width="450">Jantar</td>
              <td width="65">0</td>
              <td width="65"><?=$r->pedido_jantar?></td>
              <td width="75"><?=$r->consumido_jantar?></td>
              <td width="75"><?=moedaUsaToBr($valor_janta)?></td>
              <td>&nbsp;</td>
         </tr>
        
       	<?
				}
		?> 
      </tbody>
</table>

</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
          <td width="580"></td>
          <td>&nbsp;</td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
