<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
?>
<script src="../demonstrativo_periodo/modulos/financeiro/financeiro.js"></script>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="../" class='s1'>
  	Financeiro
</a>
<a href="../" class='s2'>
  	Relatórios
</a>
<a href="../?tela_id=81" class='navegacao_ativo'>
<span></span>    Demonstrativo Por Período
</a>
</div>
<div id="barra_info">
    <a href="../demonstrativo_periodo/modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"></a>
<form style=" margin:0; padding:0; " method="get"> 
    Filtrar:
      <select name="tipo" id="tipo">
      	<option value="nulo">Escolha o filtro</option>
        <option value="centro" id="centro_escolha" title="Centro de Custo" <? if($_GET[tipo]=='centro')echo 'selected="selected"'; ?> >Centro de Custo</option>
        <option value="plano" id="plano_escolha" title="Plano de Conta" <? if($_GET[tipo]=='plano')echo 'selected="selected"'; ?> >Plano de Contas</option>
        <option value="cliente" id="cliente_escolha" title="Cliente/Fornecedor" <? if($_GET[tipo]=='cliente')echo 'selected="selected"'; ?> >Cliente/Fornecedor</option>
      </select> 
      <label id="centro" <? if($_GET[tipo]!='centro'){ ?> style="display:none;" <? } ?> >Centro de Custo:
      <select name="centro">
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro='centro' "); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[centro]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[centro]==$sub->id)echo "selected"; ?>  value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  <label id="plano" <? if($_GET[tipo]!='plano'){ ?> style="display:none;" <? } ?> >Plano de Conta:
      <select name="plano">
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro = 'plano' "); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[plano]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[plano]==$sub->id)echo "selected"; ?> value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  <label id="cliente" <? if($_GET[tipo]!='cliente'){ ?> style="display:none;" <? } ?> >Cliente:
      <input name="cliente" type="hidden" id="internauta_id" title='<?=$cliente->razao_social?>' value="<?=$_GET[cliente]?>" />
			  <input name="cliente_nome" id="cliente_nome" value="<?=$_GET[cliente_nome]?>" busca='modulos/administrativo/empreendimentos/disponibilidades/busca_clientes.php,@r0 @r2,@r1-value>internauta_id|@r0-title>internauta_id,0' valida_minlength='5'retorno='focus|Busque o nome do Cliente' autocomplete='off'>
      
  </label>
  <label>
  Contas
  	<select name="conta">
    <option value="0">Todas</option>
    <? $contas_q=mysql_query("SELECT * FROM financeiro_contas WHERE  cliente_vekttor_id ='$vkt_id' ORDER BY nome ASC"); while($contas=mysql_fetch_object($contas_q)){ ?>
    <option <? if($_GET[conta]==$contas->id)echo "selected"; ?> value="<?=$contas->id?>"><?=$contas->nome?></option>
    <? } ?>
    </select>
  </label>
    De
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
    At&eacute;
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    <input type="hidden" name="tela_id" value="81" />
<input type="submit" name="button" id="button" value="Filtrar" />
</form>
</div>
<div id='dados'>

<table cellpadding="0" cellspacing="0"  width="100%">
    <thead>
   
    	<tr>
    	  <td width="60">Data</td>

          	<td width="100"> Centro de Custo</td>
            
            <td width="100" align="left">Plano de Conta</td>
            <td width="100" align="left">Cliente</td>
            <td width="150" align="left">Descrição</td>
            <td width="60" align="right">Entrada</td>
            <td width="60" align="right">Saída</td>
            <td width="60" align="right">Saldo</td>
            <td width=""></td>
			
        </tr>
        
         
      
    </thead>
</table>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
	<tbody>
    
    <?		/* Manipulação dos filtros */
			if($_GET[conta]!=0){$filtro_conta=" AND m.conta_id='{$_GET[conta]}'";}
			
			if($_GET[tipo]=='centro'){$filtro_pai = $_GET[centro];$filtro_tabela='centro';$oposto='plano';}
			
			if($_GET[tipo]=='plano'){$filtro_pai = $_GET[plano];$filtro_tabela='plano';$oposto='centro';}
			
			if(!isset($_GET[tipo])||$_GET[tipo]=='nulo'){$filtro_pai=0;$filtro_tabela='centro'; $oposto='plano';}
			else{$filtro_tabela_ex=" AND plano_ou_centro='{$filtro_tabela}' ";}
			/****************************************************************/
			
			
			
			/**************função para fazer a soma incluindo as subcategorias***********/
			function retornaFilhos($id){
				global $filtro_tabela_ex;
				global $filtro_tabela;
				global $plano_ou_centro;
				$filho[]=$id;
				$q=mysql_query($tt="SELECT id FROM financeiro_centro_custo WHERE centro_custo_id='$id' $filtro_tabela_ex   ") or die(mysql_error());
				
				while($f=mysql_fetch_object($q)){
					$filho[]=$f->id;
					/*
					*/
					$filhos=mysql_query("SELECT id FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' ");
					if(mysql_num_rows($filhos)>0){
						
						$filho=array_merge($filho,retornaFilhos($f->id));
						
					}
					
				}
				return array_unique($filho);
			}
	
	
	
	
			
			if(!isset($_GET[tipo]) || $_GET[tipo]!='cliente' || $_GET[tipo]=='nulo'){
			$pais_e_filhos=implode(',',retornaFilhos($filtro_pai));
			$q = mysql_query("
				SELECT
					cc.nome as nome,
					c.valor as valor, 
					m.tipo as tipo, 
					m.data_info_movimento as data_mov,
					m.descricao as descr,
					m.id as id
				FROM
					financeiro_centro_custo as cc,
					financeiro_{$filtro_tabela}_has_movimento as c,
					financeiro_movimento as m
				WHERE 
					c.plano_id in ($pais_e_filhos)
				AND 
					c.plano_id = cc.id
				AND
					c.movimento_id = m.id 
				AND 
					m.data_info_movimento>='$filtro_inicio' 
				AND 
					m.data_info_movimento<='$filtro_fim' 
				AND
					m.cliente_id='$vkt_id'
				$filtro_conta
				ORDER BY m.data_info_movimento ASC ");
			}
			if($_GET[tipo]=='cliente'){
				$q = mysql_query($tracecliente="
					SELECT 
						m.id as id,
						m.tipo as tipo,
						m.data_movimento as data_mov,
						m.entrada as entrada,
						m.saida as saida,
						m.saldo as saldo,
						tabela_plano.nome as plano_nome,
						tabela_centro.nome as centro_nome
					FROM
						 financeiro_movimento as m,
						 (SELECT * FROM financeiro_centro_custo WHERE plano_ou_centro='plano') as tabela_plano,
						 (SELECT * FROM financeiro_centro_custo WHERE plano_ou_centro='centro') as tabela_centro,
						 financeiro_centro_has_movimento as fcm,
						 financeiro_plano_has_movimento as fpm
					WHERE 
						m.internauta_id='{$_GET[cliente]}'
					AND
						m.id = fcm.movimento_id
					AND
						fcm.plano_id = tabela_centro.id
					AND
						m.id=fpm.movimento_id
					AND
						fpm.plano_id= tabela_plano.id
					AND
						m.data_info_movimento>='$filtro_inicio' 
					AND 
						m.data_info_movimento<='$filtro_fim'
					AND
						m.cliente_id='$vkt_id'
					$filtro_conta
					ORDER BY m.data_info_movimento DESC ") or die(mysql_error());
					$oposto='centro';
			} 
			
			
			$linha_contagem=0;
            while($r=mysql_fetch_object($q)){
				
				$clientes=mysql_query("
				SELECT c.razao_social as nome FROM cliente_fornecedor as c, financeiro_movimento as m WHERE m.id='{$r->id}' AND c.id = m.internauta_id  ");
				
				$cliente=mysql_fetch_object($clientes);
				
				if( $_GET[tipo] != 'cliente' ){
					$oposto_query=mysql_query($op="SELECT nome FROM financeiro_{$oposto}_has_movimento as h, financeiro_movimento as m, financeiro_centro_custo as c 
						WHERE m.id='{$r->id}' 
						AND h.movimento_id = m.id 
						AND h.plano_id = c.id 
						AND	m.cliente_id='$vkt_id'
					");
						switch($oposto){
							case'centro':
							$centro=mysql_fetch_object($oposto_query) or die(mysql_error());
							break;
							case'plano':
							$plano=mysql_fetch_object($oposto_query) or die(mysql_error());
							break;
						}
				}
				if($linha_contagem%2==0){$cl="";}else{$cl="class='al'";}
			?>
    	<tr <?=$cl?> >
        	<td width="60"><?=dataUsaToBr($r->data_mov)?></td>
          	<td width="100"><? if($oposto=='plano'){echo $r->nome; }else{ echo $centro->nome;}?> <? if($_GET[tipo]=='cliente')echo $r->centro_nome; ?></td>
            
            <td width="100"><? if($oposto=='centro'){echo $r->nome; }else{ echo $plano->nome; }?> <? if($_GET[tipo]=='cliente')echo $r->plano_nome; ?></td>
            
            <td width="100" align="left"><?=$cliente->nome?></td>
            <td width="150" align="left"><?=$r->descr?></td>
            <td width="60"  align="right" ><?
			
				if($r->tipo=='receber'&&$_GET[tipo]!='cliente'){
					$valor_receber=$r->valor;
				}elseif($_GET[tipo]=='cliente'){
					$valor_receber=$r->entrada;
				}else{$valor_receber=0;}echo number_format($valor_receber,2,',','.');
				?></td>
                
				<td width="60"  align="right" ><?
				if($r->tipo=='pagar'&&$_GET[tipo]!='cliente'){
					$valor_pagar=$r->valor;
				}elseif($_GET[tipo]=='cliente'){
					$valor_pagar=$r->saida;
				}else{$valor_pagar=0;}echo number_format($valor_pagar,2,',','.');
						
			?></td>
            <td width="60"  align="right" ><?
			 echo  number_format($valor_receber-$valor_pagar+$saldo,2,',','.');
             $saldo=$valor_receber-$valor_pagar+$saldo;
			?></td>
            <td width=""></td>
        </tr>
          <? $linha_contagem++;
			}
			?>
    </tbody>
</table>


<table cellpadding="0" cellspacing="0" width="100%">
  <thead>
    	<tr>
       	  <td width="200">Total</td>
          
          	<td width="70" style="margin:0; padding:0; text-align:right">&nbsp;</td>
          	<td width="70">&nbsp;</td>
          	<td width=""></td>
      </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0"width="<?=300+(($total_dias+1)*70)?>" >
  <thead>
    <tr>
      <td width="200">Pago</td>
            <?
			$totaln=array();
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
          	<td width="70" style="margin:0; padding:0; text-align:right">&nbsp;</td>
            <?
			}
			?>
          	<td width="70">&nbsp;</td>
	      <td width=""></td>
    </tr>
  </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>">
  <thead>
    <tr>
      <td width="200">Pendente</td>
            <?
			$totaln=array();
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
          	<td width="70" style="margin:0; padding:0; text-align:right">&nbsp;</td>
            <?
			}
			
			?>
           	<td width="70">&nbsp;</td>
     <td width=""></td>
    </tr>
  </thead>
</table>
</div>

</div>
<div id='rodape'>
	<script>
	$("#centro_escolha").click(function(){
		$("#centro").show();$("#plano").hide();$("#cliente").hide();
	})
	
	$("#plano_escolha").click(function(){
		$("#centro").hide();$("#plano").show();$("#cliente").hide();
	})
		
	
		
	$("#cliente_escolha").click(function(){
		$("#centro").hide();$("#plano").hide();$("#cliente").show();
	})
		
</script>
</div>
